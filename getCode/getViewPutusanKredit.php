<?php 
include(__DIR__ . '/../Database/koneksi.php');

$no_ktp     = $_GET['no_ktp'];
$id_riwayat = $_GET['id_riwayat'];

$query = "SELECT * 
          FROM putusan_kredit 
          JOIN riwayat_kredit ON putusan_kredit.id_riwayat = riwayat_kredit.id_riwayat 
          JOIN data_pokok ON riwayat_kredit.no_ktp = data_pokok.no_ktp AND putusan_kredit.no_ktp = data_pokok.no_ktp
          JOIN users ON users.id_pegawai = data_pokok.id_pegawai AND users.id_pegawai = riwayat_kredit.id_pegawai 
                AND users.id_pegawai = putusan_kredit.id_pegawai
          WHERE putusan_kredit.no_ktp = ? AND riwayat_kredit.id_riwayat = ?
          GROUP BY riwayat_kredit.id_riwayat";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $no_ktp, $id_riwayat);
$stmt->execute();

$result = $stmt->get_result();
$getPutusan_kredit = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>
