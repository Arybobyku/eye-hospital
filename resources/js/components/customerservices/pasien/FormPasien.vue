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
					<div class="col-4 form-mr">
						<Selected v-on:click="selectbox($event, form.select.sebutan.name, form.select.sebutan.statics)" 
							:ref="form.select.sebutan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.sebutan"></Selected>
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
						<Inputed :ref="form.alias.name" :form="form.alias"></Inputed>
						<Inputed :ref="form.tempatlahir.name" :form="form.tempatlahir"></Inputed>
						<Inputed :ref="form.tanggallahir.name" :form="form.tanggallahir"></Inputed>
						<Selected v-on:click="selectbox($event, form.select.jeniskelamin.name, form.select.jeniskelamin.statics)" 
							:ref="form.select.jeniskelamin.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.jeniskelamin"></Selected>
						<Selected v-on:click="selectbox($event, form.select.agama.name, form.select.agama.statics)" 
							:ref="form.select.agama.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.agama"></Selected>
						<Selected v-on:click="selectbox($event, form.select.statuspernikahan.name, form.select.statuspernikahan.statics)" 
							:ref="form.select.statuspernikahan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.statuspernikahan"></Selected>
						
					</div>
					<div class="col-4 form-mr form-ml">
						<Inputed :ref="form.nohandphone.name" :form="form.nohandphone"></Inputed>
						<Inputed :ref="form.alamat.name" :form="form.alamat"></Inputed>

						<Selected v-on:click="selectbox($event, form.select.provinsi.name, form.select.provinsi.statics)" 
							:ref="form.select.provinsi.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.provinsi" v-on:keyup="selectfilter($event, form.select.provinsi.name)"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kabkota.name, form.select.kabkota.statics)" 
							:ref="form.select.kabkota.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kabkota" v-on:keyup="selectfilter($event, form.select.kabkota.name)"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kecamatan.name, form.select.kecamatan.statics)" 
							:ref="form.select.kecamatan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kecamatan" v-on:keyup="selectfilter($event, form.select.kecamatan.name)"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kelurahan.name, form.select.kelurahan.statics)" 
							:ref="form.select.kelurahan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kelurahan" v-on:keyup="selectfilter($event, form.select.kelurahan.name)"></Selected>

						<Inputed :ref="form.kodepos.name" :form="form.kodepos"></Inputed>
						<Inputed :ref="form.rtrw.name" :form="form.rtrw"></Inputed>
					</div>
					<div class="col-4 form-ml">
						
						<Inputed :ref="form.email.name" :form="form.email"></Inputed>
						<Selected v-on:click="selectbox($event, form.select.jenisidentitas.name, form.select.jenisidentitas.statics)" 
							:ref="form.select.jenisidentitas.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.jenisidentitas"></Selected>
						<Inputed :ref="form.noidentitas.name" :form="form.noidentitas"></Inputed>
						<Selected v-on:click="selectbox($event, form.select.golongandarah.name, form.select.golongandarah.statics)" 
							:ref="form.select.golongandarah.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.golongandarah"></Selected>
						<Selected v-on:click="selectbox($event, form.select.pekerjaan.name, form.select.pekerjaan.statics)" 
							:ref="form.select.pekerjaan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.pekerjaan"></Selected>
						<Selected v-on:click="selectbox($event, form.select.pendidikanterakhir.name, form.select.pendidikanterakhir.statics)" 
							:ref="form.select.pendidikanterakhir.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.pendidikanterakhir"></Selected>
						<Inputed :ref="form.namaayah.name" :form="form.namaayah"></Inputed>
						<Inputed :ref="form.namaibu.name" :form="form.namaibu"></Inputed>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formpasien } from './FormData.js';
import { parsepasien } from './Attachment.js';
import { arrbiodata } from '../../../module/DataArray.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formpasien();
		vm.arr = vm.arrbiodata();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, arr: null, btnlbl: '',
	}},
	methods: {

		parsepasien, formpasien, arrbiodata, initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { vm.form = vm.conditionselected(vm.form, item, key, 'address'); vm.form = vm.itemselected(vm.form, item, key); },
		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key); },
		selectbox:function(event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
			if (result._position == 'stop') { return ; }
			else if (result._position == 'nextstop') { vm.form = result._form; }
			else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ vm.form = vm.indexdbprocessing(response, vm.form, key); })
					.catch(function(error){ console.log(error); });
			}
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid){ vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formpasien(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsepasien(vm.form), 'pasien'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		empty: function (data, number) {
			if (!data || data == '' || data == '-' || data == '0') {
				if (number == 0) { return ''; }
				else { return 'Silahkan Pilih'; }
			}
			else { return data; }
		},

		setdataform: function (response) {
			let data = response.data.data;
			vm.form.uuid = data.uuid;
			vm.form.nama.value = data.nama;
			vm.form.alias.value = vm.empty(data.alias, 0);
			vm.form.tempatlahir.value = data.tempat_lahir;
			vm.form.tanggallahir.value = data.tanggal_lahir;
			vm.form.noidentitas.value = data.no_identitas;
			vm.form.email.value = vm.empty(data.email, 0);
			vm.form.alamat.value = data.alamat;
			vm.form.nohandphone.value = vm.empty(data.no_handphone, 0);
			vm.form.kodepos.value = vm.empty(data.kodepos, 0);
			vm.form.rtrw.value = vm.empty(data.rt_rw, 0);
			vm.form.namaayah.value = vm.empty(data.nama_ayah, 0);
			vm.form.namaibu.value = vm.empty(data.nama_ibu, 0);

			vm.form.select.provinsi.value = data.provinsi_id;
			vm.form.select.provinsi.label = data.nama_provinsi;

			vm.form.select.kabkota.value = data.kab_kota_id;
			vm.form.select.kabkota.label = data.nama_kab_kota;

			vm.form.select.kecamatan.value = data.kecamatan_id;
			vm.form.select.kecamatan.label = data.nama_kecamatan;

			vm.form.select.kelurahan.value = data.kelurahan_id;
			vm.form.select.kelurahan.label = data.nama_kelurahan;

			vm.form.select.pendidikanterakhir.value = vm.empty(data.pendidikan_terakhir, 0);
			vm.form.select.pendidikanterakhir.label = vm.empty(data.pendidikan_terakhir, 1);

			vm.form.select.pekerjaan.value = vm.empty(data.pekerjaan, 0);
			vm.form.select.pekerjaan.label = vm.empty(data.pekerjaan, 1);

			vm.form.select.statuspernikahan.value = vm.empty(data.status_pernikahan, 0);
			vm.form.select.statuspernikahan.label = vm.empty(data.status_pernikahan, 1);

			vm.form.select.agama.value = data.agama;
			vm.form.select.agama.label = data.agama;

			vm.form.select.jeniskelamin.value = data.jenis_kelamin;
			vm.form.select.jeniskelamin.label = data.jenis_kelamin;

			vm.form.select.jenisidentitas.value = data.jenis_identitas;
			vm.form.select.jenisidentitas.label = data.jenis_identitas;

			vm.form.select.sebutan.value = data.sebutan;
			vm.form.select.sebutan.label = data.sebutan;

			vm.form.select.golongandarah.value = vm.empty(data.golongan_darah, 0);
			vm.form.select.golongandarah.label = vm.empty(data.golongan_darah, 1);
			
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			if (vm.form.posisi == 'adddata') {
				text = 'Yakin ingin menambah data pada halaman ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin memperbaharui data ini.';
				button = 'Ya, perbaharui data';
			}
      vm.$emit('dialog', text, button, 'formpasien');
    },
	}
}
</script>