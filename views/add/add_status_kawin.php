<form method="POST" >
<input type="hidden" class="form-control" name="no_ktp" id="no_ktp" value="<?php echo $_GET['no_ktp']; ?>">
<input type="hidden" class="form-control" name="update_kawin" id="update_kawin" 
       value="<?php $update_kawin = new DateTime(); 
       echo $update_kawin->format('Y-m-d H:i:s');  ?>">
<div class="col-lg-12">
<div class="form-group">
    <label class="form-control-label" for="input-first-name">Status Perkawinan</label>
    <select class="form-control" name="status_kawin">
        <option>Kawin</option>
        <option>Tidak Kawin</option>
        <option>Janda/Duda</option>
    </select>
</div>
</div>
<div class="col-lg-12">
<div class="form-group">
    <label class="form-control-label" for="input-first-name">Nama Pasangan</label>
    <input type="text" class="form-control" name="nama_pasangan" id="nama_pasangan" required>
</div>
</div>
<div class="col-lg-12">
<div class="form-group">
    <label class="form-control-label" for="input-first-name">Tempat Lahir Pasangan</label>
    <input type="text" class="form-control" name="tempat_lahir_pasangan" id="tempat_lahir_pasangan" required>
</div>
</div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Tanggal Lahir Pasangan</label>
            <input type="date" class="form-control" name="tgl_lahir_pasangan" id="tgl_lahir_pasangan">
		</div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" onClick="return valid()"/>
			<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-primary">
        </div>
    </div>		
</form>