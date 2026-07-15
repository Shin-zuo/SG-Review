<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('extension_status')->nullable()->after('trial_expires_at'); // pending, approved, rejected
            $table->integer('extension_days')->default(0)->after('extension_status');
            $table->text('extension_reason')->nullable()->after('extension_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['extension_status', 'extension_days', 'extension_reason']);
        });
    }
};
