<?php 
session_start();
include "other/header.php";
include(__DIR__ . '/../Database/koneksi.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek session
$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

// Fungsi dengan kolom status dan nilai dinamis
function getApprovedRekap($mysqli, $table, $statusColumn, $statusValue, $id_pegawai) {
    $sql = "
        SELECT 
            COUNT(*) AS noa_approved,
            SUM(riwayat_kredit.plafon_pengajuan) AS total_plafon
        FROM users
        JOIN data_pokok ON users.id_pegawai COLLATE utf8mb4_unicode_ci = data_pokok.id_pegawai COLLATE utf8mb4_unicode_ci
        JOIN riwayat_kredit ON data_pokok.no_ktp COLLATE utf8mb4_unicode_ci = riwayat_kredit.no_ktp COLLATE utf8mb4_unicode_ci
        JOIN $table ON 
            $table.no_ktp COLLATE utf8mb4_unicode_ci = data_pokok.no_ktp COLLATE utf8mb4_unicode_ci AND 
            $table.id_riwayat = riwayat_kredit.id_riwayat AND
            $table.id_pegawai COLLATE utf8mb4_unicode_ci = users.id_pegawai COLLATE utf8mb4_unicode_ci
        WHERE users.id_pegawai COLLATE utf8mb4_unicode_ci = ?
        AND $table.$statusColumn = ?
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Query Error: " . $mysqli->error);
    }

    $stmt->bind_param("ss", $id_pegawai, $statusValue);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); 
    $stmt->close();

    return $data;
}

// Panggil dengan status yang sesuai di tiap tabel
$rekapKaspem = getApprovedRekap($mysqli, "putusan_kaspem", "status_putusan_kaspem", "Approved", $id_pegawai);
$rekapKabag  = getApprovedRekap($mysqli, "putusan_kabag",  "status_putusan_kabag",  "Approved oleh Kadiv. Pemasaran", $id_pegawai);
$rekapKadiv  = getApprovedRekap($mysqli, "putusan_kadiv",  "status_kadiv",  "Kredit Disetujui Oleh Dirut", $id_pegawai);

$mysqli->close();
?>

<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Laporan Kredit Approved</h5>
            </div>
<div class="card-body">
<div class="form-row mb-3">
<div class="form-group col-md-6">
   <label for="laporanSelect"><strong>Pilih Jenis Laporan:</strong></label>
   <select class="form-control w-50" id="laporanSelect" onchange="location = this.value;">
      <option disabled selected>-- Pilih Laporan --</option>
      <option value="laporan_kredit_approved?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved</option>
      <option value="laporan_kredit_approved_harian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Harian</option>
      <option value="laporan_kredit_approved_bulanan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Bulanan</option>
      <option value="laporan_kredit_approved_tahunan?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Laporan Kredit Approved Tahunan</option>
   </select>
</div>
<div class="form-group col-md-6">
    <label for="rincianRekap"><strong>Rincian / Rekap:</strong></label>
      <select class="form-control" id="rincianRekap" onchange="location = this.value;">
         <option disabled selected>-- Pilih --</option>
         <option value="rekap_laporan_kreditApp?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Rekap Laporan Kredit Approved</option>
         <option value="laporan_kredit_approved?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>">Rincian Laporan Kredit Approved</option>
      </select>
   </div>
</div>
<!-- Tampilkan hasil -->
<div class="table-responsive mt-4">
  <h5><strong>📊 Rekap Kredit Approved</strong></h5>
  <table class="table table-striped table-bordered table-sm" id="dataTables-example">
    <thead class="table-light text-center">
      <tr class="text-center">
        <tr>
            <th scope="col">Approved By.</th>
            <th scope="col">NOA Approved</th>
            <th scope="col">Plafon Approved</th>
        </tr>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Pimpinan Cabang</td>
        <td class="text-center"><?php echo $rekapKaspem['noa_approved'] ?? 0; ?></td>
        <td class="text-right">Rp <?php echo number_format($rekapKaspem['total_plafon'] ?? 0, 0, ',', '.'); ?></td>
      </tr>
      <tr>
        <td>Kepala Divisi Pemasaran</td>
        <td class="text-center"><?php echo $rekapKabag['noa_approved'] ?? 0; ?></td>
        <td class="text-right">Rp <?php echo number_format($rekapKabag['total_plafon'] ?? 0, 0, ',', '.'); ?></td>
      </tr>
      <tr>
        <td>Direktur Utama</td>
        <td class="text-center"><?php echo $rekapKadiv['noa_approved'] ?? 0; ?></td>
        <td class="text-right">Rp <?php echo number_format($rekapKadiv['total_plafon'] ?? 0, 0, ',', '.'); ?></td>
      </tr>
    </tbody>
  </table>
</div>