<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- HEADER -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">PERSIAPAN PERALATAN ANESTESI</h2>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        </div>

        <!-- INFORMASI PASIEN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Informasi Pasien</h5>
          <div class="form-row-2">
            <div>
              <label>No. RM :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
            <div>
              <label>NIK :</label>
              <input type="text" v-model="form.nik" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Nama Pasien :</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div>
              <label>Tanggal Lahir :</label>
              <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Jenis Kelamin :</label>
              <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
            </div>
          </div>
        </div>

        <!-- DATA TINDAKAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Data Tindakan</h5>
          <div class="form-row-2">
            <div>
              <label>Ruangan :</label>
              <input type="text" v-model="form.ruangan" class="input-rme" placeholder="Nama ruangan..." />
            </div>
            <div>
              <label>Tanggal Tindakan :</label>
              <input type="date" v-model="form.tanggal_tindakan" class="input-rme" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Jam Tindakan :</label>
              <input type="time" v-model="form.jam_tindakan" class="input-rme" />
            </div>
            <div>
              <label>Jenis Operasi :</label>
              <input type="text" v-model="form.jenis_operasi" class="input-rme" placeholder="Jenis operasi..." />
            </div>
          </div>
          <div>
            <label>Teknik Anestesia :</label>
            <input type="text" v-model="form.teknik_anestesia" class="input-rme" placeholder="Teknik anestesia..." />
          </div>
        </div>

        <!-- CHECKLIST -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Checklist Peralatan Anestesi</h5>

          <!-- LISTRIK -->
          <h6 class="group-title">Listrik</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_mesin_anestesia" true-value="1" false-value="0" /> Mesin anestesia terhubung dengan sumber listrik, indikator (+) menyala.</label><br>
            <label><input type="checkbox" v-model="form.check_layar_pemantauan" true-value="1" false-value="0" /> Layar pemantauan terhubung dengan sumber listrik, indikator (+).</label><br>
            <label><input type="checkbox" v-model="form.check_defibrilator" true-value="1" false-value="0" /> Defibrilator terhubung dengan sumber listrik, indikator (+).</label>
          </div>

          <!-- GAS MEDIS -->
          <h6 class="group-title mt-3">Gas Medis</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_selang_oksigen" true-value="1" false-value="0" /> Selang oksigen terhubung antara sumber gas dengan mesin anestesia.</label><br>
            <label><input type="checkbox" v-model="form.check_flow_o2" true-value="1" false-value="0" /> Flow meter O₂ di mesin anestesia berfungsi, aliran gas keluar dari mesin dapat dirasakan.</label><br>
            <label><input type="checkbox" v-model="form.check_compressed_air" true-value="1" false-value="0" /> Compressed air terhubung antara sumber gas dengan mesin anestesia.</label><br>
            <label><input type="checkbox" v-model="form.check_flow_air" true-value="1" false-value="0" /> Flow meter "Air" di mesin anestesia berfungsi, aliran gas keluar mesin dapat dirasakan.</label><br>
            <label><input type="checkbox" v-model="form.check_n2o" true-value="1" false-value="0" /> N₂O terhubung antara sumber gas dengan mesin anestesia.</label><br>
            <label><input type="checkbox" v-model="form.check_flow_n2o" true-value="1" false-value="0" /> Flow meter N₂O di mesin anestesia berfungsi, aliran gas keluar mesin dapat dirasakan.</label>
          </div>

          <!-- MESIN ANESTESIA -->
          <h6 class="group-title mt-3">Mesin Anestesia</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_power_on" true-value="1" false-value="0" /> Power ON</label><br>
            <label><input type="checkbox" v-model="form.check_self_calibration" true-value="1" false-value="0" /> Self calibration : DONE</label><br>
            <label><input type="checkbox" v-model="form.check_tidak_bocor" true-value="1" false-value="0" /> Tidak ada kebocoran sirkuit nafas</label><br>
            <label><input type="checkbox" v-model="form.check_zat_volatil" true-value="1" false-value="0" /> Zat volatil terisi</label><br>
            <label><input type="checkbox" v-model="form.check_absorber_co2" true-value="1" false-value="0" /> Absorber CO₂ dalam kondisi baik</label>
          </div>

          <!-- MANAJEMEN JALAN NAFAS -->
          <h6 class="group-title mt-3">Manajemen Jalan Nafas</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_sungkup_muka" true-value="1" false-value="0" /> Sungkup muka dalam ukuran yang benar.</label><br>
            <label><input type="checkbox" v-model="form.check_oropharyngeal" true-value="1" false-value="0" /> Oropharyngeal airway (guedel) dalam ukuran yang benar.</label><br>
            <label><input type="checkbox" v-model="form.check_laringoskop_baterai" true-value="1" false-value="0" /> Batang laringoskop berisi baterai.</label><br>
            <label><input type="checkbox" v-model="form.check_bilah_laringoskop" true-value="1" false-value="0" /> Bilah laringoskop dalam ukuran yang benar.</label><br>
            <label><input type="checkbox" v-model="form.check_gagang_bilah" true-value="1" false-value="0" /> Gagang dan bilah laringoskop berfungsi baik.</label><br>
            <label><input type="checkbox" v-model="form.check_ett_lma" true-value="1" false-value="0" /> ETT atau LMA dalam ukuran yang benar, tidak bocor.</label><br>
            <label><input type="checkbox" v-model="form.check_stilet" true-value="1" false-value="0" /> Stilet (introduser)</label><br>
            <label><input type="checkbox" v-model="form.check_semprit_cuff" true-value="1" false-value="0" /> Semprit untuk mengembangkan cuff.</label><br>
            <label><input type="checkbox" v-model="form.check_forceps_magill" true-value="1" false-value="0" /> Forceps Magill</label>
          </div>

          <!-- PEMANTAUAN -->
          <h6 class="group-title mt-3">Pemantauan</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_kabel_ekg" true-value="1" false-value="0" /> Kabel EKG terhubung dengan layar pemantau.</label><br>
            <label><input type="checkbox" v-model="form.check_elektroda_ekg" true-value="1" false-value="0" /> Elektroda EKG dalam jumlah dan ukuran sesuai.</label><br>
            <label><input type="checkbox" v-model="form.check_nibp" true-value="1" false-value="0" /> NIBP terhubung dengan layar pantau, ukuran manset sesuai.</label><br>
            <label><input type="checkbox" v-model="form.check_spo2" true-value="1" false-value="0" /> SpO₂ terhubung dengan layar pantau, berfungsi baik.</label><br>
            <label><input type="checkbox" v-model="form.check_kapnografi" true-value="1" false-value="0" /> Kapnografi terhubung dengan layar pantau, berfungsi baik.</label><br>
            <label><input type="checkbox" v-model="form.check_pemantau_suhu" true-value="1" false-value="0" /> Pemantau suhu terhubung dengan layar pantau.</label>
          </div>

          <!-- LAIN-LAIN -->
          <h6 class="group-title mt-3">Lain-lain</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_stetoskop" true-value="1" false-value="0" /> Stetoskop tersedia.</label><br>
            <label><input type="checkbox" v-model="form.check_suction" true-value="1" false-value="0" /> Suction berfungsi baik.</label><br>
            <label><input type="checkbox" v-model="form.check_selang_suction" true-value="1" false-value="0" /> Selang suction terhubung, kateter suction dalam ukuran yang benar.</label><br>
            <label><input type="checkbox" v-model="form.check_plester" true-value="1" false-value="0" /> Plester untuk fiksasi.</label><br>
            <label><input type="checkbox" v-model="form.check_blanket_roll" true-value="1" false-value="0" /> Blanket roll / hemotherm / radiant heater terhubung sumber listrik, berfungsi baik.</label><br>
            <label><input type="checkbox" v-model="form.check_blanket_alas" true-value="1" false-value="0" /> Blanket roll dilapisi alas.</label><br>
            <label><input type="checkbox" v-model="form.check_xylocaine" true-value="1" false-value="0" /> Xylocaine 2% Jelly</label>
          </div>

          <!-- OBAT-OBAT -->
          <h6 class="group-title mt-3">Obat-obat</h6>
          <div class="form-checklist">
            <label><input type="checkbox" v-model="form.check_epinefrin" true-value="1" false-value="0" /> Epinefrin</label><br>
            <label><input type="checkbox" v-model="form.check_atropin" true-value="1" false-value="0" /> Atropin</label><br>
            <label><input type="checkbox" v-model="form.check_sedatif" true-value="1" false-value="0" /> Sedatif (midazolam / propofol / etomidat / ketamin / tiopental)</label><br>
            <label><input type="checkbox" v-model="form.check_opiat" true-value="1" false-value="0" /> Opiat / opioid</label><br>
            <label><input type="checkbox" v-model="form.check_pelumpuh_otot" true-value="1" false-value="0" /> Pelumpuh otot</label><br>
            <label><input type="checkbox" v-model="form.check_antibiotika" true-value="1" false-value="0" /> Antibiotika</label>
          </div>
          <div style="margin-top:8px;">
            <label>Lain-lain (obat) :</label>
            <textarea v-model="form.lain_lain_obat" class="textarea-rme" rows="3" placeholder="Tulis obat lain-lain..."></textarea>
          </div>
        </div>

        <!-- TANDA TANGAN -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan</h5>
          <div class="signature-row">
            <!-- PERAWAT ANESTESI -->
            <div>
              <div class="text-center">
                <label class="fw-bold mb-2 d-block">Pemeriksa (Perawat Anestesi)</label>
                <div v-if="form.ttd_perawat_anestesi && !ttdPerawatCleared" class="signature-preview text-center">
                  <img :src="form.ttd_perawat_anestesi" alt="TTD Perawat" class="img-signature" />
                  <p v-if="form.ttd_perawat_timestamp" class="timestamp-ttd">
                    Ditandatangani: {{ form.ttd_perawat_timestamp }}
                  </p>
                  <button @click="clearSign('ttd_perawat_anestesi')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
                </div>
                <div v-else class="text-center">
                  <VueSignaturePad ref="ttd_perawat_anestesi" :options="sigOption" class="signature-box-rme mx-auto" />
                  <button @click="saveSign('ttd_perawat_anestesi')" class="btn-save mt-2">Simpan ✔</button>
                </div>
                <input type="text" v-model="form.nama_perawat_anestesi" class="input-rme mt-2" placeholder="Nama Lengkap Perawat Anestesi" />
              </div>
            </div>

            <!-- DOKTER ANESTESI -->
            <div>
              <div class="text-center">
                <label class="fw-bold mb-2 d-block">dr. Anestesi</label>
                <div v-if="form.ttd_dr_anestesi && !ttdDrCleared" class="signature-preview text-center">
                  <img :src="form.ttd_dr_anestesi" alt="TTD Dokter" class="img-signature" />
                  <p v-if="form.ttd_dr_timestamp" class="timestamp-ttd">
                    Ditandatangani: {{ form.ttd_dr_timestamp }}
                  </p>
                  <button @click="clearSign('ttd_dr_anestesi')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
                </div>
                <div v-else class="text-center">
                  <VueSignaturePad ref="ttd_dr_anestesi" :options="sigOption" class="signature-box-rme mx-auto" />
                  <button @click="saveSign('ttd_dr_anestesi')" class="btn-save mt-2">Simpan ✔</button>
                </div>
                <input type="text" v-model="form.nama_dr_anestesi" class="input-rme mt-2" placeholder="Nama Lengkap Dokter Anestesi" />
              </div>
            </div>
          </div>
        </div>

        <!-- BUTTON BOTTOM -->
        <div class="action-footer" v-if="!disabledSubmit">
          <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
            <span v-if="loadingSubmit">Menyimpan...</span>
            <span v-else>Simpan</span>
          </button>
          <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Kembali</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormPersiapanPeralatanAnestesi",
  props: {
    selectedPatient: { type: Object, required: true },
    editData:        { type: Object, default: null },
    viewData:        { type: Object, default: null },
    documentType:    { type: String, default: "" },
  },
  data() {
    return {
      loadingSubmit:    false,
      disabledSubmit:   false,
      ttdPerawatCleared: false,
      ttdDrCleared:      false,
      sigOption: { penColor: "black", backgroundColor: "white" },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",

        ruangan: "",
        tanggal_tindakan: "",
        jam_tindakan: "",
        jenis_operasi: "",
        teknik_anestesia: "",

        // Listrik
        check_mesin_anestesia:  "0",
        check_layar_pemantauan: "0",
        check_defibrilator:     "0",

        // Gas Medis
        check_selang_oksigen:  "0",
        check_flow_o2:         "0",
        check_compressed_air:  "0",
        check_flow_air:        "0",
        check_n2o:             "0",
        check_flow_n2o:        "0",

        // Mesin Anestesia
        check_power_on:         "0",
        check_self_calibration: "0",
        check_tidak_bocor:      "0",
        check_zat_volatil:      "0",
        check_absorber_co2:     "0",

        // Manajemen Jalan Nafas
        check_sungkup_muka:        "0",
        check_oropharyngeal:       "0",
        check_laringoskop_baterai: "0",
        check_bilah_laringoskop:   "0",
        check_gagang_bilah:        "0",
        check_ett_lma:             "0",
        check_stilet:              "0",
        check_semprit_cuff:        "0",
        check_forceps_magill:      "0",

        // Pemantauan
        check_kabel_ekg:     "0",
        check_elektroda_ekg: "0",
        check_nibp:          "0",
        check_spo2:          "0",
        check_kapnografi:    "0",
        check_pemantau_suhu: "0",

        // Lain-lain
        check_stetoskop:     "0",
        check_suction:       "0",
        check_selang_suction:"0",
        check_plester:       "0",
        check_blanket_roll:  "0",
        check_blanket_alas:  "0",
        check_xylocaine:     "0",

        // Obat-obat
        check_epinefrin:    "0",
        check_atropin:      "0",
        check_sedatif:      "0",
        check_opiat:        "0",
        check_pelumpuh_otot:"0",
        check_antibiotika:  "0",
        lain_lain_obat:     "",

        // TTD
        ttd_perawat_anestesi: "",
        nama_perawat_anestesi: "",
        ttd_perawat_timestamp: "",
        ttd_dr_anestesi: "",
        nama_dr_anestesi: "",
        ttd_dr_timestamp: "",
      },
    };
  },
  async mounted() {
    await this.fetchTahunAkreditasi();
    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.loadDataForEdit();
    } else {
      this.setDataForm();
    }
  },
  methods: {
    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 5.1/PPA/${tahun}`;
        }
      } catch {
        if (!this.form.no_surat) this.form.no_surat = "RM 5.1/PPA/22";
      }
    },

    loadDataForEdit() {
      console.log("🟢 LOAD EDIT - Mulai load data");
      console.log("🟢 LOAD EDIT - editData:", this.editData);

      try {
        if (!this.editData) {
          console.warn("🟢 LOAD EDIT - Tidak ada editData!");
          this.setDataForm();
          return;
        }

        const checkFields = Object.keys(this.form).filter(k => k.startsWith('check_'));

        Object.keys(this.form).forEach((key) => {
          if (this.editData.hasOwnProperty(key)) {
            let value = this.editData[key];
            if (checkFields.includes(key)) {
              // DB boolean true/1/'1' → "1", false/0/'0'/null → "0"
              this.form[key] = (value === true || value === 1 || value === '1') ? '1' : '0';
            } else {
              this.form[key] = value !== null ? value : "";
            }
            console.log(`🟢 Set ${key}:`, this.form[key]);
          }
        });

        this.$nextTick(() => {
          if (this.form.ttd_perawat_anestesi) this.ttdPerawatCleared = false;
          if (this.form.ttd_dr_anestesi)      this.ttdDrCleared      = false;
        });

        console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);
      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal_tindakan = today.toISOString().split("T")[0];
      if (this.selectedPatient) {
        this.form.uuid_pasien   = this.selectedPatient.uuid;
        this.form.no_rm         = this.selectedPatient.rekam_medis;
        this.form.nik           = this.selectedPatient.no_identitas || "";
        this.form.nama          = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

      const flagMap = {
        ttd_perawat_anestesi: "ttdPerawatCleared",
        ttd_dr_anestesi:      "ttdDrCleared",
      };
      const tsMap = {
        ttd_perawat_anestesi: "ttd_perawat_timestamp",
        ttd_dr_anestesi:      "ttd_dr_timestamp",
      };

      if (flagMap[refName]) this[flagMap[refName]] = false;
      this.form[refName] = data;
      if (tsMap[refName]) {
        this.form[tsMap[refName]] = new Date().toLocaleString("id-ID", {
          day: "2-digit", month: "2-digit", year: "numeric",
          hour: "2-digit", minute: "2-digit", second: "2-digit",
        });
      }
    },

    clearSign(refName) {
      const flagMap = {
        ttd_perawat_anestesi: "ttdPerawatCleared",
        ttd_dr_anestesi:      "ttdDrCleared",
      };
      const tsMap = {
        ttd_perawat_anestesi: "ttd_perawat_timestamp",
        ttd_dr_anestesi:      "ttd_dr_timestamp",
      };

      if (flagMap[refName]) { this[flagMap[refName]] = true; this.form[refName] = ""; }
      if (tsMap[refName])   this.form[tsMap[refName]] = "";

      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    async submitForm() {
      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) return;
          fd.append(key, this.form[key]);
        });

        const res = await axios.post(
          "/master/pasien/dokumen-persiapan-peralatan-anestesi",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          alert(res.data.message);
          this.$emit("back");
        }
      } catch (err) {
        console.error(err.response?.data || err);
        alert("Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container { max-width: 1200px; margin: 0 auto; }

.form-row-2 { display: flex; gap: 1rem; }
.form-row-2 > div { flex: 1; min-width: 0; padding: 0.5rem; }

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

.group-title {
  font-weight: bold;
  font-size: 14px;
  color: #444;
  margin-bottom: 6px;
  padding-left: 4px;
  border-left: 3px solid #2d74b7;
}

.form-checklist { padding-left: 8px; }
.form-checklist label { font-size: 14px; color: #333; display: inline-flex; align-items: flex-start; gap: 6px; margin-bottom: 4px; cursor: pointer; }
.form-checklist input[type="checkbox"] { margin-top: 3px; flex-shrink: 0; }

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  box-sizing: border-box;
}
.input-rme:focus { outline: none; border-color: #2d74b7; background: white; }
.input-rme[readonly] { background: #e9ecef; cursor: not-allowed; }

.textarea-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 14px;
  resize: vertical;
  box-sizing: border-box;
}
.textarea-rme:focus { outline: none; border-color: #2d74b7; background: white; }

.signature-row { display: flex; gap: 2rem; margin-top: 1rem; }
.signature-row > div { flex: 1; padding: 1rem; box-sizing: border-box; }

.signature-box-rme { width: 350px !important; height: 200px !important; border: 2px solid #ccc; border-radius: 6px; }
.signature-preview { background: white; padding: 10px; border-radius: 4px; }
.img-signature { max-width: 100%; height: 160px; object-fit: contain; border: 1px dashed #ccc; display: block; margin: 0 auto; }
.timestamp-ttd { font-size: 12px; color: #2d74b7; font-weight: 500; padding: 4px 12px; background: #e9f5ff; border-radius: 4px; display: block; width: fit-content; margin: 4px auto; }

.action-footer {
  margin-top: 30px; padding: 20px; display: flex;
  justify-content: flex-end; gap: 12px;
  background: #f5f5f5; border-top: 2px solid #ddd;
  position: sticky; bottom: 0;
}

.btn-save-form { background: #0288d1; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #ccc; cursor: not-allowed; }

.btn-back { background: #ff9800; color: white; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ccc; cursor: not-allowed; }

.btn-save { background: #1e88e5; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; }
.btn-save:hover { background: #1565c0; }
.btn-clear { background: #f44336; color: white; padding: 6px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; }

.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.1); z-index: 10; cursor: not-allowed; }
.form-wrapper { position: relative; }

label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #333; }
.text-center { text-align: center; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
.mx-auto { margin-left: auto; margin-right: auto; }
.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 12px; }
.mb-2 { margin-bottom: 8px; }
.mb-4 { margin-bottom: 24px; }
.d-block { display: block; }
.position-relative { position: relative; }
.py-4 { padding-top: 24px; padding-bottom: 24px; }

@media (max-width: 768px) {
  .form-row-2, .signature-row { flex-direction: column; }
}
</style>
