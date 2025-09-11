<?php 
include(__DIR__ . '/../Database/koneksi.php');

$id_riwayat = isset($_GET['id_riwayat']) ? $_GET['id_riwayat'] : '';

if (!$id_riwayat) {
    die("ID riwayat tidak ditemukan.");
}

$stmt = $mysqli->prepare("
    SELECT *
    FROM users
    JOIN data_pokok 
        ON users.id_pegawai COLLATE utf8mb4_unicode_ci = data_pokok.id_pegawai COLLATE utf8mb4_unicode_ci
    JOIN riwayat_kredit 
        ON data_pokok.no_ktp COLLATE utf8mb4_unicode_ci = riwayat_kredit.no_ktp COLLATE utf8mb4_unicode_ci
    JOIN putusan_kabag 
        ON putusan_kabag.no_ktp COLLATE utf8mb4_unicode_ci = data_pokok.no_ktp COLLATE utf8mb4_unicode_ci 
        AND putusan_kabag.id_riwayat = riwayat_kredit.id_riwayat 
        AND putusan_kabag.id_pegawai COLLATE utf8mb4_unicode_ci = users.id_pegawai COLLATE utf8mb4_unicode_ci
    WHERE riwayat_kredit.id_riwayat = ?
");


if (!$stmt) {
    die("Query prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $id_riwayat);
$stmt->execute();

$result = $stmt->get_result();
$getPutusanKabag = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>