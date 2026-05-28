<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

        <!-- OVERLAY SAAT VIEW -->
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">PENGKAJIAN AWAL MEDIS MATA</h2>
          <p class="text-muted" style="font-size:13px;">(Diisi oleh Dokter dalam waktu 24 jam sejak pertama pasien masuk rumah sakit)</p>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        </div>

        <!-- Tanggal & Jam -->
        <div class="box-rme mb-4">
          <div class="form-row-2">
            <div>
              <label>Tanggal :</label>
              <input type="date" v-model="form.tanggal" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Jam :</label>
              <input type="time" v-model="form.jam" class="input-rme" :disabled="disabledSubmit" /> WIB
            </div>
          </div>
        </div>

        <!-- INFO PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="form-row-2">
            <div><label>Nama :</label><input type="text" v-model="form.nama" class="input-rme" readonly /></div>
            <div><label>No. RM :</label><input type="text" v-model="form.no_rm" class="input-rme" readonly /></div>
          </div>
          <div class="form-row-2 mt-2">
            <div><label>NIK :</label><input type="text" v-model="form.nik" class="input-rme" readonly /></div>
            <div><label>Tgl. Lahir :</label><input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly /></div>
          </div>
          <div class="form-row-2 mt-2">
            <div><label>Jenis Kelamin :</label><input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly /></div>
          </div>
        </div>

        <!-- ALERGI -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Alergi</h5>
          <input type="text" v-model="form.alergi" class="input-rme" placeholder="Tuliskan alergi pasien..." :disabled="disabledSubmit" />
        </div>

        <!-- SUMBER DATA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Sumber Data</h5>
          <div style="display:flex; flex-wrap:wrap; gap:16px; align-items:center;">
            <label class="checkbox-label"><input type="checkbox" v-model="form.sumber_pasien" :disabled="disabledSubmit" /> Pasien</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.sumber_keluarga" :disabled="disabledSubmit" /> Keluarga</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.sumber_teman" :disabled="disabledSubmit" /> Teman</label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.sumber_lainnya" :disabled="disabledSubmit" /> Lainnya :
              <input type="text" v-model="form.sumber_lainnya_text" class="line-input" style="width:140px;" :disabled="disabledSubmit" />
            </label>
          </div>
        </div>

        <!-- PENILAIAN NYERI (VAS) -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Penilaian Nyeri (VAS)</h5>
          <div style="display:flex; gap:20px; align-items:stretch; flex-wrap:wrap;">
            <!-- Skala VAS -->
            <div style="flex:0 0 520px; border:2px solid #333; padding:14px; text-align:center;">
              <img src="/storage/images/vas.png" alt="VAS Scale" style="width:100%; max-width:500px;" />
              <div style="display:flex; justify-content:space-between; margin-top:10px;">
                <label v-for="n in 11" :key="n-1" style="display:flex; flex-direction:column; align-items:center; font-size:13px;">
                  <input type="radio" v-model="form.skala_nyeri" :value="String(n-1)" :disabled="disabledSubmit" />
                  <span>{{ n-1 }}</span>
                </label>
              </div>
              <div style="display:flex; justify-content:space-between; font-size:11px; margin-top:6px;">
                <span>Tidak</span><span>Ringan</span><span>Sedang</span><span>Berat</span>
              </div>
            </div>
            <!-- Detail Nyeri -->
            <div style="flex:1; border:2px solid #333; padding:12px; min-width:180px;">
              <div style="display:flex; gap:20px; margin-bottom:10px;">
                <label for="">Nyeri :</label>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.nyeri_ada" value="tidak" :disabled="disabledSubmit" /> Tidak
                </label>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.nyeri_ada" value="ya" :disabled="disabledSubmit" /> Ya
                </label>
              </div>
              <div class="mt-2">
                <label>Skala Nyeri : <input type="text" v-model="form.skala_nyeri_text" class="input-rme" style="width:60px; display:inline-block;" :disabled="disabledSubmit" />&nbsp;(Intensitas 0 – 10)</label> 
                &nbsp;&nbsp;
                <label>Karakteristik : <input type="text" v-model="form.nyeri_karakteristik" class="input-rme" style="width:120px; display:inline-block;" :disabled="disabledSubmit" /></label>
                
              </div>
              <div class="mt-2">
                <label>Lokasi : <input type="text" v-model="form.nyeri_lokasi" class="input-rme" style="width:140px; display:inline-block;" :disabled="disabledSubmit" /></label>
                &nbsp;&nbsp;
                <label>Durasi : <input type="text" v-model="form.nyeri_durasi" class="input-rme" style="width:120px; display:inline-block;" :disabled="disabledSubmit" /></label>
              </div>
              <div class="mt-2">
                <label>Frekuensi : <input type="text" v-model="form.nyeri_frekuensi" class="input-rme" style="width:80px; display:inline-block;" :disabled="disabledSubmit" /> x/hari (crescendo/decrescendo)</label>
              </div>
            </div>
          </div>
        </div>

        <!-- ANAMNESA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Anamnesa</h5>
          <div class="mb-3">
            <label class="fw-semibold">Keluhan Utama :</label>
            <textarea v-model="form.keluhan_utama" class="input-rme" rows="2" :disabled="disabledSubmit"></textarea>
          </div>
          <div class="mb-3">
            <label class="fw-semibold">Riwayat Penyakit Sekarang :</label>
            <textarea v-model="form.riwayat_penyakit_sekarang" class="input-rme" rows="2" :disabled="disabledSubmit"></textarea>
          </div>
          <div class="mb-3">
            <label class="fw-semibold">Riwayat Penyakit Dahulu dan Riwayat Pengobatan :</label>
            <div class="form-row-2 mt-1">
              <div>
                <label>Riwayat Penyakit Dahulu :</label>
                <textarea v-model="form.riwayat_penyakit_dahulu" class="input-rme" rows="2" :disabled="disabledSubmit"></textarea>
              </div>
              <div>
                <label>Riwayat Pengobatan :</label>
                <textarea v-model="form.riwayat_pengobatan" class="input-rme" rows="2" :disabled="disabledSubmit"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- RIWAYAT PENYAKIT KELUARGA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Riwayat Penyakit Keluarga</h5>
          <div style="display:flex; flex-wrap:wrap; gap:10px 20px;">
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_hipertensi" :disabled="disabledSubmit" /> Hipertensi</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_diabetes" :disabled="disabledSubmit" /> Diabetes</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_jantung" :disabled="disabledSubmit" /> Jantung</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_stroke" :disabled="disabledSubmit" /> Stroke</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_dialysis" :disabled="disabledSubmit" /> Dialysis</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_asthma" :disabled="disabledSubmit" /> Asthma</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_kejang" :disabled="disabledSubmit" /> Kejang</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_liver" :disabled="disabledSubmit" /> Liver</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_cancer" :disabled="disabledSubmit" /> Cancer</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_tbc" :disabled="disabledSubmit" /> TBC</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_glaukoma" :disabled="disabledSubmit" /> Glaukoma</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_std" :disabled="disabledSubmit" /> STD</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.rpk_perdarahan" :disabled="disabledSubmit" /> Perdarahan</label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.rpk_lain_lain" :disabled="disabledSubmit" /> Lain-lain :
              <input type="text" v-model="form.rpk_lain_lain_text" class="line-input" style="width:160px;" :disabled="disabledSubmit" />
            </label>
          </div>
        </div>

        <!-- RIWAYAT OPERASI & TRANSFUSI -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Riwayat Operasi & Transfusi</h5>
          <div class="form-row-inline mb-2">
            <span class="row-label">Riwayat Operasi :</span>
            <label class="checkbox-item"><input type="radio" v-model="form.riwayat_operasi" value="Tidak" :disabled="disabledSubmit" /> Tidak</label>
            <label class="checkbox-item"><input type="radio" v-model="form.riwayat_operasi" value="Ya" :disabled="disabledSubmit" /> Ya</label>
            <span style="margin-left:8px;">Jenis &amp; Kapan :</span>
            <input type="text" v-model="form.riwayat_operasi_keterangan" class="line-input" style="flex:1;" :disabled="disabledSubmit" />
          </div>
          <div class="form-row-inline mb-2">
            <span class="row-label">Riwayat Transfusi :</span>
            <label class="checkbox-item"><input type="radio" v-model="form.riwayat_transfusi" value="Tidak" :disabled="disabledSubmit" /> Tidak</label>
            <label class="checkbox-item"><input type="radio" v-model="form.riwayat_transfusi" value="Ya" :disabled="disabledSubmit" /> Ya</label>
            <span style="margin-left:8px;">Reaksi Transfusi :</span>
            <label class="checkbox-item"><input type="radio" v-model="form.reaksi_transfusi" value="Tidak" :disabled="disabledSubmit" /> Tidak</label>
            <label class="checkbox-item"><input type="radio" v-model="form.reaksi_transfusi" value="Ya" :disabled="disabledSubmit" /> Ya</label>
            <input type="text" v-model="form.reaksi_transfusi_text" class="line-input" style="flex:1;" placeholder="Reaksi yang timbul..." :disabled="disabledSubmit" />
          </div>
        </div>

        <!-- KEBIASAAN SOSIAL -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Riwayat Pekerjaan, Sosial, Ekonomi, Psikologi dan Kebiasaan</h5>
          <textarea v-model="form.riwayat_sosial" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
        </div>

        <!-- TANDA-TANDA VITAL -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda-Tanda Vital</h5>
          <div style="display:flex; flex-wrap:wrap; gap:10px 20px; margin-bottom:10px; align-items:center;">
            <span>Keadaan Umum :</span>
            <label class="checkbox-label"><input type="radio" v-model="form.keadaan_umum" value="Baik" :disabled="disabledSubmit" /> Baik</label>
            <label class="checkbox-label"><input type="radio" v-model="form.keadaan_umum" value="Sedang" :disabled="disabledSubmit" /> Sedang</label>
            <label class="checkbox-label"><input type="radio" v-model="form.keadaan_umum" value="Lemah" :disabled="disabledSubmit" /> Lemah</label>
            <label class="checkbox-label"><input type="radio" v-model="form.keadaan_umum" value="Jelek" :disabled="disabledSubmit" /> Jelek</label>
            &nbsp;&nbsp;
            <span>Gizi :</span>
            <label class="checkbox-label"><input type="radio" v-model="form.gizi" value="Baik" :disabled="disabledSubmit" /> Baik</label>
            <label class="checkbox-label"><input type="radio" v-model="form.gizi" value="Sedang" :disabled="disabledSubmit" /> Sedang</label>
            <label class="checkbox-label"><input type="radio" v-model="form.gizi" value="Kurang" :disabled="disabledSubmit" /> Kurang</label>
            <label class="checkbox-label"><input type="radio" v-model="form.gizi" value="Buruk" :disabled="disabledSubmit" /> Buruk</label>
          </div>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0;">GCS E : <input type="text" v-model="form.gcs_e" class="input-rme" style="width:55px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0;">M : <input type="text" v-model="form.gcs_m" class="input-rme" style="width:55px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0;">V : <input type="text" v-model="form.gcs_v" class="input-rme" style="width:55px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0;">BB : <input type="number" v-model="form.bb" class="input-rme" style="width:70px;display:inline-block;" :disabled="disabledSubmit" min="0" /> kg</label>
            <span style="display:flex; align-items:center; gap:10px; margin:0;">
              <span>Tindakan Resusitasi :</span>
              <label class="checkbox-label" style="margin:0;"><input type="radio" v-model="form.tindakan_resusitasi" value="Ya" :disabled="disabledSubmit" /> Ya</label>
              <label class="checkbox-label" style="margin:0;"><input type="radio" v-model="form.tindakan_resusitasi" value="Tidak" :disabled="disabledSubmit" /> Tidak</label>
            </span>
          </div>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0;">Tensi : <input type="text" v-model="form.tensi" class="input-rme" style="width:100px;display:inline-block;" :disabled="disabledSubmit" /> mmHg</label>
            <label style="margin:0;">Suhu : <input type="number" step="0.1" v-model="form.suhu_ttv" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" min="0" /> °C</label>
            <label style="margin:0;">Nadi : <input type="number" v-model="form.nadi_ttv" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" min="0" /> x/mnt</label>
            <label style="margin:0;">Respirasi : <input type="number" v-model="form.respirasi" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" min="0" /> x/mnt</label>
          </div>
          <div style="display:flex; gap:20px; flex-wrap:wrap; align-items:center;">
            <label>Saturasi O₂ : <input type="number" v-model="form.saturasi_o2" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" min="0" max="100" /> %</label>
            <span>pada</span>
            <label class="checkbox-label"><input type="radio" v-model="form.oksigen_jenis" value="suhu_ruangan" :disabled="disabledSubmit" /> Suhu ruangan</label>
            <label class="checkbox-label"><input type="radio" v-model="form.oksigen_jenis" value="nasal_canule" :disabled="disabledSubmit" /> Nasal canule</label>
            <label class="checkbox-label"><input type="radio" v-model="form.oksigen_jenis" value="nrb" :disabled="disabledSubmit" /> NRB</label>
            <label class="checkbox-label">
              <input type="radio" v-model="form.oksigen_jenis" value="lainnya" :disabled="disabledSubmit" /> Lainnya :
              <input type="text" v-model="form.oksigen_lainnya_text" class="line-input" style="width:100px;" :disabled="disabledSubmit" />
            </label>
          </div>
        </div>

        <!-- PEMERIKSAAN FISIK -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pemeriksaan Fisik</h5>

          <!-- Keadaan Umum & Kesadaran -->
          <div style="display:flex; flex-wrap:wrap; gap:10px 20px; margin-bottom:10px; align-items:center;">
            <span>Keadaan Umum :</span>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_ku_baik" :disabled="disabledSubmit" /> Baik</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_ku_sedang" :disabled="disabledSubmit" /> Sedang</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_ku_lemah" :disabled="disabledSubmit" /> Lemah</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_ku_buruk" :disabled="disabledSubmit" /> Buruk</label>
          </div>
          <div style="display:flex; flex-wrap:wrap; gap:10px 20px; margin-bottom:10px; align-items:center;">
            <span>Kesadaran :</span>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_kes_cm" :disabled="disabledSubmit" /> CM</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_kes_somnolen" :disabled="disabledSubmit" /> Somnolen</label>
            <label class="checkbox-label"><input type="checkbox" v-model="form.pf_kes_koma" :disabled="disabledSubmit" /> Koma</label>
          </div>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0;">GCS E : <input type="text" v-model="form.pf_gcs_e" class="input-rme" style="width:60px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0;">V : <input type="text" v-model="form.pf_gcs_v" class="input-rme" style="width:60px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0;">M : <input type="text" v-model="form.pf_gcs_m" class="input-rme" style="width:60px;display:inline-block;" :disabled="disabledSubmit" /></label>
          </div>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0;">Tekanan Darah : <input type="text" v-model="form.tekanan_darah" class="input-rme" style="width:100px;display:inline-block;" :disabled="disabledSubmit" /> mmHg</label>
            <label style="margin:0;">RR : <input type="text" v-model="form.rr" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" /> x/menit</label>
          </div>
          <div class="form-row-inline mb-2" style="align-items:center;">
            <span style="display:flex; align-items:center; gap:8px; flex-shrink:0; white-space:nowrap;">
              <label style="margin:0; white-space:nowrap;">Nadi : <input type="text" v-model="form.nadi_pf" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" /> x/menit</label>
              <label class="checkbox-label" style="margin:0; white-space:nowrap;"><input type="radio" v-model="form.nadi_regularitas" value="regular" :disabled="disabledSubmit" /> Regular</label>
              <label class="checkbox-label" style="margin:0; white-space:nowrap;"><input type="radio" v-model="form.nadi_regularitas" value="irregular" :disabled="disabledSubmit" /> Irregular</label>
            </span>
          </div>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0; white-space:nowrap;">SpO₂ : <input type="text" v-model="form.spo2" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" /> %</label>
            <label style="margin:0; white-space:nowrap;">Reflex Cahaya : <input type="text" v-model="form.reflex_cahaya" class="input-rme" style="width:100px;display:inline-block;" :disabled="disabledSubmit" /></label>
          </div>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0; white-space:nowrap;">Akral : <input type="text" v-model="form.akral" class="input-rme" style="width:100px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0; white-space:nowrap;">Temp : <input type="number" step="0.1" v-model="form.temp" class="input-rme" style="width:80px;display:inline-block;" :disabled="disabledSubmit" /> °C</label>
          </div>
          <div class="mb-2"><label>Kepala :</label><input type="text" v-model="form.kepala" class="input-rme" :disabled="disabledSubmit" /></div>
          <div class="mb-2"><label>Leher :</label><input type="text" v-model="form.leher" class="input-rme" :disabled="disabledSubmit" /></div>
          <br>
          <div class="mb-2">
            <label class="fw-semibold">Jantung :</label>
            <div class="form-row-2 mt-1">
              <div><label>Inspeksi :</label><input type="text" v-model="form.jantung_inspeksi" class="input-rme" :disabled="disabledSubmit" /></div>
              <div><label>Palpasi :</label><input type="text" v-model="form.jantung_palpasi" class="input-rme" :disabled="disabledSubmit" /></div>
            </div>
            <div class="form-row-2 mt-1">
              <div><label>Perkusi :</label><input type="text" v-model="form.jantung_perkusi" class="input-rme" :disabled="disabledSubmit" /></div>
              <div><label>Auskultasi :</label><input type="text" v-model="form.jantung_auskultasi" class="input-rme" :disabled="disabledSubmit" /></div>
            </div>
          </div>
        </div>

        <!-- PEMERIKSAAN MATA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pemeriksaan Mata</h5>
          <table class="table-rme-mata">
            <thead>
              <tr>
                <th style="width:40%;">Pemeriksaan</th>
                <th style="width:30%;">OD (Kanan)</th>
                <th style="width:30%;">OS (Kiri)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Visus</td>
                <td><input type="text" v-model="form.mata_visus_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_visus_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Pergerakan Bola Mata</td>
                <td><input type="text" v-model="form.mata_pgbm_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_pgbm_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Palpebra Superior</td>
                <td><input type="text" v-model="form.mata_palpebra_sup_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_palpebra_sup_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Palpebra Inferior</td>
                <td><input type="text" v-model="form.mata_palpebra_inf_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_palpebra_inf_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Kornea</td>
                <td><input type="text" v-model="form.mata_kornea_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_kornea_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Iris</td>
                <td><input type="text" v-model="form.mata_iris_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_iris_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Konjungtiva Bulbi</td>
                <td><input type="text" v-model="form.mata_konjungtiva_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_konjungtiva_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Sekret</td>
                <td><input type="text" v-model="form.mata_sekret_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_sekret_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Tekanan Bola Mata</td>
                <td><input type="text" v-model="form.mata_tio_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_tio_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Pupil — Refleks</td>
                <td><input type="text" v-model="form.mata_pupil_reflek_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_pupil_reflek_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Pupil — Ukuran</td>
                <td><input type="text" v-model="form.mata_pupil_ukuran_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_pupil_ukuran_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
              <tr>
                <td>Pupil — Isokor</td>
                <td><input type="text" v-model="form.mata_pupil_isokor_od" class="input-rme" :disabled="disabledSubmit" /></td>
                <td><input type="text" v-model="form.mata_pupil_isokor_os" class="input-rme" :disabled="disabledSubmit" /></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- STATUS LOKALIS & PENUNJANG -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Status Lokalis / Skema</h5>
          <textarea v-model="form.status_lokalis" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
        </div>

        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pemeriksaan Penunjang (Laboratorium, EKG, X-Ray, Lain-lain)</h5>
          <textarea v-model="form.pemeriksaan_penunjang" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
        </div>

        <!-- DIAGNOSA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Diagnosa</h5>
          <div class="mb-2"><label class="fw-semibold">Diagnosa Kerja :</label><textarea v-model="form.diagnosa_kerja" class="input-rme" rows="2" :disabled="disabledSubmit"></textarea></div>
          <div class="mb-2"><label class="fw-semibold">Diagnosa Diferensial :</label><textarea v-model="form.diagnosa_diferensial" class="input-rme" rows="2" :disabled="disabledSubmit"></textarea></div>
        </div>

        <!-- TERAPI & RENCANA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Terapi</h5>
          <textarea v-model="form.terapi" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
        </div>

        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Rencana Kerja</h5>
          <textarea v-model="form.rencana_kerja" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
        </div>

        <!-- HASIL PEMBEDAHAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Hasil Pembedahan</h5>
          <textarea v-model="form.hasil_pembedahan" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
        </div>

        <!-- DISPOSISI -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Disposisi</h5>
          <!-- Boleh Pulang -->
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:16px; align-items:center;">
            <label class="checkbox-label" style="margin:0; white-space:nowrap;">
              <input type="checkbox" v-model="form.cb_boleh_pulang" :disabled="disabledSubmit" />
              Boleh pulang jam keluar :
            </label>
            <input type="time" v-model="form.disposisi_pulang_jam" class="input-rme" style="width:130px;display:inline-block;" :disabled="disabledSubmit" />
            WIB
            <label style="margin:0; white-space:nowrap;">Tanggal : <input type="date" v-model="form.disposisi_pulang_tanggal" class="input-rme" style="width:150px;display:inline-block;" :disabled="disabledSubmit" /></label>
          </div>

          <!-- Kontrol Poliklinik -->
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:16px; align-items:center;">
            <label class="checkbox-label" style="margin:0; white-space:nowrap;">
              <input type="checkbox" v-model="form.cb_kontrol_poliklinik" :disabled="disabledSubmit" />
              Kontrol Poliklinik :
            </label>
            <label class="checkbox-item"><input type="radio" v-model="form.kontrol_poliklinik" value="Tidak" :disabled="disabledSubmit" /> Tidak</label>
            <label class="checkbox-item"><input type="radio" v-model="form.kontrol_poliklinik" value="Ya" :disabled="disabledSubmit" /> Ya</label>
            <input type="text" v-model="form.kontrol_tujuan" class="line-input" style="flex:1; min-width:120px;" placeholder="Tujuan kontrol..." :disabled="disabledSubmit" />
            <label style="white-space:nowrap; margin:0;">Tanggal : <input type="date" v-model="form.kontrol_tanggal" class="input-rme" style="width:150px;display:inline-block;" :disabled="disabledSubmit" /></label>
          </div>

          <!-- Dirawat di Ruangan & Kelas -->
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:16px; align-items:center;">
            <label class="checkbox-label" style="margin:0; white-space:nowrap;">
              <input type="checkbox" v-model="form.cb_dirawat_ruangan" :disabled="disabledSubmit" />
              Dirawat di Ruangan :
            </label>
            <input type="text" v-model="form.dirawat_ruangan" class="input-rme" style="width:160px;display:inline-block;" :disabled="disabledSubmit" />
            <label class="checkbox-label" style="margin:0; white-space:nowrap;">
              <input type="checkbox" v-model="form.cb_dirawat_kelas" :disabled="disabledSubmit" />
              Kelas :
            </label>
            <input type="text" v-model="form.dirawat_kelas" class="input-rme" style="width:120px;display:inline-block;" :disabled="disabledSubmit" />
          </div>
        </div>

        <!-- REKOMENDASI & CATATAN -->
        <div class="form-row-2 mb-4">
          <div class="box-rme">
            <h5 class="section-title-rme">Rekomendasi / Saran</h5>
            <textarea v-model="form.rekomendasi" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
          </div>
          <div class="box-rme">
            <h5 class="section-title-rme">Catatan Penting</h5>
            <textarea v-model="form.catatan_penting" class="input-rme" rows="3" :disabled="disabledSubmit"></textarea>
          </div>
        </div>

        <!-- TANDA TANGAN DPJP -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan DPJP</h5>
          <div class="form-row-inline mb-2" style="flex-wrap:wrap; gap:24px; align-items:center;">
            <label style="margin:0; white-space:nowrap;">Kota : <input type="text" v-model="form.kota_ttd" class="input-rme" style="width:140px;display:inline-block;" :disabled="disabledSubmit" placeholder="Medan" /></label>
            <label style="margin:0; white-space:nowrap;">Tanggal : <input type="date" v-model="form.tanggal_ttd" class="input-rme" style="width:160px;display:inline-block;" :disabled="disabledSubmit" /></label>
            <label style="margin:0; white-space:nowrap;">Jam : <input type="time" v-model="form.jam_ttd" class="input-rme" style="width:120px;display:inline-block;" :disabled="disabledSubmit" />&nbsp;WIB</label> 
          </div>

          <!-- Tanda Tangan -->
          <div class="mt-3 text-center" style="max-width:350px; margin:0 auto;">
            <div v-if="form.ttd_dpjp && !ttdDpjpCleared" class="signature-preview text-center">
              <img :src="form.ttd_dpjp" alt="TTD DPJP" class="img-signature" />
              <p v-if="form.ttd_dpjp_timestamp" class="timestamp-ttd">Ditandatangani: {{ form.ttd_dpjp_timestamp }}</p>
              <button @click="clearSign('ttd_dpjp')" class="btn-clear mt-2">Hapus &amp; Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_dpjp" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dpjp')" class="btn-save mt-2">Simpan ✔</button>
            </div>
          </div>
          <!-- Nama Dokter (dropdown) -->
          <div class="dropdown-dokter mt-2" style="max-width:350px; margin:0 auto;">
            <select v-model="form.nama_dpjp" class="form-select-dokter" :disabled="disabledSubmit">
              <option value="" disabled>🩺 Pilih Dokter DPJP</option>
              <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                {{ dokter.nama }}
              </option>
            </select>
            <span class="dropdown-icon">▾</span>
          </div>
        </div>
        

        <!-- BUTTON BOTTOM -->
        <div class="action-footer" v-if="!disabledSubmit">
          <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
            <span v-if="loadingSubmit">Menyimpan...</span>
            <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
          </button>
          <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Kembali</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormPengkajianAwalMedisMata",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit: false,
      disabledSubmit: false,
      ttdDpjpCleared: false,
      listDokter: [],
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_surat: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",

        // Header
        tanggal: "",
        jam: "",

        // Alergi & Sumber Data
        alergi: "",
        sumber_pasien: false,
        sumber_keluarga: false,
        sumber_teman: false,
        sumber_lainnya: false,
        sumber_lainnya_text: "",

        // Nyeri
        skala_nyeri: "",
        skala_nyeri_text: "",
        nyeri_ada: "",
        nyeri_lokasi: "",
        nyeri_karakteristik: "",
        nyeri_durasi: "",
        nyeri_frekuensi: "",

        // Anamnesa
        keluhan_utama: "",
        riwayat_penyakit_sekarang: "",
        riwayat_penyakit_dahulu: "",
        riwayat_pengobatan: "",

        // RPK
        rpk_hipertensi: false,
        rpk_diabetes: false,
        rpk_jantung: false,
        rpk_stroke: false,
        rpk_dialysis: false,
        rpk_asthma: false,
        rpk_kejang: false,
        rpk_liver: false,
        rpk_cancer: false,
        rpk_tbc: false,
        rpk_glaukoma: false,
        rpk_std: false,
        rpk_perdarahan: false,
        rpk_lain_lain: false,
        rpk_lain_lain_text: "",

        // Operasi & Transfusi
        riwayat_operasi: "",
        riwayat_operasi_keterangan: "",
        riwayat_transfusi: "",
        reaksi_transfusi: "",
        reaksi_transfusi_text: "",

        // Sosial
        riwayat_sosial: "",

        // TTV
        keadaan_umum: "",
        gizi: "",
        gcs_e: "",
        gcs_m: "",
        gcs_v: "",
        bb: "",
        tindakan_resusitasi: "",
        tensi: "",
        suhu_ttv: "",
        nadi_ttv: "",
        respirasi: "",
        saturasi_o2: "",
        oksigen_jenis: "",
        oksigen_lainnya_text: "",

        // PF
        pf_ku_baik: false,
        pf_ku_sedang: false,
        pf_ku_lemah: false,
        pf_ku_buruk: false,
        pf_kes_cm: false,
        pf_kes_somnolen: false,
        pf_kes_koma: false,
        pf_gcs_e: "",
        pf_gcs_v: "",
        pf_gcs_m: "",
        tekanan_darah: "",
        nadi_pf: "",
        nadi_regularitas: "",
        rr: "",
        spo2: "",
        temp: "",
        reflex_cahaya: "",
        akral: "",
        kepala: "",
        leher: "",
        jantung_inspeksi: "",
        jantung_palpasi: "",
        jantung_perkusi: "",
        jantung_auskultasi: "",

        // Mata
        mata_visus_od: "",
        mata_visus_os: "",
        mata_pgbm_od: "",
        mata_pgbm_os: "",
        mata_palpebra_sup_od: "",
        mata_palpebra_sup_os: "",
        mata_palpebra_inf_od: "",
        mata_palpebra_inf_os: "",
        mata_kornea_od: "",
        mata_kornea_os: "",
        mata_iris_od: "",
        mata_iris_os: "",
        mata_konjungtiva_od: "",
        mata_konjungtiva_os: "",
        mata_sekret_od: "",
        mata_sekret_os: "",
        mata_tio_od: "",
        mata_tio_os: "",
        mata_pupil_reflek_od: "",
        mata_pupil_reflek_os: "",
        mata_pupil_ukuran_od: "",
        mata_pupil_ukuran_os: "",
        mata_pupil_isokor_od: "",
        mata_pupil_isokor_os: "",

        // Penunjang & Diagnosa
        status_lokalis: "",
        pemeriksaan_penunjang: "",
        diagnosa_kerja: "",
        diagnosa_diferensial: "",
        terapi: "",
        rencana_kerja: "",

        // Hasil & Disposisi
        hasil_pembedahan: "",
        cb_boleh_pulang: false,
        disposisi_pulang_jam: "",
        disposisi_pulang_tanggal: "",
        cb_kontrol_poliklinik: false,
        kontrol_poliklinik: "",
        kontrol_tujuan: "",
        kontrol_tanggal: "",
        cb_dirawat_ruangan: false,
        cb_dirawat_kelas: false,
        dirawat_ruangan: "",
        dirawat_kelas: "",
        rekomendasi: "",
        catatan_penting: "",

        // TTD
        kota_ttd: "Medan",
        tanggal_ttd: "",
        jam_ttd: "",
        ttd_dpjp: "",
        nama_dpjp: "",
        ttd_dpjp_timestamp: "",
      },
    };
  },
  computed: {
    isEditMode() {
      return this.editData !== null && this.editData !== undefined;
    },
  },
  watch: {
    "form.skala_nyeri"(val) {
      this.form.skala_nyeri_text = val;
    },
  },
  async mounted() {
    await this.fetchTahunAkreditasi();
    await this.fetchDokter();

    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },
  methods: {
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 7.7/PAMM/${tahun}`;
        }
      } catch (error) {
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 7.7/PAMM/22';
        }
      }
    },

    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
      } catch (error) {
        console.error('Gagal memuat data dokter:', error);
      }
    },

    loadDataForEdit() {
      const data = this.editData || this.viewData;
      if (!data) { this.setDataForm(); return; }

      const checkboxFields = [
        'sumber_pasien','sumber_keluarga','sumber_teman','sumber_lainnya',
        'rpk_hipertensi','rpk_diabetes','rpk_jantung','rpk_stroke','rpk_dialysis',
        'rpk_asthma','rpk_kejang','rpk_liver','rpk_cancer','rpk_tbc',
        'rpk_glaukoma','rpk_std','rpk_perdarahan','rpk_lain_lain',
        'pf_ku_baik','pf_ku_sedang','pf_ku_lemah','pf_ku_buruk',
        'pf_kes_cm','pf_kes_somnolen','pf_kes_koma',
        'cb_boleh_pulang','cb_kontrol_poliklinik','cb_dirawat_ruangan','cb_dirawat_kelas',
      ];

      Object.keys(this.form).forEach((key) => {
        if (!data.hasOwnProperty(key)) return;
        const value = data[key];
        if (checkboxFields.includes(key)) {
          this.form[key] = value === true || value === 1 || value === "1";
        } else {
          this.form[key] = value ?? "";
        }
      });

      this.$nextTick(() => {
        if (this.form.ttd_dpjp) this.ttdDpjpCleared = false;
      });
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal     = today.toISOString().split("T")[0];
      this.form.jam         = today.toTimeString().substring(0, 5);
      this.form.tanggal_ttd = today.toISOString().split("T")[0];
      this.form.jam_ttd     = today.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien   = this.selectedPatient.uuid;
        this.form.no_rm         = this.selectedPatient.rekam_medis;
        this.form.nik           = this.selectedPatient.no_identitas || "";
        this.form.nama          = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
      this.ttdDpjpCleared = false;
      this.form[refName] = data;
      const now = new Date();
      this.form.ttd_dpjp_timestamp = now.toLocaleString('id-ID', {
        day:'2-digit', month:'2-digit', year:'numeric',
        hour:'2-digit', minute:'2-digit', second:'2-digit'
      });
    },

    clearSign(refName) {
      this.ttdDpjpCleared = true;
      this.form[refName] = "";
      this.form.ttd_dpjp_timestamp = "";
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    async submitForm() {
      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) return;
          let value = this.form[key];
          if (typeof value === "boolean") value = value ? 1 : 0;
          fd.append(key, value ?? "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-pengkajian-awal-medis-mata",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        } else {
          alert(response.data.message || "Gagal menyimpan form!");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert(error.response?.data?.message || "Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
body {
  font-family: Arial, sans-serif;
  padding: 20px;
  background-color: #f5f5f5;
}

/* ====== TABLE MATA ====== */
.table-rme-mata {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
.table-rme-mata th,
.table-rme-mata td {
  border: 1px solid #ccc;
  padding: 5px 8px;
  vertical-align: middle;
}
.table-rme-mata th {
  background-color: #f0f4ff;
  font-weight: bold;
  text-align: center;
}
.table-rme-mata input.input-rme {
  width: 100%;
  box-sizing: border-box;
}

/* ====== FORM RS TABLE ====== */
.form-rs {
  width: 100%;
  border-collapse: collapse;
  font-size: 12px;
  background: white;
}
.form-rs th,
.form-rs td {
  border: 1px solid #000;
  padding: 4px 6px;
  vertical-align: middle;
}
.form-rs th {
  background-color: #ffffff;
  font-weight: bold;
  text-align: center;
}
.form-rs th.center,
.form-rs td.center {
  text-align: center;
}

/* ====== INPUTS ====== */
.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
}
.input-rme1 {
  width: 80%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
}
.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
}
.input-rme:disabled,
.input-rme[readonly] {
  background: #e9ecef;
  cursor: not-allowed;
}

.line-input {
  border: none;
  border-bottom: 1px solid #000;
  width: 40%;
  padding: 2px 4px;
  outline: none;
  background: transparent;
  font-size: 14px;
}

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
}
.textarea-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
}

/* ====== LABELS ====== */
label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 14px;
  color: #333;
}

/* ====== CHECKBOX ====== */
input[type="checkbox"] {
  cursor: pointer;
  margin-top: 3px;
}
.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}
.checkbox-item {
  display: flex;
  align-items: center;
  gap: 5px;
  margin: 0;
  white-space: nowrap;
}

/* ====== LAYOUT ROWS ====== */
.form-row-3-3 {
  display: flex;
  gap: 1rem;
}
.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem;
}

.form-row-2 {
  display: flex;
  gap: 1rem;
}
.form-row-2 > div {
  flex: 1;
  padding: 0.5rem;
}

.form-row-inline {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  gap: 20px;
}

.row-label {
  min-width: 100px;
  font-weight: normal;
}

.two-box-wrapper {
  display: flex;
  gap: 20px;
}
.two-box-wrapper .box-rme {
  flex: 1;
  width: 50%;
}

/* ====== BOX & SECTION ====== */
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
  margin-bottom: 20px;
}
.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

/* ====== CONTAINER ====== */
.container {
  max-width: 1200px;
  margin: 0 auto;
}

/* ====== SIGNATURE ====== */
.signature-preview {
  width: 100%;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}
.img-signature {
  max-width: 100%;
  height: 180px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
  display: block;
  margin: 0 auto;
}
.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
}
.signature-box-rme-small {
  width: 150px !important;
  height: 100px !important;
  border: 1px solid #000;
  border-radius: 4px;
}
.signature-actions {
  display: flex;
  justify-content: center;
  gap: 10px;
}
.signature-row {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
}
.signature-row > div {
  flex: 1;
  padding: 1rem;
  box-sizing: border-box;
}
.signature-row-3 {
  display: flex;
  gap: 0.1rem;
  margin-top: 1.5rem;
}
.signature-row-3 > div {
  flex: 1;
  padding: 1rem;
  text-align: center;
  box-sizing: border-box;
}

/* ====== TIMESTAMP ====== */
.timestamp-ttd {
  font-size: 12px;
  color: #2d74b7;
  font-weight: 500;
  padding: 6px 16px;
  background: #e9f5ff;
  border-radius: 4px;
  display: block;
  width: fit-content;
  margin: 6px auto;
}

/* ====== DROPDOWN DOKTER ====== */
.dropdown-dokter { position: relative; }
.form-select-dokter {
  width: 100%;
  padding: 8px 32px 8px 12px;
  border: 1.5px solid #4a90d9;
  border-radius: 8px;
  font-size: 14px;
  background: #f0f8ff;
  color: #1a3a5c;
  appearance: none;
  cursor: pointer;
}
.form-select-dokter:focus {
  outline: none;
  border-color: #121314;
  box-shadow: 0 0 0 3px rgba(74,144,217,.2);
}
.form-select-dokter:disabled { background: #f5f5f5; cursor: not-allowed; }
.dropdown-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
  color: #e5e7e9;
}

/* ====== BUTTONS ====== */
.btn-back {
  background: #ff9800;
  color: white;
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
}
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ccc; cursor: not-allowed; }

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
}
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}
.btn-save:hover { background: #1565c0; }

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  margin-left: 10px;
}

/* ====== ACTION FOOTER ====== */
.action-footer {
  margin-top: 30px;
  padding: 20px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  background: #f5f5f5;
  border-top: 2px solid #ddd;
  position: sticky;
  bottom: 0;
}

/* ====== VIEW OVERLAY ====== */
.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 251, 251, 0.1);
  z-index: 10;
  cursor: not-allowed;
}
.form-wrapper {
  position: relative;
}

/* ====== UTILITY ====== */
.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}
.col-md-4,
.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
}
.col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
.col-md-6 { flex: 0 0 50%; max-width: 50%; }
.col-md-12 { flex: 0 0 100%; max-width: 100%; }

.d-flex { display: flex; }
.gap-3 { gap: 12px; }
.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 16px; }
.mb-4 { margin-bottom: 24px; }
.mt-2 { margin-top: 8px; }
.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mx-auto { margin-left: auto; margin-right: auto; }
.py-4 { padding-top: 24px; padding-bottom: 24px; }

/* ====== RESPONSIVE ====== */
@media (max-width: 768px) {
  .two-box-wrapper { flex-direction: column; }
  .col-md-4, .col-md-6 { flex: 0 0 100%; max-width: 100%; }
  .form-row-3-3, .form-row-2, .signature-row { flex-direction: column; }
}
</style>
