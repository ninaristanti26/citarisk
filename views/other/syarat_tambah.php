
<?php
include "add/add_syarat_tambah.php";

$id_putusan_analis = $data_putusan_analis['id_putusan_analis'] ?? 0;

include("../getCode/getSyaratTambah.php");

// Debug
//echo '<pre>';
//ar_dump($getSyaratTambah);
//echo '</pre>';
?>

<?php if (!empty($getSyaratTambah)): ?>
    <div class="mt-3">
        <h6 class="fw-bold">📋 Daftar Syarat Tambahan:</h6>
        <ol class="ps-5">
            <?php foreach ($getSyaratTambah as $syarat): ?>
                <li><?php echo htmlspecialchars($syarat['syarat_tambah'] ?? '-'); ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php else: ?>
    <p class="mt-3"><em>🔍 Belum ada syarat tambahan yang ditambahkan.</em></p>
<?php endif; ?>

   
      