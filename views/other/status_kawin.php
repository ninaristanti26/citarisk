<!-- Header -->
<?php
    include(__DIR__ . '/../../Database/koneksi.php');
    include(__DIR__ . '/../../getCode/getStatus_kawin.php');
    include(__DIR__ . '/../../getCode/getDetail.php');

    $dataStat_kawin = $options[0] ?? [];
    $dataDeb        = $getDetail[0] ?? [];

    $status_kawin = htmlspecialchars($dataStat_kawin['status_kawin'] ?? '-');
    $nama_pasangan = htmlspecialchars($dataStat_kawin['nama_pasangan'] ?? '-');
    $tempat = htmlspecialchars($dataStat_kawin['tempat_lahir_pasangan'] ?? '-');
    $tanggal = htmlspecialchars($dataStat_kawin['tgl_lahir_pasangan'] ?? '-');

    // Pegawai yang sedang login
    $id_pegawai_login = $_SESSION['id_pegawai'];

    // Pegawai yang datanya sedang ditampilkan
    $id_pegawai_data = $dataDeb['id_pegawai'] ?? null;
?>
<div class="card-header bg-dark text-white">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <h5 class="mb-2 mb-md-0 text-white">
            👩‍❤️‍👨 Data Pasangan
        </h5>

        <div class="d-flex gap-2 flex-wrap">
            <?php if (
                $status_kawin == '-' && 
                $nama_pasangan == '-' &&
                $tempat == '-' &&
                $tanggal == '-' &&
                $id_pegawai_login == $id_pegawai_data
            ): ?>
                <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormPasangan()">
                    + Tambah Data
                </button>
            <?php endif; ?>

            <?php if ($_SESSION['id_pegawai'] == $dataDeb['id_pegawai']): ?>
                <button type="button" class="btn btn-warning btn-sm" onclick="toggleFormEditPasangan()">
                    ✏️ Edit
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- Tabel Data Status Kawin -->
<div class="table-responsive mt-2">
    
    <table class="table table-bordered table-hover table-sm mb-0">
    <tbody>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Status Kawin</th>
            <td style="width: 10px;" class="text-center">:</td>
            <td class="text-start"><?php echo htmlspecialchars($status_kawin); ?> | 
                                   <span class="badge badge-danger">Dokumen Buku Nikah</span></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Nama Pasangan</th>
            <td class="text-center">:</td>
            <td class="text-start"><?php echo htmlspecialchars($nama_pasangan); ?></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Tempat dan Tanggal Lahir Pasangan</th>
            <td class="text-center">:</td>
            <td class="text-start"><?php echo htmlspecialchars($tempat . ', ' . $tanggal); ?></td>
        </tr>
        <th class="bg-light text-start" style="width: 300px;">Surat Nikah/Akta Cerai/Lainnya</th>
            <td class="text-center">:</td>
            <td class="text-start">
            <div class="mt-2">
            <?php
            $no_ktp = $dataDeb['no_ktp'];
            include(__DIR__ . '/../../getCode/getFileSuratNikah.php');
            if (!empty($getFileSuratNikah)):
                foreach ($getFileSuratNikah as $fileSuratNikah):
            ?>
                    <strong><?php echo htmlspecialchars($fileSuratNikah['file_name_surat_nikah']); ?></strong><br>
                    <a class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($fileSuratNikah['file_path_surat_nikah']); ?>" target="_blank">🔗</a> |
                    <a class="btn btn-danger btn-sm" href="<?php echo htmlspecialchars($fileSuratNikah['file_path_surat_nikah']); ?>" download>⬇️</a> |
                    <form method="post" action="../proses/proses_delete_surat_nikah.php" onsubmit="return confirm('Yakin ingin menghapus file ini?');" style="display:inline;">
                        <input type="hidden" name="id_file_surat_nikah" value="<?php echo $fileSuratNikah['id_file_surat_nikah']; ?>">
                        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataDeb['no_ktp']); ?>">
                        <button type="submit" class="btn btn-sm btn-warning">🗑️</button>
                    </form>
                    <!--<div style="margin-top:10px; border: 1px solid #ccc;">
                        <iframe src="<?php echo htmlspecialchars($fileSuratNikah['file_path_surat_nikah']); ?>" width="50%" height="400px"></iframe>
                    </div>-->
            <?php
                endforeach;
            else:
            ?>
                <form action="../proses/proses_upload_surat_nikah.php" method="post" enctype="multipart/form-data" class="d-flex align-items-center mb-1 flex-wrap" style="gap: 8px;">
                    <label for="pdf_sk" class="mb-0">Surat Nikah/Akta Cerai/Lainnya :</label>
                    <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($no_ktp); ?>" readonly>
                    <input type="file" name="pdf_surat_nikah" id="pdf_surat_nikah" accept="application/pdf" required>
                    <button class="btn btn-sm btn-primary" type="submit" name="submit">Upload</button>
                </form>
            <?php endif; ?>
        </div>  
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;"></th>
            <td class="text-center"></td>
            <td class="text-start"></td>
        </tr>
    </tbody>
</table>
</div>

<!-- Form Input - Initially Hidden -->
<div id="formStatusKawin" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Tambah Data Status Kawin</h5>
    <form method="POST" action="../proses/proses_add_pasangan.php">
        <input type="hidden" name="no_ktp" value="<?php echo $_GET['no_ktp'] ?? ''; ?>">
        <input type="hidden" name="update_kawin" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <div class="mb-3">
            <label for="status_kawin" class="form-label">Status Perkawinan</label>
            <select class="form-control" name="status_kawin" id="status_kawin" required>
                <option value="">Pilih Status</option>
                <option value="Kawin">Kawin</option>
                <option value="Tidak Kawin">Tidak Kawin</option>
                <option value="Janda/Duda">Janda/Duda</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_pasangan" class="form-label">Nama Pasangan</label>
            <input type="text" class="form-control" name="nama_pasangan" id="nama_pasangan" required>
        </div>

        <div class="mb-3">
            <label for="tempat_lahir_pasangan" class="form-label">Tempat Lahir Pasangan</label>
            <input type="text" class="form-control" name="tempat_lahir_pasangan" id="tempat_lahir_pasangan" required>
        </div>

        <div class="mb-3">
            <label for="tgl_lahir_pasangan" class="form-label">Tanggal Lahir Pasangan</label>
            <input type="date" class="form-control" name="tgl_lahir_pasangan" id="tgl_lahir_pasangan" required>
        </div>

        <div class="d-flex justify-content-end">
        <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" onClick="return valid()"/>
        <input type="reset" name="reset" id="reset" value="Reset" class="btn btn-info">
        </div>
    </form>
</div>
<?php include(__DIR__ . '/../edit/edit_status_kawin.php'); ?>
<script>
function toggleFormPasangan() {
    const form = document.getElementById('formStatusKawin');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
function toggleFormEditPasangan() {
    const form = document.getElementById('formEditStatusKawin');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>
