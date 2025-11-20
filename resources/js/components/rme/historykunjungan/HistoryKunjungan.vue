<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- HEADER -->
    <div class="header-component-rme">History Kunjungan</div>


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
          <th>REGISTRASI</th>
          <th>TANGGAL</th>
          <th>JAM</th>
          <th>STATUS</th>
          <th>DOKTER</th>
          <th>JAMINAN</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(item, index) in paginatedData" :key="item.id">
          <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
          <td>{{ item.nomor }}</td>
          <td>{{ item.tanggal }}</td>
          <td>{{ item.waktu }}</td>
          <td>{{ mappedStatus(item) }}</td>
          <td>{{ item.nama_dokter }}</td>
          <td>{{ item.carabayar_nama }}</td>
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

      <button :disabled="currentPage === totalPages" @click="currentPage++">Next</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "HistoryKunjungan",

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      loading: false, // Loading indicator
      // Sample data (nanti ganti dengan API)
      data: [
        // { id: 1, reg: "006969", tanggal: "06-11-2025", jam: "16:27", layanan: "AESTHETIC", dokter: "dr Nisa", jaminan: "UMUM" },
        // { id: 2, reg: "006889", tanggal: "10-10-2025", jam: "20:32", layanan: "POLI PSIKOLOGI", dokter: "dr. Yoga Yandika, Sp.A", jaminan: "UMUM" },
        // { id: 3, reg: "006825", tanggal: "17-09-2025", jam: "22:19", layanan: "AESTHETIC", dokter: "dr Nisa", jaminan: "APOTEK SUMBER WARAS" },
        // { id: 4, reg: "006720", tanggal: "04-08-2025", jam: "12:27", layanan: "POLI GIGI", dokter: "drg. ALFI, Sp. KGA", jaminan: "TRANSFER" },
        // { id: 5, reg: "006726", tanggal: "04-08-2025", jam: "14:55", layanan: "POLI GIGI", dokter: "drg. ALFI, Sp. KGA", jaminan: "PRIBADI" },
        // { id: 6, reg: "006711", tanggal: "31-07-2025", jam: "15:20", layanan: "AESTHETIC", dokter: "dr Nisa", jaminan: "PRIBADI" },
        // { id: 7, reg: "006486", tanggal: "25-04-2025", jam: "17:25", layanan: "BIDAN", dokter: "Dr Dessy", jaminan: "PRIBADI" },
        // { id: 8, reg: "006415", tanggal: "18-03-2025", jam: "16:37", layanan: "POLI UMUM", dokter: "DOKTER UMUM", jaminan: "UMUM" },
        // { id: 9, reg: "006385", tanggal: "10-03-2025", jam: "10:15", layanan: "AESTHETIC", dokter: "dr Nisa", jaminan: "UMUM" },
        // { id: 10, reg: "006315", tanggal: "07-02-2025", jam: "21:17", layanan: "LABORATORIUM", dokter: "dr. Ali indri", jaminan: "UMUM" },
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
        formData.append("limit", 10);
        formData.append("page", 1);

        const res = await axios.post("/master/pasien/history", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        // 👇 pastikan data backend berupa array
        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat history:", err);
        alert("Gagal memuat data history.");
      } finally {
        this.loading = false;
      }
    },


    mappedStatus(data){
        if(data?.status_ro != 'Sudah Diperiksa'){
            return 'Pemriksasan Refraksi Optisi'
        }
        if(data?.status_dokter != 'Sudah Diperiksa'){
            return 'Pemriksasan Dokter'
        }
        if(data?.status_dokter != 'Sudah Bayar'){
            return 'Farmasi'
        }
        if(data?.status_dokter != 'Sudah Bayar'){
            return 'Kasir'
        }

        return 'Selesai'
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
  to {
    transform: rotate(360deg);
  }
}
</style>
