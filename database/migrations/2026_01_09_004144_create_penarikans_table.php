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
        Schema::create('penarikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_id')->constrained('koperasis')->onDelete('cascade');
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_penarikan')->useCurrent();
            $table->string('keterangan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users'); // Petugas yang input
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikans');
    }
};
