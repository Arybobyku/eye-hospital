<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <!-- LOADING OVERLAY -->
    <div v-if="loadingData" class="loading-overlay">
      <div class="spinner-rme"></div>
      <p>Memuat data...</p>
    </div>

    <!-- ================= HEADER ================= -->
    <div class="text-center mb-4">
      <h2 class="fw-bold">SURAT KONTROL</h2>
      <h5 class="text-muted">Rumah Sakit Khusus Mata Prima Vision</h5>
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
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
        <div class="tanggal-tempat">
          Medan, {{ formatTanggal(form.tanggal_surat) }}
        </div>
      </div>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <div class="signature-section">
        <!-- Dokter DPJP -->
        <div class="sign-box">
          <label>DPJP</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_dpjp && !signatureCleared.ttd_dpjp" class="signature-preview">
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

          <input
            v-model="form.nama_dpjp"
            class="input-rme mt-2"
            placeholder="Nama Jelas DPJP"
          />
        </div>
      </div>
    </div>
  </div>

  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer">
    <!-- TOMBOL SUBMIT -->
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
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

  mounted() {
    if (this.editData) {
      this.loadEditData();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    setDataForm() {
      const today = new Date();
      this.form.tanggal_surat = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";
      
      // Format tempat tanggal lahir
      if (this.selectedPatient?.tempat_lahir && this.selectedPatient?.tanggal_lahir) {
        this.form.tempat_tanggal_lahir = `${this.selectedPatient.tempat_lahir}, ${this.formatTanggal(this.selectedPatient.tanggal_lahir)}`;
      } else if (this.selectedPatient?.tanggal_lahir) {
        this.form.tempat_tanggal_lahir = this.formatTanggal(this.selectedPatient.tanggal_lahir);
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
            this.form.tanggal_kontrol_rs = this.formatDate(new Date(data.tanggal_kontrol_rs));
          }
          if (data.tanggal_kontrol_faskes) {
            this.form.tanggal_kontrol_faskes = this.formatDate(new Date(data.tanggal_kontrol_faskes));
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
          if (typeof this.form[key] === 'boolean') {
            fd.append(key, this.form[key] ? '1' : '0');
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-surat-kontrol",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

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
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  font-size: 16px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #fff;
}

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #fff;
  resize: vertical;
}

.signature-container {
  padding: 20px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
}

.signature-section {
  display: flex;
  justify-content: center;
  margin-top: 30px;
  margin-bottom: 20px;
}

.sign-box {
  width: 45%;
  text-align: center;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
}

.signature-box-rme {
  width: 100%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
  background: white;
}

.signature-preview {
  width: 100%;
  border: 1px solid #999;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.img-signature {
  max-width: 100%;
  height: 160px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 5px 12px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
}

.btn-save:hover {
  background: #1565c0;
}

.btn-clear {
  background: #f44336;
  color: white;
  padding: 5px 12px;
  border: none;
  border-radius: 4px;
  margin-top: 10px;
  cursor: pointer;
  font-size: 12px;
}

.btn-clear:hover {
  background: #d32f2f;
}

.tanggal-tempat {
  text-align: right;
  font-weight: bold;
  margin-top: 20px;
  font-size: 14px;
}

.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 0;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}

.btn-save-form:hover {
  background: #0277bd;
}

.btn-save-form:disabled {
  background: #b0bec5;
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
}

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ffcc80;
  cursor: not-allowed;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  color: #555;
}

.badge {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: bold;
  margin-left: 10px;
}

.badge.bg-warning {
  background: #ff9800;
  color: white;
}

.badge.bg-success {
  background: #4caf50;
  color: white;
}

/* LOADING OVERLAY */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  z-index: 9999;
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

.mt-2 {
  margin-top: 8px;
}
</style>