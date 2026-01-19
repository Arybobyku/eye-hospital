<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">PENILAIAN PRA-ANESTESI DAN SEDASI</h2>
        <h4 class="fw-semibold">RM 4.4/PPADS/22</h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>
      
        <div class="form-row-3-3">
          <div>
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div>
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" />
          </div>
        </div>
      
        <div class="form-row-3-3">
          <div>
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div>
            <label>Tanggal Lahir :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>
      
        <div class="form-row-3-3">
          <div>
            <label>Jenis Kelamin :</label>
            <select v-model="form.jenis_kelamin" class="input-rme">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= DIISI OLEH PASIEN/KELUARGA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">DIISI OLEH PASIEN / KELUARGA</h5>
        
        <h6 class="fw-bold mt-3 mb-2">SOSIAL</h6>
        <div class="form-row 2">
          <div class="col-md-3">
            <label>Umur :</label>
            <input type="number" v-model="form.umur" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Jenis Kelamin :</label>
            <div style="display: flex; gap: 15px; margin-top: 8px;">
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_kelamin_pasien" value="L" />
                L
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_kelamin_pasien" value="P" />
                P
              </label>
            </div>
          </div>
          <div class="col-md-3">
            <label>Menikah :</label>
            <div style="display: flex; gap: 15px; margin-top: 8px;">
              <label class="radio-label">
                <input type="radio" v-model="form.menikah" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.menikah" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-3">
            <label>Pekerjaan :</label>
            <input type="text" v-model="form.pekerjaan" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">KEBIASAAN</h6>
        <div class="row">
          <div class="col-md-3">
            <label>Merokok :</label>
            <select v-model="form.kebiasaan_merokok" class="input-rme">
              <option value="T">Tidak</option>
              <option value="Y">Ya</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_merokok_jumlah" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Kopi/Teh/Cola :</label>
            <select v-model="form.kebiasaan_kopi" class="input-rme">
              <option value="T">Tidak</option>
              <option value="Y">Ya</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_kopi_jumlah" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-3">
            <label>Alkohol :</label>
            <select v-model="form.kebiasaan_alkohol" class="input-rme">
              <option value="T">Tidak</option>
              <option value="Y">Ya</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_alkohol_jumlah" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Olah Raga Rutin :</label>
            <select v-model="form.kebiasaan_olahraga" class="input-rme">
              <option value="T">Tidak</option>
              <option value="Y">Ya</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_olahraga_jumlah" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">PENGOBATAN (Sebutkan dosis per hari dan lama konsumsi)</h6>
        <div class="row">
          <div class="col-md-12">
            <label>Obat yang biasa diminum :</label>
            <textarea v-model="form.obat_biasa_diminum" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Aspirin/Plavix rutin :</label>
            <div style="display: flex; gap: 15px; align-items: center;">
              <label class="radio-label">
                <input type="radio" v-model="form.aspirin_plavix" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.aspirin_plavix" value="Y" />
                Y
              </label>
              <input type="text" v-model="form.aspirin_plavix_keterangan" class="input-rme" style="flex: 1;" placeholder="Keterangan" />
            </div>
          </div>
          <div class="col-md-6">
            <label>Obat anti sakit :</label>
            <div style="display: flex; gap: 15px; align-items: center;">
              <label class="radio-label">
                <input type="radio" v-model="form.obat_anti_sakit" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.obat_anti_sakit" value="Y" />
                Y
              </label>
              <input type="text" v-model="form.obat_anti_sakit_keterangan" class="input-rme" style="flex: 1;" placeholder="Keterangan" />
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Alergi obat :</label>
            <div style="display: flex; gap: 15px; align-items: center;">
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_obat" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_obat" value="Y" />
                Y
              </label>
              <input type="text" v-model="form.alergi_obat_keterangan" class="input-rme" style="flex: 1;" placeholder="Keterangan" />
            </div>
          </div>
          <div class="col-md-6">
            <label>Alergi makanan :</label>
            <div style="display: flex; gap: 15px; align-items: center;">
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_makanan" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_makanan" value="Y" />
                Y
              </label>
              <input type="text" v-model="form.alergi_makanan_keterangan" class="input-rme" style="flex: 1;" placeholder="Keterangan" />
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Alergi, lain-lain :</label>
            <div style="display: flex; gap: 15px; align-items: center;">
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_lainnya" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_lainnya" value="Y" />
                Y
              </label>
              <input type="text" v-model="form.alergi_lainnya_keterangan" class="input-rme" style="flex: 1;" placeholder="Keterangan" />
            </div>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">RIWAYAT KELUARGA (Apakah keluarga pernah mendapat permasalahan seperti di bawah ini?)</h6>
        <div class="row">
          <div class="col-md-6">
            <label>Perdarahan yang tidak normal :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_perdarahan" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_perdarahan" value="Y" />
                Y
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Diabetes :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_diabetes" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_diabetes" value="Y" />
                Y
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Permasalahan dalam pembiusan :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_pembiusan" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_pembiusan" value="Y" />
                Y
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Asma :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_asma" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_asma" value="Y" />
                Y
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Gangguan irama jantung :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_irama_jantung" value="T" />
                T
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_keluarga_irama_jantung" value="Y" />
                Y
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Lain-lain :</label>
            <input type="text" v-model="form.riwayat_keluarga_lainnya" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">RIWAYAT PENYAKIT PASIEN (Apakah pasien pernah menderita penyakit di bawah ini?)</h6>
        <div class="row">
          <div class="col-md-6">
            <label>Perdarahan yang tidak normal :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_perdarahan" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_perdarahan" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Mengorok :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_mengorok" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_mengorok" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Nyeri dada :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_nyeri_dada" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_nyeri_dada" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Hepatitis :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_hepatitis" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_hepatitis" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Sakit maag :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_maag" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_maag" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Hipertensi :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_hipertensi" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_hipertensi" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Anemia :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_anemia" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_anemia" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Diabetes :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_diabetes" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_diabetes" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Serangan jantung :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_serangan_jantung" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_serangan_jantung" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Pingsan :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_pingsan" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_pingsan" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Asma :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_asma" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_pasien_asma" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Lain-lain :</label>
            <input type="text" v-model="form.riwayat_pasien_lainnya" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">RIWAYAT TRANSFUSI & HIV</h6>
        <div class="row">
          <div class="col-md-6">
            <label>Apakah pasien pernah mendapatkan transfusi darah? :</label>
            <div style="display: flex; gap: 15px; align-items: center;">
              <label class="radio-label">
                <input type="radio" v-model="form.transfusi_darah" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.transfusi_darah" value="T" />
                T
              </label>
              <span style="margin: 0 10px;">Bila Ya, tahun berapa?</span>
              <input type="text" v-model="form.transfusi_darah_tahun" class="input-rme" style="width: 100px;" />
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Apakah pasien pernah diperiksa untuk diagnosis HIV? :</label>
            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
              <label class="radio-label">
                <input type="radio" v-model="form.pemeriksaan_hiv" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.pemeriksaan_hiv" value="T" />
                T
              </label>
              <span style="margin: 0 10px;">Bila Ya, tahun berapa?</span>
              <input type="text" v-model="form.pemeriksaan_hiv_tahun" class="input-rme" style="width: 100px;" />
              <span style="margin: 0 10px;">Hasil pemeriksaan HIV:</span>
              <label class="radio-label">
                <input type="radio" v-model="form.hasil_hiv" value="Positif" />
                Positif
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.hasil_hiv" value="Negatif" />
                Negatif
              </label>
            </div>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">ALAT BANTU</h6>
        <div class="row">
          <div class="col-md-12">
            <label>Apakah pasien memakai:</label>
            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.alat_bantu_dengar" />
                Alat bantu dengar
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.kacamata" />
                Kacamata
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.gigi_palsu" />
                Gigi palsu
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Lain-lain :</label>
            <input type="text" v-model="form.alat_bantu_lainnya" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">RIWAYAT OPERASI</h6>
        <div class="row">
          <div class="col-md-12">
            <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_operasi" value="Belum pernah operasi" />
                Belum pernah operasi
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.riwayat_operasi" value="Pernah Operasi" />
                Pernah Operasi
              </label>
              <span>tahun</span>
              <input type="text" v-model="form.riwayat_operasi_tahun" class="input-rme" style="width: 100px;" />
              <span>Jenis operasi</span>
              <input type="text" v-model="form.riwayat_operasi_jenis" class="input-rme" style="flex: 1;" />
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label>Jenis anestesi yang digunakan dan sebutkan keluhan / reaksi yang dialami :</label>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Anestesi lokal - keluhan/reaksi :</label>
            <textarea v-model="form.anestesi_lokal_reaksi" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Anestesi regional - keluhan/reaksi :</label>
            <textarea v-model="form.anestesi_regional_reaksi" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Anestesi umum/sedasi - keluhan/reaksi :</label>
            <textarea v-model="form.anestesi_umum_sedasi_reaksi" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">KHUSUS PASIEN HAMIL</h6>
        <div class="row">
          <div class="col-md-3">
            <label>Jumlah kehamilan :</label>
            <input type="number" v-model="form.jumlah_kehamilan" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Jumlah anak :</label>
            <input type="number" v-model="form.jumlah_anak" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Menstruasi terakhir :</label>
            <input type="date" v-model="form.menstruasi_terakhir" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Menyusui :</label>
            <div style="display: flex; gap: 15px; margin-top: 8px;">
              <label class="radio-label">
                <input type="radio" v-model="form.menyusui" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.menyusui" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-6">
            <label>Tanggal Pengisian :</label>
            <input type="date" v-model="form.tanggal_pengisian" class="input-rme" />
          </div>
        </div>

        <div class="signature-grid-2x2 mt-3">
          <div class="text-center">
            <label class="fw-bold mb-2 d-block">Tanda Tangan Pasien/Keluarga</label>
            <VueSignaturePad ref="ttd_pasien" :options="sigOption" class="signature-box-rme mx-auto" />
            <button @click="saveSign('ttd_pasien')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
            <input type="text" v-model="form.nama_pasien_ttd" class="input-rme mt-2" placeholder="Nama Lengkap" />
          </div>

          <div class="text-center">
            <label class="fw-bold mb-2 d-block">Tanda Tangan Perawat</label>
            <VueSignaturePad ref="ttd_perawat" :options="sigOption" class="signature-box-rme mx-auto" />
            <button @click="saveSign('ttd_perawat')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
            <input type="text" v-model="form.nama_perawat_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Perawat" />
          </div>
        </div>
      </div>

      <!-- ================= DIISI OLEH DOKTER ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">DIISI OLEH DOKTER</h5>
        
        <h6 class="fw-bold mt-3 mb-2">KAJIAN SISTEM</h6>
        <div class="row">
          <div class="col-md-6">
            <label>Hilangnya gigi :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_hilang_gigi" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_hilang_gigi" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Obesitas :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_obesitas" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_obesitas" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Masalah mobilisasi leher :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_mobilisasi_leher" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_mobilisasi_leher" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Sakit dada :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_sakit_dada" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_sakit_dada" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Leher pendek :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_leher_pendek" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_leher_pendek" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Stroke :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_stroke" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_stroke" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Denyut jantung tidak normal :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_denyut_jantung" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_denyut_jantung" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Kejang :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_kejang" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_kejang" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Sesak napas :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_sesak_napas" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_sesak_napas" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Sedang hamil :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_hamil" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kajian_hamil" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">PEMERIKSAAN FISIK</h6>
        <div class="row">
          <div class="col-md-2">
            <label>GCS :</label>
            <input type="text" v-model="form.gcs" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>Tekanan darah :</label>
            <input type="text" v-model="form.tekanan_darah" class="input-rme" placeholder="120/80" />
          </div>
          <div class="col-md-2">
            <label>Nadi :</label>
            <input type="number" v-model="form.nadi" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>Suhu :</label>
            <input type="number" step="0.1" v-model="form.suhu" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>RR :</label>
            <input type="number" v-model="form.rr" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-2">
            <label>Tinggi (cm) :</label>
            <input type="number" v-model="form.tinggi_badan" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>Berat (kg) :</label>
            <input type="number" v-model="form.berat_badan" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>BMI :</label>
            <input type="number" step="0.1" v-model="form.bmi" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>VAS :</label>
            <input type="text" v-model="form.vas" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
            <label>Buka mulut > 2 jari :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.buka_mulut" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.buka_mulut" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-4">
            <label>Gigi palsu :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.pemeriksaan_gigi_palsu" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.pemeriksaan_gigi_palsu" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
            <label>Jarak thyromental > 3 jari :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.jarak_thyromental" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.jarak_thyromental" value="T" />
                T
              </label>
            </div>
          </div>
          <div class="col-md-4">
            <label>Mallampati :</label>
            <div style="display: flex; gap: 10px;">
              <label class="radio-label">
                <input type="radio" v-model="form.mallampati" value="I" />
                I
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.mallampati" value="II" />
                II
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.mallampati" value="III" />
                III
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.mallampati" value="IV" />
                IV
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
            <label>Gerakan leher maksimal :</label>
            <div style="display: flex; gap: 15px;">
              <label class="radio-label">
                <input type="radio" v-model="form.gerakan_leher" value="Y" />
                Y
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.gerakan_leher" value="T" />
                T
              </label>
            </div>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">KEADAAN UMUM</h6>
        <div class="row">
          <div class="col-md-3">
            <label>Kepala :</label>
            <input type="text" v-model="form.kepala" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Sklera :</label>
            <input type="text" v-model="form.sklera" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Konjungtiva :</label>
            <input type="text" v-model="form.konjungtiva" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Leher :</label>
            <input type="text" v-model="form.leher" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Jantung :</label>
            <textarea v-model="form.jantung" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Paru-paru :</label>
            <textarea v-model="form.paru_paru" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Abdomen :</label>
            <textarea v-model="form.abdomen" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Ekstremitas :</label>
            <textarea v-model="form.ekstremitas" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">LABORATORIUM (bila tersedia)</h6>
        <div class="row">
          <div class="col-md-4">
            <label>Hb/Ht/Plt :</label>
            <input type="text" v-model="form.lab_hb_ht_plt" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>SGOT/SGPT :</label>
            <input type="text" v-model="form.lab_sgot_sgpt" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>PPT/APTT :</label>
            <input type="text" v-model="form.lab_ppt_aptt" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
            <label>Glukosa darah :</label>
            <input type="text" v-model="form.lab_glukosa" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>EKG (40 Tahun keatas) :</label>
            <input type="text" v-model="form.lab_ekg" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Rontgen dada :</label>
            <input type="text" v-model="form.lab_rontgen" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">DIAGNOSIS (ICD X)</h6>
        <div class="row">
          <div class="col-md-12">
            <label>1.</label>
            <input type="text" v-model="form.diagnosis_1" class="input-rme" />
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md-12">
            <label>2.</label>
            <input type="text" v-model="form.diagnosis_2" class="input-rme" />
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">ASA CLASSIFICATION</h6>
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <label class="radio-label">
            <input type="radio" v-model="form.asa_classification" value="ASA 1" />
            ASA 1 - Pasien normal yang sehat
          </label>
          <label class="radio-label">
            <input type="radio" v-model="form.asa_classification" value="ASA 2" />
            ASA 2 - Pasien dengan penyakit sistemik ringan
          </label>
          <label class="radio-label">
            <input type="radio" v-model="form.asa_classification" value="ASA 3" />
            ASA 3 - Pasien dengan penyakit sistemik berat
          </label>
          <label class="radio-label">
            <input type="radio" v-model="form.asa_classification" value="ASA 4" />
            ASA 4 - Pasien dengan penyakit sistemik berat yang mengancam nyawa
          </label>
        </div>

        <h6 class="fw-bold mt-4 mb-2">PERENCANAAN ANESTESI</h6>
        <div class="row">
          <div class="col-md-12">
            <label>Teknik Anestesi dan Sedasi:</label>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Sedasi :</label>
            <input type="text" v-model="form.teknik_sedasi" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>GA :</label>
            <input type="text" v-model="form.teknik_ga" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Regional :</label>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 8px;">
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_spinal" />
                Spinal
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_epidural" />
                Epidural
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_kaudal" />
                Kaudal
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_blok_perifer" />
                Blok Perifer
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label>Monitoring :</label>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 8px;">
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.monitoring_ekg" />
                EKG
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.monitoring_spo2" />
                SpO2
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.monitoring_nibp" />
                NIBP
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.monitoring_temp" />
                Temp
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-12">
            <label>Lain-lain :</label>
            <input type="text" v-model="form.monitoring_lainnya" class="input-rme" />
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label>Perawatan pasca anestesi :</label>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 8px;">
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.perawatan_rawat_inap" />
                Rawat inap
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.perawatan_rawat_jalan" />
                Rawat jalan
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.perawatan_icu" />
                ICU
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.perawatan_hdu" />
                HDU
              </label>
            </div>
          </div>
        </div>

        <h6 class="fw-bold mt-4 mb-2">PERSIAPAN PRA ANESTESI</h6>
        <div class="row">
          <div class="col-md-6">
            <label>Puasa mulai Jam :</label>
            <input type="time" v-model="form.puasa_jam" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Tanggal :</label>
            <input type="date" v-model="form.puasa_tanggal" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Rencana Operasi Jam :</label>
            <input type="time" v-model="form.rencana_operasi_jam" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Tanggal :</label>
            <input type="date" v-model="form.rencana_operasi_tanggal" class="input-rme" />
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label>CATATAN :</label>
            <textarea v-model="form.catatan" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="text-center mt-4">
          <label class="fw-bold mb-2 d-block">Dokter Anestesi</label>
          <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
          <button @click="saveSign('ttd_dokter')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
          <input type="text" v-model="form.nama_dokter_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Dokter Anestesi" />
        </div>
      </div>

      <!-- ================= BUTTON BOTTOM ================= -->
      <div class="action-footer">
        <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
          <span v-if="loadingSubmit">Menyimpan...</span>
          <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
        </button>

        <button @click="$emit('back')" class="btn-back">Kembali</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormPenilaianPraAnestesiSedasi",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
    isEditMode: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      loadingSubmit: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        
        // Sosial
        umur: "",
        jenis_kelamin_pasien: "L",
        menikah: "Y",
        pekerjaan: "",
        
        // Kebiasaan
        kebiasaan_merokok: "T",
        kebiasaan_merokok_jumlah: "",
        kebiasaan_kopi: "T",
        kebiasaan_kopi_jumlah: "",
        kebiasaan_alkohol: "T",
        kebiasaan_alkohol_jumlah: "",
        kebiasaan_olahraga: "T",
        kebiasaan_olahraga_jumlah: "",
        
        // Pengobatan
        obat_biasa_diminum: "",
        aspirin_plavix: "T",
        aspirin_plavix_keterangan: "",
        obat_anti_sakit: "T",
        obat_anti_sakit_keterangan: "",
        alergi_obat: "T",
        alergi_obat_keterangan: "",
        alergi_makanan: "T",
        alergi_makanan_keterangan: "",
        alergi_lainnya: "T",
        alergi_lainnya_keterangan: "",
        
        // Riwayat Keluarga
        riwayat_keluarga_perdarahan: "T",
        riwayat_keluarga_diabetes: "T",
        riwayat_keluarga_pembiusan: "T",
        riwayat_keluarga_asma: "T",
        riwayat_keluarga_irama_jantung: "T",
        riwayat_keluarga_lainnya: "",
        
        // Riwayat Pasien
        riwayat_pasien_perdarahan: "T",
        riwayat_pasien_mengorok: "T",
        riwayat_pasien_nyeri_dada: "T",
        riwayat_pasien_hepatitis: "T",
        riwayat_pasien_maag: "T",
        riwayat_pasien_hipertensi: "T",
        riwayat_pasien_anemia: "T",
        riwayat_pasien_diabetes: "T",
        riwayat_pasien_serangan_jantung: "T",
        riwayat_pasien_pingsan: "T",
        riwayat_pasien_asma: "T",
        riwayat_pasien_lainnya: "",
        
        // Transfusi & HIV
        transfusi_darah: "T",
        transfusi_darah_tahun: "",
        pemeriksaan_hiv: "T",
        pemeriksaan_hiv_tahun: "",
        hasil_hiv: "",
        
        // Alat Bantu
        alat_bantu_dengar: false,
        kacamata: false,
        gigi_palsu: false,
        alat_bantu_lainnya: "",
        
        // Riwayat Operasi
        riwayat_operasi: "Belum pernah operasi",
        riwayat_operasi_tahun: "",
        riwayat_operasi_jenis: "",
        anestesi_lokal_reaksi: "",
        anestesi_regional_reaksi: "",
        anestesi_umum_sedasi_reaksi: "",
        
        // Khusus Hamil
        jumlah_kehamilan: "",
        jumlah_anak: "",
        menstruasi_terakhir: "",
        menyusui: "T",
        
        // Tanggal & TTD Pasien
        tanggal_pengisian: "",
        ttd_pasien: "",
        nama_pasien_ttd: "",
        ttd_perawat: "",
        nama_perawat_ttd: "",
        
        // Kajian Sistem
        kajian_hilang_gigi: "Tidak",
        kajian_obesitas: "Tidak",
        kajian_mobilisasi_leher: "Tidak",
        kajian_sakit_dada: "Tidak",
        kajian_leher_pendek: "Tidak",
        kajian_stroke: "Tidak",
        kajian_denyut_jantung: "Tidak",
        kajian_kejang: "Tidak",
        kajian_sesak_napas: "Tidak",
        kajian_hamil: "Tidak",
        
        // Pemeriksaan Fisik
        gcs: "",
        tekanan_darah: "",
        nadi: "",
        suhu: "",
        rr: "",
        tinggi_badan: "",
        berat_badan: "",
        bmi: "",
        vas: "",
        buka_mulut: "Y",
        pemeriksaan_gigi_palsu: "T",
        jarak_thyromental: "Y",
        mallampati: "",
        gerakan_leher: "Y",
        
        // Keadaan Umum
        kepala: "",
        sklera: "",
        konjungtiva: "",
        leher: "",
        jantung: "",
        paru_paru: "",
        abdomen: "",
        ekstremitas: "",
        
        // Lab
        lab_hb_ht_plt: "",
        lab_sgot_sgpt: "",
        lab_ppt_aptt: "",
        lab_glukosa: "",
        lab_ekg: "",
        lab_rontgen: "",
        
        // Diagnosis
        diagnosis_1: "",
        diagnosis_2: "",
        asa_classification: "",
        
        // Perencanaan Anestesi
        teknik_sedasi: "",
        teknik_ga: "",
        regional_spinal: false,
        regional_epidural: false,
        regional_kaudal: false,
        regional_blok_perifer: false,
        
        monitoring_ekg: false,
        monitoring_spo2: false,
        monitoring_nibp: false,
        monitoring_temp: false,
        monitoring_lainnya: "",
        
        perawatan_rawat_inap: false,
        perawatan_rawat_jalan: false,
        perawatan_icu: false,
        perawatan_hdu: false,
        
        // Persiapan
        puasa_jam: "",
        puasa_tanggal: "",
        rencana_operasi_jam: "",
        rencana_operasi_tanggal: "",
        catatan: "",
        
        // TTD Dokter
        ttd_dokter: "",
        nama_dokter_ttd: "",
      },
    };
  },
  mounted() {
    if (this.isEditMode && this.editData) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },
  methods: {
    async loadDataForEdit() {
      try {
        if (this.editData.uuid) {
          const response = await axios.get(
            `/master/pasien/dokumen-penilaian-pra-anestesi-sedasi/${this.editData.uuid}`
          );

          if (response.data.status) {
            Object.keys(this.form).forEach((key) => {
              if (response.data.data[key] !== undefined) {
                this.form[key] = response.data.data[key];
              }
            });
          }
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal_pengisian = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { data } = pad.saveSignature();
      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key]);
        });

        const response = await axios.post(
          "/master/pasien/dokumen-penilaian-pra-anestesi-sedasi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
}

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

.input-rme {
  width: 100%;
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

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 5px;
  margin: 0;
  cursor: pointer;
}

.radio-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
}

.signature-grid-2x2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 30px 20px;
  margin-top: 20px;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}

.btn-save:hover {
  background: #1565c0;
}

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

.btn-save-form:hover {
  background: #0277bd;
}

.btn-save-form:disabled {
  background: #ccc;
  cursor: not-allowed;
}

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

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ccc;
  cursor: not-allowed;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 14px;
  color: #333;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-2, .col-md-3, .col-md-4, .col-md-6, .col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
  margin-bottom: 8px;
}

.col-md-2 { flex: 0 0 16.666667%; max-width: 16.666667%; }
.col-md-3 { flex: 0 0 25%; max-width: 25%; }
.col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
.col-md-6 { flex: 0 0 50%; max-width: 50%; }
.col-md-12 { flex: 0 0 100%; max-width: 100%; }

.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 16px; }
.mb-4 { margin-bottom: 24px; }
.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 16px; }
.mt-4 { margin-top: 24px; }

.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mx-auto { margin-left: auto; margin-right: auto; }
.d-block { display: block; }

@media (max-width: 768px) {
  .col-md-2, .col-md-3, .col-md-4, .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  
  .signature-grid-2x2 {
    grid-template-columns: 1fr;
  }
}
</style>