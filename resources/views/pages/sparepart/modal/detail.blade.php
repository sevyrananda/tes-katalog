@foreach($spareparts as $sparepart)
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal{{ $sparepart->id }}" tabindex="-1"
        aria-labelledby="detailModalLabel{{ $sparepart->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $sparepart->id }}">Detail Sparepart & Scanner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode Barang</th>
                            <td>{{ $sparepart->kode_barang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $sparepart->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Detail Spesifikasi</th>
                            <td>{{ $sparepart->detail_spesifikasi }}</td>
                        </tr>
                        <tr>
                            <th>Klasifikasi</th>
                            <td>{{ $sparepart->klasifikasi }}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{ $sparepart->brand }}</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>{{ $sparepart->model }}</td>
                        </tr>
                        <tr>
                            <th>Harga Asli Offline</th>
                            <td>Rp {{ number_format($sparepart->harga_asli_offline, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga Asli Online</th>
                            <td>Rp {{ number_format($sparepart->harga_asli_online, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga RAB 20%</th>
                            <td>Rp {{ number_format($sparepart->harga_rab_20, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga RAB Wajar</th>
                            <td>Rp {{ number_format($sparepart->harga_rab_wajar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Update</th>
                            <td>{{ \Carbon\Carbon::parse($sparepart->tanggal_update)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Vendor</th>
                            <td>{{ $sparepart->nama_vendor }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Ketersediaan</th>
                            <td>{{ $sparepart->jumlah_ketersediaan }}</td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>{{ $sparepart->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $sparepart->keterangan }}</td>
                        </tr>
                        <tr>
                            <th>Gambar Perangkat</th>
                            <td>
                                @if($sparepart->gambar_perangkat)
                                    <img src="{{ asset('images/spareparts/' . $sparepart->gambar_perangkat) }}" alt="Gambar"
                                        style="width:100px; height:auto">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Link Referensi</th>
                            <td>
                                @if($sparepart->link_ref)
                                    <a href="{{ $sparepart->link_ref }}" target="_blank" class="text-blue-500 underline">Lihat</a>
                                @else
                                    <span class="text-gray-500">Tidak ada link</span>
                                @endif
                            </td>
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