<div id="formKetAgunan" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Input Agunan</h5>
    <form method="POST" action="../proses/proses_upload_sk.php" enctype="multipart/form-data">
        <!-- Hidden Inputs -->
        <input type="hidden" name="no_ktp" value="<?= htmlspecialchars($_GET['no_ktp'] ?? '') ?>">
        <input type="hidden" name="id_riwayat" value="<?= htmlspecialchars($_GET['id_riwayat'] ?? '') ?>">

        <!-- Card Container -->
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <strong>📝 Tambah Dokumen Agunan</strong>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label for="jenis_agunan" class="form-label">Jenis Agunan</label>
                    <input type="text" class="form-control" name="jenis_agunan" id="jenis_agunan" required>
                </div>

                <div class="mb-3">
                    <label for="no_agunan" class="form-label">Nomor Agunan</label>
                    <input type="text" class="form-control" name="no_agunan" id="no_agunan" required>
                </div>

                <div class="mb-3">
                    <label for="tgl_agunan" class="form-label">Tanggal Agunan</label>
                    <input type="date" class="form-control" name="tgl_agunan" id="tgl_agunan" required>
                </div>

                <div class="mb-3">
                    <label for="pdf_agunan" class="form-label">Dokumen Agunan (PDF)</label>
                    <input type="file" class="form-control" name="pdf_agunan" id="pdf_agunan" accept="application/pdf" required>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" name="submit" value="Submit" class="btn btn-success px-4 me-2">💾 Simpan</button>
                    <button type="reset" class="btn btn-secondary px-4">🔄 Reset</button>
                </div>

            </div>
        </div>
    </form>
</div>
