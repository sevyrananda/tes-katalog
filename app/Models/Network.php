<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'detail_spesifikasi',
        'klasifikasi',
        'brand',
        'model',
        'harga_asli_offline',
        'harga_asli_online',
        'harga_rab_20',
        'harga_rab_wajar',
        'tanggal_update',
        'nama_vendor',
        'jumlah_ketersediaan',
        'satuan',
        'keterangan',
        'gambar_perangkat',
        'link_ref',
    ];
}
