
<?php
include "add/add_syarat_tambah_pusat.php";

$id_putusan_analis_pusat = $data_putusan_analis_pusat['id_putusan_analis_pusat'] ?? 0;

include("../getCode/getSyaratTambahPusat.php");

// Debug
//echo '<pre>';
//var_dump($getSyaratTambahPusat);
//echo '</pre>';
?>

<?php if (!empty($getSyaratTambahPusat)): ?>
    <div class="mt-3">
        <h6 class="fw-bold">📋 Daftar Syarat Tambahan:</h6>
        <ol class="ps-5">
            <?php foreach ($getSyaratTambahPusat as $syarat_pusat): ?>
                <li><?php echo htmlspecialchars($syarat_pusat['syarat_tambah_pusat'] ?? '-'); ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php else: ?>
    <p class="mt-3"><em>🔍 Belum ada syarat tambahan yang ditambahkan.</em></p>
<?php endif; ?>

   
      