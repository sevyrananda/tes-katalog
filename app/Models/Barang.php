<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false; // Karena kode_barang bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
    ];
}
