<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['Submit'] === "Submit") {
    // Ambil & sanitasi input
    $id_riwayat        = trim(htmlspecialchars($_POST['id_riwayat']));
    $no_ktp            = trim(htmlspecialchars($_POST['no_ktp']));
    $legalitas_pemohon = trim(htmlspecialchars($_POST['legalitas_pemohon']));
    $legalitas_agunan  = trim(htmlspecialchars($_POST['legalitas_agunan']));
    $positif_point     = trim(htmlspecialchars($_POST['positif_point']));
    $negatif_point     = trim(htmlspecialchars($_POST['negatif_point']));
    $penyimpangan_sop  = trim(htmlspecialchars($_POST['penyimpangan_sop']));
    $syarat_khusus     = trim(htmlspecialchars($_POST['syarat_khusus']));
    $layak_kredit      = trim(htmlspecialchars($_POST['layak_kredit']));
    $layak_agunan      = trim(htmlspecialchars($_POST['layak_agunan']));

    // Validasi dasar
    $fields = [
        'ID Riwayat' => $id_riwayat,
        'No KTP' => $no_ktp,
        'Legalitas Pemohon' => $legalitas_pemohon,
        'Legalitas Agunan' => $legalitas_agunan,
        'Positif Point' => $positif_point,
        'Negatif Point' => $negatif_point,
        'Penyimpangan SOP' => $penyimpangan_sop,
        'Syarat Khusus' => $syarat_khusus,
        'Layak Kredit' => $layak_kredit,
        'Layak Agunan' => $layak_agunan
    ];

    foreach ($fields as $label => $value) {
        if (empty($value)) {
            die("Field \"$label\" tidak boleh kosong.");
        }
    }

    // Prepare statement
    $stmt = $mysqli->prepare("
        INSERT INTO legal_opini (
            id_riwayat,
            no_ktp,
            legalitas_pemohon,
            legalitas_agunan,
            positif_point,
            negatif_point,
            penyimpangan_sop,
            syarat_khusus,
            layak_kredit,
            layak_agunan
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "ssssssssss",
        $id_riwayat,
        $no_ktp,
        $legalitas_pemohon,
        $legalitas_agunan,
        $positif_point,
        $negatif_point,
        $penyimpangan_sop,
        $syarat_khusus,
        $layak_kredit,
        $layak_agunan
    );

    if ($stmt->execute()) {
        // Redirect jika berhasil
        header("Location: ../views/analisa_konsumtif.php?no_ktp=" . urlencode($no_ktp) . "&id_riwayat=" . urlencode($id_riwayat));
        exit;
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
