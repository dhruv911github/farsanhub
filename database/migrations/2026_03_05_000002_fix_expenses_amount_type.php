<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Normalize empty/null values before altering column type
        DB::statement("UPDATE expenses SET amount = '0' WHERE amount = '' OR amount IS NULL");

        // Use raw ALTER TABLE — no doctrine/dbal required (Laravel 9 limitation)
        DB::statement('ALTER TABLE expenses MODIFY COLUMN amount DECIMAL(10,2) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        DB::statement('ALTER TABLE expenses MODIFY COLUMN amount VARCHAR(255) NOT NULL DEFAULT 0');
    }
};
