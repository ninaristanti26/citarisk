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

    // ✅ Ambil data putusan analis pusat
    $waktu_putus_analis_pusat      = !empty($data_putusan_analis_pusat['waktu_putus_analis_pusat']) ? htmlspecialchars($data_putusan_analis_pusat['waktu_putus_analis_pusat']) : '-';
    $putusan_analis_pusat          = !empty($data_putusan_analis_pusat['putusan_analis_pusat']) ? htmlspecialchars($data_putusan_analis_pusat['putusan_analis_pusat']) : '-';
    $syarat_tambah                 = !empty($data_putusan_analis_pusat['syarat_tambah']) ? htmlspecialchars($data_putusan_analis_pusat['syarat_tambah']) : '-';
    $plafon_rekom_analis_pusat_raw = $data_putusan_analis_pusat['plafon_rekom_analis_pusat'] ?? 0;
    $plafon_rekom_analis_pusat     = is_numeric($plafon_rekom_analis_pusat_raw) ? (float) $plafon_rekom_analis_pusat_raw : 0;
    $jw_rekom_analis_pusat         = !empty($data_putusan_analis_pusat['jw_rekom_analis_pusat']) ? htmlspecialchars($data_putusan_analis_pusat['jw_rekom_analis_pusat']) : '-';
    $metode_bayar_pusat            = !empty($data_putusan_analis_pusat['metode_bayar_pusat']) ? htmlspecialchars($data_putusan_analis_pusat['metode_bayar_pusat']) : '-';
    $status_putusan_analis_pusat   = !empty($data_putusan_analis_pusat['status_putusan_analis_pusat']) ? htmlspecialchars($data_putusan_analis_pusat['status_putusan_analis_pusat']) : '-';
    $waktu_approve_kabag           = !empty($data_putusan_analis_pusat['waktu_approve_kabag']) ? htmlspecialchars($data_putusan_analis_pusat['waktu_approve_kabag']) : '-';

    // ✅ Data pengajuan & perhitungan
    $plafon_pengajuan = !empty($dataRiwayat['plafon_pengajuan']) ? number_format($dataRiwayat['plafon_pengajuan'], 0, ',', '.') : '-';
    $jw_pengajuan     = !empty($dataRiwayat['jw_pengajuan']) ? (int) $dataRiwayat['jw_pengajuan'] : 0;

    $bunga_maks     = !empty($dataKeuangan['bunga_maks']) ? (float) $dataKeuangan['bunga_maks'] : 0;
    $bunga_perbulan = $bunga_maks / 12;

    $angsuran_pokok = ($jw_pengajuan > 0) ? $plafon_rekom_analis_pusat / $jw_pengajuan : 0;
    $angsuran_bunga = ($plafon_rekom_analis_pusat * $bunga_perbulan) / 100;
    $jumlah_angs    = $angsuran_pokok + $angsuran_bunga;
?>


<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Dasar Usulan Kasie. Analis Pusat</h5>

    <?php if (
        empty($data_putusan_analis_pusat) && // ✅ Cek data belum ada
        $kode_cabang_login === $_SESSION['kode_cabang'] &&
        $id_role_login == 9
    ): ?>
    <pre>
</pre>

        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPutusanAnalisPusat()">+ Tambah Data</button>
    <?php endif; ?>
</div>


<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Dasar Usulan Kasie. Analis Pusat</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $waktu_putus_analis_pusat; ?></td>
            </tr>
            <tr class="bg-light">
                <th colspan="3"><u>Struktur Kredit :</u></th>
            </tr>
            <tr>
                <th class="bg-light text-start">Kesimpulan</th>
                <td>:</td>
                <td class="text-start"><?php echo $putusan_analis_pusat; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Plafon</th>
                <td>:</td>
                <td class="text-start">Rp <?php echo number_format($plafon_rekom_analis_pusat, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jangka Waktu</th>
                <td>:</td>
                <td class="text-start"><?php echo $jw_rekom_analis_pusat; ?> bulan</td>
            </tr>
            <tr>
                <th class="bg-light text-start">Metode Bayar</th>
                <td>:</td>
                <td class="text-start"><?php echo $metode_bayar_pusat; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Syarat Tambahan</th>
                <td>:</td>
                <td class="text-start">
                    <?php if (!empty($data_putusan_analis_pusat) &&
                              $id_pegawai_login == $_SESSION['id_pegawai'] &&
                              $kode_cabang_login == $_SESSION['kode_cabang'] &&
                              $id_role_login == 9): ?>
                    <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormSyaratTambahPusat()">
                        + Tambah Data Syarat Tambah</button>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="bg-light text-start"></th>
                <td>:</td>
                <td class="text-start">
                <?php include "other/syarat_tambah_pusat.php"; ?>
                </td>
            </tr>   
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Status Usulan Analis</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start">
                    <span class="badge bg-<?php echo ($status_putusan_analis_pusat == 'Approved oleh Kabag. Pemasaran') ? 'success' : 'danger'; ?>">
                        <?php echo $status_putusan_analis_pusat; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th class="bg-light text-start">Tanggal Kabag. Pemasaran Approved</th>
                <td>:</td>
                <td class="text-start"><?php echo $waktu_approve_kabag; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php if (
    $id_role_login == 8 &&
    isset($data_putusan_analis_pusat['status_putusan_analis_pusat']) &&
    $data_putusan_analis_pusat['status_putusan_analis_pusat'] == 'Pending'
): ?>
    <form method="POST" action="../proses/proses_approve_analis_pusat.php" class="d-inline">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_analis_pusat" value="<?php echo $data_putusan_analis_pusat['id_putusan_analis_pusat']; ?>">
        <input type="hidden" name="aksi" value="approve">
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin Approve?')">✔ Approve</button>
    </form>

    <form method="POST" action="../proses/proses_approve_analis_pusat.php" class="d-inline ms-2">
    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>">
    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>">
        <input type="hidden" name="id_putusan_analis_pusat" value="<?php echo $data_putusan_analis_pusat['id_putusan_analis_pusat']; ?>">
        <input type="hidden" name="aksi" value="reject">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin Reject?')">✖ Reject</button>
    </form>
<?php endif; ?>
<!-- Form Tambah Data -->
<?php 
include "add/add_putusan_analis_pusat.php"; 
if (in_array($status_putusan_analis_pusat, ['Approved oleh Kabag. Pemasaran', 'Rejected'])) {
    include("other/putusan_kabag.php");
 }
?>
