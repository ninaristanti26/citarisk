<?php 
include(__DIR__ . '/../Database/koneksi.php');

$id_riwayat = isset($_GET['id_riwayat']) ? $_GET['id_riwayat'] : '';

if (!$id_riwayat) {
    die("ID riwayat tidak ditemukan.");
}

$stmt = $mysqli->prepare("
    SELECT *
    FROM users
    JOIN data_pokok ON users.id_pegawai = data_pokok.id_pegawai
    JOIN riwayat_kredit ON data_pokok.no_ktp = riwayat_kredit.no_ktp
    JOIN putusan_kaspem ON 
        putusan_kaspem.no_ktp = data_pokok.no_ktp AND 
        putusan_kaspem.id_riwayat = riwayat_kredit.id_riwayat AND
        putusan_kaspem.id_pegawai = users.id_pegawai
    WHERE riwayat_kredit.id_riwayat = ?
");

if (!$stmt) {
    die("Query prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $id_riwayat);
$stmt->execute();

$result = $stmt->get_result();
$getPutusanKaspem = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>
