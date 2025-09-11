<?php
include(__DIR__ . '/../Database/koneksi.php');

$id_pegawai = isset($_SESSION['id_pegawai']) ? (int)$_SESSION['id_pegawai'] : 0;

$counts = [
    'analis' => 0,
    'kaspem' => 0,
    'pinca' => 0,
    'analis_pusat' => 0,
    'kabag' => 0,
    'kadiv' => 0,
];

// Fungsi dengan prepared statement dan JOIN yang aman
function count_pending($mysqli, $table, $status_column, $id_pegawai_column = 'id_riwayat') {
    $query = "
        SELECT COUNT(*) AS total
        FROM $table
        INNER JOIN riwayat_kredit ON $table.$id_pegawai_column = riwayat_kredit.id_riwayat
        WHERE $status_column = 'Pending' AND riwayat_kredit.id_pegawai = ?
    ";

    if ($stmt = $mysqli->prepare($query)) {
        global $id_pegawai;
        $stmt->bind_param("i", $id_pegawai);
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

// Hitung per jenis putusan
$counts['analis']        = count_pending($mysqli, 'putusan_analis', 'status_putusan_analis');
$counts['kaspem']        = count_pending($mysqli, 'putusan_kaspem', 'status_putusan_kaspem');
$counts['pinca']         = count_pending($mysqli, 'putusan_pinca', 'status'); // jika nama kolom hanya 'status'
$counts['analis_pusat']  = count_pending($mysqli, 'putusan_analis_pusat', 'status_putusan_analis_pusat');
$counts['kabag']         = count_pending($mysqli, 'putusan_kabag', 'status_putusan_kabag');
$counts['kadiv']         = count_pending($mysqli, 'putusan_kadiv', 'status_kadiv');

$total_pending_semua = array_sum($counts);

$mysqli->close();

// Output contoh:
// echo "Total Pending Semua: $total_pending_semua";
?>
