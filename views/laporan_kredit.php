<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit</h5>
            </div>
<div class="card-body">
<div class="form-row mb-3">
   <!-- Dropdown Jenis Laporan -->
   <div class="form-group col-md-6">
      <label for="jenisLaporan"><strong>Pilih Jenis Laporan:</strong></label>
      <select class="form-control" id="jenisLaporan" onchange="location = this.value;">
         <option disabled selected>-- Pilih Laporan --</option>
         <option value="laporan_kredit?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit</option>
         <option value="laporan_kredit_harian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Harian</option>
         <option value="laporan_kredit_bulanan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Bulanan</option>
         <option value="laporan_kredit_tahunan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Tahunan</option>
      </select>
   </div>

   <!-- Dropdown Rincian atau Rekap -->
   <div class="form-group col-md-6">
      <label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
      <select class="form-control" id="rincianRekap" onchange="location = this.value;">
         <option disabled selected>-- Pilih --</option>
         <option value="rekap_laporan_kredit?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Rekap Laporan Kredit</option>
         <option value="laporan_kredit?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Rincian Laporan Kredit</option>
      </select>
   </div>
</div>

<div class="table-responsive">
   <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 100%;">
    <thead class="table-light text-center">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Created At</th>
            <th scope="col">ID Marketing</th>
            <th scope="col">Nama Debitur</th>
            <th scope="col">Alamat</th>
            <th scope="col">Jenis Kredit</th>
            <th scope="col">Plafon</th>
            <th scope="col">Jangka Waktu (dalam bulan)</th>
        </tr>
    </thead>
    <tbody>
        <?php
       include(__DIR__ . '/../Database/koneksi.php');
       include(__DIR__ . '/../getCode/getLaporanKredit.php');
        $no = 0;
        foreach ($getLaporanKredit as $dataLapKredit) {
         $no++;
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['update_riwayat_kredit']) ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['id_pegawai']) ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['nama_debitur']) ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['alamat']) ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jenis_kredit']) ?></td>
                <td class="text-center"><?php echo number_format($dataLapKredit['plafon_pengajuan']) ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jw_pengajuan']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</div>
</div>
         <!-- Modal Tambah Pegawai -->
         <div class="modal fade" id="modalTambahDebitur" tabindex="-1" role="dialog" aria-labelledby="modalTambahDebiturLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="modalTambahDebiturLabel">Tambah Debitur</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <?php require_once "add/add_debitur.php"; ?>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>
