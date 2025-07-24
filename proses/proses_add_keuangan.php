<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $id_riwayat           = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp               = trim(htmlspecialchars($_POST['no_ktp']));
    $penghasilan_tetap    = str_replace(['.', ','], '', $_POST['penghasilan_tetap']);
    $penghasilan_variabel = empty($_POST['penghasilan_variabel']) 
                        ? 0 
                        : str_replace(['.', ','], '', $_POST['penghasilan_variabel']);
    $jw_maks              = trim(htmlspecialchars($_POST['jw_maks']));
    $bunga_maks           = trim(htmlspecialchars($_POST['bunga_maks']));

    // Validasi sederhana
    if (empty($id_riwayat) || 
        empty($no_ktp) || 
        !is_numeric($penghasilan_tetap) || 
        !is_numeric($penghasilan_variabel) || 
        !is_numeric($jw_maks) || 
        !is_numeric($bunga_maks)) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Siapkan query dengan prepared statement
    $stmt = $mysqli->prepare("INSERT INTO data_keuangan (
        id_riwayat,
        no_ktp,
        penghasilan_tetap,
        penghasilan_variabel,
        jw_maks,
        bunga_maks
    ) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Gunakan bind_param dengan tipe data yang sesuai
    $stmt->bind_param(
        "ssiiii",
        $id_riwayat,
        $no_ktp,
        $penghasilan_tetap,
        $penghasilan_variabel,
        $jw_maks,
        $bunga_maks
    );

    // Eksekusi query
    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
}
?>
