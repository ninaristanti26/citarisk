<?php 
include(__DIR__ . '/../Database/koneksi.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

function getPutusanByBulan($mysqli, $table, $id_pegawai, $bulan = null, $tahun = null) {
    $filter_tanggal = "";
    
    $waktu_column = [
        "putusan_kaspem" => "waktu_approve_pinca",
        "putusan_kabag"  => "waktu_approve_kadiv",
        "putusan_kadiv"  => "waktu_putus_kadiv",     
        "putusan_dirut"  => "waktu_putus_dirut"
    ];

    if ($bulan && $tahun && isset($waktu_column[$table])) {
        $filter_tanggal = "AND MONTH(" . $waktu_column[$table] . ") = ? AND YEAR(" . $waktu_column[$table] . ") = ?";
    }

    $sql = "
       SELECT *
    FROM users
    JOIN data_pokok ON users.id_pegawai COLLATE utf8mb4_unicode_ci = data_pokok.id_pegawai COLLATE utf8mb4_unicode_ci
    JOIN riwayat_kredit ON data_pokok.no_ktp COLLATE utf8mb4_unicode_ci = riwayat_kredit.no_ktp COLLATE utf8mb4_unicode_ci
    JOIN $table ON 
        $table.no_ktp COLLATE utf8mb4_unicode_ci = data_pokok.no_ktp COLLATE utf8mb4_unicode_ci AND
        $table.id_riwayat = riwayat_kredit.id_riwayat AND
        $table.id_pegawai COLLATE utf8mb4_unicode_ci = users.id_pegawai COLLATE utf8mb4_unicode_ci
    WHERE users.id_pegawai = ?
    $filter_tanggal
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    if ($bulan && $tahun && isset($waktu_column[$table])) {
        $stmt->bind_param("sii", $id_pegawai, $bulan, $tahun);
    } else {
        $stmt->bind_param("s", $id_pegawai);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $data;
}

$bulan = $_GET['bulan'] ?? null;
$tahun = $_GET['tahun'] ?? null;

$getPutusanKaspem = getPutusanByBulan($mysqli, "putusan_kaspem", $id_pegawai, $bulan, $tahun);
$getPutusanKabag  = getPutusanByBulan($mysqli, "putusan_kabag", $id_pegawai, $bulan, $tahun);
$getPutusanKadiv  = getPutusanByBulan($mysqli, "putusan_kadiv", $id_pegawai, $bulan, $tahun);
$getPutusanDirut  = getPutusanByBulan($mysqli, "putusan_dirut", $id_pegawai, $bulan, $tahun);

$mysqli->close();
?>