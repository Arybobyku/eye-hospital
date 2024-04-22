<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-besar" :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Registrasi Instalasi Gawat Darurat</h2>
			</div>
			<div class="modal-body">

				<div class="grid">
					<div class="col-3 form-mr">
						<ul class="list-detail">
							<li>No Rekam Medis<span><strong>{{ detail.rekam_medis }}</strong></span></li>
							<li>Nama Lengkap<span><strong>{{ detail.nama }}</strong></span></li>
							<li>Tempat, Tanggal Lahir<span><strong>{{ detail.tempat_lahir }}, {{ datename(detail.tanggal_lahir) }}</strong></span></li>
							<li>Jenis Kelamin<span><strong>{{ detail.jenis_kelamin }}</strong></span></li>
							<li>Jenis Identitas<span><strong>{{ detail.jenis_identitas }}</strong></span></li>
							<li>Nomor Identitas<span><strong>{{ detail.no_identitas }}</strong></span></li>
							<li>Nomor Handphone<span><strong>{{ detail.no_handphone }}</strong></span></li>
							<li>Email<span><strong>{{ detail.email }}</strong></span></li>
							<li>Pendidikan Terakhir<span><strong>{{ detail.pendidikan_terakhir }}</strong></span></li>
							<li>Alamat<span><strong>{{ detail.alamat }}</strong></span></li>
							<li>Provinsi<span><strong>{{ detail.nama_provinsi }}</strong></span></li>
							<li>Kabupaten/Kota<span><strong>{{ detail.nama_kab_kota }}</strong></span></li>
							<li>Kecamatan<span><strong>{{ detail.nama_kecamatan }}</strong></span></li>
							<li>Kelurahan<span><strong>{{ detail.nama_kelurahan }}</strong></span></li>
							<li>Pekerjaan<span><strong>{{ detail.pekerjaan }}</strong></span></li>
							<li>Golongan Darah<span><strong>{{ detail.golongan_darah }}</strong></span></li>
						</ul>
					</div>
					<div class="col-9 form-ml">
						
						<div class="tab-lines">
							<div class="tab">
								<button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">
									{{ item.label }}
								</button>
							</div>
						</div>
					
						<div class="tab-content">

							<!-- Bagian tab content untuk data histori -->
							<div class="content-tab-in" v-if="tab.content.histori">
								<HistoriRegistrasi ref="HistoriRegistrasi" :histori="histori"></HistoriRegistrasi>
							</div>

							<!-- Bagian tab content untuk data igd -->
							<div class="content-tab-in" v-if="tab.content.igd" >
								<FormIgd ref="FormIgd" @dialog="dialog" @cancel="cancel" @edit="edit" @parsingForm="parsingForm" :detail="detail" :iskunjungan="iskunjungan"></FormIgd>
								
							</div>

							<!-- Bagian tab content untuk data tindakan -->
							<div class="content-tab-in" v-if="tab.content.tindakan">
								
							</div>

							<!-- Bagian tab content untuk data obatobatan -->
							<div class="content-tab-in" v-if="tab.content.obatobatan">
								
							</div>

							<!-- Bagian tab content untuk data obatobatan racikan -->
							<div class="content-tab-in" v-if="tab.content.obatobatanracikan">
								
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
		FormIgd: defineAsyncComponent(() => import('./FormIgd.vue')), 
	},
	mounted:function() { vm = this; body = document.body; },
	created:function() { this.item = this.modal },
	data:function() { return { 
		datauuid: '',
		attach: {
			link : {
				igd: '/igd/pasien/registrasi/igd',
				editigd: '/igd/pasien/registrasi/editigd',
				canceligd: '/igd/pasien/registrasi/canceligd',
				rawatinap: '/igd/pasien/registrasi/rawatinap',
				bedah: '/igd/pasien/registrasi/bedah',
				registrasipage: '/igd/pasien/registrasi/page',
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
				{ value: 'igd', label: 'Instalasi Gawat Darurat', class: 'tab-no-active' },
				{ value: 'tindakan', label: 'Data Tindakan', class: 'tab-no-active' },
				{ value: 'obatobatan', label: 'Data Obat Non Racikan', class: 'tab-no-active' },
				{ value: 'obatobatanracikan', label: 'Data Obat Racikan', class: 'tab-no-active' },
			],
			content: { histori: true, igd: false, tindakan: false, obatobatan: false, obatobatanracikan: false }
		},
		position: '',
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

			if (values == 'igd') {
				
				if (vm.iskunjungan) { 
					setTimeout(() => {
						vm.$refs.FormIgd.seteditedv2(vm.iskunjungan, vm.pj);
					}, 500);
					
				}
			}
		},

		reloading:function() {
			vm.loaderprocess();
			vm.position = "registrasidata";
			vm.attach.data = new FormData();
			vm.attach.data.append('uuid', vm.datauuid);
			vm.attach.url = vm.attach.link.registrasipage;
			vm.executions();
			vm.show(vm.datauuid, false);
		},

		show:function(uuid, next = true){ 
			vm.datauuid = uuid;
			
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; 
				vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content.histori = true;

			if (next) {
				body.style.overflowY = 'hidden';
				vm.terminate_detail.display = 'display: block';
				vm.terminate_detail.show = true;
			}
			
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
			if (position == 'igd') {
				if (data) {
					vm.attach.data = new FormData();
					vm.attach.data.append('uuid', data.uuid);
					vm.attach.url = vm.attach.link.editigd;
					vm.position = 'editigd';
					vm.loaderprocess();
					vm.executions();
				}
			}
		},

		cancel:function(data, position) {
			if (position == 'igd') {
				if (data) {
					vm.attach.data = new FormData();
					vm.attach.data.append('uuid', data.uuid);
					vm.attach.url = vm.attach.link.canceligd;
					vm.position = 'canceligd';
					vm.dialog('Yakin ingin membatalkan penanganan pasien', 'Ya, batalkan penanganan', vm.position)
				}
			}
		},

		parsingForm:function(data, key) {
			vm.attach.data = data;
			if (key == 'igd') { vm.position = 'igd'; vm.attach.url = vm.attach.link.igd; } 
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
			if (vm.position == 'igd') { }
			else if (vm.position == 'editigd') { }
			else if (vm.position == 'rawatinap') { }
			else if (vm.position == 'bedah') { }
			else if (vm.position == 'registrasidata') { }
		},

		berhasil: function (response) {
			if (vm.$debugs) { console.log(response.data); } let active = 1;
			if (vm.position == 'igd') { 
				vm.iskunjungan = response.data.kunjungan; 
				if (response.data.pj != '') {
					vm.pj = response.data.pj;
				}
				//vm.hide();  
				setTimeout(() => {
					vm.mainreload();
					vm.reloading();
				}, 500);
				
			}
			else if (vm.position == 'registrasidata') {
				vm.loaderprocess();
				vm.setdataform(response); 
				vm.position = "-"; 
				active = 0; 
			}
			else if (vm.position == 'editigd') { vm.$refs.FormIgd.setedited(response);  }
			else if (vm.position == 'canceligd') { vm.$refs.FormIgd.resetform(); vm.hide(); vm.mainreload(); vm.iskunjungan = null; vm.pj = null;  }
			else if (vm.position == 'rawatinap') { }
			else if (vm.position == 'bedah') { }
			vm.message('success', active);
		},

		message: function (position, active) {
			if (position == 'error') {
				if (vm.position == 'igd') { vm.notification('Gagal memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'editigd') { vm.notification('Gagal memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'canceligd') { vm.notification('Gagal memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'rawatinap') { vm.notification('Gagal memproses pasien rawat inap.', 3000, position); }
				else if (vm.position == 'bedah') { vm.notification('Gagal memproses pasien ke ruangan bedah.', 3000, position); }
				else if (vm.position == 'registrasidata') { vm.notification('Proses pengambilan data gagal dilakukan.', 3000, position); }
			}
			else if (position == 'success' && active == 1) {
				if (vm.position == 'igd') { vm.notification('Berhasil memproses pasien rawat jalan.', 3000, position); }
				else if (vm.position == 'canceligd') { vm.notification('Berhasil memproses pembatalan pasien rawat jalan.', 3000, position); }
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

			if (vm.iskunjungan) {
				if (vm.iskunjungan.status == 'Instalasi Gawat Darurat') {
					vm.tab = {
						button: [
							{ value: 'histori', label: 'Histori', class: 'tab-active' },
							{ value: 'igd', label: 'Instalasi Gawat Darurat', class: 'tab-no-active' },
							{ value: 'tindakan', label: 'Data Tindakan', class: 'tab-no-active' },
							{ value: 'obatobatan', label: 'Data Obat Non Racikan', class: 'tab-no-active' },
							{ value: 'obatobatanracikan', label: 'Data Obat Racikan', class: 'tab-no-active' },
						],
						content: { histori: true, igd: false, tindakan: false, obatobatan: false, obatobatanracikan: false }
					}
				}
				else {
					vm.tab = {
						button: [
							{ value: 'histori', label: 'Histori', class: 'tab-active' },
						],
						content: { histori: true }
					}
				}
			}
			else {
				vm.tab = {
					button: [
						{ value: 'histori', label: 'Histori', class: 'tab-active' },
						{ value: 'igd', label: 'Instalasi Gawat Darurat', class: 'tab-no-active' },
					],
					content: { histori: true, igd: false }
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