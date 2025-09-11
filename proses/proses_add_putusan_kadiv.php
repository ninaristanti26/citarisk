<?php
session_start();  
include("../Database/koneksi.php");
include("../getCode/getBwk.php"); // pastikan path-nya benar

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    $id_pegawai_post     = trim(htmlspecialchars($_POST['id_pegawai']));  // Akan disimpan ke tabel
    $id_riwayat          = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp              = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_kadiv   = trim(htmlspecialchars($_POST['waktu_putus_kadiv']));
    $putusan_kadiv       = trim(htmlspecialchars($_POST['putusan_kadiv']));
    $plafon_raw          = str_replace(['.', ','], '', $_POST['plafon_rekom_kadiv']);
    $plafon_rekom_kadiv  = is_numeric($plafon_raw) ? (int)$plafon_raw : 0;
    $jw_rekom_kadiv      = trim(htmlspecialchars($_POST['jw_rekom_kadiv']));

    if (
        empty($id_pegawai_post) ||
        empty($id_riwayat) ||
        empty($no_ktp) ||
        empty($waktu_putus_kadiv) ||
        empty($putusan_kadiv) ||
        $plafon_rekom_kadiv <= 0 ||
        empty($jw_rekom_kadiv)
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    $pegawai_login = $_SESSION['id_pegawai'] ?? null;
    if (!$pegawai_login) {
        die("Session id_pegawai belum diset. Silakan login kembali.");
    }

    $bwkData = getBwkDataByPegawai($mysqli, $_SESSION['id_pegawai']);
    if (empty($bwkData)) {
        die("BWK tidak ditemukan untuk pegawai id " . $_SESSION['id_pegawai']);
    }
    $bwk = (int) $bwkData[0]['bwk'];
   
    $status_kadiv = ($plafon_rekom_kadiv > $bwk) 
        ? "Pending! Kredit Masuk BWK Dirut" 
        : "Kredit Selesai dianalisa";

    $stmt = $mysqli->prepare("INSERT INTO putusan_kadiv (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_kadiv,
        putusan_kadiv,
        plafon_rekom_kadiv,
        jw_rekom_kadiv,
        status_kadiv
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "ssssssis", // 6 string, 1 integer
        $id_pegawai_post,   // dari input form
        $id_riwayat,
        $no_ktp,
        $waktu_putus_kadiv,
        $putusan_kadiv,
        $plafon_rekom_kadiv,
        $jw_rekom_kadiv,
        $status_kadiv
    );

    if ($stmt->execute()) {
    $stmt->close();
    $mysqli->close();

    // Jangan ada var_dump/echo sebelum ini!
    header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
    exit;
}

    $stmt->close();
    $mysqli->close();
}
?>