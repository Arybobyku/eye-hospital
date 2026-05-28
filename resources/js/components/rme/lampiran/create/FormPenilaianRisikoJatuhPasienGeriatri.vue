<template>
  <div>
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
          <h3 class="fw-bold mt-4 mb-2">FORMULIR PENILAIAN RISIKO JATUH PASIEN GERIATRI</h3>
          <h4 class="fw-semibold">{{ form.no_surat }}</h4>
          <span v-if="isEditMode && !disabledSubmit" class="badge bg-warning">Mode Edit</span>
        </div>

        <!-- ================= DATA PASIEN ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Data Pasien</h5>

          <div class="patient-grid">
            <div class="patient-field">
              <label class="patient-label">Nama</label>
              <input type="text" v-model="form.nama" class="input-rme" readonly />
            </div>
            <div class="patient-field">
              <label class="patient-label">No. Rekam Medis</label>
              <input type="text" v-model="form.no_rm" class="input-rme" readonly />
            </div>
            <div class="patient-field">
              <label class="patient-label">Jenis Kelamin</label>
              <input type="text" v-model="form.jenis_kelamin" class="input-rme" readonly />
            </div>
            <div class="patient-field">
              <label class="patient-label">Tanggal Lahir</label>
              <input type="date" v-model="form.tanggal_lahir" class="input-rme" readonly />
            </div>
          </div>
        </div>

        <!-- ================= PENILAIAN RISIKO - DYNAMIC ROWS ================= -->
        <div class="box-rme mb-4">
          <div class="table-header-row">
            <h5 class="section-title-rme mb-0">Penilaian Risiko Jatuh</h5>
            <button @click="addRow" class="btn-add-row" v-if="!disabledSubmit">
              <i class="fas fa-plus"></i> Tambah Penilaian
            </button>
          </div>

          <!-- Legend -->
          <div class="risiko-legend mb-3">
            <p class="legend-title">Keterangan Nomor Faktor Risiko :</p>
            <div class="legend-grid">
              <span v-for="item in risikoItems" :key="item.no" class="legend-item">
                <strong>{{ item.no }}</strong>. {{ item.label }} <em>({{ item.skor }})</em>
              </span>
            </div>
            <p class="legend-keterangan mt-2">
              &#9724; Tidak Berisiko (skor 0) &nbsp;|&nbsp;
              &#9724; Risiko Rendah (skor 1–3) &nbsp;|&nbsp;
              &#9724; Risiko Tinggi (skor &#8805; 4)
            </p>
          </div>

          <div class="table-responsive">
            <table class="penilaian-table">
              <thead>
                <tr>
                  <th rowspan="2" style="width:110px; vertical-align:middle;">Tanggal / Jam</th>
                  <th colspan="11" style="text-align:center;">Faktor Risiko (centang jika ada)</th>
                  <th rowspan="2" style="width:110px; vertical-align:middle;">Skor &amp;<br/>Risiko</th>
                  <th rowspan="2" style="width:180px; vertical-align:middle;">Nama Penilai &amp;<br/>Tanda Tangan</th>
                  <th rowspan="2" style="width:50px; vertical-align:middle;" v-if="!disabledSubmit">Aksi</th>
                </tr>
                <tr>
                  <th
                    v-for="item in risikoItems"
                    :key="item.no"
                    style="width:48px; text-align:center;"
                    :title="item.label"
                    class="item-header"
                  >
                    {{ item.no }}<br/><small class="skor-kecil">({{ item.skor }})</small>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in form.penilaian_rows" :key="index">
                  <!-- Tanggal / Jam -->
                  <td>
                    <input type="date" v-model="row.tanggal" class="input-table mb-1" />
                    <input type="time" v-model="row.jam"     class="input-table" />
                  </td>

                  <!-- Checkboxes item 1–11 -->
                  <td v-for="item in risikoItems" :key="item.no" class="text-center">
                    <input
                      type="checkbox"
                      class="check-item"
                      :checked="row['item_' + item.no] == 1"
                      @change="toggleRowItem(index, item.no, $event)"
                    />
                  </td>

                  <!-- Skor & Risiko -->
                  <td class="text-center">
                    <div class="score-num">{{ computeRowSkor(row) }}</div>
                    <span class="risiko-badge-sm" :class="getRisikoClass(computeRowSkor(row))">
                      {{ getRisikoLevel(computeRowSkor(row)) }}
                    </span>
                  </td>

                  <!-- Nama Penilai & TTD -->
                  <td>
                    <input
                      type="text"
                      v-model="row.nama_penilai"
                      class="input-table mb-1"
                      placeholder="Nama penilai"
                    />
                    <div class="signature-cell">
                      <div v-if="row.ttd_penilai && !ttdPenilaiCleared[index]">
                        <img :src="row.ttd_penilai" class="ttd-preview" />
                        <p v-if="row.ttd_penilai_timestamp" class="ttd-timestamp">
                          {{ row.ttd_penilai_timestamp }}
                        </p>
                        <button
                          @click="clearSignRow(index)"
                          class="btn-clear-mini"
                          v-if="!disabledSubmit"
                          type="button"
                        >Hapus</button>
                      </div>
                      <div v-else>
                        <VueSignaturePad
                          :ref="`ttd_penilai_${index}`"
                          :options="sigOption"
                          class="signature-box-table"
                        />
                        <button
                          @click="saveSignRow(index)"
                          class="btn-save-mini"
                          v-if="!disabledSubmit"
                          type="button"
                        >Simpan ✔</button>
                      </div>
                    </div>
                  </td>

                  <!-- Aksi -->
                  <td class="text-center" v-if="!disabledSubmit">
                    <button
                      @click="deleteRow(index)"
                      class="btn-delete-row"
                      :disabled="form.penilaian_rows.length === 1"
                      title="Hapus Baris"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>

                <tr v-if="form.penilaian_rows.length === 0">
                  <td :colspan="disabledSubmit ? 15 : 16" class="text-center text-muted py-3">
                    Belum ada penilaian. Klik "Tambah Penilaian" untuk menambah data.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="summary-info mt-3">
            <strong>Total Penilaian :</strong> {{ form.penilaian_rows.length }} entri
          </div>
        </div>

        <!-- ================= INTERVENSI A ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">A. Intervensi Jatuh Standar / Risiko Rendah (Skor 1–3)</h5>

          <div v-for="item in intervensiA" :key="'a'+item.key" class="intervensi-item">
            <div class="intervensi-row">
              <span class="intervensi-no">{{ item.no }}.</span>
              <span class="intervensi-label">{{ item.label }}</span>
              <div class="intervensi-ya-tidak">
                <label class="cb-ya">
                  <input type="radio" :name="'int_a'+item.key" :value="1" v-model="form['int_a'+item.key]" />
                  Ya
                </label>
                <label class="cb-tidak">
                  <input type="radio" :name="'int_a'+item.key" :value="0" v-model="form['int_a'+item.key]" />
                  Tidak
                </label>
              </div>
            </div>
            <ul v-if="item.subs" class="sub-bullets">
              <li v-for="sub in item.subs" :key="sub">{{ sub }}</li>
            </ul>
          </div>
        </div>

        <!-- ================= INTERVENSI B ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">B. Intervensi Jatuh Risiko Tinggi (Skor &#8805; 4)</h5>

          <div v-for="item in intervensiB" :key="'b'+item.key" class="intervensi-item">
            <div class="intervensi-row">
              <span class="intervensi-no">{{ item.no }}.</span>
              <span class="intervensi-label">{{ item.label }}</span>
              <div class="intervensi-ya-tidak">
                <label class="cb-ya">
                  <input type="radio" :name="'int_b'+item.key" :value="1" v-model="form['int_b'+item.key]" />
                  Ya
                </label>
                <label class="cb-tidak">
                  <input type="radio" :name="'int_b'+item.key" :value="0" v-model="form['int_b'+item.key]" />
                  Tidak
                </label>
              </div>
            </div>
            <ul v-if="item.subs" class="sub-bullets">
              <li v-for="sub in item.subs" :key="sub">{{ sub }}</li>
            </ul>
          </div>

        </div>

        <!-- ================= NAMA PETUGAS ================= -->
        <div class="box-rme mb-4">
          <h5 class="section-title-rme">Nama Petugas</h5>
          <div class="petugas-center">
            <label>Nama Petugas :</label>
            <input
              type="text"
              v-model="form.nama_petugas"
              class="form-control petugas-input"
              placeholder="Nama petugas yang bertanggung jawab"
            />

            <!-- Paraf Petugas -->
            <div class="paraf-box mt-3">
              <p class="paraf-title">Paraf Petugas</p>

              <div v-if="form.ttd_petugas && !signaturePetugasCleared">
                <img :src="form.ttd_petugas" alt="Paraf Petugas" class="img-paraf" />
                <p v-if="form.ttd_petugas_timestamp" class="timestamp-ttd">
                  Ditandatangani: {{ form.ttd_petugas_timestamp }}
                </p>
                <button @click="clearSignaturePetugas()" class="btn-clear-paraf" type="button">
                  Hapus &amp; Paraf Ulang
                </button>
              </div>

              <div v-else>
                <VueSignaturePad
                  ref="ttd_petugas"
                  width="300px"
                  height="120px"
                  :options="sigOption"
                  style="border: 2px solid #999; border-radius: 4px; background: white;"
                />
                <button @click="saveSignPetugas()" class="btn-save-paraf" type="button">
                  Simpan ✔
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ================= ACTION FOOTER ================= -->
    <div class="action-footer" v-if="!disabledSubmit">
      <button class="btn-save-form" @click="submitForm" :disabled="loadingSubmit">
        <span v-if="loadingSubmit">Menyimpan...</span>
        <span v-else>{{ isEditMode ? 'Update' : 'Save' }}</span>
      </button>
      <button class="btn-back" @click="$emit('back')" :disabled="loadingSubmit">Back</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FormPenilaianRisikoJatuhPasienGeriatri",

  props: {
    selectedPatient: { type: Object, required: true },
    viewData:        { type: Object, default: null },
    editData:        { type: Object, default: null },
  },

  data() {
    return {
      loadingSubmit:          false,
      loadingData:            false,
      isEditMode:             false,
      disabledSubmit:         false,
      ttdPenilaiCleared:      [],
      signaturePetugasCleared: false,

      sigOption: { penColor: "black", backgroundColor: "white" },

      risikoItems: [
        { no: 1,  label: "Gangguan gaya berjalan (diseret, menghentak, bergoyang)", skor: 4 },
        { no: 2,  label: "Pusing / pingsan pada posisi tegak",                      skor: 3 },
        { no: 3,  label: "Kebingungan setiap saat",                                 skor: 3 },
        { no: 4,  label: "Nokturia / Inkontinen",                                   skor: 3 },
        { no: 5,  label: "Kebingungan intermiten",                                  skor: 2 },
        { no: 6,  label: "Kelemahan umum",                                          skor: 2 },
        { no: 7,  label: "Obat-obat berisiko tinggi (diuretik, narkotik, sedatif, anti psikotik, laksatif, vasodilator, antiaritmia, antihipertensi, obat hipoglikemik, obat tidur, antidepresan, neuroleptik, NSAID)", skor: 2 },
        { no: 8,  label: "Riwayat jatuh yang dialami dalam waktu 12 bulan",         skor: 2 },
        { no: 9,  label: "Osteoporosis",                                            skor: 1 },
        { no: 10, label: "Gangguan pendengaran dan atau penglihatan",               skor: 1 },
        { no: 11, label: "Usia 70 tahun ke atas",                                  skor: 1 },
      ],

      intervensiA: [
        { no: 1, key: 1, label: "Menilai kembali risiko jatuh setiap pergantian shift" },
        { no: 2, key: 2, label: "Memberikan edukasi disertai brosur pencegahan jatuh pada pasien / keluarga" },
        { no: 3, key: 3, label: "Memastikan lingkungan yang aman dan nyaman:", subs: [
          "Ruang rapi",
          "Jalur pasien bebas obstruksi",
          "Menunjukkan dan dekatkan bel pemanggil darurat dan benda pribadi seperti handphone dalam jangkauan",
          "Posisikan tempat tidur rendah, roda terkunci dan kedua sisi pegangan tempat tidur terpasang dengan baik",
          "Pastikan cahaya adekuat dan sesuai kebutuhan pasien",
          "Menjaga lantai kamar mandi dengan karpet anti slip / tidak licin",
        ]},
        { no: 4, key: 4, label: "Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam): jadwalkan ke belakang (kamar kecil) secara teratur" },
      ],

      intervensiB: [
        { no: 1,  key: 1,  label: "Melakukan intervensi jatuh risiko rendah" },
        { no: 2,  key: 2,  label: "Pakaikan gelang risiko jatuh warna kuning" },
        { no: 3,  key: 3,  label: "Pasang tanda risiko jatuh segitiga warna kuning pada bed pasien atau berikan tanda di depan kamar pasien" },
        { no: 4,  key: 4,  label: "Mengkomunikasikan risiko jatuh pasien pada anggota tim interdisiplin" },
        { no: 5,  key: 5,  label: "Dorong partisipasi keluarga dalam keselamatan pasien (jangan tinggalkan pasien sendiri)" },
        { no: 6,  key: 6,  label: "Menempatkan pasien di kamar yang dekat nurse station" },
        { no: 7,  key: 7,  label: "Melakukan kunjungan dan pengawasan ketat terhadap pasien (minimal 1 jam)" },
        { no: 8,  key: 8,  label: "Gunakan kaus kaki atau sepatu yang tidak licin dan siapkan alat bantu jalan yang sesuai (walker)" },
        { no: 9,  key: 9,  label: "Konsul ke:", subs: [
          "Farmasi Klinik unit kerja untuk kemungkinan interaksi obat",
          "Rehabilitasi Medik untuk masalah mobilitas / aktivitas harian / ADL baru",
        ]},
        { no: 10, key: 10, label: "Gunakan aktivitas pengalihan untuk mencegah pasien keluyuran" },
        { no: 11, key: 11, label: "Komunikasikan risiko pasien jatuh pada saat laporan antar shift" },
      ],

      form: {
        uuid:          "",
        uuid_pasien:   "",
        no_rm:         "",
        no_surat:      "",
        nik:           "",
        nama:          "",
        tanggal_lahir: "",
        jenis_kelamin: "",

        penilaian_rows: [],

        int_a1: null, int_a2: null, int_a3: null, int_a4: null,
        int_b1: null, int_b2: null, int_b3: null, int_b4: null,
        int_b5: null, int_b6: null, int_b7: null, int_b8: null,
        int_b9: null, int_b10: null, int_b11: null,

        nama_petugas:           "",
        ttd_petugas:            "",
        ttd_petugas_timestamp:  "",
      },
    };
  },

  async mounted() {
    await this.fetchTahunAkreditasi();
    this.disabledSubmit = false;

    if (this.viewData) {
      this.disabledSubmit = true;
      this.loadViewData();
    } else if (this.editData) {
      this.loadEditData();
    } else {
      this.setDataForm();
    }
  },

  methods: {
    /* -------- helpers -------- */
    makeEmptyRow() {
      const now = new Date();
      return {
        tanggal: now.toISOString().split("T")[0],
        jam:     now.toTimeString().slice(0, 5),
        item_1:  0, item_2:  0, item_3:  0, item_4:  0,
        item_5:  0, item_6:  0, item_7:  0, item_8:  0,
        item_9:  0, item_10: 0, item_11: 0,
        nama_penilai:          "",
        ttd_penilai:           "",
        ttd_penilai_timestamp: "",
      };
    },

    skorMap() {
      return { 1:4, 2:3, 3:3, 4:3, 5:2, 6:2, 7:2, 8:2, 9:1, 10:1, 11:1 };
    },

    computeRowSkor(row) {
      const map = this.skorMap();
      let total = 0;
      for (let i = 1; i <= 11; i++) {
        if (row["item_" + i] == 1) total += map[i];
      }
      return total;
    },

    getRisikoLevel(skor) {
      if (skor === 0) return "Tidak Berisiko";
      if (skor <= 3)  return "Risiko Rendah";
      return "Risiko Tinggi";
    },

    getRisikoClass(skor) {
      if (skor === 0) return "badge-hijau";
      if (skor <= 3)  return "badge-kuning";
      return "badge-merah";
    },

    formatDate(date) {
      if (!date) return "";
      return new Date(date).toISOString().split("T")[0];
    },

    /* -------- fetch -------- */
    async fetchTahunAkreditasi() {
      try {
        const res = await axios.get("/api/tahun-akreditasi");
        const tahun = res.data.tahun || "22";
        if (!this.form.no_surat) this.form.no_surat = `RM 6.5/FPRJPG/${tahun}`;
      } catch {
        if (!this.form.no_surat) this.form.no_surat = "RM 6.5/FPRJPG/22";
      }
    },

    /* -------- init -------- */
    setDataForm() {
      if (this.selectedPatient) {
        this.form.uuid_pasien   = this.selectedPatient.uuid        || "";
        this.form.no_rm         = this.selectedPatient.rekam_medis || "";
        this.form.nik           = this.selectedPatient.no_identitas || "";
        this.form.nama          = this.selectedPatient.nama        || "";
        this.form.jenis_kelamin = this.selectedPatient.jenis_kelamin || "";
        if (this.selectedPatient.tanggal_lahir) {
          this.form.tanggal_lahir = this.formatDate(new Date(this.selectedPatient.tanggal_lahir));
        }
      }
      // Start with one empty assessment row
      this.form.penilaian_rows = [this.makeEmptyRow()];
      this.ttdPenilaiCleared   = [false];
    },

    loadViewData() {
      if (this.viewData) this.populateForm(this.viewData);
    },

    async loadEditData() {
      this.loadingData = true;
      this.isEditMode  = true;
      try {
        let data = this.editData;
        if (typeof this.editData === "string") {
          const res = await axios.get(
            `/master/pasien/dokumen-penilaian-risiko-jatuh-geriatri/${this.editData}`
          );
          data = res.data.data;
        }
        if (data) this.populateForm(data);
      } catch (err) {
        console.error("Error loadEditData:", err);
        alert("Gagal memuat data edit!");
        this.$emit("back");
      } finally {
        this.loadingData = false;
      }
    },

    populateForm(data) {
      Object.keys(this.form).forEach((key) => {
        if (key === "penilaian_rows") return;
        if (data[key] !== undefined && data[key] !== null) {
          this.form[key] = data[key];
        }
      });

      if (data.tanggal_lahir) {
        this.form.tanggal_lahir = this.formatDate(new Date(data.tanggal_lahir));
      }

      // Parse penilaian_rows
      let rows = [];
      if (data.penilaian_rows) {
        rows = typeof data.penilaian_rows === "string"
          ? JSON.parse(data.penilaian_rows)
          : data.penilaian_rows;
      }

      // Fallback: if old single-row data exists (item_1 ... item_11)
      if (rows.length === 0 && data.item_1 !== undefined) {
        const oldRow = {
          tanggal: data.tanggal ? this.formatDate(new Date(data.tanggal)) : "",
          jam: data.jam || "",
          item_1: data.item_1 || 0, item_2:  data.item_2  || 0,
          item_3: data.item_3 || 0, item_4:  data.item_4  || 0,
          item_5: data.item_5 || 0, item_6:  data.item_6  || 0,
          item_7: data.item_7 || 0, item_8:  data.item_8  || 0,
          item_9: data.item_9 || 0, item_10: data.item_10 || 0,
          item_11: data.item_11 || 0,
          nama_penilai:          data.nama_penilai          || "",
          ttd_penilai:           data.ttd_penilai           || "",
          ttd_penilai_timestamp: data.ttd_penilai_timestamp || "",
        };
        rows = [oldRow];
      }

      if (rows.length === 0) {
        rows = [this.makeEmptyRow()];
      }

      this.form.penilaian_rows = rows;
      this.$nextTick(() => {
        this.ttdPenilaiCleared = rows.map((r) => !r.ttd_penilai);
      });
    },

    /* -------- row management -------- */
    addRow() {
      this.form.penilaian_rows.push(this.makeEmptyRow());
      this.ttdPenilaiCleared.push(false);
    },

    deleteRow(index) {
      if (this.form.penilaian_rows.length > 1) {
        this.form.penilaian_rows.splice(index, 1);
        this.ttdPenilaiCleared.splice(index, 1);
      }
    },

    toggleRowItem(index, no, event) {
      this.form.penilaian_rows[index]["item_" + no] = event.target.checked ? 1 : 0;
    },

    /* -------- signature (per row) -------- */
    saveSignRow(index) {
      const refName = `ttd_penilai_${index}`;
      const pad = this.$refs[refName];
      const sp  = Array.isArray(pad) ? pad[0] : pad;
      if (!sp) { console.error("REF tidak ditemukan:", refName); return; }

      const { isEmpty, data } = sp.saveSignature();
      if (isEmpty) { alert("Tanda tangan masih kosong!"); return; }

      this.form.penilaian_rows[index].ttd_penilai = data;
      this.ttdPenilaiCleared[index] = false;

      const ts = new Date().toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });
      this.form.penilaian_rows[index].ttd_penilai_timestamp = ts;
    },

    clearSignRow(index) {
      this.ttdPenilaiCleared[index] = true;
      this.form.penilaian_rows[index].ttd_penilai           = "";
      this.form.penilaian_rows[index].ttd_penilai_timestamp = "";

      this.$nextTick(() => {
        this.$nextTick(() => {
          const refName = `ttd_penilai_${index}`;
          const pad = this.$refs[refName];
          const sp  = Array.isArray(pad) ? pad[0] : pad;
          if (sp) sp.clearSignature();
        });
      });
    },

    /* -------- signature petugas (bottom) -------- */
    saveSignPetugas() {
      const pad = this.$refs.ttd_petugas;
      if (!pad) return;
      const { isEmpty, data } = pad.saveSignature();
      if (isEmpty) { alert("Paraf masih kosong!"); return; }
      this.form.ttd_petugas           = data;
      this.signaturePetugasCleared    = false;
      this.form.ttd_petugas_timestamp = new Date().toLocaleString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit", second: "2-digit",
      });
    },

    clearSignaturePetugas() {
      this.signaturePetugasCleared   = true;
      this.form.ttd_petugas          = "";
      this.form.ttd_petugas_timestamp = "";
      this.$nextTick(() => {
        const pad = this.$refs.ttd_petugas;
        if (pad) pad.clearSignature();
      });
    },

    /* -------- submit -------- */
    async submitForm() {
      if (this.form.penilaian_rows.length === 0) {
        alert("Minimal harus ada 1 penilaian risiko!"); return;
      }
      const hasData = this.form.penilaian_rows.some(
        (r) => r.tanggal || r.nama_penilai
      );
      if (!hasData) {
        alert("Harap isi minimal tanggal atau nama penilai pada baris penilaian!"); return;
      }

      this.loadingSubmit = true;
      try {
        const fd = new FormData();

        Object.keys(this.form).forEach((key) => {
          if (key === "uuid" && !this.form[key]) return;
          if (key === "penilaian_rows") {
            fd.append(key, JSON.stringify(this.form[key]));
          } else {
            fd.append(key, this.form[key] !== null && this.form[key] !== undefined ? this.form[key] : "");
          }
        });

        await axios.post(
          "/master/pasien/dokumen-penilaian-risiko-jatuh-geriatri",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        alert(this.isEditMode ? "Dokumen berhasil diupdate!" : "Dokumen berhasil disimpan!");
        this.$emit("back");
      } catch (err) {
        console.error("ERROR:", err.response?.data || err);
        alert("Gagal menyimpan data!");
      } finally {
        this.loadingSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
/* ================= CONTAINER ================= */
.container { max-width: 1400px; margin: 0 auto; padding: 20px; }
.py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.form-wrapper { position: relative; }
.view-overlay {
  position: absolute; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(255,251,251,0.1); z-index: 10; cursor: not-allowed;
}

/* ================= TYPOGRAPHY ================= */
.fw-bold { font-weight: 700; }
.fw-semibold { font-weight: 600; }
.text-center { text-align: center; }
.text-danger { color: #dc3545; }
.text-muted { color: #6c757d; }
.text-center h3 { font-size: 16px; margin-top: 20px; margin-bottom: 10px; }
.text-center h4 { font-size: 15px; margin-bottom: 20px; color: #555; }

/* ================= BADGE ================= */
.badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-left: 10px; margin-top: 10px; }
.badge.bg-warning { background: #ff9800; color: white; }

/* ================= BOX ================= */
.box-rme { border: 1px solid #dcdcdc; padding: 20px; border-radius: 6px; background: #fafafa; margin-bottom: 20px; }
.section-title-rme { font-weight: bold; margin-bottom: 15px; color: #2d74b7; font-size: 16px; border-bottom: 2px solid #2d74b7; padding-bottom: 8px; }

/* ================= PATIENT GRID ================= */
.patient-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px 20px;
}
.patient-field { display: flex; flex-direction: column; }
.patient-label { font-weight: 600; font-size: 13px; color: #555; margin-bottom: 5px; }

/* ================= FORM ELEMENTS ================= */
label { display: block; margin-bottom: 8px; font-weight: 500; color: #555; font-size: 14px; }
.input-rme { width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px 12px; background: #f5f5f5; font-size: 14px; color: #666; cursor: not-allowed; box-sizing: border-box; display: block; }
.form-control { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box; display: block; }
.form-control:focus { outline: none; border-color: #2d74b7; }

/* ================= ROW / COL ================= */
.row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
.col-md-6  { flex: 0 0 50%; max-width: 50%; padding: 0 10px; margin-bottom: 15px; box-sizing: border-box; }
.col-md-12 { flex: 0 0 100%; max-width: 100%; padding: 0 10px; margin-bottom: 15px; box-sizing: border-box; }
.mb-1 { margin-bottom: 5px; }
.mb-2 { margin-bottom: 10px; }
.mb-3 { margin-bottom: 15px; }
.mb-4 { margin-bottom: 20px; }
.mt-2 { margin-top: 10px; }
.mt-3 { margin-top: 15px; }
.py-3 { padding-top: 15px; padding-bottom: 15px; }

/* ================= TABLE HEADER ROW ================= */
.table-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

/* ================= LEGEND ================= */
.risiko-legend { background: #f0f7ff; border: 1px solid #c5dff8; border-radius: 6px; padding: 12px 16px; }
.legend-title { font-weight: 600; color: #2d74b7; margin: 0 0 8px 0; font-size: 13px; }
.legend-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 20px; }
.legend-item { font-size: 12px; color: #333; border-bottom: 1px dashed #ddd; padding: 3px 0; }
.legend-keterangan { font-size: 12px; color: #555; margin: 0; }

/* ================= PENILAIAN TABLE ================= */
.table-responsive { overflow-x: auto; }
.penilaian-table { width: 100%; border-collapse: collapse; font-size: 12px; min-width: 900px; }
.penilaian-table th {
  background: #2d74b7; color: white;
  padding: 8px 6px; border: 1px solid #fff;
  font-weight: 600; text-align: center; vertical-align: middle;
}
.penilaian-table td {
  border: 1px solid #ddd;
  padding: 8px 6px;
  vertical-align: middle;
}
.item-header { font-size: 12px; }
.skor-kecil { font-size: 10px; color: #cde; }

.input-table {
  width: 100%; border: 1px solid #ccc; border-radius: 3px;
  padding: 5px 6px; font-size: 12px; box-sizing: border-box;
}
.input-table:focus { outline: none; border-color: #2d74b7; }

.check-item { width: 16px; height: 16px; cursor: pointer; }

/* ================= SCORE PER ROW ================= */
.score-num { font-size: 1.5rem; font-weight: bold; color: #2d74b7; display: block; }
.risiko-badge-sm { display: inline-block; padding: 3px 8px; border-radius: 10px; font-weight: bold; font-size: 10px; color: white; margin-top: 4px; white-space: nowrap; }
.badge-hijau  { background: #28a745; }
.badge-kuning { background: #ffc107; color: #333; }
.badge-merah  { background: #dc3545; }

/* ================= SIGNATURE CELL (per row) ================= */
.signature-cell { display: flex; flex-direction: column; align-items: center; gap: 4px; margin-top: 4px; }
.signature-box-table { width: 150px; height: 80px; border: 2px solid #999; border-radius: 4px; background: white; }
.ttd-preview { width: 150px; height: 80px; object-fit: contain; border: 1px dashed #ccc; display: block; }
.ttd-timestamp { font-size: 10px; color: #2d74b7; background: #e9f5ff; padding: 2px 6px; border-radius: 3px; margin: 2px 0; text-align: center; }

/* ================= SUMMARY ================= */
.summary-info { padding: 10px 14px; background: #e9f5ff; border-left: 4px solid #2d74b7; border-radius: 4px; font-size: 14px; }

/* ================= INTERVENSI ================= */
.intervensi-item { margin-bottom: 10px; padding: 10px 14px; background: white; border: 1px solid #e0e0e0; border-radius: 4px; border-left: 3px solid #2d74b7; }
.intervensi-row { display: flex; align-items: flex-start; gap: 10px; }
.intervensi-no { font-weight: bold; min-width: 22px; color: #2d74b7; flex-shrink: 0; font-size: 14px; }
.intervensi-label { flex: 1; font-size: 14px; line-height: 1.5; color: #333; }
.intervensi-ya-tidak { display: flex; gap: 14px; min-width: 120px; flex-shrink: 0; }
.cb-ya, .cb-tidak { display: flex; align-items: center; gap: 5px; font-size: 14px; font-weight: 600; cursor: pointer; }
.cb-ya    { color: #28a745; }
.cb-tidak { color: #dc3545; }
.cb-ya input, .cb-tidak input { cursor: pointer; width: 15px; height: 15px; }
.sub-bullets { margin: 8px 0 0 32px; padding-left: 16px; font-size: 13px; color: #555; }
.sub-bullets li { margin-bottom: 3px; }

/* ================= NAMA PETUGAS + PARAF ================= */
.petugas-center { display: flex; flex-direction: column; align-items: center; }
.petugas-center label { text-align: center; }
.petugas-input { max-width: 320px; width: 100%; }
.paraf-box { border: 1px solid #dcdcdc; border-radius: 6px; padding: 14px; background: white; width: 320px; text-align: center; }
.paraf-title { font-weight: bold; font-size: 13px; color: #2d74b7; margin: 0 0 8px 0; }
.img-paraf { width: 280px; height: 120px; object-fit: contain; border: 1px dashed #ccc; background: white; display: block; margin: 0 auto; }
.timestamp-ttd { font-size: 12px; color: #2d74b7; font-weight: 500; padding: 4px 12px; background: #e9f5ff; border-radius: 4px; display: block; width: fit-content; margin: 6px auto; }
.btn-save-paraf { background: #1e88e5; color: white; padding: 7px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 500; width: 100%; margin-top: 8px; }
.btn-save-paraf:hover { background: #1565c0; }
.btn-clear-paraf { background: #f44336; color: white; padding: 5px 12px; border: none; border-radius: 4px; margin-top: 8px; cursor: pointer; font-size: 12px; }
.btn-clear-paraf:hover { background: #d32f2f; }

/* ================= BUTTONS ================= */
.btn-add-row { background: #28a745; color: white; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; }
.btn-add-row:hover { background: #218838; }
.btn-delete-row { background: #dc3545; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px; }
.btn-delete-row:hover:not(:disabled) { background: #c82333; }
.btn-delete-row:disabled { background: #ccc; cursor: not-allowed; }
.btn-save-mini { background: #1e88e5; color: white; padding: 3px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; width: 100%; }
.btn-save-mini:hover { background: #1565c0; }
.btn-clear-mini { background: #f44336; color: white; padding: 3px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; width: 100%; }
.btn-back { background: #ff9800; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-back:hover { background: #f57c00; }
.btn-back:disabled { background: #ffcc80; cursor: not-allowed; }
.btn-save-form { background: #0288d1; color: white; padding: 12px 30px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-save-form:hover { background: #0277bd; }
.btn-save-form:disabled { background: #b0bec5; cursor: not-allowed; }

/* ================= ACTION FOOTER ================= */
.action-footer { margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; padding: 20px 0; border-top: 1px solid #e0e0e0; }

/* ================= LOADING ================= */
.loading-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.95); display: flex; flex-direction: column; justify-content: center; align-items: center; font-size: 18px; z-index: 9999; }
.loading-overlay p { color: #333; font-weight: 500; margin: 0; }
.spinner-rme { width: 48px; height: 48px; border: 5px solid #ddd; border-top-color: #1d72c9; border-radius: 50%; animation: spin-rme 0.8s linear infinite; margin-bottom: 15px; }
@keyframes spin-rme { to { transform: rotate(360deg); } }

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .container { padding: 15px; }
  .col-md-6 { flex: 0 0 100%; max-width: 100%; }
  .legend-grid { grid-template-columns: 1fr; }
  .action-footer { flex-direction: column-reverse; }
  .btn-save-form, .btn-back { width: 100%; }
  .intervensi-row { flex-wrap: wrap; }
  .intervensi-ya-tidak { min-width: auto; }
}
</style>
