<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Approved <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>
<div class="card-body">
   <div class="form-group">
   <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
   <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan --</option>
      <option value="laporan_kredit_approved_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved</option>
      <option value="laporan_kredit_app_harian_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved Harian</option>
      <option value="laporan_kredit_app_bulanan_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved Bulanan</option>
      <option value="laporan_kredit_app_tahunan_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Approved Tahunan</option>
   </select>
   </div>
   <div class="table-responsive">
      <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 100%;">
      <thead class="table-light text-center">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Nama Debitur</th>
            <th scope="col">Alamat</th>
            <th scope="col">Jenis Kredit</th>
            <th scope="col">Plafon</th>
            <th scope="col">Jangka Waktu (dalam bulan)</th>
            <th scope="col">Status</th>
            <th scope="col">Tanggal Approved</th>
        </tr>
    </thead>
    <tbody>
        <?php
         include("../Database/koneksi.php");
         include("../getCode/getLaporanKreditCabang.php");
         include("../getCode/getLapKreditAppCabang.php");
         $no = 1;
         
         foreach ($getLaporanKreditCabang as $dataRiwayat) {
            $id_riwayat = $dataRiwayat['id_riwayat'];
            $status = "-";
            $waktu  = "-";
         
         $isApproved = false;

         foreach ($getPutusanKaspem as $kaspem) {
            if ($kaspem['id_riwayat'] == $id_riwayat && $kaspem['status_putusan_kaspem'] == 'Approved') {
                $status = "Approved by Pimpinan Cabang";
                $waktu  = $kaspem['waktu_approve_pinca'];
                $isApproved = true;
            break;
            }
         }

         foreach ($getPutusanKabag as $kabag) {
            if ($kabag['id_riwayat'] == $id_riwayat && $kabag['status_putusan_kabag'] == 'Approved oleh Kadiv. Pemasaran') {
                $status = "Approved by Kepala Divisi Pemasaran";
                $waktu = $kabag['waktu_approve_kadiv'];
                $isApproved = true;
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
            $isApproved = true;
            break;
        }
    }
    if (!$isApproved) {
        continue; 
    }
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataRiwayat['nama_debitur']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataRiwayat['alamat']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataRiwayat['jenis_kredit']); ?></td>
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
