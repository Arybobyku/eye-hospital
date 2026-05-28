<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="position-relative">
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">CATATAN PERKEMBANGAN TERINTEGRITASI</h2>
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
              <span class="patient-label">Tanggal Lahir</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.tanggal_lahir || '-' }}</span>
            </div>
            <div class="patient-item">
              <span class="patient-label">Jenis Kelamin</span>
              <span class="patient-sep">:</span>
              <span class="patient-val">{{ form.jenis_kelamin || '-' }}</span>
            </div>
          </div>
        </div>

        <!-- TABEL CPPT -->
        <div class="box-rme mb-4">
          <div class="table-header-row">
            <h5 class="section-title-rme mb-0">Catatan Perkembangan</h5>
            <button @click="addRow" class="btn-add-row" v-if="!disabledSubmit">
              <i class="fas fa-plus"></i> Tambah Catatan
            </button>
          </div>
          <div>
            <p class="subtitle-desc" style="padding-bottom: 10px;">
              Ditulis Berdasarkan prinsip S (Subjective / Anamnesis),  O (Objective / Hasil pemeriksaan), A (Analisa)  dan P (Planning /Rencana, tatalaksana/ Instruksi dengan Target terukur) dan ADIME dari masing-masing masalah (Assesmen, Diagnosis, Intervensi,. Monitoring dan Evaluasi). 
            </p>
          </div>

          <div class="table-responsive">
            <table class="cppt-table">
              <thead>
                <tr>
                  <th rowspan="2" style="width:110px;">Tanggal / Jam</th>
                  <th colspan="2">
                    Hasil Pemeriksaan, Analisis, Rencana Penatalaksanaan Pasien<br>
                    <small style="font-weight:normal;">(Bubuhkan Stempel, Nama, dan Paraf pada Setiap Akhir Catatan)</small>
                  </th>
                  <th rowspan="2" style="width:180px;">Verifikasi<br><small style="font-weight:normal;">(Stempel/Nama/Paraf)</small></th>
                  <th rowspan="2" style="width:60px;" v-if="!disabledSubmit">Aksi</th>
                </tr>
                <tr>
                  <th style="width:300px;">Dokter</th>
                  <th style="width:300px;">Profesi Lain / Case Manager</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in form.cppt_rows" :key="index">

                  <!-- Tanggal / Jam -->
                  <td class="text-center">
                    <input type="date" v-model="row.tanggal" class="input-table mb-1" />
                    <input type="time" v-model="row.jam" class="input-table" />
                  </td>

                  <!-- Kolom Dokter -->
                  <td>
                    <textarea
                      v-model="row.isian_dokter"
                      class="textarea-table"
                      rows="5"
                      placeholder="S: Subjektif&#10;O: Objektif&#10;A: Assessment&#10;P: Planning"
                    ></textarea>
                    <div class="dropdown-dokter mt-1">
                      <select v-model="row.nama_dokter" class="form-select-dokter">
                        <option value="" disabled>🩺 Pilih Dokter</option>
                        <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                          {{ dokter.nama }}
                        </option>
                      </select>
                      <span class="dropdown-icon">▾</span>
                    </div>
                    <div class="signature-cell mt-1">
                      <div v-if="row.ttd_dokter && !ttdDokterCleared[index]">
                        <img :src="row.ttd_dokter" class="ttd-preview" />
                        <p v-if="row.ttd_dokter_timestamp" class="ttd-timestamp">{{ row.ttd_dokter_timestamp }}</p>
                        <button @click="clearSign(index, 'ttd_dokter')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">Hapus</button>
                      </div>
                      <div v-else>
                        <VueSignaturePad :ref="`ttd_dokter_${index}`" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign(`ttd_dokter_${index}`, index, 'ttd_dokter')" class="btn-save-mini" v-if="!disabledSubmit" type="button">Simpan ✔</button>
                      </div>
                    </div>
                  </td>

                  <!-- Kolom Profesi Lain / Case Manager -->
                  <td>
                    <select v-model="row.profesi_jabatan" class="input-table mb-1">
                      <option value="">-- Profesi --</option>
                      <option value="Perawat">Perawat</option>
                      <option value="Bidan">Bidan</option>
                      <option value="Fisioterapi">Fisioterapi</option>
                      <option value="Gizi / Dietisien">Gizi / Dietisien</option>
                      <option value="Farmasi">Farmasi</option>
                      <option value="Radiologi">Radiologi</option>
                      <option value="Laboratorium">Laboratorium</option>
                      <option value="Case Manager">Case Manager</option>
                      <option value="Psikologi">Psikologi</option>
                    </select>
                    <textarea
                      v-model="row.isian_profesi_lain"
                      class="textarea-table"
                      rows="4"
                      placeholder="Catatan profesi lain / case manager..."
                    ></textarea>
                    <input
                      type="text"
                      v-model="row.nama_profesi_lain"
                      class="input-table mt-1"
                      placeholder="Nama Profesi Lain / Case Manager"
                    />
                    <div class="signature-cell mt-1">
                      <div v-if="row.ttd_profesi_lain && !ttdProfesiCleared[index]">
                        <img :src="row.ttd_profesi_lain" class="ttd-preview" />
                        <p v-if="row.ttd_profesi_lain_timestamp" class="ttd-timestamp">{{ row.ttd_profesi_lain_timestamp }}</p>
                        <button @click="clearSign(index, 'ttd_profesi_lain')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">Hapus</button>
                      </div>
                      <div v-else>
                        <VueSignaturePad :ref="`ttd_profesi_lain_${index}`" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign(`ttd_profesi_lain_${index}`, index, 'ttd_profesi_lain')" class="btn-save-mini" v-if="!disabledSubmit" type="button">Simpan ✔</button>
                      </div>
                    </div>
                  </td>

                  <!-- Kolom Verifikasi -->
                  <td class="text-center">
                    <div class="signature-cell">
                      <div v-if="row.ttd_verifikasi && !ttdVerifikasiCleared[index]">
                        <div class="ttd-canvas-wrapper">
                          <img :src="row.ttd_verifikasi" class="ttd-preview" />
                          <transition name="fade-stamp">
                            <img
                              v-if="row.stempel_verifikasi"
                              src="/storage/images/logo_antrian.png"
                              class="stamp-overlay"
                              alt="Stempel RS"
                            />
                          </transition>
                        </div>
                        <p v-if="row.ttd_verifikasi_timestamp" class="ttd-timestamp">{{ row.ttd_verifikasi_timestamp }}</p>
                        <button @click="clearSign(index, 'ttd_verifikasi')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">Hapus</button>
                      </div>
                      <div v-else>
                        <div class="ttd-canvas-wrapper">
                          <VueSignaturePad :ref="`ttd_verifikasi_${index}`" :options="sigOption" class="signature-box-table" />
                          <transition name="fade-stamp">
                            <img
                              v-if="row.stempel_verifikasi"
                              src="/storage/images/logo_antrian.png"
                              class="stamp-overlay"
                              alt="Stempel RS"
                            />
                          </transition>
                        </div>
                        <button @click="saveSign(`ttd_verifikasi_${index}`, index, 'ttd_verifikasi')" class="btn-save-mini" v-if="!disabledSubmit" type="button">Simpan ✔</button>
                      </div>
                      <button
                        v-if="!disabledSubmit"
                        @click="row.stempel_verifikasi = !row.stempel_verifikasi"
                        class="btn-stamp-mini mt-1"
                        type="button"
                      >
                        {{ row.stempel_verifikasi ? '🔴 Hapus Stempel' : '🔵 Tambah Stempel' }}
                      </button>
                    </div>
                    <input
                      type="text"
                      v-model="row.nama_verifikasi"
                      class="input-table mt-1"
                      placeholder="Nama Verifikator"
                    />
                  </td>

                  <!-- Aksi -->
                  <td class="text-center" v-if="!disabledSubmit">
                    <button
                      @click="deleteRow(index)"
                      class="btn-delete-row"
                      :disabled="form.cppt_rows.length === 1"
                      title="Hapus Baris"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>

                <tr v-if="form.cppt_rows.length === 0">
                  <td :colspan="disabledSubmit ? 4 : 5" class="text-center text-muted">
                    Belum ada catatan. Klik "Tambah Catatan" untuk menambah data.
                  </td>
                </tr>
              </tbody>
            </table>
            <p><i>(Diisi dalam waktu 24 jam pertama pasien masuk rawat inap/jalan) </i></p>

          </div>
          <div style="text-align: center;">
            <p><i>Terimakasih atas kerjasamanya telah mengisi formulir ini dengan benar dan jelas </i></p>
          </div>

          <div class="summary-info mt-3">
            <strong>Total Catatan:</strong> {{ form.cppt_rows.length }} entri
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
  name: "FormCatatanPerkembanganTerintegrasi",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit:        false,
      disabledSubmit:       false,
      editUuid:             "",
      listDokter:           [],
      ttdDokterCleared:     [],
      ttdProfesiCleared:    [],
      ttdVerifikasiCleared: [],
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid:          "",
        uuid_pasien:   "",
        no_rm:         "",
        no_surat:      "",
        nik:           "",
        nama:          "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        cppt_rows: [
          {
            tanggal: "", jam: "",
            isian_dokter: "", nama_dokter: "",
            ttd_dokter: "", ttd_dokter_timestamp: "",
            profesi_jabatan: "", isian_profesi_lain: "", nama_profesi_lain: "",
            ttd_profesi_lain: "", ttd_profesi_lain_timestamp: "",
            nama_verifikasi: "", ttd_verifikasi: "", ttd_verifikasi_timestamp: "",
            stempel_verifikasi: false,
          },
        ],
      },
    };
  },
  async mounted() {
    await this.fetchDokter();
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
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) this.form.no_surat = `RM 6.7/CPT/${tahun}`;
      } catch {
        if (!this.form.no_surat) this.form.no_surat = "RM 6.7/CPT/22";
      }
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

      this.form.cppt_rows[0].tanggal = today;
      this.form.cppt_rows[0].jam     = time;
      this.ttdDokterCleared     = [false];
      this.ttdProfesiCleared    = [false];
      this.ttdVerifikasiCleared = [false];
    },

    async loadDataForEdit() {
      try {
        if (!this.editUuid) { this.setDataForm(); return; }

        const res = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=catatan_perkembangan_terintegrasi`
        );

        if (res.data) {
          const data = res.data.data;

          Object.keys(this.form).forEach((key) => {
            if (key === "cppt_rows" && data.cppt_rows) {
              const rows = typeof data.cppt_rows === "string"
                ? JSON.parse(data.cppt_rows)
                : data.cppt_rows;
              // Ensure stempel_verifikasi exists on every row (backwards compat)
              this.form.cppt_rows = rows.map((r) => ({
                stempel_verifikasi: false,
                ...r,
              }));
            } else if (data[key] !== undefined && key !== "cppt_rows") {
              this.form[key] = data[key] !== null ? data[key] : "";
            }
          });

          this.$nextTick(() => {
            this.ttdDokterCleared     = this.form.cppt_rows.map((r) => !r.ttd_dokter);
            this.ttdProfesiCleared    = this.form.cppt_rows.map((r) => !r.ttd_profesi_lain);
            this.ttdVerifikasiCleared = this.form.cppt_rows.map((r) => !r.ttd_verifikasi);
          });
        }
      } catch (err) {
        console.error("Error loading data:", err);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    addRow() {
      const now = new Date();
      this.form.cppt_rows.push({
        tanggal: now.toISOString().split("T")[0],
        jam:     now.toTimeString().substring(0, 5),
        isian_dokter: "", nama_dokter: "",
        ttd_dokter: "", ttd_dokter_timestamp: "",
        profesi_jabatan: "", isian_profesi_lain: "", nama_profesi_lain: "",
        ttd_profesi_lain: "", ttd_profesi_lain_timestamp: "",
        nama_verifikasi: "", ttd_verifikasi: "", ttd_verifikasi_timestamp: "",
        stempel_verifikasi: false,
      });
      this.ttdDokterCleared.push(false);
      this.ttdProfesiCleared.push(false);
      this.ttdVerifikasiCleared.push(false);
    },

    deleteRow(index) {
      if (this.form.cppt_rows.length > 1) {
        this.form.cppt_rows.splice(index, 1);
        this.ttdDokterCleared.splice(index, 1);
        this.ttdProfesiCleared.splice(index, 1);
        this.ttdVerifikasiCleared.splice(index, 1);
      }
    },

    saveSign(refName, index, field) {
      const pad = this.$refs[refName];
      const sp  = Array.isArray(pad) ? pad[0] : pad;
      if (!sp) { console.error("REF tidak ditemukan:", refName); return; }

      const { isEmpty, data } = sp.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

      this.form.cppt_rows[index][field] = data;
      const ts = new Date().toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });

      if (field === "ttd_dokter") {
        this.ttdDokterCleared[index] = false;
        this.form.cppt_rows[index].ttd_dokter_timestamp = ts;
      } else if (field === "ttd_profesi_lain") {
        this.ttdProfesiCleared[index] = false;
        this.form.cppt_rows[index].ttd_profesi_lain_timestamp = ts;
      } else if (field === "ttd_verifikasi") {
        this.ttdVerifikasiCleared[index] = false;
        this.form.cppt_rows[index].ttd_verifikasi_timestamp = ts;
      }
    },

    clearSign(index, field) {
      if (field === "ttd_dokter") {
        this.ttdDokterCleared[index] = true;
        this.form.cppt_rows[index].ttd_dokter = "";
        this.form.cppt_rows[index].ttd_dokter_timestamp = "";
      } else if (field === "ttd_profesi_lain") {
        this.ttdProfesiCleared[index] = true;
        this.form.cppt_rows[index].ttd_profesi_lain = "";
        this.form.cppt_rows[index].ttd_profesi_lain_timestamp = "";
      } else if (field === "ttd_verifikasi") {
        this.ttdVerifikasiCleared[index] = true;
        this.form.cppt_rows[index].ttd_verifikasi = "";
        this.form.cppt_rows[index].ttd_verifikasi_timestamp = "";
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
      if (this.form.cppt_rows.length === 0) {
        alert("Minimal harus ada 1 catatan!"); return;
      }
      const hasData = this.form.cppt_rows.some(
        (r) => r.tanggal || r.isian_dokter || r.isian_profesi_lain
      );
      if (!hasData) {
        alert("Harap isi minimal 1 catatan perkembangan!"); return;
      }

      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) return;
          if (key === "cppt_rows") {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const res = await axios.post(
          "/master/pasien/dokumen-catatan-perkembangan-terintegrasi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          alert(res.data.message);
          this.$emit("back");
        }
      } catch (err) {
        console.error("ERROR:", err.response?.data || err);
        alert("Gagal menyimpan catatan perkembangan terintegrasi!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1600px; margin: 0 auto; }
.position-relative { position: relative; }
.py-4 { padding: 24px 0; }

.subtitle-desc {
  font-size: 12px;
  color: #302f2f;
  margin: 4px 0 0;
}

/* === PATIENT INFO === */
.patient-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px 20px;
}
.patient-item {
  display: flex;
  align-items: baseline;
  gap: 6px;
  padding: 4px 0;
  border-bottom: 1px dashed #eee;
}
.patient-label { font-weight: 600; font-size: 13px; color: #555; min-width: 110px; flex-shrink: 0; }
.patient-sep   { color: #888; flex-shrink: 0; }
.patient-val   { font-size: 13px; color: #222; }

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
.table-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

/* === TABLE === */
.table-responsive { overflow-x: auto; }
.cppt-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.cppt-table th {
  background: #2d74b7; color: white;
  padding: 10px 8px; border: 1px solid #1a5fa3;
  font-weight: 600; text-align: center; vertical-align: middle;
}
.cppt-table td { border: 1px solid #ddd; padding: 8px; vertical-align: middle; }

.input-table {
  width: 100%; border: 1px solid #ccc; border-radius: 3px;
  padding: 5px 6px; font-size: 12px; box-sizing: border-box;
}
.input-table:focus { outline: none; border-color: #2d74b7; }

.textarea-table {
  width: 100%; border: 1px solid #ccc; border-radius: 3px;
  padding: 6px 8px; font-size: 12px; resize: vertical;
  min-height: 90px; box-sizing: border-box;
}
.textarea-table:focus { outline: none; border-color: #2d74b7; }

/* === SIGNATURE === */
.signature-cell { display: flex; flex-direction: column; align-items: center; gap: 4px; }
.signature-box-table { width: 150px; height: 80px; border: 2px solid #999; border-radius: 4px; background: white; }
.ttd-preview { width: 280px; height: 180px; object-fit: contain; border: 1px dashed #ccc; display: block; }
.ttd-timestamp { font-size: 10px; color: #2d74b7; background: #e9f5ff; padding: 2px 6px; border-radius: 3px; margin: 2px 0; text-align: center; }

/* === BUTTONS === */
.btn-add-row { background: #28a745; color: white; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; }
.btn-add-row:hover { background: #218838; }

.btn-delete-row { background: #dc3545; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px; }
.btn-delete-row:hover:not(:disabled) { background: #c82333; }
.btn-delete-row:disabled { background: #ccc; cursor: not-allowed; }

.btn-save-mini { background: #1e88e5; color: white; padding: 3px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; width: 100%; }
.btn-save-mini:hover { background: #1565c0; }
.btn-clear-mini { background: #f44336; color: white; padding: 3px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; width: 100%; }

.summary-info { padding: 10px; background: #e9f5ff; border-left: 4px solid #2d74b7; border-radius: 4px; font-size: 14px; }

.action-footer {
  margin-top: 30px; padding: 20px; display: flex;
  justify-content: flex-end; gap: 12px;
  background: #f5f5f5; border-top: 2px solid #ddd; position: sticky; bottom: 0;
}
.btn-save-form { background: #0288d1; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }
.btn-back { background: #ff9800; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:disabled { background: #ccc; cursor: not-allowed; }

.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.1); z-index: 10; cursor: not-allowed; }

.text-center { text-align: center; }
.text-muted  { color: #6c757d; }
.fw-bold     { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: 4px; }
.mb-4 { margin-bottom: 24px; }
.mt-1 { margin-top: 4px; }
.mt-3 { margin-top: 16px; }

@media (max-width: 768px) {
  .patient-grid { grid-template-columns: 1fr; }
  .cppt-table   { font-size: 10px; }
  .signature-box-table, .ttd-preview { width: 120px; height: 70px; }
}

/* === DROPDOWN DOKTER === */
.dropdown-dokter { position: relative; width: 100%; }
.form-select-dokter {
  width: 100%;
  padding: 5px 28px 5px 8px;
  font-size: 12px;
  border: 1.5px solid #cbd5e0;
  border-radius: 6px;
  appearance: none;
  background: white;
  cursor: pointer;
  box-sizing: border-box;
}
.form-select-dokter:focus { outline: none; border-color: #2d74b7; }
.dropdown-icon {
  position: absolute;
  right: 8px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
  pointer-events: none;
  font-size: 12px;
}

/* === STEMPEL === */
.ttd-canvas-wrapper {
  position: relative;
  display: inline-block;
}
.stamp-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 90px;
  height: 90px;
  object-fit: contain;
  opacity: 0.75;
  pointer-events: none;
}
.btn-stamp-mini {
  background: #7b1fa2;
  color: white;
  padding: 3px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 11px;
  width: 100%;
}
.btn-stamp-mini:hover { background: #6a1090; }

/* Fade transition for stempel */
.fade-stamp-enter-active,
.fade-stamp-leave-active { transition: opacity 0.25s ease; }
.fade-stamp-enter,
.fade-stamp-leave-to { opacity: 0; }
</style>
