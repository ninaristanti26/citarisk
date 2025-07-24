<div id="formPutusanKabag" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Rekomendasi Anda Sebagai Kabag. Pemasaran</h5>
    <form method="POST" action="../proses/proses_add_putusan_kabag.php">
        
        <!-- Hidden Inputs -->
        <input type="hidden" name="id_pegawai" value="<?php echo htmlspecialchars($dataDeb['id_pegawai']); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp']); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat']); ?>">
        <input type="hidden" name="waktu_putus_kabag" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="status_putusan_kabag" value="Pending">

        <?php
            $waktu_approve_kadiv = empty($waktu_approve_kadiv) 
                ? '0000-00-00 00:00:00' 
                : (new DateTime())->format('Y-m-d H:i:s');
        ?>
        <input type="hidden" name="waktu_approve_kadiv" value="0000-00-00 00:00:00">

        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Putusan Kabag. Pemasaran</strong>
            </div>
            <div class="card-body">

                <!-- Form Group: Rekomendasi -->
                <div class="mb-3">
                    <label for="putusan_kabag" class="form-label">Kesimpulan Kabag. Pemasaran</label>
                    <input type="text" class="form-control" name="putusan_kabag" id="putusan_kabag" required>
                </div>

                <!-- Form Group: Plafon -->
                <div class="mb-3">
                    <label for="plafon_rekom_kabag" class="form-label">Plafon Usulan Kabag. Pemasaran</label>
                    <input type="text" class="form-control" name="plafon_rekom_kabag" id="plafon_rekom_kabag" required placeholder="Contoh: 50.000.000">
                </div>

                <div class="mb-3">
                    <label for="jw_rekom_kabag" class="form-label">Jangka Waktu (hanya diisi angka dalam satuan bulan)</label>
                    <input type="text" class="form-control" name="jw_rekom_kabag" id="jw_rekom_kabag" required placeholder="Contoh: 24">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea type="text" class="form-control" name="catatan" id="catatan" required></textarea>
                </div>

                <!-- Form Buttons -->
                <div class="text-center mt-4">
                    <button type="submit" name="Submit" value="Submit" class="btn btn-success px-4 me-2">💾 Simpan</button>
                    <button type="reset" class="btn btn-secondary px-4">🔄 Reset</button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function toggleFormPutusanKabag() {
    const form = document.getElementById('formPutusanKabag');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Format input angka (plafon) secara otomatis
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('plafon_rekom_kabag');
    input.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '');
        if (value !== '') {
            this.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            this.value = '';
        }
    });
});
</script>
