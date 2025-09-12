<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT']."/Database/koneksi.php");

if (!isset($id_riwayat)) {
    die("Parameter id_riwayat tidak ditemukan.");
}

$query = "SELECT data_keuangan.*, riwayat_kredit.*
          FROM data_keuangan
          INNER JOIN riwayat_kredit ON riwayat_kredit.id_riwayat = data_keuangan.id_riwayat
          WHERE riwayat_kredit.id_riwayat = ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $id_riwayat);
$stmt->execute();

$result = $stmt->get_result();
$options = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>
