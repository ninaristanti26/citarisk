<div id="formKondisiEkonomi" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
<h5 class="text-primary">➕ Skoring Kondisi Ekonomi</h5>
<form method="POST" action="../proses/proses_add_kondisi_ekonomi.php">
<input type="hidden" name="id_riwayat" id="id_riwayat" value="<?php echo $_GET['id_riwayat']; ?>">
<input type="hidden" name="no_ktp" id="no_ktp" value="<?php echo $_GET['no_ktp']; ?>">
<div class="table-responsive">
<table class="table table-sm table-bordered">
    <tbody>
        <!-- Pengaruh Eksternal Terhadap Kondisi Perusahaan -->
        <tr class="bg-light">
            <th colspan="3">Pengaruh Eksternal Terhadap Kondisi Perusahaan</th>
        </tr>
        <tr>
            <td colspan="3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="pengaruh_eksternal" id="pengaruh_eksternal1" value="2">
                    <label class="form-check-label" for="pengaruh_eksternal1">
                        Bekerja di instansi pemerintahan/bekerja di perusahaan yang tidak terpengaruh oleh kebijakan pemerintah atau situasi eksternal
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="pengaruh_eksternal" id="pengaruh_eksternal2" value="3">
                    <label class="form-check-label" for="pengaruh_eksternal2">
                        Bekerja di instansi pemerintahan dengan status pegawai kontrak atau honor/bekerja di perusahaan yang memiliki resistensi rendah terhadap kebijakan pemerintah atau situasi eksternal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pengaruh_eksternal" id="pengaruh_eksternal3" value="4">
                    <label class="form-check-label" for="pengaruh_eksternal3">
                        Bekerja di perusahaan yang memiliki resistensi tinggi terhadap kebijakan pemerintah atau situasi eksternal
                    </label>
                </div>
            </td>
        </tr>

        <!-- Lama Perusahaan Beroperasi -->
        <tr class="bg-light">
            <th colspan="3">Lama Perusahaan Beroperasi</th>
        </tr>
        <tr>
            <td colspan="3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="lama_operasi" id="lama_operasi1" value="2">
                    <label class="form-check-label" for="lama_operasi1">
                        Perusahaan telah beroperasi lebih dari 10 tahun
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="lama_operasi" id="lama_operasi2" value="3">
                    <label class="form-check-label" for="lama_operasi2">
                        Perusahaan telah beroperasi lebih dari 7 tahun dan tidak lebih dari 10 tahun
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="lama_operasi" id="lama_operasi3" value="4">
                    <label class="form-check-label" for="lama_operasi3">
                        Perusahaan telah beroperasi kurang dari 7 tahun
                    </label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

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
function toggleFormKondisiEkonomi() {
    const form = document.getElementById('formKondisiEkonomi');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>