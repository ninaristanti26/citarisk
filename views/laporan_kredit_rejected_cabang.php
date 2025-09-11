<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Rejected <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>

            <div class="card-body">
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
                           <th>Tanggal Rejected</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                        include("../Database/koneksi.php");
                        include("../getCode/getLaporanKreditCabang.php");
                        include("../getCode/getLapKreditAppCabang.php");
                        $no = 1;
                        $adaData = false;

                        foreach ($getLaporanKreditCabang as $dataRiwayat) {
                           $no_ktp       = $dataRiwayat['no_ktp'];
                           $nama_debitur = $dataRiwayat['nama_debitur'];
                           $alamat       = $dataRiwayat['alamat'];
                           $jenis_kredit = $dataRiwayat['jenis_kredit'];
                           $plafon       = $dataRiwayat['plafon_pengajuan'];
                           $jw_pengajuan = $dataRiwayat['jw_pengajuan'];
                           $id_riwayat   = $dataRiwayat['id_riwayat'];

                           $status = "";
                           $waktu  = "";

                           foreach ($getPutusanKaspem as $kaspem) {
                              if ($kaspem['id_riwayat'] == $id_riwayat && $kaspem['status_putusan_kaspem'] == 'Rejected') {
                                 $status = "Rejected by Pimpinan Cabang";
                                 $waktu  = $kaspem['waktu_approve_pinca'];
                                 break;
                              }
                           }

                           if ($status === "") {
                              foreach ($getPutusanKabag as $kabag) {
                                 if ($kabag['id_riwayat'] == $id_riwayat && $kabag['status_putusan_kabag'] == 'Rejected oleh Kadiv. Pemasaran') {
                                    $status = "Rejected by Kepala Divisi Pemasaran";
                                    $waktu  = $kabag['waktu_approve_kadiv'];
                                    break;
                                 }
                              }
                           }

                           if ($status === "") {
                              foreach ($getPutusanKadiv as $kadiv) {
                                 if ($kadiv['id_riwayat'] == $id_riwayat && $kadiv['status_kadiv'] == 'Rejected') {
                                    $status = "Rejected by Direktur Utama";
                                    foreach ($getPutusanDirut as $dirut) {
                                       if ($dirut['id_riwayat'] == $id_riwayat) {
                                          $waktu = $dirut['waktu_putus_dirut'];
                                          break;
                                       }
                                    }
                                    break;
                                 }
                              }
                           }

                           if ($status !== "") {
                              $adaData = true;
                              ?>
                              <tr>
                                 <td class="text-center"><?php echo $no++; ?></td>
                                 <td class="text-center"><?php echo htmlspecialchars($nama_debitur); ?></td>
                                 <td class="text-left"><?php echo htmlspecialchars($alamat); ?></td>
                                 <td class="text-left"><?php echo htmlspecialchars($jenis_kredit); ?></td>
                                 <td class="text-center"><?php echo number_format($plafon); ?></td>
                                 <td class="text-center"><?php echo htmlspecialchars($jw_pengajuan); ?></td>
                                 <td class="text-center"><?php echo htmlspecialchars($status); ?></td>
                                 <td class="text-center"><?php echo htmlspecialchars($waktu); ?></td>
                              </tr>
                              <?php
                           }
                        }

                        if (!$adaData) {
                           echo '<tr><td colspan="8" class="text-center">Tidak ada data pengajuan kredit yang ditolak.</td></tr>';
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
