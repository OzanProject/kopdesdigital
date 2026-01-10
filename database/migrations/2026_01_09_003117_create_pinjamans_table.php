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
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_id')->constrained('koperasis')->onDelete('cascade');
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            
            $table->decimal('jumlah_pengajuan', 15, 2);
            $table->integer('tenor_bulan'); // Lama pinjaman dalam bulan
            $table->decimal('bunga_persen', 5, 2)->default(0); // Bunga per bulan
            
            $table->decimal('jumlah_disetujui', 15, 2)->nullable();
            
            // Status Approval
            $table->enum('status', ['pending', 'approved', 'rejected', 'lunas'])->default('pending');
            $table->date('tanggal_pengajuan')->useCurrent();
            $table->date('tanggal_disetujui')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};
