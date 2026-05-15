<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Header Stats ─────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-header-bar">
			<div class="al-header-left">
				<div class="al-header-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>
				</div>
				<div>
					<div class="al-header-title">SatuSehat API Logs</div>
					<div class="al-header-sub">Riwayat semua request &amp; response ke SatuSehat API</div>
				</div>
			</div>
			<div class="al-header-right">
				<button class="al-clear-btn al-clear-old" @click="clearOld" :disabled="clearing">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
					{{ clearing === 'old' ? 'Menghapus…' : 'Hapus Log >30 Hari' }}
				</button>
				<button class="al-clear-btn al-clear-all" @click="clearAll" :disabled="clearing">
					{{ clearing === 'all' ? 'Menghapus…' : 'Hapus Semua' }}
				</button>
			</div>
		</div>
	</div>

	<!-- ── Stats Cards ─────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-stats-row" v-if="!statsLoading">
			<div class="al-stat-card al-stat-gray">
				<div class="al-stat-val">{{ stats.total }}</div>
				<div class="al-stat-lbl">Total Log</div>
			</div>
			<div class="al-stat-card al-stat-green">
				<div class="al-stat-val">{{ stats.success }}</div>
				<div class="al-stat-lbl">Sukses (2xx)</div>
			</div>
			<div class="al-stat-card al-stat-red">
				<div class="al-stat-val">{{ stats.failed }}</div>
				<div class="al-stat-lbl">Gagal</div>
			</div>
			<div class="al-stat-card al-stat-blue">
				<div class="al-stat-val">{{ stats.avg_duration }}<small>ms</small></div>
				<div class="al-stat-lbl">Avg Response Time</div>
			</div>
		</div>
		<div class="al-stats-row" v-else>
			<div class="al-stat-card al-stat-loading" v-for="i in 4" :key="i"></div>
		</div>
	</div>

	<!-- ── Filter Bar ───────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-filter-bar">
			<div class="al-filter-group">
				<label class="al-filter-label">Method</label>
				<select v-model="filterMethod" @change="resetAndLoad" class="al-filter-select">
					<option value="all">Semua Method</option>
					<option value="GET">GET</option>
					<option value="POST">POST</option>
					<option value="PUT">PUT</option>
					<option value="PATCH">PATCH</option>
				</select>
			</div>
			<div class="al-filter-group">
				<label class="al-filter-label">Konteks</label>
				<select v-model="filterContext" @change="resetAndLoad" class="al-filter-select">
					<option value="all">Semua Konteks</option>
					<option value="patient_sync">Patient Sync</option>
					<option value="encounter_sync">Encounter Sync</option>
					<option value="wilayah">Wilayah</option>
					<option value="other">Lainnya</option>
				</select>
			</div>
			<div class="al-filter-group">
				<label class="al-filter-label">Status</label>
				<select v-model="filterStatus" @change="resetAndLoad" class="al-filter-select">
					<option value="all">Semua Status</option>
					<option value="success">Sukses</option>
					<option value="failed">Gagal</option>
				</select>
			</div>
			<div class="al-filter-group al-filter-search">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="al-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				<input v-model="search" @input="onSearch" class="al-search-input" placeholder="Cari URL / body…" />
			</div>
		</div>
	</div>

	<!-- ── Table ────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-table-wrap">
			<div class="al-loading-overlay" v-if="loading">
				<div class="al-spinner"></div>
			</div>

			<table class="al-table">
				<thead>
					<tr>
						<th style="width:70px">Method</th>
						<th>URL</th>
						<th style="width:80px">HTTP</th>
						<th style="width:100px">Konteks</th>
						<th style="width:80px">Durasi</th>
						<th style="width:150px">Waktu</th>
						<th style="width:60px"></th>
					</tr>
				</thead>
				<tbody>
					<template v-if="!loading && list.length === 0">
						<tr>
							<td colspan="7" class="al-empty">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:28px;height:28px;margin-bottom:6px"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
								<div>Belum ada log API.</div>
							</td>
						</tr>
					</template>
					<template v-for="row in list" :key="row.id">
						<tr class="al-tr-main" :class="{ 'al-tr-failed': !row.is_success, 'al-tr-expanded': expandedId === row.id }">
							<td>
								<span class="al-method-badge" :class="'al-method-' + row.method.toLowerCase()">{{ row.method }}</span>
							</td>
							<td class="al-td-url">
								<span class="al-url-text" :title="row.url">{{ truncateUrl(row.url) }}</span>
							</td>
							<td>
								<span class="al-http-badge" :class="httpClass(row.http_code)">{{ row.http_code || '—' }}</span>
							</td>
							<td>
								<span class="al-ctx-badge" v-if="row.context">{{ row.context }}</span>
								<span class="al-text-muted" v-else>—</span>
							</td>
							<td class="al-text-muted">{{ row.duration_ms ? row.duration_ms + 'ms' : '—' }}</td>
							<td class="al-text-muted al-td-time">{{ formatDate(row.created_at) }}</td>
							<td>
								<button class="al-expand-btn" @click="toggleExpand(row.id)" :title="expandedId === row.id ? 'Tutup' : 'Lihat Detail'">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px;transition:transform .2s" :style="expandedId === row.id ? 'transform:rotate(180deg)' : ''"><polyline points="6 9 12 15 18 9"/></svg>
								</button>
							</td>
						</tr>
						<!-- Expanded detail row -->
						<tr v-if="expandedId === row.id" class="al-tr-detail">
							<td colspan="7">
								<div class="al-detail-grid">
									<div class="al-detail-col">
										<div class="al-detail-label">Request Body</div>
										<pre class="al-detail-pre">{{ prettyJson(row.request_body) || '(kosong)' }}</pre>
									</div>
									<div class="al-detail-col">
										<div class="al-detail-label">Response Body</div>
										<pre class="al-detail-pre">{{ prettyJson(row.response_body) || '(kosong)' }}</pre>
									</div>
								</div>
								<div class="al-detail-url">
									<strong>URL:</strong> {{ row.url }}
								</div>
							</td>
						</tr>
					</template>
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		<div class="al-pager" v-if="totalPages > 1">
			<button class="al-page-btn" :disabled="page <= 1" @click="gotoPage(page - 1)">‹</button>
			<span class="al-page-info">{{ page }} / {{ totalPages }} ({{ total }} log)</span>
			<button class="al-page-btn" :disabled="page >= totalPages" @click="gotoPage(page + 1)">›</button>
		</div>
	</div>

</div>

<div class="notification-panel" ref="notif" style="display:none">
	<span ref="notifMsg"></span>
</div>
</div>
</template>

<script>
export default {
	name: 'SatuSehatApiLogs',
	data() {
		return {
			stats: { total: 0, success: 0, failed: 0, avg_duration: 0 },
			statsLoading: true,

			list:    [],
			total:   0,
			page:    1,
			perPage: 25,
			loading: false,

			filterMethod:  'all',
			filterContext: 'all',
			filterStatus:  'all',
			search:        '',
			searchTimeout: null,

			expandedId: null,
			clearing:   null,
		};
	},
	computed: {
		totalPages() { return Math.ceil(this.total / this.perPage) || 1; },
	},
	mounted() {
		var vm = this;
		vm.loadStats();
		vm.loadList();
	},
	methods: {
		api(path, payload) {
			var fd = new FormData();
			for (var k in payload) { fd.append(k, payload[k] ?? ''); }
			return axios.post('/satusehat-api/api-logs/' + path, fd, {
				headers: { 'Content-Type': 'multipart/form-data' },
				timeout: 30000,
			});
		},

		loadStats() {
			var vm = this;
			vm.statsLoading = true;
			vm.api('dashboard', {}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.stats = r.data.data ?? vm.stats;
			}).finally(() => { vm.statsLoading = false; });
		},

		loadList() {
			var vm = this;
			vm.loading = true;
			vm.api('list', {
				page:    vm.page,
				method:  vm.filterMethod,
				context: vm.filterContext,
				status:  vm.filterStatus,
				search:  vm.search,
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.list  = r.data.data  ?? [];
				vm.total = r.data.total ?? 0;
			}).catch(() => {
				vm.notification('Gagal memuat log.', 3000, 'error');
			}).finally(() => { vm.loading = false; });
		},

		resetAndLoad() {
			this.page = 1;
			this.expandedId = null;
			this.loadList();
		},

		onSearch() {
			var vm = this;
			clearTimeout(vm.searchTimeout);
			vm.searchTimeout = setTimeout(() => { vm.resetAndLoad(); }, 400);
		},

		gotoPage(p) {
			this.page = p;
			this.expandedId = null;
			this.loadList();
		},

		toggleExpand(id) {
			this.expandedId = this.expandedId === id ? null : id;
		},

		clearOld() {
			var vm = this;
			if (vm.clearing) return;
			if (!confirm('Hapus log yang lebih dari 30 hari?')) return;
			vm.clearing = 'old';
			vm.api('clear', { days: 30 }).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.notification(r.data.message, 4000, 'success');
				vm.loadStats();
				vm.page = 1;
				vm.loadList();
			}).catch(() => { vm.notification('Gagal menghapus.', 3000, 'error'); })
			.finally(() => { vm.clearing = null; });
		},

		clearAll() {
			var vm = this;
			if (vm.clearing) return;
			if (!confirm('Hapus SEMUA log API? Tindakan ini tidak dapat dibatalkan.')) return;
			vm.clearing = 'all';
			vm.api('clear-all', {}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.notification(r.data.message, 4000, 'success');
				vm.list  = [];
				vm.total = 0;
				vm.loadStats();
			}).catch(() => { vm.notification('Gagal menghapus.', 3000, 'error'); })
			.finally(() => { vm.clearing = null; });
		},

		truncateUrl(url) {
			if (!url) return '—';
			// Hilangkan base URL, tampilkan path + query saja
			try {
				var u = new URL(url);
				var path = u.pathname + u.search;
				return path.length > 70 ? '…' + path.slice(-67) : path;
			} catch { return url.length > 70 ? url.slice(0, 67) + '…' : url; }
		},

		httpClass(code) {
			if (!code) return 'al-http-unknown';
			if (code >= 200 && code < 300) return 'al-http-ok';
			if (code >= 300 && code < 400) return 'al-http-redirect';
			if (code >= 400 && code < 500) return 'al-http-client';
			return 'al-http-server';
		},

		prettyJson(str) {
			if (!str) return '';
			try { return JSON.stringify(JSON.parse(str), null, 2); }
			catch { return str; }
		},

		formatDate(d) {
			if (!d) return '—';
			try {
				return new Date(d).toLocaleString('id-ID', {
					day: '2-digit', month: 'short', year: 'numeric',
					hour: '2-digit', minute: '2-digit', second: '2-digit',
				});
			} catch { return d; }
		},

		notification(msg, ms, type) {
			var vm = this;
			var el = vm.$refs.notif;
			if (!el) return;
			vm.$refs.notifMsg.textContent = msg;
			el.className = 'notification-panel notif-show' + (type === 'error' ? ' notif-error' : ' notif-success');
			el.style.display = '';
			clearTimeout(vm._notifTimer);
			vm._notifTimer = setTimeout(() => {
				el.className = 'notification-panel';
				setTimeout(() => { el.style.display = 'none'; }, 400);
			}, ms || 3000);
		},
	},
};
</script>

<style scoped>
/* ── Header ── */
.al-header-bar {
	display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
	background: var(--bg-card,#fff); border: 1px solid var(--border,#e5e7eb);
	border-radius: 12px; padding: 18px 22px;
}
.al-header-left { display: flex; align-items: center; gap: 14px; }
.al-header-icon {
	width: 40px; height: 40px; border-radius: 10px;
	background: #f0fdf4; display: flex; align-items: center; justify-content: center;
}
.al-header-icon svg { width: 20px; height: 20px; stroke: #16a34a; }
.al-header-title { font-size: 16px; font-weight: 600; color: var(--text-primary,#111); }
.al-header-sub   { font-size: 13px; color: var(--text-muted,#6b7280); }
.al-header-right { display: flex; gap: 8px; flex-wrap: wrap; }
.al-clear-btn {
	padding: 7px 14px; border-radius: 7px; border: 1px solid var(--border,#e5e7eb);
	font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px;
	background: var(--bg-card,#fff); color: var(--text-primary,#111); transition: all .15s;
}
.al-clear-btn:hover:not(:disabled) { background: var(--bg-hover,#f3f4f6); }
.al-clear-btn:disabled { opacity: .5; cursor: not-allowed; }
.al-clear-all { background: #fef2f2 !important; color: #dc2626 !important; border-color: #fecaca !important; }
.al-clear-all:hover:not(:disabled) { background: #fee2e2 !important; }

/* ── Stats ── */
.al-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
@media(max-width:640px){ .al-stats-row { grid-template-columns: repeat(2,1fr); } }
.al-stat-card {
	border-radius: 12px; padding: 16px 18px;
	display: flex; flex-direction: column; gap: 4px;
	border: 1px solid transparent;
}
.al-stat-val { font-size: 24px; font-weight: 700; }
.al-stat-val small { font-size: 13px; font-weight: 400; margin-left: 2px; }
.al-stat-lbl { font-size: 12px; opacity: .8; }
.al-stat-gray  { background: #f9fafb; border-color: #e5e7eb; color: #374151; }
.al-stat-green { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
.al-stat-red   { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
.al-stat-blue  { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.al-stat-loading { background: var(--bg-shimmer,#f3f4f6); height: 76px; }

/* ── Filter bar ── */
.al-filter-bar {
	display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;
	background: var(--bg-card,#fff); border: 1px solid var(--border,#e5e7eb);
	border-radius: 10px; padding: 12px 16px;
}
.al-filter-group { display: flex; flex-direction: column; gap: 4px; }
.al-filter-label { font-size: 11px; color: var(--text-muted,#6b7280); font-weight: 500; }
.al-filter-select {
	border: 1px solid var(--border,#e5e7eb); border-radius: 6px;
	padding: 6px 10px; font-size: 13px; background: var(--bg-input,#fff); color: var(--text-primary,#111);
}
.al-filter-search { flex: 1; min-width: 200px; position: relative; }
.al-search-icon { position: absolute; left: 8px; bottom: 8px; width: 14px; height: 14px; stroke: var(--text-muted,#9ca3af); }
.al-search-input { width: 100%; padding: 6px 10px 6px 28px; border: 1px solid var(--border,#e5e7eb); border-radius: 6px; font-size: 13px; background: var(--bg-input,#fff); color: var(--text-primary,#111); }

/* ── Table ── */
.al-table-wrap { position: relative; overflow-x: auto; border: 1px solid var(--border,#e5e7eb); border-radius: 10px; }
.al-loading-overlay { position: absolute; inset: 0; background: rgba(255,255,255,.7); display: flex; align-items: center; justify-content: center; z-index: 10; border-radius: 10px; }
.al-spinner { width: 26px; height: 26px; border: 3px solid #e5e7eb; border-top-color: #16a34a; border-radius: 50%; animation: spin 0.8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.al-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.al-table th { background: var(--bg-thead,#f9fafb); padding: 10px 12px; text-align: left; font-size: 11px; font-weight: 600; color: var(--text-muted,#6b7280); border-bottom: 1px solid var(--border,#e5e7eb); white-space: nowrap; text-transform: uppercase; letter-spacing: .04em; }
.al-table td { padding: 9px 12px; border-bottom: 1px solid var(--border-light,#f3f4f6); vertical-align: middle; }
.al-tr-main:hover td { background: var(--bg-hover,#f9fafb); }
.al-tr-failed td { background: #fff5f5; }
.al-tr-expanded td { background: var(--bg-hover,#f9fafb); }
.al-tr-detail td { background: var(--bg-code,#f8fafc); border-bottom: 2px solid var(--border,#e5e7eb); padding: 0; }
.al-table tbody tr:last-child td { border-bottom: none; }
.al-empty { text-align: center; padding: 40px 16px; color: var(--text-muted,#9ca3af); }
.al-text-muted { color: var(--text-muted,#9ca3af); font-size: 12px; }
.al-td-url { max-width: 300px; overflow: hidden; }
.al-url-text { font-family: monospace; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
.al-td-time { white-space: nowrap; }

/* ── Badges ── */
.al-method-badge { display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 11px; font-weight: 700; font-family: monospace; }
.al-method-get    { background: #dbeafe; color: #1d4ed8; }
.al-method-post   { background: #d1fae5; color: #065f46; }
.al-method-put    { background: #fef3c7; color: #92400e; }
.al-method-patch  { background: #ede9fe; color: #5b21b6; }
.al-method-delete { background: #fee2e2; color: #991b1b; }

.al-http-badge { display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 12px; font-weight: 600; font-family: monospace; }
.al-http-ok       { background: #d1fae5; color: #065f46; }
.al-http-redirect { background: #fef3c7; color: #92400e; }
.al-http-client   { background: #fee2e2; color: #991b1b; }
.al-http-server   { background: #fde8d8; color: #92400e; }
.al-http-unknown  { background: #f3f4f6; color: #6b7280; }

.al-ctx-badge { display: inline-block; padding: 2px 7px; border-radius: 4px; font-size: 11px; background: #f3f4f6; color: #374151; font-weight: 500; }

/* ── Expand button ── */
.al-expand-btn { background: none; border: 1px solid var(--border,#e5e7eb); border-radius: 5px; padding: 4px 6px; cursor: pointer; color: var(--text-muted,#6b7280); display: flex; align-items: center; }
.al-expand-btn:hover { background: var(--bg-hover,#f3f4f6); }

/* ── Detail panel ── */
.al-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding: 14px 16px 8px; }
@media(max-width:700px){ .al-detail-grid { grid-template-columns: 1fr; } }
.al-detail-label { font-size: 11px; font-weight: 600; color: var(--text-muted,#6b7280); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px; }
.al-detail-pre {
	background: var(--bg-card,#fff); border: 1px solid var(--border,#e5e7eb);
	border-radius: 6px; padding: 10px 12px;
	font-size: 11px; font-family: monospace; white-space: pre-wrap; word-break: break-all;
	max-height: 200px; overflow-y: auto; color: var(--text-primary,#111); margin: 0;
}
.al-detail-url { padding: 6px 16px 12px; font-size: 12px; color: var(--text-muted,#6b7280); font-family: monospace; word-break: break-all; }

/* ── Pager ── */
.al-pager { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px; }
.al-page-btn { background: none; border: 1px solid var(--border,#e5e7eb); border-radius: 6px; padding: 5px 12px; cursor: pointer; font-size: 16px; }
.al-page-btn:disabled { opacity: .4; cursor: not-allowed; }
.al-page-info { font-size: 13px; color: var(--text-muted,#6b7280); }

/* ── Notification ── */
.notification-panel {
	position: fixed; bottom: 24px; right: 24px; z-index: 9999;
	background: #1f2937; color: #fff;
	padding: 12px 20px; border-radius: 10px;
	font-size: 13px; max-width: 360px;
	transform: translateY(20px); opacity: 0; transition: all .3s;
}
.notif-show    { transform: translateY(0); opacity: 1; }
.notif-success { background: #065f46; }
.notif-error   { background: #991b1b; }
</style>
