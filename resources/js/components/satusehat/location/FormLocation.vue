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

					<!-- ── SECTION: Identitas Lokasi ── -->
					<div class="col-12">
						<div class="form-section-title">Identitas Lokasi</div>
					</div>

					<div class="col-3">
						<Inputed :ref="form.kode.name" :form="form.kode"></Inputed>
					</div>
					<div class="col-9">
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
					</div>

					<div class="col-6">
						<Inputed :ref="form.alias.name" :form="form.alias"></Inputed>
					</div>
					<div class="col-6">
						<Inputed :ref="form.deskripsi.name" :form="form.deskripsi"></Inputed>
					</div>

					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.status.value" class="ss-select" :id="form.status.for_id">
								<option v-for="opt in form.status.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.status.for_id">{{ form.status.title }}</label>
						</div>
					</div>
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.operational_status.value" class="ss-select" :id="form.operational_status.for_id">
								<option v-for="opt in form.operational_status.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.operational_status.for_id">{{ form.operational_status.title }}</label>
						</div>
					</div>
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.mode.value" class="ss-select" :id="form.mode.for_id">
								<option v-for="opt in form.mode.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.mode.for_id">{{ form.mode.title }}</label>
						</div>
					</div>
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.service_class.value" class="ss-select" :id="form.service_class.for_id">
								<option v-for="opt in form.service_class.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.service_class.for_id">{{ form.service_class.title }}</label>
						</div>
					</div>

					<!-- ── SECTION: Tipe ── -->
					<div class="col-12">
						<div class="form-section-title">Tipe Lokasi</div>
					</div>

					<div class="col-6">
						<div class="form-self-group">
							<select v-model="form.tipe_layanan.value" class="ss-select" :id="form.tipe_layanan.for_id">
								<option v-for="opt in form.tipe_layanan.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.tipe_layanan.for_id">{{ form.tipe_layanan.title }}</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-self-group">
							<select v-model="form.tipe_fisik.value" class="ss-select" :id="form.tipe_fisik.for_id">
								<option v-for="opt in form.tipe_fisik.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.tipe_fisik.for_id">{{ form.tipe_fisik.title }}</label>
						</div>
					</div>

					<!-- ── SECTION: Telecom ── -->
					<div class="col-12">
						<div class="form-section-title">Kontak (telecom)</div>
					</div>

					<div class="col-3">
						<Inputed :ref="form.telepon.name" :form="form.telepon"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.fax.name" :form="form.fax"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.email.name" :form="form.email"></Inputed>
					</div>
					<div class="col-3">
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
					<div class="col-6">
						<Inputed :ref="form.alamat.name" :form="form.alamat"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.kota.name" :form="form.kota"></Inputed>
					</div>

					<div class="col-3">
						<Inputed :ref="form.kode_pos.name" :form="form.kode_pos"></Inputed>
					</div>
					<div class="col-2">
						<Inputed :ref="form.rt.name" :form="form.rt"></Inputed>
					</div>
					<div class="col-2">
						<Inputed :ref="form.rw.name" :form="form.rw"></Inputed>
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
								class="ss-select" id="dd_prov_loc"
								:disabled="wilayah.loadingProvinces">
								<option value="">
									{{ wilayah.loadingProvinces ? '— Memuat... —' : (wilayah.provinces.length ? '— Pilih Provinsi —' : '— Belum ada data —') }}
								</option>
								<option v-for="p in wilayah.provinces" :key="p.code" :value="p.code">{{ p.name }}</option>
							</select>
							<label for="dd_prov_loc">Provinsi <code v-if="form.kode_provinsi.value" class="wil-code">{{ form.kode_provinsi.value }}</code></label>
						</div>
					</div>

					<!-- Kota/Kabupaten -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.city" @change="onCityChange"
								class="ss-select" id="dd_city_loc"
								:disabled="wilayah.loadingCities || !wilayah.province">
								<option value="">{{ wilayah.loadingCities ? '— Memuat... —' : '— Pilih Kota/Kab —' }}</option>
								<option v-for="c in wilayah.cities" :key="c.code" :value="c.code">{{ c.name }}</option>
							</select>
							<label for="dd_city_loc">Kota / Kabupaten <code v-if="form.kode_kota.value" class="wil-code">{{ form.kode_kota.value }}</code></label>
						</div>
					</div>

					<!-- Kecamatan -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.district" @change="onDistrictChange"
								class="ss-select" id="dd_dist_loc"
								:disabled="wilayah.loadingDistricts || !wilayah.city">
								<option value="">{{ wilayah.loadingDistricts ? '— Memuat... —' : '— Pilih Kecamatan —' }}</option>
								<option v-for="d in wilayah.districts" :key="d.code" :value="d.code">{{ d.name }}</option>
							</select>
							<label for="dd_dist_loc">Kecamatan <code v-if="form.kode_kecamatan.value" class="wil-code">{{ form.kode_kecamatan.value }}</code></label>
						</div>
					</div>

					<!-- Kelurahan/Desa -->
					<div class="col-3">
						<div class="form-self-group">
							<select v-model="wilayah.village" @change="onVillageChange"
								class="ss-select" id="dd_vil_loc"
								:disabled="wilayah.loadingVillages || !wilayah.district">
								<option value="">{{ wilayah.loadingVillages ? '— Memuat... —' : '— Pilih Kelurahan —' }}</option>
								<option v-for="v in wilayah.villages" :key="v.code" :value="v.code">{{ v.name }}</option>
							</select>
							<label for="dd_vil_loc">Kelurahan / Desa <code v-if="form.kode_kelurahan.value" class="wil-code">{{ form.kode_kelurahan.value }}</code></label>
						</div>
					</div>

					<!-- Hint bila belum ada data wilayah -->
					<div class="col-12" v-if="!wilayah.loadingProvinces && !wilayah.provinces.length">
						<div class="wil-empty-hint">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="wil-hint-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
							Data wilayah belum tersedia. Fetch terlebih dahulu di menu
							<strong>SatuSehat → Wilayah</strong> lalu coba lagi.
						</div>
					</div>

					<!-- ── SECTION: Posisi Geografis ── -->
					<div class="col-12">
						<div class="form-section-title">Posisi Geografis (position)</div>
					</div>

					<div class="col-6">
						<Inputed :ref="form.latitude.name" :form="form.latitude"></Inputed>
					</div>
					<div class="col-6">
						<Inputed :ref="form.longitude.name" :form="form.longitude"></Inputed>
					</div>

					<!-- ── SECTION: Organisasi & Relasi ── -->
					<div class="col-12">
						<div class="form-section-title">Organisasi &amp; Relasi</div>
					</div>

					<!-- Managing Organization — dropdown dari daftar org -->
					<div class="col-6">
						<div class="form-self-group">
							<select v-model="form.managing_organization.value" class="ss-select" :id="form.managing_organization.for_id">
								<option value="">— Gunakan default organisasi —</option>
								<option v-for="org in orgList" :key="org.satusehat_id" :value="org.satusehat_id">
									{{ org.nama }} — {{ org.satusehat_id }}
								</option>
							</select>
							<label :for="form.managing_organization.for_id">Managing Organization</label>
						</div>
					</div>

					<!-- Part Of — dropdown dari daftar lokasi yang sudah ada -->
					<div class="col-6">
						<div class="form-self-group">
							<select v-model="form.part_of.value" class="ss-select" :id="form.part_of.for_id"
								:disabled="locLoading">
								<option value="">
									{{ locLoading ? '— Memuat lokasi... —' : (availableLocList.length ? '— Lokasi induk (root / tidak ada) —' : '— Belum ada lokasi tersedia —') }}
								</option>
								<option v-for="loc in availableLocList" :key="loc.satusehat_id" :value="loc.satusehat_id">
									{{ loc.nama }}{{ loc.kode && loc.kode !== '-' ? ' (' + loc.kode + ')' : '' }}
								</option>
							</select>
							<label :for="form.part_of.for_id">
								{{ form.part_of.title }}
								<code v-if="form.part_of.value" class="wil-code">{{ form.part_of.value.slice(0,16) }}…</code>
							</label>
						</div>
					</div>

					<!-- ── SECTION: Jam Operasional ── -->
					<div class="col-12">
						<div class="form-section-title">
							Jam Operasional (hoursOfOperation)
							<span class="form-section-hint">Opsional — kosongkan jika tidak perlu ditampilkan</span>
						</div>
					</div>

					<div class="col-3">
						<div class="form-self-group">
							<select v-model="form.hours_all_day.value" class="ss-select" :id="form.hours_all_day.for_id">
								<option v-for="opt in form.hours_all_day.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.hours_all_day.for_id">{{ form.hours_all_day.title }}</label>
						</div>
					</div>
					<div class="col-9">
						<Inputed :ref="form.hours_days.name" :form="form.hours_days"></Inputed>
					</div>

					<div class="col-3">
						<Inputed :ref="form.hours_opening.name" :form="form.hours_opening"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.hours_closing.name" :form="form.hours_closing"></Inputed>
					</div>
					<div class="col-6">
						<Inputed :ref="form.availability_exceptions.name" :form="form.availability_exceptions"></Inputed>
					</div>

				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formlocation } from './FormData.js';
import { parselocation } from './Attachment.js';
var vm, body;

const WILAYAH_API  = '/satusehat-api/wilayah/select';
const ORG_LIST_API = '/satusehat-api/organization/list';
const LOC_LIST_API = '/satusehat-api/location/list';

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
		vm.form = vm.formlocation();
		vm.loadProvinces();
		vm.loadOrgList();
		vm.loadLocList();
	},
	data() {
		return {
			terminate: { show: false, display: 'display: none' },
			form: null,
			btnlbl: '',

			// ── Org list untuk dropdown managingOrganization ──────────────────
			orgList: [],

			// ── Location list untuk dropdown partOf ───────────────────────────
			locList: [],
			locLoading: false,

			// ── Wilayah cascade state ─────────────────────────────────────────
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
	computed: {
		// Exclude the location currently being edited from the parent options
		// (a location cannot be its own ancestor)
		availableLocList() {
			const currentId = vm?.form?.satusehat_id ?? '';
			return vm.locList.filter(l => l.satusehat_id !== currentId);
		},
	},
	methods: {
		formlocation, parselocation,

		// ── Org list for managingOrganization dropdown ────────────────────────
		loadOrgList() {
			const fd = new FormData();
			fd.append('search', ''); fd.append('column', ''); fd.append('page', 1); fd.append('limit', 200);
			axios.post(ORG_LIST_API, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => { vm.orgList = r.data?.data ?? []; })
				.catch(() => {});
		},

		// ── Location list for partOf dropdown ────────────────────────────────
		loadLocList() {
			vm.locLoading = true;
			const fd = new FormData();
			fd.append('search', ''); fd.append('column', ''); fd.append('page', 1); fd.append('limit', 500);
			axios.post(LOC_LIST_API, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
				.then(r => { vm.locList = r.data?.data ?? []; })
				.catch(() => {})
				.finally(() => { vm.locLoading = false; });
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

			vm.wilayah.loadingCities = true;
			try {
				const rc = await postJSON(WILAYAH_API, { level: 'city', parent_code: provCode });
				vm.wilayah.cities = rc.data?.data ?? [];
			} catch(e) {} finally { vm.wilayah.loadingCities = false; }

			if (!cityCode) return;
			vm.wilayah.city = cityCode;
			vm.form.kode_kota.value = cityCode;

			vm.wilayah.loadingDistricts = true;
			try {
				const rd = await postJSON(WILAYAH_API, { level: 'district', parent_code: cityCode });
				vm.wilayah.districts = rd.data?.data ?? [];
			} catch(e) {} finally { vm.wilayah.loadingDistricts = false; }

			if (!distCode) return;
			vm.wilayah.district = distCode;
			vm.form.kode_kecamatan.value = distCode;

			vm.wilayah.loadingVillages = true;
			try {
				const rv = await postJSON(WILAYAH_API, { level: 'sub_district', parent_code: distCode });
				vm.wilayah.villages = rv.data?.data ?? [];
			} catch(e) {} finally { vm.wilayah.loadingVillages = false; }

			if (!vilCode) return;
			vm.wilayah.village = vilCode;
			vm.form.kode_kelurahan.value = vilCode;
		},

		// ── Form actions ──────────────────────────────────────────────────────
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
			vm.form = vm.formlocation();
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
			vm.$emit('parsingForm', vm.parselocation(vm.form), 'location');
		},

		loaderprocess() {
			const left = this.$refs.rootmodal.getBoundingClientRect();
			vm.$refs.Loader.running(left, 'modal', 250);
		},

		setdataform(response) {
			const res = response.data.data;
			vm.form.satusehat_id = res.id ?? '';

			// Identitas
			vm.form.kode.value               = res.identifier?.[0]?.value ?? '';
			vm.form.nama.value               = res.name         ?? '';
			vm.form.alias.value              = res.alias?.[0]   ?? '';
			vm.form.deskripsi.value          = res.description  ?? '';
			vm.form.status.value             = res.status       ?? 'active';
			vm.form.operational_status.value = res.operationalStatus?.code ?? '';
			vm.form.mode.value               = res.mode         ?? 'instance';

			// Tipe
			vm.form.tipe_layanan.value = res.type?.[0]?.coding?.[0]?.code ?? '';
			vm.form.tipe_fisik.value   = res.physicalType?.coding?.[0]?.code ?? 'ro';

			// Service class (extension)
			const scExt   = (res.extension ?? []).find(e => e.url === 'https://fhir.kemkes.go.id/r4/StructureDefinition/LocationServiceClass');
			const scInner = scExt?.extension?.find(e => e.url === 'inpatientServiceClass');
			const scCode  = scInner?.valueCodeableConcept?.coding?.[0]?.code ?? '';
			vm.form.service_class.value = scCode.replace('kelas_', '').toUpperCase() || '';

			// Telecom
			const tel  = (res.telecom ?? []).find(t => t.system === 'phone');
			const fax  = (res.telecom ?? []).find(t => t.system === 'fax');
			const mail = (res.telecom ?? []).find(t => t.system === 'email');
			const web  = (res.telecom ?? []).find(t => t.system === 'url');
			vm.form.telepon.value  = tel?.value  ?? '';
			vm.form.fax.value      = fax?.value  ?? '';
			vm.form.email.value    = mail?.value ?? '';
			vm.form.website.value  = web?.value  ?? '';

			// Alamat
			const addr = res.address ?? {};
			vm.form.address_use.value = addr.use        ?? 'work';
			vm.form.alamat.value      = addr.line?.[0]  ?? '';
			vm.form.kota.value        = addr.city        ?? '';
			vm.form.kode_pos.value    = addr.postalCode  ?? '';

			const adminExt = addr.extension?.[0]?.extension ?? [];
			const provCode  = adminExt.find(e => e.url === 'province')?.valueCode  ?? '';
			const cityCode  = adminExt.find(e => e.url === 'city')?.valueCode      ?? '';
			const distCode  = adminExt.find(e => e.url === 'district')?.valueCode  ?? '';
			const vilCode   = adminExt.find(e => e.url === 'village')?.valueCode   ?? '';
			vm.form.rt.value = adminExt.find(e => e.url === 'rt')?.valueCode ?? '';
			vm.form.rw.value = adminExt.find(e => e.url === 'rw')?.valueCode ?? '';

			// Restore cascading wilayah dropdowns
			vm.restoreWilayah(provCode, cityCode, distCode, vilCode);

			// Posisi
			vm.form.latitude.value  = String(res.position?.latitude  ?? '');
			vm.form.longitude.value = String(res.position?.longitude ?? '');

			// Organisasi & Relasi
			const mgRef = res.managingOrganization?.reference ?? '';
			vm.form.managing_organization.value = mgRef.replace(/^Organization\//, '');
			const poRef = res.partOf?.reference ?? '';
			vm.form.part_of.value = poRef.replace(/^Location\//, '');

			// Jam Operasional
			const hours = res.hoursOfOperation?.[0] ?? null;
			if (hours) {
				vm.form.hours_all_day.value = hours.allDay ? 'true' : 'false';
				vm.form.hours_days.value    = (hours.daysOfWeek ?? []).join(',');
				vm.form.hours_opening.value = (hours.openingTime ?? '').replace(/:00$/, '');
				vm.form.hours_closing.value = (hours.closingTime ?? '').replace(/:00$/, '');
			}
			vm.form.availability_exceptions.value = res.availabilityExceptions ?? '';

			vm.loaderprocess();
		},

		dialog() {
			const text   = vm.form.posisi === 'adddata' ? 'Yakin ingin menambah Location baru ke SatuSehat?' : 'Yakin ingin memperbaharui data Location ini?';
			const button = vm.form.posisi === 'adddata' ? 'Ya, tambah data' : 'Ya, perbaharui data';
			vm.$emit('dialog', text, button, 'formlocation');
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
.ss-select:focus { outline: none; border-color: #0f766e; }
.ss-select:disabled { background: #f8fafc; color: #94a3b8; cursor: not-allowed; }

/* Section dividers */
.form-section-title {
	font-size: 11px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: .5px;
	color: #0f766e;
	border-bottom: 2px solid #ccfbf1;
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
	gap: 10px;
}

/* Wilayah badge (shows selected code inline in label) */
.wil-code {
	font-size: 10px;
	background: #dbeafe;
	color: #1d4ed8;
	border-radius: 4px;
	padding: 0 5px;
	font-family: monospace;
	font-style: normal;
}
.wil-loading-badge {
	font-size: 10px;
	background: #fef9c3;
	color: #ca8a04;
	border-radius: 10px;
	padding: 1px 8px;
	font-weight: 600;
	animation: pulse-badge 1.2s ease-in-out infinite;
}
@keyframes pulse-badge { 0%,100% { opacity: 1; } 50% { opacity: .5; } }

/* Wilayah empty hint */
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
