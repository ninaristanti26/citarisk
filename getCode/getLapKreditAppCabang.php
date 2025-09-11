<?php 
include("../Database/koneksi.php");

$kode_cabang = $_SESSION['kode_cabang'] ?? '';
if (!$kode_cabang) {
    die("Unit kerja tidak ditemukan.");
}

function getPutusanByCabang($mysqli, $table, $kode_cabang) {
    $sql = "
        SELECT $table.*, dp.no_ktp
        FROM riwayat_kredit rk
        JOIN $table ON $table.id_riwayat = rk.id_riwayat
        JOIN data_pokok dp ON dp.no_ktp = rk.no_ktp
        WHERE rk.kode_cabang = ?
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    $stmt->bind_param("s", $kode_cabang);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC); 
    $stmt->close();

    return $data;
}

// Ambil putusan berdasarkan kode cabang
$getPutusanKaspem = getPutusanByCabang($mysqli, "putusan_kaspem", $kode_cabang);
$getPutusanKabag  = getPutusanByCabang($mysqli, "putusan_kabag", $kode_cabang);
$getPutusanKadiv  = getPutusanByCabang($mysqli, "putusan_kadiv", $kode_cabang);
$getPutusanDirut  = getPutusanByCabang($mysqli, "putusan_dirut", $kode_cabang);

$mysqli->close();
?>
