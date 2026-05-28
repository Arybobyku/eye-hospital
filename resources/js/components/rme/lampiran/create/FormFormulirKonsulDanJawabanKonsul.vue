<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">FORMULIR KONSUL DAN JAWABAN KONSUL</h2>
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
              <label>Tgl. Lahir :</label>
              <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
            </div>
            <div>
              <label>Jenis Kelamin :</label>
              <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>NIK :</label>
              <input type="text" v-model="form.nik" class="input-rme" readonly />
            </div>
          </div>
        </div>

        <!-- ===== FORMULIR KONSUL ===== -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Formulir Konsul</h5>

          <div class="mb-3">
            <label>Dokter Tujuan Konsul :</label>
            <div class="dropdown-dokter" style="max-width: 100%;">
              <select v-model="form.dokter_tujuan_konsul" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter Tujuan Konsul</option>
                <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>

          <div class="mb-3">
            <label>Jenis Konsul :</label>
            <div class="radio-group">
              <label class="radio-option">
                <input type="radio" v-model="form.jenis_konsul" value="1" /> Konsul Saja
              </label>
              <label class="radio-option">
                <input type="radio" v-model="form.jenis_konsul" value="2" /> Pengobatan bersama selanjutnya
              </label>
              <label class="radio-option">
                <input type="radio" v-model="form.jenis_konsul" value="3" /> Ambil Alih
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label>Diagnosa :</label>
            <textarea v-model="form.diagnosa" class="textarea-rme" rows="2" placeholder="Masukkan diagnosa..."></textarea>
          </div>

          <div class="mb-3">
            <label>Dengan Persangkaan kami menderita :</label>
            <textarea v-model="form.persangkaan_diagnosis" class="textarea-rme" rows="2" placeholder="Masukkan persangkaan diagnosis..."></textarea>
          </div>

          <div class="mb-3">
            <label>Pada pasien kami dapati hal-hal sebagai berikut :</label>
            <textarea v-model="form.temuan_klinis" class="textarea-rme" rows="3" placeholder="Masukkan temuan klinis..."></textarea>
          </div>

          <div class="mb-3">
            <label>Pengobatan / Tindakan Pembedahan yang telah kami berikan :</label>
            <textarea v-model="form.pengobatan_tindakan_sebelumnya" class="textarea-rme" rows="3" placeholder="Masukkan pengobatan / tindakan yang telah diberikan..."></textarea>
          </div>

          <div class="form-row-2">
            <div>
              <label>Tanggal Konsul :</label>
              <input type="date" v-model="form.tanggal_konsul" class="input-rme" />
            </div>
            <div>
              <label>Jam Konsul :</label>
              <input type="time" v-model="form.jam_konsul" class="input-rme" />
            </div>
          </div>

          <!-- TTD Dokter Pengirim -->
          <div class="box-rme" style="margin-top: 20px;">
            <h5 class="section-title-rme">Tanda Tangan Dokter Pengirim</h5>
            <div class="sign-box text-center">
              <label class="fw-bold d-block mb-2">Salam Sejawat,</label>

              <div v-if="form.ttd_dokter_pengirim && !ttdDokterPengirimCleared" class="signature-preview">
                <img :src="form.ttd_dokter_pengirim" alt="TTD Dokter Pengirim" class="img-signature" />
                <p v-if="form.ttd_dokter_pengirim_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_dokter_pengirim_timestamp }}
                </p>
                <button @click="clearSign('ttd_dokter_pengirim')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
              </div>
              <div v-else>
                <VueSignaturePad ref="ttd_dokter_pengirim" :options="sigOption" class="signature-box-rme mx-auto" />
                <button @click="saveSign('ttd_dokter_pengirim')" class="btn-save mt-2">Simpan ✔</button>
              </div>

              <div class="dropdown-dokter mt-2">
                <select v-model="form.nama_dokter_pengirim" class="form-select-dokter">
                  <option value="" disabled>🩺 Pilih Dokter Pengirim</option>
                  <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                    {{ dokter.nama }}
                  </option>
                </select>
                <span class="dropdown-icon">▾</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== FORMULIR JAWABAN KONSUL ===== -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Formulir Jawaban Konsul</h5>

          <div class="mb-3">
            <label>Dokter Tujuan Jawaban :</label>
            <div class="dropdown-dokter" style="max-width: 100%;">
              <select v-model="form.dokter_tujuan_jawaban" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter Tujuan Jawaban</option>
                <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>

          <div class="mb-3">
            <label>Sehubungan permintaan konsul TS, tanggal :</label>
            <input type="date" v-model="form.tanggal_permintaan_konsul_ref" class="input-rme" />
          </div>

          <div class="mb-3">
            <label>Kami sampaikan sebagai berikut :</label>
            <textarea v-model="form.hasil_konsul" class="textarea-rme" rows="3" placeholder="Masukkan hasil konsul..."></textarea>
          </div>

          <div class="mb-3">
            <label>Berdasarkan hal-hal tersebut, kami anjurkan dilakukan pemeriksaan / tindakan pembedahan :</label>
            <textarea v-model="form.anjuran_pemeriksaan_tindakan" class="textarea-rme" rows="3" placeholder="Masukkan anjuran pemeriksaan / tindakan..."></textarea>
          </div>

          <div class="form-row-2">
            <div>
              <label>Juga kami anjurkan konsultasi TS :</label>
              <div class="dropdown-dokter" style="max-width: 100%;">
                <select v-model="form.anjuran_konsul_lanjut_dokter" class="form-select-dokter">
                  <option value="" disabled>🩺 Pilih Dokter</option>
                  <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                    {{ dokter.nama }}
                  </option>
                </select>
                <span class="dropdown-icon">▾</span>
              </div>
            </div>
            <div>
              <label>Bagian :</label>
              <input type="text" v-model="form.anjuran_konsul_lanjut_bagian" class="input-rme" placeholder="Nama bagian / spesialisasi..." />
            </div>
          </div>

          <div class="mb-3">
            <label>Therapy / Tindakan yang kami anjurkan :</label>
            <textarea v-model="form.terapi_anjuran" class="textarea-rme" rows="3" placeholder="Masukkan terapi / tindakan yang dianjurkan..."></textarea>
          </div>

          <div class="form-row-2">
            <div>
              <label>Tanggal Jawaban :</label>
              <input type="date" v-model="form.tanggal_jawaban" class="input-rme" />
            </div>
            <div>
              <label>Jam Jawaban :</label>
              <input type="time" v-model="form.jam_jawaban" class="input-rme" />
            </div>
          </div>

          <!-- TTD Dokter Konsultan -->
          <div class="box-rme" style="margin-top: 20px;">
            <h5 class="section-title-rme">Tanda Tangan Dokter Konsultan</h5>
            <div class="sign-box text-center">
              <label class="fw-bold d-block mb-2">Salam Sejawat,</label>

              <div v-if="form.ttd_dokter_konsultan && !ttdDokterKonsultanCleared" class="signature-preview">
                <img :src="form.ttd_dokter_konsultan" alt="TTD Dokter Konsultan" class="img-signature" />
                <p v-if="form.ttd_dokter_konsultan_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_dokter_konsultan_timestamp }}
                </p>
                <button @click="clearSign('ttd_dokter_konsultan')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
              </div>
              <div v-else>
                <VueSignaturePad ref="ttd_dokter_konsultan" :options="sigOption" class="signature-box-rme mx-auto" />
                <button @click="saveSign('ttd_dokter_konsultan')" class="btn-save mt-2">Simpan ✔</button>
              </div>

              <div class="dropdown-dokter mt-2">
                <select v-model="form.nama_dokter_konsultan" class="form-select-dokter">
                  <option value="" disabled>🩺 Pilih Dokter Konsultan</option>
                  <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                    {{ dokter.nama }}
                  </option>
                </select>
                <span class="dropdown-icon">▾</span>
              </div>
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
  name: "FormFormulirKonsulDanJawabanKonsul",

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
      ttdDokterPengirimCleared: false,
      ttdDokterKonsultanCleared: false,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid:                            "",
        uuid_pasien:                     "",

        // Identitas
        no_surat:                        "",
        no_rm:                           "",
        nik:                             "",
        nama:                            "",
        tanggal_lahir:                   "",
        jenis_kelamin:                   "",

        // Formulir Konsul
        dokter_tujuan_konsul:            "",
        jenis_konsul:                    "",
        diagnosa:                        "",
        persangkaan_diagnosis:           "",
        temuan_klinis:                   "",
        pengobatan_tindakan_sebelumnya:  "",
        tanggal_konsul:                  "",
        jam_konsul:                      "",
        ttd_dokter_pengirim:             "",
        nama_dokter_pengirim:            "",
        ttd_dokter_pengirim_timestamp:   "",

        // Formulir Jawaban Konsul
        dokter_tujuan_jawaban:           "",
        tanggal_permintaan_konsul_ref:   "",
        hasil_konsul:                    "",
        anjuran_pemeriksaan_tindakan:    "",
        anjuran_konsul_lanjut_dokter:    "",
        anjuran_konsul_lanjut_bagian:    "",
        terapi_anjuran:                  "",
        tanggal_jawaban:                 "",
        jam_jawaban:                     "",
        ttd_dokter_konsultan:            "",
        nama_dokter_konsultan:           "",
        ttd_dokter_konsultan_timestamp:  "",
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
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 10.2/FKDJK/${tahun}`;
        }
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 10.2/FKDJK/22';
        }
      }
    },

    setDataForm() {
      const today = new Date().toISOString().split("T")[0];
      this.form.tanggal_konsul  = today;
      this.form.tanggal_jawaban = today;
      this.form.uuid_pasien     = this.selectedPatient?.uuid          || "";
      this.form.no_rm           = this.selectedPatient?.rekam_medis   || "";
      this.form.nik             = this.selectedPatient?.no_identitas  || "";
      this.form.nama            = this.selectedPatient?.nama          || "";
      this.form.tanggal_lahir   = this.selectedPatient?.tanggal_lahir || "";
      this.form.jenis_kelamin   = this.selectedPatient?.jenis_kelamin || "";
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
        if (this.form.ttd_dokter_pengirim)  this.ttdDokterPengirimCleared  = false;
        if (this.form.ttd_dokter_konsultan) this.ttdDokterKonsultanCleared = false;
      });
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) return;

      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

      const flagMap = {
        ttd_dokter_pengirim:  "ttdDokterPengirimCleared",
        ttd_dokter_konsultan: "ttdDokterKonsultanCleared",
      };
      const timestampMap = {
        ttd_dokter_pengirim:  "ttd_dokter_pengirim_timestamp",
        ttd_dokter_konsultan: "ttd_dokter_konsultan_timestamp",
      };

      this[flagMap[refName]] = false;
      this.form[refName]     = data;

      if (timestampMap[refName]) {
        this.form[timestampMap[refName]] = new Date().toLocaleString("id-ID", {
          day: "2-digit", month: "2-digit", year: "numeric",
          hour: "2-digit", minute: "2-digit", second: "2-digit",
        });
      }
    },

    clearSign(refName) {
      const flagMap = {
        ttd_dokter_pengirim:  "ttdDokterPengirimCleared",
        ttd_dokter_konsultan: "ttdDokterKonsultanCleared",
      };
      const timestampMap = {
        ttd_dokter_pengirim:  "ttd_dokter_pengirim_timestamp",
        ttd_dokter_konsultan: "ttd_dokter_konsultan_timestamp",
      };

      this[flagMap[refName]] = true;
      this.form[refName]     = "";
      if (timestampMap[refName]) this.form[timestampMap[refName]] = "";

      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    async submitForm() {
      if (!this.form.dokter_tujuan_konsul?.trim()) {
        alert("Dokter tujuan konsul harus diisi!"); return;
      }
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
          "/master/pasien/dokumen-formulir-konsul-dan-jawaban-konsul",
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

.radio-group {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  padding: 8px 0;
}

.radio-option {
  display: flex;
  align-items: center;
  gap: 6px;
  font-weight: normal;
  cursor: pointer;
  margin-bottom: 0;
}

.radio-option input[type="radio"] {
  cursor: pointer;
  width: 16px;
  height: 16px;
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
  .radio-group { flex-direction: column; gap: 8px; }
  .signature-box-rme { width: 100% !important; }
}
</style>
