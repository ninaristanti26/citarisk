<?php
include("../Database/koneksi.php");

$kode_cabang = isset($_SESSION['kode_cabang']) ? (int)$_SESSION['kode_cabang'] : 0;

if ($kode_cabang > 0) {
    $query = "
        SELECT COUNT(riwayat_kredit.id_riwayat) AS total_riwayat_cabang
        FROM riwayat_kredit
        INNER JOIN users ON riwayat_kredit.id_pegawai = users.id_pegawai
        INNER JOIN cabang ON users.kode_cabang = cabang.kode_cabang
        WHERE cabang.kode_cabang = ?
    ";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $kode_cabang);
        $stmt->execute();
        $result = $stmt->get_result();
        $total_riwayat_cabang = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $total_riwayat_cabang = $row['total_riwayat_cabang'] ?? 0;
        }
        $stmt->close();
    } else {
        error_log("Prepare statement failed: " . $mysqli->error);
        $total_riwayat_cabang = 0;
    }
} else {
    $total_riwayat_cabang = 0;
}
$mysqli->close();
?>
