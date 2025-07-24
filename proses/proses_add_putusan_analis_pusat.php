<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // ✅ Ambil & sanitasi input dari form
    $id_pegawai                   = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat                   = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp                       = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_analis_pusat     = trim(htmlspecialchars($_POST['waktu_putus_analis_pusat']));
    $putusan_analis_pusat         = trim(htmlspecialchars($_POST['putusan_analis_pusat']));
    $plafon_raw                   = str_replace(['.', ','], '', $_POST['plafon_rekom_analis_pusat']);
    $plafon_rekom_analis_pusat    = is_numeric($plafon_raw) ? (int)$plafon_raw : 0;
    $jw_rekom_analis_pusat        = trim(htmlspecialchars($_POST['jw_rekom_analis_pusat']));
    $metode_bayar_pusat           = trim(htmlspecialchars($_POST['metode_bayar_pusat']));
    $status_putusan_analis_pusat  = trim(htmlspecialchars($_POST['status_putusan_analis_pusat']));
    $waktu_approve_kabag          = trim(htmlspecialchars($_POST['waktu_approve_kabag']));

    // ✅ Validasi field wajib
    if (
        empty($id_pegawai) ||
        empty($id_riwayat) ||
        empty($no_ktp) ||
        empty($waktu_putus_analis_pusat) ||
        empty($putusan_analis_pusat) ||
        $plafon_rekom_analis_pusat <= 0 ||
        empty($jw_rekom_analis_pusat) ||
        empty($metode_bayar_pusat) ||
        empty($status_putusan_analis_pusat) ||
        empty($waktu_approve_kabag)
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // ✅ Insert ke tabel putusan_analis_pusat
    $stmt = $mysqli->prepare("INSERT INTO putusan_analis_pusat (
                                                                id_pegawai,
                                                                id_riwayat,
                                                                no_ktp,
                                                                waktu_putus_analis_pusat,
                                                                putusan_analis_pusat,
                                                                plafon_rekom_analis_pusat,
                                                                jw_rekom_analis_pusat,
                                                                metode_bayar_pusat,
                                                                status_putusan_analis_pusat,
                                                                waktu_approve_kabag
                                                                ) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "ssssssssss",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_analis_pusat,
        $putusan_analis_pusat,
        $plafon_rekom_analis_pusat,
        $jw_rekom_analis_pusat,
        $metode_bayar_pusat,
        $status_putusan_analis_pusat,
        $waktu_approve_kabag
    );

    // ✅ Eksekusi dan redirect
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
