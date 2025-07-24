<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    $no_ktp             = trim(htmlspecialchars($_POST['no_ktp']));
    $update_info   = trim($_POST['update_info']);
    $referensi          = trim(htmlspecialchars($_POST['referensi']));
    $trade              = trim(htmlspecialchars($_POST['trade']));
    $keluarga_terdekat  = trim(htmlspecialchars($_POST['keluarga_terdekat']));
    $no_hp_keluarga     = trim(htmlspecialchars($_POST['no_hp_keluarga']));
    $aktivitas_keuangan = trim(htmlspecialchars($_POST['aktivitas_keuangan']));

    $stmt = $mysqli->prepare("INSERT INTO info_lain (
        no_ktp,
        update_info,
        referensi,
        trade,
        keluarga_terdekat,
        no_hp_keluarga,
        aktivitas_keuangan
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "sssssss",
        $no_ktp,
        $update_info,
        $referensi,
        $trade,
        $keluarga_terdekat,
        $no_hp_keluarga,
        $aktivitas_keuangan
    );

    if ($stmt->execute()) {
        header("Location: ../views/detail.php?no_ktp=" . urlencode($no_ktp));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
