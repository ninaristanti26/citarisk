<?php 
include(__DIR__ . '/../Database/koneksi.php');

// Persiapkan query
$query = "
    SELECT * FROM adm";

// Eksekusi query
$result = $mysqli->query($query);

// Inisialisasi data
$getParamAdm = [];

if ($result) {
    if ($result->num_rows > 0) {
        $getParamAdm = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Kosongkan array jika tidak ada data
        $getParamAdm = [];
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
