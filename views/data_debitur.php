<?php
session_start();
$timeout = 900;
if (isset($_SESSION['id_pegawai'])) {
    if (isset($_SESSION['last_activity'])) {
        $inactive = time() - $_SESSION['last_activity'];
        if ($inactive > $timeout) {
            session_unset();
            session_destroy();
            echo "<script>alert('Sesi Anda telah berakhir. Silakan login kembali.'); window.location.href='../login.php';</script>";
            exit;
        }
    }
    $_SESSION['last_activity'] = time();
} else {
    header("Location: ../index.php");
    exit;
}
?>

<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Data Debitur</h5>
               <!-- Tombol trigger modal -->
               <?php if (isset($_SESSION['id_role']) && $_SESSION['id_role'] == 13): ?>
               <button type="button" class="btn btn-light btn-sm text-primary" id="btnTambahDebitur">
   + Tambah Data
</button>

               <?php endif; ?>
            </div>

            <div class="card-body">
               <div class="table-responsive">
               <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 100%;">
    <thead class="table-light text-center">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Unit Kerja</th>
            <th scope="col">Created At</th>
            <th scope="col">ID Marketing</th>
            <th scope="col">Nama Debitur</th>
            <th scope="col">Alamat</th>
            <th scope="col">No. HP</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include(__DIR__ . '/../Database/koneksi.php');
        include(__DIR__ . '/../getCode/getDebitur.php');
        $no = 1;
        foreach ($options as $dataDeb) {
            $no_ktp_encoded = urlencode($dataDeb['no_ktp']);
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataDeb['kode_cabang']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataDeb['created_at']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($dataDeb['id_pegawai']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataDeb['nama_debitur']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataDeb['alamat']); ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataDeb['no_hp']); ?></td>
                <td class="text-center">
                    <a href="detail?no_ktp=<?php echo $no_ktp_encoded; ?>" class="btn btn-sm btn-primary">
                        Selengkapnya
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

               </div>
            </div>
         </div>

         <!-- Modal Tambah Pegawai -->
         <div class="modal fade" id="modalTambahDebitur" tabindex="-1" role="dialog" aria-labelledby="modalTambahDebiturLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="modalTambahDebiturLabel">Tambah Debitur</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <?php require_once "add/add_debitur.php"; ?>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div><?php include "other/footer.php"; ?>
<script>
$(document).ready(function() {
  $('#btnTambahDebitur').click(function() {
    $('#modalTambahDebitur').modal({
      backdrop: 'static', // klik di luar modal gak nutup modal
      keyboard: false    // ESC gak nutup modal
    });
  });
});
</script>



