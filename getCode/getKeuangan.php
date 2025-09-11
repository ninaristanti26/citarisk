<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT data_keuangan.*, riwayat_kredit.*  
                  FROM data_keuangan
                  INNER JOIN riwayat_kredit ON riwayat_kredit.id_riwayat = data_keuangan.id_riwayat
                  WHERE riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$options = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>