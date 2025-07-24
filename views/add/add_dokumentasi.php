<div id="formDokumentasi" class="p-3 border rounded mt-3" style="display: none; background-color: #f9f9f9;">
<h5 class="text-primary">➕ Skoring Legalitas dan Dokumentasi</h5>
<form method="POST" action="../proses/proses_add_dokumentasi.php">
<input type="hidden" name="id_riwayat" id="id_riwayat" value="<?php echo $_GET['id_riwayat']; ?>">
<input type="hidden" name="no_ktp" id="no_ktp" value="<?php echo $_GET['no_ktp']; ?>">
<div class="table-responsive">
<table class="table table-sm table-bordered">
    <tbody>

        <!-- Legalitas Permohonan -->
        <tr class="bg-light">
            <th colspan="3">Legalitas Permohonan</th>
        </tr>
        <tr>
            <td colspan="3">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="legal_pemohon" id="legal_pemohon1" value="2">
                    <label class="form-check-label" for="legal_pemohon1">
                        1. Formulir permohonan kredit telah diisi lengkap dan ditandatangani oleh calon debitur<br>
                        2. Surat persetujuan suami/istri telah diisi lengkap dan ditandatangani oleh suami/istri<br>
                        3. Surat rekomendasi dari atasan telah diisi lengkap, ditandatangani oleh atasan dan dicap (bagi perusahaan MoU dengan BPR)<br>
                        4. Surat kuasa penarikan tabungan (gaji) telah diisi lengkap dan ditandatangani oleh calon debitur
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="legal_pemohon" id="legal_pemohon2" value="3">
                    <label class="form-check-label" for="legal_pemohon2">
                        1. Formulir permohonan kredit tidak diisi lengkap tetapi ditandatangani oleh calon debitur<br>
                        2. Surat persetujuan suami/istri tidak diisi lengkap tetapi ditandatangani oleh suami/istri<br>
                        3. Surat rekomendasi dari atasan tidak diisi lengkap tetapi ditandatangani dan dicap (bagi perusahaan MoU dengan BPR)<br>
                        4. Surat kuasa penarikan tabungan (gaji) telah diisi lengkap dan ditandatangani
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="legal_pemohon" id="legal_pemohon3" value="4">
                    <label class="form-check-label" for="legal_pemohon3">
                        1. Surat persetujuan suami/istri diisi lengkap tetapi tidak ditandatangani<br>
                        2. Surat kuasa penarikan tabungan (gaji) diisi lengkap tetapi tidak ditandatangani oleh calon debitur<br>
                        3. Surat rekomendasi dari atasan diisi lengkap dan ditandatangani serta dicap oleh perusahaan yang tidak MoU dengan BPR
                    </label>
                </div>
            </td>
        </tr>

        <!-- Legalitas Identitas Debitur -->
        <tr class="bg-light">
            <th colspan="3">Legalitas Identitas Debitur</th>
        </tr>
        <tr>
            <td colspan="3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="legal_ideb" id="legal_ideb1" value="1">
                    <label class="form-check-label" for="legal_ideb1">
                        Calon debitur tidak tercatat dalam daftar pencarian orang (DPO) dan tidak masuk dalam DTTOT
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="legal_ideb" id="legal_ideb2" value="5">
                    <label class="form-check-label" for="legal_ideb2">
                        Calon debitur tercatat dalam DPO dan masuk dalam DTTOT
                    </label>
                </div>
            </td>
        </tr>

        <!-- Kelengkapan Persyaratan -->
        <tr class="bg-light">
            <th colspan="3">Kelengkapan Persyaratan</th>
        </tr>
        <tr>
            <td colspan="3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="kelengkapan_syarat" id="kelengkapan_syarat1" value="2">
                    <label class="form-check-label" for="kelengkapan_syarat1">
                        Calon debitur telah menyerahkan seluruh persyaratan dengan lengkap
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="kelengkapan_syarat" id="kelengkapan_syarat2" value="3">
                    <label class="form-check-label" for="kelengkapan_syarat2">
                        Calon debitur belum sepenuhnya menyerahkan seluruh persyaratan
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelengkapan_syarat" id="kelengkapan_syarat3" value="4">
                    <label class="form-check-label" for="kelengkapan_syarat3">
                        Calon debitur belum menyerahkan sebagian besar persyaratan
                    </label>
                </div>
            </td>
        </tr>

        <!-- Kelengkapan Legal Opinion -->
        <tr class="bg-light">
            <th colspan="3">Kelengkapan Legal Opinion</th>
        </tr>
        <tr>
            <td colspan="3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="kelengkapan_legal" id="kelengkapan_legal1" value="2">
                    <label class="form-check-label" for="kelengkapan_legal1">
                        Calon debitur telah memenuhi seluruh aspek legal dan sangat layak menjadi subyek hukum untuk perjanjian dan pengikatan agunan (jika ada)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelengkapan_legal" id="kelengkapan_legal2" value="4">
                    <label class="form-check-label" for="kelengkapan_legal2">
                        Calon debitur tidak memenuhi aspek legal dan tidak layak menjadi subyek hukum untuk perjanjian dan pengikatan agunan (jika ada)
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
function toggleFormDokumentasi() {
    const form = document.getElementById('formDokumentasi');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>