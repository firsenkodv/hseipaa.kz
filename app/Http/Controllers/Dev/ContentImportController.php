<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Important;
use App\Models\Law;
use App\Models\News;
use App\Models\Training;
use App\Models\Useful;
use Illuminate\Support\Facades\DB;

class ContentImportController extends Controller
{
    private const CATID  = 30;
    private const MODEL  = Important::class;

    public function preview()
    {
        $rows = $this->query()->limit(60)->get()->map(fn($r) => $this->clean($r));

        $total = DB::table('jos_content')
            ->where('catid', self::CATID)
            ->count();

        return response()->json([
            'total'  => $total,
            'sample' => $rows,
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    }

    public function import()
    {
        $rows = $this->query()->get()->map(fn($r) => $this->clean($r));

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        (self::MODEL)::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $now      = now();
        $imported = 0;

        $skipped = [];

        foreach ($rows as $index => $row) {
            try {
                (self::MODEL)::create([
                    'title'       => trim($row->title),
                    'slug'        => $row->alias,
                    'short_desc'  => $row->introtext ?: null,
                    'desc'        => $row->fulltext,
                    'metatitle'   => mb_substr((string) $row->meta_title, 0, 255),
                    'description' => mb_substr((string) $row->metadesc, 0, 255),
                    'keywords'    => mb_substr((string) $row->metakey, 0, 255),
                    'published'   => 1,
                    'sorting'     => ($index + 1) * 10,
                    'created_at'  => $row->created,
                    'updated_at'  => $now,
                ]);

                $imported++;
            } catch (\Exception $e) {
                $skipped[] = ['id' => $row->id, 'title' => $row->title, 'error' => $e->getMessage()];
            }
        }

        return response()->json([
            'status'   => 'ok',
            'imported' => $imported,
            'skipped'  => $skipped,
            'sample'   => (self::MODEL)::orderBy('sorting')->limit(5)->get(['id', 'title', 'slug', 'metatitle']),
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function clean(object $row): object
    {
        $text = $row->fulltext;

        // Внутри h1-h4 удалить все вложенные теги, оставить только текст
        $text = preg_replace_callback('/<(h[1-4])(\b[^>]*)>(.*?)<\/\1>/is', function ($m) {
            return "<{$m[1]}>" . strip_tags($m[3]) . "</{$m[1]}>";
        }, $text);

        // Удалить <img ... />
        $text = preg_replace('/<img\b[^>]*\/?>/i', '', $text);
        // Удалить атрибуты style="..."
        $text = preg_replace('/\s*style="[^"]*"/i', '', $text);
        // Унифицировать таблицы
        $text = $this->cleanTables($text);
        // Удалить <p>&nbsp;</p> и <p></p> (с возможными пробелами внутри)
        $text = preg_replace('/<p>\s*(&nbsp;)?\s*<\/p>/i', '', $text);
        // Схлопнуть 3+ переносов строк в два
        $text = preg_replace('/(\r?\n){3,}/', "\n\n", $text);

        // Убрать невалидные UTF-8 байты (артефакты старых Joomla latin1-соединений)
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

        $row->fulltext   = trim($text);
        $row->introtext  = trim(strip_tags((string) $row->introtext));
        $row->meta_title = $row->meta_title ?? $row->title;

        $this->fillEmptyMeta($row);

        return $row;
    }

    private function fillEmptyMeta(object $row): void
    {
        // metadesc: первые ~160 символов чистого текста
        if (empty(trim((string) $row->metadesc))) {
            $plain = preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($row->fulltext, ENT_HTML5, 'UTF-8')));
            $plain = trim($plain);
            if (mb_strlen($plain) > 160) {
                $cut = mb_substr($plain, 0, 160);
                $pos = mb_strrpos($cut, ' ');
                $plain = $pos ? mb_substr($cut, 0, $pos) : $cut;
            }
            $row->metadesc = $plain;
        }

        // metakey: текст из заголовков h1-h4 (ключевые фразы страницы)
        if (empty(trim((string) $row->metakey))) {
            preg_match_all('/<h[1-4][^>]*>(.*?)<\/h[1-4]>/is', $row->fulltext, $matches);
            $phrases = array_values(array_unique(array_filter(
                array_map(fn($h) => trim(strip_tags($h)), $matches[1])
            )));
            // Если заголовков нет — fallback на title
            $row->metakey = mb_substr(
                implode(', ', $phrases ?: [$row->title]),
                0, 255
            );
        }
    }

    private function cleanTables(string $text): string
    {
        // Убрать все атрибуты у структурных тегов таблицы
        $text = preg_replace('/<(table|tbody|thead|tfoot|tr)\b[^>]*>/i', '<$1>', $text);

        // Добавить единый класс для CSS-стилизации
        $text = str_replace('<table>', '<table class="content-table">', $text);

        // td/th: оставить только colspan/rowspan, убрать <p>-обёртки внутри ячеек
        $text = preg_replace_callback('/<(td|th)\b([^>]*)>(.*?)<\/\1>/is', function ($m) {
            // Атрибуты: только colspan и rowspan
            $attrs = '';
            if (preg_match('/\bcolspan="(\d+)"/i', $m[2], $c)) $attrs .= " colspan=\"{$c[1]}\"";
            if (preg_match('/\browspan="(\d+)"/i', $m[2], $r)) $attrs .= " rowspan=\"{$r[1]}\"";

            // Содержимое: убрать <p>-обёртки, несколько параграфов → <br>
            $inner = trim($m[3]);
            preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $inner, $paras);
            if (!empty($paras[1])) {
                $parts = array_values(array_filter(
                    array_map('trim', $paras[1]),
                    fn($p) => $p !== '' && $p !== '&nbsp;'
                ));
                $inner = implode('<br>', $parts);
            }

            return "<{$m[1]}{$attrs}>{$inner}</{$m[1]}>";
        }, $text);

        return $text;
    }

    private function query()
    {
        // Связь: jos_menu.link = "index.php?option=com_content&view=article&id={jos_content.id}"
        // jos_menu.params (JSON) -> page_title = настоящий meta title материала
        return DB::table('jos_content as c')
            ->leftJoin(
                DB::raw(
                    "(SELECT link, MIN(JSON_UNQUOTE(JSON_EXTRACT(params, '$.page_title'))) AS page_title
                      FROM jos_menu
                      WHERE link LIKE '%view=article&id=%'
                      GROUP BY link) AS m"
                ),
                'm.link',
                '=',
                DB::raw("CONCAT('index.php?option=com_content&view=article&id=', c.id)")
            )
            ->where('c.catid', self::CATID)
            ->orderBy('c.id')
            ->select([
                'c.id',
                'c.title',
                'c.alias',
                'c.introtext',
                'c.fulltext',
                DB::raw('LEFT(c.metakey, 255) AS metakey'),
                DB::raw('LEFT(c.metadesc, 255) AS metadesc'),
                'c.created',
                DB::raw("LEFT(NULLIF(m.page_title, ''), 255) AS meta_title"),
            ]);
    }

}
