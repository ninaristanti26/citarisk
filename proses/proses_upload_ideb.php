<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST["submit"])) {
    $no_ktp     = $_POST['no_ktp'];
    $id_riwayat = $_POST['id_riwayat'];
    $targetDir = "../uploads/";

    $originalName   = basename($_FILES["pdf_ideb"]["name"]);
    $fileNameIdeb   = uniqid() . "_" . $originalName;
    $targetFileIdeb = $targetDir . $fileNameIdeb;
    $fileType = strtolower(pathinfo($targetFileIdeb, PATHINFO_EXTENSION));

    // Validasi PDF
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["pdf_ideb"]["tmp_name"]);
    finfo_close($finfo);

    if ($mime !== 'application/pdf' || $fileType !== "pdf") {
        echo "<script>alert('Hanya file PDF yang valid diperbolehkan.'); window.history.back();</script>";
        exit;
    }

    if ($_FILES["pdf_ideb"]["size"] > 5 * 1024 * 1024) {
        echo "<script>alert('Ukuran file terlalu besar (maksimal 5MB).'); window.history.back();</script>";
        exit;
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($_FILES["pdf_ideb"]["tmp_name"], $targetFileIdeb)) {
        $stmt = $mysqli->prepare("INSERT INTO file_deb (no_ktp, id_riwayat, file_name_ideb, file_path_ideb) VALUES (?, ?, ?, ?)");
        
        if (!$stmt) {
            echo "<script>alert('Query gagal: " . $mysqli->error . "'); window.history.back();</script>";
            exit;
        }

        $stmt->bind_param("ssss", $no_ktp, $id_riwayat, $fileNameIdeb, $targetFileIdeb);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "<script>alert('Upload file gagal.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Metode tidak diizinkan!'); window.history.back();</script>";
}
?>