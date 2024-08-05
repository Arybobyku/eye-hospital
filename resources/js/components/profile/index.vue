<template>	
<div class="inner" ref="roottable">
	<div class="grid">
		<div class="col-2">
			<div class="foto-profile">
				<img src="/images/no-image.png" />
			</div>
			<table class="table-info">
				<tr>
					<td>Tanda Tangan Digital</td> 
					<td><strong>{{ datacomponent?.pengguna?.ttd  ? "Ada" : "Tidak Ada" }}</strong></td>
				</tr>
			</table>
		</div>
		<div class="col-5 margin-custom" v-if="datacomponent">
			<table class="table-info">
				<tr>
					<td>Nama Lengkap</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.nama_pengguna) }}</strong></td>
				</tr>
				<tr>
					<td>Username</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.username_pengguna) }}</strong></td>
				</tr>
				<tr>
					<td>Tempat, Tanggal Lahir</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.tempat_lahir) }}, {{ datename(nullAndZero(datacomponent.pengguna.tanggal_lahir)) }}</strong></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.jenis_kelamin) }}</strong></td>
				</tr>
				<tr>
					<td>Agama</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.agama) }}</strong></td>
				</tr>
			</table>
		</div>
		<div class="col-5 margin-custom" v-if="datacomponent">
			<table class="table-info">
				<tr>
					<td>Mulai Masuk Kerja</td>
					<td><strong>{{ datename(nullAndZero(datacomponent.pengguna.mulai_bekerja)) }}</strong></td>
				</tr>
				<tr>
					<td>BPJS Ketenagakerjaan</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.bpjs_ketenagakerjaan) }}</strong></td>
				</tr>
				<tr>
					<td>Posisi sebagai</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.sebagai_pengguna) }}</strong></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.status) }}</strong></td>
				</tr>
				<tr>
					<td>Nomor Handphone</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.no_handphone) }}</strong></td>
				</tr>
				<tr>
					<td>Tanda Tangan Digital</td>
					<td><strong>{{ nullAndZero(datacomponent.pengguna.ttd) ? "Ada" : "Tidak Ada" }}</strong></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="tab-lines" v-if="datacomponent">
		<div class="tab">
			<button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item, index)">{{ item.label }}</button>
		</div>
		<div class="action">
			<button v-on:click="editdata()">Edit Profile</button>
			<button v-on:click="password()">Ganti Password</button>
		</div>
	</div>

	<div class="tab-content" v-if="datacomponent">
		<div class="content-tab-in" v-if="tab.content.histori">
			<Datatable ref="Datatable" :module="module"></Datatable>
		</div>

		<div class="content-tab-in" v-if="tab.content.datalainnya">
			<div class="grid">
				<div class="col-6 margin-custom">
					<table class="table-info">
						<tr>
							<th colspan="2">Kontak Darurat</th>
						</tr>
						<tr>
							<td>No Handphone</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.darurat_no_handphone) }}</strong></td>
						</tr>
						<tr>
							<td>Nama Lengkap</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.darurat_nama) }}</strong></td>
						</tr>
						<tr>
							<td>Hubungan</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.darurat_hubungan) }}</strong></td>
						</tr>
					</table>

					<table class="table-info mt-16">
						<tr>
							<th colspan="2">Identitas</th>
						</tr>
						<tr>
							<td>KTP</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.ktp) }}</strong></td>
						</tr>
						<tr>
							<td>SIM A</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.sima) }}</strong></td>
						</tr>
						<tr>
							<td>SIM C</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.simc) }}</strong></td>
						</tr>
						<tr>
							<td>NPWP</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.npwp) }}</strong></td>
						</tr>
						<tr>
							<td>Paspor</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.paspor) }}</strong></td>
						</tr>
						<tr>
							<td>Status Pernikahan</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.status_pernikahan) }}</strong></td>
						</tr>
					</table>
				</div>
					
				<div class="col-6 margin-custom">
					<table class="table-info">
						<tr>
							<th colspan="2">Akun Bank</th>
						</tr>
						<tr>
							<td>Nomor Rekening</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.bank_norek) }}</strong></td>
						</tr>
						<tr>
							<td>Atas Nama</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.bank_an) }}</strong></td>
						</tr>
						<tr>
							<td>Nama Bank</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.bank_nama) }}</strong></td>
						</tr>
					</table>

					<table class="table-info mt-16">
						<tr>
							<th colspan="2">Data Alamat</th>
						</tr>
						<tr>
							<td>Email</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.email_pengguna) }}</strong></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.alamat) }}</strong></td>
						</tr>
						<tr>
							<td>Provinsi</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.nama_provinsi) }}</strong></td>
						</tr>
						<tr>
							<td>Kota/Kabupaten</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.nama_kab_kota) }}</strong></td>
						</tr>
						<tr>
							<td>Kecamatan</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.nama_kecamatan) }}</strong></td>
						</tr>
						<tr>
							<td>Kelurahan</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.nama_kelurahan) }}</strong></td>
						</tr>
						<tr>
							<td>Kode Pos</td>
							<td><strong>{{ nullAndZero(datacomponent.pengguna.kodepos) }}</strong></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<Loader ref="Loader"></Loader>
</div>

<FormPengguna ref="FormPengguna" v-if="datacomponent" @dialog="dialog" @parsingForm="parsingForm"></FormPengguna>
<FormPassword ref="FormPassword" v-if="datacomponent" @dialog="dialog" @parsingForm="parsingForm"></FormPassword>

</template>
	
<script>
var vm;
import { defineAsyncComponent } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
import { nullAndZero, datename } from '../../module/Manipulation.js';
	
export default {
	emits: ["titletrigger", "repatch"],
	beforeUnmount:function() {},
	components: { toast, Swal, 
		FormPengguna: defineAsyncComponent(() => import('./FormPengguna.vue')),
		FormPassword: defineAsyncComponent(() => import('./FormPassword.vue')),
		Datatable: defineAsyncComponent(() => import('../../section/Datatable.vue')),
	},
	created: function () {},
	mounted: function () {
		vm = this; 
		setTimeout(() => { this.titletrigger(); }, 250);
		vm.initdata();
		vm.loadmain();
	},
	data: function () { return {
		uri: 'profile',
		position: '',
		datacomponent: null,
		attach: {
			link : {
				data: '/profile/data',
				edit: '/profile/edit',
				update: '/profile/update',
				password: '/profile/password',
			}, url: '', data: null
		},
		tab: {
			button: [
				{ value: 'histori', label: 'Histori', class: 'tab-active' },
				{ value: 'datalainnya', label: 'Data Lainnya', class: 'tab-no-active' }
			],
			content: { histori: true, datalainnya: false, }
		},
		column: [
			{ value: 'created_at', label: 'Tanggal', type: 'text', search: false, close: false, button: false },
			{ value: 'sebagai', label: 'Sebagai', type: 'text', search: false, close: false, button: false },
			{ value: 'tindakan', label: 'Tindakan yang dilakukan', type: 'text', search: false, close: false, button: false }
		],
		module: { data: [], column: [], total: 0, ispaging: false },
	}},
	methods: {

		converter: function (data, index, column, identity) {
			let _tmp = '';
			if (identity == 'btnhtml') { _tmp = { value: vm.btnhtml(data, index), ishtml: 'button', show: false, style: 'width: 40px; text-align: center' } }
			else if (identity == 'created_at') { _tmp = { value: vm.datename(column, true), ishtml: 'html', style: '' }; }
			else { _tmp = { value: column, ishtml: 'text', style: '' } }
			return _tmp != '' ? _tmp : 'empty';
		},

		setDatatable: function (data, total) { 
			let temporer = [], col = []; 
			for (let i = 0; i < data.length; i++) { 
				col = []; 
				for (let j = 0; j < vm.column.length; j++) { 
					col.push(vm.converter(data[i], i, data[i][vm.column[j].value] ? data[i][vm.column[j].value] :vm.column[j].value, vm.column[j].value)); 
				} 
				temporer.push(col);
			}
			vm.module.data = temporer;
			vm.module.total = total;
			return temporer; 
		},

		changesTab: function (item, index) {
			if (item.class != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) {
					vm.tab.content[vm.tab.button[i].value] = false;
					vm.tab.button[i].class = 'tab-no-active';
				}

				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[item.value] = true;
			}
		},

		editdata: function () {
			vm.$refs.FormPengguna.aturulang()
			vm.position = "editdata";
			vm.$refs.FormPengguna.show('editdata', 'Edit Data');
			setTimeout(() => { vm.loadingModal('formpengguna'); }, 250, this);
			vm.attach.data = new FormData();
			vm.attach.data.append('pengguna_uuid', vm.datacomponent.pengguna.pengguna_uuid);
			vm.attach.url = vm.attach.link.edit;
			vm.executions();
		},

		password:function() {
			vm.$refs.FormPassword.aturulang();
			vm.position = "password";
			vm.$refs.FormPassword.show('password', 'Perbaharui Password', vm.datacomponent.pengguna.pengguna_uuid);
		},
		
		loadingModal: function (position) { 
			if (position == 'formpengguna') { vm.$refs.FormPengguna.loaderprocess();  }
			else if (position == 'formpassword') { vm.$refs.FormPassword.loaderprocess();  }
			
		},

		loadmain: () => {
			vm.position = 'loadmain'; 
			vm.firstloader(); 
			vm.attach.url = vm.attach.link.data;
			vm.attach.data = new FormData();
			vm.attach.data.append('kosong', '');
			vm.executions();
		},
		initdata: function () { 
			vm.datacomponent = { pengguna: null };
			vm.datacomponent.pengguna = {
				pengguna_uuid: '', nama_pengguna: '', username_pengguna: '', tempat_lahir: '', tanggal_lahir: '', jenis_kelamin: '', agama: '', 
				mulai_bekerja: '', bpjs_ketenagakerjaan: '', sebagai_pengguna: '', status: '', no_handphone: '', darurat_no_handphone: '', 
				darurat_nama: '', darurat_hubungan: '', ktp: '', sima: '', simc: '', npwp: '', paspor: '', status_pernikahan: '', 
				bank_norek: '', bank_an: '', bank_nama: '', email_pengguna: '', alamat: '', nama_provinsi: '', nama_kab_kota: '', 
				nama_kecamatan: '', nama_kelurahan: '', kodepos: ''
			} 
		},
		setdata: function (response, position) {
			if (position == 'pengguna') {
				window.localStorage.setItem("ttd", response.data.biodata.ttd);
				vm.datacomponent[position] = {
					pengguna_uuid: response.data.biodata.pengguna_uuid,
					nama_pengguna: response.data.biodata.nama_pengguna,
					username_pengguna: response.data.biodata.username_pengguna,
					ttd: response.data.biodata.ttd,
					tempat_lahir: response.data.biodata.tempat_lahir,
					tanggal_lahir: response.data.biodata.tanggal_lahir,
					jenis_kelamin: response.data.biodata.jenis_kelamin,
					agama: response.data.biodata.agama,
					mulai_bekerja: response.data.biodata.mulai_bekerja,
					bpjs_ketenagakerjaan: response.data.biodata.bpjs_ketenagakerjaan,
					sebagai_pengguna: response.data.biodata.sebagai_pengguna,
					status: response.data.biodata.status,
					no_handphone: response.data.biodata.no_handphone,
					darurat_no_handphone: response.data.biodata.darurat_no_handphone,
					darurat_nama: response.data.biodata.darurat_nama,
					darurat_hubungan: response.data.biodata.darurat_hubungan,
					ktp: response.data.biodata.ktp,
					sima: response.data.biodata.sima,
					simc: response.data.biodata.simc,
					npwp: response.data.biodata.npwp,
					paspor: response.data.biodata.paspor,
					status_pernikahan: response.data.biodata.status_pernikahan,
					bank_norek: response.data.biodata.bank_norek,
					bank_an: response.data.biodata.bank_an,
					bank_nama: response.data.biodata.bank_nama,
					email_pengguna: response.data.biodata.email_pengguna,
					alamat: response.data.biodata.alamat,
					nama_provinsi: response.data.biodata.nama_provinsi,
					nama_kab_kota: response.data.biodata.nama_kab_kota,
					nama_kecamatan: response.data.biodata.nama_kecamatan,
					nama_kelurahan: response.data.biodata.nama_kelurahan,
					kodepos: response.data.biodata.kodepos
				}
			}
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'pengguna') { if (vm.position == 'updatedata') { vm.attach.url = vm.attach.link.update; } }
			else if (key == 'password') { vm.attach.url = vm.attach.link.password; }
		},

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			if (vm.position == 'loadmain') { vm.firstloader(); active = 1; }
			else if (vm.position == 'editdata') { vm.loadingModal('formpengguna'); vm.$refs.FormPengguna.hide();  }
			else if (vm.position == 'updatedata') { vm.loadingModal('formpengguna'); }
			else if (vm.position == 'password') { vm.loadingModal('formpassword'); }
			
			/* Bagian ini tidak perlu diubah */
			if (active == 1) { setTimeout(function(){ vm.$router.push({ name: 'Error', params: { link: vm.name_vue } }) }, 250, this); }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (response.data.data == '403') { vm.$router.push('/dashboard/forbidden'); }

			if (response.data.hasil == 'wrong') { 
				vm.notification('Password lama yang anda masukkan salah.', 3000, 'error');
				vm.loadingModal('formpassword');
			}
			else if (response.data.hasil == 'notsame') { 
				vm.notification('Password baru dan konfirmasi password yang anda masukkan tidak sama.', 3000, 'error');
				vm.loadingModal('formpassword');
			}
			else {
				if (vm.position == 'loadmain') { 
					vm.firstloader();
					vm.setdata(response, 'pengguna');
					vm.$refs.Datatable.update(vm.column, vm.setDatatable(response.data.logpengguna, response.data.total), 0); 
					vm.$refs.Datatable.paging();
					
				}
				else if (vm.position == 'editdata') { 
					vm.loadingModal('formpengguna'); 
					vm.$refs.FormPengguna.setdata(response); 
					vm.position = "updatedata";
					active = 0; 
				}
				else if (vm.position == 'updatedata') {
					vm.loadingModal('formpengguna'); vm.initdata('formpengguna'); vm.$refs.FormPengguna.aturulang();
					vm.$refs.FormPengguna.hide(); setTimeout(() => { vm.loadmain(); }, 500, this);
				}
				else if (vm.position == 'password') {
					vm.loadingModal('formpassword'); vm.$refs.FormPassword.aturulang();
					vm.$refs.FormPassword.hide(); setTimeout(() => { vm.loadmain(); }, 500, this);
				}
				vm.message('success', active);
			}
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'loadmain') { vm.notification('Data gagal dimuat.', 3000, position); }
				else if (vm.position == 'editdata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
				else if (vm.position == 'updatedata') { vm.notification('Pembaharuan data gagal diproses.', 3000, position); }
				else if (vm.position == 'password') { vm.notification('Pembaharuan password gagal diproses.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'updatedata') { vm.notification('Pembaharuan data berhasil diproses.', 3000, position); }
				if (vm.position == 'password') { vm.notification('Pembaharuan password berhasil diproses.', 3000, position); }
			}
		},

		runconfirm: function (posisi) {
			if (posisi == 'formpengguna') { vm.loadingModal('formpengguna'); }
			else if (posisi == 'formpassword') { vm.loadingModal('formpassword'); }
			vm.executions();
		},

		/*************************************************************************************************************************
		* Bagian fungsi yang opsional untuk manipulasi data dan string
		*************************************************************************************************************************/
		nullAndZero, datename,

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