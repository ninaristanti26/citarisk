<?php 
include(__DIR__ . '/../Database/koneksi.php');

$getFile = [];

if (isset($_GET['no_ktp'])) {
    $no_ktp = $_GET['no_ktp'];

    $query = "SELECT file.id_file, file.file_name, file.file_path 
              FROM file, data_pokok
              WHERE file.no_ktp=data_pokok.no_ktp
              AND file.no_ktp = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $no_ktp);
        $stmt->execute();
        $result = $stmt->get_result();
        $getFile = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    $mysqli->close();
}
?>
