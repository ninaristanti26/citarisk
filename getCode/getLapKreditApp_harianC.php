<?php 
include(__DIR__ . '/../Database/koneksi.php');

$kode_cabang = $_SESSION['kode_cabang'] ?? '';
if (!$kode_cabang) {
    die("Unit kerja tidak ditemukan.");
}

function getPutusanByPegawai($mysqli, $table, $kode_cabang, $tanggal = null) {
    $waktu_column = [
        "putusan_kaspem" => "waktu_approve_pinca",
        "putusan_kabag"  => "waktu_approve_kadiv",
        "putusan_kadiv"  => "waktu_putus_kadiv", // Pastikan kolom ini ada
        "putusan_dirut"  => "waktu_putus_dirut"
    ];

    $tanggal_filter = "";
    if ($tanggal && isset($waktu_column[$table])) {
        $tanggal_filter = "AND DATE(" . $waktu_column[$table] . ") = ?";
    }

    $sql = "
        SELECT $table.*, dp.no_ktp
        FROM riwayat_kredit rk
        JOIN $table ON $table.id_riwayat = rk.id_riwayat
        JOIN data_pokok dp ON dp.no_ktp = rk.no_ktp
        WHERE rk.kode_cabang = ?
        $tanggal_filter
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    if ($tanggal && isset($waktu_column[$table])) {
        $stmt->bind_param("ss", $kode_cabang, $tanggal);
    } else {
        $stmt->bind_param("s", $kode_cabang);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $data;
}

$tanggal = $_GET['tanggal'] ?? null;

$getPutusanKaspem = getPutusanByPegawai($mysqli, "putusan_kaspem", $kode_cabang, $tanggal);
$getPutusanKabag  = getPutusanByPegawai($mysqli, "putusan_kabag", $kode_cabang, $tanggal);
$getPutusanKadiv  = getPutusanByPegawai($mysqli, "putusan_kadiv", $kode_cabang, $tanggal);
$getPutusanDirut  = getPutusanByPegawai($mysqli, "putusan_dirut", $kode_cabang, $tanggal);

$mysqli->close();
?>
