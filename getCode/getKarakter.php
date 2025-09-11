<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * 
                  FROM riwayat_kredit, karakter, data_pokok
                  WHERE riwayat_kredit.id_riwayat=karakter.id_riwayat
                  AND data_pokok.no_ktp=karakter.no_ktp 
                  AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'
                  AND data_pokok.no_ktp = '".$_GET['no_ktp']."'";
$result  = $mysqli->query($query);
$getKarakter = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>