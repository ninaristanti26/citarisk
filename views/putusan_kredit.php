<?php
include "other/header.php";
include("../Database/koneksi.php");
include("../getCode/getDetail.php");
include("../getCode/getViewPutusanKredit.php");

foreach ($getPutusan_kredit as $dataPutusan) {
    $id_riwayat    = $dataPutusan['id_riwayat'];
    $kode_cabang   = $dataPutusan['kode_cabang'];
    $no_ktp        = $dataPutusan['no_ktp'];
    $bulan         = $dataPutusan['putusan_created_at'];
    $tgl_dipake    = date("d", strtotime($bulan));
    $bulan_dipake  = date("m", strtotime($bulan));
    $bulan_dipake2 = date("F", strtotime($bulan)); // lebih lengkap (e.g. "July")
    $tahun_dipake  = date("Y", strtotime($bulan));
    $nama_debitur  = $dataPutusan['nama_debitur'];
    $alamat        = $dataPutusan['alamat'];
    $plafon        = number_format($dataPutusan['plafon_kredit'], 0, ',', '.');
    $jw            = number_format($dataPutusan['jw_kredit']);
    $tujuan        = $dataPutusan['tujuan_pengajuan'];
?>

<style>
.kop-logo {
    max-width: 180px;
    height: auto;
}
.kop-surat td {
    vertical-align: top;
    font-size: 14px;
}
hr {
    border-top: 2px solid #000;
}
p {
    text-align: justify;
}
</style>

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card mb-4 w-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">🧾 Putusan Kredit</h5>
                        <button id="btnExportPdf" class="btn btn-light btn-sm">Cetak ke PDF</button>
                    </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="../layout/images/Logo BPR 1.png" class="kop-logo" alt="Logo BPR">
                    </div>
                   
                    <table class="table table-borderless kop-surat mb-4">
                        <tr>
                            <td width="130px" class="pt-0">Nomor</td>
                            <td width="10px" class="pt-0">:</td>
                            <td class="pt-0"><?= $id_riwayat; ?>/BPR-<?= $kode_cabang; ?>/<?= $bulan_dipake; ?>/<?= $tahun_dipake; ?></td>
                        </tr>
                        <tr>
                            <td class="pt-0">Perihal</td>
                            <td class="pt-0">:</td>
                            <td class="pt-0"><strong>Putusan Kredit</strong></td>
                        </tr>
                    </table>

                    <p><strong>Yang bertanda tangan di bawah ini:</strong></p>
                    <?php
                        include("../Database/koneksi.php");
                        $query_pinca = "SELECT nama FROM users WHERE id_role = 10 AND kode_cabang = ? LIMIT 1";
                        $stmt = $mysqli->prepare($query_pinca);
                        $stmt->bind_param("s", $kode_cabang);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $data_pinca = $result->fetch_assoc();
                        $pinca = $data_pinca['nama'] ?? 'Nama tidak ditemukan';
                    ?>
                    <table class="table table-borderless kop-surat mb-4">
                        <tr>
                            <td width="130px" class="pt-0">Nama</td>
                            <td width="10px" class="pt-0">:</td>
                            <td class="pt-0"><?= htmlspecialchars($pinca); ?></td>
                        </tr>
                        <tr>
                            <td class="pt-0">Jabatan</td>
                            <td class="pt-0">:</td>
                            <td class="pt-0">Kepala Cabang</td>
                        </tr>
                    </table>

                    <p>Setelah melakukan evaluasi dan penilaian terhadap pengajuan kredit yang diajukan oleh:</p>

                    <table class="table table-borderless kop-surat mb-4">
                        <tr>
                            <td width="130px" class="pt-0">Nama</td>
                            <td width="10px" class="pt-0">:</td>
                            <td class="pt-0"><?= htmlspecialchars($nama_debitur); ?></td>
                        </tr>
                        <tr>
                            <td class="pt-0">Alamat</td>
                            <td class="pt-0">:</td>
                            <td class="pt-0"><?= htmlspecialchars($alamat); ?></td>
                        </tr>
                        <tr>
                            <td class="pt-0">Nomor KTP</td>
                            <td class="pt-0">:</td>
                            <td class="pt-0"><?= htmlspecialchars($no_ktp); ?></td>
                        </tr>
                    </table>

                    <p>Maka dengan ini diputuskan bahwa pengajuan kredit atas nama tersebut <strong>disetujui</strong> untuk dicairkan dengan ketentuan sebagai berikut:</p>

                    <table class="table table-borderless kop-surat mb-4">
                        <tr>
                            <td width="150px" class="pt-0">Plafon Kredit</td>
                            <td width="10px" class="pt-0">:</td>
                            <td class="pt-0">Rp <?= $plafon; ?></td>
                        </tr>
                        <tr>
                            <td class="pt-0">Jangka Waktu</td>
                            <td class="pt-0">:</td>
                            <td class="pt-0"><?= $jw; ?> bulan</td>
                        </tr>
                        <tr>
                            <td class="pt-0">Tujuan Penggunaan</td>
                            <td class="pt-0">:</td>
                            <td class="pt-0"><?= htmlspecialchars($tujuan); ?></td>
                        </tr>
                    </table>

                    <p>Demikian surat keputusan ini dibuat untuk dipergunakan sebagaimana mestinya dan menjadi dasar pencairan kredit.</p>

                    <table class="table table-borderless kop-surat mt-5" style="width: 50%; float: right; text-align: center;">
                        <tr>
                            <td>Sukabumi, <?= $tgl_dipake . ' ' . $bulan_dipake2 . ' ' . $tahun_dipake; ?></td>
                        </tr>
                        <tr>
                            <td class="pt-0"><strong>Hormat Kami,</strong></td>
                        </tr>
                        <tr>
                            <td class="pt-5"><u><?= htmlspecialchars($pinca); ?></u></td>
                        </tr>
                        <tr>
                            <td class="pt-0">Kepala Cabang</td>
                        </tr>
                    </table>
                </div>
              <!--  <style>
                .footer-logo {
    width: 100%;
    height: auto;
    position: relative;
    margin-top: 20px;
}
</style>
                <div class="footer">
    <img src="../layout/images/Logo BPR 2.png" class="footer-logo" alt="Footer Logo">
</div>-->
            </div>
        </div>
    </div>
</div>

<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.getElementById('btnExportPdf').addEventListener('click', function () {
    // Pilih elemen yang ingin di-export ke PDF, misal isi card-body
    const element = document.querySelector('.card-body');

    // Atur opsi pdf
    var opt = {
        margin:       0.3,
        filename:     'Putusan_Kredit_<?= $id_riwayat; ?>.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    // Jalankan export pdf
    html2pdf().set(opt).from(element).save();
});
</script>
