<form role="form" name="form1" method="post" action="../proses/proses_add_deb.php" enctype="multipart/form-data">
    <input type="hidden" class="form-control" name="upload_time" id="upload_time" value="<?php $upload_time = new DateTime(); 
            echo $upload_time->format('Y-m-d H:i:s');?>" readonly>
    <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" value="<?php echo $_SESSION['id_pegawai']; ?>" readonly>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">No. KTP</label>
            <input type="text" class="form-control" name="no_ktp" id="no_ktp" pattern="\d{16}" title="No. KTP harus 16 digit angka" required>
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Nama Calon Debitur</label>
            <input type="text" class="form-control" name="nama_debitur" id="nama_debitur" >
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-control-label" for="input-first-name">Jenis Kelamin</label>
            <select class="form-control" name="jk">
                <option>Perempuan</option>
                <option>Laki-laki</option>
            </select>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Tempat Lahir</label>
            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" >
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Tanggal Lahir</label>
            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" >
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-control-label" for="input-first-name">Pendidikan Terakhir</label>
            <select class="form-control" name="pend_akhir">
                <option>SD</option>
                <option>SLTP</option>
                <option>SLTA</option>
                <option>D/III</option>
                <option>D/IV</option>
                <option>S1</option>
                <option>S2</option>
            </select>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Nama Gadis Ibu Kandung</label>
            <input type="text" class="form-control" name="nama_ibu" id="nama_ibu" >
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Jumlah Tanggungan</label>
            <input type="text" class="form-control" name="jml_tanggungan" id="jml_tanggungan">
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">No. HP</label>
            <input type="number" class="form-control" name="no_hp" id="no_hp">
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Alamat Saat Ini</label>
            <textarea type="text" class="form-control" name="alamat" id="alamat" ></textarea>
		</div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label class="form-control-label" for="input-first-name">Status Tempat Tinggal</label>
            <select class="form-control" name="status_rumah">
                <option>Rumah Sendiri</option>
                <option>Sewa/Kontrak</option>
                <option>Rumah Orangtua</option>
                <option>Mess/Asrama</option>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" onClick="return valid()"/>
			<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-primary">
        </div>
    </div>	
</form>
<script>
function valid() {
    var form = document.forms['form1'];
    
    var no_ktp = form['no_ktp'].value.trim();
    var regex_ktp = /^\d{16}$/;
    if (!regex_ktp.test(no_ktp)) {
        alert('No. KTP harus terdiri dari 16 digit angka.');
        form['no_ktp'].focus();
        return false;
    }

    for (var i = 0; i < form.elements.length; i++) {
        var el = form.elements[i];
        
        if (el.type === 'hidden' || el.type === 'submit' || el.type === 'reset' || el.disabled) {
            continue;
        }

        if ((el.tagName.toLowerCase() === 'input' || el.tagName.toLowerCase() === 'select' || el.tagName.toLowerCase() === 'textarea') 
            && el.hasAttribute('name')) {
            var val = el.value.trim();
            if (val === '') {
                alert('Field "' + (el.previousElementSibling ? el.previousElementSibling.innerText : el.name) + '" tidak boleh kosong.');
                el.focus();
                return false;
            }
        }
    }

    return true; 
}
</script>

