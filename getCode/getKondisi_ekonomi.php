<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * 
                  FROM riwayat_kredit, kondisi_ekonomi
                  WHERE riwayat_kredit.id_riwayat=kondisi_ekonomi.id_riwayat 
                  AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$getKondisi_ekonomi = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>