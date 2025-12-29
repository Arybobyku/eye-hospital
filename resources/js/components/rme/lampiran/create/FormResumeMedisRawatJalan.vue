<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="text-center mb-4">
      <h3 class="fw-bold">RESUME MEDIS RAWAT JALAN</h3>
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
          <input v-model="form.dokter" class="input-rme" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label>Ruang Poli</label>
          <input v-model="form.poli" class="input-rme" />
        </div>
        <div class="col-md-6">
          <label>Penanggung Pembayaran</label>
          <input v-model="form.penanggung" class="input-rme" />
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

      <label>Dokter yang Memeriksa</label>
      <VueSignaturePad
        ref="dokter_ttd"
        :options="sigOption"
        class="signature-box-rme"
      />
      <button class="btn-save" @click="saveSign('dokter_ttd')">Simpan ✔</button>

      <input
        v-model="form.nama_dokter"
        class="input-rme"
        placeholder="Nama Jelas Dokter"
      />
    </div>
  </div>

  <div class="action-footer">
    <button class="btn-save-form" @click="submitForm" :disabled="loading">
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
    selectedPatient: { type: Object, required: true },
  },
  data() {
    return {
      loading: false,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid_pasien: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        no_rm: "",
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
        dokter_ttd: "",
        nama_dokter: "",
      },
    };
  },
  mounted() {
    this.setDataPasien();
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
    saveSign(ref) {
      const { data } = this.$refs[ref].saveSignature();
      this.form[ref] = data;
    },
    async submitForm() {
      this.loading = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((k) => fd.append(k, this.form[k]));
        await axios.post("/master/pasien/dokumen-resume-medis-rawat-jalan", fd);
        alert("Data berhasil disimpan");
        this.$emit("back");
      } catch (e) {
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
}
.action-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 40px;
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
</style>
