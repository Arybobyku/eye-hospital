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
      
      <h3 class="fw-bold mt-4 mb-4">LAPORAN EKSISI CHALAZION</h3>
      <p class="text-muted mb-3" style="font-size: 13px">RM 9.9/LEC/22</p>
      
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
      <div class="row">
        <div class="col-md-6">
          <label>Jenis Kelamin :</label>
          <input type="text" v-model="form.jenis_kelamin_display" class="input-rme" readonly />
        </div>
        <div class="col-md-6">
          <label>Tanggal Lahir :</label>
          <input type="text" v-model="form.tanggal_lahir_display" class="input-rme" readonly />
        </div>
      </div>
    </div>

    <!-- ================= INFORMASI BEDAH ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Bedah</h5>
      
      <div class="row mb-3">
        <div class="col-md-12">
          <label>1. Diagnosa Pra Bedah : <span class="text-danger">*</span></label>
          <textarea 
            v-model="form.diagnosa_pra_bedah" 
            class="form-control" 
            rows="3"
            placeholder="Contoh: Chalazion palpebra superior OD, Chalazion palpebra inferior OS, dll"
          ></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>2. Tindakan : <span class="text-danger">*</span></label>
          <textarea 
            v-model="form.tindakan" 
            class="form-control" 
            rows="3"
            placeholder="Contoh: Eksisi chalazion dengan forceps chalazion dan curetase"
          ></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>3. Diagnosa Post Bedah :</label>
          <textarea 
            v-model="form.diagnosa_post_bedah" 
            class="form-control" 
            rows="3"
            placeholder="Diagnosa setelah tindakan pembedahan"
          ></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>4. Unit Pembedahan :</label>
          <input 
            type="text" 
            v-model="form.unit_pembedahan" 
            class="form-control"
            placeholder="Contoh: Ruang Operasi Minor, Poliklinik Mata, dll"
          />
        </div>
      </div>
    </div>

    <!-- ================= PROSEDUR OPERASI (10 LANGKAH) ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Prosedur Pembedahan</h5>
      
      <div class="procedure-steps">
        <div class="step-item">
          <span class="step-number">1.</span>
          <span class="step-text">Pasien dibaringkan di meja operasi</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">2.</span>
          <span class="step-text">Disinfektan lapangan operasi dengan betadine</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">3.</span>
          <span class="step-text">Tutup dengan doek steril</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">4.</span>
          <span class="step-text">Pasang forceps chalazion</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">5.</span>
          <span class="step-text">Anastesi dengan injeksi lidocain subconjungtiva margin palpebra</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">6.</span>
          <span class="step-text">Dengan menggunakan mesh dilakukan perlukaan di area chalazion, maka akan tampak keluar nanah</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">7.</span>
          <span class="step-text">Bersihkan chalazion dengan cuvet</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">8.</span>
          <span class="step-text">Kontrol perdarahan</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">9.</span>
          <span class="step-text">Beri salep antibiotik kemudian ditutup dengan kassa steril</span>
        </div>
        
        <div class="step-item">
          <span class="step-number">10.</span>
          <span class="step-text">Operasi selesai</span>
        </div>
      </div>
    </div>

    <!-- ================= TERAPI PASCA BEDAH ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Terapi Pasca Bedah</h5>
      
      <div class="row">
        <div class="col-md-12">
          <label>5. Terapi Pasca Bedah :</label>
          <textarea 
            v-model="form.terapi_pasca_bedah" 
            class="form-control" 
            rows="4"
            placeholder="Contoh:&#10;- Gentamycin eye ointment 3x sehari&#10;- Paracetamol 3x500mg&#10;- Kompres hangat 3-4x sehari&#10;- Kontrol 3-5 hari"
          ></textarea>
        </div>
      </div>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <h5 class="section-title-rme text-center mb-4">Tanda Tangan</h5>
      
      <div class="signature-section">
        <!-- Perawat -->
        <div class="sign-box">
          <label>Perawat</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_perawat && !signatureCleared.ttd_perawat" class="signature-preview">
            <img :src="form.ttd_perawat" alt="TTD Perawat" class="img-signature" />
            <button @click="clearSignature('ttd_perawat')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_perawat"
              :options="sigOption"
              class="signature-box-rme"
            />
            <button @click="saveSign('ttd_perawat')" class="btn-save">Simpan ✔</button>
          </div>

          <input
            v-model="form.nama_perawat"
            class="input-rme mt-2"
            placeholder="Nama Perawat"
          />
        </div>

        <!-- Operator/Dokter -->
        <div class="sign-box">
          <label>Operator</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_operator && !signatureCleared.ttd_operator" class="signature-preview">
            <img :src="form.ttd_operator" alt="TTD Operator" class="img-signature" />
            <button @click="clearSignature('ttd_operator')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_operator"
              :options="sigOption"
              class="signature-box-rme"
            />
            <button @click="saveSign('ttd_operator')" class="btn-save">Simpan ✔</button>
          </div>

          <input
            v-model="form.nama_operator"
            class="input-rme mt-2"
            placeholder="Nama Operator/Dokter"
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
  name: "DokumenLaporanEksisiChalazion",

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
        ttd_perawat: false,
        ttd_operator: false,
      },
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
        tanggal_lahir_display: "",

        // Data Bedah (5 fields)
        diagnosa_pra_bedah: "",
        tindakan: "",
        diagnosa_post_bedah: "",
        unit_pembedahan: "",
        terapi_pasca_bedah: "",

        // Tanda Tangan
        ttd_perawat: "",
        nama_perawat: "",
        ttd_operator: "",
        nama_operator: "",
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
        this.form.tanggal_lahir_display = this.formatTanggal(this.selectedPatient.tanggal_lahir);
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
            `/master/pasien/dokumen-eksisi-chalazion/${this.editData}`
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
      if (!this.form.diagnosa_pra_bedah) {
        alert("Mohon lengkapi Diagnosa Pra Bedah!");
        return;
      }

      if (!this.form.tindakan) {
        alert("Mohon lengkapi Tindakan!");
        return;
      }

      if (!this.form.ttd_perawat) {
        alert("Mohon lengkapi tanda tangan perawat!");
        return;
      }

      if (!this.form.ttd_operator) {
        alert("Mohon lengkapi tanda tangan operator!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-eksisi-chalazion",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Laporan Eksisi Chalazion berhasil diupdate!"
          : "Laporan Eksisi Chalazion berhasil disimpan!";

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

.text-muted {
  color: #6c757d;
}

.text-danger {
  color: #dc3545;
}
</style>