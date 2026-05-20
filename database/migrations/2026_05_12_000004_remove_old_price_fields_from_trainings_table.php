<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['buy_old_price', 'buy_new_price']);
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->integer('buy_old_price')->nullable()->after('buy_certificate');
            $table->integer('buy_new_price')->nullable()->after('buy_old_price');
        });
    }
};
