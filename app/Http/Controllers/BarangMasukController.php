<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Sparepart;
use App\Models\ToolKit;
use App\Models\KategoriBarang;

class BarangMasukController extends Controller
{
    public function index()
{
    $barangMasuk = BarangMasuk::with('sparepart')->get();

    // Mengambil daftar kategori dan kode barang dari tabel sparepart
    $kategoriBarang = KategoriBarang::all();

    $kodeBarangList = Sparepart::select('kode_barang', 'nama_barang', 'kategori_id')->get();

    $kodeToolkit = ToolKit::select('kode_barang', 'nama_barang', 'kategori_id')->get();

    return view('pages.barang_masuk.barang_masuk', compact('barangMasuk', 'kategoriBarang', 'kodeBarangList', 'kodeToolkit'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'tanggal' => 'required|date',
        'kategori_id' => 'required|exists:kategori_barang,id',
        'kode_barang' => 'required|exists:barang,kode_barang',
        'nama_barang' => 'required|string',
        'jumlah_masuk' => 'required|integer|min:1',
        'lokasi_penyimpanan' => 'required|string'
    ]);

    BarangMasuk::create($validated);

    return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dicatat!');
}

    public function create()
    {
        // Mengambil daftar kategori yang unik dari tabel kategori barang
        $kategoriBarang = KategoriBarang::all();
    
        // Ambil kode barang dengan relasi kategori
        $kodeBarangList = Sparepart::select('kode_barang', 'nama_barang', 'kategori_id')->get();

        $kodeToolkit = ToolKit::select('kode_barang', 'nama_barang', 'kategori_id')->get();
    
        return view('transaksi.barang_masuk.create', compact('kodeBarangList', 'kategoriBarang', 'kodeToolkit'));
    }    

}

