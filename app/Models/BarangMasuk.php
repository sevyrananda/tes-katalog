<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'tanggal', 'kategori_id', 'kode_barang', 'nama_barang', 'jumlah_masuk', 'lokasi_penyimpanan'
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'kode_barang', 'kode_barang');
    }

    public function toolkit()
    {
        return $this->belongsTo(ToolKit::class, 'kode_barang', 'kode_barang');
    }
}
