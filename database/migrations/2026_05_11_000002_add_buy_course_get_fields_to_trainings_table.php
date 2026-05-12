<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Покупка
            $table->string('buy_title')->nullable()->after('custom_field3');
            $table->string('buy_desc')->nullable()->after('buy_title');
            $table->string('buy_calendar')->nullable()->after('buy_desc');
            $table->string('buy_hours')->nullable()->after('buy_calendar');
            $table->string('buy_certificate')->nullable()->after('buy_hours');
            $table->string('buy_old_price')->nullable()->after('buy_certificate');
            $table->string('buy_new_price')->nullable()->after('buy_old_price');

            // О курсе
            $table->string('course_title')->nullable()->after('buy_new_price');
            $table->string('course_desc')->nullable()->after('course_title');
            $table->text('course_items')->nullable()->after('course_desc');

            // Что вы получаете
            $table->string('get_title')->nullable()->after('course_items');
            $table->text('get_items')->nullable()->after('get_title');
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn([
                'buy_title', 'buy_desc', 'buy_calendar', 'buy_hours',
                'buy_certificate', 'buy_old_price', 'buy_new_price',
                'course_title', 'course_desc', 'course_items',
                'get_title', 'get_items',
            ]);
        });
    }
};
