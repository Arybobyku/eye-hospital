<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">FORMULIR REAKSI TRANSFUSI DARAH</h2>
        <h4 class="fw-semibold">{{form.no_surat}}</h4>
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
            <input type="text" v-model="displayTanggalLahir" class="input-rme" readonly />
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

      <!-- ================= DOKTER PENGIRIM & JENIS RAWAT ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Dokter & Jenis Rawat</h5>
        
        <div class="form-row-3-3">
          <div>
            <label>Dokter Pengirim / Referring Doctor :</label>
            <input type="text" v-model="form.dokter_pengirim" class="input-rme" />
          </div>
          <div>
            <label>Jenis Rawat :</label>
            <div style="display: flex; gap: 20px; margin-top: 8px;">
              <label class="checkbox-label">
                <input type="radio" v-model="form.jenis_rawat" value="inap" /> Rawat Inap / Inpatient
              </label>
              <label class="checkbox-label">
                <input type="radio" v-model="form.jenis_rawat" value="jalan" /> Rawat Jalan / Outpatient
              </label>
            </div>
          </div>
        </div>
        
        <div class="form-row-3-3">
          <div>
            <label>Tgl / Date :</label>
            <input type="date" v-model="form.tanggal" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI TRANSFUSI ================= -->
      <div class="box-rme mb-4">
        <p style="font-size: 13px; margin-bottom: 15px; color: #666;">
          <strong>Catatan:</strong> Untuk advis diagnosa dan terapi, manajemen dan sangkaan akan reaksi transfusi, hubungi dokter jaga ruangan
        </p>
        
        <div class="form-row-3-3">
          <div>
            <label>Instalansi :</label>
            <input type="text" v-model="form.instalansi" class="input-rme" />
          </div>
          <div>
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal_transfusi" class="input-rme" />
          </div>
        </div>
        
        <div style="margin-bottom: 15px;">
          <label>Diagnosa Klinis :</label>
          <input type="text" v-model="form.diagnosa_klinis" class="input-rme" />
        </div>
        
        <div class="form-row-3-3">
          <div>
            <label>Produk Darah :</label>
            <input type="text" v-model="form.produk_darah" class="input-rme" />
          </div>
          <div>
            <label>Waktu Permintaan :</label>
            <input type="time" v-model="form.waktu_permintaan" class="input-rme" />
          </div>
        </div>
        
        <div class="form-row-3-3">
          <div>
            <label>No. Kantong :</label>
            <input type="text" v-model="form.no_kantong" class="input-rme" />
          </div>
          <div>
            <label>Vol. Transfusi (ml) :</label>
            <input type="text" v-model="form.vol_transfusi" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= CLERICAL CHECK & TEMPERATUR ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Clerical Check & Temperatur</h5>
        
        <div style="display: flex; gap: 40px; margin-bottom: 15px;">
          <div style="flex: 1;">
            <h6 style="font-weight: bold; margin-bottom: 10px;">Clerical Check :</h6>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <div style="display: flex; align-items: center; gap: 20px;">
                <span style="min-width: 200px;">Pasien ID</span>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.clerical_pasien_id" value="ya" /> Ya
                </label>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.clerical_pasien_id" value="tidak" /> Tidak
                </label>
              </div>
              <div style="display: flex; align-items: center; gap: 20px;">
                <span style="min-width: 200px;">Bag Darah</span>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.clerical_bag_darah" value="ya" /> Ya
                </label>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.clerical_bag_darah" value="tidak" /> Tidak
                </label>
              </div>
              <div style="display: flex; align-items: center; gap: 20px;">
                <span style="min-width: 200px;">Rekord Transfusi Darah</span>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.clerical_rekord_transfusi" value="ya" /> Ya
                </label>
                <label class="checkbox-label">
                  <input type="radio" v-model="form.clerical_rekord_transfusi" value="tidak" /> Tidak
                </label>
              </div>
            </div>
          </div>
          
          <div style="flex: 1;">
            <h6 style="font-weight: bold; margin-bottom: 10px;">Temperatur dalam 24 jam selama transfusi :</h6>
            <div style="display: flex; gap: 30px;">
              <label class="checkbox-label">
                <input type="radio" v-model="form.temperatur_24jam" value="febris" />
                FEBRIS (< 38° C)
              </label>
              <label class="checkbox-label">
                <input type="radio" v-model="form.temperatur_24jam" value="afebris" />
                AFEBRIS (< 38° C)
              </label>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= VITAL SIGN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Vital Sign</h5>
        
        <table style="width: 100%; border-collapse: collapse; border: 2px solid #333;">
          <thead>
            <tr>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0; width: 30%;">Keterangan</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">Waktu</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">Temperatur</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">H.R</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">B.P</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">Pulse</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="border: 2px solid #333; padding: 10px;">Pre reaksi alergi</td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="time" v-model="form.pre_waktu" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.pre_temperatur" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.pre_hr" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.pre_bp" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.pre_pulse" class="input-rme" />
              </td>
            </tr>
            <tr>
              <td style="border: 2px solid #333; padding: 10px;">Waktu terjadi reaksi</td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="time" v-model="form.reaksi_waktu" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.reaksi_temperatur" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.reaksi_hr" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.reaksi_bp" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="form.reaksi_pulse" class="input-rme" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ================= OBAT PREMEDIKASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Obat Premedikasi</h5>
        
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.obat_antipiretik" :true-value="1" :false-value="0" />
            A. Antipiretik
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.obat_antihistamin" :true-value="1" :false-value="0" />
            B. Antihistamin
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.obat_steroid" :true-value="1" :false-value="0" />
            C. Steroid
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.obat_diuretik" :true-value="1" :false-value="0" />
            D. Diuretik
          </label>
        </div>
      </div>

      <!-- ================= TANDA DAN GEJALA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tanda dan Gejala</h5>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_demam" :true-value="1" :false-value="0" />
            Demam
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_pusing" :true-value="1" :false-value="0" />
            Pusing
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_kejang" :true-value="1" :false-value="0" />
            Kejang
          </label>
          
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_sesak_nafas" :true-value="1" :false-value="0" />
            Sesak Nafas
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_menggigil" :true-value="1" :false-value="0" />
            Menggigil
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_sakit_kepala" :true-value="1" :false-value="0" />
            Sakit Kepala
          </label>
          
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_nyeri_dada" :true-value="1" :false-value="0" />
            Nyeri Dada
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_gatal" :true-value="1" :false-value="0" />
            Gatal - gatal
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_mual" :true-value="1" :false-value="0" />
            Mual - mual
          </label>
          
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_lower_back_pain" :true-value="1" :false-value="0" />
            Lower back pain
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_bentol" :true-value="1" :false-value="0" />
            Bentol - bentol
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_muntah" :true-value="1" :false-value="0" />
            Muntah
          </label>
          
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_lain_lain" :true-value="1" :false-value="0" />
            Lain - lain
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_urine_gelap" :true-value="1" :false-value="0" />
            Urine Gelap
          </label>
          <label class="checkbox-label">
            <input type="checkbox" v-model="form.gejala_pendarahan" :true-value="1" :false-value="0" />
            Pendarahan dari luka atau IV
          </label>
        </div>
      </div>

      <!-- ================= PEMBERIAN DARAH DIBAWAH 12 JAM ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pemberian darah yang diberikan dibawah 12 jam</h5>
        
        <table style="width: 100%; border-collapse: collapse; border: 2px solid #333;">
          <thead>
            <tr>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" rowspan="2">Donor Unit</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" rowspan="2">Tipe Darah</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" rowspan="2">Tanggal</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" colspan="2">Waktu</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" rowspan="2">Vol. darah yang masuk</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" rowspan="2">Reaksi Ya/Tidak</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;" rowspan="2">Aksi</th>
            </tr>
            <tr>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">Mulai</th>
              <th style="border: 2px solid #333; padding: 10px; background-color: #f0f0f0;">Stop</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in form.pemberian_darah" :key="index">
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="item.donor_unit" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="item.tipe_darah" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="date" v-model="item.tanggal" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="time" v-model="item.waktu_mulai" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="time" v-model="item.waktu_stop" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <input type="text" v-model="item.volume" class="input-rme" />
              </td>
              <td style="border: 2px solid #333; padding: 5px;">
                <select v-model="item.reaksi" class="input-rme">
                  <option value="">-</option>
                  <option value="ya">Ya</option>
                  <option value="tidak">Tidak</option>
                </select>
              </td>
              <td style="border: 2px solid #333; padding: 5px; text-align: center;">
                <button @click="hapusPemberianDarah(index)" class="btn-delete" v-if="form.pemberian_darah.length > 1">
                  ✕
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        
        <button @click="tambahPemberianDarah" class="btn-add mt-2">
          + Tambah Baris
        </button>
      </div>

      <!-- ================= DOKTER PENGIRIM INFO ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Dokter Pengirim</h5>
        
        <div class="form-row-3-3">
          <!-- <div>
            <label>Nama :</label>
            <input type="text" v-model="form.dokter_nama" class="input-rme" />
          </div> -->
          <div>
            <label>Nama :</label>
            <select v-model="form.dokter_nama" class="form-select-dokter">
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
          <div>
            <label>Telp. HP :</label>
            <input type="text" v-model="form.dokter_telp" class="input-rme" />
          </div>
        </div>
        
        <div class="form-row-3-3">
          <div>
            <label>Tanggal :</label>
            <input type="date" v-model="form.dokter_tanggal" class="input-rme" />
          </div>
        </div>
        
        <div style="margin-top: 20px;">
          <label class="fw-bold mb-2">Tanda Tangan Dokter</label>
          <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto" />
          <div class="dropdown-dokter mt-2">
              <select v-model="form.dokter_nama" class="form-select-dokter">
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
          <div class="signature-actions mt-2">
          <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Clear ↻</button>
          <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button>
          </div>
        </div>
      </div>

      <!-- ================= CATATAN KAKI ================= -->
      <div class="box-rme mb-4" style="background-color: #f9f9f9;">
        <h6 style="font-weight: bold; margin-bottom: 10px;">Pertimbangkan :</h6>
        <ul style="margin: 0; padding-left: 25px; font-size: 14px; line-height: 1.8;">
          <li>Indikasi transfusi darah jika Hb < 7 gr/dl</li>
          <li>Akhir transfusi cukup sampai Hb ± 10 gr/dl</li>
        </ul>
      </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer"  v-if="!disabledSubmit">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>{{ isEditMode ? 'Update' : 'Simpan' }}</span>
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
  name: "FormReaksiTransfusiDarah",
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
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        alamat: "",
        
        // Dokter & Jenis Rawat
        dokter_pengirim: "",
        jenis_rawat: "",
        tanggal: "",
        
        // Informasi Transfusi
        instalansi: "",
        tanggal_transfusi: "",
        diagnosa_klinis: "",
        produk_darah: "",
        waktu_permintaan: "",
        no_kantong: "",
        vol_transfusi: "",
        
        // Clerical Check
        clerical_pasien_id: "",
        clerical_bag_darah: "",
        clerical_rekord_transfusi: "",
        temperatur_24jam: "",
        
        // Vital Sign - Pre
        pre_waktu: "",
        pre_temperatur: "",
        pre_hr: "",
        pre_bp: "",
        pre_pulse: "",
        
        // Vital Sign - Reaksi
        reaksi_waktu: "",
        reaksi_temperatur: "",
        reaksi_hr: "",
        reaksi_bp: "",
        reaksi_pulse: "",
        
        // Obat Premedikasi
        obat_antipiretik: 0,
        obat_antihistamin: 0,
        obat_steroid: 0,
        obat_diuretik: 0,
        
        // Tanda dan Gejala
        gejala_demam: 0,
        gejala_pusing: 0,
        gejala_kejang: 0,
        gejala_sesak_nafas: 0,
        gejala_menggigil: 0,
        gejala_sakit_kepala: 0,
        gejala_nyeri_dada: 0,
        gejala_gatal: 0,
        gejala_mual: 0,
        gejala_lower_back_pain: 0,
        gejala_bentol: 0,
        gejala_muntah: 0,
        gejala_lain_lain: 0,
        gejala_urine_gelap: 0,
        gejala_pendarahan: 0,
        
        // Pemberian Darah (array)
        pemberian_darah: [
          {
            donor_unit: "",
            tipe_darah: "",
            tanggal: "",
            waktu_mulai: "",
            waktu_stop: "",
            volume: "",
            reaksi: "",
          },
        ],
        
        // Dokter Pengirim
        dokter_nama: "",
        dokter_telp: "",
        dokter_tanggal: "",
        ttd_dokter: "",
      },
    };
  },
  computed: {
    displayTanggalLahir() {
      if (!this.form.tanggal_lahir) return "";
      
      const birthDate = new Date(this.form.tanggal_lahir);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      
      const formattedDate = birthDate.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });
      
      return `${formattedDate} (${age} tahun)`;
    },

    isEditMode() {
      return this.editData !== null && this.editData !== undefined;
    }
  },
  
async mounted() { 
  console.log("🟢 COMPONENT - Mounted");
  console.log("🟢 COMPONENT - editData:", this.editData);
  console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);

  await this.fetchDokter();
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

    async fetchDokter() {
      try {
        const response = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = response.data.data;
      } catch (error) {
        console.error('Gagal memuat data dokter:', error);
      }
    },

  async fetchTahunAkreditasi() {
    try {
      const response = await axios.get('/api/tahun-akreditasi');
      const tahun = response.data.tahun || '22';
      
      if (!this.form.no_surat) {
        this.form.no_surat = `RM 6.2/FRTD/${tahun}`;
      }
      
      console.log("✅ Tahun akreditasi:", tahun);
      console.log("✅ No surat:", this.form.no_surat);
    } catch (error) {
      console.error("❌ Error fetch tahun:", error);
      if (!this.form.no_surat) {
        this.form.no_surat = 'RM 6.2/FRTD/22';
      }
    }
  },

saveSign(refName) {
  const pad = this.$refs[refName];
  if (!pad) {
    console.error("REF tidak ditemukan:", refName);
    return;
  }

  const { data } = pad.saveSignature();
  
  if (refName === "ttd_dokter") {
    this.form.ttd_dokter = data;
  }
  
  console.log("TTD saved:", refName);
  alert("Tanda tangan berhasil disimpan!");
},

loadDataForEdit() {
  console.log("🟢 LOAD EDIT - Mulai load data");
  console.log("🟢 LOAD EDIT - editData yang diterima:", this.editData);
  
  try {
    if (!this.editData) {
      console.warn("🟢 LOAD EDIT - Tidak ada editData!");
      this.setDataForm();
      return;
    }

    // ✅ Populate form dengan data dari editData
    Object.keys(this.form).forEach((key) => {
      if (this.editData.hasOwnProperty(key)) {
        let value = this.editData[key];
        
        // Handle checkbox/integer fields
        if (key.startsWith('obat_') || key.startsWith('gejala_')) {
          this.form[key] = value ? 1 : 0;
        } 
        // Handle array JSON (pemberian_darah)
        else if (key === 'pemberian_darah') {
          if (typeof value === 'string') {
            try {
              this.form[key] = JSON.parse(value);
              console.log(`🟢 Parsed ${key}:`, this.form[key]);
            } catch (e) {
              console.error(`🟢 Error parsing ${key}:`, e);
              this.form[key] = [{
                donor_unit: "",
                tipe_darah: "",
                tanggal: "",
                waktu_mulai: "",
                waktu_stop: "",
                volume: "",
                reaksi: "",
              }];
            }
          } else if (Array.isArray(value)) {
            this.form[key] = value;
          }
        }
        // Handle normal fields
        else {
          this.form[key] = value !== null ? value : "";
        }
        
        console.log(`🟢 Set ${key}:`, this.form[key]);
      }
    });

    // ✅ PENTING: Pastikan pemberian_darah minimal ada 1 row
    if (!this.form.pemberian_darah || this.form.pemberian_darah.length === 0) {
      this.form.pemberian_darah = [{
        donor_unit: "",
        tipe_darah: "",
        tanggal: "",
        waktu_mulai: "",
        waktu_stop: "",
        volume: "",
        reaksi: "",
      }];
    }

    console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);
    // ✅ RENDER TTD SETELAH FORM TERISI SEMUA
this.renderSignature("ttd_dokter", this.form.ttd_dokter);


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
      const todayStr = today.toISOString().split("T")[0];
      
      this.form.tanggal = todayStr;
      this.form.tanggal_transfusi = todayStr;
      this.form.dokter_tanggal = todayStr;

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid || "";
        this.form.no_rm = this.selectedPatient.rekam_medis || "";
        this.form.nik = this.selectedPatient.no_identitas || "";
        this.form.nama = this.selectedPatient.nama || "";
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir || "";
        this.form.alamat = this.selectedPatient.alamat || "";
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }
    },

    tambahPemberianDarah() {
      this.form.pemberian_darah.push({
        donor_unit: "",
        tipe_darah: "",
        tanggal: "",
        waktu_mulai: "",
        waktu_stop: "",
        volume: "",
        reaksi: "",
      });
    },

    hapusPemberianDarah(index) {
      if (this.form.pemberian_darah.length > 1) {
        this.form.pemberian_darah.splice(index, 1);
      }
    },

clearSign(refName) {
  const pad = this.$refs[refName];
  if (pad) {
    pad.clearSignature();
    if (refName === "ttd_dokter") {
      this.form.ttd_dokter = "";
    }
  }
},


    validateForm() {
      // Validasi minimal
      if (!this.form.uuid_pasien) {
        alert("Data pasien tidak valid!");
        return false;
      }
      
      if (!this.form.jenis_rawat) {
        alert("Silakan pilih jenis rawat!");
        return false;
      }
      
      if (!this.form.tanggal) {
        alert("Tanggal harus diisi!");
        return false;
      }
      
      return true;
    },

async submitForm() {
  // Validasi
  if (!this.validateForm()) {
    return;
  }

  this.loadingSubmit = true;

  try {
    // Get signature
    const padDokter = this.$refs.ttd_dokter;
    if (padDokter && !padDokter.isEmpty()) {
      const { data } = padDokter.saveSignature();
      this.form.ttd_dokter = data;
    }

    // Prepare FormData
    const formData = new FormData();

    // ✅ Append semua field ke FormData (INCLUDING UUID untuk edit mode)
    Object.keys(this.form).forEach((key) => {
      if (key === 'pemberian_darah') {
        // Convert array to JSON string
        formData.append(key, JSON.stringify(this.form[key]));
      } else {
        // Append semua field, termasuk uuid jika ada (untuk edit mode)
        formData.append(key, this.form[key] || '');
      }
    });

    console.log("🟡 SUBMIT - Is Edit Mode:", this.isEditMode);
    console.log("🟡 SUBMIT - UUID:", this.form.uuid);
    console.log("🟡 SUBMIT - Form Data:", Object.fromEntries(formData));

    // ✅ ROUTE TETAP SAMA untuk create dan update
    const response = await axios.post(
      "/master/pasien/form-reaksi-transfusi-darah",
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    );

    console.log("🟡 SUBMIT - Response:", response.data);

    if (response.data.status) {
      alert(response.data.message || "Data berhasil disimpan!");
      this.$emit("back");
    } else {
      alert(response.data.message || "Gagal menyimpan form!");
    }
  } catch (error) {
    console.error("🟡 SUBMIT - ERROR:", error);
    
    let errorMsg = "Gagal menyimpan form!";
    
    if (error.response?.data) {
      errorMsg = error.response.data.message || errorMsg;
      
      if (error.response.data.errors) {
        const errors = error.response.data.errors;
        const errorList = Object.keys(errors)
          .map(key => `- ${errors[key][0]}`)
          .join('\n');
        errorMsg += '\n\nDetail Error:\n' + errorList;
      }
    } else if (error.request) {
      errorMsg = "Tidak dapat terhubung ke server!";
    }
    
    alert(errorMsg);
  } finally {
    this.loadingSubmit = false;
  }
},
  },
};
</script>

<style scoped>
body {
  font-family: Arial, sans-serif;
  padding: 20px;
  background-color: #f5f5f5;
}

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

.form-row-3-3 {
  display: flex;
  gap: 1rem;
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
  padding: 0.5rem;
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

.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 14px;
}

.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
}

.signature-actions {
  display: flex;
  justify-content: center; /* tombol rata tengah */
  gap: 10px;               /* jarak antar tombol */
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

.btn-clear:hover {
  background: #d32f2f;
}

.btn-add {
  background: #4caf50;
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
}

.btn-add:hover {
  background: #45a049;
}

.btn-delete {
  background: #f44336;
  color: white;
  padding: 4px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  font-size: 16px;
}

.btn-delete:hover {
  background: #d32f2f;
}

.dropdown-dokter {
  position: relative;
  width: 50%;
  margin: 0 auto;
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

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
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

.mb-2 {
  margin-bottom: 8px;
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

.py-4 {
  padding-top: 24px;
  padding-bottom: 24px;
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
  .form-row-3-3 {
    flex-direction: column;
  }
}
</style>