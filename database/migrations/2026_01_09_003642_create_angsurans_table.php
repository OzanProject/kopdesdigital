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
        Schema::create('angsurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pinjaman_id')->constrained('pinjamans')->onDelete('cascade');
            $table->foreignId('koperasi_id')->constrained('koperasis'); // Untuk index/query lebih cepat per tenant
            
            $table->integer('angsuran_ke');
            $table->date('jatuh_tempo');
            $table->decimal('jumlah_bayar', 15, 2); // Pokok + Bunga
            
            $table->enum('status', ['unpaid', 'paid', 'late', 'partial'])->default('unpaid');
            
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('jumlah_dibayar', 15, 2)->default(0);
            $table->decimal('denda', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};
