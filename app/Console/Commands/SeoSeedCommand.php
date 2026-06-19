<?php

namespace App\Console\Commands;

use App\Models\Seo;
use App\Models\Setting;
use Illuminate\Console\Command;

class SeoSeedCommand extends Command
{
    protected $signature = 'seo:seed';

    protected $description = 'Populate seos table from all content models and Setting groups';

    public function handle(): int
    {
        // Контентные модели — через трейт HasSeo
        foreach (config('seo.models', []) as $prefix => $class) {
            $this->info("Processing {$class}...");
            $count = 0;

            $class::query()->each(function ($item) use (&$count) {
                try {
                    $item->syncSeoRecord();
                    $count++;
                } catch (\Throwable $e) {
                    $this->warn("  Skipped id={$item->id}: {$e->getMessage()}");
                }
            });

            $this->line("  → {$count} records");
        }

        // Setting-группы с SEO — синхронизируем напрямую
        $settings = config('seo.settings', []);
        $this->info('Processing Setting groups...');
        foreach ($settings as $group => $label) {
            try {
                $setting = Setting::getGroup($group);
                Seo::updateOrCreate(
                    ['key' => "page:{$group}"],
                    [
                        'model_class' => Setting::class,
                        'label'       => $label,
                        'title'       => $setting->metatitle ?? null,
                        'description' => $setting->description ?? null,
                        'keywords'    => $setting->keywords ?? null,
                    ]
                );
            } catch (\Throwable $e) {
                $this->warn("  Skipped group={$group}: {$e->getMessage()}");
            }
        }
        $this->line('  → ' . count($settings) . ' setting pages');

        $this->info('Done.');

        return self::SUCCESS;
    }
}
