<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📅 Laporan Kredit Bulanan</h5>
            </div>
<div class="card-body">

<?php
include("../Database/koneksi.php");

// Ambil daftar bulan unik dari update_riwayat_kredit
$id_pegawai = $_SESSION['id_pegawai'];

$bulanList = [];
$sqlBulan = "SELECT DISTINCT DATE_FORMAT(update_riwayat_kredit, '%Y-%m') AS bulan 
             FROM riwayat_kredit 
             WHERE id_pegawai = ? 
             ORDER BY bulan DESC";
if ($stmtBulan = $mysqli->prepare($sqlBulan)) {
    $stmtBulan->bind_param("s", $id_pegawai);
    $stmtBulan->execute();
    $resultBulan = $stmtBulan->get_result();
    while ($row = $resultBulan->fetch_assoc()) {
        $bulanList[] = $row['bulan'];
    }
    $stmtBulan->close();
}

// Ambil bulan terpilih

?>
<div class="form-group">
   <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
   <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan --</option>
      <option value="laporan_kredit?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit</option>
      <option value="laporan_kredit_harian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Harian</option>
      <option value="laporan_kredit_bulanan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Bulanan</option>
      <option value="laporan_kredit_tahunan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Tahunan</option>
   </select>
</div>

<div class="form-row mb-6">
<div class="form-group col-md-6">
<form method="GET" action="laporan_kredit_bulanan.php" class="form-inline mb-3">
   <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
   <label class="mr-2" for="bulan"><strong>Pilih Bulan:</strong></label>
   <select name="bulan" id="bulan" class="form-control mr-2" onchange="this.form.submit()" required>
      <option disabled selected>-- Pilih Bulan --</option>
      <?php foreach ($bulanList as $bulan): ?>
         <option value="<?php echo $bulan; ?>" <?php echo ($bulan == $bulanTerpilih ? 'selected' : ''); ?>>
            <?php echo date('F Y', strtotime($bulan . '-01')); ?>
         </option>
      <?php endforeach; ?>
   </select>
</form>
</div>

<div class="form-group col-md-6">
<?php
    $bulanTerpilih = isset($_GET['bulan']) ? $_GET['bulan'] : (count($bulanList) ? $bulanList[0] : '');
    $id_pegawai = $_SESSION['id_pegawai'];
?>  
<label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
    <select class="form-control" id="rincianRekap" onchange="location = this.value;">
        <option disabled selected>-- Pilih --</option>
        <option value="rekap_laporan_kredit_bulanan?id_pegawai=<?php echo $id_pegawai; ?>&bulan=<?php echo urlencode($bulanTerpilih); ?>">Rekap Laporan Kredit</option>
        <option value="laporan_kredit_bulanan?id_pegawai=<?php echo $id_pegawai; ?>&bulan=<?php echo urlencode($bulanTerpilih); ?>">Rincian Laporan Kredit</option>
    </select>
</div>
    
<!-- Tabel Data -->
<div class="table-responsive">
   <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 102%;">
    <thead class="table-light text-center">
        <tr>
            <th>No.</th>
            <th>Created At</th>
            <th>ID Marketing</th>
            <th>Nama Debitur</th>
            <th>Alamat</th>
            <th>Jenis Kredit</th>
            <th>Plafon</th>
            <th>Jangka Waktu (bulan)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $getLaporanKredit = [];

        if ($bulanTerpilih) {
            $query = "SELECT DISTINCT riwayat_kredit.*, data_pokok.*
                      FROM riwayat_kredit 
                      INNER JOIN data_pokok ON riwayat_kredit.id_pegawai = data_pokok.id_pegawai 
                            AND riwayat_kredit.no_ktp = data_pokok.no_ktp 
                      WHERE data_pokok.id_pegawai = ? 
                      AND DATE_FORMAT(update_riwayat_kredit, '%Y-%m') = ?";

            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $id_pegawai, $bulanTerpilih);
                $stmt->execute();
                $result = $stmt->get_result();
                $getLaporanKredit = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
            } else {
                echo "<tr><td colspan='8' class='text-center'>Query error: " . $mysqli->error . "</td></tr>";
            }
        }

        $no = 1;
        foreach ($getLaporanKredit as $dataLapKredit) {
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['update_riwayat_kredit']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['id_pegawai']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['nama_debitur']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['alamat']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jenis_kredit']); ?></td>
                <td class="text-center"><?php echo number_format($dataLapKredit['plafon_pengajuan']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jw_pengajuan']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div></div>
        </div>
<?php include "other/footer.php"; ?>