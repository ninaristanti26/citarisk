<div id="formOpiniKasop" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Opini Anda sebagai Kasie. Umum dan Kepatuhan</h5>
    <form method="POST" action="../proses/proses_add_opini_kasop.php">
        
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp']); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat']); ?>">
       
        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Opini Kasie. Umum dan Kepatuhan</strong>
            </div>
            <div class="card-body">

                <!-- Form Group: Rekomendasi -->
                <div class="mb-3">
                    <label for="opini_kasop" class="form-label">Opini Kasie. Umum dan Kepatuhan</label>
                    <textarea class="form-control" name="opini_kasop" id="opini_kasop" rows="3" required placeholder="Masukkan rekomendasi..."></textarea>
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


