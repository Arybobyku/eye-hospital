<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <div v-if="state == 'list'">
      <!-- HEADER -->
      <div class="header-component-rme">Pengkajian Data Umum</div>

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
          <tr v-if="paginatedData.length === 0">
            <td colspan="8" style="text-align: center; padding: 20px">
              Tidak ada data
            </td>
          </tr>
          <tr v-for="(item, index) in paginatedData" :key="item.id || item.uuid">
            <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
            <td>{{ formatDate(item.tanggal) }}</td>
            <td>{{ item.waktu }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.jenis_kelamin }}</td>
            <td>{{ item.no_identitas }}</td>
            <td>{{ item.user_nama }}</td>
            <!-- ACTION -->
            <td class="text-center action-buttons">
              <!-- icon edit -->
              <i class="fas fa-edit action-icon" @click="onEdit(item)"></i>
              <!-- icon delete -->
              <i class="fas fa-trash action-icon" @click="onDelete(item)"></i>
              <!-- icon print -->
              <i class="fas fa-print action-icon" @click="onPrint(item)"></i>
            </td>
          </tr>
        </tbody>  
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ startRow }} s/d {{ endRow }} dari {{ filteredData.length }} data
      </div>

      <!-- PAGINATION -->
      <div class="pagination-rme" v-if="totalPages > 1">
        <button :disabled="currentPage === 1" @click="currentPage--">Previous</button>

        <button
          v-for="page in displayPages"
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

    <!-- Create/Edit Data -->
    <div v-if="state == 'create' || state == 'edit'">
      <CreatePengkajianData 
        @back="handleBack" 
        :selectedPatient="selectedPatient"
        :editData="editData"
        :isEditMode="state === 'edit'"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";
import CreatePengkajianData from "./CreatePengkajianData.vue";

export default {
  name: "pengkajianData",
  components: {
    CreatePengkajianData: defineAsyncComponent(() =>
      import("./CreatePengkajianData.vue")
    ),
  },

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      state: "list",
      loading: false,
      data: [],
      editData: null,
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

    displayPages() {
      const pages = [];
      const maxDisplay = 5;
      let start = Math.max(1, this.currentPage - Math.floor(maxDisplay / 2));
      let end = Math.min(this.totalPages, start + maxDisplay - 1);

      if (end - start + 1 < maxDisplay) {
        start = Math.max(1, end - maxDisplay + 1);
      }

      for (let i = start; i <= end; i++) {
        pages.push(i);
      }
      return pages;
    },

    startRow() {
      return this.filteredData.length === 0 ? 0 : (this.currentPage - 1) * this.perPage + 1;
    },

    endRow() {
      return Math.min(this.currentPage * this.perPage, this.filteredData.length);
    },
  },

  mounted() {
    // this.fetchHistory();
  },
  
  methods: {
    async fetchHistory() {
      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("search", this.selectedPatient.uuid);
        formData.append("limit", 100);
        formData.append("page", 1);

        const res = await axios.post("/master/pasien/list-pengkajian-data-umum", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        // 👇 pastikan data backend berupa array
        this.data = Array.isArray(res.data?.data) ? res.data.data : [];
        this.currentPage = 1;
      } catch (err) {
        console.error("Gagal memuat Pengkajian Data Umum Pasien:", err);
        alert("Gagal memuat data pengkajian data umum pasien.");
        this.data = [];
      } finally {
        this.loading = false;
      }
    },

    formatDate(date) {
      if (!date) return "-";
      const d = new Date(date);
      return d.toLocaleDateString("id-ID");
    },

    onAdd() {
      this.state = "create";
      this.editData = null;
    },

    onEdit(item) {
      this.state = "edit";
      this.editData = { ...item }; // Clone data untuk edit
    },

    async onDelete(item) {
      // Cek apakah item memiliki uuid atau id
      const identifier = item.uuid || item.id;
      
      if (!identifier) {
        alert("Data tidak valid untuk dihapus");
        return;
      }

      if (!confirm(`Yakin ingin menghapus data pengkajian untuk ${item.nama}?`)) {
        return;
      }

      this.loading = true;

      try {
        // ⚠️ SESUAIKAN endpoint dengan route yang ada
        await axios.delete(`/master/pasien/pengkajian-data-umum/${identifier}`);

        // Hapus dari array lokal
        this.data = this.data.filter(d => (d.uuid || d.id) !== identifier);

        alert("Data berhasil dihapus");
      } catch (error) {
        console.error("Error deleting:", error);
        alert("Gagal menghapus data: " + (error.response?.data?.message || error.message));
      } finally {
        this.loading = false;
      }
    },

    onPrint(item) {
      // ⚠️ SESUAIKAN dengan endpoint print yang ada
      const identifier = item.uuid || item.id;
      
      if (!identifier) {
        alert("Data tidak valid untuk dicetak");
        return;
      }

      window.open(
        `/print/pengkajian-data-umum/${identifier}`,
        "_blank"
      );
    },

    handleBack() {
      this.state = "list";
      this.editData = null;
      this.fetchHistory(); // Refresh data setelah create/edit
    },

    mappedStatus(data) {
      if (data?.status_ro != "Sudah Diperiksa") {
        return "Pemriksasan Refraksi Optisi";
      }
      if (data?.status_dokter != "Sudah Diperiksa") {
        return "Pemriksasan Dokter";
      }
      if (data?.status_dokter != "Sudah Bayar") {
        return "Farmasi";
      }
      if (data?.status_dokter != "Sudah Bayar") {
        return "Kasir";
      }

      return "Selesai";
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
  align-items: center;
  gap: 10px;
}

.search-input {
  padding: 5px 10px;
  border: 1px solid #aaa;
  border-radius: 3px;
  width: 200px;
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
  text-align: center;
  font-size: 12px;
  font-weight: 600;
  border: 1px solid #1660b0;
}

.custom-table-rme td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

.custom-table-rme tbody tr:nth-child(even) {
  background: #e9f2ff;
}

.custom-table-rme tbody tr:hover {
  background: #d4e9ff;
}

.action-buttons {
  display: flex;
  gap: 8px;
  justify-content: center;
  align-items: center;
}

.action-icon {
  cursor: pointer;
  font-size: 16px;
  transition: all 0.2s;
}

.fa-edit {
  color: #ffc107;
}

.fa-edit:hover {
  color: #e0a800;
}

.fa-trash {
  color: #dc3545;
}

.fa-trash:hover {
  color: #c82333;
}

.fa-print {
  color: #1d72c9;
}

.fa-print:hover {
  color: #0f62a8;
}

/* INFO */
.table-info {
  margin: 10px 0;
  font-size: 13px;
  color: #555;
}

/* PAGINATION */
.pagination-rme {
  display: flex;
  gap: 5px;
  margin-top: 10px;
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
  width: 40px;
  height: 40px;
  border: 4px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 10px;
}

.btn-add {
  background: #28a745;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
  transition: background 0.2s;
}

.btn-add:hover {
  background: #218838;
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
  }

  .search-input {
    width: 100%;
  }

  .custom-table-rme {
    font-size: 11px;
  }

  .custom-table-rme th,
  .custom-table-rme td {
    padding: 6px 4px;
  }
}
</style>