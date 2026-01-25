<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">LAPORAN INJEKSI ANTI VECF</h2>
        <h4 class="fw-semibold">RM 8.8/LIAV/22</h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="form-row-2">
          <div>
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div>
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div>
            <label>Tanggal Lahir / Usia :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Jenis Kelamin :</label>
            <select v-model="form.jenis_kelamin" class="input-rme" disabled>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div>
            <label>Alamat :</label>
            <input type="text" v-model="form.alamat" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= FORM CONTENT ================= -->
      <div class="form-container-rme">
        <div class="header-rme">
          <h3>LAPORAN INJEKSI ANTI VECF</h3>
        </div>

        <!-- ================= TANGGAL OPERASI ================= -->
        <div class="box-rme mb-4">
          <div class="form-row-2">
            <div>
              <label>Tanggal Operasi :</label>
              <input type="date" v-model="form.tanggal_operasi" class="input-rme" />
            </div>
          </div>
        </div>

        <!-- ================= INFO OPERASI ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Operasi</h5>

          <div class="form-row-2">
  <div class="mata-row">
    <label class="label-mata">Mata :</label>

    <label class="radio-label">
      <input type="checkbox" v-model="form.mata_od" />
      OD
    </label>

    <label class="radio-label">
      <input type="checkbox" v-model="form.mata_os" />
      OS
    </label>
  </div>

  <div>
    <label>Operator :</label>
    <input type="text" v-model="form.operator" class="input-rme" />
  </div>
</div>


          <div class="form-row-2">
            <div>
              <label>Jam Operasi :</label>
              <input type="time" v-model="form.jam_operasi" class="input-rme" />
            </div>
            <div>
              <label>Lama Operasi :</label>
              <input type="text" v-model="form.lama_operasi" class="input-rme" placeholder="contoh: 30 menit" />
            </div>
          </div>

          <div class="form-row-2">
            <div>
              <label>Diagnosis :</label>
              <input type="text" v-model="form.diagnosis" class="input-rme" />
            </div>
            <div>
              <label>Asisten :</label>
              <input type="text" v-model="form.asisten" class="input-rme" />
            </div>
          </div>

          <div class="form-row-2">
            <div>
              <label>Jenis Operasi :</label>
              <input type="text" v-model="form.jenis_operasi" class="input-rme" />
            </div>
            <div>
              <label>Anesthesia :</label>
              <input type="text" v-model="form.anesthesia" class="input-rme" />
            </div>
          </div>

          <div class="form-row-2">
            <div>
              <label>Anesthesiologist :</label>
              <input type="text" v-model="form.anesthesiologist" class="input-rme" />
            </div>
          </div>
        </div>

        <!-- ================= PROSEDUR OPERASI ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Prosedur Operasi</h5>

          <div class="prosedur-item">
            <span class="prosedur-number">1.</span>
            <div class="prosedur-content">
              <span>Pasien berbaring dalam anestesi</span>
              <label class="radio-label ml-2">
                <input type="radio" v-model="form.jenis_anestesi" value="topical" />
                topical /
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_anestesi" value="local" />
                local /
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_anestesi" value="umum" />
                umum
              </label>
            </div>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">2.</span>
            <span class="prosedur-text">Dilakukan tindakan & antiseptis menggunakan providone iodin</span>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">3.</span>
            <span class="prosedur-text">Dipasangkan eye drape</span>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">4.</span>
            <span class="prosedur-text">Dipasangkan blefarostat</span>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">5.</span>
            <div class="prosedur-content">
              <span>Dilakukan pengukuran menggunakan</span>
              <label class="radio-label ml-2">
                <input type="radio" v-model="form.alat_ukur" value="caliper" />
                caliper
              </label>
              <span>/</span>
              <label class="radio-label">
                <input type="radio" v-model="form.alat_ukur" value="trocar" />
                trocar dengan jarak
              </label>
              <label class="radio-label ml-2">
                <input type="radio" v-model="form.jarak_ukur" value="3.5" />
                3,5 mm
              </label>
              <span>/</span>
              <label class="radio-label">
                <input type="radio" v-model="form.jarak_ukur" value="4" />
                4 mm dari limbus di kuadran
              </label>
              <label class="radio-label ml-2">
                <input type="radio" v-model="form.kuadran" value="superior" />
                superior /
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.kuadran" value="temporal" />
                temporal
              </label>
            </div>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">6.</span>
            <div class="prosedur-content">
              <span>Dilakukan injeksi</span>
              <label class="radio-label ml-2">
                <input type="radio" v-model="form.jenis_injeksi" value="avastin" />
                avastin
              </label>
              <span>/</span>
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_injeksi" value="intravitreal" />
                intravitreal sebanyak
              </label>
              <input type="text" v-model="form.jumlah_injeksi" class="input-inline-small" placeholder="0.00" /> ml
            </div>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">7.</span>
            <span class="prosedur-text">Diteteskan antibiotik</span>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">8.</span>
            <span class="prosedur-text">Mata ditutup kassa & dop</span>
          </div>

          <div class="prosedur-item">
            <span class="prosedur-number">9.</span>
            <span class="prosedur-text">Tindakan selesai</span>
          </div>
        </div>

        <!-- ================= TANDA TANGAN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan</h5>
          
          <div class="signature-row">
            <!-- KOLOM KANAN - DPJP/DOKTER -->
            <div>
              <div class="text-center">
                <label class="fw-bold mb-2 d-block">Tanda Tangan DPJP/ Dokter</label>
                <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
                <div class="signature-actions mt-2">
                  <button @click="clearSign('ttd_dokter')" class="btn-clear">
                    Clear ↻
                  </button>
                  <button @click="saveSign('ttd_dokter')" class="btn-save">
                    Simpan ✔
                  </button>
                </div>
                <input type="text" v-model="form.nama_dokter" class="input-rme mt-2" placeholder="Nama Lengkap Dokter" />
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
  </div>
</div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormLaporanInjeksiAntiVECF",
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
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      disabledSubmit:false,
      form: {
        uuid: "",
        uuid_pasien: "",
        
        // Data Default Pasien
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        alamat: "",
        
        // Informasi Operasi
        tanggal_operasi: "",
        mata_od: false,
        mata_os: false,
        operator: "",
        jam_operasi: "",
        lama_operasi: "",
        diagnosis: "",
        asisten: "",
        jenis_operasi: "",
        anesthesia: "",
        anesthesiologist: "",
        
        // Prosedur Operasi - Radio Options
        jenis_anestesi: "",
        alat_ukur: "",
        jarak_ukur: "",
        kuadran: "",
        jenis_injeksi: "",
        jumlah_injeksi: "",
        
        // Tanda Tangan
        ttd_dokter: "",
        nama_dokter: "",
      },
    };
  },
mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
  
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

    this.renderSignature("ttd_dokter", this.form.ttd_dokter);

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

    setDataForm() {
      const today = new Date();
      this.form.tanggal_operasi = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama = this.selectedPatient.nama;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
        this.form.alamat = this.selectedPatient.alamat || "";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { data } = pad.saveSignature();
      
      if (refName === "ttd_dokter") {
        this.form.ttd_dokter = data;
      }
      
      console.log("TTD saved:", refName);
    },

    clearSign(refName) {
      const pad = this.$refs[refName];
      if (pad) {
        pad.clearSignature();
      }
    },

    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          
          // Convert boolean to integer untuk database
          if (typeof this.form[key] === 'boolean') {
            fd.append(key, this.form[key] ? 1 : 0);
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/form-laporan-injeksi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan form!");
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

.form-row-3-3 {
  display: flex;
  gap: 1rem;
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem;
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

.input-rme:disabled,
.input-rme[readonly] {
  background: #e9ecef;
  cursor: not-allowed;
}

.radio-label {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  cursor: pointer;
  font-size: 14px;
  margin: 0 4px;
}

.ml-2 {
  margin-left: 8px;
}

.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
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

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 14px;
  color: #333;
}

.form-row-2 {
  display: flex;
  gap: 1rem;
}

.form-row-2 > div {
  flex: 1;
  padding: 0.5rem;
}

.signature-row {
  display: flex;
  gap: 2rem;
  margin-top: 2rem;
  justify-content: center;
}

.signature-row > div {
  flex: 0 0 auto;
  padding: 1rem;
  box-sizing: border-box;
}

.d-flex {
  display: flex;
}

.gap-3 {
  gap: 12px;
}

.mb-2 {
  margin-bottom: 8px;
}

.mata-row {
  display: flex;
  align-items: center;
  gap: 16px;
}

.label-mata {
  min-width: 60px;
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

.d-block {
  display: block;
}

.header-rme {
  background: #2d74b7;
  color: white;
  padding: 15px;
  text-align: center;
  border-radius: 6px 6px 0 0;
  margin-bottom: 0;
}

.header-rme h3 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}

.form-container-rme {
  border: 2px solid #2d74b7;
  border-radius: 6px;
  overflow: hidden;
}

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
}

/* Prosedur Item Styling */
.prosedur-item {
  display: flex;
  gap: 10px;
  margin-bottom: 16px;
  align-items: flex-start;
}

.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
}

.prosedur-number {
  font-weight: 600;
  min-width: 25px;
  color: #333;
}

.prosedur-text {
  flex: 1;
  line-height: 1.6;
}

.prosedur-content {
  flex: 1;
  line-height: 1.6;
}

.input-inline-small {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 5px 10px;
  width: 80px;
  text-align: center;
  font-size: 14px;
}

.input-inline-small:focus {
  outline: none;
  border-color: #2d74b7;
  background: #fffacd;
}

.align-items-center {
  align-items: center;
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

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  margin-left: 10px;
}



@media (max-width: 768px) {
  .form-row-2 > div,
  .form-row-3-3 > div {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>