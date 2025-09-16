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
include(__DIR__ . '/../Database/koneksi.php');
$id_pegawai = $_SESSION['id_pegawai'];

// Ambil daftar bulan
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

$bulanTerpilih = $_GET['bulan'] ?? (count($bulanList) ? $bulanList[0] : '');
?>

<!-- Filter Laporan -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
        <select class="form-control" id="laporanSelect" onchange="location = this.value;">
            <option disabled selected>-- Pilih Laporan --</option>
            <option value="laporan_kredit?id_pegawai=<?php echo $id_pegawai; ?>">Laporan Kredit</option>
            <option value="laporan_kredit_harian?id_pegawai=<?php echo $id_pegawai; ?>">Laporan Kredit Harian</option>
            <option value="laporan_kredit_bulanan?id_pegawai=<?php echo $id_pegawai; ?>">Laporan Kredit Bulanan</option>
            <option value="laporan_kredit_tahunan?id_pegawai=<?php echo $id_pegawai; ?>">Laporan Kredit Tahunan</option>
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <form method="GET" action="laporan_kredit_bulanan.php">
            <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
            <label for="bulan"><strong>Pilih Bulan:</strong></label>
            <select name="bulan" id="bulan" class="form-control" onchange="this.form.submit()" required>
                <option disabled selected>-- Pilih Bulan --</option>
                <?php foreach ($bulanList as $bulan): ?>
                    <option value="<?php echo $bulan; ?>" <?php echo ($bulan == $bulanTerpilih ? 'selected' : ''); ?>>
                        <?php echo date('F Y', strtotime($bulan . '-01')); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="col-md-3 mb-3">
        <label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
        <select class="form-control" id="rincianRekap" onchange="location = this.value;">
            <option disabled selected>-- Pilih --</option>
            <option value="rekap_laporan_kredit_bulanan?id_pegawai=<?php echo $id_pegawai; ?>&bulan=<?php echo urlencode($bulanTerpilih); ?>">Rekap Laporan Kredit</option>
            <option value="laporan_kredit_bulanan?id_pegawai=<?php echo $id_pegawai; ?>&bulan=<?php echo urlencode($bulanTerpilih); ?>">Rincian Laporan Kredit</option>
        </select>
    </div>
</div>

<!-- Tabel Data -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
        <thead class="thead-light text-center">
            <tr>
                <th>No.</th>
                <th>Tanggal Pengajuan</th>
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

            if (!empty($bulanTerpilih)) {
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
                    echo "<tr><td colspan='8' class='text-center text-danger'>Query error: " . $mysqli->error . "</td></tr>";
                }
            }

            if (empty($getLaporanKredit)) {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data untuk bulan ini.</td></tr>";
            } else {
                $no = 1;
                foreach ($getLaporanKredit as $dataLapKredit):
            ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['update_riwayat_kredit']); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['id_pegawai']); ?></td>
                    <td><?php echo htmlspecialchars($dataLapKredit['nama_debitur']); ?></td>
                    <td><?php echo htmlspecialchars($dataLapKredit['alamat']); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jenis_kredit']); ?></td>
                    <td class="text-right"><?php echo number_format($dataLapKredit['plafon_pengajuan'], 0, ',', '.'); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jw_pengajuan']); ?></td>
                </tr>
            <?php 
                endforeach;
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
