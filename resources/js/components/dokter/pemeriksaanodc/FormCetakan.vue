<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Detail Data Cetakan Dokter</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-4 form-mr">
						<table class="table">
							<tbody>
								<tr>
									<td>Tanggal Pendaftaran</td>
									<td><strong>{{ datename(detail.tanggal) }}</strong></td>
								</tr>
								<tr>
									<td>No Rekam Medis</td>
									<td><strong>{{ detail.rekam_medis }}</strong></td>
								</tr>
								<tr>
									<td>Nama Lengkap</td>
									<td><strong>{{ detail.nama_pasien }}</strong></td>
								</tr>
								<tr>
									<td>Tanggal Lahir</td>
									<td><strong>{{ datename(detail.tanggal_lahir) }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-4">
						<table class="table">
							<tbody>
								<tr>
									<td>Jenis Kelamin</td>
									<td><strong>{{ detail.jenis_kelamin }}</strong></td>
								</tr>
								<tr>
									<td>Nama Provinsi</td>
									<td><strong>{{ detail.nama_provinsi }}</strong></td>
								</tr>
								<tr>
									<td>Nama Kecamatan</td>
									<td><strong>{{ detail.nama_kecamatan }}</strong></td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td><strong>{{ detail.alamat }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-4 form-ml">
						<table class="table">
							<tbody>
								<tr>
									<td>Nomor Handphone</td>
									<td><strong>{{ detail.no_handphone }}</strong></td>
								</tr>
								<tr>
									<td>Cara Bayar</td>
									<td><strong>{{ detail.carabayar_nama }}</strong></td>
								</tr>
								<tr>
									<td>Dokter yang menangani</td>
									<td><strong>{{ detail.nama_dokter }}</strong></td>
								</tr>
								<tr>
									<td>Triase</td>
									<td><strong>{{ detail.berkebutuhan_khusus }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-12" v-if="detail.berkebutuhan_khusus!='Tidak'">
						<table class="table">
							<tbody>
								<tr>
									<td>Keterangan berkebutuhan Khusus</td>
									<td><strong>{{ detail.keterangan_berkebutuhan }}</strong></td>
								</tr>
							</tbody>
						</table>
					</div>


					<div class="col-12" style="margin-bottom: 30px;">
						
						<div class="tab-lines"><div class="tab" style="width: 100%;"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
		
						
						<div class="tab-content">
							<div style="position: relative;" class="content-tab-in" v-if="tab.content.istirahat">
								<div class="grid">
									<div class="col-5">
										<Inputed :ref="form.istirahatjumlahhari.name" :form="form.istirahatjumlahhari"></Inputed>
									</div>
									<div class="col-3 form-ml">
										<Inputed :ref="form.istirahatmulai.name" :form="form.istirahatmulai"></Inputed>
									</div>
									<div class="col-3 form-ml">
										<Inputed :ref="form.istirahatsampai.name" :form="form.istirahatsampai"></Inputed>
									</div>
									<div class="col-1 form-ml">
										<button class="tooltip btn-success" v-on:click="action('suratistirahat')" style="margin-top: 20px">
											<vue-feather type="save"></vue-feather> 
											<span class="tooltiptext">Simpan Surat Keterangan Sakit</span>
										</button>
									</div>
									<div class="col-12">
										<Textarea :ref="form.istirahatdiagnosa.name" :form="form.istirahatdiagnosa"></Textarea>
									</div>

								</div>
							</div>
							<div style="position: relative;" class="content-tab-in" v-if="tab.content.resep">
								<div class="grid">
									<div class="col-11">
										<h3>Instruksi khusus</h3>
										<h4>Mohon</h4>
										<input class="checkbox" type="checkbox" :checked="m1" value="m1" style="margin-bottom: 10px; cursor: pointer;"> Ulangi pemeriksaan refraksi untuk mendapatkan tajam penglihatan terbaik dan ternyaman <br />
										<input class="checkbox" type="checkbox" :checked="m2" value="m2" style="margin-bottom: 10px; cursor: pointer;"> Resepkan kacamata sesuai dengan refraksi
										<h4>Resep buat/Prescription</h4>
										<input class="checkbox" type="checkbox" :checked="r1" value="r1" style="margin-bottom: 10px; cursor: pointer;"> Monofocal<br />
										<input class="checkbox" type="checkbox" :checked="r2" value="r2" style="margin-bottom: 10px; cursor: pointer;"> Bifocal/Progressive<br />
										<input class="checkbox" type="checkbox" :checked="r3" value="r3" style="margin-bottom: 10px; cursor: pointer;"> Contact Lens<br />
										<input class="checkbox" type="checkbox" :checked="r4" value="r4" style="margin-bottom: 10px; cursor: pointer;"> Transitional
									</div>
									<div class="col-1 form-ml">
										<button class="tooltip btn-success" v-on:click="action('resepkacamata')" style="margin-top: 20px">
											<vue-feather type="save"></vue-feather> 
											<span class="tooltiptext">Simpan Resep Kacamata</span>
										</button>
									</div>
								</div>
							</div>
							
							<div class="content-tab-in" v-if="tab.content.konsul">
								<div class="grid">
									<div class="col-6">
										<Inputed :ref="form.konsulyth.name" :form="form.konsulyth"></Inputed>
									</div>
									<div class="col-5 form-ml">
										<Inputed :ref="form.konsuldi.name" :form="form.konsuldi"></Inputed>
									</div>
									<div class="col-1 form-ml">
										<button class="tooltip btn-success" v-on:click="action('suratkonsul')" style="margin-top: 20px">
											<vue-feather type="save"></vue-feather> 
											<span class="tooltiptext">Simpan Surat Konsul</span>
										</button>
									</div>
									<div class="col-12">
										<Textarea :ref="form.konsuldiagnosa.name" :form="form.konsuldiagnosa"></Textarea>
									</div>
									<div class="col-12">
										<Textarea :ref="form.konsultindakan.name" :form="form.konsultindakan"></Textarea>
									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.balasankonsul">
								<div class="grid">
									<div class="col-6">
										<Inputed :ref="form.balasankonsulyth.name" :form="form.balasankonsulyth"></Inputed>
									</div>
									<div class="col-5 form-ml">
										<Inputed :ref="form.balasankonsuldi.name" :form="form.balasankonsuldi"></Inputed>
									</div>
									<div class="col-1 form-ml">
										<button class="tooltip btn-success" v-on:click="action('suratbalasankonsul')" style="margin-top: 20px">
											<vue-feather type="save"></vue-feather> 
											<span class="tooltiptext">Simpan Surat Balasan Konsul</span>
										</button>
									</div>
									<div class="col-12">
										<Textarea :ref="form.balasankonsuldiagnosa.name" :form="form.balasankonsuldiagnosa"></Textarea>
									</div>
									<div class="col-12">
										<Textarea :ref="form.balasankonsultindakan.name" :form="form.balasankonsultindakan"></Textarea>
									</div>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>

	<div style=""></div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formcetakan } from './FormData.js';
import { parseistirahat, parsekonsul, parsebalasankonsul, parseresepkacamata } from './Attachment.js';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2';
import { arrpemeriksaan } from '../../../module/DataArray.js';
import { datename } from '../../../module/Manipulation.js';

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {toast, Swal,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		Textarea: defineAsyncComponent(() => import('../../../section/Textarea.vue')),
	},
	computed: {},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formcetakan();
		vm.arr = vm.arrpemeriksaan();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		m1: false, m2: false, r1: false, r2: false, r3: false, r4: false,
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', arr: null,
		print: {
			suratistirahat: '/dokter/pemeriksaan/printsuratistirahat/',
			suratkonsul: '/dokter/pemeriksaan/printsuratkonsul/',
			suratbalasankonsul: '/dokter/pemeriksaan/printsuratbalasankonsul/',
			resepkacamata: '/dokter/pemeriksaan/printresepkacamata/',
		},
		detail : { uuid: '',
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: ''
		},
		tab: {
			button: [
					{ value: 'istirahat', label: 'Surat Keterangan Sakit', class: 'tab-active' },
					{ value: 'resep', label: 'Surat Resep Kacamata', class: 'tab-no-active' },
					{ value: 'konsul', label: 'Surat Konsul', class: 'tab-no-active' },
					{ value: 'balasankonsul', label: 'Surat Balasan Konsul', class: 'tab-no-active' }
			],
			content: { istirahat: true, resep: false, konsul: false, balasankonsul: false }
		},
	}},
	methods: {

		parseistirahat, parsekonsul, parsebalasankonsul, parseresepkacamata, formcetakan, arrpemeriksaan, datename,

		clearcheckbox:function() {
			var input = document.querySelectorAll('.checkbox');
			for (var i = 0; i < input.length; i++) {
				input[i].checked = false;
			}
		},

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
			}
		},

		action:function(posisi) {
			let next = true;
			if (posisi == 'suratistirahat') {
				if (
					vm.form.istirahatjumlahhari.value == '' || vm.form.istirahatjumlahhari.value == 0 || vm.form.istirahatjumlahhari.value == '0' ||
					vm.form.istirahatmulai.value == '' || vm.form.istirahatsampai.value == ''
				) {
					next = false;
				}
			}
			else if (posisi == 'suratkonsul') {
				if ( vm.form.konsuldi.value == '' || vm.form.konsulyth.value == '' ) {
					next = false;
				}
			}
			else if (posisi == 'suratbalasankonsul') {
				if ( vm.form.balasankonsuldi.value == '' || vm.form.balasankonsulyth.value == '' ) {
					next = false;
				}
			}
			else if (posisi == 'resepkacamata') {
				let test = 0;
				var input = document.querySelectorAll('.checkbox');
				for (var i = 0; i < input.length; i++) {
					if (input[i].checked) {
						if (input[i].value == 'm1') { vm.form.m1 = 'ada'; }
						else if (input[i].value == 'm2') { vm.form.m2 = 'ada'; }
						else if (input[i].value == 'r1') { vm.form.r1 = 'ada'; }
						else if (input[i].value == 'r2') { vm.form.r2 = 'ada'; }
						else if (input[i].value == 'r3') { vm.form.r3 = 'ada'; }
						else if (input[i].value == 'r4') { vm.form.r4 = 'ada'; }
						test += 1;
					}
					else {
						if (input[i].value == 'm1') { vm.form.m1 = 'tidak ada'; }
						else if (input[i].value == 'm2') { vm.form.m2 = 'tidak ada'; }
						else if (input[i].value == 'r1') { vm.form.r1 = 'tidak ada'; }
						else if (input[i].value == 'r2') { vm.form.r2 = 'tidak ada'; }
						else if (input[i].value == 'r3') { vm.form.r3 = 'tidak ada'; }
						else if (input[i].value == 'r4') { vm.form.r4 = 'tidak ada'; }
					}
				}

				if (test == 0) { next = false; }
			}
			if (next) { vm.parsingForm(posisi); vm.dialog(posisi); }
		},

		nullcheck:function(data){
			if (!data || data == '-' || data == ' ' || data == '0' || data == '') { return ''; }
			return data;
		},

		show:function(posisi, title, uuid){ vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formcetakan(); 
			vm.clearcheckbox();
			vm.detail = { uuid: '',
				agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
				kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
				nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
				rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: ''
			}
			vm.m1 = false; vm.m2 = false; vm.r1 = false; vm.r2 = false; vm.r3 = false; vm.r4 = false;
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content.istirahat = true;
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function(posisi) {
			if (posisi == 'suratistirahat') {
				vm.$emit('parsingForm', vm.parseistirahat(vm.form, vm.detail), posisi); 
			}
			else if (posisi == 'suratkonsul') {
				vm.$emit('parsingForm', vm.parsekonsul(vm.form, vm.detail), posisi); 
			}
			else if (posisi == 'suratbalasankonsul') {
				vm.$emit('parsingForm', vm.parsebalasankonsul(vm.form, vm.detail), posisi); 
			}
			else if (posisi == 'resepkacamata') {
				vm.$emit('parsingForm', vm.parseresepkacamata(vm.form, vm.detail), posisi); 
			}
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.detail = response.data.data;
			if (response.data.suratistirahat) {
				vm.form.istirahatjumlahhari.value = response.data.suratistirahat.jumlah_hari;
				vm.form.istirahatmulai.value = response.data.suratistirahat.mulai_tanggal;
				vm.form.istirahatsampai.value = response.data.suratistirahat.sampai_tanggal;
				vm.form.istirahatdiagnosa.value = response.data.suratistirahat.diagnosa;

			}
			if (response.data.suratkonsul) {
				vm.form.konsulyth.value = response.data.suratkonsul.yth;
				vm.form.konsuldi.value = response.data.suratkonsul.di;
				vm.form.konsuldiagnosa.value = response.data.suratkonsul.diagnosa;
				vm.form.konsultindakan.value = response.data.suratkonsul.tindakan;
			}
			if (response.data.suratbalasankonsul) {
				vm.form.balasankonsulyth.value = response.data.suratbalasankonsul.yth;
				vm.form.balasankonsuldi.value = response.data.suratbalasankonsul.di;
				vm.form.balasankonsuldiagnosa.value = response.data.suratbalasankonsul.diagnosa;
				vm.form.balasankonsultindakan.value = response.data.suratbalasankonsul.tindakan;
			}
			if (response.data.suratresepkacamata) {
				if (response.data.suratresepkacamata.m1 == 'ada') { vm.m1 = true; }
				if (response.data.suratresepkacamata.m2 == 'ada') { vm.m2 = true; }
				if (response.data.suratresepkacamata.r1 == 'ada') { vm.r1 = true; }
				if (response.data.suratresepkacamata.r2 == 'ada') { vm.r2 = true; }
				if (response.data.suratresepkacamata.r3 == 'ada') { vm.r3 = true; }
				if (response.data.suratresepkacamata.r4 == 'ada') { vm.r4 = true; }
			}
			vm.loaderprocess();
		},

		setopentab:function(response, posisi) {
			vm.loaderprocess();
			if (response.data.suratistirahat) {
				vm.form.istirahatjumlahhari.value = response.data.suratistirahat.jumlah_hari;
				vm.form.istirahatmulai.value = response.data.suratistirahat.mulai_tanggal;
				vm.form.istirahatsampai.value = response.data.suratistirahat.sampai_tanggal;
				vm.form.istirahatdiagnosa.value = response.data.suratistirahat.diagnosa;

			}
			if (response.data.suratkonsul) {
				vm.form.konsulyth.value = response.data.suratkonsul.yth;
				vm.form.konsuldi.value = response.data.suratkonsul.di;
				vm.form.konsuldiagnosa.value = response.data.suratkonsul.diagnosa;
				vm.form.konsultindakan.value = response.data.suratkonsul.tindakan;
			}
			if (response.data.suratbalasankonsul) {
				vm.form.balasankonsulyth.value = response.data.suratbalasankonsul.yth;
				vm.form.balasankonsuldi.value = response.data.suratbalasankonsul.di;
				vm.form.balasankonsuldiagnosa.value = response.data.suratbalasankonsul.diagnosa;
				vm.form.balasankonsultindakan.value = response.data.suratbalasankonsul.tindakan;
			}

			if (response.data.suratresepkacamata) {
				if (response.data.suratresepkacamata.m1 == 'ada') { vm.m1 = true; }
				if (response.data.suratresepkacamata.m2 == 'ada') { vm.m2 = true; }
				if (response.data.suratresepkacamata.r1 == 'ada') { vm.r1 = true; }
				if (response.data.suratresepkacamata.r2 == 'ada') { vm.r2 = true; }
				if (response.data.suratresepkacamata.r3 == 'ada') { vm.r3 = true; }
				if (response.data.suratresepkacamata.r4 == 'ada') { vm.r4 = true; }
			}
			// if (posisi == 'suratistirahat') {
			// 	window.open(vm.print.suratistirahat + response.data.data.uuid, '_blank');
			// }
			// else if (posisi == 'suratkonsul') {
			// 	window.open(vm.print.suratkonsul + response.data.data.uuid, '_blank');
			// }
			// else if (posisi == 'suratbalasankonsul') {
			// 	window.open(vm.print.suratbalasankonsul + response.data.data.uuid, '_blank');
			// }
			// else if (posisi == 'resepkacamata') {
			// 	window.open(vm.print.resepkacamata + response.data.data.uuid, '_blank');
			// }
		},

		dialog:function(posisi){
			let text = '', button = '';
			if (posisi == 'suratistirahat') {
				text = 'Yakin ingin mencetak data keterangan istirahat/sakit pada pasien ini.';
			}
			else if (posisi == 'suratkonsul') {
				text = 'Yakin ingin mencetak data surat konsul pada pasien ini.';
			}
			else if (posisi == 'suratbalasankonsul') {
				text = 'Yakin ingin mencetak data surat balasan konsul pada pasien ini.';
			}
			else if (posisi == 'resepkacamata') {
				text = 'Yakin ingin mencetak data resep kacamata pada pasien ini.';
			}
			button = 'Ya, cetak surat';
      vm.$emit('dialog', text, button, 'formcetakan');
    },
	}
}
</script>
<style>
.obatracikanclose {
	position: absolute; top: -11px; right: 20px; padding: 0 10px; background: #fff; cursor: pointer; color: #000; font-weight: bold;
}
</style>