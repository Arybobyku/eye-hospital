<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">MONITORING EFEK SAMPING OBAT</h2>
        <h4 class="fw-semibold">{{ form.no_surat}} </h4>
      </div>

      <!-- ================= A. IDENTITAS PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">A. Identitas</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>1. Nama :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>2. Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>3. No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>4. Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" step="0.1" />
          </div>
          <div class="col-md-4">
            <label>Berat Badan (Kg) :</label>
            <input type="number" v-model="form.berat_badan" class="input-rme" step="0.1" />
          </div>
          <div class="col-md-4">
            <label>Tinggi Badan (Cm) :</label>
            <input type="number" v-model="form.tinggi_badan" class="input-rme" step="0.1" />
          </div>
        </div>
      </div>

      <!-- ================= B. KELUHAN UTAMA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">B. Keluhan Utama</h5>
        <textarea 
          v-model="form.keluhan_utama" 
          class="textarea-rme" 
          rows="4"
          placeholder="Tuliskan keluhan utama pasien..."
        ></textarea>
      </div>

      <!-- ================= C. SEJARAH PENYAKIT SAAT INI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">C. Sejarah Penyakit yang diderita saat ini</h5>
        <textarea 
          v-model="form.sejarah_penyakit_sekarang" 
          class="textarea-rme" 
          rows="4"
          placeholder="Tuliskan penyakit yang sedang diderita saat ini..."
        ></textarea>
      </div>

      <!-- ================= D. SEJARAH MEDIS TERDAHULU ================= -->
      <div class="box-rme mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="section-title-rme mb-0">D. Sejarah Medis Terdahulu</h5>
          <button @click="addMedisRow" class="btn-add-row">
            <i class="fas fa-plus"></i> Tambah Riwayat
          </button>
        </div>

        <div class="table-responsive">
          <table class="resume-table">
            <thead>
              <tr>
                <th style="width: 30%">Penyakit</th>
                <th style="width: 20%">Onset</th>
                <th style="width: 20%">Membaik/Sembuh</th>
                <th style="width: 25%">Resep</th>
                <th style="width: 80px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, index) in form.sejarah_medis_rows" :key="index">
                <td>
                  <input 
                    type="text" 
                    v-model="row.penyakit" 
                    class="input-table"
                    placeholder="Nama penyakit"
                  />
                </td>
                <td>
                  <input 
                    type="text" 
                    v-model="row.onset" 
                    class="input-table"
                    placeholder="Kapan mulai"
                  />
                </td>
                <td>
                  <input 
                    type="text" 
                    v-model="row.membaik_sembuh" 
                    class="input-table"
                    placeholder="Status"
                  />
                </td>
                <td>
                  <input 
                    type="text" 
                    v-model="row.resep" 
                    class="input-table"
                    placeholder="Resep obat"
                  />
                </td>
                <td class="text-center">
                  <button 
                    @click="deleteMedisRow(index)" 
                    class="btn-delete-row"
                    :disabled="form.sejarah_medis_rows.length === 1"
                    title="Hapus Baris"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ================= E. SEJARAH ALERGI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">E. Sejarah Alergi</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label class="fw-bold mb-2">Apakah memiliki alergi?</label>
            <div class="radio-group">
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_status" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_status" value="Tidak" />
                Tidak
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_status" value="Tidak diketahui" />
                Tidak diketahui
              </label>
            </div>
          </div>
        </div>

        <div class="row" v-if="form.alergi_status === 'Ya'">
          <div class="col-md-12">
            <label class="fw-bold mb-2">Tipe:</label>
            <div class="radio-group">
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_tipe" value="Ringan" />
                Ringan
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_tipe" value="Sedang" />
                Sedang
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.alergi_tipe" value="Berat" />
                Berat
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= F. SEJARAH SOSIAL ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">F. Sejarah Sosial</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Merokok :</label>
            <select v-model="form.merokok" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Alkohol :</label>
            <select v-model="form.alkohol" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= G. SEJARAH OBAT ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">G. Sejarah Obat</h5>

        <!-- G.1 Obat Resep -->
        <div class="mb-4">
          <label class="fw-bold">1. Apakah pasien saat ini atau dalam waktu 3 bulan terakhir mengkonsumsi obat resep?</label>
          <p class="small text-muted mb-2">Bila ya, sebutkan dan jelaskan (Nama obat, Dosis, Cara, Lama pemakaian dan Kegunaan)</p>
          <textarea 
            v-model="form.obat_resep" 
            class="textarea-rme" 
            rows="4"
            placeholder="Contoh: Paracetamol 500mg, 3x1 tablet, oral, 5 hari, untuk menurunkan demam"
          ></textarea>
        </div>

        <!-- G.2 Obat Bebas -->
        <div class="mb-4">
          <label class="fw-bold">2. Apakah pasien saat ini mengkonsumsi obat bebas?</label>
          <p class="small text-muted mb-2">Bila ya, sebutkan (Nama obat, Dosis, Cara, Lama pemakaian dan kegunaan)</p>
          <textarea 
            v-model="form.obat_bebas" 
            class="textarea-rme" 
            rows="4"
            placeholder="Contoh: Antangin 1 sachet, diminum saat masuk angin"
          ></textarea>
        </div>

        <!-- G.3 Penilaian -->
        <div class="mb-3">
          <label class="fw-bold mb-2">3. Penilaian sejarah obat:</label>
          <div class="checkbox-group">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.penilaian_ketidakpatuhan" />
              Ketidakpatuhan pasien
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.penilaian_pengetahuan_kurang" />
              Pengetahuan tentang obat kurang
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.penilaian_cara_salah" />
              Cara menggunakan obat tidak benar
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.penilaian_komunikasi_kurang" />
              Komunikasi kurang cukup dengan profesi kesehatan lainnya
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.penilaian_efek_samping" />
              Reaksi efek samping obat
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.penilaian_masalah_lain" />
              Masalah berhubungan dengan obat lainnya
            </label>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Verifikasi</h5>

        <div class="row">
          <div class="col-md-6 text-center">
            <label class="fw-bold mb-2">Profesi:</label>
            <select v-model="form.profesi_ttd" class="input-rme mb-3">
              <option value="">-- Pilih Profesi --</option>
              <option value="Dokter">Dokter</option>
              <option value="Perawat">Perawat</option>
            </select>

            <label class="fw-bold mb-2">Tanda Tangan</label>
            <div v-if="form.ttd_petugas && !ttdPetugasCleared" class="signature-preview text-center">
              <img :src="form.ttd_petugas" alt="TTD Petugas" class="img-signature" />
              <button @click="clearSign('ttd_petugas')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_petugas" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_petugas')" class="btn-save mt-2">Simpan ✔</button>
            </div>
            <input
              type="text"
              v-model="form.nama_petugas"
              class="input-rme mt-2"
              placeholder="Nama Lengkap"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button  v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
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
  name: "FormMonitoringEfekSampingObat",
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
      ttdPetugasCleared: false,
      editUuid: "",
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
        berat_badan: "",
        tinggi_badan: "",
        keluhan_utama: "",
        sejarah_penyakit_sekarang: "",
        sejarah_medis_rows: [
          {
            penyakit: "",
            onset: "",
            membaik_sembuh: "",
            resep: ""
          }
        ],
        alergi_status: "",
        alergi_tipe: "",
        merokok: "",
        alkohol: "",
        obat_resep: "",
        obat_bebas: "",
        penilaian_ketidakpatuhan: false,
        penilaian_pengetahuan_kurang: false,
        penilaian_cara_salah: false,
        penilaian_komunikasi_kurang: false,
        penilaian_efek_samping: false,
        penilaian_masalah_lain: false,
        profesi_ttd: "",
        ttd_petugas: "",
        nama_petugas: ""
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
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';

        if (!this.form.no_surat) {
          this.form.no_surat = `RM 3.8/MESO/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 3.8/MESO/22';
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
    },

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/rekammedis/lampiran/${this.editUuid}?type=monitoring_efek_samping_obat`
        );

        if (response.data.status) {
          const data = response.data.data;
          
          Object.keys(this.form).forEach(key => {
            if (key === 'sejarah_medis_rows' && data.sejarah_medis_rows) {
              this.form.sejarah_medis_rows = JSON.parse(data.sejarah_medis_rows);
            } else if (data[key] !== undefined && key !== 'sejarah_medis_rows') {
              this.form[key] = data[key];
            }
          });
                            // ⬇️ PENTING: load ulang tanda tangan
      this.$nextTick(() => {
        if (this.form.ttd_petugas && this.$refs.ttd_petugas) {
          this.$refs.ttd_petugas.fromDataURL(this.form.ttd_petugas);
        }
              const flagMap = {
                ttd_petugas: 'ttdPetugasCleared',
              };
            
              Object.keys(flagMap).forEach(refName => {
                if (this.form[refName]) {
                  this[flagMap[refName]] = false;
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

    addMedisRow() {
      this.form.sejarah_medis_rows.push({
        penyakit: "",
        onset: "",
        membaik_sembuh: "",
        resep: ""
      });
    },

    deleteMedisRow(index) {
      if (this.form.sejarah_medis_rows.length > 1) {
        this.form.sejarah_medis_rows.splice(index, 1);
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }
    
      const { isEmpty, data } = pad.saveSignature();
    
      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }
    
      const flagMap = {
        ttd_petugas: 'ttdPetugasCleared',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = false;
      }
    
      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },
    
    clearSign(refName) {
      const flagMap = {
        ttd_petugas: 'ttdPetugasCleared',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = true;
        this.form[refName] = "";
      }
    
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    async submitForm() {
      // Validasi dasar
      if (!this.form.berat_badan || !this.form.tinggi_badan) {
        alert("Harap isi Berat Badan dan Tinggi Badan!");
        return;
      }

      if (!this.form.profesi_ttd || !this.form.nama_petugas) {
        alert("Harap pilih profesi dan isi nama petugas yang menandatangani!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          if (key === 'sejarah_medis_rows') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const response = await axios.post(
          "/master/pasien/dokumen-monitoring-efek-samping-obat",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan monitoring efek samping obat!");
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

/* TABLE */
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
  vertical-align: middle;
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

.btn-clear {
  background: #e53935;
  color: #fff;
  padding: 6px 14px;
  border: none;
  margin-left: 8px;
}

/* RADIO & CHECKBOX */
.radio-group,
.checkbox-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.radio-label,
.checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  font-size: 14px;
}

.radio-label input[type="radio"],
.checkbox-label input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
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

/* SIGNATURE */
.signature-box-rme {
  width: 100%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
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

.signature-preview {
  width: 100%;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.img-signature {
  max-width: 100%;
  height: 180px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
  display: block;
  margin: 0 auto;
}

/* RESPONSIVE GRID */
.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-4,
.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
}

.col-md-4 {
  flex: 0 0 33.333%;
  max-width: 33.333%;
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

.fw-bold {
  font-weight: bold;
}
.fw-semibold {
  font-weight: 600;
}

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

.small {
  font-size: 13px;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .resume-table {
    font-size: 11px;
  }

  .input-table {
    font-size: 11px;
    padding: 4px 6px;
  }
}
</style>