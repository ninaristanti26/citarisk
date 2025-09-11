<?php
    include(__DIR__ . '/../../Database/koneksi.php');
    include(__DIR__ . '/../../getCode/getRiwayat_kredit.php');
    
    $dataRiwayat = isset($getRiwayat_kredit[0]) ? $getRiwayat_kredit[0] : [];
  
    $jenis_kredit     = !empty($dataRiwayat['jenis_kredit']) ? htmlspecialchars($dataRiwayat['jenis_kredit']) : '-';
    $plafon_pengajuan = !empty($dataRiwayat['plafon_pengajuan']) ? $dataRiwayat['plafon_pengajuan'] : 0;
    $jw_pengajuan     = !empty($dataRiwayat['jw_pengajuan']) ? htmlspecialchars($dataRiwayat['jw_pengajuan']) : '-';
    $tujuan_pengajuan = !empty($dataRiwayat['tujuan_pengajuan']) ? htmlspecialchars($dataRiwayat['tujuan_pengajuan']) : '-';
    
    ?>
<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">📑 Usulan Pengajuan Kredit Petugas Marketing</h5>
</div>

<div class="table-responsive text-black">
    
<table class="table table-bordered table-hover table-sm mb-0">
    <tbody class="text-dark">
        <tr>
        <th class="bg-light text-start" style="width: 300px;">Jenis Kredit</th>
            <td style="width: 10px;" class="text-center">:</td>
            <td class="text-start"><?php echo $jenis_kredit; ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Plafon Pengajuan</th>
            <td>:</td>
            <td class="text-start"><?php echo number_format($plafon_pengajuan, 0); ?></td>
        </tr>
        <tr>
            <th class="bg-light text-start">Jangka Waktu Pengajuan</th>
            <td>:</td>
            <td class="text-start"><?php echo $jw_pengajuan; ?> bulan</td>
        </tr>
        <tr>
            <th class="bg-light text-start">Tujuan Pengajuan</th>
            <td>:</td>
            <td class="text-start"><?php echo $tujuan_pengajuan; ?></td>
        </tr>
       </tbody>
</table>

</div>
