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
<FormObat ref="FormObat" @dialog="dialog" @parsingForm="parsingForm"></FormObat>
<FormPembeli ref="FormPembeli" @dialog="dialog" @parsingForm="parsingForm"></FormPembeli>
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
		FormPembeli: defineAsyncComponent(() => import('./FormPembeli.vue')),
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
				list: '/apotek/historifarmasirawatinap/list',
				listbayar: '/apotek/farmasi/listbayar',
				editobat: '/apotek/farmasi/editobat',
				call: '/apotek/farmasi/call',
				approvement: '/apotek/farmasi/approvement',
				detail: '/apotek/farmasi/detail',
				bayar: '/apotek/farmasi/bayar',
				terima: '/apotek/farmasi/terima',
				kasir: '/print/farmasi/',
				rekammedis: '/print/rekammedis/',

			}, url: '', data: null
		},
		column: [
			{ value: 'tanggal', label: 'Tanggal', type: 'date', search: true, close: false, button: false },
			{ value: 'no_kwitansi', label: 'No Kwitansi', type: 'text', search: true, close: false, button: false },
			{ value: 'carabayar_nama', label: 'Metode Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'status_kasir', label: 'status', type: 'text', search: false, close: false, button: false },
			{ value: 'approvement_obat', label: 'Approvement', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
		tab: {
			button: [
				{ value: 'today', label: 'Data Histori', class: 'tab-active' },
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
		nullAndZero, datename, formatrupiah,

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
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, 
				show: true },
				{ icon: 'check-square', color: 'btn-warning', posisi: 'approvement', tooltip: 'Approve Obat', item: _item, index: _index, 
				show: _item.approvement_obat == 'no' ? true : false },
			]
			return str;
		},


		btnhtmlbeli:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detailbeli', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				// { icon: 'bell', color: 'btn-info', posisi: 'panggilbeli', tooltip: 'Panggil Antrian', item: _item, index: _index, show: true },
				{ icon: 'check-circle', color: 'btn-warning', posisi: 'selesaibeli', tooltip: 'Selesai', item: _item, index: _index, show: true }
			]
			return str;
		},

		nopendaftaran:function(data) {
			if (data.status_antrian_farmasi == 'active') {
				return data.no_pendaftaran + '<div class="badge badge-success">'+ data.status_antrian_farmasi +'</div>';
			}
			else {
				return data.no_pendaftaran;
			}
		},

		approvementobat:function(data) {
			if (data.approvement_obat == 'no') { return 'Belum diapprove'; }
			return 'Sudah diapprove';
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'no_pendaftaran') { _tmp = { value: vm.nopendaftaran(data), ishtml: 'html', style: '' }; }
			else if (identity == 'approvement_obat') { _tmp = { value: vm.approvementobat(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		approvepanjar:function(data) {
			if (data.approve_panjar == 0) { return 'Belum Diterima'; }
			return 'Sudah Diterima';
		},

		nopendaftaranbeli:function(data) {
			if (data.active_call == 'active') {
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

		jenisf:function(data) {
			//if (data.jenis == 'Non Racikan') { return "Non Racikan"; }
			return data.jenis;
		},

		statustindakan:function(data) {
			if (data.jenis == '-') {
				if (data.ada_tindakan == 'Tidak') { return 'Tindakan Belum Ditambahkan'; }
				return 'Tindakan Sudah Ditambahkan';
			}
			return '-';
		},

		noinvoice:function(data) {
			return 'PB'+data.no_invoice;
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
				//if (data.ruang_poliklinik != 0) {
					vm.dialog('Yakin ingin memanggil nomor antrian pasien ini.', 'Ya, panggil', 'call');
				//}
			}
			else if (posisi == 'approvement') {
				vm.position = 'approvement';
				vm.attach.url = vm.attach.link.approvement;
				console.log(data)
				vm.attach.data = new FormData();
				let number = data.no_pendaftaran.split("-");
				number = parseInt(number[1]);
				vm.attach.data.append('uuid', data.uuid);
				//if (data.ruang_poliklinik != 0) {
					vm.dialog('Yakin ingin melakukan approvement pada resep ini.', 'Ya, approve', 'approvement');
				//}
			}
			else if (posisi == 'terima') {
				vm.position = "terimadata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.terima;
				vm.dialog('Yakin ingin menerima panjar pasien.', 'Ya, proses panjar', 'terimadata');
			}
			else if (posisi == 'add') {
				vm.$refs.FormPembeli.aturulang();
				vm.position = "adddata";
				vm.$refs.FormPembeli.show('adddata', 'Tambah Data', '');
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
				vm.position = 'selesaibeli';
				vm.attach.url = vm.attach.link.selesaibeli;
				console.log(data)
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.dialog('Yakin ingin menyelesaikan proses pembelian obat pada pasien ini.', 'Ya, selesai', 'selesaibeli');
			}
			else if (posisi == 'detailbeli') {
				vm.$refs.FormObat.aturulang();
				vm.position = "detaildatabeli";
				vm.$refs.FormObat.show('detaildatabeli', 'Detail Data', data.uuid, data.pembayaran, data);
				setTimeout(() => { vm.loadingModal('formobat'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detailbeli;
				vm.executions();
			}
		},

		loadingModal: function (position) { 
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
			else if (position == 'formpembeli') { vm.$refs.FormPembeli.loaderprocess();  }
			else if (position == 'formhistori') { vm.$refs.FormHistori.loaderprocess();  }
			else if (position == 'formhistoridokter') { vm.$refs.FormHistoriDokter.loaderprocess();  }
			else if (position == 'formobat') { vm.$refs.FormObat.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'pembeli') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.addpembeli; } 
			}
			else if (key == 'add') { vm.position = 'updatedata'; vm.attach.url = vm.attach.link.bayar; }
			else if (key == 'formobat') {
				if (vm.position == 'updatedatabeli') {  vm.attach.url = vm.attach.link.addbeli; } 
			}
			else if (key == 'editobat') { vm.position = 'editobat'; vm.attach.url = vm.attach.link.editobat; }
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

		loadmain: () => { vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); },

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				vm.$refs.Datatable.skeleton(); 
				vm.$refs.Datatable.backpage();  
			}
			else if (vm.position == 'call') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'adddata') { vm.loadingModal('formpembeli'); }
			else if (vm.position == 'approvement') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'updatedata') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'editobat') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'updatedatabeli') { vm.loadingModal('formobat'); }
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			else if (vm.position == 'detaildatabeli') { vm.loadingModal('formobat'); vm.$refs.FormObat.hide();  }
			else if (vm.position == 'historidata') { vm.loadingModal('formhistori'); vm.$refs.FormHistori.hide();  }
			else if (vm.position == 'historidokter') { vm.loadingModal('formhistoridokter'); vm.$refs.FormHistoriDokter.hide();  }
			else if (vm.position == 'terimadata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'callbeli') { vm.$refs.DatatableBeli.skeleton(); }
			else if (vm.position == 'selesaibeli') { vm.$refs.DatatableBeli.skeleton(); }
			
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
			else if (vm.position == 'adddata') {
				vm.loadingModal('formpembeli');
				vm.$refs.FormPembeli.hide(); 
				setTimeout(() => { vm.$refs.DatatableBeli.skeleton(); vm.tablereload(); }, 500, this);
				active = 1;
			}
			else if (vm.position == 'externaltable') { 
				vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.skeleton(); 
				vm.$refs.Datatable.paging(); 
				active = 0;
			}
			else if (vm.position == 'call') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
				active = 1;
			}
			else if (vm.position == 'approvement') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
				active = 1;
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormDetail.setdataform(response); 
				vm.position = "updatedata"; 
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
			else if (vm.position == 'editobat') {
				vm.loadingModal('formdetail');
				vm.$refs.FormDetail.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'terimadata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'callbeli') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'selesaibeli') { 
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
				else if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Gagal memanggil antrian pasien.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'editobat') { vm.notification('Data resep obat gagal diperbaharui.', 3000, position); }
				else if (vm.position == 'approvement') { vm.notification('Gagal melakukan approvement obat pada data resep pasien.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Data tagihan pasien gagal diproses.', 3000, position); }
				else if (vm.position == 'updatedatabeli') { vm.notification('Data tagihan pasien gagal diproses.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'detaildatabeli') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidokter') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'terimadata') { vm.notification('Uang panjar gagal diproses.', 3000, position); }
				else if (vm.position == 'callbeli') { vm.notification('Pemanggilan antrian gagal diproses.', 3000, position); }
				else if (vm.position == 'selesaibeli') { vm.notification('Proses untuk penyelesaian pasien yang membeli obat gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'updatedata') { vm.notification('Data tagihan pasien berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedatabeli') { vm.notification('Data tagihan pasien berhasil diproses.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'editobat') { vm.notification('Data resep obat berhasil diperbaharui.', 3000, position); }
				else if (vm.position == 'call') { vm.notification('Antrian pasien berhasil dipanggil.', 3000, position); }
				else if (vm.position == 'approvement') { vm.notification('Approvement obat berhasil diproses.', 3000, position); }
				else if (vm.position == 'terimadata') { vm.notification('Uang Panjar berhasil diproses.', 3000, position); }
				else if (vm.position == 'callbeli') { vm.notification('Pemanggilan antrian berhasil diproses.', 3000, position); }
				else if (vm.position == 'selesaibeli') { vm.notification('Proses untuk penyelesaian pasien yang membeli obat berhasil dilakukan.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formdetail') { vm.loadingModal('formdetail'); }
			else if (posisi == 'editobat') { vm.loadingModal('formdetail'); }
			else if (posisi == 'formpembeli') { vm.loadingModal('formpembeli'); }
			else if (posisi == 'formobat') { vm.loadingModal('formobat'); }
			else if (posisi == 'terimadata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'call') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'approvement') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'callbeli') { vm.$refs.DatatableBeli.skeleton(); }
			else if (posisi == 'selesaibeli') { vm.$refs.DatatableBeli.skeleton(); }
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
