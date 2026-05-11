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
					<!-- Baris 1: Kode & Nama -->
					<div class="col-4">
						<Inputed :ref="form.kode.name" :form="form.kode"></Inputed>
					</div>
					<div class="col-8">
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
					</div>

					<!-- Baris 2: Deskripsi -->
					<div class="col-12">
						<Inputed :ref="form.deskripsi.name" :form="form.deskripsi"></Inputed>
					</div>

					<!-- Baris 3: Status, Mode, Tipe Fisik -->
					<div class="col-4">
						<div class="form-self-group">
							<select v-model="form.status.value" class="ss-select" :id="form.status.for_id">
								<option v-for="opt in form.status.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.status.for_id">{{ form.status.title }}</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-self-group">
							<select v-model="form.mode.value" class="ss-select" :id="form.mode.for_id">
								<option v-for="opt in form.mode.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.mode.for_id">{{ form.mode.title }}</label>
						</div>
					</div>
					<div class="col-4">
						<div class="form-self-group">
							<select v-model="form.tipe_fisik.value" class="ss-select" :id="form.tipe_fisik.for_id">
								<option v-for="opt in form.tipe_fisik.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
							<label :for="form.tipe_fisik.for_id">{{ form.tipe_fisik.title }}</label>
						</div>
					</div>

					<!-- Baris 4: Kontak -->
					<div class="col-4">
						<Inputed :ref="form.telepon.name" :form="form.telepon"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.fax.name" :form="form.fax"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.email.name" :form="form.email"></Inputed>
					</div>

					<!-- Baris 5: Alamat -->
					<div class="col-8">
						<Inputed :ref="form.alamat.name" :form="form.alamat"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.kota.name" :form="form.kota"></Inputed>
					</div>

					<!-- Baris 6: Kode Wilayah -->
					<div class="col-3">
						<Inputed :ref="form.kode_pos.name" :form="form.kode_pos"></Inputed>
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

					<!-- Baris 7: Kelurahan & Koordinat -->
					<div class="col-4">
						<Inputed :ref="form.kode_kelurahan.name" :form="form.kode_kelurahan"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.latitude.name" :form="form.latitude"></Inputed>
					</div>
					<div class="col-4">
						<Inputed :ref="form.longitude.name" :form="form.longitude"></Inputed>
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
				if (vm.form[key].required && vm.form[key].value === '') { next = false; }
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
			vm.form.kode.value      = res.identifier?.[0]?.value ?? '';
			vm.form.nama.value      = res.name         ?? '';
			vm.form.deskripsi.value = res.description  ?? '';
			vm.form.status.value    = res.status        ?? 'active';
			vm.form.mode.value      = res.mode          ?? 'instance';
			vm.form.tipe_fisik.value = res.physicalType?.coding?.[0]?.code ?? 'ro';

			const tel = (res.telecom ?? []).find(t => t.system === 'phone');
			const fax = (res.telecom ?? []).find(t => t.system === 'fax');
			const mail= (res.telecom ?? []).find(t => t.system === 'email');
			vm.form.telepon.value = tel?.value  ?? '';
			vm.form.fax.value     = fax?.value  ?? '';
			vm.form.email.value   = mail?.value ?? '';

			const addr = res.address ?? {};
			vm.form.alamat.value   = addr.line?.[0]   ?? '';
			vm.form.kota.value     = addr.city         ?? '';
			vm.form.kode_pos.value = addr.postalCode   ?? '';

			const adminExt = addr.extension?.[0]?.extension ?? [];
			vm.form.kode_provinsi.value  = adminExt.find(e => e.url === 'province')?.valueCode ?? '';
			vm.form.kode_kota.value      = adminExt.find(e => e.url === 'city')?.valueCode     ?? '';
			vm.form.kode_kecamatan.value = adminExt.find(e => e.url === 'district')?.valueCode ?? '';
			vm.form.kode_kelurahan.value = adminExt.find(e => e.url === 'village')?.valueCode  ?? '';

			vm.form.latitude.value  = String(res.position?.latitude  ?? '');
			vm.form.longitude.value = String(res.position?.longitude ?? '');

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
</style>
