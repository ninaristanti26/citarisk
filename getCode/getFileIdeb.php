<?php 
include("../Database/koneksi.php");

$getFileIdeb = [];

if(isset($_GET['no_ktp']) && isset($_GET['id_riwayat'])) {
    $no_ktp     = $_GET['no_ktp'];
    $id_riwayat = $_GET['id_riwayat'];

    $query = "SELECT file_deb.file_name_ideb, file_deb.file_path_ideb 
              FROM file_deb
              JOIN data_pokok ON file_deb.no_ktp = data_pokok.no_ktp
              WHERE file_deb.no_ktp = ?
              AND file_deb.id_riwayat = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ss", $no_ktp, $id_riwayat);
        $stmt->execute();
        $result = $stmt->get_result();
        $getFileIdeb = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
    $mysqli->close();
}
?>
