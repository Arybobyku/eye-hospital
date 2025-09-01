<template>
	<div class="grid" v-if="form">

		<div class="col-3">
			<div class="inner wrap-laporan" style="padding: 5px 2px 5px;" ref="roottable">
				<div class="grid">
					<div class="col-12" style="position: relative;">
						<h3 style="text-decoration: underline;">(Apotek) Data Stock</h3>
						<button v-on:click="datastock('apotek')" class="excels" style="position: absolute; top: 15px; right: 0">Excel</button>
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml">
			<div class="inner wrap-laporan" style="padding: 5px 2px;" ref="roottable">
				<div class="grid">
					<div class="col-12" style="position: relative;">
						<h3 style="text-decoration: underline;">(Gudang) Data Stock</h3>
						<button v-on:click="datastock('gudang')" class="excels" style="position: absolute; top: 15px; right: 0">Excel</button>
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml">
			<div class="inner wrap-laporan" style="padding: 5px 2px;" ref="roottable">
				<div class="grid">
					<div class="col-12" style="position: relative;">
						<h3 style="text-decoration: underline;">(Bedah Central) Data Stock</h3>
						<button v-on:click="datastock('bedah')" class="excels" style="position: absolute; top: 15px; right: 0">Excel</button>
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml">
			<div class="inner wrap-laporan" style="padding: 5px 2px;" ref="roottable">
				<div class="grid">
					<div class="col-12" style="position: relative;">
						<h3 style="text-decoration: underline;">(Rawat Jalan) Data Stock</h3>
						<button v-on:click="datastock('rawatjalan')" class="excels" style="position: absolute; top: 15px; right: 0">Excel</button>
					</div>
				</div>
			</div>
		</div>

		<div class="col-4 form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Apotek) Penjualan Obat/Alkes</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
							:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.dari.name" :form="form.dari"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.ke.name" :form="form.ke"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('penjualanapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-4 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Gudang) Faktur Obat/alkes</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.supplier.name, form.select.supplier.statics)" 
							:ref="form.select.supplier.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.supplier" v-on:keyup="selectfilter($event, form.select.supplier.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darifaktur.name" :form="form.darifaktur"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kefaktur.name" :form="form.kefaktur"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('fakturgudang')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-4 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(All) Kartu Stock</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.obat.name, form.select.obat.statics)" 
											:ref="form.select.obat.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.obat" v-on:keyup="selectfilter($event, form.select.obat.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darikartustockall.name" :form="form.darikartustockall"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kekartustockall.name" :form="form.kekartustockall"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="kartustock('kartustockall')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-mt form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Apotek) Stock Opname</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.stockopnameapotek.name" :form="form.stockopnameapotek"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('stockopnameapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Gudang) Stock Opname</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.stockopnamegudang.name" :form="form.stockopnamegudang"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('stockopnameapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Bedah Central) Stock Opname</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.stockopnamegudang.name" :form="form.stockopnamegudang"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('stockopnameapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>

			</div>
		</div>

		<div class="col-3 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Rawat Jalan) Stock Opname</h3>
					</div>
					<div class="col-12">
						<Inputed :ref="form.stockopnamegudang.name" :form="form.stockopnamegudang"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('stockopnameapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>

			</div>
		</div>

		<div class="col-3  form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Gudang) Kartu Stock</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.obatgudang.name, form.select.obatgudang.statics)" 
									:ref="form.select.obatgudang.name" @selecteditem="selecteditem" @selectclear="selectclear"
									:selection="form.select.obatgudang" v-on:keyup="selectfilter($event, form.select.obatgudang.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darikartustockgudang.name" :form="form.darikartustockgudang"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kekartustockgudang.name" :form="form.kekartustockgudang"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('kartustockgudang')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Apotek) Kartu Stock</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)" 
											:ref="form.select.apotek.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.apotek" v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darikartustockapotek.name" :form="form.darikartustockapotek"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kekartustockapotek.name" :form="form.kekartustockapotek"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('kartustockapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Bedah Central) Kartu Stock</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)" 
											:ref="form.select.apotek.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.apotek" v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darikartustockapotek.name" :form="form.darikartustockapotek"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kekartustockapotek.name" :form="form.kekartustockapotek"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('kartustockapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-3 form-ml form-mt">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Rawat Jalan) Kartu Stock</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)" 
											:ref="form.select.apotek.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.apotek" v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.darikartustockapotek.name" :form="form.darikartustockapotek"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.kekartustockapotek.name" :form="form.kekartustockapotek"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('kartustockapotek')" class="excels">Cetak ke Excel</button>
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					</div>
				</div>
			</div>
		</div>

		<!-- <div class="col-4 form-ml">
			<div class="inner wrap-laporan" ref="roottable">
				<div class="grid">
					<div class="col-12">
						<h3 style="text-decoration: underline;">(Gudang) Retur Obat/alkes</h3>
					</div>
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.supplierretur.name, form.select.supplierretur.statics)" 
							:ref="form.select.supplierretur.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.supplierretur" v-on:keyup="selectfilter($event, form.select.supplierretur.name)"></Selected>
					</div>
					<div class="col-12">
						<Inputed :ref="form.dariretur.name" :form="form.dariretur"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.keretur.name" :form="form.keretur"></Inputed>
					</div>
					<div class="col-12">
						<button v-on:click="excel('returgudang')" class="excels">Cetak ke Excel</button> -->
						<!-- <button v-on:click="pdf()" class="pdfs">Cetak ke Pdf</button> -->
					<!-- </div>
				</div>
			</div>
		</div>-->
	</div> 
<!-- <div class="inner" ref="roottable">
	<div class="grid" v-if="form">
		<div class="col-4">
			<h2>Laporan Penjualan Obat</h2>
			<div class="col-12">
				<Inputed :ref="form.dari.name" :form="form.dari"></Inputed>
			</div>
			<div class="col-12">
				<Inputed :ref="form.dari.name" :form="form.dari"></Inputed>
			</div>
			<div class="col-12">
				<Inputed :ref="form.ke.name" :form="form.ke"></Inputed>
			</div>
			<div class="col-12">
				<button v-on:click="action()">Cetak ke Excel</button>
				<button v-on:click="action()">Cetak ke Pdf</button>
			</div>
		</div>
		<div class="col-4"></div>
		<div class="col-4"></div>
		
	</div>
	<div class="grid">
		
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
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
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
			link : { }, 
		url: '', data: null },
	}},
	methods: {
		formpermintaan,
		
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
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

		kartustock:function(posisi) {
			let dari = 'kosong', ke = 'kosong', nama_obat = 'kosong';
			if (posisi == 'kartustockall') { 
				dari = vm.form.darikartustockall.value ? vm.form.darikartustockall.value : 'kosong'; 
				ke = vm.form.kekartustockall.value ? vm.form.kekartustockall.value : 'kosong'; 
				nama_obat =  vm.form.select.obat.label != '' && vm.form.select.obat.label != 'Silahkan Pilih' ? vm.form.select.obat.value : 'kosong';
			}
			let uri = '/preview/kartustock/stock/' + posisi + '/' + nama_obat + '/' + dari + '/' + ke;
			window.open(uri);
		},
		
		datastock:function(posisi) {
			let uri = '/preview/datastock/stock/' + posisi;
			window.open(uri);
		},

		excel:function(posisi) {
			let uri = '/';
			if (posisi == 'penjualanapotek') {
				let tmp = 'empty';
				if (vm.form.select.dokter.value != 'Silahkan Pilih' && vm.form.select.dokter.value != '') { tmp = vm.form.select.dokter.value; }
				uri = '/laporan/excel/' + posisi + '/' + vm.form.dari.value + '/' + vm.form.ke.value + '/' + tmp;
			}
			else if (posisi == 'fakturgudang') {
				let tmp = 'empty';
				if (vm.form.select.supplier.value != 'Silahkan Pilih' && vm.form.select.supplier.value != '') { tmp = vm.form.select.supplier.value; }
				uri = '/laporan/excel/' + posisi + '/' + vm.form.darifaktur.value + '/' + vm.form.kefaktur.value + '/' + tmp;
			}
			else if (posisi == 'stockopnameapotek') {
				uri = '/laporan/excel/' + posisi + '/' + vm.form.stockopnameapotek.value;
			}
			else if (posisi == 'stockopnamegudang') {
				uri = '/laporan/excel/' + posisi + '/' + vm.form.stockopnamegudang.value;
			}
			else if (posisi == 'returgudang') {
				let tmp = 'empty';
				if (vm.form.select.supplierretur.value != 'Silahkan Pilih' && vm.form.select.supplierretur.value != '') { tmp = vm.form.select.supplierretur.value; }
				uri = '/laporan/excel/' + posisi + '/' + vm.form.dariretur.value + '/' + vm.form.keretur.value + '/' + tmp;
			}
			else if (posisi == 'fakturgudang') {
				let tmp = 'empty';
				if (vm.form.select.supplierretur.value != 'Silahkan Pilih' && vm.form.select.supplierretur.value != '') { tmp = vm.form.select.supplierretur.value; }
				uri = '/laporan/excel/' + posisi + '/' + vm.form.dariretur.value + '/' + vm.form.keretur.value + '/' + tmp;
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