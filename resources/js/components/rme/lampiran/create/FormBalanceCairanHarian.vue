<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">BALANCE CAIRAN HARIAN</h2>
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
          <div class="col-md-2">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= TABEL BALANCE CAIRAN ================= -->
      <div class="box-rme mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="section-title-rme mb-0">Data Balance Cairan</h5>
          <button @click="addRow" class="btn-add-row">
            <i class="fas fa-plus"></i> Tambah Baris
          </button>
        </div>

        <div class="table-responsive">
          <table class="balance-table">
            <thead>
              <tr>
                <th rowspan="3" style="width: 130px; vertical-align: middle">TGL/JAM</th>
                <th colspan="5" class="text-center">INTAKE / MASUK</th>
                <th colspan="3" class="text-center">OUTPUT / KELUAR</th>
                <th rowspan="3" style="width: 150px; vertical-align: middle">NAMA<br/>PERAWAT</th>
                <th rowspan="3" style="width: 80px; vertical-align: middle">AKSI</th>
              </tr>
              <tr>
                <th colspan="2" class="text-center bg-intake">INTRAVENOUS</th>
                <th colspan="3" class="text-center bg-intake">Mulut / NGT</th>
                <th rowspan="2" class="text-center bg-output" style="vertical-align: middle">Jenis</th>
                <th rowspan="2" class="text-center bg-output" style="vertical-align: middle">Jumlah</th>
                <th rowspan="2" class="text-center bg-output" style="vertical-align: middle">Total</th>
              </tr>
              <tr>
                <th class="bg-intake" style="width: 150px">Jenis<br/>Cairan</th>
                <th class="bg-intake" style="width: 80px">Jumlah</th>
                <th class="bg-intake" style="width: 150px">Jenis<br/>Makanan</th>
                <th class="bg-intake" style="width: 80px">Jumlah</th>
                <th class="bg-intake" style="width: 80px">Total</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(row, index) in form.balance_rows" :key="index">
                <!-- TGL/JAM -->
                <td>
                  <input 
                    type="datetime-local" 
                    v-model="row.tgl_jam" 
                    class="input-table"
                  />
                </td>

                <!-- INTAKE INTRAVENOUS - Jenis Cairan -->
                <td>
                  <input 
                    type="text" 
                    v-model="row.intake_iv_jenis_cairan" 
                    class="input-table"
                    placeholder="RL, NaCl, D5%"
                  />
                </td>

                <!-- INTAKE INTRAVENOUS - Jumlah -->
                <td>
                  <input 
                    type="number" 
                    v-model.number="row.intake_iv_jumlah" 
                    class="input-table text-right"
                    @input="calculateRowTotal(row)"
                    placeholder="0"
                  />
                </td>

                <!-- INTAKE MULUT/NGT - Jenis Makanan -->
                <td>
                  <input 
                    type="text" 
                    v-model="row.intake_oral_jenis_makanan" 
                    class="input-table"
                    placeholder="Air, Susu, Juice"
                  />
                </td>

                <!-- INTAKE MULUT/NGT - Jumlah -->
                <td>
                  <input 
                    type="number" 
                    v-model.number="row.intake_oral_jumlah" 
                    class="input-table text-right"
                    @input="calculateRowTotal(row)"
                    placeholder="0"
                  />
                </td>

                <!-- INTAKE - Total -->
                <td class="bg-light">
                  <input 
                    type="number" 
                    :value="row.intake_total" 
                    class="input-table text-right fw-bold"
                    readonly
                  />
                </td>

                <!-- OUTPUT - Jenis -->
                <td>
                  <select v-model="row.output_jenis" class="input-table">
                    <option value="">-- Pilih --</option>
                    <option value="Urine">Urine</option>
                    <option value="Feses">Feses</option>
                    <option value="Drain">Drain</option>
                    <option value="NGT">NGT</option>
                    <option value="Muntah">Muntah</option>
                    <option value="IWL">IWL</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </td>

                <!-- OUTPUT - Jumlah -->
                <td>
                  <input 
                    type="number" 
                    v-model.number="row.output_jumlah" 
                    class="input-table text-right"
                    @input="calculateRowTotal(row)"
                    placeholder="0"
                  />
                </td>

                <!-- OUTPUT - Total -->
                <td class="bg-light">
                  <input 
                    type="number" 
                    :value="row.output_total" 
                    class="input-table text-right fw-bold"
                    readonly
                  />
                </td>

                <!-- NAMA PERAWAT -->
                <td>
                  <input 
                    type="text" 
                    v-model="row.nama_perawat" 
                    class="input-table"
                    placeholder="Nama Perawat"
                  />
                </td>

                <!-- AKSI -->
                <td class="text-center">
                  <button 
                    @click="deleteRow(index)" 
                    class="btn-delete-row"
                    :disabled="form.balance_rows.length === 1"
                    title="Hapus Baris"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>

              <!-- GRAND TOTAL ROW -->
              <tr class="total-row">
                <td colspan="2" class="text-right fw-bold">GRAND TOTAL:</td>
                <td class="text-right fw-bold bg-intake-total">{{ grandTotal.intake_iv }} ml</td>
                <td class="text-center">-</td>
                <td class="text-right fw-bold bg-intake-total">{{ grandTotal.intake_oral }} ml</td>
                <td class="text-right fw-bold bg-intake-total">{{ grandTotal.total_intake }} ml</td>
                <td class="text-center">-</td>
                <td class="text-right fw-bold bg-output-total">{{ grandTotal.output_jumlah }} ml</td>
                <td class="text-right fw-bold bg-output-total">{{ grandTotal.output_total }} ml</td>
                <td colspan="2"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Summary Balance -->
        <div class="row mt-4">
          <div class="col-md-3">
            <div class="summary-card bg-primary">
              <div class="summary-label">Total Intake</div>
              <div class="summary-value">{{ grandTotal.total_intake }} ml</div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="summary-card bg-danger">
              <div class="summary-label">Total Output</div>
              <div class="summary-value">{{ grandTotal.output_total }} ml</div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="summary-card" :class="balanceClass">
              <div class="summary-label">Balance</div>
              <div class="summary-value">{{ balance >= 0 ? '+' : '' }}{{ balance }} ml</div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="summary-card bg-secondary">
              <div class="summary-label">Status</div>
              <div class="summary-value-sm">{{ balanceStatus }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= CATATAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Catatan Observasi</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <textarea 
              v-model="form.catatan" 
              class="textarea-rme" 
              rows="3"
              placeholder="Observasi kondisi pasien, tanda-tanda edema, dehidrasi, diuresis, dll"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Verifikasi</h5>

        <div class="row">
          <div class="col-md-6 text-center">
            <label class="fw-bold mb-2">Tanda Tangan Perawat Penanggung Jawab</label>
            <VueSignaturePad
              ref="ttd_perawat"
              :options="sigOption"
              class="signature-box-rme mx-auto"
            />
            <button @click="saveSign('ttd_perawat')" class="btn-save mt-2">
              Simpan ✔
            </button>
            <input
              type="text"
              v-model="form.nama_perawat_verifikasi"
              class="input-rme mt-2"
              placeholder="Nama Lengkap & Paraf"
            />
          </div>
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
  name: "FormBalanceCairanHarian",
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
        no_surat:"",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        balance_rows: [
          {
            tgl_jam: "",
            intake_iv_jenis_cairan: "",
            intake_iv_jumlah: 0,
            intake_oral_jenis_makanan: "",
            intake_oral_jumlah: 0,
            intake_total: 0,
            output_jenis: "",
            output_jumlah: 0,
            output_total: 0,
            nama_perawat: ""
          }
        ],
        catatan: "",
        ttd_perawat: "",
        nama_perawat_verifikasi: "",
      }
    };
  },
  computed: {
    isEditMode() {
      return !!this.editUuid;
    },
    
    grandTotal() {
      const totals = {
        intake_iv: 0,
        intake_oral: 0,
        total_intake: 0,
        output_jumlah: 0,
        output_total: 0
      };

      this.form.balance_rows.forEach(row => {
        totals.intake_iv += Number(row.intake_iv_jumlah) || 0;
        totals.intake_oral += Number(row.intake_oral_jumlah) || 0;
        totals.total_intake += Number(row.intake_total) || 0;
        totals.output_jumlah += Number(row.output_jumlah) || 0;
        totals.output_total += Number(row.output_total) || 0;
      });

      return totals;
    },

    balance() {
      return this.grandTotal.total_intake - this.grandTotal.output_total;
    },

    balanceStatus() {
      const bal = this.balance;
      if (bal > 500) return "Positive Balance";
      if (bal >= -500 && bal <= 500) return "Balanced";
      return "Negative Balance";
    },

    balanceClass() {
      const bal = this.balance;
      if (bal > 500) return "bg-success";
      if (bal < -500) return "bg-warning";
      return "bg-info";
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
          this.form.no_surat = `RM 3.1/BCH/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 3.1/BCH/22';
        }
      }
    },

    setDataForm() {
      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_identitas || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }

      // Set default datetime untuk baris pertama
      const now = new Date();
      const datetime = now.toISOString().slice(0, 16);
      this.form.balance_rows[0].tgl_jam = datetime;
    },

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/pasien/lampiran/${this.editUuid}?type=balance_cairan_harian`
        );

        if (response.data.status) {
          const data = response.data.data;
          
          // Populate form data
          Object.keys(this.form).forEach(key => {
            if (key === 'balance_rows' && data.balance_rows) {
              this.form.balance_rows = JSON.parse(data.balance_rows);
            } else if (data[key] !== undefined && key !== 'balance_rows') {
              this.form[key] = data[key];
            }
          });
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit('back');
      }
    },

    calculateRowTotal(row) {
      // Calculate intake total
      row.intake_total = (Number(row.intake_iv_jumlah) || 0) + (Number(row.intake_oral_jumlah) || 0);
      
      // Calculate output total (sama dengan jumlah karena hanya 1 kolom output)
      row.output_total = Number(row.output_jumlah) || 0;
    },

    addRow() {
      const now = new Date();
      const datetime = now.toISOString().slice(0, 16);
      
      this.form.balance_rows.push({
        tgl_jam: datetime,
        intake_iv_jenis_cairan: "",
        intake_iv_jumlah: 0,
        intake_oral_jenis_makanan: "",
        intake_oral_jumlah: 0,
        intake_total: 0,
        output_jenis: "",
        output_jumlah: 0,
        output_total: 0,
        nama_perawat: ""
      });
    },

    deleteRow(index) {
      if (this.form.balance_rows.length > 1) {
        this.form.balance_rows.splice(index, 1);
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
      if (this.form.balance_rows.length === 0) {
        alert("Minimal harus ada 1 baris data!");
        return;
      }

      // Validasi ada data yang diisi
      const hasData = this.form.balance_rows.some(row => 
        row.intake_iv_jumlah > 0 || row.intake_oral_jumlah > 0 || row.output_jumlah > 0
      );

      if (!hasData) {
        alert("Harap isi minimal 1 data balance cairan!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        // Append regular fields
        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          if (key === 'balance_rows') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-balance-cairan-harian",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan balance cairan harian!");
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

/* BALANCE TABLE */
.table-responsive {
  overflow-x: auto;
}

.balance-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.balance-table th {
  background: #2d74b7;
  color: white;
  padding: 8px 4px;
  border: 1px solid #fff;
  font-weight: 600;
  text-align: center;
}

.balance-table td {
  border: 1px solid #ddd;
  padding: 4px;
  vertical-align: middle;
}

.bg-intake {
  background: #d4edda !important;
}

.bg-output {
  background: #f8d7da !important;
}

.bg-intake-total {
  background: #c3e6cb !important;
  font-weight: bold;
}

.bg-output-total {
  background: #f5c6cb !important;
  font-weight: bold;
}

.input-table {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 4px 6px;
  font-size: 13px;
}

.input-table:focus {
  outline: none;
  border-color: #2d74b7;
}

.input-table[readonly] {
  background: #f8f9fa;
  font-weight: 600;
}

.text-right {
  text-align: right;
}

.total-row {
  background: #f8f9fa;
  font-weight: bold;
}

.total-row td {
  padding: 10px 8px;
  font-size: 14px;
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

/* SUMMARY CARDS */
.summary-card {
  padding: 15px;
  border-radius: 6px;
  color: white;
  text-align: center;
}

.summary-label {
  font-size: 13px;
  margin-bottom: 8px;
  opacity: 0.9;
}

.summary-value {
  font-size: 24px;
  font-weight: bold;
}

.summary-value-sm {
  font-size: 16px;
  font-weight: bold;
}

.bg-primary {
  background: #007bff;
}

.bg-success {
  background: #28a745;
}

.bg-danger {
  background: #dc3545;
}

.bg-info {
  background: #17a2b8;
}

.bg-warning {
  background: #ffc107;
  color: #333;
}

.bg-secondary {
  background: #6c757d;
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

.gap-2 {
  gap: 8px;
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

.mt-4 {
  margin-top: 24px;
}

.text-center {
  text-align: center;
}

.fw-bold {
  font-weight: bold;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.text-muted {
  color: #6c757d;
}

@media (max-width: 768px) {
  .col-md-3,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .balance-table {
    font-size: 11px;
  }

  .input-table {
    font-size: 11px;
    padding: 3px 4px;
  }
}
</style>