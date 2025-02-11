<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atk;

class AtkController extends Controller
{
    public function index()
    {
        $atks = Atk::all();
        return view('pages.atk.atk', compact('atks'));
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
    $lastAtk = Atk::latest()->first();
    $nextId = $lastAtk ? $lastAtk->id + 1 : 1;
    $validated['kode_barang'] = 'BK' . $nextId; // Format Kode Barang

    $atk = new Atk($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/atks'), $imageName);
        $atk->gambar_perangkat = $imageName;
    }

    $atk->save();

    return redirect()->route('atk.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update atk
    public function update(Request $request, $id)
    {
        $atk = Atk::find($id);

        if (!$atk) {
            return response()->json(['message' => 'Atk not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:atks,kode_barang,' . $id,
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
            if ($atk->gambar_perangkat && file_exists(public_path('images/atks/' . $atk->gambar_perangkat))) {
                unlink(public_path('images/atks/' . $atk->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/atks'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data atk
        $atk->update($validated);

        return redirect()->route('atk.index')->with('success', 'ATK Berhasil Diupdate');
    }

    // Method untuk menghapus data atk
    public function destroy($id)
    {
        $atk = Atk::findOrFail($id);
        $atk->delete();

        return redirect()->route('atk.index')->with('success', 'ATK Berhasil Dihapus');
    }
}
