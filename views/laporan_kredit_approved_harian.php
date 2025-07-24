<?php 
include "other/header.php"; 
include("../Database/koneksi.php"); 
include("../getCode/getLaporanKredit.php"); 
include("../getCode/getLapKreditApp_harian.php"); 

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Approved Harian</h5>
            </div>
            <div class="card-body">

               <!-- Dropdown Pilih Jenis Laporan -->
               <div class="form-group">
                  <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
                  <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
                     <option disabled selected>-- Pilih Laporan --</option>
                     <option value="laporan_kredit_approved?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved</option>
                     <option value="laporan_kredit_approved_harian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Harian</option>
                     <option value="laporan_kredit_approved_bulanan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Bulanan</option>
                     <option value="laporan_kredit_approved_tahunan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Tahunan</option>
                  </select>
               </div>

               <!-- Form Filter Tanggal -->
               <form method="GET" action="laporan_kredit_approved_harian.php" class="form-inline mb-3">
                  <input type="hidden" name="id_pegawai" value="<?php echo $_SESSION['id_pegawai']; ?>">
                  <label class="mr-2" for="tanggal"><strong>Pilih Tanggal:</strong></label>
                  <input type="date" class="form-control mr-2" name="tanggal" id="tanggal"
                        value="<?php echo htmlspecialchars($tanggal); ?>" required>
                  <button type="submit" class="btn btn-dark">Tampilkan</button>
               </form>

               <p><strong>Tanggal Dipilih:</strong> <?php echo htmlspecialchars($tanggal); ?></p>

               <!-- Table -->
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
foreach ($getLaporanKredit as $dataRiwayat) {
   $no_ktp = $dataRiwayat['no_ktp'];
   $status = "-";
   $waktu  = "-";
   $tampilkan = false;

   foreach ($getPutusanKaspem as $kaspem) {
      if ($kaspem['no_ktp'] == $no_ktp && $kaspem['status_putusan_kaspem'] == 'Approved') {
         $status = "Approved by Pimpinan Cabang";
         $waktu = $kaspem['waktu_approve_pinca'];
         $tampilkan = true;
         break;
      }
   }

   foreach ($getPutusanKabag as $kabag) {
      if ($kabag['no_ktp'] == $no_ktp && $kabag['status_putusan_kabag'] == 'Approved oleh Kadiv. Pemasaran') {
         $status = "Approved by Kepala Divisi Pemasaran";
         $waktu = $kabag['waktu_approve_kadiv'];
         $tampilkan = true;
         break;
      }
   }

   foreach ($getPutusanKadiv as $kadiv) {
      if ($kadiv['no_ktp'] == $no_ktp && $kadiv['status_kadiv'] == 'Kredit Disetujui') {
         $status = "Approved by Direktur Utama";
         foreach ($getPutusanDirut as $dirut) {
            if ($dirut['no_ktp'] == $no_ktp) {
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
