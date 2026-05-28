<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="position-relative">
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN</h2>
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
            <h5 class="section-title-rme mb-0">Data Catatan Perkembangan Pasien</h5>
            <button @click="addRow" class="btn-add-row" v-if="!disabledSubmit">
              <i class="fas fa-plus"></i> Tambah Catatan
            </button>
          </div>

          <div class="table-responsive">
            <table class="cppt-table">
              <thead>
                <tr>
                  <th style="width:120px;">Tanggal / Jam</th>
                  <th style="width:130px;">Profesi Pemberi Asuhan (PPA)</th>
                  <th style="width:280px;">Hasil Asesmen Pasien<br/><small>(SOAP/ADIME)</small></th>
                  <th style="width:200px;">Instruksi PPA</th>
                  <th style="width:200px;">TTD PPA</th>
                  <th style="width:220px;">Review &amp; Verifikasi DPJP</th>
                  <th style="width:60px;" v-if="!disabledSubmit">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in form.cppt_rows" :key="index">
                  <!-- Tanggal / Jam -->
                  <td>
                    <input type="date" v-model="row.tanggal" class="input-table mb-1" />
                    <input type="time" v-model="row.jam" class="input-table" />
                  </td>

                  <!-- Profesi -->
                  <td>
                    <select v-model="row.profesi" class="input-table">
                      <option value="">-- Pilih --</option>
                      <option value="Dokter">Dokter</option>
                      <option value="Perawat">Perawat</option>
                      <option value="Bidan">Bidan</option>
                      <option value="Fisioterapi">Fisioterapi</option>
                      <option value="Gizi">Gizi</option>
                      <option value="Farmasi">Farmasi</option>
                      <option value="Radiologi">Radiologi</option>
                      <option value="Laboratorium">Laboratorium</option>
                    </select>
                  </td>

                  <!-- Hasil Asesmen -->
                  <td>
                    <textarea
                      v-model="row.hasil_asesmen"
                      class="textarea-table"
                      rows="5"
                      placeholder="S: Subjektif&#10;O: Objektif&#10;A: Assessment&#10;P: Planning"
                    ></textarea>
                  </td>

                  <!-- Instruksi PPA -->
                  <td>
                    <textarea
                      v-model="row.instruksi_ppa"
                      class="textarea-table"
                      rows="5"
                      placeholder="Instruksi tindakan, terapi, monitoring..."
                    ></textarea>
                    <input
                      type="text"
                      v-model="row.nama_ppa"
                      class="input-table mt-1"
                      placeholder="Nama PPA"
                    />
                  </td>

                  <!-- TTD PPA -->
                  <td class="text-center">
                    <div class="signature-cell">
                      <div v-if="row.ttd_ppa && !ttdPpaCleared[index]">
                        <img :src="row.ttd_ppa" class="ttd-preview" />
                        <p v-if="row.ttd_ppa_timestamp" class="ttd-timestamp">
                          {{ row.ttd_ppa_timestamp }}
                        </p>
                        <button @click="clearSign(index, 'ttd_ppa')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">
                          Hapus
                        </button>
                      </div>
                      <div v-else>
                        <VueSignaturePad :ref="`ttd_ppa_${index}`" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign(`ttd_ppa_${index}`, index, 'ttd_ppa')" class="btn-save-mini" v-if="!disabledSubmit" type="button">
                          Simpan ✔
                        </button>
                      </div>
                    </div>
                  </td>

                  <!-- Review DPJP -->
                  <td class="text-center">
                    <div class="signature-cell">
                      <input type="date" v-model="row.tanggal_review" class="input-table mb-1" />
                      <input type="time" v-model="row.jam_review" class="input-table mb-1" />
                      <div v-if="row.ttd_dpjp && !ttdDpjpCleared[index]">
                        <img :src="row.ttd_dpjp" class="ttd-preview" />
                        <p v-if="row.ttd_dpjp_timestamp" class="ttd-timestamp">
                          {{ row.ttd_dpjp_timestamp }}
                        </p>
                        <button @click="clearSign(index, 'ttd_dpjp')" class="btn-clear-mini" v-if="!disabledSubmit" type="button">
                          Hapus
                        </button>
                      </div>
                      <div v-else>
                        <VueSignaturePad :ref="`ttd_dpjp_${index}`" :options="sigOption" class="signature-box-table" />
                        <button @click="saveSign(`ttd_dpjp_${index}`, index, 'ttd_dpjp')" class="btn-save-mini" v-if="!disabledSubmit" type="button">
                          Simpan ✔
                        </button>
                      </div>
                      <!-- Dropdown Dokter -->
                      <div class="dropdown-dokter mt-1">
                        <select v-model="row.nama_dpjp" class="input-table">
                          <option value="">-- Pilih Dokter --</option>
                          <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                            {{ dokter.nama }}
                          </option>
                        </select>
                      </div>
                    </div>
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
                  <td :colspan="disabledSubmit ? 6 : 7" class="text-center text-muted">
                    Belum ada catatan. Klik "Tambah Catatan" untuk menambah data.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="summary-info mt-3">
            <strong>Total Catatan:</strong> {{ form.cppt_rows.length }} entri
          </div>
        </div>

        <!-- CATATAN KHUSUS -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Catatan Khusus</h5>
          <textarea
            v-model="form.catatan_khusus"
            class="textarea-rme"
            rows="3"
            placeholder="Catatan penting, perhatian khusus, alergi, dll"
          ></textarea>
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
  name: "FormCPPTRawatJalan",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit:   false,
      disabledSubmit:  false,
      editUuid:        "",
      listDokter:      [],
      ttdPpaCleared:   [],
      ttdDpjpCleared:  [],
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
            tanggal: "", jam: "", profesi: "",
            hasil_asesmen: "", instruksi_ppa: "",
            nama_ppa: "", ttd_ppa: "", ttd_ppa_timestamp: "",
            tanggal_review: "", jam_review: "",
            nama_dpjp: "", ttd_dpjp: "", ttd_dpjp_timestamp: "",
          },
        ],
        catatan_khusus: "",
      },
    };
  },
  async mounted() {
    console.log("🟢 CPPT RAJAL - Mounted, editData:", this.editData);
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
        this.listDokter = res.data.data || [];
      } catch (e) {
        console.error("Gagal memuat dokter:", e);
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) this.form.no_surat = `RM 1.5/CPPTRJ/${tahun}`;
      } catch {
        if (!this.form.no_surat) this.form.no_surat = "RM 1.5/CPPTRJ/22";
      }
    },

    setDataForm() {
      const now = new Date();
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
      this.ttdPpaCleared  = [false];
      this.ttdDpjpCleared = [false];
    },

    async loadDataForEdit() {
      try {
        if (!this.editUuid) { this.setDataForm(); return; }

        const res = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=cppt_rawat_jalan`
        );

        if (res.data) {
          const data = res.data.data;

          Object.keys(this.form).forEach((key) => {
            if (key === "cppt_rows" && data.cppt_rows) {
              this.form.cppt_rows = typeof data.cppt_rows === "string"
                ? JSON.parse(data.cppt_rows)
                : data.cppt_rows;
            } else if (data[key] !== undefined && key !== "cppt_rows") {
              this.form[key] = data[key] !== null ? data[key] : "";
            }
          });

          this.$nextTick(() => {
            this.ttdPpaCleared  = this.form.cppt_rows.map((r) => !r.ttd_ppa);
            this.ttdDpjpCleared = this.form.cppt_rows.map((r) => !r.ttd_dpjp);
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
        profesi: "", hasil_asesmen: "", instruksi_ppa: "",
        nama_ppa: "", ttd_ppa: "", ttd_ppa_timestamp: "",
        tanggal_review: "", jam_review: "",
        nama_dpjp: "", ttd_dpjp: "", ttd_dpjp_timestamp: "",
      });
      this.ttdPpaCleared.push(false);
      this.ttdDpjpCleared.push(false);
    },

    deleteRow(index) {
      if (this.form.cppt_rows.length > 1) {
        this.form.cppt_rows.splice(index, 1);
        this.ttdPpaCleared.splice(index, 1);
        this.ttdDpjpCleared.splice(index, 1);
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
    
      if (field === "ttd_ppa") {
        this.ttdPpaCleared[index] = false;
        this.form.cppt_rows[index].ttd_ppa_timestamp = ts;
      } else if (field === "ttd_dpjp") {
        this.ttdDpjpCleared[index] = false;
        this.form.cppt_rows[index].ttd_dpjp_timestamp = ts;
      }
    
      console.log("TTD saved:", refName, field);
    },
    
    clearSign(index, field) {
      if (field === "ttd_ppa") {
        this.ttdPpaCleared[index] = true;
        this.form.cppt_rows[index].ttd_ppa = "";
        this.form.cppt_rows[index].ttd_ppa_timestamp = "";
      } else if (field === "ttd_dpjp") {
        this.ttdDpjpCleared[index] = true;
        this.form.cppt_rows[index].ttd_dpjp = "";
        this.form.cppt_rows[index].ttd_dpjp_timestamp = "";
      }
    
      this.$nextTick(() => {
        this.$nextTick(() => {
          const refName = `ttd_${field === "ttd_ppa" ? "ppa" : "dpjp"}_${index}`;
          const pad = this.$refs[refName];
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
        (r) => r.tanggal || r.profesi || r.hasil_asesmen || r.instruksi_ppa
      );
      if (!hasData) {
        alert("Harap isi minimal 1 catatan perkembangan pasien!"); return;
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
          "/master/pasien/dokumen-cppt-rawat-jalan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          alert(res.data.message);
          this.$emit("back");
        }
      } catch (err) {
        console.error("ERROR:", err.response?.data || err);
        alert("Gagal menyimpan catatan perkembangan pasien!");
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

/* === PATIENT INFO BERSIH === */
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
.patient-label {
  font-weight: 600;
  font-size: 13px;
  color: #555;
  min-width: 110px;
  flex-shrink: 0;
}
.patient-sep { color: #888; flex-shrink: 0; }
.patient-val { font-size: 13px; color: #222; }

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
  padding: 10px 8px; border: 1px solid #fff;
  font-weight: 600; text-align: center; vertical-align: middle;
}
.cppt-table td { 
  border: 1px solid #ddd; 
  padding: 8px; 
  vertical-align: middle;  /* ini saja yang diubah */
}

.input-table {
  width: 100%; border: 1px solid #ccc; border-radius: 3px;
  padding: 5px 6px; font-size: 12px; box-sizing: border-box;
}
.input-table:focus { outline: none; border-color: #2d74b7; }

.textarea-table {
  width: 100%; border: 1px solid #ccc; border-radius: 3px;
  padding: 6px 8px; font-size: 12px; resize: vertical;
  min-height: 80px; box-sizing: border-box;
}
.textarea-table:focus { outline: none; border-color: #2d74b7; }

.textarea-rme {
  width: 100%; border: 1px solid #ccc; border-radius: 4px;
  padding: 8px; font-size: 14px; resize: vertical; box-sizing: border-box;
}

/* === SIGNATURE === */
.signature-cell { display: flex; flex-direction: column; align-items: center; gap: 4px; }
.signature-box-table { width: 160px; height: 90px; border: 2px solid #999; border-radius: 4px; background: white; }
.ttd-preview { width: 210px; height: 140px; object-fit: contain; border: 1px dashed #ccc; display: block; }
.ttd-timestamp { font-size: 10px; color: #2d74b7; background: #e9f5ff; padding: 2px 6px; border-radius: 3px; margin: 2px 0; }

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
.text-muted { color: #6c757d; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: 4px; }
.mb-4 { margin-bottom: 24px; }
.mt-1 { margin-top: 4px; }
.mt-3 { margin-top: 16px; }
.dropdown-dokter { width: 100%; }

@media (max-width: 768px) {
  .patient-grid { grid-template-columns: 1fr; }
  .cppt-table { font-size: 10px; }
  .signature-box-table, .ttd-preview { width: 120px; height: 70px; }
}
</style>
