<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consulting_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('sorting')->default(1);
            $table->timestamps();
        });

        Schema::create('consulting_consulting_category', function (Blueprint $table) {
            $table->foreignId('consulting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('consulting_category_id')->constrained()->cascadeOnDelete();
            $table->primary(['consulting_id', 'consulting_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consulting_consulting_category');
        Schema::dropIfExists('consulting_categories');
    }
};
