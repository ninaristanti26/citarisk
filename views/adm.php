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
               <h5 class="mb-0 text-white">📋 Parameter Kelengkapan Administrasi</h5>
               <!-- Tombol trigger modal -->
               <?php if (isset($_SESSION['id_role']) && $_SESSION['id_role'] == 16): ?>
               <button type="button" class="btn btn-light btn-sm text-primary" data-toggle="modal" data-target="#modalTambahAdm">
                  + Tambah Data
               </button>
               <?php endif; ?>
            </div>

            <div class="card-body">
               <div class="table-responsive">
               <table class="table table-striped table-bordered table-sm" id="dataTables-example" style="width: 123%;">
    <thead class="table-light text-center">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Jenis Administrasi</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include("../getCode/getParamAdm.php");
        $no = 1;
        foreach ($getParamAdm as $dataParamAdm) {
          //  $no_ktp_encoded = urlencode($dataDeb['no_ktp']);
        ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-left"><?php echo htmlspecialchars($dataParamAdm['jenis_adm']); ?></td>
                <td class="text-center">
                    <a href="detail?no_ktp=<?php echo $no_ktp_encoded; ?>" class="btn btn-sm btn-primary">
                        Edit
                    </a> | <a href="detail?no_ktp=<?php echo $no_ktp_encoded; ?>" class="btn btn-sm btn-primary">
                        Hapus
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
         <div class="modal fade" id="modalTambahAdm" tabindex="-1" role="dialog" aria-labelledby="modalTambahAdmLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="modalTambahAdmLabel">Tambah Parameter Administrasi</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <?php require_once "add/add_param_adm.php"; ?>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>