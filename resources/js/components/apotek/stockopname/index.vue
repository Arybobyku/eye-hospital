<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormAmbil ref="FormAmbil" @dialog="dialog" @parsingForm="parsingForm"></FormAmbil>
<FormKembali ref="FormKembali" @dialog="dialog" @parsingForm="parsingForm"></FormKembali>
<DetailRincian ref="DetailRincian" @dialog="dialog"></DetailRincian>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, numberdigit } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal, 
		FormAmbil: defineAsyncComponent(() => import('./FormAmbil.vue')),
		FormKembali: defineAsyncComponent(() => import('./FormKembali.vue')),
		DetailRincian: defineAsyncComponent(() => import('./DetailRincian.vue')),
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
				list: '/apotek/stockopname/list',
				ambil: '/apotek/stockopname/ambil',
				kembali: '/apotek/stockopname/kembali',
			}, url: '', data: null
		},
		column: [
			{ value: 'nama', label: 'Nama Obat', type: 'text', search: true, close: false, button: false },
			{ value: 'kategori', label: 'Kategori', type: 'text', search: true, close: false, button: false },
			{ value: 'formularium', label: 'Formularium', type: 'text', search: true, close: false, button: false },
			{ value: 'golongan', label: 'Golongan', type: 'text', search: true, close: false, button: false },
			// { value: 'stockbesar', label: 'Stock Satuan Besar', type: 'text', search: false, close: false, button: false },
			{ value: 'stockkecil', label: 'Stock Satuan Kecil', type: 'text', search: false, close: false, button: false },
			{ value: 'kalkulasi', label: 'Kalkulasi', type: 'text', search: false, close: false, button: false },
			{ value: 'rincianhtml', label: '', type: 'text', search: false, close: false, button: false },
			// { value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename, numberdigit,

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'minimize-2', color: 'btn-warning', posisi: 'ambil', tooltip: 'Ambil Obat/Alkes', item: _item, index: _index, show: true },
				{ icon: 'maximize-2', color: 'btn-success', posisi: 'kembali', tooltip: 'Kembalikan Obat/Alkes', item: _item, index: _index, show: true }
			]
			return str;
		},

		rincianhtml:function(_item, _index) {
			let str = [
				{ icon: 'book', color: 'btn-warning', posisi: 'rincian', tooltip: 'Lihat rincian', item: _item, index: _index, show: true },
			]
			return str;
		},

		stockbesar:function (data) { return data.jumlah_besar + ' ' + data.nama_satuan_besar },
		stockkecil:function (data) { return data.jumlah_kecil + ' ' + data.nama_satuan_kecil },
		kalkulasi:function (data) { 
			// return vm.numberdigit(data.hitung_besar) + ' ' + data.nama_satuan_besar + ' = ' + 
			// vm.numberdigit(data.hitung_kecil) + ' ' + data.nama_satuan_kecil; 
			return vm.numberdigit(data.hitung_kecil) + ' ' + data.nama_satuan_kecil + '/' + data.nama_satuan_besar; 
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'rincianhtml') { _tmp = { value: vm.rincianhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'stockbesar') { _tmp = { value: vm.stockbesar(data), ishtml: 'html', style: '' }; }
			else if (identity == 'stockkecil') { _tmp = { value: vm.stockkecil(data), ishtml: 'html', style: '' }; }
			else if (identity == 'kalkulasi') { _tmp = { value: vm.kalkulasi(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'ambil') {
				vm.$refs.FormAmbil.aturulang();
				vm.position = "ambildata";
				vm.$refs.FormAmbil.show('ambildata', 'Ambil Data Obat/Alkes', '', data);
			}
			else if (posisi == 'kembali') {
				vm.$refs.FormKembali.aturulang();
				vm.position = "kembalidata";
				vm.$refs.FormKembali.show('kembalidata', 'Kembalikan Data Obat/Alkes', '', data);
			} else if (posisi == 'rincian') {
				vm.position = "lihatrincian";
				vm.$refs.DetailRincian.show('lihatrincian', `Rincian ${data.nama}`, '', data);
			}
		},

		loadingModal: function (position) { 
			if (position == 'formambil') { vm.$refs.FormAmbil.loaderprocess();  }
			else if (position == 'formkembali') { vm.$refs.FormKembali.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'ambil') { vm.attach.url = vm.attach.link.ambil; }
			if (key == 'kembali') { vm.attach.url = vm.attach.link.kembali; }
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
			else if (vm.position == 'ambildata') { vm.loadingModal('formambil'); }
			else if (vm.position == 'kembalidata') { vm.loadingModal('formkembali'); }
			
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
			else if (vm.position == 'ambildata') {
				vm.loadingModal('formambil');
				vm.$refs.FormAmbil.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'kembalidata') {
				vm.loadingModal('formkembali');
				vm.$refs.FormKembali.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'ambildata') { vm.notification('Pengurangan stock opname gagal diproses.', 3000, position); }
				else if (vm.position == 'kembalidata') { vm.notification('Penambahan stock opname gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'ambildata') { vm.notification('Pengurangan stock opname berhasil diproses.', 3000, position); }
				else if (vm.position == 'kembalidata') { vm.notification('Penambahan stock opname berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formambil') { vm.loadingModal('formambil'); }
			else if (posisi == 'formkembali') { vm.loadingModal('formkembali'); }
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
