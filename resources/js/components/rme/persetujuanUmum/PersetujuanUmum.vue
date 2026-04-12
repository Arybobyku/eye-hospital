<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>
    <div v-if="state == 'list'">
    <!-- HEADER -->


    <div class="header-component-rme">Persetujuan Umum (General Consent)</div>

    <ButtonTambah  @click="onAdd" />
    <!-- <button class="btn-add" @click="onAdd">+ s</button> -->


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
        <tr v-for="(item, index) in paginatedData" :key="item.id">
          <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.nama_pasien }}</td>
          <td>{{ item.jenis_kelamin }}</td>
          <td>{{ item.nik }}</td>
          <td>{{ item.nama_pemberi_informasi }}</td>
          <td class="action-buttons">
            <i class="fa fa-bookmark action-icon icon-edit" @click="editItem(item)"></i>
            <i class="fa fa-times action-icon icon-delete" @click="deleteItem(item)"></i>
            <i class="fa fa-print action-icon icon-print" @click="print(item)"></i>
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

      <button :disabled="currentPage === totalPages" @click="currentPage++">Next</button>
    </div>
  </div>
    <!-- Create Data -->
  <div v-if="state == 'create'">
    <CreatePersetujuanUmum @back="state = 'list'" :selectedPatient="selectedPatient" />
  </div>
  </div>

</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";
import ButtonTambah from '../components/ButtonTambah.vue'
// import CreatePersetujuanUmum from "./CreatePersetujuanUmum.vue";
export default {
  name: "HistoryKunjungan",
  components: { ButtonTambah,
    CreatePersetujuanUmum: defineAsyncComponent(() =>
      import("./CreatePersetujuanUmum.vue")
    ),
   },

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      state: "list",
      loading: false, // Loading indicator
      data: [
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

        const res = await axios.post("/master/pasien/list-dokumen-persetujuan-umum", formData, {
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

    editItem(item) {
      console.log("Edit:", item)
      // buka modal atau pindah halaman
      },
      deleteItem(item) {
        console.log("Delete:", item)
        // konfirmasi hapus
      },
      printItem(item) {
        console.log("Print:", item)
        // buka print atau cetakan PDF
      },
      onAdd() {
        this.state = "create";
        this.$emit("set-breadcrumb", {
            docName: "Form Persetujuan"
        });
        console.log("TAMBAH");
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

    print(item) {
      window.open(
        `/print/rekammedis/rawat-jalan/general/`+item.uuid,
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
.action-buttons {
  display: flex;
  align-items: center;
  gap: 12px;
  justify-content: center;
}

.action-icon {
  cursor: pointer;
  font-size: 20px;
}

/* warna sesuai gambar */
.icon-edit {
  color: #5cb85c;   /* hijau */
}

.icon-delete {
  color: #d9534f;   /* merah */
}

.icon-print {
  color: #0275d8;   /* biru */
}

.action-icon:hover {
  opacity: 0.7;
}

</style>
