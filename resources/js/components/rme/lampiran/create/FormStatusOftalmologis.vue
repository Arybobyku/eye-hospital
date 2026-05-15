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
        <img src="/logo-rs.png" alt="Logo RS" class="logo-rs mb-3" style="max-width:150px" />
        <h2 class="fw-bold text-uppercase">RS KHUSUS MATA PRIMA VISION</h2>
        <p class="mb-1">VISION FOR THE NATION</p>
        <p class="mb-1">PRIMA VISION EYE HOSPITAL - 24 HOURS EYE ACCIDENT &amp; EMERGENCY UNIT</p>
        <p class="mb-1">Jalan Pabrik Tenun No. 51-53, Medan Perjuangan 20112, Sumatera Utara, Indonesia</p>
        <p class="mb-1">Hospital Hotline: (+6261) 805 14 888</p>
        <p class="mb-3">Email: rsprimavision@gmail.com</p>
        <hr class="my-3" style="border:2px solid #000" />
        <h3 class="fw-bold mt-4 mb-1">STATUS OFTALMOLOGIS RAWAT JALAN</h3>
        <h4 class="fw-semibold">{{ form.no_surat }}</h4>
        <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
      </div>

      <!-- ================= DATA PASIEN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Data Pasien</h5>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Nama :</label>
            <input type="text" v-model="form.nama" class="input-rme" readonly />
          </div>
          <div class="col-md-3">
            <label>No. Rekam Medis :</label>
            <input type="text" v-model="form.no_rm" class="input-rme" readonly />
          </div>
          <div class="col-md-3">
            <label>Jenis Kelamin :</label>
            <input type="text" v-model="jkDisplay" class="input-rme" readonly />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-4">
            <label>NIK :</label>
            <input type="text" v-model="form.nik" class="input-rme" readonly />
          </div>
          <div class="col-md-4">
            <label>Tanggal Lahir :</label>
            <input type="date" v-model="form.tanggal_lahir" class="form-control" />
          </div>
          <div class="col-md-2">
            <label>Tgl Kunjungan : <span class="text-danger">*</span></label>
            <input type="date" v-model="form.tanggal_kunjungan" class="form-control" />
          </div>
          <div class="col-md-2">
            <label>Jam :</label>
            <input type="time" v-model="form.jam_kunjungan" class="form-control" />
          </div>
        </div>
      </div>

      <!-- ================= PEMERIKSAAN REFRAKSI ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pemeriksaan Refraksi & Tekanan Intraokuler</h5>

        <div class="od-os-grid">
          <!-- OD -->
          <div class="od-col">
            <div class="od-os-header od-header">OCULAR DEXTRA (OD / Kanan)</div>

            <div class="form-row-inline">
              <label>PD :</label>
              <input type="text" v-model="form.od_pd" class="input-rme-sm" placeholder="mm" />
            </div>

            <div class="form-group-block">
              <label>Autoref :</label>
              <div class="inline-fields">
                <input type="text" v-model="form.od_autoref_s" class="input-rme-sm" placeholder="S" />
                <span class="sep">/</span>
                <input type="text" v-model="form.od_autoref_c" class="input-rme-sm" placeholder="C" />
                <span class="sep">x</span>
                <input type="text" v-model="form.od_autoref_x" class="input-rme-sm" placeholder="Axis" />
              </div>
            </div>

            <div class="form-group-block">
              <label>Keratometri :</label>
              <div class="inline-fields">
                <span class="label-sm">K1:</span>
                <input type="text" v-model="form.od_kk1" class="input-rme-sm" placeholder="D" />
                <span class="sep">@</span>
                <input type="text" v-model="form.od_kk1_axis" class="input-rme-sm" placeholder="°" />
              </div>
              <div class="inline-fields mt-1">
                <span class="label-sm">K2:</span>
                <input type="text" v-model="form.od_kk2" class="input-rme-sm" placeholder="D" />
                <span class="sep">@</span>
                <input type="text" v-model="form.od_kk2_axis" class="input-rme-sm" placeholder="°" />
              </div>
            </div>

            <div class="form-row-inline">
              <label>Tonometri :</label>
              <input type="text" v-model="form.od_tonometri" class="input-rme-sm" placeholder="MmHg" />
            </div>

            <div class="form-row-inline">
              <label>VISUS :</label>
              <input type="text" v-model="form.od_visus" class="input-rme-sm" placeholder="e.g. 6/60" />
            </div>

            <div class="form-row-inline">
              <label>BCVA :</label>
              <span class="sep">→</span>
              <input type="text" v-model="form.od_bcva" class="input-rme-sm" placeholder="e.g. 6/6" />
            </div>

            <div class="form-row-inline">
              <label>Add :</label>
              <input type="text" v-model="form.od_add" class="input-rme-sm" placeholder="+D" />
            </div>

            <div class="form-group-block">
              <label>Kacamata Lama :</label>
              <div class="inline-fields">
                <span class="label-sm">Sph</span>
                <input type="text" v-model="form.od_kacamata_sph" class="input-rme-sm" />
                <span class="sep">/</span>
                <span class="label-sm">Cyl</span>
                <input type="text" v-model="form.od_kacamata_cyl" class="input-rme-sm" />
              </div>
              <div class="inline-fields mt-1">
                <span class="label-sm">x</span>
                <input type="text" v-model="form.od_kacamata_x" class="input-rme-sm" />
                <span class="label-sm ml-2">Addisi</span>
                <input type="text" v-model="form.od_kacamata_addisi" class="input-rme-sm" />
              </div>
            </div>
          </div>

          <!-- OS -->
          <div class="os-col">
            <div class="od-os-header os-header">OCULAR SINISTRA (OS / Kiri)</div>

            <div class="form-row-inline">
              <label>PD :</label>
              <input type="text" v-model="form.os_pd" class="input-rme-sm" placeholder="mm" />
            </div>

            <div class="form-group-block">
              <label>Autoref :</label>
              <div class="inline-fields">
                <input type="text" v-model="form.os_autoref_s" class="input-rme-sm" placeholder="S" />
                <span class="sep">/</span>
                <input type="text" v-model="form.os_autoref_c" class="input-rme-sm" placeholder="C" />
                <span class="sep">x</span>
                <input type="text" v-model="form.os_autoref_x" class="input-rme-sm" placeholder="Axis" />
              </div>
            </div>

            <div class="form-group-block">
              <label>Keratometri :</label>
              <div class="inline-fields">
                <span class="label-sm">K1:</span>
                <input type="text" v-model="form.os_kk1" class="input-rme-sm" placeholder="D" />
                <span class="sep">@</span>
                <input type="text" v-model="form.os_kk1_axis" class="input-rme-sm" placeholder="°" />
              </div>
              <div class="inline-fields mt-1">
                <span class="label-sm">K2:</span>
                <input type="text" v-model="form.os_kk2" class="input-rme-sm" placeholder="D" />
                <span class="sep">@</span>
                <input type="text" v-model="form.os_kk2_axis" class="input-rme-sm" placeholder="°" />
              </div>
            </div>

            <div class="form-row-inline">
              <label>Tonometri :</label>
              <input type="text" v-model="form.os_tonometri" class="input-rme-sm" placeholder="MmHg" />
            </div>

            <div class="form-row-inline">
              <label>VISUS :</label>
              <input type="text" v-model="form.os_visus" class="input-rme-sm" placeholder="e.g. 6/60" />
            </div>

            <div class="form-row-inline">
              <label>BCVA :</label>
              <span class="sep">→</span>
              <input type="text" v-model="form.os_bcva" class="input-rme-sm" placeholder="e.g. 6/6" />
            </div>

            <div class="form-row-inline">
              <label>Add :</label>
              <input type="text" v-model="form.os_add" class="input-rme-sm" placeholder="+D" />
            </div>

            <div class="form-group-block">
              <label>Kacamata Lama :</label>
              <div class="inline-fields">
                <span class="label-sm">Sph</span>
                <input type="text" v-model="form.os_kacamata_sph" class="input-rme-sm" />
                <span class="sep">/</span>
                <span class="label-sm">Cyl</span>
                <input type="text" v-model="form.os_kacamata_cyl" class="input-rme-sm" />
              </div>
              <div class="inline-fields mt-1">
                <span class="label-sm">x</span>
                <input type="text" v-model="form.os_kacamata_x" class="input-rme-sm" />
                <span class="label-sm ml-2">Addisi</span>
                <input type="text" v-model="form.os_kacamata_addisi" class="input-rme-sm" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ================= POSISI BOLA MATA + DIAGRAM ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Posisi dan Pergerakan Bola Mata</h5>
        <div class="mb-3">
          <label class="form-check-inline">
            <input type="checkbox" v-model="form.posisi_normal" class="form-check-input me-1" />
            Normal
          </label>
        </div>

        <div class="eye-diagram-container">
          <p class="text-muted mb-2" style="font-size:12px">Tandai posisi / pergerakan abnormal pada diagram:</p>
          <div class="eye-svg-wrapper">
            <img src="/images/eye-both-background.svg" alt="Diagram Kedua Mata" class="eye-svg-bg"
                 onerror="this.style.display='none'" />
            <VueSignaturePad ref="eyeDiagram" :options="eyeSigOption" class="eye-canvas-overlay" />
          </div>
          <div class="eye-action mt-2">
            <button class="btn btn-sm btn-outline-danger" @click="clearEyeDiagram">
              Hapus Diagram
            </button>
          </div>
        </div>
      </div>

      <!-- ================= STATUS TABEL ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Status Segmen Anterior &amp; Posterior</h5>
        <table class="status-table">
          <thead>
            <tr>
              <th style="width:25%">PEMERIKSAAN</th>
              <th style="width:12%; text-align:center">OD Normal</th>
              <th style="width:12%; text-align:center">OS Normal</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in statusRows" :key="row.key">
              <td class="fw-semibold">{{ row.label }}</td>
              <td class="text-center">
                <input type="checkbox" v-model="form[row.key + '_od_normal']" />
              </td>
              <td class="text-center">
                <input type="checkbox" v-model="form[row.key + '_os_normal']" />
              </td>
              <td>
                <input type="text" v-model="form[row.key + '_ket']" class="input-rme w-100"
                       placeholder="Keterangan bila tidak normal..." />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ================= PEMERIKSAAN PENUNJANG ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Pemeriksaan Penunjang</h5>
        <textarea v-model="form.pemeriksaan_penunjang" class="form-control" rows="3"
                  placeholder="Hasil pemeriksaan laboratorium, OCT, FFA, dll..."></textarea>
      </div>

      <!-- ================= DIAGNOSA ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Diagnosa</h5>
        <div class="row mb-3">
          <div class="col-md-8">
            <label>Diagnose Kerja : <span class="text-danger">*</span></label>
            <textarea v-model="form.diagnose_kerja" class="form-control" rows="2"
                      placeholder="Diagnosa utama..."></textarea>
          </div>
          <div class="col-md-4">
            <label>Kode ICD-10 :</label>
            <input type="text" v-model="form.diagnose_kerja_icd" class="form-control"
                   placeholder="e.g. H35.0" />
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-8">
            <label>Diagnose Banding :</label>
            <textarea v-model="form.diagnose_banding" class="form-control" rows="2"
                      placeholder="Diagnosa banding..."></textarea>
          </div>
          <div class="col-md-4">
            <label>Kode ICD-10 :</label>
            <input type="text" v-model="form.diagnose_banding_icd" class="form-control"
                   placeholder="e.g. H35.1" />
          </div>
        </div>
      </div>

      <!-- ================= TATA LAKSANA & PERENCANAAN ================= -->
      <div class="box-rme mb-4">
        <h5 class="section-title-rme">Tata Laksana &amp; Perencanaan</h5>
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Tata Laksana :</label>
            <textarea v-model="form.tata_laksana" class="form-control" rows="3"
                      placeholder="Terapi, tindakan, resep..."></textarea>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Perencanaan :</label>
            <textarea v-model="form.perencanaan" class="form-control" rows="3"
                      placeholder="Rencana kontrol, operasi, dll..."></textarea>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-6">
            <label>Prognosa :</label>
            <input type="text" v-model="form.prognosa" class="form-control"
                   placeholder="e.g. Bonam, Dubia ad Bonam, dll" />
          </div>
        </div>
      </div>

      <!-- ================= TANDA TANGAN DOKTER ================= -->
      <div class="signature-container">
        <h5 class="section-title-rme text-center mb-4">Tanda Tangan Dokter Verifikasi</h5>
        <div class="signature-section-single">
          <div class="sign-box-center">
            <label>Tanda Tangan DPJP / Dokter</label>

            <!-- Preview TTD -->
            <div v-if="form.ttd_dokter && !signatureCleared" class="signature-preview">
              <img :src="form.ttd_dokter" alt="TTD Dokter" class="img-signature" />
              <p v-if="form.dokter_ttd_timestamp" class="timestamp-ttd">
                Ditandatangani: {{ form.dokter_ttd_timestamp }}
              </p>
              <button @click="clearSignature" class="btn-clear">
                Hapus &amp; Tanda Tangan Ulang
              </button>
            </div>

            <!-- Signature Pad -->
            <div v-else>
              <VueSignaturePad ref="ttd_dokter" :options="sigOption" class="signature-box-rme" />
              <button @click="saveSign" class="btn-save">Simpan ✔</button>
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

  <!-- ================= FOOTER BUTTONS ================= -->
  <div class="action-footer" v-if="!disabledSubmit">
    <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
      <span v-if="loadingSubmit">Menyimpan...</span>
      <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
    </button>
    <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Back</button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormStatusOftalmologis",

  props: {
    selectedPatient: { type: Object, required: true },
    viewData:  { type: Object, default: null },
    editData:  { type: Object, default: null },
  },

  data() {
    return {
      loadingSubmit: false,
      loadingData:   false,
      isEditMode:    false,
      signatureCleared: false,
      disabledSubmit: false,
      listDokter: [],

      sigOption: { penColor: "black", backgroundColor: "white" },
      eyeSigOption: {
        penColor: "#d32f2f",
        backgroundColor: "rgba(0,0,0,0)",
        minWidth: 1,
        maxWidth: 2,
      },

      statusRows: [
        { key: 'status_palpebra',    label: 'PALPEBRA' },
        { key: 'status_conjunctiva', label: 'CONJUNCTIVA' },
        { key: 'status_cornea',      label: 'CORNEA' },
        { key: 'status_bmd',         label: 'BILIK MATA DEPAN' },
        { key: 'status_pupil_iris',  label: 'PUPIL DAN IRIS' },
        { key: 'status_lensa',       label: 'LENSA' },
        { key: 'status_vitreous',    label: 'VITREOUS' },
        { key: 'status_funduscopy',  label: 'FUNDUSCOPY' },
      ],

      form: {
        uuid: "",
        uuid_pasien: "",
        no_rm: "", no_surat: "", jenis_kelamin: "", nama: "", nik: "",
        tanggal_lahir: "",
        tanggal_kunjungan: "",
        jam_kunjungan: "",

        // OD
        od_pd: "", od_autoref_s: "", od_autoref_c: "", od_autoref_x: "",
        od_kk1: "", od_kk1_axis: "", od_kk2: "", od_kk2_axis: "",
        od_tonometri: "", od_visus: "", od_bcva: "", od_add: "",
        od_kacamata_sph: "", od_kacamata_cyl: "", od_kacamata_x: "", od_kacamata_addisi: "",

        // OS
        os_pd: "", os_autoref_s: "", os_autoref_c: "", os_autoref_x: "",
        os_kk1: "", os_kk1_axis: "", os_kk2: "", os_kk2_axis: "",
        os_tonometri: "", os_visus: "", os_bcva: "", os_add: "",
        os_kacamata_sph: "", os_kacamata_cyl: "", os_kacamata_x: "", os_kacamata_addisi: "",

        // Posisi
        posisi_normal: false,
        diagram_mata: "",

        // Status table
        status_palpebra_od_normal: false, status_palpebra_os_normal: false, status_palpebra_ket: "",
        status_conjunctiva_od_normal: false, status_conjunctiva_os_normal: false, status_conjunctiva_ket: "",
        status_cornea_od_normal: false, status_cornea_os_normal: false, status_cornea_ket: "",
        status_bmd_od_normal: false, status_bmd_os_normal: false, status_bmd_ket: "",
        status_pupil_iris_od_normal: false, status_pupil_iris_os_normal: false, status_pupil_iris_ket: "",
        status_lensa_od_normal: false, status_lensa_os_normal: false, status_lensa_ket: "",
        status_vitreous_od_normal: false, status_vitreous_os_normal: false, status_vitreous_ket: "",
        status_funduscopy_od_normal: false, status_funduscopy_os_normal: false, status_funduscopy_ket: "",

        // Klinis
        pemeriksaan_penunjang: "",
        diagnose_kerja: "", diagnose_kerja_icd: "",
        diagnose_banding: "", diagnose_banding_icd: "",
        tata_laksana: "", perencanaan: "", prognosa: "",

        // TTD
        ttd_dokter: "", nama_dokter: "", dokter_ttd_timestamp: "",
      },
    };
  },

  computed: {
    jkDisplay() {
      const jk = this.form.jenis_kelamin;
      if (jk === "L") return "Laki-laki";
      if (jk === "P") return "Perempuan";
      return jk || "-";
    },
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
    await this.fetchNoSurat();
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
        const res = await axios.get("/master/pasien/master-dokter-all");
        this.listDokter = res.data.data;
      } catch (e) {
        console.error("Gagal memuat dokter:", e);
      }
    },

    async fetchNoSurat() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) {
          this.form.no_surat = `RM 1.4/SORJ/${tahun}`;
        }
      } catch (e) {
        if (!this.form.no_surat) this.form.no_surat = "RM 1.4/SORJ/22";
      }
    },

    setDataForm() {
      const today = new Date();
      this.form.tanggal_kunjungan = this.formatDate(today);
      this.form.jam_kunjungan = today.toTimeString().slice(0, 5);

      this.form.uuid_pasien    = this.selectedPatient?.uuid          || "";
      this.form.no_rm          = this.selectedPatient?.rekam_medis   || "";
      this.form.jenis_kelamin  = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama           = this.selectedPatient?.nama          || "";
      this.form.nik            = this.selectedPatient?.no_identitas  || "";

      if (this.selectedPatient?.tanggal_lahir) {
        this.form.tanggal_lahir = this.formatDate(new Date(this.selectedPatient.tanggal_lahir));
      }
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode  = true;
      try {
        let data = null;
        if (typeof this.editData === "string") {
          const res = await axios.get(`/master/rekammedis/lampiran/${this.editData}?type=dokumen_status_oftalmologis`);
          data = res.data.data;
        } else {
          data = this.editData;
        }

        if (data) {
          Object.keys(this.form).forEach((key) => {
            if (data[key] !== undefined && data[key] !== null) {
              this.form[key] = data[key];
            }
          });

          if (data.tanggal_lahir)    this.form.tanggal_lahir    = this.formatDate(new Date(data.tanggal_lahir));
          if (data.tanggal_kunjungan) this.form.tanggal_kunjungan = this.formatDate(new Date(data.tanggal_kunjungan));

          this.$nextTick(() => {
            if (this.form.diagram_mata && this.$refs.eyeDiagram) {
              this.$refs.eyeDiagram.clearSignature();
              this.$refs.eyeDiagram.fromDataURL(this.form.diagram_mata);
            }
          });
        }
      } catch (e) {
        console.error("Error loadEditData:", e);
        alert("Gagal memuat data!");
        this.$emit("back");
      } finally {
        this.loadingData = false;
      }
    },

    clearEyeDiagram() {
      if (this.$refs.eyeDiagram) this.$refs.eyeDiagram.clearSignature();
    },

    clearSignature() {
      this.signatureCleared     = true;
      this.form.ttd_dokter      = "";
      this.form.dokter_ttd_timestamp = "";
      this.$nextTick(() => {
        if (this.$refs.ttd_dokter) this.$refs.ttd_dokter.clearSignature();
      });
    },

    saveSign() {
      const pad = this.$refs.ttd_dokter;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }
      this.form.ttd_dokter = data;
      this.signatureCleared = false;
      const now = new Date();
      this.form.dokter_ttd_timestamp = now.toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });
    },

    getEyeDiagramImage() {
      const pad = this.$refs.eyeDiagram;
      if (!pad || pad.isEmpty()) return null;
      return pad.saveSignature().data;
    },

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return d.toISOString().split("T")[0];
    },

    async submitForm() {
      this.form.diagram_mata = this.getEyeDiagramImage();

      if (!this.form.tanggal_kunjungan) {
        alert("Mohon isi Tanggal Kunjungan!"); return;
      }
      if (!this.form.diagnose_kerja) {
        alert("Mohon isi Diagnose Kerja!"); return;
      }
      if (!this.form.nama_dokter) {
        alert("Mohon pilih Nama Dokter!"); return;
      }

      this.loadingSubmit = true;
      try {
        const fd = new FormData();
        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] !== null && this.form[key] !== undefined ? this.form[key] : "");
        });

        const res = await axios.post("/master/pasien/dokumen-status-oftalmologis", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        if (res.data.status) {
          alert(this.isEditMode ? "Status Oftalmologis berhasil diupdate!" : "Status Oftalmologis berhasil disimpan!");
          this.$emit("back");
        } else {
          alert("Gagal: " + (res.data.message || "Error tidak diketahui"));
        }
      } catch (e) {
        console.error("submitForm error:", e.response?.data || e);
        alert("Gagal menyimpan data!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
/* ── Layout ── */
.container { max-width: 1100px; margin: 0 auto; padding: 20px; }
.py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.form-wrapper { position: relative; }
.view-overlay {
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(255,255,255,0.6); z-index: 10; cursor: not-allowed; border-radius: 8px;
}

/* ── Typography ── */
.fw-bold { font-weight: 700; }
.fw-semibold { font-weight: 600; }
.text-uppercase { text-transform: uppercase; }
.text-center { text-align: center; }
.text-danger { color: #dc3545; }
.text-muted { color: #6c757d; }
.text-center h2 { font-size: 18px; margin-bottom: 10px; }
.text-center h3 { font-size: 16px; margin-top: 20px; margin-bottom: 8px; }
.badge.bg-warning { background: #ffc107; color: #000; padding: 3px 10px; border-radius: 4px; font-size: 12px; }

/* ── Boxes ── */
.box-rme {
  background: #f9fafb; border: 1px solid #e5e7eb;
  border-radius: 10px; padding: 20px;
}
.section-title-rme {
  font-weight: 700; font-size: 14px; color: #1e40af;
  border-left: 4px solid #1e40af; padding-left: 10px; margin-bottom: 16px;
}

/* ── OD/OS grid ── */
.od-os-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
}
.od-col, .os-col { background: #fff; border: 1px solid #d1d5db; border-radius: 8px; padding: 14px; }
.od-os-header {
  font-weight: 700; font-size: 13px; text-align: center;
  padding: 6px 0; margin-bottom: 12px; border-radius: 4px;
}
.od-header { background: #dbeafe; color: #1e3a8a; }
.os-header { background: #dcfce7; color: #14532d; }

/* ── Form row helpers ── */
.form-row-inline {
  display: flex; align-items: center; gap: 6px; margin-bottom: 8px;
}
.form-row-inline label { min-width: 80px; font-size: 12px; font-weight: 600; }
.form-group-block { margin-bottom: 10px; }
.form-group-block label { font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px; }
.inline-fields { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.label-sm { font-size: 11px; color: #6b7280; white-space: nowrap; }
.sep { font-size: 13px; color: #374151; }
.ml-2 { margin-left: 8px; }

/* ── Inputs ── */
.input-rme {
  border: 1px solid #d1d5db; border-radius: 6px;
  padding: 5px 8px; font-size: 13px; background: #fff; width: 100%;
}
.input-rme-sm {
  border: 1px solid #d1d5db; border-radius: 6px;
  padding: 4px 7px; font-size: 12px; background: #fff; width: 70px;
}
.w-100 { width: 100% !important; }
.form-control {
  border: 1px solid #d1d5db; border-radius: 8px;
  padding: 8px 12px; font-size: 13px; width: 100%;
}

/* ── Status Table ── */
.status-table {
  width: 100%; border-collapse: collapse; font-size: 13px;
}
.status-table th {
  background: #eff6ff; color: #1e40af; padding: 8px 10px;
  border: 1px solid #bfdbfe; font-weight: 700; font-size: 12px;
}
.status-table td {
  padding: 7px 10px; border: 1px solid #e5e7eb; vertical-align: middle;
}
.status-table tr:nth-child(even) td { background: #fafafa; }

/* ── Eye Diagram ── */
.eye-diagram-container { display: flex; flex-direction: column; align-items: center; }
.eye-svg-wrapper {
  position: relative; width: 560px; height: 200px;
  border: 1px solid #d1d5db; border-radius: 6px; overflow: hidden;
}
.eye-svg-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
.eye-canvas-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }

/* ── Signature ── */
.signature-container { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 24px; margin-bottom: 20px; }
.signature-section-single { display: flex; justify-content: center; }
.sign-box-center { width: 400px; text-align: center; }
.signature-box-rme { width: 100%; height: 140px; border: 1.5px dashed #94a3b8; border-radius: 8px; background: #fff; }
.signature-preview { margin-bottom: 10px; }
.img-signature { max-width: 250px; border: 1px solid #e2e8f0; border-radius: 4px; }
.timestamp-ttd { font-size: 11px; color: #6b7280; margin-top: 4px; }
.btn-save, .btn-clear { margin-top: 8px; padding: 6px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; border: none; }
.btn-save { background: #16a34a; color: #fff; }
.btn-clear { background: #ef4444; color: #fff; }

/* ── Dokter dropdown ── */
.dropdown-dokter { position: relative; width: 100%; }
.form-select-dokter {
  width: 100%; padding: 10px 40px 10px 14px; font-size: 14px;
  color: #2d3748; background-color: #fff; border: 1.5px solid #cbd5e0;
  border-radius: 10px; appearance: none; -webkit-appearance: none; cursor: pointer;
}
.form-select-dokter:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.2); outline: none; }
.dropdown-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #718096; pointer-events: none; }

/* ── Footer actions ── */
.action-footer { display: flex; gap: 12px; justify-content: center; padding: 20px 0 30px; }
.btn-save-form {
  background: #1e40af; color: #fff; border: none; padding: 10px 32px;
  border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer;
}
.btn-save-form:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-back {
  background: #6b7280; color: #fff; border: none; padding: 10px 24px;
  border-radius: 8px; font-size: 14px; cursor: pointer; margin-bottom: 12px;
  display: inline-block;
}

/* ── Loading ── */
.loading-overlay {
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(255,255,255,0.8); z-index: 20;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  border-radius: 10px;
}
.spinner-rme {
  width: 40px; height: 40px; border: 4px solid #e5e7eb;
  border-top-color: #1e40af; border-radius: 50%; animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Misc ── */
.row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
.col-md-2 { width: 16.666%; padding: 0 8px; }
.col-md-3 { width: 25%; padding: 0 8px; }
.col-md-4 { width: 33.333%; padding: 0 8px; }
.col-md-6 { width: 50%; padding: 0 8px; }
.col-md-8 { width: 66.666%; padding: 0 8px; }
.col-md-12 { width: 100%; padding: 0 8px; }
.mb-1 { margin-bottom: 4px; } .mb-2 { margin-bottom: 8px; } .mb-3 { margin-bottom: 12px; }
.mb-4 { margin-bottom: 16px; } .mt-1 { margin-top: 4px; } .mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 12px; } .me-1 { margin-right: 4px; }
label { font-size: 13px; font-weight: 600; display: block; margin-bottom: 4px; }
hr { border-color: #374151; }
</style>
