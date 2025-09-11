<form action="../../proses/proses_edit_detail.php" method="post" onsubmit="return validEdit()">
    <div class="modal-header">
        <h5 class="modal-title" id="modalEditDebiturLabel">Edit Data Debitur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataDeb['no_ktp']); ?>">
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp_edit" class="form-control" value="<?php echo htmlspecialchars($dataDeb['no_ktp']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Debitur</label>
            <input type="text" name="nama_debitur" class="form-control" value="<?php echo htmlspecialchars($dataDeb['nama_debitur']); ?>" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-control" required>
                <option value="Perempuan" <?php if($dataDeb['jk'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                <option value="Laki-laki" <?php if($dataDeb['jk'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" value="<?php echo htmlspecialchars($dataDeb['tempat_lahir']); ?>" required>
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" value="<?php echo htmlspecialchars($dataDeb['tgl_lahir']); ?>" required>
        </div>
        <div class="form-group">
            <label>Pendidikan Terakhir</label>
                <select name="pend_akhir" class="form-control" required>
                   <?php 
                    $pendidikanOptions = ['SD','SLTP','SLTA','D/III','D/IV','S1','S2'];
                    foreach ($pendidikanOptions as $opt) {
                    $sel = ($dataDeb['pend_akhir'] == $opt) ? 'selected' : '';
                    echo "<option value=\"$opt\" $sel>$opt</option>";
                    }
                    ?>
                </select>
        </div>
        <div class="form-group">
            <label>Nama Ibu Kandung</label>
            <input type="text" name="nama_ibu" class="form-control" value="<?php echo htmlspecialchars($dataDeb['nama_ibu']); ?>" required>
        </div>
        <div class="form-group">
                     <label>Jumlah Tanggungan</label>
                     <input type="number" name="jml_tanggungan" class="form-control" value="<?php echo htmlspecialchars($dataDeb['jml_tanggungan']); ?>" required>
                   </div>

                   <div class="form-group">
                     <label>No. HP</label>
                     <input type="text" name="no_hp" class="form-control" value="<?php echo htmlspecialchars($dataDeb['no_hp']); ?>" required>
                   </div>

                   <div class="form-group">
                     <label>Alamat</label>
                     <textarea name="alamat" class="form-control" required><?php echo htmlspecialchars($dataDeb['alamat']); ?></textarea>
                   </div>

                   <div class="form-group">
                     <label>Status Rumah</label>
                     <select name="status_rumah" class="form-control" required>
                       <?php 
                         $statusOptions = ['Rumah Sendiri','Sewa/Kontrak','Rumah Orangtua','Mess/Asrama'];
                         foreach ($statusOptions as $opt) {
                           $sel = ($dataDeb['status_rumah'] == $opt) ? 'selected' : '';
                           echo "<option value=\"$opt\" $sel>$opt</option>";
                         }
                       ?>
                     </select>
                   </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                   <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                 </div>
               </form>