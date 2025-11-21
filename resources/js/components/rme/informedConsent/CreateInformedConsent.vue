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
            <td>Diagnosis (WD&DD)</td>
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
            <td>Dasar Diagnosis</td>
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
            <td>Tindakan Kedokteran</td>
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
          <tr>
            <td>4</td>
            <td>Indikasi Tindakan</td>
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
          <tr>
            <td>5</td>
            <td>Tata Cara</td>
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
          <tr>
            <td>6</td>
            <td>Tujuan</td>
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
          <tr>
            <td>7</td>
            <td>Risiko</td>
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
          <tr>
            <td>8</td>
            <td>Komplikasi</td>
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
          <tr>
            <td>9</td>
            <td>Prognosis</td>
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
          <tr>
            <td>10</td>
            <td>Alternatif & Resiko</td>
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
          <tr>
            <td colspan="3">
              Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara
              benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi
              (dokter yang memberikan informasi / tindakan).
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
          <tr>
            <td colspan="3">
              Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di
              atas yang saya beri paraf di kolom kanannya dan telah memahaminya.
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

    <!-- ================= Persetujuan tindakan dokter ================= -->
    <div class="consent-container">
      <h3>Persetujuan / Penolakan Tindakan Kedokteran</h3>

      <div>
        Yang bertanda tangan di bawah ini, saya
        <input v-model="form.nama" class="input-rme" />, berumur
        <input v-model="form.usia" class="input-rme small" /> tahun, berjenis kelamin
        <select v-model="form.jenis_kelamin" class="input-rme">
          <option value="L">Laki - laki</option>
          <option value="P">Perempuan</option></select
        >, yang beralamatkan di
        <input v-model="form.alamat" class="input-rme" />
      </div>

      <div style="margin-top: 10px">
        Dengan ini menyatakan
        <select v-model="form.status_persetujuan" class="input-rme">
          <option value="setuju">Setuju</option>
          <option value="tidak_setuju">Tidak Setuju</option>
        </select>
        untuk dilakukan tindakan
        <input v-model="form.tindakan" class="input-rme large" />
        terhadap saya / anak saya yang bernama
        <input v-model="form.nama_anak" class="input-rme" />
      </div>

      <br />

      <div>
        Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan
        seperti di atas kepada saya, termasuk risiko dan komplikasi yang timbul.
      </div>

      <div>
        Saya juga menyadari bahwa oleh karena Ilmu kedokteran bukanlah ilmu pasti, maka
        saya tidak akan menuntut hasil dan kemungkinan risiko yang timbul seperti telah
        dijelaskan di atas.
      </div>

      <div class="tanggal-tempat">BEKASI, {{ currentDate }} WIB</div>

      <!-- ================= SIGNATURE AREA ================= -->

      <div class="signature-section">
        <!-- Yang Menyatakan -->
        <div class="sign-box">
          <label>Yang Menyatakan</label>

          <vue-signature ref="sign1" :sigOption="sigOption" class="signature-box-rme" />

          <button @click="saveSign('sign1')" class="btn-save">Simpan ✔</button>

          <input
            v-model="form.nama"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>

        <!-- Saksi 1 -->
        <div class="sign-box">
          <label>Saksi 1</label>

          <vue-signature ref="sign2" :sigOption="sigOption" class="signature-box-rme" />

          <button @click="saveSign('sign2')" class="btn-save">Simpan ✔</button>

          <input
            v-model="form.saksi1"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>

        <!-- Saksi 2 -->
        <div class="sign-box">
          <label>Saksi 2</label>

          <vue-signature ref="sign3" :sigOption="sigOption" class="signature-box-rme" />

          <button @click="saveSign('sign3')" class="btn-save">Simpan ✔</button>

          <input
            v-model="form.saksi2"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>
      </div>
    </div>
  </div>
  <!-- ================= BUTTON BOTTOM ================= -->

  <div class="action-footer">
    <button class="btn-save-form" @click="submitForm">Save</button>
    <button class="btn-back" @click="$emit('back')">Back</button>
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

.consent-container {
  padding: 20px;
  background: white;
}

.input-rme {
  padding: 4px 8px;
  border: 1px solid #ccc;
}

.input-rme.small {
  width: 80px;
}

.input-rme.large {
  width: 250px;
}

.signature-section {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
}

.sign-box {
  width: 30%;
  text-align: center;
}

.signature-box-rme {
  width: 100%;
  height: 160px;
  border: 1px solid #999;
  margin-bottom: 10px;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 5px 12px;
  border: none;
  margin-bottom: 10px;
  cursor: pointer;
}

.action-footer {

  margin-top: 90px;
  display: flex;
  justify-content: flex-end; /* tombol ke kanan */
  gap: 12px; /* jarak antar tombol */
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

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}
</style>
