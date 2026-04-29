<style scoped>
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

<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div v-if="disabledSubmit" class="view-overlay"></div>

    <div class="text-center mb-4">
      <h3 class="fw-bold">RESUME MEDIS RAWAT JALAN</h3>
      <h4 class="fw-semibold">{{ form.no_surat}} </h4>
    </div>
    <!-- IDENTITAS PASIEN -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Identitas Pasien</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Nama</label>
          <input v-model="form.nama" class="input-rme" readonly />
        </div>
        <div class="col-md-6">
          <label>Tanggal Lahir</label>
          <input v-model="form.tanggal_lahir" class="input-rme" readonly />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label>No. RM</label>
          <input v-model="form.no_rm" class="input-rme" readonly />
        </div>
        <div class="col-md-4">
          <label>NIK</label>
          <input v-model="form.nik" class="input-rme" readonly />
        </div>
        <div class="col-md-4">
          <label>Jenis Kelamin</label>
          <input v-model="form.jenis_kelamin" class="input-rme" readonly />
        </div>
      </div>
    </div>

    <!-- INFORMASI KUNJUNGAN -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Kunjungan</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Tanggal Berobat</label>
          <input type="date" v-model="form.tanggal_berobat" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Dokter yang Merawat</label>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.dokter" class="form-select-dokter">
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
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label>Ruang Poli</label>
          <input v-model="form.poli" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Penanggung Pembayaran</label>
          <div class="dropdown-dokter">
        <select v-model="form.penanggung" class="form-select-dokter">
        <option value="" disabled>Pilih Penanggung</option>
        <option
         v-for="item in listPenanggung"
        :key="item"
        :value="item"
        >
        {{ item }}
        </option>
        </select>
        <span class="dropdown-icon">▾</span>
      </div>
        </div>
      </div>
    </div>

    <!-- KLINIS -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Data Klinis</h5>

      <label>Anamnese</label>
      <textarea v-model="form.anamnese" class="textarea-rme"></textarea>

      <label>Pemeriksaan Fisik</label>
      <textarea v-model="form.pemeriksaan_fisik" class="textarea-rme"></textarea>

      <label>Alergi Obat</label>
      <textarea v-model="form.alergi_obat" class="textarea-rme"></textarea>

      <label>Hasil Penunjang Medis</label>
      <textarea v-model="form.penunjang_medis" class="textarea-rme"></textarea>

      <label>Diagnosa</label>
      <textarea v-model="form.diagnosa" class="textarea-rme"></textarea>

      <label>Tindakan</label>
      <textarea v-model="form.tindakan" class="textarea-rme"></textarea>

      <label>Terapi</label>
      <textarea v-model="form.terapi" class="textarea-rme"></textarea>

      <label>Riwayat Rawat Inap / Operasi</label>
      <textarea v-model="form.riwayat" class="textarea-rme"></textarea>

      <label>Instruksi / Edukasi Lanjutan</label>
      <textarea v-model="form.edukasi" class="textarea-rme"></textarea>
    </div>

    <!-- KONTROL & TTD -->
    <div class="box-rme">
      <h5 class="section-title-rme">Penutup</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Kontrol Tanggal</label>
          <input type="date" v-model="form.tanggal_kontrol" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Di</label>
          <input v-model="form.tempat_kontrol" class="input-rme" />
        </div>
      </div>

      <label class="fw-bold mb-2">Dokter yang Memeriksa</label>
            <div v-if="form.ttd_dokter && !ttdDokterCleared" class="signature-preview text-center">
              <img :src="form.ttd_dokter" alt="TTD Perawat Ruangan" class="img-signature" />
              <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button>
            </div>
      <div class="dropdown-dokter mt-2">
        <select v-model="form.nama_dokter" class="form-select-dokter">
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
    </div>
  </div>

  <div class="action-footer">
    <button  v-if="!disabledSubmit"  class="btn-save-form" @click="submitForm" :disabled="loading">
      {{ loading ? "Menyimpan..." : "Save" }}
    </button>

    <button class="btn-back" @click="$emit('back')">Back</button>
  </div>
</template>

<script>
  import axios from "axios";
  
  export default {
    name: "ResumeMedisRawatJalan",
    props: {
      selectedPatient: { 
        type: Object, 
        required: true 
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
        loading: false,
        disabledSubmit: false,
        ttdDokterCleared: false,
        editUuid: "",
        sigOption: { 
          penColor: "black", 
          backgroundColor: "white" 
        },
                listPenanggung: [
      "BPJS Kesehatan",
      "BPJS TK",
      "Umum",
      "Asuransi",
      "Lain-lain",
    ],
        form: {
          uuid: "",
          uuid_pasien: "",
          nama: "",
          tanggal_lahir: "",
          jenis_kelamin: "",
          no_rm: "",
          no_surat: "",
          nik: "",
          tanggal_berobat: "",
          dokter: "",
          poli: "",
          penanggung: "",
          anamnese: "",
          pemeriksaan_fisik: "",
          alergi_obat: "",
          penunjang_medis: "",
          diagnosa: "",
          tindakan: "",
          terapi: "",
          riwayat: "",
          edukasi: "",
          tanggal_kontrol: "",
          tempat_kontrol: "",
          ttd_dokter: "",
          nama_dokter: "",
        },
      };
    },
    computed: {
      isEditMode() {
        // return !!this.editUuid;
      }
    },
    async mounted() {
    await this.fetchDokter();
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
        this.setDataPasien();
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
            this.form.no_surat = `RM 1.7/RMRJ/${tahun}`;
          }

          console.log("✅ Tahun akreditasi:", tahun);
          console.log("✅ No surat:", this.form.no_surat);
        } catch (error) {
          console.error("❌ Error fetch tahun:", error);
          if (!this.form.no_surat) {
            this.form.no_surat = 'RM 1.7/RMRJ/22';
          }
        }
      },

      setDataPasien() {
        const p = this.selectedPatient;
        this.form.uuid_pasien = p?.uuid;
        this.form.nama = p?.nama;
        this.form.tanggal_lahir = p?.tanggal_lahir;
        this.form.no_rm = p?.rekam_medis;
        this.form.nik = p?.no_ktp;
        this.form.jenis_kelamin = p?.jenis_kelamin;
      },
  
      async loadDataForEdit() {
        try {
          const response = await axios.get(
            `/master/rekammedis/lampiran/${this.editUuid}?type=resume_medis_rawat_jalan`
          );
  
          if (response.data.status) {
            const data = response.data.data;
            
            // Map semua field ke form
            Object.keys(this.form).forEach(key => {
              if (data[key] !== undefined) {
                this.form[key] = data[key];
              }
            });
                  // ⬇️ PENTING: load ulang tanda tangan
      this.$nextTick(() => {
        if (this.form.ttd_dokter && this.$refs.ttd_dokter) {
          this.$refs.ttd_dokter.fromDataURL(this.form.ttd_dokter);
        }
        const flagMap = {
          ttd_dokter: 'ttdDokterCleared',
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
        ttd_dokter: 'ttdDokterCleared',
      };
    
      if (flagMap[refName] !== undefined) {
        this[flagMap[refName]] = false;
      }
    
      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },
    
    clearSign(refName) {
      const flagMap = {
        ttd_dokter: 'ttdDokterCleared',
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
        this.loading = true;
        try {
          const fd = new FormData();
          
          Object.keys(this.form).forEach((k) => {
            // Skip uuid jika kosong (untuk create mode)
            if (k === 'uuid' && !this.form[k]) {
              return;
            }
            fd.append(k, this.form[k] || '');
          });
  
          const response = await axios.post(
            "/master/pasien/dokumen-resume-medis-rawat-jalan", 
            fd,
            { headers: { "Content-Type": "multipart/form-data" } }
          );
  
          if (response.data.status) {
            alert(response.data.message || "Data berhasil disimpan");
            this.$emit("back");
          }
        } catch (e) {
          console.error("Error:", e.response?.data || e);
          alert("Gagal menyimpan data");
        } finally {
          this.loading = false;
        }
      },
    },
  };
  </script>

<style scoped>
.box-rme {
  border: 1px solid #ddd;
  padding: 20px;
  border-radius: 6px;
  margin-bottom: 20px;
}
.section-title-rme {
  font-weight: bold;
  color: #2d74b7;
  margin-bottom: 10px;
}
.input-rme,
.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  padding: 6px;
  border-radius: 4px;
  margin-bottom: 10px;
}
.textarea-rme {
  min-height: 90px;
}
.signature-box-rme {
  width: 120%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
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
.text-center {
  text-align: center;
}
.btn-save {
  background: #1e88e5;
  color: #fff;
  padding: 6px 14px;
  border: none;
}
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
  padding: 8px 18px;
  border: none;
}
.btn-back {
  background: #ff9800;
  color: white;
  padding: 8px 18px;
  border: none;
}
.btn-clear {
  background: #e53935;
  color: #fff;
  padding: 6px 14px;
  border: none;
  margin-left: 8px;
}


.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
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
</style>
