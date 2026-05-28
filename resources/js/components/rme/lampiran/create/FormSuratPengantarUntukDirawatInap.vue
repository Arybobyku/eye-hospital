<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

        <!-- OVERLAY SAAT VIEW -->
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- ================= HEADER ================= -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">SURAT PENGANTAR UNTUK DIRAWAT INAP</h2>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        </div>

        <!-- ================= INFORMASI PASIEN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>

          <div class="info-row">
            <span class="info-label">Nama</span>
            <span class="colon">:</span>
            <span class="info-value">{{ form.nama }}</span>
          </div>

          <div class="info-row">
            <span class="info-label">Tanggal Lahir</span>
            <span class="colon">:</span>
            <span class="info-value">{{ formatTanggalLahir }}</span>
          </div>

          <div class="info-row">
            <span class="info-label">Jenis Kelamin</span>
            <span class="colon">:</span>
            <span class="info-value">{{ form.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
          </div>

          <div class="info-row">
            <span class="info-label">No. RM</span>
            <span class="colon">:</span>
            <span class="info-value">{{ form.no_rm }}</span>
          </div>

          <div class="info-row">
            <span class="info-label">NIK</span>
            <span class="colon">:</span>
            <span class="info-value">{{ form.nik }}</span>
          </div>
        </div>

        <!-- ================= DATA SURAT PENGANTAR ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Data Surat Pengantar</h5>

        <!-- ASAL RUANGAN -->
        <div class="mb-3">
          <label class="fw-bold mb-2">
            Asal Ruangan: <span style="color: red;">*</span>
          </label>
          <div class="checkbox-group">
            <label class="checkbox-item">
              <input 
                type="checkbox" 
                value="IGD" 
                :checked="form.asal_ruangan.includes('IGD')"
                @change="handleAsalRuanganChange('IGD')"
              />
              <span class="ml-2">IGD</span>
            </label>
            <label class="checkbox-item">
              <input 
                type="checkbox" 
                value="Poliklinik" 
                :checked="form.asal_ruangan.includes('Poliklinik')"
                @change="handleAsalRuanganChange('Poliklinik')"
              />
              <span class="ml-2">Poliklinik</span>
            </label>
          </div>
          
          <!-- Input Poliklinik jika dipilih -->
          <div v-if="form.asal_ruangan.includes('Poliklinik')" class="mt-2">
            <input
              type="text"
              v-model="form.nama_poliklinik"
              class="input-rme"
              placeholder="Nama Poliklinik..."
            />
          </div>
        </div>

          <!-- RENCANA PERAWATAN DI -->
          <div class="mb-3">
            <label class="fw-bold mb-2">
              Rencana perawatan di: <span style="color: red;">*</span>
            </label>
            <input
              type="text"
              v-model="form.rencana_perawatan"
              class="input-rme"
              placeholder="Contoh: Ruang ICU, Ruang VIP, dll..."
            />
          </div>

          <!-- DIVIDER -->
          <div class="consent-text mb-3">
            Bersama ini kami kirimkan pasien tersebut diatas untuk dirawat inap:
          </div>

          <!-- KARENA MENDERITA -->
          <div class="mb-3">
            <label class="fw-bold mb-2">
              Karena menderita: <span style="color: red;">*</span>
            </label>
            <textarea
              v-model="form.karena_menderita"
              class="textarea-rme"
              placeholder="Diagnosis/penyakit yang diderita pasien..."
              rows="2"
            ></textarea>
          </div>

          <!-- SARAN TERAPI -->
          <div class="mb-3">
            <label class="fw-bold mb-2">
              Saran Terapi: <span style="color: red;">*</span>
            </label>
            <textarea
              v-model="form.saran_terapi"
              class="textarea-rme"
              placeholder="Saran pengobatan/terapi yang direkomendasikan..."
              rows="3"
            ></textarea>
          </div>

          <!-- RENCANA TINDAKAN -->
          <div class="mb-3">
            <label class="fw-bold mb-2">
              Rencana Tindakan: <span style="color: red;">*</span>
            </label>
            <textarea
              v-model="form.rencana_tindakan"
              class="textarea-rme"
              placeholder="Tindakan medis yang akan dilakukan..."
              rows="4"
            ></textarea>
          </div>

          <!-- CONSENT TEXT -->
          <div class="consent-text mt-4">
            Mohon ditindaklanjuti untuk rencana tindakan terapi.
          </div>

          <!-- TANGGAL -->
          <div class="row mb-3 mt-4">
            <div class="col-md-6">
              <div style="display: flex; align-items: center; gap: 10px;">
                <span>Medan,</span>
                <input
                  type="date"
                  v-model="form.tanggal"
                  class="input-rme"
                  style="width: 200px;"
                />
              </div>
            </div>
          </div>

          <!-- SIGNATURE DOKTER -->
          <div class="signature-single">
            <label class="fw-bold mb-2 text-center">Dokter yang memeriksa</label>
            
            <div v-if="form.ttd_dokter && !ttdDokterCleared" class="signature-preview text-center">
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <p v-if="form.ttd_dokter_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.ttd_dokter_timestamp }}
              </p>
              <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>
            
            <div v-else class="text-center">
              <VueSignaturePad 
                ref="ttd_dokter" 
                :options="sigOption" 
                class="signature-box-rme mx-auto" 
              />
              <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">
                Simpan ✔
              </button>
            </div>

            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter_ttd" class="form-select-dokter">
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

      <!-- ================= BUTTON BOTTOM ================= -->
      <div class="action-footer" v-if="!disabledSubmit">
        <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
          <span v-if="loadingSubmit">Menyimpan...</span>
          <span v-else>Simpan</span>
        </button>

        <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
          Kembali
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormSuratPengantarRawatInap",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
    viewData: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      loadingSubmit: false,
      disabledSubmit: false,
      ttdDokterCleared: false,
      listDokter: [],
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        nik: "",
        asal_ruangan: [],
        nama_poliklinik: "",
        rencana_perawatan: "",
        karena_menderita: "",
        saran_terapi: "",
        rencana_tindakan: "",
        tanggal: "",
        ttd_dokter: "",
        nama_dokter_ttd: "",
        ttd_dokter_timestamp: "",
      },
    };
  },
  computed: {
    formatTanggalLahir() {
      if (!this.form.tanggal_lahir) return "";
      
      const date = new Date(this.form.tanggal_lahir);
      const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
      ];
      
      return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    },
    isEditMode() {
      return !!this.editData?.uuid;
    },
  },
  async mounted() {
    console.log("🟢 COMPONENT - Mounted");
    console.log("🟢 COMPONENT - editData:", this.editData);
    console.log("🟢 COMPONENT - viewData:", this.viewData);

    await this.fetchDokter();
    await this.fetchTahunAkreditasi();

    if (this.viewData) {
      console.log("🟢 MODE: VIEW");
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      console.log("🟢 MODE: EDIT");
      this.disabledSubmit = false;
      this.loadDataForEdit();
    } else {
      console.log("🟢 MODE: CREATE");
      this.disabledSubmit = false;
      this.setDataForm();
    }
  },
  methods: {
    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
        console.log("✅ Data dokter loaded:", this.listDokter.length);
      } catch (error) {
        console.error('❌ Gagal memuat data dokter:', error);
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';
        
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 2.5/SPUDI/${tahun}`;
        }
        
        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 2.5/SPUDI/22';
        }
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
        this.form.nik = this.selectedPatient.no_ktp || this.selectedPatient.no_identitas || "";
      }

      console.log("✅ Form initialized:", this.form);
    },

    async loadDataForEdit() {
      console.log("🟢 LOAD EDIT - Mulai load data");
      
      try {
        const dataSource = this.editData || this.viewData;
        
        if (!dataSource) {
          console.warn("🟢 LOAD EDIT - Tidak ada data!");
          this.setDataForm();
          return;
        }

        // Populate form dengan data dari editData/viewData
        Object.keys(this.form).forEach((key) => {
          if (dataSource.hasOwnProperty(key)) {
            let value = dataSource[key];
            
            // Handle asal_ruangan (array dari JSON string)
            if (key === 'asal_ruangan' && typeof value === 'string') {
              try {
                this.form[key] = JSON.parse(value);
              } catch {
                this.form[key] = [];
              }
            } else {
              this.form[key] = value !== null ? value : "";
            }
            
            console.log(`🟢 Set ${key}:`, this.form[key]);
          }
        });

        console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);

        // Render signature
        this.$nextTick(() => {
          if (this.form.ttd_dokter) {
            this.ttdDokterCleared = false;
            this.renderSignature("ttd_dokter", this.form.ttd_dokter);
          }
        });

      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    renderSignature(refName, data) {
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad && data) {
          pad.clearSignature();
          pad.fromDataURL(data);
        }
      });
    },

    handleAsalRuanganChange(value) {
      const index = this.form.asal_ruangan.indexOf(value);
      
      if (index > -1) {
        // Jika sudah ada, hapus (uncheck)
        this.form.asal_ruangan.splice(index, 1);
        
        // Reset nama poliklinik jika Poliklinik di-uncheck
        if (value === 'Poliklinik') {
          this.form.nama_poliklinik = "";
        }
      } else {
        // Jika belum ada, tambahkan (check)
        this.form.asal_ruangan.push(value);
      }
      
      console.log("Asal Ruangan:", this.form.asal_ruangan);
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
      this.ttdDokterCleared = false;

      // Set timestamp
      const now = new Date();
      this.form.ttd_dokter_timestamp = now.toLocaleString('id-ID', {
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric',
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit'
      });

      console.log("TTD saved:", refName);
    },

    clearSign(refName) {
      this.ttdDokterCleared = true;
      this.form[refName] = "";
      this.form.ttd_dokter_timestamp = "";

      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    validateForm() {
      const errors = [];

      if (this.form.asal_ruangan.length === 0) {
        errors.push("Asal Ruangan harus dipilih");
      }
      
      if (this.form.asal_ruangan.includes('Poliklinik') && !this.form.nama_poliklinik.trim()) {
        errors.push("Nama Poliklinik harus diisi");
      }

      if (!this.form.rencana_perawatan.trim()) {
        errors.push("Rencana perawatan harus diisi");
      }

      if (!this.form.karena_menderita.trim()) {
        errors.push("Karena menderita harus diisi");
      }

      if (!this.form.saran_terapi.trim()) {
        errors.push("Saran Terapi harus diisi");
      }

      if (!this.form.rencana_tindakan.trim()) {
        errors.push("Rencana Tindakan harus diisi");
      }

      if (!this.form.tanggal) {
        errors.push("Tanggal harus diisi");
      }

      if (!this.form.ttd_dokter) {
        errors.push("Tanda tangan Dokter harus diisi");
      }

      if (!this.form.nama_dokter_ttd.trim()) {
        errors.push("Nama Dokter harus dipilih");
      }

      if (errors.length > 0) {
        alert("Mohon lengkapi:\n" + errors.join("\n"));
        return false;
      }

      return true;
    },

    async submitForm() {
      if (!this.validateForm()) return;

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          
          // Convert array to JSON string
          if (key === 'asal_ruangan') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const url = "/master/pasien/dokumen-surat-pengantar-rawat-inap";
        
        const response = await axios.post(url, fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        if (response.data.status) {
          alert(
            response.data.message ||
              (this.isEditMode
                ? "Data berhasil diperbarui!"
                : "Data berhasil disimpan!")
          );
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        
        let errorMessage = "Terjadi kesalahan saat menyimpan data.";
        
        if (error.response?.data?.errors) {
          const errors = Object.values(error.response.data.errors).flat();
          errorMessage += "\n" + errors.join("\n");
        } else if (error.response?.data?.message) {
          errorMessage = error.response.data.message;
        }
        
        alert(errorMessage);
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

.form-wrapper {
  position: relative;
}

.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 251, 251, 0.1);
  z-index: 10;
  cursor: not-allowed;
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

.info-row {
  display: flex;
  margin-bottom: 8px;
  font-size: 14px;
  align-items: baseline;
}

.info-label {
  width: 200px;
  font-weight: normal;
  flex-shrink: 0;
}

.colon {
  margin: 0 10px;
  flex-shrink: 0;
}

.info-value {
  flex: 1;
  border-bottom: 1px dotted #000;
  padding-left: 10px;
  min-height: 20px;
}

.checkbox-group {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
}

.checkbox-item {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 14px;
}

.checkbox-item input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
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

.consent-text {
  text-align: justify;
  line-height: 1.8;
  font-size: 14px;
  margin: 15px 0;
}

.signature-single {
  max-width: 400px;
  margin: 2rem auto;
  padding: 1rem;
  text-align: center;
}

.signature-box-rme {
  width: 100% !important;
  max-width: 350px !important;
  height: 200px !important;
  border: 2px solid #000;
  border-radius: 6px;
  margin: 0 auto;
  display: block;
}

.signature-preview {
  width: 100%;
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

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}

.btn-clear:hover {
  background: #d32f2f;
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

.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-6 {
  padding-left: 8px;
  padding-right: 8px;
  flex: 0 0 50%;
  max-width: 50%;
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

.mt-4 {
  margin-top: 24px;
}

.ml-2 {
  margin-left: 8px;
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

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
}

@media (max-width: 768px) {
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .info-row {
    flex-wrap: wrap;
  }

  .info-label {
    width: 100%;
    margin-bottom: 4px;
  }

  .colon {
    display: none;
  }

  .checkbox-group {
    flex-direction: column;
    gap: 10px;
  }
}
</style>