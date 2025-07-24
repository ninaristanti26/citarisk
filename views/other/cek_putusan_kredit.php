<?php
include("../../Database/koneksi.php");

// Tangkap parameter
$no_ktp     = isset($_GET['no_ktp']) ? $_GET['no_ktp'] : '';
$id_riwayat = isset($_GET['id_riwayat']) ? $_GET['id_riwayat'] : '';
$id_pegawai = isset($_GET['id_pegawai']) ? $_GET['id_pegawai'] : '';

// Validasi sederhana
if (empty($id_riwayat)) {
    die("ID Riwayat tidak ditemukan.");
}

// Cek apakah id_riwayat sudah ada di tabel putusan_kredit
$query = "SELECT COUNT(*) as jumlah FROM putusan_kredit WHERE id_riwayat = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $id_riwayat);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// URL yang akan dituju
$redirect_url = ($data['jumlah'] > 0)
    ? "../putusan_kredit.php"
    : "../input_putusan_kredit.php";

// Buat URL lengkap
$redirect_url .= "?no_ktp=" . urlencode($no_ktp)
               . "&id_riwayat=" . urlencode($id_riwayat)
               . "&id_pegawai=" . urlencode($id_pegawai);

// Redirect
header("Location: $redirect_url");
exit();
?>
