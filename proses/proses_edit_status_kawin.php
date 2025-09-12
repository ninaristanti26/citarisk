<?php
session_start();
include(__DIR__ . '/../Database/koneksi.php');

$no_ktp = $_POST['no_ktp'] ?? '';
$status_kawin = trim($_POST['status_kawin']) ?: '-';
$nama_pasangan = trim($_POST['nama_pasangan']) ?: '-';
$tempat_lahir_pasangan = trim($_POST['tempat_lahir_pasangan']) ?: '-';

$tgl_lahir_pasangan = $_POST['tgl_lahir_pasangan'] ?? '';
if (empty($tgl_lahir_pasangan)) {
    $tgl_lahir_pasangan = null; 
}

$sql = "UPDATE status_kawin SET 
               status_kawin = ?, 
               nama_pasangan = ?, 
               tempat_lahir_pasangan = ?, 
               tgl_lahir_pasangan = ?
        WHERE no_ktp = ?";

$stmt = $mysqli->prepare($sql);

if ($tgl_lahir_pasangan === null) {
    $sql = "UPDATE status_kawin SET 
                   status_kawin = ?, 
                   nama_pasangan = ?, 
                   tempat_lahir_pasangan = ?, 
                   tgl_lahir_pasangan = NULL
            WHERE no_ktp = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $status_kawin, $nama_pasangan, $tempat_lahir_pasangan, $no_ktp);
} else {
    $stmt->bind_param("sssss", $status_kawin, $nama_pasangan, $tempat_lahir_pasangan, $tgl_lahir_pasangan, $no_ktp);
}
$stmt->execute();
if ($stmt->affected_rows > 0) {
    header("Location: ../detail?no_ktp=" . urlencode($no_ktp));
    exit;
} else {
    header("Location: ../detail");
}
