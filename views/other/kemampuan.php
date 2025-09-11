<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getKemampuan.php');
include(__DIR__ . '/../../getCode/getDetail.php');

$dataKemampuan = $getKemampuan[0] ?? [];
$dataDeb       = $getDetail[0] ?? [];
$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

$pengendalian_pembayaran = $dataKemampuan['pengendalian_pembayaran'] ?? null;
$kualitas_angsuran       = $dataKemampuan['kualitas_angsuran'] ?? null;

//risiko pengendalian pembayaran
if($pengendalian_pembayaran == 1){
    $bobot_risiko_pengendalian_pembayaran = 11;
}elseif($pengendalian_pembayaran == 2){
    $bobot_risiko_pengendalian_pembayaran = 4.13;
}elseif($pengendalian_pembayaran == 3){
    $bobot_risiko_pengendalian_pembayaran = 1.83;
}elseif($pengendalian_pembayaran == 4){
    $bobot_risiko_pengendalian_pembayaran = 0.69;
}else{
    $bobot_risiko_pengendalian_pembayaran = 0;
}
$nilai_pengendalian_pembayaran = $pengendalian_pembayaran * $bobot_risiko_pengendalian_pembayaran;

//risiko kualitas angsuran
if($kualitas_angsuran == 1){
    $bobot_kualitas_angsuran = 9;
}elseif($kualitas_angsuran == 2){
    $bobot_kualitas_angsuran = 3.38;
}elseif($kualitas_angsuran == 3){
    $bobot_kualitas_angsuran = 1.50;
}elseif($kualitas_angsuran == 4){
    $bobot_kualitas_angsuran = 0.56;
}else{
    $bobot_kualitas_angsuran = 0;
}
$nilai_kualitas_angsuran = $kualitas_angsuran * $bobot_kualitas_angsuran;

$jumlah_risiko_repayment = $pengendalian_pembayaran + $kualitas_angsuran;
$rata_penilaian_risiko_repayment = $jumlah_risiko_repayment/2;

$jumlah_bobot_repayment = $bobot_risiko_pengendalian_pembayaran + $bobot_kualitas_angsuran;
$rata_bobot_repayment   = $jumlah_bobot_repayment/2;

$jumlah_nilai_repayment = $nilai_pengendalian_pembayaran + $nilai_kualitas_angsuran;
$rata_nilai_repayment   = $jumlah_nilai_repayment/2;


// Pegawai yang datanya sedang ditampilkan
$id_pegawai_data = $dataDeb['id_pegawai'] ?? null;

// Cek apakah semua data karakter kosong
$all_empty = empty($pengendalian_pembayaran) && 
             empty($kualitas_angsuran) &&
             $id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12
?>

<table class="table table-bordered table-hover table-sm mb-0">
<tbody class="text-dark">
<tr class="bg-light">
    <th class="text-start" colspan="4">
        <u>Capacity/Repayment Capacity</u>
    </th>
    <td class="text-end">
    </td>
    <td class="text-right">
        <?php if ($all_empty): ?>
            <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormKemampuan()">+ Tambah Data</button>
        <?php endif; ?>
    </td>
</tr>
<thead class="bg-light">
<tr>
    <th class="text-center" style="width: 300px; color: transparent;"><u>PARAMETER</u></th>
    <th class="text-center" style="width: 10px;"></th>
    <th class="text-center" style="width: 800px; color: transparent;"><u>DESKRIPSI</u></th>
    <th class="text-center" style="width: 200px; color: transparent;"><u>PENILAIAN RISIKO</u></th>
    <th class="text-center" style="width: 200px; color: transparent;"><u>BOBOT RISIKO</u></th>
    <th class="text-center" style="width: 200px; color: transparent;"><u>NILAI</u></th>
</tr>

    </thead>
    <tbody>
<?php
        // Penjabaran pengendalian pembayaran
        if (isset($dataKemampuan['pengendalian_pembayaran'])) {
            switch ($dataKemampuan['pengendalian_pembayaran']) {
                case '1':
                    $kemampuan_bayar = 'Pembayaran angsuran dari gaji, langsung autodebet dari rekening di BPR.';
                    break;
                case '2':
                    $kemampuan_bayar = 'Pembayaran angsuran dari gaji, autodebet/SI/Banpot dari rekening bank lain.';
                    break;
                case '3':
                    $kemampuan_bayar = 'Pembayaran melalui kuasa potong/juru bayar/kerjasama pendebetan atau jaminan ATM.';
                    break;
                default:
                    $kemampuan_bayar = 'Pembayaran dilakukan sendiri ke BPR.';
            }
        } else {
            $kemampuan_bayar = 'Data masih kosong';
        }
        ?>
<tr>
            <td>Pengendalian Pembayaran</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($kemampuan_bayar); ?></td>
            <td class="text-center"><?php echo number_format($pengendalian_pembayaran, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko_pengendalian_pembayaran, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_pengendalian_pembayaran, 2, ',', '.'); ?></td>
        </tr>
    
        <!-- Kualitas Angsuran -->
        <?php
        if (isset($dataKemampuan['kualitas_angsuran'])) {
            switch ($dataKemampuan['kualitas_angsuran']) {
                case '1':
                    $kualitas_angsuran_desc = '100% dari penghasilan tetap.';
                    break;
                case '2':
                    $kualitas_angsuran_desc = '70% dari penghasilan tetap.';
                    break;
                case '3':
                    $kualitas_angsuran_desc = 'Gabungan tetap & variabel, tidak lebih dari 60% variabel.';
                    break;
                case '4':
                    $kualitas_angsuran_desc = 'Gabungan tetap & variabel, lebih dari 60% variabel.';
                    break;
                default:
                    $kualitas_angsuran_desc = '100% dari penghasilan variabel.';
            }
        } else {
            $kualitas_angsuran_desc = 'Data masih kosong';
        }
        ?>
<tr>
            <td>Kualitas Angsuran</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($kualitas_angsuran_desc); ?></td>
            <td class="text-center"><?php echo number_format($kualitas_angsuran, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_kualitas_angsuran, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_kualitas_angsuran, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><b>RATA-RATA</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($rata_penilaian_risiko_repayment, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_bobot_repayment, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_nilai_repayment, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td><b>SUB TOTAL II</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo number_format($jumlah_nilai_repayment, 2, ',', '.'); ?></b></td>
        </tr>
    </tbody>
</table>
<?php include(__DIR__ . '/../add/add_kemampuan.php'); ?>