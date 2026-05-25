<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultings', function (Blueprint $table) {
            // Покупка
            $table->string('buy_title')->nullable()->after('faq');
            $table->string('buy_desc')->nullable()->after('buy_title');
            $table->string('buy_calendar')->nullable()->after('buy_desc');
            $table->string('buy_hours')->nullable()->after('buy_calendar');
            $table->string('buy_certificate')->nullable()->after('buy_hours');
            $table->string('format')->nullable()->after('buy_certificate');
            $table->json('price')->nullable()->after('format');
            // О курсе
            $table->string('course_title')->nullable()->after('price');
            $table->string('course_desc')->nullable()->after('course_title');
            $table->json('course_items')->nullable()->after('course_desc');
            // Что вы получаете
            $table->string('get_title')->nullable()->after('course_items');
            $table->json('get_items')->nullable()->after('get_title');
            // Преимущества
            $table->string('adv_title')->nullable()->after('get_items');
            $table->string('adv_desc')->nullable()->after('adv_title');
            $table->json('adv_items')->nullable()->after('adv_desc');
            // Требования
            $table->string('req_title')->nullable()->after('adv_items');
            $table->string('req_desc')->nullable()->after('req_title');
            $table->json('req_items')->nullable()->after('req_desc');
            // Кому подойдет
            $table->string('aud_title')->nullable()->after('req_items');
            $table->json('aud_items')->nullable()->after('aud_title');
            // Программа курса
            $table->string('outline_title')->nullable()->after('aud_items');
            $table->text('outline_desc')->nullable()->after('outline_title');
            $table->json('outline_stats')->nullable()->after('outline_desc');
            $table->json('outline_modules')->nullable()->after('outline_stats');
        });
    }

    public function down(): void
    {
        Schema::table('consultings', function (Blueprint $table) {
            $table->dropColumn([
                'buy_title', 'buy_desc', 'buy_calendar', 'buy_hours', 'buy_certificate', 'format', 'price',
                'course_title', 'course_desc', 'course_items',
                'get_title', 'get_items',
                'adv_title', 'adv_desc', 'adv_items',
                'req_title', 'req_desc', 'req_items',
                'aud_title', 'aud_items',
                'outline_title', 'outline_desc', 'outline_stats', 'outline_modules',
            ]);
        });
    }
};
