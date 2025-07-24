<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
               <h5 class="mb-0 text-white">📋 Data Petugas Marketing</h5>
               <!-- Tombol trigger modal -->
               <button type="button" class="btn btn-light btn-sm text-primary" data-toggle="modal" data-target="#modalTambahPegawai">
                  + Tambah Data
               </button>
            </div>

            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped table-sm" width="108%" id="dataTables-example">
                     <thead class="text-primary text-center">
                        <tr>
                           <th scope="col" class="text-center">No.</th>
                           <th scope="col" class="text-center">Unit Kerja</th>
                           <th scope="col" class="text-center">Created At</th>
                           <th scope="col" class="text-center">ID Marketing</th>
                           <th scope="col" class="text-center">Nama Petugas Marketing</th>
                           <th scope="col" class="text-center">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        include("../Database/koneksi.php");
                        include("../getCode/getData_ao.php");
                        $no = 1;
                        foreach ($options as $dataAO) {
                           $id_pegawai_encoded = urlencode($dataAO['id_pegawai']);
                        ?>
                           <tr>
                              <td class="text-center"><?php echo $no++; ?></td>
                              <td class="text-center"><?php echo htmlspecialchars($dataAO['kode_cabang']); ?></td>
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

         <!-- Modal Tambah Pegawai -->
         <div class="modal fade" id="modalTambahPegawai" tabindex="-1" role="dialog" aria-labelledby="modalTambahPegawaiLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="modalTambahPegawaiLabel">Tambah Pegawai</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <?php require_once "add/add_ao.php"; ?>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div>

<?php include "other/footer.php"; ?>
