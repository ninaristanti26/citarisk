<?php
include("../Database/koneksi.php");
include("../getCode/getLegalOpini.php");
include("../getCode/getDetail.php");

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

$legal_opini = $getLegalOpini[0] ?? [];

$legalitas_pemohon = !empty($legal_opini['legalitas_pemohon']) ? htmlspecialchars($legal_opini['legalitas_pemohon']) : '-';
$legalitas_agunan  = !empty($legal_opini['legalitas_agunan']) ? htmlspecialchars($legal_opini['legalitas_agunan']) : '-';
$positif_point     = !empty($legal_opini['positif_point']) ? htmlspecialchars($legal_opini['positif_point']) : '-';
$negatif_point     = !empty($legal_opini['negatif_point']) ? htmlspecialchars($legal_opini['negatif_point']) : '-';
$penyimpangan_sop  = !empty($legal_opini['penyimpangan_sop']) ? htmlspecialchars($legal_opini['penyimpangan_sop']) : '-';
$syarat_khusus     = !empty($legal_opini['syarat_khusus']) ? htmlspecialchars($legal_opini['syarat_khusus']) : '-';
$layak_kredit      = !empty($legal_opini['layak_kredit']) ? htmlspecialchars($legal_opini['layak_kredit']) : '-';
$layak_agunan      = !empty($legal_opini['layak_agunan']) ? htmlspecialchars($legal_opini['layak_agunan']) : '-';
?>

<table class="table table-sm table-bordered table-striped align-top text-break">
    <thead>
        <tr>
            <th colspan="2" class="d-flex justify-content-between align-items-center">
                <span><u>LEGAL OPINION</u></span>
                <?php if (
                    empty($legal_opini) &&
                    $id_pegawai_login == $_SESSION['id_pegawai'] &&
                    $kode_cabang_login == $kode_cabang_data &&
                    $id_role_login == 11
                ): ?>
                <button type="button" class="btn btn-primary btn-sm text-light" onclick="toggleFormLegalOpini()">+ Tambah Legal Opinion</button>
            </th><?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <tr><th colspan="2">I. Legalitas Pemohon</th></tr>
        <tr>
            <td colspan="2">
                <?php echo !empty($legal_opini['legalitas_pemohon']) ? 
                    htmlspecialchars($legal_opini['legalitas_pemohon']) : 'Data masih kosong'; ?>
            </td>
        </tr>

        <tr><th colspan="2">II. Legalitas Jaminan/Agunan</th></tr>
        <tr>
            <td colspan="2">
                <?php echo !empty($legal_opini['legalitas_agunan']) ? 
                    htmlspecialchars($legal_opini['legalitas_agunan']) : 'Data masih kosong'; ?>
            </td>
        </tr>

        <tr><th colspan="2">III. Positif dan Negatif Point</th></tr>
        <tr><td><strong>Positif Point:</strong></td></tr>
        <tr>
            <td colspan="2">
                <?php echo !empty($legal_opini['positif_point']) ? 
                    htmlspecialchars($legal_opini['positif_point']) : 'Data masih kosong'; ?>
            </td>
        </tr>
        <tr><td><strong>Negatif Point:</strong></td></tr>
        <tr>
            <td colspan="2">
                <?php echo !empty($legal_opini['negatif_point']) ? 
                    htmlspecialchars($legal_opini['negatif_point']) : 'Data masih kosong'; ?>
            </td>
        </tr>

        <tr><th colspan="2">IV. Penyimpangan SOP / Ketentuan Lainnya</th></tr>
        <tr>
            <td colspan="2">
                <?php echo !empty($legal_opini['penyimpangan_sop']) ? 
                    htmlspecialchars($legal_opini['penyimpangan_sop']) : 'Data masih kosong'; ?>
            </td>
        </tr>

        <tr><th colspan="2">V. Syarat Khusus</th></tr>
        <tr>
            <td colspan="2">
                <?php echo !empty($legal_opini['syarat_khusus']) ? 
                    htmlspecialchars($legal_opini['syarat_khusus']) : 'Data masih kosong'; ?>
            </td>
        </tr>

        <tr><th colspan="2">Kesimpulan</th></tr>
        <tr>
            <td colspan="2">
                Berdasarkan kondisi di atas, memberikan arti bahwa calon debitur 
                <strong><?php echo !empty($legal_opini['layak_kredit']) ? 
                    htmlspecialchars($legal_opini['layak_kredit']) : 'Data masih kosong'; ?></strong> 
                untuk menjadi subjek hukum dalam perjanjian kredit, dan legalitas agunan 
                <strong><?php echo !empty($legal_opini['layak_agunan']) ? 
                    htmlspecialchars($legal_opini['layak_agunan']) : 'Data masih kosong'; ?></strong> 
                untuk dijadikan objek agunan dalam perjanjian kredit.
            </td>
        </tr>
    </tbody>
</table>
<?php include "add/add_legal_opini.php"; ?>
<script>
// ✅ Toggle form AO
function toggleFormLegalOpini() {
    const form = document.getElementById('formLegalOpini');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}
</script>
