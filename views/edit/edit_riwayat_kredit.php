<div id="formEditRiwayatKredit" class="p-3 border rounded mt-3" style="display: none; background-color: #fffbe7;">
<form action="../../proses/proses_edit_riwayat_kredit.php" method="post" onsubmit="return validEdit()">
    <div class="modal-header">
        <h5 class="text-warning">✏️ Edit Data Pengajuan Kredit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataRiwayat['no_ktp']); ?>">
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp_edit" class="form-control" value="<?php echo htmlspecialchars($dataRiwayat['no_ktp']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Jenis Kredit</label>
            <select name="jenis_kredit" class="form-control" required>
                <option value="Konsumtif" <?php if($dataRiwayat['jenis_kredit'] == 'Konsumtif') echo 'selected'; ?>>Konsumtif</option>
            </select>
        </div>
        <div class="form-group">
             <label for="rasio" class="form-label">Plafon Pengajuan</label>
            <input type="number" class="form-control" name="plafon_pengajuan" required oninput="validRasio(this)" value="<?php echo htmlspecialchars($dataRiwayat['plafon_pengajuan']); ?>">
        </div>
        <div class="form-group">
             <label for="rasio" class="form-label">Jangka Waktu</label>
            <input type="number" class="form-control" name="jw_pengajuan" required oninput="validRasio(this)" value="<?php echo htmlspecialchars($dataRiwayat['jw_pengajuan']); ?>">
        </div>
        <input type="hidden" name="id_pegawai" value="<?php echo htmlspecialchars($dataRiwayat['id_pegawai']); ?>">
        <input type="hidden" name="kode_cabang" value="<?php echo htmlspecialchars($dataRiwayat['kode_cabang']); ?>">
        <div class="form-group">
            <label>Tujuan Pengajuan</label>
            <input type="text" name="tujuan_pengajuan" class="form-control" value="<?php echo htmlspecialchars($dataRiwayat['tujuan_pengajuan']); ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
</div>