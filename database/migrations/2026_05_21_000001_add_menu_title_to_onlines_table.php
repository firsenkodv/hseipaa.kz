<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onlines', function (Blueprint $table): void {
            $table->string('menu_title')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('onlines', function (Blueprint $table): void {
            $table->dropColumn('menu_title');
        });
    }
};
