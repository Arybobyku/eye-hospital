<template>
<div class="grid" v-if="form" ref="rootdiv" style="position: relative;">
	<div class="col-4 form-mr">
		<Selected v-on:click="selectbox($event, form.select.caramasuk.name, form.select.caramasuk.statics)" 
			:ref="form.select.caramasuk.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.caramasuk"></Selected>

		<Inputed :ref="form.rujukan.name" :form="form.rujukan"></Inputed>

		<Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)" 
			:ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)"></Selected>

		<Selected v-on:click="selectbox($event, form.select.asuransi.name, form.select.asuransi.statics)" 
			:ref="form.select.asuransi.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.asuransi" v-on:keyup="selectfilter($event, form.select.asuransi.name)"></Selected>

		<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
			:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>
	</div>
	<div class="col-4 form-ml form-mr">

		<Inputed :ref="form.nopendaftaran.name" :form="form.nopendaftaran" v-on:keyup="hurufbesar($event)"></Inputed>
		<Selected v-on:click="selectbox($event, form.select.berkebutuhankhusus.name, form.select.berkebutuhankhusus.statics)" 
			:ref="form.select.berkebutuhankhusus.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.berkebutuhankhusus"></Selected>
		<Inputed :ref="form.keteranganberkebutuhan.name" :form="form.keteranganberkebutuhan"></Inputed>
		<Selected v-on:click="selectbox($event, form.select.klinik.name, form.select.klinik.statics)" 
			:ref="form.select.klinik.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.klinik"></Selected>
	</div>

	<div class="col-4 form-ml">
		<Inputed :ref="form.pjnama.name" :form="form.pjnama"></Inputed>
		<Selected v-on:click="selectbox($event, form.select.jenisidentitas.name, form.select.jenisidentitas.statics)" 
			:ref="form.select.jenisidentitas.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.jenisidentitas"></Selected>
		<Inputed :ref="form.pjnoidentitas.name" :form="form.pjnoidentitas"></Inputed>
		<Inputed :ref="form.pjhubungan.name" :form="form.pjhubungan"></Inputed>
		<Inputed :ref="form.pjalamat.name" :form="form.pjalamat"></Inputed>
		<Inputed :ref="form.pjnohandphone.name" :form="form.pjnohandphone"></Inputed>
	</div>
	<div :style="cover" v-if="!ishide"></div>
</div>
<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form">
	<div class="col-8"></div>
	<div class="col-4" style="text-align: right"  v-if="ishide">
		<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
		<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green }}</button>
	</div>
	<div class="col-4" style="text-align: right"  v-else>
		<button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan Kunjungan</button>
		<button class="button-modal-page button-modal-green" v-on:click="edit()">Edit Data</button>
	</div>
</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formrawatjalan } from './FormData.js';
import { parserawatjalan } from './Attachment.js';
import { arrregistrasi } from '../../../module/DataArray.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm", "edit", "cancel"],
	props: ['detail', 'iskunjungan'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formrawatjalan();
		vm.arr = vm.arrregistrasi();
		
		setTimeout(() => {
			vm.test = vm.iskunjungan;
			vm.coverblock();
		}, 250);
		
		window.onclick = function(event) { 
			let a = event.target.className; 
			
			try { 
				if (a.split(" ")) { 
					a = a.split(" "); 
					
					if (a[0] != 'hospitals' && a[0] != 'click-title') { 
						vm.selecthide(); 
					} 
				} 
				if (event.target.className == '') { 
					vm.selecthide(); 
				} 
			} 
			catch { console.log('mistmatch'); } }
	},
	computed: {
		ishide:function() {
			if (vm.test) { vm.red = 'Cancel'; }
			return vm.test ? false : true;
		},
	},
	data: function() {
		return {
			green: 'Save Data',
			red: 'Clear Form', test: null,
			form: null, arr: null, cover: '', temporer: null,
		}
	},
	methods: {
		coverblock:function() {
			const left = this.$refs.rootdiv.getBoundingClientRect();
			vm.cover = 'width:'+(left.width+30)+'px;height:'+(left.height+30)+'px;border-radius:4px;position:absolute;left:-15px;top:-15px;background:rgba(0,0,0,0.4)';
		},

		formrawatjalan, parserawatjalan, arrregistrasi,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 
			vm.manipulationform(key, item, true);
		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
			vm.manipulationform(key, '', false);
		},
		selectbox:function(event, key, statics) {

			if (!vm.form.select[key].disabled) {
				let result = vm.boxselected(event, vm.form, key);
				if (result._position == 'stop') { return ; }
				else if (result._position == 'nextstop') { vm.form = result._form; }
				else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
			}
		},

		hurufbesar:function(event) {
			let str = vm.form.nopendaftaran.value.toUpperCase(), tmp = '';
			str = str.replace("-", "");
			str = str.split("");
			if (str.length > 0) {
				if (str.length < 5) {
					if (str[0].length === 1 && str[0].match(/[a-z]/i)) { str[0] = str[0] + '-'; }
					else { vm.form.nopendaftaran.value = ''; return ; }
					for (let i = 0; i < str.length; i++) { tmp += str[i]; }
					vm.form.nopendaftaran.value = tmp;
				}
				else { let str = vm.form.nopendaftaran.value; str = str.substring(0, str.length - (str.length - 5)); vm.form.nopendaftaran.value = str; }	
			}
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
				else {
					for (const keyselect in vm.form.select) {
						if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
					}
				}
			}
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		redbutton:function() {
			if (vm.red == 'Clear Form') { vm.form = vm.formrawatjalan(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
		},

		greenbutton:function() {
			if (vm.green == 'Save Data') { 
				console.log(vm.form, 'dfdf')
				vm.action();
			}
		},

		seteditedv2:function(response, pj) {
			console.log(pj)

			if (pj != '') {
				vm.form.pjnama.value = pj.nama ? pj.nama : '';
				vm.form.pjhubungan.value = pj.hubungan ? pj.hubungan : '';
				vm.form.pjalamat.value = pj.alamat ? pj.alamat : '';
				vm.form.pjnoidentitas.value = pj.no_identitas ? pj.no_identitas : '';
				vm.form.pjnohandphone.value = pj.no_handphone ? pj.no_handphone : '';
				if (pj.jenis_identitas) {
					vm.form.select.jenisidentitas.value = pj.jenis_identitas;
					vm.form.select.jenisidentitas.label = pj.jenis_identitas;
				}
				else {
					vm.form.select.jenisidentitas.value = '';
					vm.form.select.jenisidentitas.label = 'Silahkan Pilih';
				}
			}
			else {
				vm.form.pjnama.value = '';
				vm.form.pjhubungan.value = '';
				vm.form.pjalamat.value = '';
				vm.form.pjnoidentitas.value = '';
				vm.form.pjnohandphone.value = '';
				vm.form.select.jenisidentitas.value = '';
				vm.form.select.jenisidentitas.label = 'Silahkan Pilih';
			}
			

			vm.form.select.caramasuk.value = response.cara_masuk;
			vm.form.select.caramasuk.label = response.cara_masuk;

			let msg = response.rujukan;
			vm.form.rujukan.value = msg != '-' ? msg : '';
			
			vm.form.select.carabayar.value = response.carabayar_uuid;
			vm.form.select.carabayar.label = response.carabayar_nama;

			if (response.asuransi_uuid || response.asuransi_uuid != '' || response.asuransi_uuid != '-') {
				vm.form.select.asuransi.value =  response.asuransi_uuid;
				vm.form.select.asuransi.label =  response.nama_asuransi;
			}
			else {
				vm.form.select.asuransi.value = '';
				vm.form.select.asuransi.label = 'Silahkan Pilih';
			}

			vm.form.select.dokter.value =  response.pengguna_uuid;
			vm.form.select.dokter.label =  response.nama_dokter;
			vm.form.nopendaftaran.value = response.no_pendaftaran;
			
			vm.form.select.berkebutuhankhusus.value = response.berkebutuhan_khusus;
			vm.form.select.berkebutuhankhusus.label = response.berkebutuhan_khusus;

			msg = response.keterangan_berkebutuhan;
			vm.form.keteranganberkebutuhan.value = msg != '-' ? msg : '';

			if (response.ruang_poliklinik && response.ruang_poliklinik != '' && response.ruang_poliklinik != '-') {
				vm.form.select.klinik.value =  response.ruang_poliklinik;
				vm.form.select.klinik.label =  response.ruang_poliklinik;
			}
			else {
				vm.form.select.klinik.value = '';
				vm.form.select.klinik.label = 'Silahkan Pilih';
			}
			console.log(response);
		},

		setedited:function(response) {
			
			console.log(response);
			vm.temporer = vm.test;
			vm.test = null;
			vm.red = 'Back';
			vm.form.uuid = response.data.data.uuid;
			vm.form.select.caramasuk.value = response.data.data.cara_masuk;
			vm.form.select.caramasuk.label = response.data.data.cara_masuk;

			let msg = response.data.data.rujukan;
			vm.form.rujukan.value = msg != '-' ? msg : '';
			
			vm.form.select.carabayar.value = response.data.data.carabayar_uuid;
			vm.form.select.carabayar.label = response.data.data.carabayar_nama;

			if (response.data.data.asuransi_uuid || response.data.data.asuransi_uuid != '' || response.data.data.asuransi_uuid != '-') {
				vm.form.select.asuransi.value =  response.data.data.asuransi_uuid;
				vm.form.select.asuransi.label =  response.data.data.nama_asuransi;
			}
			else {
				vm.form.select.asuransi.value = '';
				vm.form.select.asuransi.label = 'Silahkan Pilih';
			}

			vm.form.select.dokter.value =  response.data.data.pengguna_uuid;
			vm.form.select.dokter.label =  response.data.data.nama_dokter;
			vm.form.nopendaftaran.value = response.data.data.no_pendaftaran;
			
			vm.form.select.berkebutuhankhusus.value = response.data.data.berkebutuhan_khusus;
			vm.form.select.berkebutuhankhusus.label = response.data.data.berkebutuhan_khusus;

			msg = response.data.data.keterangan_berkebutuhan;
			vm.form.keteranganberkebutuhan.value = msg != '-' ? msg : '';

			if (response.data.data.klinik && response.data.data.klinik != '' && response.data.data.klinik != '-') {
				vm.form.select.klinik.value =  response.data.data.klinik;
				vm.form.select.klinik.label =  response.data.data.klinik;
			}
			else {
				vm.form.select.klinik.value = '';
				vm.form.select.klinik.label = 'Silahkan Pilih';
			}

			vm.form.pjnama.value = response.data.penanggungjawab.nama ? response.data.penanggungjawab.nama : '';
			vm.form.pjhubungan.value = response.data.penanggungjawab.hubungan ? response.data.penanggungjawab.hubungan : '';
			vm.form.pjalamat.value = response.data.penanggungjawab.alamat ? response.data.penanggungjawab.alamat : '';
			vm.form.pjnoidentitas.value = response.data.penanggungjawab.no_identitas ? response.data.penanggungjawab.no_identitas : '';
			vm.form.pjnohandphone.value = response.data.penanggungjawab.no_handphone ? response.data.penanggungjawab.no_handphone : '';
			if (response.data.penanggungjawab.jenis_identitas) {
				vm.form.select.jenisidentitas.value = response.data.penanggungjawab.jenis_identitas;
				vm.form.select.jenisidentitas.label = response.data.penanggungjawab.jenis_identitas;
			}
			else {
				vm.form.select.jenisidentitas.value = '';
				vm.form.select.jenisidentitas.label = 'Silahkan Pilih';
			}
			
		},

		edit:function() {
			vm.$emit('edit', vm.test, 'rawatjalan');
		},

		cancel:function() {
			vm.$emit('cancel', vm.test, 'rawatjalan');
		},

		resetform:function() {
			vm.form = vm.formrawatjalan();
		},

		parsingForm:function() { vm.$emit('parsingForm', vm.parserawatjalan(vm.form, vm.detail), 'rawatjalan'); },

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah data pada halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'rawatjalan');
    },

		manipulationform: function (key, item, active) {
			if (key == 'caramasuk') {
				if (item.value == 'Rujukan dari' && active) { 
					vm.form.rujukan.disabled = false; 
					vm.form.rujukan.required = 'required';
				}
				else { 
					vm.form.rujukan.value = '';
					vm.form.rujukan.disabled = true; 
					vm.form.rujukan.required = ''; 
				}
			}
			else if (key == 'carabayar') {
				if (active) {
					
					vm.getIndexDB('asuransi', false);
				}
			}
			else if (key == 'berkebutuhankhusus') {
				if (item.value == 'Ya, Benar' && active) {
					vm.form.keteranganberkebutuhan.required = 'required';
					vm.form.select.klinik.isrequired =  true;
					vm.form.keteranganberkebutuhan.disabled = false;
					vm.form.select.klinik.disabled = false;
				}
				else {
					vm.form.keteranganberkebutuhan.required = '';
					vm.form.keteranganberkebutuhan.value = '';
					vm.form.select.klinik.isrequired =  false;
					vm.form.select.klinik.value = '';
					vm.form.select.klinik.label = 'Silahkan Pilih';
					vm.form.keteranganberkebutuhan.disabled = true;
					vm.form.select.klinik.disabled = true;
				}
			}
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key); 
						console.log(vm.form.select.asuransi.data);
						if (vm.form.select.asuransi.data.length < 1) {
							vm.form.select.asuransi.disabled = true;
							vm.form.select.asuransi.value = '';
							vm.form.select.asuransi.label = 'Silahkan Pilih';
							vm.form.select.asuransi.isrequired = false;
						}
						else if (vm.form.select.asuransi.data.length > 0) {
							vm.form.select.asuransi.disabled = false;
							vm.form.select.asuransi.isrequired = true;
						}
					})
					.catch(function(error){ console.log(error); });
			}
		},
	}
}
</script>