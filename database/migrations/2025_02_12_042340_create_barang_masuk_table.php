<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id(); // Auto Increment Primary Key menggunakan BigInt
            $table->date('tanggal');
            $table->unsignedBigInteger('kategori_id')->nullable()->index(); // Sesuai dengan kategori_barang
            $table->string('kode_barang', 255)->nullable()->index();
            $table->string('nama_barang', 255)->nullable();
            $table->integer('jumlah_masuk');
            $table->string('lokasi_penyimpanan', 255)->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('kategori_id')->references('id')->on('kategori_barang')->onDelete('set null');
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
