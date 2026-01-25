<template>
	<div class="grid" v-if="form">
		<div class="col-6">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">Data Klaim Prodia</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.dariprodia.name" :form="form.dariprodia"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.keprodia.name" :form="form.keprodia"></Inputed>
					</div>
					
					<div class="col-12">
						<button v-on:click="preview('prodia')" class="excels">Preview Data</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-6 form-ml">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">Data Klaim BPJS Ketenagakerjaan</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.daribpjstk.name" :form="form.daribpjstk"></Inputed>
					</div>
					<div class="col-12 ">
						<Inputed :ref="form.kebpjstk.name" :form="form.kebpjstk"></Inputed>
					</div>
					
					<div class="col-12">
						<button v-on:click="preview('bpjstk')" class="excels">Preview Data</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">Data Klaim Perusahaan Listrik Negara (PLN)</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.daripln.name" :form="form.daripln"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kepln.name" :form="form.kepln"></Inputed>
					</div>
					
					<div class="col-12">
						<button v-on:click="preview('pln')" class="excels">Preview Data</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-6 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">Data Klaim Socfindo</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darisocfindo.name" :form="form.darisocfindo"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kesocfindo.name" :form="form.kesocfindo"></Inputed>
					</div>
					
					<div class="col-12">
						<button v-on:click="preview('socfindo')" class="excels">Preview Data</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<FormPreview ref="FormPreview" @dialog="dialog" @parsingForm="parsingForm"></FormPreview>
</template>

<script>

var vm;
import { defineAsyncComponent } from 'vue';
import { formpermintaan } from './FormData.js';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { 
		toast, 
		FormPreview: defineAsyncComponent(() => import('./FormPreview.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')) ,
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		setTimeout(() => {
			vm.form = vm.formpermintaan();
		}, 1250);
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
		uri: 'histori',
		position: '',
		form: null,
		attach: { 
			link : { 
				getdata: '/preview/claimgabungan/get',
				adddata: '/preview/claimgabungan/add',
				ubahdata: '/preview/claimgabungan/ubah',
				printouts: '/laporan/exceltindakanmetode',
			}, 
		url: '', data: null },
		column: [
			{ value: 'nama_supplier', label: 'Nama Vendor', type: 'text', search: false, close: false, button: false },
			{ value: 'no_faktur', label: 'No Invoice', type: 'text', search: false, close: false, button: false },
			{ value: 'jumlah', label: 'Jumlah', type: 'text', search: false, close: false, button: false },
			{ value: 'total', label: 'Total', type: 'text', search: false, close: false, button: false },
			{ value: 'penerima', label: 'Verifikasi Staff', type: 'text', search: false, close: false, button: false },
		],
		module: { data: [], column: [], total: 0, ispaging: true },
		position: '',
	}},
	methods: {
		formpermintaan,

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

		manipulationform: function (key, item, active) {
			if (key == 'carabayar') {
				if (active) {
					vm.getIndexDB('asuransi', false);
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
							vm.form.select.asuransi.isrequired = false;
						}
					})
					.catch(function(error){ console.log(error); });
			}
		},

		preview:function(posisi) {
			vm.position = 'preview';
			vm.$refs.FormPreview.aturulang();
			vm.$refs.FormPreview.show('preview', 'Preview Data', posisi);
			setTimeout(() => { vm.loadingModal('formpreview'); }, 250, this);
			vm.attach.data = new FormData();
			vm.attach.data.append('posisi', posisi);
			vm.attach.url = vm.attach.link.getdata;
			let dari = '', ke = '';
			if (posisi == 'prodia') { dari = vm.form.dariprodia.value; ke = vm.form.keprodia.value; }
			else if (posisi == 'bpjstk') { dari = vm.form.daribpjstk.value; ke = vm.form.kebpjstk.value; }
			else if (posisi == 'socfindo') { dari = vm.form.darisocfindo.value; ke = vm.form.kesocfindo.value; }
			else if (posisi == 'pln') { dari = vm.form.daripln.value; ke = vm.form.kepln.value; }
			vm.attach.data.append('dari', dari);
			vm.attach.data.append('ke', ke);
			vm.executions();
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'preview') { vm.position = 'updatedata'; vm.attach.url = vm.attach.link.adddata; } 
			else if (key == 'ubah') { vm.position = 'ubahdata'; vm.attach.url = vm.attach.link.ubahdata; } 
		},

		loadingModal: function (position) { 
			if (position == 'formpreview') { vm.$refs.FormPreview.loaderprocess();  }
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'preview') { vm.loadingModal('formpreview'); vm.$refs.FormPreview.hide(); }
			else if (vm.position == 'updatedata') { vm.loadingModal('formpreview'); }
			else if (vm.position == 'ubahdata') { vm.loadingModal('formpreview'); }
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},
		
		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
			
			if (vm.position == 'preview') {
				vm.$refs.FormPreview.setdataform(response);
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.$refs.FormPreview.setdataform(response);
				active = 1; 
			}
			else if (vm.position == 'ubahdata') {
				vm.$refs.FormPreview.setdataform(response);
				active = 1; 
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'preview') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Penambahan data no kwitansi gagal diproses.', 3000, position); }
				else if (vm.position == 'ubahdata') { vm.notification('Perubahan status pembayaran terkait klaim gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'updatedata') { vm.notification('Penambahan data no kwitansi berhasil diproses.', 3000, position); }
				else if (vm.position == 'ubahdata') { vm.notification('Perubahan status pembayaran terkait klaim berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formpreview') { vm.loadingModal('formpreview'); }
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { 
			axios.post(vm.attach.url, vm.attach.data, {
				 headers: { 
					'Content-Type': 'multipart/form-data',
				 } 
				}).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
	
}
</script>
<style>
.excels, .pdfs {
	padding: 7px 16px;
	border-radius: 4px;
	margin: 0px 4px;
	cursor: pointer;
	background: #15532b;
	border: 1px solid #0d4721;
	color: #fff;
}

.excels:hover, .pdfs:hover {
	background: #0d4721;
	border: 1px solid #063617;
}

.wrap-laporan {
	background: #fff; border: 1px solid #d5d5d5; padding: 8px 16px 30px; border-radius: 10px;
}
</style>