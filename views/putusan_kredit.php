<?php
include "other/header.php";
include("../Database/koneksi.php");
include("../getCode/getDetail.php");
include("../getCode/getViewPutusanKredit.php");
foreach ($getPutusan_kredit as $dataPutusan) {
    $id_riwayat   = $dataPutusan['id_riwayat'];
    $kode_cabang  = $dataPutusan['kode_cabang'];
    $no_ktp       = $dataPutusan['no_ktp'];
    $bulan        = $dataPutusan['putusan_created_at'];
    $bulan_dipake = date("m", strtotime($bulan));
    $tahun_dipake = date("Y", strtotime($bulan));
    $nama_debitur = $dataPutusan['nama_debitur'];
    $alamat       = $dataPutusan['alamat'];
    $plafon       = number_format($dataPutusan['plafon_kredit']);
    $jw           = number_format($dataPutusan['jw_kredit']);
    $tujuan       = $dataPutusan['tujuan_pengajuan'];

?>
<style>
.kop-logo {
    max-width: 200px;
    height: auto;
    display: auto;
}
.kop-surat td {
    vertical-align: top;
    font-size: 14px;
}
</style>
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="card mb-4 w-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
               <h5 class="mb-0 text-white">🧾 Putusan Kredit</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                            <td class="text-center p-4"><img src="../layout/images/Logo BPR 1.png" class="kop-logo" alt="Logo BPR"></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr style="border: 1px solid #000; margin-top: 0;">
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="120px">Nomor</td>
                                <td width="10px">:</td>
                                <td><?php echo htmlspecialchars($id_riwayat); ?>/
                                    BPR-<?php echo htmlspecialchars($kode_cabang); ?>/
                                    <?= ($bulan_dipake); ?>/<?= ($tahun_dipake); ?></td>
                            </tr>
                            <tr>
                                <td>Perihal</td>
                                <td>:</td>
                                <td><strong>Putusan Kredit</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="120px">Yang bertanda tangan dibawah ini :</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="120px">Nama</td>
                                <td width="10px">:</td>
                                <td>Pimpinan Cabang</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>Kepala Cabang</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="120px">Setelah melakukan evaluasi dan penilaian terhadap pengajuan kredit yang diajukan oleh :</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="120px">Nama</td>
                                <td width="10px">:</td>
                                <td><?php echo htmlspecialchars($nama_debitur); ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($alamat); ?></td>
                            </tr>
                            <tr>
                                <td>Nomor KTP</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($no_ktp); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="120px">Maka dengan ini diputuskan bahwa pengajuan kredit atas nama tersebut disetujui untuk 
                                                  dicairkan dengan ketentuan sebagai berikut :</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-borderless kop-surat">
                        <tbody>
                            <tr>
                                <td width="150px">Plafond Kredit</td>
                                <td width="10px">:</td>
                                <td><?php echo htmlspecialchars($plafon); ?></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($jw); ?> bulan</td>
                            </tr>
                            <tr>
                                <td>Tujuan Penggunaan</td>
                                <td>:</td>
                                <td><?php echo htmlspecialchars($tujuan); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>