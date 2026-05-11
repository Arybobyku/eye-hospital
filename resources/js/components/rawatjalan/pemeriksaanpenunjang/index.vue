<template>
<div class="inner" ref="roottable">
	<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
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
	beforeUnmount: function () {},
	components: { toast, Swal,
		FormDetail: defineAsyncComponent(() => import('./FormDetail.vue')),
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loaddata();
	},
	data: function () { return {
		uri: 'detail',
		position: '',
		attach: {
			link: {
				list: '/dokter/pemeriksaan/list-penunjang',
				detail: '/dokter/pemeriksaan/detail-penunjang',
				sudahupload: '/dokter/pemeriksaan/set-sudah-upload-penunjang',
				batalkan: '/dokter/pemeriksaan/batalkan-penunjang',
			}, url: '', data: null
		},
		column: [
			{ value: 'no_pendaftaran', label: 'No Pendaftaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'text', search: true, close: false, button: false },
			{ value: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'text', search: false, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang Menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'status_dokter', label: 'Status', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false },
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

		btnhtml: function (_item, _index) {
			return [
				{ icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Detail Penunjang', item: _item, index: _index, show: true },
				{ icon: 'x-circle', color: 'btn-danger', posisi: 'batalkan', tooltip: 'Batalkan Penunjang', item: _item, index: _index, show: true },
			];
		},

		statusdokter: function (data) {
			if (data.status_dokter === 'Pemeriksaan Penunjang') {
				return '<div class="badge badge-warning">' + data.status_dokter + '</div>';
			}
			if (data.status_dokter === 'Sudah Upload Penunjang') {
				return '<div class="badge badge-success">' + data.status_dokter + '</div>';
			}
			return '<div class="badge badge-danger">' + data.status_dokter + '</div>';
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' }; }
			else if (identity == 'tanggal_lahir') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'status_dokter') { _tmp = { value: vm.statusdokter(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' }; }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton: function (posisi, data, index) {
			if (posisi == 'detail') {
				vm.$refs.FormDetail.aturulang();
				vm.position = 'detaildata';
				vm.$refs.FormDetail.show('detaildata', 'Detail Pemeriksaan Penunjang', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetail'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'batalkan') {
				vm.position = 'batalkan';
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.batalkan;
				vm.dialog('Batalkan pemeriksaan penunjang dan kembalikan status pasien menjadi Belum Diperiksa?', 'Ya, batalkan', 'batalkan');
			}
		},

		loadingModal: function (position) {
			if (position == 'formdetail') { vm.$refs.FormDetail.loaderprocess(); }
		},

		parsingForm: function (data, key) {
			vm.attach.data = data;
			if (key == 'sudah-upload') {
				vm.position = 'sudahupload';
				vm.attach.url = vm.attach.link.sudahupload;
			}
		},

		batalkanConfirm: function (uuid) {
			vm.position = 'batalkan';
			vm.attach.data = new FormData();
			vm.attach.data.append('uuid', uuid);
			vm.attach.url = vm.attach.link.batalkan;
		},

		setDatatable: function (data, total) {
			let temporer = [], col = [];
			for (let i = 0; i < data.length; i++) {
				col = [];
				for (let j = 0; j < vm.column.length; j++) {
					col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] : vm.column[j].value, vm.column[j].value));
				}
				temporer.push(col);
			}
			vm.module.data = temporer;
			vm.module.total = total;
			return temporer;
		},

		tableload: function () {
			vm.attach.url = vm.attach.link.list;
			vm.attach.data = new FormData();
			vm.attach.data.append('search', '');
			vm.attach.data.append('column', '');
			vm.attach.data.append('page', 1);
			vm.executions();
		},

		tablereload: function (data = new FormData(), pos = 'main') {
			if (pos == 'outer') { vm.$refs.Datatable.skeleton(); }
			vm.attach.url = vm.attach.link.list;
			vm.attach.data = data;
			vm.position = 'externaltable';
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		loaddata: function () { vm.position = 'loaddata'; vm.firstloader(); vm.tableload(); },

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loaddata') { vm.firstloader(); active = 1; }
			else if (vm.position == 'externaltable') {
				vm.$refs.Datatable.skeleton();
				vm.$refs.Datatable.backpage();
			}
			else if (vm.position == 'detaildata') { vm.loadingModal('formdetail'); vm.$refs.FormDetail.hide(); }
			else if (vm.position == 'sudahupload') { vm.loadingModal('formdetail'); }
			else if (vm.position == 'batalkan') { /* tidak ada modal, langsung reload tabel */ }

			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function () { vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }); }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }

			if (vm.position == 'loaddata') {
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
				vm.$refs.FormDetail.setdataform(response);
				vm.position = 'updatedata';
				active = 0;
			}
			else if (vm.position == 'sudahupload') {
				// Update status reactively in the open modal, then reload table
				if (vm.$refs.FormDetail && vm.$refs.FormDetail.terminate && vm.$refs.FormDetail.terminate.show) {
					vm.$refs.FormDetail.detail.status_dokter = 'Sudah Upload Penunjang';
				}
				vm.loadingModal('formdetail');
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 300, this);
				active = 0;
			}
			else if (vm.position == 'batalkan') {
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 300, this);
				active = 0;
			}

			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loaddata') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'detaildata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'sudahupload') { vm.notification('Pembaruan status gagal diproses.', 3000, position); }
				else if (vm.position == 'batalkan') { vm.notification('Pembatalan penunjang gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'sudahupload') { vm.notification('Status berhasil diperbarui menjadi Sudah Upload Penunjang.', 3000, position); }
				else if (vm.position == 'batalkan') { vm.notification('Pemeriksaan penunjang berhasil dibatalkan.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formdetail') { vm.loadingModal('formdetail'); }
			else if (posisi == 'sudah-upload') { vm.loadingModal('formdetail'); }
			// 'batalkan' tidak butuh loadingModal karena tidak membuka FormDetail
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function () { vm.berhasil(response); }, 750, this); }).catch(function (error) { setTimeout(function () { vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title: "Apakah Anda Yakin?", text: _text, icon: "warning", showCancelButton: !0, confirmButtonColor: "#1c84ee", cancelButtonColor: "#fd625e", confirmButtonText: _confirm, cancelButtonText: "Tidak, batal!" }).then(function (e) { if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },
		loadPatch: function () { vm.firstloader(); },
		firstloader: function () { const left = this.$refs.roottable.getBoundingClientRect(); vm.$refs.Loader.running(left); },
		unloadPatch: function (position) { vm.firstloader(); if (position == 'success') { vm.notification('Data berhasil dipatch.', 3000, position); } else if (position == 'error') { vm.notification('Data gagal dipatch.', 3000, position); } },
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); },
	}
}
</script>
