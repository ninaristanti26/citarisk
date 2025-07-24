<?php
// Koneksi ke database
include '../Database/koneksi.php';

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

echo "<h2>Proses Hashing Password Dimulai...</h2><br>";

$query = "SELECT id_pegawai, password FROM users";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $updated = 0;

    while ($row = $result->fetch_assoc()) {
        $id_pegawai         = $row['id_pegawai'];
        $plaintext_password = $row['password'];

        // Jika password tidak di-hash atau panjangnya kurang dari 60 karakter, kita hash ulang
        if (strlen($plaintext_password) < 60 || strpos($plaintext_password, '$2y$') !== 0) {
            // Meng-hash password menggunakan bcrypt
            $hashed = password_hash($plaintext_password, PASSWORD_DEFAULT);

            // Update password yang sudah di-hash ke database
            $update = $mysqli->prepare("UPDATE users SET password = ? WHERE id_pegawai = ?");
            $update->bind_param("ss", $hashed, $id_pegawai);

            if ($update->execute()) {
                echo "✅ Password untuk ID <strong>$id_pegawai</strong> berhasil di-hash.<br>";
                $updated++;
            } else {
                echo "❌ Gagal update password untuk ID <strong>$id_pegawai</strong>.<br>";
            }

            $update->close();
        } else {
            echo "ℹ️ Password untuk ID <strong>$id_pegawai</strong> sudah di-hash, dilewati.<br>";
        }
    }

    echo "<hr><strong>Total password yang di-hash: $updated</strong><br>";
} else {
    echo "Tidak ada data pengguna.";
}

$mysqli->close();
?>
