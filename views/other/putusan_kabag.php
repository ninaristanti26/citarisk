<?php
    // ✅ Include file & ambil data
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

    // ✅ Session login
    $id_role_login     = $_SESSION['id_role'];
    $id_pegawai_login  = $_SESSION['id_pegawai'];
    $kode_cabang_login = $_SESSION['kode_cabang'];

    // ✅ Data detail (pindah ke atas biar nggak null)
    $dataDeb = $getDetail[0] ?? [];
    $kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
    $id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

    // ✅ Ambil data lain
    $data_putusan_ao           = $getPutusanAO[0] ?? [];
    $dataRiwayat               = $getRiwayat_kredit[0] ?? [];
    $dataKeuangan              = $options[0] ?? [];
    $data_putusan_analis       = $getPutusanAnalis[0] ?? [];
    $data_putusan_kaspem       = $getPutusanKaspem[0] ?? [];
    $data_putusan_pinca        = $getPutusanPinca[0] ?? [];
    $data_bwk                  = $getBwk[0] ?? [];
    $data_putusan_analis_pusat = $getPutusanAnalisPusat[0] ?? [];
    $data_putusan_kabag        = $getPutusanKabag[0] ?? [];

    // ✅ Ambil data putusan analis pusat
    $waktu_putus_kabag      = !empty($data_putusan_kabag['waktu_putus_kabag']) ? htmlspecialchars($data_putusan_kabag['waktu_putus_kabag']) : '-';
    $putusan_kabag          = !empty($data_putusan_kabag['putusan_kabag']) ? htmlspecialchars($data_putusan_kabag['putusan_kabag']) : '-';
    $plafon_rekom_kabag_raw = $data_putusan_kabag['plafon_rekom_kabag'] ?? 0;
    $plafon_rekom_kabag     = is_numeric($plafon_rekom_kabag_raw) ? (float) $plafon_rekom_kabag_raw : 0;
    $jw_rekom_kabag         = !empty($data_putusan_kabag['jw_rekom_kabag']) ? htmlspecialchars($data_putusan_kabag['jw_rekom_kabag']) : '-';
    $catatan                = !empty($data_putusan_kabag['catatan']) ? htmlspecialchars($data_putusan_kabag['catatan']) : '-';
    $status_putusan_kabag   = !empty($data_putusan_kabag['status_putusan_kabag']) ? htmlspecialchars($data_putusan_kabag['status_putusan_kabag']) : '-';
    $waktu_approve_kadiv    = !empty($data_putusan_kabag['waktu_approve_kadiv']) ? htmlspecialchars($data_putusan_kabag['waktu_approve_kadiv']) : '-';
?>


<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Usulan Kepala Bagian Pemasaran</h5>

    <?php if (
        empty($data_putusan_kabag) && // ✅ Cek data belum ada
        $kode_cabang_login === $_SESSION['kode_cabang'] &&
        $id_role_login == 8
    ): ?>
    <pre>
<?php
   // var_dump($data_putusan_analis_pusat);
   // var_dump($kode_cabang_login, $_SESSION['kode_cabang']);
   // var_dump($id_role_login);
?>
</pre>

        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanKabag()">+ Tambah Data</button>
    <?php endif; ?>
</div>


<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Usulan Kabag. Pemasaran</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_kabag; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Kesimpulan Kabag. Pemasaran</th>
                <td>:</td>
                <td class="text-start"><?php echo $putusan_kabag; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon Usulan Kabag. Pemasaran</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_kabag, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo $jw_rekom_kabag; ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Catatan</th>
                <td>:</td>
                <td class="text-start"><?php echo $catatan; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Status Putusan Kabag. Pemasaran</th>
                <td>:</td>
                <td class="text-start">
                    <span class="badge bg-<?php echo ($status_putusan_kabag == 'Approved oleh Kadiv. Pemasaran') ? 'success' : 'danger'; ?>">
                        <?php echo $status_putusan_kabag; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th class="bg-light text-start">Tanggal Approved Kepala Divisi Pemasaran</th>
                <td>:</td>
                <td class="text-start"><?php echo $waktu_approve_kadiv; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php include("other/opini_kepatuhan.php"); ?>
<?php if (
    $id_role_login == 7 &&
    isset($data_putusan_kabag['status_putusan_kabag']) &&
    $data_putusan_kabag['status_putusan_kabag'] == 'Pending'
): ?>
    <form method="POST" action="../proses/proses_approve_kabag.php" class="d-inline">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_kabag" value="<?php echo $data_putusan_kabag['id_putusan_kabag']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin Approve?')">✔ Approve</button>
    </form>

    <form method="POST" action="../proses/proses_approve_kabag.php" class="d-inline ms-2">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_kabag" value="<?php echo $data_putusan_kabag['id_putusan_kabag']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>
<!-- Form Tambah Data -->
<?php 
include "add/add_putusan_kabag.php"; 
if (in_array($status_putusan_kabag, ['Approved oleh Kadiv. Pemasaran', 'Rejected'])) {
    include("other/putusan_kadiv.php");
 }
?>
