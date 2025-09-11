<?php
include("../Database/koneksi.php");

// Tampilkan error MySQL secara detail
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Tampilkan semua error PHP kecuali notice & warning
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // ✅ Ambil & sanitasi input dari form
    $id_pegawai                  = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat                  = (int) $_POST['id_riwayat']; // Pastikan integer
    $no_ktp                      = trim(htmlspecialchars($_POST['no_ktp']));
    $waktu_putus_analis_pusat   = trim($_POST['waktu_putus_analis_pusat']);
    $putusan_analis_pusat       = trim(htmlspecialchars($_POST['putusan_analis_pusat']));
    
    // Hilangkan format ribuan (titik/koma), konversi ke integer
    $plafon_raw                 = str_replace(['.', ','], '', $_POST['plafon_rekom_analis_pusat']);
    $plafon_rekom_analis_pusat  = is_numeric($plafon_raw) ? $plafon_raw : '0';
    
    $jw_rekom_analis_pusat      = trim(htmlspecialchars($_POST['jw_rekom_analis_pusat']));
    $metode_bayar_pusat         = trim(htmlspecialchars($_POST['metode_bayar_pusat']));
    $status_putusan_analis_pusat = trim(htmlspecialchars($_POST['status_putusan_analis_pusat']));
    $waktu_approve_kabag        = trim($_POST['waktu_approve_kabag']);

    // ✅ Validasi field wajib
    if (
    empty($id_pegawai) ||
    empty($id_riwayat) ||
    empty($no_ktp) ||
    empty($waktu_putus_analis_pusat) || $waktu_putus_analis_pusat === '0000-00-00 00:00:00' ||
    empty($putusan_analis_pusat) ||
    $plafon_rekom_analis_pusat <= 0 ||
    empty($jw_rekom_analis_pusat) ||
    empty($metode_bayar_pusat) ||
    empty($status_putusan_analis_pusat) ||
    empty($waktu_approve_kabag) || $waktu_approve_kabag === '0000-00-00 00:00:00'
) {
    die("Input tidak valid. Pastikan semua field telah diisi dengan benar dan format waktu sesuai.");
}


    // ✅ Insert ke tabel
    try {
        $stmt = $mysqli->prepare("INSERT INTO putusan_analis_pusat (
                                    id_pegawai,
                                    id_riwayat,
                                    no_ktp,
                                    waktu_putus_analis_pusat,
                                    putusan_analis_pusat,
                                    plafon_rekom_analis_pusat,
                                    jw_rekom_analis_pusat,
                                    metode_bayar_pusat,
                                    status_putusan_analis_pusat,
                                    waktu_approve_kabag
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sissssssss",
            $id_pegawai,
            $id_riwayat,
            $no_ktp,
            $waktu_putus_analis_pusat,
            $putusan_analis_pusat,
            $plafon_rekom_analis_pusat,
            $jw_rekom_analis_pusat,
            $metode_bayar_pusat,
            $status_putusan_analis_pusat,
            $waktu_approve_kabag
        );

        $stmt->execute();

        // Redirect jika berhasil
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } catch (Exception $e) {
        echo "Terjadi kesalahan saat menyimpan data: " . $e->getMessage();
    } finally {
        $stmt?->close();
        $mysqli?->close();
    }
}
?>