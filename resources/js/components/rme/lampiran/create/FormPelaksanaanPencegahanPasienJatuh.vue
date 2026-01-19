<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">PELAKSANAAN PENCEGAHAN PASIEN JATUH</h2>
        <h4 class="fw-semibold">RM 2.9/PPPJ/22</h4>
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
            <input type="text" v-model="form.nik" class="input-rme" />
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
            <select v-model="form.jenis_kelamin" class="input-rme">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>
      </div>

      <!-- ================= DATA PELAKSANAAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Pelaksanaan</h5>
        
        <div class="form-row-2">
          <div>
            <label>Tanggal Pelaksanaan :</label>
            <input type="date" v-model="form.tanggal_pelaksanaan" class="input-rme" />
          </div>
        </div>

        <div class="form-row-2">
          <div>
            <label>Keterangan :</label>
            <textarea v-model="form.keterangan" class="textarea-rme" rows="3" placeholder="Berikan tanda √ pada kolom □ pada tindakan yang dilakukan"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= 1. TINDAKAN BERISIKO JATUH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">1. Tindakan Berisiko Jatuh</h5>
        
        <div class="alert-info">
          <strong>Lakukan Perawatan yang Baik</strong>
        </div>

        <div class="form-row-2">
          <div>
            <label>Catatan Tindakan Berisiko Jatuh :</label>
            <textarea v-model="form.catatan_berisiko_jatuh" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= 2. RISIKO JATUH RENDAH ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">2. Risiko Jatuh Rendah</h5>
        
        <div class="alert-info mb-3">
          <strong>Lakukan intervensi jatuh standar :</strong>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_benda_pribadi" style="margin-top: 3px;" />
            <span>Benda-benda pribadi dalam jangkauan (telepon genggam, bel pasien, air minum, kacamata, dll)</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_roda_terkunci" style="margin-top: 3px;" />
            <span>Roda tempat tidur dalam posisi terkunci</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_posisi_rendah" style="margin-top: 3px;" />
            <span>Posisikan tempat tidur pada posisi rendah</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_pagar_pengaman" style="margin-top: 3px;" />
            <span>Pagar pengaman tempat tidur dinaikkan</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_monitor_berkala" style="margin-top: 3px;" />
            <span>Monitor kebutuhan pasien secara berkala, kunjungi pasien minimal 2 kali dalam 1 shift</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_edukasi" style="margin-top: 3px;" />
            <span>Berikan edukasi untuk mencegah jatuh kepada pasien dan keluarga. Berikan brosur mencegah jatuh jika ada.</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_pintu_lampu" style="margin-top: 3px;" />
            <span>Biarkan pintu terbuka, gunakan lampu pada malam hari</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_alat_bantu" style="margin-top: 3px;" />
            <span>Gunakan alat bantu jalan (walker, handrail)</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.rendah_alas_kaki" style="margin-top: 3px;" />
            <span>Anjurkan pasien menggunakan kaus kaki atau sandal/ sepatu yang tidak licin</span>
          </label>
        </div>
      </div>

      <!-- ================= 3. RISIKO JATUH TINGGI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">3. Risiko Jatuh Tinggi</h5>
        
        <div class="alert-warning mb-3">
          <strong>Lakukan intervensi jatuh tinggi :</strong>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_semua_standar" style="margin-top: 3px;" />
            <span><strong>Lakukan semua intervensi jatuh standar</strong></span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_gelang_kuning" style="margin-top: 3px;" />
            <span>Pasangkan gelang khusus (warna kuning) sebagai tanda risiko pasien jatuh</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_tanda_pintu" style="margin-top: 3px;" />
            <span>Berikan tanda risiko pasien jatuh pada pintu kamar pasien atau pada bed pasien</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_dekat_nurse" style="margin-top: 3px;" />
            <span>Pasien ditempatkan dekat nurse station</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_kunjungi_1jam" style="margin-top: 3px;" />
            <span>Kunjungi dan monitor pasien setiap 1 jam</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_edukasi_obat" style="margin-top: 3px;" />
            <span>Edukasi pasien tentang efek samping obat yang diberikan</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_dampingi_kamar_mandi" style="margin-top: 3px;" />
            <span>Dampingi pasien ke kamar mandi dan tidak meninggalkan pasien di kamar mandi</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_tempat_duduk" style="margin-top: 3px;" />
            <span>Anjurkan menggunakan tempat duduk di kamar mandi saat pasien mandi</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_bel_toilet" style="margin-top: 3px;" />
            <span>Informasikan cara menggunakan bel di toilet untuk memanggil perawat, pintu kamar mandi jangan dikunci</span>
          </label>

          <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
            <input type="checkbox" v-model="form.tinggi_komunikasi_shift" style="margin-top: 3px;" />
            <span>Komunikasikan risiko pasien jatuh pada saat laporan antara shift</span>
          </label>
        </div>
      </div>

      <!-- ================= TANDA TANGAN PETUGAS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Petugas yang Melaksanakan Pencegahan</h5>
        
        <div class="text-center">
          <label class="fw-bold mb-2 d-block">Tanda Tangan Petugas</label>
          <VueSignaturePad ref="ttd_petugas" :options="sigOption" class="signature-box-rme mx-auto" />
          <button @click="saveSign('ttd_petugas')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
          <input type="text" v-model="form.nama_petugas_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Petugas" />
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
  name: "FormPelaksanaanPencegahanPasienJatuh",
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
        
        tanggal_pelaksanaan: "",
        keterangan: "",
        
        // Tindakan Berisiko Jatuh
        catatan_berisiko_jatuh: "",
        
        // Risiko Jatuh Rendah
        rendah_benda_pribadi: false,
        rendah_roda_terkunci: false,
        rendah_posisi_rendah: false,
        rendah_pagar_pengaman: false,
        rendah_monitor_berkala: false,
        rendah_edukasi: false,
        rendah_pintu_lampu: false,
        rendah_alat_bantu: false,
        rendah_alas_kaki: false,
        
        // Risiko Jatuh Tinggi
        tinggi_semua_standar: false,
        tinggi_gelang_kuning: false,
        tinggi_tanda_pintu: false,
        tinggi_dekat_nurse: false,
        tinggi_kunjungi_1jam: false,
        tinggi_edukasi_obat: false,
        tinggi_dampingi_kamar_mandi: false,
        tinggi_tempat_duduk: false,
        tinggi_bel_toilet: false,
        tinggi_komunikasi_shift: false,
        
        // Tanda Tangan
        ttd_petugas: "",
        nama_petugas_ttd: "",
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
            `/master/pasien/dokumen-pelaksanaan-pencegahan-pasien-jatuh/${this.editData.uuid}`
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
      this.form.tanggal_pelaksanaan = today.toISOString().split("T")[0];

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
          "/master/pasien/dokumen-pelaksanaan-pencegahan-pasien-jatuh",
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

.form-row-2 {
  display: flex;
  gap: 1rem;
}

.form-row-2 > div {
  flex: 1;
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

.alert-info {
  background: #e3f2fd;
  border-left: 4px solid #2196f3;
  padding: 12px 16px;
  border-radius: 4px;
  margin-bottom: 15px;
}

.alert-warning {
  background: #fff3e0;
  border-left: 4px solid #ff9800;
  padding: 12px 16px;
  border-radius: 4px;
  margin-bottom: 15px;
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