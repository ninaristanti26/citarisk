<?php
session_start();
include "other/header.php";
?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Rekap Laporan Kredit</h5>
            </div>
<div class="card-body">
<div class="form-row mb-3">
   <!-- Dropdown Jenis Laporan -->
   <div class="form-group col-md-6">
      <label for="jenisLaporan"><strong>Pilih Jenis Laporan:</strong></label>
      <select class="form-control" id="jenisLaporan" onchange="location = this.value;">
         <option disabled selected>-- Pilih Laporan --</option>
         <option value="laporan_kredit?id_pegawai=<?php echo urlencode($_SESSION['id_pegawai']); ?>">Laporan Kredit</option>
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
    <h5 class="mb-3"><strong>Rekap Data Kredit</strong></h5>
   <table class="table table-bordered table-striped table-sm w-100">
    <tbody>
        <?php
        include(__DIR__ . '/../Database/koneksi.php');
        include(__DIR__ . '/../getCode/getRekapLaporanKredit.php');
        ?>
        <?php if (!empty($getRekapLaporanKredit)): ?>
        <?php foreach ($getRekapLaporanKredit as $dataLapKredit): ?>
            <tr>
                <th class="text-left" style="width: 30%;">ID</th>
                <td style="width: 5%;" class="text-center">:</td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['id_pegawai']); ?></td>
            </tr>
            <tr>
                <th class="text-left">Nama Petugas Marketing</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['nama']); ?></td>
            </tr>
            <tr>
                <th class="text-left">NOA Debitur Yang Diajukan</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['noa']); ?></td>
            </tr>
            <tr>
                <th class="text-left">Jumlah Plafon Pengajuan</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo number_format($dataLapKredit['plafon_pengajuan']); ?></td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
    <tr>
        <td colspan="3" class="text-center text-muted">Data tidak ditemukan.</td>
    </tr>
<?php endif; ?>
    </tbody>
</table>
</div>
</div>
</div>
</div>
   </div>
</div>

<?php include "other/footer.php"; ?>