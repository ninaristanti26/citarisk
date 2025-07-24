<?php
    include("../Database/koneksi.php");
    include("../getCode/getPekerjaan.php");
    include("../getCode/getDetail.php");

    $dataPekerjaan = isset($getPekerjaan[0]) ? $getPekerjaan[0] : [];
    $dataDeb       = $getDetail[0] ?? [];

    $nama_instansi    = !empty($dataPekerjaan['nama_instansi']) ? htmlspecialchars($dataPekerjaan['nama_instansi']) : '-';
    $jabatan          = !empty($dataPekerjaan['jabatan']) ? htmlspecialchars($dataPekerjaan['jabatan']) : '-';
    $unit_kerja       = !empty($dataPekerjaan['unit_kerja']) ? htmlspecialchars($dataPekerjaan['unit_kerja']) : '-';
    $status_kerja     = !empty($dataPekerjaan['status_kerja']) ? htmlspecialchars($dataPekerjaan['status_kerja']) : '-';
    $tgl_pengangkatan = !empty($dataPekerjaan['tgl_pengangkatan']) ? htmlspecialchars($dataPekerjaan['tgl_pengangkatan']) : '-';
    $tahun_kerja      = !empty($dataPekerjaan['tahun_kerja']) ? htmlspecialchars($dataPekerjaan['tahun_kerja']) : '-';
    $bulan_kerja      = !empty($dataPekerjaan['bulan_kerja']) ? htmlspecialchars($dataPekerjaan['bulan_kerja']) : '-';
    $usia_akhir_kerja = !empty($dataPekerjaan['usia_akhir_kerja']) ? htmlspecialchars($dataPekerjaan['usia_akhir_kerja']) : '-';
    $alamat_instansi  = !empty($dataPekerjaan['alamat_instansi']) ? htmlspecialchars($dataPekerjaan['alamat_instansi']) : '-';
    $sektor_instansi  = !empty($dataPekerjaan['sektor_instansi']) ? htmlspecialchars($dataPekerjaan['sektor_instansi']) : '-';
    $rasio            = !empty($dataPekerjaan['rasio']) ? htmlspecialchars($dataPekerjaan['rasio']) : '-';

    // Pegawai yang sedang login
    $id_pegawai_login = $_SESSION['id_pegawai'];

    // Pegawai yang datanya sedang ditampilkan
    $id_pegawai_data = $dataDeb['id_pegawai'] ?? null;
    ?>
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">💼 Informasi Pekerjaan</h5>
    <?php if ($nama_instansi == '-' && 
              $jabatan == '-' &&
              $unit_kerja == '-' &&
              $status_kerja == '-' &&
              $tgl_pengangkatan == '-' &&
              $tahun_kerja == '-' &&
              $bulan_kerja == '-' &&
              $usia_akhir_kerja == '-' &&
              $alamat_instansi == '-' &&
              $sektor_instansi == '-' &&
              $rasio == '-' &&
              $id_pegawai_login == $id_pegawai_data
              ): ?>
        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormInfoPekerjaan()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="table-responsive text-black">
    
<table class="table table-bordered table-hover table-sm mb-0">
    <tbody class="text-dark">
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Nama Perusahaan</th>
            <td style="width: 10px;" class="text-center">:</td>
            <td class="text-start"><?php echo $nama_instansi; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Jabatan</th>
            <td>:</td>
            <td class="text-start"><?php echo $jabatan; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Unit Kerja</th>
            <td>:</td>
            <td class="text-start"><?php echo $unit_kerja; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Status</th>
            <td>:</td>
            <td class="text-start"><?php echo $status_kerja; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Tanggal Pengangkatan</th>
            <td>:</td>
            <td class="text-start"><?php echo $tgl_pengangkatan; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Lama Kerja</th>
            <td>:</td>
            <td class="text-start"><?php echo $tahun_kerja; ?> tahun <?php echo $bulan_kerja; ?> bulan</td>
        </tr>
        <tr>
            <th class="bg-light text-start">Usia Berakhir Kerja</th>
            <td>:</td>
            <td class="text-start"><?php echo $usia_akhir_kerja; ?> tahun</td>
        </tr>
        <tr>
            <th class="bg-light text-start">Alamat Instansi</th>
            <td>:</td>
            <td class="text-start"><?php echo $alamat_instansi; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Sektor Instansi</th>
            <td>:</td>
            <td class="text-start"><?php echo $sektor_instansi; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Rasio</th>
            <td>:</td>
            <td class="text-start"><?php echo $rasio; ?>%</td>
        </tr>
    </tbody>
</table>

</div>

<!-- FORM TAMBAH DATA PEKERJAAN -->
<div id="formInformasiPekerjaan" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Tambah Informasi Pekerjaan</h5>
    <form method="POST" action="../proses/proses_add_pekerjaan.php">
    <input type="hidden" name="id_riwayat" value="<?php echo $_GET['id_riwayat'] ?? ''; ?>">
        <input type="hidden" name="no_ktp" value="<?php echo $_GET['no_ktp'] ?? ''; ?>">
        <input type="hidden" name="update_pekerjaan" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <div class="mb-3">
            <label for="nama_instansi" class="form-label">Nama Instansi</label>
            <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" required>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" id="jabatan" required>
        </div>

        <div class="mb-3">
            <label for="unit_kerja" class="form-label">Unit Kerja</label>
            <input type="text" class="form-control" name="unit_kerja" id="unit_kerja" required>
        </div>

        <div class="mb-3">
            <label for="status_kerja" class="form-label">Status Kerja</label>
            <select class="form-control" name="status_kerja" id="status_kerja" required>
                <option value="">Pilih Status</option>
                <option value="Pegawai Tetap">Pegawai Tetap</option>
                <option value="Kontrak">Kontrak</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tgl_pengangkatan" class="form-label">Tanggal Pengangkatan</label>
            <input type="date" class="form-control" name="tgl_pengangkatan" id="tgl_pengangkatan" required>
        </div>

        <div class="mb-3">
            <label for="usia_akhir_kerja" class="form-label">Usia Berakhir Kerja</label>
            <input type="number" class="form-control" name="usia_akhir_kerja" id="usia_akhir_kerja" required>
        </div>

        <div class="mb-3">
            <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
            <textarea class="form-control" name="alamat_instansi" id="alamat_instansi" rows="2" required></textarea>
        </div>

        <div class="mb-3">
            <label for="usia_akhir_kerja" class="form-label">Sektor Instansi</label>
            <input type="text" class="form-control" name="sektor_instansi" id="sektor_instansi" required>
        </div>

        <div class="mb-3">
            <label for="rasio" class="form-label">Rasio Pembiayaan (hanya diisi angka saja tanpa tanda %)</label>
            <input type="number" class="form-control" name="rasio" id="rasio">
        </div>

        <div class="d-flex justify-content-end gap-2">
            <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
            <input type="reset" name="reset" value="Reset" class="btn btn-secondary">
        </div>
    </form>
</div>

<!-- JavaScript Toggle -->
<script>
function toggleFormInfoPekerjaan() {
    const form = document.getElementById('formInformasiPekerjaan');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>
