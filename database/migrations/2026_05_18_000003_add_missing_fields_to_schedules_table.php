<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table): void {
            $table->string('template')->nullable()->after('slug');
            $table->string('img')->nullable()->after('subtitle');
            $table->string('img2')->nullable()->after('desc');
            $table->text('desc2')->nullable()->after('img2');
            $table->text('html')->nullable()->after('desc2');
            $table->text('html2')->nullable()->after('html');
            $table->text('params')->nullable()->after('html2');
            $table->text('video')->nullable()->after('params');
            $table->text('gallery')->nullable()->after('video');
            $table->text('files')->nullable()->after('gallery');
            $table->text('faq')->nullable()->after('script');
            $table->text('custom_field')->nullable()->after('faq');
            $table->text('custom_field2')->nullable()->after('custom_field');
            $table->text('custom_field3')->nullable()->after('custom_field2');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table): void {
            $table->dropColumn([
                'template', 'img', 'img2', 'desc2', 'html', 'html2',
                'params', 'video', 'gallery', 'files',
                'faq', 'custom_field', 'custom_field2', 'custom_field3',
            ]);
        });
    }
};
