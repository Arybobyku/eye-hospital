<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="text-center mb-4">
      <h3 class="fw-bold">CHECKLIST KESELAMATAN PASIEN OPERASI</h3>
      <p class="text-muted">RM/4.9/CLKPO/22</p>
    </div>

    <!-- IDENTITAS PASIEN -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Identitas Pasien</h5>
      <div class="row mb-3">
        <div class="col-md-4">
          <label>No. RM</label>
          <input v-model="form.no_rm" class="input-rme" readonly />
        </div>
        <div class="col-md-8">
          <label>Nama</label>
          <input v-model="form.nama" class="input-rme" readonly />
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <label>Tanggal Lahir / Umur</label>
          <input v-model="form.tanggal_lahir" class="input-rme" readonly />
        </div>
        <div class="col-md-4">
          <label>Jenis Kelamin</label>
          <input v-model="form.jenis_kelamin" class="input-rme" readonly />
        </div>
        <div class="col-md-4">
          <label>NIK</label>
          <input v-model="form.nik" class="input-rme" />
        </div>
      </div>
    </div>

    <!-- 3 FASE CHECKLIST -->
    <div class="checklist-phases">
      <!-- FASE 1: SIGN IN -->
      <div class="phase-column">
        <div class="phase-header phase-signin">
          <h5>Sebelum Induksi Anestesi</h5>
          <p class="mb-0"><strong>Sign In</strong></p>
        </div>

        <div class="phase-content">
          <div class="mb-3">
            <label class="fw-bold">Waktu</label>
            <input type="time" v-model="form.signin_waktu" class="input-rme" />
          </div>

          <p class="phase-team">Minimal ada Perawat, Perawat Anestesi dan Dokter Anestesi</p>

          <!-- Q1 -->
          <div class="question-item">
            <p class="question-text">Apakah identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada persetujuan tindakan medis yang akan dilakukan (informed consent)?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q1" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q1" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q2 -->
          <div class="question-item">
            <p class="question-text">Apakah area yang akan dioperasi sudah diberi tanda?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q2" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q2" value="tidak_diperlukan" />
              Tidak diperlukan
            </label>
          </div>

          <!-- Q3 -->
          <div class="question-item">
            <p class="question-text">Apakah mesin anestesi dan obat-obatan sudah lengkap?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q3" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q3" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q4 -->
          <div class="question-item">
            <p class="question-text">Apakah sudah terpasang 'pulse oksimetri' pada pasien, dan sudah berfungsi baik?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q4" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q4" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q5 -->
          <div class="question-item">
            <p class="question-text">Apakah pasien memiliki riwayat alergi?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q5" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q5" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q6 -->
          <div class="question-item">
            <p class="question-text">Apakah pasien memiliki gangguan pernafasan?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q6" value="ya_tersedia" />
              Ya, dan alat/bantuan sudah tersedia
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q6" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q7 -->
          <div class="question-item">
            <p class="question-text">Resiko perdarahan > 500ml (7ml/kg bagi anak-anak)</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q7" value="ya_direncanakan" />
              Ya, dan sudah direncanakan pemasangan infus 2 line dan tersedia cairan-cairan yang akan diberikan
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signin_q7" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- SIGNATURE SIGN IN -->
          <div class="signature-section mt-4">
            <h6 class="fw-bold mb-3">Tanda Tangan dan Nama</h6>
            
            <div class="mb-3">
              <label>dr. Anestesi</label>
              <VueSignaturePad
                ref="signin_ttd_dr_anestesi"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signin_ttd_dr_anestesi')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signin_ttd_dr_anestesi')">Clear ✖</button>
              <input v-model="form.signin_nama_dr_anestesi" class="input-rme mt-2" placeholder="Nama dr. Anestesi" />
            </div>

            <div class="mb-3">
              <label>Perawat Anestesi</label>
              <VueSignaturePad
                ref="signin_ttd_perawat_anestesi"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signin_ttd_perawat_anestesi')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signin_ttd_perawat_anestesi')">Clear ✖</button>
              <input v-model="form.signin_nama_perawat_anestesi" class="input-rme mt-2" placeholder="Nama Perawat Anestesi" />
            </div>

            <div class="mb-3">
              <label>Perawat</label>
              <VueSignaturePad
                ref="signin_ttd_perawat"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signin_ttd_perawat')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signin_ttd_perawat')">Clear ✖</button>
              <input v-model="form.signin_nama_perawat" class="input-rme mt-2" placeholder="Nama Perawat" />
            </div>
          </div>
        </div>
      </div>

      <!-- FASE 2: TIME OUT -->
      <div class="phase-column">
        <div class="phase-header phase-timeout">
          <h5>Sebelum Insisi</h5>
          <p class="mb-0"><strong>Time Out</strong></p>
        </div>

        <div class="phase-content">
          <div class="mb-3">
            <label class="fw-bold">Waktu</label>
            <input type="time" v-model="form.timeout_waktu" class="input-rme" />
          </div>

          <p class="phase-team">Dengan Perawat, Perawat Anestesi, Dokter Anestesi dan Dokter Bedah</p>

          <!-- Q1 -->
          <div class="question-item">
            <p class="question-text">Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri (nama dan peran masing-masing)</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q1" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q1" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q2 -->
          <div class="question-item">
            <p class="question-text">Memastikan dan baca ulang nama pasien, tindakan medis dan area yang akan diinsisi.</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q2" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q2" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q3 -->
          <div class="question-item">
            <p class="question-text">Apakah profilaksis antibiotik sudah diberikan 1 jam sebelumnya?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q3" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q3" value="tidak_perlu" />
              Tidak perlu
            </label>
          </div>

          <!-- Q4 - Dokter Bedah -->
          <div class="question-item">
            <p class="question-text fw-bold">Kejadian beresiko yang perlu diantisipasi untuk Dokter Bedah:</p>
            
            <p class="question-text">Apakah tindakan beresiko atau tindakan tidak rutin yang akan dilakukan?</p>
            <textarea v-model="form.timeout_q4_tindakan_beresiko" class="textarea-rme" rows="3" placeholder="Jelaskan..."></textarea>
            
            <p class="question-text">Berapa lama tindakan ini akan dikerjakan?</p>
            <input v-model="form.timeout_q4_lama_tindakan" class="input-rme" placeholder="contoh: 2 jam" />
            
            <p class="question-text">Apakah sudah antisipasi perdarahan?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q4_antisipasi_perdarahan" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q4_antisipasi_perdarahan" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q5 - Dokter Anestesi -->
          <div class="question-item">
            <p class="question-text fw-bold">Untuk Dokter Anestesi</p>
            <p class="question-text">Apakah ada hal khusus untuk pasien ini?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q5" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q5" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q6 - Tim Perawat -->
          <div class="question-item">
            <p class="question-text fw-bold">Untuk Tim Perawat</p>
            
            <p class="question-text">Apakah sudah dipastikan kesterilan peralatan?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_kesterilan" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_kesterilan" value="tidak" />
              Tidak
            </label>

            <p class="question-text">Apakah alat implan yang dibutuhkan sudah disterilkan?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_implan" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_implan" value="tidak" />
              Tidak
            </label>

            <p class="question-text">Apakah ada masalah dengan peralatan atau masalah alat yang dikhawatirkan?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_masalah_alat" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_masalah_alat" value="tidak" />
              Tidak
            </label>

            <p class="question-text">Apakah hasil radiologi yang diperlukan sudah ada?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_radiologi" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.timeout_q6_radiologi" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- SIGNATURE TIME OUT -->
          <div class="signature-section mt-4">
            <h6 class="fw-bold mb-3">Tanda Tangan dan Nama</h6>
            
            <div class="mb-3">
              <label>dr. Anestesi</label>
              <VueSignaturePad
                ref="timeout_ttd_dr_anestesi"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('timeout_ttd_dr_anestesi')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('timeout_ttd_dr_anestesi')">Clear ✖</button>
              <input v-model="form.timeout_nama_dr_anestesi" class="input-rme mt-2" placeholder="Nama dr. Anestesi" />
            </div>

            <div class="mb-3">
              <label>Perawat Anestesi</label>
              <VueSignaturePad
                ref="timeout_ttd_perawat_anestesi"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('timeout_ttd_perawat_anestesi')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('timeout_ttd_perawat_anestesi')">Clear ✖</button>
              <input v-model="form.timeout_nama_perawat_anestesi" class="input-rme mt-2" placeholder="Nama Perawat Anestesi" />
            </div>

            <div class="mb-3">
              <label>Perawat Sirkuler</label>
              <VueSignaturePad
                ref="timeout_ttd_perawat_sirkuler"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('timeout_ttd_perawat_sirkuler')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('timeout_ttd_perawat_sirkuler')">Clear ✖</button>
              <input v-model="form.timeout_nama_perawat_sirkuler" class="input-rme mt-2" placeholder="Nama Perawat Sirkuler" />
            </div>
          </div>
        </div>
      </div>

      <!-- FASE 3: SIGN OUT -->
      <div class="phase-column">
        <div class="phase-header phase-signout">
          <h5>Sebelum Pasien Meninggalkan Kamar Operasi</h5>
          <p class="mb-0"><strong>Sign Out</strong></p>
        </div>

        <div class="phase-content">
          <div class="mb-3">
            <label class="fw-bold">Waktu</label>
            <input type="time" v-model="form.signout_waktu" class="input-rme" />
          </div>

          <p class="phase-team">Dengan Perawat, Perawat Anestesi, Dokter Anestesi dan Dokter Bedah</p>

          <!-- Q1 -->
          <div class="question-item">
            <p class="question-text">Secara verbal perawat memastikan nama tindakan</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q1" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q1" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q2 -->
          <div class="question-item">
            <p class="question-text">Kelengkapan alat, jumlah kasa dan jarum</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q2" value="lengkap" />
              Lengkap
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q2" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q3 -->
          <div class="question-item">
            <p class="question-text">Pelabelan specimen (baca label specimen dan nama pasien dengan keras)</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q3" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q3" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q4 -->
          <div class="question-item">
            <p class="question-text">Apakah ada masalah peralatan yang perlu disampaikan?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q4" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q4" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- Q5 -->
          <div class="question-item">
            <p class="question-text fw-bold">Untuk Dokter Bedah, Dokter Anestesi dan Perawat:</p>
            <p class="question-text">Apakah ada catatan khusus untuk proses recovery dan penanganan perawatan pasien ini?</p>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q5" value="ya" />
              Ya
            </label>
            <label class="radio-label">
              <input type="radio" v-model="form.signout_q5" value="tidak" />
              Tidak
            </label>
          </div>

          <!-- SIGNATURE SIGN OUT -->
          <div class="signature-section mt-4">
            <h6 class="fw-bold mb-3">Tanda Tangan dan Nama</h6>
            
            <div class="mb-3">
              <label>dr. Bedah</label>
              <VueSignaturePad
                ref="signout_ttd_dr_bedah"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signout_ttd_dr_bedah')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signout_ttd_dr_bedah')">Clear ✖</button>
              <input v-model="form.signout_nama_dr_bedah" class="input-rme mt-2" placeholder="Nama dr. Bedah" />
            </div>

            <div class="mb-3">
              <label>dr. Anestesi</label>
              <VueSignaturePad
                ref="signout_ttd_dr_anestesi"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signout_ttd_dr_anestesi')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signout_ttd_dr_anestesi')">Clear ✖</button>
              <input v-model="form.signout_nama_dr_anestesi" class="input-rme mt-2" placeholder="Nama dr. Anestesi" />
            </div>

            <div class="mb-3">
              <label>Perawat Anestesi</label>
              <VueSignaturePad
                ref="signout_ttd_perawat_anestesi"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signout_ttd_perawat_anestesi')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signout_ttd_perawat_anestesi')">Clear ✖</button>
              <input v-model="form.signout_nama_perawat_anestesi" class="input-rme mt-2" placeholder="Nama Perawat Anestesi" />
            </div>

            <div class="mb-3">
              <label>Perawat Instrument</label>
              <VueSignaturePad
                ref="signout_ttd_perawat_instrument"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signout_ttd_perawat_instrument')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signout_ttd_perawat_instrument')">Clear ✖</button>
              <input v-model="form.signout_nama_perawat_instrument" class="input-rme mt-2" placeholder="Nama Perawat Instrument" />
            </div>

            <div class="mb-3">
              <label>Perawat Sirkuler</label>
              <VueSignaturePad
                ref="signout_ttd_perawat_sirkuler"
                :options="sigOption"
                class="signature-box-small"
              />
              <button class="btn-save btn-sm" @click="saveSign('signout_ttd_perawat_sirkuler')">Simpan ✔</button>
              <button class="btn-clear btn-sm" @click="clearSign('signout_ttd_perawat_sirkuler')">Clear ✖</button>
              <input v-model="form.signout_nama_perawat_sirkuler" class="input-rme mt-2" placeholder="Nama Perawat Sirkuler" />
            </div>
          </div>

          <div class="mt-3">
            <label>Medan, Tanggal</label>
            <input type="date" v-model="form.tanggal_ttd" class="input-rme" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER ACTIONS -->
  <div class="action-footer">
    <button class="btn-save-form" @click="submitForm" :disabled="loading">
      {{ loading ? "Menyimpan..." : "Simpan Data" }}
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loading">Kembali</button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormChecklistKeselamatanPasienOperasi",
  props: {
    selectedPatient: { 
      type: Object, 
      required: true 
    },
    editUuid: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      loading: false,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        
        // Identitas
        no_rm: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        nik: "",
        
        // SIGN IN
        signin_waktu: "",
        signin_q1: "",
        signin_q2: "",
        signin_q3: "",
        signin_q4: "",
        signin_q5: "",
        signin_q6: "",
        signin_q7: "",
        signin_ttd_dr_anestesi: "",
        signin_nama_dr_anestesi: "",
        signin_ttd_perawat_anestesi: "",
        signin_nama_perawat_anestesi: "",
        signin_ttd_perawat: "",
        signin_nama_perawat: "",
        
        // TIME OUT
        timeout_waktu: "",
        timeout_q1: "",
        timeout_q2: "",
        timeout_q3: "",
        timeout_q4_tindakan_beresiko: "",
        timeout_q4_lama_tindakan: "",
        timeout_q4_antisipasi_perdarahan: "",
        timeout_q5: "",
        timeout_q6_kesterilan: "",
        timeout_q6_implan: "",
        timeout_q6_masalah_alat: "",
        timeout_q6_radiologi: "",
        timeout_ttd_dr_anestesi: "",
        timeout_nama_dr_anestesi: "",
        timeout_ttd_perawat_anestesi: "",
        timeout_nama_perawat_anestesi: "",
        timeout_ttd_perawat_sirkuler: "",
        timeout_nama_perawat_sirkuler: "",
        
        // SIGN OUT
        signout_waktu: "",
        signout_q1: "",
        signout_q2: "",
        signout_q3: "",
        signout_q4: "",
        signout_q5: "",
        signout_ttd_dr_bedah: "",
        signout_nama_dr_bedah: "",
        signout_ttd_dr_anestesi: "",
        signout_nama_dr_anestesi: "",
        signout_ttd_perawat_anestesi: "",
        signout_nama_perawat_anestesi: "",
        signout_ttd_perawat_instrument: "",
        signout_nama_perawat_instrument: "",
        signout_ttd_perawat_sirkuler: "",
        signout_nama_perawat_sirkuler: "",
        
        tanggal_ttd: "",
      },
    };
  },
  computed: {
    isEditMode() {
      return !!this.editUuid;
    }
  },
  mounted() {
    if (this.isEditMode) {
      this.loadDataForEdit();
    } else {
      this.setDataPasien();
    }
  },
  methods: {
    setDataPasien() {
      const p = this.selectedPatient;
      this.form.uuid_pasien = p?.uuid;
      this.form.nama = p?.nama;
      this.form.tanggal_lahir = p?.tanggal_lahir;
      this.form.no_rm = p?.rekam_medis;
      this.form.nik = p?.no_ktp;
      this.form.jenis_kelamin = p?.jenis_kelamin;
    },

    async loadDataForEdit() {
      try {
        console.log("Loading data for edit:", this.editUuid);
        const response = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=checklist_keselamatan_pasien_operasi`
        );

        if (response.data.status) {
          const data = response.data.data;
          
          Object.keys(this.form).forEach(key => {
            if (data[key] !== undefined) {
              this.form[key] = data[key];
            }
          });

          // Load semua signature
          this.$nextTick(() => {
            const signatureRefs = [
              'signin_ttd_dr_anestesi',
              'signin_ttd_perawat_anestesi',
              'signin_ttd_perawat',
              'timeout_ttd_dr_anestesi',
              'timeout_ttd_perawat_anestesi',
              'timeout_ttd_perawat_sirkuler',
              'signout_ttd_dr_bedah',
              'signout_ttd_dr_anestesi',
              'signout_ttd_perawat_anestesi',
              'signout_ttd_perawat_instrument',
              'signout_ttd_perawat_sirkuler',
            ];

            signatureRefs.forEach(ref => {
              if (this.form[ref] && this.$refs[ref]) {
                this.$refs[ref].fromDataURL(this.form[ref]);
              }
            });
          });
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit('back');
      }
    },

    saveSign(ref) {
      const pad = this.$refs[ref];
      if (!pad) {
        console.error("REF tidak ditemukan:", ref);
        return;
      }
      const { data } = pad.saveSignature();
      this.form[ref] = data;
      alert("Tanda Tangan Berhasil Disimpan");
      console.log("TTD saved:", ref);
    },

    clearSign(ref) {
      const pad = this.$refs[ref];
      if (!pad) return;
      pad.clearSignature();
      this.form[ref] = "";
    },

    async submitForm() {
      this.loading = true;
      try {
        const fd = new FormData();
        
        Object.keys(this.form).forEach((k) => {
          if (k === 'uuid' && !this.form[k]) {
            return;
          }
          fd.append(k, this.form[k] || '');
        });

        const response = await axios.post(
          "/master/pasien/dokumen-checklist-keselamatan-pasien-operasi", 
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message || "Data berhasil disimpan");
          this.$emit("back");
        }
      } catch (e) {
        console.error("Error:", e.response?.data || e);
        alert("Gagal menyimpan data");
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
/* BOX & SECTION */
.box-rme {
  border: 1px solid #ddd;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
}
.section-title-rme {
  font-weight: bold;
  color: #2d74b7;
  margin-bottom: 15px;
}

/* 3 PHASE COLUMNS */
.checklist-phases {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 15px;
  margin-bottom: 20px;
}

@media (max-width: 992px) {
  .checklist-phases {
    grid-template-columns: 1fr;
  }
}

.phase-column {
  border: 2px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  background: white;
}

.phase-header {
  padding: 15px;
  color: white;
  text-align: center;
}
.phase-header h5 {
  margin: 0;
  font-size: 16px;
  font-weight: bold;
}
.phase-header p {
  margin: 5px 0 0 0;
  font-size: 14px;
}

.phase-signin {
  background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
}
.phase-timeout {
  background: linear-gradient(135deg, #43a047 0%, #2e7d32 100%);
}
.phase-signout {
  background: linear-gradient(135deg, #fb8c00 0%, #e65100 100%);
}

.phase-content {
  padding: 20px;
}

.phase-team {
  font-size: 13px;
  font-style: italic;
  color: #666;
  margin-bottom: 15px;
  padding: 8px;
  background: #f0f0f0;
  border-left: 3px solid #2d74b7;
}

/* QUESTION ITEMS */
.question-item {
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}
.question-item:last-child {
  border-bottom: none;
}

.question-text {
  font-size: 14px;
  margin-bottom: 8px;
  color: #333;
  line-height: 1.5;
}

.radio-label {
  display: block;
  margin-bottom: 6px;
  font-size: 14px;
  cursor: pointer;
}
.radio-label input[type="radio"] {
  margin-right: 8px;
  cursor: pointer;
}

/* INPUTS */
.input-rme,
.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  padding: 8px;
  border-radius: 4px;
  margin-bottom: 10px;
  background: white;
  font-size: 14px;
}
.textarea-rme {
  resize: vertical;
}

/* SIGNATURE */
.signature-section {
  border-top: 2px solid #ddd;
  padding-top: 15px;
}
.signature-box-small {
  width: 100%;
  height: 120px;
  border: 1px solid #999;
  margin-bottom: 8px;
  background: white;
}

/* BUTTONS */
.btn-save,
.btn-clear {
  padding: 4px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}
.btn-save {
  background: #1e88e5;
  color: white;
}
.btn-clear {
  background: #e53935;
  color: white;
  margin-left: 5px;
}
.btn-sm {
  font-size: 11px;
  padding: 3px 8px;
}

/* ACTION FOOTER */
.action-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 40px;
  padding: 20px 0;
}
.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.btn-back {
  background: #ff9800;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.btn-save-form:disabled,
.btn-back:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>