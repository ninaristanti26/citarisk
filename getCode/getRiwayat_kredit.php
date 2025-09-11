<?php 
include(__DIR__ . '/../Database/koneksi.php');
$no_ktp = $_GET['no_ktp'];
$query = "SELECT riwayat_kredit.*, data_pokok.nama_debitur
          FROM riwayat_kredit
          JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp
          WHERE data_pokok.no_ktp = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $no_ktp);
$stmt->execute();
$result = $stmt->get_result();
$getRiwayat_kredit = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>