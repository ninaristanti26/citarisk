<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // ✅ Ambil & sanitasi input dari form
    $id_pegawai              = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat              = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp                  = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_kabag       = trim(htmlspecialchars($_POST['waktu_putus_kabag']));
    $putusan_kabag           = trim(htmlspecialchars($_POST['putusan_kabag']));
    $plafon_raw              = str_replace(['.', ','], '', $_POST['plafon_rekom_kabag']);
    $plafon_rekom_kabag      = is_numeric($plafon_raw) ? (int)$plafon_raw : 0;
    $jw_rekom_kabag          = trim(htmlspecialchars($_POST['jw_rekom_kabag']));
    $catatan                 = trim(htmlspecialchars($_POST['catatan']));
    $status_putusan_kabag    = trim(htmlspecialchars($_POST['status_putusan_kabag']));
    $waktu_approve_kadiv     = trim(htmlspecialchars($_POST['waktu_approve_kadiv']));

    // ✅ Validasi field wajib
    if (
        empty($id_pegawai) ||
        empty($id_riwayat) ||
        empty($no_ktp) ||
        empty($waktu_putus_kabag) ||
        empty($putusan_kabag) ||
        $plafon_rekom_kabag <= 0 ||
        empty($jw_rekom_kabag) ||
        empty($catatan) ||
        empty($status_putusan_kabag)
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // ✅ Insert ke tabel putusan_kabag
    $stmt = $mysqli->prepare("INSERT INTO putusan_kabag (
        id_pegawai,
        id_riwayat,
        no_ktp,
        waktu_putus_kabag,
        putusan_kabag,
        plafon_rekom_kabag,
        jw_rekom_kabag,
        catatan,
        status_putusan_kabag,
        waktu_approve_kadiv
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "ssssssssss",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $waktu_putus_kabag,
        $putusan_kabag,
        $plafon_rekom_kabag,
        $jw_rekom_kabag,
        $catatan,
        $status_putusan_kabag,
        $waktu_approve_kadiv
    );

    // ✅ Eksekusi dan redirect
    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
