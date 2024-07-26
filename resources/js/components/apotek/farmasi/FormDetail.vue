<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar"
			:class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()" v-if="detail.status_kasir == 'Belum Bayar'">Perbaharui Data Obat</button>
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
							<li v-if="detail.berkebutuhan_khusus!='Tidak'">Keterangan<span><strong>{{
										detail.keterangan_berkebutuhan }}</strong></span></li>
						</ul>
					</div>
					<div class="col-8">
						<div class="tab-lines">
							<div class="tab" style="width: 100%;"><button v-for="(item, index) in tab.button"
									:class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.
									label }}</button>
							</div>
						</div>
						<div class="tab-content">



							<div class="content-tab-in" v-if="tab.content.obatdokter">
								<div class="grid">
									<div class="col-12">
										<table class="table">
											<thead>
												<tr>
													<th style="width: 3%;">No.</th>
													<th style="width: 30%;">Nama Item</th>
													<template v-if="detail.status_kasir == 'Belum Bayar'">
														<th style="width: 11%;">Qty</th>
														<th style="width: 9%;">Satuan</th>
													</template>
													<template v-else>
														<th style="width: 19%;">Qty</th>
													</template>
													<th style="width: 9%;">Signa</th>
													<th style="width: 15%;">Harga</th>
													<th style="width: 15%;">Total</th>
													<!-- <td v-if="detail.status_kasir == 'Belum Bayar'">#</td> -->
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in listobat">
													<td>{{ index + 1 }}</td>
													<td>{{ item.nama }}</td>
													<template v-if="detail.status_kasir == 'Belum Bayar'">
														<td>
															<input type="number" :value="item.jumlah_kecil"
																style="width: 100%;"
																v-on:keyup="ubah($event, item, index)" />
														</td>
														<td>{{ item.nama_satuan_kecil }}</td>
													</template>
													<template v-else>
														<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
													</template>
													<td>{{ item.signa }}</td>
													<td>{{ formatrupiah(Math.floor(item.hja_resep).toString()) }}</td>
													<td>{{ formatrupiah(Math.floor(item.total).toString()) }}</td>
													<!-- <td v-if="detail.status_kasir == 'Belum Bayar'">
												<button class="tooltip btn-danger" v-on:click="removeobat(index, indexin)">
													<vue-feather type="trash"></vue-feather> 
													<span class="tooltiptext">Hapus Data Obat</span>
												</button>
											</td> -->
												</tr>
											</tbody>
										</table>
									</div>

									<div class="col-12">
										<table class="table">
											<thead>
												<tr>
													<th>Data Racikan</th>
													<th>Informasi Obat</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in listobatracikan"
													v-if="listobatracikan.length > 0">
													<td>
														<table class="table">
															<tbody>
																<tr>
																	<td>Nama Racikan</td>
																	<td>{{ item.label }}</td>
																</tr>
																<tr>
																	<td>Signa</td>
																	<td>{{ item.signa }}</td>
																</tr>
																<tr>
																	<td>Jumlah Kemasan</td>
																	<td>{{ item.jumlah }} {{ item.kemasan }}</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td>
														<table class="table">
															<thead>
																<tr>
																	<th>Nama Obat/Alkes</th>
																	<!-- <th>Komposisi dikemasan</th>
														<th>Dosis yang diperlukan</th> -->
																	<th>Qty</th>
																	<th>Harga</th>
																	<th>Total</th>
																	<!-- <th>#</th> -->
																</tr>
															</thead>
															<tbody v-if="item.informasi.length > 0">
																<tr v-for="(itemin, indexin) in item.informasi">
																	<td>{{ itemin.nama }}</td>
																	<!-- <td>{{ itemin.komposisi }} {{ itemin.nama_satuan_komposisi }}</td>
														<td>{{ itemin.dosis_diperlukan }} {{ itemin.nama_satuan_diperlukan }}</td> -->
																	<td>{{ itemin.jumlah_kecil }} {{
																		itemin.nama_satuan_kecil }}
																	</td>
																	<td>{{ itemin.jumlah_kecil }} {{
																		itemin.nama_satuan_kecil }}
																	</td>
																	<td>{{ formatrupiah(itemin.hja_resep.toString()) }}
																	</td>
																	<td>{{ formatrupiah(itemin.total.toString()) }}</td>
																	<!-- <td>
															<td>
																	<button class="tooltip btn-danger" v-on:click="removeobatracikandetail(index, indexin)">
																		<vue-feather type="trash"></vue-feather> 
																		<span class="tooltiptext">Edit Data Obat</span>
																	</button>
																</td>
														</td> -->

																</tr>
															</tbody>
															<tbody v-else>
																<tr>
																	<td colspan="3">List data obat racikan belum
																		ditambahkan
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr v-else>
													<td colspan="3">No Data for Result</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.obattambahan">
								<div class="grid">

									<div class="col-5 form-mr">
										<Selected
											v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)"
											:ref="form.select.apotek.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.apotek"
											v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
									</div>
									<div class="col-3 form-mr form-ml">
										<Inputed :ref="form.quantity.name" :form="form.quantity"></Inputed>
									</div>
									<div class="col-3 form-mr form-ml">
										<Inputed :ref="form.signa.name" :form="form.signa"></Inputed>
									</div>
									<div class="col-1">
										<button class="tooltip btn-danger" v-on:click="additemobat()"
											style="margin-top: 20px">
											<vue-feather type="plus"></vue-feather>
											<span class="tooltiptext">Add Item Obat</span>
										</button>
									</div>

									<div class="col-12">
										<table class="table">
											<thead>
												<tr>
													<th>Nama Obat</th>
													<th>Signa</th>
													<th>Qty</th>
													<th>Harga</th>
													<th>Total</th>
													<th>#</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in listobattambahan" v-if="listobattambahan.length > 0">
													<td>{{ item.nama }}</td>
													<td>{{ item.signa }}</td>
													<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
													<td>{{ formatrupiah(item.hja_resep.toString()) }}</td>
													<td>{{ formatrupiah(item.total.toString()) }}</td>
													<td>
														<button class="tooltip btn-danger"
															v-on:click="removeobattambahan(index)">
															<vue-feather type="trash"></vue-feather>
															<span class="tooltiptext">Hapus Obat</span>
														</button>
													</td>
												</tr>
												<tr v-else>
													<td colspan="3">No Data for Result</td>
												</tr>
												<tr v-if="listobattambahan.length > 0">
													<td colspan="4">Grant Total</td>
													<td colspan="2">{{ formatrupiah(totalobattambahan.toString()) }}</td>
												</tr>
											</tbody>

										</table>
									</div>
								</div>
							</div>

						</div>



					</div>

				</div>

				<!-- <div class="grid" style="border-top: 1px solid #d0d0d0; margin-top: 16px; padding-top: 20px;" v-if="form">
					<div class="col-8"></div>
					<div class="col-4" style="text-align: right"  v-if="ishide">
						<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red }}</button>
						<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green }}</button>
					</div>
					<div class="col-4" style="text-align: right"  v-else>
						<button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan Kunjungan</button>
						<button class="button-modal-page button-modal-green" v-on:click="edit()">Edit Data</button>
					</div>
				</div> -->
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
		totalbiaya:function() {
			let temp = 0;
			for (let i = 0; i < vm.listdata.length; i++) {
				temp += parseInt(vm.listdata[i].subtotal);
			}
			return temp;
		},
		supergrandtotal:function() {
			let temp = vm.totalbiaya - vm.detail.panjar;
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
		totalobattambahan: function () {
				let temp = 0;
				for (let i = 0; i < vm.listobattambahan.length; i++) {
					temp += parseInt(vm.listobattambahan[i].total);
				}
				let ab = parseInt(temp);
				return ab;
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
		listdata: [], tmplistdata: [], templistobat: [], listobat: [], templistobattambahan: [], listobattambahan: [], listobatracikan: [], tempobat: null, tempobattambahan: null,
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
		tab: {
			button: [{
				value: 'obatdokter',
				label: 'Obat Dari Dokter',
				class: 'tab-active'
			},
			{
				value: 'obattambahan',
				label: 'Obat/Vit Tambahan',
				class: 'tab-no-active'
			},
			

			],
			// racikan: false,
			content: {
				obatdokter: true,
				obattambahan: false
			}
		},
		temphitung: [],
	}},
	methods: {

		ubah:function(event, item, index) {
			let number = event.target.value;
			if (number != '') {
				let hitungan = parseInt(number * item.hja_resep);
				vm.listobat[index].jumlah_kecil = number;
				vm.listobat[index].total = parseInt(Math.floor(hitungan));
			}
			
		},

		formatrupiah,
		removetindakan:function(index) {
			vm.listdata.splice(index, 1);
		},

		removeobattambahan:function(index) {
			vm.listobattambahan.splice(index, 1);
		},

		pendingbutton:function() {
			if (vm.form.panjar.value != '' && vm.form.panjar.value != ' ') {
				vm.form.ispending = 'yes';
				vm.action();
			}
			
		},
		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) {
					vm.tab.content[vm.tab.button[i].value] = false;
					vm.tab.button[i].class = 'tab-no-active';
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
			}
		},

		additemobat: function () {
			console.log(vm.tempobattambahan)
			if (vm.tempobattambahan) {
				let _total = parseInt(vm.form.quantity.value) * parseInt(vm.tempobattambahan.hja_resep);
				let tmp = {
					obat_uuid: vm.tempobattambahan.obat_uuid,
					nama: vm.tempobattambahan.nama,
					kategori: vm.tempobattambahan.kategori,
					formularium: vm.tempobattambahan.formularium,
					golongan: vm.tempobattambahan.golongan,
					satuan_uuid_besar: vm.tempobattambahan.satuan_uuid_besar,
					nama_satuan_besar: vm.tempobattambahan.nama_satuan_besar,
					satuan_uuid_kecil: vm.tempobattambahan.satuan_uuid_kecil,
					nama_satuan_kecil: vm.tempobattambahan.nama_satuan_kecil,
					hitung_besar: vm.tempobattambahan.hitung_besar,
					hitung_kecil: vm.tempobattambahan.hitung_kecil,
					harga_netto: parseInt(vm.tempobattambahan.harga_netto),
					harga_netto_discount: parseInt(vm.tempobattambahan.harga_netto_discount),
					harga_netto_ppn: parseInt(vm.tempobattambahan.harga_netto_ppn),
					hpp: parseInt(vm.tempobattambahan.hpp),
					margin_resep: vm.tempobattambahan.margin_resep,
					margin_non_resep: vm.tempobattambahan.margin_non_resep,
					hja_resep: parseInt(vm.tempobattambahan.hja_resep),
					hja_non_resep: parseInt(vm.tempobattambahan.hja_non_resep),
					hja_resep_besar: vm.tempobattambahan.hja_resep_besar,
					hja_non_resep_besar: vm.tempobattambahan.hja_non_resep_besar,
					jumlah_kecil: vm.form.quantity.value,
					jumlah_besar: parseFloat(vm.form.quantity.value / vm.tempobattambahan.hitung_kecil),
					signa: vm.form.signa.value,
					total: parseInt(_total),
				}
				vm.listobattambahan.push(tmp);
				vm.tempobattambahan = null;
				vm.form.signa.value = '';
				vm.form.quantity.value = '';
				vm.form.select.apotek.value = '';
				vm.form.select.apotek.label = 'Silahkan Pilih';
			}
		},

		greenbutton:function() {
			if (vm.green == 'Proses Pembayaran') {
				vm.action();
			}
		},

		redbutton:function() {
			if (vm.red == 'Cancel') { vm.hide(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
		},

		parsekelurahan, formkelurahan, initindexdb, indexdbprocessing, arrpemeriksaan, datename,
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
				vm.tempobattambahan = item;
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

		action:function() { 
			//if (vm.listobat.length > 0) {
				vm.parsingForm(); 
				vm.dialog(); 
			//}
		},

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
			vm.listobattambahan = [];
			vm.tempobattambahan = null;
			vm.tempobat = null;
			vm.tempobattambahan = null;
			vm.listobatracikan = [];
			vm.detail = { uuid: '',
				agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
				kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
				nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
				rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: ''
			}
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detail, vm.listobat, vm.listobattambahan), 'editobat'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.detail = response.data.data;
			vm.form.carabayar_nama = vm.detail.carabayar_nama;

			if (vm.detail.panjar != '0') {
				vm.form.panjar.value = vm.detail.panjar;
				if (vm.detail.approve_panjar == '1') {
					vm.form.panjar.disabled = true;
				}
			}

			// for (let i = 0; i < response.data.layanan.length; i++){
			// 	let _item = {
			// 		nama_tindakan_rawat_jalan: response.data.layanan[i].nama_layanan,
			// 		tindakan_rawat_jalan_uuid: response.data.layanan[i].layanan_uuid,
			// 		harga: response.data.layanan[i].tarif,
			// 		subtotal: response.data.layanan[i].tarif
			// 	}

			// 	vm.listdata.push(_item);
			// }

			vm.tmplistdata = vm.listdata;
			console.log("Response Data");
			console.log(response.data);
			let obats = response.data.obat;
			for (let i = 0; i < obats.length; i++){

				let _total = parseInt(obats[i].quantity) * parseInt(obats[i].harga);
				let tmp = {
					nama: obats[i].nama_obat,
					obat_uuid: obats[i].obat_uuid,
					kategori: obats[i].kategori,
					formularium: obats[i].formularium,
					golongan: obats[i].golongan,
					satuan_uuid_besar: obats[i].satuan_uuid_besar,
					nama_satuan_besar: obats[i].nama_satuan_besar,
					satuan_uuid_kecil: obats[i].satuan_uuid_kecil,
					nama_satuan_kecil: obats[i].nama_satuan_kecil,
					hitung_besar: obats[i].hitung_besar,
					hitung_kecil: obats[i].hitung_kecil,
					harga_netto: parseInt(obats[i].harga_netto),
					harga_netto_discount: parseInt(obats[i].harga_netto_discount),
					harga_netto_ppn: parseInt(obats[i].harga_netto_ppn),
					hpp: parseInt(obats[i].hpp),
					margin_resep: obats[i].margin_resep,
					margin_non_resep: obats[i].margin_non_resep,
					hja_resep: parseInt(obats[i].hja_resep),
					hja_non_resep: parseInt(obats[i].hja_non_resep),
					hja_resep_besar: parseInt(obats[i].hja_resep_besar),
					hja_non_resep_besar: parseInt(obats[i].hja_non_resep_besar),
					jumlah_kecil: obats[i].jumlah_kecil,
					jumlah_besar: obats[i].jumlah_besar,
					signa: obats[i].signa,
					total: obats[i].total,
				}
				vm.listobat.push(tmp);
			}

			vm.templistobat = vm.listobat;

			let obatsracikan = response.data.obatracikan;
			for (let i = 0; i < obatsracikan.length; i++){

				let tmp = {
					label: obatsracikan[i].label,
					kemasan: obatsracikan[i].kemasan,
					jumlah: obatsracikan[i].jumlah,
					signa: obatsracikan[i].signa,
					total: obatsracikan[i].total,
					informasi: JSON.parse(obatsracikan[i].informasi)
				}
				vm.listobatracikan.push(tmp);
			}
			console.log(vm.listobat, 'fdfdf')

			let obatstambahan = response.data.obattambahan;
			for (let i = 0; i < obatstambahan.length; i++) {

				let _total = parseInt(obatstambahan[i].quantity) * parseInt(obatstambahan[i].harga);
				let tmp = {
					nama: obatstambahan[i].nama_obat,
					obat_uuid: obatstambahan[i].obat_uuid,
					kategori: obatstambahan[i].kategori,
					formularium: obatstambahan[i].formularium,
					golongan: obatstambahan[i].golongan,
					satuan_uuid_besar: obatstambahan[i].satuan_uuid_besar,
					nama_satuan_besar: obatstambahan[i].nama_satuan_besar,
					satuan_uuid_kecil: obatstambahan[i].satuan_uuid_kecil,
					nama_satuan_kecil: obatstambahan[i].nama_satuan_kecil,
					hitung_besar: obatstambahan[i].hitung_besar,
					hitung_kecil: obatstambahan[i].hitung_kecil,
					harga_netto: parseInt(obatstambahan[i].harga_netto),
					harga_netto_discount: parseInt(obatstambahan[i].harga_netto_discount),
					harga_netto_ppn: parseInt(obatstambahan[i].harga_netto_ppn),
					hpp: parseInt(obatstambahan[i].hpp),
					margin_resep: obatstambahan[i].margin_resep,
					margin_non_resep: obatstambahan[i].margin_non_resep,
					hja_resep: parseInt(obatstambahan[i].hja_resep),
					hja_non_resep: parseInt(obatstambahan[i].hja_non_resep),
					hja_resep_besar: parseInt(obatstambahan[i].hja_resep_besar),
					hja_non_resep_besar: parseInt(obatstambahan[i].hja_non_resep_besar),
					jumlah_kecil: obatstambahan[i].jumlah_kecil,
					jumlah_besar: obatstambahan[i].jumlah_besar,
					signa: obatstambahan[i].signa,
					total: obatstambahan[i].total,
				}
				vm.listobattambahan.push(tmp);
			}
			vm.templistobattambahan = vm.listobattambahan;

			

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
      vm.$emit('dialog', text, button, 'editobat');
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