<template>
<div class="inner" ref="roottable">
	<div class="grid">

		<!-- ── Summary Card ───────────────────────────────────────────────── -->
		<div class="col-12">

			<div class="loc-summary-card" v-if="!profileLoading && summary">
				<div class="lsc-header">
					<div class="lsc-header-left">
						<div class="lsc-avatar">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
							</svg>
						</div>
						<div>
							<h2 class="lsc-title">Lokasi Rumah Sakit</h2>
							<p class="lsc-subtitle">Organization ID: <code>{{ summary.organization_id }}</code></p>
						</div>
					</div>
					<div class="lsc-total-block">
						<span class="lsc-total-num">{{ summary.total }}</span>
						<span class="lsc-total-label">Total Lokasi</span>
					</div>
				</div>

				<div class="lsc-body">

					<!-- Status Stats -->
					<div class="lsc-stat-group">
						<div class="lsc-section-title">Status</div>
						<div class="lsc-stats">
							<div class="lsc-stat lsc-stat-green">
								<span class="lsc-stat-num">{{ summary.active }}</span>
								<span class="lsc-stat-lbl">Active</span>
							</div>
							<div class="lsc-stat lsc-stat-red">
								<span class="lsc-stat-num">{{ summary.inactive }}</span>
								<span class="lsc-stat-lbl">Inactive</span>
							</div>
							<div class="lsc-stat lsc-stat-yellow">
								<span class="lsc-stat-num">{{ summary.suspended }}</span>
								<span class="lsc-stat-lbl">Suspended</span>
							</div>
						</div>
					</div>

					<!-- Divider -->
					<div class="lsc-divider"></div>

					<!-- Tipe Fisik breakdown -->
					<div class="lsc-tipe-group" v-if="summary.tipe_count && Object.keys(summary.tipe_count).length">
						<div class="lsc-section-title">Tipe Fisik</div>
						<div class="lsc-tipes">
							<div class="lsc-tipe-chip" v-for="(count, code) in summary.tipe_count" :key="code">
								<span class="lsc-tipe-code">{{ code }}</span>
								<span class="lsc-tipe-count">{{ count }}</span>
							</div>
						</div>
					</div>

					<!-- Divider -->
					<div class="lsc-divider"></div>

					<!-- Sync ke database lokal -->
					<div class="lsc-sync-group">
						<div class="lsc-section-title">Database Lokal</div>
						<div class="lsc-sync-meta">
							<span class="lsc-sync-count">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
								<strong>{{ syncStatus.total }}</strong> tersimpan
							</span>
							<span class="lsc-sync-time" v-if="syncStatus.last_synced">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
								{{ formatSyncTime(syncStatus.last_synced) }}
							</span>
							<span class="lsc-sync-time" v-else style="color:#94a3b8">Belum pernah disinkronkan</span>
						</div>
						<button class="lsc-sync-btn" @click="runSync" :disabled="syncing">
							<svg v-if="!syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
							<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="spin-icon"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
							{{ syncing ? 'Menyinkronkan...' : 'Sync ke DB Lokal' }}
						</button>
					</div>

				</div>
			</div>

			<!-- Skeleton -->
			<div class="loc-summary-skeleton" v-if="profileLoading">
				<div class="skel skel-avatar"></div>
				<div class="skel-lines">
					<div class="skel skel-h1"></div>
					<div class="skel skel-h2"></div>
				</div>
			</div>

		</div>

		<!-- ── Location Chart ────────────────────────────────────────────── -->
		<div class="col-12">
			<div class="loc-chart-wrapper">
				<div class="lcw-header" @click="chartOpen = !chartOpen">
					<div class="lcw-title">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lcw-icon"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
						Location Chart
					</div>
					<div style="display:flex;align-items:center;gap:10px">
						<span class="lcw-count" v-if="chartNodes.length">{{ chartNodes.length }} lokasi</span>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="lcw-chevron" :class="chartOpen ? 'chevron-up' : ''"><polyline points="6 9 12 15 18 9"/></svg>
					</div>
				</div>

				<div class="lcw-body" v-show="chartOpen">
					<div v-if="chartLoading" class="chart-loading">
						<div class="chart-spin"></div>
						<span>Memuat lokasi...</span>
					</div>
					<div v-else-if="!chartNodes.length" class="chart-empty">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:28px;height:28px;stroke:#94a3b8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
						<span>Belum ada data lokasi.</span>
					</div>
					<div v-else class="chart-scroll">
						<div class="chart-tree">
							<LocNode
								v-for="root in chartRoots"
								:key="root.satusehat_id"
								:node="root"
								:children-map="chartChildrenMap"
								:depth="0"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ── Datatable ──────────────────────────────────────────────────── -->
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>

	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormLocation ref="FormLocation" @dialog="dialog" @parsingForm="parsingForm"></FormLocation>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';

export default {
	emits: ['titletrigger', 'repatch'],
	beforeUnmount() {},
	components: {
		toast, Swal,
		FormLocation: defineAsyncComponent(() => import('./FormLocation.vue')),
		Datatable:    defineAsyncComponent(() => import('../../../section/Datatable.vue')),
		LocNode:      defineAsyncComponent(() => import('./LocNode.vue')),
	},
	created() {},
	mounted() {
		vm = this;
		setTimeout(() => { vm.titletrigger(); }, 250);
		vm.loadmain();
		vm.loadProfile();
		vm.loadChart();
		vm.loadSyncStatus();
	},
	data() {
		return {
			uri: 'satusehat-location',
			position: '',
			attach: {
				link: {
					profile:    '/satusehat-api/location/profile',
					list:       '/satusehat-api/location/list',
					add:        '/satusehat-api/location/add',
					edit:       '/satusehat-api/location/edit',
					update:     '/satusehat-api/location/update',
					sync:       '/satusehat-api/location/sync',
					syncStatus: '/satusehat-api/location/sync-status',
				},
				url: '', data: null
			},
			column: [
				{ value: 'satusehat_id',      label: 'ID SatuSehat',    type: 'text', search: false, close: false, button: false },
				{ value: 'kode',              label: 'Kode',             type: 'text', search: true,  close: false, button: false },
				{ value: 'nama',              label: 'Nama',             type: 'text', search: true,  close: false, button: false },
				{ value: 'alias',             label: 'Alias',            type: 'text', search: false, close: false, button: false },
				{ value: 'status',            label: 'Status',           type: 'text', search: false, close: false, button: false },
				{ value: 'operational_status',label: 'Op. Status',       type: 'text', search: false, close: false, button: false },
				{ value: 'tipe_layanan',      label: 'Tipe Layanan',     type: 'text', search: false, close: false, button: false },
				{ value: 'tipe_fisik',        label: 'Tipe Fisik',       type: 'text', search: false, close: false, button: false },
				{ value: 'service_class',     label: 'Kelas',            type: 'text', search: false, close: false, button: false },
				{ value: 'telepon',           label: 'Telepon',          type: 'text', search: false, close: false, button: false },
				{ value: 'kota',              label: 'Kota',             type: 'text', search: false, close: false, button: false },
				{ value: 'btnhtml',           label: '',                 type: 'text', search: false, close: false, button: true  },
			],
			module: { data: [], column: [], total: 0, ispaging: true },

			// Summary card
			summary: null,
			profileLoading: true,

			// Location chart
			chartOpen: true,
			chartLoading: false,
			chartNodes: [],

			// Sync ke DB lokal
			syncing: false,
			syncStatus: { total: 0, last_synced: null },
		};
	},
	computed: {
		// Build a map: parentId → [children]  (strip "Location/" prefix from part_of)
		chartChildrenMap() {
			const map = {};
			for (const node of vm.chartNodes) {
				const rawPartOf = node.part_of || '';
				const parentId  = rawPartOf.replace(/^Location\//, '');
				if (!map[parentId]) map[parentId] = [];
				map[parentId].push(node);
			}
			return map;
		},
		// Nodes whose parent is not in the node list → these are tree roots
		chartRoots() {
			const allIds = new Set(vm.chartNodes.map(n => n.satusehat_id));
			return vm.chartNodes.filter(n => {
				const rawPartOf = n.part_of || '';
				const parentId  = rawPartOf.replace(/^Location\//, '');
				return !parentId || parentId === '-' || !allIds.has(parentId);
			});
		},
	},
	methods: {
		nullAndZero, datename,

		// ── Location chart ───────────────────────────────────────────────────
		loadChart() {
			vm.chartLoading = true;
			const fd = new FormData();
			fd.append('search', ''); fd.append('column', ''); fd.append('page', 1); fd.append('limit', 500);
			axios.post(vm.attach.link.list, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => { vm.chartNodes = r.data?.data ?? []; })
				.catch(() => {})
				.finally(() => { vm.chartLoading = false; });
		},

		// ── Sync ke DB lokal ─────────────────────────────────────────────────
		loadSyncStatus() {
			axios.post(vm.attach.link.syncStatus, new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data?.data && typeof r.data.data === 'object') {
					vm.syncStatus = r.data.data;
				}
			}).catch(() => {});
		},

		runSync() {
			if (vm.syncing) return;
			vm.syncing = true;
			axios.post(vm.attach.link.sync, new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data?.data === '419') { window.location.href = '/masuk'; return; }
				if (r.data?.data === 'berhasil') {
					const count = r.data?.count ?? 0;
					vm.notification(`${count} lokasi berhasil disinkronkan ke database lokal.`, 4000, 'success');
					vm.loadSyncStatus();
				} else {
					vm.notification(r.data?.message ?? 'Sync gagal.', 4000, 'error');
				}
			}).catch(() => {
				vm.notification('Sync location gagal. Periksa koneksi SatuSehat.', 4000, 'error');
			}).finally(() => {
				vm.syncing = false;
			});
		},

		formatSyncTime(ts) {
			if (!ts) return '';
			const d = new Date(ts);
			return d.toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
		},

		// ── Profile / Summary ────────────────────────────────────────────────
		loadProfile() {
			vm.profileLoading = true;
			axios.post(vm.attach.link.profile, new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				setTimeout(() => {
					vm.summary        = (typeof r.data.data === 'object' && r.data.data !== null) ? r.data.data : null;
					vm.profileLoading = false;
				}, 600);
			}).catch(() => {
				vm.profileLoading = false;
				vm.notification('Gagal memuat ringkasan Location.', 3500, 'error');
			});
		},

		// ── Tombol aksi per baris ────────────────────────────────────────────
		btnhtml(_item, _index) {
			return [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Location', item: _item, index: _index, show: true },
			];
		},

		converter(data, index, column, identity) {
			let _tmp = '';
			if (identity === 'btnhtml') {
				_tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 60px; text-align: center' };
			} else if (identity === 'status') {
				const colorMap = { 'Active': '#dcfce7', 'Inactive': '#fee2e2', 'Suspended': '#fef9c3' };
				const textMap  = { 'Active': '#16a34a', 'Inactive': '#dc2626', 'Suspended': '#ca8a04' };
				const bg   = colorMap[column] ?? '#f1f5f9';
				const text = textMap[column]  ?? '#475569';
				_tmp = { value: `<span style="padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;background:${bg};color:${text}">${column}</span>`, ishtml: 'html', style: '' };
			} else if (identity === 'operational_status') {
				if (!column || column === '-') {
					_tmp = { value: '<span style="color:#cbd5e1;font-size:11px">—</span>', ishtml: 'html', style: '' };
				} else {
					const opColorMap = { O: '#fef3c7', C: '#fee2e2', H: '#e0f2fe', K: '#fae8ff', I: '#fef9c3', U: '#f0fdf4' };
					const opTextMap  = { O: '#92400e', C: '#dc2626', H: '#0369a1', K: '#7e22ce', I: '#854d0e', U: '#166534' };
					const bg   = opColorMap[column] ?? '#f1f5f9';
					const text = opTextMap[column]  ?? '#475569';
					_tmp = { value: `<span style="padding:2px 8px;border-radius:12px;font-size:11px;font-weight:700;background:${bg};color:${text}">${column}</span>`, ishtml: 'html', style: '' };
				}
			} else if (identity === 'service_class') {
				if (!column || column === '-') {
					_tmp = { value: '<span style="color:#cbd5e1;font-size:11px">—</span>', ishtml: 'html', style: '' };
				} else {
					_tmp = { value: `<span style="padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;background:#ede9fe;color:#5b21b6">${column}</span>`, ishtml: 'html', style: '' };
				}
			} else if (identity === 'tipe_layanan') {
				if (!column || column === '-') {
					_tmp = { value: '<span style="color:#cbd5e1;font-size:11px">—</span>', ishtml: 'html', style: '' };
				} else {
					_tmp = { value: `<span style="padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600;background:#e0f2fe;color:#075985;font-family:monospace">${column}</span>`, ishtml: 'html', style: '' };
				}
			} else if (identity === 'satusehat_id') {
				_tmp = { value: `<span style="font-size:10px;color:#64748b;font-family:monospace">${column}</span>`, ishtml: 'html', style: '' };
			} else {
				_tmp = { value: column, ishtml: 'text', style: '' };
			}
			return _tmp !== '' ? _tmp : 'empty';
		},

		tablebutton(posisi, data, index) {
			if (posisi === 'add') {
				vm.$refs.FormLocation.aturulang();
				vm.position = 'adddata';
				vm.$refs.FormLocation.show('adddata', 'Tambah Location', '');
			} else if (posisi === 'edit') {
				vm.$refs.FormLocation.aturulang();
				vm.position = 'editdata';
				vm.$refs.FormLocation.show('editdata', 'Edit Location', data.satusehat_id);
				setTimeout(() => { vm.loadingModal('formlocation'); }, 250);
				vm.attach.data = new FormData();
				vm.attach.data.append('satusehat_id', data.satusehat_id);
				vm.attach.url  = vm.attach.link.edit;
				vm.executions();
			}
		},

		loadingModal(position) {
			if (position === 'formlocation') { vm.$refs.FormLocation.loaderprocess(); }
		},

		parsingForm(data, key) {
			vm.attach.data = data;
			if (key === 'location') {
				vm.attach.url = vm.position === 'adddata' ? vm.attach.link.add : vm.attach.link.update;
			}
		},

		setDatatable(data, total) {
			let temporer = [], col = [];
			for (let i = 0; i < data.length; i++) {
				col = [];
				for (let j = 0; j < vm.column.length; j++) {
					col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ?? vm.column[j].value, vm.column[j].value));
				}
				temporer.push(col);
			}
			vm.module.data  = temporer;
			vm.module.total = total;
			return temporer;
		},

		tableload() {
			vm.attach.url  = vm.attach.link.list;
			vm.attach.data = new FormData();
			vm.attach.data.append('search', '');
			vm.attach.data.append('column', '');
			vm.attach.data.append('page', 1);
			vm.executions();
		},

		tablereload(data = new FormData(), pos = 'main') {
			if (pos === 'outer') { vm.$refs.Datatable.skeleton(); }
			vm.attach.url  = vm.attach.link.list;
			vm.attach.data = data;
			vm.position    = 'externaltable';
			vm.executions();
		},

		loadmain() { vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); },

		gagal(error) {
			if (vm.$debugs) { console.log(error.response); }
			let active = 0;
			vm.message('error', 1);
			if (vm.position === 'loadmain')           { vm.firstloader(); active = 1; }
			else if (vm.position === 'externaltable') { vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); }
			else if (vm.position === 'adddata')       { vm.loadingModal('formlocation'); }
			else if (vm.position === 'editdata')      { vm.loadingModal('formlocation'); vm.$refs.FormLocation.hide(); }
			else if (vm.position === 'updatedata')    { vm.loadingModal('formlocation'); }
			if (active === 1) { setTimeout(() => { vm.$router.push({ name: 'Error', params: { link: vm.uri } }); }, 250); }
		},

		berhasil(response) {
			if (vm.$debugs) { console.log(response.data); }
			let active = 1;
			if (response.data.data === '403') { vm.$router.push('/dashboard/forbidden'); }

			if (vm.position === 'loadmain') {
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total);
				vm.$refs.Datatable.paging();
				active = 0;
			} else if (vm.position === 'externaltable') {
				vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total);
				vm.$refs.Datatable.skeleton();
				vm.$refs.Datatable.paging();
				active = 0;
			} else if (vm.position === 'adddata') {
				vm.loadingModal('formlocation');
				vm.$refs.FormLocation.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); vm.loadChart(); }, 500);
				// Refresh summary setelah tambah data
				vm.loadProfile();
			} else if (vm.position === 'editdata') {
				vm.$refs.FormLocation.setdataform(response);
				vm.position = 'updatedata';
				active = 0;
			} else if (vm.position === 'updatedata') {
				vm.loadingModal('formlocation');
				vm.$refs.FormLocation.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); vm.loadChart(); }, 500);
				// Refresh summary setelah update data
				vm.loadProfile();
			}
			vm.message('success', active);
		},

		message(position, active) {
			if (position === 'error') {
				if (vm.position === 'loadmain')           { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position === 'externaltable') { vm.notification('Datalist gagal dimuat.', 3000, position); }
				else if (vm.position === 'adddata')       { vm.notification('Penambahan Location gagal.', 3000, position); }
				else if (vm.position === 'editdata')      { vm.notification('Gagal mengambil data Location.', 3000, position); }
				else if (vm.position === 'updatedata')    { vm.notification('Pembaharuan Location gagal.', 3000, position); }
			} else if (position === 'success' && active === 1) {
				if (vm.position === 'adddata')         { vm.notification('Location berhasil ditambahkan ke SatuSehat.', 4000, position); }
				else if (vm.position === 'updatedata') { vm.notification('Location berhasil diperbaharui.', 4000, position); }
			}
		},

		runconfirm(posisi) {
			if (posisi === 'formlocation') { vm.loadingModal('formlocation'); }
			vm.executions();
		},

		executions()   { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(r => { if (r.data.data === '419') { window.location.href = '/masuk'; } setTimeout(() => { vm.berhasil(r); }, 750); }).catch(e => { setTimeout(() => { vm.gagal(e); }, 750); }); },
		dialog(_text, _confirm, posisi) { Swal.fire({ title: 'Apakah Anda Yakin?', text: _text, icon: 'warning', showCancelButton: true, confirmButtonColor: '#1c84ee', cancelButtonColor: '#fd625e', confirmButtonText: _confirm, cancelButtonText: 'Tidak, batal!' }).then(e => { if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification(message, timer, position) { if (position === 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch()    { vm.firstloader(); },
		firstloader()  { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch(position) { vm.firstloader(); if (position === 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else { vm.notification('Data gagal dipatch.', 3000, 'error'); } },
		titletrigger() { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); },
	},
}
</script>

<style scoped>
/* ── Summary Card ──────────────────────────────────────────────────────── */
.loc-summary-card {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	margin-bottom: 20px;
	overflow: hidden;
	box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

/* Header */
.lsc-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 16px;
	padding: 18px 24px;
	background: linear-gradient(135deg, #0f766e 0%, #0d5e57 100%);
	flex-wrap: wrap;
}
.lsc-header-left { display: flex; align-items: center; gap: 14px; }
.lsc-avatar {
	width: 46px; height: 46px;
	background: rgba(255,255,255,.15);
	border-radius: 10px;
	display: flex; align-items: center; justify-content: center;
	flex-shrink: 0;
}
.lsc-avatar svg { width: 24px; height: 24px; stroke: #fff; }
.lsc-title  { margin: 0 0 4px; font-size: 16px; font-weight: 700; color: #fff; }
.lsc-subtitle { margin: 0; font-size: 12px; color: rgba(255,255,255,.7); }
.lsc-subtitle code { background: rgba(255,255,255,.15); padding: 1px 6px; border-radius: 4px; font-family: monospace; color: #fff; }

.lsc-total-block { text-align: right; }
.lsc-total-num   { display: block; font-size: 32px; font-weight: 800; color: #fff; line-height: 1; }
.lsc-total-label { font-size: 11px; color: rgba(255,255,255,.7); text-transform: uppercase; letter-spacing: .5px; }

/* Body */
.lsc-body {
	display: flex;
	align-items: center;
	gap: 0;
	padding: 16px 24px;
	flex-wrap: wrap;
}
.lsc-section-title {
	font-size: 10px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .6px;
	color: #94a3b8;
	margin-bottom: 10px;
}

/* Status stats */
.lsc-stat-group { display: flex; flex-direction: column; }
.lsc-stats { display: flex; gap: 10px; }
.lsc-stat {
	display: flex;
	flex-direction: column;
	align-items: center;
	padding: 8px 16px;
	border-radius: 8px;
	min-width: 70px;
}
.lsc-stat-num  { font-size: 22px; font-weight: 800; line-height: 1; }
.lsc-stat-lbl  { font-size: 11px; font-weight: 500; margin-top: 3px; }
.lsc-stat-green  { background: #dcfce7; color: #16a34a; }
.lsc-stat-red    { background: #fee2e2; color: #dc2626; }
.lsc-stat-yellow { background: #fef9c3; color: #ca8a04; }

/* Divider */
.lsc-divider {
	width: 1px;
	height: 60px;
	background: #e2e8f0;
	margin: 0 24px;
	flex-shrink: 0;
}

/* Tipe fisik chips */
.lsc-tipe-group { flex: 1; }
.lsc-tipes { display: flex; flex-wrap: wrap; gap: 8px; }
.lsc-tipe-chip {
	display: flex;
	align-items: center;
	gap: 6px;
	background: #f1f5f9;
	border: 1px solid #e2e8f0;
	border-radius: 20px;
	padding: 4px 10px;
}
.lsc-tipe-code  { font-size: 12px; font-weight: 600; color: #0f766e; font-family: monospace; }
.lsc-tipe-count {
	background: #0f766e;
	color: #fff;
	font-size: 11px;
	font-weight: 700;
	border-radius: 10px;
	padding: 0 6px;
	min-width: 18px;
	text-align: center;
}

/* ── Skeleton ──────────────────────────────────────────────────────────── */
.loc-summary-skeleton {
	display: flex;
	gap: 20px;
	align-items: center;
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	padding: 22px 24px;
	margin-bottom: 20px;
}
.skel-lines { flex: 1; }
.skel {
	background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
	background-size: 200% 100%;
	animation: shimmer 1.4s infinite;
	border-radius: 6px;
	margin-bottom: 12px;
}
.skel-avatar { width: 46px; height: 46px; border-radius: 10px; flex-shrink: 0; }
.skel-h1 { height: 18px; width: 40%; }
.skel-h2 { height: 13px; width: 28%; margin-bottom: 0; }
@keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

/* ── Sync section ────────────────────────────────────────────────────────── */
.lsc-sync-group { display: flex; flex-direction: column; gap: 8px; min-width: 200px; }

.lsc-sync-meta {
	display: flex;
	flex-direction: column;
	gap: 4px;
}
.lsc-sync-count, .lsc-sync-time {
	display: flex;
	align-items: center;
	gap: 5px;
	font-size: 12px;
	color: #64748b;
}
.lsc-sync-count svg, .lsc-sync-time svg { width: 13px; height: 13px; stroke: #94a3b8; flex-shrink: 0; }
.lsc-sync-count strong { color: #0f766e; font-weight: 700; }

.lsc-sync-btn {
	display: inline-flex;
	align-items: center;
	gap: 7px;
	background: #0f766e;
	color: #fff;
	border: none;
	border-radius: 8px;
	padding: 8px 16px;
	font-size: 12px;
	font-weight: 600;
	cursor: pointer;
	transition: background .15s, opacity .15s;
	white-space: nowrap;
}
.lsc-sync-btn:hover:not(:disabled) { background: #0d5e57; }
.lsc-sync-btn:disabled { opacity: .6; cursor: not-allowed; }
.lsc-sync-btn svg { width: 14px; height: 14px; stroke: #fff; }
.spin-icon { animation: spin .8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Location Chart ─────────────────────────────────────────────────────── */
.loc-chart-wrapper {
	background: #1e293b;
	border-radius: 12px;
	margin-bottom: 20px;
	overflow: hidden;
	box-shadow: 0 2px 8px rgba(0,0,0,.12);
}

.lcw-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 14px 20px;
	cursor: pointer;
	user-select: none;
	transition: background .15s;
}
.lcw-header:hover { background: rgba(255,255,255,.04); }

.lcw-title {
	display: flex;
	align-items: center;
	gap: 10px;
	font-size: 13px;
	font-weight: 700;
	color: #f1f5f9;
	letter-spacing: .3px;
}
.lcw-icon { width: 18px; height: 18px; stroke: #5eead4; }

.lcw-count {
	font-size: 11px;
	background: rgba(94,234,212,.15);
	color: #5eead4;
	border-radius: 10px;
	padding: 2px 10px;
	font-weight: 600;
}
.lcw-chevron { width: 16px; height: 16px; stroke: #94a3b8; transition: transform .25s; }
.chevron-up  { transform: rotate(180deg); }

.lcw-body {
	background: #f8fafc;
	border-top: 1px solid rgba(255,255,255,.06);
}

/* Loading spinner */
.chart-loading {
	display: flex;
	align-items: center;
	gap: 12px;
	padding: 30px 24px;
	font-size: 13px;
	color: #64748b;
}
.chart-spin {
	width: 20px; height: 20px;
	border: 2px solid #e2e8f0;
	border-top-color: #0f766e;
	border-radius: 50%;
	animation: spin .7s linear infinite;
	flex-shrink: 0;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Empty state */
.chart-empty {
	display: flex;
	align-items: center;
	gap: 10px;
	padding: 28px 24px;
	font-size: 13px;
	color: #94a3b8;
}

/* Scrollable tree container */
.chart-scroll {
	overflow-x: auto;
	padding: 24px 24px 28px;
}
.chart-tree {
	display: flex;
	gap: 28px;
	align-items: flex-start;
	min-width: max-content;
}
</style>
