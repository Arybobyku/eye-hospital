<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- LOADING OVERLAY -->
      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">SURAT KONTROL</h2>
        <h5 class="text-muted">Rumah Sakit Khusus Mata Prima Vision</h5>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>

          <div class="col-md-6">
            <label>Tempat, Tanggal Lahir :</label>
            <input type="text" v-model="form.tempat_tanggal_lahir" class="input-rme" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa</h5>

        <div class="row">
          <div class="col-md-12">
            <textarea
              v-model="form.diagnosa"
              class="textarea-rme"
              rows="3"
              placeholder="Masukkan diagnosa pasien..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TINDAK LANJUT YANG DIANJURKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tindak Lanjut Yang Dianjurkan</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>1. Pengobatan, dengan obat :</label>
            <textarea
              v-model="form.pengobatan_dengan_obat"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan daftar obat dan dosis..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= KONTROL LEBIH LANJUT ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Kontrol Lebih Lanjut</h5>

        <div class="row mb-3">
          <div class="col-md-12 mb-3">
            <label>1) Kontrol ulang di Rumah Sakit Khusus Mata Prima Vision Medan</label>
            <div class="row mt-2">
              <div class="col-md-6">
                <label>Tanggal Kontrol :</label>
                <input
                  type="date"
                  v-model="form.tanggal_kontrol_rs"
                  class="form-control"
                />
              </div>
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <label>2) Kontrol di Fasilitas Kesehatan Tingkat Pertama</label>
            <div class="row mt-2">
              <div class="col-md-6">
                <label>Tanggal Kontrol :</label>
                <input
                  type="date"
                  v-model="form.tanggal_kontrol_faskes"
                  class="form-control"
                />
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <label>3) Sembuh</label>
            <div class="form-check mt-2">
              <input
                type="checkbox"
                v-model="form.status_sembuh"
                class="form-check-input"
                id="checkSembuh"
              />
              <label class="form-check-label" for="checkSembuh">
                Pasien dinyatakan sembuh
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= TEMPAT & TANGGAL ================= -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="tanggal-tempat">Medan, {{ formatTanggal(form.tanggal_surat) }}</div>
        </div>
      </div>

      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <div class="signature-section">
          <!-- Dokter DPJP -->
          <div class="sign-box">
            <label>DPJP</label>

            <!-- Preview TTD yang sudah ada -->
            <div
              v-if="form.ttd_dpjp && !signatureCleared.ttd_dpjp"
              class="signature-preview"
            >
              <img :src="form.ttd_dpjp" alt="TTD DPJP" class="img-signature" />
              <button @click="clearSignature('ttd_dpjp')" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_dpjp"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('ttd_dpjp')" class="btn-save">Simpan ✔</button>
            </div>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dpjp" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter</option>
                <option
                  v-for="dokter in listDokter"
                  :key="dokter.id"
                  :value="dokter.nama"
                >
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
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
  name: "SuratKontrol",

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
        ttd_dpjp: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        tanggal_surat: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Informasi Pasien
        nama_pasien: "",
        tempat_tanggal_lahir: "",
        no_rm_pasien: "",

        // Diagnosa
        diagnosa: "",

        // Tindak Lanjut
        pengobatan_dengan_obat: "",

        // Kontrol Lebih Lanjut
        tanggal_kontrol_rs: "",
        tanggal_kontrol_faskes: "",
        status_sembuh: false,

        // Tanda Tangan
        ttd_dpjp: "",
        nama_dpjp: "",
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
    await this.fetchDokter();
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
    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
      } catch (error) {
        console.error('Gagal memuat data dokter:', error);
      }
    },
    setDataForm() {
      const today = new Date();
      this.form.tanggal_surat = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.no_identitas || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";

      // Format tempat tanggal lahir
      if (this.selectedPatient?.tempat_lahir && this.selectedPatient?.tanggal_lahir) {
        this.form.tempat_tanggal_lahir = `${
          this.selectedPatient.tempat_lahir
        }, ${this.formatTanggal(this.selectedPatient.tanggal_lahir)}`;
      } else if (this.selectedPatient?.tanggal_lahir) {
        this.form.tempat_tanggal_lahir = this.formatTanggal(
          this.selectedPatient.tanggal_lahir
        );
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
            `/master/pasien/dokumen-surat-kontrol/${this.editData}`
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
          if (data.tanggal_surat) {
            this.form.tanggal_surat = this.formatDate(new Date(data.tanggal_surat));
          }
          if (data.tanggal_kontrol_rs) {
            this.form.tanggal_kontrol_rs = this.formatDate(
              new Date(data.tanggal_kontrol_rs)
            );
          }
          if (data.tanggal_kontrol_faskes) {
            this.form.tanggal_kontrol_faskes = this.formatDate(
              new Date(data.tanggal_kontrol_faskes)
            );
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

      // Reset signature pad di next tick
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) {
          pad.clearSignature();
        }
      });
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
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi
      if (!this.form.diagnosa) {
        alert("Mohon isi diagnosa!");
        return;
      }

      if (!this.form.ttd_dpjp) {
        alert("Mohon lengkapi tanda tangan DPJP!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          // Convert boolean ke string untuk FormData
          if (typeof this.form[key] === "boolean") {
            fd.append(key, this.form[key] ? "1" : "0");
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const response = await axios.post("/master/pasien/dokumen-surat-kontrol", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Surat Kontrol berhasil diupdate!"
          : "Surat Kontrol berhasil disimpan!";

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

/* ================= TYPOGRAPHY ================= */
.fw-bold {
  font-weight: 700;
}

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

.text-center h2 {
  font-size: 22px;
  margin-bottom: 5px;
  color: #333;
  letter-spacing: 0.5px;
}

.text-center h5 {
  font-size: 15px;
  margin-bottom: 15px;
  font-weight: normal;
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
  margin-bottom: 20px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
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
  min-height: 100px;
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

/* ================= CHECKBOX STYLING ================= */
.form-check {
  padding-left: 0;
  margin-top: 10px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.form-check-input {
  width: 18px;
  height: 18px;
  cursor: pointer;
  margin: 0;
}

.form-check-label {
  cursor: pointer;
  margin: 0;
  user-select: none;
  font-size: 14px;
  color: #333;
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
  margin-bottom: 15px;
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

.dropdown-dokter {
  position: relative;
  width: 100%;
}

.form-select-dokter {
  width: 100%;
  padding: 10px 40px 10px 14px;
  font-size: 14px;
  color: #2d3748;
  background-color: #fff;
  border: 1.5px solid #cbd5e0;
  border-radius: 10px;
  appearance: none;
  -webkit-appearance: none;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
  outline: none;
}

.form-select-dokter:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.form-select-dokter:hover {
  border-color: #a0aec0;
}

.dropdown-icon {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
  font-size: 16px;
  pointer-events: none;
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

/* ================= LOADING OVERLAY ================= */
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

  .form-check-label {
    font-size: 13px;
  }
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
.form-wrapper {
  position: relative;
}
</style>
