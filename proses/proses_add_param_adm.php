<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $jenis_adm = $_POST['jenis_adm'];
    
    // Gunakan prepared statement untuk INSERT
    $stmt = $mysqli->prepare("INSERT INTO adm (jenis_adm) 
                              VALUES (?)");

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "s",
        $jenis_adm);

    if ($stmt->execute()) {
        header("Location: ../views/adm.php");
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
