<?php
include("../Database/koneksi.php");
include("../getCode/getBwk.php"); // Pastikan path benar

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_pegawai         = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat         = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp             = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_dirut  = trim(htmlspecialchars($_POST['waktu_putus_dirut']));
    $putusan_dirut      = trim(htmlspecialchars($_POST['putusan_dirut']));
    $plafon_raw         = str_replace(['.', ','], '', $_POST['plafon_rekom_dirut']);
    $plafon_rekom_dirut = is_numeric($plafon_raw) ? (int)$plafon_raw : 0;
    $jw_rekom_dirut     = trim(htmlspecialchars($_POST['jw_rekom_dirut']));

    // Validasi input
    if (
        empty($id_pegawai) ||
        empty($id_riwayat) ||
        empty($no_ktp) ||
        empty($waktu_putus_dirut) ||
        empty($putusan_dirut) ||
        $plafon_rekom_dirut <= 0 ||
        empty($jw_rekom_dirut)
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Persiapan query insert
    $stmt = $mysqli->prepare("INSERT INTO putusan_dirut (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_dirut,
        putusan_dirut,
        plafon_rekom_dirut,
        jw_rekom_dirut
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Binding parameter
    $stmt->bind_param(
        "sssssis",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_dirut,
        $putusan_dirut,
        $plafon_rekom_dirut,
        $jw_rekom_dirut
    );

    // Eksekusi query
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
