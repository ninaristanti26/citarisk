<?php 
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$getFileSK = [];

if (isset($_GET['no_ktp']) && isset($_GET['id_riwayat'])) {
    $no_ktp     = $_GET['no_ktp'];
    $id_riwayat = $_GET['id_riwayat'];

    $query = "SELECT *
              FROM file_sk, data_pokok, riwayat_kredit
              WHERE file_sk.no_ktp=data_pokok.no_ktp
              AND file_sk.id_riwayat=riwayat_kredit.id_riwayat
              AND file_sk.no_ktp = ?
              AND file_sk.id_riwayat = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ss", $no_ktp, $id_riwayat);
        $stmt->execute();
        $result = $stmt->get_result();
        $getFileSK = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    $mysqli->close();
}
?>