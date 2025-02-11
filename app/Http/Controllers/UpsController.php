<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ups;

class UpsController extends Controller
{
    public function index()
    {
        $upss = Ups::all();
        return view('pages.ups.ups', compact('upss'));
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

    // Dapupsan ID terakhir dari database
    $lastUps = Ups::latest()->first();
    $nextId = $lastUps ? $lastUps->id + 1 : 1;
    $validated['kode_barang'] = 'BL' . $nextId; // Format Kode Barang

    $ups = new Ups($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/upss'), $imageName);
        $ups->gambar_perangkat = $imageName;
    }

    $ups->save();

    return redirect()->route('ups.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update ups
    public function update(Request $request, $id)
    {
        $ups = Ups::find($id);

        if (!$ups) {
            return response()->json(['message' => 'Ups not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:upss,kode_barang,' . $id,
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
            if ($ups->gambar_perangkat && file_exists(public_path('images/upss/' . $ups->gambar_perangkat))) {
                unlink(public_path('images/upss/' . $ups->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/upss'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data ups
        $ups->update($validated);

        return redirect()->route('ups.index')->with('success', 'UPS & Baterai Berhasil Diupdate');
    }

    // Method untuk menghapus data ups
    public function destroy($id)
    {
        $ups = Ups::findOrFail($id);
        $ups->delete();

        return redirect()->route('ups.index')->with('success', 'UPS & Baterai Berhasil Dihapus');
    }
}
