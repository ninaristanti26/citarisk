<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getRiwayat_kredit.php');
include(__DIR__ . '/../../getCode/getRole.php');
$id_role_login = $_SESSION['id_role'];
?>
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📑 Usulan Pengajuan Kredit</h5>
    <?php if ($id_role_login == 13): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleRiwayatKreditForm()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="card-body">
    <div class="table-responsive" align="center">
    <table class="table table-bordered table-striped table-hover" id="dataTables-example" width="100%">
    <thead class="thead-light text-center align-middle">
        <tr>
            <th>No.</th>
            <th>Tanggal Input Pengajuan</th>
            <th>Jenis Kredit</th>
            <th>Plafon</th>
            <th>Jangka Waktu</th>
            <th>Tujuan Pengajuan Kredit</th>
            <th>Status</th>
            <th>Tanggal Approved</th>
            <th class="text-nowrap">Aksi</th>
        </tr>
    </thead>
    <tbody class="text-center align-middle">
    <?php
    $no = 1;
    foreach ($getRiwayat_kredit as $dataRiwayat):
        $no_ktp_encoded      = urlencode($dataRiwayat['no_ktp']);
        $id_riwayat_encoded  = urlencode($dataRiwayat['id_riwayat']);
        $id_pegawai_encoded  = urlencode($dataRiwayat['id_pegawai']);

        $plafon_pengajuan = !empty($dataRiwayat['plafon_pengajuan']) 
            ? number_format($dataRiwayat['plafon_pengajuan'], 0, ',', '.') 
            : '-';

        $jw_pengajuan = !empty($dataRiwayat['jw_pengajuan']) 
            ? number_format($dataRiwayat['jw_pengajuan'], 0, ',', '.') 
            : '-';

        $tujuan_pengajuan = !empty($dataRiwayat['tujuan_pengajuan']) 
            ? htmlspecialchars($dataRiwayat['tujuan_pengajuan']) 
            : '-';
        
        $status_rk = !empty($dataRiwayat['status_rk']) 
            ? htmlspecialchars($dataRiwayat['status_rk']) 
            : '-';
        
        $approved_at = !empty($dataRiwayat['approved_at']) 
            ? htmlspecialchars($dataRiwayat['approved_at']) 
            : '-';
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo htmlspecialchars($dataRiwayat['update_riwayat_kredit'] ?? '-'); ?></td>
        <td><?php echo htmlspecialchars($dataRiwayat['jenis_kredit'] ?? '-'); ?></td>
        <td><?php echo $plafon_pengajuan; ?></td>
        <td><?php echo $jw_pengajuan; ?> bulan</td>
        <td><?php echo $tujuan_pengajuan; ?></td>
        <td><span class="badge bg-secondary"><?php echo $status_rk; ?></span></td>
        <td><?php echo $approved_at; ?></td>
        <td>
            <div class="d-grid gap-1 text-nowrap">
                <!-- Lihat Analisa -->
                  <form method="POST" action="analisa_konsumtif">
                        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataRiwayat['no_ktp']); ?>">
                        <input type="hidden" name="id_riwayat" value="<?php echo htmlspecialchars($dataRiwayat['id_riwayat']); ?>">
                        <button type="submit" class="btn btn-sm btn-primary">📄 Analisa</button>
                    </form>
                <!--<a href="analisa_konsumtif?no_ktp=<?php echo $no_ktp_encoded; ?>&id_riwayat=<?php echo $id_riwayat_encoded; ?>" 
                   class="btn btn-sm btn-primary" title="Lihat Analisa">
                    📄 Analisa
                </a>-->
                |
                <!-- Edit Pengajuan (jika pemilik data) -->
                <?php if ($_SESSION['id_pegawai'] == $dataDeb['id_pegawai'] && $status_rk === 'Pengajuan'): ?>
                    <button type="button" class="btn btn-sm btn-warning" onclick="toggleFormEditRiwayatKredit()" title="Edit Pengajuan">
                        ✏️ Edit Pengajuan
                    </button>
                <?php endif; ?>
                |
                <!-- Tracking -->
                <a href="treking?no_ktp=<?php echo $no_ktp_encoded; ?>&id_riwayat=<?php echo $id_riwayat_encoded; ?>" 
                   class="btn btn-sm btn-danger" title="Tracking Kredit">
                    🚚 Tracking
                </a>
                |
                <!-- Putusan -->
                <a href="other/cek_putusan_kredit.php?no_ktp=<?php echo $no_ktp_encoded; ?>&id_riwayat=<?php echo $id_riwayat_encoded; ?>&id_pegawai=<?php echo $id_pegawai_encoded; ?>" 
                   class="btn btn-sm btn-success" title="Lihat Putusan Kredit">
                    ✅ Putusan
                </a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>


    </div>
</div>

<div id="formRiwayatKredit" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Tambah Usulan Pengajuan Kredit</h5>
    <form method="POST" action="../proses/proses_riwayat_kredit.php">
        <input type="hidden" name="update_riwayat_kredit" value="<?php echo (new DateTime())->format('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($_GET['no_ktp'] ?? ''); ?>">
        
        <!-- Hidden inputs for id_pegawai and kode_cabang -->
        <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $_SESSION['id_pegawai']; ?>">
        <input type="hidden" name="kode_cabang" id="kode_cabang" value="<?php echo $_SESSION['kode_cabang']; ?>">

        <!-- Form for jenis kredit -->
        <div class="form-group">
            <label for="jenis_kredit">Jenis Kredit</label>
            <select class="form-control" name="jenis_kredit">
                <option>Konsumtif</option>
                <option>Modal Kerja</option>
                <option>Investasi</option>
            </select>
        </div>
        <!-- Form for plafon pengajuan -->
        <div class="form-group">
            <label for="plafon_pengajuan">Plafon Pengajuan</label>
            <input type="text" class="form-control" name="plafon_pengajuan" id="plafon_pengajuan" required>
        </div>

        <!-- Form for jangka waktu pengajuan -->
        <div class="form-group">
            <label for="jw_pengajuan">Jangka Waktu Pengajuan</label>
            <input type="number" class="form-control" name="jw_pengajuan" id="jw_pengajuan" required>
        </div>

        <div class="form-group">
            <label for="tujuan_pengajuan">Tujuan Pengajuan Kredit</label>
            <input type="text" class="form-control" name="tujuan_pengajuan" id="tujuan_pengajuan" required>
        </div>
        <input type="hidden" name="status" value="Pending">
        <?php
            $approved_at = empty($approved_at) 
                ? '0000-00-00 00:00:00' 
                : (new DateTime())->format('Y-m-d H:i:s');
        ?>
        <input type="hidden" name="approved_at" value="0000-00-00 00:00:00">

        <div class="d-flex justify-content-end gap-2">
            <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
            <input type="reset" name="reset" value="Reset" class="btn btn-secondary">
        </div>
    </form>
</div>
<?php include(__DIR__ . '/../edit/edit_riwayat_kredit.php'); ?>
<script>
// Toggle form visibility
function toggleRiwayatKreditForm() {
    const form = document.getElementById('formRiwayatKredit');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
}

// Automatic number formatting for plafon_pengajuan input
document.querySelectorAll('#plafon_pengajuan').forEach(input => {
    input.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, "");
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });
});
function toggleFormEditRiwayatKredit() {
    const form = document.getElementById('formEditRiwayatKredit');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>
