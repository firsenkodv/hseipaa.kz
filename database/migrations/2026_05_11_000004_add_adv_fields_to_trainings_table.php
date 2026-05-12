<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('adv_title')->nullable()->after('get_items');
            $table->string('adv_desc')->nullable()->after('adv_title');
            $table->text('adv_items')->nullable()->after('adv_desc');
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['adv_title', 'adv_desc', 'adv_items']);
        });
    }
};
