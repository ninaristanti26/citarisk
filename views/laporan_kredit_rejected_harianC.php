<?php 
include "other/header.php"; 
include("../Database/koneksi.php"); 
include("../getCode/getLaporanKreditCabang.php"); 
include("../getCode/getLapKreditApp_harianC.php"); 

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Rejected Harian <?php $_SESSION['kode_cabang'];?></h5>
            </div>
            <div class="card-body">

               <!-- Dropdown Pilih Jenis Laporan -->
               <div class="form-group">
                  <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
                  <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
                     <option disabled selected>-- Pilih Laporan --</option>
                     <option value="laporan_kredit_rejected_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Rejected</option>
                     <option value="laporan_kredit_rejected_harianC?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Rejected Harian</option>
                     <option value="laporan_kredit_rejected_bulananC?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Rejected Bulanan</option>
                     <option value="laporan_kredit_rejected_tahunanC?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Rejected Tahunan</option>
                  </select>
               </div>

               <!-- Form Filter Tanggal -->
               <form method="GET" action="laporan_kredit_rejected_harianC.php" class="form-inline mb-3">
                  <input type="hidden" name="kode_cabang" value="<?php echo $_SESSION['kode_cabang']; ?>">
                  <label class="mr-2" for="tanggal"><strong>Pilih Tanggal:</strong></label>
                  <input type="date" class="form-control mr-2" name="tanggal" id="tanggal"
                        value="<?php echo htmlspecialchars($tanggal); ?>" required>
                  <button type="submit" class="btn btn-dark">Tampilkan</button>
               </form>

               <p><strong>Tanggal Dipilih:</strong> <?php echo htmlspecialchars($tanggal); ?></p>

               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 102%;">
                     <thead class="table-light text-center">
                        <tr>
                           <th>No.</th>
                           <th>Nama Debitur</th>
                           <th>Alamat</th>
                           <th>Jenis Kredit</th>
                           <th>Plafon</th>
                           <th>Jangka Waktu</th>
                           <th>Status</th>
                           <th>Tanggal Approved</th>
                        </tr>
                     </thead>
                     <tbody>
                       <?php
$no = 1;
foreach ($getLaporanKreditCabang as $dataRiwayat) {
   $id_riwayat = $dataRiwayat['id_riwayat'];
   $status = "-";
   $waktu  = "-";
   $tampilkan = false;

   foreach ($getPutusanKaspem as $kaspem) {
      if ($kaspem['id_riwayat'] == $id_riwayat && $kaspem['status_putusan_kaspem'] == 'Rejected') {
         $status = "Rejected by Pimpinan Cabang";
         $waktu = $kaspem['waktu_approve_pinca'];
         $tampilkan = true;
         break;
      }
   }

   foreach ($getPutusanKabag as $kabag) {
      if ($kabag['id_riwayat'] == $id_riwayat && $kabag['status_putusan_kabag'] == 'Rejected') {
         $status = "Rejected by Kepala Divisi Pemasaran";
         $waktu = $kabag['waktu_approve_kadiv'];
         $tampilkan = true;
         break;
      }
   }

   foreach ($getPutusanKadiv as $kadiv) {
      if ($kadiv['id_riwayat'] == $id_riwayat && $kadiv['status_kadiv'] == 'Rejected') {
         $status = "Rejected by Direktur Utama";
         foreach ($getPutusanDirut as $dirut) {
            if ($dirut['id_riwayat'] == $id_riwayat) {
               $waktu = $dirut['waktu_putus_dirut'];
               $tampilkan = true;
               break;
            }
         }
         break;
      }
   }

   if (!$tampilkan) continue;
?>
                        <tr>
                           <td class="text-center"><?php echo $no++; ?></td>
                           <td class="text-center"><?php echo htmlspecialchars($dataRiwayat['nama_debitur']); ?></td>
                           <td class="text-left"><?php echo htmlspecialchars($dataRiwayat['alamat']); ?></td>
                           <td class="text-left"><?php echo htmlspecialchars($dataRiwayat['jenis_kredit']); ?></td>
                           <td class="text-center"><?php echo number_format($dataRiwayat['plafon_pengajuan']); ?></td>
                           <td class="text-center"><?php echo htmlspecialchars($dataRiwayat['jw_pengajuan']); ?></td>
                           <td class="text-center"><?php echo htmlspecialchars($status); ?></td>
                           <td class="text-center"><?php echo htmlspecialchars($waktu); ?></td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>
