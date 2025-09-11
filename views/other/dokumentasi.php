<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getLegal.php');
include(__DIR__ . '/../../getCode/getDetail.php');

$legal   = $getLegal[0] ?? [];
$dataDeb = $getDetail[0] ?? [];

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

$legal_pemohon      = $legal['legal_pemohon'] ?? null;
$legal_ideb         = $legal['legal_ideb'] ?? null;
$kelengkapan_syarat = $legal['kelengkapan_syarat'] ?? null;
$kelengkapan_legal  = $legal['kelengkapan_legal'] ?? null;

//risiko legal pemohon
if($legal_pemohon == 1){
    $bobot_legal_pemohon = 4;
}elseif($legal_pemohon == 2){
    $bobot_legal_pemohon = 1.50;
}elseif($legal_pemohon == 3){
    $bobot_legal_pemohon = 0.67;
}elseif($legal_pemohon == 4){
    $bobot_legal_pemohon = 0.25;
}else{
    $bobot_legal_pemohon = 0;
}
$nilai_legal_pemohon = $legal_pemohon * $bobot_legal_pemohon;

//risiko legal ideb
if($legal_ideb == 1){
    $bobot_legal_ideb = 7;
}elseif($legal_ideb == 2){
    $bobot_legal_ideb = 2.63;
}elseif($legal_ideb == 3){
    $bobot_legal_ideb = 1.17;
}elseif($legal_ideb == 4){
    $bobot_legal_ideb = 0.25;
}else{
    $bobot_legal_ideb = 0;
}
$nilai_legal_ideb = $legal_ideb * $bobot_legal_ideb;

//risiko kelengkapan persyaratan
if($kelengkapan_syarat == 1){
    $bobot_kelengkapan_syarat = 4;
}elseif($kelengkapan_syarat == 2){
    $bobot_kelengkapan_syarat = 1.50;
}elseif($kelengkapan_syarat == 3){
    $bobot_kelengkapan_syarat = 0.67;
}elseif($kelengkapan_syarat == 4){
    $bobot_kelengkapan_syarat = 0.25;
}else{
    $bobot_kelengkapan_syarat = 0;
}
$nilai_kelengkapan_syarat = $kelengkapan_syarat * $bobot_kelengkapan_syarat;

//risiko kelengkapan persyaratan
if($kelengkapan_legal == 1){
    $bobot_kelengkapan_legal = 5;
}elseif($kelengkapan_legal == 2){
    $bobot_kelengkapan_legal = 1.88;
}elseif($kelengkapan_legal == 3){
    $bobot_kelengkapan_legal = 0.83;
}elseif($kelengkapan_legal == 4){
    $bobot_kelengkapan_legal = 0.31;
}else{
    $bobot_kelengkapan_legal = 0;
}
$nilai_kelengkapan_legal = $kelengkapan_legal * $bobot_kelengkapan_legal;

$jumlah_risiko_legal   = $legal_pemohon + $legal_ideb + $kelengkapan_syarat + $kelengkapan_legal;
$rata_penilaian_legal  = $jumlah_risiko_legal/4;

$jumlah_bobot_legal = $bobot_legal_pemohon + $bobot_legal_ideb + $bobot_kelengkapan_syarat + $bobot_kelengkapan_legal;
$rata_bobot_legal   = $jumlah_bobot_legal/4;

$jumlah_nilai_legal = $nilai_legal_pemohon + $nilai_legal_ideb + $nilai_kelengkapan_syarat + $nilai_kelengkapan_legal;
$rata_nilai_legal   = $jumlah_nilai_legal/4;


$total = $jumlah_nilai + $jumlah_nilai_repayment + $jumlah_nilai_agunan + $jumlah_nilai_ekonomi + $jumlah_nilai_legal;


// Pegawai yang sedang login
$id_pegawai_login = $_SESSION['id_pegawai'];

// Pegawai yang datanya sedang ditampilkan
$id_pegawai_data = $dataDeb['id_pegawai'] ?? null;

// Cek apakah semua data karakter kosong
$all_empty = empty($legal_pemohon) && 
             empty($legal_ideb) &&
             empty($kelengkapan_syarat) &&
             empty($kelengkapan_legal) &&
             $id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12
             ;
?>

<table class="table table-bordered table-hover table-sm mb-0">
<tbody class="text-dark">
<tr class="bg-light">
    <th class="text-start" colspan="4">
        <u>Legalitas dan Dokumentasi</u>
    </th>
    <td class="text-end">
    </td>
            <td class="text-right"><?php if ($all_empty): ?>
                    <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormDokumentasi()">+ Tambah Data</button>
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
        <!-- Legalitas Permohonan -->
        <?php
$legal_pemohon_raw = 'Data masih kosong';

if (isset($legal['legal_pemohon'])) {
    switch ($legal['legal_pemohon']) {
        case '2':
            $legal_pemohon_raw = '1. Formulir permohonan lengkap dan ditandatangani |
                                  2. Surat persetujuan suami/istri lengkap dan ditandatangani |
                                  3. Rekomendasi dari atasan lengkap dan dicap (untuk perusahaan MoU) |
                                  4. Surat kuasa penarikan tabungan ditandatangani calon debitur';
            break;
        case '3':
            $legal_pemohon_raw = '1. Formulir tidak lengkap tapi ditandatangani |
                                  2. Surat persetujuan tidak lengkap tapi ditandatangani |
                                  3. Rekomendasi tidak lengkap tapi ditandatangani |
                                  4. Surat kuasa tidak lengkap tapi ditandatangani';
            break;
        default:
            $legal_pemohon_raw = '1. Surat persetujuan lengkap tapi tidak ditandatangani |
                                  2. Surat kuasa lengkap tapi tidak ditandatangani |
                                  3. Rekomendasi lengkap dan dicap meskipun tanpa MoU';
    }
}

// Format deskripsi jadi multi-line HTML
$legal_pemohon_desc = nl2br(str_replace("|", "<br>", trim($legal_pemohon_raw)));
?>

<tr>
    <td>Legal Permohonan</td>
    <td class="text-center">:</td>
    <td><?php echo $legal_pemohon_desc; ?></td>
    <td class="text-center"><?php echo isset($legal_pemohon) ? number_format($legal_pemohon, 0, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($bobot_legal_pemohon) ? number_format($bobot_legal_pemohon, 2, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($nilai_legal_pemohon) ? number_format($nilai_legal_pemohon, 2, ',', '.') : '-'; ?></td>
</tr>
<?php
$legal_ideb_raw = 'Data masih kosong';
if (isset($legal['legal_ideb'])) {
    switch ($legal['legal_ideb']) {
        case '1':
            $legal_ideb_raw = 'Calon debitur <strong>TIDAK</strong> tercatat dalam DPO atau DTTOT.';
            break;
        case '5':
            $legal_ideb_raw = 'Calon debitur <strong>TERCATAT</strong> dalam DPO atau DTTOT.';
            break;
    }
} 
// Format deskripsi jadi multi-line HTML
$legal_ideb_desc = nl2br(str_replace("|", "<br>", trim($legal_ideb_raw)));
?>
        <tr>
    <td>Legal Identitas Debitur</td>
    <td class="text-center">:</td>
    <td><?php echo $legal_ideb_raw; ?></td>
    <td class="text-center"><?php echo isset($legal_ideb) ? number_format($legal_ideb, 0, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($bobot_legal_ideb) ? number_format($bobot_legal_ideb, 2, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($nilai_legal_ideb) ? number_format($nilai_legal_ideb, 2, ',', '.') : '-'; ?></td>
</tr>

<?php
$kelengkapan_syarat_raw = 'Data masih kosong';
if (isset($legal['kelengkapan_syarat'])) {
    switch ($legal['kelengkapan_syarat']) {
        case '2':
            $kelengkapan_syarat_raw = 'Calon debitur telah menyerahkan seluruh persyaratan.';
            break;
        case '3':
            $kelengkapan_syarat_raw = 'Calon debitur belum sepenuhnya menyerahkan persyaratan.';
            break;
        case '4':
            $kelengkapan_syarat_raw = 'Calon debitur belum menyerahkan sebagian besar persyaratan.';
            break;
    }
} ?>
        <tr>
    <td>Kelengkapan Syarat</td>
    <td class="text-center">:</td>
    <td><?php echo $kelengkapan_syarat_raw; ?></td>
    <td class="text-center"><?php echo isset($kelengkapan_syarat) ? number_format($kelengkapan_syarat, 0, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($bobot_kelengkapan_syarat) ? number_format($bobot_kelengkapan_syarat, 2, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($nilai_kelengkapan_syarat) ? number_format($nilai_kelengkapan_syarat, 2, ',', '.') : '-'; ?></td>
</tr>

        <!-- Kelengkapan Legal -->
        <?php
        $kelengkapan_legal_raw = 'Data masih kosong';
if (isset($legal['kelengkapan_legal'])) {
    switch ($legal['kelengkapan_legal']) {
        case '2':
            $kelengkapan_legal_raw = 'Debitur memenuhi aspek legal dan layak jadi subjek hukum.';
            break;
        case '4':
            $kelengkapan_legal_raw = 'Debitur tidak memenuhi aspek legal.';
            break;
    }
} ?>
          <tr>
    <td>Kelengkapan Legal</td>
    <td class="text-center">:</td>
    <td><?php echo $kelengkapan_legal_raw; ?></td>
    <td class="text-center"><?php echo isset($kelengkapan_legal) ? number_format($kelengkapan_legal, 0, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($bobot_kelengkapan_legal) ? number_format($bobot_kelengkapan_legal, 2, ',', '.') : '-'; ?></td>
    <td class="text-center"><?php echo isset($nilai_kelengkapan_legal) ? number_format($nilai_kelengkapan_legal, 2, ',', '.') : '-'; ?></td>
</tr>
<tr>
            <td><b>RATA-RATA</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($rata_penilaian_legal, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_bobot_legal, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_nilai_legal, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td><b>SUB TOTAL V</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo number_format($jumlah_nilai_legal, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center"></td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
        <?php include "layak_kredit.php"; ?>
    </tbody>
</table>
<?php 
include(__DIR__ . '/../add/add_dokumentasi.php');
?>
<!-- LEGAL OPINION -->

