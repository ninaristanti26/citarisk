<?php include "other/header.php"; ?>
<style>
.timeline {
    position: relative;
    margin-left: 30px;
    padding-left: 20px;
    border-left: 2px solid #dee2e6;
}
.timeline li {
    position: relative;
    margin-bottom: 2rem;
}
.timeline li:last-child {
    margin-bottom: 0;
}
.timeline .timeline-dot {
    position: absolute;
    left: -36px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.timeline .timeline-dot i {
    font-size: 1rem;
}
</style>

<?php
include("../Database/koneksi.php");
include("../getCode/getDetail.php");
include("../getCode/getRiwayatKreditTreking.php");
include("../getCode/getPutusanAnalis.php");
include("../getCode/getOpiniKasop.php");
include("../getCode/getPutusanKaspem.php");
include("../getCode/getPutusanPinca.php");
include("../getCode/getPutusanAnalisPusat.php");
include("../getCode/getPutusanKabag.php");
include("../getCode/getPutusanKadiv.php");
include("../getCode/getPutusanDirut.php");

// Siapkan array kosong jika tidak ada data
$getRiwayat_kredit_treking = $getRiwayat_kredit_treking ?: [[]];
$getPutusanAnalis          = $getPutusanAnalis ?: [[]];
$getOpiniKasop             = $getOpiniKasop ?: [[]];
$getPutusanKaspem          = $getPutusanKaspem ?: [[]];
$getPutusanPinca           = $getPutusanPinca ?: [[]];
$getPutusanAnalisPusat     = $getPutusanAnalisPusat ?: [[]];
$getPutusanKabag           = $getPutusanKabag ?: [[]];
$getPutusanKadiv           = $getPutusanKadiv ?: [[]];
$getPutusanDirut           = $getPutusanDirut ?: [[]];
?>

<div id="content-page" class="content-page">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-12">

<?php foreach ($getDetail as $dataDeb):
    $no_ktp_encoded = urlencode($dataDeb['no_ktp']);

    $dataRiwayat            = $getRiwayat_kredit_treking[0];
    $dataPutusan            = $getPutusanAnalis[0];
    $dataOpiniKasop         = $getOpiniKasop[0];
    $dataPutusanKaspem      = $getPutusanKaspem[0];
    $dataPutusanPinca       = $getPutusanPinca[0];
    $dataPutusanAnalisPusat = $getPutusanAnalisPusat[0];
    $dataPutusanKabag       = $getPutusanKabag[0];
    $dataPutusanKadiv       = $getPutusanKadiv[0];
    $dataPutusanDirut       = $getPutusanDirut[0];

    $updateDate            = $dataRiwayat['update_riwayat_kredit'] ?? '';
    $updateDatePutusan     = $dataPutusan['waktu_putus_analis'] ?? '';
    $updateAppKaspem       = $dataPutusan['waktu_approve_kaspem'] ?? '';
    $status_putusan_analis = ($dataPutusan['status_putusan_analis'] ?? '') == "Pending" 
        ? "Perlu Review Kepala Seksi Pemasaran" 
        : "Usulan Kredit Selesai di Review oleh Kasie. Pemasaran";

    $updateDateOpiniKasop  = $dataOpiniKasop['created_at'] ?? '';
    $updateAppPinca        = $dataPutusanKaspem['waktu_approve_pinca'] ?? '';
    $status_putusan_kaspem = ($dataPutusanKaspem['status_putusan_kaspem'] ?? '') == "Pending" 
        ? "Proses Pengambilan Keputusan Kredit" 
        : "Usulan Kredit Selesai Diputuskan oleh Pimpinan Cabang";

    $updatePinca = $dataPutusanPinca['waktu_putus_pinca'] ?? '';
    $status      = $dataPutusanPinca['status'] ?? 'Status tidak tersedia';

    $updateAppKabag = $dataPutusanAnalisPusat['waktu_approve_kabag'] ?? '';
    $status_putusan_analis_pusat = ($dataPutusanAnalisPusat['status_putusan_analis_pusat'] ?? '') == "Pending" 
        ? "Perlu Approve Kepala Bagian Pemasaran" 
        : "Usulan Kredit Selesai Proses oleh Kepala Bagian Pemasaran";

    $updateDatePutusanKadiv = $dataPutusanKabag['waktu_approve_kadiv'] ?? '';
    $status_putusan_kabag   = ($dataPutusanKabag['status_putusan_kabag'] ?? '') == "Pending" 
        ? "Perlu Proses Kepala Divisi Pemasaran" 
        : "Usulan Kredit Selesai Proses oleh Kepala Divisi Pemasaran";

    $updateKadiv  = $dataPutusanKadiv['waktu_putus_kadiv'] ?? '';
    $status_kadiv = $dataPutusanKadiv['status_kadiv'] ?? 'Status tidak tersedia';

    $updateDirut = $dataPutusanDirut['waktu_putus_dirut'] ?? '';

    // Bangun event berdasarkan validasi tanggal
    $rawEvents = [
        ['color' => 'danger',  'title' => 'Kredit Diusulkan', 'date' => $updateDate],
        ['color' => 'success', 'title' => 'Kredit Dianalisa', 'date' => $updateDatePutusan],
        ['color' => 'primary', 'title' => $status_putusan_analis, 'date' => $updateAppKaspem],
        ['color' => 'info',    'title' => 'Opini Kepatuhan dari Kasie. Ops dan Kepatuhan',  'date' => $updateDateOpiniKasop],
        ['color' => 'warning', 'title' => $status_putusan_kaspem, 'date' => $updateAppPinca],
        ['color' => 'info',    'title' => $status, 'date' => $updatePinca],
        ['color' => 'success', 'title' => $status_putusan_analis_pusat, 'date' => $updateAppKabag],
        ['color' => 'danger',  'title' => $status_putusan_kabag, 'date' => $updateDatePutusanKadiv],
        ['color' => 'warning', 'title' => $status_kadiv, 'date' => $updateKadiv],
        ['color' => 'danger',  'title' => 'Approval Direktur Utama', 'date' => $updateDirut]
    ];

    $events = [];
    foreach ($rawEvents as $event) {
        $tanggal = trim($event['date']);
        if (empty($tanggal) || strtolower($tanggal) === 'null' || $tanggal === 'Tanggal tidak tersedia') {
            break;
        }
        $events[] = $event;
    }

    if (empty($events)) {
        $events[] = [
            'color' => 'secondary',
            'title' => 'Belum ada proses kredit',
            'date'  => 'Tanggal tidak tersedia'
        ];
    }
?>

<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-0">
      Tracking Kredit - <?= htmlspecialchars($dataDeb['nama_debitur']) ?> 
      dengan Plafon Pengajuan - <?= number_format($dataRiwayat['plafon_pengajuan'] ?? 0) ?>
    </h4>
  </div>
  <div class="card-body">
    <ul class="timeline list-unstyled">
      <?php foreach ($events as $event): ?>
      <li>
        <div class="timeline-dot bg-<?= $event['color'] ?>">
          <i class="ri-pantone-line"></i>
        </div>
        <div class="ms-2">
          <div class="d-flex justify-content-between">
            <h6 class="mb-1 fw-semibold"><?= $event['title'] ?></h6>
            <span class="badge bg-dark text-light"><?= $event['date'] ?></span>
          </div>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<?php include "other/footer.php"; ?>
