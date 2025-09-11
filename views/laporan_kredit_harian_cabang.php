<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Harian <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>
<div class="card-body">
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
<!-- Form Pilih Tanggal -->
<form method="GET" action="laporan_kredit_harian_cabang.php" class="form-inline mb-3">
   <input type="hidden" name="kode_cabang" value="<?php echo $_SESSION['kode_cabang']; ?>">
   <label class="mr-2" for="tanggal"><strong>Pilih Tanggal:</strong></label>
   <input type="date" class="form-control mr-2" name="tanggal" id="tanggal"
      value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : null; ?>" required>
   <button type="submit" class="btn btn-dark">Tampilkan</button>
</form>

<!-- Tabel Laporan -->
 <?php if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])): ?>
<div class="table-responsive">
   <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 100%;">
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
        $kode_cabang = $_SESSION['kode_cabang'];
        $tanggal     = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

        $query = "SELECT * FROM riwayat_kredit 
                  INNER JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp
                  INNER JOIN cabang ON riwayat_kredit.kode_cabang = cabang.kode_cabang
                  WHERE riwayat_kredit.kode_cabang = ? 
                  AND DATE(riwayat_kredit.update_riwayat_kredit) = ?";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $kode_cabang, $tanggal);
            $stmt->execute();
            $result = $stmt->get_result();
            $getLaporanKreditCabang = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            echo "<tr><td colspan='8' class='text-center'>Query error: " . $mysqli->error . "</td></tr>";
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
