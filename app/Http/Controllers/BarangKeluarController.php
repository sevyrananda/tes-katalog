<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Sparepart;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('sparepart')->get();
        return view('pages.transaksi.barang_keluar', compact('barangKeluar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori_id' => 'required',
            'kode_barang' => 'required|exists:spareparts,kode_barang',
            'nama_barang' => 'required',
            'jumlah_keluar' => 'required|integer',
            'tujuan' => 'required'
        ]);

        $sparepart = Sparepart::where('kode_barang', $request->kode_barang)->first();

        if ($sparepart && $sparepart->jumlah_ketersediaan >= $request->jumlah_keluar) {
            BarangKeluar::create($validated);
            $sparepart->decrement('jumlah_ketersediaan', $request->jumlah_keluar);
            return redirect()->route('barang_keluar.index')->with('success', 'Barang keluar berhasil dicatat!');
        } else {
            return redirect()->route('barang_keluar.index')->with('error', 'Stok tidak mencukupi!');
        }
    }
}
