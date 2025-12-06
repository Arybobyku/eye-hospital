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
      <h2 class="fw-bold">Surat Penolakan Rujukan</h2>
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
    </div>

    <!-- DATE -->
    <div class="row mb-3">
      <div class="col-md-12 mb-2">
        <label>Tanggal :</label>
        <input type="date" v-model="form.tanggal" class="form-control" />
      </div>
    </div>

    <!-- ================= PEMBUAT PERNYATAAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Yang Bertanda Tangan Di Bawah Ini</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama :</label>
          <input type="text" v-model="form.pembuat_nama" class="input-rme" />
        </div>

        <div class="col-md-6">
          <label>NIK :</label>
          <input type="text" v-model="form.pembuat_nik" class="input-rme" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>Alamat :</label>
          <textarea v-model="form.pembuat_alamat" class="textarea-rme" rows="2"></textarea>
        </div>
      </div>
    </div>

    <!-- ================= INFORMASI PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Selaku Keluarga / Pendamping Pasien</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama Pasien :</label>
          <input type="text" v-model="form.pasien_nama" class="input-rme" readonly />
        </div>

        <div class="col-md-6">
          <label>NIK Pasien :</label>
          <input type="text" v-model="form.pasien_nik" class="input-rme" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>No. Rekam Medis :</label>
          <input type="text" v-model="form.pasien_no_rm" class="input-rme" readonly />
        </div>

        <div class="col-md-6">
          <label>Tanggal Lahir :</label>
          <input type="text" v-model="form.pasien_tanggal_lahir" class="input-rme" readonly />
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>Alamat Pasien :</label>
          <textarea
            v-model="form.pasien_alamat"
            class="textarea-rme"
            rows="2"
            readonly
          ></textarea>
        </div>
      </div>
    </div>

    <!-- ================= ISI PERNYATAAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Pernyataan</h5>

      <p style="text-align: justify; line-height: 1.8">
        Dengan ini menyatakan <strong>MENOLAK</strong> untuk dilakukan rujukan ke
        Rumah Sakit yang lebih lengkap fasilitasnya untuk pasien tersebut di atas.
      </p>

      <p style="text-align: justify; line-height: 1.8">
        Saya telah mendapat penjelasan dari dokter yang merawat bahwa kondisi pasien
        memerlukan perawatan di Rumah Sakit yang lebih lengkap fasilitasnya, namun saya
        dengan sadar dan tanpa paksaan dari pihak manapun menolak rujukan tersebut.
      </p>

      <p style="text-align: justify; line-height: 1.8">
        Saya memahami segala risiko dan konsekuensi yang mungkin terjadi akibat
        keputusan saya ini, dan saya tidak akan menuntut pihak rumah sakit atau tenaga
        medis atas segala akibat yang timbul dari penolakan rujukan ini.
      </p>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <div class="signature-section">
        <!-- Dokter -->
        <div class="sign-box">
          <label>Dokter yang Merawat</label>

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
            v-model="form.nama_dokter_ttd"
            class="input-rme mt-2"
            placeholder="Nama Dokter"
          />
        </div>

        <!-- Pembuat Pernyataan -->
        <div class="sign-box">
          <label>Yang Membuat Pernyataan</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_pembuat && !signatureCleared.ttd_pembuat" class="signature-preview">
            <img :src="form.ttd_pembuat" alt="TTD Pembuat" class="img-signature" />
            <button @click="clearSignature('ttd_pembuat')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_pembuat"
              :options="sigOption"
              class="signature-box-rme"
            />
            <button @click="saveSign('ttd_pembuat')" class="btn-save">Simpan ✔</button>
          </div>

          <input
            v-model="form.pembuat_nama"
            class="input-rme mt-2"
            placeholder="Nama Pembuat Pernyataan"
            readonly
          />
        </div>
      </div>

      <div class="tanggal-tempat">
        Bekasi, {{ formatTanggal(form.tanggal) }}
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
  name: "SuratPenolakanRujukan",

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
        ttd_pembuat: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        tanggal: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Yang bertanda tangan (pembuat pernyataan)
        pembuat_nama: "",
        pembuat_nik: "",
        pembuat_alamat: "",

        // Data Pasien
        pasien_nama: "",
        pasien_nik: "",
        pasien_no_rm: "",
        pasien_tanggal_lahir: "",
        pasien_alamat: "",

        // Tanda Tangan
        ttd_dokter: "",
        nama_dokter_ttd: "",
        ttd_pembuat: "",
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

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.pasien_no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.pasien_nama = this.selectedPatient?.nama || "";
      this.form.pasien_tanggal_lahir = this.selectedPatient?.tanggal_lahir || "";
      this.form.pasien_alamat = this.selectedPatient?.alamat || "";
      this.form.pasien_nik = this.selectedPatient?.nik || "";
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-surat-penolakan-rujukan/${this.editData}`
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
      if (!this.form.pembuat_nama || !this.form.pembuat_nik) {
        alert("Mohon lengkapi data pembuat pernyataan!");
        return;
      }

      if (!this.form.ttd_dokter || !this.form.ttd_pembuat) {
        alert("Mohon lengkapi semua tanda tangan!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-surat-penolakan-rujukan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Surat Penolakan Rujukan berhasil diupdate!"
          : "Surat Penolakan Rujukan berhasil disimpan!";

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
  padding: 8px;
  background: #fff;
  resize: vertical;
}

.signature-container {
  padding: 20px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
}

.signature-section {
  display: flex;
  justify-content: space-around;
  margin-top: 30px;
  margin-bottom: 20px;
  gap: 20px;
}

.sign-box {
  width: 45%;
  text-align: center;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
}

.signature-box-rme {
  width: 100%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
  background: white;
}

.signature-preview {
  width: 100%;
  border: 1px solid #999;
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
  padding: 5px 12px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
}

.btn-save:hover {
  background: #1565c0;
}

.btn-clear {
  background: #f44336;
  color: white;
  padding: 5px 12px;
  border: none;
  border-radius: 4px;
  margin-top: 10px;
  cursor: pointer;
  font-size: 12px;
}

.btn-clear:hover {
  background: #d32f2f;
}

.tanggal-tempat {
  text-align: right;
  font-weight: bold;
  margin-top: 20px;
  font-size: 14px;
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
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
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
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
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
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 12px;
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
  background: rgba(255, 255, 255, 0.9);
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
</style>