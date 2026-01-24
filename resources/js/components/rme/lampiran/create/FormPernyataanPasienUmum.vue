<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4"></div>
  <div class="form-wrapper position-relative">
    <div v-if="disabledSubmit" class="view-overlay"></div>
    <!-- LOADING OVERLAY -->
    <div v-if="loadingData" class="loading-overlay">
      <div class="spinner-rme"></div>
      <p>Memuat data...</p>
    </div>

    <!-- ================= HEADER ================= -->
    <div class="text-center mb-4">
      <h2 class="fw-bold">SURAT PERNYATAAN PASIEN UMUM</h2>
      <h5 class="text-muted">General Patient Statement Letter</h5>
      <span v-if="isEditMode && !disabledSubmit"" class="badge bg-warning">Mode Edit</span>
      <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
    </div>

    <!-- DATE -->
    <div class="row mb-3">
      <div class="col-md-12 mb-2">
        <label>Tanggal Surat :</label>
        <input type="date" v-model="form.tanggal_surat" class="form-control" />
      </div>
    </div>

    <!-- ================= YANG BERTANDATANGAN DI BAWAH INI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Yang bertandatangan dibawah ini :</h5>

      <div class="mb-3">
        <div class="col-md-12">
          <label>Nama :</label>
          <input
            type="text"
            v-model="form.pembuat_nama"
            class="input-rme"
            placeholder="Masukkan nama pembuat pernyataan..."
          />
        </div>
      </div>

      <div class="mb-3">
        <div class="col-md-6">
          <label>Tempat, Tanggal Lahir :</label>
          <input
            type="text"
            v-model="form.pembuat_tempat_tanggal_lahir"
            class="input-rme"
            placeholder="Medan, 15 Mei 1985"
          />
        </div>

        <div class="col-md-6">
          <label>Pekerjaan :</label>
          <input
            type="text"
            v-model="form.pembuat_pekerjaan"
            class="input-rme"
            placeholder="Wiraswasta, PNS, dll"
          />
        </div>
      </div>

      <div class="mb-3">
        <div class="col-md-12">
          <label>Alamat :</label>
          <textarea
            v-model="form.pembuat_alamat"
            class="textarea-rme"
            rows="2"
            placeholder="Masukkan alamat lengkap..."
          ></textarea>
        </div>
      </div>

      <div class="mb-3">
        <div class="col-md-6">
          <label>No Telp/HP :</label>
          <input
            type="text"
            v-model="form.pembuat_no_telp"
            class="input-rme"
            placeholder="08123456789"
          />
        </div>

        <div class="col-md-6">
          <label>Hubungan Keluarga Pasien :</label>
          <input
            type="text"
            v-model="form.pembuat_hubungan_keluarga"
            class="input-rme"
            placeholder="Orang Tua, Anak, Suami/Istri, dll"
          />
        </div>
      </div>
    </div>

    <!-- ================= BERTINDAK UNTUK DAN ATAS NAMA PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Bertindak untuk dan atas nama pasien :</h5>

      <div class="mb-3">
        <div class="col-md-12">
          <label>Nama :</label>
          <input type="text" v-model="form.pasien_nama" class="input-rme" readonly />
        </div>
      </div>

      <div class="mb-3">
        <div class="col-md-6">
          <label>Tempat, Tanggal Lahir :</label>
          <input
            type="text"
            v-model="form.pasien_tempat_tanggal_lahir"
            class="input-rme"
          />
        </div>

        <div class="col-md-6">
          <label>No. RM :</label>
          <input type="text" v-model="form.pasien_no_rm" class="input-rme" readonly />
        </div>
      </div>

      <div class="">
        <div class="col-md-12">
          <label>Alamat :</label>
          <textarea
            v-model="form.pasien_alamat"
            class="textarea-rme"
            rows="2"
            placeholder="Masukkan alamat pasien..."
          ></textarea>
        </div>
      </div>
    </div>

    <!-- ================= PERNYATAAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Dengan ini menyatakan bahwa :</h5>

      <ol style="line-height: 2; text-align: justify">
        <li>
          Saya sudah mendapat penjelasan dan telah dianjurkan untuk memakai penjamin BPJS
          jikalau memiliki kartu BPJS dan sesuai dengan ketentuan yang berlaku.
        </li>
        <li>
          Bahwa pasien tersebut tidak memiliki dan atau tidak mau menggunakan fasilitas
          jaminan kepesertaan BPJS Kesehatan.
        </li>
        <li>
          Bahwa atas keinginan sendiri pasien tersebut diatas saya setuju dilakukan
          pemeriksaan, pengobatan, perawatan sebagai pasien umum setelah saya memahami
          perlunya dan manfaat tindakan tersebut.
        </li>
        <li>
          Bahwa saya bertanggung jawab dan bersedia membayar sendiri, secara pribadi atas
          biaya pemeriksaan, pengobatan, tindakan, dan perawatan sebagai pasien umum.
        </li>
        <li>
          Bahwa apabila saya melakukan pengingkaran atas pernyataan poin 1 – 4, maka saya
          bersedia dituntut secara hukum pasal penipuan/membuat pernyataan palsu.
        </li>
      </ol>

      <p
        style="
          text-align: justify;
          line-height: 1.8;
          margin-top: 20px;
          font-style: italic;
        "
      >
        Demikian surat penyataan ini saya perbuat dengan sadar, tidak dalam kondisi panik,
        tanpa ada unsur paksaan dan tekanan dari pihak manapun.
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
      <div class="signature-section-triple">
        <!-- Yang Membuat Pernyataan -->
        <div class="sign-box">
          <label>Yang membuat pernyataan</label>

          <!-- Preview TTD yang sudah ada -->
          <div
            v-if="form.ttd_pembuat_pernyataan && !signatureCleared.ttd_pembuat_pernyataan"
            class="signature-preview"
          >
            <img
              :src="form.ttd_pembuat_pernyataan"
              alt="TTD Pembuat"
              class="img-signature"
            />
            <button @click="clearSignature('ttd_pembuat_pernyataan')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_pembuat_pernyataan"
              :options="sigOption"
              class="signature-box-rme-small"
            />
            <button @click="saveSign('ttd_pembuat_pernyataan')" class="btn-save">
              Simpan ✔
            </button>
          </div>

          <input
            v-model="form.nama_pembuat_pernyataan"
            class="input-rme mt-2"
            placeholder="Nama Jelas"
          />
        </div>

        <!-- Saksi Pasien -->
        <div class="sign-box">
          <label>Saksi Pasien</label>

          <!-- Preview TTD yang sudah ada -->
          <div
            v-if="form.ttd_saksi_pasien && !signatureCleared.ttd_saksi_pasien"
            class="signature-preview"
          >
            <img
              :src="form.ttd_saksi_pasien"
              alt="TTD Saksi Pasien"
              class="img-signature"
            />
            <button @click="clearSignature('ttd_saksi_pasien')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_saksi_pasien"
              :options="sigOption"
              class="signature-box-rme-small"
            />
            <button @click="saveSign('ttd_saksi_pasien')" class="btn-save">
              Simpan ✔
            </button>
          </div>

          <input
            v-model="form.nama_saksi_pasien"
            class="input-rme mt-2"
            placeholder="Nama Jelas Saksi"
          />
        </div>

        <!-- Saksi Petugas RS -->
        <div class="sign-box">
          <label>Saksi Petugas Rumah Sakit</label>

          <!-- Preview TTD yang sudah ada -->
          <div
            v-if="form.ttd_saksi_petugas && !signatureCleared.ttd_saksi_petugas"
            class="signature-preview"
          >
            <img
              :src="form.ttd_saksi_petugas"
              alt="TTD Saksi Petugas"
              class="img-signature"
            />
            <button @click="clearSignature('ttd_saksi_petugas')" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_saksi_petugas"
              :options="sigOption"
              class="signature-box-rme-small"
            />
            <button @click="saveSign('ttd_saksi_petugas')" class="btn-save">
              Simpan ✔
            </button>
          </div>

          <input
            v-model="form.nama_saksi_petugas"
            class="input-rme mt-2"
            placeholder="Nama Jelas Petugas"
          />
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
  name: "SuratPernyataanPasienUmum",

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
        ttd_pembuat_pernyataan: false,
        ttd_saksi_pasien: false,
        ttd_saksi_petugas: false,
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
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Yang Bertandatangan (Pembuat Pernyataan)
        pembuat_nama: "",
        pembuat_tempat_tanggal_lahir: "",
        pembuat_alamat: "",
        pembuat_pekerjaan: "",
        pembuat_no_telp: "",
        pembuat_hubungan_keluarga: "",

        // Bertindak untuk dan atas nama Pasien
        pasien_nama: "",
        pasien_tempat_tanggal_lahir: "",
        pasien_alamat: "",
        pasien_no_rm: "",

        // Tanda Tangan (Triple Signatures)
        ttd_pembuat_pernyataan: "",
        nama_pembuat_pernyataan: "",
        ttd_saksi_pasien: "",
        nama_saksi_pasien: "",
        ttd_saksi_petugas: "",
        nama_saksi_petugas: "",
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
    }
    if (this.editData) {
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
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.pasien_nama = this.selectedPatient?.nama || "";
      this.form.pasien_no_rm = this.selectedPatient?.rekam_medis || "";

      // Format tempat tanggal lahir pasien
      if (this.selectedPatient?.tempat_lahir && this.selectedPatient?.tanggal_lahir) {
        this.form.pasien_tempat_tanggal_lahir = `${
          this.selectedPatient.tempat_lahir
        }, ${this.formatTanggal(this.selectedPatient.tanggal_lahir)}`;
      } else if (this.selectedPatient?.tanggal_lahir) {
        this.form.pasien_tempat_tanggal_lahir = this.formatTanggal(
          this.selectedPatient.tanggal_lahir
        );
      }

      // Alamat pasien
      this.form.pasien_alamat = this.selectedPatient?.alamat || "";
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-surat-pernyataan-pasien-umum/${this.editData}`
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
      if (!this.form.pembuat_nama || !this.form.pembuat_no_telp) {
        alert("Mohon lengkapi data pembuat pernyataan!");
        return;
      }

      if (!this.form.ttd_pembuat_pernyataan) {
        alert("Mohon lengkapi tanda tangan pembuat pernyataan!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-surat-pernyataan-pasien-umum",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Surat Pernyataan Pasien Umum berhasil diupdate!"
          : "Surat Pernyataan Pasien Umum berhasil disimpan!";

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
  min-height: 80px;
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

/* ================= ORDERED LIST ================= */
ol {
  padding-left: 25px;
  line-height: 2;
  text-align: justify;
  margin: 0;
}

ol li {
  margin-bottom: 10px;
  font-size: 14px;
  color: #333;
}

.box-rme p {
  text-align: justify;
  line-height: 1.8;
  margin-top: 20px;
  font-style: italic;
  font-size: 14px;
  color: #555;
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

.signature-section-triple {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-top: 20px;
  margin-bottom: 20px;
  gap: 20px;
}

.sign-box {
  flex: 1;
  text-align: center;
  min-width: 0;
}

.sign-box label {
  font-weight: bold;
  display: block;
  margin-bottom: 15px;
  color: #333;
  font-size: 13px;
  line-height: 1.4;
  min-height: 35px;
}

/* ================= MATERAI ================= */
.materai-box {
  border: 2px solid #333;
  padding: 10px;
  margin: 10px auto 15px;
  width: 90px;
  font-weight: bold;
  font-size: 11px;
  line-height: 1.3;
  text-align: center;
  background: #fff;
}

/* ================= SIGNATURE PAD & PREVIEW ================= */
.signature-box-rme-small {
  width: 100%;
  height: 120px;
  border: 2px solid #999;
  margin-bottom: 10px;
  background: white;
  border-radius: 4px;
}

.signature-preview {
  width: 100%;
  border: 2px solid #999;
  background: white;
  padding: 8px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.img-signature {
  max-width: 100%;
  height: 120px;
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
  padding: 6px 14px;
  border: none;
  border-radius: 4px;
  margin-bottom: 8px;
  cursor: pointer;
  font-size: 12px;
  font-weight: 500;
  transition: background 0.3s;
}

.btn-save:hover {
  background: #1565c0;
}

.btn-clear {
  background: #f44336;
  color: white;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  margin-top: 8px;
  cursor: pointer;
  font-size: 11px;
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

  .signature-section-triple {
    flex-direction: column;
    gap: 30px;
  }

  .sign-box {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
  }

  .sign-box label {
    min-height: auto;
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

  .materai-box {
    margin-left: auto;
    margin-right: auto;
  }
}

@media (max-width: 480px) {
  .box-rme {
    padding: 15px;
  }

  ol {
    padding-left: 20px;
  }

  ol li {
    font-size: 13px;
  }

  .signature-box-rme-small {
    height: 150px;
  }

  .img-signature {
    height: 150px;
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
