<template>
  <div>
    <button @click="$emit('back')" class="btn-back">Kembali</button>

    <div class="container py-4">
      <div class="form-wrapper position-relative">

      <div v-if="disabledSubmit" class="view-overlay"></div>
      
      <!-- ================= HEADER ================= -->
      <div class="text-center mb-4">
        <h2 class="fw-bold">FORMULIR PENYIMPANAN BARANG BERHARGA MILIK PASIEN</h2>
        <h4 class="fw-semibold">{{ form.no_surat }}</h4>
      </div>

      <!-- ================= INFORMASI PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Informasi Pasien</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Umur :</label>
            <input type="text" v-model="umurDisplay" class="input-rme" readonly />
          </div>
        </div>

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
        
        <div class="row">
          <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="jenisKelaminDisplay" class="input-rme" readonly />
          </div>
        </div>
      </div>

      <!-- ================= NAMA PETUGAS ================= -->
      <div class="box-rme mb-4">
        <div class="mb-3">
          <label class="fw-bold mb-2">
            Nama petugas penerima barang: <span style="color: red;">*</span>
          </label>
          <input
            type="text"
            v-model="form.nama_petugas"
            class="input-rme"
            placeholder="Nama petugas yang menerima barang..."
          />
        </div>
      </div>

      <!-- ================= TABEL BARANG BERHARGA ================= -->
      <div class="box-rme mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="section-title-rme mb-0">Data Barang Berharga</h5>
          <button @click="addRow" class="btn-add-row">
            <i class="fas fa-plus"></i> Tambah Barang
          </button>
        </div>

        <div class="table-responsive">
          <table class="barang-table">
            <thead>
              <tr>
                <th style="width: 50px">NO</th>
                <th>Jenis harta benda</th>
                <th style="width: 100px">Jumlah</th>
                <th colspan="2" style="width: 200px">Kondisi barang</th>
                <th style="width: 150px">Saat dititipkan</th>
                <th style="width: 150px">Saat diserahkan</th>
                <th style="width: 80px">Aksi</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="width: 100px">Baik</th>
                <th style="width: 100px">Buruk</th>
                <th>tanggal</th>
                <th>tanggal</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(row, index) in form.barang_rows" :key="index">
                <!-- NO -->
                <td class="text-center">{{ index + 1 }}</td>

                <!-- Jenis harta benda -->
                <td>
                  <input 
                    type="text" 
                    v-model="row.jenis_barang" 
                    class="input-table"
                    placeholder="Jenis barang..."
                  />
                </td>

                <!-- Jumlah -->
                <td>
                  <input 
                    type="number" 
                    v-model="row.jumlah" 
                    class="input-table"
                    min="1"
                  />
                </td>

                <!-- Kondisi Baik -->
                <td class="text-center">
                  <input 
                    type="checkbox" 
                    :checked="row.kondisi === 'baik'"
                    @change="setKondisi(index, 'baik')"
                    class="checkbox-table"
                  />
                </td>

                <!-- Kondisi Buruk -->
                <td class="text-center">
                  <input 
                    type="checkbox" 
                    :checked="row.kondisi === 'buruk'"
                    @change="setKondisi(index, 'buruk')"
                    class="checkbox-table"
                  />
                </td>

                <!-- Saat dititipkan -->
                <td>
                  <input 
                    type="date" 
                    v-model="row.tanggal_dititipkan" 
                    class="input-table"
                  />
                </td>

                <!-- Saat diserahkan -->
                <td>
                  <input 
                    type="date" 
                    v-model="row.tanggal_diserahkan" 
                    class="input-table"
                  />
                </td>

                <!-- Aksi -->
                <td class="text-center">
                  <button 
                    @click="deleteRow(index)" 
                    class="btn-delete-row"
                    :disabled="form.barang_rows.length === 1"
                    title="Hapus Baris"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>

              <tr v-if="form.barang_rows.length === 0">
                <td colspan="8" class="text-center text-muted">
                  Belum ada data barang. Klik "Tambah Barang" untuk menambah data.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Summary Info -->
        <div class="summary-info mt-3">
          <strong>Total Barang:</strong> {{ form.barang_rows.length }} item
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
          <!-- KOLOM 1: Yang Memeriksa / Petugas RS -->
          <div>
            <label class="fw-bold mb-2">Yang Memeriksa</label>
            <p class="text-muted small">Petugas Rumah Sakit</p>
            
            <div v-if="form.ttd_petugas && !ttdPetugasCleared" class="signature-preview text-center">
              <img :src="form.ttd_petugas" alt="TTD Petugas" class="img-signature" />
              <p v-if="form.ttd_petugas_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.ttd_petugas_timestamp }}
              </p>
              <button @click="clearSign('ttd_petugas')" class="btn-clear mt-2">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>
            
            <div v-else class="text-center">
              <VueSignaturePad 
                ref="ttd_petugas" 
                :options="sigOption" 
                class="signature-box-rme mx-auto" 
              />
              <button @click="saveSign('ttd_petugas')" class="btn-save mt-2">
                Simpan ✔
              </button>
            </div>
            
            <input 
              type="text" 
              v-model="form.nama_petugas_ttd" 
              class="input-rme mt-2" 
              placeholder="Nama jelas & Tanda tangan" 
            />
          </div>

          <!-- KOLOM 2: Saksi 1 -->
          <div>
            <label class="fw-bold mb-2">Saksi 1</label>
            <p class="text-muted small">&nbsp;</p>
            
            <div v-if="form.ttd_saksi1 && !ttdSaksi1Cleared" class="signature-preview text-center">
              <img :src="form.ttd_saksi1" alt="TTD Saksi 1" class="img-signature" />
              <p v-if="form.ttd_saksi1_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.ttd_saksi1_timestamp }}
              </p>
              <button @click="clearSign('ttd_saksi1')" class="btn-clear mt-2">
                Hapus & Tanda Tangan Ulang
              </button>
            </div>
            
            <div v-else class="text-center">
              <VueSignaturePad 
                ref="ttd_saksi1" 
                :options="sigOption" 
                class="signature-box-rme mx-auto" 
              />
              <button @click="saveSign('ttd_saksi1')" class="btn-save mt-2">
                Simpan ✔
              </button>
            </div>
            
            <input 
              type="text" 
              v-model="form.nama_saksi1_ttd" 
              class="input-rme mt-2" 
              placeholder="Nama saksi 1" 
            />
          </div>

          <!-- KOLOM 3: Saksi / Pasien/Keluarga -->
          <div>
            <label class="fw-bold mb-2">Saksi</label>
            <p class="text-muted small">Pasien/keluarga</p>
            
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

      <!-- ================= KEADAAN KHUSUS ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Keadaan khusus pasien tidak sadar</h5>
        
        <div class="consent-text mb-3">
          Dengan ini menyatakan bahwa telah mendata serta menyimpan harta/benda milik pasien yang 
          masuk ke Ruang Rawat dalam keadaan tidak sadar tanpa didampingi oleh keluarga/wali.
        </div>

        <!-- CHECKBOX PASIEN TIDAK SADAR -->
        <div class="mb-3">
          <label class="checkbox-item">
            <input 
              type="checkbox" 
              v-model="form.pasien_tidak_sadar"
            />
            <span class="ml-2">Pasien masuk dalam keadaan tidak sadar</span>
          </label>
        </div>

        <!-- TTD KEPALA RUANGAN (muncul jika checkbox dicentang) -->
        <div v-if="form.pasien_tidak_sadar" class="signature-single">
          <label class="fw-bold mb-2 text-center">Mengetahui</label>
          <p class="text-center text-muted small">Kepala ruangan</p>
          
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
            placeholder="Nama Kepala Ruangan" 
          />
        </div>
      </div>
    </div>
    </div>

    <!-- ================= BUTTON BOTTOM ================= -->
    <div class="action-footer" >
      <button v-if="!disabledSubmit" class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
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
  name: "FormPenyimpananBarangBerharga",
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
      ttdPetugasCleared: false,
      ttdSaksi1Cleared: false,
      ttdKeluargaCleared: false,
      ttdKepalaCleared: false,
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "",
        no_surat: "",
        nik: "",
        nama: "",
        tanggal_lahir: "",
        jenis_kelamin: "L",
        nama_petugas: "",
        tanggal: "",
        pasien_tidak_sadar: false,
        
        // Barang rows (dynamic table)
        barang_rows: [
          {
            jenis_barang: "",
            jumlah: 1,
            kondisi: "",
            tanggal_dititipkan: "",
            tanggal_diserahkan: ""
          }
        ],
        
        // Tanda tangan
        ttd_petugas: "",
        nama_petugas_ttd: "",
        ttd_petugas_timestamp: "",
        
        ttd_saksi1: "",
        nama_saksi1_ttd: "",
        ttd_saksi1_timestamp: "",
        
        ttd_keluarga: "",
        nama_keluarga_ttd: "",
        ttd_keluarga_timestamp: "",
        
        ttd_kepala_ruangan: "",
        nama_kepala_ruangan_ttd: "",
        ttd_kepala_ruangan_timestamp: "",
      }
    };
  },
  computed: {
    umurDisplay() {
      if (!this.form.tanggal_lahir) return "";
      
      const today = new Date();
      const birthDate = new Date(this.form.tanggal_lahir);
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      
      return `${age} tahun`;
    },
    jenisKelaminDisplay() {
      return this.form.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    },
    isEditMode() {
      return !!this.editData?.uuid;
    },
  },
  async mounted() {
    await this.fetchTahunAkreditasi();
    
    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadDataForEdit();
    } else if (this.editData) {
      this.disabledSubmit = false;
      this.loadDataForEdit();
    } else {
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
          this.form.no_surat = `RM 7.2/FPBBMP/${tahun}`;
        }
        
        console.log("✅ Tahun akreditasi:", tahun);
        console.log("✅ No surat:", this.form.no_surat);
      } catch (error) {
        console.error("❌ Error fetch tahun:", error);
        if (!this.form.no_surat) {
          this.form.no_surat = 'RM 7.2/FPBBMP/22';
        }
      }
    },

    setDataForm() {
      if (this.selectedPatient) {
        this.form.uuid_pasien = this.selectedPatient.uuid;
        this.form.no_rm = this.selectedPatient.rekam_medis;
        this.form.nik = this.selectedPatient.no_ktp || "";
        this.form.nama = this.selectedPatient.nama;
        this.form.tanggal_lahir = this.selectedPatient.tanggal_lahir;
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "L";
      }

      // Set default tanggal
      const now = new Date();
      this.form.tanggal = now.toISOString().split('T')[0];
      this.form.barang_rows[0].tanggal_dititipkan = now.toISOString().split('T')[0];
    },

    async loadDataForEdit() {
      try {
        const dataSource = this.editData || this.viewData;
        
        if (!dataSource) {
          this.setDataForm();
          return;
        }

        Object.keys(this.form).forEach(key => {
          if (key === 'barang_rows' && dataSource.barang_rows) {
            this.form.barang_rows = JSON.parse(dataSource.barang_rows);
          } else if (key === 'pasien_tidak_sadar' && dataSource[key] !== undefined) {
            this.form[key] = !!dataSource[key];
          } else if (dataSource[key] !== undefined) {
            this.form[key] = dataSource[key];
          }
        });

        // Render signatures
        this.$nextTick(() => {
          ['ttd_petugas', 'ttd_saksi1', 'ttd_keluarga', 'ttd_kepala_ruangan'].forEach(refName => {
            if (this.form[refName]) {
              const flagMap = {
                ttd_petugas: 'ttdPetugasCleared',
                ttd_saksi1: 'ttdSaksi1Cleared',
                ttd_keluarga: 'ttdKeluargaCleared',
                ttd_kepala_ruangan: 'ttdKepalaCleared',
              };
              this[flagMap[refName]] = false;
            }
          });
        });
      } catch (err) {
        console.error(err);
      }
    },

    addRow() {
      const now = new Date();
      this.form.barang_rows.push({
        jenis_barang: "",
        jumlah: 1,
        kondisi: "",
        tanggal_dititipkan: now.toISOString().split('T')[0],
        tanggal_diserahkan: ""
      });
    },

    deleteRow(index) {
      if (this.form.barang_rows.length > 1) {
        this.form.barang_rows.splice(index, 1);
      }
    },

    setKondisi(index, value) {
      // Toggle: jika sudah dipilih, kosongkan; jika belum, set value
      if (this.form.barang_rows[index].kondisi === value) {
        this.form.barang_rows[index].kondisi = "";
      } else {
        this.form.barang_rows[index].kondisi = value;
      }
    },

    saveSign(refName) {
      const pad = this.$refs[refName];
      const signaturePad = Array.isArray(pad) ? pad[0] : pad;
    
      if (!signaturePad) {
        console.error("REF tidak ditemukan:", refName);
        return;
      }
    
      const { isEmpty, data } = signaturePad.saveSignature();
      if (isEmpty) {
        alert("Tanda tangan masih kosong!");
        return;
      }
    
      const flagMap = {
        ttd_petugas: 'ttdPetugasCleared',
        ttd_saksi1: 'ttdSaksi1Cleared',
        ttd_keluarga: 'ttdKeluargaCleared',
        ttd_kepala_ruangan: 'ttdKepalaCleared',
      };

      const timestampMap = {
        ttd_petugas: 'ttd_petugas_timestamp',
        ttd_saksi1: 'ttd_saksi1_timestamp',
        ttd_keluarga: 'ttd_keluarga_timestamp',
        ttd_kepala_ruangan: 'ttd_kepala_ruangan_timestamp',
      };
    
      this.form[refName] = data;
      if (flagMap[refName]) this[flagMap[refName]] = false;

      if (timestampMap[refName]) {
        const now = new Date();
        this.form[timestampMap[refName]] = now.toLocaleString('id-ID', {
          day: '2-digit', month: '2-digit', year: 'numeric',
          hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
      }
      
      console.log("TTD saved:", refName);
    },

    clearSign(refName) {
      const flagMap = {
        ttd_petugas: 'ttdPetugasCleared',
        ttd_saksi1: 'ttdSaksi1Cleared',
        ttd_keluarga: 'ttdKeluargaCleared',
        ttd_kepala_ruangan: 'ttdKepalaCleared',
      };

      const timestampMap = {
        ttd_petugas: 'ttd_petugas_timestamp',
        ttd_saksi1: 'ttd_saksi1_timestamp',
        ttd_keluarga: 'ttd_keluarga_timestamp',
        ttd_kepala_ruangan: 'ttd_kepala_ruangan_timestamp',
      };
    
      if (flagMap[refName]) this[flagMap[refName]] = true;
      this.form[refName] = "";
      if (timestampMap[refName]) this.form[timestampMap[refName]] = "";
    
      this.$nextTick(() => {
        this.$nextTick(() => {
          const pad = this.$refs[refName];
          const signaturePad = Array.isArray(pad) ? pad[0] : pad;
          if (signaturePad) signaturePad.clearSignature();
        });
      });
    },

    async submitForm() {
      // Validasi
      if (!this.form.nama_petugas.trim()) {
        alert("Nama petugas penerima barang harus diisi!");
        return;
      }

      if (this.form.barang_rows.length === 0) {
        alert("Minimal harus ada 1 data barang!");
        return;
      }

      // Validasi ada data yang diisi
      const hasData = this.form.barang_rows.some(row => 
        row.jenis_barang || row.jumlah
      );

      if (!hasData) {
        alert("Harap isi minimal 1 data barang!");
        return;
      }

      if (!this.form.ttd_petugas) {
        alert("Tanda tangan Petugas harus diisi!");
        return;
      }

      if (!this.form.ttd_saksi1) {
        alert("Tanda tangan Saksi 1 harus diisi!");
        return;
      }

      if (!this.form.ttd_keluarga) {
        alert("Tanda tangan Pasien/Keluarga harus diisi!");
        return;
      }

      if (this.form.pasien_tidak_sadar && !this.form.ttd_kepala_ruangan) {
        alert("Tanda tangan Kepala Ruangan harus diisi (pasien tidak sadar)!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === 'uuid' && !this.form[key]) {
            return;
          }
          if (key === 'barang_rows') {
            fd.append(key, JSON.stringify(this.form[key]));
          } else if (key === 'pasien_tidak_sadar') {
            fd.append(key, this.form[key] ? '1' : '0');
          } else {
            fd.append(key, this.form[key] || '');
          }
        });

        const url = "/master/pasien/dokumen-penyimpanan-barang-berharga";


        const response = await axios.post(url, fd, {
          headers: { "Content-Type": "multipart/form-data" }
        });

        if (response.data.status) {
          alert(response.data.message);
          this.$emit("back");
        }
      } catch (error) {
        console.error("ERROR:", error.response?.data || error);
        alert("Gagal menyimpan formulir!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1400px;
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

.consent-text {
  text-align: justify;
  line-height: 1.8;
  font-size: 14px;
  margin: 15px 0;
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

/* TABLE */
.table-responsive {
  overflow-x: auto;
}

.barang-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.barang-table th {
  background: #2d74b7;
  color: white;
  padding: 10px 8px;
  border: 1px solid #fff;
  font-weight: 600;
  text-align: center;
}

.barang-table td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: middle;
}

.input-table {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 5px 6px;
  font-size: 13px;
}

.input-table:focus {
  outline: none;
  border-color: #2d74b7;
}

.checkbox-table {
  width: 20px;
  height: 20px;
  cursor: pointer;
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

/* BUTTONS */
.btn-add-row {
  background: #28a745;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.btn-add-row:hover {
  background: #218838;
}

.btn-delete-row {
  background: #dc3545;
  color: white;
  border: none;
  padding: 4px 8px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}

.btn-delete-row:hover:not(:disabled) {
  background: #c82333;
}

.btn-delete-row:disabled {
  background: #ccc;
  cursor: not-allowed;
}

/* SUMMARY */
.summary-info {
  padding: 10px;
  background: #e9f5ff;
  border-left: 4px solid #2d74b7;
  border-radius: 4px;
  font-size: 14px;
}

/* SIGNATURES */
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

.signature-single {
  max-width: 400px;
  margin: 2rem auto;
  padding: 1rem;
  text-align: center;
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

/* ACTION FOOTER */
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

  position: relative;
  z-index: 9999;
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

/* RESPONSIVE GRID */
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

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.align-items-center {
  align-items: center;
}

.mb-0 {
  margin-bottom: 0;
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

.ml-2 {
  margin-left: 8px;
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

  .barang-table {
    font-size: 11px;
  }

  .input-table {
    font-size: 11px;
    padding: 4px 5px;
  }

  .signature-row-3 {
    flex-direction: column;
  }

  .signature-box-rme {
    max-width: 250px !important;
    height: 120px !important;
  }
  .form-wrapper {
  position: relative;
}
}
</style>