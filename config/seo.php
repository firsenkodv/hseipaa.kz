<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Модели с прямыми SEO-полями (metatitle / description / keywords)
    |--------------------------------------------------------------------------
    | Трейт HasSeo автоматически синхронизирует их в таблицу seos при saved.
    | Ключ — префикс записи в seos (например, 'training:42').
    */
    'models' => [
        'about'      => \App\Models\About::class,
        'document'   => \App\Models\Document::class,
        'training'   => \App\Models\Training::class,
        'consulting' => \App\Models\Consulting::class,
        'useful'     => \App\Models\Useful::class,
        'online'     => \App\Models\Online::class,
        'team'       => \App\Models\Team::class,
        'partner'    => \App\Models\Partner::class,
        'law'        => \App\Models\Law::class,
        'news'       => \App\Models\News::class,
        'important'  => \App\Models\Important::class,
        'seminar'    => \App\Models\Seminar::class,
        'schedule'   => \App\Models\Schedule::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Setting-группы, у которых есть SEO-поля (хранятся в JSON data)
    |--------------------------------------------------------------------------
    | SettingObserver синхронизирует их в seos при saved.
    | Ключ записи в seos — 'page:{group}', model_class = Setting::class.
    | Группы без SEO (toast, social, calculator, promo_modal) сюда не входят.
    */
    'settings' => [
        'home'             => 'Главная страница',
        'onas'             => 'О нас (раздел)',
        'onas_team'        => 'Команда (раздел)',
        'onas_partnjory'   => 'Партнёры (раздел)',
        'onas_dokumenty'   => 'Документы (раздел)',
        'klienty'          => 'Клиенты (раздел)',
        'o_kompanii'       => 'О компании (раздел)',
        'sotrudnichestvo'  => 'Сотрудничество (раздел)',
        'obuchenie'        => 'Обучение (раздел)',
        'konsalting'       => 'Консалтинг (раздел)',
        'distantcionno'    => 'Дистанционно (раздел)',
        'schedule'         => 'Расписание (раздел)',
        'poleznoe'         => 'Полезное (раздел)',
        'poleznoe_novosti' => 'Новости (раздел)',
        'poleznoe_vazhnoe' => 'Статьи (раздел)',
        'poleznoe_zakony'  => 'Законы (раздел)',
        'poleznoe_seminar' => 'Семинары (раздел)',
        'poleznoe_diplomy' => 'Дипломы (раздел)',
    ],

];
