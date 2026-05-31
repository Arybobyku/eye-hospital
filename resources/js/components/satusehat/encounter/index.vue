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
				<div class="esc-sub">{{ dateFrom === dateTo ? dateFrom : dateFrom + ' s/d ' + dateTo }}</div>
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
				<div class="es-toolbar-right">
					<!-- Date range picker — default bulan ini -->
					<div class="es-daterange-wrap">
						<div class="es-dr-group">
							<label class="es-date-label">Dari</label>
							<input v-model="dateFrom" type="date" class="es-date-input" @change="onRangeChange" />
						</div>
						<span class="es-dr-sep">—</span>
						<div class="es-dr-group">
							<label class="es-date-label">Sampai</label>
							<input v-model="dateTo" type="date" class="es-date-input" @change="onRangeChange" />
						</div>
						<!-- Shortcut buttons -->
						<div class="es-dr-shortcuts">
							<button class="es-dr-sc" @click="setRange('today')">Hari ini</button>
							<button class="es-dr-sc" @click="setRange('week')">Minggu ini</button>
							<button class="es-dr-sc" @click="setRange('month')">Bulan ini</button>
						</div>
					</div>
					<div class="es-search-wrap">
						<input v-model="search" @keyup.enter="doSearch" type="text"
							placeholder="Cari nama / nomor / dokter / encounter ID…" class="es-search-input" />
						<button @click="doSearch" class="es-search-btn">Cari</button>
					</div>
				</div>
			</div>

			<!-- Table -->
			<div class="es-table-wrap" v-if="!listLoading">
				<table class="es-table" v-if="list.length > 0">
					<thead>
						<tr>
							<th class="es-th-toggle"></th>
							<th>No. Registrasi</th>
							<th>Nama Pasien</th>
							<th>Dokter / Poli</th>
							<th>Tgl Kunjungan</th>
							<th>Encounter ID</th>
							<th>Status Sync</th>
							<th>Status FHIR</th>
							<th class="es-th-cp">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="es-th-cp-icon"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
								CarePlan Kontrol
							</th>
							<th>Waktu Sync</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="row in list" :key="row.id">
						<!-- ── Main row ── -->
						<tr :class="{ 'es-row-syncing': syncingRows[row.uuid], 'es-row-expanded': expandedRows[row.uuid] }">
							<td class="es-td-toggle">
								<button
									v-if="row.satusehat_encounter_status === 'synced' && row.satusehat_encounter_id"
									class="es-toggle-btn"
									:class="{ active: expandedRows[row.uuid] }"
									@click="toggleDetail(row)"
									:title="expandedRows[row.uuid] ? 'Tutup detail' : 'Lihat detail Encounter'">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
								</button>
							</td>
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
							<td class="es-td-sm">
								<div>{{ row.nama_dokter || '-' }}</div>
								<div class="es-td-poli" v-if="row.ruang_poliklinik">{{ row.ruang_poliklinik }}</div>
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
							<!-- Status Sync (proses teknis) -->
							<td>
								<span class="es-badge" :class="statusBadgeClass(row.satusehat_encounter_status)">
									{{ statusLabel(row.satusehat_encounter_status, row.patient_ihs_id) }}
								</span>
							</td>
							<!-- Status FHIR (klinis) -->
							<td>
								<div v-if="row.satusehat_encounter_id" class="es-fhir-status-wrap">
									<span class="es-fhir-badge" :class="fhirStatusClass(row.satusehat_encounter_fhir_status)">
										{{ fhirStatusLabel(row.satusehat_encounter_fhir_status) }}
									</span>
									<button class="es-fhir-edit-btn"
										:disabled="updatingFhirRows[row.uuid]"
										@click="openStatusModal(row)"
										title="Ubah status FHIR Encounter">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
									</button>
								</div>
								<span v-else class="es-no-id">—</span>
							</td>
							<!-- CarePlan Kontrol -->
							<td class="es-td-cp">
								<!-- Sudah synced -->
								<div v-if="row.satusehat_careplan_kontrol_status === 'synced'" class="es-cp-wrap">
									<span class="es-cp-badge es-cp-synced">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
										Terkirim
									</span>
									<div class="es-cp-id" v-if="row.satusehat_careplan_kontrol_id">
										{{ row.satusehat_careplan_kontrol_id.substring(0, 12) }}…
									</div>
									<div class="es-cp-date" v-if="row.tanggal_kontrol_selanjutnya">
										Kontrol: {{ formatDateShort(row.tanggal_kontrol_selanjutnya) }}
									</div>
								</div>
								<!-- Gagal -->
								<div v-else-if="row.satusehat_careplan_kontrol_status === 'failed'" class="es-cp-wrap">
									<span class="es-cp-badge es-cp-failed">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
										Gagal
									</span>
									<div class="es-cp-date" v-if="row.tanggal_kontrol_selanjutnya">
										Kontrol: {{ formatDateShort(row.tanggal_kontrol_selanjutnya) }}
									</div>
								</div>
								<!-- Waiting -->
								<div v-else-if="row.satusehat_careplan_kontrol_status === 'waiting_encounter' || row.satusehat_careplan_kontrol_status === 'waiting_patient'" class="es-cp-wrap">
									<span class="es-cp-badge es-cp-waiting">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
										Menunggu
									</span>
								</div>
								<!-- Ada tanggal kontrol tapi belum sync -->
								<div v-else-if="row.tanggal_kontrol_selanjutnya" class="es-cp-wrap">
									<span class="es-cp-badge es-cp-pending">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
										Perlu Sync
									</span>
									<div class="es-cp-date">
										Kontrol: {{ formatDateShort(row.tanggal_kontrol_selanjutnya) }}
									</div>
								</div>
								<!-- Tidak ada jadwal kontrol -->
								<span v-else class="es-no-id">—</span>
							</td>
							<td class="es-td-sm">
								<span v-if="row.satusehat_encounter_synced_at">{{ formatDate(row.satusehat_encounter_synced_at) }}</span>
								<span v-else class="es-no-id">—</span>
							</td>
							<td class="es-td-action">
								<div class="es-action-group">
									<!-- Tombol sync — hanya jika belum synced -->
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
									<!-- Sudah synced -->
									<span v-else class="es-synced-label">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
										Terkirim
									</span>
									<!-- Tombol history -->
									<button v-if="row.satusehat_encounter_id"
										class="es-hist-btn"
										@click="openHistoryModal(row)"
										title="Lihat riwayat status">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									</button>
								</div>
							</td>
						</tr>
						<!-- ── Expandable detail row ── -->
						<tr v-if="expandedRows[row.uuid]" class="es-detail-row">
							<td colspan="11" class="es-detail-td">
								<!-- Loading -->
								<div v-if="detailData[row.uuid] && detailData[row.uuid].loading" class="es-dp-loading">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin es-dp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
									Memuat detail encounter dari SatuSehat…
								</div>
								<!-- Error -->
								<div v-else-if="detailData[row.uuid] && detailData[row.uuid].error" class="es-dp-error">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
									{{ detailData[row.uuid].error }}
								</div>
								<!-- Detail panel -->
								<div v-else-if="detailData[row.uuid] && detailData[row.uuid].data" class="es-detail-panel">
									<div class="es-dp-header">
										<span class="es-dp-res-type">{{ detailData[row.uuid].data.resourceType }}</span>
										<span class="es-dp-id">ID: {{ detailData[row.uuid].data.id }}</span>
										<span class="es-fhir-badge" :class="fhirStatusClass(detailData[row.uuid].data.status)">
											{{ fhirStatusLabel(detailData[row.uuid].data.status) }}
										</span>
										<span class="es-dp-ver" v-if="detailData[row.uuid].data.meta">
											v{{ detailData[row.uuid].data.meta.versionId }}
											· {{ formatDate(detailData[row.uuid].data.meta.lastUpdated) }}
										</span>
										<!-- Tombol Check Conditions -->
										<button
											class="es-dp-cond-btn"
											:disabled="conditionsData[row.uuid] && conditionsData[row.uuid].loading"
											@click="checkConditions(row)"
											title="Ambil daftar Condition dari SatuSehat untuk encounter ini">
											<svg v-if="!(conditionsData[row.uuid] && conditionsData[row.uuid].loading)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
											<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
											{{ (conditionsData[row.uuid] && conditionsData[row.uuid].loading) ? 'Memuat…' : 'Cek Conditions' }}
										</button>
										<!-- Tombol Check Observations (CPPT) -->
										<button
											class="es-dp-obs-btn"
											:disabled="observationsData[row.uuid] && observationsData[row.uuid].loading"
											@click="checkObservations(row)"
											title="Ambil daftar Observation CPPT dari SatuSehat untuk encounter ini">
											<svg v-if="!(observationsData[row.uuid] && observationsData[row.uuid].loading)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
											<svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
											{{ (observationsData[row.uuid] && observationsData[row.uuid].loading) ? 'Memuat…' : 'Cek Observations' }}
										</button>
									</div>

									<!-- ── Conditions Section ── -->
									<div v-if="conditionsData[row.uuid]" class="es-dp-conditions">
										<div v-if="conditionsData[row.uuid].loading" class="es-dp-cond-state">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
											Memuat Conditions dari SatuSehat…
										</div>
										<div v-else-if="conditionsData[row.uuid].error" class="es-dp-cond-state es-dp-cond-state-err">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
											{{ conditionsData[row.uuid].error }}
										</div>
										<div v-else-if="!conditionsData[row.uuid].conditions || conditionsData[row.uuid].conditions.length === 0" class="es-dp-cond-state es-dp-cond-state-empty">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
											Tidak ada Condition untuk encounter ini di SatuSehat.
										</div>
										<div v-else class="es-dp-cond-list">
											<div class="es-dp-cond-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
												Conditions ({{ conditionsData[row.uuid].conditions.length }} diagnosis ditemukan)
											</div>
											<div v-for="(cond, ci) in conditionsData[row.uuid].conditions" :key="ci" class="es-dp-cond-item">
												<div class="es-dp-cond-left">
													<span class="es-dp-cond-code">{{ cond.kode_icd || '—' }}</span>
													<span class="es-dp-cond-display">{{ cond.display_icd || '—' }}</span>
												</div>
												<div class="es-dp-cond-right">
													<span class="es-dp-cond-cs" :class="cond.clinical_status === 'active' ? 'es-cond-active' : 'es-cond-inactive'">
														{{ cond.clinical_status || '—' }}
													</span>
													<span class="es-dp-cond-cat" v-if="cond.category_display">{{ cond.category_display }}</span>
													<span class="es-dp-cond-mono">{{ cond.id }}</span>
													<span class="es-dp-cond-ts" v-if="cond.last_updated">{{ formatDate(cond.last_updated) }}</span>
												</div>
											</div>
										</div>
									</div>

									<!-- ── Observations Section (CPPT) ── -->
									<div v-if="observationsData[row.uuid]" class="es-dp-observations">
										<div v-if="observationsData[row.uuid].loading" class="es-dp-cond-state">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
											Memuat Observations dari SatuSehat…
										</div>
										<div v-else-if="observationsData[row.uuid].error" class="es-dp-cond-state es-dp-cond-state-err">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
											{{ observationsData[row.uuid].error }}
										</div>
										<template v-else>
											<!-- Status CPPT lokal -->
											<div v-if="observationsData[row.uuid].cppt_local && observationsData[row.uuid].cppt_local.length" class="es-dp-obs-local">
												<div class="es-dp-cond-title">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
													CPPT Lokal ({{ observationsData[row.uuid].cppt_local.length }} entri dengan asesmen)
												</div>
												<div v-for="(cppt, ci) in observationsData[row.uuid].cppt_local" :key="'cppt-'+ci" class="es-dp-obs-local-item">
													<span class="es-dp-obs-sebagai">{{ cppt.sebagai || '—' }}</span>
													<span class="es-dp-obs-nama">{{ cppt.nama_dokter || cppt.nama_pengguna || '—' }}</span>
													<span class="es-obs-status-badge" :class="obsStatusClass(cppt.satusehat_observation_status)">
														{{ obsStatusLabel(cppt.satusehat_observation_status) }}
													</span>
													<span class="es-dp-cond-mono es-dp-obs-id" v-if="cppt.satusehat_observation_id" :title="cppt.satusehat_observation_id">
														{{ cppt.satusehat_observation_id.substring(0, 14) }}…
													</span>
													<span class="es-dp-cond-ts" v-if="cppt.satusehat_observation_synced_at">
														{{ formatDate(cppt.satusehat_observation_synced_at) }}
													</span>
												</div>
											</div>
											<!-- Observations dari SatuSehat -->
											<div v-if="!observationsData[row.uuid].observations || observationsData[row.uuid].observations.length === 0" class="es-dp-cond-state es-dp-cond-state-empty">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
												Tidak ada Observation untuk encounter ini di SatuSehat.
											</div>
											<div v-else class="es-dp-cond-list">
												<div class="es-dp-cond-title">
													<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
													Observations SatuSehat ({{ observationsData[row.uuid].observations.length }} temuan)
												</div>
												<div v-for="(obs, oi) in observationsData[row.uuid].observations" :key="'obs-'+oi" class="es-dp-obs-item">
													<div class="es-dp-obs-left">
														<span class="es-dp-obs-code">{{ obs.code || '—' }}</span>
														<span class="es-dp-obs-val">{{ obs.value_string || '—' }}</span>
													</div>
													<div class="es-dp-obs-right">
														<span class="es-dp-cond-cs es-cond-active">{{ obs.status || '—' }}</span>
														<span class="es-dp-cond-cat" v-if="obs.category_display">{{ obs.category_display }}</span>
														<span class="es-dp-obs-performer" v-if="obs.performer_name">{{ obs.performer_name }}</span>
														<span class="es-dp-cond-mono">{{ obs.id }}</span>
														<span class="es-dp-cond-ts" v-if="obs.last_updated">{{ formatDate(obs.last_updated) }}</span>
													</div>
												</div>
											</div>
										</template>
									</div>
									<div class="es-dp-grid">
										<!-- Subject -->
										<div class="es-dp-section">
											<div class="es-dp-sec-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
												Pasien (Subject)
											</div>
											<div class="es-dp-row" v-if="detailData[row.uuid].data.subject">
												<span class="es-dp-key">Nama</span>
												<span class="es-dp-val">{{ detailData[row.uuid].data.subject.display || '—' }}</span>
											</div>
											<div class="es-dp-row" v-if="detailData[row.uuid].data.subject">
												<span class="es-dp-key">Referensi</span>
												<span class="es-dp-val es-dp-mono">{{ detailData[row.uuid].data.subject.reference || '—' }}</span>
											</div>
										</div>
										<!-- Period -->
										<div class="es-dp-section">
											<div class="es-dp-sec-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
												Periode Kunjungan
											</div>
											<div class="es-dp-row" v-if="detailData[row.uuid].data.period">
												<span class="es-dp-key">Mulai</span>
												<span class="es-dp-val">{{ formatDate(detailData[row.uuid].data.period.start) }}</span>
											</div>
											<div class="es-dp-row" v-if="detailData[row.uuid].data.period && detailData[row.uuid].data.period.end">
												<span class="es-dp-key">Selesai</span>
												<span class="es-dp-val">{{ formatDate(detailData[row.uuid].data.period.end) }}</span>
											</div>
										</div>
										<!-- Participant -->
										<div class="es-dp-section" v-if="detailData[row.uuid].data.participant && detailData[row.uuid].data.participant.length">
											<div class="es-dp-sec-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
												Tenaga Medis
											</div>
											<template v-for="(p, pi) in detailData[row.uuid].data.participant" :key="pi">
												<div class="es-dp-row" v-if="p.individual">
													<span class="es-dp-key">Nama</span>
													<span class="es-dp-val">{{ p.individual.display || '—' }}</span>
												</div>
												<div class="es-dp-row" v-if="p.individual">
													<span class="es-dp-key">Referensi</span>
													<span class="es-dp-val es-dp-mono">{{ p.individual.reference || '—' }}</span>
												</div>
											</template>
										</div>
										<!-- Location -->
										<div class="es-dp-section" v-if="detailData[row.uuid].data.location && detailData[row.uuid].data.location.length">
											<div class="es-dp-sec-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
												Lokasi
											</div>
											<template v-for="(loc, li) in detailData[row.uuid].data.location" :key="li">
												<div class="es-dp-loc-item">
													<div class="es-dp-row">
														<span class="es-dp-key">Lokasi {{ li + 1 }}</span>
														<span class="es-dp-val">
															{{ (loc.location && loc.location.display) || (loc.location && loc.location.reference) || '—' }}
															<span class="es-dp-loc-status" :class="'es-dp-ls-' + (loc.status || 'unknown')">{{ loc.status }}</span>
														</span>
													</div>
													<div class="es-dp-row" v-if="loc.period && loc.period.start">
														<span class="es-dp-key">Mulai</span>
														<span class="es-dp-val">{{ formatDate(loc.period.start) }}</span>
													</div>
												</div>
											</template>
										</div>
										<!-- Status History -->
										<div class="es-dp-section es-dp-sec-wide" v-if="detailData[row.uuid].data.statusHistory && detailData[row.uuid].data.statusHistory.length">
											<div class="es-dp-sec-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
												Riwayat Status (FHIR)
											</div>
											<div class="es-dp-sh-list">
												<div v-for="(sh, si) in detailData[row.uuid].data.statusHistory" :key="si" class="es-dp-sh-item">
													<span class="es-fhir-badge" :class="fhirStatusClass(sh.status)">{{ fhirStatusLabel(sh.status) }}</span>
													<span class="es-dp-sh-period">
														{{ sh.period && sh.period.start ? formatDate(sh.period.start) : '' }}
														<span v-if="sh.period && sh.period.end"> → {{ formatDate(sh.period.end) }}</span>
													</span>
												</div>
											</div>
										</div>
										<!-- Identifier -->
										<div class="es-dp-section" v-if="detailData[row.uuid].data.identifier && detailData[row.uuid].data.identifier.length">
											<div class="es-dp-sec-title">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
												Identifier
											</div>
											<template v-for="(ident, ii) in detailData[row.uuid].data.identifier" :key="ii">
												<div class="es-dp-row">
													<span class="es-dp-key">Nilai</span>
													<span class="es-dp-val es-dp-mono">{{ ident.value }}</span>
												</div>
												<div class="es-dp-row" v-if="ident.system">
													<span class="es-dp-key">System</span>
													<span class="es-dp-val es-dp-mono es-dp-sm">{{ ident.system }}</span>
												</div>
											</template>
										</div>
									</div>
								</div>
							</td>
						</tr>
						</template>
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

<!-- ── Modal: Update FHIR Status ─────────────────────────────────────────── -->
<teleport to="body">
<div class="es-modal-backdrop" v-if="statusModal.show" @click.self="closeStatusModal">
	<div class="es-modal">
		<div class="es-modal-header">
			<div class="es-modal-title">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="es-modal-icon"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
				Update Status FHIR Encounter
			</div>
			<button class="es-modal-close" @click="closeStatusModal">✕</button>
		</div>
		<div class="es-modal-body" v-if="statusModal.row">
			<div class="es-modal-info">
				<span class="es-modal-label">Pasien</span>
				<span class="es-modal-val">{{ statusModal.row.nama_pasien }}</span>
				<span class="es-modal-label">No. Reg</span>
				<span class="es-modal-val">{{ statusModal.row.nomor }}</span>
				<span class="es-modal-label">Encounter ID</span>
				<span class="es-modal-val es-mono">{{ statusModal.row.satusehat_encounter_id }}</span>
				<span class="es-modal-label">Status Saat Ini</span>
				<span class="es-modal-val">
					<span class="es-fhir-badge" :class="fhirStatusClass(statusModal.row.satusehat_encounter_fhir_status)">
						{{ fhirStatusLabel(statusModal.row.satusehat_encounter_fhir_status) }}
					</span>
				</span>
			</div>

			<!-- Status selector — tampilkan sebagai pilihan pill -->
			<div class="es-status-picker">
				<label class="es-field-label">Status Baru</label>
				<div class="es-status-pills">
					<button v-for="(label, key) in fhirStatusOptions" :key="key"
						class="es-status-pill"
						:class="[fhirStatusClass(key), { active: statusModal.newStatus === key }]"
						:disabled="key === statusModal.row.satusehat_encounter_fhir_status"
						@click="statusModal.newStatus = key">
						{{ label }}
						<span v-if="key === statusModal.row.satusehat_encounter_fhir_status" class="es-pill-current">(saat ini)</span>
					</button>
				</div>
			</div>

			<!-- Waktu mulai status baru -->
			<div class="es-field-group">
				<label class="es-field-label">Waktu Mulai Status Baru</label>
				<input v-model="statusModal.periodStart" type="datetime-local" class="es-field-input" />
				<small class="es-field-hint">Kosongkan untuk menggunakan waktu sekarang</small>
			</div>

			<!-- Catatan opsional -->
			<div class="es-field-group">
				<label class="es-field-label">Catatan (opsional)</label>
				<input v-model="statusModal.catatan" type="text" class="es-field-input"
					placeholder="Mis: Pasien masuk ruang dokter pukul 10:30" />
			</div>
		</div>
		<div class="es-modal-footer">
			<button class="es-modal-cancel" @click="closeStatusModal">Batal</button>
			<button class="es-modal-confirm"
				:disabled="!statusModal.newStatus || statusModal.loading || statusModal.newStatus === (statusModal.row && statusModal.row.satusehat_encounter_fhir_status)"
				@click="submitStatusUpdate">
				<svg v-if="statusModal.loading" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="etp-spin es-btn-icon"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.67"/></svg>
				{{ statusModal.loading ? 'Menyimpan…' : 'Simpan & Kirim ke SatuSehat' }}
			</button>
		</div>
	</div>
</div>

<!-- ── Modal: Riwayat Status ──────────────────────────────────────────────── -->
<div class="es-modal-backdrop" v-if="historyModal.show" @click.self="closeHistoryModal">
	<div class="es-modal es-modal-wide">
		<div class="es-modal-header">
			<div class="es-modal-title">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="es-modal-icon"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
				Riwayat Status Encounter
			</div>
			<button class="es-modal-close" @click="closeHistoryModal">✕</button>
		</div>
		<div class="es-modal-body" v-if="historyModal.row">
			<div class="es-modal-info es-modal-info-sm">
				<span class="es-modal-label">Pasien</span>
				<span class="es-modal-val">{{ historyModal.row.nama_pasien }} — {{ historyModal.row.nomor }}</span>
				<span class="es-modal-label">Encounter ID</span>
				<span class="es-modal-val es-mono">{{ historyModal.row.satusehat_encounter_id }}</span>
			</div>

			<div v-if="historyModal.loading" class="es-hist-loading">Memuat riwayat…</div>
			<div v-else-if="historyModal.rows.length === 0" class="es-hist-empty">Belum ada riwayat status.</div>
			<div v-else class="es-timeline">
				<div v-for="(h, idx) in historyModal.rows" :key="h.id" class="es-tl-item">
					<div class="es-tl-dot" :class="fhirStatusClass(h.status)"></div>
					<div class="es-tl-line" v-if="idx < historyModal.rows.length - 1"></div>
					<div class="es-tl-content">
						<div class="es-tl-top">
							<span class="es-fhir-badge" :class="fhirStatusClass(h.status)">{{ fhirStatusLabel(h.status) }}</span>
							<span class="es-tl-time">{{ formatDate(h.period_start) }}</span>
							<span class="es-tl-end" v-if="h.period_end">s/d {{ formatDate(h.period_end) }}</span>
						</div>
						<div class="es-tl-meta" v-if="h.catatan || h.updated_by">
							<span v-if="h.catatan">{{ h.catatan }}</span>
							<span class="es-tl-by" v-if="h.updated_by">oleh {{ h.updated_by }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="es-modal-footer">
			<button class="es-modal-cancel" @click="closeHistoryModal">Tutup</button>
		</div>
	</div>
</div>
</teleport>
</template>

<script>
import axios from 'axios';

export default {
	name: 'EncounterSync',
	data() {
		// Helper: format Date ke YYYY-MM-DD lokal (tanpa timezone offset)
		function fmt(d) {
			return d.getFullYear() + '-'
				+ String(d.getMonth() + 1).padStart(2, '0') + '-'
				+ String(d.getDate()).padStart(2, '0');
		}
		var now      = new Date();
		var today    = fmt(now);
		var firstDay = fmt(new Date(now.getFullYear(), now.getMonth(), 1)); // awal bulan ini

		return {
			// Stats
			stats: null,
			statsLoading: true,

			// Filter date range — default bulan ini
			dateFrom: firstDay,
			dateTo:   today,

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

			// Update FHIR status per row
			updatingFhirRows: {},

			// Retry
			retrying: false,

			// Modal: update FHIR status
			statusModal: {
				show:        false,
				row:         null,
				newStatus:   null,
				periodStart: '',
				catatan:     '',
				loading:     false,
			},

			// Modal: riwayat status
			historyModal: {
				show:    false,
				row:     null,
				rows:    [],
				loading: false,
			},

			// Expanded detail toggle — { uuid: true/false }
			expandedRows: {},
			// Cached detail data — { uuid: { loading, error, data } }
			detailData: {},
			// Conditions per encounter — { uuid: { loading, error, conditions } }
			conditionsData: {},
			observationsData: {},

			// FHIR status options
			fhirStatusOptions: {
				'arrived':     'Tiba / Mendaftar',
				'in-progress': 'Sedang Diperiksa',
				'finished':    'Selesai',
				'cancelled':   'Dibatalkan',
			},

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

		// ── Date range helpers ────────────────────────────────────────────
		onRangeChange() {
			var vm = this;
			// Pastikan from <= to
			if (vm.dateFrom > vm.dateTo) { var t = vm.dateFrom; vm.dateFrom = vm.dateTo; vm.dateTo = t; }
			vm.page   = 1;
			vm.search = '';
			vm.loadDashboard();
			vm.loadList();
		},

		setRange(preset) {
			var vm  = this;
			var now = new Date();
			function fmt(d) {
				return d.getFullYear() + '-'
					+ String(d.getMonth() + 1).padStart(2, '0') + '-'
					+ String(d.getDate()).padStart(2, '0');
			}
			if (preset === 'today') {
				vm.dateFrom = fmt(now);
				vm.dateTo   = fmt(now);
			} else if (preset === 'week') {
				var day  = now.getDay() || 7;              // Mon=1 … Sun=7
				var mon  = new Date(now); mon.setDate(now.getDate() - day + 1);
				var sun  = new Date(now); sun.setDate(now.getDate() - day + 7);
				vm.dateFrom = fmt(mon);
				vm.dateTo   = fmt(sun);
			} else if (preset === 'month') {
				vm.dateFrom = fmt(new Date(now.getFullYear(), now.getMonth(), 1));
				vm.dateTo   = fmt(now);
			}
			vm.page   = 1;
			vm.search = '';
			vm.loadDashboard();
			vm.loadList();
		},

		// ── Stats ─────────────────────────────────────────────────────────
		loadDashboard() {
			var vm = this;
			vm.statsLoading = true;
			vm.api('dashboard', { date_from: vm.dateFrom, date_to: vm.dateTo }).then(function (r) {
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
				page:      vm.page,
				status:    vm.activeTab,
				search:    vm.search,
				date_from: vm.dateFrom,
				date_to:   vm.dateTo,
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
			vm.syncing        = true;
			vm.lastSyncResult = null;
			vm.showLog        = false;

			vm.api('run-sync', { batch: vm.syncBatch, date_from: vm.dateFrom, date_to: vm.dateTo }, { timeout: 300000 })
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
			vm.api('retry-failed', { date_from: vm.dateFrom, date_to: vm.dateTo }).then(function (r) {
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

		// ── Modal: Update FHIR Status ─────────────────────────────────────
		openStatusModal(row) {
			var vm = this;
			vm.statusModal = {
				show:        true,
				row:         row,
				newStatus:   null,
				periodStart: '',
				catatan:     '',
				loading:     false,
			};
		},
		closeStatusModal() {
			this.statusModal.show = false;
		},
		submitStatusUpdate() {
			var vm = this;
			if (!vm.statusModal.newStatus || vm.statusModal.loading) return;

			vm.statusModal.loading = true;

			var payload = {
				uuid:    vm.statusModal.row.uuid,
				status:  vm.statusModal.newStatus,
				catatan: vm.statusModal.catatan || null,
			};
			if (vm.statusModal.periodStart) {
				// Konversi datetime-local ke ISO
				payload.period_start = new Date(vm.statusModal.periodStart).toISOString();
			}

			vm.api('update-status', payload)
				.then(function (r) {
					if (r.data.data === 'berhasil') {
						// Update baris di list langsung tanpa reload penuh
						var idx = vm.list.findIndex(function (i) { return i.uuid === vm.statusModal.row.uuid; });
						if (idx !== -1) {
							vm.list[idx].satusehat_encounter_fhir_status = vm.statusModal.newStatus;
						}
						vm.closeStatusModal();
					} else {
						alert(r.data.message || 'Gagal mengubah status.');
					}
				})
				.catch(function (e) {
					alert('Error: ' + (e.response && e.response.data ? e.response.data.message : 'Network error'));
				})
				.finally(function () {
					vm.statusModal.loading = false;
				});
		},

		// ── Modal: Riwayat Status ─────────────────────────────────────────
		openHistoryModal(row) {
			var vm = this;
			vm.historyModal = { show: true, row: row, rows: [], loading: true };

			vm.api('status-history', { uuid: row.uuid })
				.then(function (r) {
					vm.historyModal.rows = r.data.data || [];
				})
				.catch(function () {
					vm.historyModal.rows = [];
				})
				.finally(function () {
					vm.historyModal.loading = false;
				});
		},
		closeHistoryModal() {
			this.historyModal.show = false;
		},

		// ── Encounter Detail toggle ───────────────────────────────────────
		toggleDetail(row) {
			var vm   = this;
			var uuid = row.uuid;

			// Toggle close
			if (vm.expandedRows[uuid]) {
				vm.expandedRows = { ...vm.expandedRows, [uuid]: false };
				return;
			}

			// Open
			vm.expandedRows = { ...vm.expandedRows, [uuid]: true };

			// Return if already loaded (cache hit)
			if (vm.detailData[uuid] && !vm.detailData[uuid].loading && vm.detailData[uuid].data) return;

			// Fetch
			vm.detailData = { ...vm.detailData, [uuid]: { loading: true, error: null, data: null } };

			vm.api('detail', { uuid: uuid })
				.then(function (r) {
					vm.detailData = { ...vm.detailData, [uuid]: { loading: false, error: null, data: r.data.data } };
				})
				.catch(function (e) {
					var msg = (e.response && e.response.data && e.response.data.message)
						? e.response.data.message
						: 'Gagal memuat detail encounter dari SatuSehat';
					vm.detailData = { ...vm.detailData, [uuid]: { loading: false, error: msg, data: null } };
				});
		},

		// ── Check Conditions ─────────────────────────────────────────────
		checkConditions(row) {
			var vm   = this;
			var uuid = row.uuid;

			// Tandai loading — selalu refresh (tidak cache)
			vm.conditionsData = { ...vm.conditionsData, [uuid]: { loading: true, error: null, conditions: null } };

			vm.api('conditions', { uuid: uuid })
				.then(function (r) {
					var conds = Array.isArray(r.data.data) ? r.data.data : [];
					vm.conditionsData = { ...vm.conditionsData, [uuid]: { loading: false, error: null, conditions: conds } };
				})
				.catch(function (e) {
					var msg = (e.response && e.response.data && e.response.data.message)
						? e.response.data.message
						: 'Gagal mengambil Conditions dari SatuSehat';
					vm.conditionsData = { ...vm.conditionsData, [uuid]: { loading: false, error: msg, conditions: null } };
				});
		},

		// ── Check Observations (CPPT) ─────────────────────────────────────
		checkObservations(row) {
			var vm   = this;
			var uuid = row.uuid;

			vm.observationsData = { ...vm.observationsData, [uuid]: { loading: true, error: null, observations: null, cppt_local: null } };

			vm.api('observations', { uuid: uuid })
				.then(function (r) {
					var obs      = Array.isArray(r.data.data)      ? r.data.data      : [];
					var cpptLocal = Array.isArray(r.data.cppt_local) ? r.data.cppt_local : [];
					vm.observationsData = { ...vm.observationsData, [uuid]: { loading: false, error: null, observations: obs, cppt_local: cpptLocal } };
				})
				.catch(function (e) {
					var msg = (e.response && e.response.data && e.response.data.message)
						? e.response.data.message
						: 'Gagal mengambil Observations dari SatuSehat';
					var cpptLocal = (e.response && e.response.data && Array.isArray(e.response.data.cppt_local))
						? e.response.data.cppt_local : [];
					vm.observationsData = { ...vm.observationsData, [uuid]: { loading: false, error: msg, observations: null, cppt_local: cpptLocal } };
				});
		},

		obsStatusLabel(status) {
			if (status === 'synced')              return 'Synced';
			if (status === 'failed')              return 'Gagal';
			if (status === 'waiting_patient')     return 'Menunggu IHS';
			if (status === 'waiting_encounter')   return 'Menunggu Encounter';
			if (status === 'waiting_assessment')  return 'Asesmen Kosong';
			return 'Pending';
		},

		obsStatusClass(status) {
			if (status === 'synced')            return 'es-obs-synced';
			if (status === 'failed')            return 'es-obs-failed';
			if (status && status.startsWith('waiting')) return 'es-obs-waiting';
			return 'es-obs-pending';
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

		fhirStatusLabel(status) {
			var map = {
				'arrived':     'Arrived',
				'in-progress': 'In Progress',
				'finished':    'Finished',
				'cancelled':   'Cancelled',
			};
			return map[status] || (status || '—');
		},

		fhirStatusClass(status) {
			if (status === 'arrived')     return 'es-fhir-arrived';
			if (status === 'in-progress') return 'es-fhir-inprogress';
			if (status === 'finished')    return 'es-fhir-finished';
			if (status === 'cancelled')   return 'es-fhir-cancelled';
			return 'es-fhir-arrived';
		},

		formatDate(dt) {
			if (!dt) return '-';
			var d = new Date(dt);
			return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
				+ ' ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
		},

		// Tanggal pendek tanpa jam (untuk tanggal_kontrol_selanjutnya)
		formatDateShort(dt) {
			if (!dt) return '-';
			var d = new Date(dt);
			return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
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
.es-toolbar        { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding: 14px 18px; border-bottom: 1px solid #f1f5f9; }
.es-filter-tabs    { display: flex; gap: 4px; flex-wrap: wrap; }
.es-tab            { padding: 6px 14px; border: 1px solid #e2e8f0; background: #f8fafc; color: #64748b; font-size: 12px; font-weight: 500; border-radius: 20px; cursor: pointer; transition: all .15s; }
.es-tab:hover      { border-color: #7c3aed; color: #7c3aed; }
.es-tab.active     { background: #7c3aed; border-color: #7c3aed; color: #fff; }
.es-toolbar-right    { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

/* Date range */
.es-daterange-wrap   { display: flex; align-items: flex-end; gap: 6px; flex-wrap: wrap; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 7px 12px; }
.es-dr-group         { display: flex; flex-direction: column; gap: 2px; }
.es-date-label       { font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; }
.es-date-input       { padding: 5px 9px; border: 1px solid #e2e8f0; border-radius: 7px; font-size: 13px; color: #1e293b; outline: none; background: #fff; cursor: pointer; }
.es-date-input:focus { border-color: #7c3aed; }
.es-dr-sep           { font-size: 14px; color: #cbd5e1; padding-bottom: 4px; }
.es-dr-shortcuts     { display: flex; gap: 4px; align-items: flex-end; padding-bottom: 1px; }
.es-dr-sc            { padding: 4px 10px; font-size: 11px; font-weight: 600; color: #7c3aed; background: #ede9fe; border: none; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: background .15s; }
.es-dr-sc:hover      { background: #ddd6fe; }

/* Search */
.es-search-wrap    { display: flex; gap: 6px; }
.es-search-input   { padding: 7px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; width: 200px; outline: none; color: #1e293b; }
.es-search-input:focus { border-color: #7c3aed; }
.es-search-btn     { padding: 7px 14px; background: #7c3aed; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; font-weight: 500; }
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

/* ── FHIR Status badges ──────────────────────────────────────────────────────── */
.es-fhir-status-wrap  { display: flex; align-items: center; gap: 5px; }
.es-fhir-badge        { display: inline-block; font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 10px; white-space: nowrap; }
.es-fhir-arrived      { background: #dbeafe; color: #1e40af; }
.es-fhir-inprogress   { background: #fef9c3; color: #713f12; }
.es-fhir-finished     { background: #dcfce7; color: #166534; }
.es-fhir-cancelled    { background: #f1f5f9; color: #475569; }
.es-fhir-edit-btn     { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; cursor: pointer; transition: all .15s; flex-shrink: 0; }
.es-fhir-edit-btn svg { width: 11px; height: 11px; stroke: #64748b; }
.es-fhir-edit-btn:hover:not(:disabled) { background: #ede9fe; border-color: #c4b5fd; }
.es-fhir-edit-btn:hover:not(:disabled) svg { stroke: #7c3aed; }
.es-fhir-edit-btn:disabled { opacity: .4; cursor: not-allowed; }

/* ── Action group ────────────────────────────────────────────────────────────── */
.es-action-group  { display: flex; align-items: center; gap: 5px; }
.es-hist-btn      { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; transition: all .15s; flex-shrink: 0; }
.es-hist-btn svg  { width: 13px; height: 13px; stroke: #64748b; }
.es-hist-btn:hover { background: #ede9fe; border-color: #c4b5fd; }
.es-hist-btn:hover svg { stroke: #7c3aed; }
.es-td-poli       { font-size: 11px; color: #7c3aed; background: #ede9fe; display: inline-block; padding: 1px 6px; border-radius: 4px; margin-top: 2px; }

/* ── Modal backdrop ──────────────────────────────────────────────────────────── */
.es-modal-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,.45); backdrop-filter: blur(2px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; }
.es-modal          { background: #fff; border-radius: 14px; width: 100%; max-width: 520px; box-shadow: 0 20px 60px rgba(0,0,0,.18); display: flex; flex-direction: column; max-height: 90vh; overflow: hidden; }
.es-modal-wide     { max-width: 660px; }

.es-modal-header   { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px 14px; border-bottom: 1px solid #f1f5f9; }
.es-modal-title    { display: flex; align-items: center; gap: 8px; font-size: 15px; font-weight: 700; color: #1e293b; }
.es-modal-icon     { width: 18px; height: 18px; stroke: #7c3aed; flex-shrink: 0; }
.es-modal-close    { background: none; border: none; font-size: 16px; color: #94a3b8; cursor: pointer; padding: 4px 8px; border-radius: 6px; }
.es-modal-close:hover { background: #f1f5f9; color: #475569; }

.es-modal-body     { padding: 18px 22px; overflow-y: auto; flex: 1; }
.es-modal-info     { display: grid; grid-template-columns: 90px 1fr; gap: 6px 12px; background: #f8fafc; border-radius: 8px; padding: 12px 14px; margin-bottom: 18px; font-size: 13px; }
.es-modal-info-sm  { grid-template-columns: 80px 1fr; }
.es-modal-label    { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .3px; align-self: center; }
.es-modal-val      { color: #1e293b; font-size: 13px; align-self: center; }
.es-mono           { font-family: monospace; font-size: 12px; color: #7c3aed; }

/* Status pill selector */
.es-status-picker  { margin-bottom: 16px; }
.es-status-pills   { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
.es-status-pill    { padding: 7px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: 2px solid transparent; transition: all .15s; }
.es-status-pill.es-fhir-arrived    { background: #dbeafe; color: #1e40af; }
.es-status-pill.es-fhir-inprogress { background: #fef9c3; color: #713f12; }
.es-status-pill.es-fhir-finished   { background: #dcfce7; color: #166534; }
.es-status-pill.es-fhir-cancelled  { background: #f1f5f9; color: #475569; }
.es-status-pill.active             { border-color: currentColor; box-shadow: 0 0 0 3px rgba(124,58,237,.15); }
.es-status-pill:disabled           { opacity: .5; cursor: not-allowed; }
.es-pill-current   { font-size: 10px; font-weight: 400; opacity: .7; margin-left: 4px; }

/* Field inputs */
.es-field-label  { display: block; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 5px; }
.es-field-group  { margin-bottom: 14px; }
.es-field-input  { width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #1e293b; outline: none; box-sizing: border-box; }
.es-field-input:focus { border-color: #7c3aed; }
.es-field-hint   { font-size: 11px; color: #94a3b8; margin-top: 4px; display: block; }

.es-modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 22px; border-top: 1px solid #f1f5f9; }
.es-modal-cancel  { padding: 8px 18px; background: #f1f5f9; color: #475569; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; }
.es-modal-cancel:hover { background: #e2e8f0; }
.es-modal-confirm { display: flex; align-items: center; gap: 6px; padding: 8px 18px; background: #7c3aed; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background .15s; }
.es-modal-confirm:hover:not(:disabled) { background: #6d28d9; }
.es-modal-confirm:disabled { opacity: .55; cursor: not-allowed; }
.es-btn-icon { width: 14px; height: 14px; flex-shrink: 0; }

/* Timeline */
.es-hist-loading { text-align: center; padding: 20px; font-size: 13px; color: #94a3b8; }
.es-hist-empty   { text-align: center; padding: 20px; font-size: 13px; color: #94a3b8; }
.es-timeline     { padding: 4px 0; }
.es-tl-item      { display: flex; gap: 14px; position: relative; padding-bottom: 18px; }
.es-tl-item:last-child { padding-bottom: 0; }
.es-tl-dot       { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; border: 2px solid #fff; box-shadow: 0 0 0 2px currentColor; }
.es-tl-dot.es-fhir-arrived    { background: #3b82f6; }
.es-tl-dot.es-fhir-inprogress { background: #f59e0b; }
.es-tl-dot.es-fhir-finished   { background: #22c55e; }
.es-tl-dot.es-fhir-cancelled  { background: #94a3b8; }
.es-tl-line { position: absolute; left: 5px; top: 16px; bottom: -2px; width: 2px; background: #f1f5f9; }
.es-tl-content { flex: 1; }
.es-tl-top     { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.es-tl-time    { font-size: 12px; color: #64748b; }
.es-tl-end     { font-size: 11px; color: #94a3b8; }
.es-tl-meta    { font-size: 12px; color: #475569; margin-top: 4px; display: flex; gap: 10px; flex-wrap: wrap; }
.es-tl-by      { color: #94a3b8; font-style: italic; }

/* ── Toggle column ──────────────────────────────────────────────────────────── */
.es-th-toggle   { width: 36px; padding: 0 6px !important; }
.es-td-toggle   { width: 36px; padding: 0 6px !important; text-align: center; }
.es-toggle-btn  {
	display: inline-flex; align-items: center; justify-content: center;
	width: 26px; height: 26px; border-radius: 6px; border: 1px solid #e2e8f0;
	background: #f8fafc; cursor: pointer; transition: all .2s; flex-shrink: 0;
}
.es-toggle-btn svg { width: 14px; height: 14px; stroke: #64748b; transition: transform .2s; }
.es-toggle-btn:hover { background: #ede9fe; border-color: #c4b5fd; }
.es-toggle-btn:hover svg { stroke: #7c3aed; }
.es-toggle-btn.active { background: #ede9fe; border-color: #a78bfa; }
.es-toggle-btn.active svg { stroke: #7c3aed; transform: rotate(180deg); }
.es-row-expanded td { background: #fdfbff !important; }

/* ── Detail row ──────────────────────────────────────────────────────────────── */
.es-detail-row td   { padding: 0 !important; border-bottom: 2px solid #ede9fe !important; }
.es-detail-td       { padding: 0 !important; }

.es-dp-loading { display: flex; align-items: center; gap: 10px; padding: 18px 22px; font-size: 13px; color: #64748b; }
.es-dp-spin    { width: 16px; height: 16px; flex-shrink: 0; }
.es-dp-error   { display: flex; align-items: center; gap: 8px; padding: 14px 22px; font-size: 13px; color: #991b1b; background: #fff5f5; }
.es-dp-error svg { width: 16px; height: 16px; stroke: #dc2626; flex-shrink: 0; }

.es-detail-panel  { padding: 16px 22px 20px; background: #faf8ff; border-top: 1px solid #ede9fe; }
.es-dp-header     { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #ede9fe; }
.es-dp-res-type   { font-size: 12px; font-weight: 700; color: #7c3aed; background: #ede9fe; padding: 2px 8px; border-radius: 5px; letter-spacing: .3px; }
.es-dp-id         { font-family: monospace; font-size: 11px; color: #475569; background: #f1f5f9; padding: 2px 7px; border-radius: 4px; }
.es-dp-ver        { font-size: 11px; color: #94a3b8; margin-left: auto; }

.es-dp-grid       { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px; }
.es-dp-sec-wide   { grid-column: 1 / -1; }

.es-dp-section    { background: #fff; border: 1px solid #f1f5f9; border-radius: 8px; padding: 12px 14px; }
.es-dp-sec-title  { display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; }
.es-dp-sec-title svg { width: 13px; height: 13px; flex-shrink: 0; stroke: #7c3aed; }
.es-dp-row        { display: flex; gap: 8px; margin-bottom: 6px; font-size: 12px; align-items: baseline; }
.es-dp-row:last-child { margin-bottom: 0; }
.es-dp-key        { font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .3px; flex-shrink: 0; min-width: 62px; }
.es-dp-val        { color: #1e293b; flex: 1; word-break: break-all; }
.es-dp-mono       { font-family: monospace; font-size: 11px; color: #7c3aed; }
.es-dp-sm         { font-size: 10px; }

.es-dp-loc-item   { margin-bottom: 6px; padding-bottom: 6px; border-bottom: 1px dashed #f1f5f9; }
.es-dp-loc-item:last-child { margin-bottom: 0; border-bottom: none; }
.es-dp-loc-status { font-size: 10px; font-weight: 600; padding: 1px 6px; border-radius: 4px; margin-left: 6px; }
.es-dp-ls-completed { background: #dcfce7; color: #166534; }
.es-dp-ls-active    { background: #fef9c3; color: #713f12; }
.es-dp-ls-planned   { background: #dbeafe; color: #1e40af; }
.es-dp-ls-unknown   { background: #f1f5f9; color: #64748b; }

.es-dp-sh-list    { display: flex; flex-wrap: wrap; gap: 8px; }
.es-dp-sh-item    { display: flex; align-items: center; gap: 8px; background: #f8fafc; border-radius: 7px; padding: 6px 10px; }
.es-dp-sh-period  { font-size: 11px; color: #475569; }

/* ── Check Conditions button ─────────────────────────────────────────────────── */
.es-dp-cond-btn {
	display: inline-flex; align-items: center; gap: 6px; margin-left: auto;
	padding: 5px 13px; font-size: 12px; font-weight: 600;
	background: #0ea5e9; color: #fff; border: none; border-radius: 7px;
	cursor: pointer; transition: background .15s; white-space: nowrap; flex-shrink: 0;
}
.es-dp-cond-btn svg { width: 13px; height: 13px; flex-shrink: 0; }
.es-dp-cond-btn:hover:not(:disabled) { background: #0284c7; }
.es-dp-cond-btn:disabled { opacity: .6; cursor: not-allowed; }

/* ── Conditions section ──────────────────────────────────────────────────────── */
.es-dp-conditions { margin-top: 12px; border-top: 1px solid #e0f2fe; padding-top: 12px; }

.es-dp-cond-state {
	display: flex; align-items: center; gap: 8px;
	font-size: 12px; color: #64748b; padding: 10px 14px;
	background: #f8fafc; border-radius: 7px;
}
.es-dp-cond-state svg { width: 14px; height: 14px; flex-shrink: 0; }
.es-dp-cond-state-err  { color: #991b1b; background: #fff5f5; }
.es-dp-cond-state-err svg { stroke: #dc2626; }
.es-dp-cond-state-empty { color: #64748b; }

.es-dp-cond-list  { display: flex; flex-direction: column; gap: 6px; }
.es-dp-cond-title {
	display: flex; align-items: center; gap: 6px;
	font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase;
	letter-spacing: .4px; margin-bottom: 6px;
}
.es-dp-cond-title svg { width: 13px; height: 13px; stroke: #0ea5e9; flex-shrink: 0; }

.es-dp-cond-item {
	display: flex; align-items: center; justify-content: space-between; gap: 12px;
	flex-wrap: wrap; background: #f0f9ff; border: 1px solid #bae6fd;
	border-radius: 8px; padding: 8px 12px;
}
.es-dp-cond-left  { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 180px; }
.es-dp-cond-code  { font-family: monospace; font-size: 12px; font-weight: 700; color: #0369a1; background: #e0f2fe; padding: 2px 7px; border-radius: 5px; white-space: nowrap; }
.es-dp-cond-display { font-size: 13px; color: #1e293b; }
.es-dp-cond-right { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.es-dp-cond-cs    { font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 5px; text-transform: capitalize; }
.es-cond-active   { background: #dcfce7; color: #166534; }
.es-cond-inactive { background: #f1f5f9; color: #64748b; }
.es-dp-cond-cat   { font-size: 10px; color: #64748b; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; }
.es-dp-cond-mono  { font-family: monospace; font-size: 10px; color: #94a3b8; }
.es-dp-cond-ts    { font-size: 10px; color: #94a3b8; }

/* ── Observations section (CPPT) ─────────────────────────────────────────────── */
.es-dp-obs-btn {
	display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600;
	padding: 4px 10px; border-radius: 6px; border: 1px solid #a7f3d0; cursor: pointer;
	background: #ecfdf5; color: #065f46; transition: background .15s;
}
.es-dp-obs-btn:hover:not(:disabled) { background: #d1fae5; }
.es-dp-obs-btn svg { width: 12px; height: 12px; stroke: #059669; flex-shrink: 0; }
.es-dp-obs-btn:disabled { opacity: .6; cursor: not-allowed; }

.es-dp-observations { margin-top: 12px; border-top: 1px solid #d1fae5; padding-top: 12px; }

.es-dp-obs-local       { margin-bottom: 10px; }
.es-dp-obs-local-item  {
	display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
	background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 7px; padding: 6px 10px; margin-bottom: 4px;
}
.es-dp-obs-sebagai     { font-size: 10px; font-weight: 700; color: #065f46; background: #d1fae5; padding: 2px 6px; border-radius: 4px; }
.es-dp-obs-nama        { font-size: 12px; color: #1e293b; flex: 1; }
.es-dp-obs-id          { color: #6b7280; }
.es-obs-status-badge   { font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 5px; white-space: nowrap; }
.es-obs-synced         { background: #dcfce7; color: #166534; }
.es-obs-failed         { background: #fee2e2; color: #991b1b; }
.es-obs-waiting        { background: #fef9c3; color: #713f12; }
.es-obs-pending        { background: #dbeafe; color: #1e40af; }

.es-dp-obs-item {
	display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
	flex-wrap: wrap; background: #f0fdf4; border: 1px solid #bbf7d0;
	border-radius: 8px; padding: 8px 12px;
}
.es-dp-obs-left         { display: flex; flex-direction: column; gap: 3px; flex: 1; min-width: 180px; }
.es-dp-obs-code         { font-family: monospace; font-size: 11px; font-weight: 700; color: #065f46; background: #d1fae5; padding: 2px 7px; border-radius: 5px; width: fit-content; }
.es-dp-obs-val          { font-size: 12px; color: #1e293b; }
.es-dp-obs-right        { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.es-dp-obs-performer    { font-size: 11px; color: #374151; background: #f3f4f6; padding: 2px 6px; border-radius: 4px; }

/* ── CarePlan Kontrol column ─────────────────────────────────────────────────── */
.es-th-cp         { white-space: nowrap; }
.es-th-cp-icon    { width: 12px; height: 12px; vertical-align: middle; margin-right: 3px; stroke: #64748b; }
.es-td-cp         { min-width: 130px; }
.es-cp-wrap       { display: flex; flex-direction: column; gap: 3px; }
.es-cp-badge      { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 5px; width: fit-content; white-space: nowrap; }
.es-cp-badge svg  { width: 10px; height: 10px; flex-shrink: 0; }
.es-cp-synced     { background: #dcfce7; color: #166534; }
.es-cp-failed     { background: #fee2e2; color: #991b1b; }
.es-cp-waiting    { background: #fef9c3; color: #713f12; }
.es-cp-pending    { background: #dbeafe; color: #1e40af; }
.es-cp-id         { font-size: 9px; font-family: monospace; color: #94a3b8; word-break: break-all; }
.es-cp-date       { font-size: 10px; color: #64748b; }

/* ── Pagination / count ─────────────────────────────────────────────────────── */
.es-pagination   { display: flex; justify-content: center; align-items: center; gap: 10px; padding: 12px 18px; border-top: 1px solid #f1f5f9; }
.es-page-btn     { padding: 5px 12px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 6px; cursor: pointer; font-size: 16px; color: #475569; transition: all .15s; }
.es-page-btn:hover:not(:disabled) { border-color: #7c3aed; color: #7c3aed; }
.es-page-btn:disabled { opacity: .4; cursor: not-allowed; }
.es-page-info    { font-size: 13px; color: #64748b; min-width: 60px; text-align: center; }
.es-count-info   { padding: 6px 18px 12px; font-size: 12px; color: #94a3b8; text-align: right; }
</style>
