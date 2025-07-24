<?php
    include("../Database/koneksi.php");
    include("../getCode/getPutusanAO.php");
    include("../getCode/getRiwayat_kredit.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getDetail.php");
    include("../getCode/getRole.php");
    include("../getCode/getPutusanAnalis.php");
    include("../getCode/getPutusanKaspem.php");
    include("../getCode/getPutusanPinca.php");
   // include("../getCode/getBwk.php");

    $id_role_login     = $_SESSION['id_role'];
    $id_pegawai_login  = $_SESSION['id_pegawai'];
    $kode_cabang_login = $_SESSION['kode_cabang'];

    $kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
    $id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

    $data_putusan_ao     = $getPutusanAO[0] ?? [];
    $dataRiwayat         = $getRiwayat_kredit[0] ?? [];
    $dataKeuangan        = $options[0] ?? [];
    $dataDeb             = $getDetail[0] ?? [];
    $data_putusan_analis = $getPutusanAnalis[0] ?? [];
    $data_putusan_kaspem = $getPutusanKaspem[0] ?? [];
    $data_putusan_pinca  = $getPutusanPinca[0] ?? [];
    $data_bwk            = $getBwk[0] ?? [];
    $bwk_data            = $data_bwk['bwk'] ?? null;

    $waktu_putus_pinca      = !empty($data_putusan_pinca['waktu_putus_pinca']) ? htmlspecialchars($data_putusan_pinca['waktu_putus_pinca']) : '-';
    $putusan_pinca          = !empty($data_putusan_pinca['putusan_pinca']) ? htmlspecialchars($data_putusan_pinca['putusan_pinca']) : '-';
    $plafon_rekom_pinca_raw = $data_putusan_pinca['plafon_rekom_pinca'] ?? 0;
    $plafon_rekom_pinca     = is_numeric($plafon_rekom_pinca_raw) ? (float) $plafon_rekom_pinca_raw : 0;
    $jw_rekom_pinca         = !empty($data_putusan_pinca['jw_rekom_pinca']) ? htmlspecialchars($data_putusan_pinca['jw_rekom_pinca']) : '-';
    $status                 = !empty($data_putusan_pinca['status']) ? htmlspecialchars($data_putusan_pinca['status']) : '-';
    
    $plafon_pengajuan     = !empty($dataRiwayat['plafon_pengajuan']) ? number_format($dataRiwayat['plafon_pengajuan'], 0, ',', '.') : '-';
    $jw_pengajuan         = !empty($dataRiwayat['jw_pengajuan']) ? (int) $dataRiwayat['jw_pengajuan'] : 0;

?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Putusan Kepala Cabang</h5>
    <?php if (
    empty($data_putusan_pinca) &&
    $id_pegawai_login == $_SESSION['id_pegawai'] &&
    $kode_cabang_login == $kode_cabang_data &&
    $id_role_login == 10
): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanPinca()">+ Tambah Data</button>
<?php endif; ?>
</div>

<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Putusan Pimpinan Cabang</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_pinca; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Putusan Pimpinan Cabang</th>
                <td>:</td>
                <td class="text-start"><?php echo $putusan_pinca; ?></td>
            </tr>
            <tr class="bg-light">
                <th colspan="3"><u>USULAN PLAFON PUTUSAN KEPALA CABANG</u></th>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon Putusan Pimpinan Cabang</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_pinca, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo $jw_rekom_pinca; ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Status</th>
                <td>:</td>
                <td class="text-start"> <span class="badge bg-<?php echo ($status == 'Selesai! Kredit Masuk BWK Cabang') ? 'success' : 'danger'; ?>">
                        <?php echo $status; ?>
                    </span></td>
            </tr>
        </tbody>
    </table>
</div>
<?php if (
    $id_role_login == 9 &&
    isset($data_putusan_pinca['status']) &&
    $data_putusan_pinca['status'] == 'Pending! Kredit Masuk BWK Pusat'
): ?>
    <form method="POST" action="../proses/proses_approve_pinca.php" class="d-inline">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_pinca" value="<?php echo $data_putusan_pinca['id_putusan_pinca']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin Proses?')">✔ Pengajuan Kredit Diproses</button>
    </form>

    <form method="POST" action="../proses/proses_approve_pinca.php" class="d-inline ms-2">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_pinca" value="<?php echo $data_putusan_pinca['id_putusan_pinca']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>

<?php include "add/add_putusan_pinca.php"; ?>
<!-- Form Tambah Data -->
<?php
if (in_array($status, ['Kredit Diproses oleh Analis Pusat', 'Rejected'])) {
   include("other/putusan_analis_pusat.php");
}
?>
