<?php
include("../Database/koneksi.php");

$kode_cabang = isset($_SESSION['kode_cabang']) ? (int)$_SESSION['kode_cabang'] : 0;

// Inisialisasi hasil
$counts = [
    'analis' => 0,
    'kaspem' => 0,
    'pinca' => 0,
    'analis_pusat' => 0,
    'kabag' => 0,
    'kadiv' => 0,
];

function count_rejected($mysqli, $table, $status_column) {
    global $kode_cabang;
    $query = "
        SELECT COUNT(*) AS total
        FROM $table
        INNER JOIN riwayat_kredit ON $table.id_riwayat = riwayat_kredit.id_riwayat
        WHERE $status_column = 'Rejected' AND riwayat_kredit.kode_cabang = ?
    ";

    if ($stmt = $mysqli->prepare($query)) {
        global $kode_cabang;
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

// Hitung per jenis putusan dengan status 'Rejected'
$counts['analis']        = count_rejected($mysqli, 'putusan_analis', 'status_putusan_analis');
$counts['kaspem']        = count_rejected($mysqli, 'putusan_kaspem', 'status_putusan_kaspem');
$counts['pinca']         = count_rejected($mysqli, 'putusan_pinca', 'status'); // jika nama kolom memang 'status'
$counts['analis_pusat']  = count_rejected($mysqli, 'putusan_analis_pusat', 'status_putusan_analis_pusat');
$counts['kabag']         = count_rejected($mysqli, 'putusan_kabag', 'status_putusan_kabag');
$counts['kadiv']         = count_rejected($mysqli, 'putusan_kadiv', 'status_kadiv');

// Total semua status rejected
$total_rejected_semua = array_sum($counts);

$mysqli->close();

// Contoh output (nonaktifkan komentar jika ingin cetak hasil)
/*
echo "Total Rejected Semua: $total_rejected_semua";
foreach ($counts as $key => $value) {
    echo ucfirst($key) . ": $value<br>";
}
*/
?>
