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
               <h5 class="mb-0 text-white">📋 Laporan Pencapaian Kredit <?php echo $_SESSION['kode_cabang']; ?></h5>
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
               <form method="GET" action="laporan_pencapaian_cabang" class="form-inline mb-3">
                  <input type="hidden" name="kode_cabang" value="<?php echo $_SESSION['kode_cabang']; ?>">
                  <label class="mr-2"><strong>Tahun:</strong></label>
                  <select name="tahun" class="form-control mr-2" required>
                     <?php
                        include("../Database/koneksi.php");
                        $query = "SELECT DISTINCT YEAR(putusan_created_at) AS tahun 
                                  FROM putusan_kredit 
                                  ORDER BY tahun DESC";
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

if ($kode_cabang && $tahun) {

    $queryTarget = "SELECT SUM(target) AS total_target FROM target WHERE kode_cabang = ? AND tahun_target = ?";
    if ($stmt1 = $mysqli->prepare($queryTarget)) {
        $stmt1->bind_param("si", $kode_cabang, $tahun);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row1 = $result1->fetch_assoc();
        $totalTarget = $row1['total_target'] ?? 0;
        $stmt1->close();
    }

    $queryPlafon = "SELECT SUM(pk.plafon_kredit) AS total_plafon
                    FROM putusan_kredit pk
                    JOIN riwayat_kredit rk ON pk.id_riwayat = rk.id_riwayat
                    WHERE rk.kode_cabang = ? AND YEAR(pk.putusan_created_at) = ?";
    if ($stmt2 = $mysqli->prepare($queryPlafon)) {
        $stmt2->bind_param("si", $kode_cabang, $tahun);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $row2 = $result2->fetch_assoc();
        $totalPlafon = $row2['total_plafon'] ?? 0;
        $stmt2->close();
    }

    $selisih = $totalPlafon - $totalTarget;
    $persentase = ($totalTarget > 0) ? ($totalPlafon / $totalTarget) * 100 : 0;

    function formatRupiahNegatif($angka) {
        if ($angka < 0) {
            return '<span style="color:red;">(' . number_format(abs($angka), 0, ',', '.') . ')</span>';
        } else {
            return number_format($angka, 0, ',', '.');
        }
    }
}
?>
<?php if ($tahun): ?>
    <?php if ($totalTarget > 0 || $totalPlafon > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm" style="width: 100%;">
                <tbody>
                    <tr>
                        <td class="text-left" width="35%">Kode Cabang</td>
                        <td class="text-center" width="5%">:</td>
                        <td class="text-left"><?php echo htmlspecialchars($kode_cabang); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">Total Target Kredit Cabang</td>
                        <td class="text-center">:</td>
                        <td class="text-left"><?php echo number_format($totalTarget, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">Total Realisasi Kredit Cabang</td>
                        <td class="text-center">:</td>
                        <td class="text-left"><?php echo number_format($totalPlafon, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">Kekurangan/Kelebihan</td>
                        <td class="text-center">:</td>
                        <td class="text-left"><?php echo formatRupiahNegatif($selisih); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">Persentase Pencapaian</td>
                        <td class="text-center">:</td>
                        <td class="text-left"><?php echo number_format($persentase, 2); ?>%</td>
                    </tr>
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
