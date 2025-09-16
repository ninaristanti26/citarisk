<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
  <div class="container-fluid">
    <div class="row">
      <div class="card mb-4 w-100">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
          <h5 class="mb-0 text-white">📋 Rekap Laporan Kredit Tahunan</h5>
        </div>
        <div class="card-body">

          <!-- Dropdown Pilih Jenis Laporan -->
          <div class="row mb-4">
  <!-- Jenis Laporan -->
  <div class="col-md-4 mb-3">
    <label for="laporanSelect"><strong>Jenis Laporan:</strong></label>
    <select class="form-control" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan --</option>
      <option value="laporan_kredit?id_pegawai=<?= $_SESSION['id_pegawai']; ?>">Laporan Kredit</option>
      <option value="laporan_kredit_harian?id_pegawai=<?= $_SESSION['id_pegawai']; ?>">Laporan Kredit Harian</option>
      <option value="laporan_kredit_bulanan?id_pegawai=<?= $_SESSION['id_pegawai']; ?>">Laporan Kredit Bulanan</option>
      <option value="laporan_kredit_tahunan?id_pegawai=<?= $_SESSION['id_pegawai']; ?>">Laporan Kredit Tahunan</option>
    </select>
  </div>

          <?php
            include(__DIR__ . '/../Database/koneksi.php');

            $id_pegawai = $_SESSION['id_pegawai'];

            // Ambil daftar tahun dari riwayat_kredit
            $tahunList = [];
            $result = $mysqli->query("SELECT DISTINCT YEAR(update_riwayat_kredit) AS tahun FROM riwayat_kredit ORDER BY tahun DESC");
            while ($row = $result->fetch_assoc()) {
              $tahunList[] = $row['tahun'];
            }

            $tahunTerpilih = isset($_GET['tahun']) ? $_GET['tahun'] : (count($tahunList) ? $tahunList[0] : '');
          ?>

          <div class="col-md-4 mb-3">
    <form method="GET" action="rekap_laporan_kredit_tahunan.php">
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

            <!-- Dropdown Rincian / Rekap -->
             <div class="col-md-4 mb-3">
    <label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
    <select class="form-control" id="rincianRekap" onchange="location = this.value;">
      <option disabled selected>-- Pilih --</option>
      <option value="rekap_laporan_kredit_tahunan?id_pegawai=<?= $id_pegawai; ?>&tahun=<?= urlencode($tahunTerpilih); ?>">Rekap Laporan Kredit</option>
      <option value="laporan_kredit_tahunan?id_pegawai=<?= $id_pegawai; ?>&tahun=<?= urlencode($tahunTerpilih); ?>">Rincian Laporan Kredit</option>
    </select>
  </div>
</div>

          <!-- Tabel Rekap -->
          <?php if (!empty($tahunTerpilih)): ?>
            <?php
              $query = "SELECT users.id_pegawai, users.nama,  
                          COUNT(riwayat_kredit.plafon_pengajuan) AS noa, 
                          SUM(riwayat_kredit.plafon_pengajuan) AS plafon_pengajuan
                        FROM riwayat_kredit
                        INNER JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp
                        INNER JOIN users ON users.id_pegawai = data_pokok.id_pegawai
                        WHERE users.id_pegawai = ?
                        AND YEAR(update_riwayat_kredit) = ?
                        GROUP BY users.id_pegawai, users.nama";

              if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $id_pegawai, $tahunTerpilih);
                $stmt->execute();
                $result = $stmt->get_result();
                $getRekapLaporanKredit = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
              } else {
                echo "<div class='alert alert-danger'>Query error: " . $mysqli->error . "</div>";
              }
            ?>

            <div class="table-responsive">
              <h5 class="mb-3"><strong>Rekap Data Kredit Tahun <?php echo $tahunTerpilih; ?></strong></h5>
              <table class="table table-bordered table-striped table-sm w-100">
                <tbody>
                  <?php if (!empty($getRekapLaporanKredit)): ?>
                    <?php foreach ($getRekapLaporanKredit as $dataLapKredit): ?>
                      <tr>
                        <th style="width: 30%;">ID</th>
                        <td style="width: 5%;" class="text-center">:</td>
                        <td><?php echo htmlspecialchars($dataLapKredit['id_pegawai']); ?></td>
                      </tr>
                      <tr>
                        <th>Nama Petugas Marketing</th>
                        <td class="text-center">:</td>
                        <td><?php echo htmlspecialchars($dataLapKredit['nama']); ?></td>
                      </tr>
                      <tr>
                        <th>NOA Debitur Yang Diajukan</th>
                        <td class="text-center">:</td>
                        <td><?php echo htmlspecialchars($dataLapKredit['noa']); ?></td>
                      </tr>
                      <tr>
                        <th>Jumlah Plafon Pengajuan</th>
                        <td class="text-center">:</td>
                        <td><?php echo number_format($dataLapKredit['plafon_pengajuan'], 0, ',', '.'); ?></td>
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
          <?php else: ?>
            <div class="alert alert-info mt-3" role="alert">
              Silakan pilih tahun terlebih dahulu untuk menampilkan rekap laporan.
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "other/footer.php"; ?>