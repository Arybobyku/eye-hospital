<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="position-relative">
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">PEMBERIAN EDUKASI PASIEN TERINTEGRASI</h2>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        </div>

        <!-- INFORMASI PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="patient-grid">
            <div class="patient-item">
              <span class="patient-label">No. RM</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.no_rm || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">NIK</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.nik || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Nama Pasien</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.nama || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Tgl. Lahir</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.tanggal_lahir || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Jenis Kelamin</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.jenis_kelamin || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Tgl. Kunjungan</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">
                <input v-if="!disabledSubmit" type="date" v-model="form.tanggal_kunjungan" class="input-inline" />
                <span v-else>{{ form.tanggal_kunjungan || '-' }}</span>
              </span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Jam</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">
                <input v-if="!disabledSubmit" type="time" v-model="form.jam_kunjungan" class="input-inline" />
                <span v-else>{{ form.jam_kunjungan || '-' }} WIB</span>
              </span>
            </div>
          </div>
        </div>

        <!-- TABEL EDUKASI -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Data Edukasi</h5>

          <div class="table-responsive">
            <table class="edukasi-table">
              <thead>
                <tr>
                  <th rowspan="2" style="width:240px; min-width:220px;">Materi Edukasi</th>
                  <th colspan="2" style="min-width:90px;">Bukti Sudah Diberikan</th>
                  <th rowspan="2" style="min-width:100px;">Tanggal<br>Edukasi</th>
                  <th rowspan="2" style="min-width:110px;">Metode Edukasi<br><small style="font-weight:normal;">(D/Demo/C/S/O/PL)</small></th>
                  <th rowspan="2" style="min-width:130px;">Evaluasi</th>
                  <th rowspan="2" style="min-width:100px;">Tanggal<br>Re-Edukasi</th>
                  <th rowspan="2" style="min-width:150px;">Paraf / Nama Edukator</th>
                  <th rowspan="2" style="min-width:150px;">Paraf / Nama Pasien / Keluarga</th>
                </tr>
                <tr>
                  <th style="min-width:40px;">Ya</th>
                  <th style="min-width:45px;">Tidak</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(sec, index) in form.edukasi_sections" :key="index">

                  <!-- Materi Edukasi -->
                  <td class="td-materi">
                    <div class="kategori-title">{{ sec.kategori }}</div>

                    <!-- Extra fields Perawat -->
                    <template v-if="sec.kategori === 'Perawat'">
                      <div class="extra-field mt-1">
                        <small><b>•</b> a. Pendidikan kesehatan tentang:</small>
                        <input type="text" v-model="sec.extra.topik1" class="input-table mt-1" placeholder="Topik 1" :disabled="disabledSubmit" />
                        <input type="text" v-model="sec.extra.topik2" class="input-table mt-1" placeholder="Topik 2" :disabled="disabledSubmit" />
                      </div>
                    </template>
                    <ul class="sub-items">
                      <li v-for="item in sec.sub_items" :key="item">{{ item }}</li>
                    </ul>
                    <!-- Extra field Rehabilitasi Medik -->
                    <template v-if="sec.kategori === 'Rehabilitasi Medik'">
                      <div class="extra-field mt-1">
                        <input type="text" v-model="sec.extra.lainnya" class="input-table mt-1" placeholder="d. Lainnya..." :disabled="disabledSubmit" />
                      </div>
                    </template>
                  </td>

                  <!-- Bukti Ya -->
                  <td class="text-center">
                    <input type="radio" :name="`bukti_${index}`" value="ya" v-model="sec.bukti" :disabled="disabledSubmit" />
                  </td>

                  <!-- Bukti Tidak -->
                  <td class="text-center">
                    <input type="radio" :name="`bukti_${index}`" value="tidak" v-model="sec.bukti" :disabled="disabledSubmit" />
                  </td>

                  <!-- Tanggal Edukasi -->
                  <td>
                    <input type="date" v-model="sec.tanggal_edukasi" class="input-table" :disabled="disabledSubmit" />
                  </td>

                  <!-- Metode Edukasi -->
                  <td>
                    <select v-model="sec.metode_edukasi" class="input-table" :disabled="disabledSubmit">
                      <option value="">-</option>
                      <option value="D">Diskusi (D) </option>
                      <option value="Demo">Demo (Demonstrasi)</option>
                      <option value="C">Ceramah (C)</option>
                      <option value="S">Simulasi (S)</option>
                      <option value="O">Observasi (O) </option>
                      <option value="PL">Praktek Langsung (PL)</option>
                    </select>
                  </td>

                  <!-- Evaluasi -->
                  <td class="td-evaluasi">
                    <label v-for="opt in ['Sudah Mengerti', 'Re-Demonstrasi', 'Re-Edukasi']" :key="opt" class="eval-label">
                      <input type="radio" :name="`evaluasi_${index}`" :value="opt" v-model="sec.evaluasi" :disabled="disabledSubmit" />
                      {{ opt }}
                    </label>
                  </td>

                  <!-- Tanggal Re-Edukasi -->
                  <td>
                    <input type="date" v-model="sec.tanggal_re_edukasi" class="input-table" :disabled="disabledSubmit" />
                  </td>

                  <!-- Paraf/Nama Edukator -->
                  <td>
                    <div class="signature-cell">
                      <div v-if="sec.ttd_edukator && !ttdEdukatorCleared[index]">
                        <img :src="sec.ttd_edukator" class="ttd-preview" />
                        <p v-if="sec.ttd_edukator_timestamp" class="ttd-timestamp">{{ sec.ttd_edukator_timestamp }}</p>
                        <button @click="clearSign(index, 'ttd_edukator')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">Hapus</button>
                      </div>
                      <div v-else>
                        <VueSignaturePad :ref="`ttd_edukator_${index}`" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign(`ttd_edukator_${index}`, index, 'ttd_edukator')" class="btn-save-mini" v-if="!disabledSubmit" type="button">Simpan ✔</button>
                      </div>
                    </div>
                    <input type="text" v-model="sec.nama_edukator" class="input-table mt-1" placeholder="Nama Edukator" :disabled="disabledSubmit" />
                  </td>

                  <!-- Paraf/Nama Pasien/Keluarga -->
                  <td>
                    <div class="signature-cell">
                      <div v-if="sec.ttd_pasien && !ttdPasienCleared[index]">
                        <img :src="sec.ttd_pasien" class="ttd-preview" />
                        <p v-if="sec.ttd_pasien_timestamp" class="ttd-timestamp">{{ sec.ttd_pasien_timestamp }}</p>
                        <button @click="clearSign(index, 'ttd_pasien')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">Hapus</button>
                      </div>
                      <div v-else>
                        <VueSignaturePad :ref="`ttd_pasien_${index}`" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign(`ttd_pasien_${index}`, index, 'ttd_pasien')" class="btn-save-mini" v-if="!disabledSubmit" type="button">Simpan ✔</button>
                      </div>
                    </div>
                    <input type="text" v-model="sec.nama_pasien_keluarga" class="input-table mt-1" placeholder="Nama Pasien / Keluarga" :disabled="disabledSubmit" />
                  </td>

                </tr>
              </tbody>
            </table>
          </div>

          <!-- Kode Legend -->
          <div class="kode-legend mt-3">
            <strong>Kode :</strong>
            <span>Diskusi (D) </span>
            <span>Demo = Demonstrasi</span>
            <span>Ceramah (C)</span>
            <span>simulasi (S)</span>
            <span>Observasi (O)</span>
            <span>Praktek Langsung (PL) </span>
          </div>
        </div>
      </div>
    </div>

    <!-- BUTTON BOTTOM -->
    <div class="action-footer">
      <button v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>{{ editUuid ? 'Update' : 'Simpan' }}</span>
      </button>
      <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Kembali</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormPemberianEdukasiPasienTerintegrasi",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit:       false,
      disabledSubmit:      false,
      editUuid:            "",
      ttdEdukatorCleared:  [false, false, false, false, false],
      ttdPasienCleared:    [false, false, false, false, false],
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid:               "",
        uuid_pasien:        "",
        no_rm:              "",
        no_surat:           "",
        nik:                "",
        nama:               "",
        tanggal_lahir:      "",
        jenis_kelamin:      "",
        tanggal_kunjungan:  "",
        jam_kunjungan:      "",
        edukasi_sections:   [],
      },
    };
  },

  async mounted() {
    await this.fetchTahunAkreditasi();

    if (this.viewData) {
      this.disabledSubmit = true;
      this.editUuid = this.editData?.uuid || "";
      this.loadDataForEdit();
    } else if (this.editData) {
      this.disabledSubmit = false;
      this.editUuid = this.editData.uuid;
      this.loadDataForEdit();
    } else {
      this.disabledSubmit = false;
      this.setDataForm();
    }
  },

  methods: {
    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) this.form.no_surat = `RM 6.6/PEPT/${tahun}`;
      } catch {
        if (!this.form.no_surat) this.form.no_surat = "RM 6.6/PEPT/22";
      }
    },

    buildDefaultSections() {
      const base = () => ({
        bukti: "",
        tanggal_edukasi: "",
        metode_edukasi: "",
        evaluasi: "",
        tanggal_re_edukasi: "",
        ttd_edukator: "", nama_edukator: "", ttd_edukator_timestamp: "",
        ttd_pasien: "", nama_pasien_keluarga: "", ttd_pasien_timestamp: "",
      });
      return [
        {
          kategori: "Dokter Spesialis / Dokter Umum",
          sub_items: [
            "a. Penjelasan penyakit, penyebab, tanda & gejala, prognosa",
            "b. Hasil pemeriksaan",
            "c. Tindakan medis",
            "d. Perkiraan hari rawat",
            "e. Penjelasan komplikasi yang mungkin terjadi",
          ],
          extra: {},
          ...base(),
        },
        {
          kategori: "Farmasi",
          sub_items: [
            "a. Nama Obat dan kegunaan",
            "b. Aturan pemakaian dan dosis obat",
            "c. Jumlah yang diberikan",
            "d. Cara penyimpanan obat",
            "e. Efek samping obat",
            "f. Kontraindikasi obat",
          ],
          extra: {},
          ...base(),
        },
        {
          kategori: "Perawat",
          sub_items: [
            "b. Penanganan & cara perawatan di rumah",
            "c. Perawatan luka",
            "d. Cara penggunaan bell untuk memanggil perawat",
            "e. Alat-alat yang perlu dipersiapkan di rumah",
            "f. Keamanan penggunaan alat-alat kesehatan",
            "g. Keamanan lingkungan bermain",
            "h. Memanggil perawat setiap memerlukan bantuan",
            "i. Keamanan lingkungan perawatan di rumah",
          ],
          extra: { topik1: "", topik2: "" },
          ...base(),
        },
        {
          kategori: "Manajemen Nyeri",
          sub_items: [
            "a. Farmakologi",
            "b. Non Farmakologi",
          ],
          extra: {},
          ...base(),
        },
        {
          kategori: "Rehabilitasi Medik",
          sub_items: [
            "a. Dokter Sp. KFR",
            "b. Psikolog",
            "c. Okupasi terapi",
          ],
          extra: { lainnya: "" },
          ...base(),
        },
      ];
    },

    setDataForm() {
      const now   = new Date();
      const today = now.toISOString().split("T")[0];
      const time  = now.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien   = this.selectedPatient.uuid;
        this.form.no_rm         = this.selectedPatient.rekam_medis;
        this.form.nik           = this.selectedPatient.no_ktp || this.selectedPatient.no_identitas || "";
        this.form.nama          = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
      }

      this.form.tanggal_kunjungan = today;
      this.form.jam_kunjungan     = time;
      this.form.edukasi_sections  = this.buildDefaultSections();
      this.ttdEdukatorCleared     = [false, false, false, false, false];
      this.ttdPasienCleared       = [false, false, false, false, false];
    },

    async loadDataForEdit() {
      try {
        if (!this.editUuid) { this.setDataForm(); return; }

        const res = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=pemberian_edukasi_pasien_terintegrasi`
        );

        if (res.data) {
          const data = res.data.data;
          const defaults = this.buildDefaultSections();

          Object.keys(this.form).forEach((key) => {
            if (key === "edukasi_sections" && data.edukasi_sections) {
              const stored = typeof data.edukasi_sections === "string"
                ? JSON.parse(data.edukasi_sections)
                : data.edukasi_sections;
              // Merge with defaults to ensure all fields exist
              this.form.edukasi_sections = defaults.map((def, i) => ({
                ...def,
                ...(stored[i] || {}),
                extra: { ...def.extra, ...(stored[i]?.extra || {}) },
              }));
            } else if (data[key] !== undefined && key !== "edukasi_sections") {
              this.form[key] = data[key] !== null ? data[key] : "";
            }
          });

          this.$nextTick(() => {
            this.ttdEdukatorCleared = this.form.edukasi_sections.map((s) => !s.ttd_edukator);
            this.ttdPasienCleared   = this.form.edukasi_sections.map((s) => !s.ttd_pasien);
          });
        }
      } catch (err) {
        console.error("Error loading data:", err);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    saveSign(refName, index, field) {
      const pad = this.$refs[refName];
      const sp  = Array.isArray(pad) ? pad[0] : pad;
      if (!sp) { console.error("REF tidak ditemukan:", refName); return; }

      const { isEmpty, data } = sp.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

      this.form.edukasi_sections[index][field] = data;
      const ts = new Date().toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });

      if (field === "ttd_edukator") {
        this.ttdEdukatorCleared[index] = false;
        this.form.edukasi_sections[index].ttd_edukator_timestamp = ts;
      } else if (field === "ttd_pasien") {
        this.ttdPasienCleared[index] = false;
        this.form.edukasi_sections[index].ttd_pasien_timestamp = ts;
      }
    },

    clearSign(index, field) {
      if (field === "ttd_edukator") {
        this.ttdEdukatorCleared[index] = true;
        this.form.edukasi_sections[index].ttd_edukator = "";
        this.form.edukasi_sections[index].ttd_edukator_timestamp = "";
      } else if (field === "ttd_pasien") {
        this.ttdPasienCleared[index] = true;
        this.form.edukasi_sections[index].ttd_pasien = "";
        this.form.edukasi_sections[index].ttd_pasien_timestamp = "";
      }

      this.$nextTick(() => {
        this.$nextTick(() => {
          const pad = this.$refs[`${field}_${index}`];
          const sp  = Array.isArray(pad) ? pad[0] : pad;
          if (sp) sp.clearSignature();
        });
      });
    },

    async submitForm() {
      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) return;
          if (key === "edukasi_sections") {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const res = await axios.post(
          "/master/pasien/dokumen-pemberian-edukasi-pasien-terintegrasi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          alert(res.data.message);
          this.$emit("back");
        }
      } catch (err) {
        console.error("ERROR:", err.response?.data || err);
        alert("Gagal menyimpan data edukasi!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1700px; margin: 0 auto; }
.position-relative { position: relative; }
.py-4 { padding: 24px 0; }

/* === PATIENT INFO === */
.patient-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px 20px;
}
.patient-item {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 4px 0;
  border-bottom: 1px dashed #eee;
}
.patient-label { font-weight: 600; font-size: 13px; color: #555; min-width: 120px; flex-shrink: 0; }
.patient-sep   { color: #888; flex-shrink: 0; }
.patient-val   { font-size: 13px; color: #222; }
.input-inline  { border: 1px solid #ccc; border-radius: 3px; padding: 3px 6px; font-size: 12px; }

/* === BOX & SECTION === */
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

/* === TABLE === */
.table-responsive { overflow-x: auto; }
.edukasi-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.edukasi-table th {
  background: #2d74b7; color: white;
  padding: 8px 6px; border: 1px solid #1a5fa3;
  font-weight: 600; text-align: center; vertical-align: middle;
}
.edukasi-table td { border: 1px solid #ddd; padding: 6px 8px; vertical-align: top; }

.td-materi { vertical-align: top; }
.kategori-title { font-weight: bold; color: #1a5fa3; margin-bottom: 4px; font-size: 12px; }
.sub-items { margin: 4px 0 0 14px; padding: 0; font-size: 11px; color: #333; }
.sub-items li { margin-bottom: 2px; }
.extra-field { font-size: 11px; }

.td-evaluasi { vertical-align: top; }
.eval-label {
  display: flex; align-items: center; gap: 5px;
  font-size: 11px; color: #333;
  margin-bottom: 4px; cursor: pointer;
  white-space: nowrap;
}

.input-table {
  width: 100%; border: 1px solid #ccc; border-radius: 3px;
  padding: 4px 5px; font-size: 11px; box-sizing: border-box;
}
.input-table:focus { outline: none; border-color: #2d74b7; }
.input-table:disabled { background: #f5f5f5; }

/* === SIGNATURE === */
.signature-cell { display: flex; flex-direction: column; align-items: center; gap: 3px; }
.signature-box-table { width: 130px; height: 70px; border: 2px solid #999; border-radius: 4px; background: white; }
.ttd-preview { width: 130px; height: 70px; object-fit: contain; border: 1px dashed #ccc; display: block; }
.ttd-timestamp { font-size: 9px; color: #2d74b7; background: #e9f5ff; padding: 1px 5px; border-radius: 3px; margin: 1px 0; }

/* === BUTTONS === */
.btn-save-mini  { background: #1e88e5; color: white; padding: 2px 8px; border: none; border-radius: 3px; cursor: pointer; font-size: 10px; width: 100%; }
.btn-clear-mini { background: #f44336; color: white; padding: 2px 8px; border: none; border-radius: 3px; cursor: pointer; font-size: 10px; width: 100%; }

/* === KODE LEGEND === */
.kode-legend {
  display: flex; flex-wrap: wrap; gap: 8px 20px;
  font-size: 12px; color: #444;
  background: #f0f8ff; border-left: 4px solid #2d74b7;
  padding: 8px 12px; border-radius: 4px;
}
.kode-legend strong { margin-right: 8px; }

/* === FOOTER === */
.action-footer {
  margin-top: 30px; padding: 20px; display: flex;
  justify-content: flex-end; gap: 12px;
  background: #f5f5f5; border-top: 2px solid #ddd;
  position: sticky; bottom: 0;
}
.btn-save-form { background: #0288d1; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }
.btn-back { background: #ff9800; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:disabled { background: #ccc; cursor: not-allowed; }

.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.1); z-index: 10; cursor: not-allowed; }

.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mb-4 { margin-bottom: 24px; }
.mt-1 { margin-top: 4px; }
.mt-3 { margin-top: 16px; }

@media (max-width: 768px) {
  .patient-grid { grid-template-columns: 1fr; }
}
</style>
