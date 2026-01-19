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
      <img src="/logo-rs.png" alt="Logo RS" class="logo-rs mb-3" style="max-width: 150px" />
      <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
      <p class="mb-1">VISION FOR THE NATION</p>
      <p class="mb-1">PRIMA VISION EYE HOSPITAL - 24 HOURS EYE ACCIDENT & EMERGENCY UNIT</p>
      <p class="mb-1">Jalan Pabrik Tenun No. 51-53, Medan Perjuangan 20112, Sumatera Utara, Indonesia</p>
      <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
      <p class="mb-1">24 Hours Eye Emergency Hotline: 0822 7755 5151</p>
      <p class="mb-3">Email: rsprimavision@gmail.com</p>
      <hr class="my-3" style="border: 2px solid #000" />
      
      <h3 class="fw-bold mt-4 mb-3">FORM TINDAKAN LASER</h3>
      <h4 class="fw-bold mb-4">Capsulotomy (Nd. YAG)</h4>
      
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
    </div>

    <!-- ================= DATA PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Data Pasien</h5>
      
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
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Jenis Kelamin :</label>
          <input type="text" v-model="form.jenis_kelamin_display" class="input-rme" readonly />
        </div>
        <div class="col-md-6">
          <label>1. Tanggal Lahir : <span class="text-danger">*</span></label>
          <input type="date" v-model="form.tanggal_lahir" class="form-control" />
        </div>
      </div>
    </div>

    <!-- ================= INFORMASI TINDAKAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Tindakan</h5>
      
      <div class="row mb-3">
        <div class="col-md-6">
          <label>2. Tanggal : <span class="text-danger">*</span></label>
          <input type="date" v-model="form.tanggal" class="form-control" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>3. Diagnosa : <span class="text-danger">*</span></label>
          <textarea 
            v-model="form.diagnosa" 
            class="form-control" 
            rows="3"
            placeholder="Contoh: Posterior Capsule Opacity (PCO) post cataract OD, After Cataract OS"
          ></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>4. Mata yang Ditindak : <span class="text-danger">*</span></label>
          <div class="checkbox-group">
            <div class="form-check form-check-inline">
              <input 
                type="checkbox" 
                v-model="form.mata_od" 
                class="form-check-input" 
                id="mataOD"
              />
              <label class="form-check-label" for="mataOD">
                <strong>OD (Mata Kanan)</strong>
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input 
                type="checkbox" 
                v-model="form.mata_os" 
                class="form-check-input" 
                id="mataOS"
              />
              <label class="form-check-label" for="mataOS">
                <strong>OS (Mata Kiri)</strong>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= PROSEDUR TINDAKAN (10 LANGKAH) ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Langkah-langkah Tindakan Laser Capsulotomy (Nd. YAG)</h5>
      
      <div class="procedure-steps">
        <div class="step-item">
          <span class="step-number">1.</span>
          <span class="step-text">Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%)</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">2.</span>
          <span class="step-text">Perawat mempersiapkan berkas kelengkapan tindakan laser</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">3.</span>
          <span class="step-text">Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">4.</span>
          <span class="step-text">Pasien diberi obat tetes Anestesi (Pantocain 0,5%)</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">5.</span>
          <span class="step-text">Pasien duduk menghadap ke alat laser</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">6.</span>
          <span class="step-text">Pasien menempelkan dagu dan dahi ke penyangga pada alat laser</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">7.</span>
          <span class="step-text">Dokter menyalakan alat YAG Laser</span>
        </div>
        
        <div class="step-item step-item-important">
          <span class="step-number">8.</span>
          <div class="step-content">
            <span class="step-text mb-2">Dilakukan tindakan laser dengan Parameter (Power) Laser :</span>
            <textarea 
              v-model="form.parameter_laser" 
              class="form-control mt-2" 
              rows="3"
              placeholder="Contoh:&#10;- Power: 2.5 mJ&#10;- Total shots: 45&#10;- Focus: Posterior capsule&#10;- Target area: Central 3mm"
            ></textarea>
          </div>
        </div>
        
        <div class="step-item">
          <span class="step-number">9.</span>
          <span class="step-text">Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">10.</span>
          <span class="step-text">Pasien diberikan resep obat dan surat kontrol</span>
        </div>
      </div>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <h5 class="section-title-rme text-center mb-4">Tanda Tangan DPJP / Dokter</h5>
      
      <div class="signature-section-single">
        <div class="sign-box-center">
          <label>5. Dokter Penanggung Jawab</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_dokter && !signatureCleared" class="signature-preview">
            <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
            <button @click="clearSignature()" class="btn-clear">
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
            <button @click="saveSign()" class="btn-save">Simpan ✔</button>
          </div>

          <input
            v-model="form.nama_dokter"
            class="input-rme mt-2"
            placeholder="Nama Dokter"
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
  name: "DokumenTindakanLaserCapsulotomy",

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
      signatureCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Data Pasien untuk form
        nama_pasien: "",
        no_rm_pasien: "",
        jenis_kelamin_display: "",

        // Form Input (5 fields sesuai requirement)
        tanggal_lahir: "",
        tanggal: "",
        diagnosa: "",
        mata_od: false,
        mata_os: false,

        // Parameter Laser (point 8)
        parameter_laser: "",

        // Tanda Tangan
        ttd_dokter: "",
        nama_dokter: "",
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
      // Set tanggal hari ini
      const today = new Date();
      this.form.tanggal = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";
      
      // Jenis kelamin display
      this.form.jenis_kelamin_display = this.selectedPatient?.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
      
      // Format tanggal lahir
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir = this.formatDate(new Date(this.selectedPatient.tanggal_lahir));
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
            `/master/pasien/dokumen-laser-capsulotomy/${this.editData}`
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

          // Format date fields
          if (data.tanggal_lahir) {
            this.form.tanggal_lahir = this.formatDate(new Date(data.tanggal_lahir));
          }
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

    clearSignature() {
      this.signatureCleared = true;
      this.form.ttd_dokter = "";

      // Reset signature pad di next tick
      this.$nextTick(() => {
        const pad = this.$refs.ttd_dokter;
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

    saveSign() {
      const pad = this.$refs.ttd_dokter;

      if (!pad) {
        console.error("REF tidak ditemukan: ttd_dokter");
        return;
      }

      const { isEmpty, data } = pad.saveSignature();

      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }

      this.form.ttd_dokter = data;
      console.log("TTD saved: ttd_dokter");
    },

    async submitForm() {
      // Validasi
      if (!this.form.tanggal_lahir) {
        alert("Mohon lengkapi Tanggal Lahir!");
        return;
      }

      if (!this.form.tanggal) {
        alert("Mohon lengkapi Tanggal Tindakan!");
        return;
      }

      if (!this.form.diagnosa) {
        alert("Mohon lengkapi Diagnosa!");
        return;
      }

      if (!this.form.mata_od && !this.form.mata_os) {
        alert("Mohon pilih minimal satu mata (OD atau OS)!");
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
          "/master/pasien/dokumen-laser-capsulotomy",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Form Tindakan Laser Capsulotomy berhasil diupdate!"
          : "Form Tindakan Laser Capsulotomy berhasil disimpan!";

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
.container {
  max-width: 1000px;
  margin: 0 auto;
}

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
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #fff;
}

/* CHECKBOX GROUP */
.checkbox-group {
  display: flex;
  gap: 30px;
  padding: 10px;
  background: white;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
}

.form-check-inline {
  margin-right: 20px;
}

.form-check-input {
  width: 20px;
  height: 20px;
  cursor: pointer;
}

.form-check-label {
  margin-left: 8px;
  cursor: pointer;
  font-size: 15px;
}

/* PROCEDURE STEPS STYLING */
.procedure-steps {
  background: white;
  padding: 20px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
}

.step-item {
  display: flex;
  margin-bottom: 15px;
  padding: 12px;
  background: #f8f9fa;
  border-radius: 4px;
  border-left: 3px solid #2d74b7;
}

.step-item-important {
  background: #fff9e6;
  border-left: 3px solid #ff9800;
}

.step-number {
  font-weight: bold;
  color: #2d74b7;
  min-width: 35px;
  font-size: 16px;
}

.step-text {
  flex: 1;
  line-height: 1.6;
  color: #333;
}

.step-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.signature-container {
  padding: 20px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section-single {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.sign-box-center {
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.sign-box-center label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
  font-size: 16px;
}

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
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
  font-weight: 500;
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
}

.btn-clear:hover {
  background: #d32f2f;
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
  padding: 12px 30px;
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
  background: #b0bec5;
  cursor: not-allowed;
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
  font-size: 14px;
}

.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 13px;
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
  background: rgba(255, 255, 255, 0.95);
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

.mb-2 {
  margin-bottom: 8px;
}

.logo-rs {
  display: block;
  margin: 0 auto;
}

hr {
  margin: 20px 0;
}

.fw-bold {
  font-weight: 700;
}

.text-uppercase {
  text-transform: uppercase;
}

.text-center {
  text-align: center;
}

.text-danger {
  color: #dc3545;
}
</style>