<!-- Modal Tambah Barang Masuk -->
<div class="modal fade" id="modalTambahBarangMasuk" tabindex="-1" aria-labelledby="modalTambahBarangMasukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahBarangMasukLabel">Tambah Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <form id="formTambahBarangMasuk" action="{{ route('barang_masuk.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Barang</label>
                        <select id="kategori" name="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriBarang as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <select id="kode_barang" name="kode_barang" class="form-control" required>
                            <option value="">-- Pilih Kode Barang --</option>
                            @foreach ($kodeBarangList as $kodeBarang)
                                <option value="{{ $kodeBarang->kode_barang }}">{{ $kodeBarang->kode_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_masuk" class="form-label">Jumlah Barang Masuk</label>
                        <input type="number" class="form-control" id="jumlah_masuk" name="jumlah_masuk" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" class="form-control" id="lokasi_penyimpanan" name="lokasi_penyimpanan" required>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const kodeBarangList = @json($kodeBarangList);
    const kodeToolkitList = @json($kodeToolkit);
    const combinedKodeBarangList = [...kodeBarangList, ...kodeToolkitList];

    document.getElementById("kategori").addEventListener("change", function () {
        const selectedKategori = this.value;
        const kodeBarangDropdown = document.getElementById("kode_barang");
        
        kodeBarangDropdown.innerHTML = '<option value="">-- Pilih Kode Barang --</option>';

        if (selectedKategori) {
            const filteredKodeBarang = combinedKodeBarangList.filter(item => item.kategori_id == selectedKategori);
            filteredKodeBarang.forEach(item => {
                const option = document.createElement("option");
                option.value = item.kode_barang;
                option.text = item.kode_barang;
                kodeBarangDropdown.appendChild(option);
            });
        }
    });

    document.getElementById("kode_barang").addEventListener("change", function () {
        const selectedKodeBarang = this.value;
        const namaBarangField = document.getElementById("nama_barang");
        const selectedBarang = combinedKodeBarangList.find(item => item.kode_barang === selectedKodeBarang);
        namaBarangField.value = selectedBarang ? selectedBarang.nama_barang : "";
    });
});
</script>