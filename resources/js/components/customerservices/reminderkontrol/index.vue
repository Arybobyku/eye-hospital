<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.all">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.seven">
			<Datatable ref="DatatableSeven" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.six">
			<Datatable ref="DatatableSix" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.five">
			<Datatable ref="DatatableFive" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.four">
			<Datatable ref="DatatableFour" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.three">
			<Datatable ref="DatatableThree" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.two">
			<Datatable ref="DatatableTwo" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.one">
			<Datatable ref="DatatableOne" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
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
				list: '/customerservices/reminderkontrol/list',
				seven: '/customerservices/reminderkontrol/seven',
				six: '/customerservices/reminderkontrol/six',
				five: '/customerservices/reminderkontrol/five',
				four: '/customerservices/reminderkontrol/four',
				three: '/customerservices/reminderkontrol/three',
				two: '/customerservices/reminderkontrol/two',
				one: '/customerservices/reminderkontrol/one',
				add: '/customerservices/reminderkontrol/add',
				detail: '/customerservices/reminderkontrol/detail',
			}, url: '', data: null
		},
		column: [
			{ value: 'jadwal_kontrol', label: 'Jadwal Kontrol', type: 'text', search: true, close: false, button: false },
			{ value: 'no_handphone', label: 'No Handphone', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'No Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },

		tab: {
			button: [
				{ value: 'all', label: 'All Data', class: 'tab-active' },
				{ value: 'seven', label: '+7 hari ke depan', class: 'tab-no-active' },
				{ value: 'six', label: '+6 hari ke depan', class: 'tab-no-active' },
				{ value: 'five', label: '+5 hari ke depan', class: 'tab-no-active' },
				{ value: 'four', label: '+4 hari ke depan', class: 'tab-no-active' },
				{ value: 'three', label: '+3 hari ke depan', class: 'tab-no-active' },
				{ value: 'two', label: '+2 hari ke depan', class: 'tab-no-active' },
				{ value: 'one', label: '+1 hari ke depan', class: 'tab-no-active' },
			],
			content: { 
				all: true, 
				seven: false, 
				six: false,
				five: false,
				four: false,
				three: false,
				two: false,
				one: false,
			}
		},
		posisieksternal: 'all'
	}},
	methods: {

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

				vm.module.data = [];
				
				if (values == 'seven') {
					vm.posisieksternal = 'seven';
					vm.loadseven();
				}
				else if (values == 'six') {
					vm.posisieksternal = 'six';
					vm.loadsix();
				}
				else if (values == 'five') {
					vm.posisieksternal = 'five';
					vm.loadfive();
				}
				else if (values == 'four') {
					vm.posisieksternal = 'four';
					vm.loadfour();
				}
				else if (values == 'three') {
					vm.posisieksternal = 'three';
					vm.loadthree();
				}
				else if (values == 'two') {
					vm.posisieksternal = 'two';
					vm.loadtwo();
				}
				else if (values == 'one') {
					vm.posisieksternal = 'one';
					vm.loadone();
				}
				else {
					vm.posisieksternal = 'all';
					vm.loadmain();
				}
			}
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
			]
			return str;
		},

		jadwalkontrol:function(data) {
			return vm.datename(data.tanggal) + (data.waktu != '-' && data.waktu != '0' ? (' ' + data.waktu) : '');
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'jadwal_kontrol') { _tmp = { value: vm.jadwalkontrol(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "adddata";
				vm.$refs.FormUnit.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'detail') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "detaildata";
				vm.$refs.FormUnit.show('detaildata', 'Detail Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formunit'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'remove') {
				vm.position = "removedata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.remove;
				vm.dialog('Yakin ingin menghapus data yang terpilih dihalaman ini.', 'Ya, hapus data', 'removedata');
			}
		},

		loadingModal: function (position) { 
			if (position == 'formunit') { vm.$refs.FormUnit.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'unit') {
				vm.position = 'adddata';
				vm.attach.url = vm.attach.link.add; 
			}
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },
		
		tableload:function(pos = 'main') { 
			if (pos == 'main') {
				vm.attach.url = vm.attach.link.list; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			}
			else if (pos == 'seven') {
				vm.attach.url = vm.attach.link.seven; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'six') {
				vm.attach.url = vm.attach.link.six; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'five') {
				vm.attach.url = vm.attach.link.five; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'four') {
				vm.attach.url = vm.attach.link.four; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'three') {
				vm.attach.url = vm.attach.link.three; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'two') {
				vm.attach.url = vm.attach.link.two; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'one') {
				vm.attach.url = vm.attach.link.one; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			
			vm.executions(); 
		},
		
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (vm.posisieksternal == 'seven') {
				if (pos == 'outer') {
					vm.$refs.DatatableSeven.skeleton(); 
				}
				vm.attach.url = vm.attach.link.seven; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'six') {
				if (pos == 'outer') {
					vm.$refs.DatatableSix.skeleton(); 
				}
				vm.attach.url = vm.attach.link.six; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'five') {
				if (pos == 'outer') {
					vm.$refs.DatatableFive.skeleton(); 
				}
				vm.attach.url = vm.attach.link.five; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'four') {
				if (pos == 'outer') {
					vm.$refs.DatatableFour.skeleton(); 
				}
				vm.attach.url = vm.attach.link.four; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'three') {
				if (pos == 'outer') {
					vm.$refs.DatatableThree.skeleton(); 
				}
				vm.attach.url = vm.attach.link.three; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'two') {
				if (pos == 'outer') {
					vm.$refs.DatatableTwo.skeleton(); 
				}
				vm.attach.url = vm.attach.link.two; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'one') {
				if (pos == 'outer') {
					vm.$refs.DatatableOne.skeleton(); 
				}
				vm.attach.url = vm.attach.link.one; 
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

		loadmain: () => { vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); },
		loadseven:function() { vm.position = 'loadseven'; vm.firstloader();  vm.tableload('seven'); },
		loadsix:function() { vm.position = 'loadsix'; vm.firstloader();  vm.tableload('six'); },
		loadfive:function() { vm.position = 'loadfive'; vm.firstloader();  vm.tableload('five'); },
		loadfour:function() { vm.position = 'loadfour'; vm.firstloader();  vm.tableload('four'); },
		loadthree:function() { vm.position = 'loadthree'; vm.firstloader();  vm.tableload('three'); },
		loadtwo:function() { vm.position = 'loadtwo'; vm.firstloader();  vm.tableload('two'); },
		loadone:function() { vm.position = 'loadone'; vm.firstloader();  vm.tableload('one'); },

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadseven') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadsix') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadfive') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadfour') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadthree') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadtwo') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadone') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal='seven') {
					vm.$refs.DatatableSeven.skeleton(); vm.$refs.DatatableSeven.backpage(); 
				}
				else if (vm.posisieksternal='six') {
					vm.$refs.DatatableSix.skeleton(); vm.$refs.DatatableSix.backpage(); 
				}
				else if (vm.posisieksternal='five') {
					vm.$refs.DatatableFive.skeleton(); vm.$refs.DatatableFive.backpage(); 
				}
				else if (vm.posisieksternal='four') {
					vm.$refs.DatatableFour.skeleton(); vm.$refs.DatatableFour.backpage(); 
				}
				else if (vm.posisieksternal='three') {
					vm.$refs.DatatableThree.skeleton(); vm.$refs.DatatableThree.backpage(); 
				}
				else if (vm.posisieksternal='two') {
					vm.$refs.DatatableTwo.skeleton(); vm.$refs.DatatableTwo.backpage(); 
				}
				else if (vm.posisieksternal='one') {
					vm.$refs.DatatableOne.skeleton(); vm.$refs.DatatableOne.backpage(); 
				}
				else {
					vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); 
				}
			}
			else if (vm.position == 'adddata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'detaildata') { vm.loadingModal('formunit'); vm.$refs.FormUnit.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'loadmain') { 
				vm.posisieksternal='all';
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadseven') { 
				vm.posisieksternal='seven';
				vm.firstloader();
				vm.$refs.DatatableSeven.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableSeven.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadsix') { 
				vm.posisieksternal='six';
				vm.firstloader();
				vm.$refs.DatatableSix.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableSix.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadfive') { 
				vm.posisieksternal='five';
				vm.firstloader();
				vm.$refs.DatatableFive.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableFive.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadfour') { 
				vm.posisieksternal='four';
				vm.firstloader();
				vm.$refs.DatatableFour.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableFour.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadthree') { 
				vm.posisieksternal='three';
				vm.firstloader();
				vm.$refs.DatatableThree.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableThree.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadtwo') { 
				vm.posisieksternal='two';
				vm.firstloader();
				vm.$refs.DatatableTwo.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableTwo.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadone') { 
				vm.posisieksternal='one';
				vm.firstloader();
				vm.$refs.DatatableOne.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableOne.paging(); 
				active = 0;
			}
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal=='seven') {
					vm.$refs.DatatableSeven.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableSeven.skeleton(); 
					vm.$refs.DatatableSeven.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='six') {
					vm.$refs.DatatableSix.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableSix.skeleton(); 
					vm.$refs.DatatableSix.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='five') {
					vm.$refs.DatatableFive.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableFive.skeleton(); 
					vm.$refs.DatatableFive.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='four') {
					vm.$refs.DatatableFour.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableFour.skeleton(); 
					vm.$refs.DatatableFour.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='three') {
					vm.$refs.DatatableThree.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableThree.skeleton(); 
					vm.$refs.DatatableThree.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='two') {
					vm.$refs.DatatableTwo.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableTwo.skeleton(); 
					vm.$refs.DatatableTwo.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='one') {
					vm.$refs.DatatableOne.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableOne.skeleton(); 
					vm.$refs.DatatableOne.paging(); 
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
				vm.$refs.FormUnit.setdataform(response);
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormUnit.setdataform(response);
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
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadseven') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadsix') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadfive') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadfour') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadthree') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadtwo') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadone') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
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
			if (posisi == 'formunit') { vm.loadingModal('formunit'); }
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
