<div id="formDataAgunan" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
    <h5 class="text-primary">➕ Skoring Collateral</h5>
    <form method="POST" action="../proses/proses_add_agunan.php">
<input type="hidden" name="id_riwayat" id="id_riwayat" value="<?php echo $_GET['id_riwayat']; ?>">
<input type="hidden" name="no_ktp" id="no_ktp" value="<?php echo $_GET['no_ktp']; ?>">
<div class="table-responsive">
<div class="table-responsive">
    <table class="table table-sm table-borderless">
        <tbody>

            <!-- MOU / Corporate Guarantee -->
            <tr>
                <th width="300px">MOU / Corporate Guarantee</th>
                <td>:</td>
                <td>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="mou" id="mou1" value="2" required>
                        <label class="form-check-label" for="mou1">
                            Ada kerjasama antara BPR dan perusahaan/instansi tempat debitur bekerja
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="mou" id="mou2" value="3">
                        <label class="form-check-label" for="mou2">
                            Ada kerjasama antara BPR dan HRD/bendahara tempat debitur bekerja
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="mou" id="mou3" value="4">
                        <label class="form-check-label" for="mou3">
                            Tidak ada kerjasama, tapi ada rekomendasi dari HRD
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mou" id="mou4" value="5">
                        <label class="form-check-label" for="mou4">
                            Tidak ada kerjasama maupun rekomendasi dari HRD
                        </label>
                    </div>
                </td>
            </tr>

            <!-- SK -->
            <tr>
                <th>SK</th>
                <td>:</td>
                <td>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sk" id="sk1" value="1" required>
                        <label class="form-check-label" for="sk1">
                            SK asli pengangkatan 80% dan 100%
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sk" id="sk2" value="2">
                        <label class="form-check-label" for="sk2">
                            Surat pengangkatan karyawan tetap (swasta) atau surat perjanjian kerja (PPPK)
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sk" id="sk3" value="3">
                        <label class="form-check-label" for="sk3">
                            1. SK Kepangkatan/Berkala (PNS) <br>
                            2. Surat perjanjian kerja (swasta) <br>
                            3. Surat Keterangan Kerja (swasta)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sk" id="sk4" value="4">
                        <label class="form-check-label" for="sk4">
                            Dokumen berupa fotokopi legalisir (SK / Perjanjian Kerja / Keterangan Kerja)
                        </label>
                    </div>
                </td>
            </tr>

            <!-- Tambahan Agunan -->
            <tr>
                <th>Tambahan Agunan</th>
                <td>:</td>
                <td>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tambahan_agunan" id="agunan1" value="1" required>
                        <label class="form-check-label" for="agunan1">
                            Agunan milik sendiri, bisa mengcover plafon kredit, berupa tabungan/deposito
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tambahan_agunan" id="agunan2" value="2">
                        <label class="form-check-label" for="agunan2">
                            1. Agunan keluarga + surat kuasa, cover plafon, marketable & terikat<br>
                            2. Agunan orang lain + surat kuasa, cover plafon, marketable & diikat HT
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tambahan_agunan" id="agunan3" value="3">
                        <label class="form-check-label" for="agunan3">
                            Agunan orang lain, cover plafon, marketable, namun tidak diikat
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="tambahan_agunan" id="agunan4" value="4">
                        <label class="form-check-label" for="agunan4">
                            Agunan sendiri, tidak cover plafon, marketable & dapat diikat
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tambahan_agunan" id="agunan5" value="5">
                        <label class="form-check-label" for="agunan5">
                            Agunan sendiri, tidak cover plafon, marketable tapi tidak dapat diikat
                        </label>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>

</div>
<div class="col-md-12">
        <div class="form-group text-center">
        <input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" onClick="return valid()"/>
            <button type="reset" name="reset" id="reset" class="btn btn-secondary">Reset</button>
        </div>
    </div>
</form>
</div>
<script>
function toggleFormAgunan() {
    const form = document.getElementById('formDataAgunan');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>