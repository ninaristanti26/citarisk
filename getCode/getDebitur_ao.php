<?php 
include("../Database/koneksi.php");

$id_pegawai = $_GET['id_pegawai'];

// Siapkan statement dengan parameter
$query = "
    SELECT *
    FROM data_pokok
    INNER JOIN users ON data_pokok.id_pegawai = users.id_pegawai
    INNER JOIN cabang ON users.kode_cabang = cabang.kode_cabang
    WHERE users.id_pegawai = ?
";

$getDebitur_ao = [];

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $id_pegawai); // Gunakan "i" jika id_pegawai adalah integer, "s" jika string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $getDebitur_ao = $result->fetch_all(MYSQLI_ASSOC);
    }

    $stmt->close();
} else {
    error_log("Prepare failed: " . $mysqli->error);
}

// Tutup koneksi
$mysqli->close();
?>
