<?php 
include(__DIR__ . '/../Database/koneksi.php');

if (!isset($_SESSION['kode_cabang'])) {
    die("Unit Kerja tidak ditemukan di sesi.");
}

$kode_cabang = $_SESSION['kode_cabang'];

$query = "SELECT *
          FROM riwayat_kredit 
          INNER JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp
          INNER JOIN cabang ON riwayat_kredit.kode_cabang = cabang.kode_cabang
          WHERE riwayat_kredit.kode_cabang = ?";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $kode_cabang); // s = string
    $stmt->execute();
    $result = $stmt->get_result();
    $getLaporanKreditCabang = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Query error: " . $mysqli->error);
}

$mysqli->close();
?>
