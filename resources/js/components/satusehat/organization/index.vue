<template>
<div class="inner" ref="roottable">
	<div class="grid">

		<!-- ── Profile Card ───────────────────────────────────────────────── -->
		<div class="col-12">
			<div class="org-profile-card" v-if="!profileLoading && org">

				<div class="opc-header">
					<div class="opc-avatar">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
						</svg>
					</div>
					<div class="opc-title-block">
						<h2 class="opc-name">{{ org.nama }}</h2>
						<div class="opc-meta">
							<span class="opc-badge" :class="org.active ? 'badge-green' : 'badge-red'">
								{{ org.active ? 'Aktif' : 'Tidak Aktif' }}
							</span>
							<span class="opc-type">{{ org.tipe_code }} — {{ org.tipe }}</span>
							<span class="opc-alias" v-if="org.alias && org.alias.length">
								aka {{ Array.isArray(org.alias) ? org.alias.join(', ') : org.alias }}
							</span>
							<span class="opc-id">ID: {{ org.satusehat_id }}</span>
						</div>
					</div>
					<div class="opc-updated">
						<span class="opc-updated-label">Terakhir diperbarui</span>
						<span class="opc-updated-val">{{ formatDate(org.last_updated) }}</span>
					</div>
				</div>

				<div class="opc-body">
					<!-- Kontak Umum -->
					<div class="opc-section">
						<div class="opc-section-title">Kontak Umum</div>
						<div class="opc-info-row">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.38 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 5.55 5.55l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
							<span>{{ org.telepon }}</span>
						</div>
						<div class="opc-info-row">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							<span>{{ org.email }}</span>
						</div>
						<div class="opc-info-row" v-if="org.website && org.website !== '-'">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
							<span>{{ org.website }}</span>
						</div>
					</div>

					<!-- Alamat -->
					<div class="opc-section opc-section-wide">
						<div class="opc-section-title">Alamat</div>
						<div class="opc-info-row opc-info-row-sm" style="margin-bottom:6px">
							<span class="opc-chip opc-chip-sm">{{ org.address_use }}</span>
							<span class="opc-chip opc-chip-sm">{{ org.address_type }}</span>
						</div>
						<div class="opc-info-row">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
							<span>{{ org.alamat }}</span>
						</div>
						<div class="opc-info-row opc-info-row-sm">
							<span class="opc-chip">{{ org.kota }}</span>
							<span class="opc-chip" v-if="org.kode_pos && org.kode_pos !== '-'">{{ org.kode_pos }}</span>
						</div>
						<!-- Kode Wilayah BPS inline -->
						<div class="opc-codes" style="margin-top:8px">
							<div class="opc-code-item">
								<span class="opc-code-label">Provinsi</span>
								<code>{{ org.kode_provinsi }}</code>
							</div>
							<div class="opc-code-item">
								<span class="opc-code-label">Kota/Kab</span>
								<code>{{ org.kode_kota }}</code>
							</div>
							<div class="opc-code-item">
								<span class="opc-code-label">Kecamatan</span>
								<code>{{ org.kode_kecamatan }}</code>
							</div>
							<div class="opc-code-item">
								<span class="opc-code-label">Kelurahan</span>
								<code>{{ org.kode_kelurahan }}</code>
							</div>
						</div>
					</div>

					<!-- Kontak Tujuan & partOf -->
					<div class="opc-section">
						<div class="opc-section-title">Kontak Tujuan</div>
						<template v-if="org.contact_purpose && org.contact_purpose !== '-'">
							<div class="opc-info-row">
								<span class="opc-badge-purpose">{{ org.contact_purpose }}</span>
							</div>
							<div class="opc-info-row" v-if="org.contact_nama && org.contact_nama !== '-'">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
								<span>{{ org.contact_nama }}</span>
							</div>
							<div class="opc-info-row" v-if="org.contact_telepon && org.contact_telepon !== '-'">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.38 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 5.55 5.55l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
								<span>{{ org.contact_telepon }}</span>
							</div>
							<div class="opc-info-row" v-if="org.contact_email && org.contact_email !== '-'">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
								<span>{{ org.contact_email }}</span>
							</div>
						</template>
						<div v-else class="opc-info-row" style="color:#94a3b8;font-size:12px;font-style:italic">Tidak ada kontak tujuan</div>
						<div class="opc-section-title" style="margin-top:14px">Bagian dari (partOf)</div>
						<div class="opc-info-row">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opc-info-icon"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
							<code style="font-size:11px;color:#64748b;word-break:break-all">{{ org.part_of }}</code>
						</div>
					</div>
				</div>

			</div>

			<!-- Skeleton Profile -->
			<div class="org-profile-skeleton" v-if="profileLoading">
				<div class="skel skel-avatar"></div>
				<div class="skel-lines">
					<div class="skel skel-h1"></div>
					<div class="skel skel-h2"></div>
					<div class="skel skel-h3"></div>
				</div>
			</div>
		</div>

		<!-- ── Sync Panel ────────────────────────────────────────────────── -->
		<div class="col-12">
			<div class="sync-panel">
				<div class="sync-panel-left">
					<div class="sync-panel-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M3 22v-6h6"/><path d="M21 12a9 9 0 0 1-15 6.7L3 16"/></svg>
					</div>
					<div class="sync-panel-info">
						<div class="sync-panel-title">Sync Organization ke DB Lokal</div>
						<div class="sync-panel-desc">
							Simpan data Organization dari SatuSehat ke database lokal agar bisa dipakai oleh Encounter Sync tanpa perlu hit API berulang.
						</div>
					</div>
				</div>
				<div class="sync-panel-right">
					<div class="sync-stats" v-if="syncStatus.total !== null">
						<div class="sync-stat-item">
							<span class="sync-stat-label">Total Tersimpan</span>
							<span class="sync-stat-val">{{ syncStatus.total }}</span>
						</div>
						<div class="sync-stat-item" v-if="syncStatus.last_synced">
							<span class="sync-stat-label">Terakhir Sync</span>
							<span class="sync-stat-val">{{ formatSyncTime(syncStatus.last_synced) }}</span>
						</div>
					</div>
					<button class="sync-btn" :disabled="syncing" @click="runSync">
						<span v-if="!syncing">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;vertical-align:middle;margin-right:5px"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M3 22v-6h6"/><path d="M21 12a9 9 0 0 1-15 6.7L3 16"/></svg>
							Sync ke DB Lokal
						</span>
						<span v-else style="display:flex;align-items:center;gap:6px">
							<svg style="width:14px;height:14px;animation:spin .75s linear infinite" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 2v6h-6"/><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/></svg>
							Menyinkronkan...
						</span>
					</button>
				</div>
			</div>
		</div>

		<!-- ── Org Chart ─────────────────────────────────────────────────── -->
		<div class="col-12">
			<div class="org-chart-wrapper">
				<div class="ocw-header" @click="chartOpen = !chartOpen">
					<div class="ocw-title">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ocw-icon"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="8.5" y="14" width="7" height="7" rx="1"/><line x1="6.5" y1="10" x2="6.5" y2="17"/><line x1="17.5" y1="10" x2="17.5" y2="12.5"/><line x1="6.5" y1="14" x2="17.5" y2="14"/><line x1="12" y1="14" x2="12" y2="10"/></svg>
						Org Chart — Struktur Organisasi SatuSehat
					</div>
					<div class="ocw-toggle">
						<span class="ocw-count" v-if="chartNodes.length">{{ chartNodes.length }} organisasi</span>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ocw-chevron" :class="chartOpen ? 'chevron-up' : ''"><polyline points="6 9 12 15 18 9"/></svg>
					</div>
				</div>

				<div class="ocw-body" v-show="chartOpen">
					<div v-if="chartLoading" class="chart-loading">
						<div class="chart-spin"></div>
						<span>Memuat struktur organisasi...</span>
					</div>
					<div v-else-if="!chartNodes.length" class="chart-empty">
						Belum ada data organisasi. Tambahkan suborganisasi terlebih dahulu.
					</div>
					<div v-else class="chart-scroll">
						<div class="chart-tree">
							<OrgNode
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
<FormOrganization ref="FormOrganization" @dialog="dialog" @parsingForm="parsingForm"></FormOrganization>
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
		FormOrganization: defineAsyncComponent(() => import('./FormOrganization.vue')),
		Datatable:        defineAsyncComponent(() => import('../../../section/Datatable.vue')),
		OrgNode:          defineAsyncComponent(() => import('./OrgNode.vue')),
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
			uri: 'satusehat-organization',
			position: '',
			attach: {
				link: {
					profile:    '/satusehat-api/organization/profile',
					list:       '/satusehat-api/organization/list',
					add:        '/satusehat-api/organization/add',
					edit:       '/satusehat-api/organization/edit',
					update:     '/satusehat-api/organization/update',
					sync:       '/satusehat-api/organization/sync',
					syncStatus: '/satusehat-api/organization/sync-status',
				},
				url: '', data: null
			},
			column: [
				{ value: 'satusehat_id',    label: 'ID SatuSehat',   type: 'text', search: false, close: false, button: false },
				{ value: 'kode',            label: 'Kode',            type: 'text', search: true,  close: false, button: false },
				{ value: 'nama',            label: 'Nama',            type: 'text', search: true,  close: false, button: false },
				{ value: 'alias',           label: 'Alias',           type: 'text', search: false, close: false, button: false },
				{ value: 'active',          label: 'Status',          type: 'text', search: false, close: false, button: false },
				{ value: 'tipe',            label: 'Tipe',            type: 'text', search: false, close: false, button: false },
				{ value: 'telepon',         label: 'Telepon',         type: 'text', search: false, close: false, button: false },
				{ value: 'contact_purpose', label: 'Kontak Tujuan',   type: 'text', search: false, close: false, button: false },
				{ value: 'btnhtml',         label: '',                type: 'text', search: false, close: false, button: true  },
			],
			module: { data: [], column: [], total: 0, ispaging: true },

			// Profile card
			org: null,
			profileLoading: true,

			// Org chart
			chartOpen: true,
			chartLoading: false,
			chartNodes: [],

			// Sync to local DB
			syncing: false,
			syncStatus: { total: null, last_synced: null },
		};
	},
	computed: {
		// Build a map: parentId → [children]
		chartChildrenMap() {
			const map = {};
			const allIds = new Set(vm.chartNodes.map(n => n.satusehat_id));
			for (const node of vm.chartNodes) {
				const parentId = node.part_of || '';
				if (!map[parentId]) map[parentId] = [];
				map[parentId].push(node);
			}
			return map;
		},
		// Nodes with no parent (or whose parent isn't in the list)
		chartRoots() {
			const allIds = new Set(vm.chartNodes.map(n => n.satusehat_id));
			return vm.chartNodes.filter(n => !n.part_of || !allIds.has(n.part_of));
		},
	},
	methods: {
		nullAndZero, datename,

		// ── Org chart ─────────────────────────────────────────────────────────
		loadChart() {
			vm.chartLoading = true;
			const fd = new FormData();
			fd.append('search', ''); fd.append('column', ''); fd.append('page', 1); fd.append('limit', 500);
			axios.post(vm.attach.link.list, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => {
					vm.chartNodes = r.data?.data ?? [];
				})
				.catch(() => {})
				.finally(() => { vm.chartLoading = false; });
		},

		// ── Profile card ─────────────────────────────────────────────────────
		loadProfile() {
			vm.profileLoading = true;
			axios.post(vm.attach.link.profile, new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				setTimeout(() => {
					vm.org = (typeof r.data.data === 'object' && r.data.data !== null) ? r.data.data : null;
					vm.profileLoading = false;
				}, 600);
			}).catch(() => {
				vm.profileLoading = false;
				vm.notification('Gagal memuat profil Organization.', 3500, 'error');
			});
		},

		formatDate(iso) {
			if (!iso || iso === '-') return '-';
			try {
				return new Date(iso).toLocaleString('id-ID', {
					day: '2-digit', month: 'long', year: 'numeric',
					hour: '2-digit', minute: '2-digit',
				});
			} catch { return iso; }
		},

		// ── Tombol aksi per baris ────────────────────────────────────────
		btnhtml(_item, _index) {
			return [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Organization', item: _item, index: _index, show: true },
			];
		},

		converter(data, index, column, identity) {
			let _tmp = '';
			if (identity === 'btnhtml') {
				_tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 60px; text-align: center' };
			} else if (identity === 'active') {
				const isAktif = column === 'Aktif';
				_tmp = {
					value: `<span style="padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;background:${isAktif ? '#dcfce7' : '#fee2e2'};color:${isAktif ? '#16a34a' : '#dc2626'}">${column}</span>`,
					ishtml: 'html', style: ''
				};
			} else if (identity === 'satusehat_id') {
				_tmp = { value: `<span style="font-size:10px;color:#64748b;font-family:monospace">${column}</span>`, ishtml: 'html', style: 'max-width:160px;overflow:hidden;text-overflow:ellipsis' };
			} else {
				_tmp = { value: column, ishtml: 'text', style: '' };
			}
			return _tmp !== '' ? _tmp : 'empty';
		},

		tablebutton(posisi, data, index) {
			if (posisi === 'add') {
				vm.$refs.FormOrganization.aturulang();
				vm.position = 'adddata';
				vm.$refs.FormOrganization.show('adddata', 'Tambah Organization', '');
			} else if (posisi === 'edit') {
				vm.$refs.FormOrganization.aturulang();
				vm.position = 'editdata';
				vm.$refs.FormOrganization.show('editdata', 'Edit Organization', data.satusehat_id);
				setTimeout(() => { vm.loadingModal('formorganization'); }, 250);
				vm.attach.data = new FormData();
				vm.attach.data.append('satusehat_id', data.satusehat_id);
				vm.attach.url  = vm.attach.link.edit;
				vm.executions();
			}
		},

		loadingModal(position) {
			if (position === 'formorganization') { vm.$refs.FormOrganization.loaderprocess(); }
		},

		parsingForm(data, key) {
			vm.attach.data = data;
			if (key === 'organization') {
				vm.attach.url = vm.position === 'adddata' ? vm.attach.link.add : vm.attach.link.update;
			}
		},

		// ── Datatable helpers ────────────────────────────────────────────
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

		// ── State handlers ───────────────────────────────────────────────
		loadmain() { vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); },

		gagal(error) {
			if (vm.$debugs) { console.log(error.response); }
			let active = 0;
			vm.message('error', 1);
			if (vm.position === 'loadmain')       { vm.firstloader(); active = 1; }
			else if (vm.position === 'externaltable')  { vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); }
			else if (vm.position === 'adddata')        { vm.loadingModal('formorganization'); }
			else if (vm.position === 'editdata')       { vm.loadingModal('formorganization'); vm.$refs.FormOrganization.hide(); }
			else if (vm.position === 'updatedata')     { vm.loadingModal('formorganization'); }
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
				vm.loadingModal('formorganization');
				vm.$refs.FormOrganization.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); vm.loadChart(); }, 500);
			} else if (vm.position === 'editdata') {
				vm.$refs.FormOrganization.setdataform(response);
				vm.position = 'updatedata';
				active = 0;
			} else if (vm.position === 'updatedata') {
				vm.loadingModal('formorganization');
				vm.$refs.FormOrganization.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); vm.loadChart(); }, 500);
			}
			vm.message('success', active);
		},

		message(position, active) {
			if (position === 'error') {
				if (vm.position === 'loadmain')     { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position === 'externaltable') { vm.notification('Datalist gagal dimuat.', 3000, position); }
				else if (vm.position === 'adddata')       { vm.notification('Penambahan Organization gagal.', 3000, position); }
				else if (vm.position === 'editdata')      { vm.notification('Gagal mengambil data Organization.', 3000, position); }
				else if (vm.position === 'updatedata')    { vm.notification('Pembaharuan Organization gagal.', 3000, position); }
			} else if (position === 'success' && active === 1) {
				if (vm.position === 'adddata')    { vm.notification('Organization berhasil ditambahkan ke SatuSehat.', 4000, position); }
				else if (vm.position === 'updatedata') { vm.notification('Organization berhasil diperbaharui.', 4000, position); }
			}
		},

		runconfirm(posisi) {
			if (posisi === 'formorganization') { vm.loadingModal('formorganization'); }
			vm.executions();
		},

		// ── Sync to local DB ─────────────────────────────────────────────
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
				const synced = r.data?.synced ?? 0;
				const failed = r.data?.failed ?? 0;
				vm.notification(`Sync berhasil: ${synced} organization tersimpan` + (failed ? `, ${failed} gagal` : '') + '.', 4000, 'success');
				vm.loadSyncStatus();
			}).catch(() => {
				vm.notification('Sync Organization gagal.', 3500, 'error');
			}).finally(() => {
				vm.syncing = false;
			});
		},

		formatSyncTime(ts) {
			if (!ts) return '-';
			try {
				return new Date(ts).toLocaleString('id-ID', {
					day: '2-digit', month: 'short', year: 'numeric',
					hour: '2-digit', minute: '2-digit',
				});
			} catch { return ts; }
		},

		// ── Wajib disertakan ─────────────────────────────────────────────
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
/* ── Profile Card ──────────────────────────────────────────────────────── */
.org-profile-card {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	margin-bottom: 20px;
	overflow: hidden;
	box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

/* Header */
.opc-header {
	display: flex;
	align-items: center;
	gap: 16px;
	padding: 20px 24px;
	background: linear-gradient(135deg, #1c84ee 0%, #1264b3 100%);
	flex-wrap: wrap;
}
.opc-avatar {
	width: 52px; height: 52px;
	background: rgba(255,255,255,.15);
	border-radius: 12px;
	display: flex; align-items: center; justify-content: center;
	flex-shrink: 0;
}
.opc-avatar svg { width: 28px; height: 28px; stroke: #fff; }

.opc-title-block { flex: 1; min-width: 0; }
.opc-name {
	margin: 0 0 6px;
	font-size: 17px;
	font-weight: 700;
	color: #fff;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.opc-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.opc-badge {
	padding: 2px 10px;
	border-radius: 20px;
	font-size: 11px;
	font-weight: 700;
}
.badge-green { background: #dcfce7; color: #16a34a; }
.badge-red   { background: #fee2e2; color: #dc2626; }
.opc-type {
	font-size: 12px;
	color: rgba(255,255,255,.8);
	background: rgba(255,255,255,.15);
	padding: 2px 8px;
	border-radius: 6px;
}
.opc-id {
	font-size: 11px;
	color: rgba(255,255,255,.65);
	font-family: monospace;
}

.opc-updated { text-align: right; }
.opc-updated-label { display: block; font-size: 10px; color: rgba(255,255,255,.6); margin-bottom: 2px; }
.opc-updated-val   { font-size: 12px; color: rgba(255,255,255,.9); white-space: nowrap; }

/* Body */
.opc-body {
	display: flex;
	flex-wrap: wrap;
	gap: 0;
	padding: 0;
	border-top: 1px solid #e2e8f0;
}
.opc-section {
	flex: 1;
	min-width: 200px;
	padding: 16px 20px;
	border-right: 1px solid #e2e8f0;
}
.opc-section:last-child { border-right: none; }
.opc-section-wide { flex: 2; min-width: 260px; }

.opc-section-title {
	font-size: 10px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .6px;
	color: #94a3b8;
	margin-bottom: 10px;
}

.opc-info-row {
	display: flex;
	align-items: flex-start;
	gap: 8px;
	margin-bottom: 8px;
	font-size: 13px;
	color: #334155;
	line-height: 1.4;
}
.opc-info-row-sm { margin-top: 4px; flex-wrap: wrap; }
.opc-info-icon { width: 14px; height: 14px; flex-shrink: 0; margin-top: 1px; color: #94a3b8; }

.opc-chip {
	background: #f1f5f9;
	border: 1px solid #e2e8f0;
	border-radius: 6px;
	padding: 2px 8px;
	font-size: 11px;
	color: #475569;
}

/* Kode wilayah */
.opc-codes {
	display: flex;
	gap: 12px;
	flex-wrap: wrap;
}
.opc-code-item {
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 6px;
	padding: 6px 10px;
}
.opc-code-label {
	display: block;
	font-size: 10px;
	color: #94a3b8;
	font-weight: 600;
	margin-bottom: 3px;
}
.opc-code-item code {
	font-family: monospace;
	font-size: 13px;
	color: #1c84ee;
	font-weight: 600;
}

.opc-alias {
	font-size: 11px;
	color: rgba(255,255,255,.7);
	font-style: italic;
}
.opc-chip-sm {
	font-size: 10px;
	padding: 1px 6px;
	background: #e2e8f0;
	color: #475569;
}
.opc-badge-purpose {
	display: inline-block;
	background: #dbeafe;
	color: #1d4ed8;
	font-size: 11px;
	font-weight: 700;
	padding: 2px 8px;
	border-radius: 12px;
	margin-bottom: 6px;
}

/* ── Org Chart ─────────────────────────────────────────────────────────── */
.org-chart-wrapper {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	margin-bottom: 20px;
	overflow: hidden;
	box-shadow: 0 1px 4px rgba(0,0,0,.04);
}
.ocw-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 14px 20px;
	background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
	cursor: pointer;
	user-select: none;
}
.ocw-header:hover { background: linear-gradient(135deg, #1e293b 0%, #1e3a5f 100%); }
.ocw-title {
	display: flex;
	align-items: center;
	gap: 10px;
	font-size: 13px;
	font-weight: 700;
	color: #fff;
	letter-spacing: .3px;
}
.ocw-icon { width: 18px; height: 18px; stroke: #93c5fd; flex-shrink: 0; }
.ocw-toggle { display: flex; align-items: center; gap: 8px; }
.ocw-count { font-size: 11px; color: rgba(255,255,255,.6); background: rgba(255,255,255,.1); padding: 2px 9px; border-radius: 20px; }
.ocw-chevron { width: 16px; height: 16px; stroke: rgba(255,255,255,.7); transition: transform .25s; }
.chevron-up { transform: rotate(180deg); }

.ocw-body { padding: 20px; }

/* Loading state */
.chart-loading {
	display: flex;
	align-items: center;
	gap: 12px;
	padding: 20px;
	color: #64748b;
	font-size: 13px;
}
.chart-spin {
	width: 20px; height: 20px;
	border: 2px solid #e2e8f0;
	border-top-color: #1c84ee;
	border-radius: 50%;
	animation: spin .75s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.chart-empty {
	text-align: center;
	padding: 30px;
	color: #94a3b8;
	font-size: 13px;
}

/* Scrollable tree container */
.chart-scroll { overflow-x: auto; padding-bottom: 10px; }
.chart-tree {
	display: flex;
	gap: 24px;
	justify-content: center;
	align-items: flex-start;
	min-width: max-content;
	padding: 8px 16px;
}

/* ── Skeleton ──────────────────────────────────────────────────────────── */
.org-profile-skeleton {
	display: flex;
	gap: 20px;
	align-items: center;
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	padding: 24px;
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
.skel-avatar { width: 52px; height: 52px; border-radius: 12px; flex-shrink: 0; }
.skel-h1 { height: 20px; width: 55%; }
.skel-h2 { height: 14px; width: 35%; }
.skel-h3 { height: 14px; width: 70%; }
@keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

/* ── Sync Panel ────────────────────────────────────────────────────────── */
.sync-panel {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 12px;
	margin-bottom: 20px;
	padding: 16px 20px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 16px;
	flex-wrap: wrap;
	box-shadow: 0 1px 4px rgba(0,0,0,.04);
}
.sync-panel-left  { display: flex; align-items: flex-start; gap: 14px; flex: 1; min-width: 0; }
.sync-panel-icon {
	width: 40px; height: 40px; flex-shrink: 0;
	background: linear-gradient(135deg, #eff6ff, #dbeafe);
	border-radius: 10px;
	display: flex; align-items: center; justify-content: center;
}
.sync-panel-icon svg { width: 20px; height: 20px; stroke: #1c84ee; }
.sync-panel-info { flex: 1; min-width: 0; }
.sync-panel-title {
	font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 4px;
}
.sync-panel-desc { font-size: 12px; color: #64748b; line-height: 1.5; }

.sync-panel-right { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }

.sync-stats { display: flex; gap: 16px; }
.sync-stat-item { text-align: center; }
.sync-stat-label { display: block; font-size: 10px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 2px; }
.sync-stat-val   { font-size: 18px; font-weight: 700; color: #1c84ee; }
.sync-stat-item:last-child .sync-stat-val { font-size: 12px; color: #475569; font-weight: 600; }

.sync-btn {
	display: inline-flex;
	align-items: center;
	padding: 8px 16px;
	background: linear-gradient(135deg, #1c84ee, #1264b3);
	color: #fff;
	border: none;
	border-radius: 8px;
	font-size: 13px;
	font-weight: 600;
	cursor: pointer;
	transition: opacity .2s;
	white-space: nowrap;
}
.sync-btn:disabled { opacity: .65; cursor: not-allowed; }
.sync-btn:not(:disabled):hover { opacity: .88; }
</style>
