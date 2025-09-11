<?php 
include "other/header.php"; 
include("../Database/koneksi.php"); 
$tahun = $_GET['tahun'] ?? null;
?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Pencapaian Kredit <?php echo $_SESSION['kode_cabang']; ?> By Petugas Marketing</h5>
            </div>
            <div class="card-body">

<?php if (isset($_SESSION['id_role']) && in_array($_SESSION['id_role'], [10, 11])): ?>
<div class="form-group">
   <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
   <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan Pencapaian --</option>
      <option value="laporan_pencapaian_cabang?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan Pencapaian Cabang</option>
      <option value="laporan_pencapaian_ao?kode_cabang=<?php echo $_SESSION['kode_cabang']; ?>">Laporan pencapaian Petugas Marketing</option>
   </select>
</div>
<?php endif; ?>

<form method="GET" action="laporan_pencapaian_ao" class="form-inline mb-3">
   <input type="hidden" name="kode_cabang" value="<?php echo $_SESSION['kode_cabang']; ?>">
   <label class="mr-2"><strong>Tahun:</strong></label>
   <select name="tahun" class="form-control mr-2" required>
      <?php
         $query = "SELECT DISTINCT YEAR(putusan_created_at) AS tahun FROM putusan_kredit ORDER BY tahun DESC";
         $result = mysqli_query($mysqli, $query);
         while ($row = mysqli_fetch_assoc($result)) {
            $y = $row['tahun'];
            $selected = ($y == $tahun) ? 'selected' : '';
            echo "<option value='$y' $selected>$y</option>";
         }
      ?>
   </select>
   <button type="submit" class="btn btn-dark">Tampilkan</button>
</form>

<p><strong>Periode:</strong> <?php echo $tahun; ?></p>

<?php
$kode_cabang = $_SESSION['kode_cabang'] ?? null;
$totalTarget = 0;
$totalPlafon = 0;
$dataMarketing = [];

if ($kode_cabang && $tahun) {
$queryTarget = "SELECT target FROM target WHERE kode_cabang = ? AND tahun_target = ?";
    if ($stmt1 = $mysqli->prepare($queryTarget)) {
        $stmt1->bind_param("si", $kode_cabang, $tahun);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($row1 = $result1->fetch_assoc()) {
            $totalTarget = $row1['target'] ?? 0;
        }
        $stmt1->close();
    }

    $queryPlafon = "SELECT tg.id_pegawai,
                       tg.target,
                       COALESCE(p.total_plafon, 0) AS total_plafon,
                       u.nama
                FROM target tg
                LEFT JOIN users u ON TRIM(tg.id_pegawai) = TRIM(u.id_pegawai)
                LEFT JOIN (
                    SELECT rk.id_pegawai, SUM(pk.plafon_kredit) AS total_plafon
                    FROM riwayat_kredit rk
                    JOIN putusan_kredit pk ON rk.id_riwayat = pk.id_riwayat
                    WHERE YEAR(pk.putusan_created_at) = ?
                    AND rk.kode_cabang = ?
                    GROUP BY rk.id_pegawai
                ) p ON p.id_pegawai = tg.id_pegawai
                WHERE tg.tahun_target = ?
                AND tg.kode_cabang = ?
                ORDER BY u.nama";

if ($stmt2 = $mysqli->prepare($queryPlafon)) {
    $stmt2->bind_param("siss", $tahun, $kode_cabang, $tahun, $kode_cabang);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $dataMarketing = $result2->fetch_all(MYSQLI_ASSOC);
    $stmt2->close();
}
    
    foreach ($dataMarketing as $dm) {
        $totalPlafon += $dm['total_plafon'];
        if (empty($dm['nama'])) continue;
    }
    
    $selisih = $totalPlafon - $totalTarget;
    $persentase = ($totalTarget > 0) ? ($totalPlafon / $totalTarget) * 100 : 0;

    function formatRupiahNegatif($angka) {
        if ($angka < 0) {
            return '<span style="color:red;">(' . number_format(abs($angka), 0, ',', '.') . ')</span>';
        } else {
            return number_format($angka, 0, ',', '.');
        }
    }}
    //echo '<pre>'; print_r($dataMarketing); echo '</pre>';
?>

<?php if ($tahun): ?>
    <?php if (!empty($dataMarketing)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-sm" style="width: 100%;">
                <thead class="table-dark text-center">
                    <tr class="text-center">
                        <th>No.</th>
                        <th>ID Marketing</th>
                        <th>Nama Petugas Marketing</th>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th>Kekurangan/Kelebihan</th>
                        <th>% Pencapaian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($dataMarketing as $dm): ?>
                        <?php
                            $selisih = $dm['total_plafon'] - $dm['target'];
                            $persentase = ($dm['target'] > 0) ? ($dm['total_plafon'] / $dm['target']) * 100 : 0;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($dm['id_pegawai']); ?></td>
                            <td><?php echo htmlspecialchars($dm['nama']); ?></td>
                            <td class="text-right"><?php echo number_format($dm['target'], 0, ',', '.'); ?></td>
                            <td class="text-right"><?php echo number_format($dm['total_plafon'], 0, ',', '.'); ?></td>
                            <td class="text-right"><?php echo formatRupiahNegatif($selisih); ?></td>
                            <td class="text-right"><?php echo number_format($persentase, 2); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-3">Tidak ada data pencapaian kredit untuk tahun <?php echo $tahun; ?>.</div>
    <?php endif; ?>
<?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include "other/footer.php"; ?>
