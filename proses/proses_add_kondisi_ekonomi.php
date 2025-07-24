<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input, beri nilai default bila null
    $id_riwayat         = isset($_POST['id_riwayat']) ? trim(htmlspecialchars($_POST['id_riwayat'])) : '';
    $no_ktp             = isset($_POST['no_ktp']) ? trim(htmlspecialchars($_POST['no_ktp'])) : '';
    $pengaruh_eksternal = isset($_POST['pengaruh_eksternal']) ? trim(htmlspecialchars($_POST['pengaruh_eksternal'])) : '';
    $lama_operasi       = isset($_POST['lama_operasi']) ? trim(htmlspecialchars($_POST['lama_operasi'])) : '';
    
    // Validasi sederhana
    if (
        empty($id_riwayat) || empty($no_ktp) ||
        $pengaruh_eksternal === '' || $lama_operasi === ''
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi.");
    }

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO kondisi_ekonomi (
        id_riwayat,
        no_ktp,
        pengaruh_eksternal,
        lama_operasi
    ) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind parameter (semua string)
    $stmt->bind_param(
        "ssss",
        $id_riwayat,
        $no_ktp,
        $pengaruh_eksternal,
        $lama_operasi
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
