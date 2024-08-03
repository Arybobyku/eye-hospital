<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-4 form-mr">
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
							<li><Inputed :ref="form.nama_pemeriksa.name" :form="form.nama_pemeriksa"></Inputed></li>
							
						</ul>
					</div>
					<div class="col-8">
						
						<div class="tab-lines"><div class="tab"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
		
						<div class="tab-content">
							<div style="position: relative;" class="content-tab-in" v-if="tab.content.pemeriksaan_fisik">
								<div class="grid">
									<div class="col-6 form-mr">

										<Inputed :ref="form.penetesanobat.name" :form="form.penetesanobat"></Inputed>

										<Inputed :ref="form.keluhanutama.name" :form="form.keluhanutama"></Inputed>

										<Inputed :ref="form.riwayatpenyakit.name" :form="form.riwayatpenyakit"></Inputed>

										<Selected v-on:click="selectbox($event, form.select.kasusurgent.name, form.select.kasusurgent.statics)" 
											:ref="form.select.kasusurgent.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.kasusurgent" v-on:keyup="selectfilter($event, form.select.kasusurgent.name)"></Selected>

										<Inputed :ref="form.kasusurgentlainnya.name" :form="form.kasusurgentlainnya"></Inputed>

										<Selected v-on:click="selectbox($event, form.select.statuspsikologis.name, form.select.statuspsikologis.statics)" 
											:ref="form.select.statuspsikologis.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.statuspsikologis" v-on:keyup="selectfilter($event, form.select.statuspsikologis.name)"></Selected>

										<Selected v-on:click="selectbox($event, form.select.statusfungsional.name, form.select.statusfungsional.statics)" 
											:ref="form.select.statusfungsional.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.statusfungsional" v-on:keyup="selectfilter($event, form.select.statusfungsional.name)"></Selected>
											

									</div>
									<div class="col-6 form-ml">

										<Inputed :ref="form.nadi.name" :form="form.nadi"></Inputed>
										<Inputed :ref="form.respiratoryrate.name" :form="form.respiratoryrate"></Inputed>
										<Inputed :ref="form.suhu.name" :form="form.suhu"></Inputed>
										<Inputed :ref="form.beratbadan.name" :form="form.beratbadan"></Inputed>
										<Inputed :ref="form.tinggibadan.name" :form="form.tinggibadan"></Inputed>
										<Inputed :ref="form.tekanandarah.name" :form="form.tekanandarah"></Inputed>
									
									</div>
								</div>
							</div>
							
							<div class="content-tab-in" v-if="tab.content.skrinning">
								<div class="grid">
									<div class="col-6 form-mr">

										
										<Selected v-on:click="selectbox($event, form.select.nyeri.name, form.select.nyeri.statics)" 
											:ref="form.select.nyeri.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.nyeri" v-on:keyup="selectfilter($event, form.select.nyeri.name)"></Selected>

										<Selected v-on:click="selectbox($event, form.select.nyerihilangbila.name, form.select.nyerihilangbila.statics)" 
											:ref="form.select.nyerihilangbila.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.nyerihilangbila" v-on:keyup="selectfilter($event, form.select.nyerihilangbila.name)"></Selected>

										<Inputed :ref="form.nyerihilangbilalainnya.name" :form="form.nyerihilangbilalainnya"></Inputed>

										<Inputed :ref="form.skalanyeri.name" :form="form.skalanyeri"></Inputed>
											
									</div>
									<div class="col-6 form-ml">

										<Inputed :ref="form.lokasinyeri.name" :form="form.lokasinyeri"></Inputed>
										<Inputed :ref="form.durasinyeri.name" :form="form.durasinyeri"></Inputed>
										<Inputed :ref="form.karakteristiknyeri.name" :form="form.karakteristiknyeri"></Inputed>
										<Inputed :ref="form.keterangannyeri.name" :form="form.keterangannyeri"></Inputed>

									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.riwayat_kesehatan">
								<div class="grid">
									<div class="col-6 form-mr">
										

										<Selected v-on:click="selectbox($event, form.select.penyakitpernahdiderita.name, form.select.penyakitpernahdiderita.statics)" 
											:ref="form.select.penyakitpernahdiderita.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.penyakitpernahdiderita" v-on:keyup="selectfilter($event, form.select.penyakitpernahdiderita.name)"></Selected>

										<Inputed :ref="form.penyakitpernahdideritalainnya.name" :form="form.penyakitpernahdideritalainnya"></Inputed>

										<Selected v-on:click="selectbox($event, form.select.pernahdioperasi.name, form.select.pernahdioperasi.statics)" 
											:ref="form.select.pernahdioperasi.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.pernahdioperasi" v-on:keyup="selectfilter($event, form.select.pernahdioperasi.name)"></Selected>

										<Inputed :ref="form.pernahdioperasilainnya.name" :form="form.pernahdioperasilainnya"></Inputed>


										<Selected v-on:click="selectbox($event, form.select.riwayatalergimakanan.name, form.select.riwayatalergimakanan.statics)" 
											:ref="form.select.riwayatalergimakanan.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.riwayatalergimakanan" v-on:keyup="selectfilter($event, form.select.riwayatalergimakanan.name)"></Selected>

										<Inputed :ref="form.riwayatalergimakananlainnya.name" :form="form.riwayatalergimakananlainnya"></Inputed>
										
									</div>
									<div class="col-6 form-ml">

										<Selected v-on:click="selectbox($event, form.select.riwayatalergiobatan.name, form.select.riwayatalergimakanan.statics)" 
											:ref="form.select.riwayatalergiobatan.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.riwayatalergiobatan" v-on:keyup="selectfilter($event, form.select.riwayatalergiobatan.name)"></Selected>

										<Inputed :ref="form.riwayatalergiobatanlainnya.name" :form="form.riwayatalergiobatanlainnya"></Inputed>

										<Selected v-on:click="selectbox($event, form.select.obatdigunakansaatini.name, form.select.riwayatalergimakanan.statics)" 
											:ref="form.select.obatdigunakansaatini.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.obatdigunakansaatini" v-on:keyup="selectfilter($event, form.select.obatdigunakansaatini.name)"></Selected>

										<Inputed :ref="form.obatdigunakansaatinilainnya.name" :form="form.obatdigunakansaatinilainnya"></Inputed>
										
										<Selected v-on:click="selectbox($event, form.select.penilaianresikojatuh.name, form.select.riwayatalergimakanan.statics)" 
											:ref="form.select.penilaianresikojatuh.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.penilaianresikojatuh" v-on:keyup="selectfilter($event, form.select.penilaianresikojatuh.name)"></Selected>
											
									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.ocular_dextra">
								<div class="grid">
									<div class="col-6 form-mr">
										<Inputed :ref="form.oculardextraautoref.name" :form="form.oculardextraautoref"></Inputed>
										<Inputed :ref="form.oculardextrapd.name" :form="form.oculardextrapd"></Inputed>
										<Inputed :ref="form.oculardextrakeratometrik1.name" :form="form.oculardextrakeratometrik1"></Inputed>
										<Inputed :ref="form.oculardextrakeratometrik2.name" :form="form.oculardextrakeratometrik2"></Inputed>
										<Inputed :ref="form.oculardextratonometri.name" :form="form.oculardextratonometri"></Inputed>
										<Inputed :ref="form.oculardextravisus.name" :form="form.oculardextravisus"></Inputed>
									</div>
									<div class="col-6 form-ml">
										<div class="grid">
											<div class="col-12">
												<Inputed :ref="form.oculardextraadd.name" :form="form.oculardextraadd"></Inputed>
											</div>

											<div class="col-8 form-mr">
												<Inputed :ref="form.oculardextrabcva1.name" :form="form.oculardextrabcva1"></Inputed>
											</div>

											<div class="col-4 form-ml">
												<Inputed :ref="form.oculardextrabcva2.name" :form="form.oculardextrabcva2"></Inputed>
											</div>

											<div class="col-12">
												<h4>Kacamata lama</h4>
											</div>

											<div class="col-12">
												<Inputed :ref="form.oculardextrakacamatalamasph.name" :form="form.oculardextrakacamatalamasph"></Inputed>
											</div>

											<div class="col-12">
												<Inputed :ref="form.oculardextrakacamatalamacyl.name" :form="form.oculardextrakacamatalamacyl"></Inputed>
											</div>

											<div class="col-12">
												<Inputed :ref="form.oculardextrakacamatalamaaddisi.name" :form="form.oculardextrakacamatalamaaddisi"></Inputed>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.ocular_sinistra">
								<div class="grid">
									<div class="col-6 form-mr">
										<Inputed :ref="form.ocularsinistraautoref.name" :form="form.ocularsinistraautoref"></Inputed>
										<Inputed :ref="form.ocularsinistrakeratometrik1.name" :form="form.ocularsinistrakeratometrik1"></Inputed>
										<Inputed :ref="form.ocularsinistrakeratometrik2.name" :form="form.ocularsinistrakeratometrik2"></Inputed>
										<Inputed :ref="form.ocularsinistratonometri.name" :form="form.ocularsinistratonometri"></Inputed>
										<Inputed :ref="form.ocularsinistravisus.name" :form="form.ocularsinistravisus"></Inputed>
									</div>

									<div class="col-6 form-ml">
										<div class="grid">
											<div class="col-12">
												<Inputed :ref="form.ocularsinistraadd.name" :form="form.ocularsinistraadd"></Inputed>
											</div>

											<div class="col-8 form-mr">
												<Inputed :ref="form.ocularsinistrabcva1.name" :form="form.ocularsinistrabcva1"></Inputed>
											</div>

											<div class="col-4 form-ml">
												<Inputed :ref="form.ocularsinistrabcva2.name" :form="form.ocularsinistrabcva2"></Inputed>
											</div>

											<div class="col-12">
												<h4>Kacamata lama</h4>
											</div>

											<div class="col-12">
												<Inputed :ref="form.ocularsinistrakacamatalamasph.name" :form="form.ocularsinistrakacamatalamasph"></Inputed>
											</div>

											<div class="col-12">
												<Inputed :ref="form.ocularsinistrakacamatalamacyl.name" :form="form.ocularsinistrakacamatalamacyl"></Inputed>
											</div>

											<div class="col-12">
												<Inputed :ref="form.ocularsinistrakacamatalamaaddisi.name" :form="form.ocularsinistrakacamatalamaaddisi"></Inputed>
											</div>
										</div>
									</div>

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
</template>

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

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {toast, Swal,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
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
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', arr: null,
		green: 'Save Data', red: 'Clear Form', test: null, cover: '', temporer: null,
		detail : { uuid: '',
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: ''
		},
		tab: {
			button: [
					{ value: 'pemeriksaan_fisik', label: 'Pemeriksaan Fisik', class: 'tab-active' },
					{ value: 'skrinning', label: 'Skrinning', class: 'tab-no-active' },
					{ value: 'riwayat_kesehatan', label: 'Riwayat Kesehatan', class: 'tab-no-active' },
					{ value: 'ocular_dextra', label: 'Ocular Dextra', class: 'tab-no-active' },
					{ value: 'ocular_sinistra', label: 'Ocular Sinistra', class: 'tab-no-active' },
			],
			content: { pemeriksaan_fisik: true, skrinning: false, riwayat_kesehatan: false, ocular_dextra: false, ocular_sinistra: false }
		},
	}},
	methods: {

		datename,

		greenbutton:function() {
			if (vm.green == 'Save Data') { 
				console.log(vm.form, 'dfdf')
				vm.action();
			}
		},

		redbutton:function() {
			if (vm.red == 'Clear Form') { vm.form = vm.formkelurahan(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
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
			
		parsekelurahan, formkelurahan, initindexdb, indexdbprocessing, arrpemeriksaan, datename,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { vm.form = vm.conditionselected(vm.form, item, key, 'address'); vm.form = vm.itemselected(vm.form, item, key); },
		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key); },
		selectbox:function(event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
			console.log(key);
			if (result._position == 'stop') { return ; }
			else if (result._position == 'nextstop') { vm.form = result._form; }
			else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
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
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
				else {
					for (const keyselect in vm.form.select) {
						if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
					}
				}
			}
			
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
		aturulang: function () { vm.form = vm.formkelurahan(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detail), 'add'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.detail = response.data.data;
			vm.histori = response.data.histori;

			if (vm.detail.ruang_poliklinik != '0') {
				vm.form.select.klinik.value = vm.detail.ruang_poliklinik;
				vm.form.select.klinik.label = 'Poli ' + vm.detail.ruang_poliklinik;
			}
			

			let temps = response.data.kunjungan;

			if (temps) {
				vm.form.uuid = temps.uuid;
				vm.form.penetesanobat.value = vm.nullcheck(temps.penetesan_obat);
				vm.form.nama_pemeriksa.value = vm.nullcheck(temps.nama_pemeriksa);
				vm.form.keluhanutama.value = vm.nullcheck(temps.keluhan_utama);
				vm.form.riwayatpenyakit.value = vm.nullcheck(temps.riwayat_penyakit);
				vm.form.kasusurgentlainnya.value = vm.nullcheck(temps.kasus_urgent_lainnya);
				vm.form.tekanandarah.value = vm.nullcheck(temps.tekanan_darah);
				vm.form.nadi.value = vm.nullcheck(temps.nadi);
				vm.form.respiratoryrate.value = vm.nullcheck(temps.respiratory_rate);
				vm.form.beratbadan.value = vm.nullcheck(temps.berat_badan);
				vm.form.tinggibadan.value = vm.nullcheck(temps.tinggi_badan);
				vm.form.suhu.value = vm.nullcheck(temps.suhu);
				vm.form.nyerihilangbilalainnya.value = vm.nullcheck(temps.nyeri_hilang_bila_lainnya);
				vm.form.skalanyeri.value = vm.nullcheck(temps.skala_nyeri);
				vm.form.lokasinyeri.value = vm.nullcheck(temps.lokasi_nyeri);
				vm.form.durasinyeri.value = vm.nullcheck(temps.durasi_nyeri);
				vm.form.karakteristiknyeri.value = vm.nullcheck(temps.karakteristik_nyeri);
				vm.form.keterangannyeri.value = vm.nullcheck(temps.keterangan_nyeri);
				vm.form.penyakitpernahdideritalainnya.value = vm.nullcheck(temps.penyakit_pernah_diderita_lainnya);
				vm.form.pernahdioperasilainnya.value = vm.nullcheck(temps.pernah_dioperasi_lainnya);
				vm.form.ocularsinistrakacamatalamasph.value = vm.nullcheck(temps.ocular_sinistra_kacamata_lama_sph);
				vm.form.riwayatalergimakananlainnya.value = vm.nullcheck(temps.riwayat_alergi_makanan_lainnya);
				vm.form.riwayatalergiobatanlainnya.value = vm.nullcheck(temps.riwayat_alergi_obatan_lainnya);
				vm.form.obatdigunakansaatinilainnya.value = vm.nullcheck(temps.obat_digunakan_saat_ini_lainnya);
				vm.form.oculardextraautoref.value = vm.nullcheck(temps.ocular_dextra_autoref);
				vm.form.oculardextrapd.value = vm.nullcheck(temps.ocular_dextra_pd);
				vm.form.oculardextrakeratometrik1.value = vm.nullcheck(temps.ocular_dextra_keratometri_k1);
				vm.form.oculardextrakeratometrik2.value = vm.nullcheck(temps.ocular_dextra_keratometri_k2);
				vm.form.oculardextratonometri.value = vm.nullcheck(temps.ocular_dextra_tonometri);
				vm.form.oculardextravisus.value = vm.nullcheck(temps.ocular_dextra_visus);
				vm.form.oculardextraadd.value = vm.nullcheck(temps.ocular_dextra_add);
				vm.form.oculardextraautoref.value = vm.nullcheck(temps.ocular_dextra_autoref);
				vm.form.oculardextrabcva1.value = vm.nullcheck(temps.ocular_dextra_bcva1);
				vm.form.oculardextrabcva2.value = vm.nullcheck(temps.ocular_dextra_bcva2);
				vm.form.oculardextrakacamatalamasph.value = vm.nullcheck(temps.ocular_dextra_kacamata_lama_sph);
				vm.form.oculardextrakacamatalamacyl.value = vm.nullcheck(temps.ocular_dextra_kacamata_lama_cyl);
				vm.form.oculardextrakacamatalamaaddisi.value = vm.nullcheck(temps.ocular_dextra_kacamata_lama_addisi);
				vm.form.ocularsinistraautoref.value = vm.nullcheck(temps.ocular_sinistra_autoref);
				vm.form.ocularsinistraro.value = vm.nullcheck(temps.ocular_sinistra_ro);
				vm.form.ocularsinistrakeratometrik1.value = vm.nullcheck(temps.ocular_sinistra_keratometri_k1);
				vm.form.ocularsinistrakeratometrik2.value = vm.nullcheck(temps.ocular_sinistra_keratometri_k2);
				vm.form.ocularsinistratonometri.value = vm.nullcheck(temps.ocular_sinistra_tonometri);
				vm.form.ocularsinistravisus.value = vm.nullcheck(temps.ocular_sinistra_visus);
				vm.form.ocularsinistraadd.value = vm.nullcheck(temps.ocular_sinistra_add);
				vm.form.ocularsinistrabcva1.value = vm.nullcheck(temps.ocular_sinistra_bcva1);
				vm.form.ocularsinistrabcva2.value = vm.nullcheck(temps.ocular_sinistra_bcva2);
				vm.form.ocularsinistrakacamatalamacyl.value = vm.nullcheck(temps.ocular_sinistra_kacamata_lama_cyl);
				vm.form.ocularsinistrakacamatalamaaddisi.value = vm.nullcheck(temps.ocular_sinistra_kacamata_lama_addisi);

				// vm.form.select.klinik.value = vm.nullcheck(temps.klinik)
				
				if (vm.nullcheck(temps.kasus_urgent) == '') {
					vm.form.select.kasusurgent.value = '';
					vm.form.select.kasusurgent.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.kasusurgent.value = vm.nullcheck(temps.kasus_urgent);
					vm.form.select.kasusurgent.label = vm.nullcheck(temps.kasus_urgent);
				}

			

				if (vm.nullcheck(temps.status_psikologi) == '') {
					vm.form.select.statuspsikologis.value = '';
					vm.form.select.statuspsikologis.value = 'Silahkan Pilih';
				}
				else {
					vm.form.select.statuspsikologis.value = vm.nullcheck(temps.status_psikologi);
					vm.form.select.statuspsikologis.label = vm.nullcheck(temps.status_psikologi);
				}

				
				if (vm.nullcheck(temps.status_fungsional) == '') {
					vm.form.select.statusfungsional.value = '';
					vm.form.select.statusfungsional.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.statusfungsional.value = vm.nullcheck(temps.status_fungsional);
					vm.form.select.statusfungsional.label = vm.nullcheck(temps.status_fungsional);
				}


				if (vm.nullcheck(temps.nyeri) == '') {
					vm.form.select.nyeri.value = '';
					vm.form.select.nyeri.value = 'Silahkan Pilih';
				}
				else {
					vm.form.select.nyeri.value = vm.nullcheck(temps.nyeri);
					vm.form.select.nyeri.label = vm.nullcheck(temps.nyeri);
				}

				if (vm.nullcheck(temps.nyeri_hilang_bila) == '') {
					vm.form.select.nyerihilangbila.value = '';
					vm.form.select.nyerihilangbila.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.nyerihilangbila.value = vm.nullcheck(temps.nyeri_hilang_bila);
					vm.form.select.nyerihilangbila.label = vm.nullcheck(temps.nyeri_hilang_bila);
				}

				if (vm.nullcheck(temps.penyakit_pernah_diderita) == '') {
					vm.form.select.penyakitpernahdiderita.value = '';
					vm.form.select.penyakitpernahdiderita.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.penyakitpernahdiderita.value = vm.nullcheck(temps.penyakit_pernah_diderita);
					vm.form.select.penyakitpernahdiderita.label = vm.nullcheck(temps.penyakit_pernah_diderita);
				}

				if (vm.nullcheck(temps.pernah_dioperasi) == '') {
					vm.form.select.pernahdioperasi.value = '';
					vm.form.select.pernahdioperasi.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.pernahdioperasi.value = vm.nullcheck(temps.pernah_dioperasi);
					vm.form.select.pernahdioperasi.label = vm.nullcheck(temps.pernah_dioperasi);
				}

				if (vm.nullcheck(temps.riwayat_alergi_makanan) == '') {
					vm.form.select.riwayatalergimakanan.value = '';
					vm.form.select.riwayatalergimakanan.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.riwayatalergimakanan.value = vm.nullcheck(temps.riwayat_alergi_makanan);
					vm.form.select.riwayatalergimakanan.label = vm.nullcheck(temps.riwayat_alergi_makanan);
				}

				if (vm.nullcheck(temps.riwayat_alergi_obatan) == '') {
					vm.form.select.riwayatalergiobatan.value = '';
					vm.form.select.riwayatalergiobatan.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.riwayatalergiobatan.value = vm.nullcheck(temps.riwayat_alergi_obatan);
					vm.form.select.riwayatalergiobatan.label = vm.nullcheck(temps.riwayat_alergi_obatan);
				}

				if (vm.nullcheck(temps.obat_digunakan_saat_ini) == '') {
					vm.form.select.obatdigunakansaatini.value = '';
					vm.form.select.obatdigunakansaatini.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.obatdigunakansaatini.value = vm.nullcheck(temps.obat_digunakan_saat_ini);
					vm.form.select.obatdigunakansaatini.label = vm.nullcheck(temps.obat_digunakan_saat_ini);
				}

				if (vm.nullcheck(temps.penilaian_resiko_jatuh) == '') {
					vm.form.select.penilaianresikojatuh.value = '';
					vm.form.select.penilaianresikojatuh.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.penilaianresikojatuh.value = vm.nullcheck(temps.penilaian_resiko_jatuh);
					vm.form.select.penilaianresikojatuh.label = vm.nullcheck(temps.penilaian_resiko_jatuh);
				}
			
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