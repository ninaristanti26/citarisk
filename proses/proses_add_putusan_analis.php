<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_pegawai               = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat               = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp                   = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_analis       = trim(htmlspecialchars($_POST['waktu_putus_analis']));
    $putusan_analis           = trim(htmlspecialchars($_POST['putusan_analis']));
    $plafon_rekom_analis_raw  = str_replace(['.', ','], '', $_POST['plafon_rekom_analis']);
    $plafon_rekom_analis      = is_numeric($plafon_rekom_analis_raw) ? (int)$plafon_rekom_analis_raw : 0;
    $status_putusan_analis    = trim(htmlspecialchars($_POST['status_putusan_analis']));
    $waktu_approve_kaspem     = trim(htmlspecialchars($_POST['waktu_approve_kaspem']));
    $jw_rekom_analis          = trim(htmlspecialchars($_POST['jw_rekom_analis']));
    $metode_bayar             = trim(htmlspecialchars($_POST['metode_bayar']));
    $goldeb                   = trim(htmlspecialchars($_POST['goldeb']));

    // Validasi dasar
    if (
        empty($id_pegawai) || 
        empty($no_ktp) || 
        empty($id_riwayat) ||
        empty($waktu_putus_analis) || 
        empty($putusan_analis) || 
        $plafon_rekom_analis <= 0 ||
        empty($status_putusan_analis) ||
        empty($waktu_approve_kaspem) ||
        empty($jw_rekom_analis) ||
        empty($metode_bayar) ||
        empty($goldeb) 
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Query insert ke tabel putusan_analis
    $stmt = $mysqli->prepare("INSERT INTO putusan_analis (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_analis,
        putusan_analis,
        plafon_rekom_analis,
        status_putusan_analis,
        waktu_approve_kaspem,
        jw_rekom_analis,
        metode_bayar,
        goldeb
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Perhatikan: i untuk integer, s untuk string
    $stmt->bind_param(
        "sssssisssss",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_analis,
        $putusan_analis,
        $plafon_rekom_analis,
        $status_putusan_analis,
        $waktu_approve_kaspem,
        $jw_rekom_analis,
        $metode_bayar,
        $goldeb
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
