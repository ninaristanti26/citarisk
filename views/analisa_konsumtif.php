<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Cek jika akses bukan dari POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['no_ktp']) && !empty($_POST['id_riwayat'])) {
    $no_ktp     = $_POST['no_ktp'];
    $id_riwayat = $_POST['id_riwayat'];
} else {
    die("Akses tidak valid.");
}
?>
<?php 
include "other/header.php";
include(__DIR__ . '/../Database/koneksi.php');
include(__DIR__ . '/../getCode/getDetail.php');

$no = 1;
foreach ($getDetail as $dataDeb) {
$no_ktp_encoded = urlencode($dataDeb['no_ktp']);
?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">💳 Data Pokok Debitur</h5>
               <?php if ($_SESSION['id_pegawai'] == $dataDeb['id_pegawai']): ?>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditDebitur">✏️ Edit</button>
               <?php endif; ?>
            </div>
            <div class="card-body">
               <div class="table-responsive">
              
                  <table class="table table-bordered table-hover table-sm mb-0">
                  <tbody class="text-dark">
        <tr>
            <th class="bg-light text-start" style="width: 300px;">Petugas Marketing</th>
            <td style="width: 10px;" class="text-center">:</td>
            <td class="text-start"><?php echo htmlspecialchars($dataDeb['nama']); ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Nama</th>
            <td class="text-center">:</td>
            <td class="text-start"><?php echo htmlspecialchars($dataDeb['nama_debitur']); ?></td>
        </tr>
        <tr>
                <th class="bg-light text-start">No. KTP</th>
                <td>:</td>
                <td>
                <?php echo htmlspecialchars($dataDeb['no_ktp']); ?>
                    <div class="mt-2">
                    <?php
                        $_GET['no_ktp'] = $dataDeb['no_ktp']; 
                        include(__DIR__ . '/../getCode/getFile.php');
                            if (!empty($getFile)):
                            foreach ($getFile as $file):
                    ?>
                    <strong><?php echo htmlspecialchars($file['file_name']); ?></strong><br>
                    <a class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($file['file_path']); ?>" target="_blank">🔗</a> | 
                    <a class="btn btn-danger btn-sm" href="<?php echo htmlspecialchars($file['file_path']); ?>" download>⬇️</a> |
                    <form method="post" action="../proses/proses_delete_ktp.php" onsubmit="return confirm('Yakin ingin menghapus file ini?');" style="display:inline;">
                        <input type="hidden" name="id_file" value="<?php echo $file['id_file']; ?>">
                        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataDeb['no_ktp']); ?>">
                        <button type="submit" class="btn btn-sm btn-warning">🗑️</button>
                    </form>
                    <!--   <div style="margin-top:10px; border: 1px solid #ccc;">
                            <iframe src="<?php echo htmlspecialchars($file['file_path']); ?>" width="50%" height="400px"></iframe>
                        </div>-->
                    <?php
                        endforeach;
                        else:
                    ?>
                    <form action="../proses/proses_upload_ktp.php" method="post" enctype="multipart/form-data" class="d-flex align-items-center mb-1 flex-wrap" style="gap: 8px;">
                        <label for="pdf" class="mb-0">KTP:</label>
                        <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($dataDeb['no_ktp']); ?>" readonly>
                        <input type="file" name="pdf" id="pdf" accept="application/pdf" required>
                        <button class="btn btn-sm btn-primary" type="submit" name="submit">Upload</button>
                    </form>
                    <?php endif; ?>
                    </div>
                </td>
                </tr>
        <tr>
            <th class="bg-light text-start">Alamat</th>
            <td class="text-center">:</td>
            <td class="text-start"><?php echo htmlspecialchars($dataDeb['alamat']); ?></td>
        </tr>
    </tbody>
                        <?php } ?>
                  </table>
               </div>
               <?php include("other/status_kawin.php"); ?>
               <?php include("other/informasi_pekerjaan.php"); ?>
               <?php include("other/usulan_ao.php"); ?>
               <?php include("other/bank_lain.php"); ?>
               <?php include("other/data_keuangan.php"); ?>
               <?php include("other/hitung_plafon.php"); ?>
               <?php include("other/skoring_kredit.php"); ?>
               <?php include("other/form_agunan.php"); ?>
               <?php include("other/putusan_analis.php"); ?>
            </div>
         </div>
         <!-- Modal Tambah Pegawai -->
      </div>
   </div>
</div>
<?php include "other/footer.php"; ?>
