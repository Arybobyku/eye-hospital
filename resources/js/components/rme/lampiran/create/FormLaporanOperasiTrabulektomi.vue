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

        <h3 class="fw-bold mt-4 mb-4">LAPORAN OPERASI TRABEKULEKTOMI</h3>
        <p class="text-muted mb-3" style="font-size: 13px">RM 8.10/LOT/22</p>

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
        <div class="row">
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
            <label>Tanggal Lahir :</label>
            <input
              type="text"
              v-model="form.tanggal_lahir_display"
              class="input-rme"
              readonly
            />
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Operasi</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Tgl. Operasi : <span class="text-danger">*</span></label>
            <input type="date" v-model="form.tanggal_operasi" class="form-control" />
          </div>
        </div>

        <div class="info-table">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="label-cell" style="width: 15%">Mata :</td>
                <td style="width: 35%">
                  <div class="d-flex gap-4">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="form.mata_od"
                        id="mataOD"
                      />
                      <label class="form-check-label" for="mataOD">OD</label>
                    </div>
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="form.mata_os"
                        id="mataOS"
                      />
                      <label class="form-check-label" for="mataOS">OS</label>
                    </div>
                  </div>
                </td>
                <td class="label-cell" style="width: 15%">Operator :</td>
                <td style="width: 35%">
                  <input
                    type="text"
                    v-model="form.operator"
                    class="form-control form-control-sm"
                    placeholder="Nama Operator/Dokter"
                  />
                </td>
              </tr>
              <tr>
                <td class="label-cell">Jam Operasi :</td>
                <td>
                  <input
                    type="time"
                    v-model="form.jam_operasi"
                    class="form-control form-control-sm"
                  />
                </td>
                <td class="label-cell">Lama Operasi :</td>
                <td>
                  <input
                    type="text"
                    v-model="form.lama_operasi"
                    class="form-control form-control-sm"
                    placeholder="Contoh: 45 menit"
                  />
                </td>
              </tr>
              <tr>
                <td class="label-cell">Diagnosis :</td>
                <td colspan="3">
                  <input
                    type="text"
                    v-model="form.diagnosis"
                    class="form-control form-control-sm"
                    placeholder="Diagnosis pasien"
                  />
                </td>
              </tr>
              <tr>
                <td class="label-cell">Asisten :</td>
                <td colspan="3">
                  <input
                    type="text"
                    v-model="form.asisten"
                    class="form-control form-control-sm"
                    placeholder="Nama Asisten"
                  />
                </td>
              </tr>
              <tr>
                <td class="label-cell">Jenis Operasi :</td>
                <td>
                  <input
                    type="text"
                    v-model="form.jenis_operasi"
                    class="form-control form-control-sm"
                    placeholder="Jenis Operasi"
                  />
                </td>
                <td class="label-cell">Anesthesia :</td>
                <td>
                  <input
                    type="text"
                    v-model="form.anesthesia"
                    class="form-control form-control-sm"
                    placeholder="Jenis Anestesi"
                  />
                </td>
              </tr>
              <tr>
                <td class="label-cell">Anesthesiologist :</td>
                <td colspan="3">
                  <input
                    type="text"
                    v-model="form.anesthesiologist"
                    class="form-control form-control-sm"
                    placeholder="Nama Dokter Anestesi"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ================= PROSEDUR OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Prosedur Operasi</h5>

        <div class="procedure-steps">
          <div class="step-item">
            <span class="step-number">1.</span>
            <span class="step-text">Pasien dalam posisi SUPINE di tempat tidur</span>
          </div>

          <div class="step-item">
            <span class="step-number">2.</span>
            <span class="step-text">Teknik A & Antiseptic</span>
          </div>

          <div class="step-item">
            <span class="step-number">3.</span>
            <span class="step-text">Pasang drape dan spekulum</span>
          </div>

          <div class="step-item">
            <span class="step-number">4.</span>
            <span class="step-text">Dilakukan Anastesi Subkonjungtiva</span>
          </div>

          <div class="step-item">
            <span class="step-number">5.</span>
            <span class="step-text"
              >Peritomi konjungtiva superior kemudian dibuat flap sclera</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">6.</span>
            <span class="step-text"
              >Buat Insisi berbentuk jendela antara Sclera dan Kornea</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">7.</span>
            <span class="step-text"
              >Setelah itu dilakukan Iridektomi, kemudian Flap Sclera dijahit dan
              dilakukan penjahitan Konjungtiva</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">8.</span>
            <span class="step-text"
              >Injeksi Antibiotik Gentamycin, Dexametason dan salep</span
            >
          </div>

          <div class="step-item">
            <span class="step-number">9.</span>
            <span class="step-text">Operasi selesai</span>
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
            <div
              v-if="form.ttd_perawat && !signatureCleared.ttd_perawat"
              class="signature-preview"
            >
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
            <div
              v-if="form.ttd_operator && !signatureCleared.ttd_operator"
              class="signature-preview"
            >
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
  name: "DokumenLaporanOperasiTrabekulektomi",

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
        tanggal_operasi: "",

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

        // Informasi Operasi
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
      this.form.tanggal_operasi = this.formatDate(today);

      // Set current time
      const hours = String(today.getHours()).padStart(2, "0");
      const minutes = String(today.getMinutes()).padStart(2, "0");
      this.form.jam_operasi = `${hours}:${minutes}`;

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
      this.form.jenis_kelamin_display =
        this.selectedPatient?.jenis_kelamin === "L" ? "Laki-laki" : "Perempuan";

      // Format tanggal lahir
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir_display = this.formatTanggal(
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
            `/master/pasien/dokumen-operasi-trabekulektomi/${this.editData}`
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
          if (data.tanggal_operasi) {
            this.form.tanggal_operasi = this.formatDate(new Date(data.tanggal_operasi));
          }

          // Convert boolean values
          this.form.mata_od = Boolean(data.mata_od);
          this.form.mata_os = Boolean(data.mata_os);

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
      if (!this.form.tanggal_operasi) {
        alert("Mohon lengkapi tanggal operasi!");
        return;
      }

      if (!this.form.mata_od && !this.form.mata_os) {
        alert("Mohon pilih mata yang dioperasi (OD/OS)!");
        return;
      }

      if (!this.form.operator) {
        alert("Mohon lengkapi nama operator!");
        return;
      }

      if (!this.form.diagnosis) {
        alert("Mohon lengkapi diagnosis!");
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

        // Convert boolean to 0/1 for backend
        const submitData = { ...this.form };
        submitData.mata_od = this.form.mata_od ? 1 : 0;
        submitData.mata_os = this.form.mata_os ? 1 : 0;

        Object.keys(submitData).forEach((key) => {
          fd.append(key, submitData[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-operasi-trabekulektomi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Laporan Operasi Trabekulektomi berhasil diupdate!"
          : "Laporan Operasi Trabekulektomi berhasil disimpan!";

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

.text-muted {
  color: #6c757d;
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
}

.form-control:focus {
  outline: none;
  border-color: #2d74b7;
}

.form-control-sm {
  padding: 6px 10px;
  font-size: 13px;
}

/* ================= CHECKBOX STYLING ================= */
.form-check {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-check-input {
  width: 18px;
  height: 18px;
  cursor: pointer;
  margin: 0;
}

.form-check-label {
  cursor: pointer;
  margin: 0;
  user-select: none;
  font-size: 14px;
  font-weight: 500;
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

/* ================= FLEXBOX UTILITIES ================= */
.d-flex {
  display: flex;
}

.gap-3 {
  gap: 1rem;
}

.gap-4 {
  gap: 1.5rem;
}

/* ================= INFO TABLE ================= */
.info-table {
  background: white;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.info-table table {
  width: 100%;
  margin-bottom: 0;
  border-collapse: collapse;
}

.info-table .table-bordered {
  border: 1px solid #dee2e6;
}

.info-table .label-cell {
  background: #f5f5f5;
  font-weight: 600;
  color: #333;
  vertical-align: middle;
  padding: 12px 15px;
  font-size: 14px;
  border: 1px solid #dee2e6;
}

.info-table td {
  padding: 12px 15px;
  vertical-align: middle;
  border: 1px solid #dee2e6;
}

.info-table tbody tr:hover {
  background: #f9fafb;
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

.step-number {
  font-weight: bold;
  color: #2d74b7;
  min-width: 35px;
  font-size: 15px;
  flex-shrink: 0;
}

.step-text {
  flex: 1;
  line-height: 1.6;
  color: #333;
  font-size: 14px;
}

/* ================= SIGNATURE SECTION ================= */
.signature-container {
  padding: 25px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;
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
  margin-bottom: 15px;
  color: #333;
  font-size: 16px;
  line-height: 1.4;
}

/* ================= SIGNATURE PAD & PREVIEW ================= */
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
  display: block;
  margin: 0 auto;
}

/* ================= BUTTONS ================= */
.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
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

  .signature-section {
    flex-direction: column;
    gap: 30px;
  }

  .sign-box {
    width: 100%;
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

  .step-number {
    min-width: 30px;
    font-size: 14px;
  }

  .step-text {
    font-size: 13px;
  }

  .info-table .label-cell,
  .info-table td {
    padding: 8px 10px;
    font-size: 13px;
  }

  /* Stack table cells on mobile */
  .info-table table,
  .info-table tbody,
  .info-table tr,
  .info-table td {
    display: block;
    width: 100%;
  }

  .info-table tr {
    margin-bottom: 15px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    overflow: hidden;
  }

  .info-table .label-cell {
    border-bottom: 1px solid #dee2e6;
  }

  .signature-box-rme {
    height: 180px;
  }

  .img-signature {
    height: 180px;
  }
}

@media (max-width: 480px) {
  .logo-rs {
    max-width: 120px;
  }

  .section-title-rme {
    font-size: 15px;
  }

  .d-flex {
    flex-direction: column;
    gap: 10px;
  }

  .gap-3,
  .gap-4 {
    gap: 0.5rem;
  }
}
</style>
