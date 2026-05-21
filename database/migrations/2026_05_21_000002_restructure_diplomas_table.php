<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $drop = [
        'slug', 'template', 'subtitle', 'short_desc',
        'img', 'desc', 'img2', 'desc2', 'html', 'html2',
        'params', 'video', 'gallery', 'files',
        'metatitle', 'description', 'keywords', 'script',
        'faq', 'custom_field', 'custom_field2', 'custom_field3',
    ];

    public function up(): void
    {
        Schema::table('diplomas', function (Blueprint $table): void {
            $table->dropColumn($this->drop);
        });

        Schema::table('diplomas', function (Blueprint $table): void {
            $table->string('fio')->nullable()->after('title');
            $table->date('issued_at')->nullable()->after('fio');
            $table->string('discipline')->nullable()->after('issued_at');
        });
    }

    public function down(): void
    {
        Schema::table('diplomas', function (Blueprint $table): void {
            $table->dropColumn(['fio', 'issued_at', 'discipline']);
        });

        Schema::table('diplomas', function (Blueprint $table): void {
            $table->string('slug')->unique()->after('title');
            $table->string('template')->default('default')->after('slug');
            $table->string('subtitle')->nullable()->after('template');
            $table->text('short_desc')->nullable();
            $table->string('img')->nullable();
            $table->text('desc')->nullable();
            $table->string('img2')->nullable();
            $table->text('desc2')->nullable();
            $table->text('html')->nullable();
            $table->text('html2')->nullable();
            $table->text('params')->nullable();
            $table->string('video')->nullable();
            $table->text('gallery')->nullable();
            $table->text('files')->nullable();
            $table->string('metatitle')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->text('script')->nullable();
            $table->text('faq')->nullable();
            $table->text('custom_field')->nullable();
            $table->text('custom_field2')->nullable();
            $table->text('custom_field3')->nullable();
        });
    }
};
