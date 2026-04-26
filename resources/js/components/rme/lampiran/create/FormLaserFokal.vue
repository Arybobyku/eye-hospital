<style scoped>
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
</style>

<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- LOADING OVERLAY -->
      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <img
          src="/logo-rs.png"
          alt="Logo RS"
          class="logo-rs mb-3"
          style="max-width: 150px"
        />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <p class="mb-1">VISION FOR THE NATION</p>
        <p class="mb-1">
          PRIMA VISION EYE HOSPITAL - 24 HOURS EYE ACCIDENT & EMERGENCY UNIT
        </p>
        <p class="mb-1">
          Jalan Pabrik Tenun No. 51-53, Medan Perjuangan 20112, Sumatera Utara, Indonesia
        </p>
        <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
        <p class="mb-1">24 Hours Eye Emergency Hotline: 0822 7755 5151</p>
        <p class="mb-3">Email: rsprimavision@gmail.com</p>
        <hr class="my-3" style="border: 2px solid #000" />

        <h3 class="fw-bold mt-4 mb-4">FORM TINDAKAN LASER FOKAL</h3>
        <h4 class="fw-semibold">{{ form.no_surat}} </h4>

        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
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
            <input
              type="text"
              v-model="form.jenis_kelamin_display"
              class="input-rme"
              readonly
            />
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
              placeholder="Contoh: Diabetic Macular Edema OD, Retinal Vein Occlusion OS"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>5. Mata : <span class="text-danger">*</span></label>
            <div class="checkbox-group">
              <div class="form-check form-check-inline">
                <input
                  type="checkbox"
                  v-model="form.mata_kanan"
                  class="form-check-input"
                  id="mataKanan"
                />
                <label class="form-check-label" for="mataKanan">
                  <strong>Mata Kanan (OD)</strong>
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input
                  type="checkbox"
                  v-model="form.mata_kiri"
                  class="form-check-input"
                  id="mataKiri"
                />
                <label class="form-check-label" for="mataKiri">
                  <strong>Mata Kiri (OS)</strong>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= PROSEDUR TINDAKAN (11 LANGKAH) ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Langkah-langkah Tindakan Laser Fokal</h5>

        <div class="procedure-steps">
          <div class="step-item">
            <span class="step-number">1.</span>
            <span class="step-text"
              >Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%)</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">2.</span>
            <span class="step-text"
              >Perawat mempersiapkan berkas kelengkapan tindakan laser</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">3.</span>
            <span class="step-text"
              >Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien
              masuk ke ruangan laser</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">4.</span>
            <span class="step-text"
              >Pasien diberi obat tetes Anestesi (Pantocain 0,5%)</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">5.</span>
            <span class="step-text">Pasien duduk menghadap ke alat laser</span>
          </div>

          <div class="step-item">
            <span class="step-number">6.</span>
            <span class="step-text"
              >Pasien menempelkan dagu dan dahi ke penyangga pada alat laser</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">7.</span>
            <span class="step-text">Dokter menyalakan alat Laser Photocoagulation</span>
          </div>

          <div class="step-item">
            <span class="step-number">8.</span>
            <span class="step-text"
              >Pasien dipasang marker pada mata yang akan dilaser</span
            >
          </div>

          <div class="step-item step-item-important">
            <span class="step-number">9.</span>
            <div class="step-content">
              <span class="step-text mb-2"
                >Dilakukan tindakan laser dengan parameter laser :</span
              >
              <label class="mt-2 mb-1"
                >4. Parameter Laser Fokal : <span class="text-danger">*</span></label
              >
              <textarea
                v-model="form.parameter_laser_fokal"
                class="form-control mt-2"
                rows="4"
                placeholder="Contoh:&#10;- Power: 100-200 mW&#10;- Duration: 100-200 ms&#10;- Spot size: 50-100 μm&#10;- Total shots: 200-400&#10;- Target: Microaneurysms, hard exudates, leakage areas"
              ></textarea>
            </div>
          </div>

          <div class="step-item">
            <span class="step-number">10.</span>
            <span class="step-text"
              >Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">11.</span>
            <span class="step-text">Pasien diberikan resep obat dan surat kontrol</span>
          </div>
        </div>
      </div>


       <!-- ================= DIAGRAM MATA ================= -->
        <div class="box-rme mb-4">
            <h5 class="section-title-rme text-center mb-3">
                Diagram Tindakan
            </h5>

            <div class="eye-diagram-container">

                <div class="eye-svg-wrapper">
                    <!-- BACKGROUND SVG -->
                    <img
                        src="/images/eye-prp-background.svg"
                        alt="Diagram Mata"
                        class="eye-svg-bg"
                    />

                    <!-- CORETAAN DOKTER -->
                    <VueSignaturePad
                        ref="eyeDiagram"
                        :options="eyeSigOption"
                        class="eye-canvas-overlay"
                    />
                </div>

                <div class="eye-action">
                    <button
                        class="btn btn-sm btn-outline-danger"
                        @click="clearEyeDiagram"
                    >
                        Hapus Diagram
                    </button>
                </div>

            </div>
        </div>




      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <h5 class="section-title-rme text-center mb-4">Tanda Tangan DPJP / Dokter</h5>

        <div class="signature-section-single">
          <div class="sign-box-center">
            <label>6. Dokter Penanggung Jawab Pelayanan</label>

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

            <label class="mt-3"
              >7. Nama Dokter : <span class="text-danger">*</span></label
            >
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter" class="form-select-dokter">
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
  </div>
  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer" v-if="!disabledSubmit">
    <!-- TOMBOL SUBMIT -->
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? "Update" : "Save" }}</span>
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
  name: "DokumenFormLaserFokal",

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    viewData: {
      type: Object,
      default: null,
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
      disabledSubmit: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      eyeSigOption: {
      penColor: "#d32f2f", // merah medis
      backgroundColor: "rgba(0,0,0,0)", // transparan
      minWidth: 1,
      maxWidth: 2,
    },
      form: {
        uuid: "",
        uuid_pasien: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        no_surat: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Data Pasien untuk form
        nama_pasien: "",
        no_rm_pasien: "",
        jenis_kelamin_display: "",

        // Form Input (7 fields sesuai requirement)
        tanggal_lahir: "",
        tanggal: "",
        diagnosa: "",
        parameter_laser_fokal: "",
        mata_kanan: false,
        mata_kiri: false,

        // Tanda Tangan
        ttd_dokter: "",
        nama_dokter: "",
        diagram_mata: "",
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

  async mounted() {
    await this.fetchDokter();
    await this.fetchTahunAkreditasi();
    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadEditData();
    } else if (this.editData) {
      this.loadEditData();
    } else {
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
          this.form.no_surat = `RM 10.5/FTLF/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 10.5/FTLF/22';
        }
      }
    },
    setDataForm() {
      // Set tanggal hari ini
      const today = new Date();
      this.form.tanggal = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.no_identitas || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";

      // Jenis kelamin display
      this.form.jenis_kelamin_display =
        this.selectedPatient?.jenis_kelamin === "L" ? "Laki-laki" : "Perempuan";

      // Format tanggal lahir
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir = this.formatDate(
          new Date(this.selectedPatient.tanggal_lahir)
        );
      }
    },

    clearEyeDiagram() {
    if (this.$refs.eyeDiagram) {
      this.$refs.eyeDiagram.clearSignature()
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
            `/master/pasien/dokumen-laser-fokal/${this.editData}`
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
          this.$nextTick(() => {
            if (this.form.diagram_mata && this.$refs.eyeDiagram) {
                this.$refs.eyeDiagram.clearSignature();
                this.$refs.eyeDiagram.fromDataURL(this.form.diagram_mata);
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


    getEyeDiagramImage() {
    const pad = this.$refs.eyeDiagram;

    if (!pad || pad.isEmpty()) {
        return null;
    }

    return pad.saveSignature().data;
    },

    async submitForm() {
      this.form.diagram_mata = this.getEyeDiagramImage();
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

      if (!this.form.parameter_laser_fokal) {
        alert("Mohon lengkapi Parameter Laser Fokal!");
        return;
      }

      if (!this.form.mata_kanan && !this.form.mata_kiri) {
        alert("Mohon pilih minimal satu mata (Kanan atau Kiri)!");
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

        const response = await axios.post("/master/pasien/dokumen-laser-fokal", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Form Laser Fokal berhasil diupdate!"
          : "Form Laser Fokal berhasil disimpan!";

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
/* ================= CONTAINER & LAYOUT ================= */
.container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px;
}

.py-4 {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
}

/* ================= TYPOGRAPHY ================= */
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

.text-center h2 {
  font-size: 18px;
  margin-bottom: 10px;
}

.text-center h3 {
  font-size: 16px;
  margin-top: 20px;
  margin-bottom: 20px;
}

.text-center p {
  font-size: 13px;
  margin: 0;
  line-height: 1.5;
}

hr {
  margin: 20px 0;
  border: 2px solid #000;
}

/* ================= LOGO ================= */
.logo-rs {
  display: block;
  margin: 0 auto 15px;
  max-width: 150px;
}

/* ================= BADGE ================= */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: bold;
  margin-left: 10px;
  margin-top: 10px;
}

.badge.bg-warning {
  background: #ff9800;
  color: white;
}

.badge.bg-success {
  background: #4caf50;
  color: white;
}

/* ================= BOX & SECTIONS ================= */
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
  margin-bottom: 20px;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

/* ================= FORM ELEMENTS ================= */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px 12px;
  background: #fff;
  font-size: 14px;
  transition: border-color 0.3s;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
}

.input-rme[readonly] {
  background: #f5f5f5;
  cursor: not-allowed;
  color: #666;
}

.form-control {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.3s;
  font-family: "Arial", sans-serif;
  line-height: 1.6;
}

.form-control:focus {
  outline: none;
  border-color: #2d74b7;
}

textarea.form-control {
  resize: vertical;
  min-height: 80px;
}

/* ================= CHECKBOX STYLING ================= */
.checkbox-group {
  display: flex;
  gap: 30px;
  padding: 15px;
  background: white;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
}

.form-check {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-check-inline {
  display: inline-flex;
  align-items: center;
  margin-right: 0;
}

.form-check-input {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin: 0;
}

.form-check-label {
  cursor: pointer;
  margin: 0;
  user-select: none;
  font-size: 15px;
  color: #333;
}

/* ================= SINGLE EYE DIAGRAM (FINAL) ================= */

/* CONTAINER UTAMA */
.eye-diagram-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* WRAPPER SVG + CANVAS */
.eye-svg-wrapper {
  position: relative;
  width: 500px;        /* HARUS SAMA DENGAN PDF */
  height: 250px;
  border: 1px solid #ddd;
  border-radius: 6px;
  background: #fff;
  overflow: hidden;
}

/* SVG BACKGROUND */
.eye-svg-bg {
  width: 100%;
  height: 100%;
  display: block;
}

/* CANVAS CORETAAN */
.eye-canvas-overlay {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  cursor: crosshair;
}

/* AREA TOMBOL */
.eye-action {
  margin-top: 12px;
}




/* ================= ROW & COLUMNS ================= */
.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -10px;
}

.mb-1 {
  margin-bottom: 5px;
}

.mb-2 {
  margin-bottom: 10px;
}

.mb-3 {
  margin-bottom: 15px;
}

.mb-4 {
  margin-bottom: 20px;
}

.mt-2 {
  margin-top: 10px;
}

.mt-3 {
  margin-top: 15px;
}

.mt-4 {
  margin-top: 20px;
}

.my-3 {
  margin-top: 15px;
  margin-bottom: 15px;
}

.col-md-6,
.col-md-12 {
  padding: 0 10px;
  margin-bottom: 15px;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

/* ================= PROCEDURE STEPS ================= */
.procedure-steps {
  background: white;
  padding: 20px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
}

.step-item {
  display: flex;
  margin-bottom: 15px;
  padding: 12px 15px;
  background: #f8f9fa;
  border-radius: 4px;
  border-left: 4px solid #2d74b7;
  transition: all 0.3s;
}

.step-item:hover {
  background: #f0f4f8;
  border-left-color: #1976d2;
}

.step-item:last-child {
  margin-bottom: 0;
}

.step-item-important {
  background: #fff9e6;
  border-left: 4px solid #ff9800;
  flex-direction: column;
  padding: 15px;
}

.step-item-important:hover {
  background: #fff5d6;
  border-left-color: #f57c00;
}

.step-number {
  font-weight: bold;
  color: #2d74b7;
  min-width: 40px;
  font-size: 15px;
  flex-shrink: 0;
}

.step-text {
  flex: 1;
  line-height: 1.6;
  color: #333;
  font-size: 14px;
}

.step-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.step-content .step-text {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
}

.step-content label {
  color: #ff9800;
  font-size: 15px;
  font-weight: 600;
  margin-top: 10px;
  margin-bottom: 8px;
}

/* ================= SIGNATURE SECTION ================= */
.signature-container {
  padding: 25px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section-single {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  margin-top: 20px;
  margin-bottom: 20px;
}

.sign-box-center {
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.sign-box-center label {
  font-weight: bold;
  display: block;
  margin-bottom: 15px;
  color: #333;
  font-size: 16px;
  line-height: 1.4;
}

/* ================= SIGNATURE PAD & PREVIEW ================= */
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
  display: block;
  margin: 0 auto;
}

/* ================= BUTTONS ================= */
.btn-save {
  background: #1e88e5;
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
  transition: background 0.3s;
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
  transition: background 0.3s;
}

.btn-clear:hover {
  background: #d32f2f;
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
  transition: background 0.3s;
}

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ffcc80;
  cursor: not-allowed;
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
  transition: background 0.3s;
}

.btn-save-form:hover {
  background: #0277bd;
}

.btn-save-form:disabled {
  background: #b0bec5;
  cursor: not-allowed;
}

/* ================= ACTION FOOTER ================= */
.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 0;
  border-top: 1px solid #e0e0e0;
}

/* ================= LOADING OVERLAY ================= */
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

.loading-overlay p {
  color: #333;
  font-weight: 500;
  margin: 0;
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

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .container {
    padding: 15px;
  }

  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .sign-box-center {
    max-width: 100%;
  }

  .action-footer {
    flex-direction: column-reverse;
  }

  .btn-save-form,
  .btn-back {
    width: 100%;
  }

  .text-center h2 {
    font-size: 16px;
  }

  .text-center h3 {
    font-size: 15px;
  }

  .text-center p {
    font-size: 12px;
  }

  .box-rme {
    padding: 15px;
  }

  .procedure-steps {
    padding: 15px;
  }

  .step-item {
    padding: 10px 12px;
  }

  .step-item-important {
    padding: 12px;
  }

  .step-number {
    min-width: 35px;
    font-size: 14px;
  }

  .step-text {
    font-size: 13px;
  }

  .checkbox-group {
    flex-direction: column;
    gap: 15px;
  }

  .signature-box-rme {
    height: 200px;
  }

  .img-signature {
    height: 200px;
  }
}

@media (max-width: 480px) {
  .logo-rs {
    max-width: 120px;
  }

  .section-title-rme {
    font-size: 15px;
  }

  label {
    font-size: 13px;
  }
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
</style>
