<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
  <div class="container-fluid">
    <div class="row">
      <div class="card mb-4 w-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark">
          <h5 class="mb-0 text-white">📅 Laporan Kredit Tahunan</h5>
        </div>
        <div class="card-body">

          <?php
  include(__DIR__ . '/../Database/koneksi.php');
  $id_pegawai = $_SESSION['id_pegawai'];

  // Ambil daftar tahun
  $tahunList = [];
  $sqlTahun = "SELECT DISTINCT YEAR(update_riwayat_kredit) AS tahun 
               FROM riwayat_kredit 
               WHERE id_pegawai = ? 
               ORDER BY tahun DESC";
  if ($stmtTahun = $mysqli->prepare($sqlTahun)) {
      $stmtTahun->bind_param("s", $id_pegawai);
      $stmtTahun->execute();
      $resultTahun = $stmtTahun->get_result();
      while ($row = $resultTahun->fetch_assoc()) {
          $tahunList[] = $row['tahun'];
      }
      $stmtTahun->close();
  }

  $tahunTerpilih = $_GET['tahun'] ?? (count($tahunList) ? $tahunList[0] : '');
?>
          
          <div class="row mb-4">
  <!-- Jenis Laporan -->
  <div class="col-md-4 mb-3">
    <label for="laporanSelect"><strong>Jenis Laporan:</strong></label>
    <select class="form-control" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan --</option>
      <option value="laporan_kredit?id_pegawai=<?= $id_pegawai; ?>">Laporan Kredit</option>
      <option value="laporan_kredit_harian?id_pegawai=<?= $id_pegawai; ?>">Laporan Kredit Harian</option>
      <option value="laporan_kredit_bulanan?id_pegawai=<?= $id_pegawai; ?>">Laporan Kredit Bulanan</option>
      <option value="laporan_kredit_tahunan?id_pegawai=<?= $id_pegawai; ?>">Laporan Kredit Tahunan</option>
    </select>
  </div>

          <div class="col-md-4 mb-3">
    <form method="GET" action="laporan_kredit_tahunan.php">
      <input type="hidden" name="id_pegawai" value="<?= $id_pegawai; ?>">
      <label for="tahun"><strong>Pilih Tahun:</strong></label>
      <select name="tahun" id="tahun" class="form-control" onchange="this.form.submit()" required>
        <option disabled selected>-- Pilih Tahun --</option>
        <?php foreach ($tahunList as $tahun): ?>
          <option value="<?= $tahun; ?>" <?= ($tahun == $tahunTerpilih ? 'selected' : ''); ?>>
            <?= $tahun; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
  </div>

           <div class="col-md-4 mb-3">
    <label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
    <select class="form-control" id="rincianRekap" onchange="location = this.value;">
      <option disabled selected>-- Pilih --</option>
      <option value="rekap_laporan_kredit_tahunan?id_pegawai=<?= $id_pegawai; ?>&tahun=<?= urlencode($tahunTerpilih); ?>">Rekap Laporan Kredit</option>
      <option value="laporan_kredit_tahunan?id_pegawai=<?= $id_pegawai; ?>&tahun=<?= urlencode($tahunTerpilih); ?>">Rincian Laporan Kredit</option>
    </select>
  </div>
</div>
          
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 100%;">
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
                if (!empty($tahunTerpilih)) {
                    $query = "SELECT riwayat_kredit.*, data_pokok.nama_debitur, data_pokok.alamat 
                              FROM riwayat_kredit
                              INNER JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp
                              WHERE riwayat_kredit.id_pegawai = ? 
                              AND YEAR(riwayat_kredit.update_riwayat_kredit) = ?";
                    if ($stmt = $mysqli->prepare($query)) {
                        $stmt->bind_param("si", $id_pegawai, $tahunTerpilih);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result) {
                            $getLaporanKredit = $result->fetch_all(MYSQLI_ASSOC);
                        }
                        $stmt->close();
                    } else {
                        echo "<tr><td colspan='8' class='text-center text-danger'>Query error: " . $mysqli->error . "</td></tr>";
                    }
                }
                if (!empty($getLaporanKredit)):
                    $no = 1;
                    foreach ($getLaporanKredit as $dataLapKredit):
                ?>
                  <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['update_riwayat_kredit']); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['id_pegawai']); ?></td>
                    <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['nama_debitur']); ?></td>
                    <td class="text-left"><?php echo htmlspecialchars($dataLapKredit['alamat']); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jenis_kredit']); ?></td>
                    <td class="text-center"><?php echo number_format($dataLapKredit['plafon_pengajuan'], 0, ',', '.'); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataLapKredit['jw_pengajuan']); ?></td>
                  </tr>
                <?php
                    endforeach;
                else:
                ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted">Data tidak ditemukan untuk tahun tersebut.</td>
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