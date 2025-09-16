<?php 
include "other/header.php"; 
include(__DIR__ . '/../Database/koneksi.php');
include(__DIR__ . '/../getCode/getLaporanKredit.php');
include(__DIR__ . '/../getCode/getLapKreditApp_bulanan.php');

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Approved Bulanan</h5>
            </div>
            <div class="card-body">

               <!-- Dropdown Pilih Laporan -->
               <div class="form-group">
                  <label><strong>Pilih Jenis Laporan:</strong></label>
                  <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
                     <option disabled selected>-- Pilih Laporan --</option>
                     <option value="laporan_kredit_approved?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved</option>
                     <option value="laporan_kredit_approved_harian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Harian</option>
                     <option value="laporan_kredit_approved_bulanan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Bulanan</option>
                     <option value="laporan_kredit_approved_tahunan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Tahunan</option>
                  </select>
               </div>

               <!-- Form Filter Bulan dan Tahun -->
               <form method="GET" action="laporan_kredit_approved_bulanan.php" class="form-inline mb-3">
                  <input type="hidden" name="id_pegawai" value="<?php echo $_SESSION['id_pegawai']; ?>">

                  <label class="mr-2"><strong>Bulan:</strong></label>
                  <select name="bulan" class="form-control mr-2" required>
                     <?php 
                     for ($i = 1; $i <= 12; $i++) {
                        $selected = ($i == $bulan) ? 'selected' : '';
                        echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
                     }
                     ?>
                  </select>

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

               <p><strong>Periode:</strong> <?php echo date('F', mktime(0,0,0,$bulan,1)) . " " . $tahun; ?></p>

               <div class="table-responsive">
                  <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 100%;">
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
                        foreach ($getLaporanKredit as $dataRiwayat) {
                           $no_ktp = $dataRiwayat['no_ktp'];
                           $status = "-";
                           $waktu  = "-";

                           foreach ($getPutusanKaspem as $kaspem) {
                              if ($kaspem['no_ktp'] == $no_ktp && $kaspem['status_putusan_kaspem'] == 'Approved') {
                                 $status = "Approved by Pimpinan Cabang";
                                 $waktu  = $kaspem['waktu_approve_pinca'];
                                 break;
                              }
                           }

                           foreach ($getPutusanKabag as $kabag) {
                              if ($kabag['no_ktp'] == $no_ktp && $kabag['status_putusan_kabag'] == 'Approved oleh Kadiv. Pemasaran') {
                                 $status = "Approved by Kepala Divisi Pemasaran";
                                 $waktu  = $kabag['waktu_approve_kadiv'];
                                 break;
                              }
                           }

                           foreach ($getPutusanKadiv as $kadiv) {
                              if ($kadiv['no_ktp'] == $no_ktp && $kadiv['status_kadiv'] == 'Kredit Disetujui') {
                                 $status = "Approved by Direktur Utama";
                                 foreach ($getPutusanDirut as $dirut) {
                                    if ($dirut['no_ktp'] == $no_ktp) {
                                       $waktu = $dirut['waktu_putus_dirut'];
                                       break;
                                    }
                                 }
                                 break;
                              }
                           }

                       if ($status !== "-" && $waktu !== "-") {
       $tgl_approve = strtotime($waktu);
       if (date('m', $tgl_approve) == $bulan && date('Y', $tgl_approve) == $tahun) {
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