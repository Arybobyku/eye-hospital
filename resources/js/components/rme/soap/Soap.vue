<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- HEADER -->
    <div class="header-component-rme">Riwayat SOAP dan Diagnosa</div>

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
          <th>REG</th>
          <th>REKAM MEDIS</th>
          <th>TGL MASUK</th>
          <th>DOKTER</th>
          <th>ACTION</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(item, index) in paginatedData" :key="item.id">
          <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
          <td>{{ item?.registrasi?.nomor }}</td>
          <td>{{ item?.rekam_medis }}</td>
          <td>{{ item?.registrasi?.tanggal }}</td>
          <td>{{ item?.nama_dokter }}</td>
          <!-- ACTION -->
          <td class="text-center">
            <!-- icon lihat -->
            <i class="fas fa-book action-icon" @click="openModal('detail', item)"></i>

            <!-- icon print -->
            <i class="fas fa-print action-icon" @click="print('print', item)"></i>
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

  <!-- Modal Print-->
  <!-- Modal SOAP -->
  <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
    <div class="modal-box">
      <div class="modal-header-rme">
        <h3>{{ modalTitle }}</h3>
        <span class="close-btn" @click="closeModal">&times;</span>
      </div>

      <div class="modal-content-rme">
        <h4>Detail</h4>
        <table class="modal-table">
          <tr>
            <td><strong>Tanggal</strong></td>
            <td>{{ formatDate(selectedItem?.created_at) }}</td>
          </tr>
          <tr>
            <td><strong>Nama Dokter</strong></td>
            <td>{{ selectedItem?.nama_dokter }}</td>
          </tr>
        </table>

        <h4 class="mb-2"><strong>Pemeriksaan Mata</strong></h4>
        <table class="modal-table">
          <tr>
            <th colspan="2" class="text-center">Ocular Dextra (OD) – Mata Kanan</th>
          </tr>
          <tr>
            <td>Palpebra</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_palpebra }}</td>
          </tr>
          <tr>
            <td>Conjunctiva</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_conjunctiva }}</td>
          </tr>
          <tr>
            <td>Cornea</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_cornea }}</td>
          </tr>
          <tr>
            <td>Bilik Mata Depan</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_bilik_mata_depan }}</td>
          </tr>
          <tr>
            <td>Pupil dan Iris</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_pupil_dan_iris }}</td>
          </tr>
          <tr>
            <td>Lensa</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_lensa }}</td>
          </tr>
          <tr>
            <td>Vitreous</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_vitreous }}</td>
          </tr>
          <tr>
            <td>Funduscopy</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_funduscopy }}</td>
          </tr>
        </table>

        <br />

        <table class="modal-table">
          <tr>
            <th colspan="2" class="text-center">Ocular Sinistra (OS) – Mata Kiri</th>
          </tr>
          <tr>
            <td>Palpebra</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_palpebra }}</td>
          </tr>
          <tr>
            <td>Conjunctiva</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_conjunctiva }}</td>
          </tr>
          <tr>
            <td>Cornea</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_cornea }}</td>
          </tr>
          <tr>
            <td>Bilik Mata Depan</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_bilik_mata_depan }}</td>
          </tr>
          <tr>
            <td>Pupil dan Iris</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_pupil_dan_iris }}</td>
          </tr>
          <tr>
            <td>Lensa</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_lensa }}</td>
          </tr>
          <tr>
            <td>Vitreous</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_vitreous }}</td>
          </tr>
          <tr>
            <td>Funduscopy</td>
            <td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_funduscopy }}</td>
          </tr>
        </table>
        <h4>Subject</h4>
        <ckeditor
          v-model="selectedItem.subjek"
          :editor="ClassicEditor"
          @ready="onReady"
        ></ckeditor>

        <h4>Object</h4>
        <ckeditor
          v-model="selectedItem.objek"
          :editor="ClassicEditor"
          @ready="onReady"
        ></ckeditor>

        <h4>Assessment</h4>
        <ckeditor
          v-model="selectedItem.asesmen"
          :editor="ClassicEditor"
          @ready="onReady"
        ></ckeditor>

        <h4>Plan</h4>
        <ckeditor
          v-model="selectedItem.plan"
          :editor="ClassicEditor"
          @ready="onReady"
        ></ckeditor>

        <h4>Tanda Tangan</h4>
        <div v-if="selectedItem.ttd" style="margin-top: 8px;">
          <img :src="selectedItem.ttd" alt="Tanda Tangan Dokter"
               style="height:100px; max-width:100%; border:1px solid #ccc; border-radius:4px;" />
        </div>
        <div v-else style="color:#999; font-size:13px; margin-top:8px;">Tidak ada tanda tangan</div>
      </div>

      <div class="modal-footer-rme">
        <button class="btn-close" @click="closeModal">Close</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  name: "HistoryKunjungan",

  data() {
    return {
      ClassicEditor,
      showModal: false,
      selectedItem: null,
      modalTitle: "",
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      loading: false, // Loading indicator
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
        if (newVal?.uuid) {
          this.fetchHistory();
        }
      },
    },
  },
  components: {
    ckeditor: CKEditor.component,
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

        const res = await axios.post("/master/pasien/soap", formData, {
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

    openModal(type, item) {
      this.selectedItem = item;

      if (type === "detail") {
        this.modalTitle = "Detail Data";
      } else if (type === "print") {
        this.modalTitle = "Print Data";
      }

      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    print(){
        window.open(`/print/rekammedis/rawat-jalan/cpptpoli/${this.selectedPatient.uuid}`, "_blank");
    },
    onReady(editor) {
      // Cara resmi CKEditor 5 untuk read-only
      editor.enableReadOnlyMode("soap-view-mode");
    },
    formatDate(dateString) {
      const d = new Date(dateString);

      const day = String(d.getDate()).padStart(2, "0");
      const month = String(d.getMonth() + 1).padStart(2, "0");
      const year = d.getFullYear();

      const hours = String(d.getHours()).padStart(2, "0");
      const minutes = String(d.getMinutes()).padStart(2, "0");

      return `${day}-${month}-${year} ${hours}:${minutes}`;
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

.soap-box {
  background: #e9e9eb; /* abu-abu seperti gambar */
  border: 1px solid #d3d3d3;
  padding: 15px;
  border-radius: 4px;
  min-height: 120px; /* tinggi minimum kotak */
  margin-bottom: 20px; /* jarak antar kotak */
  overflow-x: auto;
}

@keyframes spin-rme {
  to {
    transform: rotate(360deg);
  }
}
</style>
