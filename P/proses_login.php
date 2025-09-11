<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../Database/koneksi.php';

// Ambil dan bersihkan input
$id_pegawai = isset($_POST['id_pegawai']) ? trim($_POST['id_pegawai']) : '';
$password   = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validasi input
if (empty($id_pegawai) || empty($password)) {
    header("Location: ../index?pesan=kosong");
    exit;
}

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Siapkan query untuk ambil data user
$stmt = $mysqli->prepare("SELECT * FROM users WHERE id_pegawai = ?");
if (!$stmt) {
    die("Prepare statement gagal: " . $mysqli->error);
}

$stmt->bind_param("s", $id_pegawai);
$stmt->execute();
$result = $stmt->get_result();

// Cek hasil
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();

    // Debugging: Tampilkan password yang disimpan dan yang diinput
   // echo "Password yang diinput: $password<br>";
   // echo "Password yang disimpan: " . $data['password'] . "<br>";

    // Verifikasi password (pastikan password di DB sudah di-hash!)
    if (password_verify($password, $data['password'])) {
        // Set session jika password valid
        $_SESSION['id_pegawai']  = $data['id_pegawai'];
        $_SESSION['kode_cabang'] = $data['kode_cabang'];
        $_SESSION['nama']        = $data['nama'];
        $_SESSION['id_role']     = $data['id_role'];
        $_SESSION['loggedin']    = true;

        // Redirect ke halaman home
        header("Location: ../views/home");
        exit;
    } else {
        // Password salah
        header("Location: ../index?pesan=password_salah");
        exit;
    }
} else {
    // User tidak ditemukan
    header("Location: ../index?pesan=gagal");
    exit;
}

// Tutup koneksi
$stmt->close();
$mysqli->close();
?>