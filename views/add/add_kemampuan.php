<div id="formDataKemampuan" class="p-4 border rounded mt-3 bg-light" style="display: none;">
    <h5 class="text-primary mb-4">➕ Skoring Repayment Capacity</h5>
    <form method="POST" action="../proses/proses_add_kemampuan.php" onsubmit="return validateForm();">
        <input type="hidden" name="id_riwayat" value="<?php echo $_GET['id_riwayat'] ?? ''; ?>">
        <input type="hidden" name="no_ktp" value="<?php echo $_GET['no_ktp'] ?? ''; ?>">

        <div class="table-responsive">
            <table class="table table-sm table-borderless">
                <tbody>
                    <!-- Pengendalian Pembayaran -->
                    <tr>
                        <th width="300px">Pengendalian Pembayaran</th>
                        <td>:</td>
                        <td>
                            <?php
                            $optionsPembayaran = [
                                "1" => "Autodebet dari rekening tabungan di BPR.",
                                "2" => "Autodebet/SI/Banpot dari rekening tabungan di bank lain.",
                                "3" => "Pemotongan gaji / kuasa pendebetan / penyerahan ATM & PIN.",
                                "4" => "Pembayaran dilakukan sendiri ke BPR."
                            ];
                            foreach ($optionsPembayaran as $value => $label) {
                                echo '
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="pengendalian_pembayaran" value="' . $value . '" id="pengendalian' . $value . '" required>
                                    <label class="form-check-label" for="pengendalian' . $value . '">' . $label . '</label>
                                </div>';
                            }
                            ?>
                        </td>
                    </tr>

                    <!-- Kualitas Angsuran -->
                    <tr>
                        <th>Kualitas Angsuran</th>
                        <td>:</td>
                        <td>
                            <?php
                            $optionsKualitas = [
                                "1" => "100% dari penghasilan tetap.",
                                "2" => "70% dari penghasilan tetap.",
                                "3" => "Kombinasi tetap & variabel, variabel tidak melebihi 60%.",
                                "4" => "Kombinasi tetap & variabel, variabel melebihi 60%.",
                                "5" => "100% dari penghasilan variabel."
                            ];
                            foreach ($optionsKualitas as $value => $label) {
                                echo '
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="kualitas_angsuran" value="' . $value . '" id="kualitas' . $value . '" required>
                                    <label class="form-check-label" for="kualitas' . $value . '">' . $label . '</label>
                                </div>';
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" name="Submit" value="Submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<script>
function toggleFormKemampuan() {
    const form = document.getElementById('formDataKemampuan');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function validateForm() {
    const pengendalian = document.querySelector('input[name="pengendalian_pembayaran"]:checked');
    const kualitas = document.querySelector('input[name="kualitas_angsuran"]:checked');

    if (!pengendalian || !kualitas) {
        alert("Silakan pilih semua opsi skoring sebelum submit.");
        return false;
    }
    return true;
}
</script>
