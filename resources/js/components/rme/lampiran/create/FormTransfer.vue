<template>
    <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>
        </div>
        </
 <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">TRANSFER PASIEN</h2>
        <h4 class="fw-semibold">RM 2.6/TP/22</h4>
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

      <!-- ================= DATA TRANSFER ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Transfer</h5>
        
        <div class="form-row-2">
          <div>
            <label>Tanggal Masuk :</label>
            <input type="date" v-model="form.tanggal_masuk" class="input-rme" />
          </div>
          <div>
            <label>Tanggal Pindah :</label>
            <input type="date" v-model="form.tanggal_pindah" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Asal Ruangan :</label>
            <input type="text" v-model="form.asal_ruangan" class="input-rme" />
          </div>
          <div>
            <label>Ruangan Selanjutnya :</label>
            <input type="text" v-model="form.ruangan_selanjutnya" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Dokter Yang Merawat :</label>
            <input type="text" v-model="form.dokter_yang_merawat" class="input-rme" />
          </div>
          <div>
            <label>Dokter Penanggung Jawab (DPJP) :</label>
            <input type="text" v-model="form.dpjp" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa</h5>
        
        <div class="form-row-2">
          <div>
            <label>Diagnosa Utama :</label>
            <textarea v-model="form.diagnosa_utama" class="textarea-rme" rows="3"></textarea>
          </div>
          <div>
            <label>Perlu Menjadi Perhatian :</label>
            <textarea v-model="form.perlu_perhatian" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Alergi :</label>
            <input type="text" v-model="form.alergi" class="input-rme" placeholder="Sebutkan..." />
          </div>
          <div>
            <label>
              <input type="checkbox" v-model="form.mrsa" />
              MRSA
            </label>
          </div>
        </div>

        <div>
          <label class="fw-bold mb-2">Diagnosa Sekunder :</label>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <div v-for="n in 5" :key="n">
              <label>{{ n }}.</label>
              <input type="text" v-model="form['diagnosa_sekunder_' + n]" class="input-rme" />
            </div>
          </div>
        </div>
      </div>

      <!-- ================= ALASAN PERPINDAHAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Alasan Perpindahan Pasien</h5>
        
        <div class="form-row-2">
          <div>
            <label>1. Kondisi Pasien :</label>
            <select v-model="form.kondisi_pasien" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="memburuk">Memburuk</option>
              <option value="stabil">Stabil</option>
              <option value="tidak_ada_perubahan">Tidak Ada Perubahan</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>2. Fasilitas :</label>
            <select v-model="form.alasan_fasilitas" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="kurang_memadai">Kurang Memadai</option>
              <option value="membutuhkan_peralatan_lebih_baik">Membutuhkan Peralatan yang Lebih Baik</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>3. Tenaga :</label>
            <select v-model="form.alasan_tenaga" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="membutuhkan_tenaga_lebih_ahli">Membutuhkan Tenaga yang Lebih Ahli</option>
              <option value="jumlah_tenaga_kurang">Jumlah Tenaga Kurang</option>
            </select>
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>4. Lain-lain :</label>
            <input type="text" v-model="form.alasan_lainnya" class="input-rme" placeholder="Sebutkan..." />
          </div>
        </div>
      </div>

      <!-- ================= METODE PERPINDAHAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Metode Perpindahan Pasien</h5>
        
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.metode_kursi_roda" />
            Kursi Roda
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.metode_tempat_tidur" />
            Tempat Tidur
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.metode_brankar" />
            Brankar / Stretcher
          </label>
        </div>
      </div>

      <!-- ================= PERSETUJUAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Persetujuan</h5>
        
        <div class="mb-3">
          <label>
            <input type="checkbox" v-model="form.pasien_keluarga_setuju" />
            Pasien / Keluarga mengetahui dan menyetujui mengenai alasan perpindahan
          </label>
        </div>

        <div class="form-row-2">
          <div>
            <label>Nama Pemberi Persetujuan (Keluarga) :</label>
            <input type="text" v-model="form.nama_pemberi_persetujuan" class="input-rme" placeholder="Jika pemberi persetujuan adalah keluarga" />
          </div>
          <div>
            <label>Hubungan dengan Pasien :</label>
            <input type="text" v-model="form.hubungan_pemberi_persetujuan" class="input-rme" />
          </div>
        </div>

        <!-- TTD Keluarga -->
        <div class="text-center mt-3">
          <label class="fw-bold mb-2">Tanda Tangan Keluarga</label>
          <VueSignaturePad ref="ttd_keluarga" :options="sigOption" class="signature-box-rme mx-auto" />
          <button @click="saveSign('ttd_keluarga')" class="btn-save mt-2">Simpan ✔</button>
          <input type="text" v-model="form.nama_keluarga_ttd" class="input-rme mt-2" placeholder="Nama Lengkap" />
        </div>
      </div>

      <!-- ================= PERALATAN YANG MENYERTAI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Peralatan yang Menyertai Pasien Saat Pindah</h5>
        
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_portable" />
            Portable
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_alat_penghisap" />
            Alat Penghisap
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_bagging" />
            Bagging
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_ngt" />
            NGT
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_ventilator" />
            Ventilator
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_kateter_urin" />
            Kateter Urin
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.peralatan_pompa_infus" />
            Pompa Infus
          </label>
        </div>
      </div>

      <!-- ================= KEADAAN PASIEN SAAT PINDAH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Keadaan Pasien Saat Pindah</h5>
        
        <div class="form-row-2">
          <div>
            <label>Keadaan Umum :</label>
            <input type="text" v-model="form.keadaan_umum" class="input-rme" />
          </div>
          <div>
            <label>Kesadaran :</label>
            <input type="text" v-model="form.kesadaran" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Status Nyeri :</label>
            <input type="text" v-model="form.status_nyeri" class="input-rme" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <label>TD (mmHg) :</label>
            <input type="text" v-model="form.td" class="input-rme" placeholder="120/80" />
          </div>
          <div class="col-md-3">
            <label>Nadi (x/menit) :</label>
            <input type="number" v-model="form.nadi" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Suhu (°C) :</label>
            <input type="number" step="0.1" v-model="form.suhu" class="input-rme" />
          </div>
          <div class="col-md-3">
            <label>Pernafasan (x/menit) :</label>
            <input type="number" v-model="form.pernafasan" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= PENDAMPING PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pendamping Pasien Saat Pindah</h5>
        
        <div class="form-row-2">
          <div>
            <label>Nama Petugas :</label>
            <input type="text" v-model="form.nama_pendamping" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= DISABILITAS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Disabilitas</h5>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_amputasi" />
            Amputasi
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_kontraktur" />
            Kontraktur
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_paralisis" />
            Paralisis
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_ulkus_dikubitus" />
            Ulkus Dikubitus
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_gangguan_mental" />
            Gangguan Mental
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_bicara" />
            Bicara
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_pendengaran" />
            Pendengaran
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_penglihatan" />
            Penglihatan
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.disabilitas_sensasi" />
            Sensasi
          </label>
        </div>
      </div>

      <!-- ================= INKONTINENSIA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Inkontinensia</h5>
        
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.inkontinensia_urin" />
            Urin
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.inkontinensia_saliva" />
            Saliva
          </label>
          <label class="checkbox-item">
            <input type="checkbox" v-model="form.inkontinensia_alvi" />
            Alvi
          </label>
        </div>
      </div>

      <!-- ================= POTENSI REHABILITASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Potensial untuk Dilakukan Rehabilitasi</h5>
        
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
          <label class="radio-label">
            <input type="radio" v-model="form.potensial_rehabilitasi" value="baik" />
            Baik
          </label>
          <label class="radio-label">
            <input type="radio" v-model="form.potensial_rehabilitasi" value="sedang" />
            Sedang
          </label>
          <label class="radio-label">
            <input type="radio" v-model="form.potensial_rehabilitasi" value="buruk" />
            Buruk
          </label>
        </div>
      </div>

      <!-- ================= PEMERIKSAAN FISIK ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pemeriksaan Fisik</h5>
        
        <div class="form-row-2">
          <div>
            <label>Status Generalis (temuan yang signifikan) :</label>
            <textarea v-model="form.status_generalis" class="textarea-rme" rows="4"></textarea>
          </div>
          <div>
            <label>Status Lokalis (temuan yang signifikan) :</label>
            <textarea v-model="form.status_lokalis" class="textarea-rme" rows="4"></textarea>
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Pemeriksaan Penunjang / Diagnostik (EKG, Lab, dll) :</label>
            <textarea v-model="form.pemeriksaan_penunjang" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= STATUS KEMANDIRIAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Status Kemandirian</h5>
        
        <table class="kemandirian-table">
          <thead>
            <tr>
              <th>Aktivitas</th>
              <th>Mandiri</th>
              <th>Butuh Bantuan</th>
              <th>Tidak Mampu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4" class="header-row">Aktivitas di Tempat Tidur</td>
            </tr>
            <tr>
              <td>Berguling</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_berguling" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_berguling" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_berguling" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Duduk</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_duduk" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_duduk" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_duduk" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td colspan="4" class="header-row">Hygiene Pribadi</td>
            </tr>
            <tr>
              <td>Wajah, rambut, tangan</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_wajah" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_wajah" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_wajah" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Batang tubuh & perineum</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_tubuh" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_tubuh" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_tubuh" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Ekstremitas bawah</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_ekstremitas" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_ekstremitas" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_ekstremitas" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Mulut</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_mulut" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_mulut" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_hygiene_mulut" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td colspan="4" class="header-row">Berpakaian</td>
            </tr>
            <tr>
              <td>Ekstremitas atas</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_atas" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_atas" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_atas" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Batang tubuh</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_tubuh" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_tubuh" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_tubuh" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Ekstremitas bawah</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_bawah" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_bawah" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_pakaian_bawah" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td colspan="4" class="header-row">Cara Memberi Makan</td>
            </tr>
            <tr>
              <td>Makan</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_makan" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_makan" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_makan" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td colspan="4" class="header-row">Pergerakan</td>
            </tr>
            <tr>
              <td>Jalan kaki</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_jalan" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_jalan" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_jalan" value="tidak_mampu" /></td>
            </tr>
            <tr>
              <td>Kursi roda</td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_kursi_roda" value="mandiri" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_kursi_roda" value="butuh_bantuan" /></td>
              <td class="text-center"><input type="radio" v-model="form.kemandirian_kursi_roda" value="tidak_mampu" /></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ================= INTERVENSI & TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Intervensi / Tindakan yang Sudah Dilakukan</h5>
        
        <div class="form-row-2">
          <div>
            <label>Intervensi / Tindakan :</label>
            <textarea v-model="form.intervensi_tindakan" class="textarea-rme" rows="3"></textarea>
          </div>
          <div>
            <label>Diet :</label>
            <textarea v-model="form.diet" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= RENCANA PERAWATAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Rencana Perawatan Selanjutnya</h5>
        
        <div class="form-row-2">
          <div>
            <textarea v-model="form.rencana_perawatan" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>


      <!-- ================= TERAPI SAAT PINDAH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Terapi Saat Pindah</h5>
        
        <button @click="addObat" class="btn-save mb-3">+ Tambah Obat</button>
        
        <div v-for="(obat, index) in form.terapi_obat" :key="index" class="obat-item">
          <div class="row">
            <div class="col-md-2">
              <label>Nama Obat :</label>
              <input type="text" v-model="obat.nama_obat" class="input-rme" />
            </div>
            <div class="col-md-2">
              <label>Jumlah :</label>
              <input type="text" v-model="obat.jumlah" class="input-rme" />
            </div>
            <div class="col-md-2">
              <label>Dosis :</label>
              <input type="text" v-model="obat.dosis" class="input-rme" />
            </div>
            <div class="col-md-2">
              <label>Frekuensi :</label>
              <input type="text" v-model="obat.frekuensi" class="input-rme" />
            </div>
            <div class="col-md-3">
              <label>Cara Pemberian :</label>
              <input type="text" v-model="obat.cara_pemberian" class="input-rme" />
            </div>
            <div class="col-md-1">
              <label>&nbsp;</label>
              <button @click="removeObat(index)" class="btn-danger mb-3">Hapus</button>
            </div>
          </div>
        </div>
      </div>
      




        <!-- ================= TANDA TANGAN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan</h5>
        
          <div class="signature-grid-2x2">
            <!-- BARIS 1 KOLOM 1 -->
            <div>
              <label class="fw-bold mb-2">Dokter Pengirim</label>
              <VueSignaturePad ref="ttd_dokter_pengirim" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dokter_pengirim')" class="btn-save mt-2">Simpan ✔</button>
              <input type="text" v-model="form.nama_dokter_pengirim" class="input-rme mt-2" placeholder="Nama Lengkap Dokter Pengirim" />
            <div class="form-row-2 mt-2">
          <div>
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal_dokter_penerima" class="input-rme" />
          </div>
          <div>
            <label>Jam :</label>
            <input type="time" v-model="form.jam_dokter_penerima" class="input-rme" />
          </div>
        </div>
            </div>
        
            <!-- BARIS 1 KOLOM 2 -->
            <div>
              <label class="fw-bold mb-2">Dokter Penerima</label>
              <VueSignaturePad ref="ttd_dokter_penerima" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dokter_penerima')" class="btn-save mt-2">Simpan ✔</button>
              <input type="text" v-model="form.nama_dokter_penerima" class="input-rme mt-2" placeholder="Nama Lengkap Dokter Penerima" />
              
        <div class="form-row-2 mt-2">
          <div>
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal_dokter_penerima" class="input-rme" />
          </div>
          <div>
            <label>Jam :</label>
            <input type="time" v-model="form.jam_dokter_penerima" class="input-rme" />
          </div>
        </div>
      </div>
    </div>
            
    <!-- <h5 class="section-title-rme mt-4">Seluruh Proses Pemindahan Telah Selesai</h5> -->
    
    <div class="signature-grid-2x2">
      <!-- PERAWAT PENGANTAR -->
      <div>
        <label class="fw-bold mb-2">Perawat yang Mengantar</label>
        <VueSignaturePad ref="ttd_perawat_pengantar" :options="sigOption" class="signature-box-rme mx-auto" />
        <button @click="saveSign('ttd_perawat_pengantar')" class="btn-save mt-2">Simpan ✔</button>
        <input type="text" v-model="form.nama_perawat_pengantar" class="input-rme mt-2" placeholder="Nama Lengkap Perawat Pengantar" />
      </div>

      <!-- PERAWAT PENERIMA -->
      <div>
        <label class="fw-bold mb-2">Perawat yang Menerima</label>
        <VueSignaturePad ref="ttd_perawat_penerima" :options="sigOption" class="signature-box-rme mx-auto" />
        <button @click="saveSign('ttd_perawat_penerima')" class="btn-save mt-2">Simpan ✔</button>
        <input type="text" v-model="form.nama_perawat_penerima" class="input-rme mt-2" placeholder="Nama Lengkap Perawat yang Menerima" />
      </div>
    </div>
  </div>


    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>Simpan</span>
      </button>
<button @click="$emit('back')" class="btn-back">Kembali</button>
    </div>
  
</template>

<script>
import axios from "axios";

export default {
  name: "FormTransfer",
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
        
        tanggal_masuk: "",
        tanggal_pindah: "",
        asal_ruangan: "",
        ruangan_selanjutnya: "",
        dokter_yang_merawat: "",
        dpjp: "",
        
        diagnosa_utama: "",
        perlu_perhatian: "",
        alergi: "",
        mrsa: false,
        diagnosa_sekunder_1: "",
        diagnosa_sekunder_2: "",
        diagnosa_sekunder_3: "",
        diagnosa_sekunder_4: "",
        diagnosa_sekunder_5: "",
        
        kondisi_pasien: "",
        alasan_fasilitas: "",
        alasan_tenaga: "",
        alasan_lainnya: "",
        
        metode_kursi_roda: false,
        metode_tempat_tidur: false,
        metode_brankar: false,
        
        pasien_keluarga_setuju: false,
        nama_pemberi_persetujuan: "",
        hubungan_pemberi_persetujuan: "",
        
        peralatan_portable: false,
        peralatan_alat_penghisap: false,
        peralatan_bagging: false,
        peralatan_ngt: false,
        peralatan_ventilator: false,
        peralatan_kateter_urin: false,
        peralatan_pompa_infus: false,
        
        keadaan_umum: "",
        kesadaran: "",
        status_nyeri: "",
        td: "",
        nadi: "",
        suhu: "",
        pernafasan: "",
        
        nama_pendamping: "",
        
        disabilitas_amputasi: false,
        disabilitas_kontraktur: false,
        disabilitas_paralisis: false,
        disabilitas_ulkus_dikubitus: false,
        disabilitas_gangguan_mental: false,
        disabilitas_bicara: false,
        disabilitas_pendengaran: false,
        disabilitas_penglihatan: false,
        disabilitas_sensasi: false,
        
        inkontinensia_urin: false,
        inkontinensia_saliva: false,
        inkontinensia_alvi: false,
        
        potensial_rehabilitasi: "",
        
        status_generalis: "",
        status_lokalis: "",
        pemeriksaan_penunjang: "",
        
        kemandirian_berguling: "",
        kemandirian_duduk: "",
        kemandirian_hygiene_wajah: "",
        kemandirian_hygiene_tubuh: "",
        kemandirian_hygiene_ekstremitas: "",
        kemandirian_hygiene_mulut: "",
        kemandirian_pakaian_atas: "",
        kemandirian_pakaian_tubuh: "",
        kemandirian_pakaian_bawah: "",
        kemandirian_makan: "",
        kemandirian_jalan: "",
        kemandirian_kursi_roda: "",
        
        intervensi_tindakan: "",
        diet: "",
        rencana_perawatan: "",
        
        terapi_obat: [],
        
        ttd_dokter_pengirim: "",
        nama_dokter_pengirim: "",
        jam_dokter_pengirim: "",
        tanggal_dokter_pengirim: "",
        
        ttd_dokter_penerima: "",
        nama_dokter_penerima: "",
        jam_dokter_penerima: "",
        tanggal_dokter_penerima: "",
        
        ttd_perawat_pengantar: "",
        nama_perawat_pengantar: "",
        
        ttd_perawat_penerima: "",
        nama_perawat_penerima: "",
        
        ttd_keluarga: "",
        nama_keluarga_ttd: "",
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
            `/master/pasien/dokumen-form-transfer-pasien/${this.editData.uuid}`
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
      this.form.tanggal_pindah = today.toISOString().split("T")[0];

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

    addObat() {
      this.form.terapi_obat.push({
        nama_obat: "",
        jumlah: "",
        dosis: "",
        frekuensi: "",
        cara_pemberian: "",
      });
    },

    removeObat(index) {
      this.form.terapi_obat.splice(index, 1);
    },

    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          
          if (key === "terapi_obat") {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key]);
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-form-transfer-pasien",
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

.signature-grid-2x2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 30px 20px;
  margin-top: 20px;
}

.form-row-block {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding-left: 20px;
}

.form-row-block .checkbox-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin: 0;
  cursor: pointer;
}

.form-row-block .checkbox-item input[type="checkbox"] {
  margin-top: 3px;
  flex-shrink: 0;
  cursor: pointer;
}

.form-section {
  margin-bottom: 20px;
}

.anesthesia-section {
  border-top: 1px solid #ccc;
  padding-top: 10px;
}

.section-label {
  display: block;
  margin-bottom: 10px;
  font-weight: normal;
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

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 5px;
  margin: 0;
  white-space: nowrap;
}

.checkbox-item input[type="checkbox"] {
  margin: 0;
}
.container {
  max-width: 1200px;
  margin: 0 auto;
}

.form-row-3-3 {
  display: flex;
  gap: 1rem; /* jarak antar kolom */
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem; /* tambahkan padding di dalam setiap kolom */
}

.signature-row-3 {
  display: flex;
  gap: 0.1rem;     /* jarak antar kolom */
  margin-top: 1.5rem;
}

.signature-row-3 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  text-align: center;
  box-sizing: border-box;
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

.radio-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.signature-box-rme {
  width: 350px !important;   /* paksa lebar */
  height: 220px !important;  /* paksa tinggi */
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

.date-time-wrapper {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.date-time-wrapper > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.form-row-2 {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.form-row-2 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.signature-row {
  display: flex;
  gap: 2rem;       /* jarak antar kolom kiri-kanan */
  margin-top: 2rem;
}

.signature-row > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  box-sizing: border-box;
}
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

.col-md-4 {
  flex: 0 0 33.333333%;
  max-width: 33.333333%;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

.d-flex {
  display: flex;
}

.gap-3 {
  gap: 12px;
}

.mb-2 {
  margin-bottom: 8px;
}

.mb-3 {
  margin-bottom: 16px;
}

.mb-4 {
  margin-bottom: 24px;
}

.mt-2 {
  margin-top: 8px;
}

.text-center {
  text-align: center;
}

.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>