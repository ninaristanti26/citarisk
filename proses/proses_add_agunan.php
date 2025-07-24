<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input, beri nilai default bila null
    $id_riwayat      = isset($_POST['id_riwayat']) ? trim(htmlspecialchars($_POST['id_riwayat'])) : '';
    $no_ktp          = isset($_POST['no_ktp']) ? trim(htmlspecialchars($_POST['no_ktp'])) : '';
    $mou             = isset($_POST['mou']) ? trim(htmlspecialchars($_POST['mou'])) : '';
    $sk              = isset($_POST['sk']) ? trim(htmlspecialchars($_POST['sk'])) : '';
    $tambahan_agunan = isset($_POST['tambahan_agunan']) ? trim(htmlspecialchars($_POST['tambahan_agunan'])) : '';

    // Validasi sederhana
    if (
        empty($id_riwayat) || empty($no_ktp) ||
        $mou === '' || $sk === '' || $tambahan_agunan === ''
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi.");
    }

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO agunan_konsumtif (
        id_riwayat,
        no_ktp,
        mou,
        sk,
        tambahan_agunan
    ) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind parameter (semua string)
    $stmt->bind_param(
        "sssss",
        $id_riwayat,
        $no_ktp,
        $mou,
        $sk,
        $tambahan_agunan
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
