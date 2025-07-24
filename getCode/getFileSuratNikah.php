<?php 
include("../Database/koneksi.php");

$getFileSuratNikah = [];

if (isset($_GET['no_ktp'])) {
    $no_ktp = $_GET['no_ktp'];

    $query = "SELECT file_surat_nikah.file_name_surat_nikah, file_surat_nikah.file_path_surat_nikah 
              FROM file_surat_nikah, data_pokok
              WHERE file_surat_nikah.no_ktp=data_pokok.no_ktp
              AND file_surat_nikah.no_ktp = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $no_ktp);
        $stmt->execute();
        $result = $stmt->get_result();
        $getFileSuratNikah = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
    $mysqli->close();
}
?>
