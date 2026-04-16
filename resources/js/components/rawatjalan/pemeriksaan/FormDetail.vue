<template>
	<div class="form-khusus">
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-4 form-mr">
						<!-- Foto Pasien -->
						<div style="text-align:center; margin-bottom: 12px;">
							<img
								:src="detail.photos ? '/' + detail.photos : '/default-avatar.png'"
								alt="Foto Pasien"
								@error="$event.target.src='/default-avatar.png'"
								style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid #e0e0e0; box-shadow:0 2px 8px rgba(0,0,0,0.12);"
							/>
							<div style="margin-top:6px; font-weight:600; font-size:13px; color:#333;">{{ detail.nama_pasien }}</div>
							<div style="font-size:11px; color:#888;">{{ detail.rekam_medis }}</div>
						</div>
						<ul class="list-detail">
							<li>No Rekam Medis<span><strong>{{ detail.rekam_medis }}</strong></span></li>
							<li>Nama Lengkap<span><strong>{{ detail.nama_pasien }}</strong></span></li>
							<li>Tanggal Lahir<span><strong>{{ datename(detail.tanggal_lahir) }}</strong></span></li>
							<li>Jenis Kelamin<span><strong>{{ detail.jenis_kelamin }}</strong></span></li>
							<li>Nomor Handphone<span><strong>{{ detail.no_handphone }}</strong></span></li>
							<li>Cara Bayar<span><strong>{{ detail.carabayar_nama }}</strong></span></li>
							<li>Dokter yang menangani<span><strong>{{ detail.nama_dokter }}</strong></span></li>
							<li>Provinsi<span><strong>{{ detail.nama_provinsi }}</strong></span></li>
							<li>Kecamatan<span><strong>{{ detail.nama_kecamatan }}</strong></span></li>
							<li>Alamat<span><strong>{{ detail.alamat }}</strong></span></li>
							<li>Triase<span><strong>{{ detail.berkebutuhan_khusus }}</strong></span></li>
							<li v-if="detail.berkebutuhan_khusus!='Tidak'">Keterangan<span><strong>{{ detail.keterangan_berkebutuhan }}</strong></span></li>
							<li><Inputed :ref="form.ocularsinistraro.name" :form="form.ocularsinistraro"></Inputed></li>
							<!-- <li><Inputed :ref="form.nama_pemeriksa.name" :form="form.nama_pemeriksa"></Inputed></li> -->
						</ul>
					</div>
					<div class="col-8">

						<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>

						<div class="tab-content">

							<div style="position: relative;" class="content-tab-in" v-if="tab.content.ocular_dextra">
								<div class="grid">
									<!-- Ocular Dextra -->
									<div class="col-6">
										<h4>Ocular Dextra</h4>
										<div class="grid">
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextraautoref_s.name, form.select.oculardextraautoref_s.statics)" 
												:ref="form.select.oculardextraautoref_s.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextraautoref_s"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextraautoref_c.name, form.select.oculardextraautoref_c.statics)" 
												:ref="form.select.oculardextraautoref_c.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextraautoref_c"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextraautoref_x.name, form.select.oculardextraautoref_x.statics)" 
												:ref="form.select.oculardextraautoref_x.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextraautoref_x"></Selected>
											</div>
										</div>
										<Inputed :ref="form.oculardextrapd.name" :form="form.oculardextrapd"></Inputed>
										<Inputed :ref="form.oculardextrakeratometrik1.name"
											:form="form.oculardextrakeratometrik1"></Inputed>
										<Inputed :ref="form.oculardextrakeratometrik2.name"
											:form="form.oculardextrakeratometrik2"></Inputed>
										<Inputed :ref="form.oculardextratonometri.name"
											:form="form.oculardextratonometri"></Inputed>
											<div class="grid">
												<div class="col-6">
												<Selected v-on:click="selectbox($event, form.select.oculardextravisus.name, form.select.oculardextravisus.statics)" 
														:ref="form.select.oculardextravisus.name" @selecteditem="selecteditem" @selectclear="selectclear"
														:selection="form.select.oculardextravisus" v-on:keyup="selectfilter($event, form.select.oculardextravisus.name)"></Selected>
												</div>
											</div>

										<div class="grid">
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextrabcva1_s.name, form.select.oculardextrabcva1_s.statics)" 
												:ref="form.select.oculardextrabcva1_s.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextrabcva1_s"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextrabcva1_c.name, form.select.oculardextrabcva1_c.statics)" 
												:ref="form.select.oculardextrabcva1_c.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextrabcva1_c"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextrabcva1_x.name, form.select.oculardextrabcva1_x.statics)" 
												:ref="form.select.oculardextrabcva1_x.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextrabcva1_x"></Selected>
											</div>
										</div>
										<Inputed :ref="form.oculardextrabcva2.name" :form="form.oculardextrabcva2">
										</Inputed>
										<Inputed :ref="form.oculardextraadd.name" :form="form.oculardextraadd">
										</Inputed>
										<h4>Kacamata lama</h4>
										<div class="grid">
											<div class="col-4">
										<Selected v-on:click="selectbox($event, form.select.oculardextrakacamatalamasph.name, form.select.oculardextrakacamatalamasph.statics)" 
												:ref="form.select.oculardextrakacamatalamasph.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextrakacamatalamasph"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextrakacamatalamacyl.name, form.select.oculardextrakacamatalamacyl.statics)" 
												:ref="form.select.oculardextrakacamatalamacyl.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextrakacamatalamacyl"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.oculardextrakacamatalamaaddisi.name, form.select.oculardextrakacamatalamaaddisi.statics)" 
												:ref="form.select.oculardextrakacamatalamaaddisi.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.oculardextrakacamatalamaaddisi"></Selected>
											</div>
										</div>
									</div>

									<!-- Ocular Sinistra -->
									<div class="col-6 ">
										<h4>Ocular Sinistra</h4>
										<!-- spacer setinggi PD dextra -->
										<!-- <Inputed :ref="form.oculardextrapd.name" :form="form.oculardextrapd"></Inputed> -->
										<div class="grid">
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistraautoref_s.name, form.select.ocularsinistraautoref_s.statics)" 
												:ref="form.select.ocularsinistraautoref_s.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistraautoref_s"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistraautoref_c.name, form.select.ocularsinistraautoref_c.statics)" 
												:ref="form.select.ocularsinistraautoref_c.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistraautoref_c"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistraautoref_x.name, form.select.ocularsinistraautoref_x.statics)" 
												:ref="form.select.ocularsinistraautoref_x.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistraautoref_x"></Selected>
											</div>
										</div>
										<h1>&nbsp;</h1>
										<Inputed :ref="form.ocularsinistrakeratometrik1.name"
											:form="form.ocularsinistrakeratometrik1"></Inputed>
										<Inputed :ref="form.ocularsinistrakeratometrik2.name"
											:form="form.ocularsinistrakeratometrik2"></Inputed>
										<Inputed :ref="form.ocularsinistratonometri.name"
											:form="form.ocularsinistratonometri"></Inputed>
										<!-- <Inputed :ref="form.ocularsinistravisus.name" :form="form.ocularsinistravisus"> -->
											<div class="grid">
												<div class="col-6">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistravisus.name, form.select.ocularsinistravisus.statics)" 
														:ref="form.select.ocularsinistravisus.name" @selecteditem="selecteditem" @selectclear="selectclear"
														:selection="form.select.ocularsinistravisus" v-on:keyup="selectfilter($event, form.select.ocularsinistravisus.name)"></Selected>
												</div>
											</div>
											
										<div class="grid">
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistrabcva1_s.name, form.select.ocularsinistrabcva1_s.statics)" 
												:ref="form.select.ocularsinistrabcva1_s.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistrabcva1_s"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistrabcva1_c.name, form.select.ocularsinistrabcva1_c.statics)" 
												:ref="form.select.ocularsinistrabcva1_c.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistrabcva1_c"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistrabcva1_x.name, form.select.ocularsinistrabcva1_x.statics)" 
												:ref="form.select.ocularsinistrabcva1_x.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistrabcva1_x"></Selected>
											</div>
										</div>
					
										<Inputed :ref="form.ocularsinistrabcva2.name" :form="form.ocularsinistrabcva2">
										</Inputed>
										<Inputed :ref="form.ocularsinistraadd.name" :form="form.ocularsinistraadd">
										</Inputed>
										<h4>Kacamata lama</h4>
										<div class="grid">
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistrakacamatalamasph.name, form.select.ocularsinistrakacamatalamasph.statics)" 
												:ref="form.select.ocularsinistrakacamatalamasph.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistrakacamatalamasph"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistrakacamatalamacyl.name, form.select.ocularsinistrakacamatalamacyl.statics)" 
												:ref="form.select.ocularsinistrakacamatalamacyl.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistrakacamatalamacyl"></Selected>
											</div>
											<div class="col-4">
												<Selected v-on:click="selectbox($event, form.select.ocularsinistrakacamatalamaaddisi.name, form.select.ocularsinistrakacamatalamaaddisi.statics)" 
												:ref="form.select.ocularsinistrakacamatalamaaddisi.name" @selecteditem="selecteditem" @selectclear="selectclear"
												:selection="form.select.ocularsinistrakacamatalamaaddisi"></Selected>
									</div>
								</div>
							</div>

								</div>
							</div>

							<div style="position: relative" class="content-tab-in" v-if="tab.content.cppt">


								<div class="grid">
									<div class="col-6 form-ml">
										<iframe title="CPPT" width="100%" height="100%" style="border: 0" :src="linkR">
										</iframe>
									</div>
									<div class="col-6 form-ml">
										<label for=""> Subject</label>
										<ckeditor v-model="form.subject" :editor="editor">
										</ckeditor>
										<br>
										<label for=""> Object</label>
										<ckeditor v-model="form.object" :editor="editor">
										</ckeditor>
										<br>

										<label for=""> Assessment </label>
										<ckeditor v-model="form.assessment" :editor="editor">
										</ckeditor>
										<br />
										<label for=""> Planning </label>
										<ckeditor v-model="form.plan" :editor="editor">
										</ckeditor>
									</div>

									<div class="col-9"></div>
									<!-- <div class="col-3 form-ml form-mt">
											<label for="">Tanda Tangan di Dokumen Ini</label>
												<img
													v-if="form.ttd"
													:src="form.ttd"
													alt="ttd dokter"
													height="100"
													width="400"
												/>
												<br>
											<button v-if="!form.ttd" class="button-modal-page button-modal-green" v-on:click="doDigitalSignature()">Tanda Tangan</button>
									</div> -->

								</div>
							</div>
						</div>

					</div>

				</div>

				<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form">
					<div class="col-8"></div>
					<div class="col-4" style="text-align: right"  v-if="ishide">
						<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
						<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green }}</button>
					</div>
					<div class="col-4" style="text-align: right"  v-else>
						<button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan Kunjungan</button>
						<button class="button-modal-page button-modal-green" v-on:click="edit()">Edit Data</button>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</div>
</template>
<style>
.form-khusus .form-self-group {
  float: none;
}</style>
<script>
import { defineAsyncComponent } from 'vue';
import { formkelurahan } from './FormData.js';
import { parsekelurahan } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2';
import { arrpemeriksaan } from '../../../module/DataArray.js';
import { datename } from '../../../module/Manipulation.js';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
function getUserNama() {
    const meta = document.querySelector('meta[name="user-nama"]');
    return meta ? meta.getAttribute('content') : '';
}

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {toast, Swal,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		ckeditor: CKEditor.component,
	},
	computed: {
		ishide:function() {
			if (vm.test) { vm.red = 'Cancel'; }
			return vm.test ? false : true;
		},
	},
	mounted:function() {
		vm = this; body = document.body;
		vm.form = vm.formkelurahan();
		vm.arr = vm.arrpemeriksaan();
    const namaLogin = getUserNama();
    vm.form.ocularsinistraro.value = namaLogin;
    vm.form.ocularsinistraro.disabled = true;
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return {
		linkR: "/print/rekammedis/rawat-jalan/cppt/",
		editor: ClassicEditor,
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', arr: null,
		cpptResponse: null,
		green: 'Save Data', red: 'Clear Form', test: null, cover: '', temporer: null,
		detail : { uuid: '',
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '',
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '',
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '',
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: ''
		},
		tab: {
			button: [
					{ value: 'ocular_dextra', label: 'Ocular Dextra & Ocular Sinistra', class: 'tab-active' },
					// { value: 'ocular_sinistra', label: 'Ocular Sinistra', class: 'tab-no-active' },
					{ value: 'cppt', label: 'CPPT', class: 'tab-no-active' },
			],
			content: { ocular_dextra: true,  cppt: false, }
		},
	}},
	methods: {

		datename,
		doDigitalSignature: function () {
			vm.form.ttd = window.localStorage.getItem("ttd") ?? "";
		},
		greenbutton:function() {
			if (vm.green == 'Save Data') {
				console.log(vm.form, 'dfdf')
				vm.action();
			}
		},
		parseScx(text) {
			if (!text) return { s: '', c: '', x: '' };

			const sMatch = text.match(/S\s*([^\s]+)/i);
			const cMatch = text.match(/C\s*([^\s]+)/i);
			const xMatch = text.match(/X\s*([^\s]+)/i);

			let s = sMatch ? sMatch[1] : '';
			let c = cMatch ? cMatch[1] : '';
			let x = xMatch ? xMatch[1] : '';

			// 🔥 validasi biar gak salah tangkap huruf
			if (s.toLowerCase() === 'c' || s.toLowerCase() === 'x') s = '';
			if (c.toLowerCase() === 's' || c.toLowerCase() === 'x') c = '';
			if (x.toLowerCase() === 's' || x.toLowerCase() === 'c') x = '';

			return { s, c, x };
		},
		redbutton:function() {
			if (vm.red == 'Clear Form') { vm.form = vm.formkelurahan(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
		},

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) {
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; }
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
				//- if(vm.cpptResponse == null){
				//- 	vm.setCkEditor();
				//- }
				vm.setCkEditor();
			}
		},

		setCkEditor: function(){
			var odautoref_s = vm.form.select.oculardextraautoref_s.value;
			var odautoref_c = vm.form.select.oculardextraautoref_c.value;
			var odautoref_x = vm.form.select.oculardextraautoref_x.value;
			var odautoref = '';
			if (odautoref_s) odautoref += 's ' + odautoref_s + ' ';
			if (odautoref_c) odautoref += ' c ' + odautoref_c + ' ';
			if (odautoref_x) odautoref += ' x ' + odautoref_x;
			odautoref = odautoref.trim();

			var osautoref_s = vm.form.select.ocularsinistraautoref_s.value;
			var osautoref_c = vm.form.select.ocularsinistraautoref_c.value;
			var osautoref_x = vm.form.select.ocularsinistraautoref_x.value;
			var osautoref = '';
			if (osautoref_s) osautoref += 's ' + osautoref_s + ' ';
			if (osautoref_c) osautoref += ' c ' + odautoref_c + ' ';
			if (osautoref_x) osautoref += ' x ' + odautoref_x;
			osautoref = osautoref.trim();

			var odbcva1_s = vm.form.select.oculardextrabcva1_s.value;
			var odbcva1_c = vm.form.select.oculardextrabcva1_c.value;
			var odbcva1_x = vm.form.select.oculardextrabcva1_x.value;
			var odbcva1 = '';
			if (odbcva1_s) odbcva1 += 's ' + odbcva1_s + ' ';
			if (odbcva1_c) odbcva1 += ' c ' + odbcva1_c + ' ';
			if (odbcva1_x) odbcva1 += ' x ' + odbcva1_x;
			odbcva1 = odbcva1.trim();

			var osbcva1_s = vm.form.select.ocularsinistrabcva1_s.value;
			var osbcva1_c = vm.form.select.ocularsinistrabcva1_c.value;
			var osbcva1_x = vm.form.select.ocularsinistrabcva1_x.value;
			var osbcva1 = '';
			if (osbcva1_s) osbcva1 += 's ' + osbcva1_s + ' ';
			if (osbcva1_c) osbcva1 += ' c ' + osbcva1_c + ' ';
			if (osbcva1_x) osbcva1 += ' x ' + osbcva1_x;
			osbcva1 = osbcva1.trim();


				vm.form.object = `
				<figure class="table">
				<table>
					<tbody>
					<tr>
						<td>&nbsp;</td>
						<td>Ocular Dextra</td>
						<td>Ocular Sinistra</td>
					</tr>
					<tr>
						<td>Autoref</td>
						<td>${odautoref}</td>
						<td>${osautoref}</td>
					</tr>
					<tr>
						<td>Add</td>
						<td>${vm.form.oculardextraadd.value}</td>
						<td>${vm.form.ocularsinistraadd.value}</td>
					</tr>
					<tr>
						<td>BCVA</td>
						<td>${odbcva1} => ${vm.form.oculardextrabcva2.value}</td>
						<td>${osbcva1} => ${vm.form.ocularsinistrabcva2.value}</td>
					</tr>
					<tr>
						<td>Keratometri K1</td>
						<td>${vm.form.oculardextrakeratometrik1.value}</td>
						<td>${vm.form.ocularsinistrakeratometrik1.value}</td>
					</tr>
					<tr>
						<td>Keratometri K2</td>
						<td>${vm.form.oculardextrakeratometrik2.value}</td>
						<td>${vm.form.ocularsinistrakeratometrik2.value}</td>
					</tr>
					<tr>
						<td>Tonometri</td>
						<td>${vm.form.oculardextratonometri.value}</td>
						<td>${vm.form.ocularsinistratonometri.value}</td>
					</tr>
					<tr>
						<td>Visus</td>
						<td>${vm.form.select.oculardextravisus.label}</td>
						<td>${vm.form.select.ocularsinistravisus.label}</td>
					</tr>
					<tr>
						<td>Kacamata Sph</td>
						<td>${vm.form.select.oculardextrakacamatalamasph.value}</td>
						<td>${vm.form.select.ocularsinistrakacamatalamasph.value}</td>
					</tr>
					<tr>
						<td>Kacamata Cyl</td>
						<td>${vm.form.select.oculardextrakacamatalamacyl.value}</td>
						<td>${vm.form.select.ocularsinistrakacamatalamacyl.value}</td>
					</tr>
					<tr>
						<td>Kacamata Add</td>
						<td>${vm.form.select.oculardextrakacamatalamaaddisi.value}</td>
						<td>${vm.form.select.ocularsinistrakacamatalamaaddisi.value}</td>
					</tr>
					<tr>
						<td>PD</td>
						<td>${vm.form.oculardextrapd.value}</td>
						<td></td>
					</tr>
					</tbody>
				</table>
				</figure>
				`;


		console.log("====>", vm.form.object)
		},


		parsekelurahan, formkelurahan, initindexdb, indexdbprocessing, arrpemeriksaan, datename,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { vm.form = vm.conditionselected(vm.form, item, key, 'address'); vm.form = vm.itemselected(vm.form, item, key); },
		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key); },
		// selectbox:function(event, key, statics) {
		// 	let result = vm.boxselected(event, vm.form, key);
		// 	console.log(key);
		// 	if (result._position == 'stop') { return ; }
		// 	else if (result._position == 'nextstop') { vm.form = result._form; }
		// 	else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
		// },
		selectbox: function(event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
			console.log(key);
			if (result._position == 'stop') { return; }
			else if (result._position == 'nextstop') { vm.form = result._form; }
			else { 
				vm.selecthide(); 
				vm.getIndexDB(key, statics); 
				vm.form.select[key].option = 'display: block';

				// Scroll ke item 0.00
				vm.$nextTick(() => {
					const ref = vm.$refs[key];
					if (ref) {
						const ul = ref.$el.querySelector('ul');
						const items = ul.querySelectorAll('li');
						items.forEach(li => {
							if (li.textContent.trim() === '0.00') {
								li.scrollIntoView({ block: 'center' });
							}
						});
					}
				});
			}
		},
		

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ vm.form = vm.indexdbprocessing(response, vm.form, key); })
					.catch(function(error){ console.log(error); });
			}
		},

		action:function() {
			let next = true;
			//- for (const key in vm.form) {
			//- 	if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			//- 	else {
			//- 		for (const keyselect in vm.form.select) {
			//- 			if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
			//- 		}
			//- 	}
			//- }

			if (next) { vm.parsingForm(); vm.dialog(); }
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
			vm.form = vm.formkelurahan();
    const namaLogin = getUserNama();
    vm.form.ocularsinistraro.value = namaLogin;
    vm.form.ocularsinistraro.disabled = true;
			vm.linkR = '/print/rekammedis/rawat-jalan/cppt/';
			vm.tab= {
			button: [
					{ value: 'ocular_dextra', label: 'Ocular Dextra & Ocular Sinistra', class: 'tab-active' },
					// { value: 'ocular_sinistra', label: 'Ocular Sinistra', class: 'tab-no-active' },
					{ value: 'cppt', label: 'CPPT', class: 'tab-no-active' },
			],
			content: { ocular_dextra: true, cppt: false, }
			};

		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detail), 'add'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.detail = response.data.data;
			vm.histori = response.data.histori;
			vm.linkR = vm.linkR + vm.detail.pasien_uuid;

			const namaLogin = response.data.nama_login ?? '';
    		vm.form.ocularsinistraro.value = namaLogin;
    		vm.form.ocularsinistraro.disabled = true;



			vm.form.cppt_sebagai = 'RO';

			let cppt = response.data.cppt;
			if(cppt != null){
				vm.cpptResponse = cppt;
				vm.form.subject = cppt.subjek;
				vm.form.object = cppt.objek;
				vm.form.assessment = cppt.asesmen;
				vm.form.plan = cppt.plan;
			}

			let temps = response.data.kunjungan;

			if (temps) {
				
				vm.form.uuid = temps.uuid;
				// vm.form.penetesanobat.value = vm.nullcheck(temps.penetesan_obat);
				vm.form.nama_pemeriksa.value = vm.nullcheck(temps.nama_pemeriksa);
				// vm.form.keluhanutama.value = vm.nullcheck(temps.keluhan_utama);
				// vm.form.riwayatpenyakit.value = vm.nullcheck(temps.riwayat_penyakit);
				// vm.form.kasusurgentlainnya.value = vm.nullcheck(temps.kasus_urgent_lainnya);
				// vm.form.tekanandarah.value = vm.nullcheck(temps.tekanan_darah);
				// vm.form.nadi.value = vm.nullcheck(temps.nadi);
				// vm.form.respiratoryrate.value = vm.nullcheck(temps.respiratory_rate);
				// vm.form.beratbadan.value = vm.nullcheck(temps.berat_badan);
				// vm.form.tinggibadan.value = vm.nullcheck(temps.tinggi_badan);
				// vm.form.suhu.value = vm.nullcheck(temps.suhu);
				// vm.form.nyerihilangbilalainnya.value = vm.nullcheck(temps.nyeri_hilang_bila_lainnya);
				// vm.form.skalanyeri.value = vm.nullcheck(temps.skala_nyeri);
				// vm.form.lokasinyeri.value = vm.nullcheck(temps.lokasi_nyeri);
				// vm.form.durasinyeri.value = vm.nullcheck(temps.durasi_nyeri);
				// vm.form.karakteristiknyeri.value = vm.nullcheck(temps.karakteristik_nyeri);
				// vm.form.keterangannyeri.value = vm.nullcheck(temps.keterangan_nyeri);
				// vm.form.penyakitpernahdideritalainnya.value = vm.nullcheck(temps.penyakit_pernah_diderita_lainnya);
				// vm.form.pernahdioperasilainnya.value = vm.nullcheck(temps.pernah_dioperasi_lainnya);
				// vm.form.riwayatalergimakananlainnya.value = vm.nullcheck(temps.riwayat_alergi_makanan_lainnya);
				// vm.form.riwayatalergiobatanlainnya.value = vm.nullcheck(temps.riwayat_alergi_obatan_lainnya);
				// vm.form.obatdigunakansaatinilainnya.value = vm.nullcheck(temps.obat_digunakan_saat_ini_lainnya);
				// vm.form.oculardextraautoref.value = vm.nullcheck(temps.ocular_dextra_autoref);
				const parsed = this.parseScx(temps.ocular_dextra_autoref);
				vm.form.select.oculardextraautoref_s.value = parsed.s;
				vm.form.select.oculardextraautoref_c.value = parsed.c;
				vm.form.select.oculardextraautoref_x.value = parsed.x;
				vm.form.select.oculardextraautoref_s.label = parsed.s;
				vm.form.select.oculardextraautoref_c.label = parsed.c;
				vm.form.select.oculardextraautoref_x.label = parsed.x;
				if (parsed.s == '') {
					vm.form.select.oculardextraautoref_s.label = 'Silahkan Pilih';
				}
				if (parsed.c == '') {
					vm.form.select.oculardextraautoref_c.label = 'Silahkan Pilih';
				}
				console.log('parsed', parsed.x);
				if (parsed.x == '') {
					vm.form.select.oculardextraautoref_x.label = 'Silahkan Pilih';
				}
				vm.form.oculardextrapd.value = vm.nullcheck(temps.ocular_dextra_pd);
				vm.form.oculardextrakeratometrik1.value = vm.nullcheck(temps.ocular_dextra_keratometri_k1);
				vm.form.oculardextrakeratometrik2.value = vm.nullcheck(temps.ocular_dextra_keratometri_k2);
				vm.form.oculardextratonometri.value = vm.nullcheck(temps.ocular_dextra_tonometri);
				vm.form.select.oculardextravisus.value = temps.ocular_dextra_visus;
				vm.form.select.oculardextravisus.label =  temps.ocular_dextra_visus;
				if (temps.ocular_dextra_visus == '') {
					vm.form.select.oculardextravisus.label = 'Silahkan Pilih';
				}
				vm.form.oculardextraadd.value = vm.nullcheck(temps.ocular_dextra_add);
				vm.form.oculardextraautoref.value = vm.nullcheck(temps.ocular_dextra_autoref);
				console.log(temps.ocular_dextra_bcva1);
			    const parsed1 = this.parseScx(temps.ocular_dextra_bcva1);
				vm.form.select.oculardextrabcva1_s.value = parsed1.s;
				vm.form.select.oculardextrabcva1_c.value = parsed1.c;
				vm.form.select.oculardextrabcva1_x.value = parsed1.x;
				vm.form.select.oculardextrabcva1_s.label = parsed1.s;
				vm.form.select.oculardextrabcva1_c.label = parsed1.c;
				vm.form.select.oculardextrabcva1_x.label = parsed1.x;
				if (parsed1.s == '') {
					vm.form.select.oculardextrabcva1_s.label = 'Silahkan Pilih';
				}
				if (parsed1.c == '') {
					vm.form.select.oculardextrabcva1_c.label = 'Silahkan Pilih';
				}
				if (parsed1.x == '') {
					vm.form.select.oculardextrabcva1_x.label = 'Silahkan Pilih';
				}
				vm.form.oculardextrabcva2.value = vm.nullcheck(temps.ocular_dextra_bcva2);
				vm.form.select.oculardextrakacamatalamasph.value = temps.ocular_dextra_kacamata_lama_sph;
				vm.form.select.oculardextrakacamatalamasph.label = temps.ocular_dextra_kacamata_lama_sph;
				if (temps.ocular_dextra_kacamata_lama_sph  == '' || temps.ocular_dextra_kacamata_lama_sph  == null) {
					vm.form.select.oculardextrakacamatalamasph.label = 'Silahkan Pilih';
					vm.form.select.oculardextrakacamatalamasph.value = '';
				}
				vm.form.select.oculardextrakacamatalamacyl.value = temps.ocular_dextra_kacamata_lama_cyl;
				vm.form.select.oculardextrakacamatalamacyl.label = temps.ocular_dextra_kacamata_lama_cyl;
				if (temps.ocular_dextra_kacamata_lama_cyl  == '' || temps.ocular_dextra_kacamata_lama_cyl  == null) {
					vm.form.select.oculardextrakacamatalamacyl.label = 'Silahkan Pilih';
					vm.form.select.oculardextrakacamatalamacyl.value = '';
				}
				vm.form.select.oculardextrakacamatalamaaddisi.value = temps.ocular_dextra_kacamata_lama_addisi;
				vm.form.select.oculardextrakacamatalamaaddisi.label = temps.ocular_dextra_kacamata_lama_addisi;
				if (temps.ocular_dextra_kacamata_lama_addisi  == '' || temps.ocular_dextra_kacamata_lama_addisi  == null) {
					vm.form.select.oculardextrakacamatalamaaddisi.label = 'Silahkan Pilih';
					vm.form.select.oculardextrakacamatalamaaddisi.value = '';

				}
				// vm.form.ocularsinistraautoref.value = vm.nullcheck(temps.ocular_sinistra_autoref);
				const parsed2 = this.parseScx(temps.ocular_sinistra_autoref);
				vm.form.select.ocularsinistraautoref_s.value = parsed2.s;
				vm.form.select.ocularsinistraautoref_c.value = parsed2.c;
				vm.form.select.ocularsinistraautoref_x.value = parsed2.x;
				vm.form.select.ocularsinistraautoref_s.label = parsed2.s;
				vm.form.select.ocularsinistraautoref_c.label = parsed2.c;
				vm.form.select.ocularsinistraautoref_x.label = parsed2.x;
				if (parsed2.s == '') {
					vm.form.select.ocularsinistraautoref_s.label = 'Silahkan Pilih';
				}
				if (parsed2.c == '') {
					vm.form.select.ocularsinistraautoref_c.label = 'Silahkan Pilih';
				}
				if (parsed2.x == '') {
					vm.form.select.ocularsinistraautoref_x.label = 'Silahkan Pilih';
				}
				vm.form.ocularsinistraro.value = vm.nullcheck(temps.ocular_sinistra_ro);
				vm.form.ocularsinistraro.disabled = true; // ✅ tambahkan ini
				vm.form.ocularsinistrakeratometrik1.value = vm.nullcheck(temps.ocular_sinistra_keratometri_k1);
				vm.form.ocularsinistrakeratometrik2.value = vm.nullcheck(temps.ocular_sinistra_keratometri_k2);
				vm.form.ocularsinistratonometri.value = vm.nullcheck(temps.ocular_sinistra_tonometri);
				vm.form.select.ocularsinistravisus.value = temps.ocular_sinistra_visus;
				vm.form.select.ocularsinistravisus.label = temps.ocular_sinistra_visus;
				if (temps.ocular_sinistra_visus == '' || temps.ocular_sinistra_visus == null) {
					vm.form.select.ocularsinistravisus.label = 'Silahkan Pilih';
				}
				vm.form.ocularsinistraadd.value = vm.nullcheck(temps.ocular_sinistra_add);
				// vm.form.ocularsinistrabcva1.value = vm.nullcheck(temps.ocular_sinistra_bcva1);
				const parsed3 = this.parseScx(temps.ocular_sinistra_bcva1);
				vm.form.select.ocularsinistrabcva1_s.value = parsed3.s;
				vm.form.select.ocularsinistrabcva1_c.value = parsed3.c;
				vm.form.select.ocularsinistrabcva1_x.value = parsed3.x;
				vm.form.select.ocularsinistrabcva1_s.label = parsed3.s;
				vm.form.select.ocularsinistrabcva1_c.label = parsed3.c;
				vm.form.select.ocularsinistrabcva1_x.label = parsed3.x;
				if (parsed3.s == '') {
					vm.form.select.ocularsinistrabcva1_s.label = 'Silahkan Pilih';
				}
				if (parsed3.x == '') {
					vm.form.select.ocularsinistrabcva1_x.label = 'Silahkan Pilih';
				}
				if (parsed3.c == '') {
					vm.form.select.ocularsinistrabcva1_c.label = 'Silahkan Pilih';
				}
				vm.form.ocularsinistrabcva2.value = vm.nullcheck(temps.ocular_sinistra_bcva2);


				vm.form.select.ocularsinistrakacamatalamasph.value = temps.ocular_sinistra_kacamata_lama_sph;
				vm.form.select.ocularsinistrakacamatalamasph.label = temps.ocular_sinistra_kacamata_lama_sph;
				if (temps.ocular_sinistra_kacamata_lama_sph  == '' || temps.ocular_sinistra_kacamata_lama_sph  == null) {
					vm.form.select.ocularsinistrakacamatalamasph.label = 'Silahkan Pilih';
					vm.form.select.ocularsinistrakacamatalamasph.value = '';

				}
				vm.form.select.ocularsinistrakacamatalamacyl.value = temps.ocular_sinistra_kacamata_lama_cyl;
				vm.form.select.ocularsinistrakacamatalamacyl.label = temps.ocular_sinistra_kacamata_lama_cyl;
				if (temps.ocular_sinistra_kacamata_lama_cyl  == '' || temps.ocular_sinistra_kacamata_lama_cyl  == null ) {
					vm.form.select.ocularsinistrakacamatalamacyl.label = 'Silahkan Pilih';
					vm.form.select.ocularsinistrakacamatalamacyl.value = '';
				}
				vm.form.select.ocularsinistrakacamatalamaaddisi.value = temps.ocular_sinistra_kacamata_lama_addisi;
				vm.form.select.ocularsinistrakacamatalamaaddisi.label = temps.ocular_sinistra_kacamata_lama_addisi;
				console.log('yduha', temps.ocular_sinistra_kacamata_lama_addisi );
				if (temps.ocular_sinistra_kacamata_lama_addisi  == '' || temps.ocular_sinistra_kacamata_lama_addisi  == null) {
					vm.form.select.ocularsinistrakacamatalamaaddisi.label = 'Silahkan Pilih';
					vm.form.select.ocularsinistrakacamatalamaaddisi.value = '';
				}
				// vm.form.select.klinik.value = vm.nullcheck(temps.klinik)

				// if (vm.nullcheck(temps.kasus_urgent) == '') {
				// 	vm.form.select.kasusurgent.value = '';
				// 	vm.form.select.kasusurgent.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.kasusurgent.value = vm.nullcheck(temps.kasus_urgent);
				// 	vm.form.select.kasusurgent.label = vm.nullcheck(temps.kasus_urgent);
				// }



				// if (vm.nullcheck(temps.status_psikologi) == '') {
				// 	vm.form.select.statuspsikologis.value = '';
				// 	vm.form.select.statuspsikologis.value = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.statuspsikologis.value = vm.nullcheck(temps.status_psikologi);
				// 	vm.form.select.statuspsikologis.label = vm.nullcheck(temps.status_psikologi);
				// }


				// if (vm.nullcheck(temps.status_fungsional) == '') {
				// 	vm.form.select.statusfungsional.value = '';
				// 	vm.form.select.statusfungsional.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.statusfungsional.value = vm.nullcheck(temps.status_fungsional);
				// 	vm.form.select.statusfungsional.label = vm.nullcheck(temps.status_fungsional);
				// }


				// if (vm.nullcheck(temps.nyeri) == '') {
				// 	vm.form.select.nyeri.value = '';
				// 	vm.form.select.nyeri.value = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.nyeri.value = vm.nullcheck(temps.nyeri);
				// 	vm.form.select.nyeri.label = vm.nullcheck(temps.nyeri);
				// }

				// if (vm.nullcheck(temps.nyeri_hilang_bila) == '') {
				// 	vm.form.select.nyerihilangbila.value = '';
				// 	vm.form.select.nyerihilangbila.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.nyerihilangbila.value = vm.nullcheck(temps.nyeri_hilang_bila);
				// 	vm.form.select.nyerihilangbila.label = vm.nullcheck(temps.nyeri_hilang_bila);
				// }

				// if (vm.nullcheck(temps.penyakit_pernah_diderita) == '') {
				// 	vm.form.select.penyakitpernahdiderita.value = '';
				// 	vm.form.select.penyakitpernahdiderita.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.penyakitpernahdiderita.value = vm.nullcheck(temps.penyakit_pernah_diderita);
				// 	vm.form.select.penyakitpernahdiderita.label = vm.nullcheck(temps.penyakit_pernah_diderita);
				// }

				// if (vm.nullcheck(temps.pernah_dioperasi) == '') {
				// 	vm.form.select.pernahdioperasi.value = '';
				// 	vm.form.select.pernahdioperasi.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.pernahdioperasi.value = vm.nullcheck(temps.pernah_dioperasi);
				// 	vm.form.select.pernahdioperasi.label = vm.nullcheck(temps.pernah_dioperasi);
				// }

				// if (vm.nullcheck(temps.riwayat_alergi_makanan) == '') {
				// 	vm.form.select.riwayatalergimakanan.value = '';
				// 	vm.form.select.riwayatalergimakanan.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.riwayatalergimakanan.value = vm.nullcheck(temps.riwayat_alergi_makanan);
				// 	vm.form.select.riwayatalergimakanan.label = vm.nullcheck(temps.riwayat_alergi_makanan);
				// }

				// if (vm.nullcheck(temps.riwayat_alergi_obatan) == '') {
				// 	vm.form.select.riwayatalergiobatan.value = '';
				// 	vm.form.select.riwayatalergiobatan.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.riwayatalergiobatan.value = vm.nullcheck(temps.riwayat_alergi_obatan);
				// 	vm.form.select.riwayatalergiobatan.label = vm.nullcheck(temps.riwayat_alergi_obatan);
				// }

				// if (vm.nullcheck(temps.obat_digunakan_saat_ini) == '') {
				// 	vm.form.select.obatdigunakansaatini.value = '';
				// 	vm.form.select.obatdigunakansaatini.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.obatdigunakansaatini.value = vm.nullcheck(temps.obat_digunakan_saat_ini);
				// 	vm.form.select.obatdigunakansaatini.label = vm.nullcheck(temps.obat_digunakan_saat_ini);
				// }

				// if (vm.nullcheck(temps.penilaian_resiko_jatuh) == '') {
				// 	vm.form.select.penilaianresikojatuh.value = '';
				// 	vm.form.select.penilaianresikojatuh.label = 'Silahkan Pilih';
				// }
				// else {
				// 	vm.form.select.penilaianresikojatuh.value = vm.nullcheck(temps.penilaian_resiko_jatuh);
				// 	vm.form.select.penilaianresikojatuh.label = vm.nullcheck(temps.penilaian_resiko_jatuh);
				// }

			}
			else {
				vm.form.uuid = '';
			}
			console.log(vm.form.uuid)

			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			if (vm.form.posisi == 'adddata') {
				text = 'Yakin ingin menambah data pada halaman ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin memperbaharui data ini.';
				button = 'Ya, perbaharui data';
			}
      vm.$emit('dialog', text, button, 'formdetail');
    },
	}
}
</script>
