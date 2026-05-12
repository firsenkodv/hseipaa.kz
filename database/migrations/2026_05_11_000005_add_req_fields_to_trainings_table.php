<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('req_title')->nullable()->after('adv_items');
            $table->string('req_desc')->nullable()->after('req_title');
            $table->text('req_items')->nullable()->after('req_desc');
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['req_title', 'req_desc', 'req_items']);
        });
    }
};
