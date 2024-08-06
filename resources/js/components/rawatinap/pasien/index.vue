<template>
	<div class="inner" ref="roottable">
		<div class="grid">
			<div class="col-12">
				<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton">
				</Datatable>
			</div>
		</div>
		<Loader ref="Loader"></Loader>
	</div>
	<FormUnit ref="FormUnit" @dialog="dialog" @parsingForm="parsingForm"></FormUnit>
	<FormObat ref="FormObat" @dialog="dialog" @parsingForm="parsingForm"></FormObat>
	<FormResep ref="FormResep" @dialog="dialog" @parsingForm="parsingForm"></FormResep>
	<FormPaket ref="FormPaket" @dialog="dialog" @parsingForm="parsingForm"></FormPaket>
	<FormDetailPulang ref="FormDetailPulang" @dialog="dialog" @parsingForm="parsingForm"></FormDetailPulang>
	<FormJadwalKontrol ref="FormJadwalKontrol" @dialog="dialog" @parsingForm="parsingForm"></FormJadwalKontrol>
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
		FormUnit: defineAsyncComponent(() => import('./FormUnit.vue')),
		FormObat: defineAsyncComponent(() => import('./FormObat.vue')),
		FormPaket: defineAsyncComponent(() => import('./FormPaket.vue')),
		FormResep: defineAsyncComponent(() => import('./FormResep.vue')),
		FormDetailPulang: defineAsyncComponent(() => import('./FormDetailPulang.vue')),
		FormJadwalKontrol: defineAsyncComponent(() => import('./FormJadwalKontrol.vue')),
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
				list: '/rawatinap/pasien/list',
				add: '/rawatinap/pasien/add',
				remove: '/rawatinap/pasien/remove',
				detailpulang: '/rawatinap/pasien/detailpulang',
				pulang: '/rawatinap/pasien/pulang',
				getlayanan: '/rawatinap/pasien/getlayanan',
				addobat: '/rawatinap/pasien/addobat',
				addresep: '/rawatinap/pasien/addresep',
				addjadwalkontrol: '/rawatinap/pasien/addjadwalkontrol',
				addpaket: '/rawatinap/pasien/addpaket',
				removeobat: '/rawatinap/pasien/removeobat',
				removeresep: '/rawatinap/pasien/removeresep',
				getobat: '/rawatinap/pasien/getobat',
				getresep: '/rawatinap/pasien/getresep',
				getjadwalkontrol: '/rawatinap/pasien/getjadwalkontrol',
				getpaket: '/rawatinap/pasien/getpaket',
			}, url: '', data: null
		},
		column: [
		
			{ value: 'tanggal', label: 'Tanggal', type: 'text', search: true, close: false, button: false },
			{ value: 'carabayar_nama', label: 'Cara Pembayaran', type: 'text', search: true, close: false, button: false },
			{ value: 'rekam_medis', label: 'No Rekam Medis', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_pasien', label: 'Nama Pasien', type: 'text', search: true, close: false, button: false },
			{ value: 'nama_dokter', label: 'Dokter yang menangani', type: 'text', search: true, close: false, button: false },
			{ value: 'keterangan_inap', label: 'Keterangan', type: 'text', search: false, close: false, button: false },
			{ value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
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
			{ icon: 'plus-circle', color: 'btn-info', posisi: 'operasi', tooltip: 'Tambah Paket Operasi', item: _item, index: _index, show: true },
				{ icon: 'plus-circle', color: 'btn-info', posisi: 'add', tooltip: 'Tambah Tindakan', item: _item, index: _index, show: true },
				{ icon: 'aperture', color: 'btn-warning', posisi: 'obat', tooltip: 'Tambah Obat/Alkes', item: _item, index: _index, show: true },
				//{ icon: 'aperture', color: 'btn-success', posisi: 'resep', tooltip: 'Resep Obat', item: _item, index: _index, show: true },
				{ icon: 'check-circle', color: 'btn-info', posisi: 'jadwalkontrol', tooltip: 'Jadwal Kontrol', item: _item, index: _index, show: true },
				{ icon: 'printer', color: 'btn-success', posisi: 'print', tooltip: 'Cetak Gelang', item: _item, index: _index, show: true },
				{ icon: 'check-circle', color: 'btn-info', posisi: 'detailpulang', tooltip: 'Pasien Pulang', item: _item, index: _index, show: true },
			]
			return str;
		},

		tampiltanggal:function(data) {
			return vm.datename(data.tanggal) + ' ' + data.waktu;
		},

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else if (identity == 'tanggal') { _tmp = { value: vm.tampiltanggal(data), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		tablebutton:function(posisi, data, index) {
			console.log("posisi");
			console.log(posisi);
			if (posisi == 'add') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "loaddata";
				vm.$refs.FormUnit.show('loaddata', 'Penambahan Data Tindakan', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formunit'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.uuid);
				vm.attach.url = vm.attach.link.getlayanan;
				vm.executions();
			}
			else if (posisi == 'obat') {
				vm.$refs.FormObat.aturulang();
				vm.position = "loaddataobat";
				vm.$refs.FormObat.show('loaddataobat', 'Data obat yang dibawa pulang', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formobat'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.uuid);
				vm.attach.url = vm.attach.link.getobat;
				vm.executions();
			}

			else if (posisi == 'detailpulang') {
				vm.$refs.FormDetailPulang.aturulang();
				vm.position = "detailpulangdata";
				vm.$refs.FormDetailPulang.show('detailpulangdata', 'Pasien Pulang', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formdetailpulang'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.uuid);
				vm.attach.url = vm.attach.link.detailpulang;
				vm.executions();
			}
			else if (posisi == 'resep') {
				vm.$refs.FormResep.aturulang();
				vm.position = "loaddataresep";
				vm.$refs.FormResep.show('loaddataresep', 'Data obat yang dibawa pulang', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formresep'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.uuid);
				vm.attach.url = vm.attach.link.getresep;
				vm.executions();
			}
			else if (posisi == 'jadwalkontrol') {
				vm.$refs.FormJadwalKontrol.aturulang();
				vm.position = "loaddatajadwalkontrol";
				vm.$refs.FormJadwalKontrol.show('loaddatajadwalkontrol', 'Data obat yang dibawa pulang', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formjadwalkontrol'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.uuid);
				vm.attach.url = vm.attach.link.getjadwalkontrol;
				vm.executions();
			}
			else if (posisi == 'operasi') {
				vm.$refs.FormPaket.aturulang();
				vm.position = "loaddatapaket";
				vm.$refs.FormPaket.show('loaddatapaket', 'Data paket operasi', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formpaket'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.uuid);
				vm.attach.url = vm.attach.link.getpaket;
				vm.executions();
			}
			else if (posisi == 'pulang') {
				vm.position = "pulangdata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.pulang;
				vm.dialog('Yakin ingin memulangkan data yang terpilih dihalaman ini.', 'Ya, hapus data', 'pulangdata');
			}
		},

		loadingModal: function (position) { 
			console.log("position loadingmodal");
			console.log(position);
			if (position == 'formunit') { vm.$refs.FormUnit.loaderprocess();  }
			else if (position == 'formobat') { vm.$refs.FormObat.loaderprocess();  }
			else if (position == 'formresep') { vm.$refs.FormResep.loaderprocess();  }
			else if (position == 'formjadwalkontrol') { vm.$refs.FormJadwalKontrol.loaderprocess();  }
			else if (position == 'formpaket') { vm.$refs.FormPaket.loaderprocess(); }
			else if (position == 'formdetailpulang') { vm.$refs.FormDetailPulang.loaderprocess(); }
			else if (position == 'detailpulangdata') { vm.$refs.FormDetailPulang.loaderprocess(); }
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			console.log("key parsing");
			console.log(key);
			if (key == 'add') {
				vm.position = 'adddata';
				vm.attach.url = vm.attach.link.add;
			}
			else if (key == 'remove') {
				vm.position = 'removedata';
				vm.attach.url = vm.attach.link.remove;
			}
			else if (key == 'addobat') {
				vm.position = 'adddataobat';
				vm.attach.url = vm.attach.link.addobat;
			}
			else if (key == 'addresep') {
				vm.position = 'adddataresep';
				vm.attach.url = vm.attach.link.addresep;
			}
			else if (key == 'addjadwalkontrol') {
				vm.position = 'addjadwalkontrol';
				vm.attach.url = vm.attach.link.addjadwalkontrol;
			}
			else if (key == 'addpaket') {
				vm.position = 'addpaket';
				vm.attach.url = vm.attach.link.addpaket;
			}
			else if (key == 'removeobat') {
				vm.position = 'removedataobat';
				vm.attach.url = vm.attach.link.removeobat;
			}
			else if (key == 'removeresep') {
				vm.position = 'removeresep';
				vm.attach.url = vm.attach.link.removeresep;
			}
			else if (key == 'pulang') 
			{ vm.position = 'updatepulangdata'; vm.attach.url = vm.attach.link.pulang; }

			// else if (key == 'pulang') {
			// 	vm.position = 'pulang';
			// 	vm.attach.url = vm.attach.link.pulang;
			// }
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
			else if (vm.position == 'adddataobat') { vm.loadingModal('formobat'); }
			else if (vm.position == 'adddataresep') { vm.loadingModal('formresep'); }
			else if (vm.position == 'addjadwalkontrol') { vm.loadingModal('formjadwalkontrol'); }
			else if (vm.position == 'addpaket') { vm.loadingModal('formpaket'); }
			else if (vm.position == 'loaddata') { vm.loadingModal('formunit'); vm.$refs.FormUnit.hide();  }
			else if (vm.position == 'loaddataobat') { vm.loadingModal('formobat'); vm.$refs.FormObat.hide();  }
			else if (vm.position == 'loaddataresep') { vm.loadingModal('formresep'); vm.$refs.FormResep.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'removedata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'removedataobat') { vm.loadingModal('formobat'); }
			else if (vm.position == 'removedataresep') { vm.loadingModal('formresep'); }
			else if (vm.position == 'detailpulangdata') { vm.loadingModal('formdetailpulang'); vm.$refs.FormPulangDetail.hide(); }

			else if (vm.position == 'updatepulangdata') { vm.loadingModal('formpulangdetail'); }

			// else if (vm.position == 'pulangdata') { vm.$refs.Datatable.skeleton(); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			console.log("vm position berhasil");
			console.log(vm.position);
			console.log(response.data);
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
				vm.$refs.FormUnit.setdataform(response);
			}
			else if (vm.position == 'adddataobat') {
				vm.$refs.FormObat.setdataform(response);
			}
			else if (vm.position == 'adddataresep') {
				vm.$refs.FormResep.setdataform(response);
			}
			else if (vm.position == 'addjadwalkontrol') {
				vm.$refs.FormJadwalKontrol.hide();
				vm.loadingModal('formjadwalkontrol');
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'addpaket') {
				vm.$refs.FormPaket.hide();
				vm.loadingModal('formpaket');
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 125, this); 
			}
			else if (vm.position == 'loaddata') {
				vm.$refs.FormUnit.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'loaddataobat') {
				vm.$refs.FormObat.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'loaddataresep') {
				vm.$refs.FormResep.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'loaddatajadwalkontrol') {
				vm.$refs.FormJadwalKontrol.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'loaddatapaket') {
				vm.$refs.FormPaket.setdataform(response); 
				active = 0; 
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formunit');
				vm.$refs.FormUnit.hide(); 
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'removedata') { 
				vm.$refs.FormUnit.setdataform(response);
			}
			else if (vm.position == 'removedataobat') { 
				vm.$refs.FormObat.setdataform(response);
			}
			else if (vm.position == 'removedataresep') { 
				vm.$refs.FormResep.setdataform(response);
			}
			else if (vm.position == 'pulang') {
				vm.loadingModal('formpulang');
				vm.$refs.FormPulang.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'detailpulangdata') {
				vm.$refs.FormDetailPulang.setdataform(response);
				vm.position = "updatedpulangdata";
				active = 0;
			}
			else if (vm.position == 'updatepulangdata') {
				vm.loadingModal('formdetailpulang');
				vm.$refs.FormDetailPulang.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'updatepulang') {
				vm.loadingModal('formdetailpulang');
				vm.$refs.FormDetailPulang.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			// else if (vm.position == 'pulangdata') { 
			// 	setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 125, this); 
			// }
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'adddataobat') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'adddataresep') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'addjadwalkontrol') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'addpaket') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'loaddata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddataobat') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddataresep') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddatapaket') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedataobat') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'removedataresep') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
				else if (vm.position == 'pulang') { vm.notification('Pemulangan data pasien gagal diproses.', 3000, position); }
				else if (vm.position == 'updatepulangdata') { vm.notification('Penambahan/Pembaharuan data gagal diproses.', 3000, position); }

			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'adddataobat') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'adddataresep') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'addjadwalkontrol') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'addpaket') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedataobat') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedataresep') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }
				// else if (vm.position == 'pulangdata') { vm.notification('Pemulangan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'pulang') { vm.notification('Pemulangan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatepulangdata') { vm.notification('Penambahan/Pembaharuan berhasil diproses.', 3000, position); }


			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'adddata') { vm.loadingModal('formunit'); }
			else if (posisi == 'removedata') { vm.loadingModal('formunit');  }
			else if (posisi == 'adddataobat') { vm.loadingModal('formobat'); }
			else if (posisi == 'formresep') { vm.loadingModal('formresep'); }
			else if (posisi == 'formkontrol') { vm.loadingModal('formjadwalkontrol'); }
			else if (posisi == 'formpaket') { vm.loadingModal('formpaket'); }
			else if (posisi == 'removedataobat') { vm.loadingModal('formobat');  }
			else if (posisi == 'removedataresep') { vm.loadingModal('formresep');  }
			// else if (posisi == 'pulangdata') { vm.$refs.Datatable.skeleton(); }
			// else if (posisi == 'pulangdata') { vm.loadingModal('formpulang'); }

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
