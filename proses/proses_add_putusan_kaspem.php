<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_pegawai               = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat               = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp                   = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_kaspem       = trim(htmlspecialchars($_POST['waktu_putus_kaspem']));
    $putusan_kaspem           = trim(htmlspecialchars($_POST['putusan_kaspem']));
    $plafon_rekom_kaspem_raw  = str_replace(['.', ','], '', $_POST['plafon_rekom_kaspem']);
    $plafon_rekom_kaspem      = is_numeric($plafon_rekom_kaspem_raw) ? (int)$plafon_rekom_kaspem_raw : 0;
    $jw_rekom_kaspem          = trim(htmlspecialchars($_POST['jw_rekom_kaspem']));
    $status_putusan_kaspem    = trim(htmlspecialchars($_POST['status_putusan_kaspem']));
    $waktu_approve_pinca      = trim(htmlspecialchars($_POST['waktu_approve_pinca']));

    // Validasi dasar
    if (
        empty($id_pegawai) || 
        empty($no_ktp) || 
        empty($id_riwayat) ||
        empty($waktu_putus_kaspem) || 
        empty($putusan_kaspem) || 
        $plafon_rekom_kaspem <= 0 ||
        empty($jw_rekom_kaspem) ||
        empty($status_putusan_kaspem) ||
        empty($waktu_approve_pinca) 
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Query insert ke tabel putusan_ao
    $stmt = $mysqli->prepare("INSERT INTO putusan_kaspem (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_kaspem,
        putusan_kaspem,
        plafon_rekom_kaspem,
        jw_rekom_kaspem,
        status_putusan_kaspem,
        waktu_approve_pinca
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "sssssssss",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_kaspem,
        $putusan_kaspem,
        $plafon_rekom_kaspem,
        $jw_rekom_kaspem,
        $status_putusan_kaspem,
        $waktu_approve_pinca
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
