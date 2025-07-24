<?php
include("../Database/koneksi.php");
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

if (isset($_POST['Submit']) && $_POST['Submit'] === "Submit") {
    // Ambil dan filter data input
    $upload_time    = $_POST['upload_time'];
    $id_pegawai     = $_POST['id_pegawai'];
    $no_ktp         = $_POST['no_ktp'];
    $nama_debitur   = $_POST['nama_debitur'];
    $jk             = $_POST['jk'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tgl_lahir      = $_POST['tgl_lahir'];
    $pend_akhir     = $_POST['pend_akhir'];
    $nama_ibu       = $_POST['nama_ibu'];
    $jml_tanggungan = $_POST['jml_tanggungan'];
    $no_hp          = $_POST['no_hp'];
    $alamat         = $_POST['alamat'];
    $status_rumah   = $_POST['status_rumah'];

    // Cek apakah no_ktp sudah ada di database
    $cek_ktp = $mysqli->prepare("SELECT no_ktp FROM data_pokok WHERE no_ktp = ?");
    $cek_ktp->bind_param("s", $no_ktp);
    $cek_ktp->execute();
    $cek_ktp->store_result();

    if ($cek_ktp->num_rows > 0) {
        echo "<script>alert('Nomor KTP sudah ada'); window.history.back();</script>";
        exit;
    }
    $cek_ktp->close();

    // Gunakan prepared statement untuk INSERT
    $stmt = $mysqli->prepare("INSERT INTO data_pokok (
        upload_time,
        id_pegawai,
        no_ktp,
        nama_debitur,
        jk,
        tempat_lahir,
        tgl_lahir,
        pend_akhir,
        nama_ibu,
        jml_tanggungan,
        no_hp,
        alamat,
        status_rumah
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param(
        "sssssssssssss",
        $upload_time,
        $id_pegawai,
        $no_ktp,
        $nama_debitur,
        $jk,
        $tempat_lahir,
        $tgl_lahir,
        $pend_akhir,
        $nama_ibu,
        $jml_tanggungan,
        $no_hp,
        $alamat,
        $status_rumah
    );

    if ($stmt->execute()) {
        header("Location: ../views/data_debitur.php");
        exit;
    } else {
        echo "Tambah Data Gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
