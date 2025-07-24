<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $id_riwayat  = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp      = trim(htmlspecialchars($_POST['no_ktp']));
    $sifat       = trim(htmlspecialchars($_POST['sifat']));
    $ideb        = trim(htmlspecialchars($_POST['ideb']));
    $repayment   = trim(htmlspecialchars($_POST['repayment']));
    $perkara_hukum   = trim(htmlspecialchars($_POST['perkara_hukum']));
    $gaya_hidup  = trim(htmlspecialchars($_POST['gaya_hidup']));
    $lama_kerja  = trim($_POST['lama_kerja']);

    // Gunakan prepared statement untuk keamanan
    $stmt = $mysqli->prepare("INSERT INTO karakter (
        id_riwayat,
        no_ktp,
        sifat,
        ideb,
        repayment,
        perkara_hukum,
        gaya_hidup,
        lama_kerja
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Bind sesuai urutan kolom SQL
    $stmt->bind_param(
        "ssssssss",
        $id_riwayat,
        $no_ktp,
        $sifat,
        $ideb,
        $repayment,
        $perkara_hukum,
        $gaya_hidup,
        $lama_kerja
    );

    // Eksekusi dan cek keberhasilan
    if ($stmt->execute()) {
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
