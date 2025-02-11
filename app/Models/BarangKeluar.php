<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'kategori_id', 'kode_barang', 'nama_barang', 'jumlah_keluar', 'tujuan'
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'kode_barang', 'kode_barang');
    }
}
