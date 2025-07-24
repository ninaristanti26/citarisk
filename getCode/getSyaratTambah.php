<?php 
include("../Database/koneksi.php");

$getSyaratTambah = [];

if (!empty($id_putusan_analis)) {
    $stmt = $mysqli->prepare("
        SELECT *
        FROM putusan_analis
        JOIN syarat_tambahan ON putusan_analis.id_putusan_analis = syarat_tambahan.id_putusan_analis
        JOIN data_pokok ON putusan_analis.no_ktp = data_pokok.no_ktp
        JOIN riwayat_kredit ON putusan_analis.id_riwayat = riwayat_kredit.id_riwayat
        WHERE putusan_analis.id_putusan_analis = ?
    ");

    if ($stmt) {
        $stmt->bind_param("i", $id_putusan_analis);
        $stmt->execute();
        $result = $stmt->get_result();
        $getSyaratTambah = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        echo "Query gagal: " . $mysqli->error;
    }
}

$mysqli->close();
?>
