<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Bulk Sync Panel ────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="pr-trigger-panel">
			<div class="prt-left">
				<div class="prt-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
				</div>
				<div>
					<div class="prt-title">Sync Practitioner (Dokter)</div>
					<div class="prt-desc">
						Lookup IHS Number dokter ke SatuSehat berdasarkan NIK.
						Pastikan kolom <strong>NIK</strong> sudah diisi di data pengguna sebelum sync.
					</div>
				</div>
			</div>
			<div class="prt-right">
				<div class="prt-batch-wrap">
					<label class="prt-batch-label">Batch per run</label>
					<select v-model="syncBatch" class="prt-batch-select" :disabled="syncing">
						<option value="10">10 dokter</option>
						<option value="20">20 dokter</option>
						<option value="50">50 dokter</option>
						<option value="100">100 dokter</option>
					</select>
				</div>
				<button class="prt-run-btn" @click="runBulkSync" :disabled="syncing || statsLoading">
					<svg v-if="!syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="prt-btn-icon"><polygon points="5 3 19 12 5 21 5 3"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="prt-btn-icon prt-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ syncing ? 'Sedang berjalan…' : 'Jalankan Sync' }}
				</button>
			</div>
		</div>

		<!-- Result bar -->
		<div class="pr-sync-result" v-if="lastSyncResult">
			<div class="psr-item psr-green" v-if="lastSyncResult.synced >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				<strong>{{ lastSyncResult.synced }}</strong> berhasil sync
			</div>
			<div class="psr-item psr-slate" v-if="lastSyncResult.not_found >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
				<strong>{{ lastSyncResult.not_found }}</strong> tidak ditemukan
			</div>
			<div class="psr-item psr-red" v-if="lastSyncResult.failed >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
				<strong>{{ lastSyncResult.failed }}</strong> gagal
			</div>
			<div class="psr-msg">{{ lastSyncResult.message }}</div>
			<button class="psr-close" @click="lastSyncResult = null">&#10005;</button>
		</div>

		<!-- Log output -->
		<div class="pr-sync-log" v-if="lastSyncResult && lastSyncResult.output">
			<div class="psl-header">
				<span>Output log</span>
				<button class="psl-toggle" @click="showLog = !showLog">{{ showLog ? 'Sembunyikan' : 'Tampilkan' }}</button>
			</div>
			<pre class="psl-body" v-if="showLog">{{ lastSyncResult.output }}</pre>
		</div>
	</div>

	<!-- ── No NIK Warning ──────────────────────────────────────────────────── -->
	<div class="col-12" v-if="stats && stats.no_nik > 0">
		<div class="pr-nik-warn">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="pr-ww-icon"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
			<div class="pr-ww-body">
				<div class="pr-ww-title">
					<strong>{{ stats.no_nik }} dokter</strong> belum memiliki NIK
				</div>
				<div class="pr-ww-text">
					Dokter-dokter ini tidak bisa di-sync ke SatuSehat.
					Buka halaman <strong>Data Pengguna</strong>, isi kolom NIK (16 digit) terlebih dahulu.
				</div>
			</div>
			<div class="pr-ww-actions">
				<button class="pr-ww-btn-ghost" @click="switchFilter('no_nik')">Lihat Dokter</button>
			</div>
		</div>
	</div>

	<!-- ── Stats Cards ─────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="pr-stats-row" v-if="!statsLoading && stats">

			<div class="pr-stat-card pr-card-blue" @click="switchFilter('all')" :class="{ 'pr-card-active': activeFilter === 'all' }">
				<div class="prc-top">
					<span class="prc-label">Total Dokter</span>
					<div class="prc-icon prc-icon-blue">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
					</div>
				</div>
				<div class="prc-num">{{ stats.total }}</div>
				<div class="prc-sub">Pengguna dengan role dokter</div>
			</div>

			<div class="pr-stat-card pr-card-green" @click="switchFilter('synced')" :class="{ 'pr-card-active': activeFilter === 'synced' }">
				<div class="prc-top">
					<span class="prc-label">Sudah Sync</span>
					<div class="prc-icon prc-icon-green">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
					</div>
				</div>
				<div class="prc-num prc-num-green">{{ stats.synced }}</div>
				<div class="prc-sub">Memiliki IHS ID SatuSehat</div>
			</div>

			<div class="pr-stat-card pr-card-slate" @click="switchFilter('pending')" :class="{ 'pr-card-active': activeFilter === 'pending' }">
				<div class="prc-top">
					<span class="prc-label">Belum Sync</span>
					<div class="prc-icon prc-icon-slate">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					</div>
				</div>
				<div class="prc-num prc-num-slate">{{ stats.pending }}</div>
				<div class="prc-sub">Menunggu lookup ke SatuSehat</div>
			</div>

			<div class="pr-stat-card pr-card-yellow" @click="switchFilter('not_found')" :class="{ 'pr-card-active': activeFilter === 'not_found' }">
				<div class="prc-top">
					<span class="prc-label">Tidak Ditemukan</span>
					<div class="prc-icon prc-icon-yellow">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
					</div>
				</div>
				<div class="prc-num prc-num-yellow">{{ stats.not_found }}</div>
				<div class="prc-sub">NIK tidak ditemukan di SatuSehat</div>
			</div>

			<div class="pr-stat-card pr-card-red" @click="switchFilter('failed')" :class="{ 'pr-card-active': activeFilter === 'failed' }">
				<div class="prc-top">
					<span class="prc-label">Gagal</span>
					<div class="prc-icon prc-icon-red">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					</div>
				</div>
				<div class="prc-num prc-num-red">{{ stats.failed }}</div>
				<div class="prc-sub">Error saat sync</div>
			</div>

			<div class="pr-stat-card pr-card-orange" @click="switchFilter('no_nik')" :class="{ 'pr-card-active': activeFilter === 'no_nik' }">
				<div class="prc-top">
					<span class="prc-label">Tanpa NIK</span>
					<div class="prc-icon prc-icon-orange">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="18" y1="8" x2="23" y2="13"/><line x1="23" y1="8" x2="18" y2="13"/></svg>
					</div>
				</div>
				<div class="prc-num prc-num-orange">{{ stats.no_nik }}</div>
				<div class="prc-sub">Tidak bisa di-sync</div>
			</div>

		</div>

		<!-- Stats skeleton -->
		<div class="pr-stats-skeleton" v-if="statsLoading">
			<div class="skel skel-card" v-for="i in 6" :key="i"></div>
		</div>
	</div>

	<!-- ── Filter Tabs ──────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="pr-tabs">
			<button
				v-for="tab in tabs" :key="tab.key"
				class="pr-tab"
				:class="{ 'pr-tab-active': activeFilter === tab.key }"
				@click="switchFilter(tab.key)"
			>{{ tab.label }}</button>
		</div>
	</div>

	<!-- ── Search bar ─────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="pr-searchbar">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="pr-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			<input v-model="searchQuery" @input="onSearch" type="text" class="pr-search-input" placeholder="Cari nama atau NIK dokter…" />
			<button v-if="searchQuery" class="pr-search-clear" @click="clearSearch">&#10005;</button>
		</div>
	</div>

	<!-- ── Datatable ───────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="pr-table-wrap">
			<table class="pr-table">
				<thead>
					<tr>
						<th>Nama Dokter</th>
						<th>NIK</th>
						<th>Role / Sebagai</th>
						<th>IHS ID SatuSehat</th>
						<th>Status</th>
						<th>Terakhir Sync</th>
						<th style="width:90px;text-align:center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<!-- Loading rows -->
					<tr v-if="tableLoading" v-for="i in 5" :key="'sk'+i" class="pr-row-skel">
						<td><div class="skel skel-text"></div></td>
						<td><div class="skel skel-text skel-sm"></div></td>
						<td><div class="skel skel-text skel-sm"></div></td>
						<td><div class="skel skel-text skel-md"></div></td>
						<td><div class="skel skel-badge"></div></td>
						<td><div class="skel skel-text skel-sm"></div></td>
						<td><div class="skel skel-btn"></div></td>
					</tr>
					<!-- Empty state -->
					<tr v-if="!tableLoading && rows.length === 0">
						<td colspan="7" class="pr-empty">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="8" y1="15" x2="16" y2="15"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
							<span>Tidak ada dokter{{ searchQuery ? ' yang cocok' : '' }} pada filter ini.</span>
						</td>
					</tr>
					<!-- Data rows -->
					<tr v-if="!tableLoading" v-for="row in rows" :key="row.uuid" class="pr-row">
						<td class="pr-td-nama">{{ row.nama }}</td>
						<td class="pr-td-nik">
							<span v-if="row.nik !== '-'" class="pr-nik-chip">{{ row.nik }}</span>
							<span v-else class="pr-nik-empty">Belum diisi</span>
						</td>
						<td class="pr-td-role">{{ row.sebagai }}</td>
						<td class="pr-td-ihs">
							<span v-if="row.satusehat_ihs_id" class="pr-ihs-chip">{{ row.satusehat_ihs_id }}</span>
							<span v-else class="pr-ihs-empty">—</span>
						</td>
						<td class="pr-td-status">
							<span :class="statusClass(row.sync_status)" class="pr-status-badge">{{ statusLabel(row.sync_status) }}</span>
						</td>
						<td class="pr-td-date">
							<span v-if="row.synced_at">{{ formatDate(row.synced_at) }}</span>
							<span v-else class="pr-date-empty">—</span>
						</td>
						<td class="pr-td-action">
							<button
								class="pr-sync-btn"
								:class="row.sync_status === 'synced' ? 'pr-sync-btn-re' : 'pr-sync-btn-go'"
								:disabled="syncingUuid === row.uuid || row.nik === '-'"
								@click="syncOne(row)"
								:title="syncBtnTitle(row)"
							>
								<svg v-if="syncingUuid !== row.uuid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
								<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="prt-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
							</button>
						</td>
					</tr>
				</tbody>
			</table>

			<!-- Pagination -->
			<div class="pr-pagination" v-if="!tableLoading && totalRows > perPage">
				<button class="pr-page-btn" :disabled="currentPage <= 1" @click="goPage(currentPage - 1)">&#8592;</button>
				<span class="pr-page-info">Hal {{ currentPage }} / {{ totalPages }} &nbsp;({{ totalRows }} dokter)</span>
				<button class="pr-page-btn" :disabled="currentPage >= totalPages" @click="goPage(currentPage + 1)">&#8594;</button>
			</div>
			<div class="pr-total-info" v-if="!tableLoading && totalRows <= perPage && totalRows > 0">
				{{ totalRows }} dokter ditampilkan
			</div>
		</div>
	</div>

</div>
<Loader ref="Loader"></Loader>
</div>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default {
	emits: ['titletrigger', 'repatch'],
	components: {
		toast,
	},
	mounted() {
		vm = this;
		setTimeout(() => { vm.titletrigger(); }, 250);
		vm.loadStats();
		vm.loadTable();
	},
	data() {
		return {
			uri: 'satusehat-practitioner-sync',
			link: {
				dashboard: '/satusehat-api/practitioner-sync/dashboard',
				list:      '/satusehat-api/practitioner-sync/list',
				syncOne:   '/satusehat-api/practitioner-sync/sync-one',
				syncBulk:  '/satusehat-api/practitioner-sync/sync-bulk',
			},
			stats:        null,
			statsLoading: true,
			rows:         [],
			tableLoading: true,
			totalRows:    0,
			perPage:      20,
			currentPage:  1,
			searchQuery:  '',
			searchTimer:  null,
			activeFilter: 'all',
			syncing:      false,
			syncingUuid:  null,
			syncBatch:    20,
			lastSyncResult: null,
			showLog:      false,
			tabs: [
				{ key: 'all',       label: 'Semua'             },
				{ key: 'synced',    label: 'Sudah Sync'        },
				{ key: 'pending',   label: 'Belum Sync'        },
				{ key: 'not_found', label: 'Tidak Ditemukan'   },
				{ key: 'failed',    label: 'Gagal'             },
				{ key: 'no_nik',    label: 'Tanpa NIK'         },
			],
		};
	},
	computed: {
		totalPages() { return Math.ceil(vm.totalRows / vm.perPage); },
	},
	methods: {
		// ── Stats ──────────────────────────────────────────────────────────
		loadStats() {
			vm.statsLoading = true;
			axios.post(vm.link.dashboard, new FormData(), { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => {
					if (r.data.data === '419') { window.location.href = '/masuk'; return; }
					vm.stats        = (typeof r.data.data === 'object') ? r.data.data : null;
					vm.statsLoading = false;
				})
				.catch(() => {
					vm.statsLoading = false;
					vm.notify('Gagal memuat statistik Practitioner.', 'error');
				});
		},

		// ── Table ──────────────────────────────────────────────────────────
		loadTable(page = 1) {
			vm.tableLoading = true;
			vm.currentPage  = page;
			const fd = new FormData();
			fd.append('search', vm.searchQuery);
			fd.append('filter', vm.activeFilter);
			fd.append('page',   page);
			axios.post(vm.link.list, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => {
					if (r.data.data === '419') { window.location.href = '/masuk'; return; }
					vm.rows         = r.data.data  ?? [];
					vm.totalRows    = r.data.total ?? 0;
					vm.tableLoading = false;
				})
				.catch(() => {
					vm.tableLoading = false;
					vm.notify('Gagal memuat daftar dokter.', 'error');
				});
		},

		// ── Sync single ───────────────────────────────────────────────────
		syncOne(row) {
			if (vm.syncingUuid) return;
			vm.syncingUuid = row.uuid;
			const fd = new FormData();
			fd.append('uuid', row.uuid);
			axios.post(vm.link.syncOne, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => {
					vm.syncingUuid = null;
					const d = r.data;
					if (d.data === 'berhasil') {
						vm.notify(`${row.nama}: IHS ID ${d.ihs_id}`, 'success');
						vm.loadStats();
						vm.loadTable(vm.currentPage);
					} else if (d.data === 'not_found') {
						vm.notify(`${row.nama}: Tidak ditemukan di SatuSehat.`, 'warn');
						vm.loadTable(vm.currentPage);
					} else {
						vm.notify(`${row.nama}: ${d.message ?? 'Gagal sync.'}`, 'error');
						vm.loadTable(vm.currentPage);
					}
				})
				.catch(e => {
					vm.syncingUuid = null;
					const msg = e.response?.data?.message ?? 'Gagal sync.';
					vm.notify(`${row.nama}: ${msg}`, 'error');
				});
		},

		// ── Bulk sync ─────────────────────────────────────────────────────
		runBulkSync() {
			if (vm.syncing) return;
			vm.syncing        = true;
			vm.lastSyncResult = null;
			const fd = new FormData();
			fd.append('batch', vm.syncBatch);
			axios.post(vm.link.syncBulk, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => {
					vm.syncing = false;
					const d    = r.data;
					if (d.data === 'kosong') {
						vm.notify(d.message, 'info');
					} else {
						vm.lastSyncResult = { synced: d.synced, not_found: d.not_found, failed: d.failed, message: d.message, output: d.output };
						if (d.synced > 0) { vm.notify(d.message, 'success'); }
						vm.loadStats();
						vm.loadTable(1);
					}
				})
				.catch(e => {
					vm.syncing = false;
					vm.notify(e.response?.data?.message ?? 'Bulk sync gagal.', 'error');
				});
		},

		// ── Filter / Search ───────────────────────────────────────────────
		switchFilter(key) {
			vm.activeFilter = key;
			vm.currentPage  = 1;
			vm.loadTable(1);
		},

		onSearch() {
			clearTimeout(vm.searchTimer);
			vm.searchTimer = setTimeout(() => { vm.loadTable(1); }, 400);
		},

		clearSearch() {
			vm.searchQuery = '';
			vm.loadTable(1);
		},

		goPage(page) {
			if (page < 1 || page > vm.totalPages) return;
			vm.loadTable(page);
		},

		// ── Helpers ───────────────────────────────────────────────────────
		statusClass(status) {
			const map = {
				synced:    'pr-badge-green',
				not_found: 'pr-badge-yellow',
				failed:    'pr-badge-red',
			};
			return map[status] ?? 'pr-badge-slate';
		},

		statusLabel(status) {
			const map = {
				synced:    'Synced',
				not_found: 'Tidak Ditemukan',
				failed:    'Gagal',
			};
			return map[status] ?? 'Belum Sync';
		},

		formatDate(dt) {
			if (!dt) return '—';
			const d = new Date(dt);
			return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
				+ ' ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
		},

		notify(msg, type) {
			if (type === 'success') toast.success(msg, { rtl: false, autoClose: 4000 });
			else if (type === 'error') toast.error(msg, { rtl: false, autoClose: 4000 });
			else if (type === 'warn')  toast.warning(msg, { rtl: false, autoClose: 4000 });
			else toast.info(msg, { rtl: false, autoClose: 3000 });
		},

		syncBtnTitle(row) {
			if (row.nik === '-') return 'NIK belum diisi';
			return row.sync_status === 'synced' ? 'Re-sync' : 'Sync ke SatuSehat';
		},

		titletrigger() {
			let title = vm.$router.currentRoute._value.meta.title;
			vm.$emit('titletrigger', title);
		},
	},
}
</script>

<style scoped>
/* ── Trigger Panel ──────────────────────────────────────────────────────── */
.pr-trigger-panel {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-left: 4px solid #7c3aed;
	border-radius: 10px;
	padding: 18px 20px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 16px;
	flex-wrap: wrap;
	margin-bottom: 8px;
	box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.prt-left { display: flex; align-items: center; gap: 14px; flex: 1; }
.prt-icon {
	width: 42px; height: 42px; background: #ede9fe; border-radius: 10px;
	display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.prt-icon svg { width: 22px; height: 22px; stroke: #7c3aed; }
.prt-title { font-size: 14px; font-weight: 700; color: #1e293b; }
.prt-desc  { font-size: 12px; color: #64748b; margin-top: 3px; }
.prt-right { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.prt-batch-label { font-size: 11px; color: #64748b; }
.prt-batch-wrap  { display: flex; flex-direction: column; gap: 3px; }
.prt-batch-select {
	padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px;
	font-size: 13px; color: #334155; background: #fff;
}
.prt-run-btn {
	display: flex; align-items: center; gap: 7px;
	background: #7c3aed; color: #fff;
	border: none; border-radius: 8px;
	padding: 9px 18px; font-size: 13px; font-weight: 600;
	cursor: pointer; transition: background .15s;
}
.prt-run-btn:hover:not(:disabled) { background: #6d28d9; }
.prt-run-btn:disabled { opacity: .55; cursor: not-allowed; }
.prt-btn-icon { width: 16px; height: 16px; }
.prt-spin { animation: spin 1s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* Result bar */
.pr-sync-result {
	background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;
	padding: 10px 16px; display: flex; align-items: center; gap: 14px;
	flex-wrap: wrap; margin-top: 8px;
}
.psr-item { display: flex; align-items: center; gap: 5px; font-size: 13px; }
.psr-item svg { width: 14px; height: 14px; }
.psr-green  { color: #16a34a; }
.psr-slate  { color: #475569; }
.psr-red    { color: #dc2626; }
.psr-msg    { font-size: 12px; color: #64748b; flex: 1; }
.psr-close  { margin-left: auto; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 14px; padding: 2px 6px; }
.pr-sync-log { background: #0f172a; border-radius: 8px; overflow: hidden; margin-top: 8px; }
.psl-header { display: flex; justify-content: space-between; align-items: center; padding: 8px 14px; background: #1e293b; }
.psl-header span { font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; }
.psl-toggle { background: none; border: 1px solid #334155; color: #94a3b8; font-size: 11px; border-radius: 4px; padding: 2px 8px; cursor: pointer; }
.psl-body { margin: 0; padding: 12px 14px; font-size: 11px; color: #94a3b8; font-family: monospace; white-space: pre-wrap; max-height: 240px; overflow-y: auto; }

/* ── NIK Warning ────────────────────────────────────────────────────────── */
.pr-nik-warn {
	background: #fffbeb; border: 1px solid #fde68a; border-left: 4px solid #f59e0b;
	border-radius: 8px; padding: 12px 16px; display: flex; align-items: flex-start;
	gap: 12px; flex-wrap: wrap; margin-bottom: 4px;
}
.pr-ww-icon { width: 20px; height: 20px; stroke: #d97706; flex-shrink: 0; margin-top: 2px; }
.pr-ww-body { flex: 1; }
.pr-ww-title { font-size: 13px; font-weight: 700; color: #92400e; }
.pr-ww-text  { font-size: 12px; color: #78350f; margin-top: 3px; }
.pr-ww-actions { display: flex; gap: 8px; align-items: center; }
.pr-ww-btn-ghost { background: none; border: 1px solid #d97706; color: #d97706; border-radius: 6px; padding: 5px 12px; font-size: 12px; cursor: pointer; }

/* ── Stats Cards ────────────────────────────────────────────────────────── */
.pr-stats-row { display: flex; gap: 12px; flex-wrap: wrap; }
.pr-stat-card {
	flex: 1; min-width: 130px;
	background: #fff; border: 1px solid #e2e8f0;
	border-radius: 10px; padding: 14px 16px;
	cursor: pointer; transition: box-shadow .15s, transform .1s;
	box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.pr-stat-card:hover  { box-shadow: 0 4px 12px rgba(0,0,0,.1); transform: translateY(-1px); }
.pr-card-active      { outline: 2px solid currentColor; }
.prc-top  { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
.prc-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; color: #94a3b8; }
.prc-icon {
	width: 30px; height: 30px; border-radius: 8px;
	display: flex; align-items: center; justify-content: center;
}
.prc-icon svg { width: 15px; height: 15px; }
.prc-icon-blue   { background: #dbeafe; } .prc-icon-blue   svg { stroke: #1d4ed8; }
.prc-icon-green  { background: #dcfce7; } .prc-icon-green  svg { stroke: #16a34a; }
.prc-icon-slate  { background: #f1f5f9; } .prc-icon-slate  svg { stroke: #475569; }
.prc-icon-yellow { background: #fef9c3; } .prc-icon-yellow svg { stroke: #ca8a04; }
.prc-icon-red    { background: #fee2e2; } .prc-icon-red    svg { stroke: #dc2626; }
.prc-icon-orange { background: #ffedd5; } .prc-icon-orange svg { stroke: #ea580c; }
.prc-num        { font-size: 26px; font-weight: 800; color: #1e293b; line-height: 1; }
.prc-num-green  { color: #16a34a; }
.prc-num-slate  { color: #475569; }
.prc-num-yellow { color: #ca8a04; }
.prc-num-red    { color: #dc2626; }
.prc-num-orange { color: #ea580c; }
.prc-sub { font-size: 11px; color: #94a3b8; margin-top: 4px; }

/* Stats skeleton */
.pr-stats-skeleton { display: flex; gap: 12px; flex-wrap: wrap; }
.skel-card { flex: 1; min-width: 130px; height: 88px; border-radius: 10px; }

/* ── Filter Tabs ─────────────────────────────────────────────────────────── */
.pr-tabs { display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 4px; }
.pr-tab {
	padding: 6px 14px; font-size: 12px; font-weight: 500;
	border: 1px solid #e2e8f0; border-radius: 6px;
	background: #fff; color: #64748b; cursor: pointer; transition: all .12s;
}
.pr-tab:hover { background: #f8fafc; }
.pr-tab-active { background: #7c3aed; color: #fff; border-color: #7c3aed; font-weight: 700; }

/* ── Search ──────────────────────────────────────────────────────────────── */
.pr-searchbar {
	display: flex; align-items: center; gap: 8px;
	background: #fff; border: 1px solid #e2e8f0; border-radius: 8px;
	padding: 8px 12px; margin-bottom: 8px;
}
.pr-search-icon { width: 16px; height: 16px; stroke: #94a3b8; flex-shrink: 0; }
.pr-search-input { flex: 1; border: none; outline: none; font-size: 13px; color: #334155; background: transparent; }
.pr-search-clear { background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 13px; padding: 0 4px; }

/* ── Table ───────────────────────────────────────────────────────────────── */
.pr-table-wrap { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.pr-table { width: 100%; border-collapse: collapse; }
.pr-table thead tr { background: #f8fafc; }
.pr-table th {
	text-align: left; padding: 10px 14px;
	font-size: 11px; font-weight: 700; text-transform: uppercase;
	letter-spacing: .4px; color: #64748b;
	border-bottom: 2px solid #e2e8f0;
}
.pr-row td { padding: 11px 14px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; }
.pr-row:last-child td { border-bottom: none; }
.pr-row:hover td { background: #fafafa; }

.pr-td-nama  { font-weight: 600; color: #1e293b; }
.pr-td-nik   { font-family: monospace; font-size: 12px; }
.pr-td-role  { color: #64748b; font-size: 12px; }
.pr-td-ihs   { font-family: monospace; font-size: 11px; }
.pr-td-date  { font-size: 11px; color: #94a3b8; }
.pr-td-action { text-align: center; }

.pr-nik-chip  { background: #f1f5f9; padding: 2px 8px; border-radius: 6px; color: #334155; }
.pr-nik-empty { color: #fca5a5; font-size: 11px; font-style: italic; }
.pr-ihs-chip  { background: #ede9fe; color: #6d28d9; padding: 2px 8px; border-radius: 6px; font-weight: 600; }
.pr-ihs-empty { color: #cbd5e1; }
.pr-date-empty { color: #cbd5e1; }

/* Status badges */
.pr-status-badge { padding: 2px 9px; border-radius: 12px; font-size: 11px; font-weight: 700; }
.pr-badge-green  { background: #dcfce7; color: #16a34a; }
.pr-badge-yellow { background: #fef9c3; color: #ca8a04; }
.pr-badge-red    { background: #fee2e2; color: #dc2626; }
.pr-badge-slate  { background: #f1f5f9; color: #64748b; }

/* Sync button */
.pr-sync-btn {
	width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
	border: none; border-radius: 7px; cursor: pointer; transition: background .12s;
}
.pr-sync-btn svg { width: 15px; height: 15px; }
.pr-sync-btn-go  { background: #7c3aed; } .pr-sync-btn-go  svg { stroke: #fff; }
.pr-sync-btn-go:hover:not(:disabled)  { background: #6d28d9; }
.pr-sync-btn-re  { background: #f1f5f9; } .pr-sync-btn-re  svg { stroke: #475569; }
.pr-sync-btn-re:hover:not(:disabled)  { background: #e2e8f0; }
.pr-sync-btn:disabled { opacity: .45; cursor: not-allowed; }

/* Empty state */
.pr-empty { text-align: center; padding: 40px 20px !important; color: #94a3b8; }
.pr-empty svg { width: 36px; height: 36px; stroke: #cbd5e1; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
.pr-empty span { font-size: 13px; }

/* Skeleton rows */
.pr-row-skel td { padding: 11px 14px; border-bottom: 1px solid #f1f5f9; }
.skel {
	background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
	background-size: 200% 100%;
	animation: shimmer 1.4s infinite;
	border-radius: 6px;
}
.skel-text   { height: 14px; width: 80%; }
.skel-sm     { width: 55%; }
.skel-md     { width: 65%; }
.skel-badge  { height: 20px; width: 70px; border-radius: 12px; }
.skel-btn    { height: 28px; width: 32px; border-radius: 7px; }
@keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

/* Pagination */
.pr-pagination, .pr-total-info {
	display: flex; align-items: center; justify-content: center;
	gap: 12px; padding: 12px 20px;
	border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b;
}
.pr-page-btn {
	padding: 5px 12px; border: 1px solid #e2e8f0; border-radius: 6px;
	background: #fff; cursor: pointer; font-size: 13px; color: #334155;
}
.pr-page-btn:disabled { opacity: .4; cursor: not-allowed; }
.pr-page-info { font-size: 12px; color: #64748b; }
</style>
