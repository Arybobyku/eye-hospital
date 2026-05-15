<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Manual Trigger Panel ───────────────────────────────────────── -->
	<div class="col-12">
		<div class="es-trigger-panel">
			<div class="etp-left">
				<div class="etp-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
				</div>
				<div>
					<div class="etp-title">Sync Encounter Manual</div>
					<div class="etp-desc">
						Kirim data kunjungan (registrasi) ke SatuSehat. Scheduler otomatis berjalan
						<strong>setiap 30 menit</strong>. Hanya registrasi yang pasiennya sudah ter-sync yang diproses.
					</div>
				</div>
			</div>
			<div class="etp-right">
				<div class="etp-batch-wrap">
					<label class="etp-batch-label">Batch per run</label>
					<select v-model="syncBatch" class="etp-batch-select" :disabled="syncing">
						<option value="10">10 kunjungan</option>
						<option value="20">20 kunjungan</option>
						<option value="30">30 kunjungan</option>
						<option value="50">50 kunjungan</option>
					</select>
				</div>
				<button class="etp-run-btn" @click="runSync" :disabled="syncing || statsLoading">
					<svg v-if="!syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polygon points="5 3 19 12 5 21 5 3"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ syncing ? 'Sedang berjalan…' : 'Jalankan Sync' }}
				</button>
			</div>
		</div>

		<!-- Result bar -->
		<div class="es-sync-result" v-if="lastSyncResult">
			<div class="esr-item esr-green" v-if="lastSyncResult.synced >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				<strong>{{ lastSyncResult.synced }}</strong> berhasil sync
			</div>
			<div class="esr-item esr-red" v-if="lastSyncResult.failed >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
				<strong>{{ lastSyncResult.failed }}</strong> gagal
			</div>
			<div class="esr-msg">{{ lastSyncResult.message }}</div>
			<button class="esr-close" @click="lastSyncResult = null">✕</button>
		</div>

		<!-- Log output -->
		<div class="es-sync-log" v-if="lastSyncResult && lastSyncResult.output">
			<div class="esl-header">
				<span>Output log</span>
				<button class="esl-toggle" @click="showLog = !showLog">{{ showLog ? 'Sembunyikan' : 'Tampilkan' }}</button>
			</div>
			<pre class="esl-body" v-if="showLog">{{ lastSyncResult.output }}</pre>
		</div>
	</div>

	<!-- ── Stats Cards ─────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="es-stats-row" v-if="!statsLoading && stats">

			<div class="es-stat-card es-card-blue">
				<div class="esc-top">
					<span class="esc-label">Total Kunjungan</span>
					<div class="esc-icon esc-icon-blue">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
					</div>
				</div>
				<div class="esc-num">{{ stats.total.toLocaleString('id-ID') }}</div>
				<div class="esc-sub">Seluruh registrasi aktif</div>
			</div>

			<div class="es-stat-card es-card-green">
				<div class="esc-top">
					<span class="esc-label">Berhasil Dikirim</span>
					<div class="esc-icon esc-icon-green">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
					</div>
				</div>
				<div class="esc-num">{{ stats.synced.toLocaleString('id-ID') }}</div>
				<div class="esc-bar-wrap">
					<div class="esc-bar esc-bar-green" :style="{ width: stats.pct_synced + '%' }"></div>
				</div>
				<div class="esc-sub">{{ stats.pct_synced }}% dari total</div>
			</div>

			<div class="es-stat-card es-card-yellow">
				<div class="esc-top">
					<span class="esc-label">Pending</span>
					<div class="esc-icon esc-icon-yellow">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					</div>
				</div>
				<div class="esc-num">{{ stats.pending.toLocaleString('id-ID') }}</div>
				<div class="esc-sub">Menunggu diproses scheduler</div>
			</div>

			<div class="es-stat-card es-card-slate">
				<div class="esc-top">
					<span class="esc-label">Pasien Belum Sync</span>
					<div class="esc-icon esc-icon-slate">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
					</div>
				</div>
				<div class="esc-num">{{ stats.not_eligible.toLocaleString('id-ID') }}</div>
				<div class="esc-sub">Pasien perlu sync dulu ke SatuSehat</div>
			</div>

			<div class="es-stat-card es-card-red">
				<div class="esc-top">
					<span class="esc-label">Gagal (Error)</span>
					<div class="esc-icon esc-icon-red">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					</div>
				</div>
				<div class="esc-num">{{ stats.failed.toLocaleString('id-ID') }}</div>
				<div class="esc-sub">
					<button class="esc-retry-btn" v-if="stats.failed > 0" @click="retryFailed" :disabled="retrying">
						{{ retrying ? 'Memproses…' : 'Reset & Retry' }}
					</button>
					<span v-else>Tidak ada error</span>
				</div>
			</div>

		</div>

		<!-- Last sync info -->
		<div class="es-last-sync" v-if="!statsLoading && stats && stats.last_sync">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="es-clock-icon"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			Sync terakhir: <strong>{{ formatDate(stats.last_sync) }}</strong>
			&nbsp;·&nbsp;
			Scheduler: setiap 30 menit otomatis
			&nbsp;·&nbsp;
			<code>php artisan satusehat:sync-encounter</code>
		</div>

		<!-- Stats skeleton -->
		<div class="es-stats-skeleton" v-if="statsLoading">
			<div class="skel" v-for="i in 5" :key="i"></div>
		</div>
	</div>

	<!-- ── Filter & Tabel ──────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="es-table-card">

			<!-- Toolbar -->
			<div class="es-toolbar">
				<div class="es-filter-tabs">
					<button v-for="tab in tabs" :key="tab.key"
						class="es-tab" :class="{ active: activeTab === tab.key }"
						@click="switchTab(tab.key)">
						{{ tab.label }}
					</button>
				</div>
				<div class="es-search-wrap">
					<input v-model="search" @keyup.enter="doSearch" type="text"
						placeholder="Cari nama / nomor / dokter / encounter ID…" class="es-search-input" />
					<button @click="doSearch" class="es-search-btn">Cari</button>
				</div>
			</div>

			<!-- Table -->
			<div class="es-table-wrap" v-if="!listLoading">
				<table class="es-table" v-if="list.length > 0">
					<thead>
						<tr>
							<th>No. Registrasi</th>
							<th>Nama Pasien</th>
							<th>Dokter</th>
							<th>Poli</th>
							<th>Tgl Kunjungan</th>
							<th>Encounter ID (SatuSehat)</th>
							<th>Status</th>
							<th>Waktu Sync</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="row in list" :key="row.id" :class="{ 'es-row-syncing': syncingRows[row.uuid] }">
							<td class="es-td-nomor">
								<div class="es-nomor">{{ row.nomor }}</div>
								<div class="es-rm">{{ row.rekam_medis }}</div>
							</td>
							<td>
								<div class="es-name">{{ row.nama_pasien }}</div>
								<div class="es-ihs-small" v-if="row.patient_ihs_id">
									<span class="es-badge-mini es-badge-green">✓ IHS: {{ row.patient_ihs_id }}</span>
								</div>
								<div class="es-ihs-small" v-else>
									<span class="es-badge-mini es-badge-slate">Pasien belum sync</span>
								</div>
							</td>
							<td class="es-td-sm">{{ row.nama_dokter || '-' }}</td>
							<td class="es-td-sm">
								<div>{{ row.ruang_poliklinik || '-' }}</div>
								<div class="es-loc-id" v-if="row.satusehat_location_id">
									<small class="es-loc-chip">{{ row.satusehat_location_id }}</small>
								</div>
							</td>
							<td class="es-td-sm">
								<div>{{ row.tanggal }}</div>
								<div class="es-td-waktu">{{ row.waktu }}</div>
							</td>
							<td>
								<span class="es-encounter-id" v-if="row.satusehat_encounter_id">
									{{ row.satusehat_encounter_id }}
								</span>
								<span class="es-no-id" v-else>—</span>
							</td>
							<td>
								<span class="es-badge" :class="statusBadgeClass(row.satusehat_encounter_status)">
									{{ statusLabel(row.satusehat_encounter_status, row.patient_ihs_id) }}
								</span>
							</td>
							<td class="es-td-sm">
								<span v-if="row.satusehat_encounter_synced_at">{{ formatDate(row.satusehat_encounter_synced_at) }}</span>
								<span v-else class="es-no-id">—</span>
							</td>
							<td class="es-td-action">
								<!-- Tombol sync per baris — disabled jika sedang diproses atau pasien belum punya IHS ID -->
								<button
									v-if="row.satusehat_encounter_status !== 'synced'"
									class="es-sync-one-btn"
									:class="{ 'es-sync-one-loading': syncingRows[row.uuid] }"
									:disabled="!!syncingRows[row.uuid] || !row.patient_ihs_id"
									:title="!row.patient_ihs_id ? 'Pasien belum memiliki ID SatuSehat. Jalankan Patient Sync terlebih dahulu.' : 'Kirim encounter ke SatuSehat'"
									@click="syncOne(row)">
									<svg v-if="!syncingRows[row.uuid]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
									<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
									{{ syncingRows[row.uuid] ? '' : 'Sync' }}
								</button>
								<!-- Sudah synced — tampilkan label saja -->
								<span v-else class="es-synced-label">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
									Terkirim
								</span>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- Empty state -->
				<div class="es-empty" v-else>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="es-empty-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
					<div>Tidak ada data ditemukan</div>
				</div>
			</div>

			<!-- List Skeleton -->
			<div class="es-list-skeleton" v-if="listLoading">
				<div class="skel-row" v-for="i in 8" :key="i"></div>
			</div>

			<!-- Pagination -->
			<div class="es-pagination" v-if="!listLoading && totalPage > 1">
				<button class="es-page-btn" :disabled="page <= 1" @click="changePage(page - 1)">‹</button>
				<span class="es-page-info">{{ page }} / {{ totalPage }}</span>
				<button class="es-page-btn" :disabled="page >= totalPage" @click="changePage(page + 1)">›</button>
			</div>

			<!-- Total row count -->
			<div class="es-count-info" v-if="!listLoading && total > 0">
				Menampilkan {{ list.length }} dari {{ total.toLocaleString('id-ID') }} registrasi
			</div>

		</div>
	</div>

</div>
</div>
</template>

<script>
import axios from 'axios';

export default {
	name: 'EncounterSync',
	data() {
		return {
			// Stats
			stats: null,
			statsLoading: true,

			// Table
			list: [],
			listLoading: false,
			total: 0,
			page: 1,
			take: 20,
			search: '',
			activeTab: 'all',

			// Manual sync (batch)
			syncing: false,
			syncBatch: 20,
			lastSyncResult: null,
			showLog: false,

			// Sync per row — { uuid: true/false }
			syncingRows: {},

			// Retry
			retrying: false,

			tabs: [
				{ key: 'all',          label: 'Semua' },
				{ key: 'pending',      label: 'Pending' },
				{ key: 'synced',       label: 'Berhasil' },
				{ key: 'not_eligible', label: 'Pasien Belum Sync' },
				{ key: 'failed',       label: 'Gagal' },
			],
		};
	},

	computed: {
		totalPage() {
			return Math.ceil(this.total / this.take);
		},
	},

	mounted() {
		this.loadDashboard();
		this.loadList();
	},

	methods: {
		// ── API base ──────────────────────────────────────────────────────
		api(path, payload = {}) {
			return axios.post('/satusehat-api/encounter-sync/' + path, payload);
		},

		// ── Stats ─────────────────────────────────────────────────────────
		loadDashboard() {
			var vm = this;
			vm.statsLoading = true;
			vm.api('dashboard').then(function (r) {
				if (r.data.data && typeof r.data.data === 'object') {
					vm.stats = r.data.data;
				}
			}).catch(function () {}).finally(function () {
				vm.statsLoading = false;
			});
		},

		// ── Table ─────────────────────────────────────────────────────────
		loadList() {
			var vm = this;
			vm.listLoading = true;
			vm.api('list', {
				page:   vm.page,
				status: vm.activeTab,
				search: vm.search,
			}).then(function (r) {
				vm.list  = r.data.data  || [];
				vm.total = r.data.total || 0;
			}).catch(function () {
				vm.list  = [];
				vm.total = 0;
			}).finally(function () {
				vm.listLoading = false;
			});
		},

		switchTab(key) {
			var vm = this;
			vm.activeTab = key;
			vm.page      = 1;
			vm.search    = '';
			vm.loadList();
		},

		doSearch() {
			var vm = this;
			vm.page = 1;
			vm.loadList();
		},

		changePage(p) {
			var vm = this;
			vm.page = p;
			vm.loadList();
		},

		// ── Manual Sync ───────────────────────────────────────────────────
		runSync() {
			var vm = this;
			if (vm.syncing) return;
			vm.syncing       = true;
			vm.lastSyncResult = null;
			vm.showLog        = false;

			vm.api('run-sync', { batch: vm.syncBatch }, { timeout: 300000 })
				.then(function (r) {
					vm.lastSyncResult = r.data;
					vm.loadDashboard();
					vm.loadList();
				})
				.catch(function (e) {
					vm.lastSyncResult = {
						synced:  0,
						failed:  0,
						message: e.response ? e.response.data.message : 'Request timeout / network error',
						output:  '',
					};
				})
				.finally(function () {
					vm.syncing = false;
				});
		},

		// ── Retry Failed ──────────────────────────────────────────────────
		retryFailed() {
			var vm = this;
			if (vm.retrying) return;
			vm.retrying = true;
			vm.api('retry-failed').then(function (r) {
				if (r.data.data === 'berhasil') {
					vm.loadDashboard();
					vm.loadList();
				}
			}).catch(function () {}).finally(function () {
				vm.retrying = false;
			});
		},

		// ── Sync per baris ────────────────────────────────────────────────
		syncOne(row) {
			var vm = this;
			if (vm.syncingRows[row.uuid]) return;

			vm.syncingRows = { ...vm.syncingRows, [row.uuid]: true };

			vm.api('sync-one', { uuid: row.uuid })
				.then(function (r) {
					if (r.data.data === 'berhasil') {
						// Update baris langsung di list tanpa reload penuh
						var idx = vm.list.findIndex(function (i) { return i.uuid === row.uuid; });
						if (idx !== -1) {
							vm.list[idx].satusehat_encounter_id      = r.data.encounter_id;
							vm.list[idx].satusehat_encounter_status  = 'synced';
							vm.list[idx].satusehat_encounter_synced_at = new Date().toISOString();
						}
						vm.loadDashboard();
					} else {
						alert('Gagal: ' + (r.data.message || 'Unknown error'));
						// Refresh baris agar status terbaru tampil
						vm.loadList();
					}
				})
				.catch(function (e) {
					var msg = e.response && e.response.data ? e.response.data.message : 'Network error';
					alert('Gagal mengirim encounter: ' + msg);
					vm.loadList();
				})
				.finally(function () {
					vm.syncingRows = { ...vm.syncingRows, [row.uuid]: false };
				});
		},

		// ── Helpers ───────────────────────────────────────────────────────
		statusLabel(status, patientIhsId) {
			if (status === 'synced')  return 'Berhasil';
			if (status === 'failed')  return 'Gagal';
			if (!patientIhsId)        return 'Pasien Belum Sync';
			return 'Pending';
		},

		statusBadgeClass(status) {
			if (status === 'synced') return 'es-badge-green';
			if (status === 'failed') return 'es-badge-red';
			return 'es-badge-yellow';
		},

		formatDate(dt) {
			if (!dt) return '-';
			var d = new Date(dt);
			return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
				+ ' ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
		},
	},
};
</script>

<style scoped>
/* ── Trigger Panel ─────────────────────────────────────────────────────────── */
.es-trigger-panel {
	display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;
	background: #fff; border-left: 4px solid #7c3aed; border-radius: 10px;
	padding: 18px 22px; margin-bottom: 4px;
	box-shadow: 0 1px 4px rgba(0,0,0,.07);
}
.etp-left  { display: flex; align-items: center; gap: 14px; flex: 1; min-width: 260px; }
.etp-icon  { width: 40px; height: 40px; background: #ede9fe; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.etp-icon svg { width: 20px; height: 20px; stroke: #7c3aed; }
.etp-title { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 2px; }
.etp-desc  { font-size: 12px; color: #64748b; line-height: 1.5; }
.etp-right { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.etp-batch-wrap   { display: flex; flex-direction: column; gap: 4px; }
.etp-batch-label  { font-size: 11px; color: #64748b; font-weight: 500; }
.etp-batch-select { padding: 6px 10px; border: 1px solid #e2e8f0; border-radius: 7px; font-size: 13px; background: #f8fafc; color: #1e293b; cursor: pointer; }
.etp-run-btn { display: flex; align-items: center; gap: 7px; padding: 9px 18px; background: #7c3aed; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background .15s; white-space: nowrap; }
.etp-run-btn:hover:not(:disabled) { background: #6d28d9; }
.etp-run-btn:disabled { opacity: .65; cursor: not-allowed; }
.etp-btn-icon { width: 15px; height: 15px; }
@keyframes espin { to { transform: rotate(360deg); } }
.etp-spin { animation: espin .8s linear infinite; }

/* ── Result bar ─────────────────────────────────────────────────────────────── */
.es-sync-result { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; padding: 10px 16px; background: #f1f5f9; border-radius: 8px; margin-top: 8px; font-size: 13px; }
.esr-item  { display: flex; align-items: center; gap: 6px; font-size: 13px; }
.esr-item svg { width: 14px; height: 14px; }
.esr-green { color: #16a34a; }
.esr-red   { color: #dc2626; }
.esr-msg   { color: #475569; font-style: italic; flex: 1; min-width: 120px; }
.esr-close { margin-left: auto; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 14px; padding: 2px 6px; border-radius: 4px; }
.esr-close:hover { background: #e2e8f0; }

/* ── Log ────────────────────────────────────────────────────────────────────── */
.es-sync-log    { margin-top: 8px; background: #0f172a; border-radius: 8px; overflow: hidden; }
.esl-header     { display: flex; justify-content: space-between; align-items: center; padding: 8px 14px; border-bottom: 1px solid rgba(255,255,255,.08); }
.esl-header span { font-size: 12px; color: #94a3b8; font-weight: 500; }
.esl-toggle     { background: none; border: none; color: #7c3aed; font-size: 12px; cursor: pointer; padding: 2px 8px; border-radius: 4px; }
.esl-toggle:hover { background: rgba(124,58,237,.15); }
.esl-body       { margin: 0; padding: 12px 14px; font-size: 11px; color: #a3e635; font-family: monospace; line-height: 1.6; overflow-x: auto; white-space: pre-wrap; max-height: 260px; overflow-y: auto; }

/* ── Stats row ──────────────────────────────────────────────────────────────── */
.es-stats-row    { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 10px; }
.es-stat-card    { flex: 1; min-width: 160px; background: #fff; border-radius: 10px; padding: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.07); border-top: 3px solid transparent; }
.es-card-blue    { border-top-color: #3b82f6; }
.es-card-green   { border-top-color: #22c55e; }
.es-card-yellow  { border-top-color: #f59e0b; }
.es-card-slate   { border-top-color: #64748b; }
.es-card-red     { border-top-color: #ef4444; }
.esc-top         { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.esc-label       { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .4px; }
.esc-icon        { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
.esc-icon svg    { width: 16px; height: 16px; }
.esc-icon-blue   { background: #dbeafe; } .esc-icon-blue svg   { stroke: #2563eb; }
.esc-icon-green  { background: #dcfce7; } .esc-icon-green svg  { stroke: #16a34a; }
.esc-icon-yellow { background: #fef9c3; } .esc-icon-yellow svg { stroke: #ca8a04; }
.esc-icon-slate  { background: #f1f5f9; } .esc-icon-slate svg  { stroke: #64748b; }
.esc-icon-red    { background: #fee2e2; } .esc-icon-red svg    { stroke: #dc2626; }
.esc-num         { font-size: 26px; font-weight: 700; color: #1e293b; line-height: 1.1; }
.esc-bar-wrap    { height: 4px; background: #f1f5f9; border-radius: 2px; margin: 8px 0 4px; overflow: hidden; }
.esc-bar         { height: 100%; border-radius: 2px; transition: width .4s; }
.esc-bar-green   { background: #22c55e; }
.esc-sub         { font-size: 11px; color: #94a3b8; margin-top: 4px; }
.esc-retry-btn   { font-size: 11px; font-weight: 600; color: #ef4444; background: #fee2e2; border: none; padding: 3px 10px; border-radius: 5px; cursor: pointer; transition: background .15s; }
.esc-retry-btn:hover:not(:disabled) { background: #fecaca; }
.esc-retry-btn:disabled { opacity: .6; cursor: not-allowed; }

/* ── Last sync info ─────────────────────────────────────────────────────────── */
.es-last-sync    { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #64748b; padding: 8px 0; }
.es-clock-icon   { width: 14px; height: 14px; flex-shrink: 0; }
.es-last-sync code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 11px; color: #475569; }

/* ── Stats skeleton ──────────────────────────────────────────────────────────── */
.es-stats-skeleton { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 10px; }
.es-stats-skeleton .skel { flex: 1; min-width: 150px; height: 100px; background: #f1f5f9; border-radius: 10px; animation: skelPulse 1.3s ease-in-out infinite; }
@keyframes skelPulse { 0%,100%{opacity:1} 50%{opacity:.5} }

/* ── Table card ─────────────────────────────────────────────────────────────── */
.es-table-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.07); overflow: hidden; }

/* ── Toolbar ────────────────────────────────────────────────────────────────── */
.es-toolbar      { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding: 14px 18px; border-bottom: 1px solid #f1f5f9; }
.es-filter-tabs  { display: flex; gap: 4px; flex-wrap: wrap; }
.es-tab          { padding: 6px 14px; border: 1px solid #e2e8f0; background: #f8fafc; color: #64748b; font-size: 12px; font-weight: 500; border-radius: 20px; cursor: pointer; transition: all .15s; }
.es-tab:hover    { border-color: #7c3aed; color: #7c3aed; }
.es-tab.active   { background: #7c3aed; border-color: #7c3aed; color: #fff; }
.es-search-wrap  { display: flex; gap: 6px; }
.es-search-input { padding: 7px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; width: 240px; outline: none; color: #1e293b; }
.es-search-input:focus { border-color: #7c3aed; }
.es-search-btn   { padding: 7px 14px; background: #7c3aed; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; }
.es-search-btn:hover { background: #6d28d9; }

/* ── Table ──────────────────────────────────────────────────────────────────── */
.es-table-wrap   { overflow-x: auto; }
.es-table        { width: 100%; border-collapse: collapse; font-size: 13px; }
.es-table thead  { background: #f8fafc; }
.es-table th     { padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .5px; border-bottom: 1px solid #f1f5f9; white-space: nowrap; }
.es-table td     { padding: 11px 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; color: #1e293b; }
.es-table tr:last-child td { border-bottom: none; }
.es-table tr:hover td { background: #fafbfc; }
.es-td-sm        { font-size: 12px; color: #475569; }
.es-td-nomor     { font-family: monospace; }
.es-nomor        { font-size: 13px; font-weight: 600; color: #1e293b; }
.es-rm           { font-size: 11px; color: #94a3b8; }
.es-name         { font-weight: 500; }
.es-ihs-small    { margin-top: 3px; }
.es-badge-mini   { font-size: 10px; padding: 1px 7px; border-radius: 10px; font-weight: 600; }
.es-badge-mini.es-badge-green  { background: #dcfce7; color: #166534; }
.es-badge-mini.es-badge-slate  { background: #f1f5f9; color: #475569; }
.es-loc-id       { margin-top: 3px; }
.es-loc-chip     { font-size: 10px; background: #ede9fe; color: #5b21b6; padding: 1px 6px; border-radius: 4px; font-family: monospace; }
.es-td-waktu     { font-size: 11px; color: #94a3b8; }
.es-encounter-id { font-family: monospace; font-size: 11px; color: #7c3aed; background: #ede9fe; padding: 2px 7px; border-radius: 4px; }
.es-no-id        { color: #cbd5e1; font-size: 12px; }

/* ── Status badges ──────────────────────────────────────────────────────────── */
.es-badge        { display: inline-block; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 10px; white-space: nowrap; }
.es-badge-green  { background: #dcfce7; color: #166534; }
.es-badge-red    { background: #fee2e2; color: #991b1b; }
.es-badge-yellow { background: #fef9c3; color: #713f12; }

/* ── Empty ──────────────────────────────────────────────────────────────────── */
.es-empty        { text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 14px; }
.es-empty-icon   { width: 36px; height: 36px; margin: 0 auto 10px; opacity: .4; display: block; }

/* ── List skeleton ──────────────────────────────────────────────────────────── */
.es-list-skeleton { padding: 12px 18px; }
.skel-row { height: 44px; background: #f1f5f9; border-radius: 8px; margin-bottom: 8px; animation: skelPulse 1.3s ease-in-out infinite; }

/* ── Action column ──────────────────────────────────────────────────────────── */
.es-td-action    { white-space: nowrap; }
.es-sync-one-btn {
	display: inline-flex; align-items: center; gap: 5px;
	padding: 5px 12px; font-size: 12px; font-weight: 600;
	background: #ede9fe; color: #5b21b6; border: 1px solid #c4b5fd;
	border-radius: 7px; cursor: pointer; transition: all .15s;
	white-space: nowrap;
}
.es-sync-one-btn:hover:not(:disabled) { background: #ddd6fe; border-color: #a78bfa; }
.es-sync-one-btn:disabled { opacity: .5; cursor: not-allowed; }
.es-sync-one-btn svg { width: 13px; height: 13px; flex-shrink: 0; }
.es-sync-one-loading { background: #f5f3ff !important; color: #8b5cf6 !important; padding: 5px 10px; }
.es-synced-label {
	display: inline-flex; align-items: center; gap: 4px;
	font-size: 11px; font-weight: 600; color: #16a34a;
}
.es-synced-label svg { width: 12px; height: 12px; }
.es-row-syncing td { background: #fdfbff !important; }

/* ── Pagination / count ─────────────────────────────────────────────────────── */
.es-pagination   { display: flex; justify-content: center; align-items: center; gap: 10px; padding: 12px 18px; border-top: 1px solid #f1f5f9; }
.es-page-btn     { padding: 5px 12px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 6px; cursor: pointer; font-size: 16px; color: #475569; transition: all .15s; }
.es-page-btn:hover:not(:disabled) { border-color: #7c3aed; color: #7c3aed; }
.es-page-btn:disabled { opacity: .4; cursor: not-allowed; }
.es-page-info    { font-size: 13px; color: #64748b; min-width: 60px; text-align: center; }
.es-count-info   { padding: 6px 18px 12px; font-size: 12px; color: #94a3b8; text-align: right; }
</style>
