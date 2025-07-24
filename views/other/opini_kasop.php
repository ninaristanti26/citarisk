<?php
    include("../Database/koneksi.php");
    include("../getCode/getPutusanAO.php");
    include("../getCode/getRiwayat_kredit.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getDetail.php");
    include("../getCode/getRole.php");
    include("../getCode/getPutusanAnalis.php");
    include("../getCode/getPutusanKaspem.php");
    include("../getCode/getOpiniKasop.php");

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
    $data_opini_kasop    = $getOpiniKasop[0] ?? [];

    $opini_kasop = !empty($data_opini_kasop['opini_kasop']) ? htmlspecialchars($data_opini_kasop['opini_kasop']) : '-';
    $created_at  = !empty($data_opini_kasop['created_at']) ? htmlspecialchars($data_opini_kasop['created_at']) : '-';
?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Opini Kepala Seksi Umum dan Kepatuhan</h5>
    <?php if (
    empty($data_opini_kasop) &&
    $id_pegawai_login == $_SESSION['id_pegawai'] &&
    $kode_cabang_login == $kode_cabang_data &&
    $id_role_login == 15
): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormOpiniKasop()">+ Tambah Data</button>
<?php endif; ?>
</div>

<!-- Tabel Putusan AO -->
<div class="table-responsive text-black">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Tanggal Opini Kasie. Umum dan Kepatuhan</th>
                <td style="width: 10px;" class="text-center">:</td>
                <td class="text-start"><?php echo $created_at; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Opini Kasie. Umum dan Kepatuhan</th>
                <td>:</td>
                <td class="text-start"><?php echo $opini_kasop; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Form Tambah Data -->
<?php include "add/add_opini_kasop.php"; ?>

<script>
// ✅ Toggle form AO
function toggleFormOpiniKasop() {
    const form = document.getElementById('formOpiniKasop');
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