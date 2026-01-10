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
            $table->string('no_badan_hukum')->nullable()->after('nama');
            $table->string('email')->nullable()->after('kontak');
            $table->string('website')->nullable()->after('email');
            $table->text('deskripsi')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koperasis', function (Blueprint $table) {
            $table->dropColumn(['no_badan_hukum', 'email', 'website', 'deskripsi']);
        });
    }
};
