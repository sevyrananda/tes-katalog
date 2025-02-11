@extends('layouts.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Katalog Barang /</span> PIDS</h4>
    <hr class="my-2" />

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-2" role="alert"
            style="background-color: #28a745; color: white; border: 1px solid #28a745; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 5px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Responsive Table -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center px-3 pb-2">
            <h5 class="card-header mb-0">Data PIDS</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPids">
                <i class="bx bx-plus"></i> Tambah
            </button>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Detail Spesifikasi</th>
                        <th>Klasifikasi</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Harga Asli Offline</th>
                        <th>Harga Asli Online</th>
                        <th>Harga RAB 20%</th>
                        <th>Harga RAB Wajar</th>
                        <th>Tanggal Update</th>
                        <th>Nama Vendor</th>
                        <th>Jumlah Ketersediaan</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        <th>Gambar Perangkat</th>
                        <th>Link Referensi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pidss as $index => $pids)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pids->kode_barang }}</td>
                            <td>{{ $pids->nama_barang }}</td>
                            <td>{{ $pids->detail_spesifikasi }}</td>
                            <td>{{ $pids->klasifikasi }}</td>
                            <td>{{ $pids->brand }}</td>
                            <td>{{ $pids->model }}</td>
                            <td>Rp {{ number_format($pids->harga_asli_offline, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pids->harga_asli_online, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pids->harga_rab_20, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pids->harga_rab_wajar, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pids->tanggal_update)->format('d-m-Y') }}</td>
                            <td>{{ $pids->nama_vendor }}</td>
                            <td>{{ $pids->jumlah_ketersediaan }}</td>
                            <td>{{ $pids->satuan }}</td>
                            <td>{{ $pids->keterangan }}</td>
                            <td>
                                @if($pids->gambar_perangkat)
                                    <img src="{{ asset('images/pidss/' . $pids->gambar_perangkat) }}" alt="Gambar"
                                        class="w-16 h-16" style="width:100px; height:auto">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                @if($pids->link_ref)
                                    <a href="{{ $pids->link_ref }}" target="_blank" class="text-blue-500 underline">Lihat</a>
                                @else
                                    <span class="text-gray-500">Tidak ada link</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $pids->id }}">
                                    <i class="bx bx-show me-2"></i> Detail
                                </button>
                                <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $pids->id }}">
                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $pids->id }}')">
                                    <i class="bx bx-trash me-2"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Table -->
</div>

<script>
    function confirmDelete(id) {
        // Menyimpan URL yang benar untuk form delete
        var form = document.getElementById('deleteForm');
        form.action = '/katalog/pidss/' + id;

        // Menampilkan modal konfirmasi delete
        var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        myModal.show();
    }
</script>

@include('pages.pids.modal.add')
@include('pages.pids.modal.edit')
@include('pages.pids.modal.del')
@include('pages.pids.modal.detail')

@endsection