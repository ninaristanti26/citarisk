<?php
include(__DIR__ . '/../../Database/koneksi.php');
include(__DIR__ . '/../../getCode/getKondisi_ekonomi.php');
include(__DIR__ . '/../../getCode/getDetail.php');

$ekonomi = $getKondisi_ekonomi[0] ?? [];
$dataDeb = $getDetail[0] ?? [];

$id_role_login     = $_SESSION['id_role'];
$id_pegawai_login  = $_SESSION['id_pegawai'];
$kode_cabang_login = $_SESSION['kode_cabang'];

$kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;
$id_pegawai_data   = $dataDeb['id_pegawai'] ?? null;

$pengaruh_eksternal = $ekonomi['pengaruh_eksternal'] ?? null;
$lama_operasi       = $ekonomi['lama_operasi'] ?? null;

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

// Pegawai yang datanya sedang ditampilkan
$id_pegawai_data = $dataDeb['id_pegawai'] ?? null;

// Cek apakah semua data karakter kosong
$all_empty = empty($pengaruh_eksternal) && 
             empty($lama_operasi) &&
             $id_pegawai_login == $_SESSION['id_pegawai'] &&
             $kode_cabang_login == $kode_cabang_data &&
             $id_role_login == 12
?>
<table class="table table-bordered table-hover table-sm mb-0">
<tbody class="text-dark">
<tr class="bg-light">
    <th class="text-start" colspan="4">
        <u>Kondisi Ekonomi</u>
    </th>
    <td class="text-end">
    </td>
    <td class="text-right"><?php if ($all_empty): ?>
        <button type="button" class="btn btn-primary btn-sm text-white" onclick="toggleFormKondisiEkonomi()">+ Tambah Data</button>
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
        <!-- Pengaruh Eksternal -->
        <?php
        $pengaruh_eksternal_desc = 'Data masih kosong';
        if (isset($ekonomi['pengaruh_eksternal'])) {
            switch ($ekonomi['pengaruh_eksternal']) {
                case '2':
                    $pengaruh_eksternal_desc = 'Bekerja di instansi pemerintahan atau perusahaan yang tidak terpengaruh oleh kebijakan eksternal.';
                    break;
                case '3':
                    $pengaruh_eksternal_desc = 'Bekerja di instansi pemerintahan dengan status kontrak/honor atau perusahaan dengan resistensi rendah terhadap kebijakan eksternal.';
                    break;
                default:
                    $pengaruh_eksternal_desc = 'Bekerja di perusahaan dengan resistensi tinggi terhadap kebijakan eksternal.';
            }
        }
        ?>
        <tr>
            <td>Pengaruh Eksternal Terhadap Kondisi Perusahaan</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($pengaruh_eksternal_desc); ?></td>
            <td class="text-center"><?php echo number_format($pengaruh_eksternal, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko_pengaruh_eksternal, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_pengaruh_eksternal, 2, ',', '.'); ?></td>
        </tr>

        <!-- Lama Operasi Perusahaan -->
        <?php
        $lama_operasi_desc = 'Data masih kosong';
        if (isset($ekonomi['lama_operasi'])) {
            switch ($ekonomi['lama_operasi']) {
                case '2':
                    $lama_operasi_desc = 'Perusahaan beroperasi lebih dari 10 tahun.';
                    break;
                case '3':
                    $lama_operasi_desc = 'Perusahaan beroperasi antara 7 - 10 tahun.';
                    break;
                default:
                    $lama_operasi_desc = 'Perusahaan beroperasi kurang dari 7 tahun.';
            }
        }
        ?>
        <tr>
            <td>Lama Perusahaan Beroperasi</td>
            <td class="text-center">:</td>
            <td><?php echo htmlspecialchars($lama_operasi_desc); ?></td>
            <td class="text-center"><?php echo number_format($lama_operasi, 0, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($bobot_risiko_lama_operasi, 2, ',', '.'); ?></td>
            <td class="text-center"><?php echo number_format($nilai_lama_operasi, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><b>RATA-RATA</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"><b><?php echo number_format($rata_penilaian_risiko_ekonomi, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_bobot_ekonomi, 2, ',', '.'); ?></b></td>
            <td class="text-center"><b><?php echo number_format($rata_nilai_ekonomi, 2, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <td><b>SUB TOTAL IV</b></td>
            <td class="text-center">:</td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"><b><?php echo number_format($jumlah_nilai_ekonomi, 2, ',', '.'); ?></b></td>
        </tr>
    </tbody>
</table>
<?php include(__DIR__ . '/../add/add_kondisi_ekonomi.php'); ?>