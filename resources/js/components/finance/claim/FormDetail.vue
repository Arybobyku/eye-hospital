<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="printsa('kwitansi')">Cetak Kwitansi</button>
				<button v-on:click="printsa('rincian')" style="margin-right: 140px;">Cetak Rincian Tagihan</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-4 form-mr">
						<ul class="list-detail" v-if="detail">
							<li>Tanggal Pendaftaran<span><strong>{{ datename(detail.tanggal) }}</strong></span></li>
							<li>No Rekam Medis<span><strong>{{ detail.rekam_medis }}</strong></span></li>
							<li>Nama Lengkap<span><strong>{{ detail.nama_pasien }}</strong></span></li>
							<li>Tanggal Lahir<span><strong>{{ datename(detail.tanggal_lahir) }}</strong></span></li>
							<li>Jenis Kelamin<span><strong>{{ detail.jenis_kelamin }}</strong></span></li>
							<li>Nomor Handphone<span><strong>{{ detail.no_handphone }}</strong></span></li>
							<li>Cara Bayar<span><strong>{{ detail.carabayar_nama }}</strong></span></li>
							<li>Dokter yang menangani<span><strong>{{ detail.nama_dokter }}</strong></span></li>
							<li>Triase<span><strong>{{ detail.berkebutuhan_khusus }}</strong></span></li>
							<li v-if="detail.berkebutuhan_khusus!='Tidak'">Keterangan<span><strong>{{ detail.keterangan_berkebutuhan }}</strong></span></li>
							<li v-if="detail.carabayar_nama == 'Umum'">
								<Selected v-on:click="selectbox($event, form.select.metodepembayaran.name, form.select.metodepembayaran.statics)" 
									:ref="form.select.metodepembayaran.name" @selecteditem="selecteditem" @selectclear="selectclear"
									:selection="form.select.metodepembayaran" v-on:keyup="selectfilter($event, form.select.metodepembayaran.name)"></Selected>
							</li>
						</ul>
					</div>
					<div class="col-8">
						
						<div class="grid">
							<div class="col-2"></div>
							<div class="col-8">
								<div class="cop-surat" >
									<div class="top" style="left: 70px">
										<img src="/images/favicon.png">
										<div class="label">
											<span class="label1">RUMAH SAKIT KHUSUS MATA</span><br />
											<span class="label2">PRIMA VISION</span><br />
											<span class="label3">VISION FOR THE NATION</span>
										</div>
									</div>
									<div class="bottom">
										<span class="label1">Jalan Pabrik Tenun NO. 51-53. Medan Petisah. 20118. <br /> Sumatera Utara. Indonesia</span><br />
										<span class="label2">Email : rsprimavision@gmail.com - HOSPITAL HOTLINE (061) 805 14 888</span>
									</div>
								</div>
							</div>
							<div class="col-2"></div>
						</div>

						<div class="grid">
							<div class="col-12">
								<div class="line-surat">
									<div class="line-double"></div>
									<div class="line-single"></div>
								</div>
							</div>
						</div>

						<div class="grid">
							<div class="col-12">
								<table class="table">
									<thead>
										<tr>
											<th style="width: 3%;">No.</th>
											<th style="width: 49%;">Nama Item</th>
											<th style="width: 14%;">Harga</th>
											<th style="width: 12%;">Disc(Rp)</th>
											<th style="width: 8%;">Disc(%)</th>
											<th style="width: 14%;">Sub Total</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(item, index) in listdata">
											<td><strong>{{ index+1 }}</strong></td>
											<td><strong>{{ item.nama_layanan }}</strong></td>
											<td><strong>{{ formatrupiah(item.tarif.toString()) }}</strong></td>
											<td><input type="number" :value="item.diskon_rp" style="width: 100%;" v-on:keyup="ubah($event, item, index, 'rupiah')" /></td>
											<td><input type="number" :value="item.diskon_persen" style="width: 100%;" v-on:keyup="ubah($event, item, index, 'persen')" /></td>
											<td><strong>{{ formatrupiah(item.total.toString()) }}</strong></td>
										</tr>
										<tr>
											<td colspan="5">
												<span v-if="(detail.panjar != '0' && detail.status == 'Pending') || detail.cover_asuransi != 0">Sub Total</span>
												<span v-else>Grand Total</span>
											</td>
											<td><strong>{{ formatrupiah(totalbiaya.toString()) }}</strong></td>
										</tr>
										<tr v-if="detail.panjar != '0' && detail.status == 'Pending'">
											<td colspan="5">
												Panjar
											</td>
											<td>{{ formatrupiah(panjars.toString()) }}</td>
										</tr>
										<tr v-if="detail.cover_asuransi != 0">
											<td colspan="5">
												Nominal Asuransi
											</td>
											<td>{{ formatrupiah(coverasuransis.toString()) }}</td>
										</tr>
										<tr v-if="(detail.panjar != '0' && detail.status == 'Pending') || detail.cover_asuransi != 0">
											<td colspan="5">
												Grand Total
											</td>
											<td>{{ formatrupiah(supergrandtotal.toString()) }}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="grid" v-if="detail.catatan">
							<div class="col-12">
								<div class="message">{{ detail.catatan }}</div>
							</div>
						</div>

						<template v-if="detail.carabayar_nama != 'Umum' && detail.carabayar_nama != 'BPJS Kesehatan'">
							<div class="grid" v-if="detail.is_pay == 'tidak'">
								<div class="col-12">
									<div class="message">{{ msgasuransi() }}</div>
								</div>
							</div>
						</template>
					</div>

				</div>

				<div class="grid" style="border-top: 1px solid #d0d0d0; margin-top: 16px; padding-top: 20px;" v-if="detail">
					<div class="col-8"></div>
					<div class="col-4" style="text-align: right" v-if="detail.approvement_obat == 'yes'">
						<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
						<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green }}</button>
					</div>
					<div class="col-4" style="text-align: right" v-if="listobat.length < 1 || listobatracikan.length < 1 ">
						<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
						<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green }}</button>
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
import { arrkasir } from '../../../module/DataArray.js';
import { datename, formatrupiah } from '../../../module/Manipulation.js';

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
		panjars:function() {
			return parseInt(vm.detail.panjar);
		},
		coverasuransis:function() {
			return parseInt(vm.detail.cover_asuransi);
		},
		totalbiaya:function() {
			let temp = 0;
			for (let i = 0; i < vm.listdata.length; i++) {
				temp += parseInt(vm.listdata[i].total);
			}
			return temp;
		},
		supergrandtotal:function() {
			let temp = vm.totalbiaya - vm.detail.panjar;
			temp -= vm.detail.cover_asuransi;
			return temp;
		},
		totalobat:function() {
			let temp = 0;
			for (let i = 0; i < vm.listobat.length; i++) {
				temp += parseInt(vm.listobat[i].total.replace(/\D/g, ""));
			}
			let ab = vm.formatrupiah(temp.toString());
			return ab;
		},
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formkelurahan();
		vm.arr = vm.arrkasir();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		listdata: [], tmplistdata:[], listobat: [], listobatracikan: [], tempobat: null,
		listadministrasi: [], listrawatjalan: [],
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', arr: null,
		green: 'Proses Pembayaran', red: 'Cancel', pendings: 'Ubah Menjadi Pending', test: null, cover: '', temporer: null,
		pemeriksaanro: null,
		detail : { uuid: '',
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: '', catatan: ''
		},
		temphitung: [],
	}},
	methods: {

		formatrupiah,

		printsa:function(posisi) {
			if (posisi == 'kwitansi') {
				window.open('/print/kasir/' + vm.detail.uuid, '_blank');
			}
			else {
				window.open('/print/kasirrincian/' + vm.detail.uuid, '_blank');
			}
		},

		removetindakan:function(index) {
			vm.listdata.splice(index, 1);
		},

		removeobat:function(index) {
			vm.listobat.splice(index, 1);
		},

		msgasuransi:function() {
			let msg = 'Pasien dengan nama '+vm.detail.nama_pasien+', saat ini menggunakan metode pembayaran '+vm.detail.carabayar_nama;
			if (vm.detail.nama_asuransi != '' && vm.detail.nama_asuransi != 'Silahkan Pilih') {
				msg += ' yaitu "'+vm.detail.nama_asuransi+'"';
			}
			msg += ' dan saat ini status pembayarannya belum diterima dari pihak penjamin.';
			return msg;
		},

		additemobat:function() {
			console.log(vm.tempobat)
			if (vm.tempobat) {
				let _total = parseInt(vm.form.quantity.value) * parseInt(vm.tempobat.hja_resep);
				let tmp = {
					nama: vm.tempobat.nama,
					hja_resep: vm.formatrupiah(vm.tempobat.hja_resep.toString()),
					signa: vm.form.signa.value,
					quantity: vm.form.quantity.value,
					total: vm.formatrupiah(_total.toString()),
				}
				vm.listobat.push(tmp);
				vm.tempobat = null;
				vm.form.signa = '';
				vm.form.quantity = '';
				vm.form.select.apotek.value = '';
				vm.form.select.apotek.label = 'Silahkan Pilih';
			}
		},

		ubah:function(event, item, index, posisi) {
			let number = event.target.value;
			if (number != '') {
				if (posisi == 'rupiah' && parseInt(number) <= vm.listdata[index].tarif) {
					
					vm.listdata[index].total = item.tarif - parseInt(number);
					vm.listdata[index].diskon_rp = parseInt(number);
				}
				else if (posisi == 'persen' && parseInt(number) <= 100) {
					let hitungan = parseFloat(item.tarif - parseFloat((parseFloat(parseInt(number)/100) * item.tarif)));
					vm.listdata[index].total = Math.floor(hitungan);

					vm.listdata[index].diskon_persen = parseInt(number);
				}
			}
			else {
				vm.listdata[index].total = vm.tmplistdata[index].total;
				vm.listdata[index].diskon_rp = vm.tmplistdata[index].diskon_rp;
				vm.listdata[index].diskon_persen = vm.tmplistdata[index].diskon_persen;
			}
			
		},

		greenbutton:function() {
			if (vm.green == 'Proses Pembayaran') {
				if (vm.detail.carabayar_nama == 'Umum') {
					if (vm.form.select.metodepembayaran.value != '' && vm.form.select.metodepembayaran.value != ' ' && vm.form.select.metodepembayaran.value) {
						vm.action();
					}
				}
				else {
					vm.action();
				}
				
			}
		},

		redbutton:function() {
			if (vm.red == 'Cancel') { vm.hide(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
		},

		parsekelurahan, formkelurahan, initindexdb, indexdbprocessing, arrkasir, datename,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key); 

			if (key == 'carabayartindakanrawatjalan') {
				let _item = {
					nama_tindakan_rawat_jalan: item.nama_tindakan_rawat_jalan,
					tindakan_rawat_jalan_uuid: item.tindakan_rawat_jalan_uuid,
					harga: vm.formatrupiah(item.harga.toString()),
				}

				vm.listdata.push(_item);

				vm.form.select.carabayartindakanrawatjalan.value = '';
				vm.form.select.carabayartindakanrawatjalan.label = 'Silahkan Pilih';
			}
			else if (key == 'apotek') {
				vm.tempobat = item;
			}
		},
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

		action:function() { vm.parsingForm(); vm.dialog(); },

		nullcheck:function(data){
			if (!data || data == '-' || data == ' ' || data == '0' || data == '') { return ''; }
			return data;
		},

		show:function(posisi, title, uuid){ vm.btnlbl = posisi == 'adddata' ? 'Proses Pembayaran' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formkelurahan(); 
			vm.listdata = [];
			vm.listobat = [];
			vm.tempobat = null;
			vm.detail = { uuid: '',
				agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
				kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
				nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
				rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: ''
			}
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detail, vm.listdata), 'add'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {

			console.log(response);
			vm.detail = response.data.data;

			if (vm.detail.carabayar_nama == 'Umum') {
				vm.form.select.metodepembayaran.isrequired = true;
			}
			else {
				vm.form.select.metodepembayaran.isrequired = false;
			}
			vm.form.carabayar_nama = vm.detail.carabayar_nama;

			if (vm.detail.panjar != '0') {
				vm.form.panjar.value = vm.detail.panjar;
				if (vm.detail.approve_panjar == '1') {
					vm.form.panjar.disabled = true;
				}
			}

			for (let i = 0; i < response.data.layanan.length; i++){
				let _item = {
					id: response.data.layanan[i].id,
					uuid: response.data.layanan[i].uuid,
					nama_layanan: response.data.layanan[i].nama_layanan,
					layanan_uuid: response.data.layanan[i].layanan_uuid,
					tarif: response.data.layanan[i].tarif,
					total: response.data.layanan[i].total,
					diskon_rp: response.data.layanan[i].diskon_rp,
					diskon_persen: response.data.layanan[i].diskon_persen
				}

				vm.listdata.push(_item);
			}

			vm.tmplistdata = vm.listdata;
			vm.listobat = response.data.obat;
			vm.listobatracikan = response.data.obatracikan;

			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			if (vm.form.posisi == 'adddata') {
				text = 'Yakin ingin menambah data pada halaman ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin memproses tagihan data pasien ini.';
				button = 'Ya, proses tagihan';
			}
      vm.$emit('dialog', text, button, 'formdetail');
    },
	}
}
</script>
<style>
.message {
	width: 100%; 
	height: auto; 
	float: left;
	border-radius: 4px; 
	margin-top: 25px; 
	color: #FFF; 
	padding: 15px 20px; 
	background-color: #62ad9b;
}
</style>