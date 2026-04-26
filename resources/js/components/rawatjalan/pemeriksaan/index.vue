<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>

		<div class="tab-content">
			<div class="content-tab-in" v-if="tab.content.ro_bpjs">
				<Datatable ref="DatatableRoBpjs" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
			</div>
			<div class="content-tab-in" v-else-if="tab.content.ro_nonbpjs">
				<Datatable ref="DatatableRoNonBpjs" :module="moduleRoNonBpjs" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
			</div>
			<div class="content-tab-in" v-else-if="tab.content.perawat_bpjs">
				<Datatable ref="DatatablePerawatBpjs" :module="moduleperawat" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
			</div>
			<div class="content-tab-in" v-else-if="tab.content.perawat_nonbpjs">
				<Datatable ref="DatatablePerawatNonBpjs" :module="modulePerawatNonBpjs" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
			</div>
		</div>
	<!-- <div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div> -->
	<Loader ref="Loader"></Loader>
</div>
<FormPerawat ref="FormPerawat" @dialog="dialog" @parsingForm="parsingForm"></FormPerawat>
<FormDetail ref="FormDetail" @dialog="dialog" @parsingForm="parsingForm"></FormDetail>
<FormHistori ref="FormHistori"></FormHistori>

</template>

<script>
var vm, audio;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal,
		FormPerawat: defineAsyncComponent(() => import('./FormPerawat.vue')),
		FormDetail: defineAsyncComponent(() => import('./FormDetail.vue')),
		FormHistori: defineAsyncComponent(() => import('./FormHistori.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {

		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadRoBpjs();
		Echo.channel('rotrades')
				.listen('NewTradeRo', (e) => {
					vm.triggercall(e.trade);
					//console.log(e.trade);
				});
	},
	data: function () { return {
		uri: 'detail',
		position: '',
		attach: {
			link : {
				list: '/rawatjalan/pemeriksaan/list',
				listperawat: '/rawatjalan/pemeriksaan/listperawat',
				add: '/rawatjalan/pemeriksaan/add',
				addperawat: '/rawatjalan/pemeriksaan/addperawat',
				detail: '/rawatjalan/pemeriksaan/detail',
				detailperawat: '/rawatjalan/pemeriksaan/detailperawat',
				histori: '/rawatjalan/pemeriksaan/histori',
				call: '/rawatjalan/pemeriksaan/call',
			}, url: '', data: null
		},
		column: [
			{ value: 'no_pendaftaran', label: 'No Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'berkebutuhan_khusus', label: 'Triase?', type: 'text', search: false, close: false, button: false },
			{ value: 'status_ro', label: 'status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		columnperawat: [
			{ value: 'no_pendaftaran', label: 'No Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'berkebutuhan_khusus', label: 'Triase?', type: 'text', search: false, close: false, button: false },
			{ value: 'status_ro', label: 'status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtmlperawat', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
		moduleRoNonBpjs: { data: [], column: [], total: 0, ispaging: true },
		moduleperawat: { data: [], column: [], total: 0, ispaging: true },
		modulePerawatNonBpjs: { data: [], column: [], total: 0, ispaging: true },
		tab: {
			button: [
				{ value: 'ro_bpjs', label: 'RO (BPJS)', class: 'tab-active' },
				{ value: 'ro_nonbpjs', label: 'RO (Non BPJS)', class: 'tab-no-active' },
				{ value: 'perawat_bpjs', label: 'Perawat (BPJS)', class: 'tab-no-active' },
				{ value: 'perawat_nonbpjs', label: 'Perawat (Non BPJS)', class: 'tab-no-active' },
			],
			content: {
				ro_bpjs: true,
				ro_nonbpjs: false,
				perawat_bpjs: false,
				perawat_nonbpjs: false,
			}
		},
	}},
	methods: {
		bunyibell:function() {
			var audio = new Audio('/mp3/robell.mp3');
			audio.play();
		},

		triggercall:function() {
			vm.bunyibell();
		},
		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,
		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) {
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active';
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;

				if (values == 'ro_nonbpjs') {
					vm.posisieksternal = 'ro_nonbpjs';
					vm.loadRoNonBpjs();
				}
				else if (values == 'perawat_bpjs') {
					vm.posisieksternal = 'perawat_bpjs';
					vm.loadPerawatBpjs();
				}
				else if (values == 'perawat_nonbpjs') {
					vm.posisieksternal = 'perawat_nonbpjs';
					vm.loadPerawatNonBpjs();
				}
				else {
					vm.posisieksternal = 'ro_bpjs';
					vm.loadRoBpjs();
				}
			}
		},
		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Pemeriksaan RO', item: _item, index: _index, show: true },
				// { icon: 'arrow-up', color: 'btn-success', posisi: 'detailperawat', tooltip: 'Pemeriksaan Perawat', item: _item, index: _index, show: true },
				{ icon: 'bell', color: 'btn-info', posisi: 'panggil', tooltip: 'Panggil Pasien', item: _item, index: _index, show: true },
				{ icon: 'book', color: 'btn-warning', posisi: 'histori', tooltip: 'Log Pemeriksaan RO', item: _item, index: _index, show: true },
				{ icon: 'file-text', color: 'btn-primary', posisi: 'rme', tooltip: 'Informed Consent (RME)', item: _item, index: _index, show: true },
			]
			return str;
		},

		btnhtmlperawat:function(_item, _index) {
			let str = [
				// { icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Pemeriksaan RO', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detailperawat', tooltip: 'Pemeriksaan Perawat', item: _item, index: _index, show: true },
				{ icon: 'bell', color: 'btn-info', posisi: 'panggil', tooltip: 'Panggil Pasien', item: _item, index: _index, show: true },
				{ icon: 'book', color: 'btn-warning', posisi: 'histori', tooltip: 'Log Pemeriksaan RO', item: _item, index: _index, show: true },
				{ icon: 'file-text', color: 'btn-primary', posisi: 'rme', tooltip: 'Informed Consent (RME)', item: _item, index: _index, show: true },
			]
			return str;
		},


		statusro:function(data) {
			if (data.status_ro == 'Belum Diperiksa') {
				return '<div class="badge badge-danger">'+data.status_ro+'</div>';
			}
			if (data.status_ro == 'Sudah Diperiksa Perawat' || data.status_ro == 'Sudah Diperiksa RO') {
				return '<div class="badge badge-warning">'+data.status_ro+'</div>';
			}
			return '<div class="badge badge-success">'+data.status_ro+'</div>'
		},

		nopendaftaran:function(data) {
			if (data.status_antrian_ro == 'active') {
				return data.no_pendaftaran + '<div class="badge badge-success">'+ data.status_antrian_ro +'</div>';
			}
			else {
				return data.no_pendaftaran;
			}
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'btnhtmlperawat') { _tmp = { value: vm.btnhtmlperawat(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'no_pendaftaran') { _tmp = { value: vm.nopendaftaran(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status_ro') { _tmp = { value: vm.statusro(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'detailperawat') {
				vm.$refs.FormPerawat.aturulang();
				vm.position = "detaildataperawat";
				vm.$refs.FormPerawat.show('detaildataperawat', 'Detail Data Perawat', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetailperawat'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detailperawat;
				vm.executions();
			}
			else if (posisi == 'detail') {
				vm.$refs.FormDetail.aturulang();
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detail;
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
			else if (posisi == 'panggil') {
				vm.position = 'call';
				vm.attach.url = vm.attach.link.call;
				console.log(data)
				vm.attach.data = new FormData();
				let number = data.no_pendaftaran.split("-");
				number = parseInt(number[1]);
				vm.attach.data.append('number', number);
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('pengguna_uuid', data.pengguna_uuid);
				vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'call');

			}
			else if (posisi == 'rme') {
				vm.$router.push({
					name: 'RME (Data Pasien)',
					query: {
						pasien_uuid: data.pasien_uuid,
						rekam_medis: data.rekam_medis,
						menu: 'Informed Consent',
					}
				});
			}
		},

		loadingModal: function (position) {
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
			else if (position == 'formdetailperawat') { vm.$refs.FormPerawat.loaderprocess();  }
			else if (position == 'formhistori') { vm.$refs.FormHistori.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'add') { vm.attach.url = vm.attach.link.add; }
			else if (key == 'addperawat') { vm.attach.url = vm.attach.link.addperawat; }
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },
		setDatatableRoNonBpjs: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.moduleRoNonBpjs.data = temporer; vm.moduleRoNonBpjs.total = total; return temporer; },
		setDatatablePerawat: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnperawat.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.columnperawat[j].value] ? data[i][vm.columnperawat[j].value] :vm.columnperawat[j].value, vm.columnperawat[j].value)); } temporer.push(col); } vm.moduleperawat.data = temporer; vm.moduleperawat.total = total; return temporer; },
		setDatatablePerawatNonBpjs: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnperawat.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.columnperawat[j].value] ? data[i][vm.columnperawat[j].value] :vm.columnperawat[j].value, vm.columnperawat[j].value)); } temporer.push(col); } vm.modulePerawatNonBpjs.data = temporer; vm.modulePerawatNonBpjs.total = total; return temporer; },
		tableload:function(pos = 'ro_bpjs') {
			if (pos == 'ro_bpjs') {
				vm.attach.url = vm.attach.link.list;
				vm.attach.data = new FormData();
				vm.attach.data.append('search', '');
				vm.attach.data.append('column', '');
				vm.attach.data.append('page', 1);
				vm.attach.data.append('carabayar_filter', 'bpjs');
			}
			else if (pos == 'ro_nonbpjs') {
				vm.attach.url = vm.attach.link.list;
				vm.attach.data = new FormData();
				vm.attach.data.append('search', '');
				vm.attach.data.append('column', '');
				vm.attach.data.append('page', 1);
				vm.attach.data.append('carabayar_filter', 'nonbpjs');
			}
			else if (pos == 'perawat_bpjs') {
				vm.attach.url = vm.attach.link.listperawat;
				vm.attach.data = new FormData();
				vm.attach.data.append('search', '');
				vm.attach.data.append('column', '');
				vm.attach.data.append('page', 1);
				vm.attach.data.append('carabayar_filter', 'bpjs');
			}
			else {
				vm.attach.url = vm.attach.link.listperawat;
				vm.attach.data = new FormData();
				vm.attach.data.append('search', '');
				vm.attach.data.append('column', '');
				vm.attach.data.append('page', 1);
				vm.attach.data.append('carabayar_filter', 'nonbpjs');
			}
			vm.executions();
		},
		tablereload: function (data = new FormData(), pos = 'main') {
			if (vm.posisieksternal == 'ro_bpjs') {
				if (pos == 'outer') { vm.$refs.DatatableRoBpjs.skeleton(); }
				vm.attach.url = vm.attach.link.list;
				data.append('carabayar_filter', 'bpjs');
				vm.attach.data = data;
			}
			else if (vm.posisieksternal == 'ro_nonbpjs') {
				if (pos == 'outer') { vm.$refs.DatatableRoNonBpjs.skeleton(); }
				vm.attach.url = vm.attach.link.list;
				data.append('carabayar_filter', 'nonbpjs');
				vm.attach.data = data;
			}
			else if (vm.posisieksternal == 'perawat_bpjs') {
				if (pos == 'outer') { vm.$refs.DatatablePerawatBpjs.skeleton(); }
				vm.attach.url = vm.attach.link.listperawat;
				data.append('carabayar_filter', 'bpjs');
				vm.attach.data = data;
			}
			else {
				if (pos == 'outer') { vm.$refs.DatatablePerawatNonBpjs.skeleton(); }
				vm.attach.url = vm.attach.link.listperawat;
				data.append('carabayar_filter', 'nonbpjs');
				vm.attach.data = data;
			}
			vm.position = 'externaltable';
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		loadRoBpjs: () => { vm.position = 'loadRoBpjs'; vm.firstloader(); vm.tableload('ro_bpjs'); },
		loadRoNonBpjs: () => { vm.position = 'loadRoNonBpjs'; vm.firstloader(); vm.tableload('ro_nonbpjs'); },
		loadPerawatBpjs: () => { vm.position = 'loadPerawatBpjs'; vm.firstloader(); vm.tableload('perawat_bpjs'); },
		loadPerawatNonBpjs: () => { vm.position = 'loadPerawatNonBpjs'; vm.firstloader(); vm.tableload('perawat_nonbpjs'); },
		getCurrentDatatableRef: function() {
			if (vm.posisieksternal == 'ro_nonbpjs') return vm.$refs.DatatableRoNonBpjs;
			if (vm.posisieksternal == 'perawat_bpjs') return vm.$refs.DatatablePerawatBpjs;
			if (vm.posisieksternal == 'perawat_nonbpjs') return vm.$refs.DatatablePerawatNonBpjs;
			return vm.$refs.DatatableRoBpjs;
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadRoBpjs') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadRoNonBpjs') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadPerawatBpjs') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadPerawatNonBpjs') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') {
				vm.getCurrentDatatableRef().skeleton();
				vm.getCurrentDatatableRef().backpage();
			}
			else if (vm.position == 'adddata') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			else if (vm.position == 'adddataperawat') { vm.loadingModal('formdetailperawat'); }
			else if (vm.position == 'detaildataperawat') { vm.loadingModal('formdetailperawat'); vm.$refs.FormPerawat.hide();  }
			else if (vm.position == 'historidata') { vm.loadingModal('formhistori'); vm.$refs.FormHistori.hide();  }
			else if (vm.position == 'call') {
				vm.getCurrentDatatableRef().skeleton();
			}
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }

			if (vm.position == 'loadRoBpjs') {
				vm.posisieksternal='ro_bpjs';
				vm.firstloader();
				vm.$refs.DatatableRoBpjs.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total);
				vm.$refs.DatatableRoBpjs.paging();
				active = 0;
			}
			else if (vm.position == 'loadRoNonBpjs') {
				vm.posisieksternal='ro_nonbpjs';
				vm.firstloader();
				vm.$refs.DatatableRoNonBpjs.update(vm.column, vm.setDatatableRoNonBpjs(response.data.data, response.data.total), response.data.total);
				vm.$refs.DatatableRoNonBpjs.paging();
				active = 0;
			}
			else if (vm.position == 'loadPerawatBpjs') {
				vm.posisieksternal='perawat_bpjs';
				vm.firstloader();
				vm.$refs.DatatablePerawatBpjs.update(vm.columnperawat, vm.setDatatablePerawat(response.data.data, response.data.total), response.data.total);
				vm.$refs.DatatablePerawatBpjs.paging();
				active = 0;
			}
			else if (vm.position == 'loadPerawatNonBpjs') {
				vm.posisieksternal='perawat_nonbpjs';
				vm.firstloader();
				vm.$refs.DatatablePerawatNonBpjs.update(vm.columnperawat, vm.setDatatablePerawatNonBpjs(response.data.data, response.data.total), response.data.total);
				vm.$refs.DatatablePerawatNonBpjs.paging();
				active = 0;
			}
			else if (vm.position == 'externaltable') {
				if (vm.posisieksternal=='ro_bpjs') {
					vm.$refs.DatatableRoBpjs.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total);
					vm.$refs.DatatableRoBpjs.skeleton();
					vm.$refs.DatatableRoBpjs.paging();
					active = 0;
				}
				else if (vm.posisieksternal=='ro_nonbpjs') {
					vm.$refs.DatatableRoNonBpjs.update('', vm.setDatatableRoNonBpjs(response.data.data, response.data.total), response.data.total);
					vm.$refs.DatatableRoNonBpjs.skeleton();
					vm.$refs.DatatableRoNonBpjs.paging();
					active = 0;
				}
				else if (vm.posisieksternal=='perawat_bpjs') {
					vm.$refs.DatatablePerawatBpjs.update('', vm.setDatatablePerawat(response.data.data, response.data.total), response.data.total);
					vm.$refs.DatatablePerawatBpjs.skeleton();
					vm.$refs.DatatablePerawatBpjs.paging();
					active = 0;
				}
				else {
					vm.$refs.DatatablePerawatNonBpjs.update('', vm.setDatatablePerawatNonBpjs(response.data.data, response.data.total), response.data.total);
					vm.$refs.DatatablePerawatNonBpjs.skeleton();
					vm.$refs.DatatablePerawatNonBpjs.paging();
					active = 0;
				}
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormDetail.setdataform(response);
				vm.position = "updatedata";
				active = 0;
			}
			else if (vm.position == 'detaildataperawat') {
				vm.$refs.FormPerawat.setdataform(response);
				vm.position = "updatedataperawat";
				active = 0;
			}
			else if (vm.position == 'historidata') {
				vm.$refs.FormHistori.setdataform(response);
				//vm.position = "updatedata";
				active = 0;
			}
			else if (vm.position == 'updatedataperawat') {
				vm.loadingModal('formdetailperawat');
				vm.$refs.FormPerawat.aturulang();
				vm.$refs.FormPerawat.hide();
				setTimeout(() => { vm.getCurrentDatatableRef().skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formdetail');
				vm.$refs.FormDetail.hide();
				setTimeout(() => { vm.getCurrentDatatableRef().skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'call') {
				setTimeout(() => { vm.tablereload(); }, 500, this);
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadRoBpjs') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadRoNonBpjs') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadPerawatBpjs') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadPerawatNonBpjs') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'adddataperawat') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Gagal memanggil antrian pasien.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'detaildataperawat') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				if (vm.position == 'adddataperawat') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Antrian pasien berhasil dipanggil.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedataperawat') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formdetail') { vm.loadingModal('formdetail'); }
			else if (posisi == 'formdetailperawat') { vm.loadingModal('formdetailperawat'); }
			else if (posisi == 'removedata') { vm.getCurrentDatatableRef().skeleton(); }
			else if (posisi == 'call') { vm.getCurrentDatatableRef().skeleton(); }
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
