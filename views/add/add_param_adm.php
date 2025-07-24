<form role="form" name="form1" method="post" action="../proses/proses_add_param_adm.php" enctype="multipart/form-data">
    <div class="col-lg-12">
        <div class="form-group">
        <label class="form-control-label" for="input-first-name">Jenis Administrasi</label>
            <textarea type="text" class="form-control" name="jenis_adm" id="jenis_adm"></textarea>
		</div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" onClick="return valid()"/>
			<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-primary">
        </div>
    </div>	
</form>