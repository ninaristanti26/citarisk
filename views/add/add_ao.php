<form role="form" name="form1" method="post" action="../proses/proses_add_ao.php" enctype="multipart/form-data">
    <div class="col-lg-12">
        <div class="form-group">
            <label>ID Pegawai</label>
            <input type="text" class="form-control" name="id_pegawai" required>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label>Nama Pegawai</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label>Unit Kerja</label>
            <?php
                include("../Database/koneksi.php");
                include("../getCode/getCab.php");
            ?>
            <select class="form-control" name="kode_cabang" required>
                <?php foreach ($options as $option) { ?>
                    <option value="<?= $option['kode_cabang'] ?>"><?= $option['kode_cabang']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label>Kode Akses</label>
            <?php
                include("../getCode/getRole.php");
            ?>
            <select class="form-control" name="id_role" required>
                <option value="">Akses Sebagai</option>
                <?php 
                    foreach ($getRole as $option) {
                        echo "<option value='" . $option['id_role'] . "'>" . $option['role'] . "</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
            <input type="reset" name="reset" value="Reset" class="btn btn-secondary">
        </div>
    </div>		
</form>

