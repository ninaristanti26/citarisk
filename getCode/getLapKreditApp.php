<?php 
include(__DIR__ . '/../Database/koneksi.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

function getPutusanByPegawai($mysqli, $table, $id_pegawai) {
   $sql = "
    SELECT $table.*, data_pokok.no_ktp
    FROM users
    JOIN data_pokok ON users.id_pegawai COLLATE utf8mb4_unicode_ci = data_pokok.id_pegawai COLLATE utf8mb4_unicode_ci
    JOIN riwayat_kredit ON data_pokok.no_ktp COLLATE utf8mb4_unicode_ci = riwayat_kredit.no_ktp COLLATE utf8mb4_unicode_ci
    JOIN $table ON 
        $table.no_ktp COLLATE utf8mb4_unicode_ci = data_pokok.no_ktp COLLATE utf8mb4_unicode_ci AND 
        $table.id_riwayat = riwayat_kredit.id_riwayat AND
        $table.id_pegawai COLLATE utf8mb4_unicode_ci = users.id_pegawai COLLATE utf8mb4_unicode_ci
    WHERE users.id_pegawai COLLATE utf8mb4_unicode_ci = ?
";


    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Query Error: " . $mysqli->error); // Debug
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