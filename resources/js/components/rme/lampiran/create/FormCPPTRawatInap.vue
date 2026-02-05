<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
    <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</h2>
        <h4 class="fw-semibold">RAWAT INAP</h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-3">
            <label>Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
          <div class="col-md-3">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= TABEL CPPT ================= -->
      <div class="box-rme mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="section-title-rme mb-0">Data Catatan Perkembangan Pasien</h5>
          <button @click="addRow" class="btn-add-row">
            <i class="fas fa-plus"></i> Tambah Catatan
          </button>
        </div>

        <div class="table-responsive">
          <table class="cppt-table">
            <thead>
              <tr>
                <th style="width: 130px">Tanggal / Jam</th>
                <th style="width: 130px">Profesi<br/>Pemberi Asuhan</th>
                <th style="width: 280px">Hasil Asesmen Pasien<br/>(SOAP/ADIME)</th>
                <th style="width: 200px">Instruksi PPA</th>
                <th style="width: 200px">TTD PPA</th>
                <th style="width: 200px">Review DPJP</th>
                <th style="width: 80px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(row, index) in form.cppt_rows" :key="index">
                <!-- Tanggal / Jam -->
                <td>
                  <input 
                    type="date" 
                    v-model="row.tanggal" 
                    class="input-table mb-1"
                  />
                  <input 
                    type="time" 
                    v-model="row.jam" 
                    class="input-table"
                  />
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
                    placeholder="S: Subjektif (keluhan pasien)
O: Objektif (hasil pemeriksaan)
A: Assessment (diagnosis)
P: Planning (rencana tindakan)"
                  ></textarea>
                </td>

                <!-- Instruksi PPA -->
                <td>
                  <textarea 
                    v-model="row.instruksi_ppa" 
                    class="textarea-table" 
                    rows="5"
                    placeholder="Instruksi tindakan, terapi, monitoring, dll"
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
                    <VueSignaturePad
                      :ref="`ttd_ppa_${index}`"
                      :options="sigOption"
                      class="signature-box-table"
                    />
                    <button 
                      @click="saveSign(`ttd_ppa_${index}`, index, 'ttd_ppa')" 
                      class="btn-save-mini"
                    >
                      Simpan ✔
                    </button>
                  </div>
                </td>

                <!-- Review DPJP -->
                <td class="text-center">
                  <div class="signature-cell">
                    <input 
                      type="date" 
                      v-model="row.tanggal_review" 
                      class="input-table mb-1"
                      placeholder="Tgl Review"
                    />
                    <input 
                      type="time" 
                      v-model="row.jam_review" 
                      class="input-table mb-1"
                    />
                    <VueSignaturePad
                      :ref="`ttd_dpjp_${index}`"
                      :options="sigOption"
                      class="signature-box-table"
                    />
                    <button 
                      @click="saveSign(`ttd_dpjp_${index}`, index, 'ttd_dpjp')" 
                      class="btn-save-mini"
                    >
                      Simpan ✔
                    </button>
                    <input 
                      type="text" 
                      v-model="row.nama_dpjp" 
                      class="input-table mt-1"
                      placeholder="Nama DPJP"
                    />
                  </div>
                </td>

                <!-- Aksi -->
                <td class="text-center">
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
                <td colspan="7" class="text-center text-muted">
                  Belum ada catatan. Klik "Tambah Catatan" untuk menambah data.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Summary Info -->
        <div class="summary-info mt-3">
          <strong>Total Catatan:</strong> {{ form.cppt_rows.length }} entri
        </div>
      </div>

      <!-- ================= CATATAN KHUSUS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Catatan Khusus / Informasi Tambahan</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <textarea 
              v-model="form.catatan_khusus" 
              class="textarea-rme" 
              rows="4"
              placeholder="Catatan penting, perhatian khusus, alergi, dll"
            ></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button  v-if="!disabledSubmit"  class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>{{ editUuid ? 'Update' : 'Simpan' }}</span>
      </button>

      <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
        Kembali
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormCPPTRawatInap",
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
      disabledSubmit: false,
      editUuid: "",
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        cppt_rows: [
          {
            tanggal: "",
            jam: "",
            profesi: "",
            hasil_asesmen: "",
            instruksi_ppa: "",
            nama_ppa: "",
            ttd_ppa: "",
            tanggal_review: "",
            jam_review: "",
            nama_dpjp: "",
            ttd_dpjp: ""
          }
        ],
        catatan_khusus: ""
      }
    };
  },
  computed: {
    isEditMode() {
      // return !!this.editUuid;
    }
  },
  mounted() {
    console.log("p", this.editData);
    if(this.viewData) {
      console.log(this.editUuid);

      this.editUuid = this.editData.uuid;
      this.disabledSubmit = true;
      this.loadDataForEdit();
    }  else if (this.editData) {
      this.disabledSubmit = false;
      this.editUuid = this.editData.uuid;

      this.loadDataForEdit();
    } else {
      this.disabledSubmit = false;

      this.setDataForm();
    }
  },
  methods: {
    setDataForm() {
      if (this.selectedPatient) {
        console.log('selected pas', this.selectedPatient)
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_ktp || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }

      // Set default tanggal & jam untuk baris pertama
      const now = new Date();
      this.form.cppt_rows[0].tanggal = now.toISOString().split('T')[0];
      this.form.cppt_rows[0].jam = now.toTimeString().substring(0, 5);
    },

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=cppt_rawat_inap`
        );

        if (response.data) {
          const data = response.data.data;
          
          Object.keys(this.form).forEach(key => {
            if (key === 'cppt_rows' && data.cppt_rows) {
              this.form.cppt_rows = JSON.parse(data.cppt_rows);
            } else if (data[key] !== undefined && key !== 'cppt_rows') {
              this.form[key] = data[key];
            }
          });
          this.$nextTick(() => {
          this.form.cppt_rows.forEach((row, index) => {

            // ===== TTD PPA =====
            if (row.ttd_ppa && this.$refs[`ttd_ppa_${index}`]) {
              const padPpa = this.$refs[`ttd_ppa_${index}`][0];
              padPpa.fromDataURL(row.ttd_ppa);
            }

            // ===== TTD DPJP =====
            if (row.ttd_dpjp && this.$refs[`ttd_dpjp_${index}`]) {
              const padDpjp = this.$refs[`ttd_dpjp_${index}`][0];
              padDpjp.fromDataURL(row.ttd_dpjp);
            }

          });
        });
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit('back');
      }
    },

    addRow() {
      const now = new Date();
      
      this.form.cppt_rows.push({
        tanggal: now.toISOString().split('T')[0],
        jam: now.toTimeString().substring(0, 5),
        profesi: "",
        hasil_asesmen: "",
        instruksi_ppa: "",
        nama_ppa: "",
        ttd_ppa: "",
        tanggal_review: "",
        jam_review: "",
        nama_dpjp: "",
        ttd_dpjp: ""
      });
    },

    deleteRow(index) {
      if (this.form.cppt_rows.length > 1) {
        this.form.cppt_rows.splice(index, 1);
      }
    },

    saveSign(refName, index, field) {
      const pad = this.$refs[refName];
      
      if (!pad || !pad[0]) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { data } = pad[0].saveSignature();
      this.form.cppt_rows[index][field] = data;
      console.log("TTD saved:", refName, field);
    },

    async submitForm() {
      // Validasi
      if (this.form.cppt_rows.length === 0) {
        alert("Minimal harus ada 1 catatan!");
        return;
      }

      // Validasi ada data yang diisi
      const hasData = this.form.cppt_rows.some(row => 
        row.tanggal || row.profesi || row.hasil_asesmen || row.instruksi_ppa
      );

      if (!hasData) {
        alert("Harap isi minimal 1 catatan perkembangan pasien!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          if (key === 'cppt_rows') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-cppt-rawat-inap",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan catatan perkembangan pasien!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1600px;
  margin: 0 auto;
}

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: white;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
}

.input-rme:disabled,
.input-rme[readonly] {
  background: #e9ecef;
  cursor: not-allowed;
}

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
}

/* CPPT TABLE */
.table-responsive {
  overflow-x: auto;
}

.cppt-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 12px;
}

.cppt-table th {
  background: #2d74b7;
  color: white;
  padding: 10px 8px;
  border: 1px solid #fff;
  font-weight: 600;
  text-align: center;
  vertical-align: middle;
}

.cppt-table td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: top;
}

.input-table {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 5px 6px;
  font-size: 12px;
}

.input-table:focus {
  outline: none;
  border-color: #2d74b7;
}

.textarea-table {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 6px 8px;
  font-size: 12px;
  resize: vertical;
  min-height: 80px;
  font-family: 'Courier New', monospace;
  line-height: 1.4;
}

.textarea-table:focus {
  outline: none;
  border-color: #2d74b7;
}

.signature-cell {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}

.signature-box-table {
  width: 180px;
  height: 100px;
  border: 2px solid #999;
  border-radius: 4px;
  background: white;
}

.btn-save-mini {
  background: #1e88e5;
  color: white;
  padding: 3px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 11px;
  font-weight: 500;
  width: 100%;
}

.btn-save-mini:hover {
  background: #1565c0;
}

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

/* BUTTONS */
.btn-add-row {
  background: #28a745;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.btn-add-row:hover {
  background: #218838;
}

.btn-delete-row {
  background: #dc3545;
  color: white;
  border: none;
  padding: 4px 8px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}

.btn-delete-row:hover:not(:disabled) {
  background: #c82333;
}

.btn-delete-row:disabled {
  background: #ccc;
  cursor: not-allowed;
}

/* SUMMARY */
.summary-info {
  padding: 10px;
  background: #e9f5ff;
  border-left: 4px solid #2d74b7;
  border-radius: 4px;
  font-size: 14px;
}

/* ACTION FOOTER */
.action-footer {
  margin-top: 30px;
  padding: 20px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  background: #f5f5f5;
  border-top: 2px solid #ddd;
  position: sticky;
  bottom: 0;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 10px 24px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  font-size: 16px;
}

.btn-save-form:disabled {
  background: #ccc;
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
  font-size: 16px;
}

/* RESPONSIVE GRID */
.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-3,
.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
}

.col-md-3 {
  flex: 0 0 25%;
  max-width: 25%;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.align-items-center {
  align-items: center;
}

.mb-0 {
  margin-bottom: 0;
}

.mb-1 {
  margin-bottom: 4px;
}

.mb-3 {
  margin-bottom: 16px;
}

.mb-4 {
  margin-bottom: 24px;
}

.mt-1 {
  margin-top: 4px;
}

.mt-3 {
  margin-top: 16px;
}

.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
}

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
}

@media (max-width: 768px) {
  .col-md-3,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .cppt-table {
    font-size: 10px;
  }

  .input-table,
  .textarea-table {
    font-size: 11px;
    padding: 4px 5px;
  }

  .signature-box-table {
    width: 140px;
    height: 80px;
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
}
</style>