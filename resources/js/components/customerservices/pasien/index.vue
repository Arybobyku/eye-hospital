<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
		
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.pasien">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.antrian">
			<Datatable ref="DatatableAntrian" :module="moduleantrian" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.kunjungan">
			<Datatable ref="DatatableKunjungan" :module="modulekunjungan" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else="tab.content.pending">
			<Datatable ref="DatatablePending" :module="modulepending"></Datatable>
		</div>
	</div>

	<Loader ref="Loader"></Loader>
</div>

<FormPilihRoSuratSehat ref="FormPilihRoSuratSehat" @dialog="dialog" />
<FormPilihRoSuratRo ref="FormPilihRoSuratRo" @dialog="dialog" />
<FormPasien ref="FormPasien" @dialog="dialog" @parsingForm="parsingForm"></FormPasien>
<FormDetail ref="FormDetail" @dialog="dialog" @parsingForm="parsingForm"></FormDetail>
<FormRegistrasi ref="FormRegistrasi" @mainreload="mainreload"></FormRegistrasi>
<FormRegistrasiInap ref="FormRegistrasiInap" @mainreload="mainreload"></FormRegistrasiInap>
<FormRegistrasiOdc ref="FormRegistrasiOdc" @mainreload="mainreload"></FormRegistrasiOdc>
<FormCetakan ref="FormCetakan" @dialog="dialog" @parsingForm="parsingForm"></FormCetakan>
<FormUpload ref="FormUpload" @dialog="dialog" @parsingForm="parsingForm"></FormUpload>

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
		FormPilihRoSuratSehat: defineAsyncComponent(() => import('./FormPilihRoSuratSehat.vue')),
		FormPilihRoSuratRo: defineAsyncComponent(() => import('./FormPilihRoSuratRo.vue')),
		FormPasien: defineAsyncComponent(() => import('./FormPasien.vue')),
		FormDetail: defineAsyncComponent(() => import('./FormDetail.vue')),
		FormCetakan: defineAsyncComponent(() => import('./FormCetakan.vue')),
		FormUpload: defineAsyncComponent(() => import('./FormUpload.vue')),
		AntrianPage: defineAsyncComponent(() => import('./AntrianPage.vue')),
		FormRegistrasi: defineAsyncComponent(() => import('./FormRegistrasi.vue')),
		FormRegistrasiInap: defineAsyncComponent(() => import('./FormRegistrasiInap.vue')),
		FormRegistrasiOdc: defineAsyncComponent(() => import('./FormRegistrasiOdc.vue')),
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
		position: 'loadmain',
		attach: {
			link : {
				list: '/customerservices/pasien/list',
				add: '/customerservices/pasien/add',
				edit: '/customerservices/pasien/edit',
				update: '/customerservices/pasien/update',
				detail: '/customerservices/pasien/detail',
				suratpersetujuan: '/customerservices/pasien/suratpersetujuan',
				printsuratpersetujuan: '/customerservices/pasien/printsuratpersetujuan/',
				printcetakkartu: '/customerservices/pasien/cetakkartu/',
				printcetaklabel: '/customerservices/pasien/cetaklabel/',
				uploadfile: '/customerservices/pasien/uploadfile',
				registrasipage: '/customerservices/pasien/registrasi/page',
				registrasipageinap: '/customerservices/pasien/registrasi/pageinap',
				registrasipageodc: '/customerservices/pasien/registrasi/pageodc',
				antrian: '/customerservices/antrian/list',
				call: '/customerservices/antrian/call',
				finish: '/customerservices/antrian/finish',
				listpending: '/customerservices/pasien/pending',
				listkunjungan: '/customerservices/pasien/listkunjungan',
			}, url: '', data: null
		},
		tab: {
			button: [
				{ value: 'pasien', label: 'Data Pasien', class: 'tab-active' },
				{ value: 'antrian', label: 'Daftar Antrian', class: 'tab-no-active' },
				{ value: 'kunjungan', label: 'Pasien yang Berkunjung', class: 'tab-no-active' },
			],
			content: { 
				pasien: true, 
				antrian: false, 
				kunjungan: false 
			}
		},
		moduleantrian: { data: [], column: [], total: 0, ispaging: true },
		modulepending: { data: [], column: [], total: 0, ispaging: true },
		module: { data: [], column: [], total: 0, ispaging: true },
		modulekunjungan: { data: [], column: [], total: 0, ispaging: true },
		column: [
			{ value: 'is_printer_card', label: 'Cetak Kartu?', type: 'text', search: false, close: false, button: false },
			{ value: 'rekam_medis', label: 'No Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', search: true, close: false, button: false },
			{ value: 'alamat', label: 'Alamat', type: 'text', search: true, close: false, button: false },
			{ value: 'usia', label: 'Usia', type: 'number', search: false, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'no_handphone', label: 'No Handphone', type: 'text', search: true, close: false, button: false },
			{ value: 'status', label: 'status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: true }
		],
		columnkunjungan: [
			{ value: 'is_printer_card', label: 'Cetak Kartu?', type: 'text', search: false, close: false, button: false },
			{ value: 'rekam_medis', label: 'No Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', search: true, close: false, button: false },
			{ value: 'alamat', label: 'Alamat', type: 'text', search: true, close: false, button: false },
			{ value: 'usia', label: 'Usia', type: 'number', search: false, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'no_handphone', label: 'No Handphone', type: 'text', search: true, close: false, button: false },
			{ value: 'status', label: 'status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: true }
		],
		columnantrian: [
			{ value: 'kode', label: 'No Antrian Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis', label: 'Metode Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'pemanggil', label: 'Customer Service', type: 'text', search: true, close: false, button: false },
			
			{ value: 'btnhtmlantrian', label: '', type: 'text', search: false, close: false, button: false }
		],
		columnpending: [
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'no_handphone', label: 'No Handphone', type: 'text', search: true, close: false, button: false },
			{ value: 'panjar', label: 'Jumlah Panjar', type: 'text', search: false, close: false, button: false },
			{ value: 'approve_panjar', label: 'Status Panjar', type: 'text', search: false, close: false, button: false }
		],
		posisieksternal: 'pasien'
	}},
	methods: {
		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename, countage, formatrupiah,
		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
				
				vm.moduleantrian.data = [];
				vm.modulepending.data = [];
				vm.module.data = [];
				
				if (values == 'antrian') {
					vm.posisieksternal = 'antrian';
					vm.loadantrian();
				}
				else if (values == 'pending') {
					vm.posisieksternal = 'pending';
					vm.loadpending();
				}
				else if (values == 'kunjungan') {
					vm.posisieksternal = 'kunjungan';
					vm.loadkunjungan();
				}
				else {
					vm.posisieksternal = 'pasien';
					vm.loadmain();
				}
			}
		},
		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'book-open', color: 'btn-info', posisi: 'registrasi', tooltip: 'Data Registrasi (Rawat Jalan)', item: _item, index: _index, 
						show: _item.status == 'Kunjungan' || _item.status == 'Aktif' ? true : false },
				{ icon: 'book-open', color: 'btn-info', posisi: 'rawatinap', tooltip: 'Data Registrasi (Rawat Inap)', item: _item, index: _index, 
						show: _item.status == 'Rawat Inap' || _item.status == 'Aktif' ? true : false },
				{ icon: 'book-open', color: 'btn-info', posisi: 'onedaycare', tooltip: 'Data Registrasi (ODC)', item: _item, index: _index, 
						show: _item.status == 'One Day Care' || _item.status == 'Aktif' ? true : false },
				{ icon: 'printer', color: 'btn-success', posisi: 'suratpersetujuan', tooltip: 'Surat Persetujuan', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-info', posisi: 'uploadfile', tooltip: 'Upload Surat Persetujuan', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetakkartu', tooltip: 'Cetak Kartu', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaklabel', tooltip: 'Cetak Label', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetakidentitas', tooltip: 'Cetak Identitas', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaksuratsakit', tooltip: 'Cetak Surat Sakit', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaksuratsehat', tooltip: 'Cetak Surat Sehat', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaksuratro', tooltip: 'Cetak Surat Keterangan Hasil Pemeriksaan Mata', item: _item, index: _index, show: true },
			]
			return str;
		},

		btnhtmlkunjungan:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'book-open', color: 'btn-info', posisi: 'registrasi', tooltip: 'Data Registrasi (Rawat Jalan)', item: _item, index: _index, 
						show: _item.status == 'Kunjungan' || _item.status == 'Aktif' ? true : false },
				{ icon: 'book-open', color: 'btn-info', posisi: 'rawatinap', tooltip: 'Data Registrasi (Rawat Inap)', item: _item, index: _index, 
						show: _item.status == 'Rawat Inap' || _item.status == 'Aktif' ? true : false },
				{ icon: 'book-open', color: 'btn-info', posisi: 'onedaycare', tooltip: 'Data Registrasi (ODC)', item: _item, index: _index, 
						show: _item.status == 'One Day Care' || _item.status == 'Aktif' ? true : false },
				{ icon: 'printer', color: 'btn-success', posisi: 'suratpersetujuan', tooltip: 'Surat Persetujuan', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-info', posisi: 'uploadfile', tooltip: 'Upload Surat Persetujuan', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetakkartu', tooltip: 'Cetak Kartu', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaklabel', tooltip: 'Cetak Label', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetakidentitas', tooltip: 'Cetak Identitas', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaksuratsakit', tooltip: 'Cetak Surat Sakit', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaksuratsehat', tooltip: 'Cetak Surat Sehat', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaksuratro', tooltip: 'Cetak Surat Keterangan Hasil Pemeriksaan Mata', item: _item, index: _index, show: true },
			]
			return str;
		},

		btnhtmlantrian:function(_item, _index) {
			let str = [
				{ icon: 'bell', color: 'btn-warning', posisi: 'panggil', tooltip: 'Panggil Pasien', item: _item, index: _index, show: true },
				{ icon: 'check-square', color: 'btn-success', posisi: 'selesai', tooltip: 'Selesai', item: _item, index: _index, show: true }
			]
			return str;
		},

		customer:function(item) {
			//if (!item.pemanggil || item.pemanggil == '0' || item.pemanggil == 0 || item.pemanggil == '-' || item.pemanggil == ' ') { return ''; }
			return item.pemanggil;
		},

		checknumber:function(data) {
			let msg = data.kode;
    	if (data.number < 10) { msg = data.kode + '-00' + data.number; } 
			else if (data.number > 9 && data.number < 100) { msg = data.kode + '-0' + data.number; } 
			else if (data.number > 99 && data.number < 1000) { msg = data.kode + '-' + data.number; }

    	return msg;
		},

		usia: function (_item) { return vm.countage(_item.tanggal_lahir); },

		status: function (_item) {
			let color = _item.status == 'Aktif' ? 'badge-success' : (_item.status == 'kunjungan' ? 'badge-warning' : 'badge-danger');
			return '<div class="badge '+ color +'"><strong>'+ _item.status +'</strong></div>';
		},

		is_printer_card:function(_item) {
			let color = _item.is_printer_card == 'Sudah' ? 'badge-success' : 'badge-danger';
			return '<div class="badge '+ color +'"><strong>'+ _item.is_printer_card +'</strong></div>';
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column), ishtml: 'html', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.usia(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.status(data), ishtml: 'html', style: '' }; }
			else if (identity == 'is_printer_card') { _tmp = { value: vm.is_printer_card(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		converterkunjungan: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column), ishtml: 'html', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.usia(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.status(data), ishtml: 'html', style: '' }; }
			else if (identity == 'is_printer_card') { _tmp = { value: vm.is_printer_card(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		converterantrian: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtmlantrian') { _tmp = { value: vm.btnhtmlantrian(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'pemanggil') { _tmp = { value: vm.customer(data), ishtml: 'html', style: '' }; }
			else if (identity == 'kode') { _tmp = { value: vm.checknumber(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		approvepanjar:function(data) {
			if (data.approve_panjar == 0) { return 'Belum Dibayar'; }
			return 'Sudah Dibayar';
		},

		converterpending: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtmlpending') { _tmp = { value: vm.btnhtmlpending(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'approve_panjar') { _tmp = { value: vm.approvepanjar(data), ishtml: 'html', style: '' }; }
			else if (identity == 'panjar') { _tmp = { value: vm.formatrupiah(column.toString()), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormPasien.aturulang();
				vm.position = "adddata";
				vm.$refs.FormPasien.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormPasien.aturulang();
				vm.position = "editdata";
				vm.$refs.FormPasien.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formpasien'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.edit;
				vm.executions();
			}
			else if (posisi == 'detail') {
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'registrasi') {
				vm.position = "registrasidata";
				vm.$refs.FormRegistrasi.show('registrasidata', 'Halaman Registrasi', data.uuid);
				setTimeout(() => { vm.loadingModal('formregistrasi'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.registrasipage;
				vm.executions();
			}
			else if (posisi == 'rawatinap') {
				vm.position = "rawatinapdata";
				vm.$refs.FormRegistrasiInap.show('rawatinapdata', 'Halaman Registrasi', data.uuid);
				setTimeout(() => { vm.loadingModal('formregistrasirawatinap'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.registrasipageinap;
				vm.executions();
			}
			else if (posisi == 'onedaycare') {
				vm.position = "onedaycaredata";
				vm.$refs.FormRegistrasiOdc.show('onedaycaredata', 'Halaman Registrasi', data.uuid);
				setTimeout(() => { vm.loadingModal('formregistrasiodc'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.registrasipageodc;
				vm.executions();
			}
			else if (posisi == 'panggil') {
				console.log(data)
				vm.position = 'panggil';
				vm.attach.url = vm.attach.link.call;
				vm.attach.data = new FormData();
				vm.attach.data.append('antrian_uuid', data.uuid);
				vm.attach.data.append('kode', data.kode);
				vm.attach.data.append('number', data.number);
				vm.attach.data.append('jenis', data.jenis);
				vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'panggil');
			}
			else if (posisi == 'selesai') {
				console.log(data)
				vm.position = 'selesai';
				vm.attach.url = vm.attach.link.finish;
				vm.attach.data = new FormData();
				vm.attach.data.append('antrian_uuid', data.uuid);
				vm.attach.data.append('kode', data.kode);
				vm.attach.data.append('number', data.number);
				vm.attach.data.append('jenis', data.jenis);
				vm.dialog('Yakin ingin menyudahi pelayanan pada nomor antrian pasien ini.', 'Ya, selesai', 'selesai');
			}
			else if (posisi == 'suratpersetujuan') {
				vm.$refs.FormCetakan.aturulang();
				vm.position = "cetakandata";
				vm.$refs.FormCetakan.show('cetakandata', 'Halaman Cetakan Data', data);
			}
			else if (posisi == 'uploadfile') {
				vm.$refs.FormUpload.aturulang();
				vm.position = "uploadfiledata";
				vm.$refs.FormUpload.show('uploadfiledata', 'Halaman Upload File', data);
			}
			else if (posisi == 'cetakkartu') {
				window.open(vm.attach.link.printcetakkartu + data.uuid, '_blank');
				setTimeout(() => {
					vm.$refs.Datatable.skeleton(); vm.posisieksternal='main';
					vm.tablereload();
				}, 2000);
			}
			else if (posisi == 'cetaklabel') {
				window.open(vm.attach.link.printcetaklabel + data.uuid, '_blank');
			}
			else if (posisi == 'cetakidentitas') {
				window.open('/customerservices/pasien/cetakidentitas/' + data.uuid, '_blank');
			}
			else if (posisi == 'cetaksuratsakit') {
				window.open('/customerservices/pasien/cetaksuratsakit/' + data.uuid, '_blank');
			}
			else if (posisi == 'cetaksuratsehat') {
				vm.position = "cetaksuratsehat";
				vm.$refs.FormPilihRoSuratSehat.show(data.uuid);
				setTimeout(() => { vm.loadingModal('cetaksuratsehat'); }, 250, this);
			}
			else if (posisi == 'cetaksuratro') {
				vm.position = "cetaksuratro";
				vm.$refs.FormPilihRoSuratRo.show(data.uuid);
				setTimeout(() => { vm.loadingModal('cetaksuratro'); }, 250, this);
			}
		},

		loadingModal: function (position) { 
			if (position == 'formpasien') { vm.$refs.FormPasien.loaderprocess();  }
			else if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
			else if (position == 'formregistrasi') { vm.$refs.FormRegistrasi.loaderprocess();  }
			else if (position == 'formregistrasirawatinap') { vm.$refs.FormRegistrasiInap.loaderprocess();  }
			else if (position == 'formregistrasiodc') { vm.$refs.FormRegistrasiOdc.loaderprocess();  }
			else if (position == 'formcetakan') { vm.$refs.FormCetakan.loaderprocess();  }
			else if (position == 'formfile') { vm.$refs.FormUpload.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'pasien') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; }  
			}
			else if (key == 'suratpersetujuan') { vm.attach.url = vm.attach.link.suratpersetujuan; }
			else if (key == 'uploadfile') { vm.attach.url = vm.attach.link.uploadfile; }
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },

		setDatatablekunjungan: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnkunjungan.length; j++) { col.push(vm.converterkunjungan(data[i], i, data[i][vm.columnkunjungan[j].value] ? data[i][vm.columnkunjungan[j].value] :vm.columnkunjungan[j].value, vm.columnkunjungan[j].value)); } temporer.push(col); } vm.modulekunjungan.data = temporer; vm.modulekunjungan.total = total; return temporer; },

		setDatatableantrian: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnantrian.length; j++) { col.push(vm.converterantrian(data[i], i, data[i][vm.columnantrian[j].value] ? data[i][vm.columnantrian[j].value] :vm.columnantrian[j].value, vm.columnantrian[j].value)); } temporer.push(col); } vm.moduleantrian.data = temporer; vm.moduleantrian.total = total; return temporer; },

		setDatatablepending: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnpending.length; j++) { col.push(vm.converterpending(data[i], i, data[i][vm.columnpending[j].value] ? data[i][vm.columnpending[j].value] :vm.columnpending[j].value, vm.columnpending[j].value)); } temporer.push(col); } vm.modulepending.data = temporer; vm.modulepending.total = total; return temporer; },

		tableload:function(pos = 'main') { 
			if (pos == 'main') {
				vm.attach.url = vm.attach.link.list; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'pending') {
				vm.attach.url = vm.attach.link.listpending; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'kunjungan') {
				vm.attach.url = vm.attach.link.listkunjungan; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else {
				vm.attach.url = vm.attach.link.antrian;
				vm.attach.data = new FormData();
				vm.attach.data.append('list', '');
			}
			
			vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (vm.posisieksternal == 'antrian') {
				if (pos == 'outer') {
					vm.$refs.DatatableAntrian.skeleton(); 
				}
				vm.attach.url = vm.attach.link.antrian; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'pending') {
				if (pos == 'outer') {
					vm.$refs.DatatablePending.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listpending; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'kunjungan') {
				if (pos == 'outer') {
					vm.$refs.DatatableKunjungan.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listkunjungan; 
				vm.attach.data = data; 
			}
			else {
				if (pos == 'outer') {
					vm.$refs.Datatable.skeleton(); 
				}
				vm.attach.url = vm.attach.link.list; 
				vm.attach.data = data; 
			}
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
		
		loadantrian:function() {
			vm.position = 'loadantrian'; 
			vm.firstloader(); 
			vm.tableload('antrian');
			
		},

		loadpending:function() {
			vm.position = 'loadpending'; 
			vm.firstloader(); 
			vm.tableload('pending');
			
		},

		loadkunjungan:function() {
			vm.position = 'loadkunjungan'; 
			vm.firstloader(); 
			vm.tableload('kunjungan');
			
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadantrian') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadpending') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadkunjungan') { vm.firstloader(); active = 1; }
			else if (vm.position == 'panggil') { vm.$refs.DatatableAntrian.skeleton(); }
			else if (vm.position == 'selesai') { vm.$refs.DatatableAntrian.skeleton(); }
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal='antrian') {
					vm.$refs.DatatableAntrian.skeleton(); 
					vm.$refs.DatatableAntrian.backpage(); 
				}
				else if (vm.posisieksternal='kunjungan') {
					vm.$refs.DatatableKunjungan.skeleton(); 
					vm.$refs.DatatableKunjungan.backpage(); 
				}
				else {
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.backpage(); 
				}
			}
			else if (vm.position == 'adddata') { vm.loadingModal('formpasien'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formpasien'); vm.$refs.FormPasien.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formpasien'); }
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			else if (vm.position == 'registrasidata') { vm.loadingModal('formregistrasi'); vm.$refs.FormRegistrasi.hide();  }
			else if (vm.position == 'rawatinapdata') { vm.loadingModal('formregistrasirawatinap'); vm.$refs.FormRegistrasiInap.hide();  }
			else if (vm.position == 'onedaycaredata') { vm.loadingModal('formregistrasiodc'); vm.$refs.FormRegistrasiOdc.hide();  }
			else if (vm.position == 'cetakandata') { vm.loadingModal('formcetakan');  }
			else if (vm.position == 'uploadfiledata') { vm.loadingModal('formfile');  }
			
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
				else if (vm.position == 'loadantrian') { 
					vm.posisieksternal='antrian';
					vm.firstloader();
					vm.$refs.DatatableAntrian.update(vm.columnantrian, vm.setDatatableantrian(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableAntrian.paging(); 
					active = 0;
				}
				else if (vm.position == 'loadpending') { 
					vm.posisieksternal='pending';
					vm.firstloader();
					vm.$refs.DatatablePending.update(vm.columnpending, vm.setDatatablepending(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatablePending.paging(); 
					active = 0;
				}
				else if (vm.position == 'loadkunjungan') { 
					vm.posisieksternal='kunjungan';
					vm.firstloader();
					vm.$refs.DatatableKunjungan.update(vm.columnkunjungan, vm.setDatatablekunjungan(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableKunjungan.paging(); 
					active = 0;
				}
				else if (vm.position == 'panggil') {
					setTimeout(() => { vm.posisieksternal='antrian'; vm.tablereload(); }, 500, this);
				}
				else if (vm.position == 'selesai') {
					setTimeout(() => { vm.posisieksternal='antrian'; vm.tablereload(); }, 500, this);
				}
				else if (vm.position == 'externaltable') { 
					if (vm.posisieksternal=='antrian') {
						vm.$refs.DatatableAntrian.update('', vm.setDatatableantrian(response.data.data, response.data.total), response.data.total); 
						vm.$refs.DatatableAntrian.skeleton(); 
						vm.$refs.DatatableAntrian.paging(); 
						active = 0;
					}
					else if (vm.posisieksternal=='pending') {
						vm.$refs.DatatablePending.update('', vm.setDatatablepending(response.data.data, response.data.total), response.data.total); 
						vm.$refs.DatatablePending.skeleton(); 
						vm.$refs.DatatablePending.paging(); 
						active = 0;
					}
					else if (vm.posisieksternal=='kunjungan') {
						vm.$refs.DatatableKunjungan.update('', vm.setDatatablekunjungan(response.data.data, response.data.total), response.data.total); 
						vm.$refs.DatatableKunjungan.skeleton(); 
						vm.$refs.DatatableKunjungan.paging(); 
						active = 0;
					}
					else {
						vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
						vm.$refs.Datatable.skeleton(); 
						vm.$refs.Datatable.paging(); 
						active = 0;
					}

				}
				else if (vm.position == 'adddata') {
					vm.posisieksternal='pasien';
					vm.loadingModal('formpasien');
					vm.$refs.FormPasien.hide(); 
					setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.posisieksternal='main'; vm.tablereload(); }, 500, this);
				}
				else if (vm.position == 'editdata') {
					vm.posisieksternal='pasien';
					vm.$refs.FormPasien.setdataform(response); 
					vm.position = "updatedata"; 
					active = 0; 
				}
				else if (vm.position == 'updatedata') {
					vm.posisieksternal='pasien';
					vm.loadingModal('formpasien');
					vm.$refs.FormPasien.hide(); 
					setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.posisieksternal='pasien'; vm.tablereload(); }, 500, this);
				}
				else if (vm.position == 'detaildata') {
					vm.posisieksternal='pasien';
					vm.$refs.FormDetail.setdataform(response); 
					vm.position = "-"; 
					active = 0; 
				}
				else if (vm.position == 'registrasidata') {
					vm.posisieksternal='pasien';
					vm.$refs.FormRegistrasi.setdataform(response); 
					vm.position = "-"; 
					active = 0; 
				}
				else if (vm.position == 'rawatinapdata') {
					vm.posisieksternal='pasien';
					vm.$refs.FormRegistrasiInap.setdataform(response); 
					vm.position = "-"; 
					active = 0; 
				}
				else if (vm.position == 'onedaycaredata') {
					vm.posisieksternal='pasien';
					vm.$refs.FormRegistrasiOdc.setdataform(response); 
					vm.position = "-"; 
					active = 0; 
				}
				else if (vm.position == 'cetakandata') {
					vm.posisieksternal='pasien';
					vm.loadingModal('formcetakan');
					vm.$refs.FormCetakan.hide(); 
					window.open(vm.attach.link.printsuratpersetujuan + response.data.data.uuid, '_blank');
					vm.position = "-"; 
					active = 0; 
				}
				else if (vm.position == 'uploadfiledata') {
					vm.posisieksternal='pasien';
					vm.loadingModal('formfile');
					vm.$refs.FormUpload.hide(); 
					setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.posisieksternal='pasien'; vm.tablereload(); }, 500, this);
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
				else if (vm.position == 'loadantrian') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadpending') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadkunjungan') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'panggil') { vm.notification('Gagal memanggil pasien.', 3000, position); }
				else if (vm.position == 'cetakandata') { vm.notification('Gagal mencetak surat persetujuan pasien.', 3000, position); }
				else if (vm.position == 'selesai') { vm.notification('Proses pendaftaran kunjungan pasien gagal disudahi.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'registrasidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'rawatinapdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'onedaycaredata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'uploadfiledata') { vm.notification('Penyimpanan data file gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'panggil') { vm.notification('Pasien berhasil dipanggil.', 3000, position); }
				else if (vm.position == 'selesai') { vm.notification('Proses pendaftaran kunjungan pasien berhasil disudahi.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'uploadfiledata') { vm.notification('Penyimpanan data file berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formpasien') { vm.loadingModal('formpasien'); }
			else if(posisi == 'panggil') { vm.$refs.DatatableAntrian.skeleton(); }
			else if(posisi == 'selesai') { vm.$refs.DatatableAntrian.skeleton(); }
			else if(posisi == 'formcetakan') { vm.loadingModal('formcetakan'); }
			else if(posisi == 'uploadfile') { vm.loadingModal('formfile'); }
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
