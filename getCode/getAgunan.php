<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * 
                  FROM riwayat_kredit, agunan_konsumtif
                  WHERE riwayat_kredit.id_riwayat=agunan_konsumtif.id_riwayat  
                  AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$getAgunan = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>