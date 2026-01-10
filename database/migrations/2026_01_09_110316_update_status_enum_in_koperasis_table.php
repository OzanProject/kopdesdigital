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
        Schema::table('koperasis', function (Blueprint $table) {
            // Using raw statement because changing enum in Laravel is tricky with Doctrine
            DB::statement("ALTER TABLE koperasis MODIFY COLUMN status ENUM('active', 'inactive', 'suspended', 'pending_payment') DEFAULT 'pending_payment'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koperasis', function (Blueprint $table) {
            DB::statement("ALTER TABLE koperasis MODIFY COLUMN status ENUM('active', 'inactive', 'suspended') DEFAULT 'active'");
        });
    }
};
