<template>
<div class="inner" ref="roottable">
	<div class="grid" v-if="form">
		<div class="col-12">
			<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
			:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
			:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>
		</div>
	</div>
	<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
	<div class="tab-content">
		<div class="content-tab-in" v-if="tab.content.pasien">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>

	<Loader ref="Loader"></Loader>
</div>

</template>

<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { nullAndZero, datename, countage, formatrupiah } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
import { formantrian } from './FormData.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
export default {
	emits: ["titletrigger", "repatch"],
	components: { toast, Swal, 
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	
	created: function () {},
	mounted: function () {
		vm = this;
		
		setTimeout(() => { this.titletrigger(); }, 250);

		setTimeout(() => {
			vm.form = vm.formantrian();
		}, 1250);
		vm.loadmain();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	data: function () { return {
		uri: 'unit',
		form: null,
		position: 'loadmain',
		pengguna_uuid: 'empty',
		pagenumber: 0,
		attach: {
			link : {
				list: '/customerservices/antrianpasien/list',
			}, url: '', data: null
		},
		tab: {
			button: [
				{ value: 'pasien', label: 'Data Pasien', class: 'tab-active' },
			],
			content: { 
				pasien: true,
			}
		},
		module: { data: [], column: [], total: 0, ispaging: true },
		column: [
			{ value: 'rekam_medis', label: 'No Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date', search: true, close: false, button: false },
			{ value: 'alamat', label: 'Alamat', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'no_handphone', label: 'No Handphone', type: 'text', search: true, close: false, button: false },
			{ value: 'sisa_antrian', label: 'Sisa Antrian', type: 'text', search: false, close: false, button: false },
		],
		posisieksternal: 'pasien'
	}},
	methods: {
		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		formantrian, filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,
		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.itemselected(vm.form, item, key); 
			vm.pengguna_uuid = vm.form.select.dokter.value;
			vm.loadmain();
		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
			vm.pengguna_uuid = 'empty';
			vm.loadmain();
		},
		selectbox:function(event, key, statics) {
			if (!vm.form.select[key].disabled) {
				let result = vm.boxselected(event, vm.form, key);
				if (result._position == 'stop') { return ; }
				else if (result._position == 'nextstop') { vm.form = result._form; }
				else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
			}
		},
		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key); 
					})
					.catch(function(error){ console.log(error); });
			}
		},
		nullAndZero, datename, countage, formatrupiah,
		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
				
				vm.module.data = [];
				vm.posisieksternal = 'pasien';
				vm.loadmain();
			}
		},
		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: true },
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Data', item: _item, index: _index, show: true },
				{ icon: 'book-open', color: 'btn-info', posisi: 'registrasi', tooltip: 'Data Registrasi', item: _item, index: _index, 
						show: _item.status == 'Kunjungan' || _item.status == 'Aktif' ? true : false },
				{ icon: 'printer', color: 'btn-success', posisi: 'suratpersetujuan', tooltip: 'Surat Persetujuan', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-info', posisi: 'uploadfile', tooltip: 'Upload Surat Persetujuan', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetakkartu', tooltip: 'Cetak Kartu', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-warning', posisi: 'cetaklabel', tooltip: 'Cetak Label', item: _item, index: _index, show: true }
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

		sisa_antrian:function() {
			return (vm.pagenumber++) + ' Orang';
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column), ishtml: 'html', style: '' }; }
			else if (identity == 'usia') { _tmp = { value: vm.usia(data), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.status(data), ishtml: 'html', style: '' }; }
			else if (identity == 'sisa_antrian') { _tmp = { value: vm.sisa_antrian(), ishtml: 'html', style: '' }; }
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

		tablebutton:function(posisi, data, index) {},

		loadingModal: function (position) { },

		parsingForm:function(data, key) {},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },

		tableload:function(pos = 'main') { 
			vm.attach.url = vm.attach.link.list; 
			vm.attach.data = new FormData(); 
			vm.attach.data.append('search', ''); 
			vm.attach.data.append('column', ''); 
			vm.attach.data.append('page', 1); 
			vm.attach.data.append('pengguna_uuid', vm.pengguna_uuid); 
			vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			
			if (pos == 'outer') {
				vm.$refs.Datatable.skeleton(); 
			}
			for(var pair of data.entries()) {
				if (pair[0] == 'page') {
					vm.pagenumber = (pair[1] * 15) - 15;
				}
				//console.log(pair[0]+ ', '+ pair[1]); 
 			}
			vm.attach.url = vm.attach.link.list; 
			data.append('pengguna_uuid', vm.pengguna_uuid); 
			vm.attach.data = data; 
			vm.position = 'externaltable'; 
			vm.executions(); 
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		loadmain: () => { 
			console.log(vm.position);
			vm.pagenumber = 0;
			vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); 
		},
		

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
				
				vm.$refs.Datatable.skeleton(); 
				vm.$refs.Datatable.backpage(); 
			}
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
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
			}
			else if (position == 'success' && active == 1) {}
		},

		runconfirm: function (posisi) {
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
