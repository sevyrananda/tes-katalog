<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToolKit;

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
        $validated['kode_barang'] = 'BB' . $nextId; // Format Kode Barang

        $toolkit = new ToolKit($validated);

        $toolkit->kategori_id = $request->kategori_id ?? 2;

        if ($request->hasFile('gambar_perangkat')) {
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/toolkits'), $imageName);
            $toolkit->gambar_perangkat = $imageName;
        }

        $toolkit->save();

        // Mengambil seluruh toolkit setelah berhasil disimpan
        $toolkits = ToolKit::all();

        return redirect()->route('toolkit.index')->with('success', 'Data berhasil ditambahkan!', compact('toolkits'));
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

        // Jika ada gambar baru, hapus gambar lama dan upload gambar baru
        if ($request->hasFile('gambar_perangkat')) {
            if ($toolkit->gambar_perangkat && file_exists(public_path('images/toolkits/' . $toolkit->gambar_perangkat))) {
                unlink(public_path('images/toolkits/' . $toolkit->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/toolkits'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data toolkit
        $toolkit->update($validated);

        return redirect()->route('toolkit.index')->with('success', 'Toolkit Berhasil Diupdate');
    }

    // Method untuk menghapus data toolkit
    public function destroy($id)
    {
        $toolkit = ToolKit::findOrFail($id);
        $toolkit->delete();

        return redirect()->route('toolkit.index')->with('success', 'Toolkit Berhasil Dihapus');
    }
}