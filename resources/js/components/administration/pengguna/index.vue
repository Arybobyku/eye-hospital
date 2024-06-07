<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<DetailPengguna ref="DetailPengguna"></DetailPengguna>
<FormPengguna ref="FormPengguna" @dialog="dialog" @parsingForm="parsingForm"></FormPengguna>
<HakAkses ref="HakAkses" @dialog="dialog" @parsingForm="parsingForm"></HakAkses>
</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, countage } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal, 
		FormPengguna: defineAsyncComponent(() => import('./FormPengguna.vue')),
		DetailPengguna: defineAsyncComponent(() => import('./DetailPengguna.vue')),
		HakAkses: defineAsyncComponent(() => import('./HakAkses.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'pengguna',
		position: '',
		attach: {
			link : {
				list: '/administration/pengguna/list',
				add: '/administration/pengguna/add',
				edit: '/administration/pengguna/edit',
				update: '/administration/pengguna/update',
				block: '/administration/pengguna/block',
				active: '/administration/pengguna/active',
				reset: '/administration/pengguna/reset',
				akseslook: '/administration/pengguna/hakakses/look',
				aksesupdate: '/administration/pengguna/hakakses/update',
				detail: '/administration/pengguna/detail',
			}, url: '', data: null
		},
		column: [
			{ value: 'nama_pengguna', label: 'Nama Lengkap', type: 'text', search: true, close: false, button: false },
			{ value: 'username_pengguna', label: 'Username', type: 'text', search: true, close: false, button: false },
			{ value: 'usia', label: 'Usia', type: 'number', search: true, close: false, button: false },
			{ value: 'posisi_pengguna', label: 'Level Akun', type: 'text', search: true, close: false, button: false },
			{ value: 'sebagai_pengguna', label: 'Posisi Sebagai', type: 'text', search: true, close: false, button: false },
			{ value: 'status', label: 'Status', type: 'text', search: true, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: true }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename, countage,

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: _item.status == 'active' ? true : false },
				{ icon: 'minus-square', color: 'btn-danger', posisi: 'block', tooltip: 'Blokir akun', item: _item, index: _index, show: _item.status == 'active' ? true : false },
				{ icon: 'check-square', color: 'btn-success', posisi: 'active', tooltip: 'Aktifkan akun', item: _item, index: _index, show: _item.status == 'block' ? true : false },
				{ icon: 'key', color: 'btn-warning', posisi: 'reset', tooltip: 'Reset Password', item: _item, index: _index, show: _item.status == 'active' ? true : false },
				{ icon: 'user-check', color: 'btn-success', posisi: 'akses', tooltip: 'Atur Hak Akses', item: _item, index: _index, show: _item.status == 'active' ? true : false },
				{ icon: 'eye', color: 'btn-danger', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: _item.status == 'active' ? true : false }
			]
			return str;
		},

		badge:function(_item, _index) {
			let str = '';
			if (_item.status == 'active') {
				str = '<div class="badge badge-success">'+ vm.nullAndZero(_item.status) + '</div>';
			}
			else {
				str = '<div class="badge badge-danger">'+ vm.nullAndZero(_item.status) + '</div>';
			}
			return str;
		},

		posisipengguna:function(item) { 
			if (item == '8807') { return 'Karyawan'; } 
			else if (item == '8808') { return 'Dokter Spesialis'; } 
			else { return 'Dokter Umum'; } },

		converter:function(data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' }; }
			else if (identity == 'status') { _tmp = { value: vm.badge(data, index), ishtml: 'html', style: '' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column), ishtml: 'text', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column), ishtml: 'text', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.countage(data.tanggal_lahir), ishtml: 'text', style: '' }; }
			else if (identity == 'posisi_pengguna') { _tmp = { value: vm.posisipengguna(column), ishtml: 'text', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormPengguna.aturulang();
				vm.position = "adddata";
				vm.$refs.FormPengguna.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormPengguna.aturulang();
				vm.position = "editdata";
				vm.$refs.FormPengguna.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formpengguna'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.attach.url = vm.attach.link.edit;
				vm.executions();
			}
			else if (posisi == 'block') {
				vm.position = "blockdata";
				vm.attach.data = new FormData();
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.attach.url = vm.attach.link.block;
				vm.dialog('Yakin ingin memblokir data yang terpilih dihalaman ini.', 'Ya, blokir akun', 'blockdata');
			}
			else if (posisi == 'active') {
				vm.position = "activedata";
				vm.attach.data = new FormData();
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.attach.url = vm.attach.link.active;
				vm.dialog('Yakin ingin mengaktfikan data yang terpilih dihalaman ini.', 'Ya, aktifkan akun', 'activedata');
			}
			else if (posisi == 'reset') {
				vm.position = "resetdata";
				vm.attach.data = new FormData();
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.attach.url = vm.attach.link.reset;
				vm.dialog('Yakin ingin mereset password data yang terpilih dihalaman ini.', 'Ya, reset password', 'resetdata');
			}
			else if (posisi == 'detail') {
				vm.position = "detaildata";
				vm.$refs.DetailPengguna.show();
				setTimeout(() => { vm.loadingModal('detaildata'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'akses') {
				vm.$refs.HakAkses.aturulang();
				vm.position = "aksesdata";
				vm.$refs.HakAkses.show();
				setTimeout(() => { vm.loadingModal('aksesdata'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.attach.url = vm.attach.link.akseslook;
				vm.executions();
			}
		},

		loadingModal: function (position, additional = '') { 
			if (position == 'formpengguna') { vm.$refs.FormPengguna.loaderprocess();  }
			else if (position == 'detaildata') { vm.$refs.DetailPengguna.loaderprocess();  }
			else if (position == 'aksesdata') { vm.$refs.HakAkses.loaderprocess(additional);  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'pengguna') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; } 
			}
			else if (key == 'aksesdata') { vm.position="updatehakakses"; vm.attach.url = vm.attach.link.aksesupdate; }
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
			else if (vm.position == 'adddata') { vm.loadingModal('formpengguna'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formpengguna'); vm.$refs.FormPengguna.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formpengguna'); }
			else if (vm.position == 'blockdata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'activedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'resetdata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'detaildata') { vm.loadingModal('detaildata'); vm.$refs.DetailPengguna.hide();  }
			else if (vm.position == 'aksesdata') { vm.loadingModal('aksesdata'); vm.$refs.HakAkses.hide();  }
			else if (vm.position == 'updatehakakses') { vm.loadingModal('aksesdata', 'back'); }
		
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
				vm.loadingModal('formpengguna');
				vm.$refs.FormPengguna.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormPengguna.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formpengguna');
				vm.$refs.FormPengguna.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'blockdata') { setTimeout(() => { vm.tablereload(); }, 125, this); }
			else if (vm.position == 'activedata') { setTimeout(() => { vm.tablereload(); }, 125, this); }
			else if (vm.position == 'resetdata') { setTimeout(() => { vm.tablereload(); }, 125, this); }
			else if (vm.position == 'detaildata') {
				vm.$refs.DetailPengguna.setdataform(response);
				active = 0; 
			}
			else if (vm.position == 'aksesdata') {
				vm.$refs.HakAkses.setdataform(response);
				active = 0; 
			}
			else if (vm.position == 'updatehakakses') {
				vm.loadingModal('aksesdata'); 
				vm.$refs.HakAkses.hide(); setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
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
				else if (vm.position == 'blockdata') { vm.notification('Pemblokiran data gagal diproses.', 3000, position); }
				else if (vm.position == 'activedata') { vm.notification('Pengaktifan data gagal diproses.', 3000, position); }
				else if (vm.position == 'resetdata') { vm.notification('Reset password gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'aksesdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatehakakses') { vm.notification('Pembaharuan hak akses gagal diproses.', 3000, position); }

			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'blockdata') { vm.notification('Pemblokiran data berhasil diproses.', 3000, position); }
				else if (vm.position == 'activedata') { vm.notification('Pengaktifan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'resetdata') { vm.notification('Reset password berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatehakakses') { vm.notification('Pembaharuan hak akses berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formpengguna') { vm.loadingModal('formpengguna'); }
			else if (posisi == 'blockdata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'activedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'resetdata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'aksesdata') { vm.loadingModal('aksesdata', 'yes'); }

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
