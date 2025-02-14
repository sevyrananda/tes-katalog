<!-- Modal Edit Barang Masuk -->
<div class="modal fade" id="modalEditBarangMasuk" tabindex="-1" aria-labelledby="modalEditBarangMasukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditBarangMasukLabel">Edit Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <form id="formEditBarangMasuk" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_kategori" class="form-label">Kategori Barang</label>
                        <select id="edit_kategori" name="kategori_id" class="form-control" readonly>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriBarang as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_kode_barang" class="form-label">Kode Barang</label>
                        <select id="edit_kode_barang" name="kode_barang" class="form-control" readonly>
                            <option value="">-- Pilih Kode Barang --</option>
                            @foreach ($kodeBarangList as $kodeBarang)
                                <option value="{{ $kodeBarang->kode_barang }}">{{ $kodeBarang->kode_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="edit_jumlah_masuk" class="form-label">Jumlah Barang Masuk</label>
                        <input type="number" class="form-control" id="edit_jumlah_masuk" name="jumlah_masuk" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_lokasi_penyimpanan" class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" class="form-control" id="edit_lokasi_penyimpanan" name="lokasi_penyimpanan" required>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

    document.querySelectorAll(".btn-edit").forEach(button => {
        button.addEventListener("click", function () {
            const barangMasuk = JSON.parse(this.getAttribute("data-barang"));
            
            document.getElementById("edit_id").value = barangMasuk.id;
            document.getElementById("edit_tanggal").value = barangMasuk.tanggal;
            document.getElementById("edit_kategori").value = barangMasuk.kategori_id;
            document.getElementById("edit_kode_barang").value = barangMasuk.kode_barang;
            document.getElementById("edit_nama_barang").value = barangMasuk.nama_barang;
            document.getElementById("edit_jumlah_masuk").value = barangMasuk.jumlah_masuk;
            document.getElementById("edit_lokasi_penyimpanan").value = barangMasuk.lokasi_penyimpanan;

            const formEdit = document.getElementById("formEditBarangMasuk");
            formEdit.action = `/transaksi/barang-masuk/${barangMasuk.id}`;

            new bootstrap.Modal(document.getElementById("modalEditBarangMasuk")).show();
        });
    });

    document.getElementById("edit_kategori").addEventListener("change", function () {
        const selectedKategori = this.value;
        const kodeBarangDropdown = document.getElementById("edit_kode_barang");
        
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

    document.getElementById("edit_kode_barang").addEventListener("change", function () {
        const selectedKodeBarang = this.value;
        const namaBarangField = document.getElementById("edit_nama_barang");
        const selectedBarang = combinedKodeBarangList.find(item => item.kode_barang === selectedKodeBarang);
        namaBarangField.value = selectedBarang ? selectedBarang.nama_barang : "";
    });
});
</script>
