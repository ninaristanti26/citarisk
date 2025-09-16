<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Rejected</h5>
            </div>

            <div class="card-body">
               <!-- Dropdown Pilih Laporan -->
               <div class="form-group">
                  <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
                  <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
                     <option disabled selected>-- Pilih Laporan --</option>
                     <option value="laporan_kredit_rejected?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Rejected</option>
                     <option value="laporan_kredit_rejected_harian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Rejected Harian</option>
                     <option value="laporan_kredit_rejected_bulanan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Rejected Bulanan</option>
                     <option value="laporan_kredit_rejected_tahunan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Rejected Tahunan</option>
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
                        include(__DIR__ . '/../Database/koneksi.php');
                        include(__DIR__ . '/../getCode/getLaporanKredit.php');
                        include(__DIR__ . '/../getCode/getLapKreditApp.php');
                        $no = 1;
                        $adaData = false;

                        foreach ($getLaporanKredit as $dataRiwayat) {
                           $no_ktp       = $dataRiwayat['no_ktp'];
                           $nama_debitur = $dataRiwayat['nama_debitur'];
                           $alamat       = $dataRiwayat['alamat'];
                           $jenis_kredit = $dataRiwayat['jenis_kredit'];
                           $plafon       = $dataRiwayat['plafon_pengajuan'];
                           $jw_pengajuan = $dataRiwayat['jw_pengajuan'];

                           $status = "";
                           $waktu  = "";

                           // Cek di setiap level apakah ditolak
                           foreach ($getPutusanKaspem as $kaspem) {
                              if ($kaspem['no_ktp'] == $no_ktp && $kaspem['status_putusan_kaspem'] == 'Rejected') {
                                 $status = "Rejected by Pimpinan Cabang";
                                 $waktu  = $kaspem['waktu_approve_pinca'];
                                 break;
                              }
                           }

                           if ($status === "") {
                              foreach ($getPutusanKabag as $kabag) {
                                 if ($kabag['no_ktp'] == $no_ktp && $kabag['status_putusan_kabag'] == 'Rejected oleh Kadiv. Pemasaran') {
                                    $status = "Rejected by Kepala Divisi Pemasaran";
                                    $waktu  = $kabag['waktu_approve_kadiv'];
                                    break;
                                 }
                              }
                           }

                           if ($status === "") {
                              foreach ($getPutusanKadiv as $kadiv) {
                                 if ($kadiv['no_ktp'] == $no_ktp && $kadiv['status_kadiv'] == 'Rejected') {
                                    $status = "Rejected by Direktur Utama";
                                    foreach ($getPutusanDirut as $dirut) {
                                       if ($dirut['no_ktp'] == $no_ktp) {
                                          $waktu = $dirut['waktu_putus_dirut'];
                                          break;
                                       }
                                    }
                                    break;
                                 }
                              }
                           }

                           // Jika status rejected ditemukan, tampilkan
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
