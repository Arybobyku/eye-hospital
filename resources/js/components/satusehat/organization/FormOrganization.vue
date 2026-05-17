<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">

					<!-- ── SECTION: Identitas Organisasi ── -->
					<div class="col-12">
						<div class="form-section-title">Identitas Organisasi</div>
					</div>

					<div class="col-4">
						<Inputed :ref="form.kode.name" :form="form.kode"></Inputed>
					</div>
					<div class="col-8">
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
					</div>

					<div class="col-6">
						<Inputed :ref="form.alias.name" :form="form.alias"></Inputed>
					</div>
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.active.value" class="ss-select" :id="form.active.for_id">
								<option v-for="opt in form.active.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.active.for_id">{{ form.active.title }}</label>
						</div>
					</div>
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.tipe_code.value" class="ss-select" :id="form.tipe_code.for_id">
								<option v-for="opt in form.tipe_code.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.tipe_code.for_id">{{ form.tipe_code.title }}</label>
						</div>
					</div>

					<!-- partOf — dropdown dari daftar org yg sudah ada -->
					<div class="col-12">
						<div class="form-self-group">
							<select v-model="form.part_of.value" class="ss-select" :id="form.part_of.for_id">
								<option value="">— Organisasi induk (root) —</option>
								<option v-for="org in orgList" :key="org.satusehat_id" :value="org.satusehat_id">
									{{ org.nama }} <span v-if="org.kode">({{ org.kode }})</span> — {{ org.satusehat_id }}
								</option>
							</select>
							<label :for="form.part_of.for_id">{{ form.part_of.title }}</label>
						</div>
					</div>

					<!-- ── SECTION: Telecom ── -->
					<div class="col-12">
						<div class="form-section-title">Kontak Umum (telecom)</div>
					</div>

					<div class="col-4">
						<Inputed :ref="form.telepon.name" :form="form.telepon"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.email.name" :form="form.email"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.website.name" :form="form.website"></Inputed>
					</div>

					<!-- ── SECTION: Alamat ── -->
					<div class="col-12">
						<div class="form-section-title">Alamat</div>
					</div>

					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.address_use.value" class="ss-select" :id="form.address_use.for_id">
								<option v-for="opt in form.address_use.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.address_use.for_id">{{ form.address_use.title }}</label>
						</div>
					</div>
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.address_type.value" class="ss-select" :id="form.address_type.for_id">
								<option v-for="opt in form.address_type.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.address_type.for_id">{{ form.address_type.title }}</label>
						</div>
					</div>
					<div class="col-6">
						<Inputed :ref="form.kota.name" :form="form.kota"></Inputed>
					</div>

					<div class="col-9">
						<Inputed :ref="form.alamat.name" :form="form.alamat"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.kode_pos.name" :form="form.kode_pos"></Inputed>
					</div>

					<!-- ── Kode Wilayah BPS — Cascading Dropdown ── -->
					<div class="col-12">
						<div class="form-sub-label">
							Kode Wilayah Administratif (BPS / SatuSehat)
							<span v-if="wilayah.loadingAny" class="wil-loading-badge">Memuat...</span>
						</div>
					</div>

					<!-- Provinsi -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.province" @change="onProvinceChange"
								class="ss-select" id="dd_province"
								:disabled="wilayah.loadingProvinces">
								<option value="">
									{{ wilayah.loadingProvinces ? '— Memuat... —' : (wilayah.provinces.length ? '— Pilih Provinsi —' : '— Belum ada data —') }}
								</option>
								<option v-for="p in wilayah.provinces" :key="p.code" :value="p.code">{{ p.name }}</option>
							</select>
							<label for="dd_province">Provinsi <code v-if="form.kode_provinsi.value" class="wil-code">{{ form.kode_provinsi.value }}</code></label>
						</div>
					</div>

					<!-- Kota/Kabupaten -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.city" @change="onCityChange"
								class="ss-select" id="dd_city"
								:disabled="wilayah.loadingCities || !wilayah.province">
								<option value="">
									{{ wilayah.loadingCities ? '— Memuat... —' : '— Pilih Kota/Kab —' }}
								</option>
								<option v-for="c in wilayah.cities" :key="c.code" :value="c.code">{{ c.name }}</option>
							</select>
							<label for="dd_city">Kota / Kabupaten <code v-if="form.kode_kota.value" class="wil-code">{{ form.kode_kota.value }}</code></label>
						</div>
					</div>

					<!-- Kecamatan -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.district" @change="onDistrictChange"
								class="ss-select" id="dd_district"
								:disabled="wilayah.loadingDistricts || !wilayah.city">
								<option value="">
									{{ wilayah.loadingDistricts ? '— Memuat... —' : '— Pilih Kecamatan —' }}
								</option>
								<option v-for="d in wilayah.districts" :key="d.code" :value="d.code">{{ d.name }}</option>
							</select>
							<label for="dd_district">Kecamatan <code v-if="form.kode_kecamatan.value" class="wil-code">{{ form.kode_kecamatan.value }}</code></label>
						</div>
					</div>

					<!-- Kelurahan/Desa -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.village" @change="onVillageChange"
								class="ss-select" id="dd_village"
								:disabled="wilayah.loadingVillages || !wilayah.district">
								<option value="">
									{{ wilayah.loadingVillages ? '— Memuat... —' : '— Pilih Kelurahan —' }}
								</option>
								<option v-for="v in wilayah.villages" :key="v.code" :value="v.code">{{ v.name }}</option>
							</select>
							<label for="dd_village">Kelurahan / Desa <code v-if="form.kode_kelurahan.value" class="wil-code">{{ form.kode_kelurahan.value }}</code></label>
						</div>
					</div>

					<!-- Catatan jika belum ada data wilayah -->
					<div class="col-12" v-if="!wilayah.loadingProvinces && !wilayah.provinces.length">
						<div class="wil-empty-hint">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="wil-hint-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
							Data wilayah belum tersedia. Fetch terlebih dahulu di menu
							<strong>SatuSehat → Wilayah</strong> lalu coba lagi.
						</div>
					</div>

					<!-- ── SECTION: Contact Tujuan ── -->
					<div class="col-12">
						<div class="form-section-title">
							Kontak Tujuan (contact)
							<span class="form-section-hint">Opsional — untuk kontak spesifik (billing, admin, HR, dll.)</span>
						</div>
					</div>

					<div class="col-4">
						<div class="form-self-group">
							<select v-model="form.contact_purpose_code.value" class="ss-select" :id="form.contact_purpose_code.for_id">
								<option v-for="opt in form.contact_purpose_code.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.contact_purpose_code.for_id">{{ form.contact_purpose_code.title }}</label>
						</div>
					</div>
					<div class="col-8">
						<Inputed :ref="form.contact_nama.name" :form="form.contact_nama"></Inputed>
					</div>

					<div class="col-6">
						<Inputed :ref="form.contact_telepon.name" :form="form.contact_telepon"></Inputed>
					</div>
					<div class="col-6">
						<Inputed :ref="form.contact_email.name" :form="form.contact_email"></Inputed>
					</div>

				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formorganization } from './FormData.js';
import { parseorganization } from './Attachment.js';
var vm, body;

const WILAYAH_API = '/satusehat-api/wilayah/select';
const ORG_LIST_API = '/satusehat-api/organization/list';

function postJSON(url, payload = {}) {
	const fd = new FormData();
	Object.entries(payload).forEach(([k, v]) => fd.append(k, v));
	return axios.post(url, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
}

export default {
	emits: ['dialog', 'parsingForm'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted() {
		vm = this; body = document.body;
		vm.form = vm.formorganization();
		vm.loadProvinces();
		vm.loadOrgList();
	},
	data() {
		return {
			terminate: { show: false, display: 'display: none' },
			form: null,
			btnlbl: '',

			// ── Org list untuk dropdown partOf ───────────────────────────────
			orgList: [],

			// ── Wilayah cascade state ────────────────────────────────────────
			wilayah: {
				provinces: [], cities: [], districts: [], villages: [],
				province: '', city: '', district: '', village: '',
				loadingProvinces: false,
				loadingCities:    false,
				loadingDistricts: false,
				loadingVillages:  false,
				get loadingAny() {
					return this.loadingProvinces || this.loadingCities || this.loadingDistricts || this.loadingVillages;
				},
			},
		};
	},
	methods: {
		formorganization, parseorganization,

		// ── Org list for partOf dropdown ─────────────────────────────────────
		loadOrgList() {
			const fd = new FormData();
			fd.append('search', ''); fd.append('column', ''); fd.append('page', 1); fd.append('limit', 200);
			axios.post(ORG_LIST_API, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => { vm.orgList = r.data?.data ?? []; })
				.catch(() => {});
		},

		// ── Wilayah cascade ───────────────────────────────────────────────────
		loadProvinces() {
			vm.wilayah.loadingProvinces = true;
			postJSON(WILAYAH_API, { level: 'province' })
				.then(r => { vm.wilayah.provinces = r.data?.data ?? []; })
				.catch(() => {})
				.finally(() => { vm.wilayah.loadingProvinces = false; });
		},

		loadCities(provinceCode) {
			vm.wilayah.loadingCities = true;
			vm.wilayah.cities = []; vm.wilayah.districts = []; vm.wilayah.villages = [];
			postJSON(WILAYAH_API, { level: 'city', parent_code: provinceCode })
				.then(r => { vm.wilayah.cities = r.data?.data ?? []; })
				.catch(() => {})
				.finally(() => { vm.wilayah.loadingCities = false; });
		},

		loadDistricts(cityCode) {
			vm.wilayah.loadingDistricts = true;
			vm.wilayah.districts = []; vm.wilayah.villages = [];
			postJSON(WILAYAH_API, { level: 'district', parent_code: cityCode })
				.then(r => { vm.wilayah.districts = r.data?.data ?? []; })
				.catch(() => {})
				.finally(() => { vm.wilayah.loadingDistricts = false; });
		},

		loadVillages(districtCode) {
			vm.wilayah.loadingVillages = true;
			vm.wilayah.villages = [];
			postJSON(WILAYAH_API, { level: 'sub_district', parent_code: districtCode })
				.then(r => { vm.wilayah.villages = r.data?.data ?? []; })
				.catch(() => {})
				.finally(() => { vm.wilayah.loadingVillages = false; });
		},

		onProvinceChange() {
			const code = vm.wilayah.province;
			vm.form.kode_provinsi.value = code;
			vm.wilayah.city = ''; vm.wilayah.district = ''; vm.wilayah.village = '';
			vm.form.kode_kota.value = ''; vm.form.kode_kecamatan.value = ''; vm.form.kode_kelurahan.value = '';
			vm.wilayah.cities = []; vm.wilayah.districts = []; vm.wilayah.villages = [];
			if (code) vm.loadCities(code);
		},

		onCityChange() {
			const code = vm.wilayah.city;
			vm.form.kode_kota.value = code;
			vm.wilayah.district = ''; vm.wilayah.village = '';
			vm.form.kode_kecamatan.value = ''; vm.form.kode_kelurahan.value = '';
			vm.wilayah.districts = []; vm.wilayah.villages = [];
			if (code) vm.loadDistricts(code);
		},

		onDistrictChange() {
			const code = vm.wilayah.district;
			vm.form.kode_kecamatan.value = code;
			vm.wilayah.village = '';
			vm.form.kode_kelurahan.value = '';
			vm.wilayah.villages = [];
			if (code) vm.loadVillages(code);
		},

		onVillageChange() {
			vm.form.kode_kelurahan.value = vm.wilayah.village;
		},

		// Restore cascading dropdowns when editing (sequential async)
		async restoreWilayah(provCode, cityCode, distCode, vilCode) {
			if (!provCode) return;
			vm.wilayah.province = provCode;
			vm.form.kode_provinsi.value = provCode;

			// Load cities for province
			vm.wilayah.loadingCities = true;
			try {
				const rc = await postJSON(WILAYAH_API, { level: 'city', parent_code: provCode });
				vm.wilayah.cities = rc.data?.data ?? [];
			} catch(e) {} finally { vm.wilayah.loadingCities = false; }

			if (!cityCode) return;
			vm.wilayah.city = cityCode;
			vm.form.kode_kota.value = cityCode;

			// Load districts for city
			vm.wilayah.loadingDistricts = true;
			try {
				const rd = await postJSON(WILAYAH_API, { level: 'district', parent_code: cityCode });
				vm.wilayah.districts = rd.data?.data ?? [];
			} catch(e) {} finally { vm.wilayah.loadingDistricts = false; }

			if (!distCode) return;
			vm.wilayah.district = distCode;
			vm.form.kode_kecamatan.value = distCode;

			// Load villages for district
			vm.wilayah.loadingVillages = true;
			try {
				const rv = await postJSON(WILAYAH_API, { level: 'sub_district', parent_code: distCode });
				vm.wilayah.villages = rv.data?.data ?? [];
			} catch(e) {} finally { vm.wilayah.loadingVillages = false; }

			if (!vilCode) return;
			vm.wilayah.village = vilCode;
			vm.form.kode_kelurahan.value = vilCode;
		},

		// ── Form actions ─────────────────────────────────────────────────────
		action() {
			let next = true;
			for (const key in vm.form) {
				if (['title','posisi','satusehat_id'].includes(key)) continue;
				if (vm.form[key] && vm.form[key].required && vm.form[key].value === '') { next = false; }
			}
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show(posisi, title, satusehatId) {
			vm.btnlbl = posisi === 'adddata' ? 'Simpan Data' : 'Perbaharui Data';
			vm.form.satusehat_id = satusehatId;
			vm.form.title  = title;
			vm.form.posisi = posisi;
			body.style.overflowY = 'hidden';
			vm.terminate.display = 'display: block';
			vm.terminate.show    = true;
		},

		aturulang() {
			vm.form = vm.formorganization();
			vm.wilayah.province = ''; vm.wilayah.city = '';
			vm.wilayah.district = ''; vm.wilayah.village = '';
			vm.wilayah.cities = []; vm.wilayah.districts = []; vm.wilayah.villages = [];
		},

		hide() {
			vm.terminate.show = false;
			setTimeout(() => {
				vm.terminate.display = 'display: none';
				body.style.overflowY = 'auto';
			}, 250);
		},

		parsingForm() {
			vm.$emit('parsingForm', vm.parseorganization(vm.form), 'organization');
		},

		loaderprocess() {
			const left = this.$refs.rootmodal.getBoundingClientRect();
			vm.$refs.Loader.running(left, 'modal', 250);
		},

		setdataform(response) {
			const res = response.data.data;
			vm.form.satusehat_id = res.id ?? '';

			// Identitas
			vm.form.kode.value         = res.identifier?.[0]?.value ?? '';
			vm.form.nama.value         = res.name  ?? '';
			vm.form.alias.value        = res.alias?.[0] ?? '';
			vm.form.active.value       = res.active ? 'true' : 'false';
			vm.form.tipe_code.value    = res.type?.[0]?.coding?.[0]?.code ?? 'dept';

			// partOf — strip "Organization/" prefix
			const partOfRef = res.partOf?.reference ?? '';
			vm.form.part_of.value = partOfRef.replace(/^Organization\//, '');

			// Telecom umum
			const tel  = (res.telecom ?? []).find(t => t.system === 'phone');
			const mail = (res.telecom ?? []).find(t => t.system === 'email');
			const web  = (res.telecom ?? []).find(t => t.system === 'url');
			vm.form.telepon.value  = tel?.value  ?? '';
			vm.form.email.value    = mail?.value ?? '';
			vm.form.website.value  = web?.value  ?? '';

			// Alamat
			const addr = res.address?.[0] ?? {};
			vm.form.address_use.value  = addr.use        ?? 'work';
			vm.form.address_type.value = addr.type       ?? 'both';
			vm.form.alamat.value       = addr.line?.[0]  ?? '';
			vm.form.kota.value         = addr.city       ?? '';
			vm.form.kode_pos.value     = addr.postalCode ?? '';

			const adminExt = addr.extension?.[0]?.extension ?? [];
			const prov = adminExt.find(e => e.url === 'province')?.valueCode ?? '';
			const city = adminExt.find(e => e.url === 'city')?.valueCode     ?? '';
			const dist = adminExt.find(e => e.url === 'district')?.valueCode ?? '';
			const vil  = adminExt.find(e => e.url === 'village')?.valueCode  ?? '';

			// Restore cascading wilayah dropdowns
			vm.restoreWilayah(prov, city, dist, vil);

			// Contact tujuan (ambil contact[0] jika ada)
			const contact = res.contact?.[0] ?? null;
			if (contact) {
				vm.form.contact_purpose_code.value = contact.purpose?.coding?.[0]?.code ?? '';
				vm.form.contact_nama.value         = contact.name?.text ?? '';
				const ctTel  = (contact.telecom ?? []).find(t => t.system === 'phone');
				const ctMail = (contact.telecom ?? []).find(t => t.system === 'email');
				vm.form.contact_telepon.value = ctTel?.value  ?? '';
				vm.form.contact_email.value   = ctMail?.value ?? '';
			}

			vm.loaderprocess();
		},

		dialog() {
			const text   = vm.form.posisi === 'adddata' ? 'Yakin ingin menambah Organization baru ke SatuSehat?' : 'Yakin ingin memperbaharui data Organization ini?';
			const button = vm.form.posisi === 'adddata' ? 'Ya, tambah data' : 'Ya, perbaharui data';
			vm.$emit('dialog', text, button, 'formorganization');
		},
	},
}
</script>

<style scoped>
.ss-select {
	width: 100%;
	padding: 10px 12px;
	border: 1px solid #cbd5e1;
	border-radius: 6px;
	background: #fff;
	font-size: 13px;
	color: #334155;
	margin-top: 4px;
}
.ss-select:focus { outline: none; border-color: #1c84ee; }
.ss-select:disabled { background: #f8fafc; color: #94a3b8; cursor: not-allowed; }

/* Section dividers */
.form-section-title {
	font-size: 11px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .5px;
	color: #1c84ee;
	border-bottom: 2px solid #dbeafe;
	padding-bottom: 6px;
	margin: 10px 0 4px;
	display: flex;
	align-items: center;
	gap: 10px;
}
.form-section-hint {
	font-size: 10px;
	font-weight: 400;
	text-transform: none;
	letter-spacing: 0;
	color: #94a3b8;
}
.form-sub-label {
	font-size: 11px;
	font-weight: 600;
	color: #64748b;
	background: #f8fafc;
	border: 1px solid #e2e8f0;
	border-radius: 6px;
	padding: 5px 10px;
	margin: 4px 0 2px;
	display: flex;
	align-items: center;
	gap: 8px;
}

/* Wilayah dropdown helpers */
.wil-code {
	font-family: monospace;
	font-size: 10px;
	color: #1c84ee;
	background: #dbeafe;
	border-radius: 4px;
	padding: 1px 5px;
	margin-left: 4px;
	font-weight: 600;
}

.wil-loading-badge {
	font-size: 10px;
	background: #fef9c3;
	color: #854d0e;
	border-radius: 20px;
	padding: 1px 8px;
	font-weight: 600;
	animation: pulse 1s ease-in-out infinite alternate;
}
@keyframes pulse { from { opacity: .6; } to { opacity: 1; } }

.wil-empty-hint {
	display: flex;
	align-items: center;
	gap: 8px;
	background: #fff7ed;
	border: 1px solid #fed7aa;
	border-radius: 6px;
	padding: 8px 12px;
	font-size: 12px;
	color: #9a3412;
}
.wil-hint-icon { width: 16px; height: 16px; stroke: #ea580c; flex-shrink: 0; }
</style>
