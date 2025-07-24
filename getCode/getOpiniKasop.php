<?php 
include("../Database/koneksi.php");

$id_riwayat = isset($_GET['id_riwayat']) ? $_GET['id_riwayat'] : '';

if (!$id_riwayat) {
    die("ID riwayat tidak ditemukan.");
}

$stmt = $mysqli->prepare("
    SELECT opini_kasop.*, 
           riwayat_kredit.*, 
           data_pokok.*
    FROM opini_kasop
    INNER JOIN riwayat_kredit ON riwayat_kredit.id_riwayat = opini_kasop.id_riwayat
    INNER JOIN data_pokok ON data_pokok.no_ktp = opini_kasop.no_ktp
    WHERE riwayat_kredit.id_riwayat = ?
");

if (!$stmt) {
    die("Query prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $id_riwayat);
$stmt->execute();

$result = $stmt->get_result();
$getOpiniKasop = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>
