<?php 
include "other/header.php"; 
include("../Database/koneksi.php"); 
include("../getCode/getLaporanKredit.php"); 
//include("../getCode/getRekapLapKrdApp_bulanan.php");

$tahun = $_GET['tahun'] ?? date('Y');
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Pencapaian Kredit</h5>
            </div>
            <div class="card-body">
             <form method="GET" action="laporan_pencapaian.php" class="form-inline mb-3">
                  <input type="hidden" name="id_pegawai" value="<?php echo $_SESSION['id_pegawai']; ?>">

                  <label class="mr-2"><strong>Tahun:</strong></label>
                  <select name="tahun" class="form-control mr-2" required>
                     <?php 
                     $currentYear = date('Y');
                     for ($y = $currentYear; $y >= 2020; $y--) {
                        $selected = ($y == $tahun) ? 'selected' : '';
                        echo "<option value='$y' $selected>$y</option>";
                     }
                     ?>
                  </select>

                  <button type="submit" class="btn btn-dark">Tampilkan</button>
               </form>

               <p><strong>Periode:</strong> <?php echo $tahun; ?></p>
               
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>