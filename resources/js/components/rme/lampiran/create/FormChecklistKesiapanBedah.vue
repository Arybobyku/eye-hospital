<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">CHECKLIST KESIAPAN BEDAH</h2>
        <h4 class="fw-semibold">{{ form.no_surat}} </h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="form-row-3-3">
          <div>
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div>
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>

        <div class="form-row-3-3">
          <div>
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div>
            <label>Tanggal Lahir / Usia :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>

        <div class="form-row-3-3">
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

      <!-- ================= INFORMASI KLINIK + CHECKLIST + TTD ================= -->
      <div class="form-container-rme">


    <!-- ================= INFORMASI KLINIK + CHECKLIST + TTD ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">PEMBERIAN INFORMASI</h5>

      <div class="form-row-2">
        <div>
          <label>Ruang :</label>
          <input type="text" v-model="form.nama_ruang" class="input-rme" />
        </div>
        <div>
          <label>Kamar :</label>
          <input type="text" v-model="form.nama_kamar" class="input-rme" />
        </div>
      </div>

      <div class="form-row-2">
        <div>
          <label>Diagnosa :</label>
          <input type="text" v-model="form.diagnosa" class="input-rme" />
        </div>
        <div>
          <label>Tindakan :</label>
          <input type="text" v-model="form.tindakan" class="input-rme" />
        </div>
      </div>

      <div class="form-row-2">
        <div>
          <label>Tehnik Anastesi :</label>
          <input type="text" v-model="form.teknik_anastesi" class="input-rme" />
        </div>
        <div>
          <label>Tgl. Tindakan :</label>
          <input type="date" v-model="form.tanggal_tindakan" class="input-rme" />
        </div>
      </div>

      <!-- Checklist Kesiapan Operasi -->
      <h4 class="section-title-rme mt-4">Checklist Kesiapan Operasi</h4>

      <h5 class="mt-3 mb-2">Listrik</h5>
      <div class="form-checklist">
        <label><input type="checkbox" v-model="form.check_phaco" true-value="1" false-value="0" /> Mesin Phaco terhubung dengan sumber listrik, indikator (+)</label><br>
        <label><input type="checkbox" v-model="form.check_anestesi" true-value="1" false-value="0" /> Mesin anestesi terhubung dengan sumber listrik, indikator (+)</label><br>
        <label><input type="checkbox" v-model="form.check_light_source" true-value="1" false-value="0" /> Light source, monitor Mata terhubung dengan sumber listrik, indicator (+)</label><br>
        <label><input type="checkbox" v-model="form.check_ext_kabel" true-value="1" false-value="0" /> Extention kabel terhubung dengan sumber listrik, indikator (+)</label><br>
        <label><input type="checkbox" v-model="form.check_meja_operasi" true-value="1" false-value="0" /> Meja operasi terhubung dengan sumber listrik, indikator (+)</label><br>
        <label><input type="checkbox" v-model="form.check_mikroskop" true-value="1" false-value="0" /> Mikroskop terhubung dengan sumber listrik, indikator (+)</label><br>
        <label><input type="checkbox" v-model="form.check_lampu_ok" true-value="1" false-value="0" /> Lampu kamar operasi menyala</label><br>
        <label><input type="checkbox" v-model="form.check_ac_ok" true-value="1" false-value="0" /> AC berfungsi dengan baik</label><br>
        <label><input type="checkbox" v-model="form.check_gas_medis" true-value="1" false-value="0" /> Gas medis terhubung dengan mesin, indikator (+)</label>
      </div>

      <h5 class="mt-4 mb-2">Alat</h5>
      <div class="form-checklist">
        <label><input type="checkbox" v-model="form.check_cassette" true-value="1" false-value="0" /> Cassette, selang, diatermi dan konektor Mesin Phaco sudah tersedia</label><br>
        <label><input type="checkbox" v-model="form.check_patient_plate" true-value="1" false-value="0" /> Patient plate sudah tersedia</label><br>
        <label><input type="checkbox" v-model="form.check_instrumen" true-value="1" false-value="0" /> Instrument steril sesuai kebutuhan sudah tersedia</label><br>
        <label><input type="checkbox" v-model="form.check_handle_mikro" true-value="1" false-value="0" /> Handle mikroskop steril</label><br>
        <label><input type="checkbox" v-model="form.check_kom_kidney" true-value="1" false-value="0" /> Kom kidney steril sudah tersedia</label>
      </div>

      <h5 class="mt-4 mb-2">Linen Steril</h5>
      <div class="form-checklist">
        <label><input type="checkbox" v-model="form.check_jas_steril" true-value="1" false-value="0" /> Jas steril</label><br>
        <label><input type="checkbox" v-model="form.check_duk" true-value="1" false-value="0" /> Duk steril</label><br>
        <label><input type="checkbox" v-model="form.check_linen" true-value="1" false-value="0" /> Linen meja instrumen</label><br>
        <label><input type="checkbox" v-model="form.check_kasa" true-value="1" false-value="0" /> Kasa</label>
      </div>

      <h5 class="mt-4 mb-2">AKHP</h5>
      <div class="form-checklist">
        <label><input type="checkbox" v-model="form.check_akhp" true-value="1" false-value="0" /> Tersedia AKHP sesuai kebutuhan</label>
      </div>

      <!-- TANDA TANGAN -->
      <h4 class="section-title-rme mt-4">Tanda Tangan</h4>
      <div class="signature-row">
        <!-- KOLOM KIRI - PERAWAT -->
        <div>
          <div class="text-center">
            <label class="fw-bold mb-2 d-block">Perawat kamar bedah</label>
            <VueSignaturePad ref="ttd_perawat" :options="sigOption" class="signature-box-rme mx-auto" />
            <div class="signature-actions mt-2">
                <button @click="clearSign('ttd_perawat')" class="btn-clear mt-2">Clear ↻</button>
                <button @click="saveSign('ttd_perawat')" class="btn-save mt-2 ">Simpan ✔</button>
            </div>

            <input type="text" v-model="form.nama_lengkap_perawat" class="input-rme mt-2" placeholder="Nama Lengkap Perawat" />
          </div>
        </div>

        <!-- KOLOM KANAN - KEPALA RUANGAN -->
        <div>
          <div class="text-center">
            <label class="fw-bold mb-2 d-block">Kepala Ruangan</label>
            <VueSignaturePad ref="ttd_kepala" :options="sigOption" class="signature-box-rme mx-auto" />
            <div class="signature-actions mt-2">            
              <button @click="clearSign('ttd_kepala')" class="btn-clear mt-2">Clear ↻</button>
              <button @click="saveSign('ttd_kepala')" class="btn-save mt-2">Simpan ✔</button>
            </div>

            <input type="text" v-model="form.nama_lengkap_kepala_ruangan" class="input-rme mt-2" placeholder="Nama Lengkap Kepala Ruangan" />
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
  name: "FormCeklistKesiapanBedah",
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
      form: {
        uuid: "", // ✨ Field uuid untuk edit
        uuid_pasien: "",
        tanggal_tindakan: "",
        
        // Data Default
        no_rm: "",
        no_surat: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",
        
        // Data Pasien
        nama_pasien: "",
        
        no_rm_pasien: "",
        tanggal_lahir: "",
        
        // Form Fields
        nama_ruang: "",
        nama_kamar: "",
        diagnosa: "",
        tindakan: "",
        teknik_anastesi: "",
        
        // Checklist - Listrik
        check_phaco: "0",
        check_anestesi: "0",
        check_light_source: "0",
        check_ext_kabel: "0",
        check_meja_operasi: "0",
        check_mikroskop: "0",
        check_lampu_ok: "0",
        check_ac_ok: "0",
        check_gas_medis: "0",
        
        // Checklist - Alat
        check_cassette: "0",
        check_patient_plate: "0",
        check_instrumen: "0",
        check_handle_mikro: "0",
        check_kom_kidney: "0",
        
        // Checklist - Linen
        check_jas_steril: "0",
        check_duk: "0",
        check_linen: "0",
        check_kasa: "0",
        
        // Checklist - AKHP
        check_akhp: "0",
        
        // Tanda Tangan
        ttd_perawat: "",
        nama_lengkap_perawat: "",
        ttd_kepala: "",
        nama_lengkap_kepala_ruangan: "",
      },
    };
  },
async mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);

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
  async fetchTahunAkreditasi() {
    try {
      const response = await axios.get('/api/tahun-akreditasi');
      const tahun = response.data.tahun || '22';
      
      if (!this.form.no_surat) {
        this.form.no_surat = `RM 2.0/CKB/${tahun}`;
      }
      
      console.log("✅ Tahun akreditasi:", tahun);
      console.log("✅ No surat:", this.form.no_surat);
    } catch (error) {
      console.error("❌ Error fetch tahun:", error);
      if (!this.form.no_surat) {
        this.form.no_surat = 'RM 2.0/CKB/22';
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
        
        // // Handle checkbox (convert ke string "0" atau "1")
        // if (key.startsWith('check_')) {
        //   this.form[key] = value ? "1" : "0";
        // } else {
          this.form[key] = value !== null ? value : "";
      // }
        
        console.log(`🟢 Set ${key}:`, this.form[key]);
      }
    });

    this.renderSignature("ttd_perawat", this.form.ttd_perawat); this.renderSignature("ttd_kepala", this.form.ttd_kepala);

    console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);

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
      this.form.tanggal_tindakan = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama = this.selectedPatient.nama; 
        this.form.no_rm_pasien = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.nama_pasien = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { data } = pad.saveSignature();
      
      if (refName === "ttd_perawat") {
        this.form.ttd_perawat= data;
      } else if (refName === "ttd_kepala") {
        this.form.ttd_kepala = data;
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
          // Jangan kirim uuid jika kosong (mode create)
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key]);
        });

        const response = await axios.post(
          "/master/pasien/dokumen-ceklist-kesiapan-bedah",
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
  gap: 1rem; /* jarak antar kolom */
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem; /* tambahkan padding di dalam setiap kolom */
}

.signature-row-3 {
  display: flex;
  gap: 0.1rem;     /* jarak antar kolom */
  margin-top: 1.5rem;
}

.signature-row-3 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  text-align: center;
  box-sizing: border-box;
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

.radio-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.signature-box-rme {
  width: 350px !important;   /* paksa lebar */
  height: 220px !important;  /* paksa tinggi */
  border: 2px solid #ccc;
  border-radius: 6px;
}
.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 9px;               /* jarak antar tombol */
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

.date-time-wrapper {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.date-time-wrapper > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.form-row-2 {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.form-row-2 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.signature-row {
  display: flex;
  gap: 2rem;       /* jarak antar kolom kiri-kanan */
  margin-top: 2rem;
}

.signature-row > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  box-sizing: border-box;
}
.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-4,
.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
}

.col-md-4 {
  flex: 0 0 33.333333%;
  max-width: 33.333333%;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
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
}


@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
