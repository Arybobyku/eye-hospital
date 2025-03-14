<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-besar"
			:class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Halaman Registrasi</h2>
			</div>
			<div class="modal-body">

				<div class="grid">

					<div class="col-4">
						<table class="table">
							<tbody>
								<tr>
									<td>No Rekam Medis</td>
									<td><strong>{{ detail.rekam_medis }}</strong></td>
								</tr>
								<tr>
									<td>Nama Lengkap</td>
									<td><strong>{{ detail.nama }}</strong></td>
								</tr>
								<tr>
									<td>Tempat, Tanggal Lahir</td>
									<td><strong>{{ detail.tempat_lahir }}, {{ datename(detail.tanggal_lahir) }}</strong>
									</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td><strong>{{ detail.jenis_kelamin }}</strong></td>
								</tr>
								<tr>
									<td>Golongan Darah</td>
									<td><strong>{{ detail.golongan_darah }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-4 form-ml">
						<table class="table">
							<tbody>
								<tr>
									<td>Jenis Identitas</td>
									<td><strong>{{ detail.jenis_identitas }}</strong></td>
								</tr>
								<tr>
									<td>Nomor Identitas</td>
									<td><strong>{{ detail.no_identitas }}</strong></td>
								</tr>
								<tr>
									<td>Nomor Handphone</td>
									<td><strong>{{ detail.no_handphone }}</strong></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><strong>{{ detail.email }}</strong></td>
								</tr>
								<tr>
									<td>Pekerjaan</td>
									<td><strong>{{ detail.pekerjaan }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-4 form-ml">
						<table class="table">
							<tbody>
								<tr>
									<td>Alamat</td>
									<td><strong>{{ detail.alamat }}</strong></td>
								</tr>
								<tr>
									<td>Provinsi</td>
									<td><strong>{{ detail.nama_provinsi }}</strong></td>
								</tr>
								<tr>
									<td>Kabupaten/Kota</td>
									<td><strong>{{ detail.nama_kab_kota }}</strong></td>
								</tr>
								<tr>
									<td>Kecamatan</td>
									<td><strong>{{ detail.nama_kecamatan }}</strong></td>
								</tr>
								<tr>
									<td>Kelurahan</td>
									<td><strong>{{ detail.nama_kelurahan }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>


					<div class="col-12">

						<div class="tab-lines">
							<div class="tab">
								<button v-for="(item, index) in tab.button" :class="item.class"
									v-on:click="changesTab(item.value, index, item.class)">
									{{ item.label }}
								</button>
							</div>
						</div>

						<div class="tab-content">

							<!-- Bagian tab content untuk data histori -->
							<div class="content-tab-in" v-if="tab.content.histori">
								<HistoriRegistrasi ref="HistoriRegistrasi" :histori="histori"></HistoriRegistrasi>
							</div>

							<!-- Bagian tab content untuk data rawatjalan -->
							<div class="content-tab-in" v-if="tab.content.rawatjalan">
								<FormRawatJalan ref="FormRawatJalan" @dialog="dialog" @cancel="cancel" @edit="edit"
									:poliBpjs="poliBpjs" @parsingForm="parsingForm" :detail="detail" :iskunjungan="iskunjungan">
								</FormRawatJalan>

							</div>

						</div>

					</div>
				</div>
			</div>

			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
var vm, body;
import { defineAsyncComponent } from 'vue';
import { datename, nullAndZero } from '../../../module/Manipulation.js';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Swal from 'sweetalert2';
export default {
	emits: ["mainreload"],
	components: { toast, Swal, 
		HistoriRegistrasi: defineAsyncComponent(() => import('./HistoriRegistrasi.vue')), 
		FormRawatJalan: defineAsyncComponent(() => import('./FormRawatJalan.vue')), 
	},
	mounted:function() { vm = this; body = document.body;
		// this.fetchPoliBpjs();
		// this.fetchPoliBpjs(); // Pastikan data diambil saat komponen dimuat
		// console.log("Data poliBpjs di main.vue sebelum dikirim:", this.poliBpjs);
	 },
	created:function() { this.item = this.modal },
	data:function() { return { 

		attach: {
			link : {
				rawatjalan: '/customerservices/pasien/registrasi/rawatjalan',
				editrawatjalan: '/customerservices/pasien/registrasi/editrawatjalan',
				cancelrawatjalan: '/customerservices/pasien/registrasi/cancelrawatjalan',
				rawatinap: '/customerservices/pasien/registrasi/rawatinap',
				bedah: '/customerservices/pasien/registrasi/bedah',
			}, url: '', data: null
		},
		terminate_detail: { show: false, display: 'display: none' },
		detail : { uuid: '',
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: ''
		},
		histori: [],
		iskunjungan: null, pj: null,
		tab: {
			button: [
				{ value: 'histori', label: 'Histori', class: 'tab-active' },
				{ value: 'rawatjalan', label: 'Registrasi', class: 'tab-no-active' },
				// { value: 'pembelianobatkhusus', label: 'Pembelian Obat Khusus', class: 'tab-no-active' },
				// { value: 'operasi', label: 'Operasi/Bedah', class: 'tab-no-active' },
			],
			content: { histori: true, rawatjalan: false, 
				// pembelianobatkhusus: false 
			}
		},
		
		position: '',
		selectedPoli: "", // Untuk menyimpan nilai yang dipilih
		poliBpjs: [] // Data poli_bpjs dari API
	}},

	methods: {

		datename, nullAndZero,

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
			}

			if (values == 'rawatjalan') {
				
				if (vm.iskunjungan) { 
					setTimeout(() => {
						vm.$refs.FormRawatJalan.seteditedv2(vm.iskunjungan, vm.pj, true);
					}, 500);
				}
				else {
					setTimeout(() => {
						vm.$refs.FormRawatJalan.seteditedv3(false);
					}, 500);
				}
			}

			
		},

		show:function(){ 
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; 
				vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content.histori = true;

			body.style.overflowY = 'hidden';
			vm.terminate_detail.display = 'display: block';
			vm.terminate_detail.show = true;
    },

		hide:function() {
			vm.terminate_detail.show = false;
			setTimeout(function() {
				vm.terminate_detail.display = 'display: none';
				body.style.overflowY = 'auto';
			}, 250, this);
		},

		mainreload:function() {
			vm.$emit('mainreload', 'main');
		},

		edit:function(data, position) {
			if (position == 'rawatjalan') {
				if (data) {
					vm.attach.data = new FormData();
					vm.attach.data.append('uuid', data.uuid);
					vm.attach.url = vm.attach.link.editrawatjalan;
					vm.position = 'editrawatjalan';
					vm.loaderprocess();
					vm.executions();
				}
			}
		},

		cancel:function(data, position) {
			if (position == 'rawatjalan') {
				if (data) {
					vm.attach.data = new FormData();
					vm.attach.data.append('uuid', data.uuid);
					vm.attach.url = vm.attach.link.cancelrawatjalan;
					vm.position = 'cancelrawatjalan';
					vm.dialog('Yakin ingin membatalkan kunjungan pasien', 'Ya, batalkan kunjungan', vm.position)
				}
			}
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'rawatjalan') { vm.attach.url = vm.attach.link.rawatjalan; } 
			else if (key == 'rawatinap') { vm.attach.url = vm.attach.link.rawatinap; } 
			else if (key == 'bedah') { vm.attach.url = vm.attach.link.bedah; } 
		},

		loaderprocess:function() { const left = this.$refs.rootdetail.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 0); },

		/*************************************************************************************************************************
		* Bagian fungsi untuk pemrosesan message, fungsi untuk error dan success
		*************************************************************************************************************************/

		gagal: function (error) {
			if (vm.$debugs) { console.log(error.response); } let active = 0;
			vm.message('error', 1);
			vm.loaderprocess();
			if (vm.position == 'rawatjalan') { }
			else if (vm.position == 'editrawatjalan') { }
			else if (vm.position == 'rawatinap') { }
			else if (vm.position == 'bedah') { }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			vm.loaderprocess();
			if (vm.position == 'rawatjalan') { 
				vm.iskunjungan = response.data.kunjungan; 
				if (response.data.pj != '') {
					vm.pj = response.data.pj;
				}
				vm.hide();  
				vm.mainreload(); 
			}
			else if (vm.position == 'editrawatjalan') { vm.$refs.FormRawatJalan.setedited(response, true);  }
			else if (vm.position == 'cancelrawatjalan') { vm.$refs.FormRawatJalan.resetform(); vm.hide(); vm.mainreload(); vm.iskunjungan = null; vm.pj = null;  }
			else if (vm.position == 'rawatinap') { }
			else if (vm.position == 'bedah') { }
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'rawatjalan') { vm.notification('Gagal memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'editrawatjalan') { vm.notification('Gagal memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'cancelrawatjalan') { vm.notification('Gagal memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'rawatinap') { vm.notification('Gagal memproses pasien rawat inap.', 3000, position); }
				else if (vm.position == 'bedah') { vm.notification('Gagal memproses pasien ke ruangan bedah.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'rawatjalan') { vm.notification('Berhasil memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'cancelrawatjalan') { vm.notification('Berhasil memproses pembatalan pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'rawatinap') { vm.notification('Berhasil memproses pasien rawat inap.', 3000, position); }
				else if (vm.position == 'bedah') { vm.notification('Berhasil memproses pasien ke ruangan bedah.', 3000, position); }
			}
		},

		runconfirm: function (posisi) { 
			vm.position = posisi; 
			vm.loaderprocess(); 
			vm.executions(); },

		/*************************************************************************************************************************
		* Bagian fungsi yang wajib disertakan disetiap index dan tidak perlu diubah-ubah
		*************************************************************************************************************************/
		executions: function () { axios.post(vm.attach.url, vm.attach.data, { headers: { 'Content-Type': 'multipart/form-data' } }).then(function (response) { if (response.data.data == '419') { window.location.href = '/masuk'; } setTimeout(function(){ vm.berhasil(response); }, 750, this); }).catch(function (error){ setTimeout(function(){ vm.gagal(error); }, 750, this); }); },
		dialog: function (_text, _confirm, posisi) { Swal.fire({ title:"Apakah Anda Yakin?", text:_text, icon:"warning", showCancelButton:!0, confirmButtonColor:"#1c84ee", cancelButtonColor:"#fd625e", confirmButtonText: _confirm, cancelButtonText:"Tidak, batal!" }).then(function(e){ if (e.isConfirmed) { vm.runconfirm(posisi); } }); },
		notification: function (message, timer, position) { if (position == 'error') { toast.error(message, { rtl: false, autoClose: timer }); } else { toast.success(message, { rtl: false, autoClose: timer }); } },

		setdataform: function (response) {
			let data = response.data.data;
			vm.histori = response.data.registrasi;
			vm.iskunjungan = response.data.kunjungan;
			vm.poliBpjs = response.data.poli_bpjs?.response?.filter(poli => poli.kdpoli === "MAT") || [];

			console.log("vm.poliBpjs", vm.poliBpjs);

			if (vm.iskunjungan) {
				console.log(vm.iskunjungan.status, 'sfsddsfdddsfdf')
				if (vm.iskunjungan.status == 'Rawat Inap') {
					alert('dfd');
					vm.tab = {
						button: [
							{ value: 'histori', label: 'Histori', class: 'tab-active' },
						],
						content: { histori: true }
					}
				}
				else {
					vm.tab = {
						button: [
							{ value: 'histori', label: 'Histori', class: 'tab-active' },
							{ value: 'rawatjalan', label: 'Registrasi', class: 'tab-no-active' },
						],
						content: { histori: true, rawatjalan: false }
					}
				}
			}

			if (response.data.pj != '') {
				vm.pj = response.data.pj;
			}
			
			vm.detail.uuid = data.uuid;
			vm.detail.agama = data.agama; vm.detail.alamat = data.alamat; vm.detail.alias = vm.empty(data.alias);
			vm.detail.email = vm.empty(data.email); vm.detail.golongan_darah = vm.empty(data.golongan_darah);
			vm.detail.jenis_identitas = data.jenis_identitas; vm.detail.jenis_kelamin = data.jenis_kelamin;
			vm.detail.kodepos = vm.empty(data.kodepos); vm.detail.nama = data.nama;
			vm.detail.nama_ayah = vm.empty(data.nama_ayah); vm.detail.nama_ibu = vm.empty(data.nama_ibu);
			vm.detail.nama_kab_kota = data.nama_kab_kota; vm.detail.nama_kecamatan = data.nama_kecamatan;
			vm.detail.nama_kelurahan = data.nama_kelurahan; vm.detail.nama_provinsi = data.nama_provinsi;
			vm.detail.no_handphone = vm.empty(data.no_handphone); vm.detail.no_identitas = data.no_identitas;
			vm.detail.pekerjaan = vm.empty(data.pekerjaan); vm.detail.pendidikan_terakhir = vm.empty(data.pendidikan_terakhir);
			vm.detail.rekam_medis = data.rekam_medis; vm.detail.rt_rw = vm.empty(data.rt_rw); vm.detail.status_pernikahan = vm.empty(data.status_pernikahan);
			vm.detail.tanggal_lahir = data.tanggal_lahir; vm.detail.tempat_lahir = data.tempat_lahir;
			vm.loaderprocess();
		},
		empty: function (data) {
			if (!data || data == '' || data == '-' || data == '0') { return '-'; }
			else { return data; }
		},
	}
}
</script>