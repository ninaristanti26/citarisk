<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['Submit'])) {
    include("../Database/koneksi.php");

    $id_pegawai   = trim($_POST['id_pegawai']);
    $nama         = trim($_POST['nama']);
    $password     = $_POST['password'];
    $kode_cabang  = $_POST['kode_cabang'];
    $id_role      = $_POST['id_role'];

    // Validasi sederhana
    if (empty($id_pegawai) || empty($nama) || empty($password) || empty($kode_cabang) || empty($id_role)) {
        echo "<script>alert('Semua field wajib diisi!');</script>";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Cek apakah ID Pegawai sudah ada
        $cek = $mysqli->prepare("SELECT id_pegawai FROM users WHERE id_pegawai = ?");
        $cek->bind_param("s", $id_pegawai);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            echo "<script>alert('ID Pegawai sudah terdaftar!');</script>";
        } else {
            // Insert data
            $sql = "INSERT INTO users (id_pegawai, nama, password, kode_cabang, id_role, created_at)
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssss", $id_pegawai, $nama, $hashedPassword, $kode_cabang, $id_role);

            if ($stmt->execute()) {
                echo "<script>alert('Data berhasil ditambahkan'); window.location.href='../views/data_ao.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan data: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        }

        $cek->close();
        $koneksi->close();
    }
}
?>