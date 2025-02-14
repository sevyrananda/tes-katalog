@extends('layouts.app')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Transaksi Barang /</span> Barang Masuk</h4>
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
                <h5 class="card-header mb-0">Data Barang Masuk</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBarangMasuk">
                    <i class="bx bx-plus"></i> Tambah
                </button>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Masuk</th>
                            <th>Lokasi Penyimpanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangMasuk as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->jumlah_masuk }}</td>
                                <td>{{ $item->lokasi_penyimpanan }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id }}">
                                        <i class="bx bx-show me-2"></i> Detail
                                    </button>
                                    <button type="button" class="btn btn-warning btn-edit" data-barang='@json($item)'>
                                        <i class="bx bx-edit-alt me-2"></i> Edit
                                    </button>

                                    <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $item->id }}')">
                                        <i class="bx bx-trash me-2"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        @if ($barangMasuk->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No data available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
        var form = document.getElementById('deleteForm');
        form.action = "{{ route('barang_masuk.destroy', '') }}/" + id;

        var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        myModal.show();
    }
    </script>

    @include('pages.barang_masuk.modal.add')
    @include('pages.barang_masuk.modal.edit')
    @include('pages.barang_masuk.modal.del')
    @include('pages.barang_masuk.modal.detail')

@endsection