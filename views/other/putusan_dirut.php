<?php
// ✅ Include semua file yang dibutuhkan
include("../Database/koneksi.php");
include("../getCode/getPutusanAO.php");
include("../getCode/getRiwayat_kredit.php");
include("../getCode/getKeuangan.php");
include("../getCode/getDetail.php");
include("../getCode/getRole.php");
include("../getCode/getPutusanAnalis.php");
include("../getCode/getPutusanKaspem.php");
include("../getCode/getPutusanPinca.php");
include("../getCode/getPutusanAnalisPusat.php");
include("../getCode/getPutusanKabag.php");
include("../getCode/getPutusanKadiv.php");
include("../getCode/getPutusanDirut.php");

// ✅ Session
$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

// ✅ Data detail (didefinisikan duluan biar tidak null)
$dataDeb = $getDetail[0] ?? [];
$kode_cabang_data = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data  = $dataDeb['id_pegawai'] ?? null;

// ✅ Ambil data
$data_putusan_kadiv = $getPutusanKadiv[0] ?? [];
$dataRiwayat        = $getRiwayat_kredit[0] ?? [];
$dataKeuangan       = $options[0] ?? [];
$data_putusan_pinca = $getPutusanPinca[0] ?? [];
$data_putusan_kadiv = $getPutusanKadiv[0] ?? [];
$data_putusan_dirut = $getPutusanDirut[0] ?? [];

$jw_pengajuan = !empty($dataRiwayat['jw_pengajuan']) ? (int) $dataRiwayat['jw_pengajuan'] : 0;
$bunga_maks   = !empty($dataKeuangan['bunga_maks']) ? (float) $dataKeuangan['bunga_maks'] : 0;
$bunga_perbulan = $bunga_maks / 12;

// ✅ Ambil dan bersihkan data dari Kadiv
$waktu_putus_dirut      = !empty($data_putusan_dirut['waktu_putus_dirut']) ? htmlspecialchars($data_putusan_dirut['waktu_putus_dirut']) : '-';
$putusan_dirut          = !empty($data_putusan_dirut['putusan_dirut']) ? htmlspecialchars($data_putusan_dirut['putusan_dirut']) : '-';
$plafon_rekom_dirut_raw = $data_putusan_dirut['plafon_rekom_dirut'] ?? 0;
$plafon_rekom_dirut     = is_numeric($plafon_rekom_dirut_raw) ? (float) $plafon_rekom_dirut_raw : 0;
$jw_rekom_dirut         = !empty($data_putusan_dirut['jw_rekom_dirut']) ? htmlspecialchars($data_putusan_dirut['jw_rekom_dirut']) : '-';

?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Putusan Direktur Utama</h5>
    <?php if (
        empty($data_putusan_dirut) && // ✅ Cek data belum ada
        $kode_cabang_login === $_SESSION['kode_cabang'] &&
        $id_role_login == 5
    ): ?>
        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanDirut()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Putusan Direktur Utama</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_dirut; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Putusan Dirut</th>
                <td>:</td>
                <td class="text-start"><?php echo $putusan_dirut; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon Putusan Direktur Utama</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_dirut, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo $jw_rekom_dirut; ?> bulan</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Aksi tombol jika role adalah Pinca (id_role 5) dan status kadiv pending -->

<?php include "add/add_putusan_dirut.php"; ?>

