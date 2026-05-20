<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedule_courses', function (Blueprint $table): void {
            $table->dropForeign(['schedule_id']);
            $table->dropColumn('schedule_id');
        });

        Schema::create('course_schedule', function (Blueprint $table): void {
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('schedule_courses')->cascadeOnDelete();
            $table->primary(['schedule_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_schedule');

        Schema::table('schedule_courses', function (Blueprint $table): void {
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
        });
    }
};
