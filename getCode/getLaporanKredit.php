<?php 
include(__DIR__ . '/../Database/koneksi.php');


// Cek apakah sesi tersedia
if (!isset($_SESSION['id_pegawai'])) {
    die("ID Pegawai tidak ditemukan di sesi.");
}

$id_pegawai = $_SESSION['id_pegawai'];

// Siapkan statement dengan INNER JOIN
$query = "SELECT *
          FROM riwayat_kredit 
          INNER JOIN data_pokok ON riwayat_kredit.id_pegawai = data_pokok.id_pegawai AND riwayat_kredit.no_ktp = data_pokok.no_ktp
          INNER JOIN users ON riwayat_kredit.id_pegawai = users.id_pegawai
          WHERE data_pokok.id_pegawai = ?";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $id_pegawai); // s = string
    $stmt->execute();
    $result = $stmt->get_result();
    $getLaporanKredit = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Query error: " . $mysqli->error);
}

$mysqli->close();
?>
