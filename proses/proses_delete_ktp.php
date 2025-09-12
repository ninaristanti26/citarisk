<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include(__DIR__ . '/../Database/koneksi.php');

    $file_id = $_POST['id_file'] ?? null;
    $no_ktp  = $_POST['no_ktp'] ?? null;

    if (!$file_id || !$no_ktp) {
        header("Location: /detail?no_ktp=" . urlencode($no_ktp));
        exit();
    }

    $stmt = $mysqli->prepare("SELECT file_path FROM file WHERE id_file = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $delStmt = $mysqli->prepare("DELETE FROM file WHERE id_file = ?");
        $delStmt->bind_param("i", $file_id);
        $delStmt->execute();
    }

    $stmt->close();
    $mysqli->close();

    // Redirect kembali ke halaman detail
    header("Location: /detail?no_ktp=" . urlencode($no_ktp));
    exit();
}
?>
