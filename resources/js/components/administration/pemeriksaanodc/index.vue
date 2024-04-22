<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.today">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormDetail ref="FormDetail" @dialog="dialog" @parsingForm="parsingForm"></FormDetail>
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
		FormDetail: defineAsyncComponent(() => import('./FormDetail.vue')),
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
				list: '/administration/pemeriksaanodc/list',
				add: '/administration/pemeriksaanodc/add',
				detail: '/administration/pemeriksaanodc/detail',
			}, url: '', data: null
		},
		column: [
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			// { value: 'status_dokter', label: 'status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: true }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
		tab: {
			button: [
				{ value: 'today', label: 'Pasien One Day Care Bedah', class: 'tab-active' },
			],
			content: { 
				today: true, 
			}
		},
		posisieksternal: 'today'
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

				vm.posisieksternal = 'today';
				vm.loadmain();
			}
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'book', color: 'btn-warning', posisi: 'histori', tooltip: 'Histori RO', item: _item, index: _index, show: true },
				{ icon: 'book', color: 'btn-success', posisi: 'historidokter', tooltip: 'Histori Dokter', item: _item, index: _index, show: true },
				{ icon: 'clock', color: 'btn-warning', posisi: 'jadwalkontrol', tooltip: 'Buat Jadwal Kontrol', item: _item, index: _index, show: true },
				// { icon: 'clock', color: 'btn-warning', posisi: 'transfer', tooltip: 'Alihkan/Transfer Pasien', item: _item, index: _index, show: true },
			]
			return str;
		},

		nopendaftaran:function(data) {
			if (data.status_antrian_dokter == 'active') {
				return data.no_pendaftaran + '<div class="badge badge-success">'+ data.status_antrian_dokter +'</div>';
			}
			else {
				return data.no_pendaftaran;
			}
		},

		statusdokter:function(data) {
			if (data.status_dokter == 'Belum Diperiksa') {
				return '<div class="badge badge-danger">'+data.status_dokter+'</div>';
			}
			return '<div class="badge badge-success">'+data.status_dokter+'</div>'
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'status_dokter') { _tmp = { value: vm.statusdokter(data), ishtml: 'html', style: '' }; }
			else if (identity == 'no_pendaftaran') { _tmp = { value: vm.nopendaftaran(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormDetail.aturulang();
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Data', data.uuid);
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
		},

		loadingModal: function (position) { 
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
			else if (position == 'formdetailtransfer') { vm.$refs.FormDetailTransfer.loaderprocess();  }
			else if (position == 'formcetakan') { vm.$refs.FormCetakan.loaderprocess();  }
			else if (position == 'formhistori') { vm.$refs.FormHistori.loaderprocess();  }
			else if (position == 'formhistoridokter') { vm.$refs.FormHistoriDokter.loaderprocess();  }
			else if (position == 'formjadwalkontrol') { vm.$refs.FormJadwalKontrol.loaderprocess();  }
			else if (position == 'formtransfer') { vm.$refs.FormTransfer.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'add') { vm.position = 'updatedata'; vm.attach.url = vm.attach.link.add; }
			else if (key == 'suratistirahat') { vm.position = 'suratistirahat'; vm.attach.url = vm.attach.link.suratistirahat; }
			else if (key == 'suratkonsul') { vm.position = 'suratkonsul'; vm.attach.url = vm.attach.link.suratkonsul; }
			else if (key == 'suratbalasankonsul') { vm.position = 'suratbalasankonsul'; vm.attach.url = vm.attach.link.suratbalasankonsul; }
			else if (key == 'resepkacamata') { vm.position = 'resepkacamata'; vm.attach.url = vm.attach.link.resepkacamata; }
			else if (key == 'addjadwalkontrol') {
				vm.position = 'addjadwalkontrol';
				vm.attach.url = vm.attach.link.addjadwalkontrol;
			}
			else if (key == 'addtransfer') {
				vm.position = 'addtransfer';
				vm.attach.url = vm.attach.link.addtransfer;
			}
			else if (key == 'removetransfer') {
				vm.position = 'removetransfer';
				vm.attach.url = vm.attach.link.removetransfer;
			}
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },
		setDatatablepending: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columnpending.length; j++) { col.push(vm.converterpending(data[i], i, data[i][vm.columnpending[j].value] ? data[i][vm.columnpending[j].value] :vm.columnpending[j].value, vm.columnpending[j].value)); } temporer.push(col); } vm.modulepending.data = temporer; vm.modulepending.total = total; return temporer; },
		setDatatabletriase: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columntriase.length; j++) { col.push(vm.convertertriase(data[i], i, data[i][vm.columntriase[j].value] ? data[i][vm.columntriase[j].value] :vm.columntriase[j].value, vm.columntriase[j].value)); } temporer.push(col); } vm.moduletriase.data = temporer; vm.moduletriase.total = total; return temporer; },
		setDatatabletransfer: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columntransfer.length; j++) { col.push(vm.convertertransfer(data[i], i, data[i][vm.columntransfer[j].value] ? data[i][vm.columntransfer[j].value] :vm.columntransfer[j].value, vm.columntransfer[j].value)); } temporer.push(col); } vm.moduletransfer.data = temporer; vm.moduletransfer.total = total; return temporer; },
		tableload:function(pos = 'main') { 
			if (pos == 'main') {
				vm.attach.url = vm.attach.link.list; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'triase') {
				vm.attach.url = vm.attach.link.listtriase; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			}
			else if (pos == 'transfer') {
				vm.attach.url = vm.attach.link.listtransfer; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			}
			else {
				vm.attach.url = vm.attach.link.listpending; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			
			vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (vm.posisieksternal == 'pending') {
				if (pos == 'outer') {
					vm.$refs.DatatablePending.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listpending; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'triase') {
				if (pos == 'outer') {
					vm.$refs.DatatableTriase.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listtriase; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'transfer') {
				if (pos == 'outer') {
					vm.$refs.DatatableTransfer.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listtransfer; 
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

		loadpending:function() {
			vm.position = 'loadpending'; 
			vm.firstloader(); 
			vm.tableload('pending');
		},

		loadtriase:function() {
			vm.position = 'loadtriase'; 
			vm.firstloader(); 
			vm.tableload('triase');
		},

		loadtransfer:function() {
			vm.position = 'loadtransfer'; 
			vm.firstloader(); 
			vm.tableload('transfer');
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadpending') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadtriase') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadtransfer') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal='pending') {
					vm.$refs.DatatablePending.skeleton(); 
					vm.$refs.DatatablePending.backpage(); 
				}
				else if (vm.posisieksternal='triase') {
					vm.$refs.DatatableTriase.skeleton(); 
					vm.$refs.DatatableTriase.backpage(); 
				}
				else {
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.backpage(); 
				} 
			}
			else if (vm.position == 'addjadwalkontrol') { vm.loadingModal('formjadwalkontrol'); }
			else if (vm.position == 'addtransfer') { vm.loadingModal('formtransfer'); }
			else if (vm.position == 'removetransfer') { vm.loadingModal('formtransfer'); }
			else if (vm.position == 'loaddatajadwalkontrol') { vm.loadingModal('formjadwalkontrol'); vm.$refs.FormJadwalKontrol.hide(); }
			else if (vm.position == 'loaddatatransfer') { vm.loadingModal('formtransfer'); vm.$refs.FormTransfer.hide(); }
			else if (vm.position == 'call') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'updatedata') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'updatedatatransfer') { vm.loadingModal('formdetailtransfer'); }
			else if (vm.position == 'suratistirahat') { vm.loadingModal('formcetakan'); }
			else if (vm.position == 'suratkonsul') { vm.loadingModal('formcetakan'); }
			else if (vm.position == 'suratbalasankonsul') { vm.loadingModal('formcetakan'); }
			else if (vm.position == 'resepkacamata') { vm.loadingModal('formcetakan'); }
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			else if (vm.position == 'detaildatatransfer') { vm.loadingModal('formdetailtransfer'); vm.$refs.FormDetailTransfer.hide();  }
			else if (vm.position == 'cetakandata') { vm.loadingModal('formcetakan'); vm.$refs.FormCetakan.hide();  }
			else if (vm.position == 'historidata') { vm.loadingModal('formhistori'); vm.$refs.FormHistori.hide();  }
			else if (vm.position == 'historidokter') { vm.loadingModal('formhistoridokter'); vm.$refs.FormHistoriDokter.hide();  }
			
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
			else if (vm.position == 'loadpending') { 
				vm.posisieksternal='pending';
				vm.firstloader();
				vm.$refs.DatatablePending.update(vm.columnpending, vm.setDatatablepending(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatablePending.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadtriase') { 
				vm.posisieksternal='triase';
				vm.firstloader();
				vm.$refs.DatatableTriase.update(vm.columntriase, vm.setDatatabletriase(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableTriase.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadtransfer') { 
				vm.posisieksternal='transfer';
				vm.firstloader();
				vm.$refs.DatatableTransfer.update(vm.columntransfer, vm.setDatatabletransfer(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableTransfer.paging(); 
				active = 0;
			}
			else if (vm.position == 'externaltable') { 

				if (vm.posisieksternal=='pending') {
					vm.$refs.DatatablePending.update('', vm.setDatatablepending(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatablePending.skeleton(); 
					vm.$refs.DatatablePending.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='triase') {
					vm.$refs.DatatableTriase.update('', vm.setDatatabletriase(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableTriase.skeleton(); 
					vm.$refs.DatatableTriase.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='transfer') {
					vm.$refs.DatatableTransfer.update('', vm.setDatatabletransfer(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableTransfer.skeleton(); 
					vm.$refs.DatatableTransfer.paging(); 
					active = 0;
				}
				else {
					vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.paging(); 
					active = 0;
				}

				
			}
			else if (vm.position == 'addjadwalkontrol') {
				vm.$refs.FormJadwalKontrol.hide();
				vm.loadingModal('formjadwalkontrol');
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'loaddatajadwalkontrol') {
				vm.$refs.FormJadwalKontrol.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'loaddatatransfer') {
				vm.$refs.FormTransfer.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'addtransfer') {
				vm.$refs.FormTransfer.setdataform(response);
			}
			else if (vm.position == 'removetransfer') {
				vm.$refs.FormTransfer.setdataform(response);
			}
			else if (vm.position == 'call') { 
				vm.tablereload();
				active = 0;
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormDetail.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'detaildatatransfer') {
				vm.$refs.FormDetailTransfer.setdataform(response); 
				vm.position = "updatedatatransfer"; 
				active = 0; 
			}
			else if (vm.position == 'cetakandata') {
				vm.$refs.FormCetakan.setdataform(response); 
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
			else if (vm.position == 'updatedatatransfer') {
				vm.loadingModal('formdetailtransfer');
				vm.$refs.FormDetailTransfer.hide(); 
				setTimeout(() => { vm.$refs.DatatableTransfer.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'suratistirahat') {
				vm.$refs.FormCetakan.setopentab(response, 'suratistirahat'); 
			}
			else if (vm.position == 'suratkonsul') {
				vm.$refs.FormCetakan.setopentab(response, 'suratkonsul'); 
			}
			else if (vm.position == 'suratbalasankonsul') {
				vm.$refs.FormCetakan.setopentab(response, 'suratbalasankonsul'); 
			}
			else if (vm.position == 'resepkacamata') {
				vm.$refs.FormCetakan.setopentab(response, 'resepkacamata'); 
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadpending') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadtriase') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadtransfer') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'addjadwalkontrol') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'addtransfer') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removetransfer') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Gagal memanggil antrian pasien.', 3000, position); }
				else if (vm.position == 'loaddatajadwalkontrol') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddatatransfer') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Penambahan/Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'suratistirahat') { vm.notification('Cetakan data gagal diproses.', 3000, position); }
				else if (vm.position == 'suratkonsul') { vm.notification('Cetakan data gagal diproses.', 3000, position); }
				else if (vm.position == 'suratbalasankonsul') { vm.notification('Cetakan data gagal diproses.', 3000, position); }
				else if (vm.position == 'resepkacamata') { vm.notification('Cetakan data gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'cetakandata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidokter') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'updatedata') { vm.notification('Penambahan/Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'addjadwalkontrol') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'addtransfer') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removetransfer') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Antrian pasien berhasil dipanggil.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formdetail') { vm.loadingModal('formdetail'); }
			else if (posisi == 'formdetailtransfer') { vm.loadingModal('formdetailtransfer'); }
			else if (posisi == 'formcetakan') { vm.loadingModal('formcetakan'); }
			else if (posisi == 'formkontrol') { vm.loadingModal('formjadwalkontrol'); }
			else if (posisi == 'formtransfer') { vm.loadingModal('formtransfer'); }
			else if (posisi == 'removetransfer') { vm.loadingModal('formtransfer'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'call') { vm.$refs.Datatable.skeleton(); }
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
