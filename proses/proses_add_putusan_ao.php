<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_pegawai           = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat           = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp               = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_ao       = trim(htmlspecialchars($_POST['waktu_putus_ao']));
    $putusan_ao           = trim(htmlspecialchars($_POST['putusan_ao']));
    $plafon_rekom_ao_raw  = str_replace(['.', ','], '', $_POST['plafon_rekom_ao']);
    $plafon_rekom_ao      = is_numeric($plafon_rekom_ao_raw) ? (int)$plafon_rekom_ao_raw : 0;
    $status_putusan_ao    = trim(htmlspecialchars($_POST['status_putusan_ao']));
    $waktu_approve_analis = trim(htmlspecialchars($_POST['waktu_approve_analis']));

    // Validasi dasar
    if (
        empty($id_pegawai) || 
        empty($no_ktp) || 
        empty($id_riwayat) ||
        empty($waktu_putus_ao) || 
        empty($putusan_ao) || 
        $plafon_rekom_ao <= 0 ||
        empty($status_putusan_ao) ||
        empty($waktu_approve_analis) 
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Query insert ke tabel putusan_ao
    $stmt = $mysqli->prepare("INSERT INTO putusan_ao (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_ao,
        putusan_ao,
        plafon_rekom_ao,
        status_putusan_ao,
        waktu_approve_analis
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "ssssssss",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_ao,
        $putusan_ao,
        $plafon_rekom_ao,
        $status_putusan_ao,
        $waktu_approve_analis
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
