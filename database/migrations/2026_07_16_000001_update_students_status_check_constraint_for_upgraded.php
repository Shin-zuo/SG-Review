<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE students DROP CONSTRAINT IF EXISTS students_status_check');
        DB::statement("ALTER TABLE students ADD CONSTRAINT students_status_check CHECK (status::text IN ('pending', 'paid', 'active', 'expired', 'failed', 'cancelled', 'upgraded'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE students DROP CONSTRAINT IF EXISTS students_status_check');
        DB::statement("ALTER TABLE students ADD CONSTRAINT students_status_check CHECK (status::text IN ('pending', 'paid', 'active', 'expired', 'failed', 'cancelled'))");
    }
};
