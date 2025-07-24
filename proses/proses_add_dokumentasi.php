<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input, beri nilai default bila null
    $id_riwayat         = isset($_POST['id_riwayat']) ? trim(htmlspecialchars($_POST['id_riwayat'])) : '';
    $no_ktp             = isset($_POST['no_ktp']) ? trim(htmlspecialchars($_POST['no_ktp'])) : '';
    $legal_pemohon      = isset($_POST['legal_pemohon']) ? trim(htmlspecialchars($_POST['legal_pemohon'])) : '';
    $legal_ideb         = isset($_POST['legal_ideb']) ? trim(htmlspecialchars($_POST['legal_ideb'])) : '';
    $kelengkapan_syarat = isset($_POST['kelengkapan_syarat']) ? trim(htmlspecialchars($_POST['kelengkapan_syarat'])) : '';
    $kelengkapan_legal  = isset($_POST['kelengkapan_legal']) ? trim(htmlspecialchars($_POST['kelengkapan_legal'])) : '';

    // Validasi sederhana
    if (
        empty($id_riwayat) || empty($no_ktp) ||
        $legal_pemohon === '' || 
        $legal_ideb === '' ||
        $kelengkapan_syarat === '' ||
        $kelengkapan_legal === ''
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi.");
    }

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO dokumentasi (
        id_riwayat,
        no_ktp,
        legal_pemohon,
        legal_ideb,
        kelengkapan_syarat,
        kelengkapan_legal
    ) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind parameter sesuai jumlah kolom
    $stmt->bind_param(
        "ssssss",
        $id_riwayat,
        $no_ktp,
        $legal_pemohon,
        $legal_ideb,
        $kelengkapan_syarat,
        $kelengkapan_legal
    );

    // Eksekusi dan redirect
    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
