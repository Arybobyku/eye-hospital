<template>
	<div class="grid" v-if="form">
		<div class="col-7">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">Laporan Tindakan Pasien</h3>
					</div>

					<div class="col-12 mt-3">
  <label class="fw-bold mb-2">Jenis Laporan</label>

  <div class="form-check">
    <input
      class="form-check-input"
      type="radio"
      id="laporanTindakan"
      value="tindakan"
      v-model="jenisLaporan"
      name="jenis_laporan"
    >
    <label class="form-check-label" for="laporanTindakan">
      Laporan Tindakan Pasien
    </label>
  </div>

  <div class="form-check">
    <input
      class="form-check-input"
      type="radio"
      id="laporanDetailTindakan"
      value="detail_tindakan"
      v-model="jenisLaporan"
      name="jenis_laporan"
    >
    <label class="form-check-label" for="laporanDetailTindakan">
      Laporan Detail Tindakan Pasien
    </label>
  </div>
  <br>
</div>
					<div class="col-6">
						<Inputed :ref="form.dari.name" :form="form.dari"></Inputed>
					</div>
					<div class="col-6 form-ml">
						<Inputed :ref="form.ke.name" :form="form.ke"></Inputed>
					</div>
					<div class="col-6">
						<Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)" 
						:ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
						:selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)"></Selected>
					</div>
					<div class="col-6 form-ml">
						<Selected v-on:click="selectbox($event, form.select.asuransi.name, form.select.asuransi.statics)" 
						:ref="form.select.asuransi.name" @selecteditem="selecteditem" @selectclear="selectclear"
						:selection="form.select.asuransi" v-on:keyup="selectfilter($event, form.select.asuransi.name)"></Selected>
					</div>
					<div class="col-6">
						<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
							:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>
					</div>

					<div class="col-6 form-ml">
						<Selected v-on:click="selectbox($event, form.select.alltindakan.name, form.select.alltindakan.statics)" 
							:ref="form.select.alltindakan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.alltindakan" v-on:keyup="selectfilter($event, form.select.alltindakan.name)"></Selected>
					</div>
					
					<div class="col-12">
						<button v-on:click="excel('tindakan')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-5 form-ml">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">Laporan Registrasi Pasien</h3>
					</div>
					<div class="col-6">
						<Inputed :ref="form.darireg.name" :form="form.darireg"></Inputed>
					</div>
					<div class="col-6 form-ml">
						<Inputed :ref="form.kereg.name" :form="form.kereg"></Inputed>
					</div>
					<div class="col-6">
						<Selected v-on:click="selectbox($event, form.select.carabayarreg.name, form.select.carabayarreg.statics)" 
						:ref="form.select.carabayarreg.name" @selecteditem="selecteditem" @selectclear="selectclear"
						:selection="form.select.carabayarreg" v-on:keyup="selectfilter($event, form.select.carabayarreg.name)"></Selected>
					</div>
					<div class="col-6 form-ml">
						<Selected v-on:click="selectbox($event, form.select.asuransireg.name, form.select.asuransireg.statics)" 
						:ref="form.select.asuransireg.name" @selecteditem="selecteditem" @selectclear="selectclear"
						:selection="form.select.asuransireg" v-on:keyup="selectfilter($event, form.select.asuransireg.name)"></Selected>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.dokterreg.name, form.select.dokterreg.statics)" 
							:ref="form.select.dokterreg.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.dokterreg" v-on:keyup="selectfilter($event, form.select.dokterreg.name)"></Selected>
					</div>
					
					<div class="col-12">
						<button v-on:click="excel('registrasi')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- <div class="inner" ref="roottable">
	<div class="grid" v-if="form">
		<div class="col-5">
			<Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)" 
			:ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)"></Selected>
		</div>
		<div class="col-6 form-ml">
			<Selected v-on:click="selectbox($event, form.select.asuransi.name, form.select.asuransi.statics)" 
			:ref="form.select.asuransi.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.asuransi" v-on:keyup="selectfilter($event, form.select.asuransi.name)"></Selected>
		</div>
		<div class="col-1 form-ml">
			<button class="tooltip btn-danger" style="position: relative; top: 20px" v-on:click="loadmain()">
				<vue-feather type="filter"></vue-feather> 
				<span class="tooltiptext">Filter Data</span>
			</button>
			<button class="tooltip btn-success" style="position: relative; top: 20px" v-on:click="printout()">
				<vue-feather type="printer"></vue-feather> 
				<span class="tooltiptext">Cetak ke Excel</span>
			</button>
		</div>
	</div>
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div> -->
</template>

<script>

var vm;
import { defineAsyncComponent } from 'vue';
import { formpermintaan } from './FormData.js';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { 
		toast, 
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
		position: '', jenisLaporan: 'tindakan', // default terpilih
		form: null,
		attach: { 
			link : { 
				list: '/laporan/tindakanmetode',
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
		module: { data: [], column: [], total: 0, ispaging: true }
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

		excel:function(posisi) {
			let uri = '/';
			if (posisi == 'tindakan') {
				let carabayar_uuid = 'empty';
				let asuransi_uuid = 'empty';
				let dokter_uuid = 'empty';
				let layanan_uuid = 'empty';
				if (vm.form.select.carabayar.value != 'Silahkan Pilih' && vm.form.select.carabayar.value != '') { carabayar_uuid = vm.form.select.carabayar.value; }
				if (vm.form.select.asuransi.value != 'Silahkan Pilih' && vm.form.select.asuransi.value != '') { asuransi_uuid = vm.form.select.asuransi.value; }
				if (vm.form.select.dokter.value != 'Silahkan Pilih' && vm.form.select.dokter.value != '') { dokter_uuid = vm.form.select.dokter.value; }
				if (vm.form.select.alltindakan.value != 'Silahkan Pilih' && vm.form.select.alltindakan.value != '') { layanan_uuid = vm.form.select.alltindakan.value; }
				
				if(vm.jenisLaporan == 'tindakan'){
				uri = '/laporan/excel/' + posisi + '/' + vm.form.dari.value + '/' + vm.form.ke.value + '/' + carabayar_uuid + '/' + asuransi_uuid + '/' + dokter_uuid + '/' + layanan_uuid;
			

				}else{
				uri = '/laporan/excel/' + posisi + '-v2/' + vm.form.dari.value + '/' + vm.form.ke.value + '/' + carabayar_uuid + '/' + asuransi_uuid + '/' + dokter_uuid + '/' + layanan_uuid;
			

				}
			}
			else if (posisi == 'registrasi') {
				let carabayar_uuid = 'empty';
				let asuransi_uuid = 'empty';
				let dokter_uuid = 'empty';
				if (vm.form.select.carabayarreg.value != 'Silahkan Pilih' && vm.form.select.carabayarreg.value != '') { carabayar_uuid = vm.form.select.carabayarreg.value; }
				if (vm.form.select.asuransireg.value != 'Silahkan Pilih' && vm.form.select.asuransireg.value != '') { asuransi_uuid = vm.form.select.asuransireg.value; }
				if (vm.form.select.dokterreg.value != 'Silahkan Pilih' && vm.form.select.dokterreg.value != '') { dokter_uuid = vm.form.select.dokterreg.value; }
				
				uri = '/laporan/excel/' + posisi + '/' + vm.form.darireg.value + '/' + vm.form.kereg.value + '/' + carabayar_uuid + '/' + asuransi_uuid + '/' + dokter_uuid;
			}
			window.open(uri);
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