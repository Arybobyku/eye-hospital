<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">CATATAN KEPERAWATAN</h2>
        <h4 class="fw-semibold">{{ form.no_surat}} </h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>

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
        
        <div class="row">
          <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= TABEL CATATAN KEPERAWATAN ================= -->
      <div class="box-rme mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="section-title-rme mb-0">Data Catatan Keperawatan</h5>
          <button @click="addRow" class="btn-add-row">
            <i class="fas fa-plus"></i> Tambah Catatan
          </button>
        </div>

        <div class="table-responsive">
          <table class="catatan-table">
            <thead>
              <tr>
                <th style="width: 120px">Tanggal</th>
                <th style="width: 100px">Jam</th>
                <th>Uraian</th>
                <th style="width: 220px">Nama & Paraf</th>
                <th style="width: 80px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(row, index) in form.catatan_rows" :key="index">
                <!-- Tanggal -->
                <td>
                  <input 
                    type="date" 
                    v-model="row.tanggal" 
                    class="input-table"
                  />
                </td>

                <!-- Jam -->
                <td>
                  <input 
                    type="time" 
                    v-model="row.jam" 
                    class="input-table"
                  />
                </td>

                <!-- Uraian -->
                <td>
                  <textarea 
                    v-model="row.uraian" 
                    class="textarea-table" 
                    rows="3"
                    placeholder="Catatan keperawatan, observasi, tindakan yang dilakukan..."
                  ></textarea>
                </td>

                <!-- Nama & Paraf -->
                <td class="text-center">
                  <div class="signature-cell">
                    <input 
                      type="text" 
                      v-model="row.nama_perawat" 
                      class="input-table mb-1"
                      placeholder="Nama Perawat"
                    />
                    <VueSignaturePad
                      :ref="`ttd_${index}`"
                      :options="sigOption"
                      class="signature-box-table"
                    />
                    <button 
                      @click="saveSign(`ttd_${index}`, index)" 
                      class="btn-save-mini"
                    >
                      Simpan ✔
                    </button>
                  </div>
                </td>

                <!-- Aksi -->
                <td class="text-center">
                  <button 
                    @click="deleteRow(index)" 
                    class="btn-delete-row"
                    :disabled="form.catatan_rows.length === 1"
                    title="Hapus Baris"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>

              <tr v-if="form.catatan_rows.length === 0">
                <td colspan="5" class="text-center text-muted">
                  Belum ada catatan. Klik "Tambah Catatan" untuk menambah data.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Summary Info -->
        <div class="summary-info mt-3">
          <strong>Total Catatan:</strong> {{ form.catatan_rows.length }} entri
        </div>
      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
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
  name: "FormCatatanKeperawatan",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editUuid: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      loadingSubmit: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        catatan_rows: [
          {
            tanggal: "",
            jam: "",
            uraian: "",
            nama_perawat: "",
            ttd_perawat: ""
          }
        ]
      }
    };
  },
  computed: {
    isEditMode() {
      return !!this.editUuid;
    }
  },
  async mounted() {
    await this.fetchTahunAkreditasi();
    if (this.isEditMode) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },
  methods: {
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';
        
        if (!this.form.no_surat) {
          this.form.no_surat = `RRM 3.0/CP/${tahun}`;
        }
        
        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 3.0/CP/22';
        }
      }
    },
    setDataForm() {
      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_ktp || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }

      // Set default tanggal & jam untuk baris pertama
      const now = new Date();
      this.form.catatan_rows[0].tanggal = now.toISOString().split('T')[0];
      this.form.catatan_rows[0].jam = now.toTimeString().substring(0, 5);
    },

    async loadDataForEdit() {
  try {
    const response = await axios.get(
      `/master/rekammedis/lampiran/${this.editUuid}?type=catatan_keperawatan`
    );

    if (response.data.status) {
      const data = response.data.data;

      Object.keys(this.form).forEach(key => {
        if (key === 'catatan_rows' && data.catatan_rows) {
          this.form.catatan_rows = JSON.parse(data.catatan_rows);
        } else if (data[key] !== undefined) {
          this.form[key] = data[key];
        }
      });

      // 🔴 INI PENTING
      this.$nextTick(() => {
        this.form.catatan_rows.forEach((row, index) => {
          if (row.ttd_perawat) {
            const pad = this.$refs[`ttd_${index}`];
            if (pad && pad[0]) {
              pad[0].fromDataURL(row.ttd_perawat);
            }
          }
        });
      });
    }
  } catch (err) {
    console.error(err);
  }
},


    addRow() {
      const now = new Date();
      
      this.form.catatan_rows.push({
        tanggal: now.toISOString().split('T')[0],
        jam: now.toTimeString().substring(0, 5),
        uraian: "",
        nama_perawat: "",
        ttd_perawat: ""
      });
    },

    deleteRow(index) {
      if (this.form.catatan_rows.length > 1) {
        this.form.catatan_rows.splice(index, 1);
      }
    },

    saveSign(refName, index) {
      const pad = this.$refs[refName];
      
      if (!pad || !pad[0]) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { data } = pad[0].saveSignature();
      this.form.catatan_rows[index].ttd_perawat = data;
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi
      if (this.form.catatan_rows.length === 0) {
        alert("Minimal harus ada 1 catatan!");
        return;
      }

      // Validasi ada data yang diisi
      const hasData = this.form.catatan_rows.some(row => 
        row.tanggal || row.uraian || row.nama_perawat
      );

      if (!hasData) {
        alert("Harap isi minimal 1 catatan keperawatan!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          if (key === 'catatan_rows') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-catatan-keperawatan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan catatan keperawatan!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1400px;
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

/* TABLE */
.table-responsive {
  overflow-x: auto;
}

.catatan-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.catatan-table th {
  background: #2d74b7;
  color: white;
  padding: 10px 8px;
  border: 1px solid #fff;
  font-weight: 600;
  text-align: center;
}

.catatan-table td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: top;
}

.input-table {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 5px 6px;
  font-size: 13px;
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
  font-size: 13px;
  resize: vertical;
  min-height: 60px;
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
  width: 200px;
  height: 80px;
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

.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
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
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .catatan-table {
    font-size: 11px;
  }

  .input-table,
  .textarea-table {
    font-size: 11px;
    padding: 4px 5px;
  }

  .signature-box-table {
    width: 150px;
    height: 70px;
  }
}
</style>