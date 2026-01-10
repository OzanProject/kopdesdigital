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
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_id')->constrained('koperasis')->onDelete('cascade');
            $table->string('no_anggota');
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->date('tanggal_bergabung')->useCurrent();
            $table->enum('status', ['active', 'inactive', 'keluar'])->default('active');
            $table->timestamps();

            // Unique constraints per koperasi
            $table->unique(['koperasi_id', 'no_anggota']);
            $table->unique(['koperasi_id', 'nik']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabahs');
    }
};
