<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input utama
    $id_pegawai = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp     = trim(htmlspecialchars($_POST['no_ktp']));
    $admDipilih = $_POST['adm_selected'] ?? [];
    $statusList = $_POST['status_adm'] ?? [];

    // Validasi awal
    if (empty($id_pegawai) || empty($no_ktp) || empty($id_riwayat)) {
        die("Input tidak valid. Data utama tidak lengkap.");
    }

    if (empty($admDipilih)) {
        die("Tidak ada jenis administrasi yang dipilih.");
    }

    $stmt = $mysqli->prepare("INSERT INTO adm_relasi (
        id_pegawai,
        id_riwayat,
        no_ktp,
        id_adm,
        status_adm
    ) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    foreach ($admDipilih as $id_adm) {
        $status = trim(htmlspecialchars($statusList[$id_adm] ?? ''));

        if (empty($status)) {
            continue; // lewati jika status belum diisi
        }

        $stmt->bind_param("sssss", $id_pegawai, $id_riwayat, $no_ktp, $id_adm, $status);
        $stmt->execute();
    }

    $stmt->close();
    $mysqli->close();

    // Redirect kembali
    header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
    exit;
}
?>