<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div v-if="disabledSubmit" class="view-overlay"></div>
    <div class="text-center mb-4">
      <h3 class="fw-bold">RESUME MEDIS RAWAT INAP</h3>
      <p class="text-muted">RM 3.5/RM/22</p>
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

    <!-- INFORMASI RAWAT INAP -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Rawat Inap</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Tanggal Masuk</label>
          <input type="date" v-model="form.tanggal_masuk" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Tanggal Keluar / Meninggal</label>
          <input type="date" v-model="form.tanggal_keluar" class="input-rme" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Ruang Rawat Terakhir</label>
          <input v-model="form.ruang_rawat" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Penanggung Pembayaran</label>
          <input v-model="form.penanggung_pembayaran" class="input-rme" />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>Dokter Penanggung Jawab (DPJP)</label>
          <input v-model="form.dpjp" class="input-rme" placeholder="dr. ..." />
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-12">
          <label class="d-flex align-items-center">
            <span class="me-3">Rawat Tim Dokter:</span>
            <label class="me-3">
              <input type="radio" v-model="form.rawat_tim" value="tidak" class="me-1" />
              Tidak
            </label>
            <label>
              <input type="radio" v-model="form.rawat_tim" value="ya" class="me-1" />
              Ya
            </label>
          </label>
        </div>
      </div>

      <div v-if="form.rawat_tim === 'ya'" class="row">
        <div class="col-md-6 mb-2">
          <label>1. dr.</label>
          <input v-model="form.tim_dokter_1" class="input-rme" />
        </div>
        <div class="col-md-6 mb-2">
          <label>2. dr.</label>
          <input v-model="form.tim_dokter_2" class="input-rme" />
        </div>
        <div class="col-md-6 mb-2">
          <label>3. dr.</label>
          <input v-model="form.tim_dokter_3" class="input-rme" />
        </div>
        <div class="col-md-6 mb-2">
          <label>4. dr.</label>
          <input v-model="form.tim_dokter_4" class="input-rme" />
        </div>
      </div>
    </div>

    <!-- DIAGNOSIS & KLINIS -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Data Klinis</h5>

      <label>Alasan Dirawat</label>
      <textarea v-model="form.alasan_dirawat" class="textarea-rme"></textarea>

      <label>Didiagnosa Masuk</label>
      <textarea v-model="form.diagnosa_masuk" class="textarea-rme"></textarea>

      <div class="row mb-3">
        <div class="col-md-9">
          <label>Didiagnosa Keluar (Diagnosa Utama)</label>
          <textarea v-model="form.diagnosa_keluar" class="textarea-rme"></textarea>
        </div>
        <div class="col-md-3">
          <label>ICD</label>
          <input v-model="form.icd_utama" class="input-rme" />
        </div>
      </div>

      <label>Diagnosis Sekunder</label>
      <div class="row mb-2">
        <div class="col-md-12">
          <input v-model="form.diagnosa_sekunder_1" class="input-rme mb-2" placeholder="1. ..." />
          <input v-model="form.diagnosa_sekunder_2" class="input-rme mb-2" placeholder="2. ..." />
          <input v-model="form.diagnosa_sekunder_3" class="input-rme mb-2" placeholder="3. ..." />
          <input v-model="form.diagnosa_sekunder_4" class="input-rme mb-2" placeholder="4. ..." />
        </div>
      </div>

      <label>Penyebab Kematian (Secara Klinis)</label>
      <textarea v-model="form.penyebab_kematian" class="textarea-rme"></textarea>

      <label>Pemeriksaan Fisik Yang Penting</label>
      <textarea v-model="form.pemeriksaan_fisik" class="textarea-rme"></textarea>

      <label>Laboratorium Yang Penting</label>
      <textarea v-model="form.laboratorium" class="textarea-rme"></textarea>

      <label>Radiologi</label>
      <textarea v-model="form.radiologi" class="textarea-rme"></textarea>

      <label>Penunjang Lain</label>
      <textarea v-model="form.penunjang_lain" class="textarea-rme"></textarea>

      <div class="row">
        <div class="col-md-9">
          <label>Tindakan / Operasi</label>
          <textarea v-model="form.tindakan_operasi" class="textarea-rme"></textarea>
        </div>
        <div class="col-md-3">
          <label>ICD</label>
          <input v-model="form.icd_tindakan" class="input-rme" />
        </div>
      </div>

      <label>Pengobatan Selama Dirawat</label>
      <textarea v-model="form.pengobatan" class="textarea-rme"></textarea>
    </div>

    <!-- KONDISI PULANG -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Kondisi Pulang</h5>

      <div class="row">
        <div class="col-md-12">
          <label class="me-3">
            <input type="checkbox" v-model="form.kondisi_sembuh" class="me-1" />
            Sembuh
          </label>
          <label class="me-3">
            <input type="checkbox" v-model="form.kondisi_pindah_rs" class="me-1" />
            Pindah RS
          </label>
          <label class="me-3">
            <input type="checkbox" v-model="form.kondisi_pulang_sendiri" class="me-1" />
            Pulang atas Permintaan Sendiri
          </label>
          <label class="me-3">
            <input type="checkbox" v-model="form.kondisi_meninggal" class="me-1" />
            Meninggal
          </label>
          <label>
            <input type="checkbox" v-model="form.kondisi_lainnya" class="me-1" />
            Lain-Lain
          </label>
        </div>
      </div>
    </div>

    <!-- INSTRUKSI & EDUKASI LANJUTAN -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Instruksi dan Edukasi Lanjutan (Follow Up)</h5>

      <div class="row mb-3">
        <div class="col-md-4">
          <label>Kontrol Tanggal</label>
          <input type="date" v-model="form.kontrol_tanggal" class="input-rme" />
        </div>
        <div class="col-md-4">
          <label>Diet</label>
          <input v-model="form.diet" class="input-rme" />
        </div>
        <div class="col-md-4">
          <label>Latihan</label>
          <input v-model="form.latihan" class="input-rme" />
        </div>
      </div>

      <label>Segera kembali ke Rumah Sakit, langsung ke Gawat Darurat, bila terjadi:</label>
      <textarea v-model="form.kondisi_darurat" class="textarea-rme"></textarea>
    </div>

    <!-- TERAPI PULANG -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Terapi Pulang</h5>

      <table class="therapy-table">
        <thead>
          <tr>
            <th style="width: 25%">Nama Obat</th>
            <th style="width: 10%">Jumlah</th>
            <th style="width: 15%">Dosis</th>
            <th style="width: 15%">Frekuensi</th>
            <th style="width: 20%">Cara Pemberian</th>
            <th style="width: 15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(obat, idx) in form.terapi_pulang" :key="idx">
            <td><input v-model="obat.nama_obat" class="input-table" /></td>
            <td><input v-model="obat.jumlah" class="input-table" /></td>
            <td><input v-model="obat.dosis" class="input-table" /></td>
            <td><input v-model="obat.frekuensi" class="input-table" /></td>
            <td><input v-model="obat.cara_pemberian" class="input-table" /></td>
            <td class="text-center">
              <button @click="removeObat(idx)" class="btn-remove">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>

      <button @click="addObat" class="btn-add mt-2">+ Tambah Obat</button>
    </div>

    <!-- TANDA TANGAN -->
    <div class="box-rme">
      <h5 class="section-title-rme">Yang Membuat</h5>

      <div class="tanggal-tempat mb-3">BEKASI, {{ currentDate }} WIB</div>

      <label>Tanda Tangan Dokter</label>
      <VueSignaturePad
        ref="dokter_ttd"
        :options="sigOption"
        class="signature-box-rme"
      />
      <button class="btn-save" @click="saveSign('dokter_ttd')">Simpan ✔</button>
      <button class="btn-clear" @click="clearSign('dokter_ttd')">
        Clear ✖
      </button>

      <label>Nama Jelas Dokter</label>
      <input v-model="form.nama_dokter" class="input-rme" placeholder="Nama Jelas dan Tanda Tangan" />
    </div>
  </div>

  <!-- FOOTER ACTIONS -->
  <div class="action-footer">
    <button  v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loading">
      {{ loading ? "Menyimpan..." : "Save" }}
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loading">Back</button>
  </div>
</template>

<script>
  import axios from "axios";
  
  export default {
    name: "ResumeMedisRawatInap",
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
        editUuid: "",
        sigOption: { penColor: "black", backgroundColor: "white" },
        form: {
          uuid: "",
          uuid_pasien: "",
          nama: "",
          tanggal_lahir: "",
          jenis_kelamin: "",
          no_rm: "",
          nik: "",
          tanggal_masuk: "",
          tanggal_keluar: "",
          ruang_rawat: "",
          penanggung_pembayaran: "",
          dpjp: "",
          rawat_tim: "tidak",
          tim_dokter_1: "",
          tim_dokter_2: "",
          tim_dokter_3: "",
          tim_dokter_4: "",
          alasan_dirawat: "",
          diagnosa_masuk: "",
          diagnosa_keluar: "",
          icd_utama: "",
          diagnosa_sekunder_1: "",
          diagnosa_sekunder_2: "",
          diagnosa_sekunder_3: "",
          diagnosa_sekunder_4: "",
          penyebab_kematian: "",
          pemeriksaan_fisik: "",
          laboratorium: "",
          radiologi: "",
          penunjang_lain: "",
          tindakan_operasi: "",
          icd_tindakan: "",
          pengobatan: "",
          kondisi_sembuh: false,
          kondisi_pindah_rs: false,
          kondisi_pulang_sendiri: false,
          kondisi_meninggal: false,
          kondisi_lainnya: false,
          kontrol_tanggal: "",
          diet: "",
          latihan: "",
          kondisi_darurat: "",
          terapi_pulang: [
            { nama_obat: "", jumlah: "", dosis: "", frekuensi: "", cara_pemberian: "" }
          ],
          dokter_ttd: "",
          nama_dokter: "",
        },
      };
    },
    computed: {
      isEditMode() {
        // return !!this.editUuid;
      },
      currentDate() {
        const d = new Date();
        return d.toLocaleDateString("id-ID", { 
          day: "numeric", 
          month: "long", 
          year: "numeric" 
        });
      }
    },
    mounted() {
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
            `/master/rekammedis/lampiran/${this.editUuid}?type=resume_medis_rawat_inap`
          );
  
          if (response.data.status) {
            const data = response.data.data;
            
            Object.keys(this.form).forEach(key => {
              if (key === 'terapi_pulang' && data.terapi_pulang) {
                // Parse JSON string ke array
                this.form.terapi_pulang = typeof data.terapi_pulang === 'string' 
                  ? JSON.parse(data.terapi_pulang) 
                  : data.terapi_pulang;
              } else if (data[key] !== undefined && key !== 'terapi_pulang') {
                this.form[key] = data[key];
              }
            });
            this.$nextTick(() => {
              if (this.form.dokter_ttd && this.$refs.dokter_ttd) {
                this.$refs.dokter_ttd.fromDataURL(this.form.dokter_ttd);
              }
            });
          }
        } catch (error) {
          console.error("Error loading data:", error);
          alert("Gagal memuat data untuk edit!");
          this.$emit('back');
        }
      },
  
      addObat() {
        this.form.terapi_pulang.push({
          nama_obat: "",
          jumlah: "",
          dosis: "",
          frekuensi: "",
          cara_pemberian: ""
        });
      },
  
      removeObat(idx) {
        if (this.form.terapi_pulang.length > 1) {
          this.form.terapi_pulang.splice(idx, 1);
        }
      },
  
      saveSign(ref) {
        const pad = this.$refs[ref];
        if (!pad) {
          console.error("REF tidak ditemukan:", ref);
          return;
        }
        const { data } = pad.saveSignature();
        this.form.dokter_ttd = data; // Simpan ke field dokter_ttd
        alert("Tanda Tangan Berhasil Disimpan Silahkan Lanjut Menyimpan Data");
        console.log("TTD saved:", ref);
      },
  
      clearSign(ref) {
        const pad = this.$refs[ref];
        if (!pad) return;
  
        pad.clearSignature();
        this.form.dokter_ttd = ""; // Reset field dokter_ttd
        console.log("TTD cleared");
      },
  
      async submitForm() {
        this.loading = true;
        try {
          const fd = new FormData();
          
          Object.keys(this.form).forEach((k) => {
            // Skip uuid jika kosong (create mode)
            if (k === 'uuid' && !this.form[k]) {
              return;
            }
            
            if (k === "terapi_pulang") {
              // Convert array to JSON string
              fd.append(k, JSON.stringify(this.form[k]));
            } else {
              fd.append(k, this.form[k] || '');
            }
          });
  
          const response = await axios.post(
            "/master/pasien/dokumen-resume-medis-rawat-inap", 
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
  background: #f4f4f4;
}
.textarea-rme {
  min-height: 90px;
}
.signature-box-rme {
  width: 100%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
}
.btn-save {
  background: #1e88e5;
  color: #fff;
  padding: 6px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-bottom: 10px;
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
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.btn-back {
  background: #ff9800;
  color: white;
  padding: 8px 18px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}
.tanggal-tempat {
  font-weight: bold;
  margin: 10px 0;
}

/* THERAPY TABLE */
.therapy-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.therapy-table th,
.therapy-table td {
  border: 1px solid #ccc;
  padding: 8px;
}
.therapy-table th {
  background: #f0f0f0;
  font-weight: bold;
  text-align: left;
}
.input-table {
  width: 100%;
  border: 1px solid #ccc;
  padding: 4px;
  border-radius: 3px;
}
.btn-add {
  background: #4caf50;
  color: white;
  padding: 6px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-remove {
  background: #f44336;
  color: white;
  padding: 4px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}
.btn-clear {
  background: #e53935;
  color: #fff;
  padding: 6px 14px;
  border: none;
  margin-left: 8px;
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