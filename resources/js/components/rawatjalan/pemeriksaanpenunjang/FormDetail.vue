<template>
    <div :style="terminate.display" class="modal">
        <div ref="rootmodal" class="modal-content modal-besar"
            :class="terminate.show ? 'modal-opened' : 'modal-closed'">
            <div class="modal-header">
                <span class="close" v-on:click="hide()">&times;</span>
                <h2>Detail Pemeriksaan Penunjang</h2>
                <!-- Tombol Sudah Upload Penunjang -->
                <button
                    v-if="detail.status_dokter === 'Pemeriksaan Penunjang'"
                    v-on:click="actionSudahUpload()"
                    style="position:absolute; right:55px; top:12.5px; background:#1a6f1d; border-color:#18511a;">
                    Sudah Upload Penunjang
                </button>
            </div>
            <div class="modal-body">
                <!-- Foto + Info Singkat Pasien -->
                <div style="display:flex; align-items:center; gap:16px; padding:12px 0 14px; border-bottom:1px solid #eee; margin-bottom:16px;">
                    <img
                        :src="detail.photos ? '/' + detail.photos : '/default-avatar.png'"
                        alt="Foto Pasien"
                        @error="$event.target.src='/default-avatar.png'"
                        style="width:72px; height:72px; border-radius:50%; object-fit:cover; border:3px solid #e0e0e0; box-shadow:0 2px 8px rgba(0,0,0,0.12); flex-shrink:0;"
                    />
                    <div>
                        <div style="font-size:15px; font-weight:700; color:#222;">{{ detail.nama_pasien }}</div>
                        <div style="font-size:12px; color:#666; margin-top:2px;">{{ detail.rekam_medis }}</div>
                        <div style="font-size:12px; color:#888;">
                            {{ detail.jenis_kelamin }} &bull;
                            {{ detail.tanggal_lahir ? datename(detail.tanggal_lahir) : '' }}
                            <span v-if="detail.tanggal_lahir"> &bull; {{ countage(detail.tanggal_lahir) }}</span>
                        </div>
                    </div>
                    <!-- Badge status -->
                    <div style="margin-left:auto;">
                        <span :style="statusBadgeStyle(detail.status_dokter)" style="padding:5px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                            {{ detail.status_dokter }}
                        </span>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid" style="margin-bottom:16px;">
                    <div class="col-4 form-mr">
                        <ul class="list-detail">
                            <li>No Pendaftaran<span><strong>{{ detail.no_pendaftaran }}</strong></span></li>
                            <li>No Rekam Medis<span><strong>{{ detail.rekam_medis }}</strong></span></li>
                            <li>Penjamin<span><strong>{{ detail.carabayar_nama }}</strong></span></li>
                            <li>Nama Lengkap<span><strong>{{ detail.nama_pasien }}</strong></span></li>
                        </ul>
                    </div>
                    <div class="col-4 form-mr">
                        <ul class="list-detail">
                            <li>Tanggal Lahir<span><strong>{{ detail.tanggal_lahir ? datename(detail.tanggal_lahir) : '-' }}</strong></span></li>
                            <li>Umur<span><strong>{{ detail.tanggal_lahir ? countage(detail.tanggal_lahir) : '-' }}</strong></span></li>
                            <li>Jenis Kelamin<span><strong>{{ detail.jenis_kelamin }}</strong></span></li>
                            <li>No Handphone<span><strong>{{ detail.no_handphone }}</strong></span></li>
                        </ul>
                    </div>
                    <div class="col-4 form-mr">
                        <ul class="list-detail">
                            <li>Dokter<span><strong>{{ detail.nama_dokter }}</strong></span></li>
                            <li>Tanggal Daftar<span><strong>{{ detail.tanggal ? datename(detail.tanggal) : '-' }}</strong></span></li>
                            <li>Jenis<span><strong>{{ detail.jenis }}</strong></span></li>
                            <li>Status<span><strong>{{ detail.status_dokter }}</strong></span></li>
                        </ul>
                    </div>
                </div>

                <!-- ===== DOKUMEN PENUNJANG ===== -->
                <div style="border-top:2px solid #e2e8f0; padding-top:18px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                        <h3 style="font-size:14px; font-weight:700; color:#1a4f8a; margin:0;">
                            Dokumen Pemeriksaan Penunjang
                        </h3>
                        <button @click="openAddDokumen()" class="button-modal-page button-modal-green" style="background:#1a4f8a; border-color:#1a4f8a;">
                            + Tambah Dokumen
                        </button>
                    </div>

                    <!-- Loading -->
                    <div v-if="loadingDokumen" style="text-align:center; padding:20px; color:#888;">
                        Memuat dokumen...
                    </div>

                    <!-- Table -->
                    <table v-else style="width:100%; border-collapse:collapse; font-size:13px;">
                        <thead>
                            <tr style="background:#f0f4f8; border-bottom:2px solid #e2e8f0;">
                                <th style="padding:8px 12px; text-align:left; color:#555; font-weight:700; width:30px;">NO</th>
                                <th style="padding:8px 12px; text-align:left; color:#555; font-weight:700;">JENIS DOKUMEN</th>
                                <th style="padding:8px 12px; text-align:left; color:#555; font-weight:700;">NAMA FILE</th>
                                <th style="padding:8px 12px; text-align:left; color:#555; font-weight:700;">KETERANGAN</th>
                                <th style="padding:8px 12px; text-align:left; color:#555; font-weight:700;">TANGGAL UPLOAD</th>
                                <th style="padding:8px 12px; text-align:left; color:#555; font-weight:700;">DIUPLOAD OLEH</th>
                                <th style="padding:8px 12px; text-align:center; color:#555; font-weight:700;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="dataDokumen.length === 0">
                                <td colspan="7" style="text-align:center; padding:24px; color:#999;">Belum ada dokumen pemeriksaan penunjang</td>
                            </tr>
                            <tr v-for="(item, idx) in dataDokumen" :key="item.uuid"
                                :style="idx % 2 === 0 ? 'background:#fff;' : 'background:#f9fafb;'"
                                style="border-bottom:1px solid #eee;">
                                <td style="padding:8px 12px;">{{ idx + 1 }}</td>
                                <td style="padding:8px 12px;">{{ item.jenis_dokumen }}</td>
                                <td style="padding:8px 12px;">
                                    <a @click.prevent="previewDokumen(item)"
                                       style="color:#1a4f8a; cursor:pointer; text-decoration:underline;">
                                        {{ item.nama_file }}
                                    </a>
                                </td>
                                <td style="padding:8px 12px;">{{ item.keterangan || '-' }}</td>
                                <td style="padding:8px 12px;">{{ item.tanggal_upload }}</td>
                                <td style="padding:8px 12px;">{{ item.uploaded_by_nama }}</td>
                                <td style="padding:8px 12px; text-align:center;">
                                    <button @click="deleteDokumen(item)"
                                        style="padding:4px 10px; border:1px solid #e53e3e; border-radius:4px; background:#fff; color:#e53e3e; font-size:11px; cursor:pointer; font-weight:600;">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <Loader ref="Loader"></Loader>
        </div>
    </div>

    <!-- ===== MODAL TAMBAH DOKUMEN ===== -->
    <div v-if="showDokumenModal"
         style="position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:99999;display:flex;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:10px;box-shadow:0 8px 40px rgba(0,0,0,0.25);width:92%;max-width:520px;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;background:#1a4f8a;border-radius:10px 10px 0 0;">
                <span style="color:#fff;font-weight:700;font-size:15px;">Tambah Dokumen Penunjang</span>
                <span @click="showDokumenModal=false" style="color:#fff;font-size:24px;cursor:pointer;">&times;</span>
            </div>
            <div style="padding:20px 24px;">
                <div style="margin-bottom:14px;">
                    <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:4px;">
                        Jenis Dokumen <span style="color:red;">*</span>
                    </label>
                    <select v-model="formDokumen.jenis_dokumen"
                        style="width:100%;padding:8px 10px;border:1px solid #cbd5e0;border-radius:6px;font-size:13px;background:#fff;box-sizing:border-box;">
                        <option value="">-- Pilih Jenis Dokumen --</option>
                        <option value="Pemeriksaan Penunjang Mata">Pemeriksaan Penunjang Mata</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Radiologi">Radiologi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:4px;">
                        File <span style="color:red;">*</span>
                    </label>
                    <input type="file" @change="handleFileChange"
                        accept=".pdf,.bmp,.jpg,.jpeg,.png"
                        style="width:100%;padding:6px;border:1px solid #cbd5e0;border-radius:6px;font-size:13px;box-sizing:border-box;" />
                    <small style="display:block;margin-top:5px;font-size:12px;color:#666;">Max 1 MB. Format: PDF, BMP, JPG, JPEG, PNG</small>
                </div>
                <div style="margin-bottom:6px;">
                    <label style="font-size:13px;font-weight:600;color:#444;display:block;margin-bottom:4px;">Keterangan</label>
                    <textarea v-model="formDokumen.keterangan" rows="3"
                        style="width:100%;padding:8px 10px;border:1px solid #cbd5e0;border-radius:6px;font-size:13px;box-sizing:border-box;resize:vertical;"
                        placeholder="Keterangan dokumen (opsional)"></textarea>
                </div>
            </div>
            <div style="padding:12px 24px;border-top:1px solid #eee;display:flex;justify-content:flex-end;gap:10px;background:#fafafa;border-radius:0 0 10px 10px;">
                <button @click="showDokumenModal=false"
                    style="padding:8px 20px;border:1px solid #ccc;border-radius:5px;background:#fff;cursor:pointer;font-size:13px;font-weight:600;color:#555;">
                    Batal
                </button>
                <button @click="submitDokumen()" :disabled="savingDokumen || !isDokumenValid"
                    style="padding:8px 22px;border:none;border-radius:5px;background:#1a4f8a;color:#fff;cursor:pointer;font-size:13px;font-weight:700;"
                    :style="(savingDokumen || !isDokumenValid) ? 'opacity:0.6;cursor:not-allowed;' : ''">
                    {{ savingDokumen ? 'Menyimpan...' : 'Simpan' }}
                </button>
            </div>
        </div>
    </div>

    <!-- ===== MODAL PREVIEW FILE ===== -->
    <div v-if="showPreviewModal"
         style="position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:99999;display:flex;align-items:center;justify-content:center;"
         @click.self="showPreviewModal=false">
        <div style="background:#fff;border-radius:10px;width:92%;max-width:900px;height:88vh;display:flex;flex-direction:column;overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;background:#1a4f8a;flex-shrink:0;">
                <span style="color:#fff;font-weight:700;font-size:14px;">Preview: {{ previewItem?.nama_file }}</span>
                <span @click="showPreviewModal=false" style="color:#fff;font-size:24px;cursor:pointer;">&times;</span>
            </div>
            <div style="flex:1;overflow:hidden;">
                <iframe v-if="previewItem"
                    :src="'/print/rekammedis/dokumen/' + previewItem.uuid"
                    style="width:100%;height:100%;border:0;display:block;"></iframe>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { defineAsyncComponent } from 'vue';
import { datename, countage } from '../../../module/Manipulation.js';

var vm, body;
export default {
    emits: ['dialog', 'parsingForm'],
    components: {
        Loader: defineAsyncComponent(() => import('../../../section/Loader.vue')),
    },
    data: function () {
        return {
            terminate: { show: false, display: 'display: none' },
            detail: {},
            loadingDokumen: false,
            dataDokumen: [],
            showDokumenModal: false,
            savingDokumen: false,
            formDokumen: { jenis_dokumen: '', file: null, keterangan: '' },
            showPreviewModal: false,
            previewItem: null,
        };
    },
    computed: {
        isDokumenValid() {
            return this.formDokumen.jenis_dokumen !== '' && this.formDokumen.file !== null;
        },
    },
    mounted: function () {
        vm = this;
        body = document.body;
    },
    methods: {
        datename,
        countage,

        statusBadgeStyle(status) {
            if (status === 'Pemeriksaan Penunjang') return 'background:#fff3cd; color:#856404;';
            if (status === 'Sudah Upload Penunjang') return 'background:#d4edda; color:#155724;';
            return 'background:#e2e8f0; color:#4a5568;';
        },

        show: function (posisi, title, uuid) {
            vm.terminate.display = 'display: block';
            vm.terminate.show = true;
            body.style.overflowY = 'hidden';
        },

        hide: function () {
            vm.terminate.show = false;
            setTimeout(function () {
                vm.terminate.display = 'display: none';
                body.style.overflowY = 'auto';
            }, 300);
        },

        aturulang: function () {
            vm.detail = {};
            vm.dataDokumen = [];
            vm.formDokumen = { jenis_dokumen: '', file: null, keterangan: '' };
            vm.showDokumenModal = false;
            vm.showPreviewModal = false;
        },

        loaderprocess: function () {
            const left = this.$refs.rootmodal.getBoundingClientRect();
            vm.$refs.Loader.running(left, 'modal', 250);
        },

        setdataform: function (response) {
            vm.detail = response.data.data;
            vm.loaderprocess(); // toggle loader OFF (was toggled ON by loadingModal before API call)
            vm.fetchDokumen();
        },

        fetchDokumen: async function () {
            if (!vm.detail || !vm.detail.pasien_uuid) return;
            vm.loadingDokumen = true;
            try {
                const fd = new FormData();
                fd.append('search', vm.detail.pasien_uuid);
                fd.append('limit', 100);
                fd.append('page', 1);
                const res = await axios.post('/master/pasien/dokumen-list', fd);
                vm.dataDokumen = (res.data?.data ?? []).filter(d =>
                    ['Pemeriksaan Penunjang Mata', 'Laboratorium', 'Radiologi', 'Lainnya'].includes(d.jenis_dokumen)
                );
            } catch (e) {
                console.error('Gagal memuat dokumen:', e);
            } finally {
                vm.loadingDokumen = false;
            }
        },

        openAddDokumen: function () {
            vm.formDokumen = { jenis_dokumen: '', file: null, keterangan: '' };
            vm.showDokumenModal = true;
        },

        handleFileChange: function (event) {
            const file = event.target.files[0];
            if (!file) return;
            if (file.size > 1024 * 1024) {
                alert('Ukuran file maksimal 1 MB');
                event.target.value = '';
                vm.formDokumen.file = null;
                return;
            }
            vm.formDokumen.file = file;
        },

        submitDokumen: async function () {
            if (!vm.isDokumenValid) return;
            vm.savingDokumen = true;
            try {
                const fd = new FormData();
                fd.append('pasien_uuid', vm.detail.pasien_uuid);
                fd.append('jenis_dokumen', vm.formDokumen.jenis_dokumen);
                fd.append('file', vm.formDokumen.file);
                fd.append('keterangan', vm.formDokumen.keterangan || '');
                const res = await axios.post('/master/pasien/dokumen-store', fd, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });
                if (res.data?.status || res.data?.data === 'berhasil' || res.status === 201 || res.status === 200) {
                    vm.showDokumenModal = false;
                    vm.fetchDokumen();
                } else {
                    alert('Gagal menyimpan dokumen: ' + (res.data?.message || 'Terjadi kesalahan'));
                }
            } catch (e) {
                alert('Gagal menyimpan dokumen. Silakan coba lagi.');
                console.error(e);
            } finally {
                vm.savingDokumen = false;
            }
        },

        deleteDokumen: async function (item) {
            if (!confirm('Yakin ingin menghapus dokumen ini?')) return;
            try {
                const fd = new FormData();
                fd.append('uuid', item.uuid);
                await axios.post('/master/pasien/dokumen-delete', fd);
                vm.fetchDokumen();
            } catch (e) {
                alert('Gagal menghapus dokumen.');
            }
        },

        previewDokumen: function (item) {
            vm.previewItem = item;
            vm.showPreviewModal = true;
        },

        actionSudahUpload: function () {
            const fd = new FormData();
            fd.append('uuid', vm.detail.uuid);
            vm.$emit('parsingForm', fd, 'sudah-upload');
            vm.$emit('dialog', 'Yakin ingin menandai sudah upload pemeriksaan penunjang?', 'Ya, konfirmasi', 'sudah-upload');
        },
    },
};
</script>
