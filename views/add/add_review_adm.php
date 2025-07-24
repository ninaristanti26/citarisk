<?php
 include("../getCode/getAdm.php");
?>
<!-- Form Tambah Administrasi (Checkbox) -->
<?php include("../getCode/getAdm.php"); ?>
<div class="card mt-3" id="formAdm" style="display: none;">
    <div class="card-body">
        <h5 class="card-title">📤 Upload Dokumen Administrasi</h5>
    <form action="../proses/proses_upload_adm.php" method="post" enctype="multipart/form-data" class="row g-3 mt-3 p-3 border rounded bg-light">
    <!-- Pilih jenis administrasi -->
    <div class="col-md-4">
        <label for="id_adm" class="form-label">📁 Jenis Administrasi</label>
        <select name="id_adm" id="id_adm" class="form-control" required>
            <option value="">-- Pilih Jenis Administrasi --</option>
            <?php foreach ($getAdm as $adm): ?>
                <option value="<?= $adm['id_adm'] ?>">
                    <?= htmlspecialchars($adm['jenis_adm']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Input file PDF -->
    <div class="col-md-4">
        <label for="file_adm" class="form-label">📎 Upload Dokumen (PDF)</label>
        <input type="file" name="file_adm" id="file_adm" class="form-control" accept="application/pdf" required>
    </div>

    <!-- Status -->
    <div class="col-md-4">
        <label for="status_adm" class="form-label">📌 Status</label>
        <select name="status_adm" id="status_adm" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="Lengkap">Lengkap</option>
            <option value="Belum Lengkap">Belum Lengkap</option>
        </select>
    </div>

    <!-- Hidden inputs -->
    <input type="hidden" name="no_ktp" value="<?= htmlspecialchars($dataDeb['no_ktp'] ?? '') ?>">
    <input type="hidden" name="id_riwayat" value="<?= htmlspecialchars($dataRiwayat['id_riwayat'] ?? '') ?>">
    <input type="hidden" name="id_pegawai" value="<?= htmlspecialchars($dataRiwayat['id_pegawai'] ?? '') ?>">

    <!-- Horizontal rule (if needed) -->
    <div class="col-12"><hr></div>

    <!-- Submit buttons -->
    <div class="col-12 text-end">
        <button type="submit" name="submit" class="btn btn-primary">💾 Upload</button>
        <button type="button" class="btn btn-secondary" onclick="toggleFormAdm()">❌ Batal</button>
    </div>
</form>

    </div>
</div>
