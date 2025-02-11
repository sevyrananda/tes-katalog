@foreach($tabletmonitors as $tabletmonitor)
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal{{ $tabletmonitor->id }}" tabindex="-1"
        aria-labelledby="detailModalLabel{{ $tabletmonitor->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $tabletmonitor->id }}">Detail Tablet & Monitor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode Barang</th>
                            <td>{{ $tabletmonitor->kode_barang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $tabletmonitor->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Detail Spesifikasi</th>
                            <td>{{ $tabletmonitor->detail_spesifikasi }}</td>
                        </tr>
                        <tr>
                            <th>Klasifikasi</th>
                            <td>{{ $tabletmonitor->klasifikasi }}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{ $tabletmonitor->brand }}</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>{{ $tabletmonitor->model }}</td>
                        </tr>
                        <tr>
                            <th>Harga Asli Offline</th>
                            <td>Rp {{ number_format($tabletmonitor->harga_asli_offline, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga Asli Online</th>
                            <td>Rp {{ number_format($tabletmonitor->harga_asli_online, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga RAB 20%</th>
                            <td>Rp {{ number_format($tabletmonitor->harga_rab_20, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga RAB Wajar</th>
                            <td>Rp {{ number_format($tabletmonitor->harga_rab_wajar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Update</th>
                            <td>{{ \Carbon\Carbon::parse($tabletmonitor->tanggal_update)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Vendor</th>
                            <td>{{ $tabletmonitor->nama_vendor }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Ketersediaan</th>
                            <td>{{ $tabletmonitor->jumlah_ketersediaan }}</td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>{{ $tabletmonitor->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $tabletmonitor->keterangan }}</td>
                        </tr>
                        <tr>
                            <th>Gambar Perangkat</th>
                            <td>
                                @if($tabletmonitor->gambar_perangkat)
                                    <img src="{{ asset('images/tabletmonitors/' . $tabletmonitor->gambar_perangkat) }}" alt="Gambar"
                                        style="width:100px; height:auto">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Link Referensi</th>
                            <td>
                                @if($tabletmonitor->link_ref)
                                    <a href="{{ $tabletmonitor->link_ref }}" target="_blank" class="text-blue-500 underline">Lihat</a>
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