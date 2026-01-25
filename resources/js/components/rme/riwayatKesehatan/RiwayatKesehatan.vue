<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- HEADER -->
    <div class="header-component-rme">RIWAYAT KESEHATAN</div>

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
          <th>KODE</th>
          <th>REKAM MEDIS</th>
          <th>TANGGAL</th>
          <th>PENYAKIT YG PERNAH DIDERITA</th>
          <th>PERNAH DIOPERASI</th>
          <th>ALERGI MAKANAN</th>
          <th>ALERGI OBAT</th>
          <th>OBAT YANG DIGUNAKAN SAAT INI</th>
          <th>PENILAIAN RESIKO JATUH</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(item, index) in paginatedData" :key="item.id">
          <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
          <td>{{ item?.registrasi_nomor }}</td>
          <td>{{ item?.rekam_medis }}</td>
          <td>{{ item?.tanggal }}</td>
          <td>{{ item?.penyakit_pernah_diderita ?? "-" }}</td>
          <td>{{ item?.pernah_dioperasi ?? "-" }}</td>
          <td>{{ item?.riwayat_alergi_makanan ?? "-" }}</td>
          <td>{{ item?.riwayat_alergi_obatan ?? "-" }}</td>
          <td>{{ item?.obat_digunakan_saat_ini ?? "-" }}</td>
          <td>{{ item?.penilaian_resiko_jatuh ?? "-" }}</td>
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

  <!-- Modal Print-->
  <!-- Modal TandaTanda Umum -->
  <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
    <div class="modal-box">
      <div class="modal-header-rme">
        <h3>{{ modalTitle }}</h3>
        <span class="close-btn" @click="closeModal">&times;</span>
      </div>

      <div class="modal-content-rme"></div>

      <div class="modal-footer-rme">
        <button class="btn-close" @click="closeModal">Close</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Tindakan",

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      showModal: false,
      selectedItem: null,
      loading: false, // Loading indicator
      // Sample data (nanti ganti dengan API)
      data: [],
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

        const res = await axios.post("/master/pasien/tanda-umum-pasien", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        // 👇 pastikan data backend berupa array
        let tempData = res.data?.data ?? [];

        // filter hanya item yang punya data tidak null
        tempData = tempData.filter(element => {
          return (
            element.penyakit_pernah_diderita !== null ||
            element.pernah_dioperasi !== null ||
            element.riwayat_alergi_makanan !== null ||
            element.riwayat_alergi_obatan !== null ||
            element.obat_digunakan_saat_ini !== null ||
            element.penilaian_resiko_jatuh !== null
          );
        });

        this.data = tempData;
      } catch (err) {
        console.error("Gagal memuat history:", err);
        alert("Gagal memuat data history.");
      } finally {
        this.loading = false;
      }
    },

    formatRupiah(value) {
      if (!value) return "Rp 0";
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
      }).format(value);
    },

    openModal(type, item) {
      this.selectedItem = item;
      console.log("KLIK MODAL");

      if (type === "detail") {
        this.modalTitle = "Detail Data";
      } else if (type === "print") {
        this.modalTitle = "Print Data";
      }

      this.showModal = true;
    },
    print() {
      window.open(
        `/print/rekammedis/rawat-jalan/rm1dot3/${this.selectedPatient.uuid}`,
        "_blank"
      );
    },
    closeModal() {
      this.showModal = false;
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

.action-icon {
  cursor: pointer;
  font-size: 18px;
  margin: 0 6px;
  color: #356ead;
}

.action-icon:hover {
  color: #094a9c;
}

.action-icon {
  font-size: 20px;
  cursor: pointer;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.45);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-box {
  background: white;
  width: 90%;
  max-height: 80vh; /* 🔥 batas tinggi modal */
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.modal-header-rme {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 18px;
  background: #2b6cb0;
  color: white;
}

.close-btn {
  cursor: pointer;
  font-size: 22px;
  font-weight: bold;
}

.modal-content-rme {
  padding: 15px 18px;
  overflow-y: auto; /* 🔥 scroll jika content tinggi */
  flex: 1;
}

.modal-footer-rme {
  padding: 12px 18px;
  text-align: right;
  background: #f1f1f1;
}

.btn-close-rme {
  padding: 8px 14px;
  background: #2b6cb0;
  border: none;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.btn-close-rme:hover {
  background: #1a4f80;
}

.modal-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 15px;
  font-size: 14px;
}

.modal-table td,
.modal-table th {
  border: 1px solid #ccc;
  padding: 6px 10px;
}

.modal-table th {
  background: #f4f4f4;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}
</style>
