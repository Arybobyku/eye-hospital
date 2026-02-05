<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <!-- ================= HEADER ================= -->
    <div v-if="disabledSubmit" class="view-overlay"></div>
    <div class="text-center mb-4">
      <h2 class="fw-bold">Asesmen Awal Keperawatan Rawat Inap</h2>
      <p class="small">(Formulir ini digunakan untuk pasien dewasa/usia lanjut dan harus dilengkapi dalam waktu 24 jam pertama pasien masuk ruang rawat inap)</p>
      <p class="small fw-semibold">RM 7.8/AAKRI/2022</p>
    </div>

    <!-- DATE & TIME -->
    <div class="row mb-3">
      <div class="col-md-6 mb-2">
        <input type="date" v-model="form.date" class="form-control" readonly />
      </div>
      <div class="col-md-6 mb-2">
        <input type="time" v-model="form.time" class="form-control" readonly />
      </div>
    </div>

    <!-- ================= INFORMASI PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Pasien</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>No. RM :</label>
          <input type="text" v-model="form.no_rm" class="input-rme" readonly />
        </div>

        <div class="col-md-6">
          <label>Nama Pasien :</label>
          <input type="text" v-model="form.nama" class="input-rme" readonly />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Tanggal Lahir :</label>
          <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
        </div>

        <div class="col-md-6">
          <label>Jenis Kelamin :</label>
          <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>NIK :</label>
          <input type="text" v-model="form.nik" class="input-rme" readonly />
        </div>
      </div>
    </div>

    <!-- ================= ALERGI/REAKSI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Alergi / Reaksi</h5>

      <div class="mb-3">
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.tidak_ada_alergi" @change="clearAlergi" /> Tidak ada alergi
        </label>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>
            <input type="checkbox" v-model="form.alergi_obat_check" /> Alergi Obat, sebutkan:
          </label>
          <input type="text" v-model="form.alergi_obat" class="input-rme" :disabled="!form.alergi_obat_check" />
        </div>
        <div class="col-md-6">
          <label>Reaksi:</label>
          <input type="text" v-model="form.alergi_obat_reaksi" class="input-rme" :disabled="!form.alergi_obat_check" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>
            <input type="checkbox" v-model="form.alergi_makanan_check" /> Alergi Makanan, sebutkan:
          </label>
          <input type="text" v-model="form.alergi_makanan" class="input-rme" :disabled="!form.alergi_makanan_check" />
        </div>
        <div class="col-md-6">
          <label>Reaksi:</label>
          <input type="text" v-model="form.alergi_makanan_reaksi" class="input-rme" :disabled="!form.alergi_makanan_check" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>
            <input type="checkbox" v-model="form.alergi_lainnya_check" /> Alergi Lainnya, sebutkan:
          </label>
          <input type="text" v-model="form.alergi_lainnya" class="input-rme" :disabled="!form.alergi_lainnya_check" />
        </div>
        <div class="col-md-6">
          <label>Reaksi:</label>
          <input type="text" v-model="form.alergi_lainnya_reaksi" class="input-rme" :disabled="!form.alergi_lainnya_check" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Diberitahukan ke Dokter/Apoteker/Ahli Gizi:</label>
          <select v-model="form.diberitahu_alergi" class="input-rme">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>
        <div class="col-md-6" v-if="form.diberitahu_alergi === 'Ya'">
          <label>Pukul:</label>
          <input type="time" v-model="form.diberitahu_alergi_pukul" class="input-rme" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Gelang tanda alergi dipasang (warna merah):</label>
          <select v-model="form.gelang_alergi" class="input-rme">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="checkbox-label">
          <input type="checkbox" v-model="form.tidak_diketahui" /> Tidak Diketahui
        </label>
      </div>
    </div>

    <!-- ================= KEADAAN UMUM & PEMERIKSAAN FISIK ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Keadaan Umum & Pemeriksaan Fisik</h5>

      <div class="row mb-3">
        <div class="col-md-3">
          <label>Kesadaran:</label>
          <input type="text" v-model="form.kesadaran" class="input-rme" />
        </div>
        <div class="col-md-3">
          <label>GCS (E-V-M):</label>
          <div style="display: flex; gap: 5px;">
            <input type="number" v-model="form.gcs_e" class="input-rme" placeholder="E" style="width: 60px;" />
            <input type="number" v-model="form.gcs_v" class="input-rme" placeholder="V" style="width: 60px;" />
            <input type="number" v-model="form.gcs_m" class="input-rme" placeholder="M" style="width: 60px;" />
          </div>
        </div>
        <div class="col-md-3">
          <label>Tekanan Darah (mmHg):</label>
          <input type="text" v-model="form.tekanan_darah" class="input-rme" placeholder="120/80" />
        </div>
        <div class="col-md-3">
          <label>Nadi (x/mnt):</label>
          <input type="number" v-model="form.nadi" class="input-rme" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-3">
          <label>RR (x/mnt):</label>
          <input type="number" v-model="form.rr" class="input-rme" />
        </div>
        <div class="col-md-3">
          <label>SPO2 (%):</label>
          <input type="number" v-model="form.spo2" class="input-rme" />
        </div>
        <div class="col-md-3">
          <label>Suhu Tubuh (°C):</label>
          <input type="number" step="0.1" v-model="form.suhu" class="input-rme" />
        </div>
        <div class="col-md-3">
          <label>Berat Badan (Kg):</label>
          <input type="number" step="0.1" v-model="form.berat_badan" class="input-rme" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-3">
          <label>Tinggi Badan (cm):</label>
          <input type="number" v-model="form.tinggi_badan" class="input-rme" />
        </div>
        <div class="col-md-3">
          <label>Lingkar Kepala (cm):</label>
          <input type="number" v-model="form.lingkar_kepala" class="input-rme" />
        </div>
        <div class="col-md-3">
          <label>LiLA (cm):</label>
          <input type="number" v-model="form.lila" class="input-rme" />
        </div>
      </div>

      <!-- Pemeriksaan Fisik Detail -->
      <h6 class="mt-4 mb-3" style="font-weight: bold;">Pemeriksaan Fisik Detail</h6>

      <table class="info-table">
        <thead>
          <tr>
            <th style="width: 200px">Pemeriksaan</th>
            <th>Status</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Pernafasan</td>
            <td>
              <label><input type="radio" v-model="form.pernafasan" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.pernafasan" value="Batuk" /> Batuk</label>
              <label><input type="radio" v-model="form.pernafasan" value="Sesak" /> Sesak</label>
            </td>
            <td><input type="text" v-model="form.pernafasan_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Penglihatan</td>
            <td>
              <label><input type="radio" v-model="form.penglihatan" value="Baik" /> Baik</label>
              <label><input type="radio" v-model="form.penglihatan" value="Rusak" /> Rusak</label>
              <label><input type="radio" v-model="form.penglihatan" value="Alat Bantu" /> Alat Bantu</label>
            </td>
            <td><input type="text" v-model="form.penglihatan_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Pendengaran</td>
            <td>
              <label><input type="radio" v-model="form.pendengaran" value="Baik" /> Baik</label>
              <label><input type="radio" v-model="form.pendengaran" value="Rusak" /> Rusak</label>
              <label><input type="radio" v-model="form.pendengaran" value="Alat Bantu" /> Alat Bantu</label>
            </td>
            <td><input type="text" v-model="form.pendengaran_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Bicara</td>
            <td>
              <label><input type="radio" v-model="form.bicara" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.bicara" value="Gangguan" /> Gangguan</label>
            </td>
            <td><input type="text" v-model="form.bicara_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Mulut</td>
            <td>
              <label><input type="radio" v-model="form.mulut" value="Bersih" /> Bersih</label>
              <label><input type="radio" v-model="form.mulut" value="Kotor" /> Kotor</label>
              <label><input type="radio" v-model="form.mulut" value="Gigi Palsu" /> Gigi Palsu</label>
            </td>
            <td><input type="text" v-model="form.mulut_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Refleks Menelan</td>
            <td>
              <label><input type="radio" v-model="form.refleks_menelan" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.refleks_menelan" value="Sulit" /> Sulit</label>
              <label><input type="radio" v-model="form.refleks_menelan" value="Rusak" /> Rusak</label>
            </td>
            <td><input type="text" v-model="form.refleks_menelan_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Gastrointestinal</td>
            <td>
              <label><input type="radio" v-model="form.gastrointestinal" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.gastrointestinal" value="Refluks" /> Refluks</label>
              <label><input type="radio" v-model="form.gastrointestinal" value="Nausea" /> Nausea</label>
              <label><input type="radio" v-model="form.gastrointestinal" value="Muntah" /> Muntah</label>
            </td>
            <td><input type="text" v-model="form.gastrointestinal_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Defekasi</td>
            <td>
              <label><input type="radio" v-model="form.defekasi" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.defekasi" value="Retensio" /> Retensio</label>
            </td>
            <td><input type="text" v-model="form.defekasi_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Miksi</td>
            <td>
              <label><input type="radio" v-model="form.miksi" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.miksi" value="Retensio" /> Retensio</label>
            </td>
            <td><input type="text" v-model="form.miksi_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Pola Tidur</td>
            <td>
              <label><input type="radio" v-model="form.pola_tidur" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.pola_tidur" value="Insomnia" /> Insomnia</label>
            </td>
            <td><input type="text" v-model="form.pola_tidur_ket" class="input-rme" /></td>
          </tr>

          <tr>
            <td>Kulit</td>
            <td>
              <label><input type="radio" v-model="form.kulit" value="Normal" /> Normal</label>
              <label><input type="radio" v-model="form.kulit" value="Luka" /> Luka</label>
            </td>
            <td>
              <div>
                <label>Lokasi:</label>
                <input type="text" v-model="form.kulit_lokasi" class="input-rme" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="mt-3">
        <label style="font-weight: bold;">Jumlah Skor: {{ nortonScore }}</label>
        <div class="mt-2">
          <span v-if="nortonScore >= 16 && nortonScore <= 20" style="color: green;">16-20: Tidak ada risiko</span>
          <span v-else-if="nortonScore >= 12 && nortonScore <= 15" style="color: orange;">12-15: Risiko Sedang</span>
          <span v-else-if="nortonScore < 12 && nortonScore > 0" style="color: red;">&lt;12: Risiko Tinggi</span>
        </div>
      </div>
    </div>

    <!-- ================= RIWAYAT PSIKOSOSIAL KULTURAL SPIRITUAL ================= -->
<div class="box-rme mb-4">
  <h5 class="section-title-rme">Riwayat Psikososial Kultural Spiritual</h5>

  <!-- STATUS PSIKOLOGIS -->
  <h6 class="mt-3 mb-2" style="font-weight: bold;">Status Psikologis</h6>
  <div class="mb-3">
    <label class="checkbox-label">
      <input type="checkbox" v-model="form.psikologis_cemas" /> Cemas
    </label>
    <label class="checkbox-label">
      <input type="checkbox" v-model="form.psikologis_takut" /> Takut
    </label>
    <label class="checkbox-label">
      <input type="checkbox" v-model="form.psikologis_marah" /> Marah
    </label>
    <label class="checkbox-label">
      <input type="checkbox" v-model="form.psikologis_sedih" /> Sedih
    </label>
    <label class="checkbox-label">
      <input type="checkbox" v-model="form.psikologis_bunuh_diri" /> Kecenderungan bunuh diri
    </label>
  </div>

  <div class="row mb-3">
    <div class="col-md-12">
      <label>Lain-lain, sebutkan:</label>
      <input type="text" v-model="form.psikologis_lainnya" class="input-rme" placeholder="Sebutkan kondisi psikologis lainnya..." />
    </div>
  </div>

  <!-- STATUS SOSIAL -->
  <h6 class="mt-4 mb-2" style="font-weight: bold;">Status Sosial</h6>
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Hubungan pasien dengan anggota keluarga:</label>
      <select v-model="form.hubungan_keluarga" class="input-rme">
        <option value="">Pilih</option>
        <option value="Baik">Baik</option>
        <option value="Tidak Baik">Tidak Baik</option>
      </select>
    </div>
    <div class="col-md-6">
      <label>Tempat tinggal:</label>
      <input type="text" v-model="form.tempat_tinggal" class="input-rme" placeholder="Rumah/Apartemen/Panti/Lainnya" />
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-md-4">
      <label>Kerabat yang dapat dihubungi - Nama:</label>
      <input type="text" v-model="form.kerabat_nama" class="input-rme" />
    </div>
    <div class="col-md-4">
      <label>Hubungan:</label>
      <input type="text" v-model="form.kerabat_hubungan" class="input-rme" placeholder="Contoh: Suami/Istri/Anak" />
    </div>
    <div class="col-md-4">
      <label>Telepon:</label>
      <input type="tel" v-model="form.kerabat_telepon" class="input-rme" placeholder="08xxxxxxxxxx" />
    </div>
  </div>

  <!-- STATUS KULTURAL -->
  <h6 class="mt-4 mb-2" style="font-weight: bold;">Status Kultural</h6>
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Bahasa Sehari-hari:</label>
      <select v-model="form.bahasa_sehari" class="input-rme">
        <option value="">Pilih</option>
        <option value="Indonesia">Indonesia</option>
        <option value="Daerah">Daerah</option>
        <option value="Inggris">Inggris (aktif/pasif)</option>
        <option value="Lainnya">Lainnya</option>
      </select>
    </div>
    <div class="col-md-6" v-if="form.bahasa_sehari === 'Daerah'">
      <label>Sebutkan bahasa daerah:</label>
      <input type="text" v-model="form.bahasa_daerah_sebutkan" class="input-rme" placeholder="Contoh: Jawa, Sunda, dll" />
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-md-6">
      <label>Perlu penterjemah:</label>
      <select v-model="form.perlu_penterjemah" class="input-rme">
        <option value="">Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>
    <div class="col-md-6" v-if="form.perlu_penterjemah === 'Ya'">
      <label>Bahasa yang diperlukan:</label>
      <input type="text" v-model="form.penterjemah_bahasa" class="input-rme" placeholder="Sebutkan bahasa..." />
    </div>
  </div>

  <!-- STATUS SPIRITUAL -->
  <h6 class="mt-4 mb-2" style="font-weight: bold;">Status Spiritual</h6>
  <div class="row mb-3">
    <div class="col-md-12">
      <label>Nilai-nilai atau kepercayaan yang dianut:</label>
      <textarea v-model="form.spiritual_kepercayaan" class="textarea-rme" rows="3" placeholder="Jelaskan nilai-nilai atau kepercayaan yang dianut pasien..."></textarea>
    </div>
  </div>
</div>

<!-- ================= KHUSUS UNTUK WANITA ================= -->
<div class="box-rme mb-4" v-if="form.jenis_kelamin === 'Perempuan' || form.jenis_kelamin === 'P'">
  <h5 class="section-title-rme">Khusus Untuk Wanita</h5>

  <div class="row mb-3">
    <div class="col-md-6">
      <label>Hamil:</label>
      <select v-model="form.hamil" class="input-rme">
        <option value="">Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>
    <div class="col-md-6" v-if="form.hamil === 'Ya'">
      <label>HPHT (Hari Pertama Haid Terakhir):</label>
      <input type="date" v-model="form.hpht" class="input-rme" />
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-md-12">
      <label>Keluhan Menstruasi:</label>
      <textarea v-model="form.keluhan_menstruasi" class="textarea-rme" rows="2" placeholder="Jelaskan keluhan menstruasi jika ada..."></textarea>
    </div>
  </div>
</div>

<!-- ================= PENILAIAN RISIKO DEKUBITUS (SKALA NORTON) ================= -->
<div class="box-rme mb-4">
  <h5 class="section-title-rme">Penilaian Risiko Dekubitus (Skala Norton)</h5>

  <table class="info-table">
    <thead>
      <tr>
        <th style="width: 200px">Yang Dinilai</th>
        <th style="width: 150px; text-align:center;">4</th>
        <th style="width: 150px; text-align:center;">3</th>
        <th style="width: 150px; text-align:center;">2</th>
        <th style="width: 150px; text-align:center;">1</th>
      </tr>
    </thead>
    <tbody>
      <!-- KELUHAN FISIK -->
      <tr>
        <td>Keluhan Fisik</td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_fisik" value="4" /> Baik
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_fisik" value="3" /> Sedang
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_fisik" value="2" /> Buruk
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_fisik" value="1" /> Sangat buruk
          </label>
        </td>
      </tr>

      <!-- STATUS MENTAL -->
      <tr>
        <td>Status Mental</td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mental" value="4" /> Sadar
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mental" value="3" /> Apatis
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mental" value="2" /> Bingung
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mental" value="1" /> Stupor
          </label>
        </td>
      </tr>

      <!-- AKTIVITAS -->
      <tr>
        <td>Aktivitas</td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_aktivitas" value="4" /> Jalan sendiri
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_aktivitas" value="3" /> Dengan bantuan
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_aktivitas" value="2" /> Kursi roda
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_aktivitas" value="1" /> Di tempat tidur
          </label>
        </td>
      </tr>

      <!-- MOBILITAS -->
      <tr>
        <td>Mobilitas</td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mobilitas" value="4" /> Bebas bergerak
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mobilitas" value="3" /> Gerak terbatas
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mobilitas" value="2" /> Sangat terbatas
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_mobilitas" value="1" /> Tidak bergerak
          </label>
        </td>
      </tr>

      <!-- INKONTINENSIA -->
      <tr>
        <td>Inkontinensia</td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_inkontinensia" value="4" /> Kontinen
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_inkontinensia" value="3" /> Kadang inkontinen
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_inkontinensia" value="2" /> Selalu inkontinen
          </label>
        </td>
        <td style="text-align:center;">
          <label>
            <input type="radio" v-model="form.norton_inkontinensia" value="1" /> Inkontinen urin & alvi
          </label>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- DISPLAY TOTAL SKOR -->
  <div class="mt-3" style="padding: 15px; background: #ffffcc; border: 1px solid #ddd; border-radius: 4px;">
    <label style="font-weight: bold; font-size: 16px;">Jumlah Skor: {{ nortonScore }}</label>
    <div class="mt-2">
      <span v-if="nortonScore >= 16 && nortonScore <= 20" style="color: green; font-weight: bold;">
        ✓ 16-20: Tidak ada risiko
      </span>
      <span v-else-if="nortonScore >= 12 && nortonScore <= 15" style="color: orange; font-weight: bold;">
        ⚠ 12-15: Risiko Sedang
      </span>
      <span v-else-if="nortonScore < 12 && nortonScore > 0" style="color: red; font-weight: bold;">
        ✕ &lt;12: Risiko Tinggi
      </span>
      <span v-else style="color: #999; font-style: italic;">
        Silakan lengkapi penilaian di atas
      </span>
    </div>
  </div>
</div>

<!-- ================= SKRINING RISIKO CEDERA/JATUH ================= -->
<div class="box-rme mb-4">
  <h5 class="section-title-rme">Skrining Risiko Cedera/Jatuh</h5>

  <div class="row mb-3">
    <div class="col-md-12">
      <label style="font-weight: bold;">Risiko Cedera/Jatuh:</label>
      <div>
        <label style="margin-right: 20px;">
          <input type="radio" v-model="form.risiko_jatuh" value="Ya" /> Ya
        </label>
        <label>
          <input type="radio" v-model="form.risiko_jatuh" value="Tidak" /> Tidak
        </label>
      </div>
    </div>
  </div>

  <div v-if="form.risiko_jatuh === 'Ya'" class="mb-3" style="padding-left: 20px;">
    <p style="font-weight: bold; margin-bottom: 10px;">Maka lakukan pemasangan:</p>
    <div>
      <label class="checkbox-label">
        <input type="checkbox" v-model="form.gelang_risiko_jatuh" /> Gelang risiko jatuh
      </label>
    </div>
    <div>
      <label class="checkbox-label">
        <input type="checkbox" v-model="form.segitiga_risiko_jatuh" /> Segitiga risiko jatuh
      </label>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-md-6">
      <label>Diberitahukan ke dokter:</label>
      <select v-model="form.risiko_jatuh_ke_dokter" class="input-rme">
        <option value="">Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>
    <div class="col-md-6" v-if="form.risiko_jatuh_ke_dokter === 'Ya'">
      <label>Pukul:</label>
      <input type="time" v-model="form.risiko_jatuh_ke_dokter_pukul" class="input-rme" />
    </div>
  </div>
</div>

    <!-- ================= PENILAIAN SKALA NYERI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Penilaian Skala Nyeri</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Keluhan Nyeri:</label>
          <select v-model="form.keluhan_nyeri" class="input-rme">
            <option value="">Pilih</option>
            <option value="Ada">Ada</option>
            <option value="Tidak ada">Tidak ada</option>
          </select>
        </div>
        <div class="col-md-6" v-if="form.keluhan_nyeri === 'Ada'">
          <label>Skala Nyeri (0-10):</label>
          <input type="number" min="0" max="10" v-model="form.skala_nyeri" class="input-rme" />
        </div>
      </div>

      <div v-if="form.keluhan_nyeri === 'Ada'">
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Lokasi:</label>
            <input type="text" v-model="form.nyeri_lokasi" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Nyeri berpindah/menjalar:</label>
            <select v-model="form.nyeri_menjalar" class="input-rme">
              <option value="">Pilih</option>
              <option value="Ada">Ada</option>
              <option value="Tidak ada">Tidak ada</option>
            </select>
          </div>
        </div>

        <div class="row mb-3" v-if="form.nyeri_menjalar === 'Ada'">
          <div class="col-md-6">
            <label>Menjalar ke:</label>
            <input type="text" v-model="form.nyeri_menjalar_ke" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Onset nyeri:</label>
            <select v-model="form.onset_nyeri" class="input-rme">
              <option value="">Pilih</option>
              <option value="Akut">&lt; 3 bulan (Akut)</option>
              <option value="Kronik">&gt; 3 bulan (Kronik)</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label>Rasa Nyeri:</label>
          <div>
            <label><input type="checkbox" v-model="form.nyeri_ditusuk" /> Seperti ditusuk</label>
            <label><input type="checkbox" v-model="form.nyeri_ditikam" /> Seperti ditikam</label>
            <label><input type="checkbox" v-model="form.nyeri_berdenyut" /> Seperti berdenyut</label>
          </div>
          <div>
            <label><input type="checkbox" v-model="form.nyeri_dipukul" /> Seperti dipukul</label>
            <label><input type="checkbox" v-model="form.nyeri_kram" /> Seperti kram</label>
            <label><input type="checkbox" v-model="form.nyeri_dibakar" /> Seperti dibakar</label>
          </div>
          <div>
            <label><input type="checkbox" v-model="form.nyeri_tajam" /> Nyeri tajam</label>
            <label><input type="checkbox" v-model="form.nyeri_tumpul" /> Nyeri tumpul</label>
            <label><input type="checkbox" v-model="form.nyeri_ditarik" /> Seperti ditarik</label>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Frekuensi nyeri:</label>
            <select v-model="form.frekuensi_nyeri" class="input-rme">
              <option value="">Pilih</option>
              <option value="1-2 jam">1-2 jam</option>
              <option value="3-4 jam">3-4 jam</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Lama nyeri:</label>
            <select v-model="form.lama_nyeri" class="input-rme">
              <option value="">Pilih</option>
              <option value="<30 menit">&lt;30 menit</option>
              <option value=">30 menit">&gt;30 menit</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nyeri memburuk bila:</label>
            <input type="text" v-model="form.nyeri_memburuk" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Nyeri berkurang bila:</label>
            <input type="text" v-model="form.nyeri_berkurang" class="input-rme" />
          </div>
        </div>
      </div>
    </div>

    <!-- ================= SKRINING GIZI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Skrining Gizi (MST)</h5>

      <table class="info-table">
        <thead>
          <tr>
            <th style="width: 60px">No</th>
            <th>Parameter</th>
            <th style="width: 150px">Skor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 3 bulan terakhir?</td>
            <td>
              <select v-model="form.gizi_penurunan_bb" class="input-rme">
                <option value="">Pilih</option>
                <option value="0">0 = Tidak ada penurunan BB</option>
                <option value="1">1 = Penurunan 1-5 kg</option>
                <option value="2">2 = Penurunan 6-10 kg</option>
                <option value="3">3 = Penurunan 11-15 kg</option>
                <option value="4">4 = Penurunan &gt;15 kg</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Apakah asupan makanan berkurang karena tidak nafsu makan?</td>
            <td>
              <select v-model="form.gizi_asupan_makanan" class="input-rme">
                <option value="">Pilih</option>
                <option value="0">0 = Tidak</option>
                <option value="1">1 = Ya</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="mt-3">
        <label style="font-weight: bold;">Total Skor: {{ giziScore }}</label>
        <div class="mt-2">
          <span v-if="giziScore > 2" style="color: red;">Bila skor &gt;2 dan/atau pasien dengan penyakit yang berat dilakukan pengkajian lanjutan oleh ahli gizi</span>
        </div>
      </div>

      <div class="row mt-3" v-if="giziScore > 2">
        <div class="col-md-6">
          <label>Sudah dibaca dan diketahui ahli gizi:</label>
          <select v-model="form.gizi_ke_ahli" class="input-rme">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>
        <div class="col-md-6" v-if="form.gizi_ke_ahli === 'Ya'">
          <label>Pukul:</label>
          <input type="time" v-model="form.gizi_ke_ahli_pukul" class="input-rme" />
        </div>
      </div>
    </div>

    <!-- ================= STATUS FUNGSIONAL/TINGKAT KETERGANTUNGAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Status Fungsional / Tingkat Ketergantungan</h5>

      <div class="mb-3">
        <label style="font-weight: bold;">Aktivitas dan Mobilisasi:</label>
        <div>
          <label><input type="radio" v-model="form.status_fungsional" value="Mandiri" /> Mandiri</label>
        </div>
        <div>
          <label><input type="radio" v-model="form.status_fungsional" value="Perlu bantuan minimal" /> Perlu bantuan minimal</label>
          <input type="text" v-model="form.status_fungsional_bantuan" class="input-rme" placeholder="Sebutkan..." :disabled="form.status_fungsional !== 'Perlu bantuan minimal'" />
        </div>
        <div>
          <label><input type="radio" v-model="form.status_fungsional" value="Ketergantungan total" /> Ketergantungan total</label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label>Dilapor ke dokter:</label>
          <select v-model="form.fungsional_ke_dokter" class="input-rme">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>
        <div class="col-md-6" v-if="form.fungsional_ke_dokter === 'Ya'">
          <label>Pukul:</label>
          <input type="time" v-model="form.fungsional_ke_dokter_pukul" class="input-rme" />
        </div>
      </div>

      <p class="small mt-2" style="font-style: italic;">
        (bila ketergantungan total kolaborasi dengan DPJP, apakah perlu untuk konsul ke rehabilitasi medik)
      </p>
    </div>

    <!-- ================= DIAGNOSA KEPERAWATAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Diagnosa Keperawatan</h5>

      <table class="info-table">
        <thead>
          <tr>
            <th>Diagnosa Keperawatan</th>
            <th>Tujuan</th>
            <th>Intervensi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><textarea v-model="form.diagnosa_keperawatan" class="textarea-rme" rows="4"></textarea></td>
            <td><textarea v-model="form.diagnosa_tujuan" class="textarea-rme" rows="4"></textarea></td>
            <td><textarea v-model="form.diagnosa_intervensi" class="textarea-rme" rows="4"></textarea></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ================= RENCANA PEMULANGAN PASIEN (DISCHARGE PLANNING) ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Rencana Pemulangan Pasien (Discharge Planning)</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Estimasi tanggal pemulangan pasien:</label>
          <input type="date" v-model="form.estimasi_pemulangan" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Apakah Pasien/keluarga tahu rencana pulang?</label>
          <select v-model="form.tahu_rencana_pulang" class="input-rme">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>
      </div>

      <table class="info-table">
        <thead>
          <tr>
            <th style="width: 50%">Keterangan Rencana Pulang</th>
            <th style="width: 80px">Ya</th>
            <th style="width: 80px">Tidak</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Apakah rawat inap berpengaruh terhadap:<br>- Pasien dan Keluarga<br>- Pekerjaan<br>- Keuangan</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_berpengaruh" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_berpengaruh" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_berpengaruh_ket" class="textarea-rme" rows="2"></textarea>
            </td>
          </tr>

          <tr>
            <td>
              Masalah pemenuhan kebutuhan yang dihadapi saat pulang<br>
              <div style="margin-top: 5px;">
                <label><input type="checkbox" v-model="form.dp_mobilitas" /> Mobilitas Fisik</label>
                <label><input type="checkbox" v-model="form.dp_hygiene" /> Personal Hygiene</label><br>
                <label><input type="checkbox" v-model="form.dp_obat" /> Kepatuhan Minum Obat</label>
                <label><input type="checkbox" v-model="form.dp_diet" /> Pengaturan Diet</label><br>
                <label><input type="checkbox" v-model="form.dp_makanan" /> Menyiapkan makanan/minum</label>
                <label><input type="checkbox" v-model="form.dp_lainnya_check" /> Lainnya</label>
              </div>
            </td>
            <td colspan="2"></td>
            <td>
              <input type="text" v-model="form.dp_lainnya" class="input-rme" placeholder="Lainnya..." />
            </td>
          </tr>

          <tr>
            <td>Apakah ada yang membantu kebutuhan tersebut diatas (yang merawat pasien)?</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_ada_yang_membantu" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_ada_yang_membantu" value="Tidak" />
            </td>
            <td>
              <input type="text" v-model="form.dp_yang_merawat" class="input-rme" placeholder="Yang merawat..." />
            </td>
          </tr>

          <tr>
            <td>Apakah pasien menggunakan peralatan medis dirumah setelah keluar rumah sakit (cateter, NGT, double lumen, oksigen)?</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_peralatan_medis" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_peralatan_medis" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_peralatan_medis_ket" class="textarea-rme" rows="2" placeholder="Alat yang digunakan..."></textarea>
            </td>
          </tr>

          <tr>
            <td>Apakah pasien memerlukan alat bantu setelah keluar dari rumah sakit (tongkat, kursi roda, walker dll)?</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_alat_bantu" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_alat_bantu" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_alat_bantu_ket" class="textarea-rme" rows="2" placeholder="Alat yang digunakan..."></textarea>
            </td>
          </tr>

          <tr>
            <td>Apakah ketika pulang masih ada perawatan lanjutan/khusus yang harus dilakukan dirumah (rawat luka, perawatan bayi, injeksi lantus dll)?</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_perawatan_lanjutan" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_perawatan_lanjutan" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_perawatan_lanjutan_ket" class="textarea-rme" rows="2" placeholder="Jenis Perawatan..."></textarea>
            </td>
          </tr>

          <tr>
            <td>Apakah pasien memiliki masalah seperti nyeri kronis, kelelahan, batasan asupan cairan atau batasan aktivitas setelah keluar dari rumah sakit?</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_masalah_khusus" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_masalah_khusus" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_masalah_khusus_ket" class="textarea-rme" rows="2" placeholder="Cara mengatasinya..."></textarea>
            </td>
          </tr>

          <tr>
            <td>Apakah alat transportasi pasien untuk pulang aman sesuai dengan kondisi pasien saat keluar rumah sakit?</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_transportasi_aman" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_transportasi_aman" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_transportasi_ket" class="textarea-rme" rows="2" placeholder="Alat transportasi..."></textarea>
            </td>
          </tr>

          <tr>
            <td>Apakah pasien dan keluarga memerlukan edukasi kesehatan keluar dari rumah sakit obat-obatan, nyeri, diet, mencari pertolongan, followup, dll</td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_edukasi" value="Ya" />
            </td>
            <td class="text-center">
              <input type="radio" v-model="form.dp_edukasi" value="Tidak" />
            </td>
            <td>
              <textarea v-model="form.dp_edukasi_ket" class="textarea-rme" rows="2" placeholder="Jenis edukasi..."></textarea>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ================= PERAWAT YANG MENGKAJI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Perawat yang Mengkaji</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Tanggal:</label>
          <input type="date" v-model="form.tanggal_kaji" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Pukul:</label>
          <input type="time" v-model="form.pukul_kaji" class="input-rme" />
        </div>
      </div>

      <div class="signature-section">
        <div class="sign-box">
          <label>Tanda Tangan Perawat</label>
          <VueSignaturePad
            ref="perawat_ttd"
            :options="sigOption"
            class="signature-box-rme"
          />
          <button  @click="saveSign('perawat_ttd')" class="btn-save">Simpan ✔</button>
          <input
            v-model="form.perawat_nama"
            class="input-rme"
            placeholder="Nama Perawat"
          />
        </div>
      </div>
    </div>
  </div>

  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer">
    <button v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>Simpan</span>
    </button>

    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
      Kembali
    </button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormAssesmenAwalKeperawatanRawatInap",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      // ✨ Props untuk data edit
      type: Object,
      default: null,
    },
    viewData: {
      type: Object,
      default: null,
    },
    editUuid: {
        type: String,
        default: null,
    },
  },
  data() {
    return {
      loadingSubmit: false,
      disabledSubmit : false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "", // ✨ Tambahkan field uuid untuk edit
        uuid_pasien: "",
        date: "",
        time: "",
        no_rm: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        nik: "",
        
        // Alergi
        tidak_ada_alergi: false,
        alergi_obat_check: false,
        alergi_obat: "",
        alergi_obat_reaksi: "",
        alergi_makanan_check: false,
        alergi_makanan: "",
        alergi_makanan_reaksi: "",
        alergi_lainnya_check: false,
        alergi_lainnya: "",
        alergi_lainnya_reaksi: "",
        diberitahu_alergi: "",
        diberitahu_alergi_pukul: "",
        gelang_alergi: "",
        tidak_diketahui: false,
        
        // Keadaan Umum
        kesadaran: "",
        gcs_e: "",
        gcs_v: "",
        gcs_m: "",
        tekanan_darah: "",
        nadi: "",
        rr: "",
        spo2: "",
        suhu: "",
        berat_badan: "",
        tinggi_badan: "",
        lingkar_kepala: "",
        lila: "",
        
        // Pemeriksaan Fisik
        pernafasan: "",
        pernafasan_ket: "",
        penglihatan: "",
        penglihatan_ket: "",
        pendengaran: "",
        pendengaran_ket: "",
        bicara: "",
        bicara_ket: "",
        mulut: "",
        mulut_ket: "",
        refleks_menelan: "",
        refleks_menelan_ket: "",
        gastrointestinal: "",
        gastrointestinal_ket: "",
        defekasi: "",
        defekasi_ket: "",
        miksi: "",
        miksi_ket: "",
        pola_tidur: "",
        pola_tidur_ket: "",
        kulit: "",
        kulit_lokasi: "",
        
        // Khusus Wanita
        hamil: "",
        hpht: "",
        keluhan_menstruasi: "",
        
        // Risiko Jatuh
        risiko_jatuh: "",
        gelang_risiko_jatuh: false,
        segitiga_risiko_jatuh: false,
        risiko_jatuh_ke_dokter: "",
        risiko_jatuh_ke_dokter_pukul: "",
        
        // Psikososial
        psikologis_cemas: false,
        psikologis_takut: false,
        psikologis_marah: false,
        psikologis_sedih: false,
        psikologis_bunuh_diri: false,
        psikologis_lainnya: "",
        hubungan_keluarga: "",
        tempat_tinggal: "",
        kerabat_nama: "",
        kerabat_hubungan: "",
        kerabat_telepon: "",
        bahasa_sehari: "",
        bahasa_daerah_sebutkan: "",
        perlu_penterjemah: "",
        penterjemah_bahasa: "",
        spiritual_kepercayaan: "",
        
        // Skala Norton
        norton_fisik: "",
        norton_mental: "",
        norton_aktivitas: "",
        norton_mobilitas: "",
        norton_inkontinensia: "",
        
        // Skala Nyeri
        keluhan_nyeri: "",
        skala_nyeri: "",
        nyeri_lokasi: "",
        nyeri_menjalar: "",
        nyeri_menjalar_ke: "",
        onset_nyeri: "",
        nyeri_ditusuk: false,
        nyeri_ditikam: false,
        nyeri_berdenyut: false,
        nyeri_dipukul: false,
        nyeri_kram: false,
        nyeri_dibakar: false,
        nyeri_tajam: false,
        nyeri_tumpul: false,
        nyeri_ditarik: false,
        frekuensi_nyeri: "",
        lama_nyeri: "",
        nyeri_memburuk: "",
        nyeri_berkurang: "",
        
        // Skrining Gizi
        gizi_penurunan_bb: "",
        gizi_asupan_makanan: "",
        gizi_ke_ahli: "",
        gizi_ke_ahli_pukul: "",
        
        // Status Fungsional
        status_fungsional: "",
        status_fungsional_bantuan: "",
        fungsional_ke_dokter: "",
        fungsional_ke_dokter_pukul: "",
        
        // Diagnosa Keperawatan
        diagnosa_keperawatan: "",
        diagnosa_tujuan: "",
        diagnosa_intervensi: "",
        
        // Discharge Planning
        estimasi_pemulangan: "",
        tahu_rencana_pulang: "",
        dp_berpengaruh: "",
        dp_berpengaruh_ket: "",
        dp_mobilitas: false,
        dp_hygiene: false,
        dp_obat: false,
        dp_diet: false,
        dp_makanan: false,
        dp_lainnya_check: false,
        dp_lainnya: "",
        dp_ada_yang_membantu: "",
        dp_yang_merawat: "",
        dp_peralatan_medis: "",
        dp_peralatan_medis_ket: "",
        dp_alat_bantu: "",
        dp_alat_bantu_ket: "",
        dp_perawatan_lanjutan: "",
        dp_perawatan_lanjutan_ket: "",
        dp_masalah_khusus: "",
        dp_masalah_khusus_ket: "",
        dp_transportasi_aman: "",
        dp_transportasi_ket: "",
        dp_edukasi: "",
        dp_edukasi_ket: "",
        
        // Perawat
        tanggal_kaji: "",
        pukul_kaji: "",
        perawat_nama: "",
        perawat_ttd: "",
      },
    };
  },


  computed: {
    nortonScore() {
      const fisik = parseInt(this.form.norton_fisik) || 0;
      const mental = parseInt(this.form.norton_mental) || 0;
      const aktivitas = parseInt(this.form.norton_aktivitas) || 0;
      const mobilitas = parseInt(this.form.norton_mobilitas) || 0;
      const inkontinensia = parseInt(this.form.norton_inkontinensia) || 0;
      return fisik + mental + aktivitas + mobilitas + inkontinensia;
    },
    
    giziScore() {
      const bb = parseInt(this.form.gizi_penurunan_bb) || 0;
      const asupan = parseInt(this.form.gizi_asupan_makanan) || 0;
      return bb + asupan;
    },
    isEditMode() {
      console.log('p', this.editUuid);
        return !!this.editUuid;
      }
    
  },

  mounted() {
    console.log('editmode', this.isEditMode);
    if (this.isEditMode && this.editData) {
      // ✨ LOAD DATA UNTUK EDIT
      console.log("edit");
      this.disabledSubmit = false;
      this.loadDataForEdit();
    }else if(this.viewData) {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else {
      this.disabledSubmit = false; 
      // CREATE MODE
      this.setDataForm();
    }
  },

  methods: {
    async loadDataForEdit() {
      try {
        const dataSource = this.editData || this.viewData;

        // Jika data lengkap sudah ada di editData props
        if (dataSource) {
          // Fetch detail dari server untuk data lengkap
          const response = await axios.get(
             `/master/rekammedis/lampiran/${dataSource.uuid}?type=asesmen_keperawatan_rawat_inap`
          );
          console.log("123", response.data)
          if (response.data.status) {
            // Populate form dengan data dari server
            Object.keys(this.form).forEach((key) => {
              if (response.data.data[key] !== undefined) {
                this.form[key] = response.data.data[key];
              }
            });

            // ✨ Load signature jika ada
            this.$nextTick(() => {
              // Signature akan di-load manual jika diperlukan
              // Note: vue-signature-pad perlu special handling untuk load existing signature
            });
          }
        }

        // Alternative: Langsung gunakan editData jika sudah lengkap
        // Object.keys(this.form).forEach(key => {
        //   if (this.editData[key] !== undefined) {
        //     this.form[key] = this.editData[key];
        //   }
        // });
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },
    formatDate(d) {
      return d.toISOString().split("T")[0];
    },

    formatTime(d) {
      return d.toTimeString().substring(0, 5);
    },

    setDataForm() {
      const now = new Date();
      this.form.date = this.formatDate(now);
      this.form.time = this.formatTime(now);
      this.form.tanggal_kaji = this.formatDate(now);
      this.form.pukul_kaji = this.formatTime(now);
      
      // Set data pasien dari props
      this.form.uuid_pasien = this.selectedPatient?.uuid;
      this.form.no_rm = this.selectedPatient?.rekam_medis;
      this.form.nama = this.selectedPatient?.nama;
      this.form.tanggal_lahir = this.selectedPatient?.tanggal_lahir;
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin;
      this.form.nik = this.selectedPatient?.no_ktp;
    },

    clearAlergi() {
      if (this.form.tidak_ada_alergi) {
        this.form.alergi_obat_check = false;
        this.form.alergi_obat = "";
        this.form.alergi_obat_reaksi = "";
        this.form.alergi_makanan_check = false;
        this.form.alergi_makanan = "";
        this.form.alergi_makanan_reaksi = "";
        this.form.alergi_lainnya_check = false;
        this.form.alergi_lainnya = "";
        this.form.alergi_lainnya_reaksi = "";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];

      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { isEmpty, data } = pad.saveSignature();
      
      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }

      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi basic
      if (!this.form.kesadaran) {
        alert("Mohon lengkapi data Kesadaran!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
  if (this.form[key] === null) {
    fd.append(key, "");
  } else {
    fd.append(key, this.form[key]);
  }
});

        const response = await axios.post(
          "/master/pasien/asesmen-awal-keperawatan-rawat-inap",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);
        
        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan data! " + (error.response?.data?.message || error.message));
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
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
  padding: 6px 10px;
  background: #f9f9f9;
  font-size: 14px;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
}

.input-rme:disabled {
  background: #e9ecef;
  cursor: not-allowed;
}

.textarea-rme {
  width: 100%;
  min-height: 80px;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px 10px;
  font-family: inherit;
  font-size: 14px;
  resize: vertical;
}

.textarea-rme:focus {
  outline: none;
  border-color: #2d74b7;
}
.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 251, 251, 0.1); /* transparan */
  z-index: 10;
  cursor: not-allowed;
}
.info-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

.info-table th,
.info-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}

.info-table th {
  background: #f0f0f0;
  font-weight: bold;
  color: #333;
}

.info-table td {
  vertical-align: top;
}

.info-table .text-center {
  text-align: center;
}

.signature-box-rme {
  width: 100%;
  max-width: 300px;
  height: 150px;
  border: 2px solid #999;
  margin: 10px auto;
  display: block;
  background: white;
}

.signature-section {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.sign-box {
  text-align: center;
  width: 100%;
  max-width: 350px;
}

.sign-box label {
  display: block;
  font-weight: bold;
  margin-bottom: 8px;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  margin: 10px 0;
  cursor: pointer;
  font-weight: bold;
}

.btn-save:hover {
  background: #1565c0;
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

.action-footer {
  margin-top: 30px;
  padding: 20px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  background: #f8f9fa;
  border-top: 2px solid #ddd;
  position: sticky;
  bottom: 0;
  z-index: 10;
}

.checkbox-label {
  display: inline-block;
  margin-right: 15px;
  margin-bottom: 5px;
}

label {
  display: inline-block;
  margin-right: 15px;
  margin-bottom: 5px;
  font-size: 14px;
}

label input[type="checkbox"],
label input[type="radio"] {
  margin-right: 5px;
}

.small {
  font-size: 12px;
  color: #666;
}

.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
}

.text-center {
  text-align: center;
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

.mt-1 {
  margin-top: 4px;
}

.mt-2 {
  margin-top: 8px;
}

.mt-3 {
  margin-top: 16px;
}

.mt-4 {
  margin-top: 24px;
}

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -8px;
}

.col-md-3,
.col-md-4,
.col-md-6,
.col-md-12 {
  padding: 0 8px;
  width: 100%;
}

@media (min-width: 768px) {
  .col-md-3 {
    width: 25%;
  }
  
  .col-md-4 {
    width: 33.333%;
  }
  
  .col-md-6 {
    width: 50%;
  }
  
  .col-md-12 {
    width: 100%;
  }
}
</style>