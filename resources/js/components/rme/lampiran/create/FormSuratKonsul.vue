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
      <h2 class="fw-bold">SURAT KONSUL</h2>
      <h5 class="text-muted">REFERAL LETTER</h5>
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
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
      <p class="small text-muted">Herewith, we would like to refer following patient:</p>

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
        Atas bantuannya, kami ucapkan banyak terima kasih<br/>
        <em>Really appreciate to your assistance. Thank you in advanced and we are looking forward to receiving your report.</em>
      </p>
    </div>

    <!-- ================= TEMPAT & TANGGAL ================= -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="tanggal-tempat">
          Medan, {{ formatTanggal(form.tanggal) }}
        </div>
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
          <div v-if="form.ttd_dokter && !signatureCleared.ttd_dokter" class="signature-preview">
            <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
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
  name: "SuratKonsul",

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
      this.form.tanggal = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

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

        const response = await axios.post(
          "/master/pasien/dokumen-surat-konsul",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

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

.small {
  font-size: 0.875rem;
}

.text-muted {
  color: #6c757d;
}
</style>