<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table): void {
            $table->string('metatitle')->nullable()->after('sorting');
            $table->string('description')->nullable()->after('metatitle');
            $table->string('keywords')->nullable()->after('description');
            $table->text('script')->nullable()->after('keywords');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table): void {
            $table->dropColumn(['metatitle', 'description', 'keywords', 'script']);
        });
    }
};
