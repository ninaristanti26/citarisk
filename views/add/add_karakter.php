<div id="formDataKarakter" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Skoring Karakter</h5>

    <form method="POST" action="../proses/proses_add_karakter.php">
        <input type="hidden" name="id_riwayat" value="<?php echo $_GET['id_riwayat']; ?>">
        <input type="hidden" name="no_ktp" value="<?php echo $_GET['no_ktp']; ?>">

        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tbody>
                    <!-- === 1. Sifat === -->
                    <tr class="table-light">
                        <th colspan="3">Sifat Kejujuran, Kooperatif, dan Keterbukaan</th>
                    </tr>
                    <?php
                    $sifat_options = [
                        "sangat terbuka, jujur dan cepat dalam menyampaikan data dan informasi pada saat wawancara",
                        "sangat terbuka, jujur namun agak lambat dalam menyampaikan data dan informasi pada saat wawancara",
                        "jujur dan cukup terbuka, namun masih ada kesan menyembunyikan sesuatu",
                        "sering menyembunyikan sesuatu dan sangat lambat dalam menyampaikan data dan informasi pada saat wawancara",
                        "tidak jujur, sering menyembunyikan sesuatu dan tidak kooperatif dalam menyampaikan data dan informasi pada saat wawancara"
                    ];
                    foreach ($sifat_options as $index => $label): ?>
                    <tr>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sifat" id="sifat<?php echo $index+1; ?>" value="<?php echo $index+1; ?>">
                                <label class="form-check-label" for="sifat<?php echo $index+1; ?>"><?php echo $label; ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- === 2. Informasi Debitur (IDEB) === -->
                    <tr class="table-light">
                        <th colspan="3">Informasi Debitur (IDeb)</th>
                    </tr>
                    <?php
                    $ideb_options = [
                        "memiliki kredit di bank lain atau lembaga non bank/BPR dan tidak terdapat tunggakan atau nihil",
                        "memiliki kredit, tunggakan lebih dari 10 hari tapi kurang dari 30 hari",
                        "tunggakan lebih dari 30 hari tapi kurang dari 60 hari / belum pernah memiliki pinjaman / pernah macet tapi lunas",
                        "tunggakan lebih dari 60 hari tapi kurang dari 90 hari",
                        "tunggakan lebih dari 90 hari dan belum lunas"
                    ];
                    foreach ($ideb_options as $index => $label): ?>
                    <tr>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ideb" id="ideb<?php echo $index+1; ?>" value="<?php echo $index+1; ?>">
                                <label class="form-check-label" for="ideb<?php echo $index+1; ?>"><?php echo $label; ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- === 3. Repayment Checking === -->
                    <tr class="table-light">
                        <th colspan="3">Repayment Checking</th>
                    </tr>
                    <?php
                    $repayment_options = [
                        "Tidak memiliki pinjaman atau tidak auto debet",
                        "Auto debet tidak melebihi 40% dari penghasilan tetap",
                        "Auto debet tidak melebihi 60%",
                        "Auto debet antara 60% - 80%",
                        "Auto debet melebihi 80%"
                    ];
                    foreach ($repayment_options as $index => $label): ?>
                    <tr>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="repayment" id="repayment<?php echo $index+1; ?>" value="<?php echo $index+1; ?>">
                                <label class="form-check-label" for="repayment<?php echo $index+1; ?>"><?php echo $label; ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- === 4. Perkara Hukum === -->
                    <tr class="table-light">
                        <th colspan="3">Perkara Hukum</th>
                    </tr>
                    <?php
                    $perkara_options = [
                        1 => "Tidak pernah terkait dengan masalah hukum",
                        3 => "Pernah menjalani kasus hukum dan dinyatakan bersalah",
                        5 => "Sedang menjalani kasus hukum dan dinyatakan bersalah"
                    ];
                    foreach ($perkara_options as $value => $label): ?>
                    <tr>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="perkara_hukum" id="perkara_hukum<?php echo $value; ?>" value="<?php echo $value; ?>">
                                <label class="form-check-label" for="perkara_hukum<?php echo $value; ?>"><?php echo $label; ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- === 5. Gaya Hidup === -->
                    <tr class="table-light">
                        <th colspan="3">Gaya Hidup</th>
                    </tr>
                    <?php
                    $gaya_hidup_options = [
                        1 => "Kesan positif, hidup sederhana, tidak berjudi, taat norma",
                        5 => "Kesan negatif, suka berfoya-foya, berjudi, melanggar norma"
                    ];
                    foreach ($gaya_hidup_options as $value => $label): ?>
                    <tr>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gaya_hidup" id="gaya_hidup<?php echo $value; ?>" value="<?php echo $value; ?>">
                                <label class="form-check-label" for="gaya_hidup<?php echo $value; ?>"><?php echo $label; ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <!-- === 6. Lama Kerja === -->
                    <tr class="table-light">
                        <th colspan="3">Lama Kerja</th>
                    </tr>
                    <?php
                    $lama_kerja_options = [
                        "Memiliki masa kerja > 10 tahun (swasta) atau > 5 tahun (ASN)",
                        "8 - 10 tahun (swasta) atau > 5 tahun (ASN PPPK)",
                        "5 - 8 tahun (swasta) atau 2 - 5 tahun (ASN PPPK)",
                        "3 - 5 tahun (swasta) atau < 2 tahun (ASN PPPK)",
                        "Kurang dari 3 tahun"
                    ];
                    foreach ($lama_kerja_options as $index => $label): ?>
                    <tr>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lama_kerja" id="lama_kerja<?php echo $index+1; ?>" value="<?php echo $index+1; ?>">
                                <label class="form-check-label" for="lama_kerja<?php echo $index+1; ?>"><?php echo $label; ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" onclick="return valid()" />
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<script>
function toggleFormKarakter() {
    const form = document.getElementById('formDataKarakter');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
}
</script>
