<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToolKit;
use App\Models\Barang;
use Illuminate\Support\Facades\File;

class ToolKitController extends Controller
{
    public function index()
    {
        $toolkits = ToolKit::all();
        return view('pages.toolkit.toolkit', compact('toolkits'));
    }

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

        $lastToolKit = ToolKit::latest()->first();
        $nextId = $lastToolKit ? $lastToolKit->id + 1 : 1;
        $validated['kode_barang'] = 'BB' . str_pad($nextId, 1, '0', STR_PAD_LEFT);

        // Proses upload gambar
        if ($request->hasFile('gambar_perangkat')) {
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/toolkits'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Simpan ke tabel toolkit
        $toolkit = ToolKit::create($validated);

        // Simpan ke tabel barang
        Barang::create([
            'kode_barang' => $validated['kode_barang'],
            'nama_barang' => $validated['nama_barang'],
            'kategori_id' => $request->kategori_id ?? 2,
            'jumlah_ketersediaan' => $validated['jumlah_ketersediaan'],
        ]);

        return redirect()->route('toolkit.index')->with('success', 'Data berhasil ditambahkan!');
    }


    // Method update: memproses data update toolkit
    public function update(Request $request, $id)
    {
        $toolkit = ToolKit::find($id);

        if (!$toolkit) {
            return response()->json(['message' => 'Toolkit not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:toolkits,kode_barang,' . $id,
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
            if ($toolkit->gambar_perangkat && File::exists(public_path('images/toolkits/' . $toolkit->gambar_perangkat))) {
                File::delete(public_path('images/toolkits/' . $toolkit->gambar_perangkat));
            }

            // Upload gambar baru
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/toolkits'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data toolkit
        $toolkit->update($validated);

        // Update juga di tabel barang
        Barang::where('kode_barang', $toolkit->kode_barang)->update([
            'nama_barang' => $validated['nama_barang'],
            'jumlah_ketersediaan' => $validated['jumlah_ketersediaan'],
        ]);

        return redirect()->route('toolkit.index')->with('success', 'Toolkit Berhasil Diupdate');
    }

    // Method untuk menghapus data toolkit
    public function destroy($id)
    {
        $toolkit = ToolKit::findOrFail($id);

        // Hapus gambar jika ada
        if ($toolkit->gambar_perangkat && File::exists(public_path('images/toolkits/' . $toolkit->gambar_perangkat))) {
            File::delete(public_path('images/toolkits/' . $toolkit->gambar_perangkat));
        }

        // Hapus data toolkit
        $toolkit->delete();

        // Hapus juga dari tabel barang
        Barang::where('kode_barang', $toolkit->kode_barang)->delete();

        return redirect()->route('toolkit.index')->with('success', 'Toolkit Berhasil Dihapus');
    }

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