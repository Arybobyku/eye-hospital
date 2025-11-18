<template>
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-3 form-mr">
			<Inputed :ref="formDownloadName" :form="formDownloadName"></Inputed>
		</div>
		<div class="col-3 form-mr">
			<Inputed :ref="formDownloadTanggal" :form="formDownloadTanggal"></Inputed>
		</div>
		<div class="col-3 form-mr">
			<Inputed :ref="formDownloadWaktu" :form="formDownloadWaktu"></Inputed>
		</div>
		<div class="col-3 form-mr">
			<button class="btn-tambah" @click="downloadTemplate()">Generate Template</button>
		</div>
		<div class="col-2 form-mr">
			<div class="form-self-group">
				<input 
					:id="formUpload.for_id" 
					:type="formUpload.type" 
					:disabled="formUpload.disabled ? 'disabled' : false" 
					@change="onFileChange" 
				/>
			</div>

		</div>
		<div class="col-1 form-mr">
			<button class="btn-tambah" @click="uploadFile()">Upload</button>
		</div>
	</div>	
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormUnit ref="FormUnit" @dialog="dialog" @parsingForm="parsingForm"></FormUnit>
<FormBalance ref="FormBalance" @dialog="dialog" @parsingForm="parsingForm"></FormBalance>
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
		FormBalance: defineAsyncComponent(() => import('./FormBalance.vue')),
		FormDetail: defineAsyncComponent(() => import('./FormDetail.vue')),
		FormUnit: defineAsyncComponent(() => import('./FormUnit.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
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
		formDownloadName: { 
			title: 'Nama penginput stock opname', 
			for_id: 'formDownloadName',
			type: 'text', 
			required: '', 
			key: 'formDownloadName', 
			model: 'formDownloadName', 
			disabled: false,
			value: '',
			},
		formDownloadTanggal: { 
			title: 'Tanggal', 
			for_id: 'formDownloadTanggal',
			type: 'date', 
			required: '', 
			key: 'formDownloadTanggal', 
			model: 'formDownloadTanggal', 
			disabled: false,
			value: '',
			},
		formDownloadWaktu: { 
			title: 'Waktu (jam:menit)', 
			for_id: 'formDownloadWaktu',
			type: 'time', 
			required: '', 
			key: 'formDownloadWaktu', 
			model: 'formDownloadWaktu', 
			disabled: false,
			value: '',
			},
		formUpload: { 
			title: 'Upload Metode Pembayaran', 
			for_id: 'upload',
			type: 'file', 
			required: '', 
			key: 'upload', 
			model: 'upload', 
			disabled: false,
			value: null,
		},
		attach: {
			link : {
				list: '/gudang/stockcatatlabel/list',
				add: '/gudang/stockcatatlabel/add',
				edit: '/gudang/stockcatatlabel/edit',
				update: '/gudang/stockcatatlabel/update',
				remove: '/gudang/stockcatatlabel/remove',
				getbalance: '/gudang/stockcatatlabel/getbalance',
				addbalance: '/gudang/stockcatatlabel/addbalance',
				prosesbalance: '/gudang/stockcatatlabel/prosesbalance',

			}, url: '', data: null
		},
		column: [
			{ value: 'nama', label: 'Nama', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal', label: 'Tanggal', type: 'date', search: true, close: false, button: false },
			{ value: 'jam', label: 'Pukul', type: 'text', search: true, close: false, button: false },
			{ value: 'status', label: 'Status Stock Opname', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: true }
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
		downloadTemplate: function(){
			let name = vm.formDownloadName.value;
			let tanggal = vm.formDownloadTanggal.value;
			let waktu = vm.formDownloadWaktu.value;
			let link = `/gudang/stockcatatlabel/downloadtemplate/${name}/${tanggal}/${waktu}`;						
			window.open(link); 
			vm.formDownloadName.value = '';
			vm.formDownloadTanggal.value = '';
			vm.formDownloadWaktu.value = '';
		},
		onFileChange(e) {
			console.log("onfilechanges",e.target.files[0]);
			vm.formUpload.value = e.target.files[0];
		},
		uploadFile: function(){
			console.log("File upload", vm.formUpload.value);

			vm.$refs.Datatable.skeleton();

			let formData = new FormData();
			formData.append('file', vm.formUpload.value); // sesuaikan dengan nama field di Laravel request

			axios.post('/gudang/stockcatatlabel/uploadexcel', formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			})
				.then(function (response) {
					setTimeout(function () {
						vm.berhasil(response);
					}, 300);

					window.location.reload();
				})
				.catch(function (error) {
					console.error(error);
					setTimeout(function () {
						vm.gagal(error);
					}, 300).then(function(){
						window.location.reload();
					});
				});
		},
		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'detail', tooltip: 'Detail Stock Opname', item: _item, index: _index, show: _item.status == 'Selesai' ? true : false },
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: _item.status != 'Selesai' ? true : false },
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'remove', tooltip: 'Hapus Data', item: _item, index: _index, show: _item.status != 'Selesai' ? true : false },
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'balance', tooltip: 'Input Stok Fisik', item: _item, index: _index, show: _item.status != 'Selesai' ? true : false },
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'prosesbalance', tooltip: 'Proses Balancing Obat/Alkes', item: _item, index: _index, 
				show: _item.status == 'Proses' ? true : false },
			]
			return str;
		},

		statused:function(data) {
			if (data.status == 'Proses') { return 'Draft'; }
			return 'Done';
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'status') { _tmp = { value: vm.statused(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "adddata";
				vm.$refs.FormUnit.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "editdata";
				vm.$refs.FormUnit.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formunit'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.edit;
				vm.executions();
			}
			else if (posisi == 'balance') {
				vm.$refs.FormBalance.aturulang();
				vm.position = "balancedata";
				vm.$refs.FormBalance.show('balancedata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formbalance'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.getbalance;
				vm.executions();
			}
			else if (posisi == 'detail') {
				vm.$refs.FormDetail.aturulang();
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.getbalance;
				vm.executions();
			}
			else if (posisi == 'remove') {
				vm.position = "removedata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.remove;
				vm.dialog('Yakin ingin menghapus data ' + data.nama, 'Ya, hapus data', 'removedata');
			}
			else if (posisi == 'prosesbalance') {
				vm.position = "prosesbalancedata";
				vm.attach.data = new FormData();
				vm.attach.data.append('label_stockopname_uuid', data.uuid);
				vm.attach.url = vm.attach.link.prosesbalance;
				vm.dialog('Yakin ingin memproses stock opname pada data ini.', 'Ya, stock opname', 'prosesbalancedata');
			}
		},

		loadingModal: function (position) { 
			if (position == 'formunit') { vm.$refs.FormUnit.loaderprocess();  }
			else if (position == 'formbalance') { vm.$refs.FormBalance.loaderprocess();  }
			else if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'unit') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; } 
			}
			else if (key == 'balance') { vm.position = 'updatebalance'; vm.attach.url = vm.attach.link.addbalance; }
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
			else if (vm.position == 'adddata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formunit'); vm.$refs.FormUnit.hide();  }
			else if (vm.position == 'balancedata') { vm.loadingModal('formbalance'); vm.$refs.FormBalance.hide();  }
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'updatebalance') { vm.loadingModal('formbalance'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'prosesbalancedata') { vm.$refs.Datatable.skeleton(); }
			
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
				vm.loadingModal('formunit');
				vm.$refs.FormUnit.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormUnit.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'balancedata') {
				vm.$refs.FormBalance.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormDetail.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formunit');
				vm.$refs.FormUnit.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'updatebalance') {
				vm.loadingModal('formbalance');
				vm.$refs.FormBalance.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'removedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'prosesbalancedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'balancedata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'updatebalance') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'prosesbalancedata') { vm.notification('Stock opname data gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatebalance') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'prosesbalancedata') { vm.notification('Stock opname data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formunit') { vm.loadingModal('formunit'); }
			else if (posisi == 'formbalance') { vm.loadingModal('formbalance'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'prosesbalancedata') { vm.$refs.Datatable.skeleton(); }
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
