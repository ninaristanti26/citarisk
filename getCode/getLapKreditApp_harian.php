<?php 
include("../Database/koneksi.php");

$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

function getPutusanByPegawai($mysqli, $table, $id_pegawai, $tanggal = null) {
    // Kolom waktu untuk masing-masing tabel
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
        SELECT *
        FROM users
        JOIN data_pokok ON users.id_pegawai = data_pokok.id_pegawai
        JOIN riwayat_kredit ON data_pokok.no_ktp = riwayat_kredit.no_ktp
        JOIN $table ON 
            $table.no_ktp = data_pokok.no_ktp AND 
            $table.id_riwayat = riwayat_kredit.id_riwayat AND
            $table.id_pegawai = users.id_pegawai
        WHERE users.id_pegawai = ?
        $tanggal_filter
        GROUP BY riwayat_kredit.id_riwayat
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    if ($tanggal && isset($waktu_column[$table])) {
        $stmt->bind_param("ss", $id_pegawai, $tanggal);
    } else {
        $stmt->bind_param("s", $id_pegawai);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $data;
}

$tanggal = $_GET['tanggal'] ?? null;

$getPutusanKaspem = getPutusanByPegawai($mysqli, "putusan_kaspem", $id_pegawai, $tanggal);
$getPutusanKabag  = getPutusanByPegawai($mysqli, "putusan_kabag", $id_pegawai, $tanggal);
$getPutusanKadiv  = getPutusanByPegawai($mysqli, "putusan_kadiv", $id_pegawai, $tanggal);
$getPutusanDirut  = getPutusanByPegawai($mysqli, "putusan_dirut", $id_pegawai, $tanggal);

$mysqli->close();
?>
