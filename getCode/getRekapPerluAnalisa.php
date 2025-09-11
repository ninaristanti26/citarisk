<?php 
include("../Database/koneksi.php");
$kode_cabang = $_SESSION['kode_cabang'];

$query = "SELECT dp.*, rk.*
          FROM data_pokok dp
          JOIN riwayat_kredit rk ON rk.no_ktp = dp.no_ktp
          WHERE rk.id_riwayat NOT IN (SELECT id_riwayat FROM putusan_analis)
          AND rk.kode_cabang = ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $kode_cabang);
$stmt->execute();
$result = $stmt->get_result();
$getRekapPerluAnalisa = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
