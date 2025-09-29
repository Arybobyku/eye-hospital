<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.all">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.belum">
			<Datatable ref="DatatableBelum" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.tagihan">
			<div class="grid" style="margin-bottom: 20px;" v-if="button_tombol">
				<div class="col-12" style="text-align: right">
					<button class="button-modal-page button-modal-red" v-on:click="changesstatus()">Ubah Statu Menjadi Sudah Dibayar</button>
					<button class="button-modal-page button-modal-green" v-on:click="cetakfaktur()">Cetak Faktur Pembayaran</button>
				</div>
			</div>
			<Datatable ref="DatatableTagihan" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
		<div class="content-tab-in" v-else-if="tab.content.sudah">
			<Datatable ref="DatatableSudah" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<!-- <div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div> -->
	<Loader ref="Loader"></Loader>
</div>
<FormFaktur ref="FormFaktur" @dialog="dialog" @parsingForm="parsingForm"></FormFaktur>
<FormObat ref="FormObat" @dialog="dialog" @parsingForm="parsingForm"></FormObat>
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
		FormFaktur: defineAsyncComponent(() => import('./FormFaktur.vue')),
		FormObat: defineAsyncComponent(() => import('./FormObat.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () { return {
		button_tombol: false,
		uri: 'unit',
		position: '',
		attach: {
			link : {
				list: '/finance/pembelian/list',
				listtagihan: '/finance/pembelian/listtagihan',
				listsudah: '/finance/pembelian/listsudah',
				listbelum: '/finance/pembelian/listbelum',
				add: '/finance/pembelian/add',
				edit: '/finance/pembelian/edit',
				update: '/finance/pembelian/update',
				remove: '/finance/pembelian/remove',
				approve: '/finance/pembelian/approve',
				obat: '/finance/pembelian/obat',
				addobat: '/finance/pembelian/addobat',
				addobat: '/finance/pembelian/addobat',
				cetak: '/finance/pembelian/cetak',
				ubahstatus: '/finance/pembelian/ubahstatus',
			}, url: '', data: null
		},
		column: [
			{ value: 'tanggal_faktur', label: 'Tanggal Faktur', type: 'date', search: true, close: false, button: false },
			{ value: 'no_faktur', label: 'No. Faktur', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_supplier', label: 'Nama Supplier', type: 'text', search: true, close: false, button: false },
			{ value: 'ppn', label: 'PPN (%)', type: 'text', search: true, close: false, button: false },
			{ value: 'pembayaran', label: 'Pembayaran', type: 'number', search: true, close: false, button: false },
			{ value: 'jumlah', label: 'Jumlah Obat', type: 'text', search: false, close: false, button: false },
			{ value: 'tempo', label: 'Jatuh Tempo', type: 'text', search: false, close: false, button: false },
			{ value: 'status_pembayaran', label: 'Status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: '', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },

		tab: {
			button: [
				{ value: 'all', label: 'All Data', class: 'tab-active' },
				{ value: 'belum', label: 'Tagihan Belum Dibayar', class: 'tab-no-active' },
				{ value: 'tagihan', label: 'Tagihan Faktur (Aktif)', class: 'tab-no-active' },
				{ value: 'sudah', label: 'Tagihan Sudah Dibayar', class: 'tab-no-active' },
			],
			content: { 
				all: true, 
				belum: false,
				tagihan: false,
				sudah: false,
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
				
				if (values == 'tagihan') {
					vm.posisieksternal = 'tagihan';
					vm.loadtagihan();
				}
				else if (values == 'sudah') {
					vm.posisieksternal = 'sudah';
					vm.loadsudah();
				}
				else if (values == 'belum') {
					vm.posisieksternal = 'belum';
					vm.loadbelum();
				}
				else {
					vm.posisieksternal = 'all';
					vm.loadmain();
				}
			}
		},

		changesstatus:function() {
			vm.position = "ubahstatus";
			vm.attach.data = new FormData();
			vm.attach.data.append('-', '-');
			vm.attach.url = vm.attach.link.ubahstatus;
			vm.dialog('Yakin ingin merubah status faktur menjadi sudah dibayar.', 'Ya, ubah status', 'ubahstatus');
		},
		
		cetakfaktur:function() {
			window.open(vm.attach.link.cetak, '_self');
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			if (_item.status == 'approve') {
				//return { key: 'html', data: '<span class="badge badge-success" style="padding: 2px 10px">Disetujui</span>' }
			}
			return {
				key : 'button',
				width: _item.status == 'active' ? '195px' : '50px',
				data : [
					{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: _item.status == 'active' ? true : false, },
					{ icon: 'trash-2', color: 'btn-danger', posisi: 'remove', tooltip: 'Hapus Data', item: _item, index: _index, show: _item.status == 'active' ? true : false, },
					{ icon: 'eye', color: 'btn-warning', posisi: 'formobat', tooltip: 'Detail Faktur', item: _item, index: _index, show: _item.status == 'active' ? true : true, },
					{ icon: 'check-square', color: 'btn-success', posisi: 'approve', tooltip: 'Approve Faktur', item: _item, index: _index, show: _item.status == 'active' ? true : false, }
				]
			}
		},

		jumlah: function (item) { if (item == 'jumlah') { return '0'; } return item; },

		pembayaran:function(_item) {
			if (_item.pembayaran == 'Kredit') { return _item.pembayaran + ' ' + _item.jangka_waktu + ' Hari' }
			return _item.pembayaran;
		},

		tempo:function(data) {
			if (data.tempo == '1990-01-01') { return '-' }
			return vm.datename(data.tempo);
		},

		converter:function(data, index, column, identity) {
			let _tmp = '';
			let _btn_html = vm.btnhtml(data, index);
			if (identity == 'btnhtml') { _tmp = { value: _btn_html.data, ishtml: _btn_html.key, show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column), ishtml: 'text', style: '' }; }
			else if (identity == 'tanggal_faktur') { _tmp = { value: vm.datename(column), ishtml: 'text', style: '' }; }
			else if (identity == 'pembayaran') { _tmp = { value: vm.pembayaran(data), ishtml: 'text', style: '' }; }
			else if (identity == 'jumlah') { _tmp = { value: vm.jumlah(column), ishtml: 'text', style: '' }; }
			else if (identity == 'tempo') { _tmp = { value: vm.tempo(data), ishtml: 'text', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormFaktur.aturulang();
				vm.position = "adddata";
				vm.$refs.FormFaktur.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormFaktur.aturulang();
				vm.position = "editdata";
				vm.$refs.FormFaktur.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formfaktur'); }, 250, this);
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
				vm.dialog('Yakin ingin menghapus data ' + data.no_faktur, 'Ya, hapus data', 'removedata');
			}
			else if (posisi == 'approve') {
				if (data.jumlah > 0) {
					console.log(data)
					vm.position = "approvedata";
					vm.attach.data = new FormData();
					vm.attach.data.append('uuid', data.uuid);
					vm.attach.url = vm.attach.link.approve;
					vm.dialog('Yakin ingin menyetujui faktur dan menambahakn data obat yang ada difaktur ke dalam stock opname gudang.', 'Ya, approve faktur', 'approvedata');
				}
			}
			else if (posisi == 'formobat') {
				vm.position = "formobat";
				vm.$refs.FormObat.aturulang();
				vm.$refs.FormObat.show('formobat', '', '');
				setTimeout(() => { vm.loadingModal('formobat'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.obat;
				vm.executions();
			}
		},

		loadingModal: function (position) { 
			if (position == 'formfaktur') { vm.$refs.FormFaktur.loaderprocess();  }
			else if (position == 'formobat') { vm.$refs.FormObat.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'faktur') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; } 
			}
			else if (key == 'obat') {
				vm.attach.url = vm.attach.link.addobat;
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
			else if (pos == 'tagihan') {
				vm.attach.url = vm.attach.link.listtagihan; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'belum') {
				vm.attach.url = vm.attach.link.listbelum; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			else if (pos == 'sudah') {
				vm.attach.url = vm.attach.link.listsudah; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1); 
			}
			vm.executions(); 
		},

		tablereload:function(data = new FormData(), pos = 'main') { 
			if (vm.posisieksternal == 'tagihan') {
				if (pos == 'outer') {
					vm.$refs.DatatableTagihan.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listtagihan; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'belum') {
				if (pos == 'outer') {
					vm.$refs.DatatableBelum.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listbelum; 
				vm.attach.data = data; 
			}
			else if (vm.posisieksternal == 'sudah') {
				if (pos == 'outer') {
					vm.$refs.DatatableSudah.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listsudah; 
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
		loadtagihan:function() { vm.position = 'loadtagihan'; vm.firstloader();  vm.tableload('tagihan'); },
		loadbelum:function() { vm.position = 'loadbelum'; vm.firstloader();  vm.tableload('belum'); },
		loadsudah:function() { vm.position = 'loadsudah'; vm.firstloader();  vm.tableload('sudah'); },

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadtagihan') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadbelum') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loadsudah') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal='tagihan') {
					vm.button_tombol = false;
					vm.$refs.DatatableTagihan.skeleton(); vm.$refs.DatatableTagihan.backpage(); 
				}
				else if (vm.posisieksternal='belum') {
					vm.button_tombol = false;
					vm.$refs.DatatableBelum.skeleton(); vm.$refs.DatatableBelum.backpage(); 
				}
				else if (vm.posisieksternal='sudah') {
					vm.button_tombol = false;
					vm.$refs.DatatableSudah.skeleton(); vm.$refs.DatatableSudah.backpage(); 
				}
				else {
					vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); 
				}
			}
			else if (vm.position == 'adddata') { vm.loadingModal('formfaktur'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formfaktur'); vm.$refs.FormFaktur.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formfaktur'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'approvedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'ubahstatus') { vm.$refs.DatatableTagihan.skeleton(); }
			else if (vm.position == 'formobat') { vm.loadingModal('formobat'); vm.$refs.FormObat.hide();  }
			else if (vm.position == 'updatedataobat') { vm.loadingModal('formobat'); }

			
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
			else if (vm.position == 'loadtagihan') { 
				vm.posisieksternal='tagihan';
				vm.firstloader();
				vm.$refs.DatatableTagihan.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableTagihan.paging(); 
				active = 0;
				if (response.data.total > 0) {
					vm.button_tombol = true;
				}
				else {
					vm.button_tombol = false;
				}
			}
			else if (vm.position == 'loadbelum') { 
				vm.posisieksternal='belum';
				vm.firstloader();
				vm.$refs.DatatableBelum.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableBelum.paging(); 
				active = 0;
			}
			else if (vm.position == 'loadsudah') { 
				vm.posisieksternal='sudah';
				vm.firstloader();
				vm.$refs.DatatableSudah.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableSudah.paging(); 
				active = 0;
			}
			else if (vm.position == 'externaltable') { 
				if (vm.posisieksternal=='tagihan') {
					vm.$refs.DatatableTagihan.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableTagihan.skeleton(); 
					vm.$refs.DatatableTagihan.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='belum') {
					vm.$refs.DatatableBelum.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableBelum.skeleton(); 
					vm.$refs.DatatableBelum.paging(); 
					active = 0;
				}
				else if (vm.posisieksternal=='sudah') {
					vm.$refs.DatatableSudah.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableSudah.skeleton(); 
					vm.$refs.DatatableSudah.paging(); 
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
				vm.loadingModal('formfaktur');
				vm.$refs.FormFaktur.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormFaktur.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formfaktur');
				vm.$refs.FormFaktur.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'removedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'approvedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'ubahstatus') { 
				setTimeout(() => { vm.posisieksternal == 'tagihan'; vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'formobat') {
				vm.$refs.FormObat.setdataform(response); 
				vm.position = "updatedataobat"; 
				active = 0; 
			}
			else if (vm.position == 'updatedataobat') {
				vm.loadingModal('formobat');
				vm.$refs.FormObat.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadtagihan') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadbelum') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loadsudah') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'approvedata') { vm.notification('Approval data gagal diproses.', 3000, position); }
				else if (vm.position == 'ubahstatus') { vm.notification('Perubahan status data gagal diproses.', 3000, position); }
				else if (vm.position == 'formobat') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedataobat') { vm.notification('Penambahan/Pembaharuan data obat gagal diproses.', 3000, position); }

			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'approvedata') { vm.notification('Approval data berhasil diproses.', 3000, position); }
				else if (vm.position == 'ubahstatus') { vm.notification('Perubahan status data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedataobat') { vm.notification('Penambahan/Pembaharuan data obat berhasil diproses.', 3000, position); }

			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formfaktur') { vm.loadingModal('formfaktur'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'approvedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'ubahstatus') { vm.$refs.DatatableTagihan.skeleton(); }
			else if (posisi == 'formobat') { vm.loadingModal('formobat'); }
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
