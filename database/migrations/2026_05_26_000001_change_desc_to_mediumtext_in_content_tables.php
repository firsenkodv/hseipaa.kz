<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $tables = ['trainings', 'laws', 'news', 'importants', 'seminars', 'consultings'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::statement("ALTER TABLE `{$table}` MODIFY `desc` MEDIUMTEXT NULL");
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::statement("ALTER TABLE `{$table}` MODIFY `desc` TEXT NULL");
            }
        }
    }
};
