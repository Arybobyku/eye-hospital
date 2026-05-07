<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<div class="token-card">

				<!-- ── Header ── -->
				<div class="token-header">
					<div class="token-header-left">
						<i data-feather="key" class="token-icon"></i>
						<div>
							<h2 class="token-title">SatuSehat Access Token</h2>
							<p class="token-subtitle">OAuth2 Client Credentials — berlaku 3600 detik, di-cache 55 menit</p>
						</div>
					</div>
					<button class="btn-refresh" :class="{ loading: refreshing }" @click="doRefresh" :disabled="refreshing">
						<i data-feather="refresh-cw" class="btn-icon"></i>
						{{ refreshing ? 'Memperbarui…' : 'Refresh Token' }}
					</button>
				</div>

				<!-- ── Status Row ── -->
				<div class="token-status-row" v-if="!loading">

					<!-- Cache Status -->
					<div class="token-stat">
						<span class="stat-label">Status Cache</span>
						<span class="stat-badge" :class="info.cached ? 'badge-green' : 'badge-red'">
							{{ info.cached ? '● Aktif' : '○ Tidak Ada' }}
						</span>
					</div>

					<!-- Diambil pada -->
					<div class="token-stat">
						<span class="stat-label">Diambil Pada</span>
						<span class="stat-value">{{ info.fetched_at ?? '—' }}</span>
					</div>

					<!-- Kadaluarsa -->
					<div class="token-stat">
						<span class="stat-label">Kadaluarsa Estimasi</span>
						<span class="stat-value">{{ info.expires_at ?? '—' }}</span>
					</div>

					<!-- Client ID -->
					<div class="token-stat">
						<span class="stat-label">Client ID</span>
						<span class="stat-value mono">{{ info.client_id ?? '—' }}</span>
					</div>

					<!-- Endpoint -->
					<div class="token-stat endpoint-stat">
						<span class="stat-label">Endpoint Auth</span>
						<span class="stat-value mono small">{{ info.endpoint_auth ?? '—' }}</span>
					</div>

				</div>

				<!-- ── Token Preview ── -->
				<div class="token-preview" v-if="!loading && info.token_masked">
					<span class="preview-label">Token (dipotong) — digunakan seluruh modul SatuSehat</span>
					<div class="preview-value">
						<code>{{ info.token_masked }}</code>
						<span class="preview-hint">terpusat di cache</span>
					</div>
				</div>

				<div class="token-empty" v-if="!loading && !info.token_masked">
					<i data-feather="alert-circle"></i>
					<span>Token belum ada di cache. Klik <strong>Refresh Token</strong> untuk mengambil token baru dari SatuSehat.</span>
				</div>

				<!-- ── Skeleton ── -->
				<div v-if="loading" class="token-skeleton">
					<div class="skel skel-wide"></div>
					<div class="skel skel-mid"></div>
					<div class="skel skel-wide"></div>
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
		vm.loadStatus();
		setTimeout(() => { if (window.feather) feather.replace(); }, 300);
	},
	data() {
		return {
			loading:    true,
			refreshing: false,
			info: {
				cached:        false,
				token_masked:  null,
				expires_at:    null,
				fetched_at:    null,
				client_id:     null,
				endpoint_auth: null,
			},
		};
	},
	methods: {
		loadStatus() {
			vm.loading = true;
			axios.post('/satusehat-api/token/status', new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				setTimeout(() => {
					vm.info    = r.data.data ?? {};
					vm.loading = false;
					vm.$nextTick(() => { if (window.feather) feather.replace(); });
				}, 600);
			}).catch(() => {
				vm.loading = false;
				vm.notification('Gagal memuat status token.', 3500, 'error');
			});
		},

		doRefresh() {
			vm.refreshing = true;
			axios.post('/satusehat-api/token/refresh', new FormData(), {
				headers: { 'Content-Type': 'multipart/form-data' }
			}).then(r => {
				if (r.data.data === '419') { window.location.href = '/masuk'; return; }
				setTimeout(() => {
					vm.refreshing = false;
					if (r.data.data === 'berhasil') {
						vm.info.cached       = true;
						vm.info.token_masked = r.data.token_masked;
						vm.info.expires_at   = r.data.expiry      ?? vm.info.expires_at;
						vm.info.fetched_at   = r.data.fetched_at  ?? vm.info.fetched_at;
						vm.notification('Access Token diperbarui — seluruh modul SatuSehat kini menggunakan token ini.', 4500, 'success');
					} else {
						vm.notification('Refresh token gagal: ' + (r.data.message ?? '-'), 4500, 'error');
					}
					vm.$nextTick(() => { if (window.feather) feather.replace(); });
				}, 750);
			}).catch(e => {
				vm.refreshing = false;
				const msg = e?.response?.data?.message ?? 'Terjadi kesalahan server.';
				vm.notification('Refresh token gagal: ' + msg, 4500, 'error');
			});
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
.token-card {
	background: #fff;
	border-radius: 12px;
	border: 1px solid #e2e8f0;
	padding: 28px 32px;
	box-shadow: 0 1px 4px rgba(0,0,0,.06);
}

/* Header */
.token-header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin-bottom: 28px;
	flex-wrap: wrap;
	gap: 16px;
}
.token-header-left {
	display: flex;
	align-items: center;
	gap: 14px;
}
.token-icon {
	width: 36px;
	height: 36px;
	color: #1c84ee;
	flex-shrink: 0;
}
.token-title {
	margin: 0;
	font-size: 18px;
	font-weight: 700;
	color: #1e293b;
}
.token-subtitle {
	margin: 2px 0 0;
	font-size: 12px;
	color: #64748b;
}

/* Refresh button */
.btn-refresh {
	display: flex;
	align-items: center;
	gap: 8px;
	padding: 9px 20px;
	background: #1c84ee;
	color: #fff;
	border: none;
	border-radius: 8px;
	font-size: 13px;
	font-weight: 600;
	cursor: pointer;
	transition: background .15s, opacity .15s;
}
.btn-refresh:hover:not(:disabled) { background: #1668c4; }
.btn-refresh:disabled { opacity: .65; cursor: not-allowed; }
.btn-refresh.loading .btn-icon { animation: spin 1s linear infinite; }
.btn-icon { width: 15px; height: 15px; }
@keyframes spin { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }

/* Stat row */
.token-status-row {
	display: flex;
	flex-wrap: wrap;
	gap: 20px;
	margin-bottom: 24px;
}
.token-stat {
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 8px;
	padding: 12px 18px;
	min-width: 160px;
	flex: 1;
}
.endpoint-stat { flex: 3; min-width: 280px; }
.stat-label {
	display: block;
	font-size: 11px;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: .5px;
	color: #94a3b8;
	margin-bottom: 6px;
}
.stat-value {
	font-size: 13px;
	font-weight: 500;
	color: #334155;
}
.stat-value.mono { font-family: monospace; }
.stat-value.small { font-size: 12px; word-break: break-all; }
.stat-badge {
	display: inline-block;
	padding: 3px 10px;
	border-radius: 20px;
	font-size: 12px;
	font-weight: 700;
}
.badge-green { background: #dcfce7; color: #16a34a; }
.badge-red   { background: #fee2e2; color: #dc2626; }

/* Token preview */
.token-preview {
	background: #0f172a;
	border-radius: 8px;
	padding: 16px 20px;
}
.preview-label {
	display: block;
	font-size: 11px;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: .5px;
	color: #64748b;
	margin-bottom: 8px;
}
.preview-value {
	display: flex;
	align-items: center;
	gap: 14px;
	flex-wrap: wrap;
}
.preview-value code {
	font-family: monospace;
	font-size: 13px;
	color: #4ade80;
	word-break: break-all;
}
.preview-hint {
	font-size: 11px;
	color: #64748b;
	background: #1e293b;
	padding: 2px 8px;
	border-radius: 4px;
	white-space: nowrap;
}

/* Empty */
.token-empty {
	display: flex;
	align-items: center;
	gap: 10px;
	padding: 18px 20px;
	background: #fffbeb;
	border: 1px solid #fde68a;
	border-radius: 8px;
	color: #92400e;
	font-size: 13px;
}
.token-empty svg { width:18px; height:18px; flex-shrink:0; }

/* Skeleton */
.token-skeleton { padding-top: 8px; }
.skel {
	background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
	background-size: 200% 100%;
	animation: shimmer 1.4s infinite;
	border-radius: 6px;
	height: 20px;
	margin-bottom: 14px;
}
.skel-wide { width: 100%; }
.skel-mid  { width: 60%; }
@keyframes shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }
</style>
