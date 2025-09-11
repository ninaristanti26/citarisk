<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * 
                  FROM riwayat_kredit, kemampuan
                  WHERE riwayat_kredit.id_riwayat=kemampuan.id_riwayat 
                  AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$getKemampuan = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>