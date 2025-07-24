<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    $id_putusan_analis = isset($_POST['id_putusan_analis']) ? (int) $_POST['id_putusan_analis'] : 0;
    $syarat_tambah     = trim($_POST['syarat_tambah']);
    $no_ktp            = isset($_POST['no_ktp']) ? trim($_POST['no_ktp']) : null;
    $id_riwayat        = isset($_POST['id_riwayat']) ? trim($_POST['id_riwayat']) : null;

    if ($id_putusan_analis <= 0 || 
        empty($syarat_tambah) ||
        empty($id_riwayat) ||
        empty($no_ktp)
        ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    $stmt = $mysqli->prepare("INSERT INTO syarat_tambahan (
        id_putusan_analis,
        syarat_tambah,
        id_riwayat,
        no_ktp
    ) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("isii", $id_putusan_analis, $syarat_tambah, $id_riwayat, $no_ktp);

    if ($stmt->execute()) {
        // Redirect jika data berhasil ditambahkan
        if ($no_ktp && $id_riwayat) {
            header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        } else {
            header("Location: ../views/analisa_konsumtif.php");
        }
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
