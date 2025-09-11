<?php
    include("../Database/koneksi.php");
    include("../getCode/getKeuangan.php");
    include("../getCode/getBank_lain.php");
    include("../getCode/getDetail.php");

    $dataKeuangan = $options[0] ?? [];
    $dataBankLain = $getBankLain[0] ?? [];
    $dataDeb      = $getDetail[0] ?? [];

    $id_role_login     = $_SESSION['id_role'];
    $id_pegawai_login  = $_SESSION['id_pegawai'];
    $kode_cabang_login = $_SESSION['kode_cabang'];
    $kode_cabang_data  = $dataDeb['kode_cabang'] ?? null;

    $penghasilan_tetap    = !empty($dataKeuangan['penghasilan_tetap']) ? $dataKeuangan['penghasilan_tetap'] : 0;
    $penghasilan_variabel = !empty($dataKeuangan['penghasilan_variabel']) ? $dataKeuangan['penghasilan_variabel'] : 0;
    $jumlah_penghasilan   = $penghasilan_tetap + $penghasilan_variabel;

    $total_angsuran = $dataBankLain['angs_bank_lain'] ?? 0;
    $penghasilan_bersih = $jumlah_penghasilan - $total_angsuran;

    $id_pegawai_login = $_SESSION['id_pegawai'];
    $id_pegawai_data  = $dataDeb['id_pegawai'] ?? null;
?>

<div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <h5 class="mb-0 text-white">💰 Data Keuangan yang Diperoleh</h5>
    <?php if (
        $penghasilan_tetap == 0 && 
        $penghasilan_variabel == 0 &&
        $id_pegawai_login == $_SESSION['id_pegawai'] &&
        $kode_cabang_login == $kode_cabang_data &&
        $id_role_login == 12
    ): ?>
        <button type="button" class="btn btn-light btn-sm text-primary" onclick="toggleFormDataKeuangan()">+ Tambah Data</button>
    <?php endif; ?>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm mb-0">
        <tbody class="text-dark">
            <tr>
                <th class="bg-light text-start" style="width: 300px;">Penghasilan Tetap / Gaji</th>
                <td class="text-center" style="width: 10px;">:</td>
                <td class="text-start"><?php echo number_format($penghasilan_tetap, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Penghasilan Lainnya (Lembur/Insentif/Bonus)</th>
                <td class="text-center">:</td>
                <td class="text-start"><?php echo number_format($penghasilan_variabel, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Jumlah Penghasilan</th>
                <td class="text-center">:</td>
                <td class="text-start font-weight-bold"><?php echo number_format($jumlah_penghasilan, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Angsuran ke Bank Lain</th>
                <td class="text-center">:</td>
                <td class="text-start"><?php echo number_format($total_angsuran, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th class="bg-light text-start">Penghasilan Bersih</th>
                <td class="text-center">:</td>
                <td class="text-start font-weight-bold"><?php echo number_format($penghasilan_bersih, 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- FORM TAMBAH DATA -->
<?php include "add/add_keuangan.php"; ?>

<!-- Pindahkan script ke sini agar dikenali -->
<script>
function toggleFormDataKeuangan() {
    const form = document.getElementById('formDataKeuangan');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#penghasilan_tetap, #penghasilan_variabel').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, "");
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });
});
</script>