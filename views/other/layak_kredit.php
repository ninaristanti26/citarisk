<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getKarakter.php');
include(__DIR__ . '/../../getCode/getDetail.php');
include(__DIR__ . '/../../getCode/getKemampuan.php');
include(__DIR__ . '/../../getCode/getAgunan.php');
include(__DIR__ . '/../../getCode/getKondisi_ekonomi.php');
include(__DIR__ . '/../../getCode/getLegal.php');

$dataKarakter  = $getKarakter[0] ?? [];
$dataKemampuan = $getKemampuan[0] ?? [];
$agunan        = $getAgunan[0] ?? [];
$ekonomi       = $getKondisi_ekonomi[0] ?? [];
$legal         = $getLegal[0] ?? [];

$nilai_sifat             = $dataKarakter['sifat'] ?? null;
$nilai_ideb              = $dataKarakter['ideb'] ?? null;
$nilai_repayment         = $dataKarakter['repayment'] ?? null;
$nilai_perkara_hukum     = $dataKarakter['perkara_hukum'] ?? null;
$nilai_gaya_hidup        = $dataKarakter['gaya_hidup'] ?? null;
$nilai_lama_kerja        = $dataKarakter['lama_kerja'] ?? null;
$pengendalian_pembayaran = $dataKemampuan['pengendalian_pembayaran'] ?? null;
$kualitas_angsuran       = $dataKemampuan['kualitas_angsuran'] ?? null;
$mou                     = $agunan['mou'] ?? null;
$sk                      = $agunan['sk'] ?? null;
$tambahan_agunan         = $agunan['tambahan_agunan'] ?? null;
$pengaruh_eksternal      = $ekonomi['pengaruh_eksternal'] ?? null;
$lama_operasi            = $ekonomi['lama_operasi'] ?? null;
$legal_pemohon           = $legal['legal_pemohon'] ?? null;
$legal_ideb              = $legal['legal_ideb'] ?? null;
$kelengkapan_syarat      = $legal['kelengkapan_syarat'] ?? null;
$kelengkapan_legal       = $legal['kelengkapan_legal'] ?? null;

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


//risiko pengaruh eskternal
if($pengaruh_eksternal == 1){
    $bobot_risiko_pengaruh_eksternal = 11;
}elseif($pengaruh_eksternal == 2){
    $bobot_risiko_pengaruh_eksternal = 4.13;
}elseif($pengaruh_eksternal == 3){
    $bobot_risiko_pengaruh_eksternal = 1.83;
}elseif($pengaruh_eksternal == 4){
    $bobot_risiko_pengaruh_eksternal = 0.69;
}else{
    $bobot_risiko_pengaruh_eksternal = 0;
}
$nilai_pengaruh_eksternal = $pengaruh_eksternal * $bobot_risiko_pengaruh_eksternal;

//risiko lama operasi
if($lama_operasi == 1){
    $bobot_risiko_lama_operasi = 9;
}elseif($lama_operasi == 2){
    $bobot_risiko_lama_operasi = 3.38;
}elseif($lama_operasi == 3){
    $bobot_risiko_lama_operasi = 1.50;
}elseif($lama_operasi == 4){
    $bobot_risiko_lama_operasi = 0.56;
}else{
    $bobot_risiko_lama_operasi = 0;
}
$nilai_lama_operasi = $lama_operasi * $bobot_risiko_lama_operasi;

$jumlah_risiko_ekonomi          = $pengaruh_eksternal + $lama_operasi;
$rata_penilaian_risiko_ekonomi  = $jumlah_risiko_ekonomi/2;

$jumlah_bobot_ekonomi = $bobot_risiko_pengaruh_eksternal + $bobot_risiko_lama_operasi;
$rata_bobot_ekonomi   = $jumlah_bobot_ekonomi/2;

$jumlah_nilai_ekonomi = $nilai_pengaruh_eksternal + $nilai_lama_operasi;
$rata_nilai_ekonomi   = $jumlah_nilai_ekonomi/2;


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
$total_rata_risiko = (
    $nilai_sifat + $nilai_ideb + $nilai_repayment + $nilai_perkara_hukum + $nilai_gaya_hidup + $nilai_lama_kerja +
    $pengendalian_pembayaran + $kualitas_angsuran + $mou + $sk + $tambahan_agunan + $pengaruh_eksternal + $lama_operasi + $legal_pemohon +
    $legal_ideb + $kelengkapan_syarat + $kelengkapan_legal
 ) / 17;
if($total_rata_risiko >= 1.00 && $total_rata_risiko <= 1.50){
$rata_risiko = "Sangat Rendah";
}elseif($total_rata_risiko >= 1.51 && $total_rata_risiko <= 2.00){
$rata_risiko = "Rendah";
}elseif($total_rata_risiko >= 2.01 && $total_rata_risiko <= 2.50){
$rata_risiko = "Sedang";
}elseif($total_rata_risiko >= 2.51 && $total_rata_risiko <= 3.00){
$rata_risiko = "Tinggi";
}elseif($total_rata_risiko >= 3.01 && $total_rata_risiko <= 5.00){
$rata_risiko = "Sangat Tinggi";
}else{
$rata_risiko = "Data masih kosong";
}

if($total >= 0 && $total <= 49){
$penilaian_analisa_kredit = "Tidak Layak";
}elseif($total >= 50 && $total <= 62){
$penilaian_analisa_kredit = "Kurang Layak";
}elseif($total >= 63 && $total <= 75){
$penilaian_analisa_kredit = "Cukup Layak";
}elseif($total >= 76 && $total <= 88){
$penilaian_analisa_kredit = "Layak";
}elseif($total >= 89 && $total <= 100){
$penilaian_analisa_kredit = "Sangat Layak";
}
?>
<tr>
            <td><b>TOTAL</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo number_format($total, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center"></td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
        <tr>
            <td><b>Total Rata-rata Risiko</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($total_rata_risiko, 2, ',', '.'); ?></b></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo $rata_risiko; ?></b></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center"></td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
        <tr>
            <td><b>Penilaian Analisis Kredit</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($total, 2, ',', '.'); ?></b></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo $penilaian_analisa_kredit; ?></b></td>
        </tr>