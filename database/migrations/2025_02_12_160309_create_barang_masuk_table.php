<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('barang_masuk', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->unsignedBigInteger('kategori_id');
        $table->string('kode_barang');
        $table->string('nama_barang');
        $table->integer('jumlah_masuk');
        $table->string('lokasi_penyimpanan');
        $table->timestamps();
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
