<?php 
include "other/header.php"; 
include("../Database/koneksi.php"); 
include("../getCode/getLaporanKreditCabang.php"); 
include("../getCode/getLapKreditApp_bulananC.php");

$tahun = $_GET['tahun'] ?? date('Y');
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Approved Tahunan <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>
            <div class="card-body">

               <!-- Dropdown Pilih Laporan -->
               <div class="form-group">
                  <label><strong>Pilih Jenis Laporan:</strong></label>
                  <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
                    <option disabled selected>-- Pilih Laporan --</option>
                    <option value="laporan_kredit_approved_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved</option>
                    <option value="laporan_kredit_app_harian_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved Harian</option>
                    <option value="laporan_kredit_app_bulanan_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved Bulanan</option>
                    <option value="laporan_kredit_app_tahunan_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved Tahunan</option>
                  </select>
               </div>

               <!-- Form Filter Bulan dan Tahun -->
               <form method="GET" action="laporan_kredit_app_tahunan_cabang.php" class="form-inline mb-3">
                  <input type="hidden" name="kode_cabang" value="<?php echo $_SESSION['kode_cabang']; ?>">
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

               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 102%;">
                     <thead class="text-center table-light">
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
                              if ($kaspem['id_riwayat'] == $id_riwayat && $kaspem['status_putusan_kaspem'] == 'Approved') {
                                 $status = "Approved by Pimpinan Cabang";
                                 $waktu  = $kaspem['waktu_approve_pinca'];
                                 break;
                              }
                           }

                           foreach ($getPutusanKabag as $kabag) {
                              if ($kabag['id_riwayat'] == $id_riwayat && $kabag['status_putusan_kabag'] == 'Approved oleh Kadiv. Pemasaran') {
                                 $status = "Approved by Kepala Divisi Pemasaran";
                                 $waktu  = $kabag['waktu_approve_kadiv'];
                                 break;
                              }
                           }

                           foreach ($getPutusanKadiv as $kadiv) {
                              if ($kadiv['id_riwayat'] == $id_riwayat && $kadiv['status_kadiv'] == 'Kredit Disetujui oleh Dirut') {
                                 $status = "Approved by Direktur Utama";
                                 foreach ($getPutusanDirut as $dirut) {
                                    if ($dirut['id_riwayat'] == $id_riwayat) {
                                       $waktu = $dirut['waktu_putus_dirut'];
                                       break;
                                    }
                                 }
                                 break;
                              }
                           }
                           
    if ($status !== "-" && $waktu !== "-") {
       $tgl_approve = strtotime($waktu);
       if (date('Y', $tgl_approve) == $tahun) {
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
           <?php
       }
   }
}

// Jika tidak ada data yang ditampilkan
if ($no === 1) {
    echo '<tr><td colspan="8" class="text-center">Tidak ada data untuk periode ini.</td></tr>';
}
?>
                     </tbody>
                  </table>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>