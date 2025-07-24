<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST["submit"])) {
    $no_ktp     = $_POST['no_ktp'];
    $id_riwayat = $_POST['id_riwayat'];
    $id_pegawai = $_POST['id_pegawai'];
    $id_adm     = $_POST['id_adm'];
    $status_adm = $_POST['status_adm'];

    $targetDir = "../uploads/";

    $originalName = basename($_FILES["file_adm"]["name"]);
    $fileNameAdm  = uniqid() . "_" . $originalName;
    $targetFileAdm = $targetDir . $fileNameAdm;
    $fileType = strtolower(pathinfo($targetFileAdm, PATHINFO_EXTENSION));

    // Validasi PDF
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["file_adm"]["tmp_name"]);
    finfo_close($finfo);

    if ($mime !== 'application/pdf' || $fileType !== "pdf") {
        echo "<script>alert('Hanya file PDF yang valid diperbolehkan.'); window.history.back();</script>";
        exit;
    }

    if ($_FILES["file_adm"]["size"] > 5 * 1024 * 1024) {
        echo "<script>alert('Ukuran file terlalu besar (maksimal 5MB).'); window.history.back();</script>";
        exit;
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($_FILES["file_adm"]["tmp_name"], $targetFileAdm)) {
        $stmt = $mysqli->prepare("
            INSERT INTO adm_relasi (id_pegawai, no_ktp, id_riwayat, id_adm, file_name_adm, file_path_adm, status_adm)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            echo "<script>alert('Query gagal: " . $mysqli->error . "'); window.history.back();</script>";
            exit;
        }

        $stmt->bind_param("sssssss", $id_pegawai, $no_ktp, $id_riwayat, $id_adm, $fileNameAdm, $targetFileAdm, $status_adm);
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
