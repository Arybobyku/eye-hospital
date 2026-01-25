<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">PERSETUJUAN UMUM (GENERAL CONSENT)</h2>
        <h4 class="fw-semibold"> RM 1.1/PU(GJ)/22</h4>
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

        <!-- ================= PERSETUJUAN UMUM (GENERAL CONSENT) ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">PERSETUJUAN UMUM (GENERAL CONSENT)</h5>
        
          <div class="row mt-4">
            <div class="col-md-12 mb-4">
              <label style="margin-bottom: 20px; text-align: justify; display: block; line-height: 1.8;">
                <strong>PASIEN/KELUARGA DAN ATAU WALI HUKUM HARUS MEMBACA, MEMAHAMI DAN MENGISI INFORMASI BERIKUT:</strong>
                <br><br>
                <strong>1. PERSETUJUAN UNTUK PERAWATAN DAN PENGOBATAN</strong><br>
                Saya menyetujui untuk mendapatkan perawatan di Rumah Sakit Khusus Prima Vision Medan sebagai pasien rawat jalan/rawat inap tergantung kepada kebutuhan medis. Pengobatan dapat meliputi pemeriksaan visus, tonometri dan prosedur rutin seperti cairan infuse atau suntikan dan evaluasi (wawancara dan pemeriksaan fisik).
                <br> <br>
                Persetujuan yang saya berikan tidak termasuk persetujuan untuk prosedur/tindakan invasif (misalnya operasi) atau tindakan yang mempunyai resiko tinggi.
                <br> <br>
                Jika saya memutuskan untuk menghentikan perawatan medis untuk diri saya, saya memahami dan menyadari bahwa Rumah Sakit Khusus Mata Prima Vision ataupun dokter tidak bertanggung jawab atau hasil yang merugikan saya
                <br><br>
                <strong>2. PERSETUJUAN PERLEPASAN INFORMASI</strong><br>
                    Saya memahami informasi yang ada di dalam Saya, termasuk Diagnosis, hasil 
                    laboratorium dan hasil tes diagnostik yang digunakan untuk perawatan medis, Rumah Sakit 
                    Khusus Mata Prima Vision Medan akan menjamin kerahasiaannya.
                    <br><br>
                    Saya memberi wewenang kepada Rumah Sakit Khusus Mata Prima Vision Medan untuk 
                    memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan bila diperlukan untuk 
                    memproses klaim asuransi/perusahaan atau lembaga pemerintah.
                    <br><br>
                    Saya memberi wewenang kepada Rumah Sakit Khusus Mata Prima Vision Medan untuk 
                    memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan saya kepada anggota 
                    keluarga saya dan kepada: 
                    <br>
                a. <input type="text" v-model="form.info_kepada_a" class="line-inputs"><br>
                b. <input type="text" v-model="form.info_kepada_b" class="line-inputs"><br>
                c. <input type="text" v-model="form.info_kepada_c" class="line-inputs">
                <br><br>
                <strong>3. HAK DAN TANGGUNG JAWAB PASIEN</strong><br>
                Saya memiliki hak untuk mengambil bagian dalam keputusan mengenai penyakit saya dalam hal 
                perawatan medis dan rencana pengobatan.
                <br><br>
                Saya telah mendapat informasi tentang Hak dan Tanggung Jawab Pasien Rumah Sakit Khusus 
                Mata Prima Vision Medan melalui leaflet dan banner yang disediakan petugas
                <br><br>
                Saya memahami bahwa Rumah Sakit Khusus Mata Prima Vision Medan tidak bertanggung jawab 
                atas kehilangan barang-barang pribadi dan barang yang dibawa ke Rumah Sakit Khusus Mata 
                Prima Vision Medan.
                <br><br>
                Saya memahami bahwa Rumah Sakit Khusus Mata Prima Vision Medan tidak memperbolehkan 
                pendokumentasian semua tindakan yang dilakukan di Rumah Sakit Khusus Mata Prima Vision, 
                baik berbentuk Foto / Video / Audio (sesuai UU Praktik Kedokteran No.29/2004 pasal 48 dan 51, 
                UU Telekomunikasi No.36/1999).
                <br><br>
                <strong>4. INFORMASI RAWAT INAP</strong><br><br>
                Saya telah menerima informasi tentang peraturan yang telah diberlakukan oleh Rumah Sakit 
                Khusus Mata Prima Vision Medan dan saya beserta keluarga bersedia untuk mematuhinya, 
                termasuk mematuhi berkunjung pasien sesuai dengan aturan di Rumah Sakit Khusus Mata Prima 
                Vision Medan
                <br><br>
                Anggota keluarga saya yang menunggu saya bersedia untuk selalu memakai tanda pengenal 
                khusus yang diberikan Rumah Sakit Khusus Mata Prima Vision Medan, dan demi keamanan 
                seluruh pasien setiap keluarga dan siapapun yang akan mengunjungi saya diluar jam berkunjung 
                bersedia untuk diminta/diperiksa identitasnya dan memakai identitas yang diberikan Rumah Sakit 
                Khusus Mata Prima Vision Medan.
                <br><br>
                Saya memahami bahwa saya dapat memilih turun kelas perawatan apabila kamar perawatan yang 
                menjadi hak saya sesuai fasilitas kartu BPJS saya tidak akan tersedia. Dan saya telah memahami 
                apa yang menjadi kewajiban dan hak saya memilih hal tersebut. Dan saya bersedia mengikuti 
                peraturan Rumah Sakit Khusus Mata Prima Vision Medan yang berlaku saat ini.
                <br><br>
                <strong>5. BIAYA PERAWATAN</strong>
                <br><br>
                        • Saya menyatakan setuju sebagai pasien/penanggung jawab dengan status umum untuk 
                           membayar total biaya perawatan yang diberikan sesuai rincian biaya dan ketentuan Rumah 
                           Sakit Khusus Mata Prima Vision Medan
                <br><br>
                        •Saya menyatakan setuju sebagai pasien/penanggung jawab dengan biaya ditanggung penjamin untuk segera melengkapi berkas administrasi paling lambat 3x24 jam.
                <br><br>
                Saya telah membaca isi dari pernyataan ini/telah dibacakan isi dari pernyataan ini, dan saya telah 
                memahami isi dari pernyataan ini. Dan semua pernyataan saya telah dijawab dengan jelas.
              </label>
          
              <!-- TANGGAL & WAKTU -->
              <div class="row mb-3">
                <div class="col-md-6 mb-2">
                  <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span>Medan, Tanggal</span>
                    <input
                      type="date"
                      v-model="form.tanggal"
                      class="input-rme"
                      style="width: 200px;"
                    />
                    <span>Waktu</span>
                    <input
                      type="time"
                      v-model="form.waktu"
                      class="input-rme"
                      style="width: 130px;"
                    />
                  </div>
                </div>
              </div>
                      <div class="signature-row-3">
                  <!-- KOLOM 1 -->
                  <div>
                    <label class="fw-bold mb-2">Pemberi Informasi dari</label><br>
                    <label class="fw-bold mb-2">RS Khusus Mata Prima Vision</label>
                    <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
                    <div class="signature-actions mt-2" style="margin-top: 8px;">
                    <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Ulang ↻</button>
                    <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button> </div>
                    <input type="text" v-model="form.nama_dokter_ttd" class="input-rme mt-2" placeholder="Nama dan Tandatangan " />
                  </div>
              
                  <!-- KOLOM 2 -->
                  <div>
                    <label class="fw-bold mb-2">Penerima Informasi</label><br>
                                <label class="fw-bold mb-2">( Pasien/Keluarga Pasien )</label>
                    <VueSignaturePad ref="ttd_keluarga" :options="sigOption" class="signature-box-rme mx-auto" />
                    <div class="signature-actions mt-2" style="margin-top: 8px;">
                    <button @click="clearSign('ttd_keluarga')" class="btn-clear mt-2">Ulang ↻</button>
                    <button @click="saveSign('ttd_keluarga')" class="btn-save mt-2">Simpan ✔</button> </div>
                    <input type="text" v-model="form.nama_keluarga_ttd" class="input-rme mt-2" placeholder="Nama dan Tandatangan " />
                  </div>
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
  name: "FormPersetujuanUmumPasienKeluarga",
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
      disabledSubmit: false, // ✅ Tambahkan ini
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        info_kepada_a: "",
        info_kepada_b: "",
        info_kepada_c: "",
        tanggal: "",
        waktu: "",
        ttd_dokter: "",
        nama_dokter_ttd: "",
        ttd_keluarga: "",
        nama_keluarga_ttd: "",
      },
    };
  },

  computed: {
    isEditMode() {
      return this.editData !== null && this.editData !== undefined;
    }
  },

  mounted() {
    console.log("🟢 COMPONENT - Mounted");
    console.log("🟢 COMPONENT - editData:", this.editData);
    console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
    
    this.disabledSubmit = false;
    
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
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
        const dataSource = this.editData || this.viewData; // ✅ Support both
        
        if (!dataSource) {
          console.warn("🟢 LOAD EDIT - Tidak ada editData/viewData!");
          this.setDataForm();
          return;
        }

        // ✅ Populate form dengan data
        Object.keys(this.form).forEach((key) => {
          if (dataSource.hasOwnProperty(key)) {
            let value = dataSource[key];
            
            // Handle checkbox jika ada
            if (key.startsWith('check_')) {
              this.form[key] = value ? "1" : "0";
            } else {
              this.form[key] = value !== null ? value : "";
            }
            
            console.log(`🟢 Set ${key}:`, this.form[key]);
          }
        });

        console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);

        // ✅ PENTING: Load signatures setelah DOM ready
        this.$nextTick(() => {
          this.loadSignatures(dataSource);
        });

      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    // ✅ TAMBAHKAN METHOD INI (yang missing!)
    loadSignatures(data) {
      const signatures = [
        'ttd_dokter',
        'ttd_keluarga'
      ];
      
      signatures.forEach(sig => {
        if (data[sig] && this.$refs[sig]) {
          try {
            this.$refs[sig].fromDataURL(data[sig]);
            console.log(`✅ Signature loaded: ${sig}`);
          } catch (err) {
            console.error(`❌ Error loading signature ${sig}:`, err);
          }
        }
      });
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];
      this.form.waktu = today.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.alamat = this.selectedPatient.alamat;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { isEmpty, data } = pad.saveSignature();
      if (!isEmpty) {
        this.form[refName] = data;
        console.log("TTD saved:", refName);
      }
    },

    clearSign(refName) {
      const pad = this.$refs[refName];
      if (pad) {
        pad.clearSignature();
        this.form[refName] = "";
      }
    },

    async submitForm() {
      // ✅ Validasi nama dokter dan keluarga
      if (!this.form.nama_dokter_ttd) {
        alert("Nama Dokter harus diisi!");
        return;
      }
      
      if (!this.form.nama_keluarga_ttd) {
        alert("Nama Keluarga/Pasien harus diisi!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        // ✅ Append semua fields termasuk UUID
        Object.keys(this.form).forEach((key) => {
          const value = this.form[key] ?? "";
          fd.append(key, value);
        });

        console.log("🟡 SUBMIT - Is Edit Mode:", this.isEditMode);
        console.log("🟡 SUBMIT - UUID:", this.form.uuid);

        // ✅ Same route for both create and update
        const response = await axios.post(
          "/master/pasien/form-persetujuan-umum-pasien-keluarga",
          fd,
          {
            headers: { "Content-Type": "multipart/form-data" },
          }
        );

        console.log("🟡 SUBMIT - Response:", response.data);

        if (response.data.status) {
          alert(response.data.message || "Data berhasil disimpan!");
          this.$emit("back");
        } else {
          alert(response.data.message || "Gagal menyimpan data!");
        }
      } catch (error) {
        console.error("🟡 SUBMIT - ERROR:", error.response?.data || error);
        
        if (error.response?.data?.errors) {
          const errors = Object.values(error.response.data.errors).flat();
          alert("Error:\n" + errors.join("\n"));
        } else {
          alert(error.response?.data?.message || "Gagal menyimpan form!");
        }
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

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
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

.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
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

.line-inputs {
  border: none;
  border-bottom: 1px dotted #0b0b0c;
  padding: 0 5px;
  outline: none;
  width: 1120px;        /* 🔥 bikin lebih panjang */
  /* atau */
  /* min-width: 400px; */
  background: transparent;
}


.line-input:focus {
  border-bottom: 1px solid #bcbfc9;
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

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
