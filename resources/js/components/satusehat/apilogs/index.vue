<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Header ──────────────────────────────────────────────────────── -->
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
				<button class="al-btn al-btn-outline" @click="refresh" :disabled="statsLoading">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" :class="{'al-spin':statsLoading}"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					Refresh
				</button>
				<button class="al-btn al-btn-danger-ghost" @click="showClearDlg = true" :disabled="!!clearing">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
					Hapus Log Lama
				</button>
			</div>
		</div>
	</div>

	<!-- ── Stats ────────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-stats-row">
			<template v-if="!statsLoading && stats">
				<div class="al-stat al-stat-gray">
					<div class="al-stat-num">{{ stats.total.toLocaleString('id-ID') }}</div>
					<div class="al-stat-lbl">Total Requests</div>
				</div>
				<div class="al-stat al-stat-green">
					<div class="al-stat-num">{{ stats.success.toLocaleString('id-ID') }}</div>
					<div class="al-stat-lbl">Berhasil (2xx)</div>
					<div class="al-stat-pct" v-if="stats.total">{{ pct(stats.success,stats.total) }}%</div>
				</div>
				<div class="al-stat al-stat-red">
					<div class="al-stat-num">{{ stats.failed.toLocaleString('id-ID') }}</div>
					<div class="al-stat-lbl">Gagal</div>
					<div class="al-stat-pct" v-if="stats.total">{{ pct(stats.failed,stats.total) }}%</div>
				</div>
				<div class="al-stat al-stat-blue">
					<div class="al-stat-num">{{ stats.avg_duration.toLocaleString('id-ID') }}<span class="al-stat-unit">ms</span></div>
					<div class="al-stat-lbl">Rata-rata Durasi</div>
				</div>
			</template>
			<template v-else>
				<div class="al-stat al-stat-skel" v-for="n in 4" :key="n"></div>
			</template>
		</div>
	</div>

	<!-- ── Filter Bar ──────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-filter-bar">
			<div class="al-fg">
				<label>Method</label>
				<select v-model="filter.method" @change="resetAndLoad">
					<option value="all">Semua</option>
					<option value="GET">GET</option>
					<option value="POST">POST</option>
					<option value="PUT">PUT</option>
					<option value="PATCH">PATCH</option>
				</select>
			</div>
			<div class="al-fg">
				<label>Status</label>
				<select v-model="filter.status" @change="resetAndLoad">
					<option value="all">Semua</option>
					<option value="success">Berhasil</option>
					<option value="failed">Gagal</option>
				</select>
			</div>
			<div class="al-fg al-fg-ctx">
				<label>Konteks</label>
				<select v-model="filter.context" @change="resetAndLoad">
					<option value="all">Semua</option>
					<option v-for="c in ctxOptions" :key="c" :value="c">{{ c }}</option>
				</select>
			</div>
			<div class="al-fg al-fg-search">
				<label>Cari URL / body</label>
				<input type="text" v-model="filter.search" @input="debounceLoad" placeholder="Ketik kata kunci…" />
			</div>
		</div>
	</div>

	<!-- ── Table ───────────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="al-table-wrap">
			<!-- loading overlay -->
			<div class="al-overlay" v-if="listLoading">
				<div class="al-spinner"></div>
			</div>

			<table class="al-table">
				<thead>
					<tr>
						<th style="width:46px">#</th>
						<th style="width:72px">Method</th>
						<th style="width:68px">HTTP</th>
						<th>URL</th>
						<th style="width:130px">Konteks</th>
						<th style="width:88px">Durasi</th>
						<th style="width:148px">Waktu</th>
						<th style="width:44px"></th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="!listLoading && rows.length === 0">
						<td colspan="8" class="al-empty">Tidak ada data log.</td>
					</tr>
					<tr
						v-for="row in rows" :key="row.id"
						class="al-tr"
						:class="{ 'al-tr-sel': detailId === row.id, 'al-tr-fail': !row.is_success }"
					>
						<td class="al-td-id">{{ row.id }}</td>
						<td>
							<span class="al-mbadge" :class="'al-m-' + row.method.toLowerCase()">{{ row.method }}</span>
						</td>
						<td>
							<span class="al-hbadge" :class="hClass(row.http_code)">{{ row.http_code ?? '—' }}</span>
						</td>
						<td class="al-td-url" :title="row.url">{{ shortUrl(row.url) }}</td>
						<td class="al-td-ctx">{{ row.context ?? '—' }}</td>
						<td class="al-td-muted">{{ row.duration_ms != null ? row.duration_ms + ' ms' : '—' }}</td>
						<td class="al-td-muted al-nowrap">{{ fmtTime(row.created_at) }}</td>
						<td>
							<button class="al-view-btn" :class="{ 'al-view-active': detailId === row.id }" @click="toggleDetail(row.id)" :disabled="detailLoading === row.id" title="Lihat detail">
								<svg v-if="detailLoading !== row.id" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
								<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="al-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
							</button>
						</td>
					</tr>
				</tbody>
			</table>

			<!-- Pagination -->
			<div class="al-pager" v-if="totalRows > 0">
				<span class="al-pager-info">{{ pgInfo }}</span>
				<div class="al-pager-btns">
					<button @click="loadList(page - 1)" :disabled="page <= 1">‹</button>
					<span>{{ page }} / {{ totalPages }}</span>
					<button @click="loadList(page + 1)" :disabled="page >= totalPages">›</button>
				</div>
			</div>
		</div>
	</div>

</div><!-- /grid -->


<!-- ═══════════════════════════════════════════════════════════════════════
     Backdrop + Detail side panel
════════════════════════════════════════════════════════════════════════ -->
<transition name="al-fade">
<div class="al-backdrop" v-if="detail" @click.self="closeDetail"></div>
</transition>

<transition name="al-slide">
<div class="al-side-panel" v-if="detail">

	<!-- sticky header -->
	<div class="al-sp-head">
		<div class="al-sp-badges">
			<span class="al-mbadge" :class="'al-m-' + detail.method.toLowerCase()">{{ detail.method }}</span>
			<span class="al-hbadge" :class="hClass(detail.http_code)">{{ detail.http_code ?? '—' }}</span>
			<span class="al-sp-ctx">{{ detail.context ?? 'no context' }}</span>
		</div>
		<button class="al-sp-close" @click="closeDetail" title="Tutup">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
	</div>

	<!-- meta -->
	<div class="al-sp-meta">
		<div class="al-sp-meta-row">
			<span class="al-sp-meta-k">URL</span>
			<span class="al-sp-meta-v al-mono al-sp-url">{{ detail.url }}</span>
		</div>
		<div class="al-sp-meta-row">
			<span class="al-sp-meta-k">Waktu</span>
			<span class="al-sp-meta-v">{{ fmtTimeFull(detail.created_at) }}</span>
		</div>
		<div class="al-sp-meta-row">
			<span class="al-sp-meta-k">Durasi</span>
			<span class="al-sp-meta-v">{{ detail.duration_ms != null ? detail.duration_ms + ' ms' : '—' }}</span>
		</div>
		<div class="al-sp-meta-row">
			<span class="al-sp-meta-k">Status</span>
			<span class="al-sp-meta-v">
				<span class="al-dot" :class="detail.is_success ? 'al-dot-ok' : 'al-dot-fail'"></span>
				{{ detail.is_success ? 'Berhasil' : 'Gagal' }}
			</span>
		</div>
	</div>

	<!-- Request Body -->
	<div class="al-sp-section">
		<div class="al-sp-sec-head">
			<span class="al-sp-sec-title">Request Body</span>
			<button class="al-copy-btn" @click="copy(detail.request_body, 'req')" :class="{ 'al-copied': copied === 'req' }">
				<svg v-if="copied !== 'req'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
				<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				{{ copied === 'req' ? 'Tersalin!' : 'Copy' }}
			</button>
		</div>
		<div class="al-json-wrap">
			<pre class="al-json" v-if="detail.request_body">{{ fmtJson(detail.request_body) }}</pre>
			<div class="al-json-empty" v-else>— kosong —</div>
		</div>
	</div>

	<!-- Response Body -->
	<div class="al-sp-section">
		<div class="al-sp-sec-head">
			<span class="al-sp-sec-title">Response Body</span>
			<button class="al-copy-btn" @click="copy(detail.response_body, 'res')" :class="{ 'al-copied': copied === 'res' }">
				<svg v-if="copied !== 'res'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
				<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				{{ copied === 'res' ? 'Tersalin!' : 'Copy' }}
			</button>
		</div>
		<div class="al-json-wrap">
			<pre class="al-json" v-if="detail.response_body">{{ fmtJson(detail.response_body) }}</pre>
			<div class="al-json-empty" v-else>— kosong —</div>
		</div>
	</div>

</div>
</transition>


<!-- ═══════════════════════════════════════════════════════════════════════
     Dialog: hapus log lama
════════════════════════════════════════════════════════════════════════ -->
<div class="al-modal-bg" v-if="showClearDlg" @click.self="showClearDlg = false">
	<div class="al-modal">
		<div class="al-modal-title">Hapus Log Lama</div>
		<div class="al-modal-body">
			<p>Pilih batas usia log yang akan dihapus:</p>
			<div class="al-modal-days-row">
				<label>Hapus log lebih dari</label>
				<select v-model="clearDays">
					<option :value="7">7 hari</option>
					<option :value="14">14 hari</option>
					<option :value="30">30 hari</option>
					<option :value="60">60 hari</option>
					<option :value="90">90 hari</option>
				</select>
				<label>hari yang lalu</label>
			</div>
		</div>
		<div class="al-modal-footer">
			<button class="al-btn al-btn-outline" @click="showClearDlg = false">Batal</button>
			<button class="al-btn al-btn-danger" @click="doClear" :disabled="!!clearing">
				{{ clearing === 'old' ? 'Menghapus…' : 'Hapus' }}
			</button>
		</div>
	</div>
</div>


</div><!-- /inner -->
</template>

<script>
const PER = 25;

export default {
	name: 'SatuSehatApiLogs',
	data() {
		return {
			stats:       null,
			statsLoading: false,

			rows:       [],
			totalRows:  0,
			page:       1,
			listLoading: false,

			filter: { method: 'all', status: 'all', context: 'all', search: '' },
			ctxOptions: [],
			debTimer:   null,

			detail:       null,
			detailId:     null,
			detailLoading: null,
			copied:       null,

			showClearDlg: false,
			clearDays:    30,
			clearing:     null,
		};
	},
	computed: {
		totalPages() { return Math.max(1, Math.ceil(this.totalRows / PER)); },
		pgInfo() {
			const from = (this.page - 1) * PER + 1;
			const to   = Math.min(this.page * PER, this.totalRows);
			return `${from}–${to} dari ${this.totalRows.toLocaleString('id-ID')}`;
		},
	},
	mounted() {
		this.loadStats();
		this.loadList(1);
	},
	methods: {
		// ── API helper ───────────────────────────────────────────────────────
		api(path, payload) {
			var fd = new FormData();
			for (var k in payload) fd.append(k, payload[k] ?? '');
			return axios.post('/satusehat-api/api-logs/' + path, fd, {
				headers: { 'Content-Type': 'multipart/form-data' },
				timeout: 30000,
			});
		},

		// ── Stats ────────────────────────────────────────────────────────────
		loadStats() {
			var vm = this;
			vm.statsLoading = true;
			vm.api('dashboard', {}).then(r => {
				if (r.data.data === '419') { location.href = '/masuk'; return; }
				if (r.data.data && typeof r.data.data === 'object') {
					vm.stats = r.data.data;
					vm.ctxOptions = (r.data.data.by_context || []).map(c => c.context).filter(Boolean);
				}
			}).finally(() => { vm.statsLoading = false; });
		},

		// ── List ─────────────────────────────────────────────────────────────
		loadList(p) {
			var vm = this;
			vm.page = p || 1;
			vm.listLoading = true;
			vm.api('list', {
				page:    vm.page,
				method:  vm.filter.method,
				status:  vm.filter.status,
				context: vm.filter.context,
				search:  vm.filter.search,
			}).then(r => {
				if (r.data.data === '419') { location.href = '/masuk'; return; }
				vm.rows      = r.data.data  ?? [];
				vm.totalRows = r.data.total ?? 0;
			}).finally(() => { vm.listLoading = false; });
		},

		resetAndLoad() { this.page = 1; this.loadList(1); },
		debounceLoad()  {
			clearTimeout(this.debTimer);
			this.debTimer = setTimeout(() => this.resetAndLoad(), 400);
		},
		refresh() { this.loadStats(); this.loadList(this.page); },

		// ── Detail ───────────────────────────────────────────────────────────
		toggleDetail(id) {
			if (this.detailId === id) { this.closeDetail(); return; }
			var vm = this;
			vm.detailLoading = id;
			vm.api('detail', { id }).then(r => {
				if (r.data.data === '419') { location.href = '/masuk'; return; }
				if (r.data.data && typeof r.data.data === 'object') {
					vm.detail   = r.data.data;
					vm.detailId = id;
					vm.copied   = null;
				}
			}).finally(() => { vm.detailLoading = null; });
		},
		closeDetail() { this.detail = null; this.detailId = null; this.copied = null; },

		// ── Copy ─────────────────────────────────────────────────────────────
		copy(raw, key) {
			if (!raw) return;
			var text = this.fmtJson(raw);
			navigator.clipboard.writeText(text).then(() => {
				this.copied = key;
				setTimeout(() => { if (this.copied === key) this.copied = null; }, 2000);
			});
		},

		// ── Format JSON ──────────────────────────────────────────────────────
		fmtJson(raw) {
			if (!raw) return '';
			try   { return JSON.stringify(JSON.parse(raw), null, 2); }
			catch { return raw; }
		},

		// ── Clear ────────────────────────────────────────────────────────────
		doClear() {
			var vm = this;
			vm.clearing = 'old';
			vm.api('clear', { days: vm.clearDays }).then(r => {
				if (r.data.data === '419') { location.href = '/masuk'; return; }
				vm.showClearDlg = false;
				vm.loadStats();
				vm.loadList(1);
			}).finally(() => { vm.clearing = null; });
		},

		// ── Helpers ──────────────────────────────────────────────────────────
		hClass(code) {
			if (!code) return 'al-h-unk';
			if (code >= 200 && code < 300) return 'al-h-ok';
			if (code >= 400 && code < 500) return 'al-h-4xx';
			return 'al-h-err';
		},
		shortUrl(url) {
			if (!url) return '—';
			try {
				var u    = new URL(url);
				var path = u.pathname + u.search;
				return path.length > 65 ? '…' + path.slice(-63) : path;
			} catch { return url.length > 65 ? '…' + url.slice(-63) : url; }
		},
		fmtTime(ts) {
			if (!ts) return '—';
			return new Date(ts).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' });
		},
		fmtTimeFull(ts) {
			if (!ts) return '—';
			return new Date(ts).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'medium' });
		},
		pct(a, b) { return b ? Math.round(a / b * 100) : 0; },
	},
};
</script>

<style scoped>
/* ─── Header ─────────────────────────────────────────────────────────────── */
.al-header-bar {
	display: flex; align-items: center; justify-content: space-between; gap: 12px;
	flex-wrap: wrap; background: #fff; border: 1px solid #e5e7eb;
	border-radius: 12px; padding: 16px 20px;
}
.al-header-left { display: flex; align-items: center; gap: 14px; }
.al-header-icon {
	width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
	background: #f0fdf4; display: flex; align-items: center; justify-content: center;
}
.al-header-icon svg { width: 20px; height: 20px; stroke: #16a34a; }
.al-header-title { font-size: 15px; font-weight: 700; color: #111; }
.al-header-sub   { font-size: 12px; color: #6b7280; margin-top: 2px; }
.al-header-right { display: flex; gap: 8px; flex-wrap: wrap; }

/* ─── Buttons ────────────────────────────────────────────────────────────── */
.al-btn {
	display: inline-flex; align-items: center; gap: 6px;
	padding: 7px 13px; border-radius: 7px; font-size: 13px; font-weight: 500;
	cursor: pointer; border: 1px solid transparent; transition: all .15s;
}
.al-btn svg { width: 14px; height: 14px; flex-shrink: 0; }
.al-btn-outline       { background: #fff; color: #374151; border-color: #d1d5db; }
.al-btn-outline:hover:not(:disabled) { background: #f9fafb; }
.al-btn-danger        { background: #dc2626; color: #fff; border-color: #dc2626; }
.al-btn-danger:hover:not(:disabled)  { background: #b91c1c; }
.al-btn-danger-ghost  { background: #fff; color: #dc2626; border-color: #fca5a5; }
.al-btn-danger-ghost:hover:not(:disabled) { background: #fef2f2; }
.al-btn:disabled { opacity: .5; cursor: not-allowed; }

/* ─── Stats ──────────────────────────────────────────────────────────────── */
.al-stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; }
@media(max-width:800px){ .al-stats-row { grid-template-columns: repeat(2,1fr); } }
.al-stat {
	padding: 15px 16px; border-radius: 10px; border: 1px solid;
	display: flex; flex-direction: column; gap: 2px;
}
.al-stat-num  { font-size: 24px; font-weight: 700; color: #111; }
.al-stat-unit { font-size: 13px; font-weight: 400; margin-left: 2px; color: #6b7280; }
.al-stat-lbl  { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; color: #6b7280; }
.al-stat-pct  { font-size: 11px; color: #9ca3af; }
.al-stat-gray  { background: #f9fafb; border-color: #e5e7eb; }
.al-stat-green { background: #f0fdf4; border-color: #bbf7d0; }
.al-stat-green .al-stat-lbl { color: #16a34a; }
.al-stat-red   { background: #fef2f2; border-color: #fecaca; }
.al-stat-red   .al-stat-lbl { color: #dc2626; }
.al-stat-blue  { background: #eff6ff; border-color: #bfdbfe; }
.al-stat-blue  .al-stat-lbl { color: #2563eb; }
.al-stat-skel  { height: 78px; background: #f3f4f6; animation: al-pulse 1.5s infinite; }

/* ─── Filter bar ─────────────────────────────────────────────────────────── */
.al-filter-bar {
	display: flex; flex-wrap: wrap; align-items: flex-end; gap: 10px;
	padding: 12px 14px; background: #fff;
	border: 1px solid #e5e7eb; border-radius: 10px;
}
.al-fg { display: flex; flex-direction: column; gap: 3px; }
.al-fg label { font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; }
.al-fg select, .al-fg input {
	border: 1px solid #d1d5db; border-radius: 6px;
	padding: 6px 10px; font-size: 13px; color: #374151; background: #fff; outline: none;
	min-width: 110px;
}
.al-fg select:focus, .al-fg input:focus { border-color: #4a6fa5; box-shadow: 0 0 0 2px #dbeafe; }
.al-fg-ctx select  { min-width: 160px; }
.al-fg-search input{ min-width: 220px; }

/* ─── Table ──────────────────────────────────────────────────────────────── */
.al-table-wrap {
	position: relative; overflow-x: auto;
	background: #fff; border: 1px solid #e5e7eb; border-radius: 10px;
}
.al-overlay {
	position: absolute; inset: 0; background: rgba(255,255,255,.7);
	display: flex; align-items: center; justify-content: center; z-index: 10; border-radius: 10px;
}
.al-spinner {
	width: 28px; height: 28px; border: 3px solid #e5e7eb;
	border-top-color: #16a34a; border-radius: 50%; animation: al-spin .8s linear infinite;
}
.al-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.al-table thead { background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
.al-table th {
	padding: 9px 11px; text-align: left; font-size: 11px; font-weight: 700;
	text-transform: uppercase; letter-spacing: .4px; color: #6b7280; white-space: nowrap;
}
.al-table td      { padding: 8px 11px; border-bottom: 1px solid #f1f5f9; }
.al-tr:hover td   { background: #f8fafc; }
.al-tr-sel td     { background: #eff6ff !important; }
.al-tr-fail td    { border-left: 3px solid #fca5a5; }
.al-tr-fail:hover td { background: #fff5f5; }
.al-table tbody tr:last-child td { border-bottom: none; }
.al-empty { padding: 40px; text-align: center; color: #9ca3af; }

.al-td-id   { font-family: monospace; font-size: 11px; color: #9ca3af; }
.al-td-url  { max-width: 260px; overflow: hidden; }
.al-td-url  span { display: block; font-family: monospace; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #1e40af; }
.al-td-ctx  { font-size: 12px; color: #6b7280; }
.al-td-muted{ font-size: 12px; color: #9ca3af; }
.al-nowrap  { white-space: nowrap; }

/* Badges */
.al-mbadge {
	display: inline-block; padding: 2px 6px; border-radius: 4px;
	font-size: 11px; font-weight: 700; font-family: monospace; letter-spacing: .2px;
}
.al-m-get    { background: #dbeafe; color: #1e40af; }
.al-m-post   { background: #d1fae5; color: #065f46; }
.al-m-put    { background: #fef3c7; color: #92400e; }
.al-m-patch  { background: #ede9fe; color: #5b21b6; }
.al-m-delete { background: #fee2e2; color: #991b1b; }

.al-hbadge {
	display: inline-block; padding: 2px 6px; border-radius: 4px;
	font-size: 12px; font-weight: 700; font-family: monospace;
}
.al-h-ok  { background: #d1fae5; color: #065f46; }
.al-h-4xx { background: #fef3c7; color: #92400e; }
.al-h-err { background: #fee2e2; color: #991b1b; }
.al-h-unk { background: #f3f4f6; color: #6b7280; }

/* View button */
.al-view-btn {
	background: none; border: 1px solid #e5e7eb; border-radius: 6px;
	padding: 4px 7px; cursor: pointer; color: #4a6fa5; display: flex; align-items: center;
	transition: all .15s;
}
.al-view-btn svg { width: 14px; height: 14px; }
.al-view-btn:hover:not(:disabled) { background: #eff6ff; border-color: #93c5fd; }
.al-view-btn.al-view-active { background: #eff6ff; border-color: #3b82f6; color: #1d4ed8; }
.al-view-btn:disabled { opacity: .5; cursor: not-allowed; }

/* Pagination */
.al-pager {
	display: flex; align-items: center; justify-content: space-between;
	padding: 10px 14px; border-top: 1px solid #f1f5f9; background: #fafbfc;
	font-size: 12px; color: #6b7280;
}
.al-pager-btns { display: flex; align-items: center; gap: 8px; }
.al-pager-btns button {
	padding: 4px 11px; border: 1px solid #d1d5db; border-radius: 6px;
	background: #fff; font-size: 14px; cursor: pointer; color: #374151;
}
.al-pager-btns button:hover:not(:disabled) { background: #f9fafb; }
.al-pager-btns button:disabled { opacity: .4; cursor: not-allowed; }
.al-pager-btns span { font-weight: 600; min-width: 60px; text-align: center; }

/* ─── Backdrop ───────────────────────────────────────────────────────────── */
.al-backdrop {
	position: fixed; inset: 0; z-index: 1100;
	background: rgba(0,0,0,.38);
}
.al-fade-enter-active, .al-fade-leave-active { transition: opacity .22s; }
.al-fade-enter-from, .al-fade-leave-to { opacity: 0; }

/* ─── Side panel ─────────────────────────────────────────────────────────── */
.al-side-panel {
	position: fixed; top: 0; right: 0; bottom: 0; z-index: 1200;
	width: 620px; max-width: 96vw; overflow-y: auto;
	background: #fff; display: flex; flex-direction: column;
	box-shadow: -4px 0 28px rgba(0,0,0,.18);
}
.al-slide-enter-active, .al-slide-leave-active { transition: transform .22s ease; }
.al-slide-enter-from, .al-slide-leave-to { transform: translateX(100%); }

/* Panel head */
.al-sp-head {
	position: sticky; top: 0; z-index: 2;
	display: flex; align-items: center; justify-content: space-between; gap: 8px;
	padding: 13px 16px; border-bottom: 1px solid #e5e7eb; background: #fff;
}
.al-sp-badges { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
.al-sp-ctx    { font-size: 12px; color: #6b7280; }
.al-sp-close {
	background: none; border: none; cursor: pointer; padding: 4px;
	border-radius: 6px; color: #6b7280; display: flex; flex-shrink: 0;
}
.al-sp-close:hover { background: #f3f4f6; color: #111; }
.al-sp-close svg { width: 18px; height: 18px; }

/* Panel meta */
.al-sp-meta {
	padding: 12px 16px; border-bottom: 1px solid #f1f5f9;
	display: flex; flex-direction: column; gap: 7px;
}
.al-sp-meta-row   { display: flex; align-items: baseline; gap: 10px; }
.al-sp-meta-k     { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #9ca3af; width: 60px; flex-shrink: 0; }
.al-sp-meta-v     { font-size: 13px; color: #374151; word-break: break-all; }
.al-sp-url        { font-family: monospace; font-size: 12px; color: #1e40af; }
.al-dot           { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 5px; }
.al-dot-ok        { background: #22c55e; }
.al-dot-fail      { background: #ef4444; }
.al-mono          { font-family: monospace; }

/* Panel section */
.al-sp-section { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; }
.al-sp-sec-head {
	display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;
}
.al-sp-sec-title {
	font-size: 12px; font-weight: 700; text-transform: uppercase;
	letter-spacing: .5px; color: #374151;
}

/* Copy button */
.al-copy-btn {
	display: inline-flex; align-items: center; gap: 5px;
	padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 500;
	cursor: pointer; border: 1px solid #d1d5db; background: #fff; color: #374151;
	transition: all .15s;
}
.al-copy-btn svg { width: 13px; height: 13px; }
.al-copy-btn:hover     { background: #f9fafb; border-color: #9ca3af; }
.al-copy-btn.al-copied { background: #f0fdf4; border-color: #86efac; color: #16a34a; }

/* JSON code block */
.al-json-wrap {
	border: 1px solid #2d2d3f; border-radius: 8px;
	background: #1e1e2e; max-height: 380px; overflow: auto;
}
.al-json {
	margin: 0; padding: 13px 15px;
	font-family: 'Fira Code','Cascadia Code','Consolas',monospace;
	font-size: 12px; line-height: 1.65; color: #cdd6f4;
	white-space: pre; tab-size: 2;
}
.al-json-empty {
	padding: 20px; text-align: center; color: #555; font-size: 13px; font-style: italic;
}

/* ─── Modal ──────────────────────────────────────────────────────────────── */
.al-modal-bg {
	position: fixed; inset: 0; z-index: 1300;
	background: rgba(0,0,0,.42); display: flex; align-items: center; justify-content: center;
}
.al-modal {
	background: #fff; border-radius: 12px; padding: 24px;
	width: 400px; max-width: 94vw; box-shadow: 0 20px 50px rgba(0,0,0,.22);
}
.al-modal-title  { font-size: 16px; font-weight: 700; color: #111; margin-bottom: 12px; }
.al-modal-body p { font-size: 14px; color: #374151; margin-bottom: 10px; }
.al-modal-days-row {
	display: flex; align-items: center; gap: 8px; font-size: 13px; color: #374151; flex-wrap: wrap;
}
.al-modal-days-row select {
	padding: 5px 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; outline: none;
}
.al-modal-footer { display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px; }

/* ─── Animations ─────────────────────────────────────────────────────────── */
@keyframes al-pulse { 0%,100%{opacity:1} 50%{opacity:.5} }
@keyframes al-spin  { to{transform:rotate(360deg)} }
.al-spin { animation: al-spin .8s linear infinite; display: inline-block; }
</style>
