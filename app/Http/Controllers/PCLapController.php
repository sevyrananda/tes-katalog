<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PCLap;

class PCLapController extends Controller
{
    public function index()
    {
        $pclaptops = PCLap::all();
        return view('pages.pclaptop.pclaptop', compact('pclaptops'));
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
    $lastPClaptop = PCLap::latest()->first();
    $nextId = $lastPClaptop ? $lastPClaptop->id + 1 : 1;
    $validated['kode_barang'] = 'BG' . $nextId; // Format Kode Barang

    $pclaptop = new PCLap($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/pclaptops'), $imageName);
        $pclaptop->gambar_perangkat = $imageName;
    }

    $pclaptop->save();

    return redirect()->route('pclaptop.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update pclaptop
    public function update(Request $request, $id)
    {
        $pclaptop = PCLap::find($id);

        if (!$pclaptop) {
            return response()->json(['message' => 'Pclaptop not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:pclaptops,kode_barang,' . $id,
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
            if ($pclaptop->gambar_perangkat && file_exists(public_path('images/pclaptops/' . $pclaptop->gambar_perangkat))) {
                unlink(public_path('images/pclaptops/' . $pclaptop->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/pclaptops'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data pclaptop
        $pclaptop->update($validated);

        return redirect()->route('pclaptop.index')->with('success', 'PC & Laptop Berhasil Diupdate');
    }

    // Method untuk menghapus data pclaptop
    public function destroy($id)
    {
        $pclaptop = PCLap::findOrFail($id);
        $pclaptop->delete();

        return redirect()->route('pclaptop.index')->with('success', 'PC & Laptop Berhasil Dihapus');
    }
}
