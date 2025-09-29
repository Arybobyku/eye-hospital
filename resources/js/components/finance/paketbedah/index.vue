<template>
<div class="inner" ref="roottable">
<div class="grid">
		<div class="col-4 form-mr">
			<Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)" 
					:ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
					:selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)"></Selected>
		</div>
		<div class="col-3 form-mr">
			<Inputed :ref="formDownload" :form="formDownload"></Inputed>
		</div>
		<div class="col-2 form-mr">
			<button class="btn-tambah" @click="downloadTemplate()">Generate Template</button>
		</div>
		<div class="col-2 form-mr">
			<div class="form-self-group">
				<input 
					:id="formUpload.for_id" 
					:type="formUpload.type" 
					:disabled="formUpload.disabled ? 'disabled' : false" 
					@change="onFileChange" 
				/>
			</div>

		</div>
		<div class="col-1 form-mr">
			<button class="btn-tambah" @click="uploadFile()">Upload</button>
		</div>
	</div>
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormUnit ref="FormUnit" @dialog="dialog" @parsingForm="parsingForm"></FormUnit>
<DetailData ref="DetailData" @dialog="dialog" @parsingForm="parsingForm"></DetailData>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, formatrupiah } from '../../../module/Manipulation.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal, 
		FormUnit: defineAsyncComponent(() => import('./FormUnit.vue')),
		DetailData: defineAsyncComponent(() => import('./DetailData.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
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
		formDownload: { 
			title: 'Nama Paket Bedah', 
			for_id: 'templateName',
			type: 'text', 
			required: '', 
			key: 'templateName', 
			model: 'templateName', 
			disabled: false,
			value: '',
			},
		formUpload: { 
			title: 'Upload Paket Bedah', 
			for_id: 'upload',
			type: 'file', 
			required: '', 
			key: 'upload', 
			model: 'upload', 
			disabled: false,
			value: null,
			},
		form:{
			select: {
				carabayar: { 
					key : 'carabayar', for_id: 'form_'+'carabayar', name: 'carabayar', uuid:'', value: '', label: 'Silahkan Pilih', 
					filter: [], data: [], search: '', option: 'display: none', statics: false,
					class: 'carabayar', isrequired: true, html: 'Cara Bayar', issearch: false, disabled: false,
				},
			},
		},
		attach: {
			link : {
				list: '/finance/paketbedah/list',
				add: '/finance/paketbedah/add',
				edit: '/finance/paketbedah/edit',
				update: '/finance/paketbedah/update',
				remove: '/finance/paketbedah/remove',
				duplicate: '/finance/paketbedah/duplicate',
			}, url: '', data: null
		},
		column: [
			{ value: 'nama', label: 'Nama Paket', type: 'text', search: true, close: false, button: false },
			// { value: 'nama_dokter', label: 'Nama Dokter', type: 'text', search: true, close: false, button: false },
			{ value: 'harga_sudah_ditentukan', label: 'Harga Sudah Ditentukan', type: 'text', search: false, close: false, button: false },
			{ value: 'total', label: 'Biaya', type: 'text', search: false, close: false, button: false },
			{ value: 'keterangan', label: 'Keterangan', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: true }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename, formatrupiah,

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/
		initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			//vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 
		},
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

		downloadTemplate: function(){
			let carabayar = vm.form.select.carabayar.value;
			let nama = vm.formDownload.value;
			let link = `/finance/listpaketbedah/download/${carabayar}/${nama}`;						
			window.open(link); 
			vm.formDownload.value = '';
		},
		onFileChange(e) {
			console.log("onfilechanges",e.target.files[0]);
			vm.formUpload.value = e.target.files[0];
		},
		uploadFile: function(){
			console.log("File upload", vm.formUpload.value);

			vm.$refs.Datatable.skeleton();

			let formData = new FormData();
			formData.append('file', vm.formUpload.value); // sesuaikan dengan nama field di Laravel request

			axios.post('/finance/listpaketbedah/upload', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			})
				.then(function (response) {
					setTimeout(function () {
						vm.berhasil(response);
					}, 300);
					window.location.reload();
				})
				.catch(function (error) {
					console.error(error);
					setTimeout(function () {
						vm.gagal(error);
					}, 300);
					window.location.reload();
				});
		},		

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: true },
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'remove', tooltip: 'Hapus Data', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-info', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-info', posisi: 'duplicate', tooltip: 'Duplicate Data', item: _item, index: _index, show: true },
			]
			return str;
		},

		total:function(column, is) {
			return formatrupiah(column.toString());
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'harga_sudah_ditentukan') { _tmp = { value: column == 1 ? 'iya' : 'tidak', ishtml: 'text', style: '' }; }
			else if (identity == 'total') { _tmp = { value: vm.total(column, true), ishtml: 'text', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "adddata";
				vm.$refs.FormUnit.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "editdata";
				vm.$refs.FormUnit.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formunit'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.edit;
				vm.executions();
			}
			else if (posisi == 'remove') {
				vm.position = "removedata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.remove;
				vm.dialog('Yakin ingin menghapus data ' + data.nama, 'Ya, hapus data', 'removedata');
			}
			else if (posisi == 'duplicate') {
				vm.position = "duplicatedata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.duplicate;
				vm.dialog('Yakin ingin mengduplikat data yang terpilih dihalaman ini.', 'Ya, Duplikasi data', 'duplicatedata');
			}
			else if (posisi == 'detail') {
				vm.$refs.DetailData.aturulang();
				vm.position = "detaildata";
				vm.$refs.DetailData.show('editdata', 'Edit Data', data.uuid, data.nama);
			}
		},

		loadingModal: function (position) { 
			if (position == 'formunit') { vm.$refs.FormUnit.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'unit') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; } 
			}
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
			else if (vm.position == 'adddata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formunit'); vm.$refs.FormUnit.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'duplicatedata') { vm.$refs.Datatable.skeleton(); }
			
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
			else if (vm.position == 'adddata') {
				vm.loadingModal('formunit');
				vm.$refs.FormUnit.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormUnit.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formunit');
				vm.$refs.FormUnit.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'removedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'duplicatedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'duplicatedata') { vm.notification('Duplikasi data gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'duplicatedata') { vm.notification('Duplikasi data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formunit') { vm.loadingModal('formunit'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'duplicatedata') { vm.$refs.Datatable.skeleton(); }
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
