<?php 
include(__DIR__ . '/../Database/koneksi.php');

$kode_cabang = $_SESSION['kode_cabang'] ?? '';
if (!$kode_cabang) {
    die("Unit kerja tidak ditemukan.");
}

function getPutusanByBulan($mysqli, $table, $kode_cabang, $bulan = null, $tahun = null) {
    $filter_tanggal = "";
    
    $waktu_column = [
        "putusan_kaspem" => "waktu_approve_pinca",
        "putusan_kabag"  => "waktu_approve_kadiv",
        "putusan_kadiv"  => "waktu_putus_kadiv",     // pastikan kolom benar
        "putusan_dirut"  => "waktu_putus_dirut"
    ];

    if ($bulan && $tahun && isset($waktu_column[$table])) {
        $filter_tanggal = "AND MONTH(" . $waktu_column[$table] . ") = ? AND YEAR(" . $waktu_column[$table] . ") = ?";
    }

    $sql = "
        SELECT $table.*, dp.no_ktp
        FROM riwayat_kredit rk
        JOIN $table ON $table.id_riwayat = rk.id_riwayat
        JOIN data_pokok dp ON dp.no_ktp = rk.no_ktp
        WHERE rk.kode_cabang = ?
        $filter_tanggal
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    if ($bulan && $tahun && isset($waktu_column[$table])) {
        $stmt->bind_param("sii", $kode_cabang, $bulan, $tahun);
    } else {
        $stmt->bind_param("s", $kode_cabang);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $data;
}

$bulan = $_GET['bulan'] ?? null;
$tahun = $_GET['tahun'] ?? null;

$getPutusanKaspem = getPutusanByBulan($mysqli, "putusan_kaspem", $kode_cabang, $bulan, $tahun);
$getPutusanKabag  = getPutusanByBulan($mysqli, "putusan_kabag", $kode_cabang, $bulan, $tahun);
$getPutusanKadiv  = getPutusanByBulan($mysqli, "putusan_kadiv", $kode_cabang, $bulan, $tahun);
$getPutusanDirut  = getPutusanByBulan($mysqli, "putusan_dirut", $kode_cabang, $bulan, $tahun);

$mysqli->close();
?>
