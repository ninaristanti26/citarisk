<?php 
include("../Database/koneksi.php");

// Persiapkan query
$query = "
    SELECT *
    FROM data_pokok
    INNER JOIN users ON data_pokok.id_pegawai = users.id_pegawai
    INNER JOIN cabang ON users.kode_cabang = cabang.kode_cabang
";

// Eksekusi query
$result = $mysqli->query($query);

// Inisialisasi data
$options = [];

if ($result) {
    if ($result->num_rows > 0) {
        $options = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Kosongkan array jika tidak ada data
        $options = [];
    }

    // Bebaskan hasil
    $result->free();
} else {
    // Tampilkan pesan error untuk debugging (jangan tampilkan ini di production!)
    error_log("Query error: " . $mysqli->error); // log saja, jangan ditampilkan langsung
    // Bisa juga tampilkan pesan user-friendly:
    // echo "<p>Terjadi kesalahan saat mengambil data. Silakan coba lagi nanti.</p>";
}

// Tutup koneksi
$mysqli->close();
?>
