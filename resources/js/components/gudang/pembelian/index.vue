<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
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
		uri: 'unit',
		position: '',
		attach: {
			link : {
				list: '/gudang/pembelian/list',
				add: '/gudang/pembelian/add',
				edit: '/gudang/pembelian/edit',
				update: '/gudang/pembelian/update',
				remove: '/gudang/pembelian/remove',
				approve: '/gudang/pembelian/approve',
				obat: '/gudang/pembelian/obat',
				addobat: '/gudang/pembelian/addobat',
			}, url: '', data: null
		},
		column: [
			{ value: 'tanggal_faktur', label: 'Tanggal Faktur', type: 'date', search: true, close: false, button: false },
			{ value: 'no_faktur', label: 'No. Faktur', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_supplier', label: 'Nama Supplier', type: 'text', search: true, close: false, button: false },
			{ value: 'ppn', label: 'PPN (%)', type: 'text', search: true, close: false, button: false },
			{ value: 'pembayaran', label: 'Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'jumlah', label: 'Jumlah Obat', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: '', search: false, close: false, button: true }
		],
		module: { data: [], column: [], total: 0, ispaging: true },
	}},
	methods: {

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,

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

		converter:function(data, index, column, identity) {
			let _tmp = '';
			let _btn_html = vm.btnhtml(data, index);
			if (identity == 'btnhtml') { _tmp = { value: _btn_html.data, ishtml: _btn_html.key, show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column), ishtml: 'text', style: '' }; }
			else if (identity == 'tanggal_faktur') { _tmp = { value: vm.datename(column), ishtml: 'text', style: '' }; }
			else if (identity == 'pembayaran') { _tmp = { value: vm.pembayaran(data), ishtml: 'text', style: '' }; }
			else if (identity == 'jumlah') { _tmp = { value: vm.jumlah(column), ishtml: 'text', style: '' }; }
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
				vm.dialog('Yakin ingin menghapus data yang terpilih dihalaman ini.', 'Ya, hapus data', 'removedata');
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
		tableload:function() { vm.attach.url = vm.attach.link.list; vm.attach.data = new FormData(); vm.attach.data.append('search', ''); vm.attach.data.append('column', ''); vm.attach.data.append('page', 1); vm.executions(); },
		tablereload:function(data = new FormData(), pos = 'main') { if (pos == 'outer') { vm.$refs.Datatable.skeleton(); } vm.attach.url = vm.attach.link.list; vm.attach.data = data; vm.position = 'externaltable'; vm.executions(); },

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		loadmain: () => { vm.position = 'loadmain'; vm.firstloader(); vm.tableload(); },

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') { vm.$refs.Datatable.skeleton(); vm.$refs.Datatable.backpage(); }
			else if (vm.position == 'adddata') { vm.loadingModal('formfaktur'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formfaktur'); vm.$refs.FormFaktur.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formfaktur'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'approvedata') { vm.$refs.Datatable.skeleton(); }
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
			else if (vm.position == 'externaltable') { 
				vm.$refs.Datatable.update('', vm.setDatatable(response.data.data, response.data.total), response.data.total); 
				vm.$refs.Datatable.skeleton(); 
				vm.$refs.Datatable.paging(); 
				active = 0;
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
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'approvedata') { vm.notification('Approval data gagal diproses.', 3000, position); }
				else if (vm.position == 'formobat') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedataobat') { vm.notification('Penambahan/Pembaharuan data obat gagal diproses.', 3000, position); }

			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'approvedata') { vm.notification('Approval data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedataobat') { vm.notification('Penambahan/Pembaharuan data obat berhasil diproses.', 3000, position); }

			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formfaktur') { vm.loadingModal('formfaktur'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'approvedata') { vm.$refs.Datatable.skeleton(); }
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
