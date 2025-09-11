<div id="formSyaratTambah" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Syarat Tambahan Jika Diperlukan</h5>
    <?php
        $id_riwayat = isset($_GET['id_riwayat']) ? htmlspecialchars($_GET['id_riwayat']) : '';
        $no_ktp     = isset($_GET['no_ktp']) ? htmlspecialchars($_GET['no_ktp']) : '';
    ?>
<form method="POST" action="../proses/proses_add_syarat_tambah.php">
    <input type="hidden" name="id_putusan_analis" value="<?php echo htmlspecialchars($data_putusan_analis['id_putusan_analis']); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo $id_riwayat; ?>">
    <input type="hidden" name="no_ktp" value="<?php echo $no_ktp; ?>">
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <strong>📝 Tambah Syarat Tambahan Jika Dibutuhkan</strong>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="syarat_tambah" class="form-label">Syarat Tambahan</label>
                <textarea class="form-control" name="syarat_tambah" id="syarat_tambah" rows="3" required placeholder="Masukkan syarat..."></textarea>
            </div>
            <div class="text-center mt-4">
                <button type="submit" name="Submit" value="Submit" class="btn btn-success px-4 me-2">💾 Simpan</button>
                <button type="reset" class="btn btn-secondary px-4">🔄 Reset</button>
            </div>
        </div>
    </div>
</form>
</div>

<script>
function toggleFormSyaratTambah() {
    const form = document.getElementById('formSyaratTambah');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>