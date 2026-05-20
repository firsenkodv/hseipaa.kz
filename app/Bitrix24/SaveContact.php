<?php

namespace App\Bitrix24;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Support\Traits\Makeable;

class SaveContact extends Courses
{
    use Makeable;

    public function save(array $array): bool
    {
        // 1. Компания — только для юр.лиц; null = физлицо (норма), false = ошибка
        $companyId = $this->saveCompany($array);
        if ($companyId === false) {
            return false;
        }

        // 2. Контакт — обязателен, без него дальше не идём; передаём companyId для привязки
        $contactId = $this->saveContact($array, $companyId);
        if ($contactId === false) {
            return false;
        }

        // 3. Сделка — передаём оба ID
        $dealId = $this->saveDeal($array, $companyId, $contactId);

        return $dealId !== false;
    }

    public function saveContact(array $array, int|null $companyId = null): int|false
    {
        try {
            $contactId = null;

            // 1. Поиск по телефону
            $found = $this->bx_result('crm.contact.list', [
                'filter' => ['PHONE' => $array['phone']],
                'select' => ['ID'],
                'start'  => 0,
            ]);
            if (!empty($found)) {
                $contactId = (int) $found[0]['ID'];
            }

            // 2. Поиск по email
            if (!$contactId && $array['email']) {
                $found = $this->bx_result('crm.contact.list', [
                    'filter' => ['EMAIL' => $array['email']],
                    'select' => ['ID'],
                    'start'  => 0,
                ]);
                if (!empty($found)) {
                    $contactId = (int) $found[0]['ID'];
                }
            }

            // 3. Создать, если не нашли
            if (!$contactId) {
                $fields = [
                    'NAME'           => $array['name'],
                    'LAST_NAME'      => null,
                    'SECOND_NAME'    => null,
                    'ASSIGNED_BY_ID' => $this->bx_resp_id,
                    'SOURCE_ID'      => 'WEB',
                ];
                if ($companyId)      $fields['COMPANY_ID'] = $companyId;
                if ($array['phone']) $fields['PHONE'] = [['VALUE' => $array['phone'], 'VALUE_TYPE' => 'WORK']];
                if ($array['email']) $fields['EMAIL'] = [['VALUE' => $array['email'], 'VALUE_TYPE' => 'WORK']];

                $contactId = (int) $this->bx_result('crm.contact.add', ['fields' => $fields]);
            }

            return $contactId;

        } catch (\Throwable $e) {
            \Log::error('Bitrix24 saveContact error: ' . $e->getMessage(), ['data' => $array]);
            return false;
        }
    }

    public function saveCompany(array $array): int|null|false
    {
        // Физлицо — компания не нужна
        if (empty($array['organization']) || $array['organization'] === ' - ') {
            return null;
        }

        try {
            $companyId = null;

            // 1. Поиск по названию
            $found = $this->bx_result('crm.company.list', [
                'filter' => ['%TITLE' => $array['organization']],
                'select' => ['ID'],
                'start'  => 0,
            ]);
            if (!empty($found)) {
                $companyId = (int) $found[0]['ID'];
            }

            // 2. Поиск по email
            if (!$companyId && $array['email']) {
                $found = $this->bx_result('crm.company.list', [
                    'filter' => ['EMAIL' => $array['email']],
                    'select' => ['ID'],
                    'start'  => 0,
                ]);
                if (!empty($found)) {
                    $companyId = (int) $found[0]['ID'];
                }
            }

            // 3. Создать, если не нашли
            if (!$companyId) {
                $fields = [
                    'TITLE'          => $array['organization'],
                    'ASSIGNED_BY_ID' => $this->bx_resp_id,
                    'SOURCE_ID'      => 'WEB',
                ];
                if ($array['phone']) $fields['PHONE'] = [['VALUE' => $array['phone'], 'VALUE_TYPE' => 'WORK']];
                if ($array['email']) $fields['EMAIL'] = [['VALUE' => $array['email'], 'VALUE_TYPE' => 'WORK']];

                $companyId = (int) $this->bx_result('crm.company.add', ['fields' => $fields]);
            }

            return $companyId;

        } catch (\Throwable $e) {
            \Log::error('Bitrix24 saveCompany error: ' . $e->getMessage(), ['data' => $array]);
            return false;
        }
    }

    public function saveDeal(array $array, int|null $companyId = null, int|null $contactId = null): int|false
    {
        try {
            $isLegal = ($array['type'] ?? '') === 'legal';

            // Сопоставляем ID из запроса с полными данными товаров (id, name, price)
            $resolvedItems = $this->resolveItems($array);

            $itemLabel = !empty($resolvedItems)
                ? implode(', ', array_column($resolvedItems, 'name'))
                : '-';

            $dealTitle = 'Заявка от '. config('app.url').': ' . $itemLabel . ' — ' . ($array['organization'] ?? $array['name']);

            $comments = ['Тип клиента: ' . ($isLegal ? 'Юридическое лицо' : 'Физическое лицо')];
            foreach ($resolvedItems as $type => $item) {
                $comments[] = ucfirst($type) . ': ' . $item['name'];
            }
            foreach ($array['extras'] ?? [] as $label => $value) {
                if ($value) {
                    $comments[] = $label . ': ' . $value;
                }
            }

            // Сумма сделки — сумма цен всех выбранных товаров
            $opportunity = array_sum(array_column($resolvedItems, 'price'));

            $dealFields = [
                'TITLE'          => $dealTitle,
                'STAGE_ID'       => 'NEW',
                'SOURCE_ID'      => 'WEB',
                'ASSIGNED_BY_ID' => $this->bx_resp_id,
                'COMMENTS'       => implode("\n", array_filter($comments)),
            ];

            if ($opportunity)  $dealFields['OPPORTUNITY'] = $opportunity;
            if ($contactId)    $dealFields['CONTACT_ID']  = $contactId;
            if ($companyId)    $dealFields['COMPANY_ID']  = $companyId;

            $dealId = (int) $this->bx_result('crm.deal.add', ['fields' => $dealFields]);

            // Привязываем товарные строки к сделке (вкладка «Товары» в Битрикс24)
            if ($dealId && !empty($resolvedItems)) {
                $rows = [];
                foreach ($resolvedItems as $item) {
                    $rows[] = [
                        'PRODUCT_ID'   => (int) $item['id'],
                        'PRODUCT_NAME' => $item['name'],
                        'PRICE'        => (float) $item['price'],
                        'QUANTITY'     => 1,
                    ];
                }
                try {
                    $this->bx_result('crm.deal.productrows.set', [
                        'id'   => $dealId,
                        'rows' => $rows,
                    ]);
                } catch (\Throwable $e) {
                    \Log::error('Bitrix24 productrows error: ' . $e->getMessage(), ['dealId' => $dealId]);
                }
            }

            return $dealId;

        } catch (\Throwable $e) {
            \Log::error('Bitrix24 saveDeal error: ' . $e->getMessage(), ['data' => $array]);
            return false;
        }
    }

    private function resolveItems(array $array): array
    {
        $sections = Setting::getGroup('social')->getValue('b24', []) ?? [];

        if (empty($sections)) {
            return [];
        }

        $resolved = [];

        foreach ($sections as $section) {
            $type      = $section['json_forms']    ?? null;
            $sectionId = $section['bx_section_id'] ?? null;

            if (!$type || !$sectionId) {
                continue;
            }

            $id = $array[$type] ?? null;
            if (!$id) {
                continue;
            }

            $courses = $this->getCourses($sectionId);
            if (empty($courses['courses'])) {
                continue;
            }

            foreach ($courses['courses'] as $course) {
                if ((string) $course['id'] === (string) $id) {
                    $resolved[$type] = [
                        'id'    => $course['id'],
                        'name'  => $course['name'],
                        'price' => (float) ($course['price'] ?? 0),
                    ];
                    break;
                }
            }
        }

        return $resolved;
    }
}
