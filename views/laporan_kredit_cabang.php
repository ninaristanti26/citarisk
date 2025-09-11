<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>
<div class="card-body">
  <div class="form-group">
   <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
   <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan --</option>
      <option value="laporan_kredit_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit</option>
      <option value="laporan_kredit_harian_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Harian</option>
      <option value="laporan_kredit_bulanan_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Bulanan</option>
      <option value="laporan_kredit_tahunan_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Kredit Tahunan</option>
   </select>
</div>
<div class="table-responsive">
   <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 102%;">
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
       include("../Database/koneksi.php");
       include("../getCode/getLaporanKreditCabang.php");
        $no = 0;
        foreach ($getLaporanKreditCabang as $dataLapKreditCabang) {
         $no++;
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['update_riwayat_kredit']) ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['id_pegawai']) ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKreditCabang['nama_debitur']) ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKreditCabang['alamat']) ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['jenis_kredit']) ?></td>
                <td class="text-right"><?php echo number_format($dataLapKreditCabang['plafon_pengajuan']) ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['jw_pengajuan']) ?></td>
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
