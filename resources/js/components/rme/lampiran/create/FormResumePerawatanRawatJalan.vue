<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">RESUME PERAWATAN PASIEN RAWAT JALAN</h2>
        <p class="text-muted">{{ form.no_surat}}</p>
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

      <!-- ================= TABEL RESUME KUNJUNGAN ================= -->
      <div class="box-rme mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="section-title-rme mb-0">Data Resume Kunjungan</h5>
          <button @click="addRow" class="btn-add-row">
            <i class="fas fa-plus"></i> Tambah Kunjungan
          </button>
        </div>

        <div class="table-responsive">
          <table class="resume-table">
            <thead>
              <tr>
                <th style="width: 130px">Tanggal<br/>Kunjungan</th>
                <th style="width: 150px">Poli</th>
                <th style="width: 250px">Diagnosa</th>
                <th>Terapi/Tindakan</th>
                <th style="width: 150px">Dokter</th>
                <th style="width: 80px">Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(row, index) in form.resume_rows" :key="index">
                <!-- Tanggal Kunjungan -->
                <td>
                  <input 
                    type="date" 
                    v-model="row.tanggal_kunjungan" 
                    class="input-table"
                  />
                </td>

                <!-- Poli -->
                <td>
                  <select v-model="row.poli" class="input-table">
                    <option value="">-- Pilih Poli --</option>
                    <option value="Poli Mata">Poli Mata</option>
                    <option value="Poli Umum">Poli NO</option>
                    <option value="Poli Gigi">Poli Vitreo Retina</option>
                    <option value="Poli Anak">Poli KBR</option>
                  </select>
                </td>

                <!-- Diagnosa -->
                <td>
                  <textarea 
                    v-model="row.diagnosa" 
                    class="textarea-table" 
                    rows="2"
                    placeholder="ICD-10, diagnosa kerja..."
                  ></textarea>
                </td>

                <!-- Terapi/Tindakan -->
                <td>
                  <textarea 
                    v-model="row.terapi_tindakan" 
                    class="textarea-table" 
                    rows="2"
                    placeholder="Obat yang diberikan, tindakan yang dilakukan..."
                  ></textarea>
                </td>

                <!-- Dokter -->
                <td>
                  <div class="dropdown-dokter mt-2">
                    <select v-model="form.nama_dokter_verifikasi" class="form-select-dokter">
                      <option value="" disabled>🩺 Pilih Dokter</option>
                      <option
                        v-for="dokter in listDokter"
                        :key="dokter.id"
                        :value="dokter.nama"
                      >
                        {{ dokter.nama }}
                      </option>
                    </select>
                    <span class="dropdown-icon">▾</span>
                  </div>
                </td>

                <!-- Aksi -->
                <td class="text-center">
                  <button 
                    @click="deleteRow(index)" 
                    class="btn-delete-row"
                    :disabled="form.resume_rows.length === 1"
                    title="Hapus Baris"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>

              <tr v-if="form.resume_rows.length === 0">
                <td colspan="6" class="text-center text-muted">
                  Belum ada data kunjungan. Klik "Tambah Kunjungan" untuk menambah data.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Summary Info -->
        <div class="summary-info mt-3">
          <strong>Total Kunjungan:</strong> {{ form.resume_rows.length }} kali
        </div>
      </div>

      <!-- ================= CATATAN TAMBAHAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Catatan Tambahan</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <textarea 
              v-model="form.catatan" 
              class="textarea-rme" 
              rows="4"
              placeholder="Catatan perkembangan pasien, riwayat alergi, catatan khusus, dll"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <!-- <div class="box-rme mb-4">
        <h5 class="section-title-rme">Verifikasi</h5>

        <div class="row">
          <div class="col-md-6 text-center">
            <label class="fw-bold mb-2">Tanda Tangan Dokter Penanggung Jawab</label>
            <VueSignaturePad
              ref="ttd_dokter"
              :options="sigOption"
              class="signature-box-rme mx-auto"
            />
            <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">
              Simpan ✔
            </button>
            <input
              type="text"
              v-model="form.nama_dokter_verifikasi"
              class="input-rme mt-2"
              placeholder="Nama Lengkap Dokter"
            />
          </div>
        </div>
      </div> -->
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button  v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span  v-if="loadingSubmit">Menyimpan...</span>
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
  name: "FormResumePerawatanRawatJalan",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: String,
      default: null,
    },
    viewData: {
      type: String,
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
        no_surat:"",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        resume_rows: [
          {
            tanggal_kunjungan: "",
            poli: "",
            diagnosa: "",
            terapi_tindakan: "",
            dokter: ""
          }
        ],
        catatan: "",
        ttd_dokter: "",
        nama_dokter_verifikasi: "",
      }
    };
  },
  computed: {
    isEditMode() {
      // return !!this.editUuid;
    }
  },
  async mounted() {
    await this.fetchTahunAkreditasi();
    await this.fetchDokter();
    if(this.viewData) {
      console.log(this.editUuid);
      this.editUuid = this.editData.uuid;
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.editUuid = this.editData.uuid;
      this.disabledSubmit = false;
      this.loadDataForEdit();
    } else {
      this.disabledSubmit = false;
      this.setDataForm();
    }
  },
  methods: {
    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
      } catch (error) {
        console.error('Gagal memuat data dokter:', error);
      }
    },
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';

        if (!this.form.no_surat) {
          this.form.no_surat = `RM 1.6/RPPRJ/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 1.6/RPPRJ/22';
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

      // Set default tanggal untuk baris pertama
      const today = new Date().toISOString().split('T')[0];
      this.form.resume_rows[0].tanggal_kunjungan = today;
    },

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=resume_perawatan_rawat_jalan`
        );
        if (response.data.status) {
          const data = response.data.data;
          
          Object.keys(this.form).forEach(key => {
            if (key === 'resume_rows' && data.resume_rows) {
              this.form.resume_rows = JSON.parse(data.resume_rows);
            } else if (data[key] !== undefined && key !== 'resume_rows') {
              this.form[key] = data[key];
            }
          });
          this.$nextTick(() => {
            if (this.form.ttd_dokter && this.$refs.ttd_dokter) {
              this.$refs.ttd_dokter.fromDataURL(this.form.ttd_dokter);
            }
          });
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit('back');
      }
    },

    addRow() {
      const today = new Date().toISOString().split('T')[0];
      
      this.form.resume_rows.push({
        tanggal_kunjungan: today,
        poli: "",
        diagnosa: "",
        terapi_tindakan: "",
        dokter: ""
      });
    },

    deleteRow(index) {
      if (this.form.resume_rows.length > 1) {
        this.form.resume_rows.splice(index, 1);
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { data } = pad.saveSignature();
      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi
      if (this.form.resume_rows.length === 0) {
        alert("Minimal harus ada 1 data kunjungan!");
        return;
      }

      // Validasi ada data yang diisi
      const hasData = this.form.resume_rows.some(row => 
        row.tanggal_kunjungan || row.poli || row.diagnosa || row.terapi_tindakan || row.dokter
      );

      if (!hasData) {
        alert("Harap isi minimal 1 data kunjungan!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          if (key === 'resume_rows') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-resume-perawatan-rawat-jalan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan resume perawatan rawat jalan!");
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

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
}

/* RESUME TABLE */
.table-responsive {
  overflow-x: auto;
}

.resume-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.resume-table th {
  background: #2d74b7;
  color: white;
  padding: 10px 8px;
  border: 1px solid #fff;
  font-weight: 600;
  text-align: center;
}

.resume-table td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: top;
}

.input-table {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 6px 8px;
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
  min-height: 50px;
}

.textarea-table:focus {
  outline: none;
  border-color: #2d74b7;
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

/* SIGNATURE */
.signature-box-rme {
  width: 300px;
  height: 150px;
  border: 2px solid #999;
  border-radius: 4px;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
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
  z-index: 10;
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

/* RESPONSIVE */
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

.gap-2 {
  gap: 8px;
}

.mb-0 {
  margin-bottom: 0;
}

.mb-2 {
  margin-bottom: 8px;
}

.mb-3 {
  margin-bottom: 16px;
}

.mb-4 {
  margin-bottom: 24px;
}

.mt-2 {
  margin-top: 8px;
}

.mt-3 {
  margin-top: 16px;
}

.fw-bold {
  font-weight: bold;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
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
@media (max-width: 768px) {
  .col-md-3,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .resume-table {
    font-size: 11px;
  }

  .input-table,
  .textarea-table {
    font-size: 11px;
    padding: 4px 6px;
  }
}

.dropdown-dokter {
  position: relative;
  width: 100%;
}

.form-select-dokter {
  width: 100%;
  padding: 10px 40px 10px 14px;
  font-size: 14px;
  color: #2d3748;
  background-color: #fff;
  border: 1.5px solid #cbd5e0;
  border-radius: 10px;
  appearance: none;
  -webkit-appearance: none;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
  outline: none;
}

.form-select-dokter:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.form-select-dokter:hover {
  border-color: #a0aec0;
}

.dropdown-icon {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
  font-size: 16px;
  pointer-events: none;
}
</style>