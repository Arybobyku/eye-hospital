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
        </div>

        <!-- HASIL PEMERIKSAAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Hasil Pemeriksaan</h5>

          <!-- Autorefkeratometry -->
          <div class="mb-3">
            <label class="label-section">Autorefkeratometry</label>
            <div class="form-row-2 mt-2">
              <div>
                <label>OD (Mata Kanan) :</label>
                <input type="text" v-model="form.autorefkeratometry_od" class="input-rme" placeholder="Contoh: -1.25 / -0.50 x 90" />
              </div>
              <div>
                <label>OS (Mata Kiri) :</label>
                <input type="text" v-model="form.autorefkeratometry_os" class="input-rme" placeholder="Contoh: -1.00 / -0.25 x 85" />
              </div>
            </div>
          </div>

          <!-- Visus -->
          <div class="mb-3">
            <label class="label-section">Visus</label>
            <div class="form-row-2 mt-2">
              <div>
                <label>OD (Mata Kanan) :</label>
                <input type="text" v-model="form.visus_od" class="input-rme" placeholder="Contoh: 6/6" />
              </div>
              <div>
                <label>OS (Mata Kiri) :</label>
                <input type="text" v-model="form.visus_os" class="input-rme" placeholder="Contoh: 6/6" />
              </div>
            </div>
          </div>

          <!-- Tonometry -->
          <div class="mb-3">
            <label class="label-section">Tonometry (MmHg)</label>
            <div class="form-row-2 mt-2">
              <div>
                <label>OD (Mata Kanan) :</label>
                <input type="text" v-model="form.tonometry_od" class="input-rme" placeholder="Contoh: 14" />
              </div>
              <div>
                <label>OS (Mata Kiri) :</label>
                <input type="text" v-model="form.tonometry_os" class="input-rme" placeholder="Contoh: 16" />
              </div>
            </div>
          </div>

          <!-- Diagnosa -->
          <div class="mb-3">
            <label>Diagnosa :</label>
            <textarea v-model="form.diagnosa" class="textarea-rme" rows="3" placeholder="Masukkan diagnosa..."></textarea>
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
            <label class="fw-bold d-block mb-2">Hormat saya,</label>

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

            <div class="dropdown-dokter mt-3">
              <select v-model="form.nama_dokter" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter</option>
                <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>

          <div class="form-row-2 mt-3">
            <div>
              <label>Email Dokter :</label>
              <input type="email" v-model="form.email_dokter" class="input-rme" placeholder="email@example.com" />
            </div>
            <div>
              <label>No. Handphone :</label>
              <input type="text" v-model="form.hp_dokter" class="input-rme" placeholder="08xxxxxxxxxx" />
            </div>
          </div>
        </div>

        <!-- ACTION FOOTER -->
        <div class="action-footer" v-if="!disabledSubmit">
          <button @click="submitForm" class="btn-submit" :disabled="loadingSubmit">
            {{ loadingSubmit ? "Menyimpan..." : isEditMode ? "Update" : "Simpan" }}
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { VueSignaturePad } from "vue-signature-pad";

export default {
  name: "FormSuratKeteranganMata",
  components: { VueSignaturePad },

  props: {
    selectedPatient: { type: Object, default: null },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    disabledSubmit:  { type: Boolean, default: false },
  },

  emits: ["back"],

  data() {
    return {
      loadingSubmit:   false,
      ttdDokterCleared: false,
      listDokter:      [],

      sigOption: {
        penColor: "#000",
        backgroundColor: "rgba(255,255,255,0)",
      },

      form: {
        uuid:         "",
        uuid_pasien:  "",
        no_rm:        "",
        nik:          "",
        nama:         "",
        no_surat:     "",

        autorefkeratometry_od: "",
        autorefkeratometry_os: "",
        visus_od:  "",
        visus_os:  "",
        tonometry_od: "",
        tonometry_os: "",
        diagnosa:  "",

        tanggal_surat: "",

        ttd_dokter:           "",
        nama_dokter:          "",
        email_dokter:         "",
        hp_dokter:            "",
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

    if (this.viewData && typeof this.viewData === "object") {
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
        this.listDokter = res.data?.data || [];
      } catch (e) {
        this.listDokter = [];
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 8.6/SKHPM/${tahun}`;
        }
      } catch {
        if (!this.form.no_surat) {
          this.form.no_surat = "RM 8.6/SKHPM/22";
        }
      }
    },

    setDataForm() {
      const today = new Date().toISOString().split("T")[0];
      this.form.tanggal_surat = today;
      this.form.uuid_pasien   = this.selectedPatient?.uuid         || "";
      this.form.no_rm         = this.selectedPatient?.rekam_medis  || "";
      this.form.nik           = this.selectedPatient?.no_identitas || "";
      this.form.nama          = this.selectedPatient?.nama         || "";
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

      this.$nextTick(() => {
        if (this.form.ttd_dokter) this.ttdDokterCleared = false;
      });
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
      this.ttdDokterCleared        = false;
      this.form.ttd_dokter         = data;
      this.form.ttd_dokter_timestamp = new Date().toISOString();
    },

    clearSign(refName) {
      this.ttdDokterCleared          = true;
      this.form.ttd_dokter           = "";
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
      if (!this.form.diagnosa?.trim()) {
        alert("Diagnosa harus diisi!"); return;
      }

      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          const val = this.form[key];
          fd.append(key, val === null || val === undefined ? "" : val);
        });

        const res = await axios.post(
          "/master/pasien/dokumen-surat-keterangan-mata",
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
        alert(`❌ ${err.response?.data?.message || "Gagal menyimpan data!"}`);
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
  gap: 16px;
  margin-bottom: 12px;
}

.form-row-2 > div {
  flex: 1;
  display: flex;
  flex-direction: column;
}

label {
  font-size: 13px;
  color: #555;
  margin-bottom: 4px;
}

.input-rme {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px 10px;
  font-size: 13px;
  width: 100%;
  box-sizing: border-box;
}

.textarea-rme {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px 10px;
  font-size: 13px;
  width: 100%;
  resize: vertical;
  box-sizing: border-box;
}

.sign-box {
  border: 1px dashed #ccc;
  border-radius: 6px;
  padding: 16px;
  background: #fafafa;
}

.signature-box-rme {
  border: 1px solid #999;
  border-radius: 4px;
  width: 440px;
  height: 160px;
  background: #fff;
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

.btn-save {
  background: #28a745;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 6px 18px;
  cursor: pointer;
  font-size: 13px;
}

.btn-clear {
  background: #dc3545;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 5px 14px;
  cursor: pointer;
  font-size: 12px;
}

.dropdown-dokter {
  position: relative;
  display: inline-block;
  width: 100%;
  max-width: 340px;
}

.form-select-dokter {
  width: 100%;
  padding: 7px 32px 7px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 13px;
  appearance: none;
  background: #fff;
}

.dropdown-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
  color: #555;
}

.action-footer {
  display: flex;
  justify-content: flex-end;
  padding: 16px 0;
}

.btn-submit {
  background: #2d74b7;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 32px;
  font-size: 15px;
  cursor: pointer;
  font-weight: bold;
}

.btn-submit:disabled {
  background: #90b8d8;
  cursor: not-allowed;
}

/* .btn-back {
  background: none;
  border: none;
  color: #2d74b7;
  font-size: 14px;
  cursor: pointer;
  padding: 8px 0 0 8px;
  text-decoration: underline;
} */

.btn-back {
  background: #ff9800; color: white; padding: 10px 24px;
  border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;
}

.view-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0.45);
  z-index: 10;
  border-radius: 6px;
}

.signature-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 12px; }
.mb-3 { margin-bottom: 12px; }
.mb-4 { margin-bottom: 16px; }
.fw-bold { font-weight: bold; }
.text-muted { color: #888; }
.text-center { text-align: center; }
.d-block { display: block; }
.badge { padding: 4px 10px; border-radius: 12px; font-size: 12px; }
.bg-warning { background: #ffc107; color: #333; }
</style>
