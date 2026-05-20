<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('outline_title')->nullable()->after('aud_items');
            $table->text('outline_desc')->nullable()->after('outline_title');
            $table->json('outline_stats')->nullable()->after('outline_desc');
            $table->json('outline_modules')->nullable()->after('outline_stats');
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['outline_title', 'outline_desc', 'outline_stats', 'outline_modules']);
        });
    }
};
