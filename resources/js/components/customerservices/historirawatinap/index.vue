<template>
<div class="inner" ref="roottable">
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
		
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.pasien">
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
import { nullAndZero, datename, countage, formatrupiah } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["titletrigger", "repatch"],
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
		uri: 'unit',
		position: 'loadmain',
		attach: {
			link : {
				list: '/customerservices/historirawatinap/list',
				detail: '/customerservices/historirawatinap/detail',
			}, url: '', data: null
		},
		tab: {
			button: [
				{ value: 'pasien', label: 'Data Pasien', class: 'tab-active' },
				// { value: 'antrian', label: 'Daftar Antrian', class: 'tab-no-active' },
				// { value: 'pending', label: 'Pasien yang Pending', class: 'tab-no-active' },
			],
			content: { 
				pasien: true, 
				antrian: false, 
				// pending: false 
			}
		},
		moduleantrian: { data: [], column: [], total: 0, ispaging: true },
		modulepending: { data: [], column: [], total: 0, ispaging: true },
		module: { data: [], column: [], total: 0, ispaging: true },
		column: [
			{ value: 'detail', label: 'Informasi', type: 'text', search: false, close: false, button: false },
			{ value: 'waktu_status', label: 'Waktu dan Status', type: 'text', search: false, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
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
				
				// if (values == 'antrian') {
				// 	vm.posisieksternal = 'antrian';
				// 	vm.loadantrian();
				// }
				// else if (values == 'pending') {
				// 	vm.posisieksternal = 'pending';
				// 	vm.loadpending();
				// }
				// else {
					vm.posisieksternal = 'pasien';
					vm.loadmain();
				//}
			}
		},
		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
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

		detail: function(_item) {
			let msg = '<table>'	+
									'<tr>' +
										'<td>No. Registrasi</td>' +
										'<td>: RI'+_item.nomor+'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>Tanggal Lahir</td>' +
										'<td>: '+vm.datename(_item.tanggal_lahir)+'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>Usia</td>' +
										'<td>: '+vm.countage(_item.tanggal_lahir)+'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>Jenis Kelamin</td>' +
										'<td>: '+_item.jenis_kelamin+'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>No. Handphone</td>' +
										'<td>: '+_item.no_handphone+'</td>' +
									'</tr>' +
								'</table>';

			return msg;
		},

		asuransi:function(_item) {
			return _item.nama_asuransi != '-' && _item.nama_asuransi != 'Silahkan Pilih' ? _item.nama_asuransi : '';
		},

		waktu_status: function(_item) {
			let msg = '<table class="table">'	+
									'<tr>' +
										'<td>Tanggal Pendaftaran</td>' +
										'<td>: '+vm.datename(_item.tanggal)+'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>Jam Pendaftaran</td>' +
										'<td>: '+_item.waktu+'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>Metode Pembayaran</td>' +
										'<td>: '+_item.carabayar_nama+'<br />'+ vm.asuransi(_item) +'</td>' +
									'</tr>' +
									'<tr>' +
										'<td>Berkebutuhan Khusus?</td>' +
										'<td>: '+_item.berkebutuhan_khusus+'</td>' +
									'</tr>' +
									
								'</table>';

			return msg;
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
			if (posisi == 'detail') {
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Data', data.pasien_uuid);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.pasien_uuid);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'cetakkartu') {
				window.open(vm.attach.link.printcetakkartu + data.uuid, '_blank');
			}
		},

		loadingModal: function (position) { 
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
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

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				vm.$refs.Datatable.skeleton(); 
				vm.$refs.Datatable.backpage(); 
			}
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			
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
				else if (vm.position == 'externaltable') { 
					vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.paging(); 
					active = 0;
				}
				else if (vm.position == 'detaildata') {
					vm.posisieksternal='pasien';
					vm.$refs.FormDetail.setdataform(response); 
					vm.position = "-"; 
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
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
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
