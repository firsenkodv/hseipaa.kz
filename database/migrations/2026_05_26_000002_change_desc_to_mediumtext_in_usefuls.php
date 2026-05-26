<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getSchemaBuilder()->hasTable('usefuls')) {
            DB::statement("ALTER TABLE `usefuls` MODIFY `desc` MEDIUMTEXT NULL");
        }
    }

    public function down(): void
    {
        if (DB::getSchemaBuilder()->hasTable('usefuls')) {
            DB::statement("ALTER TABLE `usefuls` MODIFY `desc` TEXT NULL");
        }
    }
};
