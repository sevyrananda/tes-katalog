<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabletMonitor;

class TabletMonitorController extends Controller
{
    public function index()
    {
        $tabletmonitors = TabletMonitor::all();
        return view('pages.tabletmonitor.tabletmonitor', compact('tabletmonitors'));
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
    $lastTabletMonitor = TabletMonitor::latest()->first();
    $nextId = $lastTabletMonitor ? $lastTabletMonitor->id + 1 : 1;
    $validated['kode_barang'] = 'BE' . $nextId; // Format Kode Barang

    $tabletmonitor = new TabletMonitor($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/tabletmonitors'), $imageName);
        $tabletmonitor->gambar_perangkat = $imageName;
    }

    $tabletmonitor->save();

    return redirect()->route('tabletmonitor.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update tabletmonitor
    public function update(Request $request, $id)
    {
        $tabletmonitor = TabletMonitor::find($id);

        if (!$tabletmonitor) {
            return response()->json(['message' => 'TabletMonitor not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:tabletmonitors,kode_barang,' . $id,
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
            if ($tabletmonitor->gambar_perangkat && file_exists(public_path('images/tabletmonitors/' . $tabletmonitor->gambar_perangkat))) {
                unlink(public_path('images/tabletmonitors/' . $tabletmonitor->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/tabletmonitors'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data tabletmonitor
        $tabletmonitor->update($validated);

        return redirect()->route('tabletmonitor.index')->with('success', 'Tablet & Monitor Berhasil Diupdate');
    }

    // Method untuk menghapus data tabletmonitor
    public function destroy($id)
    {
        $tabletmonitor = TabletMonitor::findOrFail($id);
        $tabletmonitor->delete();

        return redirect()->route('tabletmonitor.index')->with('success', 'Tablet & Monitor Berhasil Dihapus');
    }
}
