<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <!-- OVERLAY SAAT VIEW -->
      <div v-if="disabledSubmit" class="view-overlay"></div>

      <!-- LOADING OVERLAY -->
      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">SURAT KONSUL</h2>
        <h5 class="text-muted">REFERAL LETTER</h5>
        <p class="text-muted">{{ form.no_surat}}</p>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
      </div>

      <!-- DATE -->
      <div class="row mb-3">
        <div class="col-md-12 mb-2">
          <label>Tanggal / Date :</label>
          <input type="date" v-model="form.tanggal" class="form-control" />
        </div>
      </div>

      <!-- ================= KEPADA YANG TERHORMAT ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Kepada Yang Terhormat / Dear Collegue</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>TS. PROF/DR :</label>
            <input
              type="text"
              v-model="form.tujuan_nama_dokter"
              class="input-rme"
              placeholder="Masukkan nama dokter tujuan konsul..."
            />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label>Di/In :</label>
            <input
              type="text"
              v-model="form.tujuan_lokasi"
              class="input-rme"
              placeholder="Masukkan lokasi/rumah sakit tujuan..."
            />
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Bersama ini kami konsulkan pasien</h5>
        <p class="small text-muted">
          Herewith, we would like to refer following patient:
        </p>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama / Name :</label>
            <input type="text" v-model="form.pasien_nama" class="input-rme" readonly />
          </div>

          <div class="col-md-6">
            <label>Umur / Age :</label>
            <input type="text" v-model="form.pasien_umur" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Keluhan Utama / Chief Complaint :</label>
            <textarea
              v-model="form.keluhan_utama"
              class="textarea-rme"
              rows="2"
              placeholder="Masukkan keluhan utama pasien..."
            ></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label>Diagnosa Sementara / Differential Diagnosis :</label>
            <textarea
              v-model="form.diagnosa_sementara"
              class="textarea-rme"
              rows="3"
              placeholder="Masukkan diagnosa sementara..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= PENGOBATAN & TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pengobatan & Tindakan yang telah diberikan</h5>
        <p class="small text-muted">Medication & Treatments Given:</p>

        <div class="row">
          <div class="col-md-12">
            <textarea
              v-model="form.pengobatan_tindakan"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan daftar pengobatan dan tindakan yang telah diberikan..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= PENUTUP ================= -->
      <div class="box-rme mb-4">
        <p style="text-align: justify; line-height: 1.8">
          Atas bantuannya, kami ucapkan banyak terima kasih<br />
          <em
            >Really appreciate to your assistance. Thank you in advanced and we are
            looking forward to receiving your report.</em
          >
        </p>
      </div>

      <!-- ================= TEMPAT & TANGGAL ================= -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="tanggal-tempat">Medan, {{ formatTanggal(form.tanggal) }}</div>
        </div>
      </div>

      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <div class="signature-section">
          <!-- Dokter Penanggung Jawab -->
          <div class="sign-box">
            <label>Hormat kami / With Regards,</label>
            <label class="mt-2">Dokter Penanggung Jawab / Attending Doctor</label>

            <!-- Preview TTD yang sudah ada -->
            <div
              v-if="form.ttd_dokter && !signatureCleared.ttd_dokter"
              class="signature-preview"
            >
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <p v-if="form.dokter_ttd_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.dokter_ttd_timestamp }}
              </p>
              <button @click="clearSignature('ttd_dokter')" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_dokter"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('ttd_dokter')" class="btn-save">Simpan ✔</button>
            </div>

            <input
              v-model="form.nama_dokter_pengirim"
              class="input-rme mt-2"
              placeholder="Tanda tangan Dr & Stempel & Doctor's Stamp"
            />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer" v-if="!disabledSubmit">
    <!-- TOMBOL SUBMIT -->
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? "Update" : "Save" }}</span>
    </button>

    <!-- TOMBOL BACK -->
    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
      Back
    </button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SuratKonsul",

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    viewData: {
      type: Object,
      default: null,
    },
    editData: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      loadingSubmit: false,
      loadingData: false,
      isEditMode: false,
      disabledSubmit: false,
      signatureCleared: {
        ttd_dokter: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        tanggal: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        no_surat: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Kepada Yang Terhormat
        tujuan_nama_dokter: "",
        tujuan_lokasi: "",

        // Informasi Pasien
        pasien_nama: "",
        pasien_umur: "",
        keluhan_utama: "",
        diagnosa_sementara: "",

        // Pengobatan & Tindakan
        pengobatan_tindakan: "",

        // Tanda Tangan
        ttd_dokter: "",
        nama_dokter_pengirim: "",
        dokter_ttd_timestamp: "",
      },
    };
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(newVal) {
        if (newVal && !this.isEditMode) {
          this.setDataForm();
        }
      },
    },
    editData: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.loadEditData();
        }
      },
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
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';

        if (!this.form.no_surat) {
          this.form.no_surat = `RM 8.5/SK/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 8.5/SK/22';
        }
      }
    },
    setDataForm() {
      const today = new Date();
      this.form.tanggal = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.no_identitas || "";

      // Data pasien untuk form
      this.form.pasien_nama = this.selectedPatient?.nama || "";

      // Hitung umur dari tanggal lahir
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.pasien_umur = this.calculateAge(this.selectedPatient.tanggal_lahir);
      }
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-surat-konsul/${this.editData}`
          );
          data = response.data.data;
        } else {
          // Jika editData sudah berupa object
          data = this.editData;
        }

        if (data) {
          // Populate form dengan data yang ada
          Object.keys(this.form).forEach((key) => {
            if (data[key] !== undefined && data[key] !== null) {
              this.form[key] = data[key];
            }
          });

          // Format tanggal jika perlu
          if (data.tanggal) {
            this.form.tanggal = this.formatDate(new Date(data.tanggal));
          }

          console.log("Data loaded for edit:", this.form);
        }
      } catch (error) {
        console.error("Error loading edit data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      } finally {
        this.loadingData = false;
      }
    },

    clearSignature(refName) {
      this.signatureCleared[refName] = true;
      this.form[refName] = "";

      if (refName === 'ttd_dokter') this.form.dokter_ttd_timestamp = "";

      // Reset signature pad di next tick
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) {
          pad.clearSignature();
        }
      });
    },

    calculateAge(birthDate) {
      if (!birthDate) return "";

      const today = new Date();
      const birth = new Date(birthDate);
      let age = today.getFullYear() - birth.getFullYear();
      const monthDiff = today.getMonth() - birth.getMonth();

      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
      }

      return `${age} tahun`;
    },

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return d.toISOString().split("T")[0];
    },

    formatTanggal(dateStr) {
      if (!dateStr) return "";
      const options = { year: "numeric", month: "long", day: "numeric" };
      const d = new Date(dateStr);
      return d.toLocaleDateString("id-ID", options);
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
      this.signatureCleared[refName] = false;

      const now = new Date();
      const timestamp = now.toLocaleString('id-ID', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit'
      });
    
      if (refName === 'ttd_dokter') this.form.dokter_ttd_timestamp = timestamp
      
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi
      if (!this.form.tujuan_nama_dokter || !this.form.tujuan_lokasi) {
        alert("Mohon lengkapi data dokter dan lokasi tujuan konsul!");
        return;
      }

      if (!this.form.keluhan_utama || !this.form.diagnosa_sementara) {
        alert("Mohon lengkapi keluhan utama dan diagnosa sementara!");
        return;
      }

      if (!this.form.ttd_dokter) {
        alert("Mohon lengkapi tanda tangan dokter!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post("/master/pasien/dokumen-surat-konsul", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Surat Konsul berhasil diupdate!"
          : "Surat Konsul berhasil disimpan!";

        alert(message);

        this.$emit("back");
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan data!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>
<style scoped>
/* ================= CONTAINER & LAYOUT ================= */
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
}

.py-4 {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
}

.form-wrapper {
  position: relative;
}

/* ================= TYPOGRAPHY ================= */
.fw-bold {
  font-weight: 700;
}

.fw-semibold {
  font-weight: 600;
}

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

.small {
  font-size: 0.875rem;
}

.text-center h2 {
  font-size: 20px;
  margin-bottom: 5px;
  color: #333;
  letter-spacing: 0.5px;
}

.text-center h4 {
  font-size: 16px;
  margin-bottom: 10px;
  color: #555;
}

.text-center h5 {
  font-size: 15px;
  margin-bottom: 15px;
  font-weight: normal;
}

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

/* ================= BADGE ================= */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: bold;
  margin-left: 10px;
  margin-top: 10px;
}

.badge.bg-warning {
  background: #ff9800;
  color: white;
}

.badge.bg-success {
  background: #4caf50;
  color: white;
}

/* ================= BOX & SECTIONS ================= */
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
  margin-bottom: 20px;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.box-rme p {
  text-align: justify;
  line-height: 1.8;
  font-size: 14px;
  color: #333;
  margin-bottom: 10px;
}

.box-rme p:last-child {
  margin-bottom: 0;
}

.box-rme p em {
  color: #666;
  font-size: 13px;
  display: block;
  margin-top: 5px;
}

.box-rme .small {
  display: block;
  margin-bottom: 10px;
  font-style: italic;
}

/* ================= FORM ELEMENTS ================= */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px 12px;
  background: #fff;
  font-size: 14px;
  transition: border-color 0.3s;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
}

.input-rme[readonly] {
  background: #f5f5f5;
  cursor: not-allowed;
  color: #666;
}

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 12px;
  background: #fff;
  resize: vertical;
  font-family: "Arial", sans-serif;
  line-height: 1.6;
  font-size: 14px;
  min-height: 80px;
  transition: border-color 0.3s;
}

.textarea-rme:focus {
  outline: none;
  border-color: #2d74b7;
}

.form-control {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.3s;
}

.form-control:focus {
  outline: none;
  border-color: #2d74b7;
}

/* ================= ROW & COLUMNS ================= */
.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -10px;
}

.mb-2 {
  margin-bottom: 10px;
}

.mb-3 {
  margin-bottom: 15px;
}

.mb-4 {
  margin-bottom: 20px;
}

.mt-2 {
  margin-top: 10px;
}

.col-md-6,
.col-md-12 {
  padding: 0 10px;
  margin-bottom: 15px;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

/* ================= TANGGAL TEMPAT ================= */
.tanggal-tempat {
  text-align: right;
  font-weight: bold;
  margin-top: 25px;
  font-size: 14px;
  color: #333;
}

/* ================= SIGNATURE SECTION ================= */
.signature-container {
  padding: 25px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  margin-top: 20px;
  margin-bottom: 20px;
}

.sign-box {
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 8px;
  color: #333;
  font-size: 14px;
  line-height: 1.4;
}

/* ================= SIGNATURE PAD & PREVIEW ================= */
.signature-box-rme {
  width: 100%;
  height: 180px;
  border: 2px solid #999;
  margin-bottom: 10px;
  margin-top: 15px;
  background: white;
  border-radius: 4px;
}

.signature-preview {
  width: 100%;
  border: 2px solid #999;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
  margin-top: 15px;
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

/* ================= BUTTONS ================= */
.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
  transition: background 0.3s;
}

.btn-save:hover {
  background: #1565c0;
}

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  margin-top: 10px;
  cursor: pointer;
  font-size: 12px;
  transition: background 0.3s;
}

.btn-clear:hover {
  background: #d32f2f;
}

.btn-back {
  background: #ff9800;
  color: white;
  padding: 12px 30px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s;
}

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ffcc80;
  cursor: not-allowed;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 12px 30px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s;
}

.btn-save-form:hover {
  background: #0277bd;
}

.btn-save-form:disabled {
  background: #b0bec5;
  cursor: not-allowed;
}

/* ================= ACTION FOOTER ================= */
.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 0;
  border-top: 1px solid #e0e0e0;
}

/* ================= OVERLAYS ================= */
.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.1);
  z-index: 10;
  cursor: not-allowed;
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.95);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  z-index: 9999;
}

.loading-overlay p {
  color: #333;
  font-weight: 500;
  margin: 0;
}

.spinner-rme {
  width: 48px;
  height: 48px;
  border: 5px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .container {
    padding: 15px;
  }

  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .sign-box {
    max-width: 100%;
  }

  .action-footer {
    flex-direction: column-reverse;
  }

  .btn-save-form,
  .btn-back {
    width: 100%;
  }

  .text-center h2 {
    font-size: 18px;
  }

  .text-center h4 {
    font-size: 15px;
  }

  .text-center h5 {
    font-size: 14px;
  }

  .box-rme {
    padding: 15px;
  }

  .tanggal-tempat {
    text-align: center;
    margin-top: 20px;
  }

  .signature-box-rme {
    height: 200px;
  }

  .img-signature {
    height: 200px;
  }
}

@media (max-width: 480px) {
  .section-title-rme {
    font-size: 15px;
  }

  label {
    font-size: 13px;
  }

  .box-rme p {
    font-size: 13px;
  }

  .box-rme p em {
    font-size: 12px;
  }
}
</style>
