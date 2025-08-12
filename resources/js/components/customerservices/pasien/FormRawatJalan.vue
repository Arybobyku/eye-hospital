<template>
	<div class="grid" v-if="form" ref="rootdiv" style="position: relative;">
		<div class="col-4">
			<Inputed :ref="form.nopendaftaran.name" :form="form.nopendaftaran" v-on:keyup="hurufbesar($event)">
			</Inputed>
			<Selected v-on:click="selectbox($event, form.select.caramasuk.name, form.select.caramasuk.statics)"
				:ref="form.select.caramasuk.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.caramasuk"></Selected>

			<Inputed :ref="form.rujukan.name" :form="form.rujukan"></Inputed>

			<Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)"
				:ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)">
			</Selected>
			<Inputed :ref="form.no_bpjs_kes.name" :form="form.no_bpjs_kes" v-if="form.no_bpjs_kes.show"></Inputed>
			<Inputed :ref="form.nomorreferensi.name" :form="form.nomorreferensi" v-if="form.nomorreferensi.show">
			</Inputed>

			<select style="width: 200px;" v-model="selectedPoli" @change="fetchJadwalDokter" v-if="showSelectPoli">
				<option v-for="poli in poliBpjs" :key="poli.kdpoli" :value="poli.kdpoli">
					{{ poli.nmpoli }} - {{ poli.nmsubspesialis }}
				</option>
			</select>

			<select v-model="selectedDokter" @change="updateJadwalDokter" v-if="showSelectDokter">
				<option v-for="dokter in filteredDokter" :key="dokter.kodedokter" :value="dokter.kodedokter">
					{{ dokter.namadokter }}
				</option>
			</select>

			<p v-if="selectedDokter">
				Jadwal Dokter: {{ dokterTerpilih ? dokterTerpilih.jadwal : 'Tidak ada jadwal tersedia' }}
				({{ dokterTerpilih ? dokterTerpilih.kodesubspesialis : '-' }})
			</p>
			<p v-else>
				Tidak ada jadwal tersedia.
			</p>

			<input type="hidden" :value="dokterTerpilih ? dokterTerpilih.jadwal : ''">
			<input type="hidden" :value="dokterTerpilih ? dokterTerpilih.namadokter : ''">
			<input type="hidden" v-model="selectedNmpoli">


			<Selected v-on:click="selectbox($event, form.select.asuransi.name, form.select.asuransi.statics)"
				:ref="form.select.asuransi.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.asuransi" v-on:keyup="selectfilter($event, form.select.asuransi.name)">
			</Selected>

			<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)"
				:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"
				v-if="form.select.dokter.show"></Selected>
		</div>
		<div class="col-4 form-ml" ref="camerainternal">
			<div class="web-camera-container" v-if="isphotos">
				<div class="camera-box" style="opacity: 1;">
					<canvas id="photoTakenEdited" ref="canvasedited" :width="width_number"
						:height="height_number"></canvas>
				</div>
			</div>
			<div class="web-camera-container" v-else>
				<!-- <div class="camera-button">
      	<button type="button" class="button is-rounded" :class="{ 'is-primary' : !isCameraOpen, 'is-danger' : isCameraOpen}" @click="toggleCamera">
        	<span v-if="!isCameraOpen">Open Camera</span>
        	<span v-else>Close Camera</span>
    		</button>
  		</div> -->
				<div class="camera-pra" :style="camera_height" v-if="!isCameraOpen">
					<!-- <div class="lds-ellipsis" v-show="isLoading"><div></div><div></div><div></div><div></div></div> -->
				</div>
				<div v-if="isCameraOpen" v-show="!isLoading" class="camera-box" :class="{ 'flash' : isShotPhoto }">
					<div class="camera-shutter" :class="{'flash' : isShotPhoto}"></div>
					<video v-show="!isPhotoTaken" ref="camera" :width="width_number" :height="height_number"
						autoplay></video>
					<canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="width_number"
						:height="height_number"></canvas>
				</div>

				<!--
  		<div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
    		<a id="downloadPhoto" download="my-photo.jpg" class="button" role="button" @click="downloadImage">
      		Download
    		</a>
  		</div> -->

				<div class="bagian-bawah">
					<table>
						<tr>
							<td>
								<button class="openphoto" v-on:click="toggleCamera()" v-if="!isCameraOpen">Buka
									Kamera</button>
								<button class="openphoto" v-on:click="toggleCamera()" v-else>Tutup Kamera</button>
							</td>
							<td align="center">
								<button class="takephoto" v-on:click="takePhoto()">Ambil Photo</button>
							</td>
							<td align="right">
								<button class="reloadphoto" v-on:click="reloadPhoto()">Ambil Ulang</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.pjnama.name" :form="form.pjnama"></Inputed>
			<Selected
				v-on:click="selectbox($event, form.select.jenisidentitas.name, form.select.jenisidentitas.statics)"
				:ref="form.select.jenisidentitas.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.jenisidentitas"></Selected>
			<Inputed :ref="form.pjnoidentitas.name" :form="form.pjnoidentitas"></Inputed>
			<Inputed :ref="form.pjhubungan.name" :form="form.pjhubungan"></Inputed>
			<Inputed :ref="form.pjalamat.name" :form="form.pjalamat"></Inputed>
			<Inputed :ref="form.pjnohandphone.name" :form="form.pjnohandphone"></Inputed>
		</div>
		<div class="col-4">
			<Selected
				v-on:click="selectbox($event, form.select.berkebutuhankhusus.name, form.select.berkebutuhankhusus.statics)"
				:ref="form.select.berkebutuhankhusus.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.berkebutuhankhusus"></Selected>


		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.keteranganberkebutuhan.name" :form="form.keteranganberkebutuhan"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Selected v-on:click="selectbox($event, form.select.klinik.name, form.select.klinik.statics)"
				:ref="form.select.klinik.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.klinik"></Selected>
		</div>
		<div :style="cover" v-if="!ishide"></div>
	</div>
	<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form">
		<div class="col-8"></div>
		<div class="col-4" style="text-align: right" v-if="ishide">
			<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
			<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green }}</button>
		</div>
		<div class="col-4" style="text-align: right" v-else>
			<button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan Kunjungan</button>
			<button class="button-modal-page button-modal-green" v-on:click="edit()">Edit Data</button>
			<!-- <button class="button-modal-page button-modal-green" v-on:click="printout()">Cetak Identitas</button> -->
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formrawatjalan } from './FormData.js';
import { parserawatjalan } from './Attachment.js';
import { arrregistrasi } from '../../../module/DataArray.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm", "edit", "cancel"],
	props: ['detail', 'iskunjungan', 'poliBpjs'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formrawatjalan();
		vm.arr = vm.arrregistrasi();
		console.log("Data poliBpjs diterima di FormRawatJalan:", this.eng);
		setTimeout(() => {
			vm.test = vm.iskunjungan;
			vm.coverblock();
			vm.camerablock();
		}, 250);
		
		window.onclick = function(event) { 
			let a = event.target.className; 
			
			try { 
				if (a.split(" ")) { 
					a = a.split(" "); 
					
					if (a[0] != 'hospitals' && a[0] != 'click-title') { 
						vm.selecthide(); 
					} 
				} 
				if (event.target.className == '') { 
					vm.selecthide(); 
				} 
			} 
			catch { console.log('mistmatch'); } }
	},
	computed: {
		ishide:function() {
			if (vm.test) { vm.red = 'Cancel'; }
			return vm.test ? false : true;
		},
		selectedNmpoli() {
			const selected = this.poliBpjs?.find(poli => poli.kdpoli === this.selectedPoli);
			console.log(selected?.nmpoli)
			return selected?.nmpoli || ''; // Jika selected undefined, kembalikan string kosong
		},
		selectedNmdokter() {
			const selected = this.filteredDokter?.find(dokter => dokter.kodedokter === this.selectedDokter);
			console.log(selected?.namadokter)
			return selected?.namadokter || ''; // Jika selected undefined, kembalikan string kosong
		}
	},
	data: function() {
		return {
			isCameraOpen: false,
			isPhotoTaken: false,
			isShotPhoto: false,
			isLoading: false,
			link: '#',
			green: 'Save Data',
			red: 'Clear Form', test: null,
			form: null, arr: null, cover: '', temporer: null,
			camera_height: '',
			width_number: 0,
			height_number: 0,
			isphotos: false,
			camerastatus: 'stop',
			filteredDokter: [], // Harus ada di sini agar Vue bisa melacak perubahannya
			selectedPoli: "", // Untuk menyimpan nilai yang dipilih
			selectedPoliNama: "", // Untuk menyimpan nilai yang dipilih
			jadwalDokter: [], // Simpan jadwal dokter dari AP
			dokterTerpilih: null,
			showSelectDokter: false, 
			showSelectPoli: false, 
			// jadwalDokterBpjs: null,
			// poliBpjs: [] // Data poli_bpjs dari API
		}
	},

	methods: {

		async fetchJadwalDokter() {

			//- TODO: Ganti Tanggal dengan hari ini
			const today = "2025-03-03"; // Format: YYYY-MM-DD

			try {
				const responseJadwal = await axios.get(`/api/bpjs/antrol-bpjs/jadwaldokter/kodepoli/${this.selectedPoli}/tanggal/${today}`);

				this.jadwalDokter = responseJadwal.data.response || [];
				this.filteredDokter = this.jadwalDokter;

			} catch (error) {
				console.error("Gagal mengambil jadwal dokter:", error.response ? error.response.data : error.message);
			}
		},
		updateJadwalDokter() {
			if (!this.jadwalDokter || this.jadwalDokter.length === 0) {
				console.warn("Jadwal dokter belum tersedia.");
				this.dokterTerpilih = null;
				return;
			}

			this.dokterTerpilih = this.jadwalDokter.find(jadwal => jadwal.kodedokter === this.selectedDokter) || null;
			console.log("Dokter Terpilih:", this.dokterTerpilih);
		},


		toggleCamera() {
      if(this.isCameraOpen) {
        this.isCameraOpen = false;
        this.isPhotoTaken = false;
        this.isShotPhoto = false;
				vm.camerastatus = 'stop';
				this.stopCameraStream();
      } else {
				vm.camerastatus = 'start';
        this.isCameraOpen = true;
        this.createCameraElement();
      }
    },

		// printout:function() {
		// 	console.log(vm.iskunjungan);
		// 	if (vm.iskunjungan) {
		// 		window.open('/customerservices/pasien/cetakidentitas/' + vm.iskunjungan.uuid, '_blank');
		// 	}
			
		// },
    
    createCameraElement() {
      this.isLoading = true;
      const constraints = (window.constraints = {
				audio: false,
				video: true
			});


			navigator.mediaDevices
				.getUserMedia(constraints)
				.then(stream => {
          this.isLoading = false;
					this.$refs.camera.srcObject = stream;
				})
				.catch(error => {
          this.isLoading = false;
					alert("May the browser didn't support or there is some errors.");
				});
    },
    
    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();

			tracks.forEach(track => {
				track.stop();
			});
    },
    
    takePhoto() {
		console.log("vm", vm)
			if (vm.camerastatus == 'start') {
				if(!this.isPhotoTaken) {
					this.isShotPhoto = true;

					const FLASH_TIMEOUT = 50;

					setTimeout(() => {
						this.isShotPhoto = false;
					}, FLASH_TIMEOUT);
				}
      
				if (!this.isPhotoTaken) { 
					this.isPhotoTaken = true; 
					const context = this.$refs.canvas.getContext('2d');
					context.drawImage(this.$refs.camera, 0, 0, vm.width_number, vm.height_number);
					vm.form.photos = document.getElementById("photoTaken").toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
					vm.camerastatus = 'stop';
					this.stopCameraStream();
				}
			}
			
    },

		reloadPhoto() {
			if(this.isPhotoTaken) { this.isPhotoTaken = false; }
			vm.form.photos = '';
			if (vm.camerastatus == 'stop' && this.isCameraOpen) {
				vm.camerastatus = 'start';
        this.createCameraElement();
			}
		},
    
    downloadImage() {
      const download = document.getElementById("downloadPhoto");
      const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
      console.log(canvas);
			//download.setAttribute("href", canvas);
    },

		coverblock:function() {
			const left = this.$refs.rootdiv.getBoundingClientRect();
			vm.cover = 'width:'+(left.width+30)+'px;height:'+(left.height+30)+'px;border-radius:4px;position:absolute;left:-15px;top:-15px;background:rgba(0,0,0,0.4)';
		},

		camerablock:function() {
			const left = this.$refs.camerainternal.getBoundingClientRect();
			vm.camera_height = 'height:'+(left.width-(85+46))+'px';
			vm.width_number = left.width - 20; // 446 => 466
			vm.height_number = left.width-(85+46); // 335 => 381
			
		},

		formrawatjalan, parserawatjalan, arrregistrasi,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 
			vm.manipulationform(key, item, true);
		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
			vm.manipulationform(key, '', false);
		},
		selectbox:function(event, key, statics) {

			if (!vm.form.select[key].disabled) {
				let result = vm.boxselected(event, vm.form, key);
				if (result._position == 'stop') { return ; }
				else if (result._position == 'nextstop') { vm.form = result._form; }
				else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
			}
		},

		hurufbesar:function(event) {
			let str = vm.form.nopendaftaran.value.toUpperCase(), tmp = '';
			str = str.replace("-", "");
			str = str.split("");
			if (str.length > 0) {
				if (str.length < 6) {
					if (str[1].length === 1 && str[1].match(/[a-z]/i)) { str[1] = str[1] + '-'; }
					else { vm.form.nopendaftaran.value = ''; return ; }
					for (let i = 0; i < str.length; i++) { tmp += str[i]; }
					vm.form.nopendaftaran.value = tmp;
				}
				else { let str = vm.form.nopendaftaran.value; str = str.substring(0, str.length - (str.length - 6)); vm.form.nopendaftaran.value = str; }	
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
			if (next) { 
				if (vm.isphotos) { vm.parsingForm(); vm.dialog(); }
				else {
					if (vm.form.photos != '') { vm.parsingForm(); vm.dialog(); }
				}
				
			}
		},

		redbutton:function() {
			if (vm.red == 'Clear Form') { vm.form = vm.formrawatjalan(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
		},

		greenbutton:function() {
			if (vm.green == 'Save Data') { 
				console.log(vm.form, 'dfdf')
				vm.action();
			}
		},

		seteditedv3:function(photosstatus) {
			vm.isphotos = photosstatus;
		},

		seteditedv2:function(response, pj, photosstatus) {
			console.log("kontol",pj)
			vm.isphotos = photosstatus;
			let base_image = new Image();
  		base_image.src = '/' + response.photos;
			setTimeout(() => {
				const context = vm.$refs.canvasedited.getContext('2d');
      	context.drawImage(base_image, 0, 0, vm.width_number, vm.height_number);
			}, 750);
			

			// alert('dfssss');

			if (pj != '') {
				vm.form.pjnama.value = pj.nama ? pj.nama : '';
				vm.form.pjhubungan.value = pj.hubungan ? pj.hubungan : '';
				vm.form.pjalamat.value = pj.alamat ? pj.alamat : '';
				vm.form.pjnoidentitas.value = pj.no_identitas ? pj.no_identitas : '';
				vm.form.pjnohandphone.value = pj.no_handphone ? pj.no_handphone : '';
				if (pj.jenis_identitas) {
					vm.form.select.jenisidentitas.value = pj.jenis_identitas;
					vm.form.select.jenisidentitas.label = pj.jenis_identitas;
				}
				else {
					vm.form.select.jenisidentitas.value = '';
					vm.form.select.jenisidentitas.label = 'Silahkan Pilih';
				}
			}
			else {
				vm.form.pjnama.value = '';
				vm.form.pjhubungan.value = '';
				vm.form.pjalamat.value = '';
				vm.form.pjnoidentitas.value = '';
				vm.form.pjnohandphone.value = '';
				vm.form.select.jenisidentitas.value = '';
				vm.form.select.jenisidentitas.label = 'Silahkan Pilih';
			}
			

			vm.form.select.caramasuk.value = response.cara_masuk;
			vm.form.select.caramasuk.label = response.cara_masuk;

			let msg = response.rujukan;
			vm.form.rujukan.value = msg != '-' ? msg : '';
			
			vm.form.select.carabayar.value = response.carabayar_uuid;
			vm.form.select.carabayar.label = response.carabayar_nama;

			if (response.asuransi_uuid || response.asuransi_uuid != '' || response.asuransi_uuid != '-') {
				vm.form.select.asuransi.value =  response.asuransi_uuid;
				vm.form.select.asuransi.label =  response.nama_asuransi;
			}
			else {
				vm.form.select.asuransi.value = '';
				vm.form.select.asuransi.label = 'Silahkan Pilih';
			}

			vm.form.select.dokter.value =  response.pengguna_uuid;
			vm.form.select.dokter.label =  response.nama_dokter;
			vm.form.nopendaftaran.value = response.no_pendaftaran;
			
			vm.form.select.berkebutuhankhusus.value = response.berkebutuhan_khusus;
			vm.form.select.berkebutuhankhusus.label = response.berkebutuhan_khusus;

			msg = response.keterangan_berkebutuhan;
			vm.form.keteranganberkebutuhan.value = msg != '-' ? msg : '';

			if (response.ruang_poliklinik && response.ruang_poliklinik != '' && response.ruang_poliklinik != '-') {
				vm.form.select.klinik.value =  response.ruang_poliklinik;
				vm.form.select.klinik.label =  response.ruang_poliklinik;
			}
			else {
				vm.form.select.klinik.value = '';
				vm.form.select.klinik.label = 'Silahkan Pilih';
			}
			console.log();
			console.log("kontol",response);
		},

		setedited:function(response, photosstatus) {

			vm.isphotos = photosstatus;
			let base_image = new Image();
  		base_image.src = '/' + response.data.data.photos;
			setTimeout(() => {
				const context = vm.$refs.canvasedited.getContext('2d');
      	context.drawImage(base_image, 0, 0, vm.width_number, vm.height_number);
			}, 750);
			
			console.log("kontol", response);
			vm.temporer = vm.test;
			vm.test = null;
			vm.red = 'Back';
			vm.form.uuid = response.data.data.uuid;
			vm.form.select.caramasuk.value = response.data.data.cara_masuk;
			vm.form.select.caramasuk.label = response.data.data.cara_masuk;

			let msg = response.data.data.rujukan;
			vm.form.rujukan.value = msg != '-' ? msg : '';
			
			vm.form.select.carabayar.value = response.data.data.carabayar_uuid;
			vm.form.select.carabayar.label = response.data.data.carabayar_nama;

			if (response.data.data.asuransi_uuid || response.data.data.asuransi_uuid != '' || response.data.data.asuransi_uuid != '-') {
				vm.form.select.asuransi.value =  response.data.data.asuransi_uuid;
				vm.form.select.asuransi.label =  response.data.data.nama_asuransi;
			}
			else {
				vm.form.select.asuransi.value = '';
				vm.form.select.asuransi.label = 'Silahkan Pilih';
			}

			vm.form.select.dokter.value =  response.data.data.pengguna_uuid;
			vm.form.select.dokter.label =  response.data.data.nama_dokter;
			vm.form.nopendaftaran.value = response.data.data.no_pendaftaran;
			
			vm.form.select.berkebutuhankhusus.value = response.data.data.berkebutuhan_khusus;
			vm.form.select.berkebutuhankhusus.label = response.data.data.berkebutuhan_khusus;

			msg = response.data.data.keterangan_berkebutuhan;
			vm.form.keteranganberkebutuhan.value = msg != '-' ? msg : '';

			if (response.data.data.klinik && response.data.data.klinik != '' && response.data.data.klinik != '-') {
				vm.form.select.klinik.value =  response.data.data.klinik;
				vm.form.select.klinik.label =  response.data.data.klinik;
			}
			else {
				vm.form.select.klinik.value = '';
				vm.form.select.klinik.label = 'Silahkan Pilih';
			}

			vm.form.pjnama.value = response.data.penanggungjawab.nama ? response.data.penanggungjawab.nama : '';
			vm.form.pjhubungan.value = response.data.penanggungjawab.hubungan ? response.data.penanggungjawab.hubungan : '';
			vm.form.pjalamat.value = response.data.penanggungjawab.alamat ? response.data.penanggungjawab.alamat : '';
			vm.form.pjnoidentitas.value = response.data.penanggungjawab.no_identitas ? response.data.penanggungjawab.no_identitas : '';
			vm.form.pjnohandphone.value = response.data.penanggungjawab.no_handphone ? response.data.penanggungjawab.no_handphone : '';
			if (response.data.penanggungjawab.jenis_identitas) {
				vm.form.select.jenisidentitas.value = response.data.penanggungjawab.jenis_identitas;
				vm.form.select.jenisidentitas.label = response.data.penanggungjawab.jenis_identitas;
			}
			else {
				vm.form.select.jenisidentitas.value = '';
				vm.form.select.jenisidentitas.label = 'Silahkan Pilih';
			}
			
		},

		edit:function() {
			vm.$emit('edit', vm.test, 'rawatjalan');
		},

		cancel:function() {
			vm.$emit('cancel', vm.test, 'rawatjalan');
		},

		resetform:function() {
			vm.form = vm.formrawatjalan();
		},

		parsingForm:function() { 
			console.log("selectedDokter", this.dokterTerpilih.namadokter);
			vm.form.photos = vm.form.photos.replace("image/octet-stream", "image/jpeg");
			vm.$emit('parsingForm', vm.parserawatjalan(vm.form, vm.detail, vm.selectedPoli, vm.selectedDokter, this.dokterTerpilih.jadwal, this.selectedNmpoli, this.dokterTerpilih.namadokter), 'rawatjalan'); 
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah data pada halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'rawatjalan');
    },

		manipulationform: function (key, item, active) {
			if (key == 'caramasuk') {
				if (item.value == 'Rujukan dari' && active) { 
					vm.form.rujukan.disabled = false; 
					vm.form.rujukan.required = 'required';
				}
				else { 
					vm.form.rujukan.value = '';
					vm.form.rujukan.disabled = true; 
					vm.form.rujukan.required = ''; 
				}
			}
			else if (key == 'carabayar') {
				console.log(item,"item");
			if (item.label != 'BPJS Kesehatan') {
				vm.form.no_bpjs_kes.value = '';
				vm.form.no_bpjs_kes.show = false;
				vm.form.no_bpjs_kes.disabled = true;
				vm.form.no_bpjs_kes.required = '';
				vm.form.nomorreferensi.value = '';
				vm.form.nomorreferensi.show = false;
				vm.form.nomorreferensi.disabled = true;
				vm.form.nomorreferensi.required = '';
				vm.form.select.dokter.isrequired = true;
				vm.form.select.dokter.value = '';
				vm.form.select.dokter.label = 'Silahkan Pilih';
				vm.form.select.dokter.show = true;
				this.showSelectDokter = true; // Sembunyikan select biasa
				this.showSelectPoli = true; // Sembunyikan select biasa
			} else {
				console.log("tes", vm.detail);
				vm.form.no_bpjs_kes.value = vm.detail.no_bpjs; 
				vm.form.no_bpjs_kes.show = true;
				vm.form.no_bpjs_kes.disabled = false;
				vm.form.no_bpjs_kes.required = 'required';
				
				vm.form.nomorreferensi.value = '';
				vm.form.nomorreferensi.show = true;
				vm.form.nomorreferensi.disabled = false;
				vm.form.nomorreferensi.required = 'required';
				vm.form.select.dokter.isrequired = false;
				vm.form.select.dokter.value = '';
				vm.form.select.dokter.label = '';
				vm.form.select.dokter.show = false;


				this.showSelectDokter = true;  // Tampilkan select biasa
				this.showSelectPoli = true;  // Tampilkan select biasa

				
			}
				if (active) {
					
					vm.getIndexDB('asuransi', false);
				}
			}
			else if (key == 'berkebutuhankhusus') {
				if (item.value == 'Ya, Benar' && active) {
					vm.form.keteranganberkebutuhan.required = 'required';
					vm.form.select.klinik.isrequired =  true;
					vm.form.keteranganberkebutuhan.disabled = false;
					vm.form.select.klinik.disabled = false;
				}
				else {
					vm.form.keteranganberkebutuhan.required = '';
					vm.form.keteranganberkebutuhan.value = '';
					vm.form.select.klinik.isrequired =  false;
					vm.form.select.klinik.value = '';
					vm.form.select.klinik.label = 'Silahkan Pilih';
					vm.form.keteranganberkebutuhan.disabled = true;
					vm.form.select.klinik.disabled = true;
				}
			}
			
			
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key); 
						console.log(vm.form.select.asuransi.data);
						if (vm.form.select.asuransi.data.length < 1) {
							vm.form.select.asuransi.disabled = true;
							vm.form.select.asuransi.value = '';
							vm.form.select.asuransi.label = 'Silahkan Pilih';
							vm.form.select.asuransi.isrequired = false;
						}
						else if (vm.form.select.asuransi.data.length > 0) {
							vm.form.select.asuransi.disabled = false;
							vm.form.select.asuransi.isrequired = true;
						}
					})
					.catch(function(error){ console.log(error); });
			}
		},
	}
}
</script>
<style>


.web-camera-container {
  margin-top: 10px;
  /* margin-bottom: 2rem; */
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
	position: relative;
}
.web-camera-container .camera-button {
  margin-bottom: 2rem;
}
.web-camera-container .camera-box .camera-shutter {
  opacity: 1;
  background-color: #fff;
  position: absolute;
}

.web-camera-container .camera-pra {
  opacity: 1;
	width: 100%;
  background-color: #d5d5d5;
  position: relative;
}

.web-camera-container .bagian-bawah {
	width: 100%;
	height: auto;
	padding-top: 20px;
	padding-bottom: 5px;
}

.web-camera-container .bagian-bawah table {
	width: 100%;
}

.web-camera-container .bagian-bawah table tr td button {
	border-radius: 5px;
	border: 1px solid #0a5531;
	background: #096438;
	padding: 5px 10px;
	color: #fff;
	cursor: pointer;
}

.web-camera-container .camera-box .camera-shutter.flash {
  opacity: 1;
}
.web-camera-container .camera-loading {
  overflow: hidden;
  height: 100%;
  position: absolute;
  width: 100%;
  min-height: 150px;
  margin: 3rem 0 0 -1.2rem;
}
.web-camera-container .camera-loading ul {
  height: 100%;
  position: absolute;
  width: 100%;
  z-index: 999999;
  margin: 0;
}
.web-camera-container .camera-loading .loader-circle {
  display: block;
  height: 14px;
  margin: 0 auto;
  top: 50%;
  left: 100%;
  transform: translateY(-50%);
  transform: translateX(-50%);
  position: absolute;
  width: 100%;
  padding: 0;
}
.web-camera-container .camera-loading .loader-circle li {
  display: block;
  float: left;
  width: 10px;
  height: 10px;
  line-height: 10px;
  padding: 0;
  position: relative;
  margin: 0 0 0 4px;
  background: #999;
  animation: preload 1s infinite;
  top: -50%;
  border-radius: 100%;
}
.web-camera-container .camera-loading .loader-circle li:nth-child(2) {
  animation-delay: 0.2s;
}
.web-camera-container .camera-loading .loader-circle li:nth-child(3) {
  animation-delay: 0.4s;
}
@keyframes preload {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.4;
  }
  100% {
    opacity: 1;
  }
}
video {
  -webkit-transform: scaleX(-1);
  transform: scaleX(-1);
}

canvas {
  -webkit-transform: scaleX(-1);
  transform: scaleX(-1);
}

.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #fff;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}
</style>