<?php
include("../Database/koneksi.php");
include("../getCode/getBwk.php"); // pastikan path-nya benar

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_pegawai         = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat         = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp             = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_pinca  = trim(htmlspecialchars($_POST['waktu_putus_pinca']));
    $putusan_pinca      = trim(htmlspecialchars($_POST['putusan_pinca']));
    $plafon_raw         = str_replace(['.', ','], '', $_POST['plafon_rekom_pinca']);
    $plafon_rekom_pinca = is_numeric($plafon_raw) ? (int)$plafon_raw : 0;
    $jw_rekom_pinca     = trim(htmlspecialchars($_POST['jw_rekom_pinca']));

    // Validasi dasar
    if (
        empty($id_pegawai) ||
        empty($id_riwayat) ||
        empty($no_ktp) ||
        empty($waktu_putus_pinca) ||
        empty($putusan_pinca) ||
        $plafon_rekom_pinca <= 0 ||
        empty($jw_rekom_pinca)
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }
    var_dump($id_pegawai);
    // Ambil data BWK berdasarkan pegawai
    session_start(); // jangan lupa start session
    $pegawai_login = $_SESSION['id_pegawai'];
    $bwkData = getBwkDataByPegawai($mysqli, $pegawai_login);
    if (empty($bwkData)) {
        die("Data BWK tidak ditemukan untuk pegawai ini.");
    }

    // Asumsikan hanya satu BWK per pegawai
    $bwk = (int) $bwkData[0]['bwk'];

    // Tentukan status berdasarkan plafon dan bwk
    $status = ($plafon_rekom_pinca > $bwk) ? "Pending! Kredit Masuk BWK Pusat" : "Selesai! Kredit Masuk BWK Cabang";

    // Query insert dengan prepared statement
    $stmt = $mysqli->prepare("INSERT INTO putusan_pinca (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_pinca,
        putusan_pinca,
        plafon_rekom_pinca,
        jw_rekom_pinca,
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "sssssiss", // 6 string, 1 integer
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_pinca,
        $putusan_pinca,
        $plafon_rekom_pinca,
        $jw_rekom_pinca,
        $status
    );

    if ($stmt->execute()) {
        $stmt->close();
        $mysqli->close();
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
