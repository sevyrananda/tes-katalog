<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Sparepart;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('sparepart')->get();
        return view('pages.barang_masuk.barang_masuk', compact('barangMasuk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori_id' => 'required',
            'kode_barang' => 'required|exists:spareparts,kode_barang',
            'nama_barang' => 'required',
            'jumlah_masuk' => 'required|integer',
            'lokasi_penyimpanan' => 'required'
        ]);

        BarangMasuk::create($validated);

        // Update stok di tabel Sparepart
        $sparepart = Sparepart::where('kode_barang', $request->kode_barang)->first();
        if ($sparepart) {
            $sparepart->increment('jumlah_ketersediaan', $request->jumlah_masuk);
        }

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dicatat!');
    }

    public function create()
{
    $spareparts = Sparepart::all(); // Ambil semua sparepart dari database
    return view('transaksi.barang_masuk.create', compact('spareparts'));
}

}

