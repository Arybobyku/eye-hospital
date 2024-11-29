<template>
	<div class="inner" ref="roottable">
		<div class="tab-lines">
			<div class="tab"><button v-for="(item, index) in tab.button" :class="item.class"
					v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div>
		</div>
		<div class="tab-content">
			<div class="content-tab-in" v-if="tab.content.now">
				<Datatable ref="Datatable" :module="module" @tablereload="tablereload" @tablebutton="tablebutton">
				</Datatable>
			</div>

		</div>
		<Loader ref="Loader"></Loader>
	</div>
	<FormUnit ref="FormDetail" @dialog="dialog" @parsingForm="parsingForm"></FormUnit>
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
	beforeUnmount: function () { },
	components: {
		toast, Swal,
		Datatable: defineAsyncComponent(() => import('../../../section/Datatable.vue')),
	},
	created: function () { },
	mounted: function () {
		vm = this;
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.loadmain();
	},
	data: function () {
		return {
			uri: 'unit',
			position: '',
			attach: {
				link: {
					list: '/bedah/pasien/list',
					edit: '/antrol/tempattidur/edit',

				}, url: '', data: null
			},
			column: [
				{ value: 'kode_booking', label: 'Kode Booking', type: 'text', search: true, close: false, button: false },
				// { value: 'waktu', label: 'Waktu', type: 'text', search: true, close: false, button: false },
				{ value: 'rekam_medis', label: 'Tanggal', type: 'text', search: true, close: false, button: false },
				{ value: 'nama_pasien', label: 'Nomor Kartu', type: 'text', search: true, close: false, button: false },
				{ value: 'nama_dokter', label: 'Nama', type: 'text', search: true, close: false, button: false },
				{ value: 'nama_dokter_bedah', label: 'Status', type: 'text', search: false, close: false, button: false },
				{ value: 'nama_paket_bedah', label: 'Paket Bedah', type: 'text', search: true, close: false, button: false },
				// { value: 'btnhtml', label: '', type: 'text', search: false, close: false, button: false }
			],
			module: { data: [], column: [], total: 0, ispaging: true },
			tab: {
				button: [
					{ value: 'now', label: 'Data', class: 'tab-active' },
				],
				content: {
					now: true,
					done: false,
				}
			},
			posisieksternal: 'now'
		}
	},
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

		btnhtml: function (_item, _index) {
			let str = [
				{
					icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Edit', item: _item, index: _index,
					show: true
				},
				{
					icon: 'arrow-up', color: 'btn-success', posisi: 'detail', tooltip: 'Hapus', item: _item, index: _index,
					show: true
				},

			]
			return str;
		},

		jenisos: function (data) {
			if (data.jenis == 'One Day Care') { return 'One Day Care'; }
			return 'Rawat Inap';
		},

		bedahstatus: function (data) {
			if (data.bedah_status == '-') { return '<div class="badge badge-danger">Menunggu</div>'; }
			return '<div class="badge badge-success">' + data.bedah_status + '</div>'
		},
		waktuMasuk: function (data) {
			if (data.waktu_masuk_inap == '') {
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
			}
		},

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

		tablebutton: function (posisi, data, index) {
			console.log("POSISI aturulang");
			console.log(posisi);
			if (posisi == 'detaildokter') {
				vm.$refs.FormDetailDokter.aturulang();
				vm.position = "detaildokterdata";
				vm.$refs.FormDetailDokter.show('detaildokterdata', 'Dokter Bedah', data.uuid);
				setTimeout(() => { vm.loadingModal('formdetaildokter'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.detaildokter;
				vm.executions();
			}
			else if (posisi == 'proses') {
				vm.position = "prosesdata";
				vm.attach.data = new FormData();
				console.log(data);
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
				vm.attach.data.append('jenis', data.jenis);
				vm.attach.url = vm.attach.link.proses;
				vm.dialog('Yakin ingin memproses dan melakukan pembedahan pada pasien ini.', 'Ya, proses pembedahan', 'prosesdata');
			}
			else if (posisi == 'selesai') {
				vm.position = "selesaidata";
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('jenis', data.jenis);
				console.log(data);
				vm.attach.url = vm.attach.link.selesai;
				vm.dialog('Yakin ingin sudah selesai melakukan pembedahan pada pasien ini.', 'Ya, selesai pembedahan', 'selesaidata');
			}
			else if (posisi == 'detail') {
				vm.position = "detaildata";
				vm.$refs.FormDetail.show('detaildata', 'Detail Paket Data', data.uuid);
				setTimeout(() => { vm.loadingModal('detaildata'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('jenis', data.jenis);
				vm.attach.url = vm.attach.link.detail;
				vm.executions();
			}
			else if (posisi == 'inap') {
				vm.position = "inapdata";
				vm.$refs.FormInap.show('inapdata', 'Tambah Rawat Inap', data.uuid);
				setTimeout(() => { vm.loadingModal('inapdata'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.inap;
				vm.executions();
			}
			else if (posisi == 'inapdata') {
				vm.position = "inapdata";
				vm.$refs.FormInap.show('inapdata', 'Tambah Rawat Inap', data.uuid);
				setTimeout(() => { vm.loadingModal('inapdata'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.url = vm.attach.link.inap;
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
			else if (posisi == 'add') {
				vm.$refs.FormUnit.aturulang();
				vm.position = "loaddata";
				vm.$refs.FormUnit.show('loaddata', 'Penambahan Data Tindakan', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formunit'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
				vm.attach.data.append('uuid', data.uuid);
				vm.attach.data.append('jenis', data.jenis);
				vm.attach.url = vm.attach.link.getlayanan;
				vm.executions();
			}
			// else if (posisi == 'inapadd') {
			// 	console.log("INAP ADD");
			// 	vm.$refs.FormInap.aturulang();
			// 	vm.position = "inapadd";
			// 	vm.$refs.FormInap.show('inapadd', 'Penambahan Kamar Inap', data.uuid, data);
			// 	setTimeout(() => { vm.loadingModal('inapdata'); }, 250, this);
			// 	vm.attach.data = new FormData();
			// 	vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
			// 	vm.attach.data.append('uuid', data.uuid);
			// 	vm.attach.url = vm.attach.link.inapadd;
			// 	vm.executions();
			// }
			else if (posisi == 'obat') {
				vm.$refs.FormObat.aturulang();
				vm.position = "loaddataobat";
				vm.$refs.FormObat.show('loaddataobat', 'Data obat yang dibawa pulang', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formobat'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
				vm.attach.data.append('jenis', data.jenis);
				vm.attach.url = vm.attach.link.getobat;
				vm.executions();
			}
			else if (posisi == 'resep') {
				vm.$refs.FormResep.aturulang();
				vm.position = "loaddataresep";
				vm.$refs.FormResep.show('loaddataresep', 'Data obat yang dibawa pulang', data.uuid, data);
				console.log("uuid");
				console.log(data.uuid);
				setTimeout(() => { vm.loadingModal('formresep'); }, 250, this);
				vm.attach.data = new FormData();
				// vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
				vm.attach.data.append('uuid', data.uuid);

				vm.attach.data.append('jenis', data.jenis);
				vm.attach.url = vm.attach.link.getresep;
				vm.executions();
			}
			else if (posisi == 'jadwalkontrol') {
				vm.$refs.FormJadwalKontrol.aturulang();
				vm.position = "loaddatajadwalkontrol";
				vm.$refs.FormJadwalKontrol.show('loaddatajadwalkontrol', 'Data obat yang dibawa pulang', data.uuid, data);
				setTimeout(() => { vm.loadingModal('formjadwalkontrol'); }, 250, this);
				vm.attach.data = new FormData();
				vm.attach.data.append('registrasi_uuid', data.registrasi_uuid);
				vm.attach.data.append('jenis', data.jenis);
				vm.attach.url = vm.attach.link.getjadwalkontrol;
				vm.executions();
			}
		},

		loadingModal: function (position) {
			console.log("position loadingmodal")
			console.log(position)
			if (position == 'formunit') { vm.$refs.FormUnit.loaderprocess(); }
			else if (position == 'formobat') { vm.$refs.FormObat.loaderprocess(); }
			else if (position == 'formresep') { vm.$refs.FormResep.loaderprocess(); }
			else if (position == 'formjadwalkontrol') { vm.$refs.FormJadwalKontrol.loaderprocess(); }
			else if (position == 'detaildata') { vm.$refs.FormDetail.loaderprocess(); }
			else if (position == 'formdetaildokter') { vm.$refs.FormDetailDokter.loaderprocess(); }
			else if (position == 'detaildokterdata') { vm.$refs.FormDetailDokter.loaderprocess(); }
			else if (position == 'inapdata') { vm.$refs.FormInap.loaderprocess(); }
			else if (position == 'formhistori') { vm.$refs.FormHistori.loaderprocess(); }
			else if (position == 'formhistoridokter') { vm.$refs.FormHistoriDokter.loaderprocess(); }
		},

		parsingForm: function (data, key) {
			vm.attach.data = data;
			console.log('key');
			console.log(key);
			if (key == 'add') {
				vm.position = 'adddata';
				vm.attach.url = vm.attach.link.add;
			}
			else if (key == 'adddokter') {
				vm.position = 'updatedokterdata'; vm.attach.url = vm.attach.link.adddokter;
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
			else if (key == 'removeobat') {
				vm.position = 'removedataobat';
				vm.attach.url = vm.attach.link.removeobat;
			}
			else if (key == 'removeresep') {
				vm.position = 'removeresep';
				vm.attach.url = vm.attach.link.removeresep;
			}
			else if (key == 'inapadd') {
				vm.position = 'inapadd';
				vm.attach.url = vm.attach.link.inapadd;
			}
		},

		setDatatable: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.column.length; j++) { col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] : vm.column[j].value, vm.column[j].value)); } temporer.push(col); } vm.module.data = temporer; vm.module.total = total; return temporer; },
		setDatatabledone: function (data, total) { let temporer = [], col = []; for (let i = 0; i < data.length; i++) { col = []; for (let j = 0; j < vm.columndone.length; j++) { col.push(vm.converterdone(data[i], i, data[i][vm.columndone[j].value] ? data[i][vm.columndone[j].value] : vm.columndone[j].value, vm.columndone[j].value)); } temporer.push(col); } vm.moduledone.data = temporer; vm.moduledone.total = total; return temporer; },
		tableload: function (pos = 'main') {

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
		tablereload: function (data = new FormData(), pos = 'main') {
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

		loaddone: function () {
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
				if (vm.posisieksternal = 'done') {
					vm.$refs.DatatableDone.skeleton();
					vm.$refs.DatatableDone.backpage();
				}
				else {
					vm.$refs.Datatable.skeleton();
					vm.$refs.Datatable.backpage();
				}
			}
			else if (vm.position == 'adddata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'adddataobat') { vm.loadingModal('formobat'); }
			else if (vm.position == 'adddataresep') { vm.loadingModal('formresep'); }
			else if (vm.position == 'addjadwalkontrol') { vm.loadingModal('formjadwalkontrol'); }
			else if (vm.position == 'loaddata') { vm.loadingModal('formunit'); vm.$refs.FormUnit.hide(); }
			else if (vm.position == 'loaddataobat') { vm.loadingModal('formobat'); vm.$refs.FormObat.hide(); }
			else if (vm.position == 'loaddataresep') { vm.loadingModal('formresep'); vm.$refs.FormResep.hide(); }
			else if (vm.position == 'editdata') { vm.loadingModal('formunit'); vm.$refs.FormUnit.hide(); }
			else if (vm.position == 'updatedata') { vm.loadingModal('formunit'); }
			else if (vm.position == 'updatedokterdata') { vm.loadingModal('formdetaildokter'); }

			else if (vm.position == 'prosesdata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'selesaidata') { vm.$refs.Datatable.skeleton(); }
			else if (vm.position == 'historidata') { vm.loadingModal('formhistori'); vm.$refs.FormHistori.hide(); }
			else if (vm.position == 'historidokter') { vm.loadingModal('formhistoridokter'); vm.$refs.FormHistoriDokter.hide(); }
			else if (vm.position == 'removedata') { vm.loadingModal('formunit'); }

			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function () { vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			console.log("posisiberhasil");
			console.log(vm.position);
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }

			if (vm.position == 'loadmain') {
				vm.posisieksternal = 'now';
				vm.firstloader();
				vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.data, response.data.total), response.data.total);
				vm.$refs.Datatable.paging();
				active = 0;
			}
			else if (vm.position == 'loaddone') {
				vm.posisieksternal = 'done';
				vm.firstloader();
				vm.$refs.DatatableDone.update(vm.columndone, vm.setDatatabledone(response.data.data, response.data.total), response.data.total);
				vm.$refs.DatatableDone.paging();
				active = 0;
			}
			else if (vm.position == 'externaltable') {

				if (vm.posisieksternal == 'done') {
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
			else if (vm.position == 'updatedokterdata') {
				vm.$refs.FormDetailDokter.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'adddata') {
				vm.$refs.FormUnit.setdataform(response);
			}
			else if (vm.position == 'removedata') {
				vm.$refs.FormUnit.setdataform(response);
			}
			else if (vm.position == 'adddataobat') {
				vm.$refs.FormObat.setdataform(response);
			}
			else if (vm.position == 'adddataresep') {
				//vm.$refs.FormResep.setdataform(response);
				vm.loadingModal('formresep'); vm.$refs.FormResep.hide();
			}
			else if (vm.position == 'addjadwalkontrol') {
				vm.$refs.FormJadwalKontrol.hide();
				vm.loadingModal('formjadwalkontrol');
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
				active = 0; w
			}
			else if (vm.position == 'editdata') {
				vm.$refs.FormUnit.setdataform(response);
				vm.position = "updatedata";
				active = 0;
			}
			else if (vm.position == 'detaildata') {
				vm.$refs.FormDetail.setdataform(response);
				vm.position = "detaildata";
				active = 0;
			}
			else if (vm.position == 'detaildokterdata') {
				vm.$refs.FormDetailDokter.setdataform(response);
				vm.position = "updatedokterdata";
				active = 0;
			}
			else if (vm.position == 'inapdata') {
				vm.$refs.FormInap.setdataform(response);
				vm.position = "inapdata";
				active = 0;
			}
			else if (vm.position == 'updatedata') {
				vm.loadingModal('formunit');
				vm.$refs.FormUnit.hide();
				setTimeout(() => { vm.$refs.Datatable.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'inapadd') {
				vm.$refs.FormInap.hide();
				setTimeout(() => { vm.$refs.DatatableDone.skeleton(); vm.tablereload(); }, 500, this);
			}
			else if (vm.position == 'prosesdata') {
				setTimeout(() => { vm.tablereload(); }, 125, this);
			}
			else if (vm.position == 'selesaidata') {
				setTimeout(() => { vm.tablereload(); }, 125, this);
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
			vm.message('success', active);
		},

		message: function (position, active) {
			console.log("position msg");
			console.log(position);
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'loaddone') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'externaltable') { vm.notification('Datalist tabel gagal dimuat.', 3000, position); }
				else if (vm.position == 'adddata') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'inapadd') { vm.notification('Penambahan Kamar Inap gagal diproses.', 3000, position); }
				else if (vm.position == 'adddataobat') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'adddataresep') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'addjadwalkontrol') { vm.notification('Penambahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'loaddata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddataobat') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddataresep') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'loaddatajadwalkontrol') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'updatedokterdata') { vm.notification('Penambahan/Pembaharuan data gagal diproses.', 3000, position); }

				else if (vm.position == 'prosesdata') { vm.notification('Proses perubahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'selesaidata') { vm.notification('Proses perubahan data gagal diproses.', 3000, position); }
				else if (vm.position == 'historidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'historidokter') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'adddata') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				if (vm.position == 'updatedokterdata') { vm.notification('Penambahan/Pembaharuan data berhasil diproses.', 3000, position); }

				else if (vm.position == 'inapadd') { vm.notification('Penambahan Kamar Inap berhasil diproses.', 3000, position); }
				else if (vm.position == 'adddataobat') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'adddataresep') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'addjadwalkontrol') { vm.notification('Penambahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'prosesdata') { vm.notification('Perusahan perubahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'selesaidata') { vm.notification('Perusahan perubahan data berhasil diproses.', 3000, position); }
				else if (vm.position == 'removedata') { vm.notification('Penghapusan data berhasil diproses.', 3000, position); }

			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'adddata') { vm.loadingModal('formunit'); }
			else if (posisi == 'removedata') { vm.loadingModal('formunit'); }
			else if (posisi == 'adddataobat') { vm.loadingModal('formobat'); }
			else if (posisi == 'formresep') { vm.loadingModal('formresep'); }
			else if (posisi == 'formkontrol') { vm.loadingModal('formjadwalkontrol'); }
			else if (posisi == 'removedataobat') { vm.loadingModal('formobat'); }
			else if (posisi == 'removedataresep') { vm.loadingModal('formresep'); }
			else if (posisi == 'prosesdata') { vm.$refs.Datatable.skeleton(); }
			else if (posisi == 'selesaidata') { vm.$refs.Datatable.skeleton(); }
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
		titletrigger: function () { let title = vm.$router.currentRoute._value.meta.title; vm.$emit('titletrigger', title); }
	}
}
</script>
