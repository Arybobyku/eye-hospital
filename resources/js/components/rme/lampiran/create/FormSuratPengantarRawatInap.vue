<template>
    <div>
        <button @click="$emit('back')" class="btn-back">Kembali</button>

        <div class="container py-4">
            <!-- ================= HEADER ================= -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">SURAT PENGANTAR UNTUK DIRAWAT INAP</h2>
                <h4 class="fw-semibold">RM 2.5/SPUDI/22</h4>
                <span v-if="isEditMode" class="badge bg-warning"
                    >Mode Edit</span
                >
                <span v-else class="badge bg-success">Mode Baru</span>
            </div>

            <!-- ================= INFORMASI PASIEN ================= -->
            <div class="box-rme mb-4">
                <h5 class="section-title-rme">Informasi Pasien</h5>

                <div class="form-row-3-3">
                    <div>
                        <label>No. RM :</label>
                        <input
                            type="text"
                            v-model="form.no_rm"
                            class="input-rme"
                            readonly
                        />
                    </div>
                    <div>
                        <label>NIK :</label>
                        <input
                            type="text"
                            v-model="form.nik"
                            class="input-rme"
                            readonly
                        />
                    </div>
                </div>

                <div class="form-row-3-3">
                    <div>
                        <label>Nama Pasien :</label>
                        <input
                            type="text"
                            v-model="form.nama"
                            class="input-rme"
                            readonly
                        />
                    </div>
                    <div>
                        <label>Tanggal Lahir :</label>
                        <input type="text" v-model="form.tanggal_lahir" class="input-rme" readonly/>
                    </div>
                </div>

                <div class="form-row-3-3">
                    <div>
                        <label>Jenis Kelamin :</label>
                        <input v-model="form.jenis_kelamin" class="input-rme" readonly/>
                            <!-- <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option> -->
    

                    </div>
                </div>
            </div>

            <!-- ================= ASAL RUANGAN ================= -->
            <div class="box-rme mb-4">
                <h5 class="section-title-rme">Asal Ruangan</h5>

                <div class="row">
                    <div class="col-md-12">
                        <label>Asal Ruangan :</label>
                        <div style="display: flex; gap: 20px; flex-wrap: wrap">
                            <label class="radio-label">
                                <input
                                    type="radio"
                                    v-model="form.asal_ruangan"
                                    value="IGD"
                                />
                                IGD
                            </label>
                            <label class="radio-label">
                                <input
                                    type="radio"
                                    v-model="form.asal_ruangan"
                                    value="Poliklinik"
                                />
                                Poliklinik
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mt-2" v-if="form.asal_ruangan === 'Poliklinik'">
                    <div class="col-md-12">
                        <label>Nama Poliklinik :</label>
                        <input
                            type="text"
                            v-model="form.nama_poliklinik"
                            class="input-rme"
                            placeholder="Sebutkan nama poliklinik"
                        />
                    </div>
                </div>
            </div>

            <!-- ================= RENCANA PERAWATAN ================= -->
            <div class="box-rme mb-4">
                <h5 class="section-title-rme">Rencana Perawatan</h5>

                <div class="row">
                    <div class="col-md-12">
                        <label>Rencana Perawatan di :</label>
                        <input
                            type="text"
                            v-model="form.rencana_perawatan_di"
                            class="input-rme"
                            placeholder="Contoh: Ruang Perawatan VIP, Ruang ICU, dll"
                        />
                    </div>
                </div>
            </div>

            <!-- ================= KETERANGAN MEDIS ================= -->
            <div class="box-rme mb-4">
                <h5 class="section-title-rme">Keterangan Medis</h5>

                <div class="row">
                    <div class="col-md-12">
                        <label
                            >Bersama ini kami kirimkan pasien tersebut di atas
                            untuk dirawat inap</label
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Karena Menderita :</label>
                        <textarea
                            v-model="form.karena_menderita"
                            class="textarea-rme"
                            rows="4"
                            placeholder="Jelaskan diagnosis atau penyakit pasien"
                        ></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Saran Terapi :</label>
                        <textarea
                            v-model="form.saran_terapi"
                            class="textarea-rme"
                            rows="4"
                            placeholder="Jelaskan saran terapi yang direkomendasikan"
                        ></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label>Rencana Tindakan :</label>
                        <textarea
                            v-model="form.rencana_tindakan"
                            class="textarea-rme"
                            rows="4"
                            placeholder="Jelaskan rencana tindakan medis yang akan dilakukan"
                        ></textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <p class="mb-0" style="font-style: italic">
                            Mohon ditindaklanjuti untuk rencana tindakan terapi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ================= TANDA TANGAN DOKTER ================= -->
            <div class="box-rme mb-4">
                <h5 class="section-title-rme">Dokter yang Memeriksa</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Medan, Tanggal :</label>
                        <input
                            type="date"
                            v-model="form.tanggal_surat"
                            class="input-rme"
                        />
                    </div>
                </div>

                <div class="text-center mt-4">
                    <label class="fw-bold mb-2 d-block"
                        >Tanda Tangan Dokter yang Memeriksa</label
                    >
                    <VueSignaturePad
                        ref="ttd_dokter"
                        :options="sigOption"
                        class="signature-box-rme mx-auto"
                    />
                    <button
                        @click="saveSign('ttd_dokter')"
                        class="btn-save mt-2 d-block mx-auto"
                    >
                        Simpan ✔
                    </button>
                    <input
                        type="text"
                        v-model="form.nama_dokter_ttd"
                        class="input-rme mt-2"
                        placeholder="Nama Lengkap Dokter"
                    />
                </div>
            </div>

            <!-- ================= BUTTON BOTTOM ================= -->
            <div class="action-footer">
                <button
                    class="btn-save-form"
                    @click="submitForm"
                    :disabled="loadingSubmit"
                >
                    <span v-if="loadingSubmit">Menyimpan...</span>
                    <span v-else>{{ isEditMode ? "Update" : "Simpan" }}</span>
                </button>

                <button @click="$emit('back')" class="btn-back">Kembali</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormSuratPengantarRawatInap",

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
    editData: {
      type: Object,
      default: null,
    },
    editUuid: {
      type: String,
      default: null,
    },
  },

  data() {
    return {
      loadingSubmit: false,
      loadingData: false,
      isEditMode: false,
      signatureCleared: {
        ttd_dokter: false,
      },
      sigOption: {
        penColor: "black",
        backgroundColor: "white",
      },
      form: {
    // ================= IDENTITAS DATA =================
    uuid: "",
    uuid_pasien: "",

    // ================= INFORMASI PASIEN =================
    no_rm: "",
    nik: "",
    nama: "",
    tanggal_lahir: "",
    jenis_kelamin: "",

    // ================= ASAL RUANGAN =================
    asal_ruangan: "",        // IGD / Poliklinik
    nama_poliklinik: "",     // wajib jika Poliklinik

    // ================= RENCANA PERAWATAN =================
    rencana_perawatan_di: "",

    // ================= KETERANGAN MEDIS =================
    karena_menderita: "",
    saran_terapi: "",
    rencana_tindakan: "",

    // ================= SURAT & DOKTER =================
    tanggal_surat: "",
    ttd_dokter: "",          // base64 dari VueSignaturePad
    nama_dokter_ttd: "",
},

    };
  },
  computed: {
    isEditMode() {
      return !!this.editUuid;
    }
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
      const today = new Date();
      this.form.tanggal = this.formatDate(today);

      // Data default (wajib dikirim ke BE)
      this.form.uuid_pasien = this.selectedPatient?.uuid || "";
      this.form.no_rm = this.selectedPatient?.rekam_medis || "";
      this.form.jenis_kelamin = this.selectedPatient?.jenis_kelamin || "";
      this.form.nama = this.selectedPatient?.nama || "";
      this.form.nik = this.selectedPatient?.nik || "";

      // Data pasien untuk form
      this.form.pasien_nama = this.selectedPatient?.nama || "";
      
      // Hitung umur dari tanggal lahir
      if (this.selectedPatient?.tanggal_lahir) {
        this.form.pasien_umur = this.calculateAge(this.selectedPatient.tanggal_lahir);
      }
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode = true;

      try {
        let data = null;

        // Jika editData berupa UUID string, fetch dari API
        // if (typeof this.editData === "string") {
          const response = await axios.get(
            `/master/rekammedis/lampiran/${this.editUuid}?type=surat_pengantar_rawat_inap`


          );
          data = response.data.data;
          console.log("Fetched edit data:", data);
        // } else {
        //   // Jika editData sudah berupa object
        //   data = this.editData;
        // }

        // if (data) {
          // Populate form dengan data yang ada
          Object.keys(this.form).forEach(key => {
            if (data[key] !== undefined) {
              this.form[key] = data[key];
            }
          });

          // Format tanggal jika perlu
          if (data.tanggal) {
            this.form.tanggal = this.formatDate(new Date(data.tanggal));
          }

        //   console.log("Data loaded for edit:", this.form);
        // }
        
             this.$nextTick(() => {
            const signatureRefs = [
              'ttd_dokter',
            ];

            signatureRefs.forEach(ref => {
              if (this.form[ref] && this.$refs[ref]) {
                this.$refs[ref].fromDataURL(this.form[ref]);
              }
            });
          });
      } catch (error) {
        console.error("Error loading edit data:", error);
        alert("Gagal memuat data untuk edit!");
        this.$emit("back");
      } finally {
        this.loadingData = false;
      }
    },

    clearSignature(refName) {
      this.signatureCleared[refName] = true;
      this.form[refName] = "";

      // Reset signature pad di next tick
      this.$nextTick(() => {
        const pad = this.$refs[refName];
        if (pad) {
          pad.clearSignature();
        }
      });
    },

    calculateAge(birthDate) {
      if (!birthDate) return "";
      
      const today = new Date();
      const birth = new Date(birthDate);
      let age = today.getFullYear() - birth.getFullYear();
      const monthDiff = today.getMonth() - birth.getMonth();
      
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
      }
      
      return `${age} tahun`;
    },

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      return d.toISOString().split("T")[0];
    },

    formatTanggal(dateStr) {
      if (!dateStr) return "";
      const options = { year: "numeric", month: "long", day: "numeric" };
      const d = new Date(dateStr);
      return d.toLocaleDateString("id-ID", options);
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

      this.form[refName] = data;
      console.log("TTD saved:", refName);
    },

    async submitForm() {
      // Validasi
    //   if (!this.form.tujuan_nama_dokter || !this.form.tujuan_lokasi) {
    //     alert("Mohon lengkapi data dokter dan lokasi tujuan konsul!");
    //     return;
    //   }

    //   if (!this.form.keluhan_utama || !this.form.diagnosa_sementara) {
    //     alert("Mohon lengkapi keluhan utama dan diagnosa sementara!");
    //     return;
    //   }

      if (!this.form.ttd_dokter) {
        alert("Mohon lengkapi tanda tangan dokter!");
        return;
      }

      this.loadingSubmit = true;

      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          fd.append(key, this.form[key] || "");
        });

        const response = await axios.post(
          "/master/pasien/dokumen-surat-pengantar-rawat-inap",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        console.log("BERHASIL:", response.data);

        const message = this.isEditMode
          ? "Surat Pengantar Rawat Inap berhasil diupdate!"
          : "Surat Pengantar Rawat Inap berhasil disimpan!";

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
    max-width: 1200px;
    margin: 0 auto;
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
    width: 350px !important;
    height: 220px !important;
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

.row {
    display: flex;
    flex-wrap: wrap;
    margin-left: -8px;
    margin-right: -8px;
}

.col-md-6,
.col-md-12 {
    padding-left: 8px;
    padding-right: 8px;
    margin-bottom: 8px;
}

.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}
.col-md-12 {
    flex: 0 0 100%;
    max-width: 100%;
}

.mb-0 {
    margin-bottom: 0;
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
.mt-3 {
    margin-top: 16px;
}
.mt-4 {
    margin-top: 24px;
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
.d-block {
    display: block;
}

@media (max-width: 768px) {
    .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>
