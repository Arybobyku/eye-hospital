<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">SURAT KETERANGAN HASIL PEMERIKSAAN MATA</h2>
          <h5 class="text-muted">{{ form.no_surat }}</h5>
          <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
        </div>

        <!-- INFORMASI PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="form-row-2">
            <div>
              <label>Nama :</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div>
              <label>No. RM :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Tempat Lahir :</label>
              <input type="text" v-model="form.tempat_lahir" class="input-rme" readonly />
            </div>
            <div>
              <label>Tgl. Lahir :</label>
              <input type="date" v-model="form.tanggal_lahir" class="input-rme" readonly/>
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>NIK :</label>
              <input type="text" v-model="form.nik" class="input-rme" readonly />
            </div>
            <div>
              <label>Jenis Kelamin :</label>
              <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
            </div>
          </div>
          <div class="mb-3">
            <label>Alamat :</label>
            <textarea v-model="form.alamat" class="input-rme" rows="2" readonly></textarea>
          </div>
        </div>

        <!-- PASFOTO -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pasfoto Pasien (4×6 cm)</h5>
          <div class="pasfoto-area">
            <div class="pasfoto-preview" v-if="pasfotoPreview || form.pasfoto">
              <img :src="pasfotoPreview || form.pasfoto" alt="Pasfoto" class="img-pasfoto" />
              <button @click="removePasfoto" class="btn-clear mt-2" type="button">Hapus Foto</button>
            </div>
            <div class="pasfoto-upload" v-else>
              <label for="pasfoto-input" class="upload-label">
                <span class="upload-icon">📷</span>
                <span>Klik untuk upload foto 4×6</span>
                <span class="upload-hint">JPG, PNG — maks. 2MB</span>
              </label>
              <input
                id="pasfoto-input"
                type="file"
                accept="image/jpeg,image/png"
                @change="onPasfotoChange"
                style="display:none;"
              />
            </div>
          </div>
        </div>

        <!-- HASIL PEMERIKSAAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Hasil Pemeriksaan</h5>

          <!-- Visual Acuity -->
          <div class="mb-3">
            <label class="label-section">Visual Acuity / Tajam Penglihatan</label>
            <div class="form-row-2 mt-2">
              <div>
                <label>Mata Kanan / Ocular Dextra :</label>
                <input type="text" v-model="form.va_od" class="input-rme" placeholder="Contoh: 6/6" />
              </div>
              <div>
                <label>Koreksi Kacamata :</label>
                <input type="text" v-model="form.koreksi_od" class="input-rme" placeholder="Contoh: -1.00 sph" />
              </div>
            </div>
            <div class="form-row-2">
              <div>
                <label>Mata Kiri / Ocular Sinistra :</label>
                <input type="text" v-model="form.va_os" class="input-rme" placeholder="Contoh: 6/6" />
              </div>
              <div>
                <label>Koreksi Kacamata :</label>
                <input type="text" v-model="form.koreksi_os" class="input-rme" placeholder="Contoh: -1.00 sph" />
              </div>
            </div>
          </div>

          <!-- Tekanan Bola Mata -->
          <div class="mb-3">
            <label class="label-section">Tekanan Bola Mata</label>
            <div class="form-row-2 mt-2">
              <div>
                <label>Mata Kanan / Ocular Dextra (mmHg) :</label>
                <input type="text" v-model="form.tio_od" class="input-rme" placeholder="Contoh: 14" />
              </div>
              <div>
                <label>Mata Kiri / Ocular Sinistra (mmHg) :</label>
                <input type="text" v-model="form.tio_os" class="input-rme" placeholder="Contoh: 16" />
              </div>
            </div>
          </div>

          <!-- Penglihatan Warna -->
          <div class="mb-3">
            <label>Penglihatan Warna / Color Vision Test (Ishihara Test) :</label>
            <textarea v-model="form.penglihatan_warna" class="textarea-rme" rows="2" placeholder="Hasil tes ishihara..."></textarea>
          </div>
        </div>

        <!-- KESIMPULAN & SARAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Kesimpulan & Saran</h5>
          <div class="mb-3">
            <label>Kesimpulan :</label>
            <textarea v-model="form.kesimpulan" class="textarea-rme" rows="3" placeholder="Masukkan kesimpulan hasil pemeriksaan..."></textarea>
          </div>
          <div class="mb-3">
            <label>Saran :</label>
            <textarea v-model="form.saran" class="textarea-rme" rows="3" placeholder="Masukkan saran..."></textarea>
          </div>
        </div>

        <!-- TANDA TANGAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan Dokter</h5>
          <div class="mb-3">
            <label>Medan, Tanggal :</label>
            <input type="date" v-model="form.tanggal_surat" class="input-rme" style="max-width:280px;" />
          </div>

          <div class="sign-box text-center">
            <label class="fw-bold d-block mb-2">Salam Sejawat,</label>

            <div v-if="form.ttd_dokter && !ttdDokterCleared" class="signature-preview">
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <p v-if="form.ttd_dokter_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ formatTimestamp(form.ttd_dokter_timestamp) }}
              </p>
              <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else>
              <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button>
            </div>

            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter</option>
                <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>
        </div>

        <!-- ACTION FOOTER -->
        <div class="action-footer" v-if="!disabledSubmit">
          <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
            <span v-if="loadingSubmit">Menyimpan...</span>
            <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
          </button>
          <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Kembali</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormSuratKeteranganHasilPemeriksaanMata",

  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
  },

  data() {
    return {
      loadingSubmit: false,
      disabledSubmit: false,
      listDokter: [],
      ttdDokterCleared: false,
      pasfotoFile: null,
      pasfotoPreview: null,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid:              "",
        uuid_pasien:       "",
        no_surat:          "",
        no_rm:             "",
        nik:               "",
        nama:              "",
        tanggal_lahir:     "",
        jenis_kelamin:     "",
        tempat_lahir:      "",
        alamat:            "",
        va_od:             "",
        koreksi_od:        "",
        va_os:             "",
        koreksi_os:        "",
        tio_od:            "",
        tio_os:            "",
        penglihatan_warna: "",
        kesimpulan:        "",
        saran:             "",
        pasfoto:           "",
        tanggal_surat:     "",
        ttd_dokter:        "",
        nama_dokter:       "",
        ttd_dokter_timestamp: "",
      },
    };
  },

  computed: {
    isEditMode() {
      return this.editData !== null && this.editData !== undefined;
    },
  },

  async mounted() {
    await this.fetchDokter();
    await this.fetchTahunAkreditasi();

    if (this.viewData === true) {
      this.disabledSubmit = true;
      if (this.editData) this.loadDataForEdit();
    } else if (this.viewData && typeof this.viewData === "object") {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    async fetchDokter() {
      try {
        const res = await axios.get("/master/pasien/master-dokter-all");
        this.listDokter = res.data.data;
      } catch (e) {
        console.error("Gagal memuat dokter:", e);
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get("/api/tahun-akreditasi");
        const tahun = response.data.tahun || "22";
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 9.2/SKHPM/${tahun}`;
        }
      } catch {
        if (!this.form.no_surat) {
          this.form.no_surat = "RM 9.2/SKHPM/22";
        }
      }
    },

    setDataForm() {
      const today = new Date().toISOString().split("T")[0];
      this.form.tanggal_surat  = today;
      this.form.uuid_pasien    = this.selectedPatient?.uuid          || "";
      this.form.no_rm          = this.selectedPatient?.rekam_medis   || "";
      this.form.nik            = this.selectedPatient?.no_identitas  || "";
      this.form.nama           = this.selectedPatient?.nama          || "";
      this.form.tanggal_lahir  = this.selectedPatient?.tanggal_lahir || "";
      this.form.jenis_kelamin  = this.selectedPatient?.jenis_kelamin || "";
      this.form.tempat_lahir   = this.selectedPatient?.tempat_lahir  || "";
      this.form.alamat         = this.selectedPatient?.alamat        || "";
    },

    loadDataForEdit() {
      const src = (this.viewData && typeof this.viewData === "object")
        ? this.viewData
        : this.editData;

      if (!src) { this.setDataForm(); return; }

      Object.keys(this.form).forEach((key) => {
        if (src.hasOwnProperty(key) && src[key] !== null) {
          this.form[key] = src[key];
        }
      });

      if (this.form.pasfoto) {
        this.pasfotoPreview = `/storage/${this.form.pasfoto}`;
      }

      this.$nextTick(() => {
        if (this.form.ttd_dokter) this.ttdDokterCleared = false;
      });
    },

    onPasfotoChange(e) {
      const file = e.target.files[0];
      if (!file) return;
      if (file.size > 2 * 1024 * 1024) {
        alert("Ukuran foto maksimal 2MB!"); return;
      }
      this.pasfotoFile = file;
      this.pasfotoPreview = URL.createObjectURL(file);
    },

    removePasfoto() {
      this.pasfotoFile = null;
      this.pasfotoPreview = null;
      this.form.pasfoto = "";
      const input = document.getElementById("pasfoto-input");
      if (input) input.value = "";
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
      this.ttdDokterCleared   = false;
      this.form.ttd_dokter    = data;
      this.form.ttd_dokter_timestamp = new Date().toISOString();
    },

    clearSign(refName) {
      this.ttdDokterCleared         = true;
      this.form.ttd_dokter          = "";
      this.form.ttd_dokter_timestamp = "";
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    formatTimestamp(iso) {
      if (!iso) return "";
      return new Date(iso).toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });
    },

    async submitForm() {
      if (!this.form.kesimpulan?.trim()) {
        alert("Kesimpulan harus diisi!"); return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          const val = this.form[key];
          fd.append(key, val === null || val === undefined ? "" : val);
        });

        if (this.pasfotoFile) {
          fd.append("pasfoto_file", this.pasfotoFile);
        }

        const res = await axios.post(
          "/master/pasien/dokumen-surat-keterangan-hasil-pemeriksaan-mata",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          alert(`✅ ${res.data.message}`);
          this.$emit("back");
        } else {
          alert(`❌ ${res.data.message || "Gagal menyimpan!"}`);
        }
      } catch (err) {
        console.error(err);
        const msg = err.response?.data?.message || "Gagal menyimpan data!";
        alert(`❌ ${msg}`);
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1000px; margin: 0 auto; }
.py-4 { padding: 1.5rem 0; }

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
  margin-bottom: 20px;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.label-section {
  display: block;
  font-weight: 600;
  font-size: 14px;
  color: #444;
  margin-bottom: 4px;
}

.form-row-2 {
  display: flex;
  gap: 1rem;
  margin-bottom: 10px;
}
.form-row-2 > div { flex: 1; }

.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 16px; }
.mb-4 { margin-bottom: 24px; }
.mt-2 { margin-top: 8px; }
.d-block { display: block; }

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 14px;
  color: #333;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  box-sizing: border-box;
}
.input-rme:focus { outline: none; border-color: #2d74b7; background: white; }
.input-rme[readonly] { background: #e9ecef; cursor: not-allowed; }

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
  box-sizing: border-box;
}
.textarea-rme:focus { outline: none; border-color: #2d74b7; background: white; }

/* Pasfoto */
.pasfoto-area {
  display: flex;
  justify-content: center;
}

.pasfoto-upload {
  width: 160px;
  height: 200px;
  border: 2px dashed #90caf9;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f0f8ff;
  cursor: pointer;
}

.upload-label {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  text-align: center;
  padding: 10px;
  font-weight: normal;
  color: #1976d2;
  font-size: 13px;
}

.upload-icon { font-size: 32px; }
.upload-hint { font-size: 11px; color: #888; }

.pasfoto-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.img-pasfoto {
  width: 120px;
  height: 160px;
  object-fit: cover;
  border: 1px solid #ccc;
  border-radius: 4px;
}

/* Signature */
.sign-box { text-align: center; }

.signature-box-rme {
  width: 320px !important;
  height: 200px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
}

.signature-preview {
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
  display: block;
  margin: 0 auto;
}

.timestamp-ttd {
  font-size: 12px;
  color: #2d74b7;
  background: #e9f5ff;
  border-radius: 4px;
  padding: 4px 12px;
  display: block;
  width: fit-content;
  margin: 6px auto;
}

.dropdown-dokter { position: relative; width: 100%; max-width: 400px; margin: 0 auto; }

.form-select-dokter {
  width: 100%;
  padding: 8px 36px 8px 12px;
  font-size: 14px;
  border: 1.5px solid #cbd5e0;
  border-radius: 8px;
  appearance: none;
  background: white;
  cursor: pointer;
}
.form-select-dokter:focus { outline: none; border-color: #667eea; }

.dropdown-icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
  pointer-events: none;
}

/* Buttons */
.btn-save {
  background: #1e88e5; color: white; padding: 6px 16px;
  border: none; border-radius: 4px; cursor: pointer; font-weight: 500;
}
.btn-save:hover { background: #1565c0; }

.btn-clear {
  background: #f44336; color: white; padding: 6px 14px;
  border: none; border-radius: 4px; cursor: pointer; font-size: 12px;
}
.btn-clear:hover { background: #d32f2f; }

.btn-back {
  background: #ff9800; color: white; padding: 10px 24px;
  border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;
}
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ccc; cursor: not-allowed; }

.btn-save-form {
  background: #0288d1; color: white; padding: 10px 24px;
  border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;
}
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }

.action-footer {
  margin-top: 30px; padding: 20px;
  display: flex; justify-content: flex-end; gap: 12px;
  background: #f5f5f5; border-top: 2px solid #ddd;
  position: sticky; bottom: 0;
}

.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.text-muted { color: #6c757d; }
.mx-auto { margin: 0 auto; }

.badge {
  display: inline-block; padding: 4px 12px;
  border-radius: 20px; font-size: 12px; font-weight: bold;
}
.badge.bg-warning { background: #ff9800; color: white; }

.view-overlay {
  position: absolute; top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(255,251,251,0.1);
  z-index: 10; cursor: not-allowed;
}
.form-wrapper { position: relative; }

@media (max-width: 768px) {
  .form-row-2 { flex-direction: column; }
  .signature-box-rme { width: 100% !important; }
}
</style>
