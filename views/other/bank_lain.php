<?php
include("../Database/koneksi.php");
include("../getCode/getBank_lain.php");
include("../getCode/getDetail.php");
include("../getCode/getRiwayat_kredit.php");

$dataDeb = $getDetail[0] ?? [];

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
?>
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">🏦 Hubungan Dengan Bank Lain</h5>

    <?php if ($id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormBankLain()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="card-body">
    <div class="table-responsive">
        </div>
        <table class="table table-striped table-bordered table-sm" width="102%" id="dataTables-example">
            <thead class="text-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Nama Lembaga</th>
                    <th>Plafon</th>
                    <th>Kolektibilitas</th>
                    <th>Bakidebet</th>
                    <th>Angsuran Perbulan</th>
                    <th>Cara Bayar</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($getBankLain as $dataBankLain) {
                    $plafon   = !empty($dataBankLain['plafon_bank_lain']) ? number_format($dataBankLain['plafon_bank_lain'], 0, ',', '.') : '-';
                    $bd       = !empty($dataBankLain['bd_bank_lain']) ? number_format($dataBankLain['bd_bank_lain'], 0, ',', '.') : '-';
                    $angsuran = !empty($dataBankLain['angs_bank_lain']) ? number_format($dataBankLain['angs_bank_lain'], 0, ',', '.') : '-';
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataBankLain['nama_lembaga'] ?? '-'); ?></td>
                    <td class="text-center"><?php echo $plafon; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataBankLain['kol_bank_lain'] ?? '-'); ?></td>
                    <td class="text-center"><?php echo $bd; ?></td>
                    <td class="text-center"><?php echo $angsuran; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataBankLain['cara_bayar_bank_lain'] ?? '-'); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataBankLain['catatan_bank_lain'] ?? '-'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
            $no_ktp     = $dataDeb['no_ktp'];
            $id_riwayat = $dataRiwayat['id_riwayat'];
            include("../getCode/getFileIdeb.php");
            if (!empty($getFileIdeb)):
                foreach ($getFileIdeb as $fileIdeb):
            ?>
                <strong><?php echo htmlspecialchars($fileIdeb['file_name_ideb']); ?></strong><br>
                <a class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($fileIdeb['file_path_ideb']); ?>" target="_blank">🔗 Lihat PDF</a> |
                <a class="btn btn-danger btn-sm" href="<?php echo htmlspecialchars($fileIdeb['file_path_ideb']); ?>" download>⬇️ Download</a>
                <div style="margin-top:10px; border: 1px solid #ccc;">
                    <iframe src="<?php echo htmlspecialchars($fileIdeb['file_path_ideb']); ?>" width="50%" height="300px"></iframe>
                </div>
            <?php
                endforeach;
            else:
            ?>
                <form action="../proses/proses_upload_ideb.php" method="post" enctype="multipart/form-data" class="d-flex align-items-center mb-1 flex-wrap" style="gap: 8px;">
                    <label for="pdf_ideb" class="mb-0">Dokumen IDeb:</label>
                    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>" readonly>
                    <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($id_riwayat); ?>" readonly>
                    <input type="file" name="pdf_ideb" id="pdf_ideb" accept="application/pdf" required>
                    <button class="btn btn-sm btn-primary" type="submit" name="submit">Upload</button>
                </form>
            <?php endif; ?>
    </div>
</div>

<div id="formBankLain" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Tambah Data Bank Lain</h5>
    <form method="POST" action="../proses/proses_bank_lain.php">
        <input type="hidden" name="update_banklain" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp'] ?? ''); ?>">
        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($_GET['id_riwayat'] ?? ''); ?>">

        <div class="form-group">
            <label for="nama_lembaga">Nama Lembaga</label>
            <input type="text" class="form-control" name="nama_lembaga" id="nama_lembaga" required>
        </div>

        <div class="form-group">
            <label for="plafon_bank_lain">Plafon</label>
            <input type="text" class="form-control" name="plafon_bank_lain" id="plafon_bank_lain" required>
        </div>

        <div class="form-group">
            <label for="kol_bank_lain">Kolektibilitas</label>
            <input type="text" class="form-control" name="kol_bank_lain" id="kol_bank_lain">
        </div>

        <div class="form-group">
            <label for="bd_bank_lain">Bakidebet</label>
            <input type="text" class="form-control" name="bd_bank_lain" id="bd_bank_lain">
        </div>

        <div class="form-group">
            <label for="angs_bank_lain">Angsuran Perbulan</label>
            <input type="text" class="form-control" name="angs_bank_lain" id="angs_bank_lain">
        </div>

        <div class="form-group">
            <label for="cara_bayar_bank_lain">Cara Pembayaran</label>
            <select class="form-control" name="cara_bayar_bank_lain" id="cara_bayar_bank_lain">
                <option value="Cash">Cash</option>
                <option value="Autodebet">Autodebet</option>
            </select>
        </div>

        <div class="form-group">
            <label for="catatan_bank_lain">Catatan</label>
            <input type="text" class="form-control" name="catatan_bank_lain" id="catatan_bank_lain">
        </div>

        <div class="d-flex justify-content-end gap-2">
            <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
            <input type="reset" name="reset" value="Reset" class="btn btn-secondary">
        </div>
    </form>
</div>

<!-- ✅ JavaScript Toggle Form -->
<script>
function toggleFormBankLain() {
    const form = document.getElementById('formBankLain');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
}
// Format angka otomatis dengan titik
document.querySelectorAll('#plafon_bank_lain, #bd_bank_lain, #angs_bank_lain').forEach(input => {
    input.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, "");
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });
});

</script>

