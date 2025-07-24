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
    include("../getCode/getOpiniKepatuhan.php");

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
    $data_opini_kepatuhan      = $getOpiniKepatuhan[0] ?? [];

    $opini_kepatuhan = !empty($data_opini_kepatuhan['opini_kepatuhan']) ? htmlspecialchars($data_opini_kepatuhan['opini_kepatuhan']) : '-';
    $created_at      = !empty($data_opini_kepatuhan['created_at']) ? htmlspecialchars($data_opini_kepatuhan['created_at']) : '-';
?>
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Opini Kepatuhan</h5>

    <?php if (
        empty($data_opini_kepatuhan) && // ✅ Cek data belum ada
        $kode_cabang_login === $_SESSION['kode_cabang'] &&
        $id_role_login == 6
    ): ?>
    <pre>
<?php
   // var_dump($data_opini_kepatuhan);
   //  var_dump($kode_cabang_login, $_SESSION['kode_cabang']);
   // var_dump($id_role_login);
?>
</pre>

        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormOpiniKepatuhan()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Opini Kepatuhan</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $created_at; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Opini Kepatuhan</th>
                <td>:</td>
                <td class="text-start"><?php echo $opini_kepatuhan; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Form Tambah Data -->
<?php include "add/add_opini_kepatuhan.php"; ?>

<script>
// ✅ Toggle form AO
function toggleFormOpiniKepatuhan() {
    const form = document.getElementById('formOpiniKepatuhan');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}
</script>
<?php
//if (in_array($status_putusan_kaspem, ['Approved', 'Rejected'])) {
  // include("other/putusan_pinca.php");
//}
?>