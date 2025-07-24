<?php
    include("../Database/koneksi.php");
    include("../getCode/getPutusanAO.php");
    include("../getCode/getRiwayat_kredit.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getDetail.php");
    include("../getCode/getRole.php");
    include("../getCode/getPutusanAnalis.php");
    include("../getCode/getPutusanKaspem.php");

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

    $waktu_putus_kaspem      = !empty($data_putusan_kaspem['waktu_putus_kaspem']) ? htmlspecialchars($data_putusan_kaspem['waktu_putus_kaspem']) : '-';
    $isi_putusan_kaspem      = !empty($data_putusan_kaspem['putusan_kaspem']) ? htmlspecialchars($data_putusan_kaspem['putusan_kaspem']) : '-';
    $plafon_rekom_kaspem_raw = $data_putusan_kaspem['plafon_rekom_kaspem'] ?? 0;
    $plafon_rekom_kaspem     = is_numeric($plafon_rekom_kaspem_raw) ? (float) $plafon_rekom_kaspem_raw : 0;
    $jw_rekom_kaspem         = $data_putusan_kaspem['jw_rekom_kaspem'] ?? 0;
    $status_putusan_kaspem   = !empty($data_putusan_kaspem['status_putusan_kaspem']) ? htmlspecialchars($data_putusan_kaspem['status_putusan_kaspem']) : '-';
    $waktu_approve_pinca     = !empty($data_putusan_kaspem['waktu_approve_pinca']) ? htmlspecialchars($data_putusan_kaspem['waktu_approve_pinca']) : '-';

    $plafon_pengajuan     = !empty($dataRiwayat['plafon_pengajuan']) ? number_format($dataRiwayat['plafon_pengajuan'], 0, ',', '.') : '-';
    $jw_pengajuan         = !empty($dataRiwayat['jw_pengajuan']) ? (int) $dataRiwayat['jw_pengajuan'] : 0;

    $bunga_maks           = !empty($dataKeuangan['bunga_maks']) ? (float) $dataKeuangan['bunga_maks'] : 0;
    $bunga_perbulan       = $bunga_maks / 12;

    // Perhitungan angsuran
    $angsuran_pokok = ($jw_pengajuan > 0) ? $plafon_rekom_kaspem / $jw_pengajuan : 0;
    $angsuran_bunga = ($plafon_rekom_kaspem * $bunga_perbulan) / 100;
    $jumlah_angs    = $angsuran_pokok + $angsuran_bunga;

?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Usulan Kepala Seksi Pemasaran</h5>
    <?php if (
    empty($data_putusan_kaspem) &&
    $id_pegawai_login == $_SESSION['id_pegawai'] &&
    $kode_cabang_login == $kode_cabang_data &&
    $id_role_login == 11
): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanKaspem()">+ Tambah Data</button>
<?php endif; ?>
</div>

<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Usulan Kasie. Pemasaran</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_kaspem; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Usulan Kasie. Pemasaran</th>
                <td>:</td>
                <td class="text-start"><?php echo $isi_putusan_kaspem; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon Usulan Kasie. Pemasaran</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_kaspem, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo number_format($jw_rekom_kaspem, 0, ',', '.'); ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Status Putusan Kasie. Pemasaran</th>
                <td>:</td>
                <td class="text-start">
                    <span class="badge bg-<?php echo ($status_putusan_kaspem == 'Approved') ? 'success' : 'danger'; ?>">
                        <?php echo $status_putusan_kaspem; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th class="bg-light text-start">Tanggal Persetujuan Pimpinan Cabang</th>
                <td>:</td>
                <td class="text-start"><?php echo $waktu_approve_pinca; ?></td>
            </tr>
        </tbody>
    </table>
</div><?php include "add/add_putusan_kaspem.php"; ?>
<hr>

<?php if (
    $id_role_login == 10 &&
    isset($data_putusan_kaspem['status_putusan_kaspem']) &&
    $data_putusan_kaspem['status_putusan_kaspem'] == 'Pending'
): ?>
    <form method="POST" action="../proses/proses_approve_kaspem.php" class="d-inline">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_kaspem" value="<?php echo $data_putusan_kaspem['id_putusan_kaspem']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin Approve?')">✔ Approve</button>
    </form>

    <form method="POST" action="../proses/proses_approve_kaspem.php" class="d-inline ms-2">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_kaspem" value="<?php echo $data_putusan_kaspem['id_putusan_kaspem']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>

<!-- Form Tambah Data -->

<?php include("other/legal_opini.php"); ?>
<script>
// ✅ Toggle form AO
function toggleFormPutusanKaspem() {
    const form = document.getElementById('formPutusanKaspem');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}
</script>
<?php
if (in_array($status_putusan_analis, ['Approved oleh Kasie. Pemasaran', 'Rejected oleh Kasie. Pemasaran'])) {
   include("other/opini_kasop.php");
   include("other/putusan_pinca.php");
}
?>