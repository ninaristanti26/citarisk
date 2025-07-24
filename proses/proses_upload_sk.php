<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $no_ktp       = $_POST['no_ktp'] ?? '';
    $id_riwayat   = $_POST['id_riwayat'] ?? '';
    $jenis_agunan = $_POST['jenis_agunan'] ?? '';
    $no_agunan    = $_POST['no_agunan'] ?? '';
    $tgl_agunan   = $_POST['tgl_agunan'] ?? '';

    $targetDir = "../uploads/";
    $originalName = basename($_FILES["pdf_agunan"]["name"]);
    $fileNameAgunan = uniqid('agunan_', true) . "_" . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $originalName);
    $targetFileAgunan = $targetDir . $fileNameAgunan;
    $fileType = strtolower(pathinfo($targetFileAgunan, PATHINFO_EXTENSION));

    // Validasi file
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["pdf_agunan"]["tmp_name"]);
    finfo_close($finfo);

    if ($mime !== 'application/pdf' || $fileType !== "pdf") {
        echo "<script>alert('Hanya file PDF yang valid diperbolehkan.'); window.history.back();</script>";
        exit;
    }

    if ($_FILES["pdf_agunan"]["size"] > 5 * 1024 * 1024) {
        echo "<script>alert('Ukuran file terlalu besar (maksimal 5MB).'); window.history.back();</script>";
        exit;
    }

    // Buat direktori jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Upload file
    if (move_uploaded_file($_FILES["pdf_agunan"]["tmp_name"], $targetFileAgunan)) {
        $stmt = $mysqli->prepare("INSERT INTO file_sk (
            no_ktp, id_riwayat, file_name_sk, file_path_sk, jenis_agunan, no_agunan, tgl_agunan
        ) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "<script>alert('Query gagal: " . $mysqli->error . "'); window.history.back();</script>";
            exit;
        }

        $stmt->bind_param("sssssss",
            $no_ktp,
            $id_riwayat,
            $fileNameAgunan,
            $targetFileAgunan,
            $jenis_agunan,
            $no_agunan,
            $tgl_agunan
        );

        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "<script>alert('Upload file gagal.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Metode tidak diizinkan!'); window.history.back();</script>";
    exit;
}
