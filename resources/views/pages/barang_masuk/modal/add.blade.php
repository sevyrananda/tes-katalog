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
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="sparepart">Sparepart</option>
                            <option value="toolkit">Toolkit</option>
                            <option value="network">Network</option>
                            <option value="cctv">CCTV</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <select class="form-control" id="kode_barang" name="kode_barang" required>
                            <option value="">-- Pilih Kode Barang --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_masuk" class="form-label">Jumlah Barang Masuk</label>
                        <input type="number" class="form-control" id="jumlah_masuk" name="jumlah_masuk" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
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
    // Ketika kategori berubah, ambil kode barang sesuai kategori
    document.getElementById("kategori").addEventListener("change", function () {
        let kategori = this.value;
        let kodeBarangDropdown = document.getElementById("kode_barang");
        
        // Kosongkan dropdown kode barang
        kodeBarangDropdown.innerHTML = '<option value="">-- Pilih Kode Barang --</option>';

        if (kategori) {
            fetch(`/api/kode-barang/${kategori}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        let option = document.createElement("option");
                        option.value = item.kode_barang;
                        option.text = item.kode_barang;
                        kodeBarangDropdown.appendChild(option);
                    });
                });
        }
    });

    // Ketika kode barang dipilih, tampilkan nama barang secara otomatis
    document.getElementById("kode_barang").addEventListener("change", function () {
        let kodeBarang = this.value;
        let namaBarangField = document.getElementById("nama_barang");

        if (kodeBarang) {
            fetch(`/api/nama-barang/${kodeBarang}`)
                .then(response => response.json())
                .then(data => {
                    namaBarangField.value = data.nama_barang;
                });
        } else {
            namaBarangField.value = "";
        }
    });
});
</script>
