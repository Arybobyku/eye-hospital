<template>
<div class="inner" ref="roottable">
<div class="grid">
	<div class="col-1 form-mr">
		<button class="tooltip btn-tambah" @click="download('/finance/carabayar/download')">Download All Data</button> 
	</div>
	<div class="col-5 form-mr">
	</div>

	<div class="col-2 form-mr">
		<Inputed :ref="formDownload" :form="formDownload"></Inputed>
	</div>
	<div class="col-1 form-mr">
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

</div>
	<div class="grid">
		<div class="col-12">
			<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton"></Datatable>
		</div>
	</div>
	<Loader ref="Loader"></Loader>
</div>
<FormCarabayar ref="FormCarabayar" @dialog="dialog" @parsingForm="parsingForm"></FormCarabayar>
<FormChild ref="FormChild" @dialog="dialog" @parsingForm="parsingForm"></FormChild>
<FormTarif ref="FormTarif" @dialog="dialog" @parsingForm="parsingForm"></FormTarif>
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
		FormCarabayar: defineAsyncComponent(() => import('./FormCarabayar.vue')),
		FormChild: defineAsyncComponent(() => import('./FormChild.vue')),
		FormTarif: defineAsyncComponent(() => import('./FormTarif.vue')),
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
		uri: 'carabayar',
		position: '',
		templateName: '',
		formDownload: { 
			title: 'Nama Metode Pembayaran', 
			for_id: 'templateName',
			type: 'text', 
			required: '', 
			key: 'templateName', 
			model: 'templateName', 
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
				list: '/finance/carabayar/list',
				add: '/finance/carabayar/add',
				edit: '/finance/carabayar/edit',
				update: '/finance/carabayar/update',
				remove: '/finance/carabayar/remove',
				childdata: '/finance/carabayar/child/data',
				tarifdata: '/finance/carabayar/tarif/data',
			}, url: '', data: null
		},
		column: [
			{ value: 'nama', label: 'Nama Metode Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'tindakan', label: 'Tindakan', type: 'text', search: false, close: true, button: false },
			//- { value: 'kamar', label: 'Kamar', type: 'text', search: false, close: false, button: false },
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

		btnhtml:function(_item, _index) {
			let str = [
				{ icon: 'edit', color: 'btn-warning', posisi: 'edit', tooltip: 'Edit Data', item: _item, index: _index, show: true },
				{ icon: 'trash-2', color: 'btn-danger', posisi: 'remove', tooltip: 'Hapus Data', item: _item, index: _index, show: true },
				{ 
					icon: 'award', color: 'btn-info', posisi: 'child', tooltip: 'Child Data', 
					item: _item, index: _index, 
					show: true 
				},
				{ 
					icon: 'dollar-sign', color: 'btn-success', posisi: 'tarif', tooltip: 'Tarif Layanan', 
					item: _item, index: _index, show: true
				},
			]
			return str;
		},
		goToPage: function(link){
			const _base = '/dashboard/';
			window.open(_base + link, '_blank'); 
		},
		download: function(link){
			window.open(link); 
		},
		downloadTemplate: function(){
			let namaMetodePembayaran = vm.formDownload.value;
			let link = '/finance/carabayar/downloadtemplate/'+ namaMetodePembayaran;						
			window.open(link); 
			vm.formDownload.value = '';
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

			axios.post('/finance/carabayar/uploadmetodepembayaran', formData, {
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
					}, 300);
					window.location.reload();
				});
		},
		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tindakan') { _tmp = { value: vm.renderTindakanRawatJalan(data), ishtml: 'html', style: '' }; }
			else if (identity == 'kamar') { _tmp = { value: vm.renderJenisKamar(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},
		renderTindakanRawatJalan: function(item) {
			if(item.tindakanrawatjalan.length == 0) { 
				return '<i>Tidak ada data</i>';
			}
			let html = '<table class="table-info">';
			html += '<tr>'+
			'<th>Tindakan</th>'+
			'<th>Label</th>'+
			'<th>Default</th>'+
			'<th>Harga</th></tr>';

			item.tindakanrawatjalan.forEach(trj => {
				html += '<tr>' +
							'<td style="text-align:left;">' + trj.nama_tindakan_rawat_jalan + '</td>' +
							'<td style="text-align:left;">' + trj.jenis + '</td>' +
							'<td style="text-align:left;">' + trj.default + '</td>' +
							'<td style="text-align:left;"><strong>' + trj.harga.toLocaleString('id-ID')  + '</strong></td>' +
						'</tr>';
			});

			html += '</table>';

			return html;
		},
		renderJenisKamar: function(item) {
			let html = '<table class="table-info">';
			html += '<tr><th>Kamar</th><th>jenis</th><th>Harga</th></tr>';

			item.jeniskamar.forEach(trj => {
				html += '<tr>' +
							'<td>' + trj.nama_jenis_kamar + '</td>' +
							'<td>' + trj.jenis + '</td>' +
							'<td><strong>' + trj.harga.toLocaleString('id-ID')  + '</strong></td>' +
						'</tr>';
			});

			html += '</table>';

	
			return html;
		},
		tablebutton:function(posisi, data, index) {
			if (posisi == 'add') {
				vm.$refs.FormCarabayar.aturulang();
				vm.position = "adddata";
				vm.$refs.FormCarabayar.show('adddata', 'Tambah Data', '');
			}
			else if (posisi == 'edit') {
				vm.$refs.FormCarabayar.aturulang();
				vm.position = "editdata";
				vm.$refs.FormCarabayar.show('editdata', 'Edit Data', data.uuid);
				setTimeout(() => { vm.loadingModal('formcarabayar'); }, 250, this);
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
			else if (posisi == 'child') {
				vm.$refs.FormChild.aturulang();
				vm.position = "childdata";
				vm.$refs.FormChild.show('childdata', 'Child : ', data.uuid);
				setTimeout(() => { vm.loadingModal('formchild'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.childdata;
				vm.executions();
			}
			else if (posisi == 'tarif') {
				vm.$refs.FormTarif.aturulang();
				vm.position = "tarifdata";
				vm.$refs.FormTarif.show('tarifdata', 'Tarif ', data.uuid);
				setTimeout(() => { vm.loadingModal('formtarif'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.tarifdata;
				vm.executions();
			}
		},

		loadingModal: function (position) { 
			if (position == 'formcarabayar') { vm.$refs.FormCarabayar.loaderprocess();  }
			else if (position == 'formchild') { vm.$refs.FormChild.loaderprocess();  }
			else if (position == 'formtarif') { vm.$refs.FormTarif.loaderprocess();  }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'carabayar') {
				if (vm.position == 'adddata') { vm.attach.url = vm.attach.link.add; } 
				else if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; } 
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
			else if (vm.position == 'adddata') { vm.loadingModal('formcarabayar'); }
			else if (vm.position == 'editdata') { vm.loadingModal('formcarabayar'); vm.$refs.FormCarabayar.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formcarabayar'); }
			else if (vm.position == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'childdata') { vm.loadingModal('formchild'); vm.$refs.FormChild.hide();  }
			else if (vm.position == 'tarifdata') { vm.loadingModal('formtarif'); vm.$refs.FormTarif.hide();  }
			
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
				vm.loadingModal('formcarabayar');
				vm.$refs.FormCarabayar.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormCarabayar.setdataform(response); 
				vm.position = "updatedata"; 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formcarabayar');
				vm.$refs.FormCarabayar.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'removedata') { 
				setTimeout(() => { vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'childdata') {
				vm.$refs.FormChild.setdataform(response); 
				vm.position = "-"; 
				active = 0; 
			}
			else if (vm.position == 'tarifdata') {
				vm.$refs.FormTarif.setdataform(response); 
				vm.position = "-"; 
				active = 0; 
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
				else if (vm.position == 'childdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'tarifdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formcarabayar') { vm.loadingModal('formcarabayar'); }
			else if (posisi == 'removedata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'formchild') { vm.loadingModal('formchild'); }
			else if (posisi == 'formtarif') { vm.loadingModal('formtarif'); }
			
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
