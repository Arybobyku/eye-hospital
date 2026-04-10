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
          <label>Kode RME :</label>
          <input type="text" v-model="form.kodemr" class="input-rme" readonly />
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
          <input type="text" v-model="form.pemberi_info" class="input-rme" />
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-12">
          <label>Penerima Informasi :</label>
          <input type="text" v-model="form.penerima_info" class="input-rme" />
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
            <th style="width: 150px">Tandai ✓</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>1</td>
            <td>Diagnosis (WD&DD)</td>
            <td>
              <textarea v-model="form.diagnosis" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.diagnosis_ttd" 
                  id="diagnosis_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>2</td>
            <td>Dasar Diagnosis</td>
            <td>
              <textarea v-model="form.dasar_diagnosis" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.dasar_diagnosis_ttd" 
                  id="dasar_diagnosis_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>3</td>
            <td>Tindakan Kedokteran</td>
            <td>
              <textarea
                v-model="form.tindakan_kedokteran"
                class="textarea-rme"
              ></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.tindakan_kedokteran_ttd" 
                  id="tindakan_kedokteran_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>4</td>
            <td>Indikasi Tindakan</td>
            <td>
              <textarea v-model="form.indikasi_tindakan" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.indikasi_tindakan_ttd" 
                  id="indikasi_tindakan_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>5</td>
            <td>Tata Cara</td>
            <td>
              <textarea v-model="form.tata_cara" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.tata_cara_ttd" 
                  id="tata_cara_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>6</td>
            <td>Tujuan</td>
            <td>
              <textarea v-model="form.tujuan" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.tujuan_ttd" 
                  id="tujuan_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>7</td>
            <td>Risiko</td>
            <td>
              <textarea v-model="form.risiko" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.risiko_ttd" 
                  id="risiko_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>8</td>
            <td>Komplikasi</td>
            <td>
              <textarea v-model="form.komplikasi" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.komplikasi_ttd" 
                  id="komplikasi_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>9</td>
            <td>Prognosis</td>
            <td>
              <textarea v-model="form.prognosis" class="textarea-rme"></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.prognosis_ttd" 
                  id="prognosis_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td>10</td>
            <td>Alternatif & Resiko</td>
            <td>
              <textarea
                v-model="form.alternatif_dan_risiko"
                class="textarea-rme"
              ></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.alternatif_dan_risiko_ttd" 
                  id="alternatif_dan_risiko_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>
          <tr>
            <td>11</td>
            <td>Lain - Lain</td>
            <td>
              <textarea
                v-model="form.lainlain"
                class="textarea-rme"
              ></textarea>
            </td>
            <td class="text-center">
              <div class="checkbox-paraf">
                <input 
                  type="checkbox" 
                  v-model="form.lainlain_ttd" 
                  id="alternatif_dan_risiko_ttd"
                  class="checkbox-input"
                />
              </div>
            </td>
          </tr>

          <tr>
            <td colspan="3">
              Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara
              benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi
              (dokter yang memberikan informasi / tindakan).
            </td>
            <td class="text-center">
              <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">

                <label class="fw-bold label-small">Dokter</label>
              
                <VueSignaturePad
                  ref="menyatakan_menerangkan_ttd"
                  :options="sigOption"
                  class="signature-box-rme"
                />
              
                <!-- GANTI INPUT JADI DROPDOWN -->
                <div class="dropdown-dokter">
                  <select v-model="form.yang_menyatakan" class="form-select-dokter">
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
              
                <button @click="saveSign('menyatakan_menerangkan_ttd')" class="btn-save">
                  Simpan ✔
                </button>
              
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di
              atas yang saya beri paraf di kolom kanannya dan telah memahaminya.
            </td>
            <td class="text-center">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
              <label class="fw-bold label-small">Penerima Informasi</label>
              <VueSignaturePad
                ref="menyatakan_memahami_ttd"
                :options="sigOption"
                class="signature-box-rme"
              />
              <input
                v-model="form.yang_menyatakan"
                class="input-rme"
                placeholder="Tanda Tangan dan Nama Terang"
              />
              <button @click="saveSign('menyatakan_memahami_ttd')" class="btn-save">
                Simpan ✔
              </button>
               </div>
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
        <input v-model="form.yang_bertanda_tangan" class="input-rme" />, berumur
        <input v-model="form.berumur" class="input-rme small" /> tahun, berjenis kelamin
        <select v-model="form.jenis_kelamin" class="input-rme">
          <option value="L">Laki - laki</option>
          <option value="P">Perempuan</option></select
        >, yang beralamatkan di
        <input v-model="form.alamat" class="input-rme" />
      </div>

      <div style="margin-top: 10px">
        Dengan ini menyatakan
        <select v-model="form.menyatakan" class="input-rme">
          <option value="setuju">Setuju</option>
          <option value="tidak_setuju">Tidak Setuju</option>
        </select>
        untuk dilakukan tindakan
        <input v-model="form.dilakukan_tindakan" class="input-rme large" />
        terhadap saya / keluarga saya yang bernama
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
        <div class="sign-box" style="height: 200px">
          <label>Yang Menyatakan</label>

          <VueSignaturePad
            ref="yang_menyatakan_ttd"
            :options="sigOption"
            class="signature-box-rme"
          />

          <button @click="saveSign('yang_menyatakan_ttd')" class="btn-save">
            Simpan ✔
          </button>

          <input
            v-model="form.yang_menyatakan"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>

        <!-- Saksi 1 -->
        <div class="sign-box" style="height: 200px">
          <label>Saksi 1</label>

          <VueSignaturePad
            ref="saksi_1_ttd"
            :options="sigOption"
            class="signature-box-rme"
          />

          <button @click="saveSign('saksi_1_ttd')" class="btn-save">Simpan ✔</button>

          <input
            v-model="form.saksi_1"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>

        <!-- Saksi 2 -->
        <div class="sign-box" style="height: 200px">
          <label>Saksi 2</label>

          <VueSignaturePad
            ref="saksi_2_ttd"
            :options="sigOption"
            class="signature-box-rme"
          />

          <button @click="saveSign('saksi_2_ttd')" class="btn-save">Simpan ✔</button>

          <input
            v-model="form.saksi_2"
            class="input-rme"
            placeholder="Tanda Tangan dan Nama Terang"
          />
        </div>
      </div>
    </div>
  </div>
  <!-- ================= BUTTON BOTTOM ================= -->

  <div class="action-footer">
    <!-- TOMBOL SUBMIT -->
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>Save</span>
    </button>

    <!-- TOMBOL BACK -->
    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
      Back
    </button>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "PersetujuanPenolakanTindakan",
  data() {
    return {
      loadingSubmit: false,
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
        kodemr: "",
        nama: "",
        usia: "",
        alamat: "",
        petugas: "",
        pemberi_info: "",
        penerima_info: "",
        diagnosis: "",
        diagnosis_ttd: false,
        dasar_diagnosis: "",
        dasar_diagnosis_ttd: false,
        tindakan_kedokteran: "",
        tindakan_kedokteran_ttd: false,
        indikasi_tindakan: "",
        indikasi_tindakan_ttd: false,
        tata_cara: "",
        tata_cara_ttd: false,
        tujuan: "",
        tujuan_ttd: false,
        risiko: "",
        risiko_ttd: false,
        komplikasi: "",
        komplikasi_ttd: false,
        prognosis: "",
        prognosis_ttd: false,
        alternatif_dan_risiko: "",
        alternatif_dan_risiko_ttd: false,
        lainlain: "",
        lainlain_ttd: "",
        menyatakan_menerangkan_ttd: "",
        menyatakan_memahami_ttd: "",
        yang_bertanda_tangan: "",
        berumur: "",
        jenis_kelamin: "",
        menyatakan: "",
        dilakukan_tindakan: "",
        yang_menyatakan: "",
        yang_menyatakan_ttd: "",
        saksi_1: "",
        saksi_1_ttd: "",
        saksi_2: "",
        saksi_2_ttd: "",
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

  computed: {
    currentDate() {
      const today = new Date();
      const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      return `${today.getDate()} ${months[today.getMonth()]} ${today.getFullYear()}`;
    }
  },

  async mounted() {
    await this.fetchDokter();
    this.setDataForm();
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
      this.form.kodemr = this.selectedPatient?.rekam_medis;
      this.form.nama = this.selectedPatient?.nama;
      this.form.usia = this.selectedPatient?.tanggal_lahir;
      this.form.alamat = this.selectedPatient?.alamat;
    },
    saveSign(refName) {
      const pad = this.$refs[refName];

      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      // fungsi yang benar untuk vue-signature-pad
      const { isEmpty, data } = pad.saveSignature();

      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }

      this.form[refName] = data; // base64 string

      console.log("TTD saved:", refName);
    },

    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key]);
        });

        const response = await axios.post(
          "/master/pasien/dokumen-pertujuan-penolakan-tindakan-dokter",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        // tampilkan notif
        alert("Data berhasil disimpan!");

        // kembali ke parent component
        this.$emit("back");
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan data!");
      } finally {
        this.loadingSubmit = false;
      }
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
.label-small {
  font-size: 15px; /* bisa kamu kecilkan lagi misalnya 11px */
}

/* CHECKBOX PARAF STYLING */
.checkbox-paraf {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px;
}

.checkbox-input {
  width: 20px;
  height: 20px;
  cursor: pointer;
  accent-color: #2d74b7;
}

.checkbox-label {
  cursor: pointer;
  margin: 0;
  font-weight: 500;
  color: #333;
  user-select: none;
}

.checkbox-input:checked + .checkbox-label {
  color: #2d74b7;
  font-weight: 600;
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
  justify-content: flex-end;
  gap: 12px;
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
  margin-top: 20px;
  font-weight: 600;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}
</style>