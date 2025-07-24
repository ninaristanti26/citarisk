<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📊 Analisis Kemampuan Bayar Debitur</h5>
</div>

<div class="table-responsive">
    <?php
    include("../Database/koneksi.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getBank_lain.php");
    include("../getCode/getPekerjaan.php");
    include("../getCode/getRiwayat_kredit.php");

    $dataKeuangan  = isset($options[0]) ? $options[0] : [];
    $dataBankLain  = isset($getBankLain[0]) ? $getBankLain[0] : [];
    $dataPekerjaan = isset($getPekerjaan[0]) ? $getPekerjaan[0] : [];
    $dataRiwayat   = isset($getRiwayat_kredit[0]) ? $getRiwayat_kredit[0] : [];

    $penghasilan_tetap    = !empty($dataKeuangan['penghasilan_tetap']) ? $dataKeuangan['penghasilan_tetap'] : 0;
    $penghasilan_variabel = !empty($dataKeuangan['penghasilan_variabel']) ? $dataKeuangan['penghasilan_variabel'] : 0;
    $jumlah_penghasilan   = $penghasilan_tetap + $penghasilan_variabel;

    $penghasilan_bersih = $jumlah_penghasilan - $total_angsuran;

    $rasio        = !empty($dataPekerjaan['rasio']) ? $dataPekerjaan['rasio'] : 0;
    $rasio_pembiayaan = $rasio/100;
    $max_angs = $penghasilan_bersih*$rasio_pembiayaan;
    $jw_pengajuan = !empty($dataRiwayat['jw_pengajuan']) ? $dataRiwayat['jw_pengajuan'] : 0;
    $jw_maks      = !empty($dataKeuangan['jw_maks']) ? $dataKeuangan['jw_maks'] : 0;
    $bunga_maks   = !empty($dataKeuangan['bunga_maks']) ? $dataKeuangan['bunga_maks'] : 0;
    $bunga_perbulan = $bunga_maks/12;

    $plafon_pengajuan   = !empty($dataRiwayat['plafon_pengajuan']) ? $dataRiwayat['plafon_pengajuan'] : 0;

    //menghitung plafon maksimum
    $pembilang        = $rasio_pembiayaan * $penghasilan_bersih * $jw_maks;
    $penyebut         = ($bunga_perbulan * $jw_maks) + 100;
    if (isset($pembilang, $penyebut) && is_numeric($pembilang) && is_numeric($penyebut)) {
        $plafon_maksimum = ($pembilang / $penyebut) * 100;
    } else {
        $plafon_maksimum = 0;
    }
    
    if (isset($plafon_maksimum) && is_numeric($plafon_maksimum) && isset($jw_maks) && $jw_maks != 0) {
        $angs_pokok = $plafon_maksimum / $jw_maks;
    } else {
        $angs_pokok = 0;
    }

    $angs_bunga       = ($plafon_maksimum * $bunga_perbulan) / 100;
    $jml_angs         = $angs_pokok + $angs_bunga;

    //menghitung plafon usulan
    $penyebut_usulan   = $max_angs - ($plafon_pengajuan * $bunga_perbulan) / 100;
    if (isset($plafon_pengajuan) && is_numeric($plafon_pengajuan) && isset($penyebut_usulan) && $penyebut_usulan != 0) {
        $plafon_usulan = ($plafon_pengajuan/$penyebut_usulan) * 100;
    } else {
        $plafon_usulan = 0;
    }
    $plafon_usulan_bulat    = round($plafon_usulan, 2);
    if (isset($plafon_pengajuan) && is_numeric($plafon_pengajuan) && isset($jw_pengajuan) && $jw_pengajuan != 0) {
        $angs_pokok_pengajuan    = $plafon_pengajuan / $jw_pengajuan;
    } else {
        $angs_pokok_pengajuan = 0;
    }
    $angs_bunga_pengajuan    = ($plafon_pengajuan * $bunga_perbulan) / 100;
    $jml_angs_pengajuan      = $angs_pokok_pengajuan + $angs_bunga_pengajuan;
    ?>

<table class="table table-bordered table-hover table-sm mb-0">
    <tbody class="text-dark">
        <tr>
            <th class="bg-light text-start" style="width: 300px;">Rasio</th>
            <td class="text-center" style="width: 10px;">:</td>
            <td class="text-start">
                <?php echo number_format($rasio, 0, ',', '.'); ?> % |
                <span class="text-muted">Dalam Nominal:</span> Rp <?php echo number_format($max_angs, 0, ',', '.'); ?>
            </td>
        </tr>
        <tr>
            <th class="bg-light text-start">Jangka Waktu yang Dimohon</th>
            <td class="text-center">:</td>
            <td class="text-start"><?php echo number_format($jw_pengajuan, 0, ',', '.'); ?> bulan</td>
        </tr>
        <tr>
            <th class="bg-light text-start">Jangka Waktu Maksimum</th>
            <td class="text-center">:</td>
            <td class="text-start"><?php echo number_format($jw_maks, 0, ',', '.'); ?> bulan</td>
        </tr>
        <tr>
            <th class="bg-light text-start">Suku Bunga</th>
            <td class="text-center">:</td>
            <td class="text-start">
                <?php echo number_format($bunga_maks, 2, ',', '.'); ?>% / tahun |
                <?php echo number_format($bunga_perbulan, 2, ',', '.'); ?>% / bulan
            </td>
        </tr>
    </tbody>
</table>
<hr>
<h6 class="text-dark mb-3"><b><u>Menghitung Plafon Maksimum</u></b></h6>
<table class="table table-bordered table-sm text-center mb-4">
    <tbody>
        <tr>
            <td><?php echo number_format($rasio); ?>%</td>
            <td>&times;</td>
            <td>Rp <?php echo number_format($penghasilan_bersih, 0, ',', '.'); ?></td>
            <td>&times;</td>
            <td><?php echo $jw_maks; ?> bulan</td>
            <td>=</td>
            <td><strong>Rp <?php echo number_format($pembilang, 0, ',', '.'); ?></strong></td>
        </tr>
        <tr>
            <td>100%</td>
            <td>&times;</td>
            <td>(<?php echo number_format($bunga_perbulan, 2, ',', '.'); ?>%)</td>
            <td>&times;</td>
            <td><?php echo $jw_maks; ?></td>
            <td>=</td>
            <td><strong><?php echo number_format($penyebut, 2, ',', '.'); ?>%</strong></td>
        </tr>
        <tr class="bg-light fw-bold">
            <td colspan="6" class="text-end">Plafon Maksimum</td>
            <td class="text-primary">Rp <?php echo number_format($plafon_maksimum, 0, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>

<style>
    .table-custom th {
        width: 250px;
    }
</style>

<table class="table table-bordered table-hover table-sm mb-0">
    <tbody class="text-dark">
        <!-- Bagian 1: Usulan Plafon Maksimum Kredit -->
        <tr class="bg-light">
            <th colspan="3"><u>USULAN PLAFON MAKSIMUM KREDIT</u></th>
        </tr>
        <tr>
            <th class="bg-light text-start" style="width: 300px;">Plafon</th>
            <td class="text-center" style="width: 10px;">:</td>
            <td class="text-end">
                <?php echo !empty($plafon_maksimum) ? number_format($plafon_maksimum) : 0; ?>
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Suku Bunga Perbulan</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($bunga_perbulan) ? number_format($bunga_perbulan, 2) : 0; ?>%
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Jangka Waktu</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($jw_maks) ? number_format($jw_maks, 0) : 0; ?> bulan
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Angsuran Pokok</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($angs_pokok) ? number_format($angs_pokok, 0) : 0; ?>
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Angsuran Bunga</th>
            <td>:</td>
            <td class="text-end">
                <u><?php echo !empty($angs_bunga) ? number_format($angs_bunga, 0) : 0; ?></u>
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Jumlah Angsuran</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($jml_angs) ? number_format($jml_angs, 0) : 0; ?>
            </td>
        </tr>

        <!-- Spacer -->
        <tr><td colspan="3">&nbsp;</td></tr>

        <!-- Bagian 2: Berdasarkan Plafon yang Dimohon -->
        <tr class="bg-light">
            <th colspan="3"><u>BERDASARKAN PLAFON YANG DIMOHON</u></th>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Plafon</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($dataRiwayat['plafon_pengajuan']) ? number_format($dataRiwayat['plafon_pengajuan']) : 0; ?>
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Suku Bunga</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($bunga_perbulan) ? number_format($bunga_perbulan, 2) : 0; ?>%
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Jangka Waktu</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($jw_pengajuan) ? number_format($jw_pengajuan) : 0; ?> bulan
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Angsuran Pokok</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($angs_pokok_pengajuan) ? number_format($angs_pokok_pengajuan) : 0; ?>
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Angsuran Bunga</th>
            <td>:</td>
            <td class="text-end">
                <u><?php echo !empty($angs_bunga_pengajuan) ? number_format($angs_bunga_pengajuan) : 0; ?></u>
            </td>
        </tr>
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Jumlah Angsuran</th>
            <td>:</td>
            <td class="text-end">
                <?php echo !empty($jml_angs_pengajuan) ? number_format($jml_angs_pengajuan) : 0; ?>
            </td>
        </tr>
    </tbody>
</table>

</div>
