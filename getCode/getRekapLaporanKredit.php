<?php 
include(__DIR__ . '/../Database/koneksi.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($mysqli->connect_error) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

if (!isset($_SESSION['id_pegawai'])) {
    die("ID Pegawai tidak ditemukan di sesi.");
}

$id_pegawai = $_SESSION['id_pegawai'];

$query = "
    SELECT users.id_pegawai, users.nama,  
           COUNT(riwayat_kredit.plafon_pengajuan) AS noa, 
           SUM(riwayat_kredit.plafon_pengajuan) AS plafon_pengajuan
    FROM riwayat_kredit, data_pokok, users
    WHERE users.id_pegawai = data_pokok.id_pegawai
      AND riwayat_kredit.no_ktp = data_pokok.no_ktp
      AND users.id_pegawai = ?
      GROUP BY users.id_pegawai, users.nama
";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $id_pegawai);
    $stmt->execute();
    $result = $stmt->get_result();
    $getRekapLaporanKredit = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Query error: " . $mysqli->error);
}

$mysqli->close();
?>