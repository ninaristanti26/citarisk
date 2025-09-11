<?php 
include(__DIR__ . '/../Database/koneksi.php');

$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

function getPutusanByBulan($mysqli, $table, $id_pegawai, $tahun = null) {
    $filter_tanggal = "";
    
    $waktu_column = [
        "putusan_kaspem" => "waktu_approve_pinca",
        "putusan_kabag"  => "waktu_approve_kadiv",
        "putusan_kadiv"  => "waktu_putus_kadiv",     // pastikan kolom benar
        "putusan_dirut"  => "waktu_putus_dirut"
    ];

    if ($tahun && isset($waktu_column[$table])) {
        $filter_tanggal = "AND MONTH(" . $waktu_column[$table] . ") = ?";
    }

    $sql = "
        SELECT *
        FROM users
        JOIN data_pokok ON users.id_pegawai = data_pokok.id_pegawai
        JOIN riwayat_kredit ON data_pokok.no_ktp = riwayat_kredit.no_ktp
        JOIN $table ON 
            $table.no_ktp = data_pokok.no_ktp AND 
            $table.id_riwayat = riwayat_kredit.id_riwayat AND
            $table.id_pegawai = users.id_pegawai
        WHERE users.id_pegawai = ?
        $filter_tanggal
        GROUP BY riwayat_kredit.id_riwayat
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    if ($tahun && isset($waktu_column[$table])) {
        $stmt->bind_param("si", $id_pegawai, $tahun);
    } else {
        $stmt->bind_param("s", $id_pegawai);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $data;
}

$tahun = $_GET['tahun'] ?? null;

$getPutusanKaspem = getPutusanByBulan($mysqli, "putusan_kaspem", $id_pegawai, $tahun);
$getPutusanKabag  = getPutusanByBulan($mysqli, "putusan_kabag", $id_pegawai, $tahun);
$getPutusanKadiv  = getPutusanByBulan($mysqli, "putusan_kadiv", $id_pegawai, $tahun);
$getPutusanDirut  = getPutusanByBulan($mysqli, "putusan_dirut", $id_pegawai, $tahun);

$mysqli->close();
?>
