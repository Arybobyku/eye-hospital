<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">
        <!-- OVERLAY SAAT VIEW -->
        <div v-if="disabledSubmit" class="view-overlay"></div>

        <!-- ================= HEADER ================= -->
        <div class="text-center mb-4">
          <h2 class="fw-bold">FORMULIR PERMINTAAN PELAYANAN KEGIATAN KEROHANIAN</h2>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        </div>

        <!-- ================= IDENTITAS PASIEN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Identitas Pasien</h5>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>1. Nama :</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div class="col-md-6">
              <label>2. Tanggal lahir :</label>
              <input type="date" v-model="form.tanggal_lahir_pasien" class="input-rme" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>3. Jenis kelamin :</label>
              <input type="text" v-model="jenisKelaminPasienDisplay" class="input-rme" readonly />
            </div>
            <div class="col-md-6">
              <label>4. Alamat :</label>
              <input type="text" v-model="form.alamat_pasien" class="input-rme" readonly />
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label>5. Nomor rekam medis :</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
          </div>
        </div>

        <!-- ================= IDENTITAS WALI ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Identitas Wali (Anak/Istri/Suami/Orangtua)</h5>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>6. Nama :</label>
              <input type="text" v-model="form.nama_wali" class="input-rme" placeholder="Nama wali..." />
            </div>
            <div class="col-md-6">
              <label>7. Tanggal Lahir :</label>
              <input type="date" v-model="form.tanggal_lahir_wali" class="input-rme" />
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>8. Jenis Kelamin :</label>
              <select v-model="form.jenis_kelamin_wali" class="input-rme">
                <option value="">Pilih...</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>9. Alamat :</label>
              <input type="text" v-model="form.alamat_wali" class="input-rme" placeholder="Alamat wali..." />
            </div>
          </div>
        </div>

        <!-- ================= PERMINTAAN AGAMA ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Permintaan Agama</h5>

          <div class="mb-3">
            <label class="fw-bold mb-2">
              1. Agama Kepercayaan Pasien Yang Minta: <span style="color: red;">*</span>
            </label>
            <select v-model="form.agama_kepercayaan" class="input-rme">
              <option value="">Pilih Agama...</option>
              <option value="Islam">Islam</option>
              <option value="Kristen">Kristen</option>
              <option value="Katolik">Katolik</option>
              <option value="Hindu">Hindu</option>
              <option value="Buddha">Buddha</option>
              <option value="Konghucu">Konghucu</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="fw-bold mb-2">
              2. Bentuk Pelayanan Kerohanian Yang Diminta: <span style="color: red;">*</span>
            </label>
            <textarea
              v-model="form.bentuk_pelayanan"
              class="textarea-rme"
              placeholder="Contoh: Doa bersama, konseling rohani, kunjungan pemuka agama..."
              rows="3"
            ></textarea>
          </div>

          <div class="mb-3">
            <label class="fw-bold mb-2">
              3. Hari/Tanggal/Jam Pelayanan Kegiatan Kerohanian: <span style="color: red;">*</span>
            </label>
            <div class="row">
              <div class="col-md-6">
                <label class="small">Tanggal:</label>
                <input type="date" v-model="form.tanggal_pelayanan" class="input-rme" />
              </div>
              <div class="col-md-6">
                <label class="small">Jam:</label>
                <input type="time" v-model="form.jam_pelayanan" class="input-rme" />
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="fw-bold mb-2">
              4. Koordinasi Dengan Team Terkait:
            </label>
            <textarea
              v-model="form.koordinasi_team"
              class="textarea-rme"
              placeholder="Koordinasi dengan team terkait..."
              rows="2"
            ></textarea>
          </div>
        </div>

        <!-- ================= PELAYANAN YANG DIBERIKAN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Pelayanan Yang Diberikan</h5>

          <div class="mb-3">
            <label class="checkbox-item">
              <input 
                type="checkbox" 
                v-model="form.pelayanan_doa_bersama"
              />
              <span class="ml-2">Doa Bersama Diruangan Dengan Didampingi/Tanpa Pemuka Agama RS/Pribadi</span>
            </label>
          </div>

          <div class="mb-3">
            <label class="fw-bold mb-2">Keterangan Tambahan:</label>
            <textarea
              v-model="form.keterangan_pelayanan"
              class="textarea-rme"
              placeholder="Catatan atau keterangan tambahan pelayanan yang diberikan..."
              rows="3"
            ></textarea>
          </div>
        </div>

        <!-- ================= TANGGAL ================= -->
        <div class="box-rme mb-4">
          <div class="row mb-3">
            <div class="col-md-6">
              <div style="display: flex; align-items: center; gap: 10px;">
                <span>Medan,</span>
                <input
                  type="date"
                  v-model="form.tanggal"
                  class="input-rme"
                  style="width: 200px;"
                />
              </div>
            </div>
          </div>

          <!-- ================= SIGNATURE ROW ================= -->
          <div class="signature-row-3">
            <!-- KOLOM 1: Rohaniawan -->
            <div>
              <label class="fw-bold mb-2">Rohaniawan</label>
              <p class="text-muted small">Tanda tangan</p>
              
              <div v-if="form.ttd_rohaniawan && !ttdRohaniawanCleared" class="signature-preview text-center">
                <img :src="form.ttd_rohaniawan" alt="TTD Rohaniawan" class="img-signature" />
                <p v-if="form.ttd_rohaniawan_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_rohaniawan_timestamp }}
                </p>
                <button @click="clearSign('ttd_rohaniawan')" class="btn-clear mt-2">
                  Hapus & Tanda Tangan Ulang
                </button>
              </div>
              
              <div v-else class="text-center">
                <VueSignaturePad 
                  ref="ttd_rohaniawan" 
                  :options="sigOption" 
                  class="signature-box-rme mx-auto" 
                />
                <button @click="saveSign('ttd_rohaniawan')" class="btn-save mt-2">
                  Simpan ✔
                </button>
              </div>
              
              <input 
                type="text" 
                v-model="form.nama_rohaniawan_ttd" 
                class="input-rme mt-2" 
                placeholder="Nama rohaniawan" 
              />
            </div>

            <!-- KOLOM 2: Kepala Ruangan -->
            <div>
              <label class="fw-bold mb-2">Kepala Ruangan</label>
              <p class="text-muted small">Tanda Tangan</p>
              
              <div v-if="form.ttd_kepala_ruangan && !ttdKepalaCleared" class="signature-preview text-center">
                <img :src="form.ttd_kepala_ruangan" alt="TTD Kepala Ruangan" class="img-signature" />
                <p v-if="form.ttd_kepala_ruangan_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_kepala_ruangan_timestamp }}
                </p>
                <button @click="clearSign('ttd_kepala_ruangan')" class="btn-clear mt-2">
                  Hapus & Tanda Tangan Ulang
                </button>
              </div>
              
              <div v-else class="text-center">
                <VueSignaturePad 
                  ref="ttd_kepala_ruangan" 
                  :options="sigOption" 
                  class="signature-box-rme mx-auto" 
                />
                <button @click="saveSign('ttd_kepala_ruangan')" class="btn-save mt-2">
                  Simpan ✔
                </button>
              </div>
              
              <input 
                type="text" 
                v-model="form.nama_kepala_ruangan_ttd" 
                class="input-rme mt-2" 
                placeholder="Nama kepala ruangan" 
              />
            </div>

            <!-- KOLOM 3: Pasien/Keluarga -->
            <div>
              <label class="fw-bold mb-2">Pasien/Keluarga</label>
              <p class="text-muted small">Tanda tangan</p>
              
              <div v-if="form.ttd_keluarga && !ttdKeluargaCleared" class="signature-preview text-center">
                <img :src="form.ttd_keluarga" alt="TTD Keluarga" class="img-signature" />
                <p v-if="form.ttd_keluarga_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_keluarga_timestamp }}
                </p>
                <button @click="clearSign('ttd_keluarga')" class="btn-clear mt-2">
                  Hapus & Tanda Tangan Ulang
                </button>
              </div>
              
              <div v-else class="text-center">
                <VueSignaturePad 
                  ref="ttd_keluarga" 
                  :options="sigOption" 
                  class="signature-box-rme mx-auto" 
                />
                <button @click="saveSign('ttd_keluarga')" class="btn-save mt-2">
                  Simpan ✔
                </button>
              </div>
              
              <input 
                type="text" 
                v-model="form.nama_keluarga_ttd" 
                class="input-rme mt-2" 
                placeholder="Nama keluarga/pasien" 
              />
            </div>
          </div>
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
</template>

<script>
import axios from "axios";

export default {
  name: "FormPermintaanPelayananKerohanian",
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
  },
  data() {
    return {
      loadingSubmit: false,
      disabledSubmit: false,
      ttdRohaniawanCleared: false,
      ttdKepalaCleared: false,
      ttdKeluargaCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        
        // Identitas Pasien
        nama: "",
        tanggal_lahir_pasien: "",
        jenis_kelamin_pasien: "",
        alamat_pasien: "",
        
        // Identitas Wali
        nama_wali: "",
        tanggal_lahir_wali: "",
        jenis_kelamin_wali: "",
        alamat_wali: "",
        
        // Permintaan Agama
        agama_kepercayaan: "",
        bentuk_pelayanan: "",
        tanggal_pelayanan: "",
        jam_pelayanan: "",
        koordinasi_team: "",
        
        // Pelayanan Yang Diberikan
        pelayanan_doa_bersama: false,
        keterangan_pelayanan: "",
        
        // Tanggal
        tanggal: "",
        
        // Tanda Tangan
        ttd_rohaniawan: "",
        nama_rohaniawan_ttd: "",
        ttd_rohaniawan_timestamp: "",
        
        ttd_kepala_ruangan: "",
        nama_kepala_ruangan_ttd: "",
        ttd_kepala_ruangan_timestamp: "",
        
        ttd_keluarga: "",
        nama_keluarga_ttd: "",
        ttd_keluarga_timestamp: "",
      }
    };
  },
  computed: {
    jenisKelaminPasienDisplay() {
      return this.form.jenis_kelamin_pasien === 'L' ? 'Laki-laki' : 'Perempuan';
    },
    isEditMode() {
      return !!this.editData?.uuid;
    },
  },
  async mounted() {
    console.log("🟢 COMPONENT - Mounted");
    
    await this.fetchTahunAkreditasi();

    if (this.viewData) {
      console.log("🟢 MODE: VIEW");
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      console.log("🟢 MODE: EDIT");
      this.disabledSubmit = false;
      this.loadDataForEdit();
    } else {
      console.log("🟢 MODE: CREATE");
      this.disabledSubmit = false;
      this.setDataForm();
    }
  },
  methods: {
    async fetchTahunAkreditasi() {
      try {
        const response = await axios.get('/api/tahun-akreditasi');
        const tahun = response.data.tahun || '22';
        
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 7.1/FPPKK/${tahun}`;
        }
        
        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 7.1/FPPKK/22';
        }
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal = today.toISOString().split("T")[0];

      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir_pasien = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin_pasien = this.selectedPatient.jenis_kelamin;
        this.form.alamat_pasien = this.selectedPatient.alamat || "";
      }

      console.log("✅ Form initialized:", this.form);
    },

    async loadDataForEdit() {
      console.log("🟢 LOAD EDIT - Mulai load data");
      
      try {
        const dataSource = this.editData || this.viewData;
        
        if (!dataSource) {
          console.warn("🟢 LOAD EDIT - Tidak ada data!");
          this.setDataForm();
          return;
        }

        // Populate form dengan data dari editData/viewData
        Object.keys(this.form).forEach((key) => {
          if (dataSource.hasOwnProperty(key)) {
            let value = dataSource[key];
            
            // Handle boolean
            if (key === 'pelayanan_doa_bersama') {
              this.form[key] = !!value;
            } else {
              this.form[key] = value !== null ? value : "";
            }
            
            console.log(`🟢 Set ${key}:`, this.form[key]);
          }
        });

        console.log("🟢 LOAD EDIT - Form setelah populate:", this.form);

        // Render signatures
        this.$nextTick(() => {
          ['ttd_rohaniawan', 'ttd_kepala_ruangan', 'ttd_keluarga'].forEach(refName => {
            if (this.form[refName]) {
              const flagMap = {
                ttd_rohaniawan: 'ttdRohaniawanCleared',
                ttd_kepala_ruangan: 'ttdKepalaCleared',
                ttd_keluarga: 'ttdKeluargaCleared',
              };
              this[flagMap[refName]] = false;
            }
          });
        });

      } catch (error) {
        console.error("🟢 LOAD EDIT - Error:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      if (!pad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }

      const { isEmpty, data } = pad.saveSignature();

      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }

      const flagMap = {
        ttd_rohaniawan: 'ttdRohaniawanCleared',
        ttd_kepala_ruangan: 'ttdKepalaCleared',
        ttd_keluarga: 'ttdKeluargaCleared',
      };

      const timestampMap = {
        ttd_rohaniawan: 'ttd_rohaniawan_timestamp',
        ttd_kepala_ruangan: 'ttd_kepala_ruangan_timestamp',
        ttd_keluarga: 'ttd_keluarga_timestamp',
      };

      if (flagMap[refName]) this[flagMap[refName]] = false;
      this.form[refName] = data;

      if (timestampMap[refName]) {
        const now = new Date();
        this.form[timestampMap[refName]] = now.toLocaleString('id-ID', {
          day: '2-digit', 
          month: '2-digit', 
          year: 'numeric',
          hour: '2-digit', 
          minute: '2-digit', 
          second: '2-digit'
        });
      }

      console.log("TTD saved:", refName);
    },

    clearSign(refName) {
      const flagMap = {
        ttd_rohaniawan: 'ttdRohaniawanCleared',
        ttd_kepala_ruangan: 'ttdKepalaCleared',
        ttd_keluarga: 'ttdKeluargaCleared',
      };

      const timestampMap = {
        ttd_rohaniawan: 'ttd_rohaniawan_timestamp',
        ttd_kepala_ruangan: 'ttd_kepala_ruangan_timestamp',
        ttd_keluarga: 'ttd_keluarga_timestamp',
      };

      if (flagMap[refName]) this[flagMap[refName]] = true;
      this.form[refName] = "";
      if (timestampMap[refName]) this.form[timestampMap[refName]] = "";

      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) pad.clearSignature();
      });
    },

    validateForm() {
      const errors = [];

      if (!this.form.agama_kepercayaan) {
        errors.push("Agama Kepercayaan harus dipilih");
      }

      if (!this.form.bentuk_pelayanan.trim()) {
        errors.push("Bentuk Pelayanan harus diisi");
      }

      if (!this.form.tanggal_pelayanan) {
        errors.push("Tanggal Pelayanan harus diisi");
      }

      if (!this.form.jam_pelayanan) {
        errors.push("Jam Pelayanan harus diisi");
      }

      if (!this.form.tanggal) {
        errors.push("Tanggal harus diisi");
      }

      if (!this.form.ttd_rohaniawan) {
        errors.push("Tanda tangan Rohaniawan harus diisi");
      }

      if (!this.form.ttd_kepala_ruangan) {
        errors.push("Tanda tangan Kepala Ruangan harus diisi");
      }

      if (!this.form.ttd_keluarga) {
        errors.push("Tanda tangan Pasien/Keluarga harus diisi");
      }

      if (errors.length > 0) {
        alert("Mohon lengkapi:\n" + errors.join("\n"));
        return false;
      }

      return true;
    },

    async submitForm() {
      if (!this.validateForm()) return;

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) {
            return;
          }
          
          if (key === 'pelayanan_doa_bersama') {
            fd.append(key, this.form[key] ? '1' : '0');
          } else {
            fd.append(key, this.form[key] || "");
          }
        });

        const url = "/master/pasien/dokumen-permintaan-pelayanan-kerohanian";

        const response = await axios.post(url, fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        if (response.data.status) {
          alert(
            response.data.message ||
              (this.isEditMode
                ? "Data berhasil diperbarui!"
                : "Data berhasil disimpan!")
          );
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        
        let errorMessage = "Terjadi kesalahan saat menyimpan data.";
        
        if (error.response?.data?.errors) {
          const errors = Object.values(error.response.data.errors).flat();
          errorMessage += "\n" + errors.join("\n");
        } else if (error.response?.data?.message) {
          errorMessage = error.response.data.message;
        }
        
        alert(errorMessage);
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

.form-wrapper {
  position: relative;
}

.view-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 251, 251, 0.1);
  z-index: 10;
  cursor: not-allowed;
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

.input-rme:disabled,
.input-rme[readonly] {
  background: #e9ecef;
  cursor: not-allowed;
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

.checkbox-item {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 14px;
}

.checkbox-item input[type="checkbox"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.signature-row-3 {
  display: flex;
  gap: 1.5rem;
  margin-top: 2rem;
}

.signature-row-3 > div {
  flex: 1;
  padding: 1rem;
  text-align: center;
  box-sizing: border-box;
}

.signature-box-rme {
  width: 100% !important;
  max-width: 280px !important;
  height: 150px !important;
  border: 2px solid #000;
  border-radius: 6px;
  margin: 0 auto;
  display: block;
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
  height: 140px;
  object-fit: contain;
  border: 1px dashed #ccc;
  background: white;
  display: block;
  margin: 0 auto;
}

.timestamp-ttd {
  font-size: 10px;
  color: #2d74b7;
  background: #e9f5ff;
  padding: 3px 8px;
  border-radius: 4px;
  margin: 4px auto;
  width: fit-content;
}

.btn-save {
  background: #1e88e5;
  color: white;
  padding: 4px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  font-weight: 500;
}

.btn-save:hover {
  background: #1565c0;
}

.btn-clear {
  background: #f44336;
  color: white;
  padding: 4px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  font-weight: 500;
}

.btn-clear:hover {
  background: #d32f2f;
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

.row {
  display: flex;
  flex-wrap: wrap;
  margin-left: -8px;
  margin-right: -8px;
}

.col-md-6 {
  padding-left: 8px;
  padding-right: 8px;
  flex: 0 0 50%;
  max-width: 50%;
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

.ml-2 {
  margin-left: 8px;
}

.text-center {
  text-align: center;
}

.text-muted {
  color: #6c757d;
}

.small {
  font-size: 12px;
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

@media (max-width: 768px) {
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .signature-row-3 {
    flex-direction: column;
  }

  .signature-box-rme {
    max-width: 250px !important;
    height: 120px !important;
  }
}
</style>