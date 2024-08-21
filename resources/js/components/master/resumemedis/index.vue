<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>

	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.pasien">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.pasienbelum">
			<Datatable ref="DatatableBelum" :module="modulebelum" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.pasiensudah">
			<Datatable ref="DatatableSudah" :module="modulesudah" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>

	<Loader ref="Loader"></Loader>
</div>

<DetailRekamMedisRawatJalan ref="DetailRekamMedisRawatJalan" @dialog="dialog" @parsingForm="parsingForm"></DetailRekamMedisRawatJalan>
<DetailRekamMedisRawatInap ref="DetailRekamMedisRawatInap" @dialog="dialog" @parsingForm="parsingForm"></DetailRekamMedisRawatInap>
<DetailRekamMedisBedah ref="DetailRekamMedisBedah" @dialog="dialog" @parsingForm="parsingForm"></DetailRekamMedisBedah>

</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, countage, formatrupiah } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	components: { toast, Swal, 
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
		DetailRekamMedisRawatJalan: defineAsyncComponent(() => import('./DetailRekamMedisRawatJalan.vue')),
		DetailRekamMedisBedah: defineAsyncComponent(() => import('./DetailRekamMedisBedah.vue')),
		DetailRekamMedisRawatInap: defineAsyncComponent(() => import('./DetailRekamMedisRawatInap.vue')),
	},

	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'unit',
		position: 'loadmain',
		attach: {
			link : {
				list: '/master/pasien/list',
				obat: '/master/pasien/obat',
				tindakan: '/master/pasien/tindakan',
				kunjungan: '/master/pasien/kunjungan',
			}, url: '', data: null
		},
		tab: {
			button: [
				{ value: 'pasien', label: 'Data Pasien (All)', class: 'tab-active' },
				// { value: 'pasienbelum', label: 'Data Pasien (Process)', class: 'tab-no-active' },
				// { value: 'pasiensudah', label: 'Data Pasien (Done)', class: 'tab-no-active' },
			],
			content: { 
				pasien: true, 
				// pasienbelum: false, 
				// pasiensudah: false 
			}
		},
		moduleantrian: { data: [], column: [], total: 0, ispaging: true },
		modulepending: { data: [], column: [], total: 0, ispaging: true },
		module: { data: [], column: [], total: 0, ispaging: true },
		modulebelum: { data: [], column: [], total: 0, ispaging: true },
		modulesudah: { data: [], column: [], total: 0, ispaging: true },
		column: [
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama', label: 'Nama Lengkap', type: 'text', search: true, close: false, button: false },
			{ value: 'alamat', label: 'Alamat', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis_identitas', label: 'Jenis Identitas', type: 'text', search: true, close: false, button: false },
			{ value: 'no_identitas', label: 'No Identitas', type: 'text', search: true, close: false, button: false },
			{ value: 'no_handphone', label: 'No Handphone', type: 'text', search: true, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		posisieksternal: 'pasien'
	}},
	methods: {
		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'rawatjalan', tooltip: 'Resume Medis Rawat Jalan', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'rawatinap', tooltip: 'Resume Medis Rawat Inap', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'operasi', tooltip: 'Resume Medis Rawat Operasi', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'igd', tooltip: 'Resume Medis IGD', item: _item, index: _index, show: true },
			]
			return str;
		},


		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column), ishtml: 'html', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.usia(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.status(data), ishtml: 'html', style: '' }; }
			else if (identity == 'detail') { _tmp = { value: vm.detail(data), ishtml: 'html', style: '' }; }
			else if (identity == 'waktu_status') { _tmp = { value: vm.waktu_status(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		converterbelum: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column), ishtml: 'html', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.usia(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.status(data), ishtml: 'html', style: '' }; }
			else if (identity == 'detail') { _tmp = { value: vm.detail(data), ishtml: 'html', style: '' }; }
			else if (identity == 'waktu_status') { _tmp = { value: vm.waktu_status(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		convertersudah: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column), ishtml: 'html', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.usia(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.status(data), ishtml: 'html', style: '' }; }
			else if (identity == 'detail') { _tmp = { value: vm.detail(data), ishtml: 'html', style: '' }; }
			else if (identity == 'waktu_status') { _tmp = { value: vm.waktu_status(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'rawatjalan') {
				vm.position = "modalrawatjalan";
				vm.$refs.DetailRekamMedisRawatJalan.aturulang();
				vm.$refs.DetailRekamMedisRawatJalan.show('modalrawatjalan', 'Resume Medis Rawat Jalan', data.pasien_uuid);
				setTimeout(() => { vm.loadingModal('rawatjalan'); }, 250, this);
				vm.attach.data = new FormData();
				vm.$refs.DetailRekamMedisRawatJalan.setdataform(data);

				vm.attach.data.append('pasien_uuid', data.uuid);
				vm.executions();
			}
			else if (posisi == 'operasi') {
				vm.position = "modalBedah";
				vm.$refs.DetailRekamMedisBedah.show('modalBedah', 'Resume Medis Bedah', data.pasien_uuid);
				setTimeout(() => { vm.loadingModal('operasi'); }, 250, this);
				vm.$refs.DetailRekamMedisBedah.setdataform(data);
			}
			else if (posisi == 'rawatinap') {
				vm.position = "modalrawatinap";
				vm.$refs.DetailRekamMedisRawatInap.show('modalrawatinap', 'Resume Medis Rawat Inap', data.pasien_uuid);
				setTimeout(() => { vm.loadingModal('rawatinap'); }, 250, this);
				vm.$refs.DetailRekamMedisRawatInap.setdataform(data);
			}
		},

		loadingModal: function (position) { 
			if (position == 'rawatjalan') { vm.$refs.DetailRekamMedisRawatJalan.loaderprocess();  }
			else if (position == 'operasi') { vm.$refs.DetailRekamMedisBedah.loaderprocess();  }
			else if (position == 'rawatinap') { vm.$refs.DetailRekamMedisRawatInap.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'pasien') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; }  
			}
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },

		tableload:function(pos = 'main') { 
			if (pos == 'main') {
				vm.attach.url = 
				vm.attach.link.list; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}

			vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (pos == 'outer') {
				vm.$refs.Datatable.skeleton(); 
			}
			vm.attach.url = vm.attach.link.list; 
			vm.attach.data = data; 


			vm.position = 'externaltable'; 
			vm.executions(); 
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		loadmain: () => { 
			console.log(vm.position);
			vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); 
		},
		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadpasienbelum') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadpasiensudah') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal='pasienbelum') {
					vm.$refs.DatatableBelum.skeleton(); 
					vm.$refs.DatatableBelum.backpage(); 
				}
				else if (vm.posisieksternal='pasiensudah') {
					vm.$refs.DatatableSudah.skeleton(); 
					vm.$refs.DatatableSudah.backpage(); 
				}
				else {
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.backpage(); 
				}

			}
			else if (vm.position == 'obatdata') { vm.loadingModal('formobat'); vm.$refs.FormObat.hide();  }
			else if (vm.position == 'tindakandata') { vm.loadingModal('formtindakan'); vm.$refs.FormObat.hide();  }
			else if (vm.position == 'kunjungandata') { vm.loadingModal('formkunjungan'); vm.$refs.FormObat.hide();  }

			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }

			if (response.data.data == 'cannot') {
				setTimeout(() => { vm.posisieksternal='antrian'; vm.tablereload(); }, 500, this);
				vm.notification('Nomor yang anda panggil sudah berada di customer service.', 3000, 'warning'); 
			}
			else {
				if (vm.position == 'loadmain') { 
					vm.posisieksternal='pasien';
					vm.firstloader();
					vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.Datatable.paging(); 
					active = 0;
				}
				else if (vm.position == 'loadpasienbelum') { 
					vm.posisieksternal='pasienbelum';
					vm.firstloader();
					vm.$refs.DatatableBelum.update(vm.columnbelum, vm.setDatatablebelum(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableBelum.paging(); 
					active = 0;
				}
				else if (vm.position == 'loadpasiensudah') { 
					vm.posisieksternal='pasiensudah';
					vm.firstloader();
					vm.$refs.DatatableSudah.update(vm.columnsudah, vm.setDatatablesudah(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableSudah.paging(); 
					active = 0;
				}
				else if (vm.position == 'externaltable') { 
					vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.paging(); 
					active = 0;
				}
				vm.message('success', active);
			}
		},

		mainreload:function(pos) {
			setTimeout(() => { 
				if(pos == 'main') {
					vm.$refs.Datatable.skeleton(); vm.posisieksternal='pasien'; vm.tablereload(); 
				}
			}, 500, this);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadpasienbelum') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadpasiensudah') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'obatdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'tindakandata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'kunjungandata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				// if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			// if (posisi == 'formpasien') { vm.loadingModal('formpasien'); }
			// else if(posisi == 'panggil') { vm.$refs.DatatableAntrian.skeleton(); }
			// else if(posisi == 'selesai') { vm.$refs.DatatableAntrian.skeleton(); }
			// else if(posisi == 'formcetakan') { vm.loadingModal('formcetakan'); }
			// else if(posisi == 'uploadfile') { vm.loadingModal('formfile'); }
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { 
			if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } 
			else if (position == 'warning') { toast.warning(message, { rtl: false, autoClose: timer }); } 
			else { toast.success(message, { rtl: false, autoClose: timer }); }
		},
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
}
</script>
