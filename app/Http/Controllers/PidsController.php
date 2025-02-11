<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pids;

class PidsController extends Controller
{
    public function index()
    {
        $pidss = Pids::all();
        return view('pages.pids.pids', compact('pidss'));
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
    $lastPids = Pids::latest()->first();
    $nextId = $lastPids ? $lastPids->id + 1 : 1;
    $validated['kode_barang'] = 'BI' . $nextId; // Format Kode Barang

    $pids = new Pids($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/pidss'), $imageName);
        $pids->gambar_perangkat = $imageName;
    }

    $pids->save();

    return redirect()->route('pids.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update pids
    public function update(Request $request, $id)
    {
        $pids = Pids::find($id);

        if (!$pids) {
            return response()->json(['message' => 'Pids not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:pidss,kode_barang,' . $id,
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
            if ($pids->gambar_perangkat && file_exists(public_path('images/pidss/' . $pids->gambar_perangkat))) {
                unlink(public_path('images/pidss/' . $pids->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/pidss'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data pids
        $pids->update($validated);

        return redirect()->route('pids.index')->with('success', 'PIDS Berhasil Diupdate');
    }

    // Method untuk menghapus data pids
    public function destroy($id)
    {
        $pids = Pids::findOrFail($id);
        $pids->delete();

        return redirect()->route('pids.index')->with('success', 'PIDS Berhasil Dihapus');
    }
}
