<div id="formLegalOpini" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Berikan Legal Opinion</h5>
    <form method="POST" action="../proses/proses_add_legal_opini.php">
        
        <!-- Hidden Inputs -->
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp']); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat']); ?>">
    
        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Legal Opinion</strong>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="legalitas_pemohon" class="form-label">Legalitas Pemohon</label>
                    <textarea class="form-control" name="legalitas_pemohon" id="legalitas_pemohon" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="legalitas_agunan" class="form-label">Legalitas Agunan</label>
                    <textarea class="form-control" name="legalitas_agunan" id="legalitas_agunan" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="positif_point" class="form-label">Positif Point</label>
                    <textarea class="form-control" name="positif_point" id="positif_point" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="negatif_point" class="form-label">Negatif Point</label>
                    <textarea class="form-control" name="negatif_point" id="negatif_point" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="penyimpangan_sop" class="form-label">Penyimpangan SOP</label>
                    <textarea class="form-control" name="penyimpangan_sop" id="penyimpangan_sop" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="syarat_khusus" class="form-label">Syarat Khusus</label>
                    <textarea class="form-control" name="syarat_khusus" id="syarat_khusus" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="layak_kredit" class="form-label">Kelayakan Debitur</label>
                    <select class="form-control" name="layak_kredit">
                        <option>Layak</option>
                        <option>Tidak Layak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="layak_agunan" class="form-label">Kelayakan Agunan</label>
                    <select class="form-control" name="layak_agunan">
                        <option>Layak</option>
                        <option>Tidak Layak</option>
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
