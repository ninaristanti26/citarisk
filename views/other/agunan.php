<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getAgunan.php');
include(__DIR__ . '/../../getCode/getDetail.php');

$agunan  = $getAgunan[0] ?? [];
$dataDeb = $getDetail[0] ?? [];

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

$pengendalian_pembayaran = $dataKemampuan['pengendalian_pembayaran'] ?? null;
$kualitas_angsuran       = $dataKemampuan['kualitas_angsuran'] ?? null;

$mou             = $agunan['mou'] ?? null;
$sk              = $agunan['sk'] ?? null;
$tambahan_agunan = $agunan['tambahan_agunan'] ?? null;

//risiko mou
if($mou == 1){
    $bobot_risiko_mou = 7;
}elseif($mou == 2){
    $bobot_risiko_mou = 2.63;
}elseif($mou == 3){
    $bobot_risiko_mou = 1.17;
}elseif($mou == 4){
    $bobot_risiko_mou = 0.44;
}else{
    $bobot_risiko_mou = 0;
}
$nilai_mou = $mou * $bobot_risiko_mou;

//risiko sk
if($sk == 1){
    $bobot_risiko_sk = 4;
}elseif($sk == 2){
    $bobot_risiko_sk = 1.50;
}elseif($sk == 3){
    $bobot_risiko_sk = 0.67;
}elseif($sk == 4){
    $bobot_risiko_sk = 0.25;
}else{
    $bobot_risiko_sk = 0;
}
$nilai_sk = $sk * $bobot_risiko_sk;

//risiko tambahan agunan
if($tambahan_agunan == 1){
    $bobot_risiko_tambahan_agunan = 4;
}elseif($tambahan_agunan == 2){
    $bobot_risiko_tambahan_agunan = 1.50;
}elseif($tambahan_agunan == 3){
    $bobot_risiko_tambahan_agunan = 0.67;
}elseif($tambahan_agunan == 4){
    $bobot_risiko_tambahan_agunan = 0.25;
}else{
    $bobot_risiko_tambahan_agunan = 0;
}
$nilai_tambahan_agunan = $tambahan_agunan * $bobot_risiko_tambahan_agunan;

$jumlah_risiko_agunan         = $mou + $sk + $tambahan_agunan;
$rata_penilaian_risiko_agunan = $jumlah_risiko_agunan/3;

$jumlah_bobot_agunan = $bobot_risiko_mou + $bobot_risiko_sk + $bobot_risiko_tambahan_agunan;
$rata_bobot_agunan   = $jumlah_bobot_agunan/3;

$jumlah_nilai_agunan = $nilai_mou + $nilai_sk + $nilai_tambahan_agunan;
$rata_nilai_agunan   = $jumlah_nilai_agunan/3;

// Pegawai yang datanya sedang ditampilkan
$id_pegawai_data = $dataDeb['id_pegawai'] ?? null;

// Cek apakah semua data karakter kosong
$all_empty = empty($mou) && 
             empty($sk) &&
             empty($tambahan_agunan) &&
             $id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12
?>
<table class="table table-bordered table-hover table-sm mb-0">
<tbody class="text-dark">
<tr class="bg-light">
    <th class="text-start" colspan="4">
        <u>Collateral</u>
    </th>
    <td class="text-end">
    </td>
    <td class="text-right"><?php if ($all_empty): ?>
        <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormAgunan()">+ Tambah Data</button>
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

        <!-- MOU / Corporate Guarantee -->
        <?php
        if (isset($agunan['mou'])) {
            switch ($agunan['mou']) {
                case '2':
                    $mou_desc = 'Kerjasama antara BPR dan perusahaan atau instansi tempat debitur bekerja';
                    break;
                case '3':
                    $mou_desc = 'Kerjasama antara BPR dengan HRD atau bendahara tempat debitur bekerja';
                    break;
                case '4':
                    $mou_desc = 'Tidak ada kerjasama namun ada rekomendasi dari pihak HRD';
                    break;
                default:
                    $mou_desc = 'Tidak ada kerjasama dan tidak ada rekomendasi dari pihak HRD';
            }
        } else {
            $mou_desc = 'Data masih kosong';
        }
        ?>
        <tr>
            <td>MOU / Corporate Guarantee</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($mou_desc); ?></td>
            <td class="text-center"><?php echo number_format($mou, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko_mou, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_mou, 2, ',', '.'); ?></td>
        </tr>

        <!-- SK -->
        <?php
        if (isset($agunan['sk'])) {
            switch ($agunan['sk']) {
                case '1':
                    $sk_desc = 'Menyerahkan SK asli berupa SK pengangkatan 80% dan 100%';
                    break;
                case '2':
                    $sk_desc = 'SK karyawan tetap asli untuk swasta / surat perjanjian kerja asli untuk PPPK';
                    break;
                case '3':
                    $sk_desc = 'SK Kepangkatan atau SK Berkala (PNS) / surat kerja (swasta)';
                    break;
                default:
                    $sk_desc = 'SK, surat kerja berupa fotokopi yang dilegalisir';
            }
        } else {
            $sk_desc = 'Data masih kosong';
        }
        ?>
        <tr>
            <td>SK</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($sk_desc); ?></td>
            <td class="text-center"><?php echo number_format($sk, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko_sk, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_sk, 2, ',', '.'); ?></td>
        </tr>

        <!-- Tambahan Agunan -->
        <?php
        if (isset($agunan['tambahan_agunan'])) {
            switch ($agunan['tambahan_agunan']) {
                case '1':
                    $tambahan_agunan_desc = 'Milik sendiri, cover plafon, berupa tabungan atau deposito';
                    break;
                case '2':
                    $tambahan_agunan_desc = 'Milik keluarga/orang lain, surat kuasa, marketable, diikat HT';
                    break;
                case '3':
                    $tambahan_agunan_desc = 'Milik orang lain, marketable, tidak diikat';
                    break;
                case '4':
                    $tambahan_agunan_desc = 'Milik sendiri, tidak cover plafon, marketable & bisa diikat';
                    break;
                default:
                    $tambahan_agunan_desc = 'Milik sendiri, tidak cover plafon, marketable tapi tidak diikat';
            }
        } else {
            $tambahan_agunan_desc = 'Data masih kosong';
        }
        ?>
       <tr>
            <td>Tambahan Agunan</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($tambahan_agunan_desc); ?></td>
            <td class="text-center"><?php echo number_format($tambahan_agunan, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko_tambahan_agunan, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_tambahan_agunan, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><b>RATA-RATA</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($rata_penilaian_risiko_agunan, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_bobot_agunan, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_nilai_agunan, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td><b>SUB TOTAL III</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo number_format($jumlah_nilai_agunan, 2, ',', '.'); ?></b></td>
        </tr>
    </tbody>
</table>
<?php include(__DIR__ . '/../add/add_agunan.php'); ?>