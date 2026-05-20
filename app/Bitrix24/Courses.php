<?php

namespace App\Bitrix24;

use App\Models\Setting;
use RuntimeException;
use Throwable;

class Courses
{
    protected string $bx_webhook;
    protected mixed  $bx_resp_id;

    public function __construct()
    {
        $setting = Setting::getGroup('social');
        $this->bx_webhook = $setting->getValue('bx_webhook', '');
        $this->bx_resp_id = $setting->getValue('bx_resp_id');
    }

    public function getCourses($bx_section_id): ?array {

// ─── Загрузка курсов ──────────────────────────────────────────────────────
        try {

            $items = [];

            // Способ 1: crm.product.list (старый каталог CRM)
            // Bitrix24 отдаёт max 50 записей за раз; 'next' в ответе — смещение следующей страницы
            $start = 0;
            do {
                $json  = $this->bx_call('crm.product.list', [
                    'select' => ['ID', 'NAME', 'PRICE', 'CURRENCY_ID'],
                    'filter' => ['SECTION_ID' => $bx_section_id],
                    'order'  => ['NAME' => 'ASC'],
                    'start'  => $start,
                ]);
                $batch  = $json['result'] ?? [];
                $items  = array_merge($items, $batch);
                $start  = $json['next'] ?? null;  // null — последняя страница
            } while ($start !== null && !empty($batch));

            if (empty($items)) {
                // Способ 2: catalog.product.list (новый API)
                // фильтр в camelCase — особенность нового Catalog API
                $start = 0;
                do {
                    $json     = $this->bx_call('catalog.product.list', [
                        'select' => ['id', 'name', 'purchasingPrice'],
                        'filter' => ['iblockSectionId' => $bx_section_id],
                        'start'  => $start,
                    ]);
                    $products = $json['result']['products'] ?? [];
                    foreach ($products as $p) {
                        $items[] = [
                            'ID'          => $p['id'],
                            'NAME'        => $p['name'],
                            'PRICE'       => $p['purchasingPrice'] ?? '',
                            'CURRENCY_ID' => 'KZT',
                        ];
                    }
                    $start = $json['next'] ?? null;  // null — последняя страница
                } while ($start !== null && !empty($products));
            }

            // Формируем чистый массив для фронта
            $courses = [];
            foreach ($items as $p) {
                $courses[] = [
                    'id'       => (string)$p['ID'],
                    'name'     => $p['NAME'],
                    'price'    => $p['PRICE'] ?? '',
                    'currency' => $p['CURRENCY_ID'] ?? '',
                ];
            }

            return ['ok' => true, 'courses' => $courses];

        } catch (Throwable $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }

    }

    // Полный ответ Bitrix24 — нужен для пагинации (содержит 'result', 'next', 'total')
    public function bx_call(string $method, array $data = []): array {
        $url = rtrim($this->bx_webhook, '/') . '/' . $method . '.json';

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $response = curl_exec($ch);
        $errno    = curl_errno($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($errno) {
            throw new RuntimeException('cURL error: ' . $error);
        }

        $json = json_decode($response, true);
        if ($json === null) {  // null означает ошибку декодирования
            throw new RuntimeException('Invalid JSON response from Bitrix24');
        }
        if (!empty($json['error'])) {
            throw new RuntimeException($json['error_description'] ?? $json['error']);
        }

        return $json;
    }

    // Упрощённый вызов — возвращает только 'result', удобен когда пагинация не нужна
    public function bx_result(string $method, array $data = []): mixed {
        return $this->bx_call($method, $data)['result'] ?? [];
    }
}
