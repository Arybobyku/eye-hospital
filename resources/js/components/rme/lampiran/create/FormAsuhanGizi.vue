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
        <h2 class="fw-bold">ASUHAN GIZI</h2>
        <h5 class="text-muted">Nutrition Care / Nutritional Treatment</h5>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
      </div>

      <!-- PATIENT INFO -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Pasien</h5>
        <div class="row mb-2">
          <div class="col-md-4">
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>
          <div class="col-md-4">
            <label>Tanggal Lahir :</label>
            <input
              type="text"
              v-model="form.tanggal_lahir_pasien"
              class="input-rme"
              readonly
            />
          </div>
          <div class="col-md-4">
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA MEDIS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosis Medis</h5>
        <div class="">
          <div class="col-md-12">
            <textarea
              v-model="form.diagnosa_medis"
              class="textarea-rme"
              rows="3"
              placeholder="Masukkan diagnosis medis pasien..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= ASESMEN/PENGKAJIAN GIZI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">ASESMEN/PENGKAJIAN GIZI</h5>

        <!-- ANTROPOMETRI -->
        <div class="sub-section mb-4">
          <h6 class="sub-title-rme">Antropometri</h6>
          <div class="row mb-3">
            <div class="col-md-3">
              <label>BB (Berat Badan) :</label>
              <div class="input-group">
                <input
                  type="number"
                  step="0.1"
                  v-model.number="form.bb"
                  class="input-rme"
                  placeholder="0.0"
                  @input="calculateIMT"
                />
                <span class="input-group-text">Kg</span>
              </div>
            </div>

            <div class="col-md-3">
              <label>TB (Tinggi Badan) :</label>
              <div class="input-group">
                <input
                  type="number"
                  step="0.1"
                  v-model.number="form.tb"
                  class="input-rme"
                  placeholder="0.0"
                  @input="calculateIMT"
                />
                <span class="input-group-text">Cm</span>
              </div>
            </div>

            <div class="col-md-3">
              <label>Tinggi Lutut :</label>
              <div class="input-group">
                <input
                  type="number"
                  step="0.1"
                  v-model.number="form.tinggi_lutut"
                  class="input-rme"
                  placeholder="0.0"
                />
                <span class="input-group-text">Cm</span>
              </div>
            </div>

            <div class="col-md-3">
              <label>IMT (Index Massa Tubuh) :</label>
              <div class="input-group">
                <input
                  type="number"
                  step="0.01"
                  v-model.number="form.imt"
                  class="input-rme"
                  placeholder="0.00"
                  readonly
                />
                <span class="input-group-text">kg/m²</span>
              </div>
              <small class="text-muted">{{ imtCategory }}</small>
            </div>
          </div>
        </div>

        <!-- BIOKIMIA -->
        <div class="sub-section mb-4">
          <h6 class="sub-title-rme">Biokimia</h6>
          <div class="">
            <div class="col-md-12">
              <textarea
                v-model="form.biokimia"
                class="textarea-rme"
                rows="3"
                placeholder="Masukkan hasil pemeriksaan biokimia (lab)..."
              ></textarea>
            </div>
          </div>
        </div>

        <!-- KLINIK/FISIK -->
        <div class="sub-section mb-4">
          <h6 class="sub-title-rme">Klinik/Fisik</h6>
          <div class="">
            <div class="col-md-12">
              <textarea
                v-model="form.klinik_fisik"
                class="textarea-rme"
                rows="3"
                placeholder="Masukkan hasil pemeriksaan klinik/fisik..."
              ></textarea>
            </div>
          </div>
        </div>

        <!-- RIWAYAT GIZI -->
        <div class="sub-section mb-4">
          <h6 class="sub-title-rme">Riwayat Gizi</h6>
          <div class="mb-3">
            <div class="col-md-12">
              <label>Pola Makan :</label>
              <textarea
                v-model="form.pola_makan"
                class="textarea-rme"
                rows="2"
                placeholder="Jelaskan pola makan pasien..."
              ></textarea>
            </div>
          </div>

          <div class="">
            <div class="col-md-12">
              <label>Asupan Gizi :</label>
              <textarea
                v-model="form.asupan_gizi"
                class="textarea-rme"
                rows="2"
                placeholder="Jelaskan asupan gizi pasien..."
              ></textarea>
            </div>
          </div>
        </div>

        <!-- RIWAYAT PERSONAL -->
        <div class="sub-section">
          <h6 class="sub-title-rme">Riwayat Personal</h6>
          <div class="">
            <div class="col-md-12">
              <textarea
                v-model="form.riwayat_personal"
                class="textarea-rme"
                rows="3"
                placeholder="Masukkan riwayat personal pasien..."
              ></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSIS/MASALAH GIZI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">DIAGNOSIS/MASALAH GIZI</h5>
        <div class="">
          <div class="col-md-12">
            <textarea
              v-model="form.diagnosis_masalah_gizi"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan diagnosis atau masalah gizi yang ditemukan..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= INTERVENSI GIZI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">INTERVENSI GIZI</h5>
        <div class="">
          <div class="col-md-12">
            <textarea
              v-model="form.intervensi_gizi"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan rencana intervensi gizi..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= RENCANA MONITORING DAN EVALUASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">RENCANA MONITORING DAN EVALUASI</h5>
        <div class="">
          <div class="col-md-12">
            <textarea
              v-model="form.rencana_monitoring_evaluasi"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan rencana monitoring dan evaluasi..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANGGAL & JAM ================= -->
      <div class="row mb-4">
        <div class="col-md-6">
          <label>Tanggal :</label>
          <input type="date" v-model="form.tanggal_asuhan" class="form-control" />
        </div>
        <div class="col-md-6">
          <label>Jam :</label>
          <input type="time" v-model="form.jam_asuhan" class="form-control" />
        </div>
      </div>

      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <div class="signature-section">
          <!-- Ahli Gizi -->
          <div class="sign-box">
            <label>Ahli Gizi</label>

            <!-- Preview TTD yang sudah ada -->
            <div
              v-if="form.ttd_ahli_gizi && !signatureCleared.ttd_ahli_gizi"
              class="signature-preview"
            >
              <img :src="form.ttd_ahli_gizi" alt="TTD Ahli Gizi" class="img-signature" />
              <button @click="clearSignature('ttd_ahli_gizi')" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_ahli_gizi"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('ttd_ahli_gizi')" class="btn-save">
                Simpan ✔
              </button>
            </div>

            <input
              v-model="form.nama_ahli_gizi"
              class="input-rme mt-2"
              placeholder="Nama Jelas Ahli Gizi"
            />
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
  name: "DokumenAsuhanGizi",

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
      disabledSubmit: false,
      isEditMode: false,
      signatureCleared: {
        ttd_ahli_gizi: false,
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
        tanggal_lahir_pasien: "",
        no_rm_pasien: "",

        // Diagnosa Medis
        diagnosa_medis: "",

        // Antropometri
        bb: null,
        tb: null,
        tinggi_lutut: null,
        imt: null,

        // Biokimia
        biokimia: "",

        // Klinik/Fisik
        klinik_fisik: "",

        // Riwayat Gizi
        pola_makan: "",
        asupan_gizi: "",

        // Riwayat Personal
        riwayat_personal: "",

        // Diagnosis/Masalah Gizi
        diagnosis_masalah_gizi: "",

        // Intervensi Gizi
        intervensi_gizi: "",

        // Rencana Monitoring dan Evaluasi
        rencana_monitoring_evaluasi: "",

        // Tanggal & Jam
        tanggal_asuhan: "",
        jam_asuhan: "",

        // Tanda Tangan
        ttd_ahli_gizi: "",
        nama_ahli_gizi: "",
      },
    };
  },

  computed: {
    imtCategory() {
      if (!this.form.imt) return "";
      const imt = parseFloat(this.form.imt);
      if (imt < 18.5) return "Kurus";
      if (imt < 25) return "Normal";
      if (imt < 30) return "Gemuk";
      return "Obesitas";
    },
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
    setDataForm() {
      const today = new Date();
      this.form.tanggal_asuhan = this.formatDate(today);

      const now = new Date();
      this.form.jam_asuhan = `${String(now.getHours()).padStart(2, "0")}:${String(
        now.getMinutes()
      ).padStart(2, "0")}`;

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";

      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir_pasien = this.formatTanggal(
          this.selectedPatient.tanggal_lahir
        );
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
            `/master/pasien/dokumen-asuhan-gizi/${this.editData}`
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
          if (data.tanggal_asuhan) {
            this.form.tanggal_asuhan = this.formatDate(new Date(data.tanggal_asuhan));
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

    calculateIMT() {
      if (this.form.bb && this.form.tb) {
        const bb = parseFloat(this.form.bb);
        const tbMeter = parseFloat(this.form.tb) / 100; // convert cm to meter

        if (bb > 0 && tbMeter > 0) {
          this.form.imt = (bb / (tbMeter * tbMeter)).toFixed(2);
        }
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
      if (!this.form.diagnosa_medis) {
        alert("Mohon lengkapi diagnosis medis!");
        return;
      }

      if (!this.form.ttd_ahli_gizi) {
        alert("Mohon lengkapi tanda tangan ahli gizi!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post("/master/pasien/dokumen-asuhan-gizi", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Dokumen Asuhan Gizi berhasil diupdate!"
          : "Dokumen Asuhan Gizi berhasil disimpan!";

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
