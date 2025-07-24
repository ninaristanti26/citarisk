<?php
    include("../Database/koneksi.php");
    include("../getCode/getPutusanAO.php");
    include("../getCode/getRiwayat_kredit.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getDetail.php");
    include("../getCode/getRole.php");
    include("../getCode/getPutusanAnalis.php");
    include("../getCode/getSyaratTambah.php");
    include("../getCode/getAdm.php");
    include("../getCode/getAdmRelasi.php");

    // Data login & data debitur
    $id_role_login     = $_SESSION['id_role'];
    $id_pegawai_login  = $_SESSION['id_pegawai'];
    $kode_cabang_login = $_SESSION['kode_cabang'];

    $dataDeb             = $getDetail[0] ?? [];
    $kode_cabang_data    = $dataDeb['kode_cabang'] ?? null;
    $id_pegawai_data     = $dataDeb['id_pegawai'] ?? null;
    $data_putusan_ao     = $getPutusanAO[0] ?? [];
    $dataRiwayat         = $getRiwayat_kredit[0] ?? [];
    $dataKeuangan        = $options[0] ?? [];
    $data_putusan_analis = $getPutusanAnalis[0] ?? [];
    $data_syarat_tambah  = $getSyaratTambah[0] ?? [];

    $showTambah = (
        $id_pegawai_login == $_SESSION['id_pegawai'] &&
        $kode_cabang_login == $kode_cabang_data &&
        $id_role_login == 16
    );
?>

<!-- Judul -->
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Review Kelengkapan Administrasi</h5>
    <?php if ($showTambah): ?>
        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormAdm()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<!-- Tabel Kelengkapan Administrasi -->
<div class="card-body">
    <div class="table-responsive mt-3">
    <table class="table table-striped table-bordered table-sm align-middle" width="1200px" id="dataTables-example2">
        <thead class="table-dark text-center">
            <tr>
                <th>No.</th>
                <th>Jenis Administrasi</th>
                <th>Bukti Administrasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($getAdmRelasi)): ?>
                <?php foreach ($getAdmRelasi as $i => $relasi): ?>
                    <tr>
                        <td class="text-center"><?= $i + 1; ?></td>
                        <td class="text-start"><?= htmlspecialchars($relasi['jenis_adm']); ?></td>
                        <td class="text-start">
                            <a class="btn btn-sm btn-primary mt-1" href="<?= htmlspecialchars($relasi['file_path_adm']); ?>" target="_blank">🔗 Lihat PDF</a>
                            <a class="btn btn-sm btn-danger mt-1" href="<?= htmlspecialchars($relasi['file_path_adm']); ?>" download>⬇️ Download</a>
                            <a href="#" class="btn btn-warning btn-sm mt-1">✏️ Edit</a>
                            <a href="#" class="btn btn-outline-danger btn-sm mt-1">🗑️ Hapus</a>
                            <div class="mt-2 border rounded" style="overflow:hidden; max-width:100%; height:500px;">
                                <iframe src="<?= htmlspecialchars($relasi['file_path_adm']); ?>" style="width:100%; height:100%; border:none;"></iframe>
                            </div>
                        </td>
                        <td class="text-start"><?= htmlspecialchars($relasi['status_adm']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data administrasi yang diunggah.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>

<hr>

<!-- Form Tambah Data -->
<?php include "add/add_review_adm.php"; ?>

<!-- Toggle Form JS -->
<script>
function toggleFormAdm() {
    const form = document.getElementById('formAdm');
    if (form) form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>
