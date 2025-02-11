<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printer;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::all();
        return view('pages.printer.printer', compact('printers'));
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
    $lastPrinter = Printer::latest()->first();
    $nextId = $lastPrinter ? $lastPrinter->id + 1 : 1;
    $validated['kode_barang'] = 'BH' . $nextId; // Format Kode Barang

    $printer = new Printer($validated);

    if ($request->hasFile('gambar_perangkat')) {
        $imageName = time() . '.' . $request->gambar_perangkat->extension();
        $request->gambar_perangkat->move(public_path('images/printers'), $imageName);
        $printer->gambar_perangkat = $imageName;
    }

    $printer->save();

    return redirect()->route('printer.index')->with('success', 'Data berhasil ditambahkan!');
}



    // Method update: memproses data update printer
    public function update(Request $request, $id)
    {
        $printer = Printer::find($id);

        if (!$printer) {
            return response()->json(['message' => 'Printer not found'], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'kode_barang' => 'required|unique:printers,kode_barang,' . $id,
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
            if ($printer->gambar_perangkat && file_exists(public_path('images/printers/' . $printer->gambar_perangkat))) {
                unlink(public_path('images/printers/' . $printer->gambar_perangkat));
            }
            $imageName = time() . '.' . $request->gambar_perangkat->extension();
            $request->gambar_perangkat->move(public_path('images/printers'), $imageName);
            $validated['gambar_perangkat'] = $imageName;
        }

        // Update data printer
        $printer->update($validated);

        return redirect()->route('printer.index')->with('success', 'Printer Berhasil Diupdate');
    }

    // Method untuk menghapus data printer
    public function destroy($id)
    {
        $printer = Printer::findOrFail($id);
        $printer->delete();

        return redirect()->route('printer.index')->with('success', 'Printer Berhasil Dihapus');
    }
}
