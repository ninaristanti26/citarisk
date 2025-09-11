<?php
include(__DIR__ . '/../Database/koneksi.php');

$kode_cabang = isset($_SESSION['kode_cabang']) ? (int)$_SESSION['kode_cabang'] : 0;

$counts = [
    'analis' => 0,
    'kaspem' => 0,
    'pinca' => 0,
    'analis_pusat' => 0,
    'kabag' => 0,
    'kadiv' => 0,
];

function count_pending($mysqli, $table, $status_column) {
    global $kode_cabang;

    $query = "
        SELECT COUNT(*) AS total
        FROM $table
        INNER JOIN riwayat_kredit ON $table.id_riwayat = riwayat_kredit.id_riwayat
        WHERE $table.$status_column = 'Pending'
        AND riwayat_kredit.kode_cabang = ?
    ";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $kode_cabang);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return (int)($row['total'] ?? 0);
    } else {
        error_log("Query error in $table: " . $mysqli->error);
        return 0;
    }
}

$counts['analis']        = count_pending($mysqli, 'putusan_analis', 'status_putusan_analis');
$counts['kaspem']        = count_pending($mysqli, 'putusan_kaspem', 'status_putusan_kaspem');
$counts['pinca']         = count_pending($mysqli, 'putusan_pinca', 'status'); // Jika nama kolom hanya 'status'
$counts['analis_pusat']  = count_pending($mysqli, 'putusan_analis_pusat', 'status_putusan_analis_pusat');
$counts['kabag']         = count_pending($mysqli, 'putusan_kabag', 'status_putusan_kabag');
$counts['kadiv']         = count_pending($mysqli, 'putusan_kadiv', 'status_kadiv');

$total_pending_semua = array_sum($counts);

$mysqli->close();

?>
