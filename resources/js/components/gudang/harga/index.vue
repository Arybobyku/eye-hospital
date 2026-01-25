<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormHarga ref="FormHarga" @dialog="dialog" @parsingForm="parsingForm"></FormHarga>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, formatrupiah } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal, 
		FormHarga: defineAsyncComponent(() => import('./FormHarga.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'harga',
		position: '',
		attach: {
			link : {
				list: '/gudang/harga/list',
				add: '/gudang/harga/add',
				edit: '/gudang/harga/edit',
				update: '/gudang/harga/update',
				remove: '/gudang/harga/remove',
			}, url: '', data: null
		},
		column: [
			{ value: 'nama', label: 'Nama Obat', type: 'text', search: true, close: false, button: false },
			{ value: 'informasi', label: 'Informasi Obat', type: 'text', search: false, close: false, button: false },
			{ value: 'hpp', label: 'Nilai HPP', type: 'text', search: false, close: false, button: false },
			{ value: 'hja', label: 'Nilai HJA', type: 'text', search: false, close: false, button: false },
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

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: true },
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'remove', tooltip: 'Hapus Data', item: _item, index: _index, show: true }
			]
			return str;
		},

		informasi:function(_item) { 
			return 	'<table class="table-info">' +
								'<tr><td>Formularium</td><td><strong>'+_item.formularium+'</strong></td></tr>' +
								'<tr><td>Golongan</td><td><strong>'+_item.golongan+'</strong></td></tr>' +
								'<tr><td>Kategori</td><td><strong>'+_item.kategori+'</strong></td></tr>' +
								'<tr><td>Satuan Besar</td><td><strong>'+_item.nama_satuan_besar+'</strong></td></tr>' +
								'<tr><td>Satuan Kecil</td><td><strong>'+_item.nama_satuan_kecil+'</strong></td></tr>' +
							'</table>';
		},

		hpp:function(_item) {
			return 	'<table class="table-info">' +
								'<tr><td>Harga Netto</td><td><strong>'+vm.formatrupiah(Math.ceil (_item.harga_netto).toString())+'</strong></td></tr>' +
								'<tr><td>Diskon</td><td><strong>'+vm.nullAndZero(_item.harga_netto_discount)+' (%)</strong></td></tr>' +
								'<tr><td>PPN</td><td><strong>'+_item.harga_netto_ppn+' (%)</strong></td></tr>' +
								'<tr><td>HPP</td><td><strong>'+vm.formatrupiah(Math.ceil (_item.hpp).toString())+'</strong></td></tr>' +
							'</table>';
		},

		hja:function(_item) {
			return 	'<table class="table-info" style="margin-bottom: 5px">' +
								'<tr><td>Margin Resep</td><td><strong>'+_item.margin_resep+' (%)</strong></td></tr>' +
								'<tr><td>Harga/Satuan Kecil</td><td><strong>'+vm.formatrupiah(Math.ceil (_item.hja_resep).toString())+'</strong></td></tr>' +
								'<tr><td>Harga/Satuan Besar</td><td><strong>'+vm.formatrupiah(Math.ceil (_item.hja_resep_besar).toString())+'</strong></td></tr>' +
							'</table>' +
							'<table class="table-info" style="margin-bottom: 5px">' +
								'<tr><td>Margin Non Resep</td><td><strong>'+_item.margin_non_resep+' (%)</strong></td></tr>' +
								'<tr><td>Harga/Satuan Kecil</td><td><strong>'+vm.formatrupiah(Math.ceil (_item.hja_non_resep).toString())+'</strong></td></tr>' +
								'<tr><td>Harga/Satuan Besar</td><td><strong>'+vm.formatrupiah(Math.ceil (_item.hja_non_resep_besar).toString())+'</strong></td></tr>' +
							'</table>';;
		},

		converter:function(data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.tanggal(column, 'v1'), ishtml: 'text', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.tanggal(column, 'v1'), ishtml: 'text', style: '' }; }
			else if (identity == 'informasi') { _tmp = { value: vm.informasi(data), ishtml: 'html', style: '' }; }
			else if (identity == 'hpp') { _tmp = { value: vm.hpp(data), ishtml: 'html', style: '' }; }
			else if (identity == 'hja') { _tmp = { value: vm.hja(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormHarga.aturulang();
				vm.position = "adddata";
				vm.$refs.FormHarga.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormHarga.aturulang();
				vm.position = "editdata";
				vm.$refs.FormHarga.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formharga'); }, 250, this);
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
		},

		loadingModal: function (position) { 
			if (position == 'formharga') { vm.$refs.FormHarga.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'harga') {
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
			else if (vm.position == 'adddata') { vm.loadingModal('formharga'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formharga'); vm.$refs.FormHarga.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formharga'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			
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
				vm.loadingModal('formharga');
				vm.$refs.FormHarga.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormHarga.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formharga');
				vm.$refs.FormHarga.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'removedata') { 
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
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formharga') { vm.loadingModal('formharga'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
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
