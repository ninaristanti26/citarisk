<?php 
include("../Database/koneksi.php");

$no_ktp     = $mysqli->real_escape_string($_GET['no_ktp']);
$id_riwayat = $mysqli->real_escape_string($_GET['id_riwayat']); 

// Ambil semua data bank lain untuk no_ktp
$query = "SELECT bank_lain.*, data_pokok.nama_debitur
          FROM bank_lain
          INNER JOIN data_pokok ON bank_lain.no_ktp = data_pokok.no_ktp
          WHERE bank_lain.no_ktp = '$no_ktp'
          AND bank_lain.id_riwayat = '$id_riwayat'";
$result = $mysqli->query($query);
$getBankLain = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Ambil total angsuran
$queryTotal = "SELECT SUM(angs_bank_lain) AS total_angsuran 
               FROM bank_lain 
               WHERE no_ktp = '$no_ktp'
               AND id_riwayat = '$id_riwayat'";
$resultTotal = $mysqli->query($queryTotal);
$total = $resultTotal->fetch_assoc();

$total_angsuran = $total['total_angsuran'] ?? 0;

$mysqli->close();
?>
