<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Diploma;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiplomaImportController extends Controller
{
    private const APP_ID = 4;

    private const UUID_FIO        = '676b9ceb-2e24-4b72-8cbd-981406ec6926';
    private const UUID_ISSUED_AT  = '0066e63e-5241-4ca4-b8fe-6334a26052de';
    private const UUID_DISCIPLINE = 'd5c7234c-f007-4db5-a9bc-aaf843d01e1c';

    // Извлекает DD.MM.YYYY из произвольной строки, возвращает null если не найдено
    private function extractDate(?string $raw): ?Carbon
    {
        if (!$raw) {
            return null;
        }

        if (!preg_match('/\b(\d{2})\.(\d{2})\.(\d{4})\b/', $raw, $m)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d.m.Y', $m[0])->startOfDay();
        } catch (\Exception) {
            return null;
        }
    }

    public function preview()
    {
        $rows = DB::table('jos_zoo_item')
            ->where('application_id', self::APP_ID)
            ->limit(5)
            ->get(['name', 'elements']);

        $total = DB::table('jos_zoo_item')
            ->where('application_id', self::APP_ID)
            ->count();

        $sample = $rows->map(function ($row) {
            $el      = json_decode($row->elements, true) ?? [];
            $dateRaw = $el[self::UUID_ISSUED_AT][0]['value'] ?? null;

            return [
                'name'          => $row->name,
                'fio_raw'       => $el[self::UUID_FIO][0]['value']        ?? '(нет)',
                'date_raw'      => $dateRaw                               ?? '(нет)',
                'date_parsed'   => $this->extractDate($dateRaw)?->toDateString() ?? '(не распознана)',
                'disc_raw'      => $el[self::UUID_DISCIPLINE][0]['value'] ?? '(нет)',
            ];
        });

        return response()->json([
            'total'  => $total,
            'sample' => $sample,
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function import()
    {
        $rows = DB::table('jos_zoo_item')
            ->where('application_id', self::APP_ID)
            ->get(['name', 'elements']);

        $parsed = $rows->map(function ($row) {
            $el      = json_decode($row->elements, true) ?? [];
            $dateRaw = $el[self::UUID_ISSUED_AT][0]['value'] ?? null;

            return [
                'title'      => trim($row->name),
                'fio'        => trim($el[self::UUID_FIO][0]['value']        ?? '') ?: null,
                'issued_at'  => $this->extractDate($dateRaw),
                'discipline' => trim($el[self::UUID_DISCIPLINE][0]['value'] ?? '') ?: null,
            ];
        });

        // Дедупликация по title (номер диплома уникален)
        $parsed = $parsed->keyBy('title')->values();

        // Сортировка: сначала с датой (по возрастанию), потом без даты
        $parsed = $parsed->sortBy(fn($d) => $d['issued_at']?->timestamp ?? PHP_INT_MAX)->values();

        Diploma::truncate();

        $now      = now();
        $imported = 0;
        $skipped  = [];

        foreach ($parsed as $index => $data) {
            Diploma::create([
                'title'      => $data['title'],
                'fio'        => $data['fio'],
                'issued_at'  => $data['issued_at'],
                'discipline' => $data['discipline'],
                'published'  => 1,
                'sorting'    => ($index + 1) * 10,
                'created_at' => $data['issued_at'] ?? $now,
                'updated_at' => $now,
            ]);

            $imported++;
        }

        return response()->json([
            'status'   => 'ok',
            'imported' => $imported,
            'sample'   => Diploma::orderBy('sorting')->limit(5)->get(),
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
