<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <!-- LOADING OVERLAY -->
    <div v-if="loadingData" class="loading-overlay">
      <div class="spinner-rme"></div>
      <p>Memuat data...</p>
    </div>

    <!-- ================= HEADER ================= -->
    <div class="text-center mb-4">
      <img src="/logo-rs.png" alt="Logo RS" class="logo-rs mb-3" style="max-width: 150px" />
      <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
      <p class="mb-1">VISION FOR THE NATION</p>
      <p class="mb-1">PRIMA VISION EYE HOSPITAL - 24 HOURS EYE ACCIDENT & EMERGENCY UNIT</p>
      <p class="mb-1">Jalan Pabrik Tenun No. 51-53, Medan Perjuangan 20112, Sumatera Utara, Indonesia</p>
      <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
      <p class="mb-1">24 Hours Eye Emergency Hotline: 0822 7755 5151</p>
      <p class="mb-3">Email: rsprimavision@gmail.com</p>
      <hr class="my-3" style="border: 2px solid #000" />
      
      <h3 class="fw-bold mt-4 mb-4">FORM KRONOLOGIS PASIEN</h3>
      <p class="text-muted">RM 9.7FKP/22</p>
      
      <span v-if="isEditMode" class="badge bg-warning">Mode Edit</span>
      <span v-else class="badge bg-success">Mode Baru</span>
    </div>

    <!-- ================= DATA PASIEN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Data Pasien</h5>
      
      <div class="row mb-2">
        <div class="col-md-6">
          <label>Nama Pasien :</label>
          <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
        </div>
        <div class="col-md-6">
          <label>No. Rekam Medis :</label>
          <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Tanggal Lahir :</label>
          <input type="text" v-model="form.tanggal_lahir_display" class="input-rme" readonly />
        </div>
        <div class="col-md-6">
          <label>NIK Pasien :</label>
          <input type="text" v-model="form.nik_pasien" class="input-rme" readonly />
        </div>
      </div>
    </div>

    <!-- ================= DATA PEMBUAT KRONOLOGIS ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Saya yang bertanda tangan dibawah ini :</h5>
      
      <div class="row mb-3">
        <div class="col-md-12">
          <label>1. Nama : <span class="text-danger">*</span></label>
          <input 
            type="text" 
            v-model="form.nama_pembuat" 
            class="form-control"
            placeholder="Nama lengkap pembuat kronologis"
          />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>2. Alamat : <span class="text-danger">*</span></label>
          <textarea 
            v-model="form.alamat_pembuat" 
            class="form-control" 
            rows="2"
            placeholder="Alamat lengkap pembuat kronologis"
          ></textarea>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>3. NIK : <span class="text-danger">*</span></label>
          <input 
            type="text" 
            v-model="form.nik_pembuat" 
            class="form-control"
            placeholder="Nomor Induk Kependudukan"
            maxlength="16"
          />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>4. Hubungan dengan pasien : <span class="text-danger">*</span></label>
          
          <div class="hubungan-group">
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.hubungan_pasien" 
                value="Ayah Kandung"
                class="form-check-input" 
                id="hubAyah"
              />
              <label class="form-check-label" for="hubAyah">Ayah Kandung</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.hubungan_pasien" 
                value="Ibu Kandung"
                class="form-check-input" 
                id="hubIbu"
              />
              <label class="form-check-label" for="hubIbu">Ibu Kandung</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.hubungan_pasien" 
                value="Anak Kandung"
                class="form-check-input" 
                id="hubAnak"
              />
              <label class="form-check-label" for="hubAnak">Anak Kandung</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.hubungan_pasien" 
                value="Suami"
                class="form-check-input" 
                id="hubSuami"
              />
              <label class="form-check-label" for="hubSuami">Suami</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.hubungan_pasien" 
                value="Istri"
                class="form-check-input" 
                id="hubIstri"
              />
              <label class="form-check-label" for="hubIstri">Istri</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.hubungan_pasien" 
                value="Lainnya"
                class="form-check-input" 
                id="hubLainnya"
              />
              <label class="form-check-label" for="hubLainnya">Lainnya</label>
            </div>
            
            <div v-if="form.hubungan_pasien === 'Lainnya'" class="mt-2">
              <input 
                type="text" 
                v-model="form.hubungan_pasien_lainnya" 
                class="form-control"
                placeholder="Sebutkan hubungan lainnya..."
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= KRONOLOGIS KEJADIAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Dengan ini menerangkan kronologis kejadian yang terjadi pada :</h5>
      
      <div class="row mb-3">
        <div class="col-md-4">
          <label>Tanggal :</label>
          <input 
            type="date" 
            v-model="form.tanggal_kejadian" 
            class="form-control"
          />
        </div>
        <div class="col-md-4">
          <label>Pukul :</label>
          <input 
            type="time" 
            v-model="form.jam_kejadian" 
            class="form-control"
          />
        </div>
        <div class="col-md-4">
          <label>Di (Tempat Kejadian) :</label>
          <input 
            type="text" 
            v-model="form.tempat_kejadian" 
            class="form-control"
            placeholder="Lokasi kejadian"
          />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label class="fw-bold mb-2">Kejadian ini terjadi pada saat :</label>
          
          <div class="kejadian-group mb-3">
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.saat_kejadian" 
                value="Sedang Bekerja"
                class="form-check-input" 
                id="saatSedangKerja"
              />
              <label class="form-check-label" for="saatSedangKerja">Sedang Bekerja</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.saat_kejadian" 
                value="Pergi Bekerja"
                class="form-check-input" 
                id="saatPergiKerja"
              />
              <label class="form-check-label" for="saatPergiKerja">Pergi Bekerja</label>
            </div>
            
            <div class="form-check">
              <input 
                type="radio" 
                v-model="form.saat_kejadian" 
                value="Pulang Bekerja"
                class="form-check-input" 
                id="saatPulangKerja"
              />
              <label class="form-check-label" for="saatPulangKerja">Pulang Bekerja</label>
            </div>
          </div>

          <div class="kejadian-group">
            <div class="form-check">
              <input 
                type="checkbox" 
                v-model="form.lokasi_kecelakaan_lalu_lintas" 
                class="form-check-input" 
                id="lokasiLaluLintas"
              />
              <label class="form-check-label" for="lokasiLaluLintas">Kecelakaan Lalu Lintas di Jalan Raya</label>
            </div>
            
            <div class="form-check">
              <input 
                type="checkbox" 
                v-model="form.lokasi_rumah" 
                class="form-check-input" 
                id="lokasiRumah"
              />
              <label class="form-check-label" for="lokasiRumah">Rumah</label>
            </div>
            
            <div class="form-check">
              <input 
                type="checkbox" 
                v-model="form.lokasi_lainnya_check" 
                class="form-check-input" 
                id="lokasiLainnya"
              />
              <label class="form-check-label" for="lokasiLainnya">Dll (Lainnya)</label>
            </div>
            
            <div v-if="form.lokasi_lainnya_check" class="mt-2">
              <input 
                type="text" 
                v-model="form.lokasi_lainnya" 
                class="form-control"
                placeholder="Sebutkan lokasi lainnya..."
              />
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-12">
          <label>Detail Kronologis Kejadian : <span class="text-danger">*</span></label>
          <textarea 
            v-model="form.detail_kronologis" 
            class="form-control" 
            rows="6"
            placeholder="Tuliskan secara detail kronologis kejadian yang terjadi pada pasien..."
          ></textarea>
        </div>
      </div>
    </div>

    <!-- ================= PERNYATAAN ================= -->
    <div class="box-rme mb-4">
      <h5 class="section-title-rme">Pernyataan</h5>
      
      <div class="pernyataan-box">
        <ul class="pernyataan-list">
          <li>Formulir kronologis ini diisi dan dilengkapi dengan sebenar-benarnya, sesuai fakta, waktu dan tempat kejadian;</li>
          <li>Apabila saya memberikan kronologis yang tidak benar maka saya bersedia bertanggung jawab untuk membayar seluruh biaya perawatan kesehatan pasien selama dirawat di RSK. Mata Prima Vision.</li>
          <li>Apabila dikemudian hari, adanya tuntutan perihal formulir kronologis ini maka RSK. Mata Prima Vision akan dibebaskan dari segala tuntutan hukum pidana maupun perdata.</li>
        </ul>
        <p class="mt-3 fst-italic">
          Demikian kronologis ini saya buat dengan penuh kesadaran dan rasa tanggung jawab untuk dipergunakan sebagaimana mestinya.
        </p>
      </div>
    </div>

    <!-- ================= SIGNATURE AREA ================= -->
    <div class="signature-container">
      <div class="row mb-3">
        <div class="col-md-6">
          <label>Medan, Tanggal : <span class="text-danger">*</span></label>
          <input type="date" v-model="form.tanggal_ttd" class="form-control" />
        </div>
      </div>

      <div class="signature-section-single">
        <div class="sign-box-center">
          <label>Hormat Saya (Tanda Tangan Pembuat Kronologis)</label>

          <!-- Preview TTD yang sudah ada -->
          <div v-if="form.ttd_pembuat && !signatureCleared" class="signature-preview">
            <img :src="form.ttd_pembuat" alt="TTD Pembuat" class="img-signature" />
            <button @click="clearSignature()" class="btn-clear">
              Hapus & Tanda Tangan Ulang
            </button>
          </div>

          <!-- Signature Pad -->
          <div v-else>
            <VueSignaturePad
              ref="ttd_pembuat"
              :options="sigOption"
              class="signature-box-rme"
            />
            <button @click="saveSign()" class="btn-save">Simpan ✔</button>
          </div>

          <input
            v-model="form.nama_pembuat_ttd"
            class="input-rme mt-2"
            placeholder="Nama pembuat kronologis"
            readonly
          />
        </div>
      </div>

      <p class="text-center mt-3 fst-italic text-muted">
        <strong>Note:</strong> Wajib melampirkan fotocopy tanda pengenal pembuat kronologis
      </p>
    </div>
  </div>

  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer">
    <!-- TOMBOL SUBMIT -->
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
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
  name: "DokumenKronologisPasien",

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      loadingSubmit: false,
      loadingData: false,
      isEditMode: false,
      signatureCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",

        // Data Default (wajib dikirim ke BE)
        no_rm: "",
        jenis_kelamin: "",
        nama: "",
        nik: "",

        // Data Pasien untuk form
        nama_pasien: "",
        no_rm_pasien: "",
        nik_pasien: "",
        tanggal_lahir_display: "",

        // Data Pembuat Kronologis (4 fields)
        nama_pembuat: "",
        alamat_pembuat: "",
        nik_pembuat: "",
        hubungan_pasien: "",
        hubungan_pasien_lainnya: "",

        // Data Kronologis Kejadian
        tanggal_kejadian: "",
        jam_kejadian: "",
        tempat_kejadian: "",
        
        // Saat kejadian
        saat_kejadian: "",
        
        // Lokasi kejadian (checkboxes)
        lokasi_kecelakaan_lalu_lintas: false,
        lokasi_rumah: false,
        lokasi_lainnya_check: false,
        lokasi_lainnya: "",

        // Detail
        detail_kronologis: "",

        // Tanggal TTD
        tanggal_ttd: "",

        // Tanda Tangan
        ttd_pembuat: "",
        nama_pembuat_ttd: "",
      },
    };
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(newVal) {
        if (newVal && !this.isEditMode) {
          this.setDataForm();
        }
      },
    },
    editData: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.loadEditData();
        }
      },
    },
    'form.nama_pembuat': function(newVal) {
      this.form.nama_pembuat_ttd = newVal;
    },
  },

  mounted() {
    if (this.editData) {
      this.loadEditData();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    setDataForm() {
      // Set tanggal hari ini
      const today = new Date();
      this.form.tanggal_ttd = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.nama_pasien = this.selectedPatient?.nama || "";
      this.form.no_rm_pasien = this.selectedPatient?.rekam_medis || "";
      this.form.nik_pasien = this.selectedPatient?.nik || "";
      
      // Format tanggal lahir
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir_display = this.formatTanggalIndo(this.selectedPatient.tanggal_lahir);
      }
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/pasien/dokumen-kronologis/${this.editData}`
          );
          data = response.data.data;
        } else {
          // Jika editData sudah berupa object
          data = this.editData;
        }

        if (data) {
          // Populate form dengan data yang ada
          Object.keys(this.form).forEach((key) => {
            if (data[key] !== undefined && data[key] !== null) {
              this.form[key] = data[key];
            }
          });

          // Format date fields
          if (data.tanggal_kejadian) {
            this.form.tanggal_kejadian = this.formatDate(new Date(data.tanggal_kejadian));
          }
          if (data.tanggal_ttd) {
            this.form.tanggal_ttd = this.formatDate(new Date(data.tanggal_ttd));
          }

          console.log("Data loaded for edit:", this.form);
        }
      } catch (error) {
        console.error("Error loading edit data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      } finally {
        this.loadingData = false;
      }
    },

    clearSignature() {
      this.signatureCleared = true;
      this.form.ttd_pembuat = "";

      // Reset signature pad di next tick
      this.$nextTick(() => {
        const pad = this.$refs.ttd_pembuat;
        if (pad) {
          pad.clearSignature();
        }
      });
    },

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return d.toISOString().split("T")[0];
    },

    formatTanggalIndo(dateStr) {
      if (!dateStr) return "";
      const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      const d = new Date(dateStr);
      return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    },

    saveSign() {
      const pad = this.$refs.ttd_pembuat;

      if (!pad) {
        console.error("REF tidak ditemukan: ttd_pembuat");
        return;
      }

      const { isEmpty, data } = pad.saveSignature();

      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }

      this.form.ttd_pembuat = data;
      console.log("TTD saved: ttd_pembuat");
    },

    async submitForm() {
      // Validasi
      if (!this.form.nama_pembuat) {
        alert("Mohon lengkapi Nama pembuat kronologis!");
        return;
      }

      if (!this.form.alamat_pembuat) {
        alert("Mohon lengkapi Alamat pembuat kronologis!");
        return;
      }

      if (!this.form.nik_pembuat) {
        alert("Mohon lengkapi NIK pembuat kronologis!");
        return;
      }

      if (!this.form.hubungan_pasien) {
        alert("Mohon pilih Hubungan dengan pasien!");
        return;
      }

      if (this.form.hubungan_pasien === 'Lainnya' && !this.form.hubungan_pasien_lainnya) {
        alert("Mohon sebutkan hubungan lainnya!");
        return;
      }

      if (!this.form.detail_kronologis) {
        alert("Mohon lengkapi Detail Kronologis Kejadian!");
        return;
      }

      if (!this.form.tanggal_ttd) {
        alert("Mohon lengkapi Tanggal!");
        return;
      }

      if (!this.form.ttd_pembuat) {
        alert("Mohon lengkapi tanda tangan pembuat kronologis!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-kronologis",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Form Kronologis Pasien berhasil diupdate!"
          : "Form Kronologis Pasien berhasil disimpan!";

        alert(message);

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
.container {
  max-width: 1000px;
  margin: 0 auto;
}

.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  background: #fff;
}

/* HUBUNGAN GROUP */
.hubungan-group {
  background: white;
  padding: 15px;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
}

.form-check {
  margin-bottom: 10px;
}

.form-check-input {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.form-check-label {
  margin-left: 8px;
  cursor: pointer;
  font-size: 15px;
}

/* KEJADIAN GROUP */
.kejadian-group {
  background: white;
  padding: 15px;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
  margin-bottom: 15px;
}

/* PERNYATAAN BOX */
.pernyataan-box {
  background: #fff9e6;
  border: 2px solid #ffc107;
  border-radius: 6px;
  padding: 20px;
}

.pernyataan-list {
  margin-bottom: 0;
  padding-left: 20px;
}

.pernyataan-list li {
  margin-bottom: 12px;
  line-height: 1.6;
  color: #333;
}

.signature-container {
  padding: 20px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section-single {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.sign-box-center {
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.sign-box-center label {
  font-weight: bold;
  display: block;
  margin-bottom: 10px;
  color: #333;
  font-size: 16px;
}

.signature-box-rme {
  width: 100%;
  height: 180px;
  border: 2px solid #999;
  margin-bottom: 10px;
  background: white;
  border-radius: 4px;
}

.signature-preview {
  width: 100%;
  border: 2px solid #999;
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
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
  font-weight: 500;
}

.btn-save:hover {
  background: #1565c0;
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
}

.btn-clear:hover {
  background: #d32f2f;
}

.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 0;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 12px 30px;
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
  background: #b0bec5;
  cursor: not-allowed;
}

.btn-back {
  background: #ff9800;
  color: white;
  padding: 12px 30px;
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
  background: #ffcc80;
  cursor: not-allowed;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: bold;
  margin-left: 10px;
}

.badge.bg-warning {
  background: #ff9800;
  color: white;
}

.badge.bg-success {
  background: #4caf50;
  color: white;
}

/* LOADING OVERLAY */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.95);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  z-index: 9999;
}

.spinner-rme {
  width: 48px;
  height: 48px;
  border: 5px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 15px;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}

.mt-2 {
  margin-top: 8px;
}

.mt-3 {
  margin-top: 16px;
}

.logo-rs {
  display: block;
  margin: 0 auto;
}

hr {
  margin: 20px 0;
}

.fw-bold {
  font-weight: 700;
}

.text-uppercase {
  text-transform: uppercase;
}

.text-center {
  text-align: center;
}

.text-danger {
  color: #dc3545;
}

.text-muted {
  color: #6c757d;
}

.fst-italic {
  font-style: italic;
}
</style>