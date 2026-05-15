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

					<!-- Kode Wilayah BPS -->
					<div class="col-12">
						<div class="form-sub-label">Kode Wilayah Administratif (BPS / SatuSehat)</div>
					</div>
					<div class="col-3">
						<Inputed :ref="form.kode_provinsi.name" :form="form.kode_provinsi"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.kode_kota.name" :form="form.kode_kota"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.kode_kecamatan.name" :form="form.kode_kecamatan"></Inputed>
					</div>
					<div class="col-3">
						<Inputed :ref="form.kode_kelurahan.name" :form="form.kode_kelurahan"></Inputed>
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

					<div class="col-6">
						<Inputed :ref="form.managing_organization.name" :form="form.managing_organization"></Inputed>
					</div>
					<div class="col-6">
						<Inputed :ref="form.part_of.name" :form="form.part_of"></Inputed>
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

export default {
	emits: ['dialog', 'parsingForm'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted() {
		vm = this; body = document.body;
		vm.form = vm.formlocation();
	},
	data() {
		return {
			terminate: { show: false, display: 'display: none' },
			form: null,
			btnlbl: '',
		};
	},
	methods: {
		formlocation, parselocation,

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

		aturulang() { vm.form = vm.formlocation(); },

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
			const scExt = (res.extension ?? []).find(e => e.url === 'https://fhir.kemkes.go.id/r4/StructureDefinition/LocationServiceClass');
			const scInner = scExt?.extension?.find(e => e.url === 'inpatientServiceClass');
			const scCode = scInner?.valueCodeableConcept?.coding?.[0]?.code ?? '';
			// Map kelas_1 → '1', kelas_2 → '2', etc.
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
			vm.form.kode_provinsi.value  = adminExt.find(e => e.url === 'province')?.valueCode  ?? '';
			vm.form.kode_kota.value      = adminExt.find(e => e.url === 'city')?.valueCode      ?? '';
			vm.form.kode_kecamatan.value = adminExt.find(e => e.url === 'district')?.valueCode  ?? '';
			vm.form.kode_kelurahan.value = adminExt.find(e => e.url === 'village')?.valueCode   ?? '';
			vm.form.rt.value             = adminExt.find(e => e.url === 'rt')?.valueCode         ?? '';
			vm.form.rw.value             = adminExt.find(e => e.url === 'rw')?.valueCode         ?? '';

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
.ss-select:focus { outline: none; border-color: #1c84ee; }

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
}
</style>
