<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_riwayat  = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp      = trim(htmlspecialchars($_POST['no_ktp']));
    $opini_kasop = trim(htmlspecialchars($_POST['opini_kasop']));
    
    // Validasi dasar
    if (
        empty($no_ktp) || 
        empty($id_riwayat) ||
        empty($opini_kasop) 
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Query insert ke tabel putusan_ao
    $stmt = $mysqli->prepare("INSERT INTO opini_kasop (
        id_riwayat,
        no_ktp,
        opini_kasop
    ) VALUES (?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "sss",
        $id_riwayat,
        $no_ktp,
        $opini_kasop
    );

    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
