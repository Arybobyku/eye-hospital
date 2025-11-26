<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">FORMULIR TINDAKAN LASER FOKAL</h2>
        <h4 class="fw-semibold">Focal Laser Photocoagulation</h4>
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

      <!-- ================= TIM MEDIS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tim Medis</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Dokter Ophthalmologist :</label>
            <input type="text" v-model="form.dokter_ophthalmologist" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Teknisi Laser :</label>
            <input type="text" v-model="form.teknisi_laser" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Perawat/Asisten :</label>
            <input type="text" v-model="form.perawat_asisten" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Ruangan :</label>
            <input type="text" v-model="form.ruangan" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA & INDIKASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa dan Indikasi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Mata yang Ditindak :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.mata_ditindak" value="OD (Kanan)" /> OD (Kanan)
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.mata_ditindak" value="OS (Kiri)" /> OS (Kiri)
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.mata_ditindak" value="OU (Kedua)" /> OU (Kedua)
              </label>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Diagnosa Pra-Tindakan :</label>
            <textarea v-model="form.diagnosa_pra_tindakan" class="textarea-rme" rows="3" placeholder="Contoh: Diabetic Macular Edema, Branch Retinal Vein Occlusion, dll"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Indikasi Tindakan :</label>
            <textarea v-model="form.indikasi_tindakan" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Riwayat Penyakit Terkait :</label>
            <textarea v-model="form.riwayat_penyakit" class="textarea-rme" rows="2" placeholder="Diabetes, Hipertensi, AMD, dll"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= PEMERIKSAAN PRA-TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pemeriksaan Pra-Tindakan</h5>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Visus OD (Pre) :</label>
            <input type="text" v-model="form.visus_od_pre" class="input-rme" placeholder="6/6, 6/12, dll" />
          </div>
          <div class="col-md-4">
            <label>Visus OS (Pre) :</label>
            <input type="text" v-model="form.visus_os_pre" class="input-rme" placeholder="6/6, 6/12, dll" />
          </div>
          <div class="col-md-4">
            <label>Tekanan Intraokular :</label>
            <input type="text" v-model="form.tekanan_intraokular" class="input-rme" placeholder="mmHg" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Ketebalan Kornea (Pachymetry) :</label>
            <input type="text" v-model="form.ketebalan_kornea" class="input-rme" placeholder="µm" />
          </div>
          <div class="col-md-6">
            <label>Fluorescein Angiography :</label>
            <select v-model="form.fluorescein_angiography" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Sudah Dilakukan">Sudah Dilakukan</option>
              <option value="Tidak Dilakukan">Tidak Dilakukan</option>
            </select>
          </div>
        </div>

        <div class="row mb-3" v-if="form.fluorescein_angiography === 'Sudah Dilakukan'">
          <div class="col-md-12">
            <label>Hasil Fluorescein Angiography :</label>
            <textarea v-model="form.hasil_fluorescein" class="textarea-rme" rows="3" placeholder="Lokasi kebocoran, area yang memerlukan treatment, dll"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>OCT (Optical Coherence Tomography) Findings :</label>
            <textarea v-model="form.oct_findings" class="textarea-rme" rows="2" placeholder="Central macular thickness, cystoid spaces, dll"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= SPESIFIKASI LASER ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Spesifikasi Laser dan Parameter</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Laser :</label>
            <select v-model="form.jenis_laser" class="input-rme">
              <option value="">-- Pilih Jenis Laser --</option>
              <option value="Argon Green">Argon Green</option>
              <option value="Diode (810nm)">Diode (810nm)</option>
              <option value="Frequency-doubled Nd:YAG (532nm)">Frequency-doubled Nd:YAG (532nm)</option>
              <option value="Krypton Red">Krypton Red</option>
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
            <label>Power (mW) :</label>
            <input type="number" v-model="form.power" class="input-rme" placeholder="50-500 mW" />
          </div>
          <div class="col-md-4">
            <label>Spot Size (µm) :</label>
            <input type="number" v-model="form.spot_size" class="input-rme" placeholder="50-200 µm" />
          </div>
          <div class="col-md-4">
            <label>Duration (ms) :</label>
            <input type="number" v-model="form.duration" class="input-rme" placeholder="50-200 ms" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Jumlah Shots :</label>
            <input type="number" v-model="form.jumlah_shots" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Pattern :</label>
            <select v-model="form.pattern" class="input-rme">
              <option value="">-- Pilih Pattern --</option>
              <option value="Focal">Focal (Direct)</option>
              <option value="Grid">Grid Pattern</option>
              <option value="Modified Grid">Modified Grid</option>
            </select>
          </div>
          <div class="col-md-4">
            <label>Durasi Prosedur (menit) :</label>
            <input type="number" v-model="form.durasi_prosedur" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Area Treatment :</label>
            <textarea v-model="form.area_treatment" class="textarea-rme" rows="2" placeholder="Lokasi spesifik pada retina yang di-laser"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= ANESTESI & PERSIAPAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Anestesi dan Persiapan</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Anestesi Topikal :</label>
            <input type="text" v-model="form.anestesi_topikal" class="input-rme" placeholder="Proparacaine 0.5%, Tetracaine, dll" />
          </div>
          <div class="col-md-6">
            <label>Dilatasi Pupil :</label>
            <input type="text" v-model="form.dilatasi_pupil" class="input-rme" placeholder="Tropicamide 1%, Phenylephrine, dll" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Contact Lens yang Digunakan :</label>
            <select v-model="form.contact_lens" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Goldmann 3-mirror">Goldmann 3-mirror</option>
              <option value="Mainster">Mainster</option>
              <option value="Area Centralis">Area Centralis</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="col-md-6" v-if="form.contact_lens === 'Lainnya'">
            <label>Sebutkan Contact Lens :</label>
            <input type="text" v-model="form.contact_lens_lainnya" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= PROSEDUR TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Prosedur Tindakan</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Target Lesion :</label>
            <textarea v-model="form.target_lesion" class="textarea-rme" rows="3" placeholder="Microaneurysms, leaking vessels, specific coordinates, dll"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Teknik Tindakan :</label>
            <textarea v-model="form.teknik_tindakan" class="textarea-rme" rows="4" placeholder="Deskripsi detail teknik yang digunakan"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Respon Laser (Burn Intensity) :</label>
            <select v-model="form.burn_intensity" class="input-rme">
              <option value="">-- Pilih --</option>
              <option value="Very Light">Very Light (Barely Visible)</option>
              <option value="Light">Light</option>
              <option value="Moderate">Moderate (Ideal)</option>
              <option value="Heavy">Heavy</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Temuan Selama Tindakan :</label>
            <textarea v-model="form.temuan_tindakan" class="textarea-rme" rows="3"></textarea>
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
              <option value="Berhasil">Berhasil - Sesuai Target</option>
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
          <div class="col-md-4">
            <label>Visus OD (Post) :</label>
            <input type="text" v-model="form.visus_od_post" class="input-rme" placeholder="6/6, 6/12, dll" />
          </div>
          <div class="col-md-4">
            <label>Visus OS (Post) :</label>
            <input type="text" v-model="form.visus_os_post" class="input-rme" placeholder="6/6, 6/12, dll" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Komplikasi Intra-Prosedur :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.ada_komplikasi" value="tidak" /> Tidak Ada
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
            <textarea v-model="form.deskripsi_komplikasi" class="textarea-rme" rows="3" placeholder="Eye bleeding, additional vision loss, scotoma, dll"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Catatan Tambahan :</label>
            <textarea v-model="form.catatan_tambahan" class="textarea-rme" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- ================= INSTRUKSI PASCA TINDAKAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Instruksi Pasca Tindakan</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>1. Obat Tetes Mata :</label>
            <textarea v-model="form.instruksi_obat_tetes" class="textarea-rme" rows="2" placeholder="Antibiotic drops, Anti-inflammatory, dll"></textarea>
          </div>
          <div class="col-md-6">
            <label>2. Pembatasan Aktivitas :</label>
            <textarea v-model="form.instruksi_aktivitas" class="textarea-rme" rows="2" placeholder="Hindari mengemudi, kerja detail, dll"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>3. Durasi Pemulihan (hari) :</label>
            <input type="number" v-model="form.durasi_pemulihan" class="input-rme" placeholder="1-7 hari" />
          </div>
          <div class="col-md-6">
            <label>4. Follow-up / Kontrol Ulang :</label>
            <input type="date" v-model="form.tanggal_kontrol" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>5. Tanda Bahaya yang Perlu Diwaspadai :</label>
            <textarea v-model="form.instruksi_tanda_bahaya" class="textarea-rme" rows="3" placeholder="Nyeri hebat, penurunan penglihatan drastis, floaters berlebihan, dll"></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>6. Rencana Follow-up OCT :</label>
            <input type="date" v-model="form.rencana_oct_followup" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan Tim Medis</h5>

        <div class="row">
          <div class="col-md-6 text-center mb-4">
            <label class="fw-bold mb-2">Dokter Ophthalmologist</label>
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
            <label class="fw-bold mb-2">Teknisi Laser</label>
            <VueSignaturePad
              ref="ttd_teknisi"
              :options="sigOption"
              class="signature-box-rme mx-auto"
            />
            <button @click="saveSign('ttd_teknisi')" class="btn-save mt-2">
              Simpan ✔
            </button>
            <input
              type="text"
              v-model="form.nama_teknisi_ttd"
              class="input-rme mt-2"
              placeholder="Nama Lengkap Teknisi"
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
  name: "FormLaserFokal",
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
        tanggal: "",
        waktu: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        dokter_ophthalmologist: "",
        teknisi_laser: "",
        perawat_asisten: "",
        ruangan: "",
        mata_ditindak: "",
        diagnosa_pra_tindakan: "",
        indikasi_tindakan: "",
        riwayat_penyakit: "",
        visus_od_pre: "",
        visus_os_pre: "",
        tekanan_intraokular: "",
        ketebalan_kornea: "",
        fluorescein_angiography: "",
        hasil_fluorescein: "",
        oct_findings: "",
        jenis_laser: "",
        jenis_laser_lainnya: "",
        power: "",
        spot_size: "",
        duration: "",
        jumlah_shots: "",
        pattern: "",
        durasi_prosedur: "",
        area_treatment: "",
        anestesi_topikal: "",
        dilatasi_pupil: "",
        contact_lens: "",
        contact_lens_lainnya: "",
        target_lesion: "",
        teknik_tindakan: "",
        burn_intensity: "",
        temuan_tindakan: "",
        hasil_tindakan: "Berhasil",
        kondisi_pasien: "Baik",
        visus_od_post: "",
        visus_os_post: "",
        ada_komplikasi: "tidak",
        deskripsi_komplikasi: "",
        catatan_tambahan: "",
        instruksi_obat_tetes: "",
        instruksi_aktivitas: "",
        durasi_pemulihan: "",
        tanggal_kontrol: "",
        instruksi_tanda_bahaya: "",
        rencana_oct_followup: "",
        ttd_dokter: "",
        nama_dokter_ttd: "",
        ttd_teknisi: "",
        nama_teknisi_ttd: "",
      },
    };
  },
  computed: {
    isEditMode() {
      return !!this.editUuid;
    }
  },
  mounted() {
    if (this.isEditMode) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },
  methods: {
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

    async loadDataForEdit() {
      try {
        const response = await axios.get(
          `/master/pasien/lampiran/${this.editUuid}?type=laser_fokal`
        );

        if (response.data.status) {
          Object.keys(this.form).forEach(key => {
            if (response.data.data[key] !== undefined) {
              this.form[key] = response.data.data[key];
            }
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

      const { data } = pad.saveSignature();
      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi
      if (!this.form.dokter_ophthalmologist) {
        alert("Dokter Ophthalmologist harus diisi!");
        return;
      }

      if (!this.form.mata_ditindak) {
        alert("Mata yang ditindak harus dipilih!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key] || '');
        });

        const response = await axios.post(
          "/master/pasien/dokumen-form-laser-fokal",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan form laser fokal!");
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
