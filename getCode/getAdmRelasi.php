<?php 
include("../Database/koneksi.php");

$id_riwayat = isset($_GET['id_riwayat']) ? $_GET['id_riwayat'] : '';

if (!$id_riwayat) {
    die("ID riwayat tidak ditemukan.");
}

$stmt = $mysqli->prepare("
    SELECT *
        FROM users
        JOIN data_pokok ON users.id_pegawai = data_pokok.id_pegawai
        JOIN riwayat_kredit ON data_pokok.no_ktp = riwayat_kredit.no_ktp
        JOIN adm_relasi ON 
             adm_relasi.no_ktp = data_pokok.no_ktp AND 
             adm_relasi.id_riwayat = riwayat_kredit.id_riwayat AND
             adm_relasi.id_pegawai = users.id_pegawai
        JOIN adm ON adm_relasi.id_adm = adm.id_adm
        WHERE riwayat_kredit.id_riwayat = ?
");

if (!$stmt) {
    die("Query prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $id_riwayat);
$stmt->execute();

$result       = $stmt->get_result();
$getAdmRelasi = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();
?>
