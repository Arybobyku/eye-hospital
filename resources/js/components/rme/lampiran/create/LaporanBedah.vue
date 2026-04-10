
<style scoped>
.dropdown-dokter {
  position: relative;
  width: 100%;
}
.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  margin-top: 10px;
  cursor: pointer;
  font-size: 12px;
  transition: background 0.3s;
}

.btn-clear:hover {
  background: #d32f2f;
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
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">LAPORAN PEMBEDAHAN</h2>
        <p class="text-muted">RM 2.2/LP/22</p>
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
            <label>Tanggal Lahir :</label>
            <div class="d-flex gap-2">
              <input
                type="date"
                v-model="form.tanggal_lahir"
                class="input-rme"
                readonly
                style="flex: 1"
              />
              <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <input
              type="text"
              v-model="form.jenis_kelamin"
              class="input-rme"
              readonly />
          </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Operasi</h5>

        <div class="row mb-3">
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
            <input type="date" v-model="form.tanggal_operasi" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Operasi :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_operasi" value="akut" /> Akut
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.jenis_operasi" value="terencana" />
                Terencana
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= TIM MEDIS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tim Medis</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Pembedahan :</label>
            <input type="text" v-model="form.pembedahan" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Ahli Anestesi :</label>
            <input type="text" v-model="form.ahli_anestesi" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
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
          <div class="col-md-12">
            <div class="checkbox-grid">
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_umum" /> Umum
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_spiral" /> Spiral
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_epidural" /> Epidural
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_bsp" /> BSP*
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_csp" /> CSP*
              </label>
              <label class="checkbox-label">
                <input type="checkbox" v-model="form.anestesi_lokal" /> Lokal
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa dan Indikasi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Diagnosa Pra-Bedah :</label>
            <textarea
              v-model="form.diagnosa_pra_bedah"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>Indikasi Operasi :</label>
            <textarea
              v-model="form.indikasi_operasi"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Diagnosa Pasca-Bedah :</label>
            <textarea
              v-model="form.diagnosa_pasca_bedah"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>Jenis Operasi :</label>
            <textarea
              v-model="form.jenis_operasi_detail"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= DETAIL OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Detail Operasi</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Desinfeksi Kulit dengan :</label>
            <input type="text" v-model="form.desinfeksi_kulit" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Jam Operasi Dimulai :</label>
            <input type="time" v-model="form.jam_mulai" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Jam Operasi Selesai :</label>
            <input type="time" v-model="form.jam_selesai" class="input-rme" />
          </div>
          <div class="col-md-4">
            <label>Lama Operasi (menit) :</label>
            <input
              type="number"
              v-model="form.lama_operasi"
              class="input-rme"
              placeholder="Menit"
            />
          </div>
        </div>

        <div class="row mb-3">
          <!-- <div class="col-md-6">
            <label>Macam Sayatan (bila perlu dengan gambar) :</label>
            <textarea
              v-model="form.macam_sayatan"
              class="textarea-rme"
              rows="4"
            ></textarea>
          </div> -->
          <div class="col-md-6 ">
            <label class="mb-2 text-left">Macam Sayatan (bila perlu dengan gambar)</label>
            <!-- Preview TTD yang sudah ada -->
            <div v-if="form.macam_sayatan && !macamSayatanCleared" class="signature-preview">
              <img :src="form.macam_sayatan" alt="TTD Dokter" class="img-signature" />
              <button @click="clearMacamSayatan()" class="btn-clear">
                Hapus & Gambar Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="macam_sayatan"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('macam_sayatan')" class="btn-save mt-2">Simpan ✔</button>
            </div>
          </div>
          <div class="col-md-6 ">
            <label class="mb-2 text-left">Posisi Penderita (bila perlu dengan gambar)</label>
            <!-- Preview TTD yang sudah ada -->
            <div v-if="form.posisi_penderita && !posisiPenderitaCleared" class="signature-preview">
              <img :src="form.posisi_penderita" alt="TTD Dokter" class="img-signature" />
              <button @click="clearPosisiPenderita()" class="btn-clear">
                Hapus & Gambar Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="macam_sayatan"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('posisi_penderita')" class="btn-save mt-2">Simpan ✔</button>
            </div>
          </div>

        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Teknik Operasi dan Temuan Intra-Operasi :</label>
            <textarea
              v-model="form.teknik_operasi"
              class="textarea-rme"
              rows="6"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= BAHAN LABORATORIUM ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Bahan Laboratorium</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Jenis Bahan Yang dikirim ke laboratorium :</label>
            <input type="text" v-model="form.jenis_bahan_lab" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>Untuk pemeriksaan :</label>
            <input type="text" v-model="form.pemeriksaan_lab" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= AMHP & KOMPLIKASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">AMHP Khusus & Komplikasi</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Penggunaan AMHP Khusus :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.penggunaan_amhp" value="ya" /> Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.penggunaan_amhp" value="tidak" /> Tidak
              </label>
            </div>
          </div>
          <div class="col-md-6" v-if="form.penggunaan_amhp === 'ya'">
            <label>Jenis dan Jumlah (AMHP Khusus) :</label>
            <input type="text" v-model="form.jenis_amhp" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Komplikasi Intra-operasi :</label>
            <div class="d-flex gap-3">
              <label class="radio-label">
                <input type="radio" v-model="form.komplikasi" value="ya" /> Ya
              </label>
              <label class="radio-label">
                <input type="radio" v-model="form.komplikasi" value="tidak" /> Tidak
              </label>
            </div>
          </div>
        </div>

        <div class="row mb-3" v-if="form.komplikasi === 'ya'">
          <div class="col-md-12">
            <label>Penjabaran Komplikasi Intra-Operasi :</label>
            <textarea
              v-model="form.penjabaran_komplikasi"
              class="textarea-rme"
              rows="4"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Perdarahan (cc) :</label>
            <input
              type="number"
              v-model="form.perdarahan"
              class="input-rme"
              placeholder="cc"
            />
          </div>
        </div>
      </div>

      <!-- ================= INSTRUKSI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Instruksi Anestesi & Pasca-Bedah</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Instruksi Anestesi :</label>
            <textarea
              v-model="form.instruksi_anestesi"
              class="textarea-rme"
              rows="3"
            ></textarea>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label class="fw-bold mb-2">Instruksi Pasca-Bedah :</label>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>1. Kontrol nadi/Tensi/pernapasan/suhu :</label>
            <input type="text" v-model="form.instruksi_kontrol" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>2. Puasa :</label>
            <input type="text" v-model="form.instruksi_puasa" class="input-rme" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>3. Drain :</label>
            <input type="text" v-model="form.instruksi_drain" class="input-rme" />
          </div>
          <div class="col-md-6">
            <label>4. Infus :</label>
            <input type="text" v-model="form.instruksi_infus" class="input-rme" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label>5. Obat-obatan :</label>
            <textarea
              v-model="form.instruksi_obat"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
          <div class="col-md-6">
            <label>6. Ganti Balut :</label>
            <input type="text" v-model="form.instruksi_ganti_balut" class="input-rme" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>7. Lain-lain :</label>
            <textarea
              v-model="form.instruksi_lainnya"
              class="textarea-rme"
              rows="2"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda Tangan Operator Bedah</h5>

        <div class="row">
          <div class="col-md-6">
            <label>Medan, Tanggal :</label>
            <input type="date" v-model="form.tanggal_ttd" class="input-rme" />
          </div>
        </div>

        <div class="row mt-1">
          <div class="col-md-6 text-center">
            <label class="fw-bold mb-2">Operator Bedah</label>
            <!-- Preview TTD yang sudah ada -->
            <div v-if="form.operator_bedah_ttd && !signatureCleared" class="signature-preview">
              <img :src="form.operator_bedah_ttd" alt="TTD Dokter" class="img-signature" />
              <button @click="clearSignature()" class="btn-clear">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad
                ref="operator_bedah_ttd"
                :options="sigOption"
                class="signature-box-rme"
              />
              <button @click="saveSign('operator_bedah_ttd')" class="btn-save">Simpan ✔</button>
            </div>

            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_operator" class="form-select-dokter">
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
  name: "FormLaporanPembedahan",
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
      listDokter: [],
      signatureCleared: false,
      macamSayatanCleared: false,
      posisiPenderitaCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
        
      },
      form: {
        uuid: "", // ✨ Tambahkan field uuid
        uuid_pasien: "",
        no_rm: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "",
        ruang_operasi: "",
        kamar: "",
        tanggal_operasi: "",
        jenis_operasi: "terencana",
        pembedahan: "",
        ahli_anestesi: "",
        asisten_1: "",
        asisten_2: "",
        perawat_instrument: "",
        anestesi_umum: false,
        anestesi_spiral: false,
        anestesi_epidural: false,
        anestesi_bsp: false,
        anestesi_csp: false,
        anestesi_lokal: false,
        diagnosa_pra_bedah: "",
        indikasi_operasi: "",
        diagnosa_pasca_bedah: "",
        jenis_operasi_detail: "",
        desinfeksi_kulit: "",
        jam_mulai: "",
        jam_selesai: "",
        lama_operasi: "",
        macam_sayatan: "",
        posisi_penderita: "",
        teknik_operasi: "",
        jenis_bahan_lab: "",
        pemeriksaan_lab: "",
        penggunaan_amhp: "tidak",
        jenis_amhp: "",
        komplikasi: "tidak",
        penjabaran_komplikasi: "",
        perdarahan: "",
        instruksi_anestesi: "",
        instruksi_kontrol: "",
        instruksi_puasa: "",
        instruksi_drain: "",
        instruksi_infus: "",
        instruksi_obat: "",
        instruksi_ganti_balut: "",
        instruksi_lainnya: "",
        tanggal_ttd: "",
        nama_operator: "",
        operator_bedah_ttd: "",
      },
    };
  },
  async mounted() {
    await this.fetchDokter();
    if (this.isEditMode && this.editData) {
      // ✨ LOAD DATA UNTUK EDIT
      this.loadDataForEdit();
    } else {
      // CREATE MODE
      this.setDataForm();
    }
    
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
    clearSignature() {
      this.signatureCleared = true;
      this.form.operator_bedah_ttd = "";
      this.$nextTick(() => {
        const pad = this.$refs.operator_bedah_ttd;
        if (pad) pad.clearSignature();
      });
    },
    clearMacamSayatan() {
      this.macamSayatanCleared = true;
      this.form.macam_sayatan = "";
      this.$nextTick(() => {
        const pad = this.$refs.macam_sayatan;
        if (pad) pad.clearMacamSayatan();
      });
    },
    clearPosisiPenderita() {
      this.posisiPenderitaCleared = true;
      this.form.posisi_penderita = "";
      this.$nextTick(() => {
        const pad = this.$refs.posisi_penderita;
        if (pad) pad.clearPosisiPenderita();
      });
    },
    async loadDataForEdit() {
      try {
        // Option 1: Jika data lengkap sudah ada di editData props
        if (this.editData.uuid) {
          // Fetch detail dari server untuk data lengkap
          const response = await axios.get(
            `/master/pasien/d /${this.editData.uuid}`
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
      this.form.tanggal_operasi = today.toISOString().split("T")[0];
      this.form.tanggal_ttd = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin;
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }
      this.signatureCleared = false;
      const { data } = pad.saveSignature();
      this.form[refName] = data;
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
          "/master/pasien/dokumen-laporan-pembedahan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);
        alert("Laporan Pembedahan berhasil disimpan!");
        this.$emit("back");
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan laporan pembedahan!");
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

.radio-label,
.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.checkbox-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
}

.signature-box-rme {
  width: 500px !important;
  height: 110px !important;
  border: 2px solid #999;
  border-radius: 4px;
  display: block;
  margin: 0 auto;
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

.gap-2 {
  gap: 8px;
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

.mt-1 {
  margin-top: 4px;
}

.mt-2 {
  margin-top: 8px;
}

.mt-3 {
  margin-top: 16px;
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

.text-muted {
  color: #6c757d;
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

  .checkbox-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
