<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT']."/Database/koneksi.php");

if (!isset($no_ktp)) {
    die("Parameter no_ktp tidak ditemukan.");
}

$stmt = $mysqli->prepare("SELECT *, 
    TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) AS tahun,
    TIMESTAMPDIFF(MONTH, tgl_lahir, CURDATE()) % 12 AS bulan 
    FROM data_pokok 
    JOIN users ON data_pokok.id_pegawai = users.id_pegawai 
    JOIN cabang ON cabang.kode_cabang = users.kode_cabang 
    WHERE data_pokok.no_ktp = ?");

$stmt->bind_param("s", $no_ktp);
$stmt->execute();
$result = $stmt->get_result();
$getDetail = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$mysqli->close();

?>