<?php
include("../Database/koneksi.php");
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $no_ktp             = trim(htmlspecialchars($_POST['no_ktp']));
    $update_riwayat_kredit = trim($_POST['update_riwayat_kredit']);
    $jenis_kredit       = trim(htmlspecialchars($_POST['jenis_kredit']));
    $plafon_pengajuan   = str_replace(['.', ','], '', $_POST['plafon_pengajuan']);
    $jw_pengajuan       = trim(htmlspecialchars($_POST['jw_pengajuan']));
    $tujuan_pengajuan   = trim(htmlspecialchars($_POST['tujuan_pengajuan']));
    $id_pegawai         = trim($_POST['id_pegawai']);
    $kode_cabang        = trim($_POST['kode_cabang']);

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO riwayat_kredit (
        no_ktp,
        update_riwayat_kredit,
        jenis_kredit,
        plafon_pengajuan,
        jw_pengajuan,
        tujuan_pengajuan,
        id_pegawai,
        kode_cabang
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind sesuai urutan kolom SQL
    $stmt->bind_param(
        "ssssssss",
        $no_ktp,
        $update_riwayat_kredit,
        $jenis_kredit,
        $plafon_pengajuan,
        $jw_pengajuan,
        $tujuan_pengajuan,
        $id_pegawai,
        $kode_cabang
    );

    // Eksekusi dan cek keberhasilan
    if ($stmt->execute()) {
        header("Location: ../views/detail.php?no_ktp=" . urlencode($no_ktp));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>