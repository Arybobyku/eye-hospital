<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <div v-if="disabledSubmit" class="view-overlay"></div>

      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- HEADER -->
      <div class="text-center mb-4">
        <img src="/logo-rs.png" alt="Logo RS" class="logo-rs mb-3" style="max-width:150px" />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <p class="mb-1">VISION FOR THE NATION</p>
        <hr class="my-3" style="border:2px solid #000" />
        <div class="rahasia-box">RAHASIA, TIDAK BOLEH DIFOTOCOPY, DILAPORKAN MAXIMAL 2 x 24</div>
        <h3 class="fw-bold mt-3 mb-1">LAPORAN INSIDEN</h3>
        <p class="mb-3">(INTERNAL)</p>
        <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
      </div>

      <!-- I. DATA PASIEN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">I. Data Pasien</h5>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>No. Rekam Medis :</label>
            <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin_display" class="input-rme" readonly />
          </div>
          <div class="col-md-4">
            <label>Ruangan :</label>
            <input type="text" v-model="form.ruangan" class="form-control" placeholder="Nama ruangan" />
          </div>
          <div class="col-md-4">
            <label>Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="form-control" />
          </div>
        </div>

        <!-- Umur -->
        <div class="mb-3">
          <label class="fw-bold">Umur * :</label>
          <div class="checkbox-grid">
            <label class="cb-item"><input type="checkbox" v-model="form.umur_0_1_bulan" /> 0 – 1 bulan</label>
            <label class="cb-item"><input type="checkbox" v-model="form.umur_1_bulan_1_tahun" /> &gt; 1 bulan – 1 tahun</label>
            <label class="cb-item"><input type="checkbox" v-model="form.umur_1_5_tahun" /> &gt; 1 tahun – 5 tahun</label>
            <label class="cb-item"><input type="checkbox" v-model="form.umur_5_15_tahun" /> &gt; 5 tahun – 15 tahun</label>
            <label class="cb-item"><input type="checkbox" v-model="form.umur_15_30_tahun" /> &gt; 15 tahun – 30 tahun</label>
            <label class="cb-item"><input type="checkbox" v-model="form.umur_30_65_tahun" /> &gt; 30 tahun – 65 tahun</label>
            <label class="cb-item"><input type="checkbox" v-model="form.umur_65_plus" /> &gt; 65 tahun</label>
          </div>
        </div>

        <!-- Penanggung Biaya -->
        <div class="mb-3">
          <label class="fw-bold">Penanggung Biaya Pasien :</label>
          <div class="checkbox-group">
            <label class="cb-item"><input type="checkbox" v-model="form.biaya_pribadi" /> Pribadi</label>
            <label class="cb-item"><input type="checkbox" v-model="form.biaya_asuransi_swasta" /> Asuransi Swasta</label>
            <label class="cb-item"><input type="checkbox" v-model="form.biaya_perusahaan" /> Perusahaan</label>
            <label class="cb-item"><input type="checkbox" v-model="form.biaya_bpjs" /> BPJS*</label>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <label>Tanggal Masuk RS :</label>
            <input type="date" v-model="form.tanggal_masuk_rs" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Jam Masuk :</label>
            <input type="time" v-model="form.jam_masuk_rs" class="form-control" />
          </div>
        </div>
      </div>

      <!-- II. RINCIAN KEJADIAN -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">II. Rincian Kejadian</h5>

        <div class="row mb-3">
          <div class="col-md-4">
            <label><strong>1. Tanggal Insiden :</strong></label>
            <input type="date" v-model="form.insiden_tanggal" class="form-control" />
          </div>
          <div class="col-md-3">
            <label>Jam Insiden :</label>
            <input type="time" v-model="form.insiden_jam" class="form-control" />
          </div>
        </div>

        <div class="mb-3">
          <label><strong>2. Insiden :</strong></label>
          <input type="text" v-model="form.insiden_deskripsi" class="form-control" placeholder="Deskripsi singkat insiden" />
        </div>

        <div class="mb-3">
          <label><strong>3. Kronologis Insiden :</strong></label>
          <textarea v-model="form.kronologis_insiden" class="form-control" rows="4"
            placeholder="Uraikan kronologis kejadian..."></textarea>
        </div>

        <!-- 4. Jenis Insiden -->
        <div class="mb-3">
          <label><strong>4. Jenis Insiden* :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_knc" />
              Kejadian Nyaris Cedera / KNC <em>(Near miss)</em></label>
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_ktc" />
              Kejadian Tidak Cedera / KTC <em>(No Harm)</em></label>
            <label class="cb-item"><input type="checkbox" v-model="form.jenis_ktd" />
              Kejadian Tidak Diharapkan / KTD <em>(Adverse Event)</em> / Kejadian Sentinel</label>
          </div>
        </div>
      </div>

      <!-- BAGIAN 5–8 -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Insiden (5–8)</h5>

        <!-- 5. Orang Pertama Melaporkan -->
        <div class="mb-3">
          <label><strong>5. Orang Pertama Yang Melaporkan Insiden* :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item"><input type="checkbox" v-model="form.pelapor_karyawan" />
              Karyawan : Dokter / Perawat / Petugas lainnya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.pelapor_pasien" /> Pasien</label>
            <label class="cb-item"><input type="checkbox" v-model="form.pelapor_keluarga" /> Keluarga / Pendamping pasien</label>
            <label class="cb-item"><input type="checkbox" v-model="form.pelapor_pengunjung" /> Pengunjung</label>
            <label class="cb-item">
              <input type="checkbox" v-model="form.pelapor_lainnya" /> Lain-lain (sebutkan) :
              <input v-if="form.pelapor_lainnya" type="text" v-model="form.pelapor_lainnya_sebutkan"
                class="form-control mt-1" placeholder="Sebutkan..." />
            </label>
          </div>
        </div>

        <!-- 6. Insiden terjadi pada -->
        <div class="mb-3">
          <label><strong>6. Insiden terjadi pada* :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item"><input type="checkbox" v-model="form.terjadi_pada_pasien" /> Pasien</label>
            <label class="cb-item">
              <input type="checkbox" v-model="form.terjadi_pada_lainnya" /> Lain-lain (sebutkan) :
              <input v-if="form.terjadi_pada_lainnya" type="text" v-model="form.terjadi_pada_lainnya_sebutkan"
                class="form-control mt-1" placeholder="Mis: karyawan / Pengunjung / Pendamping..." />
            </label>
          </div>
        </div>

        <!-- 7. Insiden menyangkut pasien -->
        <div class="mb-3">
          <label><strong>7. Insiden menyangkut pasien :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item"><input type="checkbox" v-model="form.pasien_rawat_inap" /> Pasien rawat inap</label>
            <label class="cb-item"><input type="checkbox" v-model="form.pasien_rawat_jalan" /> Pasien rawat jalan</label>
            <label class="cb-item"><input type="checkbox" v-model="form.pasien_igd" /> Pasien IGD</label>
            <label class="cb-item">
              <input type="checkbox" v-model="form.pasien_lainnya" /> Lain-lain (sebutkan) :
              <input v-if="form.pasien_lainnya" type="text" v-model="form.pasien_lainnya_sebutkan"
                class="form-control mt-1" placeholder="Sebutkan..." />
            </label>
          </div>
        </div>

        <!-- 8. Tempat Insiden -->
        <div class="mb-3">
          <label><strong>8. Tempat Insiden — Lokasi Kejadian (sebutkan) :</strong></label>
          <input type="text" v-model="form.lokasi_kejadian" class="form-control" placeholder="Tempat/lokasi kejadian insiden" />
        </div>
      </div>

      <!-- BAGIAN 9–14 -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Insiden (9–14)</h5>

        <!-- 9. Spesialisasi -->
        <div class="mb-3">
          <label><strong>9. Insiden terjadi pada pasien (sesuai kasus penyakit/spesialisasi) :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item"><input type="checkbox" v-model="form.spesialisasi_penyakit_mata" /> Penyakit Mata</label>
            <label class="cb-item">
              <input type="checkbox" v-model="form.spesialisasi_lainnya" /> Lain-lain (sebutkan) :
              <input v-if="form.spesialisasi_lainnya" type="text" v-model="form.spesialisasi_lainnya_sebutkan"
                class="form-control mt-1" placeholder="Sebutkan..." />
            </label>
          </div>
        </div>

        <!-- 10. Unit Kerja -->
        <div class="mb-3">
          <label><strong>10. Unit / Departemen terkait yang menyebabkan insiden :</strong></label>
          <input type="text" v-model="form.unit_kerja_penyebab" class="form-control" placeholder="Unit kerja penyebab (sebutkan)" />
        </div>

        <!-- 11. Akibat Insiden -->
        <div class="mb-3">
          <label><strong>11. Akibat Insiden Terhadap Pasien* :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item"><input type="checkbox" v-model="form.akibat_kematian" /> Kematian</label>
            <label class="cb-item"><input type="checkbox" v-model="form.akibat_cedera_berat" /> Cedera Irreversibel / Cedera Berat</label>
            <label class="cb-item"><input type="checkbox" v-model="form.akibat_cedera_sedang" /> Cedera Reversibel / Cedera Sedang</label>
            <label class="cb-item"><input type="checkbox" v-model="form.akibat_cedera_ringan" /> Cedera Ringan</label>
            <label class="cb-item"><input type="checkbox" v-model="form.akibat_tidak_cedera" /> Tidak ada cedera</label>
          </div>
        </div>

        <!-- 12. Tindakan segera -->
        <div class="mb-3">
          <label><strong>12. Tindakan yang dilakukan segera setelah kejadian, dan hasilnya :</strong></label>
          <textarea v-model="form.tindakan_hasil" class="form-control" rows="4"
            placeholder="Uraikan tindakan yang dilakukan dan hasilnya..."></textarea>
        </div>

        <!-- 13. Tindakan dilakukan oleh -->
        <div class="mb-3">
          <label><strong>13. Tindakan dilakukan oleh* :</strong></label>
          <div class="checkbox-list">
            <label class="cb-item">
              <input type="checkbox" v-model="form.tindakan_tim" /> Tim : terdiri dari :
              <input v-if="form.tindakan_tim" type="text" v-model="form.tindakan_tim_terdiri"
                class="form-control mt-1" placeholder="Nama tim..." />
            </label>
            <label class="cb-item"><input type="checkbox" v-model="form.tindakan_dokter" /> Dokter</label>
            <label class="cb-item"><input type="checkbox" v-model="form.tindakan_perawat" /> Perawat</label>
            <label class="cb-item">
              <input type="checkbox" v-model="form.tindakan_petugas_lainnya" /> Petugas lainnya :
              <input v-if="form.tindakan_petugas_lainnya" type="text" v-model="form.tindakan_petugas_lainnya_sebutkan"
                class="form-control mt-1" placeholder="Sebutkan..." />
            </label>
          </div>
        </div>

        <!-- 14. Kejadian yang sama -->
        <div class="mb-3">
          <label><strong>14. Apakah kejadian yang sama pernah terjadi di Unit Kerja lain?*</strong></label>
          <div class="checkbox-group mb-2">
            <label class="cb-item"><input type="checkbox" v-model="form.kejadian_sama_ya" /> Ya</label>
            <label class="cb-item"><input type="checkbox" v-model="form.kejadian_sama_tidak" /> Tidak</label>
          </div>
          <div v-if="form.kejadian_sama_ya">
            <label>Kapan? dan Langkah/tindakan apa yang telah diambil untuk mencegah terulangnya?</label>
            <textarea v-model="form.kejadian_sama_keterangan" class="form-control" rows="3"
              placeholder="Uraikan kapan dan tindakan pencegahan yang telah diambil..."></textarea>
          </div>
        </div>
      </div>

      <!-- PEMBUAT / PENERIMA & GRADING -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pembuat Laporan & Grading Risiko</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Pembuat Laporan :</label>
            <input type="text" v-model="form.pembuat_laporan" class="form-control" placeholder="Nama pembuat laporan" />
          </div>
          <div class="col-md-6">
            <label>Penerima Laporan :</label>
            <input type="text" v-model="form.penerima_laporan" class="form-control" placeholder="Nama penerima laporan" />
          </div>
        </div>
        <!-- Paraf Digital Signature -->
        <div class="row mb-3">
          <!-- Paraf Pembuat -->
          <div class="col-md-6">
            <label>Paraf Pembuat :</label>
            <div class="sign-box-paraf">
              <div v-if="form.pembuat_laporan_paraf && !signaturePembuatCleared" class="signature-preview-small">
                <img :src="form.pembuat_laporan_paraf" alt="Paraf Pembuat" class="img-paraf" />
                <button @click="clearParafPembuat()" class="btn-clear">Hapus &amp; Tanda Tangan Ulang</button>
              </div>
              <div v-else>
                <VueSignaturePad ref="paraf_pembuat" :options="sigOption" class="signature-box-paraf" />
                <button @click="saveParafPembuat()" class="btn-save">Simpan ✔</button>
              </div>
            </div>
          </div>

          <!-- Paraf Penerima -->
          <div class="col-md-6">
            <label>Paraf Penerima :</label>
            <div class="sign-box-paraf">
              <div v-if="form.penerima_laporan_paraf && !signaturePenerimaCleared" class="signature-preview-small">
                <img :src="form.penerima_laporan_paraf" alt="Paraf Penerima" class="img-paraf" />
                <button @click="clearParafPenerima()" class="btn-clear">Hapus &amp; Tanda Tangan Ulang</button>
              </div>
              <div v-else>
                <VueSignaturePad ref="paraf_penerima" :options="sigOption" class="signature-box-paraf" />
                <button @click="saveParafPenerima()" class="btn-save">Simpan ✔</button>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Tgl Terima :</label>
            <input type="date" v-model="form.tgl_terima" class="form-control" />
          </div>
          <div class="col-md-6">
            <label>Tgl Lapor :</label>
            <input type="date" v-model="form.tgl_lapor" class="form-control" />
          </div>
        </div>

        <!-- Grading -->
        <div class="mb-2">
          <label><strong>Grading Risiko Kejadian* (Diisi oleh atasan pelapor) :</strong></label>
          <div class="checkbox-group grading-group">
            <label class="cb-item grading-biru"><input type="checkbox" v-model="form.grading_biru" /> BIRU</label>
            <label class="cb-item grading-hijau"><input type="checkbox" v-model="form.grading_hijau" /> HIJAU</label>
            <label class="cb-item grading-kuning"><input type="checkbox" v-model="form.grading_kuning" /> KUNING</label>
            <label class="cb-item grading-merah"><input type="checkbox" v-model="form.grading_merah" /> MERAH</label>
          </div>
          <small class="text-muted">NB. * = pilih satu jawaban.</small>
        </div>
      </div>

    </div>
  </div>

  <!-- BUTTON BOTTOM -->
  <div class="action-footer" v-if="!disabledSubmit">
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Back</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'DokumenLaporanInsiden',

  props: {
    selectedPatient: { type: Object, required: true },
    viewData:        { type: Object, default: null },
    editData:        { type: Object, default: null },
  },

  data() {
    return {
      loadingSubmit:  false,
      loadingData:    false,
      isEditMode:     false,
      disabledSubmit: false,
      signaturePembuatCleared:  false,
      signaturePenerimaCleared: false,

      sigOption: {
        penColor:        'black',
        backgroundColor: 'white',
      },

      form: {
        uuid:        '',
        uuid_pasien: '',

        // Identitas
        no_rm: '', no_surat: '', jenis_kelamin: '',
        nama: '', nik: '', tanggal_lahir: '',

        // Display only
        nama_pasien: '', no_rm_pasien: '', jenis_kelamin_display: '',

        // Header
        ruangan: '',

        // Umur
        umur_0_1_bulan: false, umur_1_bulan_1_tahun: false,
        umur_1_5_tahun: false, umur_5_15_tahun: false,
        umur_15_30_tahun: false, umur_30_65_tahun: false, umur_65_plus: false,

        // Biaya
        biaya_pribadi: false, biaya_asuransi_swasta: false,
        biaya_perusahaan: false, biaya_bpjs: false,

        // Masuk RS
        tanggal_masuk_rs: '', jam_masuk_rs: '',

        // Rincian Kejadian
        insiden_tanggal: '', insiden_jam: '',
        insiden_deskripsi: '', kronologis_insiden: '',

        // Jenis Insiden
        jenis_knc: false, jenis_ktc: false, jenis_ktd: false,

        // Pelapor
        pelapor_karyawan: false, pelapor_pasien: false,
        pelapor_keluarga: false, pelapor_pengunjung: false,
        pelapor_lainnya: false, pelapor_lainnya_sebutkan: '',

        // Terjadi pada
        terjadi_pada_pasien: false, terjadi_pada_lainnya: false,
        terjadi_pada_lainnya_sebutkan: '',

        // Menyangkut pasien
        pasien_rawat_inap: false, pasien_rawat_jalan: false,
        pasien_igd: false, pasien_lainnya: false,
        pasien_lainnya_sebutkan: '',

        // Tempat
        lokasi_kejadian: '',

        // Spesialisasi
        spesialisasi_penyakit_mata: false, spesialisasi_lainnya: false,
        spesialisasi_lainnya_sebutkan: '',

        // Unit
        unit_kerja_penyebab: '',

        // Akibat
        akibat_kematian: false, akibat_cedera_berat: false,
        akibat_cedera_sedang: false, akibat_cedera_ringan: false,
        akibat_tidak_cedera: false,

        // Tindakan
        tindakan_hasil: '', tindakan_tim: false, tindakan_tim_terdiri: '',
        tindakan_dokter: false, tindakan_perawat: false,
        tindakan_petugas_lainnya: false, tindakan_petugas_lainnya_sebutkan: '',

        // Kejadian sama
        kejadian_sama_ya: false, kejadian_sama_tidak: false,
        kejadian_sama_keterangan: '',

        // Pembuat / Penerima
        pembuat_laporan: '', pembuat_laporan_paraf: '', tgl_terima: '',
        penerima_laporan: '', penerima_laporan_paraf: '', tgl_lapor: '',

        // Grading
        grading_biru: false, grading_hijau: false,
        grading_kuning: false, grading_merah: false,
      },
    };
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(v) { if (v && !this.isEditMode) this.setDataForm(); },
    },
    editData: {
      immediate: true,
      handler(v) { if (v) this.loadEditData(); },
    },
  },

  async mounted() {
    await this.fetchTahunAkreditasi();
    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadEditData();
    } else if (this.editData) {
      this.loadEditData();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get('/api/tahun-akreditasi');
        const tahun = res.data.tahun || '22';
        if (!this.form.no_surat) this.form.no_surat = `RM 7.9/LI/${tahun}`;
      } catch {
        if (!this.form.no_surat) this.form.no_surat = 'RM 7.9/LI/22';
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.insiden_tanggal = this.formatDate(today);

      this.form.uuid_pasien   = this.selectedPatient?.uuid          || '';
      this.form.no_rm         = this.selectedPatient?.rekam_medis   || '';
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || '';
      this.form.nama          = this.selectedPatient?.nama          || '';
      this.form.nik           = this.selectedPatient?.no_identitas  || '';

      this.form.nama_pasien  = this.selectedPatient?.nama          || '';
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis   || '';
      this.form.jenis_kelamin_display =
        this.selectedPatient?.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';

      if (this.selectedPatient?.tanggal_lahir)
        this.form.tanggal_lahir = this.formatDate(new Date(this.selectedPatient.tanggal_lahir));
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode  = true;
      try {
        let data = null;
        if (typeof this.editData === 'string') {
          const res = await axios.get(
            `/master/rekammedis/lampiran/${this.editData}?type=dokumen_laporan_insiden`
          );
          data = res.data.data;
        } else {
          data = this.editData;
        }

        if (data) {
          Object.keys(this.form).forEach(k => {
            if (data[k] !== undefined && data[k] !== null) this.form[k] = data[k];
          });

          if (data.tanggal_lahir)   this.form.tanggal_lahir   = this.formatDate(new Date(data.tanggal_lahir));
          if (data.insiden_tanggal) this.form.insiden_tanggal = this.formatDate(new Date(data.insiden_tanggal));
          if (data.tanggal_masuk_rs) this.form.tanggal_masuk_rs = this.formatDate(new Date(data.tanggal_masuk_rs));
          if (data.tgl_terima)      this.form.tgl_terima      = this.formatDate(new Date(data.tgl_terima));
          if (data.tgl_lapor)       this.form.tgl_lapor       = this.formatDate(new Date(data.tgl_lapor));

          this.form.nama_pasien  = data.nama  || '';
          this.form.no_rm_pasien = data.no_rm || '';
          this.form.jenis_kelamin_display =
            data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';

          // Restore paraf signatures ke pad jika ada
          this.$nextTick(() => {
            if (data.pembuat_laporan_paraf && this.$refs.paraf_pembuat) {
              this.$refs.paraf_pembuat.clearSignature();
              this.$refs.paraf_pembuat.fromDataURL(data.pembuat_laporan_paraf);
            }
            if (data.penerima_laporan_paraf && this.$refs.paraf_penerima) {
              this.$refs.paraf_penerima.clearSignature();
              this.$refs.paraf_penerima.fromDataURL(data.penerima_laporan_paraf);
            }
          });
        }
      } catch (e) {
        console.error('Error loading edit data:', e);
        alert('Gagal memuat data!');
        this.$emit('back');
      } finally {
        this.loadingData = false;
      }
    },

    formatDate(date) {
      if (!date) return '';
      return new Date(date).toISOString().split('T')[0];
    },

    // ── Paraf Pembuat ──────────────────────────────────────────────────────
    saveParafPembuat() {
      const pad = this.$refs.paraf_pembuat;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Paraf pembuat masih kosong!'); return; }
      this.form.pembuat_laporan_paraf = data;
      this.signaturePembuatCleared = false;
    },

    clearParafPembuat() {
      this.signaturePembuatCleared      = true;
      this.form.pembuat_laporan_paraf   = '';
      this.$nextTick(() => {
        const pad = this.$refs.paraf_pembuat;
        if (pad) pad.clearSignature();
      });
    },

    // ── Paraf Penerima ─────────────────────────────────────────────────────
    saveParafPenerima() {
      const pad = this.$refs.paraf_penerima;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Paraf penerima masih kosong!'); return; }
      this.form.penerima_laporan_paraf = data;
      this.signaturePenerimaCleared = false;
    },

    clearParafPenerima() {
      this.signaturePenerimaCleared      = true;
      this.form.penerima_laporan_paraf   = '';
      this.$nextTick(() => {
        const pad = this.$refs.paraf_penerima;
        if (pad) pad.clearSignature();
      });
    },

    async submitForm() {
      if (!this.form.insiden_tanggal) { alert('Mohon lengkapi Tanggal Insiden!'); return; }
      if (!this.form.insiden_deskripsi) { alert('Mohon lengkapi deskripsi Insiden!'); return; }

      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach(k => {
          fd.append(k, this.form[k] !== null && this.form[k] !== undefined ? this.form[k] : '');
        });

        const res = await axios.post('/master/pasien/dokumen-laporan-insiden', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        alert(this.isEditMode ? 'Laporan Insiden berhasil diupdate!' : 'Laporan Insiden berhasil disimpan!');
        this.$emit('back');
      } catch (e) {
        console.error('ERROR:', e.response?.data || e);
        alert('Gagal menyimpan data!');
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1000px; margin: 0 auto; padding: 20px; }
.py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.fw-bold { font-weight: 700; }
.text-uppercase { text-transform: uppercase; }
.text-center { text-align: center; }
.text-danger { color: #dc3545; }
.text-muted { color: #888; font-size: 12px; }
.text-center h2 { font-size: 18px; margin-bottom: 10px; }
.text-center h3 { font-size: 16px; margin-top: 10px; margin-bottom: 4px; }
.text-center p { font-size: 13px; margin: 0; line-height: 1.5; }
hr { margin: 20px 0; border: 2px solid #000; }
.logo-rs { display: block; margin: 0 auto 15px; max-width: 150px; }

.rahasia-box {
  border: 1px solid #333; padding: 4px 16px;
  display: inline-block; font-size: 11px;
  font-weight: bold; margin: 8px auto;
}

.badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-top: 10px; }
.badge.bg-warning { background: #ff9800; color: white; }

.box-rme { border: 1px solid #dcdcdc; padding: 20px; border-radius: 6px; background: #fafafa; margin-bottom: 20px; }
.section-title-rme { font-weight: bold; margin-bottom: 15px; color: #2d74b7; font-size: 16px; border-bottom: 2px solid #2d74b7; padding-bottom: 8px; }

label { display: block; margin-bottom: 8px; font-weight: 500; color: #555; font-size: 14px; }
.input-rme { width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px 12px; background: #fff; font-size: 14px; box-sizing: border-box; }
.input-rme[readonly] { background: #f5f5f5; cursor: not-allowed; color: #666; }
.form-control { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; line-height: 1.6; box-sizing: border-box; }
.form-control:focus { outline: none; border-color: #2d74b7; }
textarea.form-control { resize: vertical; min-height: 80px; }

/* Checkbox styles */
.checkbox-group { display: flex; gap: 20px; flex-wrap: wrap; padding: 12px; background: white; border-radius: 4px; border: 1px solid #e0e0e0; }
.checkbox-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; padding: 12px; background: white; border-radius: 4px; border: 1px solid #e0e0e0; }
.checkbox-list { display: flex; flex-direction: column; gap: 8px; padding: 12px; background: white; border-radius: 4px; border: 1px solid #e0e0e0; }
.cb-item { display: flex; align-items: flex-start; gap: 8px; font-weight: normal; color: #333; font-size: 14px; cursor: pointer; margin: 0; }
.cb-item input[type=checkbox] { width: 18px; height: 18px; cursor: pointer; margin-top: 2px; flex-shrink: 0; }

/* Grading */
.grading-group { gap: 16px; }
.grading-biru  { color: #1565C0; font-weight: bold; }
.grading-hijau { color: #2E7D32; font-weight: bold; }
.grading-kuning{ color: #F57F17; font-weight: bold; }
.grading-merah { color: #B71C1C; font-weight: bold; }

.row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
.mb-1 { margin-bottom: 5px; } .mb-2 { margin-bottom: 10px; }
.mb-3 { margin-bottom: 15px; } .mb-4 { margin-bottom: 20px; }
.mt-1 { margin-top: 6px; }  .mt-3 { margin-top: 15px; }
.col-md-3, .col-md-4, .col-md-6, .col-md-12 { padding: 0 10px; margin-bottom: 15px; }
.col-md-3  { flex: 0 0 25%;  max-width: 25%; }
.col-md-4  { flex: 0 0 33.333%; max-width: 33.333%; }
.col-md-6  { flex: 0 0 50%;  max-width: 50%; }
.col-md-12 { flex: 0 0 100%; max-width: 100%; }

/* Paraf signature */
.sign-box-paraf { margin-top: 4px; }
.signature-box-paraf { width: 100%; height: 120px; border: 2px solid #999; background: white; border-radius: 4px; margin-bottom: 8px; }
.signature-preview-small { border: 2px solid #999; background: white; padding: 8px; border-radius: 4px; margin-bottom: 8px; }
.img-paraf { width: 100%; height: 100px; object-fit: contain; border: 1px dashed #ccc; background: white; display: block; }

.action-footer { margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; padding: 20px 0; border-top: 1px solid #e0e0e0; }
.btn-save-form { background: #0288d1; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #b0bec5; cursor: not-allowed; }
.btn-back { background: #ff9800; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ffcc80; cursor: not-allowed; }

.loading-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.95); display: flex; flex-direction: column; justify-content: center; align-items: center; font-size: 18px; z-index: 9999; }
.loading-overlay p { color: #333; font-weight: 500; margin: 0; }
.spinner-rme { width: 48px; height: 48px; border: 5px solid #ddd; border-top-color: #1d72c9; border-radius: 50%; animation: spin-rme 0.8s linear infinite; margin-bottom: 15px; }
@keyframes spin-rme { to { transform: rotate(360deg); } }

.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,251,251,0.1); z-index: 10; cursor: not-allowed; }
.form-wrapper { position: relative; }

@media (max-width: 768px) {
  .col-md-3, .col-md-4, .col-md-6 { flex: 0 0 100%; max-width: 100%; }
  .action-footer { flex-direction: column-reverse; }
  .btn-save-form, .btn-back { width: 100%; }
  .checkbox-grid { grid-template-columns: 1fr; }
}
</style>
