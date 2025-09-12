<?php
include("../Database/koneksi.php");
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $no_ktp                = $_POST['no_ktp'] ?? '';
    $jenis_kredit          = $_POST['jenis_kredit'] ?? '';
    $plafon_pengajuan      = $_POST['plafon_pengajuan'] ?? '';
    $jw_pengajuan          = $_POST['jw_pengajuan'] ?? '';
    $id_pegawai            = $_POST['id_pegawai'] ?? '';
    $kode_cabang           = $_POST['kode_cabang'] ?? '';
    $tujuan_pengajuan      = $_POST['tujuan_pengajuan'] ?? '';
   // $update_riwayat_kredit = date('Y-m-d H:i:s');

    if (!is_numeric($plafon_pengajuan)) {
        echo "<script>alert('Plafon harus berupa angka!'); window.history.back();</script>";
        exit;
    }

    // Validasi wajib isi
    if (
        empty($no_ktp) || 
        empty($jenis_kredit) || 
        empty($jw_pengajuan) || 
        empty($id_pegawai) || 
        empty($kode_cabang) || 
        empty($tujuan_pengajuan)
    ) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Query UPDATE
    $query = "UPDATE riwayat_kredit 
              SET jenis_kredit = ?,
                  plafon_pengajuan = ?,
                  jw_pengajuan = ?,
                  id_pegawai = ?,
                  kode_cabang = ?,
                  tujuan_pengajuan = ?
              WHERE no_ktp = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param(
        "sssssss",
        $jenis_kredit,
        $plafon_pengajuan,
        $jw_pengajuan,
        $id_pegawai,
        $kode_cabang,
        $tujuan_pengajuan,
        $no_ktp
    );

    if ($stmt->execute()) {
        header("Location: ../views/detail.php?no_ktp=" . urlencode($no_ktp));
        exit;
    } else {
        echo "<script>alert('Gagal mengupdate data: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "<script>alert('Metode tidak diizinkan!'); window.history.back();</script>";
}
?>
