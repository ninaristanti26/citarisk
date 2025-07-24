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
//include("../getCode/getBwk.php");
include("../getCode/getPutusanKadiv.php");

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


// ✅ Ambil dan bersihkan data dari Kadiv
$waktu_putus_kadiv      = !empty($data_putusan_kadiv['waktu_putus_kadiv']) ? htmlspecialchars($data_putusan_kadiv['waktu_putus_kadiv']) : '-';
$putusan_kadiv          = !empty($data_putusan_kadiv['putusan_kadiv']) ? htmlspecialchars($data_putusan_kadiv['putusan_kadiv']) : '-';
$plafon_rekom_kadiv_raw = $data_putusan_kadiv['plafon_rekom_kadiv'] ?? 0;
$plafon_rekom_kadiv     = is_numeric($plafon_rekom_kadiv_raw) ? (float) $plafon_rekom_kadiv_raw : 0;
$jw_rekom_kadiv         = !empty($data_putusan_kadiv['jw_rekom_kadiv']) ? htmlspecialchars($data_putusan_kadiv['jw_rekom_kadiv']) : '-';
$status_kadiv           = !empty($data_putusan_kadiv['status_kadiv']) ? htmlspecialchars($data_putusan_kadiv['status_kadiv']) : '-';

?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Putusan Kepala Divisi Pemasaran</h5>
    <?php if (
        empty($data_putusan_kadiv) && // ✅ Cek data belum ada
        $kode_cabang_login === $_SESSION['kode_cabang'] &&
        $id_role_login == 7
    ): ?>
        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanKadiv()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Putusan Kadiv</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_kadiv; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Putusan Kadiv</th>
                <td>:</td>
                <td class="text-start"><?php echo $putusan_kadiv; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon Putusan Kadiv</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_kadiv, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo $jw_rekom_kadiv; ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Status Putusan Kadiv</th>
                <td>:</td>
                <td class="text-start">
                    <span class="badge bg-<?php echo ($status_kadiv == 'Kredit Disetujui oleh Dirut') ? 'success' : 'danger'; ?>">
                        <?php echo $status_kadiv; ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Aksi tombol jika role adalah Pinca (id_role 5) dan status kadiv pending -->
<?php if (
    $id_role_login == 5 &&
    isset($data_putusan_kadiv['status_kadiv']) &&
    $data_putusan_kadiv['status_kadiv'] === 'Pending! Kredit Masuk BWK Dirut'
): ?>
    <form method="POST" action="../proses/proses_approve_dirut.php" class="d-inline">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_kadiv" value="<?php echo $data_putusan_kadiv['id_putusan_kadiv']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin Proses?')">✔ Approve</button>
    </form>

    <form method="POST" action="../proses/proses_approve_dirut.php" class="d-inline ms-2">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_dirut" value="<?php echo $data_putusan_dirut['id_putusan_dirut']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>

<?php include "add/add_putusan_kadiv.php"; ?>

<?php
// ✅ Tampilkan lanjutannya jika status sesuai
if (in_array($status_kadiv, ['Kredit Disetujui oleh Dirut', 'Rejected'])) {
    include("other/putusan_dirut.php");
}
?>
