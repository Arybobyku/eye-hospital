<template>
<!-- <button class="tooltip btn-success" @click="goToPage('bedah-kasir')">Kasir (Tagihan Rawat Inap)</button>
<button class="tooltip btn-success" @click="goToPage('histori-kasir')">Histori (Tagihan Rawat Jalan)</button>
<button class="tooltip btn-success" @click="goToPage('histori-bebas')">Histori (Tagihan Rawat Inap)</button>
<button class="tooltip btn-success" @click="goToPage('histori-kasirrawatinap')">Histori (Pasien Bebas)</button> -->
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.today">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.bayar">
			<Datatable ref="DatatableBayar" :module="modulebayar" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-if="tab.content.beli">
			<Datatable ref="DatatableBeli" :module="modulebeli" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-if="tab.content.belibayar">
			<Datatable ref="DatatableBeliBayar" :module="modulebelibayar" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormDetail ref="FormDetail" @dialog="dialog" @parsingForm="parsingForm"></FormDetail>
<FormObat ref="FormObat" @dialog="dialog" @parsingForm="parsingForm"></FormObat>
<FormPanjar ref="FormPanjar" @dialog="dialog" @parsingForm="parsingForm"></FormPanjar>
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
		FormDetail: defineAsyncComponent(() => import('./FormDetail.vue')),
		FormObat: defineAsyncComponent(() => import('./FormObat.vue')),
		FormPanjar: defineAsyncComponent(() => import('./FormPanjar.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		uri: 'detail',
		position: '',
		attach: {
			link : {
				list: '/finance/kasir/editlistsudahbayar',
				listsudahbayar: '/finance/kasir/editlistsudahbayar',
				call: '/finance/kasir/call',
				detail: '/finance/kasir/detail',
				bayar: '/finance/kasir/bayar',
				cancelbayar: '/finance/kasir/cancelbayar',
				terima: '/finance/kasir/terima',
				kasir: '/print/kasir/',
				kasirrincian: '/print/kasirrincian/',
				panjar: '/print/panjar/',
				getpanjar: '/finance/kasir/getpanjar',
				addpanjar: '/finance/kasir/addpanjar',
				hapusbiaya: '/finance/kasir/hapusbiaya',
				perbaharuibiaya: '/finance/kasir/perbaharuibiaya',
				rekammedis: '/print/rekammedis/',

				listbeli: '/finance/bebas/list',
				listbelibayar: '/finance/bebas/listbayar',
				addbeli: '/finance/bebas/add',
				detailbeli: '/finance/bebas/detail',
				callbeli: '/finance/bebas/call',
				selesaibeli: '/finance/bebas/selesai',
				kasirbeli: '/print/kasirbeli/',
			}, url: '', data: null
		},
		column: [
			{ value: 'no_kwitansi', label: 'No Kwitansi', type: 'text', search: true, close: false, button: false },
			{ value: 'no_pendaftaran', label: 'No Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'carabayar_nama', label: 'Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'status_kasir', label: 'Status', type: 'text', search: false, close: false, button: false },
			{ value: 'approvement_obat', label: 'Obat-Obatan', type: 'text', search: false, close: false, button: false },
			{ value: 'panjar', label: 'Nominial Panjar', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		columnbayar: [
			{ value: 'no_kwitansi', label: 'No Kwitansi', type: 'text', search: true, close: false, button: false },
			{ value: 'no_pendaftaran', label: 'No Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'carabayar_nama', label: 'Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'status_kasir', label: 'Status', type: 'text', search: false, close: false, button: false },
			{ value: 'approvement_obat', label: 'Obat-Obatan', type: 'text', search: false, close: false, button: false },
			{ value: 'panjar', label: 'Nominial Panjar', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		columnbeli: [
			{ value: 'tanggal', label: 'Tanggal', type: 'text', search: true, close: false, button: false },
			{ value: 'no_invoice', label: 'No Invoice', type: 'text', search: true, close: false, button: false },
			{ value: 'kode', label: 'Kode Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis', label: 'Jenis Obat', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pembeli', type: 'text', search: true, close: false, button: false },
			{ value: 'ada_obat', label: 'Obat Sudah Ditambahkan?', type: 'text', search: false, close: false, button: false },
			{ value: 'pembayaran', label: 'Pembayaran', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		columnbelibayar: [
			{ value: 'tanggal', label: 'Tanggal', type: 'text', search: true, close: false, button: false },
			{ value: 'no_invoice', label: 'No Invoice', type: 'text', search: true, close: false, button: false },
			{ value: 'kode', label: 'Kode Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis', label: 'Jenis Obat', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pembeli', type: 'text', search: true, close: false, button: false },
			{ value: 'ada_obat', label: 'Obat Sudah Ditambahkan?', type: 'text', search: false, close: false, button: false },
			{ value: 'pembayaran', label: 'Pembayaran', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
		modulebayar: { data: [], column: [], total: 0, ispaging: true },
		modulebeli: { data: [], column: [], total: 0, ispaging: true },
		modulebelibayar: { data: [], column: [], total: 0, ispaging: true },
		tab: {
			button: [
				// { value: 'today', label: 'Tagihan (Aktif)', class: 'tab-active' },
				{ value: 'bayar', label: 'Tagihan (Sudah Bayar)', class: 'tab-no-active' },
				// { value: 'beli', label: 'Pasien Bebas (Aktif)', class: 'tab-no-active' },
				// { value: 'belibayar', label: 'Pasien Bebas (Sudah Bayar)', class: 'tab-no-active' },
			],
			content: { 
				bayar: true,
				today: false,  
				beli: false,
				belibayar: false,
			}
		},
		posisieksternal: 'today'
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename, formatrupiah,
		goToPage: function(link){
			const _base = '/dashboard/';
			this.$router.push(_base + link);
		},
		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;

				if (values == 'bayar') {
					vm.loadbayar();
					vm.posisieksternal = 'bayar';
				}
				else if (values == 'beli') {
					vm.loadbeli();
					vm.posisieksternal = 'beli';
				}
				else if (values == 'belibayar') {
					vm.loadbelibayar();
					vm.posisieksternal = 'belibayar';
				}
				else {
					vm.posisieksternal = 'today';
					vm.loadmain();
				}
			}
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Edit Data', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-info', posisi: 'print', tooltip: 'Cetak Kwitansi', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-warning', posisi: 'printrincian', tooltip: 'Cetak Rincian Tagihan', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'bell', color: 'btn-info', posisi: 'panggil', tooltip: 'Panggil Pasien', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'bell', color: 'btn-info', posisi: 'openpanjar', tooltip: 'Input Nominal Panjar', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'bell', color: 'btn-info', posisi: 'printpanjar', tooltip: 'Cetak Panjar', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' && _item.panjar != 0 ? true : false },
				{ icon: 'aperture', color: 'btn-warning', posisi: 'lihatobat', tooltip: 'Lihat Data Obat', item: _item, index: _index, 
				show: _item.approvement_obat == 'yes' && _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-info', posisi: 'print', tooltip: 'Cetak Kwitansi', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-warning', posisi: 'printrincian', tooltip: 'Cetak Rincian Tagihan', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cancelbayar', tooltip: 'Batalkan Pembayaran', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				// { icon: 'printer', color: 'btn-success', posisi: 'rekammedis', tooltip: 'Cetak Rekam Medis', item: _item, index: _index, 
				// show: _item.status_kasir == 'Sudah Bayar' ? true : false },
			]
			return str;
		},

		btnhtmlbayar:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, 
				show: _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'aperture', color: 'btn-warning', posisi: 'lihatobat', tooltip: 'Lihat Data Obat', item: _item, index: _index, 
				show: _item.approvement_obat == 'yes' && _item.status_kasir == 'Belum Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-info', posisi: 'print', tooltip: 'Cetak Kwitansi', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-warning', posisi: 'printrincian', tooltip: 'Cetak Rincian Tagihan', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cancelbayar', tooltip: 'Batalkan Pembayaran', item: _item, index: _index, 
				show: _item.status_kasir == 'Sudah Bayar' ? true : false },
				// { icon: 'printer', color: 'btn-success', posisi: 'rekammedis', tooltip: 'Cetak Rekam Medis', item: _item, index: _index, 
				// show: _item.status_kasir == 'Sudah Bayar' ? true : false },
			]
			return str;
		},

		btnhtmlbeli:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detailbeli', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'bell', color: 'btn-info', posisi: 'panggilbeli', tooltip: 'Panggil Antrian', item: _item, index: _index, show: true },
				{ 
					icon: 'printer', color: 'btn-warning', posisi: 'selesaibeli', tooltip: 'Cetak Tagihan', item: _item, index: _index, 
					show: _item.pembayaran == 'Sudah Bayar' ? true : false
				}
			]
			return str;
		},

		btnhtmlbelibayar:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detailbeli', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'bell', color: 'btn-info', posisi: 'panggilbeli', tooltip: 'Panggil Antrian', item: _item, index: _index, show: true },
				{ 
					icon: 'printer', color: 'btn-warning', posisi: 'selesaibeli', tooltip: 'Cetak Tagihan', item: _item, index: _index, 
					show: _item.pembayaran == 'Sudah Bayar' ? true : false
				}
			]
			return str;
		},

		nopendaftaran:function(data) {
			if (data.status_antrian_kasir == 'active') {
				return data.no_pendaftaran + '<div class="badge badge-success">'+ data.status_antrian_kasir +'</div>';
			}
			else {
				return data.no_pendaftaran;
			}
		},

		approvementobat:function(data) {
			if (data.ada_obat == 'Ya') {
				if (data.approvement_obat == 'no') { return 'Belum diapprove'; }
				return 'Sudah diapprove';
			}
			return 'Tidak ada obat';
			
		},

		panajrs:function(data) {
			return formatrupiah(data.panjar.toString());
		},

		namapasien:function(data) {
			return data.sebutan + ' ' + data.nama_pasien;
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'no_pendaftaran') { _tmp = { value: vm.nopendaftaran(data), ishtml: 'html', style: '' }; }
			else if (identity == 'nama_pasien') { _tmp = { value: vm.namapasien(data), ishtml: 'html', style: '' }; }
			else if (identity == 'approvement_obat') { _tmp = { value: vm.approvementobat(data), ishtml: 'html', style: '' }; }
			else if (identity == 'panjar') { _tmp = { value: vm.panajrs(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		approvepanjar:function(data) {
			if (data.approve_panjar == 0) { return 'Belum Diterima'; }
			return 'Sudah Diterima';
		},

		statuspelunasan:function(data) {
			if (data.status_kasir == 'Belum Bayar') { return 'Belum Dibayar'; }
			return 'Sudah Dibayar';
		},

		converterbayar: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'no_pendaftaran') { _tmp = { value: vm.nopendaftaran(data), ishtml: 'html', style: '' }; }
			else if (identity == 'nama_pasien') { _tmp = { value: vm.namapasien(data), ishtml: 'html', style: '' }; }
			else if (identity == 'approvement_obat') { _tmp = { value: vm.approvementobat(data), ishtml: 'html', style: '' }; }
			else if (identity == 'panjar') { _tmp = { value: vm.panajrs(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		nopendaftaranbeli:function(data) {
			if (data.active_call_kasir == 'active') {
				return data.tanggal + '<div class="badge badge-success">'+ data.active_call +'</div>';
			}
			else {
				return data.tanggal;
			}
		},

		adaobat:function(data) {
			if (data.ada_obat == 'Tidak') { return 'Belum Ditambahkan'; }
			return 'Sudah Ditambahkan';
		},

		numbers:function(data) {
			if (data > 0 && data < 10) { return '00' + data; }
			else if (data > 10 && data < 100) { return '0' + data; }
			else if (data > 100 && data < 1000) { return data; }
		},

		noinvoice:function(data) {
			return 'PB'+data.no_invoice;
		},

		converterbeli: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtmlbeli(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'number') { _tmp = { value: vm.numbers(column), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.nopendaftaranbeli(data), ishtml: 'html', style: '' }; }
			else if (identity == 'no_invoice') { _tmp = { value: vm.noinvoice(data), ishtml: 'html', style: '' }; }
			else if (identity == 'ada_obat') { _tmp = { value: vm.adaobat(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		converterbelibayar: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtmlbeli(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'number') { _tmp = { value: vm.numbers(column), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.nopendaftaranbeli(data), ishtml: 'html', style: '' }; }
			else if (identity == 'no_invoice') { _tmp = { value: vm.noinvoice(data), ishtml: 'html', style: '' }; }
			else if (identity == 'ada_obat') { _tmp = { value: vm.adaobat(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'detail') {
				vm.$refs.FormDetail.aturulang();
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'openpanjar') {
				vm.$refs.FormPanjar.aturulang();
				vm.position = "panjardata";
				vm.$refs.FormPanjar.show('panjardata', 'Detail Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formpanjar'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.getpanjar;
				vm.executions();
			}
			else if (posisi == 'histori') {
				vm.$refs.FormHistori.aturulang();
				vm.position = "historidata";
				vm.$refs.FormHistori.show('historidata', 'Histori Pemeriksaan RO', data.uuid);
				setTimeout(() => { vm.loadingModal('formhistori'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.histori;
				vm.executions();
			}
			else if (posisi == 'historidokter') {
				vm.$refs.FormHistoriDokter.aturulang();
				vm.position = "historidokter";
				vm.$refs.FormHistoriDokter.show('historidokter', 'Histori Pemeriksaan Dokter', data.uuid);
				setTimeout(() => { vm.loadingModal('formhistoridokter'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.historidokter;
				vm.executions();
			}
			else if (posisi == 'print') {
				window.open(vm.attach.link.kasir + data.uuid, '_blank');
			}
			else if (posisi == 'printrincian') {
				window.open(vm.attach.link.kasirrincian + data.uuid, '_blank');
			}
			else if (posisi == 'printpanjar') {
				window.open(vm.attach.link.panjar + data.uuid, '_blank');
			}
			else if (posisi == 'rekammedis') {
				window.open(vm.attach.link.rekammedis + data.uuid, '_blank');
			}
			else if (posisi == 'panggil') {
				vm.position = 'call';
				vm.attach.url = vm.attach.link.call;
				console.log(data)
				vm.attach.data = new FormData();
				let number = data.no_pendaftaran.split("-");
				number = parseInt(number[1]);
				vm.attach.data.append('number', number);
				vm.attach.data.append('ruang_poliklinik', data.ruang_poliklinik);
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				if (data.ruang_poliklinik != 0) {
					vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'call');
				}
			}
			else if (posisi == 'panggil1') {
				vm.position = 'call1';
				vm.attach.url = vm.attach.link.call;
				console.log(data)
				vm.attach.data = new FormData();
				let number = data.no_pendaftaran.split("-");
				number = parseInt(number[1]);
				vm.attach.data.append('number', number);
				vm.attach.data.append('ruang_poliklinik', data.ruang_poliklinik);
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				if (data.ruang_poliklinik != 0) {
					vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'call1');
				}
			}
			else if (posisi == 'terima') {
				vm.position = "terimadata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.terima;
				vm.dialog('Yakin ingin menerima panjar pasien.', 'Ya, proses panjar', 'terimadata');
			}
			else if (posisi == 'panggilbeli') {
				vm.position = 'callbeli';
				vm.attach.url = vm.attach.link.callbeli;
				console.log(data)
				vm.attach.data = new FormData();
				vm.attach.data.append('number', data.number);
				vm.attach.data.append('uuid', data.uuid);
				vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'callbeli');
			}
			else if (posisi == 'selesaibeli') {
				window.open(vm.attach.link.kasirbeli + data.uuid, '_blank');
			}
			else if (posisi == 'detailbeli') {
				vm.$refs.FormObat.aturulang();
				vm.position = "detaildatabeli";
				vm.$refs.FormObat.show('detaildatabeli', 'Detail Data', data.uuid, data.pembayaran);
				setTimeout(() => { vm.loadingModal('formobat'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detailbeli;
				vm.executions();
			}
			else if (posisi == 'cancelbayar') {
				vm.position = 'cancelbayar';
				vm.attach.url = vm.attach.link.cancelbayar;
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.dialog('Yakin ingin membatalkan pembayaran ini.', 'Ya, batalkan pembayaran', 'cancelbayar');
			}
		},

		loadingModal: function (position) { 
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
			else if (position == 'formhistori') { vm.$refs.FormHistori.loaderprocess();  }
			else if (position == 'formpanjar') { vm.$refs.FormPanjar.loaderprocess();  }
			else if (position == 'formhistoridokter') { vm.$refs.FormHistoriDokter.loaderprocess();  }
			else if (position == 'formobat') { vm.$refs.FormObat.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'add') { vm.position = 'updatedata'; vm.attach.url = vm.attach.link.bayar; }
			else if (key == 'formobat') {
				if (vm.position == 'updatedatabeli') {  vm.attach.url = vm.attach.link.addbeli; } 
			}
			else if (key == 'panjar') { vm.position = 'updatepanjar'; vm.attach.url = vm.attach.link.addpanjar; }
			else if (key == 'hapus') { vm.position = 'hapusbiaya'; vm.attach.url = vm.attach.link.hapusbiaya; }
			else if (key == 'perbaharui') { vm.position = 'perbaharuibiaya'; vm.attach.url = vm.attach.link.perbaharuibiaya; }
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },
		setDatatablebayar: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnbayar.length; j++) { col.push(vm.converterbayar(data[i], i, data[i][vm.columnbayar[j].value] ? data[i][vm.columnbayar[j].value] :vm.columnbayar[j].value, vm.columnbayar[j].value)); } temporer.push(col); } vm.modulebayar.data = temporer; vm.modulebayar.total = total; return temporer; },
		setDatatablebeli: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnbeli.length; j++) { col.push(vm.converterbeli(data[i], i, data[i][vm.columnbeli[j].value] ? data[i][vm.columnbeli[j].value] :vm.columnbeli[j].value, vm.columnbeli[j].value)); } temporer.push(col); } vm.modulebeli.data = temporer; vm.modulebeli.total = total; return temporer; },
		setDatatablebelibayar: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnbelibayar.length; j++) { col.push(vm.converterbelibayar(data[i], i, data[i][vm.columnbelibayar[j].value] ? data[i][vm.columnbelibayar[j].value] :vm.columnbelibayar[j].value, vm.columnbelibayar[j].value)); } temporer.push(col); } vm.modulebelibayar.data = temporer; vm.modulebelibayar.total = total; return temporer; },
		
		tableload:function(pos = 'main') { 
			if (pos == 'main') {
				vm.attach.url = vm.attach.link.list; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'bayar') {
				vm.attach.url = vm.attach.link.listsudahbayar; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			}
			else if (pos == 'beli') {
				vm.attach.url = vm.attach.link.listbeli; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			}
			else if (pos == 'belibayar') {
				vm.attach.url = vm.attach.link.listbelibayar; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			}
			
			vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (vm.posisieksternal == 'bayar') {
				if (pos == 'outer') {
					vm.$refs.DatatableBayar.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listsudahbayar; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'beli') {
				if (pos == 'outer') {
					vm.$refs.DatatableBeli.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listbeli; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'belibayar') {
				if (pos == 'outer') {
					vm.$refs.DatatableBeliBayar.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listbelibayar; 
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

		loadmain: () => { vm.position = 'loadbayar'; vm.firstloader(); vm.tableload(); },

		loadbayar:function() {
			vm.position = 'loadbayar'; 
			vm.firstloader(); 
			vm.tableload('bayar');
		},

		loadbeli:function() {
			vm.position = 'loadbeli'; 
			vm.firstloader(); 
			vm.tableload('beli');
		},

		loadbelibayar:function() {
			vm.position = 'loadbelibayar'; 
			vm.firstloader(); 
			vm.tableload('belibayar');
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadbayar') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadbeli') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadbelibayar') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal='bayar') {
					vm.$refs.DatatableBayar.skeleton(); 
					vm.$refs.DatatableBayar.backpage(); 
				}
				else if (vm.posisieksternal='beli') {
					vm.$refs.DatatableBeli.skeleton(); 
					vm.$refs.DatatableBeli.backpage(); 
				}
				else if (vm.posisieksternal='belibayar') {
					vm.$refs.DatatableBeliBayar.skeleton(); 
					vm.$refs.DatatableBeliBayar.backpage(); 
				}
				else {
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.backpage(); 
				} 
			}
			else if (vm.position == 'call') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'cancelbayar') { vm.$refs.DatatableBayar.skeleton(); }
			else if (vm.position == 'updatedata') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'updatepanjar') { vm.loadingModal('formpanjar'); }
			else if (vm.position == 'hapusbiaya') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'perbaharuibiaya') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'updatedatabeli') { vm.loadingModal('formobat'); }
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			else if (vm.position == 'panjardata') { vm.loadingModal('formpanjar'); vm.$refs.FormPanjar.hide();  }
			else if (vm.position == 'detaildatabeli') { vm.loadingModal('formobat'); vm.$refs.FormObat.hide();  }
			else if (vm.position == 'historidata') { vm.loadingModal('formhistori'); vm.$refs.FormHistori.hide();  }
			else if (vm.position == 'historidokter') { vm.loadingModal('formhistoridokter'); vm.$refs.FormHistoriDokter.hide();  }
			else if (vm.position == 'callbeli') { vm.$refs.DatatableBeli.skeleton(); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'loadmain') { 
				vm.posisieksternal='today';
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadbayar') { 
				vm.posisieksternal='bayar';
				vm.firstloader();
				vm.$refs.DatatableBayar.update(vm.columnbayar, vm.setDatatablebayar(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableBayar.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadbeli') { 
				vm.posisieksternal='beli';
				vm.firstloader();
				vm.$refs.DatatableBeli.update(vm.columnbeli, vm.setDatatablebeli(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableBeli.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadbelibayar') { 
				vm.posisieksternal='belibayar';
				vm.firstloader();
				vm.$refs.DatatableBeliBayar.update(vm.columnbelibayar, vm.setDatatablebelibayar(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableBeliBayar.paging(); 
				active = 0;
			}
			else if (vm.position == 'externaltable') { 

				if (vm.posisieksternal=='bayar') {
					vm.$refs.DatatableBayar.update('', vm.setDatatablebayar(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableBayar.skeleton(); 
					vm.$refs.DatatableBayar.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='beli') {
					vm.$refs.DatatableBeli.update('', vm.setDatatablebeli(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableBeli.skeleton(); 
					vm.$refs.DatatableBeli.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='belibayar') {
					vm.$refs.DatatableBeliBayar.update('', vm.setDatatablebelibayar(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableBeliBayar.skeleton(); 
					vm.$refs.DatatableBeliBayar.paging(); 
					active = 0;
				}
				else {
					vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.paging(); 
					active = 0;
				}
			}
			else if (vm.position == 'call') { 
				vm.tablereload();
				active = 0;
			}
			else if (vm.position == 'cancelbayar') { 
				setTimeout(() => { vm.tablereload(); }, 500, this);
				active = 1;
			}
			else if (vm.position == 'call1') { 
				vm.tablereload();
				active = 0;
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormDetail.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'hapusbiaya') {
				vm.$refs.FormDetail.setdataform(response); 
				vm.position = "updatedata"; 
				active = 1; 
			}
			else if (vm.position == 'perbaharuibiaya') {
				vm.$refs.FormDetail.setdataform(response); 
				vm.position = "updatedata"; 
				active = 1; 
			}
			else if (vm.position == 'panjardata') {
				vm.$refs.FormPanjar.setdataform(response); 
				vm.position = "updatepanjar"; 
				active = 0; 
			}
			else if (vm.position == 'historidata') {
				vm.$refs.FormHistori.setdataform(response); 
				//vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'historidokter') {
				vm.loadingModal('formhistoridokter');
				vm.$refs.FormHistoriDokter.setdataform(response); 
				//vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formdetail');
				vm.$refs.FormDetail.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'updatepanjar') {
				vm.loadingModal('formpanjar');
				vm.$refs.FormPanjar.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'terimadata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'callbeli') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'detaildatabeli') {
				vm.$refs.FormObat.setdataform(response); 
				vm.position = "updatedatabeli"; 
				active = 0; 
			}
			else if (vm.position == 'updatedatabeli') {
				vm.loadingModal('formobat');
				vm.$refs.FormObat.hide(); 
				setTimeout(() => { vm.$refs.DatatableBeli.skeleton(); vm.tablereload(); }, 500, this);
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadbeli') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadbelibayar') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadbayar') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Gagal memanggil antrian pasien.', 3000, position); }
				else if (vm.position == 'cancelbayar') { vm.notification('Gagal membatalkan pembayaran pasien.', 3000, position); }
				else if (vm.position == 'call1') { vm.notification('Gagal memanggil antrian pasien.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Data tagihan pasien gagal diproses.', 3000, position); }
				else if (vm.position == 'updatepanjar') { vm.notification('Data panjar pasien gagal diproses.', 3000, position); }
				else if (vm.position == 'updatedatabeli') { vm.notification('Data tagihan pasien gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'hapusbiaya') { vm.notification('Proses hapus biaya gagal dilakukan.', 3000, position); }
				else if (vm.position == 'perbaharuibiaya') { vm.notification('Proses perbaharui biaya gagal dilakukan.', 3000, position); }
				else if (vm.position == 'panjardata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'detaildatabeli') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidokter') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'terimadata') { vm.notification('Uang panjar gagal diproses.', 3000, position); }
				else if (vm.position == 'callbeli') { vm.notification('Pemanggilan antrian gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'updatedata') { vm.notification('Data tagihan pasien berhasil diproses.', 3000, position); }
				else if (vm.position == 'hapusbiaya') { vm.notification('Proses hapus biaya berhasil dilakukan.', 3000, position); }
				else if (vm.position == 'perbaharuibiaya') { vm.notification('Proses perbaharui biaya berhasil dilakukan.', 3000, position); }
				else if (vm.position == 'updatepanjar') { vm.notification('Data panjar pasien berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedatabeli') { vm.notification('Data tagihan pasien berhasil diproses.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Antrian pasien berhasil dipanggil.', 3000, position); }
				else if (vm.position == 'cancelbayar') { vm.notification('Pembayaran pasien berhasil dibatalkan.', 3000, position); }
				else if (vm.position == 'call1') { vm.notification('Antrian pasien berhasil dipanggil.', 3000, position); }
				else if (vm.position == 'terimadata') { vm.notification('Uang Panjar berhasil diproses.', 3000, position); }
				else if (vm.position == 'callbeli') { vm.notification('Pemanggilan antrian berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formdetail') { vm.loadingModal('formdetail'); }
			else if (posisi == 'formobat') { vm.loadingModal('formobat'); }
			else if (posisi == 'formpanjar') { vm.loadingModal('formpanjar'); }
			else if (posisi == 'call') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'cancelbayar') { vm.$refs.DatatableBayar.skeleton(); }
			else if (posisi == 'callbeli') { vm.$refs.DatatableBeli.skeleton(); }
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
