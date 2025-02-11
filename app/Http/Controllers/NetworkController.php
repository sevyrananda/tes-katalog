<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Network;

class NetworkController extends Controller
{
    public function index()
    {
        $networks = Network::all();
        return view('pages.network.network', compact('networks'));
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
    $lastNetwork = Network::latest()->first();
    $nextId = $lastNetwork ? $lastNetwork->id + 1 : 1;
    $validated['kode_barang'] = 'BC' . $nextId; // Format Kode Barang

    $network = new Network($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/networks'), $imageName);
        $network->gambar_perangkat = $imageName;
    }

    $network->save();

    return redirect()->route('network.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update network
    public function update(Request $request, $id)
    {
        $network = Network::find($id);

        if (!$network) {
            return response()->json(['message' => 'Network not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:networks,kode_barang,' . $id,
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
            if ($network->gambar_perangkat && file_exists(public_path('images/networks/' . $network->gambar_perangkat))) {
                unlink(public_path('images/networks/' . $network->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/networks'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data network
        $network->update($validated);

        return redirect()->route('network.index')->with('success', 'Network Berhasil Diupdate');
    }

    // Method untuk menghapus data network
    public function destroy($id)
    {
        $network = Network::findOrFail($id);
        $network->delete();

        return redirect()->route('network.index')->with('success', 'Network Berhasil Dihapus');
    }
}
