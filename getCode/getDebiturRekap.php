<?php
include(__DIR__ . '/../Database/koneksi.php');

$id_pegawai = isset($_SESSION['id_pegawai']) ? (int)$_SESSION['id_pegawai'] : 0;

if ($id_pegawai > 0) {
    $query = "
        SELECT COUNT(riwayat_kredit.id_riwayat) AS total_riwayat
        FROM riwayat_kredit
        INNER JOIN users ON riwayat_kredit.id_pegawai = users.id_pegawai
        INNER JOIN cabang ON users.kode_cabang = cabang.kode_cabang
        WHERE riwayat_kredit.id_pegawai = ?
    ";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $id_pegawai);
        $stmt->execute();
        $result = $stmt->get_result();
        $total_riwayat = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $total_riwayat = $row['total_riwayat'] ?? 0;
        }
        $stmt->close();
    } else {
        error_log("Prepare statement failed: " . $mysqli->error);
        $total_riwayat = 0;
    }
} else {
    $total_riwayat = 0;
}
$mysqli->close();
?>
