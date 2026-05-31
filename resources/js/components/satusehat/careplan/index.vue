<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Trigger Panel ─────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="cp-trigger-panel">
			<div class="ctp-left">
				<div class="ctp-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
					</svg>
				</div>
				<div>
					<div class="ctp-title">Auto-Sync CarePlan (Rencana Rawat)</div>
					<div class="ctp-desc">
						CarePlan dikirim otomatis ke SatuSehat saat <strong>status dokter = "Sudah Diperiksa"</strong>
						via PostgreSQL LISTEN/NOTIFY. Scheduler safety net berjalan
						<strong>setiap 15 menit</strong>.
					</div>
				</div>
			</div>
			<div class="ctp-right">
				<div class="ctp-batch-wrap">
					<label class="ctp-batch-label">Batch per run</label>
					<select v-model="syncBatch" class="ctp-batch-select" :disabled="syncing">
						<option value="10">10 CarePlan</option>
						<option value="20">20 CarePlan</option>
						<option value="30">30 CarePlan</option>
						<option value="50">50 CarePlan</option>
					</select>
				</div>
				<button class="ctp-run-btn" @click="runSync" :disabled="syncing || statsLoading">
					<svg v-if="!syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ctp-btn-icon"><polygon points="5 3 19 12 5 21 5 3"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ctp-btn-icon ctp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ syncing ? 'Sedang berjalan…' : 'Jalankan Sync' }}
				</button>
			</div>
		</div>

		<div class="cp-sync-result" v-if="lastSyncResult">
			<div class="csr-item csr-green" v-if="lastSyncResult.dispatched >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				<strong>{{ lastSyncResult.dispatched }}</strong> job di-dispatch
			</div>
			<div class="csr-msg">{{ lastSyncResult.message }}</div>
			<button class="csr-close" @click="lastSyncResult = null">✕</button>
		</div>
	</div>

	<!-- ── Stats Cards ────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="cp-stats-row" v-if="!statsLoading && stats">
			<div class="cp-stat-card cp-card-blue">
				<div class="csc-top"><span class="csc-label">Total Diperiksa</span>
					<div class="csc-icon csc-icon-blue">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
					</div>
				</div>
				<div class="csc-num">{{ (stats.total||0).toLocaleString('id-ID') }}</div>
				<div class="csc-sub">Registrasi status dokter "Sudah Diperiksa"</div>
			</div>
			<div class="cp-stat-card cp-card-green">
				<div class="csc-top"><span class="csc-label">Berhasil Dikirim</span>
					<div class="csc-icon csc-icon-green">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
					</div>
				</div>
				<div class="csc-num">{{ (stats.synced||0).toLocaleString('id-ID') }}</div>
				<div class="csc-bar-wrap"><div class="csc-bar csc-bar-green" :style="{ width: stats.pct_synced + '%' }"></div></div>
				<div class="csc-sub">{{ stats.pct_synced }}% dari total</div>
			</div>
			<div class="cp-stat-card cp-card-yellow">
				<div class="csc-top"><span class="csc-label">Pending</span>
					<div class="csc-icon csc-icon-yellow">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					</div>
				</div>
				<div class="csc-num">{{ (stats.pending||0).toLocaleString('id-ID') }}</div>
				<div class="csc-sub">Menunggu diproses</div>
			</div>
			<div class="cp-stat-card cp-card-orange">
				<div class="csc-top"><span class="csc-label">Menunggu Prasyarat</span>
					<div class="csc-icon csc-icon-orange">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					</div>
				</div>
				<div class="csc-num">{{ ((stats.waiting_encounter||0) + (stats.waiting_patient||0)).toLocaleString('id-ID') }}</div>
				<div class="csc-sub">Encounter belum sync: {{ stats.waiting_encounter||0 }} | Pasien belum sync: {{ stats.waiting_patient||0 }}</div>
			</div>
			<div class="cp-stat-card cp-card-red">
				<div class="csc-top"><span class="csc-label">Gagal</span>
					<div class="csc-icon csc-icon-red">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
					</div>
				</div>
				<div class="csc-num">{{ (stats.failed||0).toLocaleString('id-ID') }}</div>
				<div class="csc-sub">
					<button class="csc-retry-btn" @click="retryFailed" v-if="stats.failed > 0">Reset untuk retry</button>
					<span v-else>Tidak ada yang gagal</span>
				</div>
			</div>
		</div>
		<div class="cp-stats-loading" v-if="statsLoading">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ctp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
			Memuat statistik...
		</div>
	</div>

	<!-- ── Filter & Tabel ────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="cp-filter-row">
			<div class="cp-filter-tabs">
				<button v-for="tab in tabs" :key="tab.value"
					class="cp-tab" :class="{ active: filter === tab.value }"
					@click="setFilter(tab.value)">
					{{ tab.label }}
				</button>
			</div>
			<div class="cp-search-wrap">
				<input v-model="search" @input="debouncedLoad" type="text"
					placeholder="Cari nama pasien, nomor, dokter…" class="cp-search-input"/>
			</div>
		</div>

		<div class="cp-table-wrap">
			<table class="cp-table" v-if="!loading">
				<thead>
					<tr>
						<th>No. Registrasi</th>
						<th>Pasien</th>
						<th>Dokter</th>
						<th>Tanggal</th>
						<th>Encounter ID</th>
						<th>CarePlan Status</th>
						<th>Synced At</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="row in rows" :key="row.uuid">
						<td class="cp-nomor">{{ row.nomor }}</td>
						<td>
							<div class="cp-pasien-name">{{ row.nama_pasien }}</div>
							<div class="cp-ihs" v-if="row.patient_ihs_id">IHS: {{ row.patient_ihs_id }}</div>
							<div class="cp-no-ihs" v-else>Pasien belum sync</div>
						</td>
						<td>
							<div>{{ row.nama_dokter }}</div>
							<div class="cp-ihs" v-if="row.practitioner_ihs_id">{{ row.practitioner_ihs_id }}</div>
						</td>
						<td>{{ row.tanggal }}</td>
						<td>
							<div class="cp-encounter-id" v-if="row.satusehat_encounter_id">{{ row.satusehat_encounter_id }}</div>
							<div class="cp-no-ihs" v-else>Belum sync</div>
						</td>
						<td>
							<span class="cp-badge" :class="badgeClass(row.satusehat_careplan_status)">
								{{ statusLabel(row.satusehat_careplan_status) }}
							</span>
							<div class="cp-careplan-id" v-if="row.satusehat_careplan_id">{{ row.satusehat_careplan_id }}</div>
						</td>
						<td class="cp-date">{{ formatDate(row.satusehat_careplan_synced_at) }}</td>
						<td>
							<button class="cp-sync-btn"
								@click="syncOne(row)"
								:disabled="row._syncing || row.satusehat_careplan_status === 'synced'"
								:title="row.satusehat_careplan_status === 'synced' ? 'Sudah ter-sync' : 'Sync CarePlan'">
								<svg v-if="!row._syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cp-sync-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
								<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="cp-sync-icon ctp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
							</button>
						</td>
					</tr>
					<tr v-if="rows.length === 0">
						<td colspan="8" class="cp-empty">Tidak ada data untuk filter ini.</td>
					</tr>
				</tbody>
			</table>
			<div class="cp-table-loading" v-if="loading">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ctp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
				Memuat data...
			</div>
		</div>

		<!-- Pagination -->
		<div class="cp-pagination" v-if="totalPages > 1">
			<button @click="prevPage" :disabled="page === 1" class="cp-page-btn">‹ Sebelumnya</button>
			<span class="cp-page-info">Halaman {{ page }} / {{ totalPages }} ({{ total }} data)</span>
			<button @click="nextPage" :disabled="page === totalPages" class="cp-page-btn">Berikutnya ›</button>
		</div>
	</div>

</div>
</div>
</template>

<script>
export default {
	name: 'SatuSehatCarePlanSync',
	data() {
		return {
			attach: {
				link: {
					dashboard:    window.base_url + 'satusehat-api/careplan-sync/dashboard',
					list:         window.base_url + 'satusehat-api/careplan-sync/list',
					syncOne:      window.base_url + 'satusehat-api/careplan-sync/sync-one',
					runSync:      window.base_url + 'satusehat-api/careplan-sync/run-sync',
					retryFailed:  window.base_url + 'satusehat-api/careplan-sync/retry-failed',
				}
			},
			stats:        null,
			statsLoading: false,
			rows:         [],
			total:        0,
			page:         1,
			perPage:      20,
			loading:      false,
			filter:       'all',
			search:       '',
			syncing:      false,
			syncBatch:    20,
			lastSyncResult: null,
			_debounceTimer: null,
			tabs: [
				{ value: 'all',     label: 'Semua' },
				{ value: 'pending', label: 'Pending' },
				{ value: 'synced',  label: 'Berhasil' },
				{ value: 'waiting', label: 'Menunggu' },
				{ value: 'failed',  label: 'Gagal' },
			],
		}
	},
	computed: {
		totalPages() {
			return Math.max(1, Math.ceil(this.total / this.perPage))
		}
	},
	mounted() {
		this.loadStats()
		this.loadList()
	},
	methods: {
		async loadStats() {
			this.statsLoading = true
			try {
				const fd = new FormData()
				const res = await axios.post(this.attach.link.dashboard, fd)
				this.stats = res.data.data
			} catch(e) { console.error(e) }
			finally { this.statsLoading = false }
		},

		async loadList() {
			this.loading = true
			try {
				const fd = new FormData()
				fd.append('page',   this.page)
				fd.append('status', this.filter)
				fd.append('search', this.search)
				const res = await axios.post(this.attach.link.list, fd)
				this.rows  = (res.data.data || []).map(r => ({ ...r, _syncing: false }))
				this.total = res.data.total || 0
			} catch(e) { console.error(e) }
			finally { this.loading = false }
		},

		debouncedLoad() {
			clearTimeout(this._debounceTimer)
			this._debounceTimer = setTimeout(() => { this.page = 1; this.loadList() }, 400)
		},

		setFilter(val) {
			this.filter = val
			this.page   = 1
			this.loadList()
		},

		prevPage() { if (this.page > 1) { this.page--; this.loadList() } },
		nextPage()  { if (this.page < this.totalPages) { this.page++; this.loadList() } },

		async syncOne(row) {
			if (row._syncing || row.satusehat_careplan_status === 'synced') return
			row._syncing = true
			try {
				const fd = new FormData()
				fd.append('uuid', row.uuid)
				const res = await axios.post(this.attach.link.syncOne, fd)
				if (res.data.data === 'berhasil') {
					row.satusehat_careplan_id     = res.data.careplan_id
					row.satusehat_careplan_status = 'synced'
					this.loadStats()
				} else {
					alert('Gagal: ' + (res.data.message || 'Error tidak diketahui'))
				}
			} catch(e) {
				alert('Error: ' + (e.response?.data?.message || e.message))
			} finally {
				row._syncing = false
			}
		},

		async runSync() {
			if (this.syncing) return
			this.syncing = true
			this.lastSyncResult = null
			try {
				const fd = new FormData()
				fd.append('batch', this.syncBatch)
				const res = await axios.post(this.attach.link.runSync, fd)
				this.lastSyncResult = res.data
				this.loadStats()
				this.loadList()
			} catch(e) {
				this.lastSyncResult = { dispatched: 0, message: e.response?.data?.message || e.message }
			} finally {
				this.syncing = false
			}
		},

		async retryFailed() {
			if (!confirm('Reset semua CarePlan gagal/waiting untuk diproses ulang?')) return
			try {
				const fd = new FormData()
				const res = await axios.post(this.attach.link.retryFailed, fd)
				alert(`${res.data.count} CarePlan direset.`)
				this.loadStats()
				this.loadList()
			} catch(e) { alert('Gagal: ' + e.message) }
		},

		badgeClass(status) {
			const map = {
				'synced':           'badge-green',
				'failed':           'badge-red',
				'waiting_encounter':'badge-orange',
				'waiting_patient':  'badge-orange',
				'no_location':      'badge-gray',
			}
			return map[status] || 'badge-gray'
		},

		statusLabel(status) {
			const map = {
				'synced':           'Synced',
				'failed':           'Gagal',
				'waiting_encounter':'Tunggu Encounter',
				'waiting_patient':  'Tunggu Pasien',
			}
			return map[status] || (status || 'Pending')
		},

		formatDate(dt) {
			if (!dt) return '—'
			return new Date(dt).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' })
		},
	}
}
</script>

<style scoped>
.cp-trigger-panel { display:flex; align-items:center; justify-content:space-between; gap:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:18px 20px; margin-bottom:12px; }
.ctp-left { display:flex; align-items:flex-start; gap:14px; flex:1; }
.ctp-icon { width:40px; height:40px; background:#e0f2fe; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.ctp-icon svg { width:20px; height:20px; stroke:#0284c7; }
.ctp-title { font-weight:600; font-size:14px; color:#1e293b; margin-bottom:4px; }
.ctp-desc { font-size:13px; color:#64748b; line-height:1.5; }
.ctp-right { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.ctp-batch-wrap { display:flex; flex-direction:column; gap:3px; }
.ctp-batch-label { font-size:11px; color:#94a3b8; }
.ctp-batch-select { padding:6px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; background:#fff; }
.ctp-run-btn { display:flex; align-items:center; gap:6px; padding:8px 16px; background:#0284c7; color:#fff; border:none; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer; transition:background .15s; }
.ctp-run-btn:hover:not(:disabled) { background:#0369a1; }
.ctp-run-btn:disabled { opacity:.55; cursor:not-allowed; }
.ctp-btn-icon { width:15px; height:15px; }
.ctp-spin { animation:spin .8s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }

.cp-sync-result { display:flex; align-items:center; gap:12px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:10px 14px; margin-bottom:8px; font-size:13px; }
.csr-item { display:flex; align-items:center; gap:5px; font-weight:600; }
.csr-item svg { width:14px; height:14px; }
.csr-green { color:#16a34a; }
.csr-msg { flex:1; color:#374151; }
.csr-close { margin-left:auto; background:none; border:none; cursor:pointer; color:#94a3b8; font-size:15px; }

.cp-stats-row { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:16px; }
.cp-stat-card { flex:1; min-width:160px; background:#fff; border-radius:10px; padding:14px 16px; box-shadow:0 1px 3px rgba(0,0,0,.06); border:1px solid #e2e8f0; }
.csc-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
.csc-label { font-size:12px; color:#64748b; font-weight:500; }
.csc-icon { width:30px; height:30px; border-radius:6px; display:flex; align-items:center; justify-content:center; }
.csc-icon svg { width:15px; height:15px; }
.csc-icon-blue { background:#dbeafe; } .csc-icon-blue svg { stroke:#2563eb; }
.csc-icon-green { background:#dcfce7; } .csc-icon-green svg { stroke:#16a34a; }
.csc-icon-yellow { background:#fef9c3; } .csc-icon-yellow svg { stroke:#ca8a04; }
.csc-icon-orange { background:#ffedd5; } .csc-icon-orange svg { stroke:#ea580c; }
.csc-icon-red { background:#fee2e2; } .csc-icon-red svg { stroke:#dc2626; }
.cp-card-blue { border-left:3px solid #2563eb; }
.cp-card-green { border-left:3px solid #16a34a; }
.cp-card-yellow { border-left:3px solid #ca8a04; }
.cp-card-orange { border-left:3px solid #ea580c; }
.cp-card-red { border-left:3px solid #dc2626; }
.csc-num { font-size:24px; font-weight:700; color:#1e293b; }
.csc-bar-wrap { height:4px; background:#e2e8f0; border-radius:2px; margin:6px 0; }
.csc-bar { height:4px; border-radius:2px; transition:width .3s; }
.csc-bar-green { background:#16a34a; }
.csc-sub { font-size:11px; color:#94a3b8; }
.csc-retry-btn { font-size:11px; color:#dc2626; background:none; border:1px solid #fca5a5; border-radius:4px; padding:2px 7px; cursor:pointer; }
.csc-retry-btn:hover { background:#fee2e2; }

.cp-filter-row { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px; flex-wrap:wrap; }
.cp-filter-tabs { display:flex; gap:4px; }
.cp-tab { padding:6px 14px; border:1px solid #e2e8f0; border-radius:20px; background:#fff; font-size:12px; font-weight:500; color:#64748b; cursor:pointer; transition:all .15s; }
.cp-tab.active { background:#0284c7; color:#fff; border-color:#0284c7; }
.cp-tab:hover:not(.active) { background:#f1f5f9; }
.cp-search-input { padding:7px 12px; border:1px solid #e2e8f0; border-radius:7px; font-size:13px; width:250px; }

.cp-table-wrap { overflow-x:auto; }
.cp-table { width:100%; border-collapse:collapse; font-size:13px; }
.cp-table th { background:#f8fafc; padding:10px 12px; text-align:left; font-weight:600; color:#475569; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
.cp-table td { padding:10px 12px; border-bottom:1px solid #f1f5f9; vertical-align:top; }
.cp-table tr:hover td { background:#f8fafc; }
.cp-nomor { font-weight:600; color:#1e293b; white-space:nowrap; }
.cp-pasien-name { font-weight:500; color:#1e293b; }
.cp-ihs { font-size:11px; color:#94a3b8; margin-top:2px; font-family:monospace; }
.cp-no-ihs { font-size:11px; color:#f59e0b; margin-top:2px; }
.cp-encounter-id { font-size:11px; color:#94a3b8; font-family:monospace; }
.cp-careplan-id { font-size:11px; color:#94a3b8; font-family:monospace; margin-top:2px; }
.cp-date { white-space:nowrap; font-size:12px; color:#64748b; }
.cp-badge { display:inline-block; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:600; }
.badge-green { background:#dcfce7; color:#16a34a; }
.badge-red { background:#fee2e2; color:#dc2626; }
.badge-orange { background:#ffedd5; color:#ea580c; }
.badge-gray { background:#f1f5f9; color:#64748b; }
.cp-sync-btn { background:none; border:1px solid #e2e8f0; border-radius:6px; padding:5px 8px; cursor:pointer; color:#64748b; transition:all .15s; }
.cp-sync-btn:hover:not(:disabled) { background:#f0f9ff; border-color:#0284c7; color:#0284c7; }
.cp-sync-btn:disabled { opacity:.4; cursor:not-allowed; }
.cp-sync-icon { width:14px; height:14px; display:block; }
.cp-empty { text-align:center; color:#94a3b8; padding:40px 0; }
.cp-table-loading, .cp-stats-loading { display:flex; align-items:center; gap:8px; padding:30px; color:#94a3b8; justify-content:center; font-size:13px; }
.cp-table-loading svg, .cp-stats-loading svg { width:16px; height:16px; }
.cp-pagination { display:flex; align-items:center; justify-content:center; gap:12px; padding:14px 0; }
.cp-page-btn { padding:6px 14px; border:1px solid #e2e8f0; border-radius:6px; background:#fff; font-size:13px; cursor:pointer; }
.cp-page-btn:hover:not(:disabled) { background:#f1f5f9; }
.cp-page-btn:disabled { opacity:.4; cursor:not-allowed; }
.cp-page-info { font-size:13px; color:#64748b; }
</style>
