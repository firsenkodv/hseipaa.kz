<?php

namespace App\Observers;

use App\Models\Seo;
use App\Models\Setting;

class SettingObserver
{
    public function saved(Setting $setting): void
    {
        try {
            $settings = config('seo.settings', []);

            if (! array_key_exists($setting->group, $settings)) {
                return;
            }

            Seo::updateOrCreate(
                ['key' => "page:{$setting->group}"],
                [
                    'model_class' => Setting::class,
                    'label'       => $settings[$setting->group],
                    'title'       => $setting->metatitle ?? null,
                    'description' => $setting->description ?? null,
                    'keywords'    => $setting->keywords ?? null,
                ]
            );
        } catch (\Throwable $e) {
            // таблица seos ещё не создана — пропускаем
        }
    }
}
