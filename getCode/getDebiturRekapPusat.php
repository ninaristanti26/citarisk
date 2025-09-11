<?php
include("../Database/koneksi.php");

$query = "
    SELECT COUNT(riwayat_kredit.id_riwayat) AS total_riwayat_pusat
    FROM riwayat_kredit
    INNER JOIN users ON riwayat_kredit.id_pegawai = users.id_pegawai
    INNER JOIN cabang ON users.kode_cabang = cabang.kode_cabang
";

$result = $mysqli->query($query);

$total_riwayat_pusat = 0;
if ($result && $row = $result->fetch_assoc()) {
    $total_riwayat_pusat = $row['total_riwayat_pusat'] ?? 0;
} else {
    error_log("Query failed: " . $mysqli->error);
}

$mysqli->close();
?>
