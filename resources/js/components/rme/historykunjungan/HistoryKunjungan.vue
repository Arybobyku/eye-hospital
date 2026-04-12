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
          <td>{{ formatDate(item.tanggal) }}</td>
          <td>{{ formatTime(item.waktu) }}</td>
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

    <!-- SECTION DOKUMEN PASIEN -->
    <div class="section-wrapper" style="margin-top: 30px;">
      <!-- LOADING OVERLAY -->
      <div v-if="loadingDokumen" class="loading-overlay">
        <div class="spinner-rme"></div>
        Loading...
      </div>

      <!-- HEADER -->
      <div class="header-component-rme">Dokumen Pasien</div>

      <!-- BUTTON TAMBAH -->
      <div class="action-bar">
        <button @click="openAddModal" class="btn-add">
          <span>+</span> Tambah Dokumen
        </button>
      </div>
      <div class="filter-left">
        Tampil
        <select v-model="perPageDokumen">
          <option v-for="n in [10, 25, 50, 100]" :key="n">{{ n }}</option>
        </select>
        data
      </div>

      <!-- TABLE DOKUMEN -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th>NO</th>
            <th>JENIS DOKUMEN</th>
            <th>NAMA FILE</th>
            <th>KETERANGAN</th>
            <th>TANGGAL UPLOAD</th>
            <th>DIUPLOAD OLEH</th>
            <th>VERIFIKASI</th>
            <th>ACTION</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="dataDokumen.length === 0">
            <td colspan="8" style="text-align: center; padding: 20px;">
              Belum ada dokumen
            </td>
          </tr>
          <tr v-for="(item, index) in paginatedDokumen" :key="item.uuid">
            <td>{{ index + 1 + (currentPageDokumen - 1) * perPageDokumen }}</td>
            <td>{{ item.jenis_dokumen }}</td>
            <td>
              <a @click.prevent="openFilePreview(item)" class="file-link">
                {{ item.nama_file }}
              </a>
            </td>
            <td>{{ item.keterangan || '-' }}</td>
            <td>{{ formatDate(item.tanggal_upload) }} {{ formatTime(item.waktu_upload) }}</td>
            <td>{{ item.uploaded_by_nama }}</td>
            <td>
              <span v-if="item.is_verified" class="badge-verified">Terverifikasi</span>
              <button
                v-else-if="isSuperAdmin"
                @click="verifyDocument(item)"
                class="btn-verify"
              >
                Verifikasi
              </button>
              <span v-else class="badge-unverified">Belum Diverifikasi</span>
            </td>
            <td>
              <div v-if="!item.is_verified" class="action-buttons">
                <button @click="openEditModal(item)" class="btn-edit">Edit</button>
                <button @click="deleteDocument(item)" class="btn-delete">Hapus</button>
              </div>
              <span v-else class="text-muted">-</span>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ startRowDokumen }} s/d {{ endRowDokumen }} dari {{ dataDokumen.length }} data
      </div>

      <!-- PAGINATION -->
      <div class="pagination-rme" v-if="totalPagesDokumen > 1">
        <button :disabled="currentPageDokumen === 1" @click="currentPageDokumen--">Previous</button>

        <button
          v-for="page in totalPagesDokumen"
          :key="page"
          :class="['page-btn', { active: currentPageDokumen === page }]"
          @click="currentPageDokumen = page"
        >
          {{ page }}
        </button>

        <button :disabled="currentPageDokumen === totalPagesDokumen" @click="currentPageDokumen++">Next</button>
      </div>
    </div>

    <!-- MODAL PREVIEW FILE -->
    <div v-if="showFileModal" class="modal-overlay" @click.self="showFileModal = false">
      <div class="modal-content modal-preview">
        <div class="modal-header">
          <h3 style="font-size:15px; max-width:80%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            {{ previewItem && previewItem.nama_file }}
          </h3>
          <div style="display:flex; gap:8px; align-items:center;">
            <button @click="openInNewTab" class="btn-open-tab" title="Buka di tab baru">
              <i class="fas fa-external-link-alt"></i> Buka
            </button>
            <button @click="showFileModal = false" class="btn-close">×</button>
          </div>
        </div>
        <div class="modal-body preview-body">
          <!-- Gambar -->
          <img
            v-if="previewItem && isImageFile(previewItem.nama_file)"
            :src="previewFileUrl"
            class="preview-image"
            alt="Preview"
          />
          <!-- PDF -->
          <iframe
            v-else-if="previewItem && isPdfFile(previewItem.nama_file)"
            :src="previewFileUrl"
            class="preview-iframe"
            frameborder="0"
          ></iframe>
          <!-- Tidak dikenal -->
          <div v-else class="preview-unsupported">
            <i class="fas fa-file fa-4x" style="color:#ccc;"></i>
            <p style="margin-top:12px; color:#666;">
              Format file tidak dapat ditampilkan secara langsung.
            </p>
            <button @click="openInNewTab" class="btn-primary" style="margin-top:8px;">
              Buka File
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL ADD/EDIT DOKUMEN -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>{{ isEditMode ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h3>
          <button @click="closeModal" class="btn-close">×</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Jenis Dokumen <span class="required">*</span></label>
            <select v-model="form.jenis_dokumen" class="form-control">
              <option value="">-- Pilih Jenis Dokumen --</option>
              <option value="Pemeriksaan Penunjang Mata">Pemeriksaan Penunjang Mata</option>
              <option value="Laboratorium">Laboratorium</option>
              <option value="Radiologi">Radiologi</option>
            </select>
          </div>

          <div class="form-group">
            <label>File <span class="required">*</span></label>
            <input
              type="file"
              @change="handleFileChange"
              accept=".pdf,.bmp,.jpg,.jpeg,.png"
              class="form-control"
            />
            <small class="form-text">
              Max 1 MB. Format: PDF, BMP, JPG, JPEG, PNG
            </small>
            <div v-if="isEditMode && form.nama_file" class="current-file">
              File saat ini: <strong>{{ form.nama_file }}</strong>
            </div>
          </div>

          <div class="form-group">
            <label>Keterangan</label>
            <textarea
              v-model="form.keterangan"
              class="form-control"
              rows="3"
              placeholder="Masukkan keterangan dokumen (opsional)"
            ></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button @click="closeModal" class="btn-secondary">Batal</button>
          <button @click="submitForm" class="btn-primary" :disabled="!isFormValid">
            {{ isEditMode ? 'Update' : 'Simpan' }}
          </button>
        </div>
      </div>
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
      loading: false,
      data: [],
      perPageDokumen: 10,
      currentPageDokumen: 1,
      loadingDokumen: false,
      dataDokumen: [],
      showModal: false,
      isEditMode: false,
      form: {
        uuid: null,
        jenis_dokumen: '',
        file: null,
        nama_file: '',
        keterangan: ''
      },
      isSuperAdmin: false,
      showFileModal: false,
      previewItem: null,
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
          this.fetchDokumen();
          this.checkUserRole();
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

    totalPagesDokumen() {
      return Math.ceil(this.dataDokumen.length / this.perPageDokumen);
    },

    paginatedDokumen() {
      const start = (this.currentPageDokumen - 1) * this.perPageDokumen;
      return this.dataDokumen.slice(start, start + this.perPageDokumen);
    },

    startRowDokumen() {
      return this.dataDokumen.length === 0 ? 0 : (this.currentPageDokumen - 1) * this.perPageDokumen + 1;
    },

    endRowDokumen() {
      const end = this.currentPageDokumen * this.perPageDokumen;
      return end > this.dataDokumen.length ? this.dataDokumen.length : end;
    },

    isFormValid() {
      if (this.isEditMode) {
        return this.form.jenis_dokumen !== '';
      }
      return this.form.jenis_dokumen !== '' && this.form.file !== null;
    },
    previewFileUrl() {
      if (!this.previewItem) return '';
      return `/print/rekammedis/dokumen/${this.previewItem.uuid}`;
    },
  },

  methods: {
    // Format Date: 2026-01-17 00:00:00 → 2026-01-17
    formatDate(datetime) {
      if (!datetime) return '-';
      return datetime.substring(0, 10);
    },

    // Format Time: 20:11:00 → 20:11
    formatTime(time) {
      if (!time) return '-';
      return time.substring(0, 5);
    },

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

        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat history:", err);
        alert("Gagal memuat data history.");
      } finally {
        this.loading = false;
      }
    },

    mappedStatus(data) {
      if (data?.status_ro != 'Sudah Diperiksa') {
        return 'Pemriksasan Refraksi Optisi';
      }
      if (data?.status_dokter != 'Sudah Diperiksa') {
        return 'Pemriksasan Dokter';
      }
      if (data?.status_dokter != 'Sudah Bayar') {
        return 'Farmasi';
      }
      if (data?.status_dokter != 'Sudah Bayar') {
        return 'Kasir';
      }

      return 'Selesai';
    },

    async fetchDokumen() {
      this.loadingDokumen = true;
      try {
        const formData = new FormData();
        formData.append("search", this.selectedPatient.uuid);
        formData.append("limit", 100);
        formData.append("page", 1);

        const res = await axios.post("/master/pasien/dokumen-list", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        this.dataDokumen = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat dokumen:", err);
        alert("Gagal memuat data dokumen.");
      } finally {
        this.loadingDokumen = false;
      }
    },

    async checkUserRole() {
      try {
        const res = await axios.get("/master/pasien/user-info");

        console.log('👤 User Info:', res.data);

        if (res.data.success) {
          this.isSuperAdmin = res.data.is_super_admin;
          console.log('🔐 Is Super Admin:', this.isSuperAdmin);
        } else {
          this.isSuperAdmin = false;
        }

      } catch (err) {
        console.error("Gagal cek role user:", err);
        this.isSuperAdmin = false;
      }
    },

    openAddModal() {
      this.isEditMode = false;
      this.resetForm();
      this.showModal = true;
    },

    openEditModal(item) {
      this.isEditMode = true;
      this.form = {
        uuid: item.uuid,
        jenis_dokumen: item.jenis_dokumen,
        file: null,
        nama_file: item.nama_file,
        keterangan: item.keterangan
      };
      this.showModal = true;
    },

    closeModal() {
      this.showModal = false;
      this.resetForm();
    },

    resetForm() {
      this.form = {
        uuid: null,
        jenis_dokumen: '',
        file: null,
        nama_file: '',
        keterangan: ''
      };
    },

    handleFileChange(event) {
      const file = event.target.files[0];
      if (!file) return;

      if (file.size > 1024 * 1024) {
        alert("Ukuran file maksimal 1 MB!");
        event.target.value = '';
        return;
      }

      const allowedTypes = ['application/pdf', 'image/bmp', 'image/jpeg', 'image/jpg', 'image/png'];
      if (!allowedTypes.includes(file.type)) {
        alert("Format file harus PDF, BMP, JPG, JPEG, atau PNG!");
        event.target.value = '';
        return;
      }

      this.form.file = file;
    },

    async submitForm() {
      if (!this.isFormValid) return;

      this.loadingDokumen = true;

      try {
        const formData = new FormData();
        formData.append("pasien_uuid", this.selectedPatient.uuid);
        formData.append("jenis_dokumen", this.form.jenis_dokumen);
        formData.append("keterangan", this.form.keterangan || '');

        if (this.isEditMode) {
          formData.append("uuid", this.form.uuid);
          if (this.form.file) {
            formData.append("file", this.form.file);
          }

          await axios.post("/master/pasien/dokumen-update", formData, {
            headers: { "Content-Type": "multipart/form-data" },
          });

          alert("Dokumen berhasil diupdate!");
        } else {
          formData.append("file", this.form.file);

          await axios.post("/master/pasien/dokumen-store", formData, {
            headers: { "Content-Type": "multipart/form-data" },
          });

          alert("Dokumen berhasil diupload!");
        }

        this.closeModal();
        this.fetchDokumen();
      } catch (err) {
        console.error("Error:", err);
        const errorMsg = err.response?.data?.message || "Gagal menyimpan dokumen";
        alert(errorMsg);
      } finally {
        this.loadingDokumen = false;
      }
    },

    async deleteDocument(item) {
      if (!confirm(`Yakin ingin menghapus dokumen "${item.nama_file}"?`)) return;

      this.loadingDokumen = true;

      try {
        const formData = new FormData();
        formData.append("uuid", item.uuid);

        await axios.post("/master/pasien/dokumen-delete", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        alert("Dokumen berhasil dihapus!");
        this.fetchDokumen();
      } catch (err) {
        console.error("Error:", err);
        const errorMsg = err.response?.data?.message || "Gagal menghapus dokumen";
        alert(errorMsg);
      } finally {
        this.loadingDokumen = false;
      }
    },

    async verifyDocument(item) {
      if (!confirm(`Verifikasi dokumen "${item.nama_file}"?`)) return;

      this.loadingDokumen = true;

      try {
        const formData = new FormData();
        formData.append("uuid", item.uuid);

        await axios.post("/master/pasien/dokumen-verify", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        alert("Dokumen berhasil diverifikasi!");
        this.fetchDokumen();
      } catch (err) {
        console.error("Error:", err);
        const errorMsg = err.response?.data?.message || "Gagal memverifikasi dokumen";
        alert(errorMsg);
      } finally {
        this.loadingDokumen = false;
      }
    },

    openFilePreview(item) {
      this.previewItem = item;
      this.showFileModal = true;
    },
    openInNewTab() {
      if (!this.previewItem) return;
      window.open(`/print/rekammedis/dokumen/${this.previewItem.uuid}`, '_blank');
    },
    isImageFile(filename) {
      if (!filename) return false;
      return /\.(jpg|jpeg|png|bmp|gif|webp)$/i.test(filename);
    },
    isPdfFile(filename) {
      if (!filename) return false;
      return /\.pdf$/i.test(filename);
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

.section-wrapper {
  background: white;
  padding: 15px;
  border-radius: 5px;
  border: 1px solid #ddd;
  position: relative;
}

.action-bar {
  margin-bottom: 15px;
  text-align: right;
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
}

.btn-add:hover {
  background: #218838;
}

.btn-add span {
  font-size: 18px;
  margin-right: 5px;
}

.file-link {
  color: #0066cc;
  cursor: pointer;
  text-decoration: underline;
}

.file-link:hover {
  color: #004499;
}

.badge-verified {
  background: #28a745;
  color: white;
  padding: 4px 10px;
  border-radius: 3px;
  font-size: 12px;
  display: inline-block;
}

.badge-unverified {
  background: #ffc107;
  color: #333;
  padding: 4px 10px;
  border-radius: 3px;
  font-size: 12px;
  display: inline-block;
}

.btn-verify {
  background: #007bff;
  color: white;
  border: none;
  padding: 4px 12px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}

.btn-verify:hover {
  background: #0056b3;
}

.action-buttons {
  display: flex;
  gap: 5px;
}

.btn-edit {
  background: #ffc107;
  color: #333;
  border: none;
  padding: 4px 12px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}

.btn-edit:hover {
  background: #e0a800;
}

.btn-delete {
  background: #dc3545;
  color: white;
  border: none;
  padding: 4px 12px;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
}

.btn-delete:hover {
  background: #c82333;
}

.text-muted {
  color: #999;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 8px;
  width: 90%;
  max-width: 600px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #ddd;
}

.modal-header h3 {
  margin: 0;
  font-size: 18px;
}

.btn-close {
  background: none;
  border: none;
  font-size: 28px;
  cursor: pointer;
  color: #999;
}

.btn-close:hover {
  color: #333;
}

.modal-body {
  padding: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  font-size: 14px;
}

.required {
  color: red;
}

.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.form-text {
  display: block;
  margin-top: 5px;
  font-size: 12px;
  color: #666;
}

.current-file {
  margin-top: 8px;
  padding: 8px;
  background: #f0f0f0;
  border-radius: 4px;
  font-size: 13px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  padding: 15px 20px;
  border-top: 1px solid #ddd;
}

.btn-secondary {
  background: #6c757d;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-secondary:hover {
  background: #5a6268;
}

.btn-primary {
  background: #007bff;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary:hover {
  background: #0056b3;
}

.btn-primary:disabled {
  background: #ccc;
  cursor: not-allowed;
}

/* Preview modal */
.modal-preview {
  max-width: 900px;
  width: 95vw;
  max-height: 92vh;
  display: flex;
  flex-direction: column;
}
.preview-body {
  flex: 1;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 12px;
  background: #f5f5f5;
  min-height: 500px;
}
.preview-image {
  max-width: 100%;
  max-height: 70vh;
  object-fit: contain;
  border-radius: 4px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.15);
}
.preview-iframe {
  width: 100%;
  height: 70vh;
  border: none;
  border-radius: 4px;
}
.preview-unsupported {
  text-align: center;
  padding: 40px;
}
.btn-open-tab {
  background: #17a2b8;
  color: white;
  border: none;
  padding: 5px 12px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
}
.btn-open-tab:hover {
  background: #138496;
}
</style>
