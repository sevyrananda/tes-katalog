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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 255)->unique();
            $table->string('nama_barang', 255);
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->integer('jumlah_ketersediaan')->default(0);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('kategori_id')->references('id')->on('kategori_barang')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
