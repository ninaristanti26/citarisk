<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST["submit"])) {
    $no_ktp = $_POST['no_ktp'];
    $targetDir = "../uploads/";

    $originalName         = basename($_FILES["pdf_surat_nikah"]["name"]);
    $fileNameSuratNikah   = uniqid() . "_" . $originalName;
    $targetFileSuratNikah = $targetDir . $fileNameSuratNikah;
    $fileType = strtolower(pathinfo($targetFileSuratNikah, PATHINFO_EXTENSION));

    // Validasi PDF
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["pdf_surat_nikah"]["tmp_name"]);
    finfo_close($finfo);

    if ($mime !== 'application/pdf' || $fileType !== "pdf") {
        echo "<script>alert('Hanya file PDF yang valid diperbolehkan.'); window.history.back();</script>";
        exit;
    }

    if ($_FILES["pdf_surat_nikah"]["size"] > 5 * 1024 * 1024) {
        echo "<script>alert('Ukuran file terlalu besar (maksimal 5MB).'); window.history.back();</script>";
        exit;
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($_FILES["pdf_surat_nikah"]["tmp_name"], $targetFileSuratNikah)) {
        $stmt = $mysqli->prepare("INSERT INTO file_surat_nikah (no_ktp, file_name_surat_nikah, file_path_surat_nikah) VALUES (?, ?, ?)");
        
        if (!$stmt) {
            echo "<script>alert('Query gagal: " . $mysqli->error . "'); window.history.back();</script>";
            exit;
        }

        $stmt->bind_param("sss", $no_ktp, $fileNameSuratNikah, $targetFileSuratNikah);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        header("Location: ../views/detail.php?no_ktp=" . urlencode($no_ktp));
        exit;
    } else {
        echo "<script>alert('Upload file gagal.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Metode tidak diizinkan!'); window.history.back();</script>";
}
?>