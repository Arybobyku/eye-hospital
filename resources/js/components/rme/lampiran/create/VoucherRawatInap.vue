<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

       <!-- OVERLAY SAAT VIEW -->
     <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">
          CATATAN KUNJUNGAN DOKTER<br>
          <small style="font-size: 15px; font-weight: normal;">
            (DOCTOR VISIT RECORD)
          </small>
        </h2>
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
            <label>Nama :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
        </div>
        
        <div class="form-row-3-3">
          <div>
            <label>Tanggal Lahir :</label>
            <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly />
          </div>
          <div>
            <label>Lantai/Kamar :</label>
            <input type="text" v-model="form.lantai_kamar" class="input-rme" readonly />
          </div>
        </div>
        <div class="form-row-3-3">
          <div>
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= INFORMASI DOKTER ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Dokter</h5>
        
        <div class="form-row-3-3">
          <div>
            <label>Nama Dokter :</label>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter" class="form-select-dokter">
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
          <div>
            <label>Admission Date :</label>
            <input type="date" v-model="form.admission_date" class="input-rme" />
          </div>
          <div>
            <label>Discharge Date :</label>
            <input type="date" v-model="form.discharge_date" class="input-rme" />
          </div>
        </div>
      </div>

      <!-- ================= TABEL KUNJUNGAN DOKTER ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Catatan Kunjungan Dokter</h5>

        <table class="form-rs">
          <thead>
            <tr>
              <th>HARI</th>
              <th>TANGGAL-JAM</th>
              <th>PARAF DOKTER</th>
              <th>PARAF PERAWAT</th>
              <th style="width: 60px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in form.tabel_kunjungan" :key="index">
              <td>
                <input 
                  type="text" 
                  v-model="item.hari" 
                  class="line-input"
                  :disabled="disabledSubmit"
                >
              </td>
              <td>
                <input 
                  type="datetime-local" 
                  v-model="item.tanggal_jam" 
                  class="line-input"
                  :disabled="disabledSubmit"
                >
              </td>
              <td>
                <div class="text-center">
                  <div v-if="item.paraf_dokter && !ttdDokterKunjunganCleared[index]" class="signature-preview text-center">
                    <img :src="item.paraf_dokter" style="width:150px; height:80px; object-fit:contain; border:1px dashed #ccc;" />
                    <br>
                    <button @click="clearSignKunjungan(index, 'dokter')" class="btn-clear mt-2" type="button" v-if="!disabledSubmit">
                      Hapus & TTD Ulang
                    </button>
                  </div>
                  <div v-else>
                    <VueSignaturePad
                      :ref="`ttd_dokter_${index}`"
                      :options="sigOption"
                      class="signature-box-rme-small mx-auto"
                    />
                    <div class="signature-actions mt-2" v-if="!disabledSubmit">
                      <button @click="saveSignKunjungan(index, 'dokter')" class="btn-save" type="button">Simpan ✔</button>
                    </div>
                  </div>

            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter" class="form-select-dokter">
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
              </td>
              <td>
                <div class="text-center">
                  <div v-if="item.paraf_perawat && !ttdPerawatKunjunganCleared[index]" class="signature-preview text-center">
                    <img :src="item.paraf_perawat" style="width:150px; height:80px; object-fit:contain; border:1px dashed #ccc;" />
                    <br>
                    <button @click="clearSignKunjungan(index, 'perawat')" class="btn-clear mt-2" type="button" v-if="!disabledSubmit">
                      Hapus & TTD Ulang
                    </button>
                  </div>
                  <div v-else>
                    <VueSignaturePad
                      :ref="`ttd_perawat_${index}`"
                      :options="sigOption"
                      class="signature-box-rme-small mx-auto"
                    />
                    <div class="signature-actions mt-2" v-if="!disabledSubmit">
                      <button @click="saveSignKunjungan(index, 'perawat')" class="btn-save" type="button">Simpan ✔</button>
                    </div>
                  </div>
                  <input
                    type="text"
                    v-model="item.nama_perawat"
                    class="input-rme mt-2"
                    placeholder="Nama Perawat"
                    :disabled="disabledSubmit"
                  />
                </div>
              </td>
              <td style="text-align: center;">
                <button 
                  @click="hapusTabelKunjungan(index)" 
                  class="btn-delete-small" 
                  v-if="form.tabel_kunjungan.length > 1 && !disabledSubmit"
                  type="button"
                  title="Hapus baris"
                >
                  ✕
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Tombol Tambah Baris -->
        <button 
          @click="tambahTabelKunjungan" 
          class="btn-add mt-2"
          type="button"
          v-if="!disabledSubmit"
        >
          ➕ Tambah Baris
        </button>

        <div class="italic-note mt-3">
          <p><strong><em>FORMULIR INI HANYA UNTUK SATU DOKTER. HARAP GUNAKAN FORMULIR LAIN UNTUK DOKTER YANG BERBEDA</em></strong></p>
        </div>
      </div>

      <!-- ================= VOUCHER HONOR PROFESI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Voucher Honor Profesi (Professional Charges Voucher)</h5>
        
        <!-- Perawatan-Visite -->
        <div class="form-row-2 mb-3">
          <div>
            <label>Perawatan-Visite (Kunjungan) :</label>
          </div>
          <div>
            <input type="text" v-model="form.perawatan_visite" class="input-rme" placeholder="Rp. ................../Hari" />
          </div>
        </div>

        <!-- Jenis Tarif Operasi -->
        <div class="mb-3">
          <label class="fw-bold mb-2">Jenis Tarif Operasi :</label>
          <div class="grid-4">
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.tarif_pribadi" true-value="1" false-value="0"> Pribadi
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.tarif_rumah_sakit" true-value="1" false-value="0"> Rumah Sakit
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.tarif_perusahaan" true-value="1" false-value="0"> Perusahaan
            </label>
            <label class="checkbox-label">
              <input type="checkbox" v-model="form.tarif_staff" true-value="1" false-value="0"> Staff RSKMPV
            </label>
          </div>
        </div>

        <!-- Operasi -->
        <div class="mb-3">
          <label class="fw-bold mb-2">Operasi :</label>
          <div class="form-row-2">
            <div>
              <label>Besar :</label>
            </div>
            <div>
              <input type="text" v-model="form.operasi_besar" class="input-rme" placeholder="Rp. ...................." />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Sedang :</label>
            </div>
            <div>
              <input type="text" v-model="form.operasi_sedang" class="input-rme" placeholder="Rp. ...................." />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Kecil :</label>
            </div>
            <div>
              <input type="text" v-model="form.operasi_kecil" class="input-rme" placeholder="Rp. ...................." />
            </div>
          </div>
        </div>

        <!-- Anasthesi -->
        <div class="form-row-2 mb-3">
          <div>
            <label>Anasthesi :</label>
          </div>
          <div>
            <input type="text" v-model="form.anasthesi" class="input-rme" />
          </div>
        </div>

        <!-- Dokter Konsultan -->
        <div class="form-row-2 mb-3">
          <div>
            <label>Dokter Konsultan :</label>
          </div>
          <div>
            <input type="text" v-model="form.dokter_konsultan" class="input-rme" />
          </div>
        </div>

        <!-- Partus -->
        <div class="mb-3">
          <label class="fw-bold mb-2">Partus :</label>
          <div class="form-row-2">
            <div>
              <label>Biasa/Normal :</label>
            </div>
            <div>
              <input type="text" v-model="form.partus_normal" class="input-rme" placeholder="Rp. ...................." />
            </div>
          </div>
          <div class="form-row-2">
            <div>
              <label>Vacuum, Biopsy :</label>
            </div>
            <div>
              <input type="text" v-model="form.partus_vacuum" class="input-rme" placeholder="Rp. ...................." />
            </div>
          </div>
        </div>

        <!-- Informasi Pembuat -->
        <div class="signature-row-2 mt-4">
          <div>
            <label class="fw-bold mb-2">Date :</label>
            <input type="date" v-model="form.date_voucher" class="input-rme" />
          </div>
          <div>
            <label class="fw-bold mb-2">Time :</label>
            <input type="time" v-model="form.time_voucher" class="input-rme" />
          </div>
        </div>

        <div class="signature-row-2 mt-4">
          <div>
            <label class="fw-bold mb-2">Dibuat Oleh :</label>
            <input type="text" v-model="form.dibuat_oleh" class="input-rme" placeholder="Kepala Keperawatan" />
            <div v-if="form.ttd_dibuat_oleh && !ttdDibuatOlehCleared" class="signature-preview text-center">
              <img :src="form.ttd_dibuat_oleh" alt="TTD Dibuat Oleh" class="img-signature" />
              <button @click="clearSign('ttd_dibuat_oleh')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_dibuat_oleh" :options="sigOption" class="signature-box-rme mx-auto mt-2" />
              <button @click="saveSign('ttd_dibuat_oleh')" class="btn-save mt-2">Simpan ✔</button>
            </div>
          </div>
        
          <div>
            <label class="fw-bold mb-2">Dokter (Tanda Tangan & Nama Jelas) :</label>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter_voucher" class="form-select-dokter">
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
            <div v-if="form.ttd_dokter && !ttdDokterCleared" class="signature-preview text-center">
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <button @click="clearSign('ttd_dokter')" class="btn-clear mt-2">Hapus & Tanda Tangan Ulang</button>
            </div>
            <div v-else class="text-center">
              <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme mx-auto mt-2" />
              <button @click="saveSign('ttd_dokter')" class="btn-save mt-2">Simpan ✔</button>
            </div>
          </div>
        </div>

        <div class="italic-note mt-3">
          <p><em>JIKA DOKTER MEMBERITAHUKAN HONORNYA MELALUI TELEPON ATAUPUN SECARA LISAN, MOHON KEPADA STAFF YANG MENERIMANYA MENJELASKAN NAMA DAN TANDA TANGAN DI FORM INI UNTUK MEWAKILI DOKTER.</em></p>
        </div>
      </div>

      <!-- ================= BUTTON BOTTOM ================= -->
      <div class="action-footer" v-if="!disabledSubmit">
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
</div>
</template>

<script>
import axios from "axios";

export default {
  name: "VoucherRawatInap",
  
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
      disabledSubmit: false, // ← ini juga belum ada!
      ttdDibuatOlehCleared: false,
      ttdDokterCleared: false,
      ttdDokterKunjunganCleared: [],
      ttdPerawatKunjunganCleared: [],
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        
        // Data Pasien
        no_rm: "",
        nama: "",
        tanggal_lahir: "",
        lantai_kamar: "",
        jenis_kelamin: "",
        
        // Informasi Dokter
        nama_dokter: "",
        admission_date: "",
        discharge_date: "",
        
        // ✅ TAMBAHAN SAJA
        tabel_kunjungan: [
          {
            hari: "",
            tanggal_jam: "",
            paraf_dokter: "",
            nama_dokter: "",
            paraf_perawat: "",
            nama_perawat: "",
          }
        ],
        
        // Voucher Honor Profesi
        perawatan_visite: "",
        
        // Jenis Tarif Operasi
        tarif_pribadi: "0",
        tarif_rumah_sakit: "0",
        tarif_perusahaan: "0",
        tarif_staff: "0",
        
        // Operasi
        operasi_besar: "",
        operasi_sedang: "",
        operasi_kecil: "",
        
        // Lainnya
        anasthesi: "",
        dokter_konsultan: "",
        
        // Partus
        partus_normal: "",
        partus_vacuum: "",
        
        // Tanda Tangan
        date_voucher: "",
        time_voucher: "",
        dibuat_oleh: "",
        ttd_dibuat_oleh: "",
        nama_dokter_voucher: "",
        ttd_dokter: "",
        
        created_by: "",
        updated_by: "",
      }
    };
  },
  
  async mounted() {
    await this.fetchDokter();
    console.log("🟢 COMPONENT - Mounted");
    console.log("🟢 COMPONENT - editData:", this.editData);
    console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
    
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
    loadDataForEdit() {
      console.log("🟢 LOAD EDIT - Mulai load data");
      console.log("🟢 LOAD EDIT - editData yang diterima:", this.editData);
      
      try {
        // ✅ TIDAK DIUBAH - tetap pakai this.editData (atau this.viewData kalau ada)
        const dataSource = this.editData || this.viewData;
        
        if (!dataSource) {
          console.warn("🟢 LOAD EDIT - Tidak ada editData!");
          this.setDataForm(); // Fallback ke create mode
          return;
        }

        // ✅ Populate form dengan data dari editData - TIDAK DIUBAH
        Object.keys(this.form).forEach((key) => {
          // ✅ HANYA TAMBAHAN INI
          if (key === 'tabel_kunjungan') return;
          
          if (dataSource.hasOwnProperty(key)) {
            // Konversi value yang mungkin berbeda tipe
            let value = dataSource[key];
            
            // Handle checkbox (convert ke string "0" atau "1")
            if (key.startsWith('check_')) {
              this.form[key] = value ? "1" : "0";
            } else {
              this.form[key] = value !== null ? value : "";
            }
            
            console.log(`🟢 Set ${key}:`, this.form[key]);
          }
        });

        // ✅ TAMBAHAN: Handle tabel_kunjungan
        if (dataSource.tabel_kunjungan) {
          if (typeof dataSource.tabel_kunjungan === 'string') {
            try {
              this.form.tabel_kunjungan = JSON.parse(dataSource.tabel_kunjungan);
            } catch (e) {
              console.error("Error parsing tabel_kunjungan:", e);
            }
          } else if (Array.isArray(dataSource.tabel_kunjungan)) {
            this.form.tabel_kunjungan = dataSource.tabel_kunjungan;
          }
        }

        console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);

        // ✅ TAMBAHAN: Load TTD
        this.$nextTick(() => {
          this.loadSignaturesToCanvas();
        });

      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    // ✅ METHOD BARU
    loadSignaturesToCanvas() {
      if (this.form.ttd_dibuat_oleh) this.ttdDibuatOlehCleared = false;
      if (this.form.ttd_dokter) this.ttdDokterCleared = false;
    
      this.ttdDokterKunjunganCleared = this.form.tabel_kunjungan.map(item => !item.paraf_dokter);
      this.ttdPerawatKunjunganCleared = this.form.tabel_kunjungan.map(item => !item.paraf_perawat);
    },

    setDataForm() {
      const today = new Date();
      this.form.date_voucher = today.toISOString().split("T")[0];
      this.form.time_voucher = today.toTimeString().substring(0, 5);
      this.form.admission_date = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin;
      }
    },
    
    // ✅ METHOD BARU untuk tabel dinamis
    tambahTabelKunjungan() {
      this.form.tabel_kunjungan.push({
        hari: "", tanggal_jam: "", paraf_dokter: "",
        nama_dokter: "", paraf_perawat: "", nama_perawat: "",
      });
      this.ttdDokterKunjunganCleared.push(false);
      this.ttdPerawatKunjunganCleared.push(false);
    },

    hapusTabelKunjungan(index) {
      if (this.form.tabel_kunjungan.length > 1) {
        this.form.tabel_kunjungan.splice(index, 1);
        this.ttdDokterKunjunganCleared.splice(index, 1);
        this.ttdPerawatKunjunganCleared.splice(index, 1);
      }
    },

    saveSignKunjungan(index, type) {
      const refName = `ttd_${type}_${index}`;
      const pad = this.$refs[refName];
      const signaturePad = Array.isArray(pad) ? pad[0] : pad;
      if (!signaturePad) return;
    
      const { isEmpty, data } = signaturePad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
    
      this.form.tabel_kunjungan[index][`paraf_${type}`] = data;
    
      if (type === 'dokter') this.ttdDokterKunjunganCleared[index] = false;
      else this.ttdPerawatKunjunganCleared[index] = false;
    },

    clearSignKunjungan(index, type) {
      if (type === 'dokter') {
        this.ttdDokterKunjunganCleared[index] = true;
        this.form.tabel_kunjungan[index].paraf_dokter = "";
      } else {
        this.ttdPerawatKunjunganCleared[index] = true;
        this.form.tabel_kunjungan[index].paraf_perawat = "";
      }
    
      this.$nextTick(() => {
        this.$nextTick(() => {
          const pad = this.$refs[`ttd_${type}_${index}`];
          const signaturePad = Array.isArray(pad) ? pad[0] : pad;
          if (signaturePad) signaturePad.clearSignature();
        });
      });
    },
    
    // ✅ SEMUA METHOD LAMA TIDAK DIUBAH SAMA SEKALI
    saveSignRow(rowNum, type) {
      const refName = `ttd_${type}_${rowNum}`;
      const fieldName = `row${rowNum}_paraf_${type}`;
      
      const pad = this.$refs[refName];
      const signaturePad = Array.isArray(pad) ? pad[0] : pad;
      
      if (!signaturePad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }
    
      if (signaturePad.isEmpty()) {
        alert("Silakan buat tanda tangan terlebih dahulu!");
        return;
      }
    
      const { data } = signaturePad.saveSignature();
      this.form[fieldName] = data;
      
      console.log(`TTD ${type} Row ${rowNum} saved to ${fieldName}`);
      alert(`Tanda tangan ${type} berhasil disimpan!`);
    },

clearSign(refName) {
  const flagMap = {
    ttd_dibuat_oleh: 'ttdDibuatOlehCleared',
    ttd_dokter: 'ttdDokterCleared',
  };

  if (flagMap[refName] !== undefined) {
    this[flagMap[refName]] = true;
    this.form[refName] = "";
  }

  this.$nextTick(() => {
    const pad = this.$refs[refName];
    if (pad) pad.clearSignature();
  });
},

    clearSignRow(rowNum, type) {
      const refName = `ttd_${type}_${rowNum}`;
      const pad = this.$refs[refName];
      const signaturePad = Array.isArray(pad) ? pad[0] : pad;

      if (!signaturePad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      signaturePad.clearSignature();
    },

saveSign(refName) {
  const pad = this.$refs[refName];
  const signaturePad = Array.isArray(pad) ? pad[0] : pad;
  if (!signaturePad) {
    console.error("REF tidak ditemukan:", refName);
    return;
  }

  const { isEmpty, data } = signaturePad.saveSignature();
  if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

  const flagMap = {
    ttd_dibuat_oleh: 'ttdDibuatOlehCleared',
    ttd_dokter: 'ttdDokterCleared',
  };
  if (flagMap[refName] !== undefined) this[flagMap[refName]] = false;

  this.form[refName] = data;
  console.log("TTD saved:", refName);
},

    async submitForm() {
      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          // ✅ HANYA TAMBAHAN INI
          if (key === 'tabel_kunjungan') return;
          
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          fd.append(key, this.form[key] || "");
        });

        // ✅ TAMBAHAN: append tabel_kunjungan
        fd.append('tabel_kunjungan', JSON.stringify(this.form.tabel_kunjungan));

        const url = this.isEditMode && this.form.uuid
          ? `/master/pasien/voucher-rawat-inap/${this.form.uuid}`
          : "/master/pasien/voucher-rawat-inap";
        
        const method = this.isEditMode ? "post" : "post";
        
        if (this.isEditMode) {
          fd.append("_method", "PUT");
        }

        const response = await axios[method](url, fd, {
          headers: { "Content-Type": "multipart/form-data" }
        });

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

.btn-clear {
  background: #f44336;
  color: white;
  padding: 6px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
}

.signature-actions {
  display: flex;
  justify-content: center;
  gap: 6px; /* atur jarak DI SINI */
}
.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #f9f9f9;
  font-size: 17px;
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

.form-row-3-3 {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.form-row-3-3 > div {
  flex: 1;
  min-width: 0;
}

.form-row-2 {
  display: flex;
  gap: 1rem;
  margin-bottom: 0.5rem;
}

.form-row-2 > div {
  flex: 1;
}

.btn-add {
  background: #4caf50;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
}

.btn-add:hover {
  background: #45a049;
}

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

.btn-delete-small {
  background: #f44336;
  color: white;
  border: none;
  width: 30px;
  height: 30px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-delete-small:hover {
  background: #d32f2f;
}

.signature-row-2 {
  display: flex;
  gap: 2rem;
  margin-top: 1.5rem;
}

.signature-row-2 > div {
  flex: 1;
  text-align: center;
}

.grid-4 {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 15px;
}

.checkbox-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  font-size: 17px;
}

.form-rs {
  width: 100%;
  border-collapse: collapse;
  font-size: 17px;
  margin-top: 10px;
}

.form-rs th,
.form-rs td {
  border: 1px solid #000;
  padding: 8px 6px;
  vertical-align: middle;
  text-align: center;
}

.form-rs th {
  background-color: #f0f0f0;
  font-weight: bold;
}

.line-input {
  width: 100%;
  border: none;
  padding: 4px;
  font-size: 17px;
  text-align: center;
}

.italic-note {
  text-align: center;
  font-style: italic;
  font-size: 17px;
  padding: 10px;
  background: #f9f9f9;
  border-radius: 4px;
}

.signature-box-rme {
  width: 350px !important;
  height: 220px !important;
  border: 2px solid #ccc;
  border-radius: 6px;
  margin: 0 auto;
}

.signature-preview {
  width: 100%;
  background: white;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.img-signature {
  max-width: 100%;
  height: 180px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
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
  font-size: 17px;
  color: #333;
}

.text-center {
  text-align: center;
}

.signature-box-rme-small {
  width: 150px !important;   /* lebih kecil */
  height: 80px !important;  /* lebih kecil */
  border: 1px solid #000;
  border-radius: 4px;
}

.fw-bold {
  font-weight: bold;
}

.fw-semibold {
  font-weight: 600;
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

.mt-3 {
  margin-top: 16px;
}

.mt-4 {
  margin-top: 24px;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
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
  .form-row-3-3,
  .form-row-2,
  .signature-row-2 {
    flex-direction: column;
  }

  .grid-4 {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>