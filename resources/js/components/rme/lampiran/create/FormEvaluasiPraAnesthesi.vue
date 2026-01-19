<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">EVALUASI PRA ANESTHESI</h2>
        <h4 class="fw-semibold">RM 4.10/EPA/22</h4>
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
            <input type="text" v-model="form.nik" class="input-rme"/>
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
            <input type="text" v-model="form.nik" class="input-rme"/>
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

      <!-- ================= DATA EVALUASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Evaluasi</h5>
        
        <div class="row">
          <div class="col-md-4">
            <label>Ruangan :</label>
            <input type="text" v-model="form.ruangan" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jam :</label>
            <input type="time" v-model="form.jam" class="input-rme" />
          </div>
        </div>
      </div>


       <!-- ================= DIISI OLEH PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">DIISI OLEH PASIEN</h5>
        
        <div class="row">
          <div class="col-md-3">
            <label>Umur :</label>
            <input type="number" v-model="form.umur" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Jenis Kelamin :</label>
            <select v-model="form.jenis_kelamin_pasien" class="input-rme">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Menikah :</label>
            <select v-model="form.menikah" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Pekerjaan :</label>
            <input type="text" v-model="form.pekerjaan" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= KEBIASAAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Kebiasaan</h5>
        
        <div class="form-row-2x">
          <div class="col-md-3">
            <label>Merokok :</label>
            <select v-model="form.kebiasaan_merokok" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_merokok_jumlah" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Kopi/Teh/Soda :</label>
            <select v-model="form.kebiasaan_kopi" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_kopi_jumlah" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2x">
          <div class="col-md-3">
            <label>Alkohol :</label>
            <select v-model="form.kebiasaan_alkohol" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_alkohol_jumlah" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Olahraga Rutin :</label>
            <select v-model="form.kebiasaan_olahraga" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Sebanyak :</label>
            <input type="text" v-model="form.kebiasaan_olahraga_jumlah" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= PENGOBATAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pengobatan (Sebutkan dosis atau jumlah pil per hari)</h5>
        
        <div class="form-row-2">
          <div class="col-md-6">
            <label>Obat Resep :</label>
            <textarea v-model="form.obat_resep" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label>Obat Bebas (Vitamin, herbal) :</label>
            <textarea v-model="form.obat_bebas" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-4">
            <label>Penggunaan Aspirin Rutin :</label>
            <select v-model="form.aspirin_rutin" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-8">
            <label>Dosis dan Frekuensi :</label>
            <input type="text" v-model="form.aspirin_dosis" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-4">
            <label>Obat Anti Sakit :</label>
            <select v-model="form.obat_anti_sakit" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-8">
            <label>Dosis dan Frekuensi :</label>
            <input type="text" v-model="form.obat_anti_sakit_dosis" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-4">
            <label>Injeksi Steroid Tahun-tahun Terakhir :</label>
            <select v-model="form.injeksi_steroid" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-8">
            <label>Tanggal dan Lokasi Injeksi :</label>
            <input type="text" v-model="form.injeksi_steroid_detail" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-4">
            <label>Alergi Obat :</label>
            <select v-model="form.alergi_obat" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-8">
            <label>Daftar Obat dan Tipe Reaksi :</label>
            <textarea v-model="form.alergi_obat_detail" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-4">
            <label>Alergi Lateks :</label>
            <select v-model="form.alergi_lateks" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-4">
            <label>Alergi Plaster :</label>
            <select v-model="form.alergi_plaster" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-4">
            <label>Alergi Makanan :</label>
            <select v-model="form.alergi_makanan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= RIWAYAT KELUARGA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Riwayat Keluarga (Apakah keluarga mendapat permasalahan seperti di bawah ini?)</h5>
        
        <div class="form-row-2">
          <div class="col-md-6">
            <label>Perdarahan yang Tidak Normal :</label>
            <select v-model="form.riwayat_keluarga_perdarahan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Serangan Jantung :</label>
            <select v-model="form.riwayat_keluarga_jantung" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Pembekuan Darah Tidak Normal :</label>
            <select v-model="form.riwayat_keluarga_pembekuan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Hipertensi :</label>
            <select v-model="form.riwayat_keluarga_hipertensi" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Permasalahan dalam Pembiusan :</label>
            <select v-model="form.riwayat_keluarga_pembiusan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Tuberkulosis :</label>
            <select v-model="form.riwayat_keluarga_tb" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Operasi Jantung Koroner :</label>
            <select v-model="form.riwayat_keluarga_operasi_jantung" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Penyakit Berat Lainnya :</label>
            <select v-model="form.riwayat_keluarga_penyakit_berat" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Diabetes :</label>
            <select v-model="form.riwayat_keluarga_diabetes" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Jelaskan penyakit keluarga apabila dijawab "Ya" :</label>
            <textarea v-model="form.riwayat_keluarga_penjelasan" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= KOMUNIKASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Komunikasi</h5>
        
        <div class="row">
          <div class="col-md-3">
            <label>Bahasa :</label>
            <select v-model="form.bahasa" class="input-rme">
              <option value="Indonesia">Bahasa Indonesia</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Bahasa Lainnya :</label>
            <input type="text" v-model="form.bahasa_lainnya" class="input-rme" />
          </div>
          <div class="col-md-2">
            <label>Gangguan Penglihatan/Buta :</label>
            <select v-model="form.gangguan_penglihatan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>Gangguan Pendengaran/Tuli :</label>
            <select v-model="form.gangguan_pendengaran" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>Gangguan Bicara :</label>
            <select v-model="form.gangguan_bicara" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= RIWAYAT PENYAKIT PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Riwayat Penyakit Pasien (Apakah pasien pernah menderita penyakit di bawah ini?)</h5>
        
        <div class="form-row-2">
          <div class="col-md-6">
            <label>Perdarahan yang Tidak Normal :</label>
            <select v-model="form.riwayat_pasien_perdarahan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Serangan Jantung/Nyeri Dada :</label>
            <select v-model="form.riwayat_pasien_jantung" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Pembekuan Darah Tidak Normal :</label>
            <select v-model="form.riwayat_pasien_pembekuan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Hepatitis/Sakit Kuning :</label>
            <select v-model="form.riwayat_pasien_hepatitis" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Sakit Maag :</label>
            <select v-model="form.riwayat_pasien_maag" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Sumbatan Jalan Nafas saat Tidur/Mengorok :</label>
            <select v-model="form.riwayat_pasien_sumbatan_nafas" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Anemia :</label>
            <select v-model="form.riwayat_pasien_anemia" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Penyakit Berat Lainnya :</label>
            <select v-model="form.riwayat_pasien_penyakit_berat" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Sesak Napas :</label>
            <select v-model="form.riwayat_pasien_sesak" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Asma :</label>
            <select v-model="form.riwayat_pasien_asma" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Diabetes :</label>
            <select v-model="form.riwayat_pasien_diabetes" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Pingsan :</label>
            <select v-model="form.riwayat_pasien_pingsan" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Jelaskan penyakit yang dijawab "Ya" :</label>
            <textarea v-model="form.riwayat_pasien_penjelasan" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= RIWAYAT TRANSFUSI & HIV ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Riwayat Transfusi & HIV</h5>
        
        <div class="form-row-2">
          <div class="col-md-6">
            <label>Apakah pasien pernah mendapatkan transfusi darah? :</label>
            <select v-model="form.transfusi_darah" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Bila ya, tahun berapa? :</label>
            <input type="text" v-model="form.transfusi_darah_tahun" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Apakah pasien pernah diperiksa untuk diagnosis HIV? :</label>
            <select v-model="form.pemeriksaan_hiv" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Bila ya, tahun berapa? :</label>
            <input type="text" v-model="form.pemeriksaan_hiv_tahun" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Hasil Pemeriksaan HIV :</label>
            <select v-model="form.hasil_hiv" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Positif">Positif</option>
              <option value="Negatif">Negatif</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= ALAT BANTU ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Apakah Pasien Memakai:</h5>
        
        <div class="form-row-2">
          <div class="col-md-3">
            <label>Lensa Kontak :</label>
            <select v-model="form.lensa_kontak" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Kacamata :</label>
            <select v-model="form.kacamata" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Alat Bantu Dengar :</label>
            <select v-model="form.alat_bantu_dengar" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Gigi Palsu :</label>
            <select v-model="form.gigi_palsu" class="input-rme">
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= RIWAYAT OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Riwayat Operasi</h5>
        
        <div class="form-row-2">
          <div class="col-md-12">
            <label>Riwayat operasi, tahun dan jenis operasi :</label>
            <textarea v-model="form.riwayat_operasi" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Jenis anestesi yang digunakan dan sebutkan komplikasi/reaksi yang dialami :</label>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Anestesia Lokal - Komplikasi/Reaksi :</label>
            <textarea v-model="form.anestesi_lokal_komplikasi" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Anestesia Regional - Komplikasi/Reaksi :</label>
            <textarea v-model="form.anestesi_regional_komplikasi" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Anestesia Umum - Komplikasi/Reaksi :</label>
            <textarea v-model="form.anestesi_umum_komplikasi" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-6">
            <label>Tanggal terakhir kali periksa kesehatan ke dokter :</label>
            <input type="date" v-model="form.tanggal_periksa_terakhir" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Dimana :</label>
            <input type="text" v-model="form.tempat_periksa_terakhir" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div class="col-md-12">
            <label>Untuk penyakit gangguan apa :</label>
            <textarea v-model="form.gangguan_periksa_terakhir" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= KHUSUS PASIEN PEREMPUAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Khusus Pasien Perempuan</h5>

        <div class="form-row-2">
          <div class="col-md-3">
            <label>Jumlah Kehamilan :</label>
            <input type="number" v-model="form.jumlah_kehamilan" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Jumlah Anak :</label>
            <input type="number" v-model="form.jumlah_anak" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Menstruasi Terakhir :</label>
            <input type="date" v-model="form.menstruasi_terakhir" class="input-rme" />
<!-- 
            <parameter name="command">update</parameter>
<parameter name="id">form_evaluasi_pra_anesthesi</parameter>

<parameter name="new_str"><input type="date" v-model="form.menstruasi_terakhir" class="input-rme" /> </parameter> -->
</div>

<div class="col-md-3">
<label>Menyusui :</label>
<select v-model="form.menyusui" class="input-rme">
<option value="Y">Ya</option>
<option value="T">Tidak</option>
</select>
</div>
</div>
</div>

<!-- ================= DIISI OLEH DOKTER - KAJIAN SISTEM ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">DIISI OLEH DOKTER - Kajian Sistem</h5>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Hilangnya Gigi :</label>
        <select v-model="form.kajian_hilang_gigi" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Sakit Dada :</label>
        <select v-model="form.kajian_sakit_dada" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Masalah Mobilisasi Leher :</label>
        <select v-model="form.kajian_mobilisasi_leher" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Denyut Jantung Tidak Normal :</label>
        <select v-model="form.kajian_denyut_jantung" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Leher Pendek :</label>
        <select v-model="form.kajian_leher_pendek" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Muntah :</label>
        <select v-model="form.kajian_muntah" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Batuk :</label>
        <select v-model="form.kajian_batuk" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Susah Kencing :</label>
        <select v-model="form.kajian_susah_kencing" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Sesak Nafas :</label>
        <select v-model="form.kajian_sesak_nafas" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Kejang :</label>
        <select v-model="form.kajian_kejang" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Baru saja menderita infeksi Saluran Nafas Atas :</label>
        <select v-model="form.kajian_infeksi_nafas" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Sedang Hamil :</label>
        <select v-model="form.kajian_hamil" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Periode Menstruasi Tidak Normal :</label>
        <select v-model="form.kajian_menstruasi_abnormal" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Pingsan :</label>
        <select v-model="form.kajian_pingsan" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Stroke :</label>
        <select v-model="form.kajian_stroke" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Obesitas :</label>
        <select v-model="form.kajian_obesitas" class="input-rme">
          <option value="Y">Ya</option>
          <option value="T">Tidak</option>
        </select>
      </div>
    </div>

    <div class="form-row-2 mt-3">
      <div class="col-md-12">
        <label>Keterangan :</label>
        <textarea v-model="form.kajian_keterangan" class="textarea-rme" rows="3"></textarea>
      </div>
    </div>
  </div>

  <!-- ================= KEADAAN UMUM ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Keadaan Umum</h5>

    <div class="form-row-2">
      <div class="col-md-3">
        <label>Kesadaran :</label>
        <input type="text" v-model="form.kesadaran" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Visus :</label>
        <input type="text" v-model="form.visus" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Faring :</label>
        <input type="text" v-model="form.faring" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Gigi Palsu :</label>
        <input type="text" v-model="form.keadaan_gigi_palsu" class="input-rme" />
      </div>
    </div>
  </div>

  <!-- ================= PEMERIKSAAN FISIK ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Pemeriksaan Fisik</h5>

    <div class="form-row-2">
      <div class="col-md-2">
        <label>Tinggi (cm) :</label>
        <input type="number" v-model="form.tinggi_badan" class="input-rme" />
      </div>
      <div class="col-md-2">
        <label>Berat (kg) :</label>
        <input type="number" v-model="form.berat_badan" class="input-rme" />
      </div>
      <div class="col-md-2">
        <label>TD (mmHg) :</label>
        <input type="text" v-model="form.tekanan_darah" class="input-rme" placeholder="120/80" />
      </div>
      <div class="col-md-2">
        <label>Nadi (x/menit) :</label>
        <input type="number" v-model="form.nadi" class="input-rme" />
      </div>
      <div class="col-md-2">
        <label>Suhu (°C) :</label>
        <input type="number" step="0.1" v-model="form.suhu" class="input-rme" />
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Paru-paru :</label>
        <textarea v-model="form.pemeriksaan_paru" class="textarea-rme" rows="3"></textarea>
      </div>
      <div class="col-md-6">
        <label>Jantung :</label>
        <textarea v-model="form.pemeriksaan_jantung" class="textarea-rme" rows="3"></textarea>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Abdomen :</label>
        <textarea v-model="form.pemeriksaan_abdomen" class="textarea-rme" rows="3"></textarea>
      </div>
      <div class="col-md-6">
        <label>Ekstremitas :</label>
        <textarea v-model="form.pemeriksaan_ekstremitas" class="textarea-rme" rows="3"></textarea>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-12">
        <label>Neurologi (bila dapat diperiksa) :</label>
        <textarea v-model="form.pemeriksaan_neurologi" class="textarea-rme" rows="2"></textarea>
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-12">
        <label>Keterangan :</label>
        <textarea v-model="form.pemeriksaan_fisik_keterangan" class="textarea-rme" rows="2"></textarea>
      </div>
    </div>
  </div>

  <!-- ================= LABORATORIUM ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Laboratorium (Bila Tersedia)</h5>

    <div class="form-row-2">
      <div class="col-md-3">
        <label>Hb/Ht :</label>
        <input type="text" v-model="form.lab_hb_ht" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Rontgen Dada :</label>
        <input type="text" v-model="form.lab_rontgen" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>PT/APTT :</label>
        <input type="text" v-model="form.lab_pt_aptt" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>EKG :</label>
        <input type="text" v-model="form.lab_ekg" class="input-rme" />
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-3">
        <label>Tes Kehamilan :</label>
        <input type="text" v-model="form.lab_tes_kehamilan" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Na/Cl :</label>
        <input type="text" v-model="form.lab_na_cl" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Kalium :</label>
        <input type="text" v-model="form.lab_kalium" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>CO2 :</label>
        <input type="text" v-model="form.lab_co2" class="input-rme" />
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-3">
        <label>Ureum :</label>
        <input type="text" v-model="form.lab_ureum" class="input-rme" />
      </div>
      <div class="col-md-3">
        <label>Kreatinin :</label>
        <input type="text" v-model="form.lab_kreatinin" class="input-rme" />
      </div>
      <div class="col-md-6">
        <label>Lain-lain :</label>
        <input type="text" v-model="form.lab_lainnya" class="input-rme" />
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-12">
        <label>Keterangan :</label>
        <textarea v-model="form.lab_keterangan" class="textarea-rme" rows="2"></textarea>
      </div>
    </div>
  </div>

  <!-- ================= DIAGNOSIS ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Diagnosis</h5>
    
    <div class="form-row-2">
      <div class="col-md-12">
        <textarea v-model="form.diagnosis" class="textarea-rme" rows="3"></textarea>
      </div>
    </div>
  </div>

  <!-- ================= KLASIFIKASI ASA ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Klasifikasi Berdasarkan ASA</h5>
    
    <div style="display: flex; flex-direction: column; gap: 10px;">
      <label class="radio-label">
        <input type="radio" v-model="form.klasifikasi_asa" value="ASA 1" />
        ASA 1 - Pasien normal yang sehat
      </label>
      <label class="radio-label">
        <input type="radio" v-model="form.klasifikasi_asa" value="ASA 2" />
        ASA 2 - Pasien dengan penyakit sistemik ringan
      </label>
      <label class="radio-label">
        <input type="radio" v-model="form.klasifikasi_asa" value="ASA 3" />
        ASA 3 - Pasien dengan penyakit sistemik berat
      </label>
      <label class="radio-label">
        <input type="radio" v-model="form.klasifikasi_asa" value="ASA 4" />
        ASA 4 - Pasien dengan penyakit sistemik berat yang mengancam nyawa
      </label>
    </div>
  </div>

  <!-- ================= REKOMENDASI TINDAKAN ANESTESI ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Rekomendasi Tindakan Anestesi yang Dipilih</h5>
    
    <div class="mb-3">
      <strong>Anestesi Umum:</strong>
      <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 10px;">
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.anestesi_umum_intravena" />
          Intravena
        </label>
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.anestesi_umum_sungkup" />
          Sungkup Muka
        </label>
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.anestesi_umum_lma" />
          Laringeal Mask Airway
        </label>
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.anestesi_umum_pipa" />
          Pipa Endotrakeal Tube
        </label>
      </div>
    </div>

    <div class="mb-3">
      <strong>Regional Anestesi:</strong>
      <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 10px;">
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.regional_spinal" />
          Spinal Anestesi
        </label>
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.regional_epidural" />
          Blok Epidural
        </label>
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.regional_kombinasi" />
          Kombinasi Spinal Epidural
        </label>
        <label class="checkbox-item">
          <input type="checkbox" v-model="form.regional_peripheral" />
          Peripheral Nerve Block
        </label>
      </div>
    </div>

    <div class="mb-3">
      <label class="checkbox-item">
        <input type="checkbox" v-model="form.anestesi_umum_regional" />
        <strong>Anestesi Umum + Regional Anestesi</strong>
      </label>
    </div>
  </div>

  <!-- ================= JADWAL OPERASI ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Jadwal Operasi</h5>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Puasa mulai Jam :</label>
        <input type="time" v-model="form.puasa_jam" class="input-rme" />
      </div>
      <div class="col-md-6">
        <label>Tanggal :</label>
        <input type="date" v-model="form.puasa_tanggal" class="input-rme" />
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Rencana tiba di OK Jam :</label>
        <input type="time" v-model="form.rencana_tiba_jam" class="input-rme" />
      </div>
      <div class="col-md-6">
        <label>Tanggal :</label>
        <input type="date" v-model="form.rencana_tiba_tanggal" class="input-rme" />
      </div>
    </div>

    <div class="form-row-2">
      <div class="col-md-6">
        <label>Rencana Operasi Jam :</label>
        <input type="time" v-model="form.rencana_operasi_jam" class="input-rme" />
      </div>
      <div class="col-md-6">
        <label>Tanggal :</label>
        <input type="date" v-model="form.rencana_operasi_tanggal" class="input-rme" />
      </div>
    </div>
  </div>

  <!-- ================= TANDA TANGAN DOKTER ================= -->
  <div class="box-rme mb-4">
    <h5 class="section-title-rme">Tanda Tangan Dokter</h5>
    
    <div class="text-center">
      <label class="fw-bold mb-2 d-block">Dokter Anestesi</label>
      <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
      <button @click="saveSign('ttd_dokter')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
      <input type="text" v-model="form.nama_dokter_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Dokter" />
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
  name: "FormEvaluasiPraAnesthesi",
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
        
        tanggal_pelaksanaan: "",
        keterangan: "",
        
          // Data Evaluasi
        ruangan: "",
        tanggal: "",
        jam: "",
        
        // Diisi Oleh Pasien
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
        obat_resep: "",
        obat_bebas: "",
        aspirin_rutin: "T",
        aspirin_dosis: "",
        obat_anti_sakit: "T",
        obat_anti_sakit_dosis: "",
        injeksi_steroid: "T",
        injeksi_steroid_detail: "",
        alergi_obat: "T",
        alergi_obat_detail: "",
        alergi_lateks: "T",
        alergi_plaster: "T",
        alergi_makanan: "T",
        
        // Riwayat Keluarga
        riwayat_keluarga_perdarahan: "T",
        riwayat_keluarga_jantung: "T",
        riwayat_keluarga_pembekuan: "T",
        riwayat_keluarga_hipertensi: "T",
        riwayat_keluarga_pembiusan: "T",
        riwayat_keluarga_tb: "T",
        riwayat_keluarga_operasi_jantung: "T",
        riwayat_keluarga_penyakit_berat: "T",
        riwayat_keluarga_diabetes: "T",
        riwayat_keluarga_penjelasan: "",
        
        // Komunikasi
        bahasa: "Indonesia",
        bahasa_lainnya: "",
        gangguan_penglihatan: "T",
        gangguan_pendengaran: "T",
        gangguan_bicara: "T",
        
        // Riwayat Penyakit Pasien
        riwayat_pasien_perdarahan: "T",
        riwayat_pasien_jantung: "T",
        riwayat_pasien_pembekuan: "T",
        riwayat_pasien_hepatitis: "T",
        riwayat_pasien_maag: "T",
        riwayat_pasien_sumbatan_nafas: "T",
        riwayat_pasien_anemia: "T",
        riwayat_pasien_penyakit_berat: "T",
        riwayat_pasien_sesak: "T",
        riwayat_pasien_asma: "T",
        riwayat_pasien_diabetes: "T",
        riwayat_pasien_pingsan: "T",
        riwayat_pasien_penjelasan: "",
        
        // Transfusi & HIV
        transfusi_darah: "T",
        transfusi_darah_tahun: "",
        pemeriksaan_hiv: "T",
        pemeriksaan_hiv_tahun: "",
        hasil_hiv: "",
        
        // Alat Bantu
        lensa_kontak: "T",
        kacamata: "T",
        alat_bantu_dengar: "T",
        gigi_palsu: "T",
        
        // Riwayat Operasi
        riwayat_operasi: "",
        anestesi_lokal_komplikasi: "",
        anestesi_regional_komplikasi: "",
        anestesi_umum_komplikasi: "",
        tanggal_periksa_terakhir: "",
        tempat_periksa_terakhir: "",
        gangguan_periksa_terakhir: "",
        
        // Khusus Perempuan
        jumlah_kehamilan: "",
        jumlah_anak: "",
        menstruasi_terakhir: "",
        menyusui: "T",
        
        // Kajian Sistem
        kajian_hilang_gigi: "T",
        kajian_sakit_dada: "T",
        kajian_mobilisasi_leher: "T",
        kajian_denyut_jantung: "T",
        kajian_leher_pendek: "T",
        kajian_muntah: "T",
        kajian_batuk: "T",
        kajian_susah_kencing: "T",
        kajian_sesak_nafas: "T",
        kajian_kejang: "T",
        kajian_infeksi_nafas: "T",
        kajian_hamil: "T",
        kajian_menstruasi_abnormal: "T",
        kajian_pingsan: "T",
        kajian_stroke: "T",
        kajian_obesitas: "T",
        kajian_keterangan: "",
        
        // Keadaan Umum
        kesadaran: "",
        visus: "",
        faring: "",
        keadaan_gigi_palsu: "",
        
        // Pemeriksaan Fisik
        tinggi_badan: "",
        berat_badan: "",
        tekanan_darah: "",
        nadi: "",
        suhu: "",
        pemeriksaan_paru: "",
        pemeriksaan_jantung: "",
        pemeriksaan_abdomen: "",
        pemeriksaan_ekstremitas: "",
        pemeriksaan_neurologi: "",
        pemeriksaan_fisik_keterangan: "",
        
        // Laboratorium
        lab_hb_ht: "",
        lab_rontgen: "",
        lab_pt_aptt: "",
        lab_ekg: "",
        lab_tes_kehamilan: "",
        lab_na_cl: "",
        lab_kalium: "",
        lab_co2: "",
        lab_ureum: "",
        lab_kreatinin: "",
        lab_lainnya: "",
        lab_keterangan: "",
        
        // Diagnosis
        diagnosis: "",
        klasifikasi_asa: "",
        
        // Rekomendasi Anestesi
        anestesi_umum_intravena: false,
        anestesi_umum_sungkup: false,
        anestesi_umum_lma: false,
        anestesi_umum_pipa: false,
        regional_spinal: false,
        regional_epidural: false,
        regional_kombinasi: false,
        regional_peripheral: false,
        anestesi_umum_regional: false,
        
        // Jadwal
        puasa_jam: "",
        puasa_tanggal: "",
        rencana_tiba_jam: "",
        rencana_tiba_tanggal: "",
        rencana_operasi_jam: "",
        rencana_operasi_tanggal: "",
        
        // TTD
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
            `/master/pasien/dokumen-evaluasi-pra-anesthesi/${this.editData.uuid}`
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
      this.form.tanggal_pelaksanaan = today.toISOString().split("T")[0];

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
          "/master/pasien/dokumen-evaluasi-pra-anesthesi/",
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

.alert-info {
  background: #e3f2fd;
  border-left: 4px solid #2196f3;
  padding: 12px 16px;
  border-radius: 4px;
  margin-bottom: 15px;
}

.alert-warning {
  background: #fff3e0;
  border-left: 4px solid #ff9800;
  padding: 12px 16px;
  border-radius: 4px;
  margin-bottom: 15px;
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

.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
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

.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 16px; }
.mb-4 { margin-bottom: 24px; }
.mt-2 { margin-top: 8px; }

.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mx-auto { margin-left: auto; margin-right: auto; }
.d-block { display: block; }

@media (max-width: 768px) {
  .form-row-3-3,
  .form-row-2 {
    flex-direction: column;
  }
}
</style>