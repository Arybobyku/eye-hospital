<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">LAPORAN PEMBEDAHAN</h2>
        <h4 class="fw-semibold">RM 2.2/LP/22</h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>
      
        <div class="form-row-3-3">
          <div>
            <label>No. RM :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div>
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
        </div>
      
        <div class="form-row-3-3">
          <div>
            <label>Nama Pasien :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div>
            <label>Tanggal Lahir :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>
      
        <div class="form-row-3-3">
          <div>
            <label>Jenis Kelamin :</label>
            <select v-model="form.jenis_kelamin" class="input-rme" disabled>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= DATA OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Operasi</h5>
        
        <div class="row">
          <div class="col-md-4">
            <label>Ruang Operasi :</label>
            <input type="text" v-model="form.ruang_operasi" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Kamar :</label>
            <input type="text" v-model="form.kamar" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Akut / Terencana :</label>
            <select v-model="form.akut_terencana" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Akut">Akut</option>
              <option value="Terencana">Terencana</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= TIM BEDAH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tim Bedah</h5>
        
        <div class="row">
          <div class="col-md-6">
            <label>Pembedahan :</label>
            <input type="text" v-model="form.pembedahan" class="input-rme" placeholder="Nama Dokter Bedah" />
          </div>
          <div class="col-md-6">
            <label>Ahli Anestesi :</label>
            <input type="text" v-model="form.ahli_anestesi" class="input-rme" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
            <label>Asisten I :</label>
            <input type="text" v-model="form.asisten_1" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Asisten II :</label>
            <input type="text" v-model="form.asisten_2" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Perawat Instrument :</label>
            <input type="text" v-model="form.perawat_instrument" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= JENIS ANESTESI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Jenis Anestesi</h5>
        
        <div class="row">
          <div class="col-md-3">
            <label class="checkbox-item">
              <input type="checkbox" v-model="form.anestesi_umum" />
              Umum
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-item">
              <input type="checkbox" v-model="form.anestesi_bsp" />
              BSP*
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-item">
              <input type="checkbox" v-model="form.anestesi_spinal" />
              Spinal
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-item">
              <input type="checkbox" v-model="form.anestesi_csp" />
              CSP*
            </label>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-3">
            <label class="checkbox-item">
              <input type="checkbox" v-model="form.anestesi_epidural" />
              Epidural
            </label>
          </div>
          <div class="col-md-3">
            <label class="checkbox-item">
              <input type="checkbox" v-model="form.anestesi_lokal" />
              Lokal
            </label>
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA DAN OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa dan Operasi</h5>
        
        <div class="row">
          <div class="col-md-6">
            <label>Diagnosa Pra-Bedah :</label>
            <textarea v-model="form.diagnosa_pra_bedah" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label>Indikasi Operasi :</label>
            <textarea v-model="form.indikasi_operasi" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Diagnosa Pasca-Bedah :</label>
            <textarea v-model="form.diagnosa_pasca_bedah" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label>Jenis Operasi :</label>
            <textarea v-model="form.jenis_operasi" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= DETAIL OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Operasi</h5>
        
        <div class="row">
          <div class="col-md-12">
            <label>Desinfeksi Kulit dengan :</label>
            <input type="text" v-model="form.desinfeksi_kulit" class="input-rme" placeholder="Contoh: Betadine, Alkohol 70%" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>Posisi Penderita :</label>
            <textarea v-model="form.posisi_penderita" class="textarea-rme" rows="2" placeholder="Bila perlu dengan gambar"></textarea>
          </div>
          <div class="col-md-6">
            <label>Macam Sayatan :</label>
            <textarea v-model="form.macam_sayatan" class="textarea-rme" rows="2" placeholder="Bila perlu dengan gambar"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= WAKTU OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Waktu Operasi</h5>
        
        <div class="row">
          <div class="col-md-4">
            <label>Jam Operasi Dimulai :</label>
            <input type="time" v-model="form.jam_operasi_mulai" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jam Operasi Selesai :</label>
            <input type="time" v-model="form.jam_operasi_selesai" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Lama Operasi Berlangsung (menit) :</label>
            <input type="number" v-model="form.lama_operasi" class="input-rme" placeholder="Dalam menit" />
          </div>
        </div>
      </div>

      <!-- ================= BAHAN LABORATORIUM ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Bahan Laboratorium</h5>
        
        <div class="row">
          <div class="col-md-6">
            <label>Jenis Bahan Yang Dikirim ke Laboratorium :</label>
            <textarea v-model="form.jenis_bahan_lab" class="textarea-rme" rows="3"></textarea>
          </div>
          <div class="col-md-6">
            <label>Untuk Pemeriksaan :</label>
            <textarea v-model="form.pemeriksaan_lab" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TEKNIK OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Teknik Operasi dan Temuan Intra-Operasi</h5>
        
        <div class="row">
          <div class="col-md-12">
            <textarea v-model="form.teknik_operasi_temuan" class="textarea-rme" rows="8" placeholder="Jelaskan secara detail teknik operasi dan temuan selama operasi"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= AMHP KHUSUS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Penggunaan AMHP Khusus</h5>
        
        <div class="row">
          <div class="col-md-6">
            <label>Penggunaan AMHP Khusus :</label>
            <div style="display: flex; gap: 20px;">
              <label class="radio-label">
                <input type="radio" v-model="form.amhp_khusus" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.amhp_khusus" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mt-2" v-if="form.amhp_khusus === 'Ya'">
          <div class="col-md-12">
            <label>Jenis dan Jumlah (AMHP Khusus) :</label>
            <textarea v-model="form.jenis_jumlah_amhp" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= KOMPLIKASI INTRA-OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Komplikasi Intra-Operasi</h5>
        
        <div class="row">
          <div class="col-md-6">
            <label>Komplikasi Intra-operasi :</label>
            <div style="display: flex; gap: 20px;">
              <label class="radio-label">
                <input type="radio" v-model="form.komplikasi_intra_operasi" value="Ya" />
                Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.komplikasi_intra_operasi" value="Tidak" />
                Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Perdarahan (cc) :</label>
            <input type="number" v-model="form.perdarahan" class="input-rme" placeholder="Dalam cc" />
          </div>
        </div>

        <div class="row mt-2" v-if="form.komplikasi_intra_operasi === 'Ya'">
          <div class="col-md-12">
            <label>Penjabaran Komplikasi Intra-Operasi :</label>
            <textarea v-model="form.penjabaran_komplikasi" class="textarea-rme" rows="4"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= INSTRUKSI ANESTESI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Instruksi Anestesi</h5>
        
        <div class="row">
          <div class="col-md-12">
            <textarea v-model="form.instruksi_anestesi" class="textarea-rme" rows="4"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= INSTRUKSI PASCA-BEDAH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Instruksi Pasca-Bedah</h5>
        
        <div class="row">
          <div class="col-md-6">
            <label>1. Kontrol nadi/Tensi/pernapasan/suhu :</label>
            <textarea v-model="form.instruksi_kontrol" class="textarea-rme" rows="2"></textarea>
          </div>
          <div class="col-md-6">
            <label>5. Obat-obatan :</label>
            <textarea v-model="form.instruksi_obat" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>2. Puasa :</label>
            <textarea v-model="form.instruksi_puasa" class="textarea-rme" rows="2"></textarea>
          </div>
          <div class="col-md-6">
            <label>6. Ganti Balut :</label>
            <textarea v-model="form.instruksi_ganti_balut" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>3. Drain :</label>
            <textarea v-model="form.instruksi_drain" class="textarea-rme" rows="2"></textarea>
          </div>
          <div class="col-md-6">
            <label>7. Lain-lain :</label>
            <textarea v-model="form.instruksi_lainnya" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-6">
            <label>4. Infus :</label>
            <textarea v-model="form.instruksi_infus" class="textarea-rme" rows="2"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN OPERATOR BEDAH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Operator Bedah</h5>
        
        <div class="text-center">
          <label class="fw-bold mb-2 d-block">Tanda Tangan Operator Bedah</label>
          <VueSignaturePad ref="ttd_operator" :options="sigOption" class="signature-box-rme mx-auto" />
          <button @click="saveSign('ttd_operator')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
          <input type="text" v-model="form.nama_operator_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Operator Bedah" />
          <div class="row mt-2">
            <div class="col-md-12">
              <label>Medan, Tanggal :</label>
              <input type="date" v-model="form.tanggal_ttd_operator" class="input-rme" />
            </div>
          </div>
        </div>
      </div>

      <!-- ================= BUTTON BOTTOM ================= -->
      <div class="action-footer">
        <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
          <span v-if="loadingSubmit">Menyimpan...</span>
          <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
        </button>
<button @click="$emit('back')" class="btn-back">Kembali</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormLaporanPembedahan",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
    isEditMode: {
      type: Boolean,
      default: false,
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
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        
        // Data Operasi
        ruang_operasi: "",
        kamar: "",
        tanggal: "",
        akut_terencana: "",
        
        // Tim Bedah
        pembedahan: "",
        ahli_anestesi: "",
        asisten_1: "",
        asisten_2: "",
        perawat_instrument: "",
        
        // Jenis Anestesi
        anestesi_umum: false,
        anestesi_bsp: false,
        anestesi_spinal: false,
        anestesi_csp: false,
        anestesi_epidural: false,
        anestesi_lokal: false,
        
        // Diagnosa
        diagnosa_pra_bedah: "",
        indikasi_operasi: "",
        diagnosa_pasca_bedah: "",
        jenis_operasi: "",
        
        // Detail Operasi
        desinfeksi_kulit: "",
        posisi_penderita: "",
        macam_sayatan: "",
        
        // Waktu
        jam_operasi_mulai: "",
        jam_operasi_selesai: "",
        lama_operasi: "",
        
        // Laboratorium
        jenis_bahan_lab: "",
        pemeriksaan_lab: "",
        
        // Teknik Operasi
        teknik_operasi_temuan: "",
        
        // AMHP
        amhp_khusus: "Tidak",
        jenis_jumlah_amhp: "",
        
        // Komplikasi
        komplikasi_intra_operasi: "Tidak",
        penjabaran_komplikasi: "",
        perdarahan: "",
        
        // Instruksi
        instruksi_anestesi: "",
        instruksi_kontrol: "",
        instruksi_puasa: "",
        instruksi_drain: "",
        instruksi_infus: "",
        instruksi_obat: "",
        instruksi_ganti_balut: "",
        instruksi_lainnya: "",
        
        // TTD
        ttd_operator: "",
        nama_operator_ttd: "",
        tanggal_ttd_operator: "",
      },
    };
  },
  mounted() {
    if (this.isEditMode && this.editData) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },
  methods: {
    async loadDataForEdit() {
      try {
        if (this.editData.uuid) {
          const response = await axios.get(
            `/master/pasien/dokumen-laporan-pembedahan/${this.editData.uuid}`
          );

          if (response.data.status) {
            Object.keys(this.form).forEach((key) => {
              if (response.data.data[key] !== undefined) {
                this.form[key] = response.data.data[key];
              }
            });
          }
        }
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];
      this.form.tanggal_ttd_operator = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
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
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key]);
        });

        const response = await axios.post(
          "/master/pasien/dokumen-laporan-pembedahan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
}

.form-row-3-3 {
  display: flex;
  gap: 1rem;
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem;
}

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

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
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

.textarea-rme:focus {
  outline: none;
  border-color: #2d74b7;
  background: white;
}

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 5px;
  margin: 0;
  cursor: pointer;
}

.radio-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
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

.btn-save:hover {
  background: #1565c0;
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

.btn-save-form:hover {
  background: #0277bd;
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

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ccc;
  cursor: not-allowed;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  font-size: 14px;
  color: #333;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-3, .col-md-4, .col-md-6, .col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
  margin-bottom: 8px;
}

.col-md-3 { flex: 0 0 25%; max-width: 25%; }
.col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
.col-md-6 { flex: 0 0 50%; max-width: 50%; }
.col-md-12 { flex: 0 0 100%; max-width: 100%; }

.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 16px; }
.mb-4 { margin-bottom: 24px; }
.mt-2 { margin-top: 8px; }

.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mx-auto { margin-left: auto; margin-right: auto; }
.d-block { display: block; }


@media (max-width: 768px) {
  .form-row-3-3,
  .form-row-2 {
    flex-direction: column;
  }
}
</style>