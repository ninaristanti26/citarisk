<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Harian</h5>
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
</div>
<div class="form-row mb-6">
   <div class="form-group col-md-6">
      <form method="GET" action="laporan_kredit_harian.php" class="form-inline">
         <input type="hidden" name="id_pegawai" value="<?php echo $_SESSION['id_pegawai']; ?>">
         <label class="mr-2" for="tanggal"><strong>Pilih Tanggal:</strong></label>
         <input type="date" class="form-control mr-2" name="tanggal" id="tanggal"
            value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>" required>
         <button type="submit" class="btn btn-dark">Tampilkan</button>
      </form>
   </div>

   <div class="form-group col-md-6">
      <?php
      $tanggal_terpilih = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
      $id_pegawai = $_SESSION['id_pegawai'];
      ?>
      <label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
      <select class="form-control" id="rincianRekap" onchange="location = this.value;">
         <option disabled selected>-- Pilih --</option>
         <option value="rekap_laporan_kredit_harian?id_pegawai=<?php echo $id_pegawai; ?>&tanggal=<?php echo urlencode($tanggal_terpilih); ?>">Rekap Laporan Kredit</option>
         <option value="laporan_kredit_harian?id_pegawai=<?php echo $id_pegawai; ?>&tanggal=<?php echo urlencode($tanggal_terpilih); ?>">Rincian Laporan Kredit</option>
      </select>
   </div>
</div>

<?php if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])): ?>
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
            <th scope="col">Jangka Waktu (bulan)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include("../Database/koneksi.php");
        $id_pegawai = $_SESSION['id_pegawai'];
        $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

        $query = "SELECT * FROM riwayat_kredit 
                  INNER JOIN data_pokok ON riwayat_kredit.id_pegawai = data_pokok.id_pegawai
                  WHERE riwayat_kredit.id_pegawai = ? 
                  AND DATE(riwayat_kredit.update_riwayat_kredit) = ?";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $id_pegawai, $tanggal);
            $stmt->execute();
            $result = $stmt->get_result();
            $getLaporanKredit = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            echo "<tr><td colspan='8' class='text-center'>Query error: " . $mysqli->error . "</td></tr>";
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
<?php else: ?>
   <div class="alert alert-info mt-3" role="alert">
      Silakan pilih tanggal terlebih dahulu untuk menampilkan laporan kredit harian.
   </div>
<?php endif; ?>
</div>
</div>
</div>
</div>
        </div>
<?php include "other/footer.php"; ?>