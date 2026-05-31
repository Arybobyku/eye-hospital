<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- ============ SOAP TABLE ============ -->
    <div class="header-component-rme">Riwayat SOAP dan Diagnosa</div>

    <div class="action-bar">
      <button @click="openCreateModal" class="btn-add">
        <span>+</span> Tambah CPPT &amp; SOAP
      </button>
      <button @click="showAllCppt = true" class="btn-view-all-cppt">
        <i class="fas fa-list" style="margin-right:5px;"></i> View All CPPT
      </button>
    </div>

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

    <table class="custom-table-rme">
      <thead>
        <tr>
          <th>NO</th>
          <!-- <th>REG</th> -->
          <th>REKAM MEDIS</th>
          <th>TGL MASUK</th>
          <th>SEBAGAI</th>
          <th>DOKTER</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in paginatedData" :key="item.id">
          <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
          <!-- <td>{{ item?.registrasi?.nomor }}</td> -->
          <td>{{ item?.rekam_medis }}</td>
          <td>{{ item?.registrasi?.tanggal }}</td>
          <td>{{ item?.sebagai }}</td>
          <td>{{ item?.nama_dokter }}</td>
          <td class="text-center">
            <i class="fas fa-book action-icon" @click="openModal('detail', item)"></i>
            <i class="fas fa-print action-icon" @click="print('print', item)"></i>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="table-info">
      Menampilkan {{ startRow }} s/d {{ endRow }} dari {{ data.length }} data
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

    <!-- ============ DOKUMEN PASIEN ============ -->
    <div class="section-wrapper" style="margin-top: 30px; position: relative;">
      <div v-if="loadingDokumen" class="loading-overlay">
        <div class="spinner-rme"></div>
        Loading...
      </div>

      <div class="header-component-rme">Dokumen Pasien</div>

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

      <table class="custom-table-rme" style="margin-top: 8px;">
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
            <td colspan="8" style="text-align:center; padding:20px;">Belum ada dokumen</td>
          </tr>
          <tr v-for="(item, index) in paginatedDokumen" :key="item.uuid">
            <td>{{ index + 1 + (currentPageDokumen - 1) * perPageDokumen }}</td>
            <td>{{ item.jenis_dokumen }}</td>
            <td>
              <a @click.prevent="openFilePreview(item)" class="file-link">{{ item.nama_file }}</a>
            </td>
            <td>{{ item.keterangan || '-' }}</td>
            <td>{{ formatDate(item.tanggal_upload) }} {{ formatTimeShort(item.waktu_upload) }}</td>
            <td>{{ item.uploaded_by_nama }}</td>
            <td>
              <span v-if="item.is_verified" class="badge-verified">Terverifikasi</span>
              <button v-else-if="isSuperAdmin" @click="verifyDocument(item)" class="btn-verify">Verifikasi</button>
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

      <div class="table-info">
        Menampilkan {{ startRowDokumen }} s/d {{ endRowDokumen }} dari {{ dataDokumen.length }} data
      </div>

      <div class="pagination-rme" v-if="totalPagesDokumen > 1">
        <button :disabled="currentPageDokumen === 1" @click="currentPageDokumen--">Previous</button>
        <button
          v-for="page in totalPagesDokumen"
          :key="page"
          :class="['page-btn', { active: currentPageDokumen === page }]"
          @click="currentPageDokumen = page"
        >{{ page }}</button>
        <button :disabled="currentPageDokumen === totalPagesDokumen" @click="currentPageDokumen++">Next</button>
      </div>
    </div>
  </div>

  <!-- ============ MODAL VIEW ALL CPPT (iframe) ============ -->
  <div
    v-if="showAllCppt"
    style="position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:99998;display:flex;align-items:center;justify-content:center;"
    @click.self="showAllCppt = false"
  >
    <div style="background:#fff;border-radius:10px;box-shadow:0 6px 32px rgba(0,0,0,0.22);width:92%;max-width:1150px;height:88vh;display:flex;flex-direction:column;overflow:hidden;">
      <!-- Header -->
      <div style="display:flex;align-items:center;justify-content:space-between;padding:13px 20px;background:#1a6f1d;border-radius:10px 10px 0 0;flex-shrink:0;">
        <span style="color:#fff;font-weight:700;font-size:15px;">
          <i class="fas fa-list" style="margin-right:7px;"></i>
          Semua CPPT — {{ selectedPatient.nama_pasien || selectedPatient.nama || '' }}
        </span>
        <span @click="showAllCppt = false" style="color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0 4px;">&times;</span>
      </div>
      <!-- Body: iframe -->
      <div style="flex:1;overflow:hidden;">
        <iframe
          title="All CPPT"
          width="100%"
          height="100%"
          style="border:0;display:block;"
          :src="'/print/rekammedis/rawat-jalan/cpptpoli/' + selectedPatient.uuid"
        ></iframe>
      </div>
    </div>
  </div>

  <!-- ============ MODAL CREATE CPPT & SOAP ============ -->
  <div v-if="showCreateModal" class="modal-overlay" @click.self="closeCreateModal">
    <div class="modal-content-dokumen" style="max-width: 680px;">
      <div class="modal-header-dokumen">
        <h3>Tambah CPPT &amp; SOAP</h3>
        <button @click="closeCreateModal" class="btn-close-x">×</button>
      </div>
      <div class="modal-body-dokumen">

        <!-- Loading overlay -->
        <div v-if="loadingCreate" style="text-align:center; padding: 30px 0;">
          <div class="spinner-rme" style="margin: 0 auto 10px;"></div>
          Memuat...
        </div>

        <template v-else>
          <!-- Pilih Registrasi -->
          <div class="form-group-dokumen">
            <label>Pilih Tanggal Registrasi <span style="color:red;">*</span></label>
            <select v-model="formCreate.registrasi_uuid" class="form-control-dokumen">
              <option value="">-- Pilih Kunjungan --</option>
              <option
                v-for="reg in registrasiOptions"
                :key="reg.uuid"
                :value="reg.uuid"
              >
                {{ reg.tanggal }} — {{ reg.no_pendaftaran }}
                <template v-if="reg.nama_dokter"> · {{ reg.nama_dokter }}</template>
              </option>
            </select>
          </div>

          <!-- Subject -->
          <div class="form-group-dokumen">
            <label>Subject (Subjek)</label>
            <textarea
              v-model="formCreate.subjek"
              class="form-control-dokumen"
              rows="3"
              placeholder="Keluhan / anamnesa pasien..."
            ></textarea>
          </div>

          <!-- Object -->
          <div class="form-group-dokumen">
            <label>Object (Objek)</label>
            <textarea
              v-model="formCreate.objek"
              class="form-control-dokumen"
              rows="3"
              placeholder="Pemeriksaan fisik / hasil objektif..."
            ></textarea>
          </div>

          <!-- Assessment -->
          <div class="form-group-dokumen">
            <label>Assessment (Asesmen)</label>
            <textarea
              v-model="formCreate.asesmen"
              class="form-control-dokumen"
              rows="3"
              placeholder="Diagnosis / penilaian klinis..."
            ></textarea>
          </div>

          <!-- Planning -->
          <div class="form-group-dokumen">
            <label>Planning (Plan)</label>
            <textarea
              v-model="formCreate.plan"
              class="form-control-dokumen"
              rows="3"
              placeholder="Rencana tindakan / terapi..."
            ></textarea>
          </div>
        </template>
      </div>
      <div class="modal-footer-dokumen">
        <button @click="closeCreateModal" class="btn-secondary-dokumen">Batal</button>
        <button
          @click="submitCreateForm"
          class="btn-primary-dokumen"
          :disabled="!formCreate.registrasi_uuid || loadingCreate || submittingCreate"
        >
          {{ submittingCreate ? 'Menyimpan...' : 'Simpan' }}
        </button>
      </div>
    </div>
  </div>

  <!-- ============ MODAL SOAP DETAIL ============ -->
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
          <tr><th colspan="2" class="text-center">Ocular Dextra (OD) – Mata Kanan</th></tr>
          <tr><td>Palpebra</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_palpebra }}</td></tr>
          <tr><td>Conjunctiva</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_conjunctiva }}</td></tr>
          <tr><td>Cornea</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_cornea }}</td></tr>
          <tr><td>Bilik Mata Depan</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_bilik_mata_depan }}</td></tr>
          <tr><td>Pupil dan Iris</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_pupil_dan_iris }}</td></tr>
          <tr><td>Lensa</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_lensa }}</td></tr>
          <tr><td>Vitreous</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_vitreous }}</td></tr>
          <tr><td>Funduscopy</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_dextra_funduscopy }}</td></tr>
        </table>
        <br />
        <table class="modal-table">
          <tr><th colspan="2" class="text-center">Ocular Sinistra (OS) – Mata Kiri</th></tr>
          <tr><td>Palpebra</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_palpebra }}</td></tr>
          <tr><td>Conjunctiva</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_conjunctiva }}</td></tr>
          <tr><td>Cornea</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_cornea }}</td></tr>
          <tr><td>Bilik Mata Depan</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_bilik_mata_depan }}</td></tr>
          <tr><td>Pupil dan Iris</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_pupil_dan_iris }}</td></tr>
          <tr><td>Lensa</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_lensa }}</td></tr>
          <tr><td>Vitreous</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_vitreous }}</td></tr>
          <tr><td>Funduscopy</td><td>{{ selectedItem?.pemeriksaan_dokter?.ocular_sinistra_funduscopy }}</td></tr>
        </table>

        <h4>Subject</h4>
        <ckeditor v-model="selectedItem.subjek" :editor="ClassicEditor" @ready="onReady"></ckeditor>
        <h4>Object</h4>
        <ckeditor v-model="selectedItem.objek" :editor="ClassicEditor" @ready="onReady"></ckeditor>
        <h4>Assessment</h4>
        <ckeditor v-model="selectedItem.asesmen" :editor="ClassicEditor" @ready="onReady"></ckeditor>
        <h4>Plan</h4>
        <ckeditor v-model="selectedItem.plan" :editor="ClassicEditor" @ready="onReady"></ckeditor>

        <h4>Tanda Tangan</h4>
        <div v-if="selectedItem.ttd" style="margin-top:8px;">
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

  <!-- ============ MODAL PREVIEW FILE ============ -->
  <div v-if="showFileModal" class="modal-overlay" @click.self="showFileModal = false">
    <div class="modal-content-dokumen modal-preview">
      <div class="modal-header-dokumen">
        <h3 style="font-size:15px; max-width:80%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
          {{ previewItem && previewItem.nama_file }}
        </h3>
        <div style="display:flex; gap:8px; align-items:center;">
          <button @click="openInNewTab" class="btn-open-tab" title="Buka di tab baru">
            <i class="fas fa-external-link-alt"></i> Buka
          </button>
          <button @click="showFileModal = false" class="btn-close-x">×</button>
        </div>
      </div>
      <div class="modal-body-dokumen preview-body">
        <!-- IMAGE: coba img (storage URL) dulu, fallback ke route backend via iframe jika gagal -->
        <template v-if="previewItem && isImageFile(previewItem.nama_file)">
          <img
            v-if="!imgLoadError"
            :src="previewFileUrl"
            class="preview-image"
            alt="Preview"
            @error="imgLoadError = true"
          />
          <iframe
            v-else
            :src="previewFileUrlFallback"
            class="preview-iframe"
            frameborder="0"
          ></iframe>
        </template>
        <!-- PDF -->
        <iframe
          v-else-if="previewItem && isPdfFile(previewItem.nama_file)"
          :src="previewFileUrl"
          class="preview-iframe"
          frameborder="0"
        ></iframe>
        <!-- FORMAT LAIN -->
        <div v-else class="preview-unsupported">
          <i class="fas fa-file fa-4x" style="color:#ccc;"></i>
          <p style="margin-top:12px; color:#666;">Format file tidak dapat ditampilkan secara langsung.</p>
          <button @click="openInNewTab" class="btn-primary-dokumen" style="margin-top:8px;">Buka File</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ============ MODAL TAMBAH / EDIT DOKUMEN ============ -->
  <div v-if="showDokumenModal" class="modal-overlay" @click.self="closeDokumenModal">
    <div class="modal-content-dokumen">
      <div class="modal-header-dokumen">
        <h3>{{ isEditMode ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h3>
        <button @click="closeDokumenModal" class="btn-close-x">×</button>
      </div>
      <div class="modal-body-dokumen">
        <div class="form-group-dokumen">
          <label>Jenis Dokumen <span style="color:red;">*</span></label>
          <select v-model="formDokumen.jenis_dokumen" class="form-control-dokumen">
            <option value="">-- Pilih Jenis Dokumen --</option>
            <option value="Pemeriksaan Penunjang Mata">Pemeriksaan Penunjang Mata</option>
            <option value="Laboratorium">Laboratorium</option>
            <option value="Radiologi">Radiologi</option>
          </select>
        </div>
        <div class="form-group-dokumen">
          <label>File <span style="color:red;">*</span></label>
          <input type="file" @change="handleFileChange" accept=".pdf,.bmp,.jpg,.jpeg,.png" class="form-control-dokumen" />
          <small style="display:block; margin-top:5px; font-size:12px; color:#666;">Max 1 MB. Format: PDF, BMP, JPG, JPEG, PNG</small>
          <div v-if="isEditMode && formDokumen.nama_file" style="margin-top:8px; padding:8px; background:#f0f0f0; border-radius:4px; font-size:13px;">
            File saat ini: <strong>{{ formDokumen.nama_file }}</strong>
          </div>
        </div>
        <div class="form-group-dokumen">
          <label>Keterangan</label>
          <textarea v-model="formDokumen.keterangan" class="form-control-dokumen" rows="3" placeholder="Masukkan keterangan dokumen (opsional)"></textarea>
        </div>
      </div>
      <div class="modal-footer-dokumen">
        <button @click="closeDokumenModal" class="btn-secondary-dokumen">Batal</button>
        <button @click="submitDokumenForm" class="btn-primary-dokumen" :disabled="!isDokumenFormValid">
          {{ isEditMode ? 'Update' : 'Simpan' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  name: "SoapCppt",

  components: {
    ckeditor: CKEditor.component,
  },

  data() {
    return {
      // ---- SOAP ----
      ClassicEditor,
      showModal: false,
      selectedItem: null,
      modalTitle: "",
      perPage: 10,
      currentPage: 1,
      searchQuery: "",
      loading: false,
      data: [],

      // ---- VIEW ALL CPPT ----
      showAllCppt: false,

      // ---- CREATE CPPT ----
      showCreateModal: false,
      loadingCreate: false,
      submittingCreate: false,
      registrasiOptions: [],
      formCreate: {
        registrasi_uuid: '',
        subjek: '',
        objek: '',
        asesmen: '',
        plan: '',
      },

      // ---- DOKUMEN ----
      perPageDokumen: 10,
      currentPageDokumen: 1,
      loadingDokumen: false,
      dataDokumen: [],
      showDokumenModal: false,
      isEditMode: false,
      formDokumen: {
        uuid: null,
        jenis_dokumen: '',
        file: null,
        nama_file: '',
        keterangan: '',
      },
      isSuperAdmin: false,

      // ---- FILE PREVIEW ----
      showFileModal: false,
      previewItem: null,
      imgLoadError: false,
    };
  },

  props: {
    selectedPatient: {
      type: Object,
      required: true,
    },
  },

  watch: {
    // Bandingkan UUID secara eksplisit — bukan referensi object.
    // Ini mencegah re-fetch setiap kali parent re-render (misal: saat mengetik form lain)
    // yang akan membuat object baru meskipun UUID-nya sama.
    'selectedPatient.uuid': {
      immediate: true,
      handler(newUuid, oldUuid) {
        if (newUuid && newUuid !== oldUuid) {
          this.fetchHistory();
          this.fetchDokumen();
          this.checkUserRole();
        }
      },
    },
  },

  computed: {
    // ---- SOAP computed ----
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
      return (this.currentPage - 1) * this.perPage + 1;
    },
    endRow() {
      const end = this.currentPage * this.perPage;
      return end > this.data.length ? this.data.length : end;
    },

    // ---- DOKUMEN computed ----
    totalPagesDokumen() {
      return Math.max(1, Math.ceil(this.dataDokumen.length / this.perPageDokumen));
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
    isDokumenFormValid() {
      if (this.isEditMode) return this.formDokumen.jenis_dokumen !== '';
      return this.formDokumen.jenis_dokumen !== '' && this.formDokumen.file !== null;
    },
    previewFileUrl() {
      if (!this.previewItem) return '';
      // Untuk gambar: gunakan URL storage publik langsung (tidak butuh auth, lebih reliable untuk <img>)
      if (this.isImageFile(this.previewItem.nama_file) && this.previewItem.file_path) {
        return `/storage/${this.previewItem.file_path}`;
      }
      // Untuk PDF dan file lain: gunakan route backend
      return `/print/rekammedis/dokumen/${this.previewItem.uuid}`;
    },
    // Fallback URL jika storage langsung gagal (gunakan route backend)
    previewFileUrlFallback() {
      if (!this.previewItem) return '';
      return `/print/rekammedis/dokumen/${this.previewItem.uuid}`;
    },
  },

  methods: {
    // ---- SOAP methods ----
    async fetchHistory() {
      this.loading = true;
      try {
        const formData = new FormData();
        formData.append("search", this.selectedPatient.uuid);
        formData.append("limit", 10);
        formData.append("page", 1);
        const res = await axios.post("/master/pasien/soap", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        this.data = res.data?.data ?? [];
      } catch (err) {
        console.error("Gagal memuat history:", err);
        alert("Gagal memuat data history.");
      } finally {
        this.loading = false;
      }
    },

    openModal(type, item) {
      this.selectedItem = item;
      this.modalTitle = type === "detail" ? "Detail Data" : "Print Data";
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    print() {
      window.open(`/print/rekammedis/rawat-jalan/cpptpoli/${this.selectedPatient.uuid}`, "_blank");
    },
    onReady(editor) {
      editor.enableReadOnlyMode("soap-view-mode");
    },
    formatDate(dateString) {
      if (!dateString) return '-';
      const d = new Date(dateString);
      const day   = String(d.getDate()).padStart(2, "0");
      const month = String(d.getMonth() + 1).padStart(2, "0");
      const year  = d.getFullYear();
      const hours = String(d.getHours()).padStart(2, "0");
      const mins  = String(d.getMinutes()).padStart(2, "0");
      return `${day}-${month}-${year} ${hours}:${mins}`;
    },
    formatTimeShort(time) {
      if (!time) return '-';
      return String(time).substring(0, 5);
    },

    // ---- CREATE CPPT methods ----
    async openCreateModal() {
      this.showCreateModal = true;
      this.loadingCreate = true;
      this.formCreate = { registrasi_uuid: '', subjek: '', objek: '', asesmen: '', plan: '' };
      try {
        const fd = new FormData();
        fd.append('pasien_uuid', this.selectedPatient.uuid);
        const res = await axios.post('/master/pasien/registrasi-list', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
        this.registrasiOptions = res.data?.data ?? [];
      } catch (err) {
        console.error('Gagal memuat daftar registrasi:', err);
        alert('Gagal memuat daftar kunjungan pasien.');
        this.showCreateModal = false;
      } finally {
        this.loadingCreate = false;
      }
    },

    closeCreateModal() {
      this.showCreateModal = false;
      this.formCreate = { registrasi_uuid: '', subjek: '', objek: '', asesmen: '', plan: '' };
    },

    async submitCreateForm() {
      if (!this.formCreate.registrasi_uuid) return;
      this.submittingCreate = true;
      try {
        const fd = new FormData();
        fd.append('pasien_uuid', this.selectedPatient.uuid);
        fd.append('registrasi_uuid', this.formCreate.registrasi_uuid);
        fd.append('subjek', this.formCreate.subjek);
        fd.append('objek', this.formCreate.objek);
        fd.append('asesmen', this.formCreate.asesmen);
        fd.append('plan', this.formCreate.plan);
        const res = await axios.post('/master/pasien/soap-store', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
        if (res.data?.data === 'berhasil') {
          alert('CPPT & SOAP berhasil ditambahkan!');
          this.closeCreateModal();
          this.fetchHistory();
        } else {
          alert('Gagal menyimpan data: ' + (res.data?.error ?? 'unknown error'));
        }
      } catch (err) {
        alert(err.response?.data?.message || err.response?.data?.error || 'Gagal menyimpan data.');
      } finally {
        this.submittingCreate = false;
      }
    },

    // ---- DOKUMEN methods ----
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
      } finally {
        this.loadingDokumen = false;
      }
    },

    async checkUserRole() {
      try {
        const res = await axios.get("/master/pasien/user-info");
        this.isSuperAdmin = res.data?.success ? res.data.is_super_admin : false;
      } catch (err) {
        this.isSuperAdmin = false;
      }
    },

    openAddModal() {
      this.isEditMode = false;
      this.resetDokumenForm();
      this.showDokumenModal = true;
    },
    openEditModal(item) {
      this.isEditMode = true;
      this.formDokumen = {
        uuid: item.uuid,
        jenis_dokumen: item.jenis_dokumen,
        file: null,
        nama_file: item.nama_file,
        keterangan: item.keterangan,
      };
      this.showDokumenModal = true;
    },
    closeDokumenModal() {
      this.showDokumenModal = false;
      this.resetDokumenForm();
    },
    resetDokumenForm() {
      this.formDokumen = { uuid: null, jenis_dokumen: '', file: null, nama_file: '', keterangan: '' };
    },

    handleFileChange(event) {
      const file = event.target.files[0];
      if (!file) return;
      if (file.size > 1024 * 1024) {
        alert("Ukuran file maksimal 1 MB!");
        event.target.value = '';
        return;
      }
      const allowed = ['application/pdf', 'image/bmp', 'image/jpeg', 'image/jpg', 'image/png'];
      if (!allowed.includes(file.type)) {
        alert("Format file harus PDF, BMP, JPG, JPEG, atau PNG!");
        event.target.value = '';
        return;
      }
      this.formDokumen.file = file;
    },

    async submitDokumenForm() {
      if (!this.isDokumenFormValid) return;
      this.loadingDokumen = true;
      try {
        const fd = new FormData();
        fd.append("pasien_uuid", this.selectedPatient.uuid);
        fd.append("jenis_dokumen", this.formDokumen.jenis_dokumen);
        fd.append("keterangan", this.formDokumen.keterangan || '');

        if (this.isEditMode) {
          fd.append("uuid", this.formDokumen.uuid);
          if (this.formDokumen.file) fd.append("file", this.formDokumen.file);
          await axios.post("/master/pasien/dokumen-update", fd, {
            headers: { "Content-Type": "multipart/form-data" },
          });
          alert("Dokumen berhasil diupdate!");
        } else {
          fd.append("file", this.formDokumen.file);
          await axios.post("/master/pasien/dokumen-store", fd, {
            headers: { "Content-Type": "multipart/form-data" },
          });
          alert("Dokumen berhasil diupload!");
        }
        this.closeDokumenModal();
        this.fetchDokumen();
      } catch (err) {
        alert(err.response?.data?.message || "Gagal menyimpan dokumen");
      } finally {
        this.loadingDokumen = false;
      }
    },

    async deleteDocument(item) {
      if (!confirm(`Yakin ingin menghapus dokumen "${item.nama_file}"?`)) return;
      this.loadingDokumen = true;
      try {
        const fd = new FormData();
        fd.append("uuid", item.uuid);
        await axios.post("/master/pasien/dokumen-delete", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        alert("Dokumen berhasil dihapus!");
        this.fetchDokumen();
      } catch (err) {
        alert(err.response?.data?.message || "Gagal menghapus dokumen");
      } finally {
        this.loadingDokumen = false;
      }
    },

    async verifyDocument(item) {
      if (!confirm(`Verifikasi dokumen "${item.nama_file}"?`)) return;
      this.loadingDokumen = true;
      try {
        const fd = new FormData();
        fd.append("uuid", item.uuid);
        await axios.post("/master/pasien/dokumen-verify", fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        alert("Dokumen berhasil diverifikasi!");
        this.fetchDokumen();
      } catch (err) {
        alert(err.response?.data?.message || "Gagal memverifikasi dokumen");
      } finally {
        this.loadingDokumen = false;
      }
    },

    // ---- FILE PREVIEW methods ----
    openFilePreview(item) {
      this.previewItem = item;
      this.imgLoadError = false;
      this.showFileModal = true;
    },
    openInNewTab() {
      if (!this.previewItem) return;
      window.open(`/print/rekammedis/dokumen/${this.previewItem.uuid}`, '_blank');
    },
    isImageFile(filename) {
      return /\.(jpg|jpeg|png|bmp|gif|webp)$/i.test(filename || '');
    },
    isPdfFile(filename) {
      return /\.pdf$/i.test(filename || '');
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
.filter-left { font-size: 14px; }
.filter-left select { margin: 0 5px; }
.search-input { padding: 3px 5px; border: 1px solid #aaa; border-radius: 3px; }

.custom-table-rme { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
.custom-table-rme th { background: #1d72c9; color: white; padding: 8px; text-align: left; font-size: 13px; }
.custom-table-rme td { border: 1px solid #ddd; padding: 8px; font-size: 13px; }
.custom-table-rme tbody tr:nth-child(even) { background: #e9f2ff; }

.table-info { margin-top: 5px; font-size: 13px; }

.pagination-rme { display: flex; gap: 5px; margin-top: 6px; }
.pagination-rme button { padding: 5px 10px; border: 1px solid #1d72c9; background: white; cursor: pointer; border-radius: 3px; }
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
  width: 32px; height: 32px;
  border: 4px solid #ddd;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 10px;
}
@keyframes spin-rme { to { transform: rotate(360deg); } }

/* Dokumen section */
.section-wrapper { background: white; padding: 15px; border-radius: 5px; border: 1px solid #ddd; }
.action-bar { margin-bottom: 15px; text-align: right; }
.btn-add { background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold; }
.btn-add:hover { background: #218838; }
.btn-add span { font-size: 18px; margin-right: 5px; }

.btn-view-all-cppt { background: #1a6f1d; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold; margin-left: 8px; }
.btn-view-all-cppt:hover { background: #145217; }

.file-link { color: #0066cc; cursor: pointer; text-decoration: underline; }
.file-link:hover { color: #004499; }

.badge-verified { background: #28a745; color: white; padding: 4px 10px; border-radius: 3px; font-size: 12px; display: inline-block; }
.badge-unverified { background: #ffc107; color: #333; padding: 4px 10px; border-radius: 3px; font-size: 12px; display: inline-block; }
.btn-verify { background: #007bff; color: white; border: none; padding: 4px 12px; border-radius: 3px; cursor: pointer; font-size: 12px; }
.btn-verify:hover { background: #0056b3; }
.action-buttons { display: flex; gap: 5px; }
.btn-edit { background: #ffc107; color: #333; border: none; padding: 4px 12px; border-radius: 3px; cursor: pointer; font-size: 12px; }
.btn-edit:hover { background: #e0a800; }
.btn-delete { background: #dc3545; color: white; border: none; padding: 4px 12px; border-radius: 3px; cursor: pointer; font-size: 12px; }
.btn-delete:hover { background: #c82333; }
.text-muted { color: #999; }

/* Action icons SOAP */
.action-icon { cursor: pointer; font-size: 18px; margin: 0 6px; color: #356ead; }
.action-icon:hover { color: #094a9c; }

/* Modal overlay shared */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 9999; }

/* SOAP detail modal */
.modal-box { background: white; width: 90%; max-height: 80vh; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 2px 12px rgba(0,0,0,0.25); }
.modal-header-rme { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; background: #2b6cb0; color: white; }
.close-btn { cursor: pointer; font-size: 22px; font-weight: bold; }
.modal-content-rme { padding: 15px 18px; overflow-y: auto; flex: 1; }
.modal-footer-rme { padding: 12px 18px; text-align: right; background: #f1f1f1; }
.modal-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
.modal-table td, .modal-table th { border: 1px solid #ddd; padding: 6px 8px; font-size: 13px; }
.modal-table th { background: #e8f0fb; }

/* Dokumen modal shared */
.modal-content-dokumen { background: white; border-radius: 8px; width: 90%; max-width: 620px; max-height: 92vh; overflow-y: auto; display: flex; flex-direction: column; }
.modal-header-dokumen { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #ddd; }
.modal-header-dokumen h3 { margin: 0; font-size: 18px; }
.btn-close-x { background: none; border: none; font-size: 28px; cursor: pointer; color: #999; }
.btn-close-x:hover { color: #333; }
.modal-body-dokumen { padding: 20px; flex: 1; }
.modal-footer-dokumen { display: flex; justify-content: flex-end; gap: 10px; padding: 15px 20px; border-top: 1px solid #ddd; }
.form-group-dokumen { margin-bottom: 15px; }
.form-group-dokumen label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
.form-control-dokumen { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
.btn-secondary-dokumen { background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
.btn-secondary-dokumen:hover { background: #5a6268; }
.btn-primary-dokumen { background: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
.btn-primary-dokumen:hover { background: #0056b3; }
.btn-primary-dokumen:disabled { background: #ccc; cursor: not-allowed; }

/* File preview modal */
.modal-preview { max-width: 900px; width: 95vw; }
.preview-body { display: flex; align-items: center; justify-content: center; padding: 12px; background: #f5f5f5; min-height: 500px; }
.preview-image { max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 4px; box-shadow: 0 2px 12px rgba(0,0,0,0.15); }
.preview-iframe { width: 100%; height: 70vh; border: none; border-radius: 4px; }
.preview-unsupported { text-align: center; padding: 40px; }
.btn-open-tab { background: #17a2b8; color: white; border: none; padding: 5px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; }
.btn-open-tab:hover { background: #138496; }

/* SOAP boxes */
.soap-box { background: #e9e9eb; border: 1px solid #d3d3d3; padding: 15px; border-radius: 4px; min-height: 120px; margin-bottom: 20px; overflow-x: auto; }
</style>
