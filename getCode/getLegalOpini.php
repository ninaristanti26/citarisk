<?php 
include("../Database/koneksi.php");
$query = "SELECT * 
                  FROM legal_opini, riwayat_kredit
                  WHERE riwayat_kredit.id_riwayat=legal_opini.id_riwayat 
                  AND riwayat_kredit.id_riwayat = '".$_GET['id_riwayat']."'";
$result  = $mysqli->query($query);
$getLegalOpini = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>