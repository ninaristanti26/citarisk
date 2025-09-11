<?php
include("../Database/koneksi.php");
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $no_ktp            = $_POST['no_ktp'] ?? '';
    $update_pekerjaan  = $_POST['update_pekerjaan'] ?? '';
    $nama_instansi     = $_POST['nama_instansi'] ?? '';
    $jabatan           = $_POST['jabatan'] ?? '';
    $unit_kerja        = $_POST['unit_kerja'] ?? '';
    $status_kerja      = $_POST['status_kerja'] ?? '';
    $tgl_pengangkatan  = $_POST['tgl_pengangkatan'] ?? '';
    $usia_akhir_kerja  = $_POST['usia_akhir_kerja'] ?? '';
    $alamat_instansi   = $_POST['alamat_instansi'] ?? '';
    $sektor_instansi   = $_POST['sektor_instansi'] ?? '';
    $rasio             = $_POST['rasio'] ?? '';

    // Validasi sederhana
    if (empty($no_ktp) || 
        empty($nama_instansi) || 
        empty($jabatan) ||
        empty($unit_kerja) ||
        empty($status_kerja) ||
        empty($tgl_pengangkatan) ||
        empty($usia_akhir_kerja) ||
        empty($alamat_instansi) ||
        empty($sektor_instansi) ||
        empty($rasio)
        ) {
        echo "<script>alert('Data tidak lengkap!'); window.history.back();</script>";
        exit;
    }

    // Perhatikan: Jumlah kolom = Jumlah values = Jumlah bind_param
    $query = "INSERT INTO pekerjaan 
                (no_ktp, 
                 update_pekerjaan, 
                 nama_instansi, 
                 jabatan, 
                 unit_kerja,
                 status_kerja, 
                 tgl_pengangkatan, 
                 usia_akhir_kerja, 
                 alamat_instansi, 
                 sektor_instansi, 
                 rasio)
              VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($query);

    $stmt->bind_param("sssssssssss",
        $no_ktp, 
        $update_pekerjaan, 
        $nama_instansi, 
        $jabatan, 
        $unit_kerja,
        $status_kerja, 
        $tgl_pengangkatan, 
        $usia_akhir_kerja, 
        $alamat_instansi, 
        $sektor_instansi, 
        $rasio
    );

    if ($stmt->execute()) {
        header("Location: ../views/detail.php?no_ktp=" . urlencode($no_ktp));
    } else {
        echo "<script>alert('Gagal menambahkan data: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "<script>alert('Metode tidak diizinkan!'); window.history.back();</script>";
}
?>