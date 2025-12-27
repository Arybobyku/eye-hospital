<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- ================= LIST STATE ================= -->
    <div v-if="state == 'list'">
      <!-- HEADER -->
      <div class="header-component-rme">Daftar Lampiran Dokumen</div>

      <!-- PATIENT INFO CARD -->
      <div class="patient-info-card mb-3">
        <div class="row">
          <div class="col-md-3">
            <strong>No. RM:</strong> {{ selectedPatient?.rekam_medis }}
          </div>
          <div class="col-md-4"><strong>Nama:</strong> {{ selectedPatient?.nama }}</div>
          <div class="col-md-3"><strong>NIK:</strong> {{ selectedPatient?.nik }}</div>
          <div class="col-md-2">
            <strong>JK:</strong> {{ selectedPatient?.jenis_kelamin }}
          </div>
        </div>
      </div>

      <!-- FILTER BAR -->
      <div class="filter-bar">
        <div class="filter-left">
          Tampil
          <select v-model="perPage" @change="fetchLampiran">
            <option v-for="n in [10, 25, 50, 100]" :key="n">{{ n }}</option>
          </select>
          data
        </div>

        <div class="filter-right">
          <button class="btn-add" @click="onAdd">
            <i class="fas fa-plus"></i> Tambah Dokumen
          </button>

          Cari:
          <input
            type="text"
            v-model="searchQuery"
            @input="onSearch"
            class="search-input"
            placeholder="Cari nama, no RM..."
          />
        </div>
      </div>

      <!-- TABLE -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th style="width: 50px">NO</th>
            <th style="width: 180px">JENIS DOKUMEN</th>
            <th style="width: 100px">TANGGAL</th>
            <!-- <th style="width: 80px">JAM</th> -->
            <!-- <th style="width: 120px">NO. RM</th> -->
            <!-- <th>NAMA PASIEN</th> -->
            <!-- <th style="width: 80px">JK</th> -->
            <th style="width: 150px">Creator</th>
            <!-- <th>DETAIL INFO</th> -->
            <th style="width: 120px" class="text-center">ACTION</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="data.length === 0">
            <td colspan="10" class="text-center">
              {{ loading ? "Memuat data..." : "Tidak ada data" }}
            </td>
          </tr>

          <tr v-for="(item, index) in data" :key="item.uuid">
            <td>{{ pagination.from + index }}</td>

            <!-- JENIS DOKUMEN dengan Badge -->
            <td>
              <span
                class="document-badge"
                :style="{ backgroundColor: item.document_color }"
              >
                <i :class="['fas', item.document_icon]"></i>
                {{ item.document_label }}
              </span>
            </td>

            <td>{{ formatDate(item.tanggal) }}</td>
            <!-- <td>{{ formatTime(item.waktu) }}</td> -->
            <!-- <td>{{ item.no_rm }}</td> -->
            <!-- <td>{{ item.nama }}</td> -->
            <!-- <td>{{ item.jenis_kelamin }}</td> -->
            <td>{{ item.created_by || "-" }}</td>
            <!-- <td> <div class="detail-info">{{ truncate(item.detail_info, 50) }} </div></td> -->

            <!-- ACTION BUTTONS -->
            <td class="text-center">
              <div class="action-buttons">
                <button class="btn-action btn-view" @click="onView(item)" title="Lihat">
                  <i class="fas fa-eye"></i>
                </button>

                <button class="btn-action btn-edit" @click="onEdit(item)" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>

                <button class="btn-action btn-print" @click="onPrint(item)" title="Print">
                  <i class="fas fa-print"></i>
                </button>

                <button
                  class="btn-action btn-delete"
                  @click="onDelete(item)"
                  title="Hapus"
                >
                  <i class="fas fa-trash"></i>
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

    <!-- ================= SELECT DOCUMENT STATE ================= -->
    <div v-if="state == 'select-document'" class="select-document-container">
      <div class="header-component-rme">Pilih Jenis Dokumen</div>

      <div class="document-selector-card">
        <p class="mb-3">Silakan pilih jenis dokumen yang ingin ditambahkan:</p>

        <div class="form-group">
          <label for="documentType" class="form-label">Jenis Dokumen:</label>
          <select id="documentType" v-model="selectedDocumentType" class="form-select">
            <option value="">-- Pilih Dokumen --</option>
            <option v-for="doc in availableDocuments" :key="doc.value" :value="doc.value">
              {{ doc.label }}
            </option>
          </select>
        </div>

        <div v-if="selectedDocumentType" class="document-info mt-3">
          <i class="fas fa-info-circle"></i>
          <span>{{ getSelectedDocumentInfo() }}</span>
        </div>

        <div class="button-group mt-4">
          <button
            class="btn-primary"
            @click="onProceedToCreate"
            :disabled="!selectedDocumentType"
          >
            <i class="fas fa-arrow-right"></i> Lanjutkan
          </button>
          <button class="btn-secondary" @click="onCancelSelection">
            <i class="fas fa-times"></i> Batal
          </button>
        </div>
      </div>
    </div>

    <!-- ================= CREATE STATE (DYNAMIC) ================= -->
    <div v-if="state == 'create'">
      <component
        :is="currentDocumentComponent"
        @back="onBackToList"
        :selectedPatient="selectedPatient"
        :editUuid="editUuid"
        :editData="editData"
        :documentType="selectedDocumentType"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";

export default {
  name: "ListLampiran",
  components: {
    // Lazy load components
    CreateLaporanBedah: defineAsyncComponent(() => import("./create/LaporanBedah.vue")),
    FormLaserBargage: defineAsyncComponent(() => import("./create/FormLaserBarage.vue")),
    FormPersetujuanTindakanKedokteran: defineAsyncComponent(() => import("./create/FormPersetujuanTindakanKedokteran.vue")),
    FormLaserFokal: defineAsyncComponent(() => import("./create/FormLaserFokal.vue")),
    FormResumePerawatanRawatJalan: defineAsyncComponent(() => import("./create/FormResumePerawatanRawatJalan.vue")),
    FormBalanceCairanHarian: defineAsyncComponent(() =>import("./create/FormBalanceCairanHarian.vue")),
    FormPenolakanRujukan: defineAsyncComponent(() =>import("./create/FormPenolakanRujukan.vue")),
    FormSuratKontrol: defineAsyncComponent(() =>import("./create/FormSuratKontrol.vue")),
    FormSuratKonsul: defineAsyncComponent(() =>import("./create/FormSuratKonsul.vue")),
    FormSuratBalasanKonsul: defineAsyncComponent(() =>import("./create/FormSuratBalasanKonsul.vue")),
    FormPernyataanBatalOperasi: defineAsyncComponent(() =>import("./create/FormPernyataanBatalOperasi.vue")),
    FormPernyataanPasienUmum: defineAsyncComponent(() =>import("./create/FormPernyataanPasienUmum.vue")),
    FormDietitianPasienBaru: defineAsyncComponent(() =>import("./create/FormDietitianPasienBaru.vue")),
    FormAsuhanGizi: defineAsyncComponent(() =>import("./create/FormAsuhanGizi.vue")),
    FormLaserLPI: defineAsyncComponent(() =>import("./create/FormLaserLPI.vue")),
    FormLaserPRP: defineAsyncComponent(() =>import("./create/FormLaserPRP.vue")),
    FormLaporanOperasiPterygium: defineAsyncComponent(() =>import("./create/FormLaporanOperasiPterygium.vue")),
    // Tambahkan component baru di sini
  },

  data() {
    return {
      perPage: 10,
      searchQuery: "",
      state: "list", // list | select-document | create
      selectedDocumentType: "",
      editData: null,
      editUuid: null,
      loading: false,
      data: [],
      pagination: {
        total: 0,
        per_page: 10,
        current_page: 1,
        total_pages: 0,
        from: 0,
        to: 0,
      },
      searchTimeout: null,

      // ✨ KONFIGURASI DOKUMEN (HARUS SINKRON DENGAN BACKEND)
      availableDocuments: [
        {
          value: "laporan-bedah",
          label: "Laporan Pembedahan",
          component: "CreateLaporanBedah",
          description: "Form untuk mencatat laporan operasi dan pembedahan pasien",
          backendType: "laporan_bedah",
        },
        {
          value: "laser-bargage",
          label: "Form Laser Bargage",
          component: "FormLaserBargage",
          description: "Form tindakan laser bargage medis",
          backendType: "laser_bargage",
        },
        {
          value: "laser-fokal",
          label: "Form Laser Fokal",
          component: "FormLaserFokal",
          description: "Form tindakan laser Fokal medis",
          backendType: "laser_fokal",
        },
        {
          value: "persetujuan_tindakan_kedokteran",
          label: "Form Persetujuan Tindakan Kedokteran",
          component: "FormPersetujuanTindakanKedokteran",
          description: "Form Persetujuan Tindakan Kedokteran",
          backendType: "persetujuan_tindakan_kedokteran",
        },
        {
          value: "resume-perawatan-rawat-jalan",
          label: "Form Resume Perawatan Rawat Jalan",
          component: "FormResumePerawatanRawatJalan",
          description: "Form Resume Perawatan Rawat Jalan",
          backendType: "resume_perawatan_rawat_jalan",
        },
        {
          value: "balance-cairan-harian",
          label: "Balance Cairan Harian",
          component: "FormBalanceCairanHarian",
          description: "Form monitoring intake dan output cairan pasien per hari",
          backendType: "balance_cairan_harian",
        },
        {
          value: "surat-penolakan-rujukan",
          label: "Surat Penolakan Rujukan",
          component: "FormPenolakanRujukan",
          description: "Form Surat penolakan rujukan pasien",
          backendType: "surat_penolakan_rujukan",
        },
        {
          value: "surat-kontrol-ulang",
          label: "Surat Kontrol Ulang",
          component: "FormSuratKontrol",
          description: "Form Surat Kontrol Ulang Pasien",
          backendType: "surat_kontrol_ulang",
        },
        {
          value: "surat-kosultasi",
          label: "Surat Konsultasi",
          component: "FormSuratKonsul",
          description: "Form Surat Konsultasi Pasien",
          backendType: "surat_konsul",
        },
        {
          value: "surat-balasan-kosultasi",
          label: "Surat Balasan Konsultasi",
          component: "FormSuratBalasanKonsul",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "surat_balasan_konsul",
        },
        {
          value: "surat-pernyataan-batal-operasi",
          label: "Surat Pernyataan Batal Operasi",
          component: "FormPernyataanBatalOperasi",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "surat_pernyataan_batal_operasi",
        },
        {
          value: "surat-pernyataan-pasien-umum",
          label: "Surat Pernyataan Pasien Umum",
          component: "FormPernyataanPasienUmum",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "surat_pernyataan_pasien_umum",
        },
        {
          value: "dietitian-pasien-baru",
          label: "Form Dokumen Dietitian Pasien Baru",
          component: "FormDietitianPasienBaru",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "dokumen_dietitian_pasien_baru",
        },
        {
          value: "dokumen_asuhan_gizi",
          label: "Form Dokumen Asuhan Gizi",
          component: "FormAsuhanGizi",
          description: "Form Asuhan Gizi Pasien",
          backendType: "dokumen_asuhan_gizi",
        },
        {
          value: "dokumen_tindakan_laser_lpi",
          label: "Form Dokumen Laser LPI",
          component: "FormLaserLPI",
          description: "Form Laser LPI Pasien",
          backendType: "dokumen_tindakan_laser_lpi",
        },
        {
          value: "dokumen_tindakan_laser_prp",
          label: "Form Dokumen Laser PRP",
          component: "FormLaserPRP",
          description: "Form Laser PRP Pasien",
          backendType: "dokumen_tindakan_laser_prp",
        },
        {
          value: "dokumen_laporan_operasi_trabekulektomi",
          label: "Form Laporan Operasi Trabekulektomi",
          component: "FormLaporanOperasiTrabulektomi",
          description: "Form Laporan Operasi Trabekulektomi",
          backendType: "dokumen_laporan_operasi_trabekulektomi",
        },
        {
          value: "dokumen_laporan_operasi_pterygium",
          label: "Form Laporan Operasi Pterygrium",
          component: "FormLaporanOperasiPterygium",
          description: "Form Laporan Operasi Pterygrium",
          backendType: "dokumen_laporan_operasi_pterygium",
        },
        // {
        //   value: "informed-consent",
        //   label: "Informed Consent",
        //   component: "FormInformedConsent",
        //   description: "Surat persetujuan/penolakan tindakan medis",
        //   backendType: "informed_consent"
        // },
        // ✨ TAMBAHKAN DOKUMEN BARU DI SINI
      ],
    };
  },

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(newVal) {
        if (newVal?.uuid) {
          this.fetchLampiran();
        }
      },
    },
    perPage() {
      this.pagination.current_page = 1;
      this.fetchLampiran();
    },
  },

  computed: {
    currentDocumentComponent() {
      const doc = this.availableDocuments.find(
        (d) => d.value === this.selectedDocumentType
      );
      return doc ? doc.component : null;
    },

    visiblePages() {
      const total = this.pagination.total_pages;
      const current = this.pagination.current_page;
      const delta = 2;

      let pages = [];

      // Always show first page
      pages.push(1);

      // Pages around current
      for (
        let i = Math.max(2, current - delta);
        i <= Math.min(total - 1, current + delta);
        i++
      ) {
        pages.push(i);
      }

      // Always show last page
      if (total > 1) {
        pages.push(total);
      }

      // Remove duplicates and sort
      return [...new Set(pages)].sort((a, b) => a - b);
    },
  },

  methods: {
    async fetchLampiran() {
      if (!this.selectedPatient?.uuid) return;

      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("uuid_pasien", this.selectedPatient.uuid);
        formData.append("search", this.searchQuery);
        formData.append("limit", this.perPage);
        formData.append("page", this.pagination.current_page);

        const res = await axios.post("/master/rekammedis/list-lampiran", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        if (res.data.status) {
          this.data = res.data.data || [];
          this.pagination = res.data.pagination || this.pagination;
        }
      } catch (err) {
        console.error("Gagal memuat lampiran:", err);
        this.$swal({
          icon: "error",
          title: "Error",
          text: "Gagal memuat data lampiran",
        });
      } finally {
        this.loading = false;
      }
    },

    onSearch() {
      // Debounce search
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.pagination.current_page = 1;
        this.fetchLampiran();
      }, 500);
    },

    changePage(page) {
      if (page < 1 || page > this.pagination.total_pages) return;
      this.pagination.current_page = page;
      this.fetchLampiran();
    },

    onAdd() {
      this.state = "select-document";
      this.selectedDocumentType = "";
      this.editUuid = null;
    },

    onProceedToCreate() {
      if (!this.selectedDocumentType) {
        alert("Silakan pilih jenis dokumen terlebih dahulu!");
        return;
      }
      this.state = "create";
    },

    onCancelSelection() {
      this.state = "list";
      this.selectedDocumentType = "";
    },

    onBackToList() {
      this.state = "list";
      this.selectedDocumentType = "";
      this.editUuid = null;
      this.fetchLampiran();
    },

    getSelectedDocumentInfo() {
      const doc = this.availableDocuments.find(
        (d) => d.value === this.selectedDocumentType
      );
      return doc ? doc.description : "";
    },

    onView(item) {
      // Implement view modal atau redirect ke detail page
      console.log("View:", item);
      // TODO: Implement detail view
    },

    async onEdit(item) {
      try {
        // Loading state
        this.isLoading = true;

        // Map backend type to frontend type
        const doc = this.availableDocuments.find(
          (d) => d.backendType === item.document_type
        );

        if (!doc) {
          alert("Dokumen tidak ditemukan!");
          return;
        }

        // 1. Get detail lampiran terlebih dahulu
        const response = await axios.get(
          `/master/rekammedis/lampiran/${item.uuid}`,
          {
            params: {
              type: item.document_type,
            },
          }
        );

        if (!response.data.status) {
          alert(response.data.message || "Gagal mengambil detail dokumen");
          return;
        }

        // 2. Set data untuk dikirim ke component
        this.editData = response.data.data;
        this.selectedDocumentType = doc.value;
        this.editUuid = item.uuid;

        // 3. Navigate ke component create/edit
        this.state = "create";

      } catch (error) {
        console.error("Error saat edit:", error);
        alert(
          error.response?.data?.message || "Terjadi kesalahan saat mengambil data"
        );
      } finally {
        this.isLoading = false;
      }
    },

    onPrint(item) {
      // Generate print URL based on document type
      const printUrls = {
        laser_bargage: `/print/laser-bargage/${item.uuid}`,
        laporan_bedah: `/print/laporan-pembedahan/${item.uuid}`,
        informed_consent: `/print/informed-consent/${item.uuid}`,
        surat_kontrol_ulang: `/print/rekammedis/general/suratkontrolulang/${item.uuid}`,
        surat_penolakan_rujukan: `/print/rekammedis/general/suratpenolakanrujukan/${item.uuid}`,
        surat_pernyataan_pasien_umum: `/print/rekammedis/general/suratpernyataanpasienumum/${item.uuid}`,
        surat_balasan_konsul: `/print/rekammedis/general/suratbalasankonsul/${item.uuid}`,
      };

      const url = printUrls[item.document_type];
      if (url) {
        window.open(url, "_blank");
      } else {
        alert("Print belum tersedia untuk dokumen ini");
      }
    },

    async onDelete(item) {
      const confirm = await this.$swal({
        icon: "warning",
        title: "Konfirmasi Hapus",
        text: `Apakah Anda yakin ingin menghapus ${item.document_label}?`,
        showCancelButton: true,
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal",
        confirmButtonColor: "#d33",
      });

      if (!confirm.isConfirmed) return;

      try {
        const response = await axios.delete(
          `/master/rekammedis/lampiran/${item.uuid}?type=${item.document_type}`
        );

        if (response.data.status) {
          this.$swal({
            icon: "success",
            title: "Berhasil",
            text: "Dokumen berhasil dihapus",
            timer: 2000,
          });
          this.fetchLampiran();
        }
      } catch (error) {
        console.error("Error:", error);
        this.$swal({
          icon: "error",
          title: "Error",
          text: "Gagal menghapus dokumen",
        });
      }
    },

    // Helper methods
    formatDate(date) {
      if (!date) return "-";
      const d = new Date(date);
      return d.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
    },

    formatTime(time) {
      if (!time) return "-";
      // Handle both time string and datetime
      if (typeof time === "string") {
        return time.substring(0, 5);
      }
      return "-";
    },

    truncate(text, length) {
      if (!text) return "-";
      if (text.length <= length) return text;
      return text.substring(0, length) + "...";
    },
  },
};
</script>

<style scoped>
.history-container {
  background: white;
  padding: 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  position: relative;
  min-height: 500px;
}

.header-component-rme {
  background: #0f62a8;
  color: white;
  text-align: center;
  padding: 12px;
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 15px;
  border-radius: 4px;
}

/* PATIENT INFO CARD */
.patient-info-card {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  padding: 12px 15px;
  margin-bottom: 15px;
}

.patient-info-card .row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -8px;
}

.patient-info-card .col-md-2,
.patient-info-card .col-md-3,
.patient-info-card .col-md-4 {
  padding: 0 8px;
  font-size: 14px;
}

.patient-info-card strong {
  color: #495057;
}

/* FILTER BAR */
.filter-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  font-size: 14px;
  align-items: center;
}

.filter-left select {
  margin: 0 5px;
  padding: 4px 8px;
  border: 1px solid #aaa;
  border-radius: 3px;
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
  width: 200px;
}

.btn-add {
  background: #28a745;
  color: white;
  border: none;
  padding: 7px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background 0.3s;
  display: flex;
  align-items: center;
  gap: 5px;
}

.btn-add:hover {
  background: #218838;
}

/* DOCUMENT BADGE */
.document-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 4px;
  color: white;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
}

.document-badge i {
  margin-right: 5px;
}

/* TABLE */
.custom-table-rme {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 10px;
  font-size: 13px;
}

.custom-table-rme th {
  background: #1d72c9;
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

.custom-table-rme tbody tr:nth-child(even) {
  background: #f8f9fa;
}

.custom-table-rme tbody tr:hover {
  background: #e9f2ff;
}

.text-center {
  text-align: center;
}

.detail-info {
  font-size: 12px;
  color: #666;
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

.btn-view {
  background: #17a2b8;
}

.btn-view:hover {
  background: #138496;
}

.btn-edit {
  background: #ffc107;
}

.btn-edit:hover {
  background: #e0a800;
}

.btn-print {
  background: #6c757d;
}

.btn-print:hover {
  background: #5a6268;
}

.btn-delete {
  background: #dc3545;
}

.btn-delete:hover {
  background: #c82333;
}

/* PAGINATION */
.pagination-rme {
  display: flex;
  gap: 5px;
  align-items: center;
}

.pagination-rme button {
  padding: 6px 12px;
  border: 1px solid #1d72c9;
  background: white;
  cursor: pointer;
  border-radius: 3px;
  font-size: 13px;
  transition: all 0.2s;
}

.pagination-rme button:hover:not(:disabled) {
  background: #e9f2ff;
}

.pagination-rme button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-btn.active {
  background: #1d72c9;
  color: white;
  font-weight: bold;
}

/* TABLE INFO */
.table-info {
  margin-top: 10px;
  margin-bottom: 10px;
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
  font-size: 18px;
  z-index: 10;
  border-radius: 5px;
}

.spinner-rme {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 10px;
}

/* SELECT DOCUMENT STYLES */
.select-document-container {
  padding: 20px;
}

.document-selector-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  padding: 30px;
  max-width: 600px;
  margin: 20px auto;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-weight: 600;
  margin-bottom: 8px;
  color: #333;
  font-size: 15px;
}

.form-select {
  width: 100%;
  padding: 10px 12px;
  border: 2px solid #d0d0d0;
  border-radius: 6px;
  font-size: 15px;
  background: white;
  transition: border-color 0.3s;
}

.form-select:focus {
  outline: none;
  border-color: #1d72c9;
}

.document-info {
  background: #e3f2fd;
  border-left: 4px solid #1d72c9;
  padding: 12px 15px;
  border-radius: 4px;
  font-size: 14px;
  color: #555;
  display: flex;
  align-items: flex-start;
  gap: 10px;
}

.document-info i {
  color: #1d72c9;
  margin-top: 2px;
}

.button-group {
  display: flex;
  gap: 12px;
  justify-content: center;
}

.btn-primary,
.btn-secondary {
  padding: 10px 24px;
  border: none;
  border-radius: 6px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-primary {
  background: #28a745;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #218838;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.btn-primary:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #5a6268;
  transform: translateY(-1px);
}

/* UTILITY */
.mb-3 {
  margin-bottom: 16px;
}

.mt-3 {
  margin-top: 16px;
}

.mt-4 {
  margin-top: 24px;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .filter-bar {
    flex-direction: column;
    gap: 10px;
    align-items: flex-start;
  }

  .filter-right {
    width: 100%;
    flex-direction: column;
    align-items: stretch;
  }

  .search-input {
    width: 100%;
  }

  .action-buttons {
    flex-wrap: wrap;
  }

  .document-selector-card {
    padding: 20px;
    margin: 10px;
  }

  .button-group {
    flex-direction: column;
  }

  .btn-primary,
  .btn-secondary {
    width: 100%;
    justify-content: center;
  }
}
</style>
