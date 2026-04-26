<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- ===== LIST ===== -->
    <div v-if="state == 'list'">
      <div class="header-component-rme">Persetujuan Umum (General Consent)</div>

      <ButtonTambah @click="onAdd" />

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
          Cari:
          <input type="text" v-model="searchQuery" class="search-input" />
        </div>
      </div>

      <!-- TABLE -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th>NO</th>
            <th>TANGGAL & JAM</th>
            <th>NAMA PASIEN</th>
            <th>JENIS KELAMIN</th>
            <th>NIK</th>
            <th>USER</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="paginatedData.length === 0">
            <td colspan="7" style="text-align:center; color:#999;">Tidak ada data.</td>
          </tr>
          <tr v-for="(item, index) in paginatedData" :key="item.id">
            <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
            <td>{{ item.created_at }}</td>
            <td>{{ item.nama_pasien }}</td>
            <td>{{ item.jenis_kelamin }}</td>
            <td>{{ item.nik }}</td>
            <td>{{ item.nama_pemberi_informasi }}</td>
            <td class="action-buttons">
              <i class="fas fa-eye action-icon" title="Lihat" @click="onView(item)" style="color:#1d72c9; cursor:pointer;"></i>
              <i class="fas fa-edit action-icon" title="Edit" @click="onEdit(item)" style="color:#5cb85c; cursor:pointer;"></i>
              <i class="fas fa-trash action-icon" title="Hapus" @click="onDelete(item)" style="color:#d9534f; cursor:pointer;"></i>
              <i class="fas fa-print action-icon" title="Print" @click="print(item)" style="color:#0275d8; cursor:pointer;"></i>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ startRow }} s/d {{ endRow }} dari {{ filteredData.length }} data
      </div>

      <!-- PAGINATION -->
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

    <!-- ===== VIEW ===== -->
    <div v-if="state == 'view' && selectedItem">
      <ViewPersetujuanUmum
        :item="selectedItem"
        @back="state = 'list'"
        @edit="onEdit(selectedItem)"
      />
    </div>

    <!-- ===== CREATE ===== -->
    <div v-if="state == 'create'">
      <CreatePersetujuanUmum
        @back="state = 'list'"
        @saved="onSaved"
        :selectedPatient="selectedPatient"
        :editData="null"
      />
    </div>

    <!-- ===== EDIT ===== -->
    <div v-if="state == 'edit' && selectedItem">
      <CreatePersetujuanUmum
        @back="state = 'list'"
        @saved="onSaved"
        :selectedPatient="selectedPatient"
        :editData="selectedItem"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";
import ButtonTambah from '../components/ButtonTambah.vue';

export default {
  name: "PersetujuanUmum",
  components: {
    ButtonTambah,
    CreatePersetujuanUmum: defineAsyncComponent(() =>
      import("./CreatePersetujuanUmum.vue")
    ),
    ViewPersetujuanUmum: defineAsyncComponent(() =>
      import("./ViewPersetujuanUmum.vue")
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
        const formData = new FormData();
        formData.append("search", this.selectedPatient.uuid);
        formData.append("limit", 100);
        formData.append("page", 1);

        const res = await axios.post("/master/pasien/list-dokumen-persetujuan-umum", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat data:", err);
        alert("Gagal memuat data persetujuan umum.");
      } finally {
        this.loading = false;
      }
    },

    onAdd() {
      this.selectedItem = null;
      this.state = "create";
      this.$emit("set-breadcrumb", { docName: "Form Persetujuan" });
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
      if (!confirm(`Hapus data persetujuan umum tanggal ${item.created_at}? Tindakan ini tidak dapat dibatalkan.`)) return;
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append("uuid", item.uuid);
        const res = await axios.post("/master/pasien/delete-dokumen-persetujuan-umum", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        if (res.data?.data === "berhasil" || res.data?.message === "berhasil") {
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

    print(item) {
      window.open(`/print/rekammedis/rawat-jalan/general/` + item.uuid, "_blank");
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

.filter-left select {
  margin: 0 5px;
}

.search-input {
  padding: 3px 5px;
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

/* INFO */
.table-info {
  margin-top: 5px;
  font-size: 13px;
}

/* PAGINATION */
.pagination-rme {
  display: flex;
  gap: 5px;
  margin-top: 8px;
}

.pagination-rme button {
  padding: 5px 10px;
  border: 1px solid #1d72c9;
  background: white;
  cursor: pointer;
  border-radius: 3px;
}

.page-btn.active {
  background: #1d72c9;
  color: white;
}

/* LOADING OVERLAY */
.loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.85);
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

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}

.action-buttons {
  display: flex;
  align-items: center;
  gap: 10px;
  justify-content: center;
  white-space: nowrap;
}

.action-icon {
  cursor: pointer;
  font-size: 16px;
}

.action-icon:hover {
  opacity: 0.7;
}
</style>
