<template>
  <div class="history-container">
    <!-- LOADING OVERLAY -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner-rme"></div>
      Loading...
    </div>

    <!-- ================= LIST STATE ================= -->
    <div v-if="state == 'list'">
      <!-- HEADER -->
      <div class="header-component-rme">Daftar Lampiran Dokumen</div>

      <!-- PATIENT INFO CARD -->
      <div class="patient-info-card mb-3">
        <div class="row">
          <div class="col-md-3">
            <strong>No. RM:</strong> {{ selectedPatient?.rekam_medis }}
          </div>
          <div class="col-md-4"><strong>Nama:</strong> {{ selectedPatient?.nama }}</div>
          <div class="col-md-3"><strong>NIK:</strong> {{ selectedPatient?.nik }}</div>
          <div class="col-md-2">
            <strong>JK:</strong> {{ selectedPatient?.jenis_kelamin }}
          </div>
        </div>
      </div>

      <!-- FILTER BAR -->
      <div class="filter-bar">
        <div class="filter-left">
          Tampil
          <select v-model="perPage" @change="fetchLampiran">
            <option v-for="n in [10, 25, 50, 100]" :key="n">{{ n }}</option>
          </select>
          data
        </div>

        <div class="filter-right">
          <button class="btn-add" @click="onAdd">
            <i class="fas fa-plus"></i> Tambah Dokumen
          </button>

          Cari:
          <input
            type="text"
            v-model="searchQuery"
            @input="onSearch"
            class="search-input"
            placeholder="Cari nama, no RM..."
          />
        </div>
      </div>

      <!-- TABLE -->
      <table class="custom-table-rme">
        <thead>
          <tr>
            <th style="width: 50px">NO</th>
            <th style="width: 180px">JENIS DOKUMEN</th>
            <th style="width: 180px">Nomor Dokumen</th>
            <th style="width: 100px">TANGGAL</th>
            <th style="width: 150px">Creator</th>
            <th style="width: 120px" class="text-center">ACTION</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="data.length === 0">
            <td colspan="10" class="text-center">
              {{ loading ? "Memuat data..." : "Tidak ada data" }}
            </td>
          </tr>

          <tr v-for="(item, index) in data" :key="item.uuid">
            <td>{{ pagination.from + index }}</td>

            <!-- JENIS DOKUMEN dengan Badge -->
            <td>
              <!-- <span
                class="document-badge"
                :style="{ backgroundColor: item.document_color }"
              >
                <i :class="['fas', item.document_icon]"></i>
                {{ item.document_label }}
              </span> -->
              {{ item.document_label }}
            </td>

            <td></td>

            <td>{{ formatDate(item.tanggal) }}</td>
            <td>{{ item.created_by || "-" }}</td>

            <!-- ACTION BUTTONS -->
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

                <button
                  class="btn-action btn-delete"
                  @click="onDelete(item)"
                  title="Hapus"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER INFO -->
      <div class="table-info">
        Menampilkan {{ pagination.from }} s/d {{ pagination.to }} dari
        {{ pagination.total }} data
      </div>

      <!-- PAGINATION -->
      <div class="pagination-rme">
        <button
          :disabled="pagination.current_page === 1"
          @click="changePage(pagination.current_page - 1)"
        >
          <i class="fas fa-chevron-left"></i> Previous
        </button>

        <button
          v-for="page in visiblePages"
          :key="page"
          :class="['page-btn', { active: pagination.current_page === page }]"
          @click="changePage(page)"
        >
          {{ page }}
        </button>

        <button
          :disabled="pagination.current_page === pagination.total_pages"
          @click="changePage(pagination.current_page + 1)"
        >
          Next <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- ================= SELECT DOCUMENT STATE ================= -->
    <div v-if="state == 'select-document'" class="select-document-container">
      <div class="header-component-rme">Pilih Jenis Dokumen</div>

      <div class="document-selector-card">
        <p class="mb-3">Silakan pilih jenis dokumen yang ingin ditambahkan:</p>

        <!-- 🔍 SEARCH DOCUMENT - IMPROVED -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-search"></i> Cari Jenis Dokumen
          </label>
          <div class="search-wrapper">
            <input
              type="text"
              v-model="documentSearch"
              class="form-input-search"
              placeholder="Ketik nama dokumen untuk mencari..."
              @focus="showDocumentList = true"
            />
            <i v-if="documentSearch"
               class="fas fa-times clear-search"
               @click="clearDocumentSearch"
               title="Hapus pencarian"></i>
          </div>

          <!-- Document count info -->
          <div v-if="documentSearch" class="search-info">
            <i class="fas fa-info-circle"></i>
            Ditemukan {{ filteredAvailableDocuments.length }} dari {{ availableDocuments.length }} dokumen
          </div>
        </div>

        <!-- DOCUMENT LIST - REACTIVE DISPLAY -->
        <div class="document-list-container">
          <div class="form-label">
            <i class="fas fa-file-medical"></i> Pilih Dokumen:
          </div>

          <!-- EMPTY STATE -->
          <div
            v-if="filteredAvailableDocuments.length === 0"
            class="empty-state"
          >
            <i class="fas fa-search"></i>
            <p>Tidak ada dokumen ditemukan untuk "{{ documentSearch }}"</p>
            <button class="btn-clear-search" @click="clearDocumentSearch">
              <i class="fas fa-redo"></i> Tampilkan Semua Dokumen
            </button>
          </div>

          <!-- DOCUMENT CARDS - REACTIVE LIST -->
          <div v-else class="document-cards">
            <div
              v-for="doc in filteredAvailableDocuments"
              :key="doc.value"
              :class="['document-card', { selected: selectedDocumentType === doc.value }]"
              @click="selectDocument(doc.value)"
            >
              <div class="document-card-header">
                <i :class="['fas', getDocumentIcon(doc.value)]"></i>
                <span class="document-title">{{ doc.label }}</span>
              </div>
              <div class="document-description">{{ doc.description }}</div>
              <div v-if="selectedDocumentType === doc.value" class="selected-indicator">
                <i class="fas fa-check-circle"></i> Dipilih
              </div>
            </div>
          </div>
        </div>

        <!-- SELECTED DOCUMENT INFO -->
        <div v-if="selectedDocumentType" class="document-info mt-3">
          <i class="fas fa-info-circle"></i>
          <div>
            <strong>Dokumen yang dipilih:</strong><br>
            <span>{{ getSelectedDocumentInfo() }}</span>
          </div>
        </div>

        <div class="button-group mt-4">
          <button
            class="btn-primary"
            @click="onProceedToCreate"
            :disabled="!selectedDocumentType"
          >
            <i class="fas fa-arrow-right"></i> Lanjutkan
          </button>
          <button class="btn-secondary" @click="onCancelSelection">
            <i class="fas fa-times"></i> Batal
          </button>
        </div>
      </div>
    </div>

    <!-- ================= CREATE STATE (DYNAMIC) ================= -->
    <div v-if="state == 'create'">
      <component
        :is="currentDocumentComponent"
        @back="onBackToList"
        :selectedPatient="selectedPatient"
        :editUuid="editUuid"
        :editData="editData"
        :documentType="selectedDocumentType"
      />
    </div>

    <div v-if="state == 'view'">
      <component
        :is="currentDocumentComponent"
        @back="onBackToList"
        :selectedPatient="selectedPatient"
        :editUuid="editUuid"
        :editData="editData"
        :viewData="true"
        :documentType="selectedDocumentType"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineAsyncComponent } from "vue";

export default {
  name: "ListLampiran",
  components: {
    // Lazy load components
    CreateLaporanBedah: defineAsyncComponent(() => import("./create/LaporanBedah.vue")),
    FormLaserBargage: defineAsyncComponent(() => import("./create/FormLaserBarage.vue")),
    FormPersetujuanTindakanKedokteran: defineAsyncComponent(() =>
      import("./create/FormPersetujuanTindakanKedokteran.vue")
    ),
    FormLaserFokal: defineAsyncComponent(() => import("./create/FormLaserFokal.vue")),
    FormResumePerawatanRawatJalan: defineAsyncComponent(() =>
      import("./create/FormResumePerawatanRawatJalan.vue")
    ),
    FormBalanceCairanHarian: defineAsyncComponent(() =>
      import("./create/FormBalanceCairanHarian.vue")
    ),
    FormPenolakanRujukan: defineAsyncComponent(() =>
      import("./create/FormPenolakanRujukan.vue")
    ),
    FormSuratKontrol: defineAsyncComponent(() => import("./create/FormSuratKontrol.vue")),
    FormSuratKonsul: defineAsyncComponent(() => import("./create/FormSuratKonsul.vue")),
    FormSuratBalasanKonsul: defineAsyncComponent(() =>
      import("./create/FormSuratBalasanKonsul.vue")
    ),
    FormPernyataanBatalOperasi: defineAsyncComponent(() =>
      import("./create/FormPernyataanBatalOperasi.vue")
    ),
    FormPernyataanPasienUmum: defineAsyncComponent(() =>
      import("./create/FormPernyataanPasienUmum.vue")
    ),
    FormDietitianPasienBaru: defineAsyncComponent(() =>
      import("./create/FormDietitianPasienBaru.vue")
    ),
    FormAsuhanGizi: defineAsyncComponent(() => import("./create/FormAsuhanGizi.vue")),
    FormLaserLPI: defineAsyncComponent(() => import("./create/FormLaserLPI.vue")),
    PenolakanTindakanAnestesi: defineAsyncComponent(() =>
      import("./create/PenolakanTindakanAnestesi.vue")
    ),
    FormChecklistKesiapanBedah: defineAsyncComponent(() =>
      import("./create/FormChecklistKesiapanBedah.vue")
    ),
    FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap: defineAsyncComponent(() =>
      import("./create/FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap.vue")
    ),
    FormEdukasiPasienDanKeluargaRawatJalan: defineAsyncComponent(() =>
      import("./create/FormEdukasiPasienDanKeluargaRawatJalan.vue")
    ),
    FormProsesPerawatanPeriOperative: defineAsyncComponent(() =>
      import("./create/FormProsesPerawatanPeriOperative.vue")
    ),
    FormPersetujuanUmumPasienKeluarga: defineAsyncComponent(() =>
      import("./create/FormPersetujuanUmumPasienKeluarga.vue")
    ),
    FormPengkajianKeperawatanMataRawatJalan: defineAsyncComponent(() =>
      import("./create/FormPengkajianKeperawatanMataRawatJalan.vue")
    ),
    FormLaporanInjeksi: defineAsyncComponent(() =>
      import("./create/FormLaporanInjeksi.vue")
    ),
    FormPermintaanPulang: defineAsyncComponent(() =>
      import("./create/FormPermintaanPulang.vue")
    ),
    VoucherRawatInap: defineAsyncComponent(() => import("./create/VoucherRawatInap.vue")),
    FormReaksiTransfusiDarah: defineAsyncComponent(() =>
      import("./create/FormReaksiTransfusiDarah.vue")
    ),
    FormLaserPRP: defineAsyncComponent(() => import("./create/FormLaserPRP.vue")),
    FormLaporanOperasiPterygium: defineAsyncComponent(() =>
      import("./create/FormLaporanOperasiPterygium.vue")
    ),
    FormLaporanEksisiPalebra: defineAsyncComponent(() =>
      import("./create/FormLaporanEksisiPalebra.vue")
    ),
    FormLaporanEksisiChalazion: defineAsyncComponent(() =>
      import("./create/FormLaporanEksisiChalazion.vue")
    ),
    FormAssesmenAwalKeperawatanRawatInap: defineAsyncComponent(() =>
      import("./create/FormAssesmenAwalKeperawatanRawatInap.vue")
    ),
    FormResumeMedisRawatInap: defineAsyncComponent(() =>
      import("./create/FormResumeMedisRawatInap.vue")
    ),
    FormResumeMedisRawatJalan: defineAsyncComponent(() =>
      import("./create/FormResumeMedisRawatJalan.vue")
    ),
    FormCPPTRawatInap: defineAsyncComponent(() =>
      import("./create/FormCPPTRawatInap.vue")
    ),
    FormPulangAtasPermintaanSendiri: defineAsyncComponent(() =>
      import("./create/FormPulangAtasPermintaanSendiri.vue")
    ),
    FormTindakanLaserCapsulotomy: defineAsyncComponent(() =>
      import("./create/FormTindakanLaserCapsulotomy.vue")
    ),
    FormTindakanEpilasi: defineAsyncComponent(() =>
      import("./create/FormTindakanEpilasi.vue")
    ),
    FormKronologisPasien: defineAsyncComponent(() =>
      import("./create/FormKronologisPasien.vue")
    ),
    FormCatatanOperasi: defineAsyncComponent(() =>
      import("./create/FormCatatanOperasi.vue")
    ),
    FormMonitoringEfekSampingObat: defineAsyncComponent(() =>
      import("./create/FormMonitoringEfekSampingObat.vue")
    ),
    FormCatatanKeperawatan: defineAsyncComponent(() =>
      import("./create/FormCatatanKeperawatan.vue")
    ),
    FormLaporanOperasiTrabulektomi: defineAsyncComponent(() =>
      import("./create/FormLaporanOperasiTrabulektomi.vue")
    ),
    FormStatusAnestesi: defineAsyncComponent(() =>
      import("./create/FormStatusAnestesi.vue")
    ),
    FormLaporanOperasiVitreoRetina: defineAsyncComponent(() =>
      import("./create/FormLaporanOperasiVitreoRetina.vue")
    ),
  },

  data() {
    return {
      perPage: 10,
      searchQuery: "",
      state: "list",
      selectedDocumentType: "",
      editData: null,
      editUuid: null,
      loading: false,
      data: [],
      documentSearch: "",
      showDocumentList: true,
      pagination: {
        total: 0,
        per_page: 10,
        current_page: 1,
        total_pages: 0,
        from: 0,
        to: 0,
      },
      searchTimeout: null,

      availableDocuments: [
        {
          value: "laporan-bedah",
          label: "Laporan Pembedahan",
          component: "CreateLaporanBedah",
          description: "Form untuk mencatat laporan operasi dan pembedahan pasien",
          backendType: "laporan_bedah",
        },
        // {
        //   value: "laser-bargage",
        //   label: "Form Laser Bargage",
        //   component: "FormLaserBargage",
        //   description: "Form tindakan laser bargage medis",
        //   backendType: "laser_bargage",
        // },
        {
          value: "dokumen_form_laser_fokal",
          label: "Form Laser Fokal",
          component: "FormLaserFokal",
          description: "Form tindakan laser Fokal medis",
          backendType: "dokumen_form_laser_fokal",
        },
        {
          value: "persetujuan_tindakan_kedokteran",
          label: "Form Persetujuan Tindakan Kedokteran",
          component: "FormPersetujuanTindakanKedokteran",
          description: "Form Persetujuan Tindakan Kedokteran",
          backendType: "persetujuan_tindakan_kedokteran",
        },
        {
          value: "resume-perawatan-rawat-jalan",
          label: "Form Resume Perawatan Rawat Jalan",
          component: "FormResumePerawatanRawatJalan",
          description: "Form Resume Perawatan Rawat Jalan",
          backendType: "resume_perawatan_rawat_jalan",
        },
        {
          value: "balance-cairan-harian",
          label: "Balance Cairan Harian",
          component: "FormBalanceCairanHarian",
          description: "Form monitoring intake dan output cairan pasien per hari",
          backendType: "balance_cairan_harian",
        },
        {
          value: "surat-penolakan-rujukan",
          label: "Surat Penolakan Rujukan",
          component: "FormPenolakanRujukan",
          description: "Form Surat penolakan rujukan pasien",
          backendType: "surat_penolakan_rujukan",
        },
        {
          value: "surat-kontrol-ulang",
          label: "Surat Kontrol Ulang",
          component: "FormSuratKontrol",
          description: "Form Surat Kontrol Ulang Pasien",
          backendType: "surat_kontrol_ulang",
        },
        {
          value: "surat_konsul",
          label: "Surat Konsultasi",
          component: "FormSuratKonsul",
          description: "Form Surat Konsultasi Pasien",
          backendType: "surat_konsul",
        },
        {
          value: "surat-balasan-kosultasi",
          label: "Surat Balasan Konsultasi",
          component: "FormSuratBalasanKonsul",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "surat_balasan_konsul",
        },
        {
          value: "surat-pernyataan-batal-operasi",
          label: "Surat Pernyataan Batal Operasi",
          component: "FormPernyataanBatalOperasi",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "surat_pernyataan_batal_operasi",
        },
        {
          value: "surat-pernyataan-pasien-umum",
          label: "Surat Pernyataan Pasien Umum",
          component: "FormPernyataanPasienUmum",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "surat_pernyataan_pasien_umum",
        },
        {
          value: "dietitian-pasien-baru",
          label: "Form Dokumen Dietitian Pasien Baru",
          component: "FormDietitianPasienBaru",
          description: "Form Surat Balasan Konsultasi Pasien",
          backendType: "dokumen_dietitian_pasien_baru",
        },
        {
          value: "dokumen_asuhan_gizi",
          label: "Form Dokumen Asuhan Gizi",
          component: "FormAsuhanGizi",
          description: "Form Asuhan Gizi Pasien",
          backendType: "dokumen_asuhan_gizi",
        },
        {
          value: "dokumen_tindakan_laser_lpi",
          label: "Form Dokumen Laser LPI",
          component: "FormLaserLPI",
          description: "Form Laser LPI Pasien",
          backendType: "dokumen_tindakan_laser_lpi",
        },
        {
          value: "form_persetujuan_umum_pasien_keluarga",
          label: "Form Persetujuan Umum Pasien Keluarga",
          component: "FormPersetujuanUmumPasienKeluarga",
          description: "Form Persetujuan Umum Pasien Keluarga",
          backendType: "form_persetujuan_umum_pasien_keluarga",
        },
        {
          value: "penolakan_tindakan_anestesi",
          label: "Form Tindakan Anestesi (Penolakan/Persetujuan)",
          component: "PenolakanTindakanAnestesi",
          description: "Form untuk penolakan atau persetujuan tindakan anestesi",
          backendType: "penolakan_tindakan_anestesi",
        },
        {
          value: "dokumen_ceklist_kesiapan_bedah",
          label: "Form Checklist Kesiapan Bedah",
          component: "FormChecklistKesiapanBedah",
          description: "Form Checklist Kesiapan Bedah",
          backendType: "dokumen_ceklist_kesiapan_bedah",
        },
        {
          value: "form_proses_perawatan_peri_operative",
          label: "Form Proses Perawatan Peri Operative",
          component: "FormProsesPerawatanPeriOperative",
          description: "Form Proses Perawatan Peri Operative",
          backendType: "form_proses_perawatan_peri_operative",
        },
        {
          value: "form_edukasi_pasien_dan_keluarga_rawat_jalan",
          label: "Form Edukasi Pasien Dan Keluarga Rawat Jalan",
          component: "FormEdukasiPasienDanKeluargaRawatJalan",
          description: "Form Edukasi Pasien Dan Keluarga Rawat Jalan",
          backendType: "form_edukasi_pasien_dan_keluarga_rawat_jalan",
        },
        {
          value: "form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap",
          label: "Form Pendidikan Edukasi Pasien Keluarga Terintegrasi Rawat Inap",
          component: "FormPendidikanEdukasiPasienKeluargaTerintegrasiRawatInap",
          description: "Form Pendidikan Edukasi Pasien Keluarga Terintegrasi Rawat Inap",
          backendType: "form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap",
        },
        {
          value: "form_pengkajian_keperawatan_mata_rawat_jalan",
          label: "Form Pengkajian Keperawatan Mata Rawat Jalan",
          component: "FormPengkajianKeperawatanMataRawatJalan",
          description: "Form Pengkajian Keperawatan Mata Rawat Jalan",
          backendType: "form_pengkajian_keperawatan_mata_rawat_jalan",
        },
        {
          value: "form_laporan_injeksi",
          label: "Form Laporan Injeksi",
          component: "FormLaporanInjeksi",
          description: "Form Laporan Injeksi",
          backendType: "form_laporan_injeksi",
        },
        {
          value: "form_permintaan_pulang",
          label: "Form Permintaan Pulang",
          component: "FormPermintaanPulang",
          description: "Form Permintaan Pulang",
          backendType: "form_permintaan_pulang",
        },
        {
          value: "voucher_rawat_inap",
          label: "Voucher Rawat Inap",
          component: "VoucherRawatInap",
          description: "Voucher Rawat Inap",
          backendType: "voucher_rawat_inap",
        },
        {
          value: "form_reaksi_transfusi_darah",
          label: "Form Reaksi Transfusi Darah",
          component: "FormReaksiTransfusiDarah",
          description: "Form Reaksi Transfusi Darah",
          backendType: "form_reaksi_transfusi_darah",
        },
        {
          value: "dokumen_tindakan_laser_prp",
          label: "Form Dokumen Laser PRP",
          component: "FormLaserPRP",
          description: "Form Laser PRP Pasien",
          backendType: "dokumen_tindakan_laser_prp",
        },
        {
          value: "dokumen_laporan_operasi_trabekulektomi",
          label: "Form Laporan Operasi Trabekulektomi",
          component: "FormLaporanOperasiTrabulektomi",
          description: "Form Laporan Operasi Trabekulektomi",
          backendType: "dokumen_laporan_operasi_trabekulektomi",
        },
        {
          value: "dokumen_laporan_operasi_pterygium",
          label: "Form Laporan Operasi Pterygrium",
          component: "FormLaporanOperasiPterygium",
          description: "Form Laporan Operasi Pterygrium",
          backendType: "dokumen_laporan_operasi_pterygium",
        },
        {
          value: "dokumen_laporan_eksisi_palpebra",
          label: "Form Laporan Eksisi Palebra",
          component: "FormLaporanEksisiPalebra",
          description: "Form Laporan Eksisi Palebra",
          backendType: "dokumen_laporan_eksisi_palpebra",
        },
        {
          value: "asesmen-keperawatan-rawat-inap",
          label: "Assemen Awal Keperawatan Rawat Inap",
          component: "FormAssesmenAwalKeperawatanRawatInap",
          description: "Assemen Awal Keperawatan Rawat Inap",
          backendType: "asesmen_keperawatan_rawat_inap",
        },
        {
          value: "resume-medis-rawat-inap",
          label: "Form Resume Medis Rawat Inap",
          component: "FormResumeMedisRawatInap",
          description: "Resume Medis Rawat Inap",
          backendType: "resume_medis_rawat_inap",
        },
        {
          value: "resume-medis-rawat-jalan",
          label: "Form Resume Medis Rawat Jalan",
          component: "FormResumeMedisRawatJalan",
          description: "Resume Medis Rawat Jalan",
          backendType: "resume_medis_rawat_jalan",
        },
        {
          value: "cppt-rawat-inap",
          label: "Form CPPT Rawat Inap",
          component: "FormCPPTRawatInap",
          description: "CPPT Rawat Inap",
          backendType: "cppt_rawat_inap",
        },
        {
          value: "dokumen_laporan_eksisi_chalazion",
          label: "Form Laporan Eksisi Chalazion",
          component: "FormLaporanEksisiChalazion",
          description: "Form Laporan Eksisi Chalazion",
          backendType: "dokumen_laporan_eksisi_chalazion",
        },
        {
          value: "dokumen_pulang_atas_permintaan_sendiri",
          label: "Form Pulang Atas Permintaan Sendiri",
          component: "FormPulangAtasPermintaanSendiri",
          description: "Form Pulang Atas Permintaan Sendiri",
          backendType: "dokumen_pulang_atas_permintaan_sendiri",
        },
        {
          value: "dokumen_tindakan_laser_capsulotomy",
          label: "Form Tindakan Laser",
          component: "FormTindakanLaserCapsulotomy",
          description: "Form Tindakan Laser Capsulotomy",
          backendType: "dokumen_tindakan_laser_capsulotomy",
        },
        {
          value: "dokumen_tindakan_epilasi",
          label: "Form Tindakan Epilasi",
          component: "FormTindakanEpilasi",
          description: "Form Tindakan Epilasi",
          backendType: "dokumen_tindakan_epilasi",
        },
        {
          value: "dokumen_kronologis_pasien",
          label: "Form Kronologi Pasien",
          component: "FormKronologisPasien",
          description: "Form Kronologi Pasien",
          backendType: "dokumen_kronologis_pasien",
        },
        {
          value: "dokumen_catatan_operasi",
          label: "Form Catatan Operasi",
          component: "FormCatatanOperasi",
          description: "Form Catatan Operasi",
          backendType: "dokumen_catatan_operasi",
        },
        {
          value: "monitoring-efek-samping-obat",
          label: "Form Monitoring Efek Samping Obat",
          component: "FormMonitoringEfekSampingObat",
          description: "Form Monitoring Efek Samping Obat",
          backendType: "monitoring_efek_samping_obat",
        },
        {
          value: "dokumen-catatan-keperawatan",
          label: "Form Catatan Keperawatan",
          component: "FormCatatanKeperawatan",
          description: "Form Catatan Keperawatan",
          backendType: "catatan_keperawatan",
        },
        {
          value: "dokumen_form_laser_barrage",
          label: "Form Laser Barrage",
          component: "FormLaserBargage",
          description: "Form Laser Barrage",
          backendType: "dokumen_form_laser_barrage",
        },
        {
          value: "dokumen-status-anestesi",
          label: "Form Status Anestesi",
          component: "FormStatusAnestesi",
          description: "Status Anestesi",
          backendType: "status_anestesi",
        },
        {
          value: "dokumen-form-laporan-operasi-vitreo-retina",
          label: "Form Laporan Operasi Vitreo Retina",
          component: "FormLaporanOperasiVitreoRetina",
          description: "Laporan Operasi Operasi Bedah Mata",
          backendType: "laporan_operasi_vitreo_retina",
        },
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
        if (newVal?.uuid) {
          this.fetchLampiran();
        }
      },
    },
    perPage() {
      this.pagination.current_page = 1;
      this.fetchLampiran();
    },
  },

  computed: {
    currentDocumentComponent() {
      const doc = this.availableDocuments.find(
        (d) => d.value === this.selectedDocumentType
      );
      return doc ? doc.component : null;
    },

    visiblePages() {
      const total = this.pagination.total_pages;
      const current = this.pagination.current_page;
      const delta = 2;

      let pages = [];
      pages.push(1);

      for (
        let i = Math.max(2, current - delta);
        i <= Math.min(total - 1, current + delta);
        i++
      ) {
        pages.push(i);
      }

      if (total > 1) {
        pages.push(total);
      }

      return [...new Set(pages)].sort((a, b) => a - b);
    },

    filteredAvailableDocuments() {
      if (!this.documentSearch.trim()) return this.availableDocuments;

      const keyword = this.documentSearch.toLowerCase().trim();

      return this.availableDocuments.filter(
        (doc) =>
          doc.label.toLowerCase().includes(keyword) ||
          doc.value.toLowerCase().includes(keyword) ||
          doc.description.toLowerCase().includes(keyword) ||
          doc.backendType.toLowerCase().includes(keyword)
      );
    },
  },

  methods: {
    async fetchLampiran() {
      if (!this.selectedPatient?.uuid) return;

      this.loading = true;

      try {
        const formData = new FormData();
        formData.append("uuid_pasien", this.selectedPatient.uuid);
        formData.append("search", this.searchQuery);
        formData.append("limit", this.perPage);
        formData.append("page", this.pagination.current_page);

        const res = await axios.post("/master/rekammedis/list-lampiran", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        if (res.data.status) {
          this.data = res.data.data || [];
          this.pagination = res.data.pagination || this.pagination;
        }
      } catch (err) {
        console.error("Gagal memuat lampiran:", err);
        this.$swal({
          icon: "error",
          title: "Error",
          text: "Gagal memuat data lampiran",
        });
      } finally {
        this.loading = false;
      }
    },

    onSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.pagination.current_page = 1;
        this.fetchLampiran();
      }, 500);
    },

    changePage(page) {
      if (page < 1 || page > this.pagination.total_pages) return;
      this.pagination.current_page = page;
      this.fetchLampiran();
    },

    onAdd() {
      this.state = "select-document";
      this.selectedDocumentType = "";
      this.documentSearch = "";
      this.editUuid = null;
    },

    selectDocument(value) {
      this.selectedDocumentType = value;
    },

    clearDocumentSearch() {
      this.documentSearch = "";
    },

    getDocumentIcon(value) {
      const iconMap = {
        'laporan-bedah': 'fa-file-medical',
        'laser-bargage': 'fa-radiation',
        'dokumen_form_laser_fokal': 'fa-bullseye',
        'persetujuan_tindakan_kedokteran': 'fa-file-signature',
        'resume-perawatan-rawat-jalan': 'fa-file-medical-alt',
        'balance-cairan-harian': 'fa-tint',
        'surat-penolakan-rujukan': 'fa-times-circle',
        'surat-kontrol-ulang': 'fa-redo',
        'surat_konsul': 'fa-comment-medical',
        'surat-balasan-kosultasi': 'fa-reply',
      };
      return iconMap[value] || 'fa-file-alt';
    },

    onProceedToCreate() {
      this.editData = null;
      if (!this.selectedDocumentType) {
        alert("Silakan pilih jenis dokumen terlebih dahulu!");
        return;
      }
      this.state = "create";
    },

    onCancelSelection() {
      this.state = "list";
      this.selectedDocumentType = "";
      this.documentSearch = "";
    },

    onBackToList() {
      this.state = "list";
      this.selectedDocumentType = "";
      this.editUuid = null;
      this.fetchLampiran();
    },

    getSelectedDocumentInfo() {
      const doc = this.availableDocuments.find(
        (d) => d.value === this.selectedDocumentType
      );
      return doc ? `${doc.label} - ${doc.description}` : "";
    },

    async onView(item) {
      console.log("🟡 VIEW - Item yang dipilih:", item);

      try {
        this.loading = true;

        const doc = this.availableDocuments.find(
          (d) => d.backendType === item.document_type
        );

        console.log("🟡 VIEW - Doc Config Found:", doc);

        if (!doc) {
          alert("Tipe dokumen tidak ditemukan!");
          return;
        }

        const formData = new FormData();
        formData.append("type", item.document_type);

        const url = `/master/rekammedis/lampiran/${item.uuid}/detail`;
        console.log("🟡 VIEW - URL:", url);

        const response = await axios.post(url, formData);

        console.log("🟡 VIEW - Response:", response.data);

        if (!response.data.status) {
          alert("Error: " + (response.data.message || "Gagal mengambil detail dokumen"));
          return;
        }

        this.editData = response.data.data;
        this.selectedDocumentType = doc.value;

        console.log("🟡 VIEW - View Data yang dikirim ke component:", this.editData);
        console.log("🟡 VIEW - Selected Type:", this.selectedDocumentType);

        this.$nextTick(() => {
          this.state = "view";
        });
      } catch (error) {
        console.error("🟡 VIEW - Error:", error);
        alert(
          "Error: " +
            (error.response?.data?.message || "Terjadi kesalahan saat mengambil data")
        );
      } finally {
        this.loading = false;
      }
    },

    async onEdit(item) {
      console.log("🟡 EDIT - Item yang dipilih:", item);

      try {
        this.loading = true;

        const doc = this.availableDocuments.find(
          (d) => d.backendType === item.document_type
        );

        console.log("🟡 EDIT - Doc Config Found:", doc);

        if (!doc) {
          alert("Tipe dokumen tidak ditemukan!");
          return;
        }

        const formData = new FormData();
        formData.append("type", item.document_type);

        const url = `/master/rekammedis/lampiran/${item.uuid}/detail`;
        console.log("🟡 EDIT - URL:", url);

        const response = await axios.post(url, formData);

        console.log("🟡 EDIT - Response:", response.data);

        if (!response.data.status) {
          alert("Error: " + (response.data.message || "Gagal mengambil detail dokumen"));
          return;
        }

        this.editData = response.data.data;
        this.selectedDocumentType = doc.value;

        console.log("🟡 EDIT - Edit Data yang dikirim ke component:", this.editData);
        console.log("🟡 EDIT - Selected Type:", this.selectedDocumentType);

        this.$nextTick(() => {
          this.state = "create";
        });
      } catch (error) {
        console.error("🟡 EDIT - Error:", error);
        alert(
          "Error: " +
            (error.response?.data?.message || "Terjadi kesalahan saat mengambil data")
        );
      } finally {
        this.loading = false;
      }
    },

    onPrint(item) {
      const printUrls = {
        laser_bargage: `/print/laser-bargage/${item.uuid}`,
        laporan_bedah: `/print/laporan-pembedahan/${item.uuid}`,
        informed_consent: `/print/informed-consent/${item.uuid}`,
        surat_kontrol_ulang: `/print/rekammedis/general/suratkontrolulang/${item.uuid}`,
        surat_penolakan_rujukan: `/print/rekammedis/general/suratpenolakanrujukan/${item.uuid}`,
        surat_pernyataan_pasien_umum: `/print/rekammedis/general/suratpernyataanpasienumum/${item.uuid}`,
        surat_balasan_konsul: `/print/rekammedis/general/suratbalasankonsul/${item.uuid}`,
        dokumen_ceklist_kesiapan_bedah: `/print/rekammedis/bedah/rm2dot0/${item.uuid}`,
        form_edukasi_pasien_dan_keluarga_rawat_jalan: `/print/rekammedis/rawat-jalan/rm1dot2/${item.uuid}`,
        form_persetujuan_umum_pasien_keluarga: `/print/rekammedis/rawat-jalan/rm1dot1/${item.uuid}`,
        form_proses_perawatan_peri_operative: `/print/rekammedis/bedah/rm1dot10/${item.uuid}`,
        form_pendidikan_edukasi_pasien_keluarga_terintegrasi_rawat_inap: `/print/rekammedis/general/pendidikanedukasipasienkeluargaterintegrasirawatinap/${item.uuid}`,
        penolakan_tindakan_anestesi: `/print/rekammedis/general/tindakananestesi/${item.uuid}`,
        form_pengkajian_keperawatan_mata_rawat_jalan: `/print/rekammedis/rawat-jalan/rm1dot3/${item.uuid}`,
        form_laporan_injeksi: `/print/rekammedis/general/laporaninjeksi/${item.uuid}`,
        form_permintaan_pulang: `/print/rekammedis/general/formpermintaanpulang/${item.uuid}`,
        voucher_rawat_inap: `/print/rekammedis/general/voucherrawatinap/${item.uuid}`,
        form_reaksi_transfusi_darah: `/print/rekammedis/general/formreaksitransfusidarah/${item.uuid}`,
        cppt_rawat_inap: `/print/rekammedis/lampiran/cppt-rawat-inap/${item.uuid}`,
        resume_perawatan_rawat_jalan: `/print/rekammedis/lampiran/rekam-medis-perawatan-rawat-jalan/${item.uuid}`,
        resume_medis_rawat_jalan: `/print/rekammedis/lampiran/rekam-medis-rawat-jalan/${item.uuid}`,
        resume_medis_rawat_inap: `/print/rekammedis/lampiran/rekam-medis-rawat-inap/${item.uuid}`,
        asesmen_keperawatan_rawat_inap: `/print/rekammedis/lampiran/asesmen-awal-keperawatan-rawat-inap/${item.uuid}`,
        monitoring_efek_samping_obat: `/print/rekammedis/lampiran/monitoring-efek-samping-obat/${item.uuid}`,
        catatan_keperawatan: `/print/rekammedis/lampiran/catatan-keperawatan/${item.uuid}`,
        surat_konsul: `/print/rekammedis/general/suratkonsul/${item.uuid}`,
        dokumen_tindakan_laser_prp: `/print/rekammedis/general/formlaserprp/${item.uuid}`,
        dokumen_laporan_operasi_trabekulektomi: `/print/rekammedis/general/laporanoperasitrabekulektomi/${item.uuid}`,
        dokumen_laporan_operasi_pterygium: `/print/rekammedis/general/laporanoperasipterygium/${item.uuid}`,
        dokumen_laporan_eksisi_chalazion: `/print/rekammedis/general/laporaneksisichalazion/${item.uuid}`,
        dokumen_laporan_eksisi_palpebra: `/print/rekammedis/general/laporaneksisipalbera/${item.uuid}`,
        dokumen_tindakan_laser_capsulotomy: `/print/rekammedis/general/formlasercapsulotomy/${item.uuid}`,
        dokumen_tindakan_epilasi: `/print/rekammedis/general/formtindakanepilasi/${item.uuid}`,
        dokumen_form_laser_fokal: `/print/rekammedis/general/formlaserfokal/${item.uuid}`,
        dokumen_form_laser_barrage: `/print/rekammedis/general/formlaserbarrage/${item.uuid}`,
        dokumen_asuhan_gizi: `/print/rekammedis/general/asuhangizi/${item.uuid}`,
        dokumen_tindakan_laser_lpi: `/print/rekammedis/general/tindakanlaserlpi/${item.uuid}`,
        surat_pernyataan_batal_operasi: `/print/rekammedis/general/suratpernyataanbataloperasi/${item.uuid}`,
        dokumen_dietitian_pasien_baru: `/print/rekammedis/general/kunjunganawaldietitianpadapasienbaru/${item.uuid}`,
        dokumen_catatan_operasi: `/print/rekammedis/bedah/rm2dot3/${item.uuid}`,
        dokumen_kronologis_pasien: `/print/rekammedis/general/kronologis/${item.uuid}`,
        status_anestesi: `/print/rekammedis/lampiran/status-anestesi/${item.uuid}`,
        laporan_operasi_vitreo_retina: `/print/rekammedis/lampiran/laporan-operasi-vitreo-retina/${item.uuid}`,
      };

      const url = printUrls[item.document_type];
      if (url) {
        window.open(url, "_blank");
      } else {
        alert("Print belum tersedia untuk dokumen ini");
      }
    },

    async onDelete(item) {
      console.log("🔴 DELETE - Item yang dipilih:", item);
      console.log("🔴 DELETE - Document Type:", item.document_type);

      const confirmDelete = confirm(
        `Apakah Anda yakin ingin menghapus ${item.document_label}?`
      );

      if (!confirmDelete) {
        console.log("🔴 DELETE - User batal hapus");
        return;
      }

      try {
        this.loading = true;

        const url = `/master/rekammedis/lampiran/${item.uuid}?type=${item.document_type}`;
        console.log("🔴 DELETE - URL yang dipanggil:", url);

        const response = await axios.delete(url);

        console.log("🔴 DELETE - Response:", response.data);

        if (response.data.status) {
          alert("Dokumen berhasil dihapus");
          this.fetchLampiran();
        } else {
          console.error("🔴 DELETE - Status false:", response.data.message);
          alert("Gagal menghapus dokumen: " + response.data.message);
        }
      } catch (error) {
        console.error("🔴 DELETE - Error:", error);
        console.error("🔴 DELETE - Error Response:", error.response?.data);
        alert("Error: " + (error.response?.data?.message || "Gagal menghapus dokumen"));
      } finally {
        this.loading = false;
      }
    },

    formatDate(date) {
      if (!date) return "-";
      const d = new Date(date);
      return d.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
      });
    },

    formatTime(time) {
      if (!time) return "-";
      if (typeof time === "string") {
        return time.substring(0, 5);
      }
      return "-";
    },

    truncate(text, length) {
      if (!text) return "-";
      if (text.length <= length) return text;
      return text.substring(0, length) + "...";
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
  min-height: 500px;
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

.patient-info-card {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  padding: 12px 15px;
  margin-bottom: 15px;
}

.patient-info-card .row {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -8px;
}

.patient-info-card .col-md-2,
.patient-info-card .col-md-3,
.patient-info-card .col-md-4 {
  padding: 0 8px;
  font-size: 14px;
}

.patient-info-card strong {
  color: #495057;
}

.filter-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
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
  gap: 10px;
  align-items: center;
}

.search-input {
  padding: 6px 10px;
  border: 1px solid #aaa;
  border-radius: 4px;
  width: 200px;
}

.btn-add {
  background: #28a745;
  color: white;
  border: none;
  padding: 7px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  transition: background 0.3s;
  display: flex;
  align-items: center;
  gap: 5px;
}

.btn-add:hover {
  background: #218838;
}

.document-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 4px;
  color: white;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
}

.document-badge i {
  margin-right: 5px;
}

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
  text-align: left;
  font-weight: 600;
}

.custom-table-rme td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: middle;
}

.custom-table-rme tbody tr:nth-child(even) {
  background: #f8f9fa;
}

.custom-table-rme tbody tr:hover {
  background: #e9f2ff;
}

.text-center {
  text-align: center;
}

.detail-info {
  font-size: 12px;
  color: #666;
}

.action-buttons {
  display: flex;
  gap: 5px;
  justify-content: center;
}

.btn-action {
  padding: 5px 8px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 12px;
  transition: all 0.2s;
  color: white;
}

.btn-view {
  background: #17a2b8;
}

.btn-view:hover {
  background: #138496;
}

.btn-edit {
  background: #ffc107;
}

.btn-edit:hover {
  background: #e0a800;
}

.btn-print {
  background: #6c757d;
}

.btn-print:hover {
  background: #5a6268;
}

.btn-delete {
  background: #dc3545;
}

.btn-delete:hover {
  background: #c82333;
}

.pagination-rme {
  display: flex;
  gap: 5px;
  align-items: center;
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
  font-weight: bold;
}

.table-info {
  margin-top: 10px;
  margin-bottom: 10px;
  font-size: 13px;
  color: #666;
}

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
  border: 4px solid #f3f3f3;
  border-top-color: #1d72c9;
  border-radius: 50%;
  animation: spin-rme 0.8s linear infinite;
  margin-bottom: 10px;
}

/* ==================== IMPROVED SELECT DOCUMENT STYLES ==================== */
.select-document-container {
  padding: 20px;
}

.document-selector-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  padding: 30px;
  max-width: 900px;
  margin: 20px auto;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 25px;
}

.form-label {
  display: block;
  font-weight: 600;
  margin-bottom: 10px;
  color: #333;
  font-size: 15px;
}

.form-label i {
  margin-right: 8px;
  color: #1d72c9;
}

/* Search Input dengan Clear Button */
.search-wrapper {
  position: relative;
  width: 100%;
}

.form-input-search {
  width: 100%;
  padding: 12px 40px 12px 15px;
  border: 2px solid #d0d0d0;
  border-radius: 6px;
  font-size: 15px;
  background: white;
  transition: all 0.3s;
}

.form-input-search:focus {
  outline: none;
  border-color: #1d72c9;
  box-shadow: 0 0 0 3px rgba(29, 114, 201, 0.1);
}

.clear-search {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #999;
  cursor: pointer;
  padding: 5px;
  transition: color 0.2s;
}

.clear-search:hover {
  color: #dc3545;
}

/* Search Info */
.search-info {
  margin-top: 8px;
  padding: 8px 12px;
  background: #e3f2fd;
  border-left: 3px solid #1d72c9;
  border-radius: 4px;
  font-size: 13px;
  color: #555;
  display: flex;
  align-items: center;
  gap: 8px;
}

.search-info i {
  color: #1d72c9;
}

/* Document List Container */
.document-list-container {
  margin-top: 20px;
}

/* Document Cards Grid */
.document-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 15px;
  max-height: 500px;
  overflow-y: auto;
  padding: 10px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  background: #fafafa;
}

/* Individual Document Card */
.document-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  padding: 15px;
  cursor: pointer;
  transition: all 0.3s;
  position: relative;
}

.document-card:hover {
  border-color: #1d72c9;
  box-shadow: 0 4px 12px rgba(29, 114, 201, 0.15);
  transform: translateY(-2px);
}

.document-card.selected {
  border-color: #28a745;
  background: #f0f9f4;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}

.document-card-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.document-card-header i {
  font-size: 24px;
  color: #1d72c9;
}

.document-card.selected .document-card-header i {
  color: #28a745;
}

.document-title {
  font-weight: 600;
  font-size: 14px;
  color: #333;
  flex: 1;
}

.document-description {
  font-size: 12px;
  color: #666;
  line-height: 1.4;
}

.selected-indicator {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #28a745;
  color: white;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 5px;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #888;
}

.empty-state i {
  font-size: 48px;
  margin-bottom: 15px;
  color: #ccc;
}

.empty-state p {
  font-size: 16px;
  margin-bottom: 20px;
}

.btn-clear-search {
  background: #6c757d;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-clear-search:hover {
  background: #5a6268;
  transform: translateY(-1px);
}

/* Selected Document Info */
.document-info {
  background: #e8f5e9;
  border-left: 4px solid #28a745;
  padding: 15px;
  border-radius: 4px;
  font-size: 14px;
  color: #555;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.document-info i {
  color: #28a745;
  margin-top: 2px;
  font-size: 18px;
}

.document-info strong {
  color: #333;
}

/* Button Group */
.button-group {
  display: flex;
  gap: 12px;
  justify-content: center;
}

.btn-primary,
.btn-secondary {
  padding: 12px 28px;
  border: none;
  border-radius: 6px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-primary {
  background: #28a745;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #218838;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.btn-primary:disabled {
  background: #ccc;
  cursor: not-allowed;
  transform: none;
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #5a6268;
  transform: translateY(-1px);
}

/* Utility Classes */
.mb-3 {
  margin-bottom: 16px;
}

.mt-3 {
  margin-top: 16px;
}

.mt-4 {
  margin-top: 24px;
}

/* Scrollbar Styling */
.document-cards::-webkit-scrollbar {
  width: 8px;
}

.document-cards::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.document-cards::-webkit-scrollbar-thumb {
  background: #1d72c9;
  border-radius: 4px;
}

.document-cards::-webkit-scrollbar-thumb:hover {
  background: #155a9c;
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
    flex-direction: column;
    align-items: stretch;
  }

  .search-input {
    width: 100%;
  }

  .action-buttons {
    flex-wrap: wrap;
  }

  .document-selector-card {
    padding: 20px;
    margin: 10px;
  }

  .document-cards {
    grid-template-columns: 1fr;
    max-height: 400px;
  }

  .button-group {
    flex-direction: column;
  }

  .btn-primary,
  .btn-secondary {
    width: 100%;
    justify-content: center;
  }
}
</style>
