<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Fetch Panel ─────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="es-trigger-panel">
			<div class="etp-left">
				<div class="etp-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
				</div>
				<div>
					<div class="etp-title">Data Wilayah SatuSehat</div>
					<div class="etp-desc">
						Fetch dan cache kode wilayah administratif (BPS) dari SatuSehat Masterdata API.
						Kode ini digunakan pada payload Patient → <code>address.extension.administrativeCode</code>.
					</div>
				</div>
			</div>
			<div class="etp-right">
				<button class="etp-run-btn etp-run-btn-sm" @click="fetchLevel('province')" :disabled="fetching">
					<svg v-if="fetching !== 'province'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ fetching === 'province' ? 'Fetching…' : 'Fetch Provinsi' }}
				</button>
			</div>
		</div>

		<!-- ── Fetch Semua (one-click background fetch) ──────────────── -->
		<div class="sw-fetchall-panel">
			<div class="sw-fetchall-opts">
				<span class="sw-fetchall-optlabel">Sertakan:</span>
				<label class="sw-chk-label">
					<input type="checkbox" v-model="fetchAllOpts.with_district" :disabled="fetchingAll" />
					Kecamatan
				</label>
				<label class="sw-chk-label">
					<input type="checkbox" v-model="fetchAllOpts.with_subdistrict" :disabled="fetchingAll" />
					Kelurahan/Desa
					<span class="sw-chk-warn">(lambat)</span>
				</label>
				<div class="sw-fetchall-spacer"></div>
				<button class="sw-fetchall-btn" @click="fetchAll" :disabled="fetchingAll || !!fetching">
					<svg v-if="!fetchingAll" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ fetchingAll ? 'Sedang Fetch... (' + fetchAllElapsed + 's)' : 'Fetch Semua' }}
				</button>
			</div>

			<!-- Log output -->
			<div class="sw-fetchall-log" v-if="fetchAllLog.length > 0 || fetchingAll">
				<div class="sw-fal-header">
					<span>Log Proses</span>
					<button v-if="!fetchingAll" class="sw-fal-clear" @click="fetchAllLog = []; fetchAllResult = null">Hapus</button>
				</div>
				<div class="sw-fal-body" ref="fetchLogBody">
					<div v-for="(line, i) in fetchAllLog" :key="i" class="sw-fal-line"
						:class="line.includes('GAGAL') ? 'sw-fal-err' : (line.startsWith('[') ? 'sw-fal-step' : '')">
						{{ line }}
					</div>
					<div v-if="fetchingAll" class="sw-fal-line sw-fal-waiting">
						<span class="sw-fal-dot"></span> Memproses, harap tunggu...
					</div>
				</div>
				<div v-if="fetchAllResult" class="sw-fal-summary" :class="fetchAllResult.ok ? 'sw-fal-ok' : 'sw-fal-fail'">
					{{ fetchAllResult.message }}
				</div>
			</div>
		</div>

		<!-- Fetch individual (kolapsibel) -->
		<details class="sw-fetch-manual">
			<summary class="sw-fetch-manual-summary">Fetch Manual per Level (opsional)</summary>
			<div class="sw-fetch-row">
				<div class="sw-fetch-group">
					<label class="sw-fetch-label">Fetch Kota/Kab dari Provinsi:</label>
					<select v-model="selectedProvince" class="sw-fetch-select" :disabled="!!fetching || !provinces.length">
						<option value="">— Pilih Provinsi —</option>
						<option v-for="p in provinces" :key="p.code" :value="p.code">{{ p.name }}</option>
					</select>
					<button class="sw-fetch-btn" @click="fetchLevel('city', selectedProvince)"
						:disabled="!!fetching || !selectedProvince">
						<svg v-if="fetching !== 'city'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						{{ fetching === 'city' ? 'Fetching...' : 'Fetch' }}
					</button>
				</div>

				<div class="sw-fetch-group">
					<label class="sw-fetch-label">Fetch Kecamatan dari Kota:</label>
					<select v-model="selectedCity" class="sw-fetch-select" :disabled="!!fetching || !cities.length">
						<option value="">— Pilih Kota/Kab —</option>
						<option v-for="c in cities" :key="c.code" :value="c.code">{{ c.name }}</option>
					</select>
					<button class="sw-fetch-btn" @click="fetchLevel('district', selectedCity)"
						:disabled="!!fetching || !selectedCity">
						<svg v-if="fetching !== 'district'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						{{ fetching === 'district' ? 'Fetching...' : 'Fetch' }}
					</button>
				</div>

				<div class="sw-fetch-group">
					<label class="sw-fetch-label">Fetch Kelurahan dari Kecamatan:</label>
					<select v-model="selectedDistrict" class="sw-fetch-select" :disabled="!!fetching || !districts.length">
						<option value="">— Pilih Kecamatan —</option>
						<option v-for="d in districts" :key="d.code" :value="d.code">{{ d.name }}</option>
					</select>
					<button class="sw-fetch-btn" @click="fetchLevel('sub_district', selectedDistrict)"
						:disabled="!!fetching || !selectedDistrict">
						<svg v-if="fetching !== 'sub_district'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						{{ fetching === 'sub_district' ? 'Fetching...' : 'Fetch' }}
					</button>
				</div>
			</div>
		</details>

		<!-- Fetch result -->
		<div class="es-sync-result" v-if="fetchResult">
			<div class="esr-item" :class="fetchResult.ok ? 'esr-green' : 'esr-red'">
				<svg v-if="fetchResult.ok" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				<strong>{{ fetchResult.count ?? 0 }}</strong> data disimpan
			</div>
			<div class="esr-msg">{{ fetchResult.message }}</div>
			<button class="esr-close" @click="fetchResult = null">✕</button>
		</div>
	</div>

	<!-- ── Sync ke Master Data Panel ───────────────────────────────── -->
	<div class="col-12">
		<div class="sw-master-panel">
			<div class="sw-master-header">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;stroke:#0369a1;flex-shrink:0"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
				<span class="sw-master-title">Sync Kode SatuSehat → Master Data Wilayah</span>
				<span class="sw-master-sub">Cocokkan nama wilayah lokal ke kode BPS SatuSehat (provinsi, kab_kota, kecamatan, kelurahan)</span>
			</div>
			<div class="sw-master-body">
				<div class="sw-master-progress" v-if="!masterStatsLoading">
					<div class="sw-master-prog-item" v-for="(s, lvl) in masterStats" :key="lvl">
						<div class="sw-mp-top">
							<span class="sw-mp-label">{{ levelLabel(lvl) }}</span>
							<span class="sw-mp-pct">{{ s.filled }}/{{ s.total }} ({{ s.pct }}%)</span>
						</div>
						<div class="sw-mp-bar">
							<div class="sw-mp-bar-fill" :style="{ width: s.pct + '%' }" :class="s.pct === 100 ? 'sw-mp-bar-full' : ''"></div>
						</div>
					</div>
				</div>
				<div class="sw-master-progress" v-else>
					<div class="sw-mp-shimmer" v-for="i in 4" :key="i"></div>
				</div>

				<div class="sw-master-actions">
					<button class="sw-sync-btn sw-sync-all-btn" @click="syncAll" :disabled="!!syncing">
						<svg v-if="syncing !== 'all'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						{{ syncing === 'all' ? 'Sync Semua...' : 'Sync Semua ke Master' }}
					</button>
					<div class="sw-sync-divider"></div>
					<button v-for="lvl in ['province','city','district','sub_district']" :key="lvl"
						class="sw-sync-btn sw-sync-single-btn" @click="syncToMaster(lvl)"
						:disabled="!!syncing">
						<svg v-if="syncing !== lvl" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="etp-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-btn-icon etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
						{{ syncing === lvl ? 'Sync...' : levelLabel(lvl) }}
					</button>
				</div>

				<!-- Sync All Result -->
				<div class="sw-sync-result sw-syncall-result" v-if="syncAllResult">
					<div :class="syncAllResult.ok ? 'sw-sr-ok' : 'sw-sr-fail'">{{ syncAllResult.message }}</div>
					<div v-if="syncAllResult.results" class="sw-sr-detail">
						<span v-for="(r, lvl) in syncAllResult.results" :key="lvl" class="sw-sr-badge"
							:class="r.note ? 'sw-sr-badge-grey' : (r.matched > 0 ? 'sw-sr-badge-green' : 'sw-sr-badge-yellow')">
							{{ levelLabel(lvl) }}: +{{ r.matched }}
							<template v-if="r.unmatched > 0"> / {{ r.unmatched }} unmatched</template>
							<template v-if="r.note"> ({{ r.note }})</template>
						</span>
					</div>
					<button class="esr-close" @click="syncAllResult = null">&#x2715;</button>
				</div>

				<!-- Sync result -->
				<div class="sw-sync-result" v-if="syncResult">
					<div :class="syncResult.ok ? 'sw-sr-ok' : 'sw-sr-fail'">
						{{ syncResult.message }}
					</div>
					<div v-if="syncResult.unmatched_list && syncResult.unmatched_list.length > 0" class="sw-sr-unmatched">
						<strong>Tidak cocok ({{ syncResult.unmatched_count }}):</strong>
						{{ syncResult.unmatched_list.join(', ') }}{{ syncResult.unmatched_count > 20 ? ', …' : '' }}
					</div>
					<button class="esr-close" @click="syncResult = null">✕</button>
				</div>
			</div>
		</div>
	</div>

	<!-- ── Stats Cards ─────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="ss-stats-row" v-if="!statsLoading">
			<div class="ss-stat-card ss-stat-blue">
				<div class="ss-stat-val">{{ stats.province }}</div>
				<div class="ss-stat-lbl">Provinsi</div>
			</div>
			<div class="ss-stat-card ss-stat-indigo">
				<div class="ss-stat-val">{{ stats.city }}</div>
				<div class="ss-stat-lbl">Kota/Kab</div>
			</div>
			<div class="ss-stat-card ss-stat-violet">
				<div class="ss-stat-val">{{ stats.district }}</div>
				<div class="ss-stat-lbl">Kecamatan</div>
			</div>
			<div class="ss-stat-card ss-stat-purple">
				<div class="ss-stat-val">{{ stats.sub_district }}</div>
				<div class="ss-stat-lbl">Kelurahan/Desa</div>
			</div>
		</div>
		<div class="ss-stats-row" v-else>
			<div class="ss-stat-card ss-stat-loading" v-for="i in 4" :key="i"><div class="ss-stat-shimmer"></div></div>
		</div>
	</div>

	<!-- ── Pasien Missing Wilayah Warning ─────────────────────────────── -->
	<div class="col-12" v-if="!statsLoading && (stats.missing_province > 0 || stats.missing_city > 0)">
		<div class="sw-warning-box">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="sw-warn-icon"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
			<div class="sw-warn-content">
				<div class="sw-warn-title">Pasien Belum Memiliki Kode Wilayah SatuSehat</div>
				<div class="sw-warn-detail">
					<span v-if="stats.missing_province > 0">Provinsi kosong: <strong>{{ stats.missing_province }}</strong> pasien</span>
					<span v-if="stats.missing_city > 0" class="sw-warn-sep"> · Kota kosong: <strong>{{ stats.missing_city }}</strong> pasien</span>
					<span v-if="stats.missing_district > 0" class="sw-warn-sep"> · Kecamatan kosong: <strong>{{ stats.missing_district }}</strong> pasien</span>
					<span v-if="stats.missing_subdistrict > 0" class="sw-warn-sep"> · Kelurahan kosong: <strong>{{ stats.missing_subdistrict }}</strong> pasien</span>
				</div>
				<div class="sw-warn-hint">
					Kolom <code>ss_province_code</code>, <code>ss_city_code</code>, <code>ss_district_code</code>, <code>ss_subdistrict_code</code> di tabel <code>pasien</code> perlu diisi dengan kode BPS dari SatuSehat agar payload Patient address valid.
				</div>
			</div>
		</div>
	</div>

	<!-- ── List Tabs & Table ────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="es-tab-bar">
			<button v-for="tab in tabs" :key="tab.key"
				class="es-tab-btn" :class="{ 'es-tab-active': activeTab === tab.key }"
				@click="setTab(tab.key)">
				{{ tab.label }}
				<span class="es-tab-count" v-if="tab.key === activeTab && total > 0">{{ total }}</span>
			</button>
			<div class="es-tab-spacer"></div>
			<div class="es-search-wrap">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="es-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
				<input v-model="search" @input="onSearch" class="es-search-input" placeholder="Cari kode / nama…" />
			</div>
		</div>

		<!-- Table -->
		<div class="es-table-wrap">
			<div class="es-loading-overlay" v-if="loading">
				<div class="es-spinner"></div>
			</div>

			<table class="es-table">
				<thead>
					<tr>
						<th style="width:120px">Kode</th>
						<th>Nama</th>
						<th style="width:130px" v-if="activeTab !== 'province'">Parent</th>
						<th style="width:150px">Fetched At</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="!loading && list.length === 0">
						<td :colspan="activeTab !== 'province' ? 4 : 3" class="es-empty">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:28px;height:28px;margin-bottom:6px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
							<div>Belum ada data. Gunakan tombol Fetch di atas.</div>
						</td>
					</tr>
					<tr v-for="row in list" :key="row.id">
						<td><code class="sw-code-badge">{{ row.code }}</code></td>
						<td>{{ row.name }}</td>
						<td v-if="activeTab !== 'province'">
							<code class="sw-code-badge sw-code-parent">{{ row.parent_code || '—' }}</code>
						</td>
						<td class="es-text-muted">{{ formatDate(row.fetched_at) }}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		<div class="es-pager" v-if="totalPages > 1">
			<button class="es-page-btn" :disabled="page <= 1" @click="gotoPage(page - 1)">‹</button>
			<span class="es-page-info">{{ page }} / {{ totalPages }}</span>
			<button class="es-page-btn" :disabled="page >= totalPages" @click="gotoPage(page + 1)">›</button>
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
	name: 'SatuSehatWilayah',
	data() {
		return {
			stats:       { province: 0, city: 0, district: 0, sub_district: 0,
			               missing_province: 0, missing_city: 0, missing_district: 0, missing_subdistrict: 0,
			               last_fetch: null },
			statsLoading: true,

			// Cascading dropdowns
			provinces:        [],
			cities:           [],
			districts:        [],
			selectedProvince: '',
			selectedCity:     '',
			selectedDistrict: '',

			// Fetch state
			fetching:    null,   // 'province' | 'city' | 'district' | 'sub_district' | null
			fetchResult: null,

			// Fetch All state
			fetchingAll:    false,
			fetchAllOpts:   { with_district: true, with_subdistrict: false },
			fetchAllLog:    [],
			fetchAllResult: null,
			fetchAllElapsed: 0,
			fetchAllTimer:  null,

			// Sync to master
			syncing:           null,
			syncResult:        null,
			syncAllResult:     null,
			masterStats:       {},
			masterStatsLoading: true,

			// Table
			tabs: [
				{ key: 'province',     label: 'Provinsi' },
				{ key: 'city',         label: 'Kota/Kab' },
				{ key: 'district',     label: 'Kecamatan' },
				{ key: 'sub_district', label: 'Kelurahan/Desa' },
			],
			activeTab: 'province',
			list:      [],
			total:     0,
			page:      1,
			perPage:   25,
			search:    '',
			loading:   false,
			searchTimeout: null,
		};
	},
	computed: {
		totalPages() { return Math.ceil(this.total / this.perPage) || 1; },
	},
	mounted() {
		var vm = this;
		vm.loadStats();
		vm.loadList();
		vm.loadProvinces();
		vm.loadMasterStats();
	},
	methods: {
		api(path, payload, timeout) {
			var fd = new FormData();
			for (var k in payload) { fd.append(k, payload[k] ?? ''); }
			return axios.post('/satusehat-api/wilayah/' + path, fd, {
				headers: { 'Content-Type': 'multipart/form-data' },
				timeout: timeout || 60000,
			});
		},

		loadStats() {
			var vm = this;
			vm.statsLoading = true;
			vm.api('dashboard', {}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.stats = r.data.data ?? vm.stats;
			}).catch(() => {
				vm.notification('Gagal memuat statistik.', 3000, 'error');
			}).finally(() => {
				vm.statsLoading = false;
			});
		},

		loadList() {
			var vm = this;
			vm.loading = true;
			vm.api('list', {
				level:  vm.activeTab,
				page:   vm.page,
				search: vm.search,
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.list  = r.data.data  ?? [];
				vm.total = r.data.total ?? 0;
			}).catch(() => {
				vm.notification('Gagal memuat data.', 3000, 'error');
			}).finally(() => {
				vm.loading = false;
			});
		},

		loadProvinces() {
			var vm = this;
			axios.post('/satusehat-api/wilayah/select',
				new URLSearchParams({ level: 'province' })).then(r => {
				vm.provinces = r.data.data ?? [];
			}).catch(() => {});
		},

		loadCities() {
			var vm = this;
			if (!vm.selectedProvince) { vm.cities = []; return; }
			axios.post('/satusehat-api/wilayah/select',
				new URLSearchParams({ level: 'city', parent_code: vm.selectedProvince })).then(r => {
				vm.cities = r.data.data ?? [];
				vm.selectedCity     = '';
				vm.selectedDistrict = '';
				vm.districts        = [];
			}).catch(() => {});
		},

		loadDistricts() {
			var vm = this;
			if (!vm.selectedCity) { vm.districts = []; return; }
			axios.post('/satusehat-api/wilayah/select',
				new URLSearchParams({ level: 'district', parent_code: vm.selectedCity })).then(r => {
				vm.districts = r.data.data ?? [];
				vm.selectedDistrict = '';
			}).catch(() => {});
		},

		fetchLevel(level, parentCode) {
			var vm = this;
			if (vm.fetching) return;

			if (['city', 'district', 'sub_district'].includes(level) && !parentCode) {
				vm.notification('Pilih parent terlebih dahulu.', 3000, 'error');
				return;
			}

			vm.fetching    = level;
			vm.fetchResult = null;

			var payload = { level: level };
			if (parentCode) payload.parent_code = parentCode;

			vm.api('fetch', payload).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				var ok = r.data.data === 'berhasil';
				vm.fetchResult = { ok: ok, message: r.data.message, count: r.data.count ?? 0 };
				if (ok) {
					vm.loadStats();
					// Refresh dropdown jika perlu
					if (level === 'province') { vm.loadProvinces(); }
					if (level === 'city')     { vm.loadCities(); }
					if (level === 'district') { vm.loadDistricts(); }
					// Refresh tabel jika tab aktif sesuai
					if (vm.activeTab === level) { vm.page = 1; vm.loadList(); }
					vm.notification(r.data.message, 4000, 'success');
				} else {
					vm.notification('Gagal fetch: ' + r.data.message, 5000, 'error');
				}
			}).catch(e => {
				var msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.fetchResult = { ok: false, message: msg, count: 0 };
				vm.notification('Error: ' + msg, 5000, 'error');
			}).finally(() => {
				vm.fetching = null;
			});
		},

		setTab(key) {
			var vm = this;
			vm.activeTab = key;
			vm.page      = 1;
			vm.search    = '';
			vm.loadList();
		},

		onSearch() {
			var vm = this;
			clearTimeout(vm.searchTimeout);
			vm.searchTimeout = setTimeout(() => {
				vm.page = 1;
				vm.loadList();
			}, 400);
		},

		gotoPage(p) {
			var vm = this;
			vm.page = p;
			vm.loadList();
		},

		formatDate(d) {
			if (!d) return '—';
			try {
				var dt = new Date(d);
				return dt.toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric',
				                                    hour: '2-digit', minute: '2-digit' });
			} catch { return d; }
		},

		loadMasterStats() {
			var vm = this;
			vm.masterStatsLoading = true;
			vm.api('master-stats', {}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.masterStats = r.data.data ?? {};
			}).catch(() => {}).finally(() => { vm.masterStatsLoading = false; });
		},

		syncToMaster(level) {
			var vm = this;
			if (vm.syncing) return;
			vm.syncing    = level;
			vm.syncResult = null;

			vm.api('sync-to-master', { level: level }).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				var ok = r.data.data === 'berhasil';
				vm.syncResult = {
					ok:             ok,
					message:        r.data.message,
					unmatched_count: r.data.unmatched ?? 0,
					unmatched_list:  r.data.unmatched_list ?? [],
				};
				if (ok) {
					vm.loadMasterStats();
					vm.notification(r.data.message, 4000, ok ? 'success' : 'error');
				} else {
					vm.notification('Gagal sync: ' + r.data.message, 5000, 'error');
				}
			}).catch(e => {
				var msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.syncResult = { ok: false, message: msg, unmatched_count: 0, unmatched_list: [] };
				vm.notification('Error: ' + msg, 5000, 'error');
			}).finally(() => { vm.syncing = null; });
		},

		fetchAll() {
			var vm = this;
			if (vm.fetchingAll) return;
			vm.fetchingAll    = true;
			vm.fetchAllLog    = [];
			vm.fetchAllResult = null;
			vm.fetchAllElapsed = 0;

			// Elapsed timer
			vm.fetchAllTimer = setInterval(() => { vm.fetchAllElapsed++; }, 1000);

			var payload = {
				with_district:    vm.fetchAllOpts.with_district    ? '1' : '0',
				with_subdistrict: vm.fetchAllOpts.with_subdistrict ? '1' : '0',
			};

			vm.api('fetch-all', payload, 660000).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				var ok = r.data.data === 'berhasil';
				vm.fetchAllLog    = r.data.log ?? [];
				vm.fetchAllResult = { ok: ok, message: r.data.message };
				if (ok) {
					vm.loadStats();
					vm.loadProvinces();
					vm.notification(r.data.message, 5000, 'success');
					if (vm.activeTab !== 'province') { vm.page = 1; vm.loadList(); }
				} else {
					vm.notification('Fetch Semua gagal: ' + r.data.message, 6000, 'error');
				}
				vm.$nextTick(() => {
					var el = vm.$refs.fetchLogBody;
					if (el) el.scrollTop = el.scrollHeight;
				});
			}).catch(e => {
				var msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.fetchAllLog.push('ERROR: ' + msg);
				vm.fetchAllResult = { ok: false, message: msg };
				vm.notification('Error: ' + msg, 6000, 'error');
			}).finally(() => {
				clearInterval(vm.fetchAllTimer);
				vm.fetchingAll = false;
			});
		},

		syncAll() {
			var vm = this;
			if (vm.syncing) return;
			vm.syncing       = 'all';
			vm.syncAllResult = null;

			vm.api('sync-all-to-master', {}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				var ok = r.data.data === 'berhasil';
				vm.syncAllResult = {
					ok:      ok,
					message: r.data.message,
					results: r.data.results ?? {},
				};
				if (ok) {
					vm.loadMasterStats();
					vm.notification(r.data.message, 5000, 'success');
				} else {
					vm.notification('Sync gagal: ' + r.data.message, 5000, 'error');
				}
			}).catch(e => {
				var msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.syncAllResult = { ok: false, message: msg, results: {} };
				vm.notification('Error: ' + msg, 5000, 'error');
			}).finally(() => { vm.syncing = null; });
		},

		levelLabel(level) {
			return { province: 'Provinsi', city: 'Kota/Kab', district: 'Kecamatan', sub_district: 'Kelurahan' }[level] || level;
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
	watch: {
		selectedProvince(val) { if (val) this.loadCities(); else { this.cities = []; this.selectedCity = ''; this.districts = []; this.selectedDistrict = ''; } },
		selectedCity(val)     { if (val) this.loadDistricts(); else { this.districts = []; this.selectedDistrict = ''; } },
	},
};
</script>

<style scoped>
/* ── Reuse encounter styles ── */
.es-trigger-panel {
	background: var(--bg-card, #fff);
	border: 1px solid var(--border, #e5e7eb);
	border-radius: 12px;
	padding: 20px 24px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 16px;
	flex-wrap: wrap;
	margin-bottom: 0;
}
.etp-left { display: flex; align-items: flex-start; gap: 14px; flex: 1; }
.etp-icon { width: 40px; height: 40px; border-radius: 10px; background: #ede9fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.etp-icon svg { width: 20px; height: 20px; stroke: #7c3aed; }
.etp-title { font-size: 15px; font-weight: 600; color: var(--text-primary, #111); }
.etp-desc  { font-size: 13px; color: var(--text-muted, #6b7280); margin-top: 2px; line-height: 1.5; }
.etp-desc code { background: var(--bg-code,#f3f4f6); padding: 1px 5px; border-radius: 4px; font-size: 12px; }
.etp-right { display: flex; align-items: center; gap: 10px; }
.etp-run-btn {
	display: flex; align-items: center; gap: 7px;
	background: #7c3aed; color: #fff; border: none;
	padding: 9px 18px; border-radius: 8px; cursor: pointer;
	font-size: 14px; font-weight: 500; transition: background .15s;
}
.etp-run-btn:hover:not(:disabled) { background: #6d28d9; }
.etp-run-btn:disabled { opacity: .55; cursor: not-allowed; }
.etp-run-btn-sm { padding: 8px 14px; font-size: 13px; }
.etp-btn-icon { width: 16px; height: 16px; }
.etp-spin { animation: spin 1s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Fetch row ── */
.sw-fetch-row {
	display: flex; gap: 12px; flex-wrap: wrap;
	background: var(--bg-card, #fff);
	border: 1px solid var(--border, #e5e7eb);
	border-top: none;
	border-radius: 0 0 12px 12px;
	padding: 14px 20px;
}
.sw-fetch-group { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 240px; }
.sw-fetch-label { font-size: 12px; color: var(--text-muted,#6b7280); white-space: nowrap; }
.sw-fetch-select {
	flex: 1; border: 1px solid var(--border,#e5e7eb); border-radius: 6px;
	padding: 6px 8px; font-size: 13px; background: var(--bg-input,#fff);
	color: var(--text-primary,#111);
}
.sw-fetch-btn {
	display: flex; align-items: center; gap: 5px;
	background: #6d28d9; color: #fff; border: none;
	padding: 7px 13px; border-radius: 7px; cursor: pointer;
	font-size: 12px; font-weight: 500; white-space: nowrap;
}
.sw-fetch-btn:hover:not(:disabled) { background: #5b21b6; }
.sw-fetch-btn:disabled { opacity: .5; cursor: not-allowed; }

/* ── Sync result bar ── */
.es-sync-result {
	display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
	background: var(--bg-card,#fff); border: 1px solid var(--border,#e5e7eb);
	border-top: none; border-radius: 0 0 10px 10px;
	padding: 10px 20px; font-size: 13px;
}
.esr-item { display: flex; align-items: center; gap: 5px; font-weight: 500; }
.esr-item svg { width: 14px; height: 14px; }
.esr-green { color: #059669; }
.esr-red   { color: #dc2626; }
.esr-msg   { color: var(--text-muted,#6b7280); flex: 1; }
.esr-close { background: none; border: none; color: var(--text-muted,#6b7280); cursor: pointer; font-size: 15px; }

/* ── Stats ── */
.ss-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
@media(max-width:640px){ .ss-stats-row { grid-template-columns: repeat(2, 1fr); } }
.ss-stat-card {
	border-radius: 12px; padding: 18px 20px;
	display: flex; flex-direction: column; gap: 4px;
	border: 1px solid transparent;
}
.ss-stat-val { font-size: 26px; font-weight: 700; }
.ss-stat-lbl { font-size: 12px; font-weight: 500; opacity: .8; }
.ss-stat-blue   { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.ss-stat-indigo { background: #eef2ff; border-color: #c7d2fe; color: #4338ca; }
.ss-stat-violet { background: #f5f3ff; border-color: #ddd6fe; color: #6d28d9; }
.ss-stat-purple { background: #fdf4ff; border-color: #e9d5ff; color: #7e22ce; }
.ss-stat-loading{ background: var(--bg-shimmer,#f3f4f6); border-color: transparent; height: 80px; }
.ss-stat-shimmer{ width: 60%; height: 24px; background: var(--bg-shimmer2,#e5e7eb); border-radius: 6px; margin-top: 12px; animation: shimmer 1.5s infinite; }
@keyframes shimmer { 0%,100%{opacity:1} 50%{opacity:.4} }

/* ── Master sync panel ── */
.sw-master-panel {
	background: var(--bg-card,#fff); border: 1px solid #bae6fd; border-radius: 12px; overflow: hidden;
}
.sw-master-header {
	display: flex; align-items: center; gap: 10px;
	background: #f0f9ff; padding: 14px 18px; border-bottom: 1px solid #bae6fd;
}
.sw-master-title { font-size: 14px; font-weight: 600; color: #0c4a6e; }
.sw-master-sub   { font-size: 12px; color: #0369a1; margin-left: auto; }
.sw-master-body  { padding: 16px 18px; display: flex; flex-direction: column; gap: 14px; }
.sw-master-progress { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
@media(max-width:640px){ .sw-master-progress { grid-template-columns: repeat(2,1fr); } }
.sw-master-prog-item { display: flex; flex-direction: column; gap: 5px; }
.sw-mp-top  { display: flex; justify-content: space-between; font-size: 12px; }
.sw-mp-label{ font-weight: 600; color: var(--text-primary,#111); }
.sw-mp-pct  { color: var(--text-muted,#6b7280); }
.sw-mp-bar  { height: 6px; background: #e5e7eb; border-radius: 99px; overflow: hidden; }
.sw-mp-bar-fill { height: 100%; background: #0369a1; border-radius: 99px; transition: width .5s; }
.sw-mp-bar-full { background: #16a34a; }
.sw-mp-shimmer  { height: 40px; background: #f3f4f6; border-radius: 6px; animation: shimmer 1.5s infinite; }
.sw-master-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.sw-sync-btn {
	display: flex; align-items: center; gap: 6px;
	background: #0369a1; color: #fff; border: none;
	padding: 8px 14px; border-radius: 7px; cursor: pointer;
	font-size: 13px; font-weight: 500; transition: background .15s;
}
.sw-sync-btn:hover:not(:disabled) { background: #0284c7; }
.sw-sync-btn:disabled { opacity: .5; cursor: not-allowed; }
.sw-sync-result {
	background: var(--bg-card,#fff); border: 1px solid var(--border,#e5e7eb);
	border-radius: 8px; padding: 10px 14px; font-size: 13px; position: relative;
	display: flex; flex-direction: column; gap: 4px;
}
.sw-sr-ok   { color: #065f46; font-weight: 500; }
.sw-sr-fail { color: #991b1b; font-weight: 500; }
.sw-sr-unmatched { font-size: 12px; color: var(--text-muted,#6b7280); }
.sw-sync-result .esr-close { position: absolute; top: 8px; right: 10px; }

/* ── Warning box ── */
.sw-warning-box {
	display: flex; align-items: flex-start; gap: 12px;
	background: #fffbeb; border: 1px solid #fde68a;
	border-radius: 10px; padding: 16px 18px;
}
.sw-warn-icon { width: 20px; height: 20px; stroke: #d97706; flex-shrink: 0; margin-top: 1px; }
.sw-warn-title { font-size: 14px; font-weight: 600; color: #92400e; }
.sw-warn-detail { font-size: 13px; color: #78350f; margin-top: 4px; }
.sw-warn-sep { margin-left: 4px; }
.sw-warn-hint { font-size: 12px; color: #a16207; margin-top: 6px; line-height: 1.5; }
.sw-warn-hint code { background: #fef3c7; padding: 1px 4px; border-radius: 3px; font-size: 11px; }
.sw-warn-content { flex: 1; }

/* ── Tabs ── */
.es-tab-bar {
	display: flex; align-items: center; gap: 4px; flex-wrap: wrap;
	border-bottom: 1px solid var(--border,#e5e7eb); margin-bottom: 0; padding-bottom: 0;
}
.es-tab-btn {
	padding: 9px 16px; border: none; background: none; cursor: pointer;
	font-size: 13px; color: var(--text-muted,#6b7280); border-bottom: 2px solid transparent;
	margin-bottom: -1px; font-weight: 500; transition: all .15s;
	display: flex; align-items: center; gap: 6px;
}
.es-tab-btn:hover { color: var(--text-primary,#111); }
.es-tab-active { color: #7c3aed !important; border-bottom-color: #7c3aed !important; }
.es-tab-count { background: #7c3aed; color: #fff; border-radius: 99px; font-size: 11px; padding: 1px 7px; }
.es-tab-spacer { flex: 1; }
.es-search-wrap { position: relative; margin-bottom: 2px; }
.es-search-icon { position: absolute; left: 9px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; stroke: var(--text-muted,#9ca3af); }
.es-search-input { padding: 7px 12px 7px 30px; border: 1px solid var(--border,#e5e7eb); border-radius: 7px; font-size: 13px; background: var(--bg-input,#fff); color: var(--text-primary,#111); min-width: 200px; }

/* ── Table ── */
.es-table-wrap { position: relative; overflow-x: auto; border: 1px solid var(--border,#e5e7eb); border-top: none; border-radius: 0 0 10px 10px; }
.es-loading-overlay { position: absolute; inset: 0; background: rgba(255,255,255,.7); display: flex; align-items: center; justify-content: center; z-index: 10; border-radius: 0 0 10px 10px; }
.es-spinner { width: 28px; height: 28px; border: 3px solid #e5e7eb; border-top-color: #7c3aed; border-radius: 50%; animation: spin 0.8s linear infinite; }
.es-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.es-table th { background: var(--bg-thead,#f9fafb); padding: 10px 14px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted,#6b7280); border-bottom: 1px solid var(--border,#e5e7eb); white-space: nowrap; }
.es-table td { padding: 10px 14px; border-bottom: 1px solid var(--border-light,#f3f4f6); color: var(--text-primary,#111); vertical-align: middle; }
.es-table tbody tr:last-child td { border-bottom: none; }
.es-table tbody tr:hover td { background: var(--bg-hover,#f9fafb); }
.es-empty { text-align: center; padding: 40px 16px; color: var(--text-muted,#9ca3af); }
.es-text-muted { color: var(--text-muted,#9ca3af); font-size: 12px; }

/* Code badges */
.sw-code-badge { background: #ede9fe; color: #5b21b6; padding: 2px 7px; border-radius: 5px; font-size: 12px; font-family: monospace; }
.sw-code-parent { background: #f3f4f6; color: #6b7280; }

/* ── Pager ── */
.es-pager { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px; }
.es-page-btn { background: none; border: 1px solid var(--border,#e5e7eb); border-radius: 6px; padding: 5px 12px; cursor: pointer; font-size: 16px; color: var(--text-primary,#111); }
.es-page-btn:disabled { opacity: .4; cursor: not-allowed; }
.es-page-info { font-size: 13px; color: var(--text-muted,#6b7280); }

/* ── Notification ── */
.notification-panel {
	position: fixed; bottom: 24px; right: 24px; z-index: 9999;
	background: #1f2937; color: #fff;
	padding: 12px 20px; border-radius: 10px;
	font-size: 13px; max-width: 360px;
	transform: translateY(20px); opacity: 0; transition: all .3s;
}
.notif-show   { transform: translateY(0); opacity: 1; }
.notif-success{ background: #065f46; }
.notif-error  { background: #991b1b; }

/* ── Fetch All panel ── */
.sw-fetchall-panel {
	background: var(--bg-card,#fff);
	border: 1px solid var(--border,#e5e7eb);
	border-top: none;
	border-radius: 0 0 12px 12px;
	padding: 14px 20px;
	display: flex;
	flex-direction: column;
	gap: 12px;
}
.sw-fetchall-opts {
	display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.sw-fetchall-optlabel { font-size: 12px; color: var(--text-muted,#6b7280); font-weight: 500; }
.sw-chk-label {
	display: flex; align-items: center; gap: 5px;
	font-size: 13px; color: var(--text-primary,#111); cursor: pointer; user-select: none;
}
.sw-chk-label input[type=checkbox] { cursor: pointer; width: 15px; height: 15px; }
.sw-chk-warn { font-size: 11px; color: #d97706; }
.sw-fetchall-spacer { flex: 1; }
.sw-fetchall-btn {
	display: flex; align-items: center; gap: 7px;
	background: #16a34a; color: #fff; border: none;
	padding: 9px 20px; border-radius: 8px; cursor: pointer;
	font-size: 14px; font-weight: 600; transition: background .15s; white-space: nowrap;
}
.sw-fetchall-btn:hover:not(:disabled) { background: #15803d; }
.sw-fetchall-btn:disabled { opacity: .55; cursor: not-allowed; }

/* Log output */
.sw-fetchall-log {
	border: 1px solid var(--border,#e5e7eb); border-radius: 8px; overflow: hidden;
}
.sw-fal-header {
	display: flex; justify-content: space-between; align-items: center;
	background: var(--bg-thead,#f9fafb); padding: 7px 12px;
	font-size: 12px; font-weight: 600; color: var(--text-muted,#6b7280);
	border-bottom: 1px solid var(--border,#e5e7eb);
}
.sw-fal-clear { background: none; border: none; color: #dc2626; cursor: pointer; font-size: 12px; }
.sw-fal-body {
	background: #0f172a; color: #e2e8f0;
	padding: 10px 14px; font-family: monospace; font-size: 12px; line-height: 1.6;
	max-height: 220px; overflow-y: auto;
}
.sw-fal-line { white-space: pre-wrap; }
.sw-fal-step { color: #86efac; font-weight: 600; }
.sw-fal-err  { color: #fca5a5; }
.sw-fal-waiting { color: #94a3b8; display: flex; align-items: center; gap: 8px; }
.sw-fal-dot {
	width: 8px; height: 8px; border-radius: 50%; background: #38bdf8;
	animation: fadePulse 1s infinite;
}
@keyframes fadePulse { 0%,100%{opacity:1} 50%{opacity:.2} }
.sw-fal-summary {
	padding: 8px 12px; font-size: 13px; font-weight: 600; border-top: 1px solid var(--border,#e5e7eb);
}
.sw-fal-ok   { color: #065f46; background: #d1fae5; }
.sw-fal-fail { color: #991b1b; background: #fee2e2; }

/* Fetch manual collapsible */
.sw-fetch-manual {
	background: var(--bg-card,#fff);
	border: 1px solid var(--border,#e5e7eb);
	border-top: none;
	border-radius: 0 0 10px 10px;
}
.sw-fetch-manual-summary {
	padding: 10px 18px; font-size: 12px; color: var(--text-muted,#6b7280);
	cursor: pointer; user-select: none; list-style: none;
	display: flex; align-items: center; gap: 6px;
}
.sw-fetch-manual-summary::marker,
.sw-fetch-manual-summary::-webkit-details-marker { display: none; }
.sw-fetch-manual-summary::before { content: '\25BA'; font-size: 10px; transition: transform .2s; }
details[open] .sw-fetch-manual-summary::before { transform: rotate(90deg); }
.sw-fetch-manual .sw-fetch-row { border: none; border-top: 1px solid var(--border,#e5e7eb); border-radius: 0; }

/* Sync all button */
.sw-sync-all-btn { background: #0c4a6e; font-weight: 600; }
.sw-sync-all-btn:hover:not(:disabled) { background: #075985; }
.sw-sync-single-btn { background: #0369a1; font-size: 12px; padding: 7px 11px; }
.sw-sync-divider { width: 1px; height: 30px; background: var(--border,#e5e7eb); }
.sw-syncall-result { margin-top: 0; }
.sw-sr-detail { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 6px; }
.sw-sr-badge {
	font-size: 12px; padding: 2px 8px; border-radius: 99px; font-weight: 500;
}
.sw-sr-badge-green  { background: #d1fae5; color: #065f46; }
.sw-sr-badge-yellow { background: #fef3c7; color: #92400e; }
.sw-sr-badge-grey   { background: #f3f4f6; color: #6b7280; }

</style>
