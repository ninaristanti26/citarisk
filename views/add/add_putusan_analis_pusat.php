<div id="formPutusanAnalisPusat" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Usulan Anda Sebagai Kasie. Analis Pusat</h5>
    <form method="POST" action="../proses/proses_add_putusan_analis_pusat.php">
        
        <!-- Hidden Inputs -->
        <input type="hidden" name="id_pegawai" value="<?php echo htmlspecialchars($dataDeb['id_pegawai']); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp']); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat']); ?>">
        <input type="hidden" name="waktu_putus_analis_pusat" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="status_putusan_analis_pusat" value="Pending">

        <?php
            $waktu_approve_analis_pusat = empty($waktu_approve_analis_pusat) 
                ? '0000-00-00 00:00:00' 
                : (new DateTime())->format('Y-m-d H:i:s');
        ?>
        <input type="hidden" name="waktu_approve_kabag" value="0000-00-00 00:00:00">

        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Dasar Usulan Kasie. Analis Pusat</strong>
            </div>
            <div class="card-body">

                <!-- Form Group: Rekomendasi -->
                <div class="mb-3">
                    <label for="putusan_analis_pusat" class="form-label">Dasar Usulan Kasie. Analis Pusat</label>
                    <textarea class="form-control" name="putusan_analis_pusat" id="putusan_analis_pusat" rows="3" required placeholder="Masukkan rekomendasi..."></textarea>
                </div>

                <!-- Form Group: Plafon -->
                <div class="mb-3">
                    <label for="plafon_rekom_analis_pusat" class="form-label">Plafon Usulan Kasie. Analis Pusat</label>
                    <input type="text" class="form-control" name="plafon_rekom_analis_pusat" id="plafon_rekom_analis_pusat" required placeholder="Contoh: 50.000.000">
                </div>

                <div class="mb-3">
                    <label for="jw_rekom_analis_pusat" class="form-label">Jangka Waktu Usulan Kasie. Analis Pusat</label>
                    <input type="text" class="form-control" name="jw_rekom_analis_pusat" id="jw_rekom_analis_pusat" required placeholder="Contoh: 24">
                </div>

                <div class="mb-3">
                    <label for="metode_bayar_pusat" class="form-label">Metode Bayar</label>
                    <input type="text" class="form-control" name="metode_bayar_pusat" id="metode_bayar_pusat" required placeholder="Contoh: Pokok dan bunga dibayar setiap bulan">
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
function toggleFormPutusanAnalisPusat() {
    const form = document.getElementById('formPutusanAnalisPusat');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Format input angka (plafon) secara otomatis
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('plafon_rekom_analis_pusat');
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
