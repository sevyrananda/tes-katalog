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
        Schema::create('cctvs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->text('detail_spesifikasi')->nullable();
            $table->string('klasifikasi');
            $table->string('brand');
            $table->string('model')->nullable();
            $table->decimal('harga_asli_offline', 15, 2)->default(0);
            $table->decimal('harga_asli_online', 15, 2)->default(0);
            $table->decimal('harga_rab_20', 15, 2)->default(0);
            $table->decimal('harga_rab_wajar', 15, 2)->default(0);
            $table->date('tanggal_update')->nullable();
            $table->string('nama_vendor');
            $table->integer('jumlah_ketersediaan')->default(0);
            $table->string('satuan');
            $table->text('keterangan')->nullable();
            $table->string('gambar_perangkat')->nullable();
            $table->string('link_ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctvs');
    }
};
