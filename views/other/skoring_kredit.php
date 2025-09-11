<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getKarakter.php');
include(__DIR__ . '/../../getCode/getDetail.php');

$dataKarakter = $getKarakter[0] ?? [];
$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

$nilai_sifat         = $dataKarakter['sifat'] ?? null;
$nilai_ideb          = $dataKarakter['ideb'] ?? null;
$nilai_repayment     = $dataKarakter['repayment'] ?? null;
$nilai_perkara_hukum = $dataKarakter['perkara_hukum'] ?? null;
$nilai_gaya_hidup    = $dataKarakter['gaya_hidup'] ?? null;
$nilai_lama_kerja    = $dataKarakter['lama_kerja'] ?? null;

// Pegawai yang datanya sedang ditampilkan
$id_pegawai_data = $dataDeb['id_pegawai'] ?? null;

// Cek apakah semua data karakter kosong
$all_empty = empty($nilai_sifat) && 
             empty($nilai_ideb) && 
             empty($nilai_repayment) &&
             empty($nilai_perkara_hukum) && 
             empty($nilai_gaya_hidup) && 
             empty($nilai_lama_kerja) &&
             $id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12
?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📋 Analisa Skoring</h5>
</div>

<table class="table table-bordered table-hover table-sm mb-0">
<tbody class="text-dark">
<tr class="bg-light">
    <th class="text-start" colspan="4">
        <u>Karakter Calon Debitur</u>
    </th>
    <td class="text-end">
    </td>
    <td class="text-right">
        <?php if ($all_empty): ?>
            <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormKarakter()">+ Tambah Data</button>
        <?php endif; ?>
    </td>
</tr>

        <thead class="bg-light">
        <tr>
            <th class="text-center" style="width: 300px;"><u>PARAMETER</u></th>
            <th style="width: 10px;" class="text-center"></th>
            <th class="text-center" style="width: 800px;"><u>DESKRIPSI</u></th>
            <th class="text-center" style="width: 200px;"><u>PENILAIAN RISIKO</u></th>
            <th class="text-center" style="width: 200px;"><u>BOBOT RISIKO</u></th>
            <th class="text-center" style="width: 200px;"><u>NILAI</u></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sifat_desc = match($nilai_sifat) {
            '1' => 'Sangat terbuka, jujur dan cepat dalam menyampaikan data dan informasi pada saat wawancara',
            '2' => 'Sangat terbuka, jujur namun agak lambat dalam menyampaikan data dan informasi pada saat wawancara',
            '3' => 'Jujur dan cukup terbuka, namun masih ada kesan menyembunyikan sesuatu',
            '4' => 'Sering menyembunyikan sesuatu dan sangat lambat dalam menyampaikan data dan informasi pada saat wawancara',
            '5' => 'Tidak jujur, sering menyembunyikan sesuatu dan tidak kooperatif dalam menyampaikan data dan informasi pada saat wawancara',
            default => 'Data masih kosong',
        };
        //risiko sifat
    if($nilai_sifat == 1){
        $bobot_risiko = 3;
    }elseif($nilai_sifat == 2){
        $bobot_risiko = 1.13;
    }elseif($nilai_sifat == 3){
        $bobot_risiko = 0.50;
    }elseif($nilai_sifat == 4){
        $bobot_risiko = 0.19;
    }else{
        $bobot_risiko = 0;
    }
    $nilai = $nilai_sifat * $bobot_risiko;
        ?>

<tr>
            <td>Sifat Kejujuran, Kooperatif dan Keterbukaan</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($sifat_desc); ?></td>
            <td class="text-center"><?php echo number_format($nilai_sifat, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai, 2, ',', '.'); ?></td>
        </tr>



        <?php
        $ideb_desc = match($nilai_ideb) {
            '1' => 'Memiliki kredit di bank/lembaga lain, tidak terdapat tunggakan atau nihil.',
            '2' => 'Tunggakan lebih dari 10 hari tapi tidak lebih dari 30 hari.',
            '3' => '● Tunggakan > 30 hari tapi < 60 hari<br>● Belum pernah punya pinjaman<br>● Riwayat macet tapi sudah lunas',
            '4' => 'Tunggakan > 60 hari tapi < 90 hari.',
            '5' => 'Tunggakan > 90 hari, pinjaman belum lunas.',
            default => 'Data masih kosong',
        };

        //risiko ideb
    if($nilai_ideb == 1){
        $bobot_ideb = 10;
    }elseif($nilai_ideb == 2){
        $bobot_ideb = 3.75;
    }elseif($nilai_ideb == 3){
        $bobot_ideb = 1.67;
    }elseif($nilai_ideb == 4){
        $bobot_ideb = 0.63;
    }else{
        $bobot_ideb = 0;
    }
    $penilaian_ideb = $nilai_ideb * $bobot_ideb;
        ?>

        <tr>
            <td>Informasi Debitur (IDeb)</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($ideb_desc); ?></td>
            <td class="text-center"><?php echo number_format($nilai_ideb, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_ideb, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($penilaian_ideb, 2, ',', '.'); ?></td>
        </tr>

        <?php
        $repayment_desc = match($nilai_repayment) {
            '1' => 'Tidak punya pinjaman di bank/non-bank lain atau tidak dilakukan auto-debet.',
            '2' => 'Auto-debet ≤ 40% dari penghasilan tetap.',
            '3' => 'Auto-debet ≤ 60% dari penghasilan tetap.',
            '4' => 'Auto-debet > 60% dan ≤ 80% dari penghasilan tetap.',
            '5' => 'Auto-debet > 80% dari penghasilan tetap.',
            default => 'Data masih kosong',
        };

        //risiko repayment
    if($nilai_repayment == 1){
        $bobot_repayment = 3;
    }elseif($nilai_repayment == 2){
        $bobot_repayment = 1.13;
    }elseif($nilai_repayment == 3){
        $bobot_repayment = 0.50;
    }elseif($nilai_repayment == 4){
        $bobot_repayment = 0.19;
    }else{
        $bobot_repayment = 0;
    }
    $penilaian_repayment = $nilai_repayment * $bobot_repayment;
        ?>

<tr>
            <td>Repayment Checking</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($repayment_desc); ?></td>
            <td class="text-center"><?php echo number_format($nilai_repayment, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_repayment, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($penilaian_repayment, 2, ',', '.'); ?></td>
        </tr>

        <?php
        $perkara_desc = match($nilai_perkara_hukum) {
            '1' => 'Tidak pernah terkait dengan masalah hukum.',
            '3' => 'Pernah menjalani kasus hukum dan dinyatakan bersalah oleh pengadilan.',
            '5' => 'Sedang menjalani kasus hukum dan dinyatakan bersalah oleh pengadilan.',
            default => 'Data masih kosong',
        };
        //risiko perkara hukum
    if($nilai_perkara_hukum == 1){
        $bobot_perkarahukum = 3;
    }elseif($nilai_perkara_hukum == 2){
        $bobot_perkarahukum = 1.13;
    }elseif($nilai_perkara_hukum == 3){
        $bobot_perkarahukum = 0.50;
    }elseif($nilai_perkara_hukum == 4){
        $bobot_perkarahukum = 0.19;
    }else{
        $bobot_perkarahukum = 0;
    }
    $penilaian_perkarahukum = $nilai_perkara_hukum * $bobot_perkarahukum;
        ?>

<tr>
            <td>Perkara Hukum</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($perkara_desc); ?></td>
            <td class="text-center"><?php echo number_format($nilai_perkara_hukum, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_perkarahukum, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($penilaian_perkarahukum, 2, ',', '.'); ?></td>
        </tr>

        <?php
        $gaya_hidup_desc = match($nilai_gaya_hidup) {
            '1' => 'Persepsi positif, gaya hidup sederhana, tidak berjudi, taat norma dan agama.',
            '5' => 'Persepsi negatif, suka berfoya-foya, berjudi, sering langgar norma.',
            default => 'Data masih kosong',
        };
        //risiko gaya hidup
    if($nilai_gaya_hidup == 1){
        $bobot_gayahidup = 3;
    }elseif($nilai_gaya_hidup == 2){
        $bobot_gayahidup = 1.13;
    }elseif($nilai_gaya_hidup == 3){
        $bobot_gayahidup = 0.50;
    }elseif($nilai_gaya_hidup == 4){
        $bobot_gayahidup = 0.19;
    }else{
        $bobot_gayahidup = 0;
    }
    $penilaian_gayahidup = $nilai_gaya_hidup * $bobot_gayahidup;
        ?>

<tr>
            <td>Gaya Hidup</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($gaya_hidup_desc); ?></td>
            <td class="text-center"><?php echo number_format($nilai_gaya_hidup, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_gayahidup, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($penilaian_gayahidup, 2, ',', '.'); ?></td>
        </tr>

        <?php
        $lama_kerja_desc = match($nilai_lama_kerja) {
            '1' => 'Masa kerja >10 tahun (swasta) | >5 tahun (ASN)',
            '2' => '8–10 tahun (swasta) | >5 tahun (PPPK)',
            '3' => '5–8 tahun (swasta) | 2–5 tahun (PPPK)',
            '4' => '3–5 tahun (swasta) | <2 tahun (PPPK)',
            '5' => 'Masa kerja kurang dari 3 tahun',
            default => 'Data masih kosong',
        };
        //risiko lama kerja
    if($nilai_lama_kerja == 1){
        $bobot_lamakerja = 3;
    }elseif($nilai_lama_kerja == 2){
        $bobot_lamakerja = 1.13;
    }elseif($nilai_lama_kerja == 3){
        $bobot_lamakerja = 0.50;
    }elseif($nilai_lama_kerja == 4){
        $bobot_lamakerja = 0.19;
    }else{
        $bobot_lamakerja = 0;
    }
    $penilaian_lamakerja = $nilai_lama_kerja * $bobot_lamakerja;
        ?>

<tr>
            <td>Lama Kerja</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($lama_kerja_desc); ?></td>
            <td class="text-center"><?php echo number_format($nilai_lama_kerja, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_lamakerja, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($penilaian_lamakerja, 2, ',', '.'); ?></td>
        </tr>
<?php
$data_penilaian_risiko  = [$nilai_sifat, 
                           $nilai_ideb, 
                           $nilai_repayment, 
                           $nilai_perkara_hukum, 
                           $nilai_gaya_hidup, 
                           $nilai_lama_kerja];
$penilaian_risiko_maksimum = max($data_penilaian_risiko);

$jumlah_bobot = $bobot_risiko + $bobot_ideb + $bobot_repayment + $bobot_perkarahukum + $bobot_gayahidup + $bobot_lamakerja;
$rata_bobot   = $jumlah_bobot/6;

$jumlah_nilai = $nilai + $penilaian_ideb + $penilaian_repayment + $penilaian_perkarahukum + $penilaian_gayahidup + $penilaian_lamakerja;
$rata_nilai   = $jumlah_nilai/6;
?>
<tr>
            <td><b>NILAI MAKSIMUM</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($penilaian_risiko_maksimum, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_bobot, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_nilai, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td><b>SUB TOTAL I</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo number_format($jumlah_nilai, 2, ',', '.'); ?></b></td>
        </tr>
    </tbody>
</table>
<?php include(__DIR__ . '/../add/add_karakter.php'); ?>
<?php
// Tambahan modul terkait
include("kemampuan.php");
include("agunan.php");
include("kondisi_ekonomi.php");
include("dokumentasi.php");
?>
