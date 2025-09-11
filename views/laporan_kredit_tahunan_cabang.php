
<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📅 Laporan Kredit Tahunan <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>
<div class="card-body">

<?php
include("../Database/koneksi.php");

$kode_cabang = $_SESSION['kode_cabang'];

$tahunList = [];
$sqlTahun  = "SELECT DISTINCT YEAR(update_riwayat_kredit) AS tahun 
             FROM riwayat_kredit 
             WHERE kode_cabang = ? 
             ORDER BY tahun DESC";
if ($stmtTahun = $mysqli->prepare($sqlTahun)) {
    $stmtTahun->bind_param("s", $kode_cabang);
    $stmtTahun->execute();
    $resultTahun = $stmtTahun->get_result();
    while ($row = $resultTahun->fetch_assoc()) {
        $tahunList[] = $row['tahun'];
    }
    $stmtTahun->close();
}

// Ambil bulan terpilih
$tahunTerpilih = isset($_GET['tahun']) ? $_GET['tahun'] : (count($tahunList) ? $tahunList[0] : '');
?>
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
<!-- Dropdown Pilih Bulan -->
<form method="GET" action="laporan_kredit_tahunan_cabang.php" class="form-inline mb-3">
   <input type="hidden" name="kode_cabang" value="<?php echo $kode_cabang; ?>">
   <label class="mr-2" for="tahun"><strong>Pilih Tahun:</strong></label>
   <select name="tahun" id="tahun" class="form-control mr-2" onchange="this.form.submit()" required>
      <option disabled selected>-- Pilih Tahun --</option>
      <?php foreach ($tahunList as $tahun): ?>
         <option value="<?php echo $tahun; ?>" <?php echo ($tahun == $tahunTerpilih ? 'selected' : ''); ?>>
    <?php echo $tahun; ?>
</option>
      <?php endforeach; ?>
   </select>
</form>

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
        $getLaporanKreditCabang = [];

        if ($tahunTerpilih) {
            $query = "SELECT * FROM riwayat_kredit 
                      INNER JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp
                      INNER JOIN cabang ON riwayat_kredit.kode_cabang = cabang.kode_cabang
                      WHERE riwayat_kredit.kode_cabang = ? 
                      AND YEAR(update_riwayat_kredit) = ?";

            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("si", $kode_cabang, $tahunTerpilih);
                $stmt->execute();
                $result = $stmt->get_result();
                $getLaporanKreditCabang = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
            } else {
                echo "<tr><td colspan='8' class='text-center'>Query error: " . $mysqli->error . "</td></tr>";
            }
        }

        $no = 1;
        foreach ($getLaporanKreditCabang as $dataLapKreditCabang) {
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['update_riwayat_kredit']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['id_pegawai']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKreditCabang['nama_debitur']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataLapKreditCabang['alamat']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['jenis_kredit']); ?></td>
                <td class="text-center"><?php echo number_format($dataLapKreditCabang['plafon_pengajuan']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataLapKreditCabang['jw_pengajuan']); ?></td>
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
