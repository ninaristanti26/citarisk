<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>
<div id="formEditPekerjaan" class="p-3 border rounded mt-3" style="display: none; background-color: #fffbe7;">
<form action="../../proses/proses_edit_pekerjaan.php" method="post" onsubmit="return validEdit()">
    <div class="modal-header">
        <h5 class="text-warning">✏️ Edit Data Status Kawin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataPekerjaan['no_ktp']); ?>">
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp_edit" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['no_ktp']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Instansi</label>
            <input type="text" name="nama_instansi" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['nama_instansi']); ?>">
        </div>
        <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['jabatan']); ?>">
        </div>
        <div class="form-group">
            <label>Unit Kerja</label>
            <input type="text" name="unit_kerja" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['unit_kerja']); ?>">
        </div>
        <div class="form-group">
            <label>Status Kepegawaian</label>
            <select name="status_kerja" class="form-control" required>
                <option value="Pegawai Tetap" <?php if($dataPekerjaan['status_kerja'] == 'Pegawai Tetap') echo 'selected'; ?>>Pegawai Tetap</option>
                <option value="Tenaga Kontrak" <?php if($dataPekerjaan['status_kerja'] == 'Tenaga Kontrak') echo 'selected'; ?>>Tenaga Kontrak</option>
                <option value="Lainnya" <?php if($dataPekerjaan['status_kerja'] == 'Lainnya') echo 'selected'; ?>>Lainnya</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Pengangkatan</label>
            <input type="date" name="tgl_pengangkatan" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['tgl_pengangkatan']); ?>">
        </div>
        <div class="form-group">
            <label>Usia Batas Akhir Kerja</label>
            <input type="number" name="usia_akhir_kerja" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['usia_akhir_kerja']); ?>">
        </div>
        <div class="form-group">
            <label>Alamat Instansi</label>
            <textarea name="alamat_instansi" class="form-control"><?php echo htmlspecialchars($dataPekerjaan['alamat_instansi']); ?></textarea>
        <div class="form-group">
            <label>Sektor Instansi</label>
            <input type="text" name="sektor_instansi" class="form-control" value="<?php echo htmlspecialchars($dataPekerjaan['sektor_instansi']); ?>">
        </div>
        <div class="form-group">
             <label for="rasio" class="form-label">Rasio Pembiayaan (hanya diisi angka saja tanpa tanda %)</label>
            <input type="number" class="form-control" name="rasio" id="rasio" min="0" max="100" step="0.01" required oninput="validRasio(this)" value="<?php echo htmlspecialchars($dataPekerjaan['rasio']); ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
</div></div>
<script>
function validRasio(input) {
    const value = input.value;
    if (!/^\d*\.?\d*$/.test(value)) {
        input.setCustomValidity("Hanya angka saja yang diperbolehkan.");
    } else {
        input.setCustomValidity("");
    }
}
</script>