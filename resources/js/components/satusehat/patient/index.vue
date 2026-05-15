<template>
<div class="inner" ref="roottable">
<div class="grid">

	<!-- ── Manual Trigger Panel ───────────────────────────────────────── -->
	<div class="col-12">
		<div class="ps-trigger-panel">
			<div class="ptp-left">
				<div class="ptp-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
				</div>
				<div>
					<div class="ptp-title">Sync Manual</div>
					<div class="ptp-desc">
						Jalankan sinkronisasi sekarang untuk pasien yang belum ter-sync.
						Scheduler otomatis berjalan <strong>setiap jam</strong>.
					</div>
				</div>
			</div>
			<div class="ptp-right">
				<div class="ptp-batch-wrap">
					<label class="ptp-batch-label">Batch per run</label>
					<select v-model="syncBatch" class="ptp-batch-select" :disabled="syncing">
						<option value="10">10 pasien</option>
						<option value="30">30 pasien</option>
						<option value="50">50 pasien</option>
						<option value="100">100 pasien</option>
					</select>
				</div>
				<button class="ptp-run-btn" @click="runSync" :disabled="syncing || statsLoading">
					<svg v-if="!syncing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ptp-btn-icon"><polygon points="5 3 19 12 5 21 5 3"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ptp-btn-icon ptp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ syncing ? 'Sedang berjalan…' : 'Jalankan Sync' }}
				</button>
			</div>
		</div>

		<!-- Result bar -->
		<div class="ps-sync-result" v-if="lastSyncResult">
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
			<button class="psr-close" @click="lastSyncResult = null">✕</button>
		</div>

		<!-- Log output -->
		<div class="ps-sync-log" v-if="lastSyncResult && lastSyncResult.output">
			<div class="psl-header">
				<span>Output log</span>
				<button class="psl-toggle" @click="showLog = !showLog">{{ showLog ? 'Sembunyikan' : 'Tampilkan' }}</button>
			</div>
			<pre class="psl-body" v-if="showLog">{{ lastSyncResult.output }}</pre>
		</div>
	</div>


	<!-- ── Wilayah Warning ─────────────────────────────────────────────── -->
	<div class="col-12" v-if="stats && stats.no_area_code > 0">
		<div class="ps-wilayah-warn">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ps-ww-icon"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
			<div class="ps-ww-body">
				<div class="ps-ww-title">
					<strong>{{ stats.no_area_code.toLocaleString('id-ID') }} pasien</strong> tidak memiliki kode wilayah BPS
				</div>
				<div class="ps-ww-text">
					Pasien-pasien ini akan dikirim ke SatuSehat <em>tanpa</em> <code>address.administrativeCode</code> extension.
					Buka halaman Wilayah, lakukan <strong>Sync ke Master</strong> agar kode BPS terisi otomatis dari relasi wilayah pasien.
				</div>
			</div>
			<div class="ps-ww-actions">
				<button class="ps-ww-btn-ghost" @click="switchTab('no_area_code')">Lihat Pasien</button>
				<a href="/dashboard/satusehat-wilayah" class="ps-ww-link">Buka Wilayah &rarr;</a>
			</div>
		</div>
	</div>

	<!-- ── Stats Cards ─────────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="ps-stats-row" v-if="!statsLoading && stats">

			<div class="ps-stat-card ps-card-blue">
				<div class="psc-top">
					<span class="psc-label">Total Pasien</span>
					<div class="psc-icon psc-icon-blue">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
					</div>
				</div>
				<div class="psc-num">{{ stats.total.toLocaleString('id-ID') }}</div>
				<div class="psc-sub">Seluruh pasien aktif</div>
			</div>

			<div class="ps-stat-card ps-card-green">
				<div class="psc-top">
					<span class="psc-label">Berhasil Sync</span>
					<div class="psc-icon psc-icon-green">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
					</div>
				</div>
				<div class="psc-num">{{ stats.synced.toLocaleString('id-ID') }}</div>
				<div class="psc-bar-wrap">
					<div class="psc-bar psc-bar-green" :style="{ width: stats.pct_synced + '%' }"></div>
				</div>
				<div class="psc-sub">{{ stats.pct_synced }}% dari total</div>
			</div>

			<div class="ps-stat-card ps-card-yellow">
				<div class="psc-top">
					<span class="psc-label">Belum Diproses</span>
					<div class="psc-icon psc-icon-yellow">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
					</div>
				</div>
				<div class="psc-num">{{ stats.pending.toLocaleString('id-ID') }}</div>
				<div class="psc-sub">Akan diproses scheduler berikutnya</div>
			</div>

			<div class="ps-stat-card ps-card-slate">
				<div class="psc-top">
					<span class="psc-label">Tidak Ditemukan</span>
					<div class="psc-icon psc-icon-slate">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
					</div>
				</div>
				<div class="psc-num">{{ stats.not_found.toLocaleString('id-ID') }}</div>
				<div class="psc-sub">NIK tidak terdaftar di SatuSehat</div>
			</div>

			<div class="ps-stat-card ps-card-red">
				<div class="psc-top">
					<span class="psc-label">Gagal (Error)</span>
					<div class="psc-icon psc-icon-red">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					</div>
				</div>
				<div class="psc-num">{{ stats.failed.toLocaleString('id-ID') }}</div>
				<div class="psc-sub">
					<button class="psc-retry-btn" v-if="stats.failed > 0" @click="retryFailed" :disabled="retrying">
						{{ retrying ? 'Memproses…' : 'Reset & Retry' }}
					</button>
					<span v-else>Tidak ada error</span>
				</div>
			</div>

			<div class="ps-stat-card ps-card-orange" @click="switchTab('no_area_code')" style="cursor:pointer" title="Klik untuk filter pasien tanpa kode wilayah">
				<div class="psc-top">
					<span class="psc-label">Tanpa Kode Wilayah</span>
					<div class="psc-icon psc-icon-orange">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/><line x1="2" y1="2" x2="22" y2="22" stroke-width="2"/></svg>
					</div>
				</div>
				<div class="psc-num" :class="stats.no_area_code > 0 ? 'psc-num-warn' : ''">{{ stats.no_area_code.toLocaleString('id-ID') }}</div>
				<div class="psc-sub">
					<span v-if="stats.no_area_code > 0" class="psc-sub-warn">Sync master wilayah diperlukan</span>
					<span v-else class="psc-sub-ok">Semua pasien punya kode</span>
				</div>

				<div class="ps-stat-card ps-card-teal" @click="switchTab('wilayah_complete')" style="cursor:pointer" title="Klik untuk filter pasien dengan wilayah BPS lengkap (4 level)">
					<div class="psc-top">
						<span class="psc-label">Wilayah Lengkap</span>
						<div class="psc-icon psc-icon-teal">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/><polyline points="20 6 9 17 4 12"/></svg>
						</div>
					</div>
					<div class="psc-num" :class="stats.wilayah_complete > 0 ? 'psc-num-teal' : ''">{{ (stats.wilayah_complete || 0).toLocaleString('id-ID') }}</div>
					<div class="psc-sub">
						<span v-if="stats.wilayah_complete > 0" class="psc-sub-teal">P + K + D + V semua terisi</span>
						<span v-else>Belum ada yang lengkap</span>
					</div>
				</div>
			</div>

		</div>

		<!-- Last sync info -->
		<div class="ps-last-sync" v-if="!statsLoading && stats && stats.last_sync">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ps-clock-icon"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			Sync terakhir: <strong>{{ formatDate(stats.last_sync) }}</strong>
			&nbsp;·&nbsp;
			Scheduler: setiap jam otomatis
			&nbsp;·&nbsp;
			<code>php artisan satusehat:sync-patient</code>
		</div>

		<!-- Stats skeleton -->
		<div class="ps-stats-skeleton" v-if="statsLoading">
			<div class="skel" v-for="i in 5" :key="i"></div>
		</div>

		<!-- ── Bulk Create Panel (tampil jika ada not_found) ────────────── -->
		<div class="ps-create-panel" v-if="!statsLoading && stats && stats.not_found > 0">
			<div class="pcp-left">
				<div class="pcp-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
				</div>
				<div>
					<div class="pcp-title">
						<strong>{{ stats.not_found }}</strong> pasien tidak ditemukan di SatuSehat
					</div>
					<div class="pcp-desc">
						Batch hanya memproses pasien yang kode wilayah BPS-nya <strong>sudah lengkap (P+K+D+V)</strong>.
						Pasien tanpa wilayah lengkap dilewati — sync master wilayah terlebih dahulu, atau gunakan <em>Create NIK</em> per baris.
					</div>
				</div>
			</div>
			<div class="pcp-right">
				<div class="pcp-method-wrap">
					<label class="pcp-method-label">Metode</label>
					<select v-model="bulkCreateMethod" class="pcp-method-select" :disabled="bulkCreating">
						<option value="nik">Create by NIK</option>
						<option value="nik_ibu">Create by NIK IBU</option>
					</select>
				</div>
				<div class="pcp-batch-wrap">
					<label class="pcp-method-label">Batch</label>
					<select v-model="bulkCreateBatch" class="pcp-method-select" :disabled="bulkCreating">
						<option value="10">10 pasien</option>
						<option value="20">20 pasien</option>
						<option value="50">50 pasien</option>
					</select>
				</div>
				<button class="pcp-create-btn" @click="createBulk" :disabled="bulkCreating">
					<svg v-if="!bulkCreating" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
					<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spin-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
					{{ bulkCreating ? 'Mendaftarkan…' : 'Daftarkan Batch' }}
				</button>
			</div>
		</div>

		<!-- Bulk create result -->
		<div class="ps-create-result" v-if="bulkCreateResult">
			<div class="pcr-item pcr-green" v-if="bulkCreateResult.created >= 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
				<strong>{{ bulkCreateResult.created }}</strong> berhasil didaftarkan
			</div>
			<div class="pcr-item pcr-red" v-if="bulkCreateResult.failed > 0">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				<strong>{{ bulkCreateResult.failed }}</strong> gagal
			</div>
			<div class="pcr-msg">{{ bulkCreateResult.message }}</div>
			<button class="pcr-close" @click="bulkCreateResult = null">✕</button>
		</div>
		<div class="ps-create-log" v-if="bulkCreateResult && bulkCreateResult.output">
			<div class="pcl-header">
				<span>Output</span>
				<button class="pcl-toggle" @click="showCreateLog = !showCreateLog">{{ showCreateLog ? 'Sembunyikan' : 'Tampilkan' }}</button>
			</div>
			<pre class="pcl-body" v-if="showCreateLog">{{ bulkCreateResult.output }}</pre>
		</div>
	</div>

	<!-- ── Filter & Tabel ──────────────────────────────────────────────── -->
	<div class="col-12">
		<div class="ps-table-card">

			<!-- Toolbar -->
			<div class="ps-toolbar">
				<div class="ps-filter-tabs">
					<button v-for="tab in tabs" :key="tab.key"
						class="ps-tab" :class="{ active: activeTab === tab.key }"
						@click="switchTab(tab.key)">
						{{ tab.label }}
					</button>
				</div>
				<div class="ps-search-wrap">
					<input v-model="search" @keyup.enter="doSearch" type="text"
						placeholder="Cari nama / RM / NIK / IHS…" class="ps-search-input" />
					<button @click="doSearch" class="ps-search-btn">Cari</button>
				</div>
			</div>

			<!-- Table -->
			<div class="ps-table-wrap" v-if="!listLoading">
				<table class="ps-table" v-if="list.length > 0">
					<thead>
						<tr>
							<th>No. RM</th>
							<th>Nama Pasien</th>
							<th>NIK</th>
							<th>ID SatuSehat (IHS)</th>
							<th>Status</th>
							<th>Wilayah BPS</th>
							<th>Waktu Sync</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(row, i) in list" :key="row.uuid">
							<td><code class="rm-code">{{ row.rekam_medis }}</code></td>
							<td class="td-nama">{{ row.nama }}</td>
							<td><code class="nik-code">{{ row.no_identitas || '\u2014' }}</code></td>
							<td>
								<code class="ihs-code" v-if="row.id_satu_sehat">{{ row.id_satu_sehat }}</code>
								<span class="ihs-empty" v-else>\u2014</span>
							</td>
							<td>
								<span class="status-badge" :class="statusClass(row.satusehat_sync_status)">
									{{ statusLabel(row.satusehat_sync_status) }}
								</span>
							</td>
							<!-- Kolom Wilayah BPS: 4 level indicator -->
							<td class="td-wilayah">
								<div class="wlvl-row">
									<span class="wlvl-chip" :class="wilayahChipClass(row, 'province')" :title="wilayahChipTitle(row, 'province')">
										P<span class="wlvl-code" v-if="wilayahEffCode(row,'province')">{{ wilayahEffCode(row,'province') }}</span><span class="wlvl-null" v-else>null</span>
									</span>
									<span class="wlvl-chip" :class="wilayahChipClass(row, 'city')" :title="wilayahChipTitle(row, 'city')">
										K<span class="wlvl-code" v-if="wilayahEffCode(row,'city')">{{ wilayahEffCode(row,'city') }}</span><span class="wlvl-null" v-else>null</span>
									</span>
									<span class="wlvl-chip" :class="wilayahChipClass(row, 'district')" :title="wilayahChipTitle(row, 'district')">
										D<span class="wlvl-code" v-if="wilayahEffCode(row,'district')">{{ wilayahEffCode(row,'district') }}</span><span class="wlvl-null" v-else>null</span>
									</span>
									<span class="wlvl-chip" :class="wilayahChipClass(row, 'village')" :title="wilayahChipTitle(row, 'village')">
										V<span class="wlvl-code" v-if="wilayahEffCode(row,'village')">{{ wilayahEffCode(row,'village') }}</span><span class="wlvl-null" v-else>null</span>
									</span>
								</div>
							</td>
							<td class="td-date">{{ row.satusehat_synced_at ? formatDate(row.satusehat_synced_at) : '\u2014' }}</td>
							<td class="td-action">
								<span v-if="row.id_satu_sehat" class="action-done">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
									Terdaftar
								</span>
								<div v-else class="action-create-wrap">
									<button class="btn-create-nik" :disabled="!!creatingRows[row.uuid]"
										:title="creatingRows[row.uuid] ? 'Sedang diproses...' : 'Daftarkan pasien ke SatuSehat menggunakan NIK'"
										@click="createOne(row, 'nik')">
										<svg v-if="!creatingRows[row.uuid]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
										<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spin-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
										{{ creatingRows[row.uuid] ? '...' : 'Create NIK' }}
									</button>
									<button class="btn-create-nik-ibu" :disabled="!!creatingRows[row.uuid]"
										title="Daftarkan sebagai bayi menggunakan NIK Ibu"
										@click="createOne(row, 'nik_ibu')">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
										NIK IBU
									</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="ps-empty" v-else>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
					<span>Tidak ada data untuk filter ini.</span>
				</div>
			</div>

			<!-- Table skeleton -->
			<div class="ps-table-skeleton" v-if="listLoading">
				<div class="ts-row" v-for="i in 8" :key="i">
					<div class="skel ts-col-sm"></div>
					<div class="skel ts-col-lg"></div>
					<div class="skel ts-col-md"></div>
					<div class="skel ts-col-md"></div>
					<div class="skel ts-col-xs"></div>
					<div class="skel ts-col-sm"></div>
				</div>
			</div>

			<!-- Pagination -->
			<div class="ps-pagination" v-if="!listLoading && totalPages > 1">
				<button class="pg-btn" :disabled="currentPage === 1" @click="gotoPage(currentPage - 1)">‹</button>
				<span class="pg-info">{{ currentPage }} / {{ totalPages }}</span>
				<button class="pg-btn" :disabled="currentPage === totalPages" @click="gotoPage(currentPage + 1)">›</button>
				<span class="pg-total">{{ total.toLocaleString('id-ID') }} data</span>
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
		Loader: defineAsyncComponent(() => import('../../../section/Loader.vue')),
	},
	mounted() {
		vm = this;
		setTimeout(() => { vm.titletrigger(); }, 250);
		vm.loadStats();
		vm.loadList();
	},
	data() {
		return {
			// Manual sync trigger
			syncing: false,
			syncBatch: 30,
			lastSyncResult: null,
			showLog: false,

			// Stats
			stats: null,
			statsLoading: true,
			retrying: false,

			// Per-row create state: { uuid: true/false }
			creatingRows: {},

			// Bulk create
			bulkCreating: false,
			bulkCreateMethod: 'nik',
			bulkCreateBatch: 20,
			bulkCreateResult: null,
			showCreateLog: false,

			// List
			list: [],
			listLoading: true,
			total: 0,
			currentPage: 1,
			perPage: 20,
			search: '',
			activeTab: 'all',

			tabs: [
				{ key: 'all',          label: 'Semua' },
				{ key: 'synced',       label: '✓ Berhasil' },
				{ key: 'pending',      label: '⏳ Pending' },
				{ key: 'failed',       label: '✗ Gagal' },
				{ key: 'not_found',    label: '○ Tidak Ditemukan' },
				{ key: 'no_area_code',      label: '⚠ Wilayah Kosong' },
					{ key: 'wilayah_complete', label: '✓ Wilayah Lengkap' },
			],
		};
	},
	computed: {
		totalPages() { return Math.max(1, Math.ceil(vm.total / vm.perPage)); },
	},
	methods: {
		// ── Manual sync ────────────────────────────────────────────────────
		runSync() {
			vm.syncing        = true;
			vm.lastSyncResult = null;
			vm.showLog        = false;
			const fd = new FormData();
			fd.append('batch', vm.syncBatch);
			axios.post('/satusehat-api/patient-sync/run-sync', fd, {
				headers: { 'Content-Type': 'multipart/form-data' },
				timeout: 300000, // 5 menit
			}).then(r => {
				vm.syncing = false;
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.lastSyncResult = {
					synced:    r.data.synced    ?? 0,
					not_found: r.data.not_found ?? 0,
					failed:    r.data.failed    ?? 0,
					message:   r.data.message   ?? '',
					output:    r.data.output    ?? '',
				};
				if (r.data.data === 'berhasil') {
					vm.notification('Sync selesai dijalankan.', 3500, 'success');
				} else {
					vm.notification('Sync selesai dengan error: ' + (r.data.message ?? ''), 4000, 'error');
				}
				// Reload stats & list setelah sync
				vm.loadStats();
				vm.loadList();
			}).catch(e => {
				vm.syncing = false;
				const msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.notification('Sync gagal: ' + msg, 4500, 'error');
				vm.lastSyncResult = { synced: 0, not_found: 0, failed: 0, message: msg, output: '' };
			});
		},

		// ── API calls ──────────────────────────────────────────────────────
		loadStats() {
			vm.statsLoading = true;
			axios.post('/satusehat-api/patient-sync/dashboard', new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.stats = typeof r.data.data === 'object' ? r.data.data : null;
				vm.statsLoading = false;
			}).catch(() => {
				vm.statsLoading = false;
				vm.notification('Gagal memuat statistik sync.', 3500, 'error');
			});
	
		},

		loadList() {
			vm.listLoading = true;
			const fd = new FormData();
			fd.append('page',   vm.currentPage);
			fd.append('status', vm.activeTab);
			fd.append('search', vm.search);
			axios.post('/satusehat-api/patient-sync/list', fd, {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				setTimeout(() => {
					vm.list        = r.data.data  ?? [];
					vm.total       = r.data.total ?? 0;
					vm.listLoading = false;
				}, 400);
			}).catch(() => {
				vm.listLoading = false;
				vm.notification('Gagal memuat list pasien.', 3500, 'error');
			});
		},

		retryFailed() {
			vm.retrying = true;
			axios.post('/satusehat-api/patient-sync/retry-failed', new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				vm.retrying = false;
				if (r.data.data === 'berhasil') {
					vm.notification(`${r.data.count} pasien gagal direset — akan diproses ulang oleh scheduler.`, 4000, 'success');
					vm.loadStats();
					if (vm.activeTab === 'failed') vm.loadList();
				}
			}).catch(() => {
				vm.retrying = false;
				vm.notification('Gagal mereset data.', 3000, 'error');
			});
		},

		// ── Create per-row ────────────────────────────────────────────────
		createOne(row, method) {
			if (vm.creatingRows[row.uuid]) return;
			vm.creatingRows = { ...vm.creatingRows, [row.uuid]: true };

			const fd = new FormData();
			fd.append('uuid',   row.uuid);
			fd.append('method', method);

			axios.post('/satusehat-api/patient-sync/create-one', fd, {
				headers: { 'Content-Type': 'multipart/form-data' },
				timeout: 60000,
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				if (r.data.data === 'berhasil') {
					// Update baris langsung
					const idx = vm.list.findIndex(i => i.uuid === row.uuid);
					if (idx !== -1) {
						vm.list[idx].id_satu_sehat          = r.data.id_satu_sehat;
						vm.list[idx].satusehat_sync_status  = 'synced';
						vm.list[idx].satusehat_synced_at    = new Date().toISOString();
					}
					vm.notification(r.data.message || 'Pasien berhasil didaftarkan.', 4000, 'success');
					vm.loadStats();
				} else {
					vm.notification('Gagal: ' + (r.data.message || 'Unknown error'), 5000, 'error');
				}
			}).catch(e => {
				const msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.notification('Gagal mendaftarkan pasien: ' + msg, 5000, 'error');
			}).finally(() => {
				vm.creatingRows = { ...vm.creatingRows, [row.uuid]: false };
			});
		},

		// ── Bulk create (not_found) ────────────────────────────────────────
		createBulk() {
			if (vm.bulkCreating) return;
			vm.bulkCreating     = true;
			vm.bulkCreateResult = null;
			vm.showCreateLog    = false;

			const fd = new FormData();
			fd.append('method', vm.bulkCreateMethod);
			fd.append('batch',  vm.bulkCreateBatch);

			axios.post('/satusehat-api/patient-sync/create-bulk', fd, {
				headers: { 'Content-Type': 'multipart/form-data' },
				timeout: 300000,
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				vm.bulkCreateResult = r.data;
				if (r.data.created > 0) {
					vm.notification(`${r.data.created} pasien berhasil didaftarkan ke SatuSehat.`, 4500, 'success');
				} else {
					vm.notification(r.data.message || 'Tidak ada yang diproses.', 3500, 'error');
				}
				vm.loadStats();
				vm.loadList();
			}).catch(e => {
				const msg = e?.response?.data?.message ?? e?.message ?? 'Terjadi kesalahan.';
				vm.notification('Bulk create gagal: ' + msg, 5000, 'error');
				vm.bulkCreateResult = { created: 0, failed: 0, message: msg, output: '' };
			}).finally(() => {
				vm.bulkCreating = false;
			});
		},

		// ── UI helpers ─────────────────────────────────────────────────────
		switchTab(key) {
			vm.activeTab   = key;
			vm.currentPage = 1;
			vm.loadList();
		},

		doSearch() {
			vm.currentPage = 1;
			vm.loadList();
		},

		gotoPage(p) {
			vm.currentPage = p;
			vm.loadList();
		},

		statusLabel(s) {
			const m = { synced: 'Berhasil', not_found: 'Tidak Ditemukan', failed: 'Gagal', pending: 'Pending' };
			return m[s] ?? 'Pending';
		},

		// ── Wilayah chip helpers ───────────────────────────────────────────
		wilayahEffCode(row, level) {
			// Kode BPS diambil langsung dari tabel master wilayah via FK
			switch (level) {
				case 'province': return row.master_province_code    || null;
				case 'city':     return row.master_city_code        || null;
				case 'district': return row.master_district_code    || null;
				case 'village':  return row.master_subdistrict_code || null;
			}
			return null;
		},

		wilayahChipClass(row, level) {
			return vm.wilayahEffCode(row, level) ? 'wlvl-ok' : 'wlvl-missing';
		},

		wilayahChipTitle(row, level) {
			const code = vm.wilayahEffCode(row, level);
			const names = {
				province: row.nama_provinsi  || '',
				city:     row.nama_kab_kota  || '',
				district: row.nama_kecamatan || '',
				village:  row.nama_kelurahan || '',
			};
			const levelLabels = { province: 'Provinsi', city: 'Kota/Kab', district: 'Kecamatan', village: 'Kelurahan' };
			const lbl  = levelLabels[level];
			const nama = names[level];

			if (code) return lbl + ': ' + code + (nama ? ' (' + nama + ')' : '') + ' [dari master wilayah]';
			return lbl + (nama ? ' (' + nama + ')' : '') + ': belum ada kode BPS — sync master wilayah terlebih dahulu';
		},

		statusClass(s) {
			const m = { synced: 'badge-synced', not_found: 'badge-notfound', failed: 'badge-failed' };
			return m[s] ?? 'badge-pending';
		},

		formatDate(iso) {
			if (!iso) return '—';
			try {
				return new Date(iso).toLocaleString('id-ID', {
					day: '2-digit', month: 'short', year: 'numeric',
					hour: '2-digit', minute: '2-digit'
				});
			} catch { return iso; }
		},

		firstloader()  { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		notification(message, timer, position) { if (position === 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		titletrigger() { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); },
		loadPatch()    { vm.firstloader(); },
		unloadPatch(position) { vm.firstloader(); if (position === 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else { vm.notification('Data gagal dipatch.', 3000, 'error'); } },
	},
}
</script>

<style scoped>
/* ── Manual Trigger Panel ──────────────────────────────────────────────── */
.ps-trigger-panel {
	display: flex; align-items: center; justify-content: space-between;
	gap: 16px; flex-wrap: wrap;
	background: #fff;
	border: 1px solid #e2e8f0;
	border-left: 4px solid #1c84ee;
	border-radius: 10px;
	padding: 16px 20px;
	margin-bottom: 14px;
	box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
/* ── Wilayah warning ── */
.ps-wilayah-warn {
	display: flex; align-items: flex-start; gap: 12px;
	background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 14px 18px;
}
.ps-ww-icon { width: 20px; height: 20px; stroke: #d97706; flex-shrink: 0; margin-top: 2px; }
.ps-ww-body { flex: 1; }
.ps-ww-title { font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 4px; }
.ps-ww-text  { font-size: 13px; color: #78350f; line-height: 1.5; }
.ps-ww-text code { background: #fef3c7; padding: 1px 5px; border-radius: 3px; font-size: 12px; }
.ps-ww-link {
	white-space: nowrap; align-self: center;
	background: #d97706; color: #fff; text-decoration: none;
	padding: 7px 14px; border-radius: 7px; font-size: 13px; font-weight: 500;
}
.ps-ww-link:hover { background: #b45309; }

.ptp-left { display: flex; align-items: center; gap: 14px; }
.ptp-icon {
	width: 40px; height: 40px; border-radius: 10px;
	background: #dbeafe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ptp-icon svg { width: 20px; height: 20px; stroke: #1d4ed8; }
.ptp-title { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 3px; }
.ptp-desc  { font-size: 12px; color: #64748b; }

.ptp-right { display: flex; align-items: center; gap: 10px; }
.ptp-batch-label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; display: block; margin-bottom: 3px; }
.ptp-batch-select {
	padding: 6px 10px; border: 1px solid #e2e8f0; border-radius: 6px;
	font-size: 12px; color: #334155; background: #f8fafc; outline: none;
}
.ptp-batch-select:focus { border-color: #1c84ee; }

.ptp-run-btn {
	display: flex; align-items: center; gap: 8px;
	padding: 9px 20px; background: #1c84ee; color: #fff;
	border: none; border-radius: 8px; font-size: 13px; font-weight: 700;
	cursor: pointer; transition: background .15s, opacity .15s;
	white-space: nowrap;
}
.ptp-run-btn:hover:not(:disabled) { background: #1264b3; }
.ptp-run-btn:disabled { opacity: .65; cursor: not-allowed; }
.ptp-btn-icon { width: 14px; height: 14px; flex-shrink: 0; }
.ptp-spin { animation: spin 1s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

/* Result bar */
.ps-sync-result {
	display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
	padding: 10px 16px; background: #f8fafc;
	border: 1px solid #e2e8f0; border-radius: 8px;
	margin-bottom: 10px; font-size: 13px;
}
.psr-item { display: flex; align-items: center; gap: 5px; }
.psr-item svg { width: 14px; height: 14px; flex-shrink: 0; }
.psr-green { color: #16a34a; } .psr-green svg { stroke: #16a34a; }
.psr-slate { color: #475569; } .psr-slate svg { stroke: #475569; }
.psr-red   { color: #dc2626; } .psr-red   svg { stroke: #dc2626; }
.psr-msg   { font-size: 12px; color: #94a3b8; margin-left: auto; }
.psr-close { background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 14px; padding: 0 4px; }
.psr-close:hover { color: #475569; }

/* Log output */
.ps-sync-log {
	border: 1px solid #e2e8f0; border-radius: 8px;
	overflow: hidden; margin-bottom: 14px;
}
.psl-header {
	display: flex; align-items: center; justify-content: space-between;
	padding: 8px 14px; background: #f1f5f9; font-size: 12px; color: #64748b; font-weight: 600;
}
.psl-toggle { background: none; border: none; color: #1c84ee; font-size: 12px; cursor: pointer; font-weight: 600; }
.psl-body {
	margin: 0; padding: 12px 16px;
	background: #0f172a; color: #94a3b8;
	font-family: monospace; font-size: 11px; line-height: 1.6;
	white-space: pre-wrap; max-height: 260px; overflow-y: auto;
}

/* ── Stat Cards ────────────────────────────────────────────────────────── */
.ps-stats-row {
	display: flex;
	gap: 14px;
	flex-wrap: wrap;
	margin-bottom: 10px;
}
.ps-stat-card {
	flex: 1;
	min-width: 160px;
	background: #fff;
	border-radius: 10px;
	border: 1px solid #e2e8f0;
	padding: 16px 18px;
	box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.psc-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.psc-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #94a3b8; }
.psc-icon  { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
.psc-icon svg { width: 16px; height: 16px; }
.psc-icon-blue   { background: #dbeafe; color: #1d4ed8; }
.psc-icon-green  { background: #dcfce7; color: #16a34a; }
.psc-icon-yellow { background: #fef9c3; color: #ca8a04; }
.psc-icon-slate  { background: #f1f5f9; color: #475569; }
.psc-icon-red    { background: #fee2e2; color: #dc2626; }

.psc-num { font-size: 28px; font-weight: 800; color: #1e293b; line-height: 1; margin-bottom: 6px; }
.psc-sub { font-size: 11px; color: #94a3b8; }

.psc-bar-wrap { height: 4px; background: #f1f5f9; border-radius: 2px; margin: 6px 0; }
.psc-bar { height: 4px; border-radius: 2px; transition: width .4s; }
.psc-bar-green { background: #22c55e; }

.psc-retry-btn {
	background: #fee2e2; color: #dc2626; border: none;
	border-radius: 4px; padding: 2px 8px; font-size: 11px; font-weight: 600;
	cursor: pointer; transition: background .15s;
}
.psc-retry-btn:hover:not(:disabled) { background: #fca5a5; }
.psc-retry-btn:disabled { opacity: .6; cursor: not-allowed; }

/* Stats skeleton */
.ps-stats-skeleton { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 10px; }
.ps-stats-skeleton .skel { flex: 1; min-width: 160px; height: 100px; border-radius: 10px; }

/* Last sync info */
.ps-last-sync {
	display: flex; align-items: center; gap: 6px;
	font-size: 12px; color: #64748b;
	margin-bottom: 16px;
	padding: 8px 12px;
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 8px;
}
.ps-clock-icon { width: 14px; height: 14px; color: #94a3b8; flex-shrink: 0; }
.ps-last-sync code { background: #e2e8f0; padding: 1px 6px; border-radius: 4px; font-size: 11px; }

/* ── Table Card ─────────────────────────────────────────────────────────── */
.ps-table-card {
	background: #fff;
	border: 1px solid #e2e8f0;
	border-radius: 10px;
	overflow: hidden;
	box-shadow: 0 1px 3px rgba(0,0,0,.04);
}

/* Toolbar */
.ps-toolbar {
	display: flex; align-items: center; justify-content: space-between;
	padding: 14px 18px; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 10px;
}
.ps-filter-tabs { display: flex; gap: 4px; flex-wrap: wrap; }
.ps-tab {
	padding: 5px 12px; border-radius: 6px; border: 1px solid #e2e8f0;
	background: #f8fafc; font-size: 12px; font-weight: 500; color: #475569;
	cursor: pointer; transition: all .15s;
}
.ps-tab.active { background: #1c84ee; color: #fff; border-color: #1c84ee; }
.ps-tab:hover:not(.active) { background: #f1f5f9; }

.ps-search-wrap { display: flex; gap: 6px; }
.ps-search-input {
	padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 6px;
	font-size: 12px; color: #334155; width: 220px; outline: none;
}
.ps-search-input:focus { border-color: #1c84ee; }
.ps-search-btn {
	padding: 6px 14px; background: #1c84ee; color: #fff;
	border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;
}
.ps-search-btn:hover { background: #1264b3; }

/* Table */
.ps-table-wrap { overflow-x: auto; }
.ps-table { width: 100%; border-collapse: collapse; }
.ps-table th {
	padding: 10px 14px; font-size: 11px; font-weight: 700;
	text-transform: uppercase; letter-spacing: .4px; color: #94a3b8;
	background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;
}
.ps-table td {
	padding: 10px 14px; font-size: 13px; color: #334155;
	border-bottom: 1px solid #f1f5f9; vertical-align: middle;
}
.ps-table tr:last-child td { border-bottom: none; }
.ps-table tr:hover td { background: #f8fafc; }

.rm-code  { font-family: monospace; font-size: 12px; color: #1c84ee; }
.nik-code { font-family: monospace; font-size: 12px; color: #334155; }
.ihs-code { font-family: monospace; font-size: 12px; font-weight: 700; color: #16a34a; }
.ihs-empty { color: #cbd5e1; }
.td-nama  { font-weight: 500; }
.td-date  { font-size: 12px; color: #64748b; white-space: nowrap; }

/* Status badges */
.status-badge {
	display: inline-block; padding: 2px 8px;
	border-radius: 20px; font-size: 11px; font-weight: 700;
}
.badge-synced   { background: #dcfce7; color: #16a34a; }
.badge-notfound { background: #f1f5f9; color: #64748b; }
.badge-failed   { background: #fee2e2; color: #dc2626; }
.badge-pending  { background: #fef9c3; color: #ca8a04; }

/* Empty state */
.ps-empty {
	display: flex; align-items: center; gap: 10px;
	padding: 40px; justify-content: center; color: #94a3b8;
}
.ps-empty svg { width: 20px; height: 20px; }

/* Table skeleton */
.ps-table-skeleton { padding: 12px 18px; }
.ts-row { display: flex; gap: 12px; margin-bottom: 12px; align-items: center; }
.ts-col-xs  { height: 16px; width: 50px; }
.ts-col-sm  { height: 16px; width: 90px; }
.ts-col-md  { height: 16px; width: 130px; }
.ts-col-lg  { height: 16px; flex: 1; }

/* Pagination */
.ps-pagination {
	display: flex; align-items: center; gap: 8px;
	padding: 12px 18px; border-top: 1px solid #f1f5f9;
}
.pg-btn {
	width: 28px; height: 28px; border: 1px solid #e2e8f0;
	border-radius: 6px; background: #fff; cursor: pointer; font-size: 16px;
	display: flex; align-items: center; justify-content: center; color: #475569;
}
.pg-btn:hover:not(:disabled) { background: #f1f5f9; }
.pg-btn:disabled { opacity: .4; cursor: not-allowed; }
.pg-info  { font-size: 13px; color: #334155; font-weight: 500; }
.pg-total { font-size: 12px; color: #94a3b8; margin-left: auto; }

/* Shared skeleton */
.skel {
	background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
	background-size: 200% 100%;
	animation: shimmer 1.4s infinite;
	border-radius: 6px;
}
@keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }

/* ── Bulk Create Panel ─────────────────────────────────────────────────── */
.ps-create-panel {
	display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;
	background: #fffbeb; border: 1px solid #fde68a; border-left: 4px solid #f59e0b;
	border-radius: 10px; padding: 14px 18px; margin-top: 10px;
}
.pcp-left  { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 240px; }
.pcp-icon  { width: 36px; height: 36px; background: #fef3c7; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.pcp-icon svg { width: 18px; height: 18px; stroke: #d97706; }
.pcp-title { font-size: 13px; font-weight: 600; color: #92400e; margin-bottom: 3px; }
.pcp-desc  { font-size: 12px; color: #b45309; line-height: 1.4; }
.pcp-right { display: flex; align-items: flex-end; gap: 10px; flex-wrap: wrap; }
.pcp-method-wrap, .pcp-batch-wrap { display: flex; flex-direction: column; gap: 3px; }
.pcp-method-label { font-size: 10px; font-weight: 600; color: #92400e; text-transform: uppercase; letter-spacing: .4px; }
.pcp-method-select { padding: 6px 10px; border: 1px solid #fcd34d; border-radius: 6px; font-size: 12px; background: #fffbeb; color: #78350f; outline: none; cursor: pointer; }
.pcp-create-btn {
	display: flex; align-items: center; gap: 6px;
	padding: 8px 16px; background: #f59e0b; color: #fff;
	border: none; border-radius: 8px; font-size: 13px; font-weight: 700;
	cursor: pointer; transition: background .15s; white-space: nowrap;
}
.pcp-create-btn:hover:not(:disabled) { background: #d97706; }
.pcp-create-btn:disabled { opacity: .6; cursor: not-allowed; }
.pcp-create-btn svg { width: 14px; height: 14px; }

/* ── Bulk create result ─────────────────────────────────────────────────── */
.ps-create-result { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 8px 14px; background: #f8fafc; border-radius: 8px; margin-top: 6px; font-size: 13px; }
.pcr-item { display: flex; align-items: center; gap: 5px; font-size: 13px; }
.pcr-item svg { width: 13px; height: 13px; }
.pcr-green { color: #16a34a; }
.pcr-red   { color: #dc2626; }
.pcr-msg   { color: #475569; font-style: italic; flex: 1; min-width: 100px; }
.pcr-close { margin-left: auto; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 13px; padding: 2px 5px; border-radius: 4px; }
.pcr-close:hover { background: #e2e8f0; }
.ps-create-log  { margin-top: 6px; background: #0f172a; border-radius: 8px; overflow: hidden; }
.pcl-header     { display: flex; justify-content: space-between; align-items: center; padding: 7px 12px; border-bottom: 1px solid rgba(255,255,255,.08); }
.pcl-header span { font-size: 11px; color: #94a3b8; }
.pcl-toggle     { background: none; border: none; color: #f59e0b; font-size: 11px; cursor: pointer; padding: 2px 6px; }
.pcl-body       { margin: 0; padding: 10px 12px; font-size: 11px; color: #a3e635; font-family: monospace; line-height: 1.6; white-space: pre-wrap; max-height: 200px; overflow-y: auto; }

/* ── Table action column ───────────────────────────────────────────────── */
.td-action { white-space: nowrap; }
.action-done { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; color: #16a34a; }
.action-done svg { width: 12px; height: 12px; }
.action-create-wrap { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.wilayah-badge {
	display: inline-flex; align-items: center; gap: 3px;
	font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;
	cursor: default; white-space: nowrap; line-height: 1.3;
}
.wilayah-ok      { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
.wilayah-missing { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.btn-create-nik {
	display: inline-flex; align-items: center; gap: 4px;
	padding: 4px 10px; font-size: 11px; font-weight: 700;
	background: #dcfce7; color: #166534; border: 1px solid #86efac;
	border-radius: 6px; cursor: pointer; transition: all .15s; white-space: nowrap;
}
.btn-create-nik:hover:not(:disabled) { background: #bbf7d0; }
.btn-create-nik:disabled { opacity: .5; cursor: not-allowed; }
.btn-create-nik svg { width: 11px; height: 11px; }
.btn-create-nik-ibu {
	display: inline-flex; align-items: center; gap: 4px;
	padding: 4px 9px; font-size: 11px; font-weight: 700;
	background: #fce7f3; color: #9d174d; border: 1px solid #f9a8d4;
	border-radius: 6px; cursor: pointer; transition: all .15s; white-space: nowrap;
}
.btn-create-nik-ibu:hover:not(:disabled) { background: #fbcfe8; }
.btn-create-nik-ibu:disabled { opacity: .5; cursor: not-allowed; }
.btn-create-nik-ibu svg { width: 11px; height: 11px; }
@keyframes spin { to { transform: rotate(360deg); } }
.spin-icon { animation: spin .8s linear infinite; }

/* ── Wilayah warning actions ── */
.ps-ww-actions { display: flex; flex-direction: column; gap: 6px; align-items: flex-end; flex-shrink: 0; }
.ps-ww-btn-ghost {
	background: transparent; border: 1px solid #d97706; color: #92400e;
	padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
	cursor: pointer; white-space: nowrap; transition: background .15s;
}
.ps-ww-btn-ghost:hover { background: #fef3c7; }

/* No-area-code stat card */
.ps-card-orange { border-left: 3px solid #ea580c; }
.psc-icon-orange { background: #ffedd5; }
.psc-icon-orange svg { stroke: #ea580c; }
.psc-num-warn { color: #ea580c; }
.psc-sub-warn { color: #c2410c; font-weight: 600; }
.psc-sub-ok   { color: #16a34a; }

/* Wilayah-complete stat card */
.ps-card-teal { border-left: 3px solid #0d9488; }
.psc-icon-teal { background: #ccfbf1; }
.psc-icon-teal svg { stroke: #0d9488; }
.psc-num-teal  { color: #0f766e; }
.psc-sub-teal  { color: #0f766e; font-weight: 600; }


/* ── Wilayah level chips ── */
.td-wilayah { white-space: nowrap; }
.wlvl-row   { display: flex; gap: 3px; align-items: center; flex-wrap: nowrap; }
.wlvl-chip  {
	display: inline-flex; align-items: center; gap: 2px;
	font-size: 10px; font-weight: 700; padding: 2px 5px;
	border-radius: 4px; cursor: default; line-height: 1.3;
	font-family: monospace; white-space: nowrap;
}
.wlvl-ok           { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.wlvl-missing      { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.wlvl-code  { font-size: 9px; opacity: .8; margin-left: 1px; }
.wlvl-null  { font-size: 9px; font-style: italic; opacity: .75; }

</style>
