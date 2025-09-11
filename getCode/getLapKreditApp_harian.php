<?php 
include(__DIR__ . '/../Database/koneksi.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek session id_pegawai
$id_pegawai = $_SESSION['id_pegawai'] ?? '';
if (!$id_pegawai) {
    die("ID pegawai tidak ditemukan.");
}

// Fungsi untuk mengambil data putusan dengan filter tanggal (opsional)
function getPutusanByPegawai($mysqli, $table, $id_pegawai, $tanggal = null) {
    // Daftar kolom waktu berdasarkan tabel
    $waktu_column = [
        "putusan_kaspem" => "waktu_approve_pinca",
        "putusan_kabag"  => "waktu_approve_kadiv",
        "putusan_kadiv"  => "waktu_putus_kadiv",
        "putusan_dirut"  => "waktu_putus_dirut"
    ];

    // Validasi kolom waktu berdasarkan tabel
    $tanggal_filter = "";
    $bind_types = "s";
    $bind_values = [$id_pegawai];

    if ($tanggal && isset($waktu_column[$table])) {
        $tanggal_filter = "AND DATE(" . $waktu_column[$table] . ") = ?";
        $bind_types .= "s";
        $bind_values[] = $tanggal;
    }

    $sql = "
        SELECT *
    FROM users
    JOIN data_pokok ON users.id_pegawai = data_pokok.id_pegawai
    JOIN riwayat_kredit ON data_pokok.no_ktp = riwayat_kredit.no_ktp
    JOIN $table ON 
        $table.no_ktp = data_pokok.no_ktp COLLATE utf8mb4_unicode_ci AND 
        $table.id_riwayat = riwayat_kredit.id_riwayat AND
        $table.id_pegawai = users.id_pegawai COLLATE utf8mb4_unicode_ci
    WHERE users.id_pegawai = ?
    $tanggal_filter
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        return [];
    }

    // Gunakan bind_param manual untuk PHP < 5.6
    if (count($bind_values) === 2) {
        $stmt->bind_param("ss", $bind_values[0], $bind_values[1]);
    } else {
        $stmt->bind_param("s", $bind_values[0]);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $data;
}

// Ambil tanggal dari query string (jika ada)
$tanggal = $_GET['tanggal'] ?? null;

// Ambil data dari semua tahap putusan
$getPutusanKaspem = getPutusanByPegawai($mysqli, "putusan_kaspem", $id_pegawai, $tanggal);
$getPutusanKabag  = getPutusanByPegawai($mysqli, "putusan_kabag",  $id_pegawai, $tanggal);
$getPutusanKadiv  = getPutusanByPegawai($mysqli, "putusan_kadiv",  $id_pegawai, $tanggal);
$getPutusanDirut  = getPutusanByPegawai($mysqli, "putusan_dirut",  $id_pegawai, $tanggal);
//echo '<pre>';
//var_dump($getPutusanKaspem, $getPutusanKabag, $getPutusanKadiv, $getPutusanDirut);
//echo '</pre>';

$mysqli->close();
?>