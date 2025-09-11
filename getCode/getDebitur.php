<?php 
include(__DIR__ . '/../Database/koneksi.php');

$query = "
    SELECT *
    FROM data_pokok
    INNER JOIN users ON data_pokok.id_pegawai = users.id_pegawai
    INNER JOIN cabang ON users.kode_cabang = cabang.kode_cabang
";

$result = $mysqli->query($query);
$options = [];

if ($result) {
    if ($result->num_rows > 0) {
        $options = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $options = [];
    }

    $result->free();
} else {
    error_log("Query error: " . $mysqli->error); 
}

// Tutup koneksi
$mysqli->close();
?>
