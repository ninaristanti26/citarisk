<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * FROM info_lain, data_pokok
          WHERE info_lain.no_ktp=data_pokok.no_ktp
          AND data_pokok.no_ktp = '".$_GET['no_ktp']."'";
$result  = $mysqli->query($query);
$options = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>