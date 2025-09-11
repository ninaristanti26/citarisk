<?php
session_start();
include(__DIR__ . '/../Database/koneksi.php');

// Pastikan user login
if (!isset($_SESSION['id_pegawai'])) {
    header("Location: ../index.php");
    exit;
}

// Cek method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data POST dan sanitasi
    $no_ktp_asli    = $_POST['no_ktp'] ?? '';
    $nama_debitur   = trim($_POST['nama_debitur'] ?? '');
    $jk             = $_POST['jk'] ?? '';
    $tempat_lahir   = trim($_POST['tempat_lahir'] ?? '');
    $tgl_lahir      = $_POST['tgl_lahir'] ?? '';
    $pend_akhir     = $_POST['pend_akhir'] ?? '';
    $nama_ibu       = trim($_POST['nama_ibu'] ?? '');
    $jml_tanggungan = $_POST['jml_tanggungan'] ?? '';
    $no_hp          = trim($_POST['no_hp'] ?? '');
    $alamat         = trim($_POST['alamat'] ?? '');
    $status_rumah   = $_POST['status_rumah'] ?? '';

    // Validasi server-side (minimal)
    if (empty($no_ktp_asli) || 
        empty($nama_debitur) || 
        empty($jk) || 
        empty($tempat_lahir) || 
        empty($tgl_lahir) || 
        empty($pend_akhir) || 
        empty($nama_ibu) || 
        !is_numeric($jml_tanggungan) || 
        empty($no_hp) || 
        empty($alamat) || 
        empty($status_rumah)) {
        echo "<script>alert('Semua field harus diisi dengan benar.'); window.history.back();</script>";
        exit;
    }

    // Validasi no_ktp 16 digit numeric
    if (!preg_match('/^\d{16}$/', $no_ktp_asli)) {
        echo "<script>alert('No. KTP harus 16 digit angka.'); window.history.back();</script>";
        exit;
    }

    // Query update (gunakan prepared statement untuk keamanan)
    $sql = "UPDATE data_pokok SET 
                nama_debitur = ?, 
                jk = ?, 
                tempat_lahir = ?, 
                tgl_lahir = ?, 
                pend_akhir = ?, 
                nama_ibu = ?, 
                jml_tanggungan = ?, 
                no_hp = ?, 
                alamat = ?, 
                status_rumah = ?
            WHERE no_ktp = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssssssisss", 
            $nama_debitur, 
            $jk, 
            $tempat_lahir, 
            $tgl_lahir, 
            $pend_akhir, 
            $nama_ibu, 
            $jml_tanggungan, 
            $no_hp, 
            $alamat, 
            $status_rumah, 
            $no_ktp_asli);

        if ($stmt->execute()) {
            echo "<script>alert('Data debitur berhasil diperbarui.'); window.location.href='/detail?no_ktp=" . urlencode($no_ktp_asli) . "';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui data: " . $stmt->error . "'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Kesalahan query: " . $koneksi->error . "'); window.history.back();</script>";
        exit;
    }

} else {
    header("Location: ../index.php");
    exit;
}
?>
