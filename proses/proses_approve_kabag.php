<?php
session_start();
include("../Database/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_putusan_kabag'], $_POST['aksi'])) {
    $id_putusan_kabag = $_POST['id_putusan_kabag'];
    $aksi = $_POST['aksi'];
    $waktu_approve = date('Y-m-d H:i:s');

    $no_ktp     = $_POST['no_ktp'] ?? null;
    $id_riwayat = $_POST['id_riwayat'] ?? null;

    if ($aksi === 'approve') {
        $status = 'Approved oleh Kadiv. Pemasaran';
    } elseif ($aksi === 'reject') {
        $status = 'Rejected';
    } else {
        $_SESSION['error_msg'] = "Aksi tidak valid.";
        header("Location: ../pages/detail_debitur.php");
        exit();
    }

    $query = "UPDATE putusan_kabag
              SET status_putusan_kabag = ?, 
                  waktu_approve_kadiv = ?
              WHERE id_putusan_kabag = ?";

    $stmt = $mysqli->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ssi", $status, $waktu_approve, $id_putusan_kabag);

        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Putusan Analis berhasil diubah menjadi <strong>$status</strong>.";
        } else {
            $_SESSION['error_msg'] = "Gagal mengubah status putusan: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error_msg'] = "Query gagal dipersiapkan: " . $mysqli->error;
    }

    $mysqli->close();
} else {
    $_SESSION['error_msg'] = "Permintaan tidak valid.";
}

// Redirect hanya jika no_ktp dan id_riwayat tersedia
if ($no_ktp && $id_riwayat) {
    header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
} else {
    header("Location: ../pages/detail_debitur.php");
}
exit();
?>
