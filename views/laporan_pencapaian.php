<?php 
include "other/header.php"; 
include("../Database/koneksi.php");

session_start();
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

$id_pegawai = $_SESSION['id_pegawai'] ?? null;
$tahun = $_GET['tahun'] ?? null;
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Pencapaian Kredit</h5>
            </div>
            <div class="card-body">

               <!-- Form Pilih Tahun -->
               <form method="GET" action="laporan_pencapaian" class="form-inline mb-3">
                  <input type="hidden" name="id_pegawai" value="<?php echo htmlspecialchars($id_pegawai); ?>">
                  <label class="mr-2"><strong>Tahun:</strong></label>
                  <select name="tahun" class="form-control mr-2" required>
                     <?php
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

               <?php if ($tahun): ?>
                  <p><strong>Periode:</strong> <?php echo htmlspecialchars($tahun); ?></p>

                  <?php
                  $getPencapaian = [];

                  if ($id_pegawai) {
                      $query = "SELECT pk.*, t.target, t.tahun_target 
                                FROM putusan_kredit pk
                                INNER JOIN target t ON pk.id_pegawai = t.id_pegawai
                                WHERE pk.id_pegawai = ?
                                AND YEAR(pk.putusan_created_at) = ?
                                AND t.tahun_target = ?";

                      if ($stmt = $mysqli->prepare($query)) {
                          $stmt->bind_param("iii", $id_pegawai, $tahun, $tahun);
                          $stmt->execute();
                          $result = $stmt->get_result();
                          $getPencapaian = $result->fetch_all(MYSQLI_ASSOC);
                          $stmt->close();
                      } else {
                          echo "<div class='text-danger'>Query error: " . $mysqli->error . "</div>";
                      }
                  }

                  if (!empty($getPencapaian)) {
                      $target = $getPencapaian[0]['target'];
                      $totalPlafon = 0;
                      foreach ($getPencapaian as $item) {
                          $totalPlafon += $item['plafon_kredit'];
                      }

                      $pencapaianNominal = $totalPlafon - $target;
                      $pencapaianPersen  = ($target > 0) ? ($totalPlafon / $target) * 100 : 0;

                      function formatRupiahNegatif($angka) {
                          if ($angka < 0) {
                              return '<span style="color:red;">(' . number_format(abs($angka), 0, ',', '.') . ')</span>';
                          } else {
                              return number_format($angka, 0, ',', '.');
                          }
                      }
                  ?>

                  <div class="table-responsive">
                     <table class="table table-hover table-sm">
                        <tbody>
                           <tr>
                              <td width="35%">ID Pegawai</td>
                              <td width="5%" class="text-center">:</td>
                              <td><?php echo htmlspecialchars($id_pegawai); ?></td>
                           </tr>
                           <tr>
                              <td>Target Kredit</td>
                              <td class="text-center">:</td>
                              <td><?php echo number_format($target, 0, ',', '.'); ?></td>
                           </tr>
                           <tr>
                              <td>Total Realisasi Kredit</td>
                              <td class="text-center">:</td>
                              <td><?php echo number_format($totalPlafon, 0, ',', '.'); ?></td>
                           </tr>
                           <tr>
                              <td>Selisih (Realisasi - Target)</td>
                              <td class="text-center">:</td>
                              <td><?php echo formatRupiahNegatif($pencapaianNominal); ?></td>
                           </tr>
                           <tr>
                              <td>Persentase Pencapaian</td>
                              <td class="text-center">:</td>
                              <td><?php echo number_format($pencapaianPersen, 2); ?>%</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>

                  <?php } else { ?>
                     <div class="alert alert-warning mt-3">Tidak ada data pencapaian kredit untuk tahun <?php echo htmlspecialchars($tahun); ?>.</div>
                  <?php } ?>

               <?php else: ?>
                  <div class="alert alert-info mt-3" role="alert">
                     Silakan pilih tahun terlebih dahulu untuk menampilkan laporan pencapaian kredit.
                  </div>
               <?php endif; ?>

            </div>
         </div>
      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>