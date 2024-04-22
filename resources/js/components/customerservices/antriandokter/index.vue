<template>
<div class="inner">
	<div class="grid">
		<div class="col-6" style="height: auto; border-right: 1px solid #d5d5d5; padding-right: 20px;">
			<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
				:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>

			<Selected v-on:click="selectbox($event, form.select.berkebutuhankhusus.name, form.select.berkebutuhankhusus.statics)" 
				:ref="form.select.berkebutuhankhusus.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.berkebutuhankhusus"></Selected>

			<Inputed :ref="form.nopendaftaran.name" :form="form.nopendaftaran"></Inputed>

			<div style="text-align: right">
				<button class="button-modal-page button-modal-green" style="width: 100%; margin-top: 16px" v-on:click="filtering()">Filter Pencarian</button>
			</div>
		</div>
		<div class="col-6" style="height: auto; padding-left: 20px;" ref="roottable">
			<div class="grid">
				<div class="col-4">
					<div style="width: 100%; text-align: center;">
						<h2 style="font-size: 75px; font-weight: bold;">{{ hasil.antriansaatini }}</h2>
						<p>No Antrian Saat Ini</p>
					</div>
				</div>
				<div class="col-4">
					<div style="width: 100%; text-align: center;">
						<h2 style="font-size: 75px; font-weight: bold;">{{ hasil.sisaantrian }}</h2>
						<p>Sisa Antrian</p>
					</div>
				</div>
				<div class="col-4">
					<div style="width: 100%; text-align: center;">
						<h2 style="font-size: 75px; font-weight: bold;">{{ hasil.nopoli }}</h2>
						<p>No Poli Tujuan</p>
					</div>
				</div>
				<div class="col-12" v-if="hasil.msg != ''">
					<div class="message">{{ hasil.msg }}</div>
				</div>
			</div>
			<div :style="loading.main" class="wrap-loading-main">
				<div class="loading-main">
					<div class="boxes">
						<div class="box"><div></div><div></div><div></div><div></div></div>
						<div class="box"><div></div><div></div><div></div><div></div></div>
						<div class="box"><div></div><div></div><div></div><div></div></div>
						<div class="box"><div></div><div></div><div></div><div></div></div>
					</div>
					<h3>Please Wait ...</h3>
				</div>
			</div>
		</div>
	</div>
	
</div>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
import { formunit } from './FormData.js';
import { arrregistrasi } from '../../../module/DataArray.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		//vm.loadmain();
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
	data: function () { return {
		loading: { main: 'display: none' },
		hasil: {
			sisaantrian: 0,
			antriansaatini: 'A-000',
			nopoli: 0,
			msg: ''
		},
		uri: 'unit',
		position: '',
		attach: {
			link : {
				list: '/customerservices/pasien/rawatjalan',
			}, url: '', data: null
		},
		pengguna_uuid: '', berkebutuhankhusus: '',
		form: {
			nopendaftaran: { 
				title: 'Nomor Antrian', for_id: 'form_'+'nopendaftaran', type: 'text', required: 'required', 
				name: 'nopendaftaran', value: '', disabled: false, show: true, kinds: ''
			},
			select: {
				berkebutuhankhusus: { 
					key : 'berkebutuhankhusus', for_id: 'form_'+'berkebutuhankhusus', name: 'berkebutuhankhusus', uuid:'', value: '', label: 'Silahkan Pilih', 
					filter: [], data: [], search: '', option: 'display: none', statics: true,
					class: 'berkebutuhankhusus', isrequired: true, html: 'Berkebutuhan Khusus/Triase/Disabilitas?', issearch: false, disabled: false,
				},
				
				dokter: { 
					key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
					filter: [], data: [], search: '', option: 'display: none', statics: false,
					class: 'dokter', isrequired: true, html: 'Dokter yang menangani', issearch: false, disabled: false,
				},
			},
		},
		arr: {
			berkebutuhankhusus: [
				{ value: 'Tidak', label: 'Tidak' },
				{ value: 'Ya, Benar', label: 'Ya, Benar' }
			],
		},
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,
		formunit,

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/
		arrregistrasi,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 
		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
		},
		selectbox:function(event, key, statics) {

			if (!vm.form.select[key].disabled) {
				let result = vm.boxselected(event, vm.form, key);
				if (result._position == 'stop') { return ; }
				else if (result._position == 'nextstop') { vm.form = result._form; }
				else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
			}
		},

		filtering:function() {
			let next = true;
			for (const key in vm.form) {
				for (const keyselect in vm.form.select) {
					if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
				}
			}
			
			if (next) {
				vm.hasil.msg = '';
				vm.pengguna_uuid = vm.form.select.dokter.value;
				vm.berkebutuhankhusus = vm.form.select.berkebutuhankhusus.value;
				vm.firstloader();
				vm.attach.url = vm.attach.link.list; 
				vm.attach.data = new FormData(); 
				vm.position = 'lihatantrian';
				vm.attach.data.append('no_pendaftaran', vm.form.nopendaftaran.value);
				vm.attach.data.append('pengguna_uuid', vm.pengguna_uuid);
				vm.attach.data.append('nama_dokter', vm.form.select.dokter.label);
				vm.attach.data.append('berkebutuhan_khusus', vm.berkebutuhankhusus);
				vm.executions(); 
			}
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key);
					})
					.catch(function(error){ console.log(error); });
			}
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'lihatantrian') { vm.firstloader(); active = 1; }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'lihatantrian') { 
				vm.firstloader();
				active = 0;
				vm.hasil.sisaantrian = response.data.antrian_no;
				vm.hasil.antriansaatini = response.data.antrian_saat_ini;
				vm.hasil.nopoli = response.data.no_poli;
				vm.hasil.msg = response.data.msg;
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'lihatantrian') { vm.notification('Data gagal dimuat.', 3000, position); }
			}
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch: function () {},
		firstloader: function () { 
			const left = this.$refs.roottable.getBoundingClientRect(); 
			this.loading.main = this.loading.main == 
					'display: none' ? 'display:block;width:'+(left.width-2)+'px;height:'+(left.height)+'px; left: '+(left.width+20)+'px; top: 0' : 'display: none';
		},
		unloadPatch: function (position) {},
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
}
</script>
<style>
.message {
	width: 100%; 
	height: auto; 
	float: left;
	border-radius: 4px; 
	margin-top: 25px; 
	color: #FFF; 
	padding: 15px 20px; 
	background-color: #62ad9b;
}
</style>
