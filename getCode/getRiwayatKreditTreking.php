<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * 
          FROM riwayat_kredit, data_pokok
          WHERE riwayat_kredit.no_ktp=data_pokok.no_ktp
          AND data_pokok.no_ktp = '".$_GET['no_ktp']."'
          AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$getRiwayat_kredit_treking = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>