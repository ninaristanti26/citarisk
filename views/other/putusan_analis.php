<?php
    include("../Database/koneksi.php");
    include("../getCode/getPutusanAO.php");
    include("../getCode/getRiwayat_kredit.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getDetail.php");
    include("../getCode/getRole.php");
    include("../getCode/getPutusanAnalis.php");
    include("../getCode/getSyaratTambah.php");

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
    $data_syarat_tambah  = $getSyaratTambah[0] ?? [];

    $waktu_putus_analis      = !empty($data_putusan_analis['waktu_putus_analis']) ? htmlspecialchars($data_putusan_analis['waktu_putus_analis']) : '-';
    $isi_putusan_analis      = !empty($data_putusan_analis['putusan_analis']) ? htmlspecialchars($data_putusan_analis['putusan_analis']) : '-';
    $plafon_rekom_analis_raw = $data_putusan_analis['plafon_rekom_analis'] ?? 0;
    $jw_rekom_analis_raw     = $data_putusan_analis['jw_rekom_analis'] ?? 0;
    $plafon_rekom_analis     = is_numeric($plafon_rekom_analis_raw) ? (float) $plafon_rekom_analis_raw : 0;
    $jw_rekom_analis         = is_numeric($jw_rekom_analis_raw) ? (float) $jw_rekom_analis_raw : 0;
    $status_putusan_analis   = !empty($data_putusan_analis['status_putusan_analis']) ? htmlspecialchars($data_putusan_analis['status_putusan_analis']) : '-';
    $waktu_approve_kaspem    = !empty($data_putusan_analis['waktu_approve_kaspem']) ? htmlspecialchars($data_putusan_analis['waktu_approve_kaspem']) : '-';
    $metode_bayar            = !empty($data_putusan_analis['metode_bayar']) ? htmlspecialchars($data_putusan_analis['metode_bayar']) : '-';
    $goldeb                  = !empty($data_putusan_analis['goldeb']) ? htmlspecialchars($data_putusan_analis['goldeb']) : '-';

    $jenis_kredit  = !empty($dataRiwayat['jenis_kredit']) ? htmlspecialchars($dataRiwayat['jenis_kredit']) : '-';
    $created_at    = !empty($data_syarat_tambah['created_at']) ? htmlspecialchars($data_syarat_tambah['created_at']) : '-';
    $syarat_tambah = !empty($data_syarat_tambah['syarat_tambah']) ? htmlspecialchars($data_syarat_tambah['syarat_tambah']) : '-';
  
?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Usulan Analis Kredit</h5>
    <?php if (
    empty($data_putusan_analis) &&
    $id_pegawai_login == $_SESSION['id_pegawai'] &&
    $kode_cabang_login == $kode_cabang_data &&
    $id_role_login == 12
): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanAnalis()">+ Tambah Data</button>
<?php endif; ?>
</div>

<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">TANGGAL USULAN ANALIS</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_analis; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">KESIMPULAN DAN SYARAT</th>
                <td>:</td>
                <td class="text-start"><?php echo $isi_putusan_analis; ?></td>
            </tr>
            <tr class="bg-light">
                <th colspan="3"><u>Struktur Kredit :</u></th>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_analis, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo number_format($jw_rekom_analis, 0, ',', '.'); ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Metode Bayar</th>
                <td>:</td>
                <td class="text-start"><?php echo $metode_bayar; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jenis Penggunaan</th>
                <td>:</td>
                <td class="text-start"><?php echo $jenis_kredit; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Golongan Debitur</th>
                <td>:</td>
                <td class="text-start"><?php echo $goldeb; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Syarat Tambahan</th>
                <td>:</td>
                <td class="text-start">
                    <?php if ($id_pegawai_login == $_SESSION['id_pegawai'] &&
                              $kode_cabang_login == $kode_cabang_data &&
                              $id_role_login == 12): ?>
                    <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormSyaratTambah()">
                        + Tambah Data Syarat Tambah</button>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="bg-light text-start"></th>
                <td>:</td>
                <td class="text-start">
                <?php include "other/syarat_tambah.php"; ?>
                </td>
            </tr>   
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Status Usulan Analis</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start">
                    <span class="badge bg-<?php echo ($status_putusan_analis == 'Approved oleh Kasie. Pemasaran') ? 'success' : 'danger'; ?>">
                        <?php echo $status_putusan_analis; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th class="bg-light text-start">Tanggal Kasie. Pemasaran Approved</th>
                <td>:</td>
                <td class="text-start"><?php echo $waktu_approve_kaspem; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php if (
    $id_role_login == 11 &&
    isset($data_putusan_analis['status_putusan_analis']) &&
    $data_putusan_analis['status_putusan_analis'] == 'Pending'
): ?>
    <form method="POST" action="../proses/proses_approve_analis.php" class="d-inline">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_analis" value="<?php echo $data_putusan_analis['id_putusan_analis']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin Approve?')">✔ Approve</button>
    </form>

    <form method="POST" action="../proses/proses_approve_analis.php" class="d-inline ms-2">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_analis" value="<?php echo $data_putusan_analis['id_putusan_analis']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>
<hr>
<!-- Form Tambah Data -->
<?php include "add/add_putusan_analis.php"; ?>
<?php include("other/review_adm.php"); ?>
<script>
function toggleFormPutusanAnalis() {
    const form = document.getElementById('formPutusanAnalis');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#plafon_rekom_analis, #plafon_rekom_analis').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, "");
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });
});
</script>
<?php
if (in_array($status_putusan_analis, ['Approved oleh Kasie. Pemasaran', 'Rejected oleh Kasie. Pemasaran'])) {
    include("other/putusan_kaspem.php");
}
?>