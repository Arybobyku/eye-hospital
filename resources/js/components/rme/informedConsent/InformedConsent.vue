<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- ===== LIST ===== -->
    <div v-if="state == 'list'">
      <div class="header-component-rme">Surat Persetujuan / Penolakan Medis</div>

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

      <table class="custom-table-rme">
        <thead>
          <tr>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>JAM</th>
            <th>NAMA PASIEN</th>
            <th>MENYATAKAN</th>
            <th>PETUGAS</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="paginatedData.length === 0">
            <td colspan="7" style="text-align:center; color:#999;">Tidak ada data.</td>
          </tr>
          <tr v-for="(item, index) in paginatedData" :key="item.id">
            <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
            <td>{{ item.date }}</td>
            <td>{{ item.time }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.menyatakan }}</td>
            <td>{{ item.petugas }}</td>
            <td class="text-center" style="white-space:nowrap;">
              <i class="fas fa-eye action-icon" title="Lihat" @click="onView(item)" style="color:#1d72c9; margin-right:6px; cursor:pointer;"></i>
              <i class="fas fa-edit action-icon" title="Edit" @click="onEdit(item)" style="color:#f59e0b; margin-right:6px; cursor:pointer;"></i>
              <i class="fas fa-trash action-icon" title="Hapus" @click="onDelete(item)" style="color:#e53935; cursor:pointer;"></i>
              <i class="fas fa-print action-icon" title="Print" @click="print(item.id)" style="color:#555; margin-left:6px; cursor:pointer;"></i>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="table-info">
        Menampilkan {{ startRow }} s/d {{ endRow }} dari {{ filteredData.length }} data
      </div>

      <div class="pagination-rme">
        <button :disabled="currentPage === 1" @click="currentPage--">Previous</button>
        <button
          v-for="page in totalPages"
          :key="page"
          :class="['page-btn', { active: currentPage === page }]"
          @click="currentPage = page"
        >{{ page }}</button>
        <button :disabled="currentPage === totalPages" @click="currentPage++">Next</button>
      </div>
    </div>

    <!-- ===== VIEW (read-only) ===== -->
    <div v-if="state == 'view' && selectedItem">
      <ViewInformedConsent
        :item="selectedItem"
        @back="state = 'list'"
        @edit="onEdit(selectedItem)"
      />
    </div>

    <!-- ===== CREATE / EDIT ===== -->
    <div v-if="state == 'create' || state == 'edit'">
      <CreateInformedConsent
        @back="state = 'list'"
        @saved="onSaved"
        :selectedPatient="selectedPatient"
        :editData="state === 'edit' ? selectedItem : null"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";
export default {
  name: "InformedConsent",
  components: {
    CreateInformedConsent: defineAsyncComponent(() =>
      import("./CreateInformedConsent.vue")
    ),
    ViewInformedConsent: defineAsyncComponent(() =>
      import("./ViewInformedConsent.vue")
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
      selectedItem: null,
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
      return Math.max(1, Math.ceil(this.filteredData.length / this.perPage));
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.filteredData.slice(start, start + this.perPage);
    },
    startRow() {
      if (this.filteredData.length === 0) return 0;
      return (this.currentPage - 1) * this.perPage + 1;
    },
    endRow() {
      const end = this.currentPage * this.perPage;
      return end > this.filteredData.length ? this.filteredData.length : end;
    },
  },

  methods: {
    async fetchHistory() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append("search", this.selectedPatient.uuid);
        fd.append("limit", 100);
        fd.append("page", 1);

        const res = await axios.post(
          "/master/pasien/list-dokumen-persetujuan-penolkan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );
        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat history:", err);
      } finally {
        this.loading = false;
      }
    },

    onAdd() {
      this.selectedItem = null;
      this.state = "create";
    },

    onView(item) {
      this.selectedItem = { ...item };
      this.state = "view";
    },

    onEdit(item) {
      this.selectedItem = { ...item };
      this.state = "edit";
    },

    async onDelete(item) {
      if (!confirm(`Hapus data informed consent tanggal ${item.date}? Tindakan ini tidak dapat dibatalkan.`)) return;
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append("id", item.id);
        const res = await axios.post(
          "/master/pasien/delete-dokumen-persetujuan-penolkan",
          fd,
          { headers: { "Content-Type": "multipart/form-data" } }
        );
        if (res.data?.data === "berhasil") {
          await this.fetchHistory();
        } else {
          alert("Gagal menghapus data.");
        }
      } catch (err) {
        console.error(err);
        alert("Terjadi kesalahan saat menghapus.");
      } finally {
        this.loading = false;
      }
    },

    onSaved() {
      this.state = "list";
      this.fetchHistory();
    },

    print(id) {
      window.open(`/print/rekammedis/bedah/rm1dot8/${id}`, "_blank");
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
}

.filter-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  font-size: 14px;
}

.filter-left select { margin: 0 5px; }

.search-input {
  padding: 3px 5px;
  border: 1px solid #aaa;
  border-radius: 3px;
}

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
.custom-table-rme tbody tr:nth-child(even) { background: #e9f2ff; }

.table-info { margin-top: 5px; font-size: 13px; }

.pagination-rme { display: flex; gap: 5px; margin-top: 8px; }
.pagination-rme button {
  padding: 5px 10px;
  border: 1px solid #1d72c9;
  background: white;
  cursor: pointer;
  border-radius: 3px;
}
.page-btn.active { background: #1d72c9; color: white; }

.loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0.85);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  z-index: 10;
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
@keyframes spin-rme { to { transform: rotate(360deg); } }

.btn-add {
  background: #28a745;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  margin-right: 10px;
}
.btn-add:hover { background: #218838; }

/* View styles */
.view-container { max-width: 860px; margin: 0 auto; }
.view-section {
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 16px;
  margin-bottom: 16px;
}
.view-section-title {
  font-weight: bold;
  color: #1d72c9;
  margin-bottom: 12px;
}
.view-row {
  display: flex;
  gap: 12px;
  padding: 6px 0;
  border-bottom: 1px solid #f0f0f0;
  font-size: 13px;
}
.view-label {
  width: 180px;
  font-weight: 600;
  color: #555;
  flex-shrink: 0;
}

.sig-view-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
}
.sig-view-item {
  text-align: center;
  min-width: 140px;
}
.sig-view-label {
  font-size: 12px;
  font-weight: 600;
  color: #555;
  margin-bottom: 6px;
}
.sig-view-img {
  height: 80px;
  max-width: 180px;
  border: 1px solid #ccc;
  border-radius: 4px;
  object-fit: contain;
}
.sig-view-empty {
  color: #bbb;
  font-size: 20px;
  padding: 20px 0;
}

.btn-back-ic {
  background: #f59e0b;
  color: white;
  border: none;
  padding: 7px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 12px;
}
.btn-ic-edit {
  background: #1d72c9;
  color: white;
  border: none;
  padding: 7px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 600;
}
</style>
