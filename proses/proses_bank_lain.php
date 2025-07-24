<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $no_ktp             = trim(htmlspecialchars($_POST['no_ktp']));
    $id_riwayat         = trim(htmlspecialchars($_POST['id_riwayat']));
    $update_banklain    = trim($_POST['update_banklain']);
    $nama_lembaga       = trim(htmlspecialchars($_POST['nama_lembaga']));
    $plafon_bank_lain   = str_replace(['.', ','], '', $_POST['plafon_bank_lain']); // hilangkan format ribuan
    $kol_bank_lain      = trim(htmlspecialchars($_POST['kol_bank_lain']));
    $bd_bank_lain       = str_replace(['.', ','], '', $_POST['bd_bank_lain']);
    $angs_bank_lain     = str_replace(['.', ','], '', $_POST['angs_bank_lain']);
    $cara_bayar_bank_lain = trim(htmlspecialchars($_POST['cara_bayar_bank_lain']));
    $catatan_bank_lain  = trim(htmlspecialchars($_POST['catatan_bank_lain']));

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO bank_lain (
        no_ktp,
        id_riwayat,
        update_banklain,
        nama_lembaga,
        plafon_bank_lain,
        kol_bank_lain,
        bd_bank_lain,
        angs_bank_lain,
        cara_bayar_bank_lain,
        catatan_bank_lain
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind parameter sesuai tipe data: s = string, i = integer (semua string jika dirasa aman)
    $stmt->bind_param(
        "sissssssss",
        $no_ktp,
        $id_riwayat,
        $update_banklain,
        $nama_lembaga,
        $plafon_bank_lain,
        $kol_bank_lain,
        $bd_bank_lain,
        $angs_bank_lain,
        $cara_bayar_bank_lain,
        $catatan_bank_lain
    );

    // Eksekusi dan cek keberhasilan
    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
