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
        <h2 class="fw-bold">ASESMEN AWAL GIZI - PASIEN BARU</h2>
        <h5 class="text-muted">Initial Nutrition Assessment - New Patient</h5>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
      </div>

      <!-- DATE -->
      <div class="row mb-3">
        <div class="col-md-12 mb-2">
          <label>Tanggal Asesmen :</label>
          <input type="date" v-model="form.tanggal_asesmen" class="form-control" />
        </div>
      </div>

      <!-- PATIENT INFO -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Pasien</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= 1. DIAGNOSA MEDIS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">1. Diagnosa Medis</h5>
        <div class="">
          <div class="col-md-12">
            <textarea
              v-model="form.diagnosa_medis"
              class="textarea-rme"
              rows="3"
              placeholder="Masukkan diagnosa medis pasien..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= 2. RISIKO MALNUTRISI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">
          2. Risiko Malnutrisi Berdasarkan Hasil Skrining Gizi oleh Perawat
        </h5>
        <p class="text-muted small mb-3">Kondisi pasien termasuk kategori:</p>

        <div class="row">
          <div class="col-md-12">
            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.risiko_malnutrisi"
                value="Risiko ringan (Nilai MST 0-1)"
                id="risiko_ringan"
              />
              <label class="form-check-label" for="risiko_ringan">
                Risiko ringan (Nilai MST 0-1)
              </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.risiko_malnutrisi"
                value="Risiko sedang (Nilai MST ≥ 2-3)"
                id="risiko_sedang"
              />
              <label class="form-check-label" for="risiko_sedang">
                Risiko sedang (Nilai MST ≥ 2-3)
              </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.risiko_malnutrisi"
                value="Risiko tinggi (Nilai MST 4-5)"
                id="risiko_tinggi"
              />
              <label class="form-check-label" for="risiko_tinggi">
                Risiko tinggi (Nilai MST 4-5)
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= 3. KONDISI KHUSUS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">3. Pasien Mempunyai Kondisi Khusus</h5>

        <div class="row">
          <div class="col-md-12">
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.kondisi_khusus"
                value="Ya"
                id="kondisi_ya"
              />
              <label class="form-check-label" for="kondisi_ya">Ya</label>
            </div>

            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.kondisi_khusus"
                value="Tidak"
                id="kondisi_tidak"
              />
              <label class="form-check-label" for="kondisi_tidak">Tidak</label>
            </div>
          </div>
        </div>

        <!-- Jika Ya, tampilkan textarea untuk keterangan -->
        <div v-if="form.kondisi_khusus === 'Ya'" class="row mt-3">
          <div class="col-md-12">
            <label>Keterangan Kondisi Khusus :</label>
            <textarea
              v-model="form.kondisi_khusus_keterangan"
              class="textarea-rme"
              rows="2"
              placeholder="Jelaskan kondisi khusus pasien..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= 4. ALERGI MAKANAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">4. Alergi Makanan</h5>

        <div class="row">
          <div class="col-md-6">
            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_telur"
                id="alergi_telur"
              />
              <label class="form-check-label" for="alergi_telur"> Telur </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_susu"
                id="alergi_susu"
              />
              <label class="form-check-label" for="alergi_susu">
                Susu sapi & produk olahannya
              </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_kacang"
                id="alergi_kacang"
              />
              <label class="form-check-label" for="alergi_kacang">
                Kacang kedelai/tanah
              </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_gluten"
                id="alergi_gluten"
              />
              <label class="form-check-label" for="alergi_gluten"> Gluten/gandum </label>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_udang"
                id="alergi_udang"
              />
              <label class="form-check-label" for="alergi_udang"> Udang </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_ikan"
                id="alergi_ikan"
              />
              <label class="form-check-label" for="alergi_ikan"> Ikan </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.alergi_hazelnut"
                id="alergi_hazelnut"
              />
              <label class="form-check-label" for="alergi_hazelnut">
                Hazelnut/Almond
              </label>
            </div>
          </div>
        </div>

        <div class="mt-3">
          <div class="col-md-12">
            <label>Alergi Lainnya :</label>
            <input
              type="text"
              v-model="form.alergi_lainnya"
              class="input-rme"
              placeholder="Sebutkan alergi makanan lainnya..."
            />
          </div>
        </div>
      </div>

      <!-- ================= 5. PRESKRIPSI DIET ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">5. Preskripsi Diet</h5>

        <div class="row">
          <div class="col-md-12">
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.preskripsi_diet"
                value="Makanan Biasa"
                id="diet_biasa"
              />
              <label class="form-check-label" for="diet_biasa">Makanan Biasa</label>
            </div>

            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.preskripsi_diet"
                value="Diet Khusus"
                id="diet_khusus"
              />
              <label class="form-check-label" for="diet_khusus">Diet Khusus</label>
            </div>
          </div>
        </div>

        <!-- Jika Diet Khusus, tampilkan textarea -->
        <div v-if="form.preskripsi_diet === 'Diet Khusus'" class="row mt-3">
          <div class="col-md-12">
            <label>Keterangan Diet Khusus :</label>
            <textarea
              v-model="form.preskripsi_diet_keterangan"
              class="textarea-rme"
              rows="2"
              placeholder="Jelaskan jenis diet khusus..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= 6. TINDAK LANJUT ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">6. Tindak Lanjut</h5>

        <div class="row">
          <div class="col-md-12">
            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.tindak_lanjut"
                value="Perlu asuhan gizi (lanjutkan ke Asesmen gizi)"
                id="tindak_perlu"
              />
              <label class="form-check-label" for="tindak_perlu">
                Perlu asuhan gizi (lanjutkan ke Asesmen gizi)
              </label>
            </div>

            <div class="form-check mb-2">
              <input
                class="form-check-input"
                type="radio"
                v-model="form.tindak_lanjut"
                value="Belum perlu asuhan gizi"
                id="tindak_belum"
              />
              <label class="form-check-label" for="tindak_belum">
                Belum perlu asuhan gizi
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= 7. KESIMPULAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">7. Kesimpulan</h5>
        <div class="">
          <div class="col-md-12">
            <textarea
              v-model="form.kesimpulan"
              class="textarea-rme"
              rows="4"
              placeholder="Masukkan kesimpulan asesmen gizi..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TEMPAT & TANGGAL ================= -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="tanggal-tempat">
            Medan, {{ formatTanggal(form.tanggal_asesmen) }}
          </div>
        </div>
      </div>

      <!-- ================= SIGNATURE AREA ================= -->
      <div class="signature-container">
        <div class="signature-section">
          <!-- Dokter Ahli Gizi -->
          <div class="sign-box">
            <label>Dokter Ahli Gizi / Dietitian</label>

            <!-- Preview TTD yang sudah ada -->
            <div
              v-if="form.ttd_dietitian && !signatureCleared.ttd_dietitian"
              class="signature-preview"
            >
              <img :src="form.ttd_dietitian" alt="TTD Dietitian" class="img-signature" />
              <button @click="clearSignature('ttd_dietitian')" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="ttd_dietitian"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('ttd_dietitian')" class="btn-save">
                Simpan ✔
              </button>
            </div>

            <input
              v-model="form.nama_dietitian"
              class="input-rme mt-2"
              placeholder="Nama Jelas Dokter Ahli Gizi"
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
  name: "DokumenDietitianPasienBaru",

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
        ttd_dietitian: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        tanggal_asesmen: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Data Pasien untuk form
        nama_pasien: "",
        no_rm_pasien: "",

        // 1. Diagnosa Medis
        diagnosa_medis: "",

        // 2. Risiko Malnutrisi (Radio)
        risiko_malnutrisi: "",

        // 3. Kondisi Khusus (Radio Ya/Tidak)
        kondisi_khusus: "",
        kondisi_khusus_keterangan: "",

        // 4. Alergi Makanan (Checkboxes)
        alergi_telur: false,
        alergi_susu: false,
        alergi_kacang: false,
        alergi_gluten: false,
        alergi_udang: false,
        alergi_ikan: false,
        alergi_hazelnut: false,
        alergi_lainnya: "",

        // 5. Preskripsi Diet (Radio)
        preskripsi_diet: "",
        preskripsi_diet_keterangan: "",

        // 6. Tindak Lanjut (Radio)
        tindak_lanjut: "",

        // 7. Kesimpulan
        kesimpulan: "",

        // Tanda Tangan
        ttd_dietitian: "",
        nama_dietitian: "",
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
      this.form.tanggal_asesmen = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.no_identitas || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-dietitian-pasien-baru/${this.editData}`
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
          if (data.tanggal_asesmen) {
            this.form.tanggal_asesmen = this.formatDate(new Date(data.tanggal_asesmen));
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
      if (!this.form.diagnosa_medis) {
        alert("Mohon lengkapi diagnosa medis!");
        return;
      }

      if (!this.form.risiko_malnutrisi) {
        alert("Mohon pilih risiko malnutrisi!");
        return;
      }

      if (!this.form.ttd_dietitian) {
        alert("Mohon lengkapi tanda tangan dietitian!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-dietitian-pasien-baru",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Dokumen Dietitian Pasien Baru berhasil diupdate!"
          : "Dokumen Dietitian Pasien Baru berhasil disimpan!";

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
  justify-content: center;
  margin-top: 30px;
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

.form-check {
  padding-left: 1.5rem;
}

.form-check-input {
  margin-top: 0.3rem;
}

.form-check-label {
  margin-bottom: 0;
  cursor: pointer;
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

.small {
  font-size: 0.875rem;
}

.text-muted {
  color: #6c757d;
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
