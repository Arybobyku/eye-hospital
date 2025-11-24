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
      <div class="header-component-rme">Laporan Pembedahan</div>

      <!-- FILTER BAR -->
      <div class="filter-bar">
        <div class="filter-left">
          Tampil
          <select v-model="perPage">
            <option v-for="n in [10, 25, 50, 100]" :key="n">{{ n }}</option>
          </select>
          data
        </div>

        <div class="filter-right">
          <button class="btn-add" @click="onAdd">+ Tambah</button>

          Cari:
          <input type="text" v-model="searchQuery" class="search-input" />
        </div>
      </div>

      <!-- TABLE -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>JAM</th>
            <th>NAMA PASIEN</th>
            <th>JENIS KELAMIN</th>
            <th>NIK</th>
            <th>USER</th>
            <th>ACTION</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(item, index) in paginatedData" :key="item.id">
            <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
            <td>{{ item.date }}</td>
            <td>{{ item.time }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.jenis_kelamin }}</td>
            <td>{{ item.no_identitas }}</td>
            <td>{{ item.carabayar_nama }}</td>
            <!-- ACTION -->
            <td class="text-center">
              <!-- icon print -->
              <i class="fas fa-print action-icon" @click="print()"></i>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ startRow }} s/d {{ endRow }} dari {{ data.length }} data
      </div>

      <!-- PAGINATION -->
      <div class="pagination-rme">
        <button :disabled="currentPage === 1" @click="currentPage--">Previous</button>

        <button
          v-for="page in totalPages"
          :key="page"
          :class="['page-btn', { active: currentPage === page }]"
          @click="currentPage = page"
        >
          {{ page }}
        </button>

        <button :disabled="currentPage === totalPages" @click="currentPage++">
          Next
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
          <select 
            id="documentType" 
            v-model="selectedDocumentType" 
            class="form-select"
          >
            <option value="">-- Pilih Dokumen --</option>
            <option 
              v-for="doc in availableDocuments" 
              :key="doc.value" 
              :value="doc.value"
            >
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
            Lanjutkan
          </button>
          <button class="btn-secondary" @click="onCancelSelection">
            Batal
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
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";

export default {
  name: "Lampiran",
  components: {
    // Lazy load components
    CreateLaporanBedah: defineAsyncComponent(() =>
      import("./create/LaporanBedah.vue")
    ),
    FormLaserBargage: defineAsyncComponent(() =>
      import("./create/FormLaserBarage.vue")
    ),
    // FormInformedConsent: defineAsyncComponent(() =>
    //   import("./create/FormInformedConsent.vue")
    // ),
    // Tambahkan component baru di sini jika ada
  },

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      state: "list", // list | select-document | create
      selectedDocumentType: "",
      loading: false,
      data: [],

      // ✨ DAFTAR DOKUMEN YANG TERSEDIA (MUDAH DITAMBAH/EDIT)
      availableDocuments: [
        {
          value: "laporan-bedah",
          label: "Laporan Pembedahan",
          component: "CreateLaporanBedah",
          description: "Form untuk mencatat laporan operasi dan pembedahan pasien"
        },
        {
          value: "laser-bargage",
          label: "Form Laser Bargage",
          component: "FormLaserBargage",
          description: "Form tindakan laser bargage medis"
        },
        // {
        //   value: "informed-consent",
        //   label: "Informed Consent",
        //   component: "FormInformedConsent",
        //   description: "Surat persetujuan/penolakan tindakan medis"
        // },
        // ✨ TAMBAHKAN DOKUMEN BARU DI SINI
        // {
        //   value: "nama-dokumen",
        //   label: "Label Dokumen",
        //   component: "NamaComponent",
        //   description: "Deskripsi dokumen"
        // },
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
        if (newVal?.id) {
          this.fetchHistory();
        }
      },
    },
  },

  computed: {
    filteredData() {
      if (!this.searchQuery) return this.data;

      return this.data.filter((row) =>
        Object.values(row).some((val) =>
          String(val).toLowerCase().includes(this.searchQuery.toLowerCase())
        )
      );
    },

    totalPages() {
      return Math.ceil(this.filteredData.length / this.perPage);
    },

    paginatedData() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.filteredData.slice(start, start + this.perPage);
    },

    startRow() {
      return (this.currentPage - 1) * this.perPage + 1;
    },

    endRow() {
      const end = this.currentPage * this.perPage;
      return end > this.data.length ? this.data.length : end;
    },

    // ✨ COMPUTED UNTUK MENDAPATKAN COMPONENT YANG DIPILIH
    currentDocumentComponent() {
      const doc = this.availableDocuments.find(
        d => d.value === this.selectedDocumentType
      );
      return doc ? doc.component : null;
    }
  },

  methods: {
    async fetchHistory() {
      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("search", this.selectedPatient.uuid);
        formData.append("limit", 10);
        formData.append("page", 1);

        const res = await axios.post(
          "/master/pasien/list-dokumen-persetujuan-penolkan",
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat history:", err);
        alert("Gagal memuat data history.");
      } finally {
        this.loading = false;
      }
    },

    // ✨ HANDLER UNTUK TOMBOL TAMBAH
    onAdd() {
      this.state = "select-document";
      this.selectedDocumentType = "";
    },

    // ✨ HANDLER LANJUT KE CREATE SETELAH PILIH DOKUMEN
    onProceedToCreate() {
      if (!this.selectedDocumentType) {
        alert("Silakan pilih jenis dokumen terlebih dahulu!");
        return;
      }
      this.state = "create";
    },

    // ✨ HANDLER BATAL PILIH DOKUMEN
    onCancelSelection() {
      this.state = "list";
      this.selectedDocumentType = "";
    },

    // ✨ HANDLER KEMBALI KE LIST DARI CREATE
    onBackToList() {
      this.state = "list";
      this.selectedDocumentType = "";
      this.fetchHistory(); // Refresh data setelah create
    },

    // ✨ HELPER UNTUK MENDAPATKAN INFO DOKUMEN
    getSelectedDocumentInfo() {
      const doc = this.availableDocuments.find(
        d => d.value === this.selectedDocumentType
      );
      return doc ? doc.description : "";
    },

    print() {
      window.open(
        `/print/rekammedis/rawat-jalan/rm1dot1/${this.selectedPatient.uuid}`,
        "_blank"
      );
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

.filter-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
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
  padding: 5px 8px;
  border: 1px solid #aaa;
  border-radius: 3px;
}

/* TABLE */
.custom-table-rme {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 10px;
}

.custom-table-rme th {
  background: #1d72c9;
  color: white;
  padding: 8px;
  text-align: left;
  font-size: 13px;
}

.custom-table-rme td {
  border: 1px solid #ddd;
  padding: 8px;
  font-size: 13px;
}

.custom-table-rme tbody tr:nth-child(even) {
  background: #e9f2ff;
}

.text-center {
  text-align: center;
}

.action-icon {
  cursor: pointer;
  color: #1d72c9;
  font-size: 16px;
}

.action-icon:hover {
  color: #0f62a8;
}

/* INFO */
.table-info {
  margin-top: 5px;
  font-size: 13px;
}

/* PAGINATION */
.pagination-rme {
  display: flex;
  gap: 5px;
}

.pagination-rme button {
  padding: 5px 10px;
  border: 1px solid #1d72c9;
  background: white;
  cursor: pointer;
  border-radius: 3px;
  font-size: 13px;
}

.pagination-rme button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-btn.active {
  background: #1d72c9;
  color: white;
}

/* LOADING OVERLAY */
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
  width: 32px;
  height: 32px;
  border: 4px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 10px;
}

/* ================= DOCUMENT SELECTOR STYLES ================= */
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
  box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
}

.btn-add {
  background: #28a745;
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background 0.3s;
}

.btn-add:hover {
  background: #218838;
}

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
  }
}
</style>