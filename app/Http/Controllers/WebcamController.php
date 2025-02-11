<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webcam;

class WebcamController extends Controller
{
    public function index()
    {
        $webcams = Webcam::all();
        return view('pages.webcam.webcam', compact('webcams'));
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
    $lastWebcam = Webcam::latest()->first();
    $nextId = $lastWebcam ? $lastWebcam->id + 1 : 1;
    $validated['kode_barang'] = 'BF' . $nextId; // Format Kode Barang

    $webcam = new Webcam($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/webcams'), $imageName);
        $webcam->gambar_perangkat = $imageName;
    }

    $webcam->save();

    return redirect()->route('webcam.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update webcam
    public function update(Request $request, $id)
    {
        $webcam = Webcam::find($id);

        if (!$webcam) {
            return response()->json(['message' => 'Webcam not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:webcams,kode_barang,' . $id,
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
            if ($webcam->gambar_perangkat && file_exists(public_path('images/webcams/' . $webcam->gambar_perangkat))) {
                unlink(public_path('images/webcams/' . $webcam->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/webcams'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data webcam
        $webcam->update($validated);

        return redirect()->route('webcam.index')->with('success', 'Webcam Berhasil Diupdate');
    }

    // Method untuk menghapus data webcam
    public function destroy($id)
    {
        $webcam = Webcam::findOrFail($id);
        $webcam->delete();

        return redirect()->route('webcam.index')->with('success', 'Webcam Berhasil Dihapus');
    }
}
