<?php
    include("../Database/koneksi.php");
    include("../getCode/getPutusanAO.php");
    include("../getCode/getRiwayat_kredit.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getDetail.php");
    include("../getCode/getRole.php");

    $id_role_login = $_SESSION['id_role'];

    $data_putusan_ao = $getPutusanAO[0] ?? [];
    $dataRiwayat     = $getRiwayat_kredit[0] ?? [];
    $dataKeuangan    = $options[0] ?? [];
    $dataDeb         = $getDetail[0] ?? [];

    $waktu_putus_ao       = !empty($data_putusan_ao['waktu_putus_ao']) ? htmlspecialchars($data_putusan_ao['waktu_putus_ao']) : '-';
    $isi_putusan_ao       = !empty($data_putusan_ao['putusan_ao']) ? htmlspecialchars($data_putusan_ao['putusan_ao']) : '-';
    $plafon_rekom_ao_raw  = $data_putusan_ao['plafon_rekom_ao'] ?? 0;
    $plafon_rekom_ao      = is_numeric($plafon_rekom_ao_raw) ? (float) $plafon_rekom_ao_raw : 0;
    $status_putusan_ao    = !empty($data_putusan_ao['status_putusan_ao']) ? htmlspecialchars($data_putusan_ao['status_putusan_ao']) : '-';
    $waktu_approve_analis = !empty($data_putusan_ao['waktu_approve_analis']) ? htmlspecialchars($data_putusan_ao['waktu_approve_analis']) : '-';

    $plafon_pengajuan     = !empty($dataRiwayat['plafon_pengajuan']) ? number_format($dataRiwayat['plafon_pengajuan'], 0, ',', '.') : '-';
    $jw_pengajuan         = !empty($dataRiwayat['jw_pengajuan']) ? (int) $dataRiwayat['jw_pengajuan'] : 0;

    $bunga_maks           = !empty($dataKeuangan['bunga_maks']) ? (float) $dataKeuangan['bunga_maks'] : 0;
    $bunga_perbulan       = $bunga_maks / 12;

    // Perhitungan angsuran
    $angsuran_pokok = ($jw_pengajuan > 0) ? $plafon_rekom_ao / $jw_pengajuan : 0;
    $angsuran_bunga = ($plafon_rekom_ao * $bunga_perbulan) / 100;
    $jumlah_angs    = $angsuran_pokok + $angsuran_bunga;

    // Pegawai yang sedang login
$id_pegawai_login = $_SESSION['id_pegawai'];

// Pegawai yang datanya sedang ditampilkan
$id_pegawai_data = $dataDeb['id_pegawai'] ?? null;
?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Putusan AO</h5>
    <?php if (
    empty($data_putusan_ao['waktu_putus_ao']) &&
    empty($data_putusan_ao['putusan_ao']) &&
    empty($data_putusan_ao['plafon_rekom_ao']) &&
    empty($data_putusan_ao['status_putusan_ao']) &&
    empty($data_putusan_ao['waktu_approve_analis']) &&
    $id_pegawai_login == $id_pegawai_data
): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanAO()">+ Tambah Data</button>
<?php endif; ?>
</div>

<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Putusan AO</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_ao; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Putusan AO</th>
                <td>:</td>
                <td class="text-start"><?php echo $isi_putusan_ao; ?></td>
            </tr>
            <tr class="bg-light">
                <th colspan="3"><u>USULAN PLAFON REKOMENDASI AO</u></th>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon Rekomendasi AO</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_ao, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo number_format($jw_pengajuan, 0, ',', '.'); ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Angsuran Pokok</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($angsuran_pokok, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Angsuran Bunga</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($angsuran_bunga, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jumlah Angsuran</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($jumlah_angs, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Status Putusan AO</th>
                <td>:</td>
                <td class="text-start">
                    <span class="badge bg-<?php echo ($status_putusan_ao == 'Approved') ? 'success' : 'danger'; ?>">
                        <?php echo $status_putusan_ao; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th class="bg-light text-start">Tanggal Analis Approved</th>
                <td>:</td>
                <td class="text-start"><?php echo $waktu_approve_analis; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php if (
    $id_role_login == 12 &&
    isset($data_putusan_ao['status_putusan_ao']) &&
    $data_putusan_ao['status_putusan_ao'] == 'Pending'
): ?>
    <form method="POST" action="../proses/proses_approve_ao.php" class="d-inline">
        <input type="hidden" name="id_putusan_ao" value="<?php echo $data_putusan_ao['id_putusan_ao']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin Approve?')">✔ Approve</button>
    </form>

    <form method="POST" action="../proses/proses_approve_ao.php" class="d-inline ms-2">
        <input type="hidden" name="id_putusan_ao" value="<?php echo $data_putusan_ao['id_putusan_ao']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>

<!-- Form Tambah Data -->
<?php include "add/add_putusan_ao.php"; ?>

<script>
// ✅ Toggle form AO
function toggleFormPutusanAO() {
    const form = document.getElementById('formPutusanAO');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}
</script>
<?php
if (in_array($status_putusan_ao, ['Approved', 'Rejected'])) {
    include("other/putusan_analis.php");
}
?>
