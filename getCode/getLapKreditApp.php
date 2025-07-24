<?php 
include("../Database/koneksi.php");

$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

function getPutusanByPegawai($mysqli, $table, $id_pegawai) {
    $sql = "
        SELECT $table.*, data_pokok.no_ktp
        FROM users
        JOIN data_pokok ON users.id_pegawai = data_pokok.id_pegawai
        JOIN riwayat_kredit ON data_pokok.no_ktp = riwayat_kredit.no_ktp
        JOIN $table ON 
            $table.no_ktp = data_pokok.no_ktp AND 
            $table.id_riwayat = riwayat_kredit.id_riwayat AND
            $table.id_pegawai = users.id_pegawai
        WHERE users.id_pegawai = ?
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    $stmt->bind_param("s", $id_pegawai);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC); 
    $stmt->close();

    return $data;
}

// Ambil putusan per bagian
$getPutusanKaspem = getPutusanByPegawai($mysqli, "putusan_kaspem", $id_pegawai);
$getPutusanKabag  = getPutusanByPegawai($mysqli, "putusan_kabag", $id_pegawai);
$getPutusanKadiv  = getPutusanByPegawai($mysqli, "putusan_kadiv", $id_pegawai);
$getPutusanDirut  = getPutusanByPegawai($mysqli, "putusan_dirut", $id_pegawai);
$mysqli->close();
?>
