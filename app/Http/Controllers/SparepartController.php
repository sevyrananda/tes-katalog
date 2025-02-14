<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\Barang;
use Illuminate\Support\Facades\File;

class SparepartController extends Controller
{
    // Menampilkan daftar sparepart
    public function index()
    {
        $spareparts = Sparepart::all();
        return view('pages.sparepart.sparepart', compact('spareparts'));
    }

    // Menyimpan data sparepart baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'detail_spesifikasi' => 'nullable',
            'klasifikasi' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'harga_asli_offline' => 'required|numeric',
            'harga_asli_online' => 'required|numeric',
            'harga_rab_20' => 'required|numeric',
            'harga_rab_wajar' => 'required|numeric',
            'tanggal_update' => 'required|date',
            'nama_vendor' => 'nullable',
            'jumlah_ketersediaan' => 'required|integer',
            'satuan' => 'required',
            'keterangan' => 'nullable',
            'gambar_perangkat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_ref' => 'nullable|url',
        ]);

        // Membuat kode barang otomatis
        $lastSparepart = Sparepart::latest()->first();
        $nextId = $lastSparepart ? $lastSparepart->id + 1 : 1;
        $validated['kode_barang'] = 'BA' . str_pad($nextId, 1, '0', STR_PAD_LEFT);

        // Proses upload gambar
        if ($request->hasFile('gambar_perangkat')) {
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/spareparts'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Simpan ke tabel sparepart
        $sparepart = Sparepart::create($validated);

        // Simpan ke tabel barang
        Barang::create([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'kategori_id' => $request->kategori_id ?? 1,
            'jumlah_ketersediaan' => $validated['jumlah_ketersediaan'],
        ]);

        return redirect()->route('sparepart.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Update data sparepart
    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::find($id);
        if (!$sparepart) {
            return response()->json(['message' => 'Sparepart tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'kode_barang' => 'required|unique:spareparts,kode_barang,' . $id,
            'nama_barang' => 'required',
            'detail_spesifikasi' => 'nullable',
            'klasifikasi' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'harga_asli_offline' => 'required|numeric',
            'harga_asli_online' => 'required|numeric',
            'harga_rab_20' => 'required|numeric',
            'harga_rab_wajar' => 'required|numeric',
            'tanggal_update' => 'required|date',
            'nama_vendor' => 'nullable',
            'jumlah_ketersediaan' => 'required|integer',
            'satuan' => 'required',
            'keterangan' => 'nullable',
            'gambar_perangkat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_ref' => 'nullable|url',
        ]);

        // Proses update gambar
        if ($request->hasFile('gambar_perangkat')) {
            // Hapus gambar lama jika ada
            if ($sparepart->gambar_perangkat && File::exists(public_path('images/spareparts/' . $sparepart->gambar_perangkat))) {
                File::delete(public_path('images/spareparts/' . $sparepart->gambar_perangkat));
            }

            // Upload gambar baru
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/spareparts'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data sparepart
        $sparepart->update($validated);

        // Update juga di tabel barang
        Barang::where('kode_barang', $sparepart->kode_barang)->update([
            'nama_barang' => $validated['nama_barang'],
            'jumlah_ketersediaan' => $validated['jumlah_ketersediaan'],
        ]);

        return redirect()->route('sparepart.index')->with('success', 'Sparepart Berhasil Diupdate');
    }

    // Menghapus sparepart
    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);

        // Hapus gambar jika ada
        if ($sparepart->gambar_perangkat && File::exists(public_path('images/spareparts/' . $sparepart->gambar_perangkat))) {
            File::delete(public_path('images/spareparts/' . $sparepart->gambar_perangkat));
        }

        // Hapus data sparepart
        $sparepart->delete();

        // Hapus juga dari tabel barang
        Barang::where('kode_barang', $sparepart->kode_barang)->delete();

        return redirect()->route('sparepart.index')->with('success', 'Sparepart Berhasil Dihapus');
    }

    // Relasi ke tabel barang_masuk
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'kode_barang', 'kode_barang');
    }

    // Relasi ke tabel barang_keluar
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'kode_barang', 'kode_barang');
    }
}
