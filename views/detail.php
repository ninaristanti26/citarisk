<?php include "other/header.php"; ?>
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">🧾 Data Debitur</h5>
            </div>
            <div class="card-body">
               <div class="table-responsive text-black">
               <?php
                        include(__DIR__ . '/../Database/koneksi.php');
                        include(__DIR__ . '/../getCode/getDetail.php');
                        $no = 1;
                        foreach ($getDetail as $dataDeb) {
                        $no_ktp_encoded = urlencode($dataDeb['no_ktp']);
                        ?>
   <table class="table table-bordered table-hover table-sm mb-0">
   <tbody class="text-dark">
   <tr>
        <th class="bg-light text-start" style="width: 300px;">Petugas Marketing</th>
            <td style="width: 10px;">:</td>
            <td><?php echo htmlspecialchars($dataDeb['nama']); ?></td>
            <td></td>
        </tr>
        <tr>
            <th class="bg-light text-start" style="width: 300px;">Nama</th>
            <td style="width: 10px;">:</td>
            <td><?php echo htmlspecialchars($dataDeb['nama_debitur']); ?></td>
            <td></td>
        </tr>
        <tr>
            <th class="bg-light text-start">No. KTP</th>
            <td>:</td>
            <td>
                <?php echo htmlspecialchars($dataDeb['no_ktp']); ?>
                    <div class="mt-2">
                    <?php
                        $_GET['no_ktp'] = $dataDeb['no_ktp']; // agar getFile.php bisa membaca no_ktp
                        include(__DIR__ . '/../getCode/getFile.php');
                            if (!empty($getFile)):
                            foreach ($getFile as $file):
                    ?>
                <strong><?php echo htmlspecialchars($file['file_name']); ?></strong><br>
                    <a class="btn btn-primary btn-sm" href="<?php echo htmlspecialchars($file['file_path']); ?>" target="_blank">🔗 Lihat PDF</a> | 
                    <a class="btn btn-danger btn-sm" href="<?php echo htmlspecialchars($file['file_path']); ?>" download>⬇️ Download</a>
                        <div style="margin-top:10px; border: 1px solid #ccc;">
                            <iframe src="<?php echo htmlspecialchars($file['file_path']); ?>" width="50%" height="400px"></iframe>
                        </div>
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
        <th class="bg-light text-start" style="width: 300px;">Jenis Kelamin</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['jk']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Tempat / Tanggal Lahir</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['tempat_lahir']); ?>, <?php echo htmlspecialchars($dataDeb['tgl_lahir']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Usia</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['tahun']); ?> tahun, <?php echo htmlspecialchars($dataDeb['bulan']); ?> bulan</td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Pendidikan Terakhir</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['pend_akhir']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Nama Ibu Kandung</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['nama_ibu']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Jumlah Tanggungan</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['jml_tanggungan']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">No. HP</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['no_hp']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Alamat</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['alamat']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Status Rumah</th>
            <td>:</td>
            <td><?php echo htmlspecialchars($dataDeb['status_rumah']); ?></td>
            <td></td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;"></th>
            <td class="text-center"></td>
            <td class="text-start"></td>
            <td></td>
        </tr>
    </tbody>
</table>
<?php } ?>
               </div>
         </div>
               <?php
               include("other/status_kawin.php"); 
               include("other/informasi_pekerjaan.php"); 
               include("other/info_lain.php"); 
               include("other/riwayat_kredit.php"); ?>
            </div>
         </div>
         <!-- Modal Tambah Pegawai -->
         

   </div>
</div>

<?php include "other/footer.php"; ?>
