<!-- Modal Edit Sparepart -->
@foreach ($spareparts as $sparepart)
<div class="modal fade" id="editModal{{ $sparepart->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Sparepart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <form id="formEditSparepart" action="{{ route('spareparts.update', ['id' => $sparepart->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="sparepart_id" name="sparepart_id">

                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ $sparepart->kode_barang }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $sparepart->nama_barang }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="detail_spesifikasi" class="form-label">Detail Spesifikasi</label>
                        <textarea class="form-control" id="detail_spesifikasi" name="detail_spesifikasi" rows="3">{{ $sparepart->detail_spesifikasi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="klasifikasi" class="form-label">Klasifikasi</label>
                        <input type="text" class="form-control" id="klasifikasi" name="klasifikasi" value="{{ $sparepart->klasifikasi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ $sparepart->brand }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ $sparepart->model }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_asli_offline" class="form-label">Harga Asli Offline</label>
                        <input type="number" class="form-control" id="harga_asli_offline" name="harga_asli_offline" value="{{ $sparepart->harga_asli_offline }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_asli_online" class="form-label">Harga Asli Online</label>
                        <input type="number" class="form-control" id="harga_asli_online" name="harga_asli_online" value="{{ $sparepart->harga_asli_online }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_rab_20" class="form-label">Harga RAB 20%</label>
                        <input type="number" class="form-control" id="harga_rab_20" name="harga_rab_20" value="{{ $sparepart->harga_rab_20 }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_rab_wajar" class="form-label">Harga RAB Wajar</label>
                        <input type="number" class="form-control" id="harga_rab_wajar" name="harga_rab_wajar" value="{{ $sparepart->harga_rab_wajar }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_update" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="tanggal_update" name="tanggal_update" value="{{ $sparepart->tanggal_update }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_vendor" class="form-label">Nama Vendor</label>
                        <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" value="{{ $sparepart->nama_vendor }}">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_ketersediaan" class="form-label">Jumlah Ketersediaan</label>
                        <input type="number" class="form-control" id="jumlah_ketersediaan" name="jumlah_ketersediaan" value="{{ $sparepart->jumlah_ketersediaan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $sparepart->satuan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $sparepart->keterangan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_perangkat" class="form-label">Gambar Perangkat</label>
                        <div class="mb-2">
                            @if ($sparepart->gambar_perangkat)
                            <img src="{{ asset('images/spareparts/' . $sparepart->gambar_perangkat) }}" alt="Gambar Sparepart" style="width: 150px; height: auto;">
                            @endif
                        </div>
                        <input type="file" class="form-control" id="gambar_perangkat" name="gambar_perangkat" accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="mb-3">
                        <label for="link_ref" class="form-label">Link Referensi</label>
                        <input type="url" class="form-control" id="link_ref" name="link_ref" value="{{ $sparepart->link_ref }}" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach