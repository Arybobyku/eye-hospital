<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormPermintaan ref="FormPermintaan" @dialog="dialog" @parsingForm="parsingForm"></FormPermintaan>
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
		FormPermintaan: defineAsyncComponent(() => import('./FormPermintaan.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'permintaan',
		position: '',
		attach: {
			link : {
				list: '/rawatinap/reqopname/list',
				minta: '/rawatinap/reqopname/minta',
				detail: '/rawatinap/reqopname/detail',
				batal: '/rawatinap/reqopname/batal',
				terima: '/rawatinap/reqopname/terima',
			}, url: '', data: null
		},
		column: [
			{ value: 'kode', label: 'Kode Permintaan', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_minta', label: 'Tanggal', type: 'date', search: true, close: false, button: false },
			{ value: 'ke_nama_unit', label: 'Tujuan', type: 'text', search: false, close: false, button: false },
			{ value: 'jumlah', label: 'Jumlah Obat/Alkes', type: 'text', search: false, close: false, button: false },
			{ value: 'status', label: 'Status', type: 'text', search: false, close: false, button: false },
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
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Permintaan', item: _item, index: _index, show: true },
				{ 
					icon: 'x', color: 'btn-danger', posisi: 'batal', tooltip: 'Batal Permintaan', 
					item: _item, index: _index, show: _item.status == 'Permintaan' ? true : false },
				{ 
					icon: 'pocket', color: 'btn-warning', posisi: 'terima', tooltip: 'Terima Obat/Alkes', 
					item: _item, index: _index, show: _item.status == 'Dikirim' ? true : false },
			]
			return str;
		},

		tanggalminta:function(data) { return vm.datename(data.tanggal_minta) + ' ' + '<strong>' + data.jam_minta + '</strong>'; },

		converter:function(data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_minta') { _tmp = { value: vm.tanggalminta(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormPermintaan.aturulang();
				vm.position = "adddata";
				vm.$refs.FormPermintaan.show('adddata', 'Tambah Data Permintaan', '');
			}
			else if (posisi == 'detail') {
				vm.$refs.FormPermintaan.aturulang();
				vm.position = "detaildata";
				vm.$refs.FormPermintaan.show('detaildata', 'Detail Data', data);
				setTimeout(() => { vm.loadingModal('formpermintaan'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('kode', data.kode);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'batal') {
				vm.position = "bataldata";
				vm.attach.data = new FormData();
				vm.attach.data.append('kode', data.kode);
				vm.attach.url = vm.attach.link.batal;
				vm.dialog('Yakin ingin membatalkan permintaan obat/alkes.', 'Ya, batalkan permintaan', 'bataldata');
			}
			else if (posisi == 'terima') {
				vm.position = "terimadata";
				vm.attach.data = new FormData();
				vm.attach.data.append('kode', data.kode);
				vm.attach.url = vm.attach.link.terima;
				vm.dialog('Yakin ingin menerima obat/alkes yang diminta sebelumnya.', 'Ya, terima obat/alkes', 'terimadata');
			}
		},

		loadingModal: function (position) { 
			if (position == 'formpermintaan') { vm.$refs.FormPermintaan.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'permintaan') { vm.attach.url = vm.attach.link.minta; }
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
			else if (vm.position == 'adddata') { vm.loadingModal('formpermintaan'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formpermintaan'); vm.$refs.FormPermintaan.hide();  }
			else if (vm.position == 'bataldata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'terimadata') { vm.$refs.Datatable.skeleton(); }
			
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
				vm.loadingModal('formpermintaan');
				vm.$refs.FormPermintaan.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'detaildata') {
				vm.position = "adddata";
				vm.$refs.FormPermintaan.setdataform(response);
				active = 0; 
			}
			else if (vm.position == 'bataldata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'terimadata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'bataldata') { vm.notification('Pembatalan permintaan obat/alkes gagal diproses.', 3000, position); }
				else if (vm.position == 'terimadata') { vm.notification('Penerimaan permintaan obat/alkes gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'bataldata') { vm.notification('Pembatalan permintaan obat/alkes berhasil diproses.', 3000, position); }
				else if (vm.position == 'terimadata') { vm.notification('Penerimaan permintaan obat/alkes berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formpermintaan') { vm.loadingModal('formpermintaan'); }
			else if (posisi == 'bataldata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'terimadata') { vm.$refs.Datatable.skeleton(); }
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
