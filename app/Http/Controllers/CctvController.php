<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cctv;

class CctvController extends Controller
{
    public function index()
    {
        $cctvs = Cctv::all();
        return view('pages.cctv.cctv', compact('cctvs'));
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
    $lastCctv = Cctv::latest()->first();
    $nextId = $lastCctv ? $lastCctv->id + 1 : 1;
    $validated['kode_barang'] = 'BD' . $nextId; // Format Kode Barang

    $cctv = new Cctv($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/cctvs'), $imageName);
        $cctv->gambar_perangkat = $imageName;
    }

    $cctv->save();

    return redirect()->route('cctv.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update cctv
    public function update(Request $request, $id)
    {
        $cctv = Cctv::find($id);

        if (!$cctv) {
            return response()->json(['message' => 'Cctv not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:cctvs,kode_barang,' . $id,
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
            if ($cctv->gambar_perangkat && file_exists(public_path('images/cctvs/' . $cctv->gambar_perangkat))) {
                unlink(public_path('images/cctvs/' . $cctv->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/cctvs'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data cctv
        $cctv->update($validated);

        return redirect()->route('cctv.index')->with('success', 'CCTV Berhasil Diupdate');
    }

    // Method untuk menghapus data cctv
    public function destroy($id)
    {
        $cctv = Cctv::findOrFail($id);
        $cctv->delete();

        return redirect()->route('cctv.index')->with('success', 'CCTV Berhasil Dihapus');
    }
}
