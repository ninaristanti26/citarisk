<?php
include("../Database/koneksi.php");
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan validasi input
    $no_ktp               = trim($_POST['no_ktp'] ?? '');
    $update_riwayat_kredit = trim($_POST['update_riwayat_kredit'] ?? date('Y-m-d H:i:s'));
    $jenis_kredit         = trim($_POST['jenis_kredit'] ?? '');
    $plafon_pengajuan     = str_replace(['.', ','], '', $_POST['plafon_pengajuan'] ?? '0'); // Format angka
    $jw_pengajuan         = trim($_POST['jw_pengajuan'] ?? '0');
    $tujuan_pengajuan     = trim($_POST['tujuan_pengajuan'] ?? '');
    $id_pegawai           = trim($_POST['id_pegawai'] ?? '');
    $kode_cabang          = trim($_POST['kode_cabang'] ?? '');

    // Jika status atau approved_at tidak dikirim dari form, gunakan default
    $status               = $_POST['status'] ?? 'Pengajuan'; // default status awal
    $approved_at          = $_POST['approved_at'] ?? null;   // NULL jika belum ada

    // Jika approved_at tidak diisi, set null agar tidak error di MySQL
    if (empty($approved_at) || $approved_at === '0000-00-00 00:00:00') {
        $approved_at = null;
    }

    // Siapkan query SQL
    $stmt = $mysqli->prepare("INSERT INTO riwayat_kredit (
        no_ktp,
        update_riwayat_kredit,
        jenis_kredit,
        plafon_pengajuan,
        jw_pengajuan,
        tujuan_pengajuan,
        id_pegawai,
        kode_cabang,
        status,
        approved_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind data, jika kolom bisa NULL (approved_at), tetap gunakan 's' untuk string
    $stmt->bind_param(
        "ssssssssss",
        $no_ktp,
        $update_riwayat_kredit,
        $jenis_kredit,
        $plafon_pengajuan,
        $jw_pengajuan,
        $tujuan_pengajuan,
        $id_pegawai,
        $kode_cabang,
        $status,
        $approved_at
    );

    // Eksekusi dan cek hasil
    if ($stmt->execute()) {
        header("Location: ../views/detail.php?no_ktp=" . urlencode($no_ktp));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
