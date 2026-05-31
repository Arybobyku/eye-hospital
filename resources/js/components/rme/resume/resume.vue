<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- ========== LIST ========== -->
    <div v-if="state === 'list'">
      <div class="header-component-rme">Resume Medis Rawat Jalan</div>

      <!-- PATIENT INFO CARD -->
      <div class="patient-info-card mb-3">
        <div class="row">
          <div class="col-md-3"><strong>No. RM:</strong> {{ selectedPatient?.rekam_medis }}</div>
          <div class="col-md-4"><strong>Nama:</strong> {{ selectedPatient?.nama }}</div>
          <div class="col-md-3"><strong>NIK:</strong> {{ selectedPatient?.no_identitas }}</div>
          <div class="col-md-2"><strong>JK:</strong> {{ selectedPatient?.jenis_kelamin }}</div>
        </div>
      </div>

      <!-- FILTER BAR -->
      <div class="filter-bar">
        <div class="filter-left">
          Tampil
          <select v-model="perPage" @change="fetchList">
            <option v-for="n in [10, 25, 50, 100]" :key="n">{{ n }}</option>
          </select>
          data
        </div>
        <div class="filter-right">
          <button class="btn-add" @click="onAdd">
            <i class="fas fa-plus"></i> Tambah
          </button>
          Cari:
          <input type="text" v-model="searchQuery" @input="onSearch" class="search-input" placeholder="No surat, dokter, diagnosa..." />
        </div>
      </div>

      <!-- TABLE -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th style="width:50px">NO</th>
            <th style="width:130px">TANGGAL BEROBAT</th>
            <th style="width:160px">NO SURAT</th>
            <th style="width:160px">DOKTER</th>
            <th>DIAGNOSA</th>
            <th style="width:130px">DIBUAT OLEH</th>
            <th style="width:150px" class="text-center">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="data.length === 0">
            <td colspan="7" class="text-center">
              {{ loading ? 'Memuat data...' : 'Tidak ada data' }}
            </td>
          </tr>
          <tr v-for="(item, index) in data" :key="item.uuid">
            <td>{{ pagination.from + index }}</td>
            <td>{{ formatDate(item.tanggal_berobat) }}</td>
            <td>{{ item.no_surat || '-' }}</td>
            <td>{{ item.dokter || '-' }}</td>
            <td class="diagnosa-cell">{{ item.diagnosa || '-' }}</td>
            <td>{{ item.created_by || '-' }}</td>
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
                <button class="btn-action btn-delete" @click="onDelete(item)" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ pagination.from }} s/d {{ pagination.to }} dari {{ pagination.total }} data
      </div>

      <!-- PAGINATION -->
      <div class="pagination-rme">
        <button :disabled="pagination.current_page === 1" @click="changePage(pagination.current_page - 1)">
          <i class="fas fa-chevron-left"></i> Previous
        </button>
        <button
          v-for="page in visiblePages"
          :key="page"
          :class="['page-btn', { active: pagination.current_page === page }]"
          @click="changePage(page)"
        >{{ page }}</button>
        <button :disabled="pagination.current_page === pagination.total_pages" @click="changePage(pagination.current_page + 1)">
          Next <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- ========== CREATE ========== -->
    <div v-if="state === 'create'">
      <FormResumeMedisRawatJalan
        :selectedPatient="selectedPatient"
        @back="onBack"
      />
    </div>

    <!-- ========== VIEW ========== -->
    <div v-if="state === 'view'">
      <FormResumeMedisRawatJalan
        :selectedPatient="selectedPatient"
        :viewData="activeItem"
        :editData="activeItem"
        @back="onBack"
      />
    </div>

    <!-- ========== EDIT ========== -->
    <div v-if="state === 'edit'">
      <FormResumeMedisRawatJalan
        :selectedPatient="selectedPatient"
        :editData="activeItem"
        @back="onBack"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";

export default {
  name: "ResumeMenu",

  components: {
    FormResumeMedisRawatJalan: defineAsyncComponent(() =>
      import("../lampiran/create/FormResumeMedisRawatJalan.vue")
    ),
  },

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      state: "list",
      loading: false,
      data: [],
      activeItem: null,
      searchQuery: "",
      searchTimeout: null,
      perPage: 10,
      pagination: {
        total: 0,
        per_page: 10,
        current_page: 1,
        total_pages: 1,
        from: 0,
        to: 0,
      },
    };
  },

  computed: {
    visiblePages() {
      const total = this.pagination.total_pages || 1;
      const cur   = this.pagination.current_page;
      const delta = 2;
      const range = [];
      for (let i = Math.max(1, cur - delta); i <= Math.min(total, cur + delta); i++) {
        range.push(i);
      }
      return range;
    },
  },

  watch: {
    selectedPatient: {
      immediate: true,
      handler(val) {
        if (val?.uuid) this.fetchList();
      },
    },
  },

  methods: {
    async fetchList() {
      if (!this.selectedPatient?.uuid) return;
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append("uuid_pasien", this.selectedPatient.uuid);
        fd.append("search", this.searchQuery);
        fd.append("limit", this.perPage);
        fd.append("page", this.pagination.current_page);

        const res = await axios.post("/master/pasien/list-resume-medis-rawat-jalan", fd);
        if (res.data.status) {
          this.data       = res.data.data ?? [];
          this.pagination = res.data.pagination;
        }
      } catch (err) {
        console.error("Gagal memuat data:", err);
      } finally {
        this.loading = false;
      }
    },

    onSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.pagination.current_page = 1;
        this.fetchList();
      }, 400);
    },

    changePage(page) {
      if (page < 1 || page > this.pagination.total_pages) return;
      this.pagination.current_page = page;
      this.fetchList();
    },

    onAdd() {
      this.activeItem = null;
      this.state = "create";
    },

    onView(item) {
      this.activeItem = item;
      this.state = "view";
    },

    onEdit(item) {
      this.activeItem = item;
      this.state = "edit";
    },

    onPrint(item) {
      window.open(`/print/rekammedis/lampiran/rekam-medis-rawat-jalan/${item.uuid}`, "_blank");
    },

    async onDelete(item) {
      if (!confirm("Apakah Anda yakin ingin menghapus dokumen ini?")) return;
      this.loading = true;
      try {
        const res = await axios.delete(
          `/master/rekammedis/lampiran/${item.uuid}?type=resume_medis_rawat_jalan`
        );
        if (res.data.status) {
          await this.fetchList();
        } else {
          alert(res.data.message || "Gagal menghapus data");
        }
      } catch (err) {
        console.error("Error delete:", err);
        alert("Terjadi kesalahan saat menghapus data");
      } finally {
        this.loading = false;
      }
    },

    onBack() {
      this.activeItem = null;
      this.state = "list";
      this.fetchList();
    },

    formatDate(val) {
      if (!val) return "-";
      const d = new Date(val);
      if (isNaN(d)) return val;
      return d.toLocaleDateString("id-ID", { day: "2-digit", month: "2-digit", year: "numeric" });
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

.patient-info-card {
  background: #f0f6ff;
  border: 1px solid #c7dff7;
  border-radius: 6px;
  padding: 10px 15px;
  font-size: 13px;
}

.filter-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  font-size: 14px;
  flex-wrap: wrap;
  gap: 8px;
}

.filter-left select {
  margin: 0 5px;
  padding: 3px 6px;
  border: 1px solid #aaa;
  border-radius: 3px;
}

.filter-right {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.search-input {
  padding: 4px 8px;
  border: 1px solid #aaa;
  border-radius: 3px;
  min-width: 200px;
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
  padding: 8px;
  text-align: left;
}
.custom-table-rme td {
  border: 1px solid #ddd;
  padding: 7px 8px;
}
.custom-table-rme tbody tr:nth-child(even) {
  background: #e9f2ff;
}
.diagnosa-cell {
  max-width: 200px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* ACTION BUTTONS */
.action-buttons {
  display: flex;
  justify-content: center;
  gap: 5px;
  flex-wrap: wrap;
}
.btn-action {
  width: 30px;
  height: 30px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  color: white;
  font-size: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.btn-view   { background: #17a2b8; }
.btn-view:hover { background: #138496; }
.btn-edit   { background: #ffc107; color: #333; }
.btn-edit:hover { background: #e0a800; }
.btn-print  { background: #6c757d; }
.btn-print:hover { background: #545b62; }
.btn-delete { background: #dc3545; }
.btn-delete:hover { background: #c82333; }

/* ADD BUTTON */
.btn-add {
  background: #28a745;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
}
.btn-add:hover { background: #218838; }

/* FOOTER & PAGINATION */
.table-info {
  margin-top: 5px;
  font-size: 13px;
  color: #555;
}
.pagination-rme {
  display: flex;
  gap: 5px;
  margin-top: 10px;
  flex-wrap: wrap;
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
  cursor: default;
}
.page-btn.active {
  background: #1d72c9;
  color: white;
}

/* LOADING OVERLAY */
.loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.8);
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
  to { transform: rotate(360deg); }
}

.text-center { text-align: center; }
.mb-3 { margin-bottom: 12px; }
.row { display: flex; flex-wrap: wrap; }
.col-md-2 { flex: 0 0 16.66%; }
.col-md-3 { flex: 0 0 25%; }
.col-md-4 { flex: 0 0 33.33%; }
</style>
