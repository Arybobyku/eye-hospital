<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">FORMULIR TINDAKAN LASER</h2>
        <h4 class="fw-semibold">Laser Bargage Medical Procedure</h4>
      </div>

      <!-- DATE & TIME -->
      <div class="row mb-3">
        <div class="col-md-6 mb-2">
          <label>Tanggal :</label>
          <input type="date" v-model="form.tanggal" class="input-rme" />
        </div>
        <div class="col-md-6 mb-2">
          <label>Waktu :</label>
          <input type="time" v-model="form.waktu" class="input-rme" />
        </div>
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
          <div class="col-md-6">
            <label>Tanggal Lahir / Usia :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <select v-model="form.jenis_kelamin" class="input-rme" disabled>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Alamat :</label>
            <input type="text" v-model="form.alamat" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI KLINIK ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Klinik</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Dokter Pelaksana :</label>
            <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Perawat/Asisten :</label>
            <input type="text" v-model="form.perawat_asisten" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Ruangan/Lokasi :</label>
            <input type="text" v-model="form.ruangan" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Nomor Kamar :</label>
            <input type="text" v-model="form.nomor_kamar" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa Klinis</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Diagnosa Pra-Tindakan :</label>
            <textarea
              v-model="form.diagnosa_pra_tindakan"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Indikasi Tindakan Laser :</label>
            <textarea
              v-model="form.indikasi_tindakan"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= AREA TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Area dan Lokasi Tindakan</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Lokasi Anatomis :</label>
            <input
              type="text"
              v-model="form.lokasi_anatomis"
              class="input-rme"
              placeholder="Contoh: Wajah, Tangan, Kaki, dll"
            />
          </div>
          <div class="col-md-6">
            <label>Area Spesifik :</label>
            <input
              type="text"
              v-model="form.area_spesifik"
              class="input-rme"
              placeholder="Contoh: Pipi kanan, Lengan atas kiri, dll"
            />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Deskripsi Lesi/Kelainan :</label>
            <textarea
              v-model="form.deskripsi_lesi"
              class="textarea-rme"
              rows="3"
              placeholder="Ukuran, warna, tekstur, jumlah lesi, dll"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= SPESIFIKASI LASER ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Spesifikasi Laser dan Prosedur</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Laser :</label>
            <select v-model="form.jenis_laser" class="input-rme">
              <option value="">-- Pilih Jenis Laser --</option>
              <option value="CO2">CO2 Laser</option>
              <option value="Nd:YAG">Nd:YAG Laser</option>
              <option value="Erbium">Erbium Laser</option>
              <option value="Diode">Diode Laser</option>
              <option value="Argon">Argon Laser</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="col-md-6" v-if="form.jenis_laser === 'Lainnya'">
            <label>Sebutkan Jenis Laser :</label>
            <input type="text" v-model="form.jenis_laser_lainnya" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Wavelength (nm) :</label>
            <input
              type="text"
              v-model="form.wavelength"
              class="input-rme"
              placeholder="Contoh: 1064"
            />
          </div>
          <div class="col-md-4">
            <label>Power/Energy (Watt/Joule) :</label>
            <input
              type="text"
              v-model="form.power_energy"
              class="input-rme"
              placeholder="Contoh: 10W"
            />
          </div>
          <div class="col-md-4">
            <label>Pulse Duration :</label>
            <input
              type="text"
              v-model="form.pulse_duration"
              class="input-rme"
              placeholder="Contoh: 10ms"
            />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Spot Size (mm) :</label>
            <input type="text" v-model="form.spot_size" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jumlah Pulsa/Shot :</label>
            <input type="number" v-model="form.jumlah_pulsa" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Durasi Tindakan (menit) :</label>
            <input type="number" v-model="form.durasi_tindakan" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= ANESTESI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Anestesi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Anestesi :</label>
            <select v-model="form.jenis_anestesi" class="input-rme">
              <option value="">-- Pilih Jenis Anestesi --</option>
              <option value="Tanpa Anestesi">Tanpa Anestesi</option>
              <option value="Anestesi Topikal">Anestesi Topikal</option>
              <option value="Anestesi Lokal">Anestesi Lokal</option>
              <option value="Anestesi Regional">Anestesi Regional</option>
              <option value="Sedasi">Sedasi</option>
            </select>
          </div>
          <div
            class="col-md-6"
            v-if="form.jenis_anestesi && form.jenis_anestesi !== 'Tanpa Anestesi'"
          >
            <label>Obat Anestesi yang Digunakan :</label>
            <input
              type="text"
              v-model="form.obat_anestesi"
              class="input-rme"
              placeholder="Contoh: Lidocaine 2%"
            />
          </div>
        </div>
      </div>

      <!-- ================= PROSEDUR TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Prosedur Tindakan</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Persiapan Pasien :</label>
            <textarea
              v-model="form.persiapan_pasien"
              class="textarea-rme"
              rows="3"
              placeholder="Pembersihan area, desinfeksi, dll"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Teknik Tindakan :</label>
            <textarea
              v-model="form.teknik_tindakan"
              class="textarea-rme"
              rows="4"
              placeholder="Deskripsi detail teknik yang digunakan"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Temuan Selama Tindakan :</label>
            <textarea
              v-model="form.temuan_tindakan"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= HASIL DAN KOMPLIKASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Hasil dan Komplikasi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Hasil Tindakan :</label>
            <select v-model="form.hasil_tindakan" class="input-rme">
              <option value="Berhasil">Berhasil</option>
              <option value="Berhasil Sebagian">Berhasil Sebagian</option>
              <option value="Perlu Tindakan Ulang">Perlu Tindakan Ulang</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Kondisi Pasien Pasca Tindakan :</label>
            <select v-model="form.kondisi_pasien" class="input-rme">
              <option value="Baik">Baik</option>
              <option value="Cukup">Cukup</option>
              <option value="Perlu Observasi">Perlu Observasi</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Komplikasi :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.ada_komplikasi" value="tidak" /> Tidak
                Ada
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.ada_komplikasi" value="ya" /> Ada
              </label>
            </div>
          </div>
        </div>

        <div class="row mb-3" v-if="form.ada_komplikasi === 'ya'">
          <div class="col-md-12">
            <label>Deskripsi Komplikasi :</label>
            <textarea
              v-model="form.deskripsi_komplikasi"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Catatan Tambahan :</label>
            <textarea
              v-model="form.catatan_tambahan"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= INSTRUKSI PASCA TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Instruksi Pasca Tindakan</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>1. Perawatan Luka :</label>
            <textarea
              v-model="form.instruksi_perawatan_luka"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>2. Obat-obatan :</label>
            <textarea
              v-model="form.instruksi_obat"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>3. Aktivitas yang Dihindari :</label>
            <textarea
              v-model="form.instruksi_aktivitas"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>4. Kontrol Ulang :</label>
            <input type="date" v-model="form.tanggal_kontrol" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>5. Tanda Bahaya yang Perlu Diwaspadai :</label>
            <textarea
              v-model="form.instruksi_tanda_bahaya"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan</h5>

        <div class="row">
          <div class="col-md-6 text-center mb-4">
            <label class="fw-bold mb-2">Dokter Pelaksana</label>
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
              v-model="form.nama_dokter_ttd"
              class="input-rme mt-2"
              placeholder="Nama Lengkap Dokter"
            />
          </div>

          <div class="col-md-6 text-center mb-4">
            <label class="fw-bold mb-2">Perawat/Asisten</label>
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
              v-model="form.nama_perawat_ttd"
              class="input-rme mt-2"
              placeholder="Nama Lengkap Perawat"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>Simpan</span>
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
  name: "FormLaserBargage",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      // ✨ Props untuk data edit
      type: Object,
      default: null,
    },
    isEditMode: {
      // ✨ Props flag edit mode
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
        uuid: "", // ✨ Tambahkan field uuid
        uuid_pasien: "",
        tanggal: "",
        waktu: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        dokter_pelaksana: "",
        perawat_asisten: "",
        ruangan: "",
        nomor_kamar: "",
        diagnosa_pra_tindakan: "",
        indikasi_tindakan: "",
        lokasi_anatomis: "",
        area_spesifik: "",
        deskripsi_lesi: "",
        jenis_laser: "",
        jenis_laser_lainnya: "",
        wavelength: "",
        power_energy: "",
        pulse_duration: "",
        spot_size: "",
        jumlah_pulsa: "",
        durasi_tindakan: "",
        jenis_anestesi: "",
        obat_anestesi: "",
        persiapan_pasien: "",
        teknik_tindakan: "",
        temuan_tindakan: "",
        hasil_tindakan: "Berhasil",
        kondisi_pasien: "Baik",
        ada_komplikasi: "tidak",
        deskripsi_komplikasi: "",
        catatan_tambahan: "",
        instruksi_perawatan_luka: "",
        instruksi_obat: "",
        instruksi_aktivitas: "",
        tanggal_kontrol: "",
        instruksi_tanda_bahaya: "",
        ttd_dokter: "",
        nama_dokter_ttd: "",
        ttd_perawat: "",
        nama_perawat_ttd: "",
      },
    };
  },
  mounted() {
    if (this.isEditMode && this.editData) {
      // ✨ LOAD DATA UNTUK EDIT
      this.loadDataForEdit();
    } else {
      // CREATE MODE
      this.setDataForm();
    }
  },
  methods: {
    async loadDataForEdit() {
      try {
        // Option 1: Jika data lengkap sudah ada di editData props
        if (this.editData.uuid) {
          // Fetch detail dari server untuk data lengkap
          const response = await axios.get(
            `/master/pasien/dokumen-form-laser-barbage/${this.editData.uuid}`
          );

          if (response.data.status) {
            // Populate form dengan data dari server
            Object.keys(this.form).forEach((key) => {
              if (response.data.data[key] !== undefined) {
                this.form[key] = response.data.data[key];
              }
            });

            // ✨ Load signature jika ada
            if (response.data.data.ttd_dokter) {
              this.$nextTick(() => {
                // Set signature dari base64
                // Note: vue-signature-pad biasanya perlu di-load manual
              });
            }
          }
        }

        // Option 2: Atau langsung gunakan editData jika sudah lengkap
        // Object.keys(this.form).forEach(key => {
        //   if (this.editData[key] !== undefined) {
        //     this.form[key] = this.editData[key];
        //   }
        // });
      } catch (error) {
        console.error("Error loading data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },
    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];
      this.form.waktu = today.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.alamat = this.selectedPatient.alamat;
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
          // Jangan kirim uuid jika kosong (mode create)
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key]);
        });

        const response = await axios.post(
          "/master/pasien/dokumen-form-laser-bargage",
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
    // Saat load data untuk edit
    async loadDataForEdit(uuid) {
      try {
        const response = await axios.get(
          `/master/pasien/dokumen-form-laser-bargage/${uuid}`
        );

        if (response.data.status) {
          // Isi form dengan data yang ada
          this.form = { ...this.form, ...response.data.data };
          // UUID akan otomatis terisi di form
        }
      } catch (error) {
        console.error("ERROR:", error);
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

.radio-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

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

.col-md-4,
.col-md-6,
.col-md-12 {
  padding-left: 8px;
  padding-right: 8px;
}

.col-md-4 {
  flex: 0 0 33.333333%;
  max-width: 33.333333%;
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

.gap-3 {
  gap: 12px;
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

.text-center {
  text-align: center;
}

.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
