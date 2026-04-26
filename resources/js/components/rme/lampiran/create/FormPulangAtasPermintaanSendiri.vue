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
      
      <h3 class="fw-bold mt-4 mb-4">SURAT PERNYATAAN PULANG ATAS PERMINTAAN SENDIRI</h3>
      
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
    </div>

    <!-- ================= DATA PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Data Pasien</h5>
      
      <div class="row mb-3">
        <div class="col-md-6">
          <label>1. Nama Pasien : <span class="text-danger">*</span></label>
          <input 
            type="text" 
            v-model="form.nama_pasien" 
            class="form-control"
            placeholder="Nama lengkap pasien"
          />
        </div>
        <div class="col-md-6">
          <label>2. Tempat, Tanggal Lahir :</label>
          <input 
            type="text" 
            v-model="form.tempat_tanggal_lahir" 
            class="form-control"
            placeholder="Contoh: Medan, 15 Agustus 1985"
          />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>3. No. Rekam Medis :</label>
          <input 
            type="text" 
            v-model="form.no_rm" 
            class="form-control"
            readonly
            style="background-color: #f0f0f0"
          />
        </div>
        <div class="col-md-6">
          <label>4. Agama :</label>
          <input 
            type="text" 
            v-model="form.agama" 
            class="form-control"
            placeholder="Agama pasien"
          />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>5. Pekerjaan :</label>
          <input 
            type="text" 
            v-model="form.pekerjaan" 
            class="form-control"
            placeholder="Pekerjaan pasien"
          />
        </div>
        <div class="col-md-6">
          <label>6. Alamat :</label>
          <input 
            type="text" 
            v-model="form.alamat" 
            class="form-control"
            placeholder="Alamat lengkap pasien"
          />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>7. Tanggal : <span class="text-danger">*</span></label>
          <input 
            type="date" 
            v-model="form.tanggal" 
            class="form-control"
          />
        </div>
      </div>
    </div>

    <!-- ================= PERNYATAAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Pernyataan</h5>
      
      <div class="statement-box">
        <p class="statement-text">
          Dengan ini menyatakan permintaan untuk menghentikan perawatan/pengobatan dan 
          meminta pulang atas permintaan sendiri dengan alasan :
        </p>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>Alasan Pulang Atas Permintaan Sendiri : <span class="text-danger">*</span></label>
          <textarea 
            v-model="form.alasan" 
            class="form-control" 
            rows="4"
            placeholder="Tuliskan alasan pasien meminta pulang atas permintaan sendiri..."
          ></textarea>
        </div>
      </div>
    </div>

    <!-- ================= KONSEKUENSI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Konsekuensi yang Dipahami</h5>
      
      <div class="consequences-box">
        <p class="mb-3">
          Saya memahami dan menyadari sepenuhnya bahwa dengan pulang atas permintaan sendiri, 
          maka saya akan menanggung segala risiko dan konsekuensi yang mungkin timbul, termasuk:
        </p>
        
        <div class="consequence-item">
          <span class="consequence-number">1.</span>
          <span class="consequence-text">
            Membebaskan dokter dan rumah sakit dari segala tuntutan hukum yang mungkin timbul 
            dikemudian hari akibat kondisi medis yang memburuk
          </span>
        </div>
        
        <div class="consequence-item">
          <span class="consequence-number">2.</span>
          <span class="consequence-text">
            Bertanggung jawab penuh atas kondisi kesehatan saya setelah meninggalkan rumah sakit
          </span>
        </div>
        
        <div class="consequence-item">
          <span class="consequence-number">3.</span>
          <span class="consequence-text">
            Telah mendapat penjelasan dari dokter mengenai risiko pulang atas permintaan sendiri 
            dan saya tetap pada keputusan saya
          </span>
        </div>
        
        <div class="consequence-item">
          <span class="consequence-number">4.</span>
          <span class="consequence-text">
            Bersedia menanggung seluruh biaya administrasi dan biaya perawatan yang telah 
            digunakan selama di rumah sakit
          </span>
        </div>
      </div>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <h5 class="section-title-rme text-center mb-4">Tanda Tangan</h5>
      
      <div class="signature-section">
        <!-- Pasien/Keluarga -->
        <div class="sign-box">
          <label>Pasien / Keluarga Pasien</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_pasien && !signatureCleared.ttd_pasien" class="signature-preview">
            <img :src="form.ttd_pasien" alt="TTD Pasien" class="img-signature" />
            <button @click="clearSignature('ttd_pasien')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_pasien"
              :options="sigOption"
              class="signature-box-rme"
            />
            <button @click="saveSign('ttd_pasien')" class="btn-save">Simpan ✔</button>
          </div>

          <input
            v-model="form.nama_pasien_ttd"
            class="input-rme mt-2"
            placeholder="Nama Pasien/Keluarga yang menandatangani"
          />
        </div>

        <!-- DPJP -->
        <div class="sign-box">
          <label>DPJP / Dokter Penanggung Jawab</label>

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
            placeholder="Nama DPJP"
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
  name: "DokumenPulangAtasPermintaanSendiri",

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
        ttd_pasien: false,
        ttd_dpjp: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",

        // Data Pasien (7 fields)
        nama_pasien: "",
        tempat_tanggal_lahir: "",
        no_rm: "",
        agama: "",
        pekerjaan: "",
        alamat: "",
        tanggal: "",

        // Alasan
        alasan: "",

        // Tanda Tangan
        ttd_pasien: "",
        nama_pasien_ttd: "",
        ttd_dpjp: "",
        nama_dpjp: "",

        // Data default untuk BE
        nik: "",
        jenis_kelamin: "",
        nama: "",
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

      // Auto-fill dari data pasien
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.nik = this.selectedPatient?.no_identitas || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      
      // Set nama_pasien_ttd sama dengan nama_pasien
      this.form.nama_pasien_ttd = this.selectedPatient?.nama || "";

      // Format tempat tanggal lahir jika ada
      if (this.selectedPatient?.tanggal_lahir) {
        const tempat = this.selectedPatient?.tempat_lahir || "";
        const tglLahir = this.formatTanggalIndo(this.selectedPatient.tanggal_lahir);
        this.form.tempat_tanggal_lahir = tempat ? `${tempat}, ${tglLahir}` : tglLahir;
      }

      // Data lain bisa diisi manual atau dari data pasien jika ada
      this.form.agama = this.selectedPatient?.agama || "";
      this.form.pekerjaan = this.selectedPatient?.pekerjaan || "";
      this.form.alamat = this.selectedPatient?.alamat || "";
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-pulang-aps/${this.editData}`
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

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return d.toISOString().split("T")[0];
    },

    formatTanggalIndo(dateStr) {
      if (!dateStr) return "";
      const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      const d = new Date(dateStr);
      return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
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
      if (!this.form.nama_pasien) {
        alert("Mohon lengkapi Nama Pasien!");
        return;
      }

      if (!this.form.tanggal) {
        alert("Mohon lengkapi Tanggal!");
        return;
      }

      if (!this.form.alasan) {
        alert("Mohon lengkapi Alasan pulang atas permintaan sendiri!");
        return;
      }

      if (!this.form.ttd_pasien) {
        alert("Mohon lengkapi tanda tangan pasien/keluarga!");
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
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-pulang-aps",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Dokumen Pulang APS berhasil diupdate!"
          : "Dokumen Pulang APS berhasil disimpan!";

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

/* STATEMENT BOX */
.statement-box {
  background: #fff9e6;
  border: 2px solid #ffc107;
  border-radius: 6px;
  padding: 15px;
  margin-bottom: 20px;
}

.statement-text {
  font-size: 15px;
  line-height: 1.6;
  color: #333;
  margin: 0;
  font-weight: 500;
}

/* CONSEQUENCES BOX */
.consequences-box {
  background: white;
  padding: 20px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
}

.consequence-item {
  display: flex;
  margin-bottom: 15px;
  padding: 12px;
  background: #f8f9fa;
  border-radius: 4px;
  border-left: 3px solid #dc3545;
}

.consequence-number {
  font-weight: bold;
  color: #dc3545;
  min-width: 30px;
  font-size: 16px;
}

.consequence-text {
  flex: 1;
  line-height: 1.6;
  color: #333;
}

.signature-container {
  padding: 20px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
  gap: 30px;
}

.sign-box {
  flex: 1;
  text-align: center;
  max-width: 400px;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
  font-size: 16px;
}

.signature-box-rme {
  width: 100%;
  height: 160px;
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
  height: 160px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
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