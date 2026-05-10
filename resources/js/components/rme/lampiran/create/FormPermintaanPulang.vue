<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">FORMULIR PULANG ATAS PERMINTAAN SENDIRI</h2>
        <h4 class="fw-semibold">{{ form.no_surat}}</h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <div style="margin-bottom: 15px;">
          <strong>Yang Bertanda tangan di bawah ini :</strong>
        </div>

        <div class="info-row">
          <span class="info-label">Nama Pasien</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.nama }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">NIK</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.nik }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Jenis Kelamin</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.jenis_kelamin }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Tempat/Tanggal Lahir</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.tempat_lahir }}, {{ formatTanggalLahir }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Nomor rekam medis</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.no_rm }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Agama</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.agama }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Pekerjaan</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.pekerjaan }}</span>
        </div>

        <div class="info-row">
          <span class="info-label">Alamat</span>
          <span class="colon">:</span>
          <span class="info-value">{{ form.alamat }}</span>
        </div>
      </div>

      <!-- ================= PERNYATAAN ================= -->
      <div class="box-rme mb-4">
        <div class="consent-text">
          Dengan ini menyatakan permintaan untuk menghentikan perawatan pengobatan dan meminta
          pulang atas kemauan sendiri atas alasan:
        </div>

        <!-- INPUT ALASAN -->
        <div class="mb-3">
          <label class="fw-bold mb-2">
            Alasan Pulang Atas Permintaan Sendiri: <span style="color: red;">*</span>
          </label>
          <textarea
            v-model="form.alasan"
            class="textarea-rme"
            placeholder="Masukkan alasan pulang atas permintaan sendiri..."
            rows="3"
          ></textarea>
        </div>

        <div class="consent-text">
          Sebagai pasien/keluarga pasien saya telah mendapatkan penjelasan dari rumah sakit tentang:
        </div>

        <ol class="consent-list">
          <li>Hak saya menolak atau tidak melanjutkan pengobatan.</li>
          <li>Tentang konsekuensi dari Keputusan saya untuk pulang atas permintaan sendiri.</li>
          <li>Tentang tanggung jawab saya dengan Keputusan tersebut.</li>
          <li>Tersedianya alternatif pelayanan dan pengobatan untuk pengobatan lanjutan.</li>
        </ol>

        <div class="consent-text">
          Dan saya tidak akan menuntut pihak rumah sakit atau siapapun juga akibat dari Keputusan
          saya pulang atas permintaan sendiri.
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

        <!-- SIGNATURE ROW -->
        <div class="signature-row-2">
          <!-- KOLOM 1: Keluarga Pasien -->
          <div>
            <label class="fw-bold mb-2">Keluarga Pasien</label>
            <div v-if="form.ttd_keluarga && !ttdKeluargaCleared" class="signature-preview text-center">
              <img :src="form.ttd_keluarga" alt="TTD Perawat Kamar Bedah" class="img-signature" />
                <p v-if="form.ttd_keluarga_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_keluarga_timestamp }}
                </p>
              <button @click="clearSign('ttd_keluarga')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_keluarga" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_keluarga')" class="btn-save mt-2">Simpan ✔</button>
            </div>
            <input 
              type="text" 
              v-model="form.nama_keluarga_ttd" 
              class="input-rme mt-2" 
              placeholder="Nama jelas & Tanda tangan" 
            />
          </div>

          <!-- KOLOM 2: DPJP -->
          <div>
            <label class="fw-bold mb-2">DPJP</label>
            <div v-if="form.ttd_dpjp && !ttdDpjpCleared" class="signature-preview text-center">
              <img :src="form.ttd_dpjp" alt="TTD Perawat Kamar Bedah" class="img-signature" />
                <p v-if="form.ttd_dpjp_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_dpjp_timestamp }}
                </p>
              <button @click="clearSign('ttd_dpjp')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_dpjp" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dpjp')" class="btn-save mt-2">Simpan ✔</button>
            </div>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dpjp_ttd" class="form-select-dokter">
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

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer"  v-if="!disabledSubmit">
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
  name: "FormPermintaanPulang",
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
    documentType: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      loadingSubmit: false,
      ttdKeluargaCleared: false,
      ttdDpjpCleared: false,
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
        nik: "",              // DITAMBAHKAN
        jenis_kelamin: "",    // DITAMBAHKAN
        tempat_lahir: "",
        tanggal_lahir: "",
        agama: "",
        pekerjaan: "",
        alamat: "",
        alasan: "",
        tanggal: "",
        ttd_keluarga: "",
        nama_keluarga_ttd: "",
        ttd_dpjp: "",
        nama_dpjp_ttd: "",
        ttd_keluarga_timestamp: "",
        ttd_dpjp_timestamp: "",
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
    }
  },
async mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
await this.fetchDokter();
await this.fetchTahunAkreditasi();
  
this.disabledSubmit = false;
  if(this.viewData){
    this.disabledSubmit = true;
    this.loadDataForEdit();
  }else if (this.editData) {
    console.log("🟢 MODE: EDIT");
    this.loadDataForEdit();
  } else {
    console.log("🟢 MODE: CREATE");
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

  async fetchTahunAkreditasi() {
    try {
      const response = await axios.get('/api/tahun-akreditasi');
      const tahun = response.data.tahun || '22';
      
      if (!this.form.no_surat) {
        this.form.no_surat = `RM 10.0/FPAPS/${tahun}`;
      }
      
      console.log("✅ Tahun akreditasi:", tahun);
      console.log("✅ No surat:", this.form.no_surat);
    } catch (error) {
      console.error("❌ Error fetch tahun:", error);
      if (!this.form.no_surat) {
        this.form.no_surat = 'RM 10.0/FPAPS/22';
      }
    }
  },
loadDataForEdit() {
  console.log("🟢 LOAD EDIT - Mulai load data");
  console.log("🟢 LOAD EDIT - editData yang diterima:", this.editData);
  
  try {
    if (!this.editData) {
      console.warn("🟢 LOAD EDIT - Tidak ada editData!");
      this.setDataForm(); // Fallback ke create mode
      return;
    }

    // ✅ Populate form dengan data dari editData
    Object.keys(this.form).forEach((key) => {
      if (this.editData.hasOwnProperty(key)) {
        // Konversi value yang mungkin berbeda tipe
        let value = this.editData[key];
        
        // Handle checkbox (convert ke string "0" atau "1")
        if (key.startsWith('check_')) {
          this.form[key] = value ? "1" : "0";
        } else {
          this.form[key] = value !== null ? value : "";
        }
        
        console.log(`🟢 Set ${key}:`, this.form[key]);
      }
    });

    console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);
    // 🔥 RENDER TTD SETELAH FORM TERISI
    this.renderSignature("ttd_keluarga", this.form.ttd_keluarga);
    this.renderSignature("ttd_dpjp", this.form.ttd_dpjp);


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
      const flagMap = {
        ttd_keluarga: 'ttdKeluargaCleared',
        ttd_dpjp: 'ttdDpjpCleared',
      };
    
      Object.keys(flagMap).forEach(refName => {
        if (this.form[refName]) {
          this[flagMap[refName]] = false;
        }
      });
    },


    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama = this.selectedPatient.nama;
        this.form.nik = this.selectedPatient.no_identitas || "";                    // DITAMBAHKAN
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || ""; // DITAMBAHKAN
        this.form.tempat_lahir = this.selectedPatient.tempat_lahir || "";
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.agama = this.selectedPatient.agama || "";
        this.form.pekerjaan = this.selectedPatient.pekerjaan || "";
        this.form.alamat = this.selectedPatient.alamat;
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
    
      const flagMap = {
        ttd_keluarga: 'ttdKeluargaCleared',
        ttd_dpjp: 'ttdDpjpCleared',
      };

      const timestampMap = {
        ttd_keluarga: 'ttd_keluarga_timestamp',
        ttd_dpjp: 'ttd_dpjp_timestamp',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = false;
      }
    
      this.form[refName] = data;
      if (timestampMap[refName]) {
        const now = new Date();
        this.form[timestampMap[refName]] = now.toLocaleString('id-ID', {
          day: '2-digit', month: '2-digit', year: 'numeric',
          hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
      }
      console.log("TTD saved:", refName);
    },
    
    clearSign(refName) {
      const flagMap = {
        ttd_keluarga: 'ttdKeluargaCleared',
        ttd_dpjp: 'ttdDpjpCleared',
      };

      const timestampMap = {
        ttd_keluarga: 'ttd_keluarga_timestamp',
        ttd_dpjp: 'ttd_dpjp_timestamp',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = true;
        this.form[refName] = "";
      }

      if (timestampMap[refName]) {
        this.form[timestampMap[refName]] = "";
      }
    
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    validateForm() {
      const errors = [];

      if (!this.form.alasan.trim()) {
        errors.push("Alasan harus diisi");
      }
      if (!this.form.tanggal) {
        errors.push("Tanggal harus diisi");
      }
      if (!this.form.ttd_keluarga) {
        errors.push("Tanda tangan Keluarga Pasien harus diisi");
      }
      if (!this.form.nama_keluarga_ttd.trim()) {
        errors.push("Nama Keluarga Pasien harus diisi");
      }
      if (!this.form.ttd_dpjp) {
        errors.push("Tanda tangan DPJP harus diisi");
      }
      if (!this.form.nama_dpjp_ttd.trim()) {
        errors.push("Nama DPJP harus diisi");
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
          fd.append(key, this.form[key] || "");
        });

        const url = this.isEditMode
          ? `/master/pasien/form-permintaan-pulang/${this.form.uuid}`
          : "/master/pasien/form-permintaan-pulang";

        if (this.isEditMode) {
          fd.append("_method", "PUT");
        }

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

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
  margin-bottom: 20px;
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

.info-value {
  flex: 1;
  border-bottom: 1px dotted #000;
  padding-left: 10px;
  min-height: 20px;
}

.consent-text {
  text-align: justify;
  line-height: 1.8;
  font-size: 14px;
  margin: 15px 0;
}

.consent-list {
  margin-left: 30px;
  margin-top: 10px;
  margin-bottom: 15px;
}

.consent-list li {
  margin-bottom: 8px;
  line-height: 1.6;
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

.signature-row-2 {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
}

.signature-row-2 > div {
  flex: 1;
  padding: 1rem;
  text-align: center;
  box-sizing: border-box;
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
.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
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

.mx-auto {
  margin-left: auto;
  margin-right: auto;
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

@media (max-width: 768px) {
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .signature-row-2 {
    flex-direction: column;
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
}
</style>