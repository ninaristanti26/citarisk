<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getInfoLain.php');
include(__DIR__ . '/../../getCode/getDetail.php');


$dataInfoLain = $options[0] ?? [];
$dataDeb = $getDetail[0] ?? [];

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$referensi          = !empty($dataInfoLain['referensi']) ? htmlspecialchars($dataInfoLain['referensi']) : '-';
$trade              = !empty($dataInfoLain['trade']) ? htmlspecialchars($dataInfoLain['trade']) : '-';
$keluarga_terdekat  = !empty($dataInfoLain['keluarga_terdekat']) ? htmlspecialchars($dataInfoLain['keluarga_terdekat']) : '-';
$no_hp_keluarga     = !empty($dataInfoLain['no_hp_keluarga']) ? htmlspecialchars($dataInfoLain['no_hp_keluarga']) : '-';
$aktivitas_keuangan = !empty($dataInfoLain['aktivitas_keuangan']) ? htmlspecialchars($dataInfoLain['aktivitas_keuangan']) : '-';

$id_pegawai_login = $_SESSION['id_pegawai'];
$id_pegawai_data  = $dataDeb['id_pegawai'] ?? null;
$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📚 Informasi Lainnya Calon Debitur</h5>
    <?php if (
        $referensi == '-' && 
        $trade == '-' &&
        $keluarga_terdekat == '-' &&
        $no_hp_keluarga == '-' &&
        $aktivitas_keuangan == '-' &&
        $id_pegawai_login == $_SESSION['id_pegawai'] &&
        $kode_cabang_login == $kode_cabang_data &&
        $id_role_login == 12
    ): ?>
        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleInfoFormInfoLain()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="table-responsive p-3">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Referensi Tetangga Sekitar</th>
                <td class="text-center" style="width: 10px;">:</td>
                <td class="text-left"><?php echo $referensi; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Trade Checking</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo $trade; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Keluarga Terdekat yang Bisa Dihubungi</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo $keluarga_terdekat; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">No. HP</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo $no_hp_keluarga; ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Aktivitas Keuangan</th>
                <td class="text-center">:</td>
                <td class="text-left"><?php echo $aktivitas_keuangan; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php //if ($id_pegawai_login === $id_pegawai_data): ?>
<!-- FORM INPUT INFO LAIN -->
<div id="formInfoLain" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Tambah Informasi Lain</h5>
    <form method="POST" action="../proses/proses_info_lain.php">
        <input type="hidden" name="update_info" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp'] ?? ''); ?>">

        <div class="form-group">
            <label for="referensi">Referensi Tetangga</label>
            <input type="text" class="form-control" name="referensi" id="referensi" required>
        </div>

        <div class="form-group">
            <label for="trade">Trade Checking</label>
            <input type="text" class="form-control" name="trade" id="trade" required>
        </div>

        <div class="form-group">
            <label for="keluarga_terdekat">Keluarga Terdekat yang Bisa Dihubungi</label>
            <input type="text" class="form-control" name="keluarga_terdekat" id="keluarga_terdekat" required>
        </div>

        <div class="form-group">
            <label for="no_hp_keluarga">No. HP Keluarga</label>
            <input type="text" class="form-control" name="no_hp_keluarga" id="no_hp_keluarga" required>
        </div>

        <div class="form-group">
            <label for="aktivitas_keuangan">Aktivitas Keuangan</label>
            <textarea class="form-control" name="aktivitas_keuangan" id="aktivitas_keuangan" rows="3"></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
            <input type="reset" name="reset" value="Reset" class="btn btn-secondary">
        </div>
    </form>
</div>
<?php //endif; ?>
<script>
function toggleInfoFormInfoLain() {
    const form = document.getElementById('formInfoLain');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}
</script>
