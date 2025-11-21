<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <!-- ================= HEADER ================= -->
    <div class="text-center mb-4">
      <h2 class="fw-bold">Surat Persetujuan / Penolakan Tindakan Medis</h2>
      <h4 class="fw-semibold">(Informed Consent)</h4>
    </div>

    <!-- DATE & TIME -->
    <div class="row mb-3">
      <div class="col-md-6 mb-2">
        <input type="date" v-model="form.date" class="form-control" readonly />
      </div>
      <div class="col-md-6 mb-2">
        <input type="time" v-model="form.time" class="form-control" readonly />
      </div>
    </div>

    <!-- ================= INFORMASI PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Informasi Pasien</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Kode MR :</label>
          <input type="text" v-model="form.kodeMR" class="input-rme" readonly />
        </div>

        <div class="col-md-6">
          <label>Nama Pasien :</label>
          <input type="text" v-model="form.nama" class="input-rme" readonly />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label>Usia :</label>
          <input type="text" v-model="form.usia" class="input-rme" readonly />
        </div>

        <div class="col-md-6">
          <label>Alamat :</label>
          <input type="text" v-model="form.alamat" class="input-rme" readonly />
        </div>
      </div>
    </div>

    <!-- ================= PEMBERIAN INFORMASI ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Pemberian Informasi</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label>Petugas Pelaksana Tindakan :</label>
          <input type="text" v-model="form.petugas" class="input-rme" />
        </div>

        <div class="col-md-6">
          <label>Pemberi Informasi :</label>
          <input type="text" v-model="form.pemberiInfo" class="input-rme" />
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-12">
          <label>Penerima Informasi :</label>
          <input type="text" v-model="form.penerimaInfo" class="input-rme" />
        </div>
      </div>

      <p class="small mt-1">
        *) Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima
        informasi adalah wali/keluarga terdekat.
      </p>

      <!-- ================= TABLE INFORMASI ================= -->
      <table class="info-table mt-3">
        <thead>
          <tr>
            <th style="width: 60px">No</th>
            <th style="width: 250px">Jenis Informasi</th>
            <th>Isi Informasi</th>
            <th style="width: 230px">Paraf (Diisi pasien/keluarga)</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>1</td>
            <td>Diagnosa dan keadaan kesehatan pasien</td>
            <td>
              <textarea v-model="form.isiInformasi" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <vue-signature
                ref="sign1"
                :sigOption="sigOption"
                class="signature-box-rme"
              />
              <button class="btn-rme mt-2">Simpan ✔</button>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>Nama dan tujuan tindakan</td>
            <td>
              <textarea v-model="form.tujuan" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <vue-signature
                ref="sign2"
                :sigOption="sigOption"
                class="signature-box-rme"
              />
              <button class="btn-rme mt-2">Simpan ✔</button>
            </td>
          </tr>

          <tr>
            <td>3</td>
            <td>Alternatif tindakan lain dan masing-masing risikonya</td>
            <td>
              <textarea v-model="form.alternatif" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <vue-signature
                ref="sign3"
                :sigOption="sigOption"
                class="signature-box-rme"
              />
              <button class="btn-rme mt-2">Simpan ✔</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import vueSignature from "vue-signature";
export default {
  name: "HistoryKunjungan",
  components: {
    vueSignature,
  },

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      loading: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      data: [],
      form: {
        uuid_pasien: "",
        date: "",
        time: "",
        kodeMR: "",
        nama: "",
        usia: "",
        alamat: "",
        petugas: "",
        pemberiInfo: "",
        penerimaInfo: "",
        isiInformasi: "",
      },
    };
  },
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(newVal) {
        // if (newVal?.id) {
        //   this.fetchHistory();
        // }
      },
    },
  },

  computed: {},
  mounted() {
    this.setDataForm();
  },

  methods: {
    async saveData() {
      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("search", this.selectedPatient.uuid);
        formData.append("limit", 10);
        formData.append("page", 1);

        const res = await axios.post("/master/pasien/history", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        // 👇 pastikan data backend berupa array
        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat history:", err);
        alert("Gagal memuat data history.");
      } finally {
        this.loading = false;
      }
    },
    formatDate(d) {
      return d.toISOString().split("T")[0];
    },

    formatTime(d) {
      return d.toTimeString().substring(0, 5);
    },
    setDataForm() {
      this.form.date = this.formatDate(new Date());
      this.form.time = this.formatTime(new Date());
      this.form.uuid_pasien = this.selectedPatient?.uuid;
      this.form.kodeMR = this.selectedPatient?.rekam_medis;
      this.form.nama = this.selectedPatient?.nama;
      this.form.usia = this.selectedPatient?.tanggal_lahir;
      this.form.alamat = this.selectedPatient?.alamat;
    },
  },
};
</script>

<style scoped>
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
}
.section-title-rme {
  font-weight: bold;
  margin-bottom: 10px;
  color: #2d74b7;
}
.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px;
  background: #f4f4f4;
}
.textarea-rme {
  width: 100%;
  min-height: 80px;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px;
}
.info-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.info-table th,
.info-table td {
  border: 1px solid #ccc;
  padding: 8px;
}
.signature-box-rme {
  width: 180px;
  height: 90px;
  border: 1px solid #aaa;
  margin-bottom: 8px;
}
.btn-rme {
  background: #2d74b7;
  color: #fff;
  padding: 4px 12px;
  border-radius: 4px;
}

/* LOADING OVERLAY */
.loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  z-index: 10;
}

.spinner-rme {
  width: 32px;
  height: 32px;
  border: 4px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 10px;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}
</style>
