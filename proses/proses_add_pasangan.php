<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $no_ktp                 = trim(htmlspecialchars($_POST['no_ktp']));
    $update_kawin           = trim($_POST['update_kawin']);
    $status_kawin           = trim(htmlspecialchars($_POST['status_kawin']));
    $nama_pasangan          = trim(htmlspecialchars($_POST['nama_pasangan']));
    $tempat_lahir_pasangan  = trim(htmlspecialchars($_POST['tempat_lahir_pasangan']));
    $tgl_lahir_pasangan     = trim($_POST['tgl_lahir_pasangan']);

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO status_kawin (
        no_ktp,
        update_kawin,
        status_kawin,
        nama_pasangan,
        tempat_lahir_pasangan,
        tgl_lahir_pasangan
    ) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind sesuai urutan kolom SQL
    $stmt->bind_param(
        "ssssss",
        $no_ktp,
        $update_kawin,
        $status_kawin,
        $nama_pasangan,
        $tempat_lahir_pasangan,
        $tgl_lahir_pasangan
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
