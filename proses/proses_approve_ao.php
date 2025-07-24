<?php
session_start();
include("../Database/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_putusan_ao'], $_POST['aksi'])) {
    $id_putusan_ao = $_POST['id_putusan_ao'];
    $aksi = $_POST['aksi'];
    $waktu_approve = date('Y-m-d H:i:s');

    $no_ktp     = $_POST['no_ktp'] ?? null;
    $id_riwayat = $_POST['id_riwayat'] ?? null;

    if ($aksi === 'approve') {
        $status = 'Approved';
    } elseif ($aksi === 'reject') {
        $status = 'Rejected';
    } else {
        $_SESSION['error_msg'] = "Aksi tidak valid.";
        header("Location: ../pages/detail_debitur.php");
        exit();
    }

    $query = "UPDATE putusan_ao 
              SET status_putusan_ao = ?, 
                  waktu_approve_analis = ?
              WHERE id_putusan_ao = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssi", $status, $waktu_approve, $id_putusan_ao);

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Putusan AO berhasil diubah menjadi <strong>$status</strong>.";
    } else {
        $_SESSION['error_msg'] = "Gagal mengubah status putusan.";
    }

    $stmt->close();
    $mysqli->close();
} else {
    $_SESSION['error_msg'] = "Permintaan tidak valid.";
}

header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat)); // ganti dengan file tujuan yang sesuai
exit();
