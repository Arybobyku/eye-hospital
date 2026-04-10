<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">PROSES PERAWATAN PERI – OPERATIVE </h2>
        <h4 class="fw-semibold">{{ form.no_surat}}</h4>
      </div>

      <!-- DATE & TIME -->
      <div class="date-time-wrapper">
        <div>
          <label>Tanggal :</label>
          <input type="date" v-model="form.tanggal" class="input-rme" />
        </div>
        <div>
          <label>Waktu :</label>
          <input type="time" v-model="form.waktu" class="input-rme" />
        </div>
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
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>
          <div>
            <label>Tanggal Lahir / Usia :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
        </div>
      
        <div class="form-row-3-3">
        <div>
          <label>Jenis Kelamin :</label>
          <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
        </div>
          <div>
            <label>Alamat :</label>
            <input type="text" v-model="form.alamat" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= CATATAN PERAWATAN SEBELUM OPERASI  ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">
          A. CATATAN PERAWATAN SEBELUM OPERASI 
          <small style="font-size: 12px; font-weight: normal;">
            : Bagian ini dilengkapi oleh Perawat Ruangan
          </small>
        </h5>
        <div class="form-row-2">
          <div>
            <label>Ruangan:</label>
            <input type="text" v-model="form.ruangan" class="input-rme" />
          </div>
          <div class="form-row-2">
            <div>
              <label>Jenis Pasien :</label>
              <div class="checkbox-group jenis-pasien-inline">
                <label><input type="radio" value="Umum" v-model="form.jenis_pasien" /> Umum</label>
                <label><input type="radio" value="BPJS" v-model="form.jenis_pasien" /> BPJS</label>
                <label><input type="radio" value="Asuransi" v-model="form.jenis_pasien" /> Asuransi</label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row-2">
          <div>
            <label>Diagnosis :</label>
            <input type="text" v-model="form.diagnosis" class="input-rme" />
          </div>
          <div>
            <label>Tindakan Operasi :</label>
            <input type="text" v-model="form.tindakan_operasi" class="input-rme" />
          </div>
        </div>
        <div class="form-row-2">
          <div>
            <label>Dokter Operator :</label>
            <input type="text" v-model="form.dokter_operator" class="input-rme" />
          </div>
          <div>
            <label>Dokter Anestesi :</label>
            <input type="text" v-model="form.dokter_anestesi" class="input-rme" />
          </div>
        </div>
        <div class="form-block">
          <div class="form-block shifted">
            <!-- 1. Vital Signs -->
            <div class="row">
              <span class="label">1. Vital Signs</span>
              <span>Temp. <input type="text" v-model="form.vital_temp" class="line-input2"></span>
              <span>Nadi <input type="text" v-model="form.vital_nadi" class="line-input2"></span>
              <span>Pernapasan <input type="text" v-model="form.vital_pernapasan" class="line-input2"></span>
              <span>Tekanan Darah <input type="text" v-model="form.vital_tekanan_darah" class="line-input2"></span>
              <span style="margin-left:110px;">Tinggi <input type="text" v-model="form.vital_tinggi" class="line-input2"></span>
              <span>Berat <input type="text" v-model="form.vital_berat" class="line-input2"> kg</span>
            </div>
        
            <!-- 2. Riwayat Penyakit -->
            <div class="row">
              <span class="label">2. Riwayat Penyakit</span>
              <label><input type="checkbox" v-model="form.riwayat_hipertensi"> Hipertensi</label>
              <label><input type="checkbox" v-model="form.riwayat_diabetes"> Diabetes</label>
              <label><input type="checkbox" v-model="form.riwayat_hepatitis"> Hepatitis</label>
              <label><input type="checkbox" v-model="form.riwayat_lainnya"> Lain-lain <input type="text" v-model="form.riwayat_lainnya_text" class="line-input"></label>
            </div>
        
            <!-- 3. Alergi -->
            <div class="row">
              <span class="label">3. Alergi</span>
              <label><input type="checkbox" v-model="form.alergi_tidak_tahu"> Tidak Tahu</label>
              <label><input type="checkbox" v-model="form.alergi_ya"> Ya <input type="text" v-model="form.alergi_ya_text" class="line-input"></label>
            </div>
        
            <!-- 4. Hasil KGD -->
            <div class="row">
              <span class="label">4. Hasil KGD</span>
              <input type="text" v-model="form.hasil_kgd" class="line-input" style="width:200px;">
              <span>Waktu Pengambilan Pkl.</span>
              <input type="time" v-model="form.waktu_pengambilan_kgd" class="line-input" style="width:150px;">
              <span>WIB</span>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= CATATAN PERAWATAN SEBELUM OPERASI B ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">
          B. CATATAN PERAWATAN SEBELUM OPERASI 
          <small style="font-size: 12px; font-weight: normal;">
            : Bagian ini dilengkapi oleh Perawat Ruangan dan Perawat Kamar Operasi
          </small>
        </h5>
        <div class="row">
          <label><input type="checkbox"> Ya</label>
          <label><input type="checkbox"> Tidak </label>
          <label><input type="checkbox"> N/A Tidak Tersedia</label>
        </div>
        <table class="form-rs">
          <thead>
            <tr>
              <th rowspan="2" class="judul"></th>
              <th colspan="3" class="center">RUANG TUNGGU</th>
              <th rowspan="2" class="center">KETERANGAN</th>
            </tr>
            <tr>
              <th class="center">RUANG</th>
              <th class="center">OK</th>
              <th class="center">OK</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>1. Pemeriksaan Identitas Pasien</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_1_identitas_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_1_identitas_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_1_identitas_ok2"></td>
              <td><input type="text" v-model="form.checklist_1_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>2. Pemeriksaan Gelang Nama</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_2_gelang_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_2_gelang_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_2_gelang_ok2"></td>
              <td><input type="text" v-model="form.checklist_2_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>3. Formulir Persetujuan Operasi (Tanda Tangan)</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_3_persetujuan_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_3_persetujuan_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_3_persetujuan_ok2"></td>
              <td><input type="text" v-model="form.checklist_3_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>4. Pemberian Premedikasi</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_4_premedikasi_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_4_premedikasi_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_4_premedikasi_ok2"></td>
              <td><input type="text" v-model="form.checklist_4_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>5. Pemberian makan dan minum terakhir</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_5_makan_minum_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_5_makan_minum_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_5_makan_minum_ok2"></td>
              <td><input type="text" v-model="form.checklist_5_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>6. Alat Prothesa Luar, mis : Gigi Palsu, Kontak Lensa</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_6_prothesa_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_6_prothesa_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_6_prothesa_ok2"></td>
              <td><input type="text" v-model="form.checklist_6_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>7. Penjepit Rambut/Cat Kuku/Perhiasan</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_7_perhiasan_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_7_perhiasan_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_7_perhiasan_ok2"></td>
              <td><input type="text" v-model="form.checklist_7_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>8. Status Pasien Terlampir</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_8_status_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_8_status_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_8_status_ok2"></td>
              <td><input type="text" v-model="form.checklist_8_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>9. X-ray/Scan *Pasien terlampir</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_9_xray_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_9_xray_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_9_xray_ok2"></td>
              <td><input type="text" v-model="form.checklist_9_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>10. Persiapan Pencukuran Bulu Mata</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_10_pencukuran_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_10_pencukuran_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_10_pencukuran_ok2"></td>
              <td><input type="text" v-model="form.checklist_10_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>11. Pemeriksaan darah (PMI/Lab. R.S*)</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_11_darah_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_11_darah_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_11_darah_ok2"></td>
              <td><input type="text" v-model="form.checklist_11_keterangan" class="line-input"></td>
            </tr>

            <tr>
              <td>12. Site Marker</td>
              <td class="center"><input type="checkbox" v-model="form.checklist_12_site_marker_ruang"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_12_site_marker_ok1"></td>
              <td class="center"><input type="checkbox" v-model="form.checklist_12_site_marker_ok2"></td>
              <td><input type="text" v-model="form.checklist_12_keterangan" class="line-input"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ================= TANDA TANGAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diperiksa Oleh </h5>
      
        <div class="signature-row-3">
          <!-- KOLOM 1 -->
          <div>
            <label class="fw-bold mb-2">Perawat Ruangan </label>
            <VueSignaturePad ref="ttd_perawat_ruangan" :options="sigOption" class="signature-box-rme mx-auto" />
            <div class="signature-actions mt-2" style="margin-top: 8px;">
            <button @click="clearSign('ttd_perawat_ruangan')" class="btn-clear mt-2">Ulang ↻</button>
            <button @click="saveSign('ttd_perawat_ruangan')" class="btn-save mt-2">Simpan ✔</button> </div>
            <div>
              <input type="time" v-model="form.ttd_perawat_ruangan_waktu" class="input-rme" />
            </div>
            <div>
              <input type="date" v-model="form.ttd_perawat_ruangan_tanggal" class="input-rme" />
            </div>
            <input type="text" v-model="form.nama_perawat_ruangan" class="input-rme mt-2" placeholder="Nama Lengkap Perawat Ruangan" />
          </div>
        
          <!-- KOLOM 2 -->  
          <div>
            <label class="fw-bold mb-2"> Perawat Kamar Bedah</label>
            <VueSignaturePad ref="ttd_perawat_kamar_bedah" :options="sigOption" class="signature-box-rme mx-auto" />
            <div class="signature-actions mt-2" style="margin-top: 8px;">
            <button @click="clearSign('ttd_perawat_kamar_bedah')" class="btn-clear mt-2">Ulang ↻</button>
            <button @click="saveSign('ttd_perawat_kamar_bedah')" class="btn-save mt-2">Simpan ✔</button> </div>
            <div>
              <input type="time" v-model="form.ttd_perawat_kamar_bedah_waktu" class="input-rme" />
            </div>
            <div>
              <input type="date" v-model="form.ttd_perawat_kamar_bedah_tanggal" class="input-rme" />
            </div>
            <input type="text" v-model="form.nama_perawat_kamar_bedah" class="input-rme mt-2" placeholder="Nama Lengkap Perawat Kamar Bedah" />
          </div>
        </div>
      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer"  v-if="!disabledSubmit">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>Simpan</span>
      </button>

      <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">
        Kembali
      </button>
    </div>
  </div>
</div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormProsesPerawatanPeriOperative",
  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
    viewData: {
      type: Object,
      default: null,
    },
    documentType: {
      type: String,
      default: "",
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
        
        // Data Pasien
        no_rm: "",
        no_surat: "",
        nik: "",
        nama_pasien: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        
        // Tanggal & Waktu Form
        tanggal: "",
        waktu: "",
        
        // A. CATATAN PERAWATAN SEBELUM OPERASI
        ruangan: "",
        jenis_pasien: "",
        diagnosis: "",
        tindakan_operasi: "",
        dokter_operator: "",
        dokter_anestesi: "",
        
        // 1. Vital Signs
        vital_temp: "",
        vital_nadi: "",
        vital_pernapasan: "",
        vital_tekanan_darah: "",
        vital_tinggi: "",
        vital_berat: "",
        
        // 2. Riwayat Penyakit
        riwayat_hipertensi: false,
        riwayat_diabetes: false,
        riwayat_hepatitis: false,
        riwayat_lainnya: false,
        riwayat_lainnya_text: "",
        
        // 3. Alergi
        alergi_tidak_tahu: false,
        alergi_ya: false,
        alergi_ya_text: "",
        
        // 4. Hasil KGD
        hasil_kgd: "",
        waktu_pengambilan_kgd: "",
        
        // B. CHECKLIST (12 items x 4 fields = 48 fields)
        checklist_1_identitas_ruang: false,
        checklist_1_identitas_ok1: false,
        checklist_1_identitas_ok2: false,
        checklist_1_keterangan: "",
        
        checklist_2_gelang_ruang: false,
        checklist_2_gelang_ok1: false,
        checklist_2_gelang_ok2: false,
        checklist_2_keterangan: "",
        
        checklist_3_persetujuan_ruang: false,
        checklist_3_persetujuan_ok1: false,
        checklist_3_persetujuan_ok2: false,
        checklist_3_keterangan: "",
        
        checklist_4_premedikasi_ruang: false,
        checklist_4_premedikasi_ok1: false,
        checklist_4_premedikasi_ok2: false,
        checklist_4_keterangan: "",
        
        checklist_5_makan_minum_ruang: false,
        checklist_5_makan_minum_ok1: false,
        checklist_5_makan_minum_ok2: false,
        checklist_5_keterangan: "",
        
        checklist_6_prothesa_ruang: false,
        checklist_6_prothesa_ok1: false,
        checklist_6_prothesa_ok2: false,
        checklist_6_keterangan: "",
        
        checklist_7_perhiasan_ruang: false,
        checklist_7_perhiasan_ok1: false,
        checklist_7_perhiasan_ok2: false,
        checklist_7_keterangan: "",
        
        checklist_8_status_ruang: false,
        checklist_8_status_ok1: false,
        checklist_8_status_ok2: false,
        checklist_8_keterangan: "",
        
        checklist_9_xray_ruang: false,
        checklist_9_xray_ok1: false,
        checklist_9_xray_ok2: false,
        checklist_9_keterangan: "",
        
        checklist_10_pencukuran_ruang: false,
        checklist_10_pencukuran_ok1: false,
        checklist_10_pencukuran_ok2: false,
        checklist_10_keterangan: "",
        
        checklist_11_darah_ruang: false,
        checklist_11_darah_ok1: false,
        checklist_11_darah_ok2: false,
        checklist_11_keterangan: "",
        
        checklist_12_site_marker_ruang: false,
        checklist_12_site_marker_ok1: false,
        checklist_12_site_marker_ok2: false,
        checklist_12_keterangan: "",
        
        // Tanda Tangan Perawat Ruangan
        ttd_perawat_ruangan: "",
        ttd_perawat_ruangan_waktu: "",
        ttd_perawat_ruangan_tanggal: "",
        nama_perawat_ruangan: "",
        
        // Tanda Tangan Perawat Kamar Bedah
        ttd_perawat_kamar_bedah: "",
        ttd_perawat_kamar_bedah_waktu: "",
        ttd_perawat_kamar_bedah_tanggal: "",
        nama_perawat_kamar_bedah: "",
      },
    };
  },
  
async mounted() {
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);

  await this.fetchTahunAkreditasi();
  
this.disabledSubmit = false;
  if(this.viewData){
    this.disabledSubmit = true;
    this.loadDataForEdit();
  }else if (this.editData) {
    console.log("🟢 MODE: EDIT");
    this.loadDataForEdit();
  } else {
    console.log("🟢 MODE: CREATE");
    this.setDataForm();
  }
},
  
  methods: {
async fetchTahunAkreditasi() {
  try {
    const response = await axios.get('/api/tahun-akreditasi');
    const tahun = response.data.tahun || '22';
    
    if (!this.form.no_surat) {
      this.form.no_surat = `RM 1.10/PPPO/${tahun}`;
    }
    
    console.log("✅ Tahun akreditasi:", tahun);
    console.log("✅ No surat:", this.form.no_surat);
  } catch (error) {
    console.error("❌ Error fetch tahun:", error);
    if (!this.form.no_surat) {
      this.form.no_surat = 'RM 1.10/PPPO/22';
    }
  }
},

loadDataForEdit() {
  console.log("🟢 LOAD EDIT - Mulai load data");
  console.log("🟢 LOAD EDIT - editData yang diterima:", this.editData);
  
  try {
    if (!this.editData) {
      console.warn("🟢 LOAD EDIT - Tidak ada editData!");
      this.setDataForm(); // Fallback ke create mode
      return;
    }

    // ✅ Populate form dengan data dari editData
    Object.keys(this.form).forEach((key) => {
      if (this.editData.hasOwnProperty(key)) {
        // Konversi value yang mungkin berbeda tipe
        let value = this.editData[key];
        
        // Handle checkbox (convert ke string "0" atau "1")
        if (key.startsWith('check_')) {
          this.form[key] = value ? "1" : "0";
        } else {
          this.form[key] = value !== null ? value : "";
        }
        
        console.log(`🟢 Set ${key}:`, this.form[key]);
      }
    });

    console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);
    

    // ⬇⬇ TAMBAHKAN DI SINI
this.renderSignature(
  "ttd_perawat_ruangan",
  this.form.ttd_perawat_ruangan
);
this.renderSignature(
  "ttd_perawat_kamar_bedah",
  this.form.ttd_perawat_kamar_bedah
);

  } catch (error) {
    console.error("🟢 LOAD EDIT - Error:", error);
    alert("Gagal memuat data untuk edit!");
    this.$emit("back");
  }
},

renderSignature(refName, data) {
  this.$nextTick(() => {
    const pad = this.$refs[refName];
    if (pad && data) {
      pad.clearSignature();
      pad.fromDataURL(data);
    }
  });
},

    
    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];
      this.form.waktu = today.toTimeString().substring(0, 5);

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.nik || "";
        this.form.nama_pasien = this.selectedPatient.nama;
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

      const { isEmpty, data } = pad.saveSignature();
      if (!isEmpty) {
        this.form[refName] = data;
        alert("Tanda tangan berhasil disimpan!");
      } else {
        alert("Tanda tangan masih kosong!");
      }
    },

    clearSign(refName) {
      const pad = this.$refs[refName];
      if (pad) {
        pad.clearSignature();
      }
    },

    async submitForm() {
      // Validasi form
      if (!this.form.ruangan) {
        alert("Ruangan harus diisi!");
        return;
      }
      
      if (!this.form.diagnosis) {
        alert("Diagnosis harus diisi!");
        return;
      }
      
      if (!this.form.tindakan_operasi) {
        alert("Tindakan Operasi harus diisi!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          // Jangan kirim uuid jika kosong (mode create)
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          
          // Convert boolean ke string untuk FormData
          if (typeof this.form[key] === 'boolean') {
            fd.append(key, this.form[key] ? '1' : '0');
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const url = this.isEditMode 
          ? `/master/pasien/form-proses-perawatan-peri-operative/${this.form.uuid}`
          : '/master/pasien/form-proses-perawatan-peri-operative';
        
        const method = this.isEditMode ? 'put' : 'post';

        const response = await axios[method](url, fd, {
          headers: { "Content-Type": "multipart/form-data" }
        });

        if (response.data.status) {
          alert(response.data.message || "Form berhasil disimpan!");
          this.$emit("back");
        } else {
          alert(response.data.message || "Gagal menyimpan form!");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert(error.response?.data?.message || "Gagal menyimpan form!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>

.form-rs {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.form-rs th,
.form-rs td {
  border: 1px solid #000;
  padding: 4px 6px;
  vertical-align: middle;
}

.form-rs th.center,
.form-rs td.center {
  text-align: center;
}

.line {
  border-bottom: 1px solid #000;
  width: 100%;
  height: 15px;
}


.shifted {
  padding-left: 15px;
  padding-top: 10px; /* Geser ke kanan */
}

.line-input {
  border: none;
  border-bottom: 1px solid #000;
  width: 100%;        /* atur panjang garis */
  padding: 2px 4px;
  outline: none;
  background: transparent;
  font-size: 14px;
}

.line-input2 {
  border: none;
  border-bottom: 1px solid #000;
  width: 65%;        /* atur panjang garis */
  padding: 2px 4px;
  outline: none;
  background: transparent;
  font-size: 14px;
}


.form-block {
  font-size: 14px;
  line-height: 1.8;
}

.row {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 6px;
  gap: 15px;
}

.label {
  font-weight: bold;
  margin-right: 10px;
}

.row label {
  display: flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
}

.grow-line {
  flex: 1;
  white-space: nowrap;
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

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  margin-left: 10px;
}

.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
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

.jenis-pasien-inline {
  display: flex;
  gap: 20px;    /* jarak antar item */
  align-items: center;
  margin-top: 5px;
}

.jenis-pasien-inline label {
  font-weight: normal;
  display: flex;
  align-items: center;
  gap: 5px;
}

.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 251, 251, 0.1); /* transparan */
  z-index: 10;
  cursor: not-allowed;
}
.form-wrapper {
  position: relative;
}




@media (max-width: 768px) {
  .col-md-4,
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
</style>
