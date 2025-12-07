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
      <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
      <p class="mb-1">VISION FOR THE NATION</p>
      <p class="mb-1">Jl. Gatot Subroto No. 293 - 24 Hours Eye Accident & Emergency Unit</p>
      <p class="mb-1">Jalan Pabrik Tenun No. 61 S3, Medan Perjuangan, Kota Medan 20112, Sumatera Utara, Indonesia</p>
      <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
      <p class="mb-1">24 Hours Eye Emergency Hotline: 0822 7755 5151</p>
      <p class="mb-3">Email: rsprimavision@gmail.com</p>
      <hr class="my-3" style="border: 2px solid #000" />
      
      <h3 class="fw-bold mt-4 mb-4">TINDAKAN LASER PERIPHERAL IRIDECTOMY (LPI)</h3>
      
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
    </div>

    <!-- ================= DATA PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Data Pasien</h5>
      <div class=" mb-2">
        <div class="col-md-4">
          <label>Nama Pasien :</label>
          <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
        </div>
        <div class="col-md-4">
          <label>No. Rekam Medis :</label>
          <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
        </div>
        <div class="col-md-4">
          <label>Tanggal Lahir :</label>
          <input 
            type="date" 
            v-model="form.tanggal_lahir" 
            class="form-control"
          />
        </div>
      </div>
    </div>

    <!-- ================= DIAGNOSA ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Diagnosa</h5>
      <div class="">
        <div class="col-md-12">
          <textarea 
            v-model="form.diagnosa" 
            class="textarea-rme" 
            rows="4"
            placeholder="Masukkan diagnosa medis pasien..."
          ></textarea>
        </div>
      </div>
    </div>

    <!-- ================= TINDAKAN LASER LPI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Dilakukan Tindakan Laser Peripheral Iridectomy (LPI)</h5>
      <div class="row">
        <div class="col-md-12">
          <textarea 
            v-model="form.tindakan_laser_lpi" 
            class="textarea-rme" 
            rows="8"
            placeholder="Deskripsi detail tindakan Laser Peripheral Iridectomy yang dilakukan:
- Lokasi tindakan (mata kanan/kiri/keduanya)
- Teknik yang digunakan
- Area iridektomi
- Kondisi sebelum dan sesudah tindakan
- Komplikasi (jika ada)
- Hasil observasi post-tindakan"
          ></textarea>
          <small class="text-muted">
            * LPI adalah prosedur laser untuk membuat lubang kecil pada iris guna meningkatkan aliran aqueous humor dan mencegah glaukoma sudut tertutup
          </small>
        </div>
      </div>
    </div>

    <!-- ================= TANGGAL TINDAKAN ================= -->
    <div class="row mb-4">
      <div class="col-md-6">
        <label>Tanggal Tindakan :</label>
        <input type="date" v-model="form.tanggal_tindakan" class="form-control" />
      </div>
      <div class="col-md-6">
        <label>Jam Tindakan :</label>
        <input type="time" v-model="form.jam_tindakan" class="form-control" />
      </div>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <div class="signature-section">
        <!-- DPJP/Dokter -->
        <div class="sign-box">
          <label>DPJP / Dokter yang Melakukan Tindakan</label>

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
            v-model="form.nama_dokter"
            class="input-rme mt-2"
            placeholder="Nama Jelas DPJP/Dokter"
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
  name: "DokumenTindakanLaserLPI",

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
        tanggal_tindakan: "",
        jam_tindakan: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Data Pasien untuk form
        nama_pasien: "",
        no_rm_pasien: "",
        tanggal_lahir: "",

        // Form Fields
        diagnosa: "",
        tindakan_laser_lpi: "",

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
      const today = new Date();
      this.form.tanggal_tindakan = this.formatDate(today);
      
      // Set current time
      const hours = String(today.getHours()).padStart(2, '0');
      const minutes = String(today.getMinutes()).padStart(2, '0');
      this.form.jam_tindakan = `${hours}:${minutes}`;

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";
      
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
            `/master/pasien/dokumen-laser-lpi/${this.editData}`
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
          if (data.tanggal_tindakan) {
            this.form.tanggal_tindakan = this.formatDate(new Date(data.tanggal_tindakan));
          }
          if (data.tanggal_lahir) {
            this.form.tanggal_lahir = this.formatDate(new Date(data.tanggal_lahir));
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
      if (!this.form.tanggal_lahir) {
        alert("Mohon lengkapi tanggal lahir pasien!");
        return;
      }

      if (!this.form.diagnosa) {
        alert("Mohon lengkapi diagnosa!");
        return;
      }

      if (!this.form.tindakan_laser_lpi) {
        alert("Mohon lengkapi detail tindakan Laser LPI!");
        return;
      }

      if (!this.form.ttd_dokter) {
        alert("Mohon lengkapi tanda tangan dokter!");
        return;
      }

      if (!this.form.nama_dokter) {
        alert("Mohon lengkapi nama dokter!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-laser-lpi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Dokumen Tindakan Laser LPI berhasil diupdate!"
          : "Dokumen Tindakan Laser LPI berhasil disimpan!";

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
  max-width: 900px;
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

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  background: #fff;
  resize: vertical;
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
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
  justify-content: center;
  margin-top: 20px;
  margin-bottom: 20px;
}

.sign-box {
  width: 50%;
  text-align: center;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
  font-size: 14px;
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

.text-muted {
  color: #6c757d;
  font-size: 13px;
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
</style>