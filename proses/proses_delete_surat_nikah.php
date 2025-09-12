<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . '/../Database/koneksi.php');

    $id_file_surat_nikah = $_POST['id_file_surat_nikah'] ?? null;
    $no_ktp              = $_POST['no_ktp'] ?? null;

    if (!$id_file_surat_nikah || 
        !$no_ktp) {
        header("Location: /detail?no_ktp=" . urlencode($no_ktp));
        exit();
    }

    $stmt = $mysqli->prepare("SELECT file_path_surat_nikah FROM file_surat_nikah WHERE id_file_surat_nikah = ?");
    $stmt->bind_param("i", $id_file_surat_nikah);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $file_path_surat_nikah = $row['file_path_surat_nikah'];

        if (file_exists($file_path_surat_nikah)) {
            unlink($file_path_surat_nikah);
        }

        $delStmt = $mysqli->prepare("DELETE FROM file_surat_nikah WHERE id_file_surat_nikah = ?");
        $delStmt->bind_param("i", $id_file_surat_nikah);
        $delStmt->execute();
    }

    $stmt->close();
    $mysqli->close();

    // Redirect kembali ke halaman detail
    header("Location: /detail?no_ktp=" . urlencode($no_ktp));
    exit();
}
?>
