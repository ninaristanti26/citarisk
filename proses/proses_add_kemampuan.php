<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {

    // Ambil & validasi data
    $id_riwayat              = trim($_POST['id_riwayat'] ?? '');
    $no_ktp                  = trim($_POST['no_ktp'] ?? '');
    $pengendalian_pembayaran = trim($_POST['pengendalian_pembayaran'] ?? '');
    $kualitas_angsuran       = trim($_POST['kualitas_angsuran'] ?? '');

    // Validasi data kosong
    if (empty($id_riwayat) || empty($no_ktp) || empty($pengendalian_pembayaran) || empty($kualitas_angsuran)) {
        die("Data tidak lengkap. Pastikan semua opsi terisi.");
    }

    // Simpan data
    $stmt = $mysqli->prepare("INSERT INTO kemampuan (
        id_riwayat,
        no_ktp,
        pengendalian_pembayaran,
        kualitas_angsuran
    ) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("ssss", $id_riwayat, $no_ktp, $pengendalian_pembayaran, $kualitas_angsuran);

    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Akses tidak sah.";
}
?>
