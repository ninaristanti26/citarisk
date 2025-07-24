<?php
include("../Database/koneksi.php");

$sql_pinca = $mysqli->prepare("SELECT status, plafon_rekom_pinca, jw_rekom_pinca FROM putusan_pinca WHERE id_riwayat = ?");
$sql_pinca->bind_param("s", $id_riwayat);
$sql_pinca->execute();
$result_pinca = $sql_pinca->get_result()->fetch_assoc();

$sql_kadiv = $mysqli->prepare("SELECT status_kadiv, plafon_rekom_kadiv, jw_rekom_kadiv FROM putusan_kadiv WHERE id_riwayat = ?");
$sql_kadiv->bind_param("s", $id_riwayat);
$sql_kadiv->execute();
$result_kadiv = $sql_kadiv->get_result()->fetch_assoc();

$sql_dirut = $mysqli->prepare("SELECT plafon_rekom_dirut, jw_rekom_dirut FROM putusan_dirut WHERE id_riwayat = ?");
$sql_dirut->bind_param("s", $id_riwayat);
$sql_dirut->execute();
$result_dirut = $sql_dirut->get_result()->fetch_assoc();

$plafon_kredit = "";
$jw_kredit     = "";

if (!empty($result_pinca['status']) && stripos($result_pinca['status'], "Selesai! Kredit Masuk BWK Cabang") !== false) {
    $plafon_kredit = $result_pinca['plafon_rekom_pinca'];
    $jw_kredit = $result_pinca['jw_rekom_pinca'];
} elseif (!empty($result_kadiv['status_kadiv']) && stripos($result_kadiv['status_kadiv'], "Kredit Disetujui") !== false) {
    $plafon_kredit = $result_kadiv['plafon_rekom_kadiv'];
    $jw_kredit = $result_kadiv['jw_rekom_kadiv'];
} else {
    $plafon_kredit = $result_dirut['plafon_rekom_dirut'] ?? '';
    $jw_kredit = $result_dirut['jw_rekom_dirut'] ?? '';
}
?>