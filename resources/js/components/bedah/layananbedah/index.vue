<template>
	<div class="inner" ref="roottable">
		<div class="tab-lines">
			<div class="tab"><button v-for="(item, index) in tab.button" :class="item.class"
					v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div>
		</div>
		<div class="tab-content">
			<div class="content-tab-in">
				<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton">
				</Datatable>
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
		uri: 'unit',
		position: '',
		attach: {
			link : {
				list: '/bedah/layananbedah/list',
				edit: '/bedah/layananbedah/edit',
				update: '/bedah/layananbedah/update',
				remove: '/bedah/layananbedah/remove',
			}, url: '', data: null
		},
		column: [
			{ value: 'tanggal', label: 'Tanggal', type: 'text', search: true, close: false, button: false },
			// { value: 'waktu', label: 'Waktu', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter Poli', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter_bedah', label: 'Dokter Bedah', type: 'text', search: false, close: false, button: false },
			{ value: 'nama_paket_bedah', label: 'Paket Bedah', type: 'text', search: true, close: false, button: false },
			{ value: 'bedah_status', label: 'Status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
		moduledone: { data: [], column: [], total: 0, ispaging: true },
		tab: {
			button: [
				{ value: 'now', label: 'Pasien (Aktif)', class: 'tab-active' },
			],
			content: { 
				now: true, 
				done: false,
			}
		},
		posisieksternal: 'now'
	}},
	methods: {

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;

				if (values == 'done') {
					vm.loaddone();
					vm.posisieksternal = 'done';
				}
				else {
					vm.posisieksternal = 'today';
					vm.loadmain();
				}
			}
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan table
		*************************************************************************************************************************/

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'edit', tooltip: 'Edit Layanan Bedah', item: _item, index: _index, show: true },
				
			]
			return str;
		},

		jenisos:function(data) {
			if (data.jenis == 'One Day Care') { return 'One Day Care'; }
			return 'Rawat Inap';
		},

		bedahstatus:function(data) {
			if (data.bedah_status == '-') { return '<div class="badge badge-danger">Menunggu</div>'; }
			return '<div class="badge badge-success">'+data.bedah_status+'</div>'
		},
		waktuMasuk: function (data) {
			if (data.waktu_masuk_inap == '') 
			{
				return "-";

			 } else {
			return data.waktu_masuk_inap
			} 
			// return '<div class="badge badge-success">' + waktuMasukInap + '</div>'
		},
		tanggalMasuk: function (data) {
 			if (data.tanggal_masuk_inap <= '2000-01-01') {
				return "";
			 } else {
				return data.tanggal_masuk_inap
			}

			// return '<div class="badge badge-success">' + waktuMasukInap + '</div>'
		},
		datename2: function (data, istimes = false) {
			if (data <= '2000-01-01') {
				return '-'; 
			} else {
			let tmp = data.split(" "),
				dates = tmp[0].split('-');
			if (tmp.length > 1) {
				let times = tmp[1].split(':');
				if (istimes) {
					return dates[2] + ' ' + this.monthname(dates[1]) + ' ' + dates[0] + ' <strong>' + times[0] + ':' + times[1] + '</strong>';
				}
				return dates[2] + ' ' + this.monthname(dates[1]) + ' ' + dates[0];
			}
			return dates[2] + ' ' + this.monthname(dates[1]) + ' ' + dates[0];
		}},

		monthname: function (month) {
			if (month == '01') { month = 'Januari'; }
			else if (month == '02') { month = 'Februari'; }
			else if (month == '03') { month = 'Maret'; }
			else if (month == '04') { month = 'April'; }
			else if (month == '05') { month = 'Mei'; }
			else if (month == '06') { month = 'Juni'; }
			else if (month == '07') { month = 'Juli'; }
			else if (month == '08') { month = 'Agustus'; }
			else if (month == '09') { month = 'September'; }
			else if (month == '10') { month = 'Oktober'; }
			else if (month == '11') { month = 'November'; }
			else { month = 'Desember'; }
			return month;
		},

		datenumber: function (data, istimes = false) {
			let tmp = data.split(" "),
				dates = tmp[0].split('-');
			if (tmp.length > 1) {
				let times = tmp[1].split(':');
				if (istimes) {
					return dates[2] + '/' + dates[1] + '/' + dates[0] + ' ' + times[0] + ':' + times[1];
				}
				return dates[2] + '/' + dates[1] + '/' + dates[0];
			}
			return dates[2] + '/' + dates[1] + '/' + dates[0];
		},


		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'jenis') { _tmp = { value: vm.jenisos(data), ishtml: 'html', style: '' }; }
			else if (identity == 'bedah_status') { _tmp = { value: vm.bedahstatus(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		converterdone: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'jenis') { _tmp = { value: vm.jenisos(data), ishtml: 'html', style: '' }; }
			else if (identity == 'bedah_status') { _tmp = { value: vm.bedahstatus(data), ishtml: 'html', style: '' }; }
			else if (identity == 'waktu_masuk_inap') { _tmp = { value: vm.waktuMasuk(data), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal_masuk_inap') { _tmp = { value: vm.datename2(column, true), ishtml: 'html', style: '' }; }

			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			console.log("POSISI aturulang");
			console.log(posisi);
			console.log(data);
			 if (posisi == 'edit') {
				vm.$refs.FormDetail.aturulang();
				vm.position = "edit";
				vm.$refs.FormDetail.show('edit', 'Ganti Paket Bedah', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.edit;
				vm.executions();
				
			}			
			// else if (posisi == 'detail') {
			// 	vm.position = "detaildata";
			// 	vm.$refs.FormDetail.show('detaildata', 'Detail Paket Data', data.uuid);
			// 	setTimeout(() => { vm.loadingModal('detaildata'); }, 250, this);
			// 	vm.attach.data = new FormData();
			// 	vm.attach.data.append('uuid', data.uuid);
			// 	vm.attach.data.append('jenis', data.jenis);
			// 	vm.attach.url = vm.attach.link.detail;
			// 	vm.executions();
			// }


		},

		loadingModal: function (position) { 
			console.log("position loadingmodal")
			console.log(position)
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
			else if (position == 'formeditbedah') { vm.$refs.FormEditBedah.loaderprocess(); }

		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			console.log('key');
			console.log(key);
			if (key == 'update') {
				vm.position = 'updatedata';
				vm.attach.url = vm.attach.link.update;
			}
			else if(key == 'remove') {
				 vm.position = 'removedata'; vm.attach.url = vm.attach.link.remove; }
			else if (key == 'addbedah') {
				vm.position = 'updatebedahdata'; vm.attach.url = vm.attach.link.addbedah;
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
			else if (pos == 'done') {
				vm.attach.url = vm.attach.link.listselesai; 
				vm.attach.data = new FormData(); 
				vm.attach.data.append('search', ''); 
				vm.attach.data.append('column', ''); 
				vm.attach.data.append('page', 1);
			} else {
				vm.attach.url = vm.attach.link.list;
				vm.attach.data = new FormData();
				vm.attach.data.append('search', '');
				vm.attach.data.append('column', '');
				vm.attach.data.append('page', 1); 
			}

			vm.executions(); 
		},
		tablereload:function(data = new FormData(), pos = 'main') { 
			if (vm.posisieksternal == 'done') {
				if (pos == 'outer') {
					vm.$refs.DatatableDone.skeleton(); 
				}
				vm.attach.url = vm.attach.link.listselesai; 
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

		loaddone:function() {
			vm.position = 'loaddone'; 
			vm.firstloader(); 
			vm.tableload('done');
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'loaddone') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { 
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.backpage(); 
			}
			else if (vm.position == 'updatedata') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'removedata') { vm.loadingModal('formdetail'); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			console.log("posisiberhasil");
			console.log(vm.position);
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }
	
			if (vm.position == 'loadmain') { 
				vm.posisieksternal='now';
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.paging(); 
				active = 0;
			}
			else if (vm.position == 'loaddone') { 
				vm.posisieksternal='done';
				vm.firstloader();
				vm.$refs.DatatableDone.update(vm.columndone, vm.setDatatabledone(response.data.data, response.data.total), response.data.total); 
				vm.$refs.DatatableDone.paging(); 
				active = 0;
			}
			else if (vm.position == 'edit') { 
				vm.$refs.FormDetail.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'externaltable') { 

				if (vm.posisieksternal=='done') {
					vm.$refs.DatatableDone.update('', vm.setDatatabledone(response.data.data, response.data.total), response.data.total); 
					vm.$refs.DatatableDone.skeleton(); 
					vm.$refs.DatatableDone.paging(); 
					active = 0;
				}
				else {
					vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
					vm.$refs.Datatable.skeleton(); 
					vm.$refs.Datatable.paging(); 
					active = 0;
				}
			}

			else if (vm.position == 'updatedata') {
				vm.$refs.FormDetail.setdataform(response);
			}
			else if (vm.position == 'removedata') {
				vm.$refs.FormDetail.setdataform(response);
			}
			
			else if (vm.position == 'loaddata') {
				vm.$refs.FormDetail.setdataform(response); 
				active = 0; 
			}
			
			vm.message('success', active);
		},

		message: function (position, active) {
			console.log("position msg");
			console.log(position);
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loaddone') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'edit') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }

			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'updatedata') { vm.loadingModal('formdetail'); }
			else if (posisi == 'removedata') { vm.loadingModal('formunit');  }
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
