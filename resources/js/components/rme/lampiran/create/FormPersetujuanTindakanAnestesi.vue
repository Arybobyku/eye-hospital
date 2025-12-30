<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">PERSETUJUAN TINDAKAN ANESTESI</h2>
        <h4 class="fw-semibold">RM 4.3/PTA/22 </h4>
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
          <label>Tanggal Lahir / Usia :</label>
          <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
        </div>
      </div>
    
      <div class="form-row-3-3">
        <div>
          <label>Jenis Kelamin :</label>
          <select v-model="form.jenis_kelamin" class="input-rme" enabled>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>
        <div>
          <label>Alamat :</label>
          <input type="text" v-model="form.alamat" class="input-rme" readonly />
        </div>
      </div>
    </div>


      <!-- ================= PEMBERIAN INFORMASI TINDAKAN PEMBIUSAN  ================= -->
        <div class="box-rme mb-4">
        <h5 class="section-title-rme">PEMBERIAN INFORMASI TINDAKAN PEMBIUSAN </h5>
          <div class="form-row-2">
            <div>
              <label>Dokter Pelaksana Tindakan :</label>
              <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
            </div>
            <div>
              <label>Pemberi Informasi :</label>
              <input type="text" v-model="form.perawat_asisten" class="input-rme" />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Penerima informasi/pemberi persetujuan* :</label>
              <input type="text" v-model="form.ruangan" class="input-rme" />
            </div>
          </div>
        </div>

        <!-- ================= Diagnosis (WD & DD)   ================= -->
        <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosis (WD & DD)  </h5>
            <div class="form-row-2">
                <div>
                  <label>Status Fisik ASA :</label>
                  <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
                </div>
            </div>
            <h5 class="section-title-rme">Dasar Diagnosis</h5>
            <div class="form-row-2">
                <div>
                  <label>Klinis :</label>
                  <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
                </div>
                <div>
                  <label>Radiologi :</label>
                  <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
                </div>
                <div>
                  <label>EKG :</label>
                  <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
                </div>
                <div>
                  <label>Laboratorium :</label>
                  <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
                </div>
            </div>
        </div>

        <!-- ================= Tindakan Kedokteran   ================= -->
        <div class="form-section">
          <div class="box-rme mb-4">
            <h5 class="section-title-rme">Tindakan Kedokteran</h5>
            
            <div class="form-row-2">
              <label>Anestesi / Pembiusan :</label>
            </div>
            
            <div class="form-row-inline">
              <span class="row-label">1. Umum :</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_intubasi" />
                Intubasi
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_lma" />
                LMA
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_fm" />
                FM
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.umum_tiva" />
                TIVA
              </label>
            </div>
            
            <div class="form-row-inline">
              <span class="row-label">2. Regional :</span>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_spinal1" />
                Spinal
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_spinal2" />
                Spinal
              </label>
              <label class="checkbox-item">
                <input type="checkbox" v-model="form.regional_blok_perifer" />
                Blok Perifer
              </label>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Indikasi Tindakan & Tujuan :</label>
                <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
              </div>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Tata Cara Tindakan :</label>
                <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
              </div>
            </div>
          </div>
        </div>

        <!-- ================= Risiko  ================= -->
        <div class="box-rme mb-4">
            <h5 class="section-title-rme">Dasar Diagnosis</h5>
            <div class="form-row-2">
                <div>
                  <label>
                    <input type="checkbox" v-model="form.shock" />
                    Shock
                  </label>
                </div>
                <div>
                  <label>
                    <input type="checkbox" v-model="form.henti_jantung" />
                    Henti Jantung
                  </label>
                </div>
                <div>
                  <label>
                    <input type="checkbox" v-model="form.meninggal_dunia" />
                    Meninggal dunia di meja operasi
                  </label>
                </div>
            </div>
        </div>

                <!-- ================= Komplikasi   ================= -->
        <div class="form-section">
          <div class="box-rme mb-4">
            <h5 class="section-title-rme">Komplikasi</h5>
            
            <div class="form-row-2">
              <label>Anestesi Umum :</label>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px; padding-left: 20px;">
              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_pernafasan" style="margin-top: 3px;" />
                <span>Sistem pernafasan : kejang dan penyempitan jalan nafas, kekurangan kadar O2 dalam darah, kekurangan atau kelebihan Co2 dalam darah, aspirasi pneumonia/masuknya isi lambung kedalam saluran nafas/paru</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_jantung" style="margin-top: 3px;" />
                <span>Jantung dan pembuluh darah : tekanan darah turun, tekanan darah naik, gangguan irama jantung sampai henti jantung</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_saraf" style="margin-top: 3px;" />
                <span>Sistem saraf : kejang, bangun lambat, trauma saraf tepi</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_intubasi" style="margin-top: 3px;" />
                <span>Tindakan laringoskopi intubasi (gigi patah, luka mulut, pendarahan)</span>
              </label>

              <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                <input type="checkbox" v-model="form.anestesi_umum_suhu" style="margin-top: 3px;" />
                <span>Suhu tubuh naik/turun.</span>
              </label>
                <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                  <input type="checkbox" v-model="form.anestesi_umum_posisi" style="margin-top: 3px;" />
                  <div style="display: flex; flex-direction: column; gap: 5px; width: 100%;">
                    <span>Cedera akibat posisi saat operasi</span>
                    <div style="padding-left: 20px; display: flex; gap: 20px; flex-wrap: wrap;">
                      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" v-model="form.posisi_cedera_mata" />
                        <span>Cedera mata</span>
                      </label>
                      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" v-model="form.posisi_cedera_saraf" />
                        <span>Cedera saraf</span>
                      </label>
                      <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" v-model="form.posisi_cedera_kulit" />
                        <span>Cedera kulit/jaringan lunak</span>
                      </label>
                    </div>
                  </div>
                </label>
            </div>
            
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Prognosis  :</label>
                <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
              </div>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Alternatif tindakan :</label>
                <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
              </div>
            </div>
            <div class="form-row-2">
              <div style="display: flex; flex-direction: column;">
                <label>Lain-lain :</label>
                <input type="text" v-model="form.dokter_pelaksana" class="input-rme" />
              </div>
            </div>
          </div>
        </div>

        <div class="box-rme mb-4">
            <h5 class="section-title-rme">PEMBERIAN INFORMASI</h5>
                     <!-- PERNYATAAN DAN TTD DOKTER & PASIEN SEJAJAR -->
              <div class="signature-row">
                <!-- KOLOM KIRI - DOKTER -->
                <div>
                  <label class="text-center d-block" style="margin-bottom:20px; line-height:1.6;">
                    Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi 
                  </label><br>
              
                  <div class="text-center">
                    <label class="fw-bold mb-2 d-block">Dokter Pelaksana</label>
                    <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
                    <button @click="saveSign('ttd_dokter')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
                    <input type="text" v-model="form.nama_dokter_ttd" @input="updateDisplayDokter" class="input-rme mt-2" placeholder="Nama Lengkap Dokter" />
                  </div>
                        <div>
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal" class="input-rme" />
            </div>
            <div>
              <label>Waktu :</label>
              <input type="time" v-model="form.waktu" class="input-rme" />
            </div>
        </div>
          
            <!-- KOLOM KANAN - PASIEN -->
            <div>
              <label class="text-center d-block" style="margin-bottom:20px; line-height:1.6;">
              Dengan ini menyatakan bahwa saya telah menerima informasi dari dokter sebagaimana di atas kemudian yang saya beri tanda/paraf di kolomkanannya, dan telah memahaminya              
              </label>          
              <div class="text-center">
                <label class="fw-bold mb-2 d-block">Pasien/Keluarga</label>
                <VueSignaturePad ref="ttd_pasien" :options="sigOption" class="signature-box-rme mx-auto" />
                <button @click="saveSign('ttd_pasien')" class="btn-save mt-2 d-block mx-auto">Simpan ✔</button>
                <input type="text" v-model="form.nama_pasien_ttd" @input="updateDisplayPasien" class="input-rme mt-2" placeholder="Nama Lengkap Pasien/Keluarga" />
              </div>
              <div>
                  <label>Tanggal :</label>
                  <input type="date" v-model="form.tanggal" class="input-rme" />
              </div>
              <div>
                  <label>Waktu :</label>
                  <input type="time" v-model="form.waktu" class="input-rme" />
              </div>
            </div>
          </div>
            <label class="d-block" style="margin-bottom:20px; line-height:1.6;">
            * Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.
            </label> 
        </div>

            <!-- ================= PERSETUJUAN TINDAKAN KEDOKTERAN  ================= -->
    <div class="box-rme mb-4">
        <h5 class="section-title-rme">PERSETUJUAN TINDAKAN KEDOKTERAN </h5>

        <!-- PERNYATAAN DAN TTD DOKTER & PASIEN SEJAJAR -->
        <div class="row mt-4">
          <!-- KOLOM KIRI - DOKTER -->
          <div class="col-md-12 mb-4">
            <label style="margin-bottom: 20px; text-align: justify; display: block; line-height: 1.6;">
                Yang bertanda tangan di bawah ini, saya nama 
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span>
                , tanggal lahir
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span>
                laki-laki/perempuan, alamat
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span>
                Dengan ini menyatakan <b>PERSETUJUAN</b> untuk dilakukannya tindakan <b>ANESTESI</b> terhadap saya /
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span>
                 saya* bernama
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span>
                tanggal lahir
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span> 
                laki-laki/perempuan, alamat
                <span style="color: #667eea; font-weight: 700;">
                    <span id="displayDokter" style="border-bottom: 2px dotted #667eea; padding: 0 5px;">_____</span>
                </span> <br> <br>
                Saya telah dijelaskan dan memahami tentang jenis tindakan pembiusan beserta manfaat, risiko dan komplikasi lain yang mungkin timbul.                 
                <br> 
                Saya juga menyadari bahwa dokter melakukan suatu upaya dan oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.            </label>
                <div class="row mb-3">
                  <div class="col-md-6 mb-2">
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                      <span>Medan, Tanggal</span>
                      <input 
                        type="date" 
                        v-model="form.tanggal" 
                        class="input-rme"
                        style="width: 200px;"
                      />
                      <span>Waktu</span>
                      <input 
                        type="time" 
                        v-model="form.waktu" 
                        class="input-rme"
                        style="width: 130px;"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        <!-- ================= TANDA TANGAN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Tanda Tangan</h5>
        
          <div class="signature-grid-2x2">
            <!-- BARIS 1 KOLOM 1 -->
            <div>
              <label class="fw-bold mb-2">Yang Menyatakan (Pasien)</label>
              <VueSignaturePad ref="ttd_pasien_pernyataan" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_pasien_pernyataan')" class="btn-save mt-2">Simpan ✔</button>
              <input type="text" v-model="form.nama_pasien_pernyataan" class="input-rme mt-2" placeholder="Nama Lengkap Pasien" />
            </div>
        
            <!-- BARIS 1 KOLOM 2 -->
            <div>
              <label class="fw-bold mb-2">Dokter</label>
              <VueSignaturePad ref="ttd_dokter_persetujuan" :options="sigOption" class="signature-box-rme mx-auto" />
              <button @click="saveSign('ttd_dokter_persetujuan')" class="btn-save mt-2">Simpan ✔</button>
              <input type="text" v-model="form.nama_dokter_persetujuan" class="input-rme mt-2" placeholder="Nama Lengkap Dokter" />
            </div>
          </div>
      
          <!-- SAKSI DI TENGAH -->
          <div style="text-align: center; margin-top: 30px;">
            <h4 class="fw-bold mb-3">Saksi</h4>

            <div class="signature-grid-2x2">
              <!-- SAKSI 1 - KELUARGA -->
              <div>
                <VueSignaturePad ref="ttd_keluarga" :options="sigOption" class="signature-box-rme mx-auto" />
                <input type="text" v-model="form.nama_keluarga_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Saksi" />
                                <button @click="saveSign('ttd_keluarga')" class="btn-save mt-2">Simpan ✔</button>
              </div>
          
              <!-- SAKSI 2 - PERAWAT -->
              <div>
                <VueSignaturePad ref="ttd_perawat" :options="sigOption" class="signature-box-rme mx-auto" />
                <input type="text" v-model="form.nama_perawat_ttd" class="input-rme mt-2" placeholder="Nama Lengkap Saksi" />
                                <button @click="saveSign('ttd_perawat')" class="btn-save mt-2">Simpan ✔</button>
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
  name: "FormPersetujuanTindakanAnestesi",
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
          const response = await axios.get(`
            /master/pasien/dokumen-form-persetujuan-tindakan-anestesi/${this.editData.uuid}
          `);

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
          "/master/pasien/dokumen-form-persetujuan-tindakan-anestesi",
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
        const response = await axios.get(`
          /master/pasien/dokumen-form-persetujuan-tindakan-anestesi/${uuid}
        `);

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

.signature-grid-2x2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 30px 20px;
  margin-top: 20px;
}

.form-row-block {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding-left: 20px;
}

.form-row-block .checkbox-item {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin: 0;
  cursor: pointer;
}

.form-row-block .checkbox-item input[type="checkbox"] {
  margin-top: 3px;
  flex-shrink: 0;
  cursor: pointer;
}

.form-section {
  margin-bottom: 20px;
}

.anesthesia-section {
  border-top: 1px solid #ccc;
  padding-top: 10px;
}

.section-label {
  display: block;
  margin-bottom: 10px;
  font-weight: normal;
}

.form-row-inline {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  gap: 20px;
}

.row-label {
  min-width: 100px;
  font-weight: normal;
}

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 5px;
  margin: 0;
  white-space: nowrap;
}

.checkbox-item input[type="checkbox"] {
  margin: 0;
}
.container {
  max-width: 1200px;
  margin: 0 auto;
}

.form-row-3-3 {
  display: flex;
  gap: 1rem; /* jarak antar kolom */
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem; /* tambahkan padding di dalam setiap kolom */
}

.signature-row-3 {
  display: flex;
  gap: 0.1rem;     /* jarak antar kolom */
  margin-top: 1.5rem;
}

.signature-row-3 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  text-align: center;
  box-sizing: border-box;
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
  width: 350px !important;   /* paksa lebar */
  height: 220px !important;  /* paksa tinggi */
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

.date-time-wrapper {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.date-time-wrapper > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.form-row-2 {
  display: flex;
  gap: 1rem;       /* jarak antar kolom */
}

.form-row-2 > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 0.5rem; /* ruang di dalam setiap kolom */
}

.signature-row {
  display: flex;
  gap: 2rem;       /* jarak antar kolom kiri-kanan */
  margin-top: 2rem;
}

.signature-row > div {
  flex: 1;         /* biar ukurannya seimbang */
  padding: 1rem;   /* ruang di dalam setiap kolom */
  box-sizing: border-box;
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