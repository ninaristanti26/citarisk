<div id="formEditStatusKawin" class="p-3 border rounded mt-3" style="display: none; background-color: #fffbe7;">
<form action="../../proses/proses_edit_status_kawin.php" method="post" onsubmit="return validEdit()">
    <div class="modal-header">
        <h5 class="text-warning">✏️ Edit Data Status Kawin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataStat_kawin['no_ktp']); ?>">
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp_edit" class="form-control" value="<?php echo htmlspecialchars($dataStat_kawin['no_ktp']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Status Kawin</label>
            <select name="status_kawin" class="form-control" required>
                <option value="Kawin" <?php if($dataStat_kawin['status_kawin'] == 'Kawin') echo 'selected'; ?>>Kawin</option>
                <option value="Tidak Kawin" <?php if($dataStat_kawin['status_kawin'] == 'Tidak Kawin') echo 'selected'; ?>>Tidak Kawin</option>
                <option value="Janda/Duda" <?php if($dataStat_kawin['status_kawin'] == 'Janda/Duda') echo 'selected'; ?>>Janda/Duda</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nama Pasangan</label>
            <input type="text" name="nama_pasangan" class="form-control" value="<?php echo htmlspecialchars($dataStat_kawin['nama_pasangan']); ?>">
        </div>
        <div class="form-group">
            <label>Tempat Lahir Pasangan</label>
            <input type="text" name="tempat_lahir_pasangan" class="form-control" value="<?php echo htmlspecialchars($dataStat_kawin['tempat_lahir_pasangan']); ?>">
        </div>
        <div class="form-group">
            <label>Tanggal Lahir Pasangan</label>
            <input type="date" name="tgl_lahir_pasangan" class="form-control" value="<?php echo htmlspecialchars($dataStat_kawin['tgl_lahir_pasangan']); ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
</div>