<?php 
include("../Database/koneksi.php");
$query = "SELECT *,
                    TIMESTAMPDIFF(YEAR, data_pokok.tgl_lahir, CURDATE()) AS tahun_umur,
                    TIMESTAMPDIFF(MONTH, data_pokok.tgl_lahir, CURDATE()) % 12 AS bulan_umur,
                    TIMESTAMPDIFF(YEAR, tgl_pengangkatan, CURDATE()) AS tahun_kerja,
                    TIMESTAMPDIFF(MONTH, tgl_pengangkatan, CURDATE()) % 12 AS bulan_kerja  
                  FROM pekerjaan, data_pokok, cabang, users
                  WHERE data_pokok.id_pegawai=users.id_pegawai 
                  AND users.kode_cabang=cabang.kode_cabang
                  AND pekerjaan.no_ktp=data_pokok.no_ktp
                  AND data_pokok.no_ktp = '".$_GET['no_ktp']."'";
$result  = $mysqli->query($query);
$getPekerjaan = mysqli_fetch_all($result, MYSQLI_ASSOC);
$mysqli->close();
?>