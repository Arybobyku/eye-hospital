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
        <h2 class="fw-bold">SURAT PERNYATAAN BATAL OPERASI</h2>
        <h5 class="text-muted">SURGERY CANCELLATION STATEMENT</h5>
          <h4 class="fw-semibold">{{ form.no_surat}}</h4>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
      </div>

      <!-- DATE -->
      <div class="mb-3">
        <div class="col-md-12 mb-2">
          <label>Tanggal Surat :</label>
          <input type="date" v-model="form.tanggal_surat" class="form-control" />
        </div>
      </div>

      <!-- ================= YANG BERTANDATANGAN DI BAWAH INI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">
          Yang bertandatangan di bawah ini menerangkan bahwa
        </h5>

        <div class="mb-3">
          <div class="col-md-12">
            <label>Nama :</label>
            <input
              type="text"
              v-model="form.pernyataan_nama"
              class="input-rme"
              readonly
            />
          </div>
        </div>

        <div class="mb-3">
        <div class="col-md-6">
          <label>Jenis Kelamin :</label>
          <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
        </div>

          <div class="col-md-6">
            <label>Tempat, Tanggal Lahir :</label>
            <input
              type="text"
              v-model="form.pernyataan_tempat_tanggal_lahir"
              class="input-rme"
              placeholder="Medan, 15 Mei 1985"
            />
          </div>
        </div>
      </div>

      <!-- ================= DETAIL OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Operasi Yang Dibatalkan</h5>

        <div class="mb-3">
          <div class="row-md-12">
            <label>Tanggal Operasi (yang direncanakan) :</label>
            <input type="date" v-model="form.tanggal_operasi" class="form-control" />
          </div>
        </div>

        <div class="mb-3">
          <div class="col-md-12">
            <label>Jenis Operasi :</label>
            <input
              type="text"
              v-model="form.jenis_operasi"
              class="input-rme"
              placeholder="Contoh: Operasi Katarak Fakoemulsifikasi OD"
            />
          </div>
        </div>

        <div class="col">
          <div class="col-md-12">
            <label>Alasan Batal Operasi :</label>
            <textarea
              v-model="form.alasan_batal_operasi"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan alasan pembatalan operasi..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= SARAN DAN JAWABAN PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Saran Dokter dan Jawaban Pasien</h5>

        <div class="mb-3">
          <div class="col-md-12">
            <label>Saran Dokter :</label>
            <textarea
              v-model="form.saran_dokter"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan saran dokter kepada pasien..."
            ></textarea>
          </div>
        </div>

        <div class="">
          <div class="col-md-12">
            <label>Jawaban Pasien :</label>
            <textarea
              v-model="form.jawaban_pasien"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan jawaban/tanggapan pasien..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= PERNYATAAN ================= -->
      <div class="box-rme mb-4">
        <p style="text-align: justify; line-height: 1.8">
          Dengan ini saya menyatakan bahwa saya telah memutuskan untuk
          <strong>membatalkan</strong>
          tindakan operasi yang telah dijadwalkan. Saya memahami segala konsekuensi dari
          keputusan ini dan tidak akan menuntut pihak rumah sakit atas pembatalan operasi
          tersebut.
        </p>
        <p style="text-align: justify; line-height: 1.8; margin-top: 15px">
          <em
            >I hereby declare that I have decided to cancel the scheduled surgery. I
            understand all the consequences of this decision and will not hold the
            hospital responsible for the cancellation.</em
          >
        </p>
      </div>

      <!-- ================= TEMPAT & TANGGAL ================= -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="tanggal-tempat">Medan, {{ formatTanggal(form.tanggal_surat) }}</div>
        </div>
      </div>

      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <div class="signature-section">
          <!-- Pasien/Keluarga yang menyatakan -->
          <div class="sign-box">
            <label>Yang Menyatakan</label>
            <label class="mt-2">(Pasien / Keluarga Pasien)</label>

            <!-- Preview TTD yang sudah ada -->
            <div
              v-if="form.ttd_pernyataan && !signatureCleared.ttd_pernyataan"
              class="signature-preview"
            >
              <img
                :src="form.ttd_pernyataan"
                alt="TTD Pernyataan"
                class="img-signature"
              />
              <button @click="clearSignature('ttd_pernyataan')" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_pernyataan"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('ttd_pernyataan')" class="btn-save">
                Simpan ✔
              </button>
            </div>

            <input
              v-model="form.nama_pembuat_pernyataan"
              class="input-rme mt-2"
              placeholder="Nama Jelas"
            />
          </div>

          <!-- Saksi/Dokter -->
          <div class="sign-box">
            <label>Saksi / Dokter</label>

            <!-- Preview TTD yang sudah ada -->
            <div
              v-if="form.ttd_saksi && !signatureCleared.ttd_saksi"
              class="signature-preview"
            >
              <img :src="form.ttd_saksi" alt="TTD Saksi" class="img-signature" />
              <button @click="clearSignature('ttd_saksi')" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_saksi"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('ttd_saksi')" class="btn-save">Simpan ✔</button>
            </div>

            <input
              v-model="form.nama_saksi"
              class="input-rme mt-2"
              placeholder="Nama Jelas Saksi/Dokter"
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
  name: "SuratPernyataanBatalOperasi",

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
      disabledSubmit: false,
      signatureCleared: {
        ttd_pernyataan: false,
        ttd_saksi: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        tanggal_surat: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        no_surat: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Yang Bertandatangan
        pernyataan_nama: "",
        pernyataan_jenis_kelamin: "",
        pernyataan_tempat_tanggal_lahir: "",

        // Detail Operasi
        tanggal_operasi: "",
        jenis_operasi: "",
        alasan_batal_operasi: "",

        // Saran dan Jawaban
        saran_dokter: "",
        jawaban_pasien: "",

        // Tanda Tangan
        ttd_pernyataan: "",
        nama_pembuat_pernyataan: "",
        ttd_saksi: "",
        nama_saksi: "",
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
    console.log("🟢 COMPONENT - Mounted");
    console.log("🟢 COMPONENT - editData:", this.editData);
    console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
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
      this.form.tanggal_surat = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.no_identitas || "";

      // Data yang bertandatangan (default dari data pasien)
      this.form.pernyataan_nama = this.selectedPatient?.nama || "";
      this.form.pernyataan_jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";

      // Format tempat tanggal lahir
      if (this.selectedPatient?.tempat_lahir && this.selectedPatient?.tanggal_lahir) {
        this.form.pernyataan_tempat_tanggal_lahir = `${
          this.selectedPatient.tempat_lahir
        }, ${this.formatTanggal(this.selectedPatient.tanggal_lahir)}`;
      } else if (this.selectedPatient?.tanggal_lahir) {
        this.form.pernyataan_tempat_tanggal_lahir = this.formatTanggal(
          this.selectedPatient.tanggal_lahir
        );
      }

      // Nama pembuat pernyataan default dari nama pasien
      this.form.nama_pembuat_pernyataan = this.selectedPatient?.nama || "";
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-surat-pernyataan-batal-operasi/${this.editData}`
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
          if (data.tanggal_surat) {
            this.form.tanggal_surat = this.formatDate(new Date(data.tanggal_surat));
          }
          if (data.tanggal_operasi) {
            this.form.tanggal_operasi = this.formatDate(new Date(data.tanggal_operasi));
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
      if (!this.form.pernyataan_nama || !this.form.pernyataan_jenis_kelamin) {
        alert("Mohon lengkapi data yang bertandatangan!");
        return;
      }

      if (!this.form.tanggal_operasi || !this.form.alasan_batal_operasi) {
        alert("Mohon lengkapi tanggal operasi dan alasan pembatalan!");
        return;
      }

      if (!this.form.ttd_pernyataan) {
        alert("Mohon lengkapi tanda tangan yang menyatakan!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-surat-pernyataan-batal-operasi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Surat Pernyataan Batal Operasi berhasil diupdate!"
          : "Surat Pernyataan Batal Operasi berhasil disimpan!";

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
  max-width: 900px;
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

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

.fw-semibold {
  font-weight: 600;
}

.small {
  font-size: 0.875rem;
}

.text-center h2 {
  font-size: 20px;
  margin-bottom: 8px;
  color: #333;
}

.text-center h5 {
  font-size: 15px;
  margin-bottom: 15px;
  font-weight: normal;
}

/* ================= BADGE ================= */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 12px;
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
  margin-bottom: 20px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.box-rme p {
  text-align: justify;
  line-height: 1.8;
  font-size: 14px;
  color: #333;
  margin: 0;
}

.box-rme p strong {
  color: #d32f2f;
  font-weight: 600;
}

.box-rme p em {
  color: #666;
  font-size: 13px;
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

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 12px;
  background: #fff;
  resize: vertical;
  font-family: "Arial", sans-serif;
  line-height: 1.6;
  font-size: 14px;
  min-height: 100px;
  transition: border-color 0.3s;
}

.textarea-rme:focus {
  outline: none;
  border-color: #2d74b7;
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

select.form-control {
  cursor: pointer;
  background-color: #fff;
}

/* ================= ROW & COLUMNS ================= */
.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -10px;
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

.col-md-6,
.col-md-12,
.row-md-12 {
  padding: 0 10px;
  margin-bottom: 15px;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12,
.row-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

.col {
  padding: 0 10px;
}

/* ================= TANGGAL TEMPAT ================= */
.tanggal-tempat {
  text-align: right;
  font-weight: bold;
  margin-top: 20px;
  margin-bottom: 10px;
  font-size: 14px;
  color: #333;
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
  margin-bottom: 20px;
  gap: 30px;
}

.sign-box {
  flex: 1;
  text-align: center;
  max-width: 45%;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
  font-size: 14px;
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
  margin-top: 15px;
}

.signature-preview {
  width: 100%;
  border: 2px solid #999;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
  margin-top: 15px;
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
  font-size: 13px;
  font-weight: 500;
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

/* ================= UTILITIES ================= */
.mt-2 {
  margin-top: 8px;
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
    font-size: 18px;
  }

  .text-center h5 {
    font-size: 14px;
  }

  .box-rme {
    padding: 15px;
  }
}

@media (max-width: 480px) {
  .signature-box-rme {
    height: 180px;
  }

  .img-signature {
    height: 180px;
  }

  .box-rme p {
    font-size: 13px;
  }

  .section-title-rme {
    font-size: 15px;
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
