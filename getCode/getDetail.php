<?php 
include("../Database/koneksi.php");
$query = "SELECT *,
                  TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) AS tahun,
                        TIMESTAMPDIFF(MONTH, tgl_lahir, CURDATE()) % 12 AS bulan 
                  FROM data_pokok, cabang, users
                  WHERE data_pokok.id_pegawai=users.id_pegawai
                  AND cabang.kode_cabang=users.kode_cabang 
          AND data_pokok.no_ktp = '".$_GET['no_ktp']."'";
$result  = $mysqli->query($query);
$getDetail = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>