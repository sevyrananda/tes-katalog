<!-- Modal Edit Locotrack -->
@foreach ($locotracks as $locotrack)
<div class="modal fade" id="editModal{{ $locotrack->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Locotrack</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <form id="formEditLocotrack" action="{{ route('locotracks.update', ['id' => $locotrack->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="locotrack_id" name="locotrack_id">

                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ $locotrack->kode_barang }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $locotrack->nama_barang }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="detail_spesifikasi" class="form-label">Detail Spesifikasi</label>
                        <textarea class="form-control" id="detail_spesifikasi" name="detail_spesifikasi" rows="3">{{ $locotrack->detail_spesifikasi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="klasifikasi" class="form-label">Klasifikasi</label>
                        <input type="text" class="form-control" id="klasifikasi" name="klasifikasi" value="{{ $locotrack->klasifikasi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ $locotrack->brand }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ $locotrack->model }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_asli_offline" class="form-label">Harga Asli Offline</label>
                        <input type="number" class="form-control" id="harga_asli_offline" name="harga_asli_offline" value="{{ $locotrack->harga_asli_offline }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_asli_online" class="form-label">Harga Asli Online</label>
                        <input type="number" class="form-control" id="harga_asli_online" name="harga_asli_online" value="{{ $locotrack->harga_asli_online }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_rab_20" class="form-label">Harga RAB 20%</label>
                        <input type="number" class="form-control" id="harga_rab_20" name="harga_rab_20" value="{{ $locotrack->harga_rab_20 }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_rab_wajar" class="form-label">Harga RAB Wajar</label>
                        <input type="number" class="form-control" id="harga_rab_wajar" name="harga_rab_wajar" value="{{ $locotrack->harga_rab_wajar }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_update" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="tanggal_update" name="tanggal_update" value="{{ $locotrack->tanggal_update }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_vendor" class="form-label">Nama Vendor</label>
                        <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" value="{{ $locotrack->nama_vendor }}">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_ketersediaan" class="form-label">Jumlah Ketersediaan</label>
                        <input type="number" class="form-control" id="jumlah_ketersediaan" name="jumlah_ketersediaan" value="{{ $locotrack->jumlah_ketersediaan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $locotrack->satuan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $locotrack->keterangan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_perangkat" class="form-label">Gambar Perangkat</label>
                        <div class="mb-2">
                            @if ($locotrack->gambar_perangkat)
                            <img src="{{ asset('images/locotracks/' . $locotrack->gambar_perangkat) }}" alt="Gambar Locotrack" style="width: 150px; height: auto;">
                            @endif
                        </div>
                        <input type="file" class="form-control" id="gambar_perangkat" name="gambar_perangkat" accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="mb-3">
                        <label for="link_ref" class="form-label">Link Referensi</label>
                        <input type="url" class="form-control" id="link_ref" name="link_ref" value="{{ $locotrack->link_ref }}" required>
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