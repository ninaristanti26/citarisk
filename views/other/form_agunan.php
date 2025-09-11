<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getBank_lain.php');
include(__DIR__ . '/../../getCode/getDetail.php');
include(__DIR__ . '/../../getCode/getFileSK.php');

$dataDeb = $getDetail[0] ?? [];

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
?>
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Form Agunan Kredit</h5>

    <?php if ($id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12): ?>
    <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormKetAgunan()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="card-body">
    <div class="table-responsive">
    
        </div>
        <table class="table table-striped table-bordered table-sm" width="107%" id="dataTables-example1">
            <thead class="text-dark text-center">
                <tr>
                    <th>No.</th>
                    <th>Jenis Agunan</th>
                    <th>No. Agunan</th>
                    <th>Tgl. Agunan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($getFileSK as $dataFileSK) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataFileSK['jenis_agunan'] ?? '-'); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataFileSK['no_agunan'] ?? '-'); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($dataFileSK['tgl_agunan'] ?? '-'); ?></td>
                    <td class="text-center"> 
                        <a class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($dataFileSK['file_path_sk']); ?>" target="_blank">🔗 Lihat PDF</a> |
                        <a class="btn btn-danger btn-sm" href="<?php echo htmlspecialchars($dataFileSK['file_path_sk']); ?>" download>⬇️ Download</a>
                        <div style="margin-top:10px; border: 0px solid #ccc;">
                        <iframe src="<?php echo htmlspecialchars($dataFileSK['file_path_sk']); ?>" width="100%" height="300px"></iframe>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- ✅ JavaScript Toggle Form -->
 <?php include "add/add_form_agunan.php"; ?>
 <script>
        function toggleFormKetAgunan() {
            const form = document.getElementById('formKetAgunan');
            if (form) {
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        }
    </script>

