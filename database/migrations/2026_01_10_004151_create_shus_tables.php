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
        Schema::create('shus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koperasi_id')->constrained()->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('total_shu', 15, 2);
            $table->integer('persentase_anggota')->default(70); 
            $table->integer('persentase_modal')->default(60); 
            $table->integer('persentase_usaha')->default(40); 
            $table->decimal('total_dibagikan', 15, 2); 
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });

        Schema::create('shu_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shu_id')->constrained('shus')->onDelete('cascade');
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->decimal('shu_modal', 15, 2)->default(0);
            $table->decimal('shu_usaha', 15, 2)->default(0);
            $table->decimal('total_diterima', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shu_members');
        Schema::dropIfExists('shus');
    }
};
