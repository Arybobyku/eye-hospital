<template>
<div class="inner" ref="roottable">

    <!-- ── Filter Bar ── -->
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:14px 18px;margin-bottom:14px;display:flex;flex-wrap:wrap;align-items:center;gap:12px;">
        <!-- Filter Jenis -->
        <div style="display:flex;gap:6px;align-items:center;">
            <span style="font-size:12px;font-weight:600;color:#555;margin-right:4px;">Jenis:</span>
            <button
                v-for="opt in filterJenisOptions" :key="opt.value"
                @click="setFilterJenis(opt.value)"
                :style="filter.jenis === opt.value
                    ? 'padding:5px 14px;border-radius:20px;border:none;cursor:pointer;font-size:12px;font-weight:600;background:#1a4f8a;color:#fff;'
                    : 'padding:5px 14px;border-radius:20px;border:1px solid #cbd5e0;cursor:pointer;font-size:12px;font-weight:500;background:#fff;color:#555;'">
                {{ opt.label }}
            </button>
        </div>

        <!-- Divider -->
        <div style="width:1px;height:28px;background:#e2e8f0;"></div>

        <!-- Filter Tanggal -->
        <div style="display:flex;align-items:center;gap:8px;">
            <span style="font-size:12px;font-weight:600;color:#555;">Tanggal:</span>
            <input type="date" v-model="filter.tanggal_dari" @change="applyFilter()"
                style="padding:5px 10px;border:1px solid #cbd5e0;border-radius:6px;font-size:12px;cursor:pointer;" />
            <span style="font-size:12px;color:#888;">s/d</span>
            <input type="date" v-model="filter.tanggal_sampai" @change="applyFilter()"
                style="padding:5px 10px;border:1px solid #cbd5e0;border-radius:6px;font-size:12px;cursor:pointer;" />
            <button v-if="filter.tanggal_dari || filter.tanggal_sampai" @click="clearDate()"
                style="padding:5px 10px;border:1px solid #e53e3e;border-radius:6px;font-size:12px;cursor:pointer;background:#fff;color:#e53e3e;font-weight:600;">
                Reset
            </button>
        </div>
    </div>

    <Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
    <Loader ref="Loader"></Loader>
</div>

<!-- ── Modal Dokumen Viewer ── -->
<div v-if="showDokumenModal"
    style="position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:99990;display:flex;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#fff;border-radius:10px;box-shadow:0 10px 40px rgba(0,0,0,0.25);width:100%;max-width:620px;max-height:80vh;display:flex;flex-direction:column;">
        <!-- Header -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;background:#1a4f8a;border-radius:10px 10px 0 0;">
            <span style="color:#fff;font-weight:700;font-size:14px;">
                <vue-feather :type="dokumenModal.tipe === 'penunjang' ? 'file-plus' : 'file-text'"
                    style="width:15px;height:15px;margin-right:6px;vertical-align:middle;"></vue-feather>
                {{ dokumenModal.tipe === 'penunjang' ? 'Hasil Penunjang' : 'Hasil Laporan' }} — {{ dokumenModal.nama_pasien }}
            </span>
            <span @click="showDokumenModal = false"
                style="color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0 4px;">&times;</span>
        </div>
        <!-- Body -->
        <div style="padding:18px 20px;overflow-y:auto;flex:1;">
            <div v-if="dokumenModal.loading" style="text-align:center;padding:32px;color:#888;font-size:13px;">
                Memuat dokumen...
            </div>
            <div v-else-if="dokumenModal.list.length === 0" style="text-align:center;padding:32px;color:#888;font-size:13px;">
                <vue-feather type="inbox" style="width:36px;height:36px;display:block;margin:0 auto 10px;opacity:0.4;"></vue-feather>
                Belum ada dokumen {{ dokumenModal.tipe === 'penunjang' ? 'penunjang' : 'laporan' }}.
            </div>
            <div v-else>
                <div v-for="(doc, i) in dokumenModal.list" :key="doc.uuid"
                    style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border:1px solid #e2e8f0;border-radius:7px;margin-bottom:8px;background:#f8fafc;">
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:12px;font-weight:600;color:#1a4f8a;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ doc.nama_file }}
                        </div>
                        <div style="font-size:11px;color:#888;">
                            {{ doc.jenis_dokumen }}
                            <span v-if="doc.keterangan"> · {{ doc.keterangan }}</span>
                            <span> · {{ doc.tanggal_upload }}</span>
                            <span v-if="doc.uploaded_by_nama"> · {{ doc.uploaded_by_nama }}</span>
                        </div>
                    </div>
                    <a :href="'/storage/' + doc.file_path" target="_blank"
                        style="margin-left:12px;padding:5px 14px;background:#1a4f8a;color:#fff;border-radius:5px;font-size:12px;font-weight:600;text-decoration:none;white-space:nowrap;flex-shrink:0;">
                        <vue-feather type="eye" style="width:13px;height:13px;vertical-align:middle;margin-right:4px;"></vue-feather>
                        Lihat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
    emits: ["titletrigger", "repatch"],
    beforeUnmount: function () {},
    components: { toast, Swal,
        Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
    },
    created: function () {},
    mounted: function () {
        vm = this;
        setTimeout(() => { this.titletrigger(); }, 250);
        vm.loaddata();
    },
    data: function () { return {
        position: '',
        filter: {
            jenis: '',
            tanggal_dari: '',
            tanggal_sampai: '',
        },
        filterJenisOptions: [
            { value: '', label: 'Semua' },
            { value: 'Rawat Jalan', label: 'Rawat Jalan' },
            { value: 'Rawat Inap', label: 'Rawat Inap' },
        ],
        attach: {
            link: {
                list: '/finance/claimdokumen/list',
                getDokumen: '/finance/claimdokumen/get-dokumen',
                resumePrint: '/print/rekammedis/lampiran/rekam-medis-rawat-jalan/',
                tindakanPrint: '/print/rekammedis/rawat-jalan/cpptpoli/',
            },
            url: '', data: null,
        },
        column: [
            { value: 'tanggal',     label: 'Tgl Registrasi',   type: 'text', search: true,  close: false, button: false },
            // { value: 'rekam_medis', label: 'No. Rekam Medis',  type: 'text', search: true,  close: false, button: false },
            { value: 'nama_pasien', label: 'Nama Pasien',       type: 'text', search: true,  close: false, button: false },
            { value: 'jenis',       label: 'Jenis',             type: 'text', search: false, close: false, button: false },
            { value: 'resume_medis',label: 'Resume Medis',      type: 'text', search: false, close: false, button: false },
            { value: 'hasil_tindakan', label: 'Hasil Tindakan', type: 'text', search: false, close: false, button: false },
            { value: 'hasil_laporan',  label: 'Hasil Laporan',  type: 'text', search: false, close: false, button: false },
            { value: 'hasil_penunjang',label: 'Hasil Penunjang',type: 'text', search: false, close: false, button: false },
        ],
        module: { data: [], column: [], total: 0, ispaging: true },
        showDokumenModal: false,
        dokumenModal: {
            loading: false,
            tipe: 'penunjang',
            nama_pasien: '',
            pasien_uuid: '',
            list: [],
        },
    }},
    methods: {

        /*************************************************************************************
         * Helper
         *************************************************************************************/
        nullAndZero, datename,

        setFilterJenis: function (val) {
            vm.filter.jenis = val;
            vm.applyFilter();
        },

        clearDate: function () {
            vm.filter.tanggal_dari = '';
            vm.filter.tanggal_sampai = '';
            vm.applyFilter();
        },

        applyFilter: function () {
            if (vm.$refs.Datatable) { vm.$refs.Datatable.skeleton(); }
            var fd = new FormData();
            fd.append('search', '');
            fd.append('column', 'nama_pasien');
            fd.append('page', 1);
            fd.append('jenis', vm.filter.jenis);
            fd.append('tanggal_dari', vm.filter.tanggal_dari);
            fd.append('tanggal_sampai', vm.filter.tanggal_sampai);
            vm.attach.url = vm.attach.link.list;
            vm.attach.data = fd;
            vm.position = 'externaltable';
            vm.executions();
        },

        /*************************************************************************************
         * Table
         *************************************************************************************/

        badgeJenis: function (jenis) {
            if (jenis === 'Rawat Jalan') {
                return '<span style="display:inline-block;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#dbeafe;color:#1e40af;">' + jenis + '</span>';
            }
            if (jenis === 'Rawat Inap') {
                return '<span style="display:inline-block;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#fef9c3;color:#854d0e;">' + jenis + '</span>';
            }
            return '<span style="display:inline-block;padding:2px 10px;border-radius:12px;font-size:11px;background:#f1f5f9;color:#64748b;">' + (jenis || '-') + '</span>';
        },

        badgeResumeMedis: function (data) {
            if (parseInt(data.ada_resume) > 0) {
                return '<a href="' + vm.attach.link.resumePrint + data.uuid + '" target="_blank" '
                    + 'style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#dcfce7;color:#15803d;text-decoration:none;cursor:pointer;">'
                    + '&#128196; Tersedia</a>';
            }
            return '<span style="display:inline-block;padding:2px 10px;border-radius:12px;font-size:11px;background:#f1f5f9;color:#94a3b8;">Belum Ada</span>';
        },

        badgeHasilTindakan: function (data) {
            return '<a href="' + vm.attach.link.tindakanPrint + data.uuid + '" target="_blank" '
                + 'style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#e0f2fe;color:#0369a1;text-decoration:none;cursor:pointer;">'
                + '&#128203; Lihat</a>';
        },

        badgeHasilLaporan: function (data) {
            var count = parseInt(data.ada_laporan) || 0;
            if (count > 0) {
                return '<button onclick="window.__claimDokumenLihat(\'' + data.pasien_uuid + '\',\'' + data.nama_pasien.replace(/'/g, '') + '\',\'laporan\')" '
                    + 'style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#fef3c7;color:#92400e;border:none;cursor:pointer;">'
                    + '&#128196; ' + count + ' Dokumen</button>';
            }
            return '<span style="display:inline-block;padding:2px 10px;border-radius:12px;font-size:11px;background:#f1f5f9;color:#94a3b8;">Belum Ada</span>';
        },

        badgeHasilPenunjang: function (data) {
            var count = parseInt(data.ada_penunjang) || 0;
            if (count > 0) {
                return '<button onclick="window.__claimDokumenLihat(\'' + data.pasien_uuid + '\',\'' + data.nama_pasien.replace(/'/g, '') + '\',\'penunjang\')" '
                    + 'style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#f3e8ff;color:#7e22ce;border:none;cursor:pointer;">'
                    + '&#128203; ' + count + ' Dokumen</button>';
            }
            return '<span style="display:inline-block;padding:2px 10px;border-radius:12px;font-size:11px;background:#f1f5f9;color:#94a3b8;">Belum Ada</span>';
        },

        converter: function (data, index, column, identity) {
            var _tmp = '';
            if (identity === 'tanggal') {
                _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' };
            } else if (identity === 'jenis') {
                _tmp = { value: vm.badgeJenis(column), ishtml: 'html', style: '' };
            } else if (identity === 'resume_medis') {
                _tmp = { value: vm.badgeResumeMedis(data), ishtml: 'html', style: 'text-align:center;' };
            } else if (identity === 'hasil_tindakan') {
                _tmp = { value: vm.badgeHasilTindakan(data), ishtml: 'html', style: 'text-align:center;' };
            } else if (identity === 'hasil_laporan') {
                _tmp = { value: vm.badgeHasilLaporan(data), ishtml: 'html', style: 'text-align:center;' };
            } else if (identity === 'hasil_penunjang') {
                _tmp = { value: vm.badgeHasilPenunjang(data), ishtml: 'html', style: 'text-align:center;' };
            } else {
                _tmp = { value: column, ishtml: 'text', style: '' };
            }
            return _tmp !== '' ? _tmp : 'empty';
        },

        setDatatable: function (data, total) {
            var temporer = [], col = [];
            for (var i = 0; i < data.length; i++) {
                col = [];
                for (var j = 0; j < vm.column.length; j++) {
                    col.push(vm.converter(
                        data[i], i,
                        data[i][vm.column[j].value] !== undefined ? data[i][vm.column[j].value] : vm.column[j].value,
                        vm.column[j].value
                    ));
                }
                temporer.push(col);
            }
            vm.module.data = temporer;
            vm.module.total = total;
            return temporer;
        },

        tableload: function () {
            vm.attach.url = vm.attach.link.list;
            vm.attach.data = new FormData();
            vm.attach.data.append('search', '');
            vm.attach.data.append('column', 'nama_pasien');
            vm.attach.data.append('page', 1);
            vm.attach.data.append('jenis', vm.filter.jenis);
            vm.attach.data.append('tanggal_dari', vm.filter.tanggal_dari);
            vm.attach.data.append('tanggal_sampai', vm.filter.tanggal_sampai);
            vm.executions();
        },

        tablereload: function (data, pos) {
            if (data === undefined) { data = new FormData(); }
            if (pos === 'outer') { vm.$refs.Datatable.skeleton(); }
            // Append custom filter params to whatever datatable sends
            data.append('jenis', vm.filter.jenis);
            data.append('tanggal_dari', vm.filter.tanggal_dari);
            data.append('tanggal_sampai', vm.filter.tanggal_sampai);
            vm.attach.url = vm.attach.link.list;
            vm.attach.data = data;
            vm.position = 'externaltable';
            vm.executions();
        },

        tablebutton: function (posisi, data, index) {
            // No table action buttons on this page; actions handled via inline HTML buttons
        },

        /*************************************************************************************
         * Dokumen modal
         *************************************************************************************/

        lihatDokumen: function (pasien_uuid, nama_pasien, tipe) {
            vm.dokumenModal.pasien_uuid = pasien_uuid;
            vm.dokumenModal.nama_pasien = nama_pasien;
            vm.dokumenModal.tipe = tipe;
            vm.dokumenModal.list = [];
            vm.dokumenModal.loading = true;
            vm.showDokumenModal = true;

            var fd = new FormData();
            fd.append('pasien_uuid', pasien_uuid);
            fd.append('tipe', tipe);

            axios.post(vm.attach.link.getDokumen, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
                .then(function (res) {
                    vm.dokumenModal.list = res.data.data || [];
                })
                .catch(function () {
                    vm.dokumenModal.list = [];
                    vm.notification('Gagal memuat dokumen.', 3000, 'error');
                })
                .finally(function () {
                    vm.dokumenModal.loading = false;
                });
        },

        /*************************************************************************************
         * Lifecycle helpers
         *************************************************************************************/

        loaddata: function () {
            vm.position = 'loaddata';
            vm.firstloader();
            vm.tableload();
            // Expose helper to window for inline HTML button clicks
            window.__claimDokumenLihat = function (pasien_uuid, nama_pasien, tipe) {
                vm.lihatDokumen(pasien_uuid, nama_pasien, tipe);
            };
        },

        gagal: function (error) {
            if (vm.$debugs) { console.log(error.response); }
            vm.message('error', 1);
            var active = 0;
            if (vm.position === 'loaddata') { vm.firstloader(); active = 1; }
            else if (vm.position === 'externaltable') {
                vm.$refs.Datatable.skeleton();
                vm.$refs.Datatable.backpage();
            }
            if (active === 1) { setTimeout(function () { vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }); }, 250, this); }
        },

        berhasil: function (response) {
            if (vm.$debugs) { console.log(response.data); }
            var active = 1;
            if (response.data.data === '403') { vm.$router.push('/dashboard/forbidden'); }

            if (vm.position === 'loaddata') {
                vm.firstloader();
                vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total);
                vm.$refs.Datatable.paging();
                active = 0;
            } else if (vm.position === 'externaltable') {
                vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total);
                vm.$refs.Datatable.skeleton();
                vm.$refs.Datatable.paging();
                active = 0;
            }

            vm.message('success', active);
        },

        message: function (position, active) {
            if (position === 'error') {
                if (vm.position === 'loaddata') { vm.notification('Data gagal dimuat.', 3000, position); }
                else if (vm.position === 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
            }
        },

        runconfirm: function (posisi) { vm.executions(); },

        /*************************************************************************************
         * Standard helpers — jangan diubah
         *************************************************************************************/
        executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data === '419') { window.location.href = '/masuk'; } setTimeout(function () { vm.berhasil(response); }, 750, this); }).catch(function (error) { setTimeout(function () { vm.gagal(error); }, 750, this); }); },
        dialog: function (_text, _confirm, posisi) { Swal.fire({ title: 'Apakah Anda Yakin?', text: _text, icon: 'warning', showCancelButton: true, confirmButtonColor: '#1c84ee', cancelButtonColor: '#fd625e', confirmButtonText: _confirm, cancelButtonText: 'Tidak, batal!' }).then(function (e) { if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
        notification: function (message, timer, position) { if (position === 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
        loadPatch: function () { vm.firstloader(); },
        firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
        unloadPatch: function (position) { vm.firstloader(); if (position === 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position === 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
        titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); },
    }
}
</script>
