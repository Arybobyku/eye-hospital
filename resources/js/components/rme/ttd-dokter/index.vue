<template>
  <div class="ttd-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Memuat data...
    </div>

    <!-- ================= LIST STATE ================= -->
    <div v-if="state === 'list'">
      <div class="header-component-rme">
        <i class="fas fa-file-signature"></i>
        Daftar Formulir - Perlu Tanda Tangan
      </div>

      <!-- FILTER BAR -->
      <div class="filter-bar">
        <div class="filter-left">
          Tampil
          <select v-model="perPage" @change="fetchList">
            <option v-for="n in [10, 25, 50, 100]" :key="n">{{ n }}</option>
          </select>
          data

          <!-- Filter Status -->
          <select v-model="filterStatus" @change="onFilterChange" class="filter-status-select">
            <option value="">Semua Status</option>
            <option value="direview">Direview</option>
            <option value="ditandatangan">Ditandatangani</option>
          </select>
        </div>

        <div class="filter-right">
          Cari:
          <input
            type="text"
            v-model="searchQuery"
            @input="onSearch"
            class="search-input"
            placeholder="Cari nama pasien, no RM..."
          />
        </div>
      </div>

      <!-- TABLE -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th style="width: 45px">NO</th>
            <th style="width: 160px">PASIEN</th>
            <th style="width: 100px">REVIEW DOKTER</th>
            <th style="width: 180px">JENIS DOKUMEN</th>
            <th style="width: 100px">TANGGAL</th>
            <th style="width: 130px">DIASSIGN OLEH</th>
            <th style="width: 100px">CATATAN</th>
            <th style="width: 110px">STATUS</th>
            <th style="width: 100px" class="text-center">ACTION</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="data.length === 0">
            <td colspan="9" class="text-center py-4">
              <div class="empty-state-inline">
                <i class="fas fa-file-signature"></i>
                <p>{{ loading ? "Memuat data..." : "Tidak ada lampiran yang perlu ditandatangani" }}</p>
              </div>
            </td>
          </tr>

          <tr v-for="(item, index) in data" :key="item.uuid">
            <td>{{ pagination.from + index }}</td>

            <!-- PASIEN -->
            <td>
              <div class="pasien-info">
                <div class="pasien-nama">{{ item.nama_pasien || '-' }}</div>
                <div class="pasien-nik">{{ item.nik_pasien || '' }}</div>
              </div>
            </td>

            <td>{{ item.nama_dokter || '-' }}</td>

            <!-- JENIS DOKUMEN -->
            <td>
              <span class="doc-type-badge">
                {{ getDocumentLabel(item.jenis_dokumen) }}
              </span>
            </td>

            <td>{{ formatDate(item.created_at) }}</td>

            <td>{{ item.created_by || '-' }}</td>

            <!-- CATATAN -->
            <td>
              <span class="catatan-text" :title="item.catatan">
                {{ item.catatan ? truncate(item.catatan, 30) : '-' }}
              </span>
            </td>

            <!-- STATUS -->
            <td>
              <span :class="['status-badge', 'status-' + item.status]">
                <i :class="getStatusIcon(item.status)"></i>
                {{ getStatusLabel(item.status) }}
              </span>
            </td>

            <!-- ACTION -->
            <td class="text-center">
              <div class="action-buttons">
                <!-- Tombol Tanda Tangan (hanya jika belum ditandatangani) -->
                <button
                  v-if="item.status === 'direview'"
                  class="btn-action btn-ttd"
                  @click="onTandaTangan(item)"
                  title="Tanda Tangan"
                >
                  <i class="fas fa-signature"></i>
                </button>

                <!-- Tombol Lihat (selalu ada) -->
                <button
                  class="btn-action btn-view"
                  @click="onView(item)"
                  title="Lihat Dokumen"
                >
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ pagination.from }} s/d {{ pagination.to }} dari
        {{ pagination.total }} data
      </div>

      <!-- PAGINATION -->
      <div class="pagination-rme">
        <button
          :disabled="pagination.current_page === 1"
          @click="changePage(pagination.current_page - 1)"
        >
          <i class="fas fa-chevron-left"></i> Previous
        </button>

        <button
          v-for="page in visiblePages"
          :key="page"
          :class="['page-btn', { active: pagination.current_page === page }]"
          @click="changePage(page)"
        >
          {{ page }}
        </button>

        <button
          :disabled="pagination.current_page === pagination.total_pages"
          @click="changePage(pagination.current_page + 1)"
        >
          Next <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- ================= EDIT / VIEW STATE (Dynamic Component) ================= -->
    <div v-if="state === 'edit' || state === 'view'">
      <!-- Back button custom agar bisa intercept @back -->
      <component
        :is="currentDocumentComponent"
        @back="onBackFromEdit"
        :selectedPatient="currentPatient"
        :editUuid="currentItem ? currentItem.id_dokumen : null"
        :editData="editData"
        :viewData="state === 'view'"
        :documentType="currentDocumentType"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";

// ── Import semua komponen dokumen (sama persis dengan ListLampiran.vue) ──
const documentComponents = {
  CreateLaporanBedah: defineAsyncComponent(() => import("../lampiran/create/LaporanBedah.vue")),
  FormLaserBargage: defineAsyncComponent(() => import("../lampiran/create/FormLaserBarage.vue")),
  FormPersetujuanTindakanKedokteran: defineAsyncComponent(() => import("../lampiran/create/FormPersetujuanTindakanKedokteran.vue")),
  FormLaserFokal: defineAsyncComponent(() => import("../lampiran/create/FormLaserFokal.vue")),
  FormResumePerawatanRawatJalan: defineAsyncComponent(() => import("../lampiran/create/FormResumePerawatanRawatJalan.vue")),
  FormBalanceCairanHarian: defineAsyncComponent(() => import("../lampiran/create/FormBalanceCairanHarian.vue")),
  FormPenolakanRujukan: defineAsyncComponent(() => import("../lampiran/create/FormPenolakanRujukan.vue")),
  FormSuratKontrol: defineAsyncComponent(() => import("../lampiran/create/FormSuratKontrol.vue")),
  FormSuratKonsul: defineAsyncComponent(() => import("../lampiran/create/FormSuratKonsul.vue")),
  FormSuratBalasanKonsul: defineAsyncComponent(() => import("../lampiran/create/FormSuratBalasanKonsul.vue")),
  FormPernyataanBatalOperasi: defineAsyncComponent(() => import("../lampiran/create/FormPernyataanBatalOperasi.vue")),
  FormPernyataanPasienUmum: defineAsyncComponent(() => import("../lampiran/create/FormPernyataanPasienUmum.vue")),
  FormDietitianPasienBaru: defineAsyncComponent(() => import("../lampiran/create/FormDietitianPasienBaru.vue")),
  FormAsuhanGizi: defineAsyncComponent(() => import("../lampiran/create/FormAsuhanGizi.vue")),
  FormLaserLPI: defineAsyncComponent(() => import("../lampiran/create/FormLaserLPI.vue")),
  PenolakanTindakanAnestesi: defineAsyncComponent(() => import("../lampiran/create/PenolakanTindakanAnestesi.vue")),
  FormChecklistKesiapanBedah: defineAsyncComponent(() => import("../lampiran/create/FormChecklistKesiapanBedah.vue")),
  FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap: defineAsyncComponent(() => import("../lampiran/create/FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap.vue")),
  FormEdukasiPasienDanKeluargaRawatJalan: defineAsyncComponent(() => import("../lampiran/create/FormEdukasiPasienDanKeluargaRawatJalan.vue")),
  FormProsesPerawatanPeriOperative: defineAsyncComponent(() => import("../lampiran/create/FormProsesPerawatanPeriOperative.vue")),
  FormPersetujuanUmumPasienKeluarga: defineAsyncComponent(() => import("../lampiran/create/FormPersetujuanUmumPasienKeluarga.vue")),
  FormPengkajianKeperawatanMataRawatJalan: defineAsyncComponent(() => import("../lampiran/create/FormPengkajianKeperawatanMataRawatJalan.vue")),
  FormLaporanInjeksi: defineAsyncComponent(() => import("../lampiran/create/FormLaporanInjeksi.vue")),
  FormPermintaanPulang: defineAsyncComponent(() => import("../lampiran/create/FormPermintaanPulang.vue")),
  VoucherRawatInap: defineAsyncComponent(() => import("../lampiran/create/VoucherRawatInap.vue")),
  FormReaksiTransfusiDarah: defineAsyncComponent(() => import("../lampiran/create/FormReaksiTransfusiDarah.vue")),
  FormLaserPRP: defineAsyncComponent(() => import("../lampiran/create/FormLaserPRP.vue")),
  FormLaporanOperasiPterygium: defineAsyncComponent(() => import("../lampiran/create/FormLaporanOperasiPterygium.vue")),
  FormLaporanEksisiPalebra: defineAsyncComponent(() => import("../lampiran/create/FormLaporanEksisiPalebra.vue")),
  FormLaporanEksisiChalazion: defineAsyncComponent(() => import("../lampiran/create/FormLaporanEksisiChalazion.vue")),
  FormAssesmenAwalKeperawatanRawatInap: defineAsyncComponent(() => import("../lampiran/create/FormAssesmenAwalKeperawatanRawatInap.vue")),
  FormResumeMedisRawatInap: defineAsyncComponent(() => import("../lampiran/create/FormResumeMedisRawatInap.vue")),
  FormResumeMedisRawatJalan: defineAsyncComponent(() => import("../lampiran/create/FormResumeMedisRawatJalan.vue")),
  FormCPPTRawatInap: defineAsyncComponent(() => import("../lampiran/create/FormCPPTRawatInap.vue")),
  FormPulangAtasPermintaanSendiri: defineAsyncComponent(() => import("../lampiran/create/FormPulangAtasPermintaanSendiri.vue")),
  FormTindakanLaserCapsulotomy: defineAsyncComponent(() => import("../lampiran/create/FormTindakanLaserCapsulotomy.vue")),
  FormTindakanEpilasi: defineAsyncComponent(() => import("../lampiran/create/FormTindakanEpilasi.vue")),
  FormKronologisPasien: defineAsyncComponent(() => import("../lampiran/create/FormKronologisPasien.vue")),
  FormCatatanOperasi: defineAsyncComponent(() => import("../lampiran/create/FormCatatanOperasi.vue")),
  FormMonitoringEfekSampingObat: defineAsyncComponent(() => import("../lampiran/create/FormMonitoringEfekSampingObat.vue")),
  FormCatatanKeperawatan: defineAsyncComponent(() => import("../lampiran/create/FormCatatanKeperawatan.vue")),
  FormLaporanOperasiTrabulektomi: defineAsyncComponent(() => import("../lampiran/create/FormLaporanOperasiTrabulektomi.vue")),
  FormStatusAnestesi: defineAsyncComponent(() => import("../lampiran/create/FormStatusAnestesi.vue")),
  FormLaporanOperasiVitreoRetina: defineAsyncComponent(() => import("../lampiran/create/FormLaporanOperasiVitreoRetina.vue")),
};

// ── Map backendType → component name (sama dengan availableDocuments di ListLampiran) ──
const TYPE_TO_COMPONENT = {
  "laporan_bedah":                          "CreateLaporanBedah",
  "laser_bargage":                          "FormLaserBargage",
  "dokumen_form_laser_barrage":             "FormLaserBargage",
  "dokumen_form_laser_fokal":               "FormLaserFokal",
  "persetujuan_tindakan_kedokteran":        "FormPersetujuanTindakanKedokteran",
  "resume_perawatan_rawat_jalan":           "FormResumePerawatanRawatJalan",
  "balance_cairan_harian":                  "FormBalanceCairanHarian",
  "surat_penolakan_rujukan":                "FormPenolakanRujukan",
  "surat_kontrol_ulang":                    "FormSuratKontrol",
  "surat_konsul":                           "FormSuratKonsul",
  "surat_balasan_konsul":                   "FormSuratBalasanKonsul",
  "surat_pernyataan_batal_operasi":         "FormPernyataanBatalOperasi",
  "surat_pernyataan_pasien_umum":           "FormPernyataanPasienUmum",
  "dokumen_dietitian_pasien_baru":          "FormDietitianPasienBaru",
  "dokumen_asuhan_gizi":                    "FormAsuhanGizi",
  "dokumen_tindakan_laser_lpi":             "FormLaserLPI",
  "penolakan_tindakan_anestesi":            "PenolakanTindakanAnestesi",
  "dokumen_ceklist_kesiapan_bedah":         "FormChecklistKesiapanBedah",
  "form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap": "FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap",
  "form_edukasi_pasien_dan_keluarga_rawat_jalan": "FormEdukasiPasienDanKeluargaRawatJalan",
  "form_proses_perawatan_peri_operative":   "FormProsesPerawatanPeriOperative",
  "form_persetujuan_umum_pasien_keluarga":  "FormPersetujuanUmumPasienKeluarga",
  "form_pengkajian_keperawatan_mata_rawat_jalan": "FormPengkajianKeperawatanMataRawatJalan",
  "form_laporan_injeksi":                   "FormLaporanInjeksi",
  "form_permintaan_pulang":                 "FormPermintaanPulang",
  "voucher_rawat_inap":                     "VoucherRawatInap",
  "form_reaksi_transfusi_darah":            "FormReaksiTransfusiDarah",
  "dokumen_tindakan_laser_prp":             "FormLaserPRP",
  "dokumen_laporan_operasi_trabekulektomi": "FormLaporanOperasiTrabulektomi",
  "dokumen_laporan_operasi_pterygium":      "FormLaporanOperasiPterygium",
  "dokumen_laporan_eksisi_palpebra":        "FormLaporanEksisiPalebra",
  "dokumen_laporan_eksisi_chalazion":       "FormLaporanEksisiChalazion",
  "asesmen_keperawatan_rawat_inap":         "FormAssesmenAwalKeperawatanRawatInap",
  "resume_medis_rawat_inap":                "FormResumeMedisRawatInap",
  "resume_medis_rawat_jalan":               "FormResumeMedisRawatJalan",
  "cppt_rawat_inap":                        "FormCPPTRawatInap",
  "dokumen_pulang_atas_permintaan_sendiri": "FormPulangAtasPermintaanSendiri",
  "dokumen_tindakan_laser_capsulotomy":     "FormTindakanLaserCapsulotomy",
  "dokumen_tindakan_epilasi":               "FormTindakanEpilasi",
  "dokumen_kronologis_pasien":              "FormKronologisPasien",
  "dokumen_catatan_operasi":                "FormCatatanOperasi",
  "monitoring_efek_samping_obat":           "FormMonitoringEfekSampingObat",
  "catatan_keperawatan":                    "FormCatatanKeperawatan",
  "status_anestesi":                        "FormStatusAnestesi",
  "laporan_operasi_vitreo_retina":          "FormLaporanOperasiVitreoRetina",
};

// ── Label dokumen untuk tampil di tabel ──
const TYPE_TO_LABEL = {
  "laporan_bedah":                          "Laporan Pembedahan",
  "laser_bargage":                          "Form Laser Bargage",
  "dokumen_form_laser_barrage":             "Form Laser Barrage",
  "dokumen_form_laser_fokal":               "Form Laser Fokal",
  "persetujuan_tindakan_kedokteran":        "Persetujuan Tindakan Kedokteran",
  "resume_perawatan_rawat_jalan":           "Resume Perawatan Rawat Jalan",
  "balance_cairan_harian":                  "Balance Cairan Harian",
  "surat_penolakan_rujukan":                "Surat Penolakan Rujukan",
  "surat_kontrol_ulang":                    "Surat Kontrol Ulang",
  "surat_konsul":                           "Surat Konsultasi",
  "surat_balasan_konsul":                   "Surat Balasan Konsultasi",
  "surat_pernyataan_batal_operasi":         "Pernyataan Batal Operasi",
  "surat_pernyataan_pasien_umum":           "Pernyataan Pasien Umum",
  "dokumen_dietitian_pasien_baru":          "Dietitian Pasien Baru",
  "dokumen_asuhan_gizi":                    "Asuhan Gizi",
  "dokumen_tindakan_laser_lpi":             "Tindakan Laser LPI",
  "penolakan_tindakan_anestesi":            "Tindakan Anestesi",
  "dokumen_ceklist_kesiapan_bedah":         "Ceklist Kesiapan Bedah",
  "form_laporan_injeksi":                   "Laporan Injeksi",
  "form_permintaan_pulang":                 "Permintaan Pulang",
  "voucher_rawat_inap":                     "Voucher Rawat Inap",
  "form_reaksi_transfusi_darah":            "Reaksi Transfusi Darah",
  "dokumen_tindakan_laser_prp":             "Tindakan Laser PRP",
  "dokumen_laporan_operasi_trabekulektomi": "Laporan Operasi Trabekulektomi",
  "dokumen_laporan_operasi_pterygium":      "Laporan Operasi Pterygium",
  "dokumen_laporan_eksisi_palpebra":        "Laporan Eksisi Palpebra",
  "dokumen_laporan_eksisi_chalazion":       "Laporan Eksisi Chalazion",
  "asesmen_keperawatan_rawat_inap":         "Assesmen Keperawatan Rawat Inap",
  "resume_medis_rawat_inap":                "Resume Medis Rawat Inap",
  "resume_medis_rawat_jalan":               "Resume Medis Rawat Jalan",
  "cppt_rawat_inap":                        "CPPT Rawat Inap",
  "dokumen_pulang_atas_permintaan_sendiri": "Pulang Atas Permintaan Sendiri",
  "dokumen_tindakan_laser_capsulotomy":     "Tindakan Laser Capsulotomy",
  "dokumen_tindakan_epilasi":               "Tindakan Epilasi",
  "dokumen_kronologis_pasien":              "Kronologi Pasien",
  "dokumen_catatan_operasi":                "Catatan Operasi",
  "monitoring_efek_samping_obat":           "Monitoring Efek Samping Obat",
  "catatan_keperawatan":                    "Catatan Keperawatan",
  "status_anestesi":                        "Status Anestesi",
  "laporan_operasi_vitreo_retina":          "Laporan Operasi Vitreo Retina",
};

export default {
  name: "DaftarTandaTanganDokter",

  components: documentComponents,

  data() {
    return {
      state: "list",  // 'list' | 'edit' | 'view'
      loading: false,
      data: [],
      searchQuery: "",
      filterStatus: "direview",  // default tampil yang belum ditandatangani
      perPage: 10,
      searchTimeout: null,
      pagination: {
        total: 0,
        per_page: 10,
        current_page: 1,
        total_pages: 0,
        from: 0,
        to: 0,
      },

      // State saat buka edit/view
      currentItem: null,       // row assign yang sedang dibuka
      currentPatient: null,    // object pasien untuk diteruskan ke komponen
      currentDocumentType: "", // value dari TYPE_TO_COMPONENT
      editData: null,          // data detail dokumen
    };
  },

  computed: {
    currentDocumentComponent() {
      if (!this.currentItem) return null;
      const componentName = TYPE_TO_COMPONENT[this.currentItem.jenis_dokumen];
      return componentName || null;
    },

    visiblePages() {
      const total   = this.pagination.total_pages;
      const current = this.pagination.current_page;
      const delta   = 2;
      let pages     = [1];
      for (let i = Math.max(2, current - delta); i <= Math.min(total - 1, current + delta); i++) {
        pages.push(i);
      }
      if (total > 1) pages.push(total);
      return [...new Set(pages)].sort((a, b) => a - b);
    },
  },

  mounted() {
    this.fetchList();
  },

  methods: {
    // ─────────────────────────────────────────
    // FETCH LIST
    // ─────────────────────────────────────────
    async fetchList() {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("search",  this.searchQuery);
        formData.append("status",  this.filterStatus);
        formData.append("limit",   this.perPage);
        formData.append("page",    this.pagination.current_page);

        const res = await axios.post(
          "/master/rekammedis/tanda-tangan-dokter/list",
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          this.data       = res.data.data || [];
          this.pagination = res.data.pagination || this.pagination;
        }
      } catch (err) {
        console.error("Gagal memuat daftar tanda tangan:", err);
        alert("Gagal memuat data");
      } finally {
        this.loading = false;
      }
    },

    onSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.pagination.current_page = 1;
        this.fetchList();
      }, 500);
    },

    onFilterChange() {
      this.pagination.current_page = 1;
      this.fetchList();
    },

    changePage(page) {
      if (page < 1 || page > this.pagination.total_pages) return;
      this.pagination.current_page = page;
      this.fetchList();
    },

    // ─────────────────────────────────────────
    // TANDA TANGAN → buka edit page
    // ─────────────────────────────────────────
    async onTandaTangan(item) {
      await this.openDocument(item, "edit");
    },

    async onView(item) {
      await this.openDocument(item, "view");
    },

    async openDocument(item, mode) {
      const componentName = TYPE_TO_COMPONENT[item.jenis_dokumen];
      if (!componentName) {
        alert("Komponen untuk jenis dokumen ini belum tersedia: " + item.jenis_dokumen);
        return;
      }

      this.loading = true;
      try {
        // Ambil detail dokumen
        const formData = new FormData();
        formData.append("type", item.jenis_dokumen);

        const res = await axios.post(
          `/master/rekammedis/lampiran/${item.uuid_dokumen}/detail`,
          formData
        );

        if (!res.data.status) {
          alert("Gagal mengambil detail dokumen: " + res.data.message);
          return;
        }

        this.editData   = res.data.data;
        this.currentItem = item;

        // Bangun object pasien dari data assign (tersedia dari backend)
        this.currentPatient = {
          uuid:          item.pasien_uuid,
          nama:          item.nama_pasien,
          rekam_medis:   item.no_rm,
          nik:           item.nik_pasien,
          jenis_kelamin: item.jenis_kelamin_pasien,
        };

        this.currentDocumentType = item.jenis_dokumen;

        this.$nextTick(() => {
          this.state = mode;
        });
      } catch (err) {
        console.error("Error membuka dokumen:", err);
        alert("Error: " + (err.response?.data?.message || "Terjadi kesalahan"));
      } finally {
        this.loading = false;
      }
    },

    // ─────────────────────────────────────────
    // KEMBALI DARI EDIT — update status assign
    // ─────────────────────────────────────────
    async onBackFromEdit() {
      // Jika sebelumnya mode edit (tanda tangan), update status → ditandatangan
      if (this.state === "edit" && this.currentItem) {
        await this.updateStatusDitandatangan(this.currentItem);
      }

      // Kembali ke list dan refresh
      this.state          = "list";
      this.currentItem    = null;
      this.currentPatient = null;
      this.editData       = null;
      this.fetchList();
    },

    async updateStatusDitandatangan(item) {
      try {
        const formData = new FormData();
        formData.append("uuid",   item.assign_uuid);  // uuid dari tabel lampiran_assign_dokter
        formData.append("status", "ditandatangan");

        const res = await axios.post(
          "/master/rekammedis/lampiran/assign-dokter/update-status",
          formData,
          { headers: { "Content-Type": "multipart/form-data" } }
        );

        if (res.data.status) {
          console.log("Status assign berhasil diupdate ke ditandatangan");
        } else {
          console.warn("Gagal update status assign:", res.data.message);
        }
      } catch (err) {
        console.error("Error update status assign:", err);
      }
    },

    // ─────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────
    getDocumentLabel(type) {
      return TYPE_TO_LABEL[type] || type;
    },

    getStatusLabel(status) {
      return { direview: "Direview", ditandatangan: "Ditandatangani" }[status] || status;
    },

    getStatusIcon(status) {
      return { direview: "fas fa-clock", ditandatangan: "fas fa-signature" }[status] || "fas fa-question";
    },

    formatDate(date) {
      if (!date) return "-";
      return new Date(date).toLocaleDateString("id-ID", {
        day: "2-digit", month: "2-digit", year: "numeric",
      });
    },

    truncate(text, length) {
      if (!text || text.length <= length) return text;
      return text.substring(0, length) + "...";
    },
  },
};
</script>

<style scoped>
.ttd-container {
  background: white;
  padding: 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  position: relative;
  min-height: 500px;
}

.header-component-rme {
  background: #6f42c1;
  color: white;
  text-align: center;
  padding: 12px;
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 15px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

/* FILTER BAR */
.filter-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  font-size: 14px;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}

.filter-left {
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-left select,
.filter-status-select {
  padding: 5px 8px;
  border: 1px solid #aaa;
  border-radius: 4px;
  font-size: 13px;
}

.filter-right {
  display: flex;
  gap: 10px;
  align-items: center;
}

.search-input {
  padding: 6px 10px;
  border: 1px solid #aaa;
  border-radius: 4px;
  width: 220px;
  font-size: 13px;
}

/* TABLE */
.custom-table-rme {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
  margin-bottom: 10px;
}

.custom-table-rme th {
  background: #6f42c1;
  color: white;
  padding: 10px 8px;
  text-align: left;
  font-weight: 600;
}

.custom-table-rme td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: middle;
}

.custom-table-rme tbody tr:nth-child(even) { background: #f8f9fa; }
.custom-table-rme tbody tr:hover { background: #f3eeff; }

.text-center { text-align: center; }

/* PASIEN INFO */
.pasien-info { line-height: 1.4; }
.pasien-nama { font-weight: 600; color: #333; font-size: 13px; }
.pasien-nik  { font-size: 11px; color: #888; }

/* DOC TYPE BADGE */
.doc-type-badge {
  display: inline-block;
  background: #e8f0fe;
  color: #3c4699;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: 500;
  border: 1px solid #c5cdf5;
}

/* CATATAN */
.catatan-text {
  font-size: 12px;
  color: #666;
  cursor: default;
}

/* STATUS BADGE */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 600;
  white-space: nowrap;
}

.status-direview {
  background: #fff3cd;
  color: #856404;
  border: 1px solid #ffc107;
}

.status-ditandatangan {
  background: #d1e7dd;
  color: #0a3622;
  border: 1px solid #28a745;
}

/* ACTION BUTTONS */
.action-buttons {
  display: flex;
  gap: 5px;
  justify-content: center;
}

.btn-action {
  padding: 5px 8px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
  transition: all 0.2s;
  color: white;
}

.btn-ttd   { background: #6f42c1; }
.btn-ttd:hover { background: #5a32a3; }
.btn-view  { background: #17a2b8; }
.btn-view:hover { background: #138496; }

/* EMPTY STATE */
.empty-state-inline {
  padding: 30px;
  text-align: center;
  color: #aaa;
}

.empty-state-inline i {
  font-size: 40px;
  margin-bottom: 10px;
  display: block;
}

.empty-state-inline p { font-size: 14px; }

/* PAGINATION */
.pagination-rme {
  display: flex;
  gap: 5px;
  align-items: center;
  margin-top: 10px;
}

.pagination-rme button {
  padding: 6px 12px;
  border: 1px solid #6f42c1;
  background: white;
  cursor: pointer;
  border-radius: 3px;
  font-size: 13px;
  transition: all 0.2s;
}

.pagination-rme button:hover:not(:disabled) { background: #f3eeff; }
.pagination-rme button:disabled { opacity: 0.5; cursor: not-allowed; }
.page-btn.active { background: #6f42c1; color: white; font-weight: bold; }

.table-info {
  margin-top: 10px;
  margin-bottom: 8px;
  font-size: 13px;
  color: #666;
}

/* LOADING */
.loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 16px;
  z-index: 10;
  border-radius: 5px;
  gap: 10px;
}

.spinner-rme {
  width: 38px;
  height: 38px;
  border: 4px solid #f3f3f3;
  border-top-color: #6f42c1;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
}

.py-4 { padding-top: 16px; padding-bottom: 16px; }

@keyframes spin-rme { to { transform: rotate(360deg); } }

@media (max-width: 768px) {
  .filter-bar { flex-direction: column; align-items: flex-start; }
  .search-input { width: 100%; }
  .action-buttons { flex-wrap: wrap; }
}
</style>