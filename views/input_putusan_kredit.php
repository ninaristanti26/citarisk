<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">🧾 Konfirmasi Putusan Kredit</h5>
            </div>
            <div class="card-body">
              <?php
                  $id_riwayat = isset($_GET['id_riwayat']) ? htmlspecialchars($_GET['id_riwayat']) : '';
                  $no_ktp     = isset($_GET['no_ktp']) ? htmlspecialchars($_GET['no_ktp']) : '';
                  $id_pegawai = isset($_GET['id_pegawai']) ? htmlspecialchars($_GET['id_pegawai']) : '';
               ?>
<?php
include("../getCode/getPutusanKredit.php");
include("../getCode/getRiwayat_kredit.php");
include("../getCode/getDetail.php");
?>
<div class="mb-3">
   <?php foreach ($getDetail as $dataDeb) { ?>
   <label for="plafon_kredit" class="form-label">Nama Debitur</label>
   <input class="form-control" name="#" id="#" value="<?php echo $dataDeb['nama_debitur']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="jw_kredit" class="form-label">Alamat</label>
                <input class="form-control" name="#" id="#" value="<?php echo $dataDeb['alamat']; ?>" readonly>
            </div>
<?php } ?>
<form method="POST" action="../proses/proses_add_putusan_kredit.php">
    <input type="hidden" name="id_riwayat" value="<?php echo $id_riwayat; ?>">
    <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
    <input type="hidden" name="no_ktp" value="<?php echo $no_ktp; ?>">
    <div class="card mt-3">
        <div class="card-body">
            <div class="mb-3">
               <?php
                  function formatRupiah($angka) {
                  return number_format($angka, 0, ',', '.');
                  }
               ?>
                <label for="plafon_kredit" class="form-label">Plafon Kredit</label>
                <input class="form-control" name="plafon_kredit" id="plafon_kredit" value="<?php echo formatRupiah($plafon_kredit); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="jw_kredit" class="form-label">Jangka Waktu Kredit</label>
                <input class="form-control" name="jw_kredit" id="jw_kredit" value="<?php echo htmlspecialchars($jw_kredit); ?>" readonly>
            </div>
            <div class="text-center mt-4">
                <button type="submit" name="Submit" value="Submit" class="btn btn-success px-4 me-2">💾 Simpan</button>
                <button type="reset" class="btn btn-secondary px-4">🔄 Reset</button>
            </div>
        </div>
    </div>
</form>
         </div>
            </div>
         </div>
   </div>
</div>
<?php include "other/footer.php"; ?>
