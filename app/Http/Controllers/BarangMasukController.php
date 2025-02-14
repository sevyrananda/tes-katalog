<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Sparepart;
use App\Models\ToolKit;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with(['sparepart', 'toolkit'])->get();
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

        // Simpan ke tabel barang_masuk
        $barangMasuk = BarangMasuk::create($validated);

        // Update stok di tabel Sparepart atau Toolkit
        $this->updateStock($validated['kode_barang'], $validated['jumlah_masuk']);

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dicatat!');
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $kategoriBarang = KategoriBarang::all();
        $kodeBarangList = Sparepart::select('kode_barang', 'nama_barang', 'kategori_id')->get();
        $kodeToolkit = ToolKit::select('kode_barang', 'nama_barang', 'kategori_id')->get();

        return view('pages.barang_masuk.edit', compact('barangMasuk', 'kategoriBarang', 'kodeBarangList', 'kodeToolkit'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategori_barang,id',
            'kode_barang' => 'required|exists:barang,kode_barang',
            'nama_barang' => 'required|string',
            'jumlah_masuk' => 'required|integer|min:1',
            'lokasi_penyimpanan' => 'required|string'
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);

        // Kurangi stok lama
        $this->updateStock($barangMasuk->kode_barang, -$barangMasuk->jumlah_masuk);

        // Update data barang masuk
        $barangMasuk->update($validated);

        // Tambah stok baru
        $this->updateStock($validated['kode_barang'], $validated['jumlah_masuk']);

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Kurangi stok sebelum menghapus
        $this->updateStock($barangMasuk->kode_barang, -$barangMasuk->jumlah_masuk);

        $barangMasuk->delete();

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dihapus!');
    }

    private function updateStock($kode_barang, $jumlah)
    {
        $sparepart = Sparepart::where('kode_barang', $kode_barang)->first();
        if ($sparepart) {
            $sparepart->increment('jumlah_ketersediaan', $jumlah);
        } else {
            $toolkit = ToolKit::where('kode_barang', $kode_barang)->first();
            if ($toolkit) {
                $toolkit->increment('jumlah_ketersediaan', $jumlah);
            }
        }
    }
    
}
