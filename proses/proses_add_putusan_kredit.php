<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_pegawai         = trim(htmlspecialchars($_POST['id_pegawai']));
    $id_riwayat         = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp             = trim(htmlspecialchars($_POST['no_ktp']));
    $plafon_kredit_raw  = str_replace(['.', ','], '', $_POST['plafon_kredit']);
    $plafon_kredit      = is_numeric($plafon_kredit_raw) ? (int)$plafon_kredit_raw : 0;
    $jw_kredit          = trim(htmlspecialchars($_POST['jw_kredit']));
    
    if (
        empty($id_pegawai) || 
        empty($no_ktp) || 
        empty($id_riwayat) ||
        $plafon_kredit <= 0 ||
        empty($jw_kredit) 
    ) {
        die("Input tidak valid. Pastikan semua field telah diisi dengan benar.");
    }

    // Query insert ke tabel putusan_ao
    $stmt = $mysqli->prepare("INSERT INTO putusan_kredit (
        id_pegawai,
        id_riwayat,
        no_ktp,
        plafon_kredit,
        jw_kredit
    ) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "sssss",
        $id_pegawai,
        $id_riwayat,
        $no_ktp,
        $plafon_kredit,
        $jw_kredit
    );

    if ($stmt->execute()) {
        header("Location: ../views/putusan_kredit.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
