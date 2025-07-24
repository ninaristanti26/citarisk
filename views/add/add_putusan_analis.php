<div id="formPutusanAnalis" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Rekomendasi Anda Sebagai Analis Kredit</h5>
    <form method="POST" action="../proses/proses_add_putusan_analis.php">
        
        <!-- Hidden Inputs -->
        <input type="hidden" name="id_pegawai" value="<?php echo htmlspecialchars($dataDeb['id_pegawai']); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp']); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat']); ?>">
        <input type="hidden" name="waktu_putus_analis" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="status_putusan_analis" value="Pending">

        <?php
            $waktu_approve_kaspem = empty($waktu_approve_kaspem) 
                ? '0000-00-00 00:00:00' 
                : (new DateTime())->format('Y-m-d H:i:s');
        ?>
        <input type="hidden" name="waktu_approve_kaspem" value="0000-00-00 00:00:00">

        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Putusan Analis Kredit</strong>
            </div>
            <div class="card-body">

                <!-- Form Group: Rekomendasi -->
                <div class="mb-3">
                    <label for="putusan_analis" class="form-label">Rekomendasi Analis Kredit</label>
                    <textarea class="form-control" name="putusan_analis" id="putusan_analis" rows="3" required placeholder="Masukkan rekomendasi..."></textarea>
                </div>

                <!-- Form Group: Plafon -->
                <div class="mb-3">
                    <label for="plafon_rekom_analis" class="form-label">Plafon Sesuai Rekomendasi</label>
                    <input type="text" class="form-control" name="plafon_rekom_analis" id="plafon_rekom_analis" required placeholder="Contoh: 50.000.000">
                </div>

                <div class="mb-3">
                    <label for="jw_rekom_analis" class="form-label">Jangka Waktu pertahun Sesuai Rekomendasi (Diisi angka saja)</label>
                    <input type="text" class="form-control" name="jw_rekom_analis" id="jw_rekom_analis" required placeholder="Contoh: 24">
                </div>

                <div class="mb-3">
                    <label for="metode_bayar" class="form-label">Metode Bayar</label>
                    <input type="text" class="form-control" name="metode_bayar" id="metode_bayar" required placeholder="Contoh: Pokok dan bunga dibayar setiap bulan">
                </div>

                <div class="mb-3">
                    <label for="goldeb" class="form-label">Golongan Debitur</label>
                    <select class="form-control" name="goldeb">
                        <option>Pihak tidak terkait dengan BPR pelapor</option>
                        <option>Pihak terkait</option>
                    </select>
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


