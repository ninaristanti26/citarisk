<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT *,
                        TIMESTAMPDIFF(YEAR, tgl_lahir_pasangan, CURDATE()) AS tahun,
                        TIMESTAMPDIFF(MONTH, tgl_lahir_pasangan, CURDATE()) % 12 AS bulan 
                  FROM status_kawin, data_pokok
                  WHERE data_pokok.no_ktp=status_kawin.no_ktp
                  AND data_pokok.no_ktp = '".$_GET['no_ktp']."'
          ";
$result  = $mysqli->query($query);
$options = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>