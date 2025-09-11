<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * 
                  FROM dokumentasi, riwayat_kredit, data_pokok
                  WHERE data_pokok.no_ktp=dokumentasi.no_ktp 
                  AND riwayat_kredit.id_riwayat=dokumentasi.id_riwayat 
                  AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$getLegal = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>