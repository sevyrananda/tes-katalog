<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::all();
        return view('pages.sparepart.sparepart', compact('spareparts'));
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

    // Dapatkan ID terakhir dari database
    $lastSparepart = Sparepart::latest()->first();
    $nextId = $lastSparepart ? $lastSparepart->id + 1 : 1;
    $validated['kode_barang'] = 'BA' . $nextId; // Format Kode Barang

    $sparepart = new Sparepart($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/spareparts'), $imageName);
        $sparepart->gambar_perangkat = $imageName;
    }

    $sparepart->save();

    return redirect()->route('sparepart.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update sparepart
    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::find($id);

        if (!$sparepart) {
            return response()->json(['message' => 'Sparepart not found'], 404);
        }

        // Validasi input
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

        // Jika ada gambar baru, hapus gambar lama dan upload gambar baru
        if ($request->hasFile('gambar_perangkat')) {
            if ($sparepart->gambar_perangkat && file_exists(public_path('images/spareparts/' . $sparepart->gambar_perangkat))) {
                unlink(public_path('images/spareparts/' . $sparepart->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/spareparts'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data sparepart
        $sparepart->update($validated);

        return redirect()->route('sparepart.index')->with('success', 'Sparepart Berhasil Diupdate');
    }

    // Method untuk menghapus data sparepart
    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect()->route('sparepart.index')->with('success', 'Sparepart Berhasil Dihapus');
    }

    public function barangMasuk()
{
    return $this->hasMany(BarangMasuk::class, 'kode_barang', 'kode_barang');
}

public function barangKeluar()
{
    return $this->hasMany(BarangKeluar::class, 'kode_barang', 'kode_barang');
}

}
