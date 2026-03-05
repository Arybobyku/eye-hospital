<template>
  <button @click="$emit('back')" class="btn-back">Kembali</button>

  <div class="container py-4">
    <div class="form-wrapper position-relative">
      <div v-if="disabledSubmit" class="view-overlay"></div>
      <!-- LOADING OVERLAY -->
      <div v-if="loadingData" class="loading-overlay">
        <div class="spinner-rme"></div>
        <p>Memuat data...</p>
      </div>

      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <img
          src="/logo-rs.png"
          alt="Logo RS"
          class="logo-rs mb-3"
          style="max-width: 150px"
        />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <p class="mb-1">VISION FOR THE NATION</p>
        <p class="mb-1">
          PRIMA VISION EYE HOSPITAL - 24 HOURS EYE ACCIDENT & EMERGENCY UNIT
        </p>
        <p class="mb-1">
          Jalan Pabrik Tenun No. 51-53, Medan Perjuangan 20112, Sumatera Utara, Indonesia
        </p>
        <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
        <p class="mb-1">24 Hours Eye Emergency Hotline: 0822 7755 5151</p>
        <p class="mb-3">Email: rsprimavision@gmail.com</p>
        <hr class="my-3" style="border: 2px solid #000" />

        <h3 class="fw-bold mt-4 mb-4">FORM KRONOLOGIS PASIEN</h3>
        <p class="text-muted">{{ form.no_surat}}</p>

        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning"
          >Mode Edit</span
        >
        <!-- <span v-else class="badge bg-success">Mode Baru</span> -->
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
            <input
              type="text"
              v-model="form.tanggal_lahir_display"
              class="input-rme"
              readonly
            />
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
        <h5 class="section-title-rme">
          Dengan ini menerangkan kronologis kejadian yang terjadi pada :
        </h5>

        <div class="row mb-3">
          <div class="col-md-4">
            <label>Tanggal :</label>
            <input type="date" v-model="form.tanggal_kejadian" class="form-control" />
          </div>
          <div class="col-md-4">
            <label>Pukul :</label>
            <input type="time" v-model="form.jam_kejadian" class="form-control" />
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
                <label class="form-check-label" for="saatSedangKerja"
                  >Sedang Bekerja</label
                >
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
                <label class="form-check-label" for="saatPulangKerja"
                  >Pulang Bekerja</label
                >
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
                <label class="form-check-label" for="lokasiLaluLintas"
                  >Kecelakaan Lalu Lintas di Jalan Raya</label
                >
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
            <li>
              Formulir kronologis ini diisi dan dilengkapi dengan sebenar-benarnya, sesuai
              fakta, waktu dan tempat kejadian;
            </li>
            <li>
              Apabila saya memberikan kronologis yang tidak benar maka saya bersedia
              bertanggung jawab untuk membayar seluruh biaya perawatan kesehatan pasien
              selama dirawat di RSK. Mata Prima Vision.
            </li>
            <li>
              Apabila dikemudian hari, adanya tuntutan perihal formulir kronologis ini
              maka RSK. Mata Prima Vision akan dibebaskan dari segala tuntutan hukum
              pidana maupun perdata.
            </li>
          </ul>
          <p class="mt-3 fst-italic">
            Demikian kronologis ini saya buat dengan penuh kesadaran dan rasa tanggung
            jawab untuk dipergunakan sebagaimana mestinya.
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
          <strong>Note:</strong> Wajib melampirkan fotocopy tanda pengenal pembuat
          kronologis
        </p>
      </div>
    </div>
  </div>
  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer" v-if="!disabledSubmit">
    <!-- TOMBOL SUBMIT -->
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? "Update" : "Save" }}</span>
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
    viewData: {
      type: Object,
      default: null,
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
      disabledSubmit: false,
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
        no_surat: "",
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
    "form.nama_pembuat": function (newVal) {
      this.form.nama_pembuat_ttd = newVal;
    },
  },

  async mounted() {
    console.log("🟢 COMPONENT - Mounted");
    console.log("🟢 COMPONENT - editData:", this.editData);
    console.log("🟢 COMPONENT - selectedPatient:", this.selectedPatient);
    await this.fetchTahunAkreditasi();

    this.disabledSubmit = false;
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadEditData();
    } else if (this.editData) {
      this.loadEditData();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';

        if (!this.form.no_surat) {
          this.form.no_surat = `RM 3.2/KADPPB/${tahun}`;
        }

        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 3.2/KADPPB/22';
        }
      }
    },

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
        this.form.tanggal_lahir_display = this.formatTanggalIndo(
          this.selectedPatient.tanggal_lahir
        );
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
      const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
      ];
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

      if (this.form.hubungan_pasien === "Lainnya" && !this.form.hubungan_pasien_lainnya) {
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

        const response = await axios.post("/master/pasien/dokumen-kronologis", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

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
/* ================= CONTAINER & LAYOUT ================= */
.container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 20px;
}

.py-4 {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
}

/* ================= TYPOGRAPHY ================= */
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

.text-center h2 {
  font-size: 18px;
  margin-bottom: 10px;
}

.text-center h3 {
  font-size: 16px;
  margin-top: 20px;
  margin-bottom: 20px;
}

.text-center p {
  font-size: 13px;
  margin: 0;
  line-height: 1.5;
}

hr {
  margin: 20px 0;
  border: 2px solid #000;
}

/* ================= LOGO ================= */
.logo-rs {
  display: block;
  margin: 0 auto 15px;
  max-width: 150px;
}

/* ================= BADGE ================= */
.badge {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: bold;
  margin-left: 10px;
  margin-top: 10px;
}

.badge.bg-warning {
  background: #ff9800;
  color: white;
}

.badge.bg-success {
  background: #4caf50;
  color: white;
}

/* ================= BOX & SECTIONS ================= */
.box-rme {
  border: 1px solid #dcdcdc;
  padding: 20px;
  border-radius: 6px;
  background: #fafafa;
  margin-bottom: 20px;
}

.section-title-rme {
  font-weight: bold;
  margin-bottom: 15px;
  color: #2d74b7;
  font-size: 16px;
  border-bottom: 2px solid #2d74b7;
  padding-bottom: 8px;
}

/* ================= FORM ELEMENTS ================= */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.input-rme {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px 12px;
  background: #fff;
  font-size: 14px;
  transition: border-color 0.3s;
}

.input-rme:focus {
  outline: none;
  border-color: #2d74b7;
}

.input-rme[readonly] {
  background: #f5f5f5;
  cursor: not-allowed;
  color: #666;
}

.form-control {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.3s;
  font-family: "Arial", sans-serif;
  line-height: 1.6;
}

.form-control:focus {
  outline: none;
  border-color: #2d74b7;
}

textarea.form-control {
  resize: vertical;
  min-height: 80px;
}

/* ================= CHECKBOX STYLING ================= */
.checkbox-group {
  display: flex;
  gap: 30px;
  padding: 15px;
  background: white;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
}

.form-check {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-check-inline {
  display: inline-flex;
  align-items: center;
  margin-right: 0;
}

.form-check-input {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin: 0;
}

.form-check-label {
  cursor: pointer;
  margin: 0;
  user-select: none;
  font-size: 15px;
  color: #333;
}

/* ================= ROW & COLUMNS ================= */
.row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -10px;
}

.mb-1 {
  margin-bottom: 5px;
}

.mb-2 {
  margin-bottom: 10px;
}

.mb-3 {
  margin-bottom: 15px;
}

.mb-4 {
  margin-bottom: 20px;
}

.mt-2 {
  margin-top: 10px;
}

.mt-3 {
  margin-top: 15px;
}

.mt-4 {
  margin-top: 20px;
}

.my-3 {
  margin-top: 15px;
  margin-bottom: 15px;
}

.col-md-6,
.col-md-12 {
  padding: 0 10px;
  margin-bottom: 15px;
}

.col-md-6 {
  flex: 0 0 50%;
  max-width: 50%;
}

.col-md-12 {
  flex: 0 0 100%;
  max-width: 100%;
}

/* ================= PROCEDURE STEPS ================= */
.procedure-steps {
  background: white;
  padding: 20px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
}

.step-item {
  display: flex;
  margin-bottom: 15px;
  padding: 12px 15px;
  background: #f8f9fa;
  border-radius: 4px;
  border-left: 4px solid #2d74b7;
  transition: all 0.3s;
}

.step-item:hover {
  background: #f0f4f8;
  border-left-color: #1976d2;
}

.step-item:last-child {
  margin-bottom: 0;
}

.step-item-important {
  background: #fff9e6;
  border-left: 4px solid #ff9800;
  flex-direction: column;
  padding: 15px;
}

.step-item-important:hover {
  background: #fff5d6;
  border-left-color: #f57c00;
}

.step-number {
  font-weight: bold;
  color: #2d74b7;
  min-width: 40px;
  font-size: 15px;
  flex-shrink: 0;
}

.step-text {
  flex: 1;
  line-height: 1.6;
  color: #333;
  font-size: 14px;
}

.step-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.step-content .step-text {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
}

.step-content label {
  color: #ff9800;
  font-size: 15px;
  font-weight: 600;
  margin-top: 10px;
  margin-bottom: 8px;
}

/* ================= SIGNATURE SECTION ================= */
.signature-container {
  padding: 25px;
  background: white;
  border: 1px solid #dcdcdc;
  border-radius: 6px;
  margin-top: 30px;
}

.signature-section-single {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  margin-top: 20px;
  margin-bottom: 20px;
}

.sign-box-center {
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.sign-box-center label {
  font-weight: bold;
  display: block;
  margin-bottom: 15px;
  color: #333;
  font-size: 16px;
  line-height: 1.4;
}

/* ================= SIGNATURE PAD & PREVIEW ================= */
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
  display: block;
  margin: 0 auto;
}

/* ================= BUTTONS ================= */
.btn-save {
  background: #1e88e5;
  color: white;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  margin-bottom: 10px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
  transition: background 0.3s;
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
  transition: background 0.3s;
}

.btn-clear:hover {
  background: #d32f2f;
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
  transition: background 0.3s;
}

.btn-back:hover {
  background: #f57c00;
}

.btn-back:disabled {
  background: #ffcc80;
  cursor: not-allowed;
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
  transition: background 0.3s;
}

.btn-save-form:hover {
  background: #0277bd;
}

.btn-save-form:disabled {
  background: #b0bec5;
  cursor: not-allowed;
}

/* ================= ACTION FOOTER ================= */
.action-footer {
  margin-top: 30px;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 0;
  border-top: 1px solid #e0e0e0;
}

/* ================= LOADING OVERLAY ================= */
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

.loading-overlay p {
  color: #333;
  font-weight: 500;
  margin: 0;
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

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .container {
    padding: 15px;
  }

  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .sign-box-center {
    max-width: 100%;
  }

  .action-footer {
    flex-direction: column-reverse;
  }

  .btn-save-form,
  .btn-back {
    width: 100%;
  }

  .text-center h2 {
    font-size: 16px;
  }

  .text-center h3 {
    font-size: 15px;
  }

  .text-center p {
    font-size: 12px;
  }

  .box-rme {
    padding: 15px;
  }

  .procedure-steps {
    padding: 15px;
  }

  .step-item {
    padding: 10px 12px;
  }

  .step-item-important {
    padding: 12px;
  }

  .step-number {
    min-width: 35px;
    font-size: 14px;
  }

  .step-text {
    font-size: 13px;
  }

  .checkbox-group {
    flex-direction: column;
    gap: 15px;
  }

  .signature-box-rme {
    height: 200px;
  }

  .img-signature {
    height: 200px;
  }
}

@media (max-width: 480px) {
  .logo-rs {
    max-width: 120px;
  }

  .section-title-rme {
    font-size: 15px;
  }

  label {
    font-size: 13px;
  }
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
</style>
