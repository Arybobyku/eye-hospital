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
        <img src="/logo-rs.png" alt="Logo RS" class="logo-rs mb-3" style="max-width: 150px" />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <p class="mb-1">VISION FOR THE NATION</p>
        <p class="mb-1">PRIMA VISION EYE HOSPITAL - 24 HOURS EYE ACCIDENT & EMERGENCY UNIT</p>
        <p class="mb-1">Jalan Pabrik Tenun No. 51-53, Medan Perjuangan 20112, Sumatera Utara, Indonesia</p>
        <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
        <p class="mb-1">24 Hours Eye Emergency Hotline: 0822 7755 5151</p>
        <p class="mb-3">Email: rsprimavision@gmail.com</p>
        <hr class="my-3" style="border: 2px solid #000" />
        <h3 class="fw-bold mt-4 mb-2">LAPORAN OPERASI</h3>
        <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
      </div>

      <!-- ================= DATA PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Pasien</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama_pasien" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>No. Rekam Medis :</label>
            <input type="text" v-model="form.no_rm_pasien" class="input-rme" readonly />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="form.jenis_kelamin_display" class="input-rme" readonly />
          </div>
          <div class="col-md-6">
            <label>Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="form-control" />
          </div>
        </div>
      </div>

      <!-- ================= TIM OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tim Operasi</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Ahli Bedah :</label>
            <input type="text" v-model="form.ahli_bedah" class="form-control" placeholder="Nama ahli bedah" />
          </div>
          <div class="col-md-6">
            <label>Asisten Dokter :</label>
            <input type="text" v-model="form.asisten_dokter" class="form-control" placeholder="Nama asisten dokter" />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Ahli Anestesi :</label>
            <input type="text" v-model="form.ahli_anestesi" class="form-control" placeholder="Nama ahli anestesi" />
          </div>
          <div class="col-md-6">
            <label>Instrumen :</label>
            <input type="text" v-model="form.instrumen" class="form-control" placeholder="Nama instrumen / perawat instrumen" />
          </div>
        </div>
      </div>

      <!-- ================= DIAGNOSA & WAKTU ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa & Waktu Operasi</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Diagnosa Prabedah :</label>
            <textarea v-model="form.diagnosa_prabedah" class="form-control" rows="3" placeholder="Diagnosa sebelum pembedahan"></textarea>
          </div>
          <div class="col-md-6">
            <label>Diagnosa Pasca Bedah :</label>
            <textarea v-model="form.diagnosa_pasca_bedah" class="form-control" rows="3" placeholder="Diagnosa setelah pembedahan"></textarea>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-4">
            <label>Pembedahan Mulai Pukul :</label>
            <input type="time" v-model="form.pembedahan_mulai_pukul" class="form-control" />
          </div>
          <div class="col-md-4">
            <label>Pembedahan Selesai Pukul :</label>
            <input type="time" v-model="form.pembedahan_selesai_pukul" class="form-control" />
          </div>
          <div class="col-md-4">
            <label>Lama Tindakan :</label>
            <input type="text" v-model="form.lama_tindakan" class="form-control" placeholder="mis. 2 jam 30 menit" />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-4">
            <label>Tanggal Operasi :</label>
            <input type="date" v-model="form.tanggal" class="form-control" />
          </div>
        </div>
      </div>

      <!-- ================= JENIS PEMBEDAHAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Jenis Pembedahan</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Jenis Pembedahan :</label>
            <input type="text" v-model="form.jenis_pembedahan" class="form-control" placeholder="Jenis pembedahan" />
          </div>
          <div class="col-md-6">
            <label>Macam Pembedahan :</label>
            <input type="text" v-model="form.macam_pembedahan" class="form-control" placeholder="Macam pembedahan" />
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-12">
            <label>Ukuran Pembedahan :</label>
            <div class="checkbox-group">
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.jenis_besar" class="form-check-input" id="jenisBesar" />
                <label class="form-check-label" for="jenisBesar">Besar</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.jenis_sedang" class="form-check-input" id="jenisSedang" />
                <label class="form-check-label" for="jenisSedang">Sedang</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.jenis_kecil" class="form-check-input" id="jenisKecil" />
                <label class="form-check-label" for="jenisKecil">Kecil</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-12">
            <label>Tipe Pembedahan :</label>
            <div class="checkbox-group">
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.tipe_elektif" class="form-check-input" id="tipeElektif" />
                <label class="form-check-label" for="tipeElektif">Elektif</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.tipe_emergency" class="form-check-input" id="tipeEmergency" />
                <label class="form-check-label" for="tipeEmergency"><em>Emergency</em></label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.tipe_khusus" class="form-check-input" id="tipeKhusus" />
                <label class="form-check-label" for="tipeKhusus">Khusus</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= TRANSFUSI & IMPLAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Transfusi & Implan</h5>

        <div class="row mb-3">
          <div class="col-md-12">
            <label>Transfusi :</label>
            <div class="checkbox-group mb-2">
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.transfusi_tidak" class="form-check-input" id="transfusiTidak" />
                <label class="form-check-label" for="transfusiTidak">Tidak</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.transfusi_ya" class="form-check-input" id="transfusiYa" />
                <label class="form-check-label" for="transfusiYa">Ya</label>
              </div>
            </div>
            <div v-if="form.transfusi_ya">
              <label>Jenis / Jumlah :</label>
              <input type="text" v-model="form.transfusi_jenis_jumlah" class="form-control" placeholder="mis. PRC / 2 kantong" />
            </div>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-12">
            <label>Jenis Implan :</label>
            <div class="checkbox-group mb-2">
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.implan_tidak" class="form-check-input" id="implanTidak" />
                <label class="form-check-label" for="implanTidak">Tidak</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.implan_ya" class="form-check-input" id="implanYa" />
                <label class="form-check-label" for="implanYa">Ya</label>
              </div>
            </div>
            <div v-if="form.implan_ya">
              <label>Jenis / Jumlah :</label>
              <input type="text" v-model="form.implan_jenis_jumlah" class="form-control" placeholder="mis. IOL Monofocal / 1 buah" />
            </div>
          </div>
        </div>
      </div>

      <!-- ================= URAIAN PEMBEDAHAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Uraian Pembedahan</h5>
        <div class="row mb-2">
          <div class="col-md-12">
            <textarea v-model="form.uraian_pembedahan" class="form-control" rows="10"
              placeholder="Uraian lengkap langkah-langkah pembedahan..."></textarea>
          </div>
        </div>
      </div>

      <!-- ================= KOMPLIKASI & PASCA OPERASI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pasca Operasi</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Komplikasi Intra-Operasi :</label>
            <textarea v-model="form.komplikasi_intra_operasi" class="form-control" rows="3" placeholder="Komplikasi yang terjadi selama operasi"></textarea>
          </div>
          <div class="col-md-6">
            <label>Konsultasi Intra Operasi :</label>
            <textarea v-model="form.konsultasi_intra_operasi" class="form-control" rows="3" placeholder="Konsultasi yang dilakukan selama operasi"></textarea>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Jumlah Perdarahan :</label>
            <input type="text" v-model="form.jumlah_perdarahan" class="form-control" placeholder="mis. 50 cc" />
          </div>
          <div class="col-md-6">
            <label>Jaringan ke Patologi :</label>
            <div class="checkbox-group">
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.jaringan_patologi_ya" class="form-check-input" id="patologiYa" />
                <label class="form-check-label" for="patologiYa">Ya</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="checkbox" v-model="form.jaringan_patologi_tidak" class="form-check-input" id="patologiTidak" />
                <label class="form-check-label" for="patologiTidak">Tidak</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN DOKTER ================= -->
      <div class="signature-container">
        <h5 class="section-title-rme text-center mb-4">Tanda Tangan Dokter Bedah</h5>

        <div class="signature-section-single">
          <div class="sign-box-center">
            <label>Dokter Penanggung Jawab Pelayanan (DPJP)</label>

            <!-- Preview TTD -->
            <div v-if="form.ttd_dokter && !signatureCleared" class="signature-preview">
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <p v-if="form.dokter_ttd_timestamp" class="timestamp-ttd">Ditandatangani: {{ form.dokter_ttd_timestamp }}</p>
              <button @click="clearSignature()" class="btn-clear">Hapus & Tanda Tangan Ulang</button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme" />
              <button @click="saveSign()" class="btn-save">Simpan ✔</button>
            </div>

            <label class="mt-3">Nama Dokter : <span class="text-danger">*</span></label>
            <div class="dropdown-dokter mt-2">
              <select v-model="form.nama_dokter" class="form-select-dokter">
                <option value="" disabled>🩺 Pilih Dokter</option>
                <option v-for="dokter in listDokter" :key="dokter.id" :value="dokter.nama">
                  {{ dokter.nama }}
                </option>
              </select>
              <span class="dropdown-icon">▾</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- ================= BUTTON BOTTOM ================= -->
  <div class="action-footer" v-if="!disabledSubmit">
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Back</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'DokumenLaporanOperasi',

  props: {
    selectedPatient: { type: Object, required: true },
    viewData:        { type: Object, default: null },
    editData:        { type: Object, default: null },
  },

  data() {
    return {
      loadingSubmit:     false,
      loadingData:       false,
      isEditMode:        false,
      signatureCleared:  false,
      disabledSubmit:    false,
      listDokter:        [],

      sigOption: {
        penColor:        'black',
        backgroundColor: 'white',
      },

      form: {
        uuid:        '',
        uuid_pasien: '',

        // Identitas
        no_rm:              '',
        no_surat:           '',
        jenis_kelamin:      '',
        nama:               '',
        nik:                '',
        tanggal_lahir:      '',

        // Display only
        nama_pasien:           '',
        no_rm_pasien:          '',
        jenis_kelamin_display: '',

        // Tim Operasi
        ahli_bedah:      '',
        asisten_dokter:  '',
        ahli_anestesi:   '',
        instrumen:       '',

        // Diagnosa & Waktu
        diagnosa_prabedah:      '',
        diagnosa_pasca_bedah:   '',
        pembedahan_mulai_pukul: '',
        pembedahan_selesai_pukul: '',
        lama_tindakan:          '',
        tanggal:                '',

        // Jenis Pembedahan
        jenis_pembedahan: '',
        macam_pembedahan: '',
        jenis_besar:  false,
        jenis_sedang: false,
        jenis_kecil:  false,
        tipe_elektif:   false,
        tipe_emergency: false,
        tipe_khusus:    false,

        // Transfusi
        transfusi_tidak:       false,
        transfusi_ya:          false,
        transfusi_jenis_jumlah: '',

        // Implan
        implan_tidak:       false,
        implan_ya:          false,
        implan_jenis_jumlah: '',

        // Uraian
        uraian_pembedahan: '',

        // Pasca operasi
        komplikasi_intra_operasi:  '',
        konsultasi_intra_operasi:  '',
        jumlah_perdarahan:         '',
        jaringan_patologi_ya:      false,
        jaringan_patologi_tidak:   false,

        // TTD
        ttd_dokter:           '',
        nama_dokter:          '',
        dokter_ttd_timestamp: '',
      },
    };
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(newVal) {
        if (newVal && !this.isEditMode) this.setDataForm();
      },
    },
    editData: {
      immediate: true,
      handler(newVal) {
        if (newVal) this.loadEditData();
      },
    },
  },

  async mounted() {
    await this.fetchDokter();
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
    async fetchDokter() {
      try {
        const res = await axios.get('/master/pasien/master-dokter-all');
        this.listDokter = res.data.data;
      } catch (e) {
        console.error('Gagal memuat data dokter:', e);
      }
    },

    async fetchTahunAkreditasi() {
      try {
        const res  = await axios.get('/api/tahun-akreditasi');
        const tahun = res.data.tahun || '22';
        if (!this.form.no_surat) this.form.no_surat = `RM 5.0/LO/${tahun}`;
      } catch (e) {
        if (!this.form.no_surat) this.form.no_surat = 'RM 5.0/LO/22';
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal = this.formatDate(today);

      this.form.uuid_pasien   = this.selectedPatient?.uuid           || '';
      this.form.no_rm         = this.selectedPatient?.rekam_medis    || '';
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin  || '';
      this.form.nama          = this.selectedPatient?.nama           || '';
      this.form.nik           = this.selectedPatient?.no_identitas   || '';

      this.form.nama_pasien   = this.selectedPatient?.nama           || '';
      this.form.no_rm_pasien  = this.selectedPatient?.rekam_medis    || '';
      this.form.jenis_kelamin_display =
        this.selectedPatient?.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';

      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir = this.formatDate(new Date(this.selectedPatient.tanggal_lahir));
      }
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode  = true;

      try {
        let data = null;

        if (typeof this.editData === 'string') {
          const res = await axios.get(
            `/master/rekammedis/lampiran/${this.editData}?type=dokumen_laporan_operasi`
          );
          data = res.data.data;
        } else {
          data = this.editData;
        }

        if (data) {
          Object.keys(this.form).forEach(key => {
            if (data[key] !== undefined && data[key] !== null) {
              this.form[key] = data[key];
            }
          });

          if (data.tanggal_lahir) this.form.tanggal_lahir = this.formatDate(new Date(data.tanggal_lahir));
          if (data.tanggal)       this.form.tanggal       = this.formatDate(new Date(data.tanggal));

          // Display fields
          this.form.nama_pasien           = data.nama          || '';
          this.form.no_rm_pasien          = data.no_rm         || '';
          this.form.jenis_kelamin_display = data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
        }
      } catch (e) {
        console.error('Error loading edit data:', e);
        alert('Gagal memuat data untuk edit!');
        this.$emit('back');
      } finally {
        this.loadingData = false;
      }
    },

    clearSignature() {
      this.signatureCleared    = true;
      this.form.ttd_dokter     = '';
      this.form.dokter_ttd_timestamp = '';
      this.$nextTick(() => {
        const pad = this.$refs.ttd_dokter;
        if (pad) pad.clearSignature();
      });
    },

    saveSign() {
      const pad = this.$refs.ttd_dokter;
      if (!pad) return;

      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert('Tanda tangan masih kosong!'); return; }

      this.form.ttd_dokter = data;
      this.signatureCleared = false;

      const now = new Date();
      this.form.dokter_ttd_timestamp = now.toLocaleString('id-ID', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit',
      });
    },

    formatDate(date) {
      if (!date) return '';
      return new Date(date).toISOString().split('T')[0];
    },

    async submitForm() {
      if (!this.form.tanggal_lahir) { alert('Mohon lengkapi Tanggal Lahir!'); return; }
      if (!this.form.tanggal)       { alert('Mohon lengkapi Tanggal Operasi!'); return; }
      if (!this.form.ahli_bedah)    { alert('Mohon lengkapi Ahli Bedah!'); return; }
      if (!this.form.diagnosa_prabedah) { alert('Mohon lengkapi Diagnosa Prabedah!'); return; }
      if (!this.form.ttd_dokter)    { alert('Mohon lengkapi tanda tangan dokter!'); return; }
      if (!this.form.nama_dokter)   { alert('Mohon pilih nama dokter!'); return; }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();
        Object.keys(this.form).forEach(key => {
          fd.append(key, this.form[key] !== null && this.form[key] !== undefined ? this.form[key] : '');
        });

        const res = await axios.post('/master/pasien/dokumen-laporan-operasi', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        console.log('BERHASIL:', res.data);
        alert(this.isEditMode ? 'Laporan Operasi berhasil diupdate!' : 'Laporan Operasi berhasil disimpan!');
        this.$emit('back');
      } catch (e) {
        console.error('ERROR:', e.response?.data || e);
        alert('Gagal menyimpan data!');
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.dropdown-dokter { position: relative; width: 100%; }
.form-select-dokter {
  width: 100%; padding: 10px 40px 10px 14px; font-size: 14px;
  color: #2d3748; background-color: #fff; border: 1.5px solid #cbd5e0;
  border-radius: 10px; appearance: none; -webkit-appearance: none;
  cursor: pointer; outline: none;
}
.form-select-dokter:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.2); }
.dropdown-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #718096; font-size: 16px; pointer-events: none; }

.container { max-width: 1000px; margin: 0 auto; padding: 20px; }
.py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.fw-bold { font-weight: 700; }
.text-uppercase { text-transform: uppercase; }
.text-center { text-align: center; }
.text-danger { color: #dc3545; }
.text-center h2 { font-size: 18px; margin-bottom: 10px; }
.text-center h3 { font-size: 16px; margin-top: 20px; margin-bottom: 20px; }
.text-center p { font-size: 13px; margin: 0; line-height: 1.5; }
hr { margin: 20px 0; border: 2px solid #000; }
.logo-rs { display: block; margin: 0 auto 15px; max-width: 150px; }
.badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-left: 10px; margin-top: 10px; }
.badge.bg-warning { background: #ff9800; color: white; }

.box-rme { border: 1px solid #dcdcdc; padding: 20px; border-radius: 6px; background: #fafafa; margin-bottom: 20px; }
.section-title-rme { font-weight: bold; margin-bottom: 15px; color: #2d74b7; font-size: 16px; border-bottom: 2px solid #2d74b7; padding-bottom: 8px; }

label { display: block; margin-bottom: 8px; font-weight: 500; color: #555; font-size: 14px; }
.input-rme { width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px 12px; background: #fff; font-size: 14px; }
.input-rme[readonly] { background: #f5f5f5; cursor: not-allowed; color: #666; }
.form-control { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; line-height: 1.6; }
.form-control:focus { outline: none; border-color: #2d74b7; }
textarea.form-control { resize: vertical; min-height: 80px; }

.checkbox-group { display: flex; gap: 30px; padding: 15px; background: white; border-radius: 4px; border: 1px solid #e0e0e0; flex-wrap: wrap; }
.form-check { display: flex; align-items: center; gap: 8px; }
.form-check-inline { display: inline-flex; align-items: center; margin-right: 0; }
.form-check-input { width: 20px; height: 20px; cursor: pointer; margin: 0; }
.form-check-label { cursor: pointer; margin: 0; user-select: none; font-size: 15px; color: #333; }

.row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
.mb-1 { margin-bottom: 5px; } .mb-2 { margin-bottom: 10px; } .mb-3 { margin-bottom: 15px; } .mb-4 { margin-bottom: 20px; }
.mt-2 { margin-top: 10px; } .mt-3 { margin-top: 15px; } .mt-4 { margin-top: 20px; }
.my-3 { margin-top: 15px; margin-bottom: 15px; }
.col-md-4, .col-md-6, .col-md-12 { padding: 0 10px; margin-bottom: 15px; }
.col-md-4  { flex: 0 0 33.333%; max-width: 33.333%; }
.col-md-6  { flex: 0 0 50%;     max-width: 50%; }
.col-md-12 { flex: 0 0 100%;    max-width: 100%; }

.signature-container { padding: 25px; background: white; border: 1px solid #dcdcdc; border-radius: 6px; margin-top: 30px; }
.signature-section-single { display: flex; justify-content: center; align-items: flex-start; margin-top: 20px; margin-bottom: 20px; }
.sign-box-center { text-align: center; max-width: 500px; width: 100%; }
.sign-box-center label { font-weight: bold; display: block; margin-bottom: 15px; color: #333; font-size: 16px; }
.signature-box-rme { width: 100%; height: 180px; border: 2px solid #999; margin-bottom: 10px; background: white; border-radius: 4px; }
.signature-preview { width: 100%; border: 2px solid #999; background: white; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
.img-signature { max-width: 100%; height: 180px; object-fit: contain; border: 1px dashed #ccc; background: white; display: block; margin: 0 auto; }
.timestamp-ttd { font-size: 12px; color: #2d74b7; font-weight: 500; padding: 6px 16px; background: #e9f5ff; border-radius: 4px; display: block; width: fit-content; margin: 6px auto; }

.btn-save { background: #1e88e5; color: white; padding: 8px 20px; border: none; border-radius: 4px; margin-bottom: 10px; cursor: pointer; font-weight: 500; font-size: 14px; }
.btn-save:hover { background: #1565c0; }
.btn-clear { background: #f44336; color: white; padding: 6px 12px; border: none; border-radius: 4px; margin-top: 10px; cursor: pointer; font-size: 12px; }
.btn-clear:hover { background: #d32f2f; }
.btn-back { background: #ff9800; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ffcc80; cursor: not-allowed; }
.btn-save-form { background: #0288d1; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #b0bec5; cursor: not-allowed; }

.action-footer { margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; padding: 20px 0; border-top: 1px solid #e0e0e0; }

.loading-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.95); display: flex; flex-direction: column; justify-content: center; align-items: center; font-size: 18px; z-index: 9999; }
.loading-overlay p { color: #333; font-weight: 500; margin: 0; }
.spinner-rme { width: 48px; height: 48px; border: 5px solid #ddd; border-top-color: #1d72c9; border-radius: 50%; animation: spin-rme 0.8s linear infinite; margin-bottom: 15px; }
@keyframes spin-rme { to { transform: rotate(360deg); } }

.view-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,251,251,0.1); z-index: 10; cursor: not-allowed; }
.form-wrapper { position: relative; }

@media (max-width: 768px) {
  .col-md-4, .col-md-6 { flex: 0 0 100%; max-width: 100%; }
  .action-footer { flex-direction: column-reverse; }
  .btn-save-form, .btn-back { width: 100%; }
  .checkbox-group { flex-direction: column; gap: 15px; }
}
</style>
