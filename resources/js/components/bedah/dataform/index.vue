<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormUnit ref="FormUnit" @dialog="dialog" @parsingForm="parsingForm"></FormUnit>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal, 
		FormUnit: defineAsyncComponent(() => import('./FormUnit.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'unit',
		position: '',
		attach: {
			link : {
				list: '/bedah/dataform/list',
				formall: '/bedah/dataform/formall',
				laporanpembedahan: '/bedah/dataform/laporanpembedahan',
				checklistkesiapanbedah: '/bedah/dataform/checklistkesiapanbedah',
				perawatanperioperative: '/bedah/dataform/perawatanperioperative',
				catatanoperasikatarak: '/bedah/dataform/catatanoperasikatarak',
				persetujuantindakankedokteran: '/bedah/dataform/persetujuantindakankedokteran',
				checklistkeselamatanbedah: '/bedah/dataform/checklistkeselamatanbedah',
			}, url: '', data: null
		},
		column: [
			{ value: 'tanggal', label: 'Tanggal', type: 'text', search: true, close: false, button: false },
			{ value: 'waktu', label: 'Waktu', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis', label: 'Jenis Bedah', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_paket', label: 'Paket Bedah', type: 'text', search: true, close: false, button: false },
			{ value: 'status', label: 'Status', type: 'text', search: true, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'book', color: 'btn-info', posisi: 'surat', tooltip: 'Data form dan surat', item: _item, index: _index, 
					show: true },
			]
			return str;
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'surat') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "suratdata";
				vm.$refs.FormUnit.show('suratdata', 'Data Form Bedah/Operasi', data);
				setTimeout(() => { vm.loadingModal('formunit'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
				vm.attach.url = vm.attach.link.formall;
				vm.executions();
			}
		},

		loadingModal: function (position) { 
			if (position == 'formunit') { vm.$refs.FormUnit.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			vm.position = 'loadinternal';
			if (key == 'laporanpembedahan') { vm.attach.url = vm.attach.link.laporanpembedahan; }
			else if (key == 'checklistkesiapanbedah') { vm.attach.url = vm.attach.link.checklistkesiapanbedah; }
			else if (key == 'perawatanperioperative') { vm.attach.url = vm.attach.link.perawatanperioperative; }
			else if (key == 'catatanoperasikatarak') { vm.attach.url = vm.attach.link.catatanoperasikatarak; }
			else if (key == 'persetujuantindakankedokteran') { vm.attach.url = vm.attach.link.persetujuantindakankedokteran; }
			else if (key == 'checklistkeselamatanbedah') { vm.attach.url = vm.attach.link.checklistkeselamatanbedah; }
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },
		tableload:function() { vm.attach.url = vm.attach.link.list; vm.attach.data = new FormData(); vm.attach.data.append('search', ''); vm.attach.data.append('column', ''); vm.attach.data.append('page', 1); vm.executions(); },
		tablereload:function(data = new FormData(), pos = 'main') { if (pos == 'outer') { vm.$refs.Datatable.skeleton(); } vm.attach.url = vm.attach.link.list; vm.attach.data = data; vm.position = 'externaltable'; vm.executions(); },

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		loadmain: () => { vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); },

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); }
			else if (vm.position == 'suratdata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'loadinternal') { vm.loadingModal('formunit'); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'loadmain') { 
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.paging(); 
				active = 0;
			}
			else if (vm.position == 'externaltable') { 
				vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.skeleton(); 
				vm.$refs.Datatable.paging(); 
				active = 0;
			}
			else if (vm.position == 'suratdata') {
				vm.$refs.FormUnit.setdataform(response);
				active = 0; 
			}
			else if (vm.position == 'loadinternal') {
				vm.$refs.FormUnit.setdataform(response);
				active = 1; 
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'suratdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loadinternal') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'loadinternal') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'loadinternal') { vm.loadingModal('formunit'); }
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
}
</script>
