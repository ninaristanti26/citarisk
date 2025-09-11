<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">📋 Data Petugas Marketing <?php echo $_SESSION['kode_cabang']; ?></h5>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped table-sm" width="108%" id="dataTables-example">
                     <thead class="table-light text-center">
                        <tr>
                           <th scope="col" class="text-center">No.</th>
                           <th scope="col" class="text-center">Created At</th>
                           <th scope="col" class="text-center">ID Marketing</th>
                           <th scope="col" class="text-center">Nama Petugas Marketing</th>
                           <th scope="col" class="text-center">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        include("../Database/koneksi.php");
                        include("../getCode/getData_aoCabang.php");
                        $no = 1;
                        foreach ($getData_aoCabang as $dataAO) {
                           $id_pegawai_encoded = urlencode($dataAO['id_pegawai']);
                        ?>
                           <tr>
                              <td class="text-center"><?php echo $no++; ?></td>
                              <td class="text-center"><?php echo htmlspecialchars($dataAO['created_at']); ?></td>
                              <td class="text-center"><?php echo htmlspecialchars($dataAO['id_pegawai']); ?></td>
                              <td class="text-center"><?php echo htmlspecialchars($dataAO['nama']); ?></td>
                              <td class="text-center">
                                 <a class="btn btn-primary btn-sm mx-1" href="debitur_ao?id_pegawai=<?php echo $id_pegawai_encoded; ?>">Lihat Debitur</a>
                                 <a class="btn btn-info btn-sm mx-1 text-white" href="edit_ao?id_pegawai=<?php echo $id_pegawai_encoded; ?>">Edit</a>
                                 <a class="btn btn-danger btn-sm mx-1" href="hapus_ao?id_pegawai=<?php echo $id_pegawai_encoded; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                              </td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>
