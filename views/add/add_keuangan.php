<div id="formDataKeuangan" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Tambah Data Keuangan</h5>
    <form method="POST" action="../proses/proses_add_keuangan.php">
        <input type="hidden" name="id_riwayat" value="<?php echo $_GET['id_riwayat']; ?>">
        <input type="hidden" name="no_ktp" value="<?php echo $_GET['no_ktp']; ?>">

        <div class="form-group">
            <label for="penghasilan_tetap">Penghasilan Tetap</label>
            <input type="text" class="form-control" name="penghasilan_tetap" id="penghasilan_tetap" required>
        </div>

        <div class="form-group">
            <label for="penghasilan_variabel">Penghasilan Variabel</label>
            <input type="text" class="form-control" name="penghasilan_variabel" id="penghasilan_variabel">
        </div>

        <div class="form-group">
            <label for="jw_maks">Jangka Waktu Maksimal yang dapat diberikan (bulan)</label>
            <input type="number" class="form-control" name="jw_maks" id="jw_maks" required>
        </div>

        <div class="form-group">
            <label for="bunga_maks">Suku Bunga Maksimal yang dapat diberikan (tahunan)</label>
            <input type="number" class="form-control" name="bunga_maks" id="bunga_maks" required>
        </div>

        <div class="form-group text-center">
            <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>
