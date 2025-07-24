<?php
include("../getCode/getCab.php");
?>
<div id="formPutusanDirut" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Putusan Anda Sebagai Direktur Utama</h5>
    <form method="POST" action="../proses/proses_add_putusan_dirut.php">
        
        <!-- Hidden Inputs -->
        <input type="hidden" name="id_pegawai" value="<?php echo htmlspecialchars($dataDeb['id_pegawai']); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp']); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat']); ?>">
        <input type="hidden" name="waktu_putus_dirut" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        
        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Putusan Direktur Utama</strong>
            </div>
            <div class="card-body">

                <!-- Form Group: Rekomendasi -->
                <div class="mb-3">
                    <label for="putusan_dirut" class="form-label">Putusan Kredit</label>
                    <textarea class="form-control" name="putusan_dirut" id="putusan_dirut" rows="3" required placeholder="Masukkan rekomendasi..."></textarea>
                </div>

                <!-- Form Group: Plafon -->
                <div class="mb-3">
                    <label for="plafon_rekom_dirut" class="form-label">Plafon Putusan</label>
                    <input type="text" class="form-control" name="plafon_rekom_dirut" id="plafon_rekom_dirut" required placeholder="Contoh: 50.000.000">
                </div>

                <!-- Form Group: Rekomendasi -->
                <div class="mb-3">
                    <label for="jw_rekom_dirut" class="form-label">Jangka Waktu</label>
                    <input type="text" class="form-control" name="jw_rekom_dirut" id="jw_rekom_dirut" required placeholder="Contoh: 24">
                </div>

                <!--<input type="hidden" class="form-control" name="status_putusan_pinca" id="status_putusan_pinca" required>-->
               

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
function toggleFormPutusanDirut() {
    const form = document.getElementById('formPutusanDirut');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Format input angka (plafon) secara otomatis
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('plafon_rekom_dirut');
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
