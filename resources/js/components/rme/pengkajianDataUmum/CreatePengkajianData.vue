<template>
  <div class="patient-data-form">
    <!-- Header Section -->
    <div class="header-section">
      <h2 class="form-title">Pengkajian Data Umum Pasien</h2>
      <div class="date-time-inputs">
        <div class="input-group">
          <input 
            type="date" 
            v-model="formData.tanggal" 
            class="form-control"
            readonly
          />
        </div>
        <div class="input-group">
          <input 
            type="time" 
            v-model="formData.waktu" 
            class="form-control" 
            readonly
          />
        </div>
      </div>
    </div>

    <!-- Form Section -->
    <div class="form-section">
      <h3 class="section-title">Pengkajian Data Umum Pasien</h3>
      
      <div class="form-row">
        <!-- Left Column -->
        <div class="form-column">
          <div class="form-group">
            <label>NIK :</label>
            <input 
              type="text" 
              v-model="formData.nik" 
              class="form-control"
            />
          </div>

          <div class="form-group">
            <label>Kode MR :</label>
            <input 
              type="text" 
              v-model="formData.kodeMR" 
              class="form-control"
              readonly
            />
          </div>

          <div class="form-group">
            <label>Nama :</label>
            <input 
              type="text" 
              v-model="formData.nama" 
              class="form-control"
              readonly
            />
          </div>

          <div class="form-group">
            <label>Nama Suami / Istri :</label>
            <input 
              type="text" 
              v-model="formData.namaPasangan" 
              class="form-control"
            />
          </div>

          <div class="form-group">
            <label>NIK Suami / Istri :</label>
            <input 
              type="text" 
              v-model="formData.nikPasangan" 
              class="form-control"
            />
          </div>

          <div class="form-group">
            <label>Pekerjaan :</label>
            <select v-model="formData.pekerjaan" class="form-control">
              <option value="">Pilih Pekerjaan</option>
              <option value="PNS">PNS</option>
              <option value="Swasta">Swasta</option>
              <option value="Wiraswasta">Wiraswasta</option>
              <option value="Petani">Petani</option>
              <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <div class="form-group">
            <label>Alamat :</label>
            <input 
              type="text" 
              v-model="formData.alamat" 
              class="form-control"
              readonly
            />
          </div>
        </div>

        <!-- Right Column -->
        <div class="form-column">
          <div class="form-group">
            <label>Agama :</label>
            <input 
              type="text" 
              v-model="formData.agama" 
              class="form-control"
            />
          </div>

          <div class="form-group">
            <label>Jenis Kelamin :</label>
            <input 
              type="text" 
              v-model="formData.jenisKelamin" 
              class="form-control"
              readonly
            />
          </div>

          <div class="form-group">
            <label>Tempat Tanggal Lahir :</label>
            <input 
              type="text" 
              v-model="formData.tempatTanggalLahir" 
              class="form-control"
              readonly
            />
          </div>

          <div class="form-group">
            <label>Status Pembiayaan :</label>
            <select v-model="formData.statusPembiayaan" class="form-control">
              <option value="">Pilih Status</option>
              <option value="BPJS">BPJS</option>
              <option value="Umum">Umum</option>
              <option value="Asuransi">Asuransi</option>
            </select>
          </div>

          <div class="form-group">
            <label>Status Perkawinan :</label>
            <select v-model="formData.statusPerkawinan" class="form-control">
              <option value="">Pilih Status</option>
              <option value="Menikah">Menikah</option>
              <option value="Belum Menikah">Belum Menikah</option>
              <option value="Cerai">Cerai</option>
              <option value="Janda/Duda">Janda/Duda</option>
            </select>
          </div>

          <div class="form-group">
            <label>Pendidikan :</label>
            <select v-model="formData.pendidikan" class="form-control">
              <option value="">Pilih Pendidikan</option>
              <option value="SD">SD</option>
              <option value="SMP">SMP</option>
              <option value="SMA">SMA</option>
              <option value="D3">D3</option>
              <option value="S1">S1</option>
              <option value="S2">S2</option>
              <option value="S3">S3</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="form-actions">
        <button class="btn-save-form" @click="submitForm">Save</button>
        <button class="btn-back" @click="$emit('back')">Back</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PengkajianDataUmumPasien',
  data() {
    return {
      formData: {
        tanggal: '2025-11-22',
        waktu: '19:24',
        nik: '',
        kodeMR: '000307',
        nama: 'TASYA HESTIA ANGESTI, NN',
        namaPasangan: '',
        nikPasangan: '',
        pekerjaan: '',
        alamat: 'BEKASI KOTA',
        agama: '',
        jenisKelamin: 'PEREMPUAN',
        tempatTanggalLahir: 'BEKASI, 02-09-1998',
        statusPembiayaan: '',
        statusPerkawinan: '',
        pendidikan: ''
      }
    }
  },
  methods: {
    saveData() {
      // Kirim data ke backend Laravel
      axios.post('/api/pasien/pengkajian-data-umum', this.formData)
        .then(response => {
          this.$swal('Sukses', 'Data berhasil disimpan', 'success');
          console.log('Data saved:', response.data);
        })
        .catch(error => {
          this.$swal('Error', 'Gagal menyimpan data', 'error');
          console.error('Error saving data:', error);
        });
    },
    goBack() {
      this.$router.go(-1);
    },
    loadPatientData(mrCode) {
      // Load data pasien dari backend
      axios.get(`/api/pasien/${mrCode}`)
        .then(response => {
          const data = response.data;
          this.formData.kodeMR = data.kode_mr;
          this.formData.nama = data.nama;
          this.formData.jenisKelamin = data.jenis_kelamin;
          this.formData.tempatTanggalLahir = data.tempat_tanggal_lahir;
          this.formData.alamat = data.alamat;
        })
        .catch(error => {
          console.error('Error loading patient data:', error);
        });
    }
  },
  mounted() {
    // Contoh: load data pasien saat component dimount
    // this.loadPatientData('000307');
  }
}
</script>

<style scoped>
.patient-data-form {
  background-color: #f5f5f5;
  min-height: 100vh;
  padding: 20px;
}

.header-section {
  background-color: white;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-title {
  color: #2196F3;
  font-size: 24px;
  font-weight: 600;
  margin: 0 0 15px 0;
  text-align: center;
}

.date-time-inputs {
  display: flex;
  gap: 15px;
  justify-content: center;
  align-items: center;
}

.input-group {
  flex: 0 0 200px;
}

.form-section {
  background-color: white;
  padding: 25px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.section-title {
  color: #2196F3;
  font-size: 18px;
  font-weight: 500;
  margin: 0 0 20px 0;
  padding-bottom: 10px;
  border-bottom: 2px solid #e0e0e0;
}

.form-row {
  display: flex;
  gap: 30px;
}

.form-column {
  flex: 1;
}

.form-group {
  margin-bottom: 15px;
  display: flex;
  align-items: center;
}

.form-group label {
  flex: 0 0 180px;
  font-size: 14px;
  color: #333;
  font-weight: 500;
  text-align: right;
  padding-right: 15px;
}

.form-control {
  flex: 1;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  background-color: #f5f5f5;
  transition: border-color 0.3s;
}

.form-control:focus {
  outline: none;
  border-color: #2196F3;
  background-color: white;
}

.form-control:readonly {
  background-color: #e9ecef;
  cursor: not-allowed;
}

.form-control select {
  cursor: pointer;
}

.form-actions {
  margin-top: 30px;
  display: flex;
  gap: 10px;
  padding-top: 20px;
  border-top: 2px solid #e0e0e0;
}

.btn {
  padding: 10px 30px;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s;
}

.btn-save-form {
  background: #0288d1;
  color: white;
  padding: 8px 18px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}

.btn-back {
  background: #ff9800;
  color: white;
  padding: 8px 18px;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
}

@media (max-width: 768px) {
  .form-row {
    flex-direction: column;
    gap: 0;
  }
  
  .form-group {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .form-group label {
    text-align: left;
    padding-right: 0;
    margin-bottom: 5px;
  }
}
</style>