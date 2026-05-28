<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">EVALUASI PRA ANESTHESI</h2>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        </div>

        <!-- INFORMASI PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="form-row-2">
            <div>
              <label>No. RM :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
            <div>
              <label>NIK :</label>
              <input type="text" v-model="form.nik" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Nama Pasien :</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div>
              <label>Tanggal Lahir :</label>
              <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
            </div>
          </div>
        </div>

        <!-- =============================== -->
        <!-- HALAMAN 1 — DIISI OLEH PASIEN   -->
        <!-- =============================== -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Data Umum (Diisi Pasien)</h5>

          <div class="form-row-3">
            <div>
              <label>Ruangan :</label>
              <input type="text" v-model="form.ruangan" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Tanggal :</label>
              <input type="date" v-model="form.tanggal" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Jam :</label>
              <input type="time" v-model="form.jam" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-4">
            <div>
              <label>Umur :</label>
              <input type="text" v-model="form.umur" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Pekerjaan :</label>
              <input type="text" v-model="form.pekerjaan" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Jenis Kelamin :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.jk" value="L" :disabled="disabledSubmit"> L</label>
                <label class="radio-item"><input type="radio" v-model="form.jk" value="P" :disabled="disabledSubmit"> P</label>
              </div>
            </div>
            <div>
              <label>Status Menikah :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.menikah" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.menikah" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>
        </div>

        <!-- KEBIASAAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Kebiasaan</h5>

          <div class="form-row-2 mb-2">
            <div>
              <label>Merokok :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.merokok" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.merokok" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Sebanyak :</label>
              <input type="text" v-model="form.merokok_sebanyak" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mb-2">
            <div>
              <label>Kopi / Teh / Soda :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kopi_teh_soda" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kopi_teh_soda" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Sebanyak :</label>
              <input type="text" v-model="form.kopi_teh_soda_sebanyak" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mb-2">
            <div>
              <label>Alkohol :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.alkohol" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.alkohol" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Sebanyak :</label>
              <input type="text" v-model="form.alkohol_sebanyak" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Olahraga Rutin :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.olahraga_rutin" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.olahraga_rutin" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Sebanyak :</label>
              <input type="text" v-model="form.olahraga_rutin_sebanyak" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <!-- PENGOBATAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pengobatan</h5>
          <small class="text-muted d-block mb-3">Sebutkan dosis atau jumlah pil per hari</small>

          <div class="form-row-2 mb-2">
            <div>
              <label>Obat Resep :</label>
              <textarea v-model="form.obat_resep" class="textarea-rme" rows="2" :disabled="disabledSubmit"></textarea>
            </div>
            <div>
              <label>Obat Bebas (Vitamin, Herbal) :</label>
              <textarea v-model="form.obat_bebas" class="textarea-rme" rows="2" :disabled="disabledSubmit"></textarea>
            </div>
          </div>

          <div class="yn-grid">
            <div class="yn-row">
              <span class="yn-label">Penggunaan Aspirin Rutin :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.aspirin_rutin" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.aspirin_rutin" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
              <input type="text" v-model="form.aspirin_dosis" class="input-rme input-inline" placeholder="Dosis dan frekuensi" :disabled="disabledSubmit" />
            </div>
            <div class="yn-row">
              <span class="yn-label">Obat Anti Sakit :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.obat_anti_sakit" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.obat_anti_sakit" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
              <input type="text" v-model="form.obat_anti_sakit_dosis" class="input-rme input-inline" placeholder="Dosis dan frekuensi" :disabled="disabledSubmit" />
            </div>
            <div class="yn-row">
              <span class="yn-label">Injeksi Steroid (tahun-tahun terakhir) :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.injeksi_steroid" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.injeksi_steroid" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
              <input type="text" v-model="form.injeksi_steroid_info" class="input-rme input-inline" placeholder="Tanggal dan lokasi injeksi" :disabled="disabledSubmit" />
            </div>
            <div class="yn-row">
              <span class="yn-label">Alergi Obat :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.alergi_obat" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.alergi_obat" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
              <input type="text" v-model="form.alergi_obat_daftar" class="input-rme input-inline" placeholder="Daftar obat dan tipe reaksi" :disabled="disabledSubmit" />
            </div>
          </div>

          <div class="form-row-3 mt-3">
            <div>
              <label>Alergi Lateks :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.alergi_lateks" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.alergi_lateks" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Alergi Plaster :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.alergi_plaster" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.alergi_plaster" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Alergi Makanan :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.alergi_makanan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.alergi_makanan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>
        </div>

        <!-- RIWAYAT KELUARGA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Riwayat Keluarga</h5>
          <small class="text-muted d-block mb-3">Apakah keluarga mendapat permasalahan seperti di bawah ini?</small>

          <div class="checklist-2col">
            <div class="yn-row">
              <span class="yn-label">Perdarahan yang tidak normal :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_perdarahan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_perdarahan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Serangan jantung :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_serangan_jantung" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_serangan_jantung" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Pembekuan darah tidak normal :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_pembekuan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_pembekuan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Hipertensi :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_hipertensi" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_hipertensi" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Permasalahan dalam pembuluh darah :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_pembuluh_darah" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_pembuluh_darah" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Tuberkulosis :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_tuberkulosis" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_tuberkulosis" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Operasi jantung koroner :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_operasi_jantung" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_operasi_jantung" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Penyakit berat lainnya :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_penyakit_berat_lainnya" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_penyakit_berat_lainnya" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Diabetes :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kel_diabetes" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kel_diabetes" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>
          <div class="mt-3">
            <label>Jelaskan penyakit keluarga apabila dijawab "Ya" :</label>
            <textarea v-model="form.kel_jelaskan" class="textarea-rme" rows="3" :disabled="disabledSubmit"></textarea>
          </div>
        </div>

        <!-- KOMUNIKASI -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Komunikasi</h5>
          <div class="mb-2">
            <label>Bahasa :</label>
            <div class="checkbox-inline" style="align-items: center;">
              <label class="check-item">
                <input type="checkbox" v-model="form.bahasa_indonesia" true-value="1" false-value="0" :disabled="disabledSubmit"> Indonesia
              </label>
              <label class="check-item">
                <input type="checkbox" v-model="form.bahasa_lainnya_cb" true-value="1" false-value="0" :disabled="disabledSubmit"> Lainnya
              </label>
              <input type="text" v-model="form.bahasa_lainnya" class="input-rme" style="width: 220px;" placeholder="Sebutkan bahasa lainnya..." :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-3">
            <div>
              <label>Gangguan Penglihatan / Buta :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.gangguan_penglihatan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.gangguan_penglihatan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Gangguan Pendengaran / Tuli :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.gangguan_pendengaran" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.gangguan_pendengaran" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Gangguan Bicara :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.gangguan_bicara" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.gangguan_bicara" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>
        </div>

        <!-- RIWAYAT PENYAKIT PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Riwayat Penyakit Pasien</h5>
          <small class="text-muted d-block mb-3">Apakah pasien pernah menderita penyakit di bawah ini?</small>

          <div class="checklist-2col">
            <div class="yn-row">
              <span class="yn-label">Perdarahan yang tidak normal :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_perdarahan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_perdarahan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Serangan jantung / Nyeri dada :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_serangan_jantung" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_serangan_jantung" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Pembekuan darah tidak normal :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_pembekuan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_pembekuan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Hepatitis / Sakit kuning :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_hepatitis" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_hepatitis" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sakit maag :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_sakit_maag" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_sakit_maag" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sumbatan jalan nafas saat tidur / Sleep Apnea :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_sleep_apnea" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_sleep_apnea" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Stroke :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_stroke" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_stroke" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Penyakit berat lainnya :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_penyakit_berat_lainnya" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_penyakit_berat_lainnya" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sesak Napas :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_sesak_napas" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_sesak_napas" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Asma :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_asma" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_asma" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Diabetes :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_diabetes" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_diabetes" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Pingsan :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.rp_pingsan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.rp_pingsan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>

          <div class="mt-3">
            <label>Jelaskan penyakit yang dijawab "Ya" :</label>
            <textarea v-model="form.rp_jelaskan" class="textarea-rme" rows="3" :disabled="disabledSubmit"></textarea>
          </div>

          <div class="form-row-2 mt-3">
            <div>
              <label>Apakah pasien pernah mendapatkan tranfusi darah :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.transfusi_darah" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.transfusi_darah" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Bila ya, tahun berapa :</label>
              <select v-model="form.transfusi_darah_tahun" class="input-rme" :disabled="disabledSubmit">
                <option value="">-- Pilih Tahun --</option>
                <option v-for="y in yearList" :key="y" :value="y">{{ y }}</option>
              </select>
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Apakah pasien pernah diperiksa untuk diagnosis HUV :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.hiv_diperiksa" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.hiv_diperiksa" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Bila ya, tahun berapa :</label>
              <select v-model="form.hiv_tahun" class="input-rme" :disabled="disabledSubmit">
                <option value="">-- Pilih Tahun --</option>
                <option v-for="y in yearList" :key="y" :value="y">{{ y }}</option>
              </select>
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Hasil pemeriksaan HIV :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.hiv_hasil" value="Positif" :disabled="disabledSubmit"> Positif</label>
                <label class="radio-item"><input type="radio" v-model="form.hiv_hasil" value="Negatif" :disabled="disabledSubmit"> Negatif</label>
              </div>
            </div>
          </div>
          <br>
          <small class="text-muted d-block mb-3">Apakah pasien memakai  :</small>
          <div class="form-row-2 mt-2">
            <div>
              <label>Lensa Kontak :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.lensa_kontak" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.lensa_kontak" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Kacamata :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.kacamata" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.kacamata" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Alat Bantu Dengar :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.alat_bantu_dengar" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.alat_bantu_dengar" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div>
              <label>Gigi Palsu :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.gigi_palsu_alat" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.gigi_palsu_alat" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>

          <div class="mt-3">
            <label>Riwayat operasi, tahun dan jenis operasi :</label>
            <textarea v-model="form.riwayat_operasi" class="textarea-rme" rows="2" :disabled="disabledSubmit"></textarea>
          </div>
          <br>
          <small class="text-muted d-block mb-3">Jenis anestesi yang digunakan dan sebutkan komplikasi/reaksi yang dialami  : </small>
          <div class="mt-2">
            <label>Anestesia lokal — komplikasi / reaksi :</label>
            <input type="text" v-model="form.anestesi_lokal_komplikasi" class="input-rme" :disabled="disabledSubmit" />
          </div>
          <div class="mt-2">
            <label>Anestesia regional — komplikasi / reaksi :</label>
            <input type="text" v-model="form.anestesi_regional_komplikasi" class="input-rme" :disabled="disabledSubmit" />
          </div>
          <div class="mt-2">
            <label>Anestesia umum — komplikasi / reaksi :</label>
            <input type="text" v-model="form.anestesi_umum_komplikasi" class="input-rme" :disabled="disabledSubmit" />
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Tanggal terakhir periksa ke dokter :</label>
              <input type="date" v-model="form.tgl_terakhir_periksa" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Dimana :</label>
              <input type="text" v-model="form.tempat_periksa" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="mt-2">
            <label>Untuk penyakit gangguan :</label>
            <input type="text" v-model="form.penyakit_gangguan" class="input-rme" :disabled="disabledSubmit" />
          </div>
        </div>

        <!-- KHUSUS PEREMPUAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Khusus Pasien Perempuan</h5>
          <div class="form-row-2">
            <div>
              <label>Jumlah Kehamilan :</label>
              <input type="text" v-model="form.jumlah_kehamilan" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Jumlah Anak :</label>
              <input type="text" v-model="form.jumlah_anak" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Menstruasi Terakhir :</label>
              <input type="text" v-model="form.menstruasi_terakhir" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Menyusui :</label>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.menyusui" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.menyusui" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>
        </div>

        <!-- =============================== -->
        <!-- HALAMAN 2 — DIISI OLEH DOKTER   -->
        <!-- =============================== -->

        <!-- IDENTITAS PASIEN HALAMAN 2 -->
        <div class="box-rme mb-4">
          <div class="form-row-2">
            <div>
              <label>Nama :</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div>
              <label>No. RM :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Tanggal :</label>
              <input type="date" v-model="form.tanggal" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Kajian Sistem (Diisi Dokter)</h5>

          <div class="checklist-2col">
            <div class="yn-row">
              <span class="yn-label">Hilangnya gigi :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_hilangnya_gigi" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_hilangnya_gigi" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sakit dada :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_sakit_dada" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_sakit_dada" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Masalah mobilisasi lider :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_mobilisasi_lider" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_mobilisasi_lider" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Denyut jantung tidak normal :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_denyut_jantung" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_denyut_jantung" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Lebar perotok :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_lebar_perotok" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_lebar_perotok" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Muntah :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_muntah" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_muntah" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sakit tenggorokan :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_sakit_tenggorokan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_sakit_tenggorokan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Perut pusing :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_perut_pusing" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_perut_pusing" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sesak nafas :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_sesak_nafas" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_sesak_nafas" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Kejang :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_kejang" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_kejang" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Baru saja menderita infeksi :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_baru_infeksi" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_baru_infeksi" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Sedang hamil :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_sedang_hamil" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_sedang_hamil" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Saluran nafas atas :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_saluran_nafas_atas" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_saluran_nafas_atas" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Pingsan :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_pingsan" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_pingsan" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Periode menstruasi tidak normal :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_menstruasi_tidak_normal" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_menstruasi_tidak_normal" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Obesitas :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_obesitas" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_obesitas" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
            <div class="yn-row">
              <span class="yn-label">Stroke :</span>
              <div class="radio-inline">
                <label class="radio-item"><input type="radio" v-model="form.dok_stroke" value="Y" :disabled="disabledSubmit"> Ya</label>
                <label class="radio-item"><input type="radio" v-model="form.dok_stroke" value="T" :disabled="disabledSubmit"> Tidak</label>
              </div>
            </div>
          </div>

          <div class="form-row-2 mt-3">
            <div>
              <label>Keterangan :</label>
              <input type="text" v-model="form.dok_keterangan" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <!-- KEADAAN UMUM -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Keadaan Umum</h5>
          <div class="form-row-4">
            <div>
              <label>Kesadaran :</label>
              <input type="text" v-model="form.kesadaran" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Visue :</label>
              <input type="text" v-model="form.visue" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Faring :</label>
              <input type="text" v-model="form.faring" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Gigi Palsu :</label>
              <input type="text" v-model="form.gigi_palsu" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <!-- PEMERIKSAAN FISIK -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pemeriksaan Fisik</h5>
          <div class="form-row-5 mb-2">
            <div>
              <label>Tinggi (cm) :</label>
              <input type="number" v-model="form.tinggi" class="input-rme" :disabled="disabledSubmit" min="0" />
            </div>
            <div>
              <label>Berat (kg) :</label>
              <input type="number" v-model="form.berat" class="input-rme" :disabled="disabledSubmit" min="0" />
            </div>
            <div>
              <label>TD :</label>
              <input type="number" v-model="form.td" class="input-rme" :disabled="disabledSubmit" min="0" />
            </div>
            <div>
              <label>Nadi :</label>
              <input type="number" v-model="form.nadi" class="input-rme" :disabled="disabledSubmit" min="0" />
            </div>
            <div>
              <label>Suhu :</label>
              <input type="number" v-model="form.suhu" class="input-rme" :disabled="disabledSubmit" min="0" step="0.1" />
            </div>
          </div>
          <div class="form-row-2 mb-2">
            <div>
              <label>Paru-paru :</label>
              <input type="text" v-model="form.paru_paru" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Jantung :</label>
              <input type="text" v-model="form.jantung" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mb-2">
            <div>
              <label>Abdomen :</label>
              <input type="text" v-model="form.abdomen" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Ekstrimitas :</label>
              <input type="text" v-model="form.ekstrimitas" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Neurologi (bila dapat diperiksa) :</label>
              <input type="text" v-model="form.neurologi" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Keterangan :</label>
              <input type="text" v-model="form.fisik_keterangan" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <!-- LABORATORIUM -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Laboratorium (Bila Tersedia)</h5>
          <div class="form-row-2">
            <div>
              <label>Hb/Ht :</label>
              <input type="text" v-model="form.lab_hb_ht" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Rontgen Dada :</label>
              <input type="text" v-model="form.lab_rontgen_dada" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>PT/APTT :</label>
              <input type="text" v-model="form.lab_pt_aptt" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>EKG :</label>
              <input type="text" v-model="form.lab_ekg" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Tes Kehamilan :</label>
              <input type="text" v-model="form.lab_tes_kehamilan" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label><i>Na/Ci  :</i></label>
              <input type="text" v-model="form.lab_co2" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Kalium :</label>
              <input type="text" v-model="form.lab_kalium" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Co2 :</label>
              <input type="text" v-model="form.lab_kreatinin" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Uream :</label>
              <input type="text" v-model="form.lab_uream" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Kreatinin :</label>
              <input type="text" v-model="form.lab_glukosa" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Lain-lain :</label>
              <input type="text" v-model="form.lab_lain_lain" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Keterangan :</label>
              <input type="text" v-model="form.lab_keterangan" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <!-- DIAGNOSIS / ASA -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Diagnosis & Klasifikasi ASA</h5>
          <label class="mb-2 d-block">Klasifikasi berdasarkan ASA :</label>
          <div class="asa-grid">
            <label class="asa-item"><input type="radio" v-model="form.asa_klasifikasi" value="1" :disabled="disabledSubmit"> <strong>ASA 1</strong> — Pasien normal yang sehat</label>
            <label class="asa-item"><input type="radio" v-model="form.asa_klasifikasi" value="2" :disabled="disabledSubmit"> <strong>ASA 2</strong> — Pasien dengan penyakit sistemik ringan</label>
            <label class="asa-item"><input type="radio" v-model="form.asa_klasifikasi" value="3" :disabled="disabledSubmit"> <strong>ASA 3</strong> — Pasien dengan penyakit sistemik berat</label>
            <label class="asa-item"><input type="radio" v-model="form.asa_klasifikasi" value="4" :disabled="disabledSubmit"> <strong>ASA 4</strong> — Pasien dengan penyakit sistemik berat yang mengancam nyawa</label>
          </div>
        </div>

        <!-- REKOMENDASI ANESTESI -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Rekomendasi Tindakan Anestesi</h5>

          <div class="anestesi-group">
            <div class="anestesi-group-header">
              <label class="check-item fw-bold">
                <input type="checkbox" v-model="form.rek_anestesi_umum" true-value="1" false-value="0" :disabled="disabledSubmit">
                Anestesi Umum :
              </label>
            </div>
            <div class="anestesi-sub">
              <label class="check-item"><input type="checkbox" v-model="form.rek_au_intevena" true-value="1" false-value="0" :disabled="disabledSubmit"> Intevena</label>
              <label class="check-item"><input type="checkbox" v-model="form.rek_au_sungkup_muka" true-value="1" false-value="0" :disabled="disabledSubmit"> Sungkup Muka</label>
              <label class="check-item"><input type="checkbox" v-model="form.rek_au_lma" true-value="1" false-value="0" :disabled="disabledSubmit"> Laringeal Mask Airway</label>
              <label class="check-item"><input type="checkbox" v-model="form.rek_au_ett" true-value="1" false-value="0" :disabled="disabledSubmit"> Pipa Endotrakeal Tube</label>
            </div>
          </div>

          <div class="anestesi-group mt-2">
            <div class="anestesi-group-header">
              <label class="check-item fw-bold">
                <input type="checkbox" v-model="form.rek_regional" true-value="1" false-value="0" :disabled="disabledSubmit">
                Regional Anestesi :
              </label>
            </div>
            <div class="anestesi-sub">
              <label class="check-item"><input type="checkbox" v-model="form.rek_reg_spinal" true-value="1" false-value="0" :disabled="disabledSubmit"> Spinal Anestesi Blok</label>
              <label class="check-item"><input type="checkbox" v-model="form.rek_reg_epidural" true-value="1" false-value="0" :disabled="disabledSubmit"> Epidural</label>
              <label class="check-item"><input type="checkbox" v-model="form.rek_reg_cse" true-value="1" false-value="0" :disabled="disabledSubmit"> Kombinasi Spinal Epidural</label>
              <label class="check-item"><input type="checkbox" v-model="form.rek_reg_pnb" true-value="1" false-value="0" :disabled="disabledSubmit"> Peripheral Nerve Block</label>
            </div>
          </div>

          <div class="mt-2">
            <label class="check-item fw-bold">
              <input type="checkbox" v-model="form.rek_umum_plus_regional" true-value="1" false-value="0" :disabled="disabledSubmit">
              Anestesi Umum + Regional Anestesi
            </label>
          </div>

          <div class="form-row-2 mt-3">
            <div>
              <label>Puasa Mulai — Jam :</label>
              <input type="time" v-model="form.puasa_mulai_jam" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Tanggal :</label>
              <input type="date" v-model="form.puasa_mulai_tanggal" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Rencana Elasi di OK — Jam :</label>
              <input type="time" v-model="form.rencana_elasi_jam" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Tanggal :</label>
              <input type="date" v-model="form.rencana_elasi_tanggal" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
          <div class="form-row-2 mt-2">
            <div>
              <label>Rencana Operasi — Jam :</label>
              <input type="time" v-model="form.rencana_operasi_jam" class="input-rme" :disabled="disabledSubmit" />
            </div>
            <div>
              <label>Tanggal :</label>
              <input type="date" v-model="form.rencana_operasi_tanggal" class="input-rme" :disabled="disabledSubmit" />
            </div>
          </div>
        </div>

        <!-- TANDA TANGAN DOKTER -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan Dokter</h5>
          <div class="text-center">
            <label class="fw-bold mb-2 d-block">Dokter Anestesi</label>
            <div v-if="form.ttd_dokter && !ttdDokterCleared" class="signature-preview text-center">
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <p v-if="form.ttd_dokter_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.ttd_dokter_timestamp }}
              </p>
              <button @click="clearSign" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign" class="btn-save mt-2">Simpan ✔</button>
            </div>
            <div class="dropdown-dokter mt-2" style="max-width:350px; margin:0 auto;">
              <select v-model="form.nama_dokter" class="form-select-dokter" :disabled="disabledSubmit">
                <option value="" disabled>🩺 Pilih Dokter</option>
                <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>
        </div>

        <!-- BUTTON BOTTOM -->
        <div class="action-footer" v-if="!disabledSubmit">
          <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
            <span v-if="loadingSubmit">Menyimpan...</span>
            <span v-else>Simpan</span>
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
  name: "FormEvaluasiPraAnestesi",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Boolean, default: false },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit:   false,
      disabledSubmit:  false,
      ttdDokterCleared: true,
      listDokter: [],
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",

        // Header
        diagnosa_medis: "",
        tanggal: "",
        jam: "",
        ruangan: "",
        umur: "",
        jk: "",
        menikah: "",
        pekerjaan: "",

        // Kebiasaan
        merokok: "",
        merokok_sebanyak: "",
        kopi_teh_soda: "",
        kopi_teh_soda_sebanyak: "",
        alkohol: "",
        alkohol_sebanyak: "",
        olahraga_rutin: "",
        olahraga_rutin_sebanyak: "",

        // Pengobatan
        obat_resep: "",
        obat_bebas: "",
        aspirin_rutin: "",
        aspirin_dosis: "",
        obat_anti_sakit: "",
        obat_anti_sakit_dosis: "",
        injeksi_steroid: "",
        injeksi_steroid_info: "",
        alergi_obat: "",
        alergi_obat_daftar: "",
        alergi_lateks: "",
        alergi_plaster: "",
        alergi_makanan: "",

        // Riwayat Keluarga
        kel_perdarahan: "",
        kel_serangan_jantung: "",
        kel_pembekuan: "",
        kel_hipertensi: "",
        kel_pembuluh_darah: "",
        kel_tuberkulosis: "",
        kel_operasi_jantung: "",
        kel_penyakit_berat_lainnya: "",
        kel_diabetes: "",
        kel_jelaskan: "",

        // Komunikasi
        bahasa_indonesia: "0",
        bahasa_lainnya_cb: "0",
        bahasa_lainnya: "",
        gangguan_penglihatan: "",
        gangguan_pendengaran: "",
        gangguan_bicara: "",

        // Riwayat Penyakit Pasien
        rp_perdarahan: "",
        rp_serangan_jantung: "",
        rp_pembekuan: "",
        rp_hepatitis: "",
        rp_sakit_maag: "",
        rp_sleep_apnea: "",
        rp_stroke: "",
        rp_penyakit_berat_lainnya: "",
        rp_sesak_napas: "",
        rp_asma: "",
        rp_diabetes: "",
        rp_pingsan: "",
        rp_jelaskan: "",
        transfusi_darah: "",
        transfusi_darah_tahun: "",
        hiv_diperiksa: "",
        hiv_tahun: "",
        hiv_hasil: "",
        kemoterapi_radioterapi: "",
        lensa_kontak: "",
        kacamata: "",
        alat_bantu_dengar: "",
        gigi_palsu_alat: "",
        riwayat_operasi: "",
        anestesi_lokal_komplikasi: "",
        anestesi_regional_komplikasi: "",
        anestesi_umum_komplikasi: "",
        tgl_terakhir_periksa: "",
        tempat_periksa: "",
        penyakit_gangguan: "",

        // Khusus Perempuan
        jumlah_kehamilan: "",
        jumlah_anak: "",
        menstruasi_terakhir: "",
        menyusui: "",

        // Dokter - Kajian Sistem
        dok_hilangnya_gigi: "",
        dok_sakit_dada: "",
        dok_mobilisasi_lider: "",
        dok_denyut_jantung: "",
        dok_lebar_perotok: "",
        dok_muntah: "",
        dok_sakit_tenggorokan: "",
        dok_perut_pusing: "",
        dok_sesak_nafas: "",
        dok_kejang: "",
        dok_baru_infeksi: "",
        dok_sedang_hamil: "",
        dok_saluran_nafas_atas: "",
        dok_pingsan: "",
        dok_menstruasi_tidak_normal: "",
        dok_obesitas: "",
        dok_stroke: "",
        dok_keterangan: "",
        dok_periode_tidak_stabil: "",

        // Keadaan Umum
        kesadaran: "",
        visue: "",
        faring: "",
        gigi_palsu: "",

        // Pemeriksaan Fisik
        tinggi: "",
        berat: "",
        td: "",
        nadi: "",
        suhu: "",
        paru_paru: "",
        jantung: "",
        abdomen: "",
        ekstrimitas: "",
        neurologi: "",
        fisik_keterangan: "",

        // Laboratorium
        lab_hb_ht: "",
        lab_rontgen_dada: "",
        lab_pt_aptt: "",
        lab_ekg: "",
        lab_tes_kehamilan: "",
        lab_co2: "",
        lab_kalium: "",
        lab_kreatinin: "",
        lab_uream: "",
        lab_glukosa: "",
        lab_lain_lain: "",
        lab_keterangan: "",

        // Diagnosis
        asa_klasifikasi: "",

        // Rekomendasi Anestesi
        rek_anestesi_umum: "0",
        rek_au_intevena: "0",
        rek_au_sungkup_muka: "0",
        rek_au_lma: "0",
        rek_au_ett: "0",
        rek_regional: "0",
        rek_reg_spinal: "0",
        rek_reg_epidural: "0",
        rek_reg_cse: "0",
        rek_reg_pnb: "0",
        rek_umum_plus_regional: "0",
        puasa_mulai_jam: "",
        puasa_mulai_tanggal: "",
        rencana_elasi_jam: "",
        rencana_elasi_tanggal: "",
        rencana_operasi_jam: "",
        rencana_operasi_tanggal: "",

        // TTD
        ttd_dokter: "",
        nama_dokter: "",
        ttd_dokter_timestamp: "",
      },
    };
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

  computed: {
    yearList() {
      const current = new Date().getFullYear();
      const years = [];
      for (let y = current; y >= 1950; y--) years.push(y);
      return years;
    },
  },

  methods: {
    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
      } catch (error) {
        console.error('Gagal memuat data dokter:', error);
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 4.10/EPA/${tahun}`;
        }
      } catch {
        if (!this.form.no_surat) this.form.no_surat = "RM 4.10/EPA/22";
      }
    },

    setDataForm() {
      const today = new Date().toISOString().split("T")[0];
      this.form.tanggal = today;
      if (this.selectedPatient) {
        this.form.uuid_pasien   = this.selectedPatient.uuid;
        this.form.no_rm         = this.selectedPatient.rekam_medis;
        this.form.nik           = this.selectedPatient.no_identitas || "";
        this.form.nama          = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir || "";
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
      }
    },

    loadDataForEdit() {
      if (!this.editData) { this.setDataForm(); return; }

      const checkFields = [
        'bahasa_indonesia','bahasa_lainnya_cb','rek_anestesi_umum','rek_au_intevena','rek_au_sungkup_muka',
        'rek_au_lma','rek_au_ett','rek_regional','rek_reg_spinal','rek_reg_epidural',
        'rek_reg_cse','rek_reg_pnb','rek_umum_plus_regional',
      ];

      Object.keys(this.form).forEach((key) => {
        if (this.editData.hasOwnProperty(key)) {
          const value = this.editData[key];
          if (checkFields.includes(key)) {
            this.form[key] = (value === true || value === 1 || value === '1') ? '1' : '0';
          } else {
            this.form[key] = value !== null ? value : "";
          }
        }
      });

      this.$nextTick(() => {
        if (this.form.ttd_dokter) this.ttdDokterCleared = false;
      });
    },

    saveSign() {
      const pad = this.$refs['ttd_dokter'];
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
      this.ttdDokterCleared   = false;
      this.form.ttd_dokter    = data;
      this.form.ttd_dokter_timestamp = new Date().toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });
    },

    clearSign() {
      this.ttdDokterCleared         = true;
      this.form.ttd_dokter          = "";
      this.form.ttd_dokter_timestamp = "";
      this.$nextTick(() => {
        const pad = this.$refs['ttd_dokter'];
        if (pad) pad.clearSignature();
      });
    },

    async submitForm() {
      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) return;
          fd.append(key, this.form[key] ?? "");
        });

        const res = await axios.post(
          "/master/pasien/dokumen-evaluasi-pra-anestesi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          alert(res.data.message);
          this.$emit("back");
        }
      } catch (err) {
        console.error(err.response?.data || err);
        alert("Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1100px; margin: 0 auto; }
.form-wrapper { position: relative; }

.form-row-2  { display: flex; gap: 1rem; }
.form-row-2 > div  { flex: 1; min-width: 0; padding: 0.4rem; }
.form-row-3  { display: flex; gap: 1rem; }
.form-row-3 > div  { flex: 1; min-width: 0; padding: 0.4rem; }
.form-row-4  { display: flex; gap: 1rem; flex-wrap: wrap; }
.form-row-4 > div  { flex: 1; min-width: 140px; padding: 0.4rem; }
.form-row-5  { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.form-row-5 > div  { flex: 1; min-width: 100px; padding: 0.4rem; }

.checklist-2col {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px 16px;
}

.yn-grid  { display: flex; flex-direction: column; gap: 6px; }
.yn-row   { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.yn-label { min-width: 220px; font-size: 14px; font-weight: 500; color: #333; }
.input-inline { flex: 1; min-width: 160px; }

.anestesi-group { border: 1px solid #e0e0e0; border-radius: 6px; padding: 10px 14px; }
.anestesi-group-header { margin-bottom: 8px; }
.anestesi-sub { display: flex; flex-wrap: wrap; gap: 8px 20px; padding-left: 20px; }

.asa-grid  { display: flex; flex-direction: column; gap: 8px; }
.asa-item  { display: flex; align-items: flex-start; gap: 8px; font-size: 14px; cursor: pointer; }

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
}
.section-title-rme {
  font-weight: bold;
  margin-bottom: 14px;
  color: #2d74b7;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 7px 8px;
  background: #f9f9f9;
  font-size: 14px;
  box-sizing: border-box;
}
.input-rme:focus  { outline: none; border-color: #2d74b7; background: white; }
.input-rme[readonly] { background: #e9ecef; cursor: not-allowed; }
.input-rme:disabled  { background: #e9ecef; cursor: not-allowed; }

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
  box-sizing: border-box;
}

.radio-inline  { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
.radio-item    { display: flex; align-items: center; gap: 5px; font-size: 14px; cursor: pointer; font-weight: normal; }
.checkbox-inline { display: flex; gap: 12px; flex-wrap: wrap; }
.check-item    { display: flex; align-items: center; gap: 6px; font-size: 14px; cursor: pointer; font-weight: normal; }

.signature-box-rme  { width: 350px !important; height: 180px !important; border: 2px solid #ccc; border-radius: 6px; }
.signature-preview  { background: white; padding: 10px; border-radius: 4px; }
.img-signature { max-width: 100%; height: 150px; object-fit: contain; border: 1px dashed #ccc; display: block; margin: 0 auto; }
.timestamp-ttd { font-size: 12px; color: #2d74b7; font-weight: 500; padding: 4px 12px; background: #e9f5ff; border-radius: 4px; display: block; width: fit-content; margin: 4px auto; }

.action-footer {
  margin-top: 30px; padding: 20px; display: flex;
  justify-content: flex-end; gap: 12px;
  background: #f5f5f5; border-top: 2px solid #ddd;
  position: sticky; bottom: 0;
}

.btn-save-form { background: #0288d1; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 15px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }

.btn-back { background: #ff9800; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 15px; }
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ccc; }

.btn-save  { background: #1e88e5; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; }
.btn-clear { background: #f44336; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; }

.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.08); z-index: 10; cursor: not-allowed; pointer-events: all; }

.dropdown-dokter { position: relative; width: 100%; }
.form-select-dokter {
  width: 100%; padding: 10px 40px 10px 14px; font-size: 14px;
  color: #2d3748; background-color: #fff;
  border: 1.5px solid #cbd5e0; border-radius: 10px;
  appearance: none; -webkit-appearance: none;
  cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s; outline: none;
}
.form-select-dokter:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2); }
.form-select-dokter:hover { border-color: #a0aec0; }
.form-select-dokter:disabled { background: #e9ecef; cursor: not-allowed; }
.dropdown-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #718096; font-size: 16px; pointer-events: none; }

label     { display: block; margin-bottom: 4px; font-weight: 500; font-size: 14px; color: #333; }
.text-center { text-align: center; }
.fw-bold  { font-weight: bold; }
.d-block  { display: block; }
.mx-auto  { margin-left: auto; margin-right: auto; }
.text-muted { color: #777; }
.mt-1 { margin-top: 4px; }
.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 12px; }
.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 12px; }
.mb-4 { margin-bottom: 24px; }
.py-4 { padding-top: 24px; padding-bottom: 24px; }
.position-relative { position: relative; }

@media (max-width: 768px) {
  .form-row-2, .form-row-3, .form-row-4, .form-row-5, .checklist-2col { flex-direction: column; grid-template-columns: 1fr; }
}
</style>
