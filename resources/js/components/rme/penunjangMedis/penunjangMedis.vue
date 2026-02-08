<template>
    <div class="lab-container">
        <!-- LOADING OVERLAY -->
        <div v-if="loading" class="loading-overlay">
            <div class="spinner-lab"></div>
            Loading...
        </div>

        <!-- HEADER -->
        <div class="header-component-lab">
            Daftar Hasil Pemeriksaan Laboratorium
        </div>

        <!-- BUTTON TAMBAH LAB -->
        <div class="action-bar">
            <button @click="openLabModal" class="btn-add">
                <span>+</span> Upload Hasil Lab
            </button>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="filter-left">
                Tampil
                <select v-model="perPage">
                    <option v-for="n in [10, 25, 50, 100]" :key="n">
                        {{ n }}
                    </option>
                </select>
                data
            </div>

            <div class="filter-right">
                Cari:
                <input type="text" v-model="searchQuery" class="search-input" />
            </div>
        </div>

        <!-- TABLE -->
        <table class="custom-table-lab">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO PERIKSA</th>
                    <th>TGL PERIKSA</th>
                    <th>JAM PERIKSA</th>
                    <th>REGISTER</th>
                    <th>MR</th>
                    <th>NAMA PASIEN</th>
                    <th>LAYANAN DARI</th>
                    <th>DOKTER PENGIRIM</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="paginatedData.length === 0">
                    <td colspan="10" style="text-align: center; padding: 20px">
                        Tidak ada data
                    </td>
                </tr>
                <tr v-for="(item, index) in paginatedData" :key="item.id">
                    <td>{{ index + 1 + (currentPage - 1) * perPage }}</td>
                    <td>{{ item.no_periksa }}</td>
                    <td>{{ formatDate(item.tgl_periksa) }}</td>
                    <td>{{ item.jam_periksa }}</td>
                    <td>{{ item.register }}</td>
                    <td>{{ item.mr }}</td>
                    <td>{{ item.pasien_nama }}</td>
                    <td>{{ item.layanan_dari }}</td>
                    <td>{{ item.dokter_pengirim }}</td>
                    <td class="action-buttons">
                        <i class="fas fa-edit action-icon" @click="editLab(item)"></i>
                        <!-- icon delete -->
                        <i class="fas fa-trash action-icon" @click="deleteLab(item.uuid)"></i>
                        <!-- icon print -->
                        <i class="fas fa-print action-icon" @click="printResult(item)"></i>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- FOOTER INFO -->
        <div class="table-info">
            Menampilkan {{ startRow }} s/d {{ endRow }} dari
            {{ filteredData.length }} data
        </div>

        <!-- PAGINATION -->
        <div class="pagination-lab" v-if="totalPages > 1">
            <button :disabled="currentPage === 1" @click="currentPage--">
                Previous
            </button>

            <button
                v-for="page in displayPages"
                :key="page"
                :class="['page-btn', { active: currentPage === page }]"
                @click="currentPage = page"
            >
                {{ page }}
            </button>

            <button
                :disabled="currentPage === totalPages"
                @click="currentPage++"
            >
                Next
            </button>
        </div>

        <!-- SECTION DAFTAR HASIL RADIOLOGI -->
        <div class="section-wrapper" style="margin-top: 30px">
            <!-- LOADING OVERLAY -->
            <div v-if="loadingRadiologi" class="loading-overlay">
                <div class="spinner-lab"></div>
                Loading...
            </div>

            <!-- HEADER -->
            <div class="header-component-lab">Daftar Hasil Radiologi</div>

            <!-- BUTTON TAMBAH RADIOLOGI -->
            <div class="action-bar">
                <button @click="openRadiologiModal" class="btn-add">
                    <span>+</span> Upload Hasil Radiologi
                </button>
            </div>

            <!-- FILTER BAR RADIOLOGI -->
            <div class="filter-bar">
                <div class="filter-left">
                    Tampil
                    <select v-model="perPageRadiologi">
                        <option v-for="n in [10, 25, 50, 100]" :key="n">
                            {{ n }}
                        </option>
                    </select>
                    data
                </div>

                <div class="filter-right">
                    Cari:
                    <input type="text" v-model="searchQueryRadiologi" class="search-input" />
                </div>
            </div>

            <!-- TABLE RADIOLOGI -->
            <table class="custom-table-lab">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NO RADIOLOGI</th>
                        <th>TANGGAL</th>
                        <th>NAMA PASIEN</th>
                        <th>REGISTER</th>
                        <th>PEMERIKSAAN</th>
                        <th>DOKTER PENGIRIM</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-if="paginatedRadiologi.length === 0">
                        <td
                            colspan="8"
                            style="text-align: center; padding: 20px"
                        >
                            Tidak ada data
                        </td>
                    </tr>
                    <tr
                        v-for="(item, index) in paginatedRadiologi"
                        :key="item.uuid"
                    >
                        <td>
                            {{
                                index +
                                1 +
                                (currentPageRadiologi - 1) * perPageRadiologi
                            }}
                        </td>
                        <td>{{ item.no_radiologi }}</td>
                        <td>{{ formatDate(item.tanggal) }}</td>
                        <td>{{ item.pasien_nama }}</td>
                        <td>{{ item.register }}</td>
                        <td>{{ item.pemeriksaan }}</td>
                        <td>{{ item.dokter_pengirim }}</td>
                        <td class="action-buttons">
                            <i class="fas fa-edit action-icon" @click="editRadiologi(item)"></i>
                            <!-- icon delete -->
                            <i class="fas fa-trash action-icon" @click="deleteRadiologi(item.uuid)"></i>
                            <!-- icon print -->
                            <i class="fas fa-print action-icon" @click="viewRadiologiFile(item)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- FOOTER INFO -->
            <div class="table-info">
                Menampilkan {{ startRowRadiologi }} s/d
                {{ endRowRadiologi }} dari {{ filteredRadiologiData.length }} data
            </div>

            <!-- PAGINATION -->
            <div class="pagination-lab" v-if="totalPagesRadiologi > 1">
                <button
                    :disabled="currentPageRadiologi === 1"
                    @click="currentPageRadiologi--"
                >
                    Previous
                </button>

                <button
                    v-for="page in displayPagesRadiologi"
                    :key="page"
                    :class="[
                        'page-btn',
                        { active: currentPageRadiologi === page },
                    ]"
                    @click="currentPageRadiologi = page"
                >
                    {{ page }}
                </button>

                <button
                    :disabled="currentPageRadiologi === totalPagesRadiologi"
                    @click="currentPageRadiologi++"
                >
                    Next
                </button>
            </div>
        </div>

        <!-- MODAL UPLOAD LAB -->
        <div
            v-if="showLabModal"
            class="modal-overlay"
            @click.self="closeLabModal"
        >
            <div class="modal-content modal-content-large">
                <div class="modal-header">
                    <h3>
                        {{
                            isEditModeLab
                                ? "Edit Hasil Lab"
                                : "Upload Hasil Lab"
                        }}
                    </h3>
                    <button @click="closeLabModal" class="btn-close">×</button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label
                                >No Periksa
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formLab.no_periksa"
                                class="form-control"
                                placeholder="Masukkan No Periksa"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Tanggal Periksa
                                <span class="required">*</span></label
                            >
                            <input
                                type="date"
                                v-model="formLab.tgl_periksa"
                                class="form-control"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label
                                >Jam Periksa
                                <span class="required">*</span></label
                            >
                            <input
                                type="time"
                                v-model="formLab.jam_periksa"
                                class="form-control"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Register <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formLab.register"
                                class="form-control"
                                placeholder="Masukkan No Register"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>MR <span class="required">*</span></label>
                            <input
                                type="text"
                                v-model="formLab.mr"
                                class="form-control"
                                placeholder="Masukkan No MR"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Nama Pasien
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formLab.nama_pasien"
                                class="form-control"
                                placeholder="Masukkan Nama Pasien"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label
                                >Layanan Dari
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formLab.layanan_dari"
                                class="form-control"
                                placeholder="Contoh: LABORATORIUM, POLI IMUNISASI"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Dokter Pengirim
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formLab.dokter_pengirim"
                                class="form-control"
                                placeholder="Masukkan Nama Dokter Pengirim"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            >File Hasil Lab
                            <span class="required">*</span></label
                        >
                        <input
                            type="file"
                            @change="handleLabFileChange"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="form-control"
                            ref="labFileInput"
                        />
                        <small class="form-text">
                            Max 5 MB. Format: PDF, JPG, JPEG, PNG
                        </small>
                        <div
                            v-if="isEditModeLab && formLab.nama_file"
                            class="current-file"
                        >
                            File saat ini:
                            <strong>{{ formLab.nama_file }}</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea
                            v-model="formLab.keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan keterangan tambahan (opsional)"
                        ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button @click="closeLabModal" class="btn-secondary">
                        Batal
                    </button>
                    <button
                        @click="submitLabForm"
                        class="btn-primary"
                        :disabled="!isLabFormValid"
                    >
                        {{ isEditModeLab ? "Update" : "Simpan" }}
                    </button>
                </div>
            </div>
        </div>

        <!-- MODAL UPLOAD RADIOLOGI -->
        <div
            v-if="showRadiologiModal"
            class="modal-overlay"
            @click.self="closeRadiologiModal"
        >
            <div class="modal-content modal-content-large">
                <div class="modal-header">
                    <h3>
                        {{
                            isEditModeRadiologi
                                ? "Edit Hasil Radiologi"
                                : "Upload Hasil Radiologi"
                        }}
                    </h3>
                    <button @click="closeRadiologiModal" class="btn-close">
                        ×
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label
                                >No Radiologi
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formRadiologi.no_radiologi"
                                class="form-control"
                                placeholder="Masukkan No Radiologi"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Tanggal <span class="required">*</span></label
                            >
                            <input
                                type="date"
                                v-model="formRadiologi.tanggal"
                                class="form-control"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label
                                >Nama Pasien
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formRadiologi.nama_pasien"
                                class="form-control"
                                placeholder="Masukkan Nama Pasien"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Register <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formRadiologi.register"
                                class="form-control"
                                placeholder="Masukkan No Register"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label
                                >Pemeriksaan
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formRadiologi.pemeriksaan"
                                class="form-control"
                                placeholder="Masukkan Jenis Pemeriksaan"
                            />
                        </div>

                        <div class="form-group">
                            <label
                                >Dokter Pengirim
                                <span class="required">*</span></label
                            >
                            <input
                                type="text"
                                v-model="formRadiologi.dokter_pengirim"
                                class="form-control"
                                placeholder="Masukkan Nama Dokter Pengirim"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            >File Hasil Radiologi
                            <span class="required">*</span></label
                        >
                        <input
                            type="file"
                            @change="handleRadiologiFileChange"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="form-control"
                            ref="radiologiFileInput"
                        />
                        <small class="form-text">
                            Max 5 MB. Format: PDF, JPG, JPEG, PNG
                        </small>
                        <div
                            v-if="
                                isEditModeRadiologi && formRadiologi.nama_file
                            "
                            class="current-file"
                        >
                            File saat ini:
                            <strong>{{ formRadiologi.nama_file }}</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea
                            v-model="formRadiologi.keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan keterangan tambahan (opsional)"
                        ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button @click="closeRadiologiModal" class="btn-secondary">
                        Batal
                    </button>
                    <button
                        @click="submitRadiologiForm"
                        class="btn-primary"
                        :disabled="!isRadiologiFormValid"
                    >
                        {{ isEditModeRadiologi ? "Update" : "Simpan" }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "HasilLaboratorium",

    props: {
        selectedPatient: {
            type: Object,
            default: null,
        },
    },

    data() {
        return {
            /* ================= LAB ================= */
            perPage: 10,
            currentPage: 1,
            searchQuery: "",
            loading: false,
            data: [],

            showLabModal: false,
            isEditModeLab: false,
            formLab: this.resetLabForm(),

            /* ================= RADIOLOGI ================= */
            perPageRadiologi: 10,
            currentPageRadiologi: 1,
            searchQueryRadiologi: "",
            loadingRadiologi: false,
            dataRadiologi: [],

            showRadiologiModal: false,
            isEditModeRadiologi: false,
            formRadiologi: this.resetRadiologiForm(),

            canVerify: false,
        };
    },

    mounted() {
        this.fetchData();
        this.fetchRadiologiData();
        this.checkPermission();
    },

    computed: {
        /* ================= LAB ================= */
        filteredData() {
            if (!this.searchQuery) return this.data;
            return this.data.filter((row) =>
                Object.values(row).some((val) =>
                    String(val)
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase()),
                ),
            );
        },

        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },

        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredData.slice(start, start + this.perPage);
        },

        displayPages() {
            const pages = [];
            const maxDisplay = 5;
            let start = Math.max(1, this.currentPage - Math.floor(maxDisplay / 2));
            let end = Math.min(this.totalPages, start + maxDisplay - 1);

            if (end - start + 1 < maxDisplay) {
                start = Math.max(1, end - maxDisplay + 1);
            }

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },

        startRow() {
            return this.filteredData.length === 0 ? 0 : (this.currentPage - 1) * this.perPage + 1;
        },

        endRow() {
            return Math.min(this.currentPage * this.perPage, this.filteredData.length);
        },

        /* ================= RADIOLOGI ================= */
        filteredRadiologiData() {
            if (!this.searchQueryRadiologi) return this.dataRadiologi;
            return this.dataRadiologi.filter((row) =>
                Object.values(row).some((val) =>
                    String(val)
                        .toLowerCase()
                        .includes(this.searchQueryRadiologi.toLowerCase()),
                ),
            );
        },

        totalPagesRadiologi() {
            return Math.ceil(this.filteredRadiologiData.length / this.perPageRadiologi);
        },

        paginatedRadiologi() {
            const start = (this.currentPageRadiologi - 1) * this.perPageRadiologi;
            return this.filteredRadiologiData.slice(start, start + this.perPageRadiologi);
        },

        displayPagesRadiologi() {
            const pages = [];
            const maxDisplay = 5;
            let start = Math.max(1, this.currentPageRadiologi - Math.floor(maxDisplay / 2));
            let end = Math.min(this.totalPagesRadiologi, start + maxDisplay - 1);

            if (end - start + 1 < maxDisplay) {
                start = Math.max(1, end - maxDisplay + 1);
            }

            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },

        startRowRadiologi() {
            return this.filteredRadiologiData.length === 0 ? 0 : (this.currentPageRadiologi - 1) * this.perPageRadiologi + 1;
        },

        endRowRadiologi() {
            return Math.min(this.currentPageRadiologi * this.perPageRadiologi, this.filteredRadiologiData.length);
        },

        /* ================= VALIDATION ================= */
        isLabFormValid() {
            return (
                this.formLab.no_periksa &&
                this.formLab.tgl_periksa &&
                this.formLab.jam_periksa &&
                this.formLab.register &&
                this.formLab.mr &&
                this.formLab.nama_pasien &&
                this.formLab.layanan_dari &&
                this.formLab.dokter_pengirim &&
                (this.isEditModeLab || this.formLab.file)
            );
        },

        isRadiologiFormValid() {
            return (
                this.formRadiologi.no_radiologi &&
                this.formRadiologi.tanggal &&
                this.formRadiologi.nama_pasien &&
                this.formRadiologi.register &&
                this.formRadiologi.pemeriksaan &&
                this.formRadiologi.dokter_pengirim &&
                (this.isEditModeRadiologi || this.formRadiologi.file)
            );
        },
    },

    methods: {
        /* ================= UTIL ================= */
        formatDate(date) {
            if (!date) return "-";
            const d = new Date(date);
            return d.toLocaleDateString("id-ID");
        },

        resetLabForm() {
            return {
                uuid: null,
                pasien_uuid: this.selectedPatient?.uuid ?? null,
                no_periksa: "",
                tgl_periksa: "",
                jam_periksa: "",
                register: "",
                mr: "",
                nama_pasien: "",
                layanan_dari: "",
                dokter_pengirim: "",
                file: null,
                nama_file: "",
                keterangan: "",
            };
        },

        resetRadiologiForm() {
            return {
                uuid: null,
                pasien_uuid: this.selectedPatient?.uuid ?? null,
                no_radiologi: "",
                tanggal: "",
                nama_pasien: this.selectedPatient?.nama_pasien ?? "",
                register: "",
                pemeriksaan: "",
                dokter_pengirim: "",
                file: null,
                nama_file: "",
                keterangan: "",
            };
        },

        /* ================= FETCH ================= */
        async fetchData() {
            this.loading = true;
            try {
                const res = await axios.get("/master/pasien/laboratorium/hasil-pemeriksaan");

                const result =
                    res.data?.data?.data ??
                    res.data?.data ??
                    [];

                // 🔥 FORCE REPLACE ARRAY
                this.data = Array.isArray(result) ? [...result] : [];

                // 🔥 RESET PAGINATION
                this.currentPage = 1;
            } catch (error) {
                console.error("Error fetching lab data:", error);
                this.data = [];
            } finally {
                this.loading = false;
            }
        },

        async fetchRadiologiData() {
            this.loadingRadiologi = true;
            try {
                const res = await axios.get("/master/pasien/radiologi/hasil-radiologi");

                const result =
                    res.data?.data?.data ??
                    res.data?.data ??
                    [];

                this.dataRadiologi = Array.isArray(result) ? [...result] : [];
                this.currentPageRadiologi = 1;
            } catch (error) {
                console.error("Error fetching radiologi data:", error);
                this.dataRadiologi = [];
            } finally {
                this.loadingRadiologi = false;
            }
        },

        /* ================= SUBMIT ================= */
        async submitLabForm() {
            if (!this.isLabFormValid) return;
            this.loading = true;

            try {
                const fd = new FormData();
                Object.keys(this.formLab).forEach(k => {
                    if (this.formLab[k] !== null && this.formLab[k] !== "") {
                        fd.append(k, this.formLab[k]);
                    }
                });

                const url = this.isEditModeLab
                    ? `/master/pasien/laboratorium/hasil-update/${this.formLab.uuid}`
                    : `/master/pasien/laboratorium/hasil-upload-laboratorium`;

                await axios.post(url, fd, {
                    headers: { "Content-Type": "multipart/form-data" }
                });

                alert(this.isEditModeLab ? "Data lab berhasil diupdate" : "Data lab berhasil disimpan");
                this.closeLabModal();
                await this.fetchData();
            } catch (error) {
                console.error("Error submitting lab form:", error);
                alert("Terjadi kesalahan saat menyimpan data: " + (error.response?.data?.message || error.message));
            } finally {
                this.loading = false;
            }
        },

        async submitRadiologiForm() {
            if (!this.isRadiologiFormValid) return;
            this.loadingRadiologi = true;

            try {
                const fd = new FormData();
                Object.keys(this.formRadiologi).forEach(k => {
                    if (this.formRadiologi[k] !== null && this.formRadiologi[k] !== "") {
                        fd.append(k, this.formRadiologi[k]);
                    }
                });

                const url = this.isEditModeRadiologi
                    ? `/master/pasien/radiologi/hasil-update/${this.formRadiologi.uuid}`
                    : `/master/pasien/radiologi/hasil-upload-radiologi`;

                await axios.post(url, fd, {
                    headers: { "Content-Type": "multipart/form-data" }
                });

                alert(this.isEditModeRadiologi ? "Data radiologi berhasil diupdate" : "Data radiologi berhasil disimpan");
                this.closeRadiologiModal();
                await this.fetchRadiologiData();
            } catch (error) {
                console.error("Error submitting radiologi form:", error);
                alert("Terjadi kesalahan saat menyimpan data: " + (error.response?.data?.message || error.message));
            } finally {
                this.loadingRadiologi = false;
            }
        },

        /* ================= MODAL ================= */
        openLabModal() {
            this.isEditModeLab = false;
            this.formLab = this.resetLabForm();
            this.showLabModal = true;
        },

        closeLabModal() {
            this.showLabModal = false;
            this.formLab = this.resetLabForm();
            if (this.$refs.labFileInput) {
                this.$refs.labFileInput.value = "";
            }
        },

        openRadiologiModal() {
            this.isEditModeRadiologi = false;
            this.formRadiologi = this.resetRadiologiForm();
            this.showRadiologiModal = true;
        },

        closeRadiologiModal() {
            this.showRadiologiModal = false;
            this.formRadiologi = this.resetRadiologiForm();
            if (this.$refs.radiologiFileInput) {
                this.$refs.radiologiFileInput.value = "";
            }
        },

        /* ================= FILE HANDLERS ================= */
        handleLabFileChange(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi ukuran file (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert("Ukuran file maksimal 5 MB");
                e.target.value = "";
                return;
            }

            // Validasi tipe file
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert("Format file tidak valid. Gunakan PDF, JPG, JPEG, atau PNG");
                e.target.value = "";
                return;
            }

            this.formLab.file = file;
        },

        handleRadiologiFileChange(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi ukuran file (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert("Ukuran file maksimal 5 MB");
                e.target.value = "";
                return;
            }

            // Validasi tipe file
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert("Format file tidak valid. Gunakan PDF, JPG, JPEG, atau PNG");
                e.target.value = "";
                return;
            }

            this.formRadiologi.file = file;
        },

        /* ================= OTHER ================= */
        async checkPermission() {
            try {
                const res = await axios.get("/laboratorium/user-info");
                this.canVerify = res.data?.can_verify ?? false;
            } catch (error) {
                console.error("Error checking permission:", error);
                this.canVerify = false;
            }
        },

        editLab(item) {
            this.isEditModeLab = true;

            // Clone item data ke form
            this.formLab = {
                uuid: item.uuid,
                pasien_uuid: item.pasien_uuid || this.selectedPatient?.uuid || null,
                no_periksa: item.no_periksa || "",
                tgl_periksa: item.tgl_periksa || "",
                jam_periksa: item.jam_periksa || "",
                register: item.register || "",
                mr: item.mr || "",
                nama_pasien: item.pasien_nama || item.nama_pasien || "",
                layanan_dari: item.layanan_dari || "",
                dokter_pengirim: item.dokter_pengirim || "",
                file: null,
                nama_file: item.nama_file || "",
                keterangan: item.keterangan || "",
            };

            this.showLabModal = true;
        },

        editRadiologi(item) {
            this.isEditModeRadiologi = true;

            // Clone item data ke form
            this.formRadiologi = {
                uuid: item.uuid,
                pasien_uuid: item.pasien_uuid || this.selectedPatient?.uuid || null,
                no_radiologi: item.no_radiologi || "",
                tanggal: item.tanggal || "",
                nama_pasien: item.pasien_nama || item.nama_pasien || "",
                register: item.register || "",
                pemeriksaan: item.pemeriksaan || "",
                dokter_pengirim: item.dokter_pengirim || "",
                file: null,
                nama_file: item.nama_file || "",
                keterangan: item.keterangan || "",
            };

            this.showRadiologiModal = true;
        },

        async deleteLab(uuid) {
            if (!confirm("Yakin ingin menghapus hasil lab ini?")) return;

            this.loading = true;
            try {
                await axios.delete(`/master/pasien/laboratorium/hasil/${uuid}`);

                // 🔥 LANGSUNG HAPUS DARI TABLE
                this.data = this.data.filter(item => item.uuid !== uuid);

                alert("Data lab berhasil dihapus");
            } catch (error) {
                console.error("Error deleting lab:", error);
                alert("Terjadi kesalahan saat menghapus data: " + (error.response?.data?.message || error.message));
            } finally {
                this.loading = false;
            }
        },

        async deleteRadiologi(uuid) {
            if (!confirm("Yakin ingin menghapus hasil radiologi ini?")) return;

            this.loadingRadiologi = true;
            try {
                await axios.delete(`/master/pasien/radiologi/hasil/${uuid}`);

                this.dataRadiologi = this.dataRadiologi.filter(item => item.uuid !== uuid);

                alert("Data radiologi berhasil dihapus");
            } catch (error) {
                console.error("Error deleting radiologi:", error);
                alert("Terjadi kesalahan saat menghapus data: " + (error.response?.data?.message || error.message));
            } finally {
                this.loadingRadiologi = false;
            }
        },

        printResult(item) {
            if (!item.uuid) {
                alert("Data tidak valid");
                return;
            }
            const url = `/master/pasien/laboratorium/print/${item.uuid}`;
            window.open(url, "_blank");
        },

        viewRadiologiFile(item) {
            if (!item.uuid) {
                alert("Data tidak valid");
                return;
            }
            // ✅ PERBAIKAN: Gunakan uuid bukan file_path
            const url = `/master/pasien/radiologi/view-file/${item.uuid}`;
            window.open(url, "_blank");
        },
    },
};
</script>

<style scoped>
.lab-container {
    background: white;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #ddd;
    position: relative;
}

.header-component-lab {
    background: #1e5ba8;
    color: white;
    text-align: center;
    padding: 12px;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 15px;
    border-radius: 4px;
}

.filter-bar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
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
    align-items: center;
    gap: 8px;
}

.search-input {
    padding: 5px 10px;
    border: 1px solid #aaa;
    border-radius: 3px;
    width: 200px;
}

/* TABLE */
.custom-table-lab {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
    font-size: 13px;
}

.custom-table-lab th {
    background: #1e5ba8;
    color: white;
    padding: 10px 8px;
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid #1648a0;
}

.custom-table-lab td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.custom-table-lab tbody tr:nth-child(even) {
    background: #f0f7ff;
}

.custom-table-lab tbody tr:hover {
    background: #e3f2fd;
}

.action-icon {
    cursor: pointer;
    font-size: 16px;
    margin: 0 5px;
    transition: all 0.2s;
}

.fa-edit {
    color: #ffc107;
}

.fa-edit:hover {
    color: #e0a800;
}

.fa-trash {
    color: #dc3545;
}

.fa-trash:hover {
    color: #c82333;
}

.fa-print {
    color: #1e5ba8;
}

.fa-print:hover {
    color: #164890;
}

/* INFO */
.table-info {
    margin: 10px 0;
    font-size: 13px;
    color: #555;
}

/* PAGINATION */
.pagination-lab {
    display: flex;
    gap: 5px;
    margin-top: 10px;
}

.pagination-lab button {
    padding: 6px 12px;
    border: 1px solid #1e5ba8;
    background: white;
    cursor: pointer;
    border-radius: 3px;
    font-size: 13px;
    transition: all 0.2s;
}

.pagination-lab button:hover:not(:disabled) {
    background: #e3f2fd;
}

.pagination-lab button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-btn.active {
    background: #1e5ba8;
    color: white;
}

/* LOADING OVERLAY */
.loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    z-index: 10;
    border-radius: 5px;
}

.spinner-lab {
    width: 40px;
    height: 40px;
    border: 4px solid #e0e0e0;
    border-top-color: #1e5ba8;
    border-radius: 50%;
    animation: spin-lab 0.8s linear infinite;
    margin-bottom: 10px;
}

@keyframes spin-lab {
    to {
        transform: rotate(360deg);
    }
}

/* SECTION WRAPPER */
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
    transition: background 0.2s;
}

.btn-add:hover {
    background: #218838;
}

.btn-add span {
    font-size: 18px;
    margin-right: 5px;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}

/* MODAL */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
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
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.modal-content-large {
    max-width: 800px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 2px solid #1e5ba8;
    background: #f8f9fa;
}

.modal-header h3 {
    margin: 0;
    font-size: 18px;
    color: #1e5ba8;
}

.btn-close {
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    color: #999;
    line-height: 1;
    padding: 0;
    width: 30px;
    height: 30px;
}

.btn-close:hover {
    color: #333;
}

.modal-body {
    padding: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 14px;
    color: #333;
}

.required {
    color: red;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #1e5ba8;
    box-shadow: 0 0 0 2px rgba(30, 91, 168, 0.1);
}

.form-text {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}

.current-file {
    margin-top: 8px;
    padding: 8px 12px;
    background: #f0f7ff;
    border-radius: 4px;
    font-size: 13px;
    border-left: 3px solid #1e5ba8;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 15px 20px;
    border-top: 1px solid #ddd;
    background: #f8f9fa;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-primary {
    background: #1e5ba8;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-primary:hover {
    background: #164890;
}

.btn-primary:disabled {
    background: #ccc;
    cursor: not-allowed;
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
    }

    .search-input {
        width: 100%;
    }

    .custom-table-lab {
        font-size: 11px;
    }

    .custom-table-lab th,
    .custom-table-lab td {
        padding: 6px 4px;
    }

    .modal-content {
        width: 95%;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: row;
        flex-wrap: wrap;
    }
}
</style>