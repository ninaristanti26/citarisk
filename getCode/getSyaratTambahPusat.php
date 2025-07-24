<?php 
include("../Database/koneksi.php");

$getSyaratTambahPusat = [];

if (!empty($id_putusan_analis_pusat)) {
    $stmt = $mysqli->prepare("
        SELECT *
        FROM putusan_analis_pusat
        JOIN syarat_tambahan_pusat ON putusan_analis_pusat.id_putusan_analis_pusat = syarat_tambahan_pusat.id_putusan_analis_pusat
        JOIN data_pokok ON putusan_analis_pusat.no_ktp = data_pokok.no_ktp
        JOIN riwayat_kredit ON putusan_analis_pusat.id_riwayat = riwayat_kredit.id_riwayat
        WHERE putusan_analis_pusat.id_putusan_analis_pusat = ?
    ");

    if ($stmt) {
        $stmt->bind_param("i", $id_putusan_analis_pusat);
        $stmt->execute();
        $result = $stmt->get_result();
        $getSyaratTambahPusat = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        echo "Query gagal: " . $mysqli->error;
    }
}

$mysqli->close();
?>
