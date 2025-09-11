<?php 
include(__DIR__ . '/../Database/koneksi.php');

$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

function getTotalPlafonApprovedByLevel($mysqli, $id_pegawai) {
    // 1. Plafon Pinca jika disetujui oleh Kaspem
    $sqlPinca = "
        SELECT SUM(pinca.plafon_rekom_pinca) AS total
        FROM putusan_pinca pinca
        JOIN putusan_kaspem kaspem ON 
            pinca.no_ktp = kaspem.no_ktp AND 
            pinca.id_riwayat = kaspem.id_riwayat AND 
            pinca.id_pegawai = kaspem.id_pegawai
        WHERE pinca.id_pegawai = ?
        AND kaspem.status_putusan_kaspem = 'Approved'
    ";

    // 2. Plafon Kadiv
    $sqlKadiv = "
        SELECT SUM(kabag.plafon_rekom_kadiv) AS total
        FROM putusan_kabag kabag
        WHERE kabag.id_pegawai = ?
        AND kabag.status_putusan_kabag = 'Approved oleh Kadiv. Pemasaran'
    ";

    // 3. Plafon Dirut
    $sqlDirut = "
        SELECT SUM(kadiv.plafon_rekom_dirut) AS total
        FROM putusan_kadiv kadiv
        JOIN putusan_dirut dirut ON 
            kadiv.no_ktp = dirut.no_ktp AND 
            kadiv.id_riwayat = dirut.id_riwayat AND 
            kadiv.id_pegawai = dirut.id_pegawai
        WHERE kadiv.id_pegawai = ?
        AND kadiv.status_kadiv = 'Kredit Disetujui'
    ";

    // Eksekusi
    $stmts = [
        ['sql' => $sqlPinca, 'key' => 'pinca'],
        ['sql' => $sqlKadiv, 'key' => 'kadiv'],
        ['sql' => $sqlDirut, 'key' => 'dirut']
    ];

    foreach ($stmts as $item) {
        $stmt = $mysqli->prepare($item['sql']);
        if ($stmt) {
            $stmt->bind_param("s", $id_pegawai);
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            $result[$item['key']] = $total ?? 0;
            $stmt->close();
        } else {
            error_log("Query gagal: " . $mysqli->error);
        }
    }

    return $result;
}

$getPutusanKaspem = getPutusanByBulan($mysqli, "putusan_kaspem", $id_pegawai, $bulan, $tahun);
$getPutusanKabag  = getPutusanByBulan($mysqli, "putusan_kabag", $id_pegawai, $bulan, $tahun);
$getPutusanKadiv  = getPutusanByBulan($mysqli, "putusan_kadiv", $id_pegawai, $bulan, $tahun);
$getPutusanDirut  = getPutusanByBulan($mysqli, "putusan_dirut", $id_pegawai, $bulan, $tahun);

$mysqli->close();
?>
