@foreach($barangMasuk as $item)
    <!-- Modal Detail Barang Masuk -->
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1"
        aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Tanggal Masuk</th>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Kode Barang</th>
                            <td>{{ $item->kode_barang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $item->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Masuk</th>
                            <td>{{ $item->jumlah_masuk }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi Penyimpanan</th>
                            <td>{{ $item->lokasi_penyimpanan }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
