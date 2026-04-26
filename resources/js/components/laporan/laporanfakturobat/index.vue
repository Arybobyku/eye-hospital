<template>
<div class="inner" ref="roottable">
	<div class="grid" v-if="form">
		<div class="col-11">
			<Inputed :ref="form.dari.name" :form="form.dari"></Inputed>
		</div>
		<!-- <div class="col-6 form-ml">
			<Inputed :ref="form.ke.name" :form="form.ke"></Inputed>
		</div> -->
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
</div>
</template>

<script>

var vm;
import { defineAsyncComponent } from 'vue';
import { formpermintaan } from './FormData.js';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { 
		toast, 
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')) ,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		setTimeout(() => {
			vm.form = vm.formpermintaan();
		}, 1250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'histori',
		position: '',
		form: null,
		attach: { 
			link : { 
				list: '/laporan/fakturobat',
				printouts: '/laporan/excelfakturobat',
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
		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },

		loadmain: () => {
			vm.position = 'loadmain'; 
			vm.firstloader(); 
			vm.tableload();
		},

		gagal: function (error) {
			console.log(error)
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'cetak') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'loadmain') { 
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.paging(); active = 0;
			}
			else if (vm.position == 'cetak') { 
				vm.firstloader();
				active = 1;
			}
			else if (vm.position == 'externaltable') { 
				vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.paging(); active = 0;
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'cetak') { vm.notification('Gagal mencetak data ke excel.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'cetak') { vm.notification('Cetakan excel berhasil diproses.', 3000, position); }
			}
		},

		printout:function() {
			window.open(vm.attach.link.printouts + '/' + vm.form.dari.value, '_blank')
			//vm.firstloader();
			// vm.position = 'cetak';
			// vm.attach.url = vm.attach.link.printouts; 
			// vm.attach.data = new FormData(); 
			// vm.attach.data.append('dari', vm.form.dari.value); 
			// vm.attach.data.append('ke', vm.form.ke.value);
			// vm.executions(); 
		},

		tableload:function() { 
			vm.attach.url = vm.attach.link.list; 
			vm.attach.data = new FormData(); 
			vm.attach.data.append('search', '');
			 vm.attach.data.append('column', ''); 
			 vm.attach.data.append('page', 1); 
			 if (vm.form) {
				vm.attach.data.append('dari', vm.form.dari.value); 
			 }
			 else {
				vm.attach.data.append('dari', ''); 
			 }

			//  if (vm.form) {
			// 	vm.attach.data.append('ke', vm.form.ke.value); 
			//  }
			//  else {
			// 	vm.attach.data.append('ke', ''); 
			//  }
			 
			 vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (pos == 'outer') { vm.$refs.Datatable.skeleton(); }
			vm.attach.url = vm.attach.link.list; 
			vm.attach.data = data; 
			if (vm.form) {
				vm.attach.data.append('dari', vm.form.dari.value); 
			 }
			 else {
				vm.attach.data.append('dari', ''); 
			 }

			//  if (vm.form) {
			// 	vm.attach.data.append('ke', vm.form.ke.value); 
			//  }
			//  else {
			// 	vm.attach.data.append('ke', ''); 
			//  }
			vm.position = 'externaltable'; 
			vm.executions(); },

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