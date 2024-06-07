<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Detail Data Pemeriksaan Dokter</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">

					<div class="col-12">
						
						<div class="tab-lines"><div class="tab" style="width: 100%;"><button v-for="(item, index) in tab.button" :class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button></div></div>
		
						
						<div class="tab-content">
							

							<div class="content-tab-in" v-if="tab.content.tindakan">
								<div class="grid">
									<div class="col-4">
										<Inputed :ref="form.nokwitansi.name" :form="form.nokwitansi"></Inputed>
									</div>
									<div class="col-4 form-ml">
										<Inputed :ref="form.noinvoice.name" :form="form.noinvoice"></Inputed>
									</div>
									<div class="col-4 form-ml">
										<Inputed :ref="form.nopendaftaran.name" :form="form.nopendaftaran"></Inputed>
									</div>
									
									<div class="col-4">
										<Inputed :ref="form.tanggalpendaftaran.name" :form="form.tanggalpendaftaran"></Inputed>
									</div>
									<div class="col-4 form-ml">
										<Inputed :ref="form.tanggalcetak.name" :form="form.tanggalcetak"></Inputed>
									</div>
									<div class="col-4 form-ml">
										<Inputed :ref="form.tanggalselesai.name" :form="form.tanggalselesai"></Inputed>
									</div>

									<div class="col-6">
										<Selected v-on:click="selectbox($event, form.select.carabayar.name, form.select.carabayar.statics)" 
											:ref="form.select.carabayar.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.carabayar" v-on:keyup="selectfilter($event, form.select.carabayar.name)"></Selected>
									</div>
									<div class="col-6 form-ml">
										<Selected v-on:click="selectbox($event, form.select.asuransi.name, form.select.asuransi.statics)" 
											:ref="form.select.asuransi.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.asuransi" v-on:keyup="selectfilter($event, form.select.asuransi.name)"></Selected>
									</div>
									<div class="col-12">
										<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
											:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>
									</div>
									<div class="col-12">
										<Selected v-on:click="selectbox($event, form.select.paketbedah.name, form.select.paketbedah.statics)" 
											:ref="form.select.paketbedah.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.paketbedah" v-on:keyup="selectfilter($event, form.select.paketbedah.name)"></Selected>
									</div>
									<div class="col-12">

										<Selected v-on:click="selectbox($event, form.select.carabayartindakanrawatjalan.name, form.select.carabayartindakanrawatjalan.statics)" 
											:ref="form.select.carabayartindakanrawatjalan.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.carabayartindakanrawatjalan" v-on:keyup="selectfilter($event, form.select.carabayartindakanrawatjalan.name)"
											></Selected>
									
										<table class="table">
											<thead>
												<tr>
													<th>Nama Tindakan</th>
													<th>Biaya</th>
													<th>#</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in listdata" v-if="listdata.length > 0">
													<td>{{ item.nama_tindakan_rawat_jalan }}</td>
													<td>{{ formatrupiah(item.harga.toString()) }}</td>
													<td>
														<button v-if="item.default != 'Ya'" class="tooltip btn-danger" v-on:click="removetindakan(index)">
															<vue-feather type="trash"></vue-feather> 
															<span class="tooltiptext">Hapus Tindakan</span>
														</button>
													</td>
												</tr>
												<tr v-else>
													<td colspan="3">No Data for Result</td>
												</tr>
												<tr v-if="listdata.length > 0">
													<td>Total</td>
													<td colspan="2">{{ formatrupiah(totalbiaya.toString()) }}</td>
												</tr>
											</tbody>
											
										</table>

										<Inputed :ref="form.catatan.name" :form="form.catatan" style="margin-top: 36px"></Inputed>
										
									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.resep">
								<div class="grid">
									
									<div class="col-5 form-mr">
										<Selected v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)" 
											:ref="form.select.apotek.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.apotek" v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
									</div>
									<div class="col-3 form-mr form-ml">
										<Inputed :ref="form.quantity.name" :form="form.quantity"></Inputed>
									</div>
									<div class="col-3 form-mr form-ml">
										<Inputed :ref="form.signa.name" :form="form.signa"></Inputed>
									</div>
									<div class="col-1">
										<button class="tooltip btn-danger" v-on:click="additemobat()" style="margin-top: 20px">
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
												<tr v-for="(item, index) in listobat" v-if="listobat.length > 0">
													<td>{{ item.nama }}</td>
													<td>{{ item.signa }}</td>
													<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
													<td>{{ formatrupiah(item.hja_resep.toString()) }}</td>
													<td>{{ formatrupiah(item.total.toString()) }}</td>
													<td>
														<button class="tooltip btn-danger" v-on:click="removeobat(index)">
															<vue-feather type="trash"></vue-feather> 
															<span class="tooltiptext">Hapus Obat</span>
														</button>
													</td>
												</tr>
												<tr v-else>
													<td colspan="3">No Data for Result</td>
												</tr>
												<tr v-if="listobat.length > 0">
													<td colspan="4">Grant Total</td>
													<td colspan="2">{{ formatrupiah(totalobat.toString()) }}</td>
												</tr>
											</tbody>
											
										</table>
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
						<!-- <button class="button-modal-page button-modal-red" v-on:click="pendingbutton()">{{ pendings }}</button> -->
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

	<div style=""></div>
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
import { updatedbdokter } from '../../../module/Indexdb.js';

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {toast, Swal,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		Textarea: defineAsyncComponent(() => import('../../../section/Textarea.vue')),
	},
	computed: {
		
		htgquantity:function() {
			console.log(vm.tempobatracikan)
			if (vm.tempobatracikan) {
				let hasil = (vm.form.dosisdiperlukan.value * vm.listobatracikan[vm.index_racikan].jumlah) / vm.form.komposisi.value;
				let m = Math.ceil(hasil);
				vm.quantity_racikan = m;
				if (m == hasil) {
					return "Quantity obat yang digunakan sebanyak " + hasil + " " + vm.tempobatracikan.nama_satuan_kecil;
				}
				return "Quantity obat yang digunakan sebanyak " + hasil + " dibulatkan menjadi " + m  + " " + vm.tempobatracikan.nama_satuan_kecil;
			}
			return '-';
		},
		ishide:function() {
			if (vm.test) { vm.red = 'Cancel'; }
			return vm.test ? false : true;
		},
		totalbiaya:function() {
			let temp = 0;
			for (let i = 0; i < vm.listdata.length; i++) {
				temp += parseInt(vm.listdata[i].harga);
			}
			let ab = parseInt(temp);
			return ab;
		},
		totalbiayajalan:function() {
			let temp = 0;
			for (let i = 0; i < vm.listdatajalan.length; i++) {
				temp += parseInt(vm.listdatajalan[i].harga);
			}
			let ab = parseInt(temp);
			return ab;
		},
		totalobat:function() {
			let temp = 0;
			for (let i = 0; i < vm.listobat.length; i++) {
				temp += parseInt(vm.listobat[i].total);
			}
			let ab = parseInt(temp);
			return ab;
		},
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formkelurahan();
		vm.arr = vm.arrpemeriksaan();
		window.addEventListener("click", function(event) { 
			let a = event.target.className; 
			try { 
				if (a.split(" ")) { 
					a = a.split(" "); 
					if (a[0] != 'hospitals') { vm.selecthide(); } 
				} 
				if (event.target.className == '') { vm.selecthide(); } 
			} 
			catch { console.log('mistmatch'); } });
	},
	created:function() {},
	data:function() { return { 
		title_racikan: '',
		index_racikan: 0,
		quantity_racikan: 0,
		listdata: [], listdatajalan: [], listobat: [], tempobat: null, listobatracikan: [], tempobatracikan: null,
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', arr: null,
		green: 'Save Data', red: 'Clear Form', pendings: 'Ubah Menjadi Pending', test: null, cover: '', temporer: null,
		pemeriksaanro: null,
		datakamar: null,
		detail : { uuid: '',
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: ''
		},
		// { value: 'racikan', label: 'Racikan', class: 'tab-no-active' },
		tab: {
			button: [
					{ value: 'tindakan', label: 'Tindakan/Layanan', class: 'tab-active' },
					{ value: 'resep', label: 'Resep', class: 'tab-no-active' },
			],
			// racikan: false,
			content: { tindakan: true, resep: false, }
		},
		typingTimer: null,
		doneTypingInterval: 5000
	}},
	methods: {
		updatedbdokter,
		formatrupiah,
		removetindakan:function(index) {
			vm.listdata.splice(index, 1);
		},

		removetindakanjalan:function(index) {
			vm.listdatajalan.splice(index, 1);
		},

		removeobat:function(index) {
			vm.listobat.splice(index, 1);
		},

		removeobatracikan:function(index) {
			vm.listobatracikan.splice(index, 1);
			vm.title_racikan = '';
			vm.index_racikan = '';
		},

		removeobatracikandetail:function(index, indexin) {
			let _total = vm.listobatracikan[index].informasi[index].total;
			vm.listobatracikan[index].total = parseInt(vm.listobatracikan[index].total) - parseInt(_total);
			vm.listobatracikan[index].informasi.splice(indexin, 1);
		},

		pendingbutton:function() {
			if (vm.form.panjar.value != '' && vm.form.panjar.value != ' ') {
				vm.form.ispending = 'yes';
				vm.action();
			}
			
		},

		additemobat:function() {
			console.log(vm.tempobat)
			if (vm.tempobat) {
				let _total = parseInt(vm.form.quantity.value) * parseInt(vm.tempobat.hja_resep);
				let tmp = {
					obat_uuid: vm.tempobat.obat_uuid,
					nama: vm.tempobat.nama,
					kategori: vm.tempobat.kategori,
					formularium: vm.tempobat.formularium,
					golongan: vm.tempobat.golongan,
					satuan_uuid_besar: vm.tempobat.satuan_uuid_besar,
					nama_satuan_besar: vm.tempobat.nama_satuan_besar,
					satuan_uuid_kecil: vm.tempobat.satuan_uuid_kecil,
					nama_satuan_kecil: vm.tempobat.nama_satuan_kecil,
					hitung_besar: vm.tempobat.hitung_besar,
					hitung_kecil: vm.tempobat.hitung_kecil,
					harga_netto: parseInt(vm.tempobat.harga_netto),
					harga_netto_discount: parseInt(vm.tempobat.harga_netto_discount),
					harga_netto_ppn: parseInt(vm.tempobat.harga_netto_ppn),
					hpp: parseInt(vm.tempobat.hpp),
					margin_resep: vm.tempobat.margin_resep,
					margin_non_resep: vm.tempobat.margin_non_resep,
					hja_resep: parseInt(vm.tempobat.hja_resep),
					hja_non_resep: parseInt(vm.tempobat.hja_non_resep),
					hja_resep_besar: vm.tempobat.hja_resep_besar,
					hja_non_resep_besar: vm.tempobat.hja_non_resep_besar,
					jumlah_kecil: vm.form.quantity.value,
					jumlah_besar: parseFloat(vm.form.quantity.value/vm.tempobat.hitung_kecil),
					signa: vm.form.signa.value,
					total: parseInt(_total),
				}
				vm.listobat.push(tmp);
				vm.tempobat = null;
				vm.form.signa.value = '';
				vm.form.quantity.value = '';
				vm.form.select.apotek.value = '';
				vm.form.select.apotek.label = 'Silahkan Pilih';
			}
		},

		showobatracikan:function(item, index) {
			vm.title_racikan = item.label;
			vm.index_racikan = index;
		},

		additemobatracikan:function() {
			//console.log(vm.tempobatracikan)
			if (vm.form.labelracikan.value != '' && vm.form.jeniskemasan.value != '' && vm.form.jumlahkemasan.value != ''
					&& vm.form.signaracikan.value != '') {
				let tmp = {
					label: vm.form.labelracikan.value,
					kemasan: vm.form.jeniskemasan.value,
					jumlah: vm.form.jumlahkemasan.value,
					signa: vm.form.signaracikan.value,
					total: 0,
					informasi: []
				}
				vm.listobatracikan.push(tmp);
				vm.form.labelracikan.value = '';
				vm.form.jeniskemasan.value = '';
				vm.form.jumlahkemasan.value = '';
				vm.form.signaracikan.value = '';
			}
		},

		closeform:function() {
			vm.title_racikan = '';
			vm.index_racikan = 0;
		},

		additemobatracikandetail:function() {
			
			if (vm.tempobatracikan) {
				vm.quantity_racikan = 1;
				let _total = parseInt(vm.quantity_racikan) * parseInt(vm.tempobatracikan.hja_resep);
				let tmp = {
					obat_uuid: vm.tempobatracikan.obat_uuid,
					nama: vm.tempobatracikan.nama,
					kategori: vm.tempobatracikan.kategori,
					formularium: vm.tempobatracikan.formularium,
					golongan: vm.tempobatracikan.golongan,
					jenis: vm.tempobatracikan.jenis,
					satuan_uuid_besar: vm.tempobatracikan.satuan_uuid_besar,
					nama_satuan_besar: vm.tempobatracikan.nama_satuan_besar,
					satuan_uuid_kecil: vm.tempobatracikan.satuan_uuid_kecil,
					nama_satuan_kecil: vm.tempobatracikan.nama_satuan_kecil,
					hitung_besar: vm.tempobatracikan.hitung_besar,
					hitung_kecil: vm.tempobatracikan.hitung_kecil,
					harga_netto: parseInt(vm.tempobatracikan.harga_netto),
					harga_netto_discount: parseInt(vm.tempobatracikan.harga_netto_discount),
					harga_netto_ppn: parseInt(vm.tempobatracikan.harga_netto_ppn),
					hpp: parseInt(vm.tempobatracikan.hpp),
					margin_resep: vm.tempobatracikan.margin_resep,
					margin_non_resep: vm.tempobatracikan.margin_non_resep,
					hja_resep: parseInt(vm.tempobatracikan.hja_resep),
					hja_non_resep: parseInt(vm.tempobatracikan.hja_non_resep),
					hja_resep_besar: parseInt(vm.tempobatracikan.hja_resep_besar),
					hja_non_resep_besar: parseInt(vm.tempobatracikan.hja_non_resep_besar),
					jumlah_kecil: 1,
					jumlah_besar: parseFloat(vm.quantity_racikan/vm.tempobatracikan.hitung_kecil),
					komposisi: vm.tempobatracikan.jenis == 'Obat' ? vm.form.komposisi.value : '-',
					satuan_komposisi_uuid: vm.tempobatracikan.jenis == 'Obat' ? vm.form.select.satuankomposisi.value : '-',
					nama_satuan_komposisi: vm.tempobatracikan.jenis == 'Obat' ? vm.form.select.satuankomposisi.label : '-',
					dosis_diperlukan: vm.tempobatracikan.jenis == 'Obat' ? vm.form.dosisdiperlukan.value : '-',
					satuan_diperlukan: vm.tempobatracikan.jenis == 'Obat' ? vm.form.select.satuandiperlukan.value : '-',
					satuan_diperlukan_uuid: vm.tempobatracikan.jenis == 'Obat' ? vm.form.select.satuandiperlukan.value : '-',
					nama_satuan_diperlukan: vm.tempobatracikan.jenis == 'Obat' ? vm.form.select.satuandiperlukan.label : '-',
					total: _total,
				}
				console.log(vm.listobatracikan[vm.index_racikan], 'Balbala')
				console.log(_total, 'Balbala')
				
				vm.listobatracikan[vm.index_racikan].informasi.push(tmp);
				vm.listobatracikan[vm.index_racikan].total = parseInt(vm.listobatracikan[vm.index_racikan].total) + parseInt(_total);
				
				vm.form.komposisi.value = '';
				vm.form.select.satuankomposisi.value = '';
				vm.form.select.satuankomposisi.label = 'Silahkan Pilih';
				vm.form.dosisdiperlukan.value = '';
				vm.form.select.satuandiperlukan.value = '';
				vm.form.select.satuandiperlukan.label = 'Silahkan Pilih';
				vm.tempobatracikan = null;
				
				vm.form.select.apotekracikan.value = '';
				vm.form.select.apotekracikan.label = 'Silahkan Pilih';
				vm.quantity_racikan = 0;
				vm.title_racikan = '';
				vm.index_racikan = 0;
			}
		},

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

			if (values == 'rawatinapjalan') {
				vm.form.inapjalan = 'aktif';
			}
			else {
				vm.form.inapjalan = 'aktif';''
			}
		},

		parsekelurahan, formkelurahan, initindexdb, indexdbprocessing, arrpemeriksaan, datename,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { 
			vm.form = vm.filterselected(vm.form, key); 
		},

		selectfilter: function (event, jambu, key) { 
			
			vm.form = vm.filterselected(vm.form, jambu); 
			// let nilai = event.target.value;
			// vm.form.select[jambu].dosearch = true;
			// 	if (this.typingTimer) {
			// 		clearTimeout(this.typingTimer);
			// 		this.typingTimer = null;
			// 	}
			// 	this.typingTimer = setTimeout(() => {
			// 		vm.doneTyping(nilai, key, jambu)
			// 	}, 1500);
		},
		// doneTyping:function(nilai, key, jambu) {
		// 	console.log(vm.detail.carabayar_nama, ' ', vm.detail.carabayar_uuid)
			
		// 	let formdata = new FormData();
		// 	formdata.append('search', nilai);
		// 	formdata.append('key', key);
		// 	formdata.append('carabayar_uuid', vm.detail.carabayar_uuid);
		// 	axios.post('/searchion/searching', formdata, 
		// 		{ headers: { 'Content-Type': 'multipart/form-data' } }
		// 	).then(function (response) { 
		// 		setTimeout(function(){ 
		// 			vm.form.select[jambu].dosearch = false; 
		// 			vm.form.select[jambu].filter = response.data;
		// 		}, 150, this); 
		// 	}).catch(function (error) { 
		// 		setTimeout(function(){ vm.form.select[jambu].dosearch = false; console.log(error); }, 150, this); 
		// 	});
		// },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key); 

			if (key == 'carabayartindakanrawatjalan') {
				let _item = {
					nama_tindakan_rawat_jalan: item.nama_tindakan_rawat_jalan,
					tindakan_rawat_jalan_uuid: item.tindakan_rawat_jalan_uuid,
					default: item.default,
					harga: parseInt(item.harga),
				}

				vm.listdata.push(_item);

				vm.form.select.carabayartindakanrawatjalan.value = '';
				vm.form.select.carabayartindakanrawatjalan.label = 'Silahkan Pilih';
			}
			if (key == 'carabayartindakanrawatjalanjalan') {
				let _item = {
					nama_tindakan_rawat_jalan: item.nama_tindakan_rawat_jalan,
					tindakan_rawat_jalan_uuid: item.tindakan_rawat_jalan_uuid,
					default: item.default,
					harga: parseInt(item.harga),
				}

				vm.listdatajalan.push(_item);

				vm.form.select.carabayartindakanrawatjalanjalan.value = '';
				vm.form.select.carabayartindakanrawatjalanjalan.label = 'Silahkan Pilih';
			}
			else if (key == 'apotek') {
				vm.tempobat = item;
			}
			else if (key == 'apotekracikan') {
				vm.tempobatracikan = item;
			}
			else if (key == 'paketbedah') {
				vm.form.hargapaket = item.total;
			}
			else if (key == 'paketbedahbedah') {
				vm.form.hargabedahpaket = item.total;
			}
			else if (key == 'carabayar') {
				vm.form.carabayar_nama = item.nama;
				vm.getIndexDB('asuransi', false);
			}
			else if (key == 'carabayarbedah') {
				vm.getIndexDB('asuransibedah', false);
			}
			else if (key == 'kamarinap') {
				vm.datakamar = item;
			}
			else if (key == 'kamarinapjalan') {
				vm.datakamarjalan = item;
			}
		},
		selectclear:function(key) { 
			
			vm.form = vm.clearselected(vm.form, key);
			if (key == 'apotek') {
				vm.tempobat = null;
			}
			else if (key == 'apotekracikan') {
				vm.tempobatracikan = null;
			}
			else if (key == 'paketbedah') {
				vm.form.hargapaket = '';
			}
			else if (key == 'paketbedahbedah') {
				vm.form.hargabedahpaket = '';
			}
			else if (key == 'kamarinap') {
				vm.datakamar = null;
			}
			else if (key == 'kamarinapjalan') {
				vm.datakamarjalan = null;
			}
			else if (key == 'carabayar') {
				vm.form.select.asuransi.disabled = true;
				vm.form.select.asuransi.isrequired = false;
				vm.form.select.asuransi.value = '';
				vm.form.select.asuransi.Label = 'Silahkan Pilih';
			}
			else if (key == 'carabayarbedah') {
				vm.form.select.asuransibedah.disabled = true;
				vm.form.select.asuransibedah.isrequired = false;
				vm.form.select.asuransibedah.value = '';
				vm.form.select.asuransibedah.Label = 'Silahkan Pilih';
			}
		},
		selectbox:function(event, key, statics) {
			let msg = 'select-close select-close-'+key;
			if (event.target.className != msg) {
				if (!vm.form.select[key].disabled) {
					let result = vm.boxselected(event, vm.form, key);
					if (result._position == 'stop') { return ; }
					else if (result._position == 'nextstop') { vm.form = result._form; }
					else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
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

						if (vm.form.select.asuransibedah.data.length < 1) {
							vm.form.select.asuransibedah.disabled = true;
							vm.form.select.asuransibedah.value = '';
							vm.form.select.asuransibedah.label = 'Silahkan Pilih';
							vm.form.select.asuransibedah.isrequired = false;
						}
						else if (vm.form.select.asuransibedah.data.length > 0) {
							vm.form.select.asuransibedah.disabled = false;
							vm.form.select.asuransibedah.isrequired = true;
						}
					})
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

			//if (vm.listdata.length < 1 || vm.listobat.length < 1) { next = false; }
			//if (vm.listdata.length < 1) { next = false; }
			
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
			vm.listdata = [];
			vm.listdatajalan = [];
			vm.listobat = [];
			vm.tempobat = null;
			vm.listobatracikan = [];
			vm.tempobatracikan = null;
			vm.pemeriksaanro = null;
			vm.datakamar = null;
			vm.datakamarjalan = null;
			vm.detail = { uuid: '',
				agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
				kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
				nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
				rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: '', tanggal: ''
			}
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content.tindakan = true;
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			// for (let i = 0; i < vm.listdata.length; i++) {
			// 	vm.listdata[i].harga = vm.listdata[i].harga.replace(/\D/g, "");
			// }

			// for (let i = 0; i < vm.listdatajalan.length; i++) {
			// 	vm.listdatajalan[i].harga = vm.listdatajalan[i].harga.replace(/\D/g, "");
			// }

			// for (let i = 0; i < vm.listobat.length; i++) {
			// 	vm.listobat[i].hja_resep = vm.listobat[i].hja_resep.replace(/\D/g, "");
			// 	vm.listobat[i].total = vm.listobat[i].total.replace(/\D/g, "");
			// }

			let testing = [];

			for (let i = 0; i < vm.listobatracikan.length; i++) {
				let tmp = {
					label: vm.listobatracikan[i].label,
					kemasan: vm.listobatracikan[i].kemasan,
					jumlah: vm.listobatracikan[i].jumlah,
					signa: vm.listobatracikan[i].signa,
					total: vm.listobatracikan[i].total,
					informasi: JSON.stringify(vm.listobatracikan[i].informasi)
				}
				testing.push(tmp);
			}

			if (vm.datakamar) {
				vm.form.kamar_inap_uuid = vm.datakamar.uuid;
				vm.form.kamar_inap_nama = vm.datakamar.nama;
				vm.form.kamar_inap_lantai = vm.datakamar.lantai;
				vm.form.kamar_inap_jumlah_bed = vm.datakamar.jumlah_bed;
				vm.form.jenis_kamar_uuid = vm.datakamar.jenis_kamar_uuid;
				vm.form.nama_jenis_kamar = vm.datakamar.nama_jenis_kamar;
			}
			else {
				vm.form.kamar_inap_uuid = '';
				vm.form.kamar_inap_nama = '';
				vm.form.kamar_inap_lantai = '';
				vm.form.kamar_inap_jumlah_bed = '';
				vm.form.jenis_kamar_uuid = '';
				vm.form.nama_jenis_kamar = '';
			}

			if (vm.datakamarjalan) {
				vm.form.kamar_inap_jalan_uuid = vm.datakamarjalan.uuid;
				vm.form.kamar_inap_jalan_nama = vm.datakamarjalan.nama;
				vm.form.kamar_inap_jalan_lantai = vm.datakamarjalan.lantai;
				vm.form.kamar_inap_jalan_jumlah_bed = vm.datakamarjalan.jumlah_bed;
				vm.form.jenis_kamar_jalan_uuid = vm.datakamarjalan.jenis_kamar_uuid;
				vm.form.nama_jenis_jalan_kamar = vm.datakamarjalan.nama_jenis_kamar;
			}
			else {
				vm.form.kamar_inap_jalan_uuid = '';
				vm.form.kamar_inap_jalan_nama = '';
				vm.form.kamar_inap_jalan_lantai = '';
				vm.form.kamar_inap_jalan_jumlah_bed = '';
				vm.form.jenis_kamar_jalan_uuid = '';
				vm.form.nama_jenis_jalan_kamar = '';
			}

			//alert('sdf');
			vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detail, vm.listdata, vm.listdatajalan, vm.listobat, testing), 'add'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			
			console.log(response.data)

			console.log(response.data.data.nama_paket_bedah)
			if (response.data.data) {
				if (response.data.data.nama_paket_bedah != '-') {
					vm.form.select.paketbedah.value = response.data.data.paket_bedah_uuid;
					vm.form.select.paketbedah.label = response.data.data.nama_paket_bedah;
				}
				else {
					vm.form.select.paketbedah.value = '';
					vm.form.select.paketbedah.label = 'Silahkan Pilih';
				}
			}

			let keys = [ 'carabayartindakanrawatjalan', 'tindakanrawatjalan', 'apotek', 'apotekracikan', 'paketbedah', 'carabayar', 'asuransi']

			/* Setting index DB */
			vm.updatedblocal(keys, response);


			vm.detail = response.data.data;
			vm.form.carabayar_nama = vm.detail.carabayar_nama;
			vm.histori = response.data.histori;
			vm.pemeriksaanro = response.data.pemeriksaanro;

			if (vm.detail.panjar != '0') {
				vm.form.panjar.value = vm.detail.panjar;
				if (vm.detail.approve_panjar == '1') {
					vm.form.panjar.disabled = true;
				}
			}

			//vm.listdata = response.data.layanan;

			for (let i = 0; i < response.data.layanan.length; i++){
				let _item = {
					nama_tindakan_rawat_jalan: response.data.layanan[i].nama_layanan,
					tindakan_rawat_jalan_uuid: response.data.layanan[i].layanan_uuid,
					default: response.data.layanan[i].default,
					harga: parseInt(response.data.layanan[i].tarif),
				}

				vm.listdata.push(_item);
			}

			let a = response.data.layananjalan;

			if (response.data.layananjalan) {
				for (let i = 0; i < response.data.layananjalan.length; i++){
					let _item = {
						nama_tindakan_rawat_jalan: response.data.layananjalan[i].nama_layanan,
						tindakan_rawat_jalan_uuid: response.data.layananjalan[i].layanan_uuid,
						default: response.data.layananjalan[i].default,
						harga: parseInt(response.data.layananjalan[i].tarif),
					}

					vm.listdatajalan.push(_item);
				}
			}

			if (vm.detail.kamar_inap_uuid != '-' && vm.detail.kamar_inap_uuid != '') {
				vm.form.kamar_inap_jalan_uuid = vm.detail.kamar_inap_uuid;
				vm.form.kamar_inap_jalan_nama = vm.detail.kamar_inap_nama;
				vm.form.kamar_inap_jalan_lantai = vm.detail.kamar_inap_lantai;
				vm.form.kamar_inap_jalan_jumlah_bed = vm.detail.kamar_inap_jumlah_bed;
				vm.form.jenis_kamar_jalan_uuid = vm.detail.jenis_kamar_uuid;
				vm.form.nama_jenis_jalan_kamar = vm.detail.nama_jenis_kamar;

				vm.form.select.kamarinapjalan.value = vm.detail.kamar_inap_uuid;
				vm.form.select.kamarinapjalan.label = vm.detail.nama_jenis_kamar + ' - ' + vm.detail.kamar_inap_nama;

				vm.datakamarjalan = {
						uuid: vm.detail.kamar_inap_uuid,
						nama: vm.detail.kamar_inap_nama,
						lantai: vm.detail.kamar_inap_lantai,
						jumlah_bed: vm.detail.kamar_inap_jumlah_bed,
						jenis_kamar_uuid: vm.detail.jenis_kamar_uuid,
						nama_jenis_kamar: vm.detail.nama_jenis_kamar,
				}

			}
			
			
			let obats = response.data.obat;
			for (let i = 0; i < obats.length; i++){

				let _total = parseInt(obats[i].quantity) * parseInt(obats[i].harga);
				let tmp = {
					obat_uuid: obats[i].obat_uuid,
					nama: obats[i].nama_obat,
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
					hja_resep_besar: obats[i].hja_resep_besar,
					hja_non_resep_besar: obats[i].hja_non_resep_besar,
					jumlah_kecil: obats[i].jumlah_kecil,
					jumlah_besar: obats[i].jumlah_besar,
					signa: obats[i].signa,
					total: parseInt(obats[i].total),
				}
				vm.listobat.push(tmp);
			}

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

			// let onedaycare = response.data.onedaycare;

			// if (onedaycare) {
			// 	vm.form.select.paketbedah.value = onedaycare.layanan_uuid;
			// 	vm.form.select.paketbedah.label = onedaycare.nama_layanan;
			// 	vm.form.hargapaket = onedaycare.tarif;
			// 	vm.form.keteranganbedah.value = onedaycare.keterangan;
			// 	vm.form.penjadwalanodc.value = onedaycare.tanggal;
			// 	vm.form.waktuodc.value = onedaycare.waktu;
			// 	vm.form.select.carabayar.value = onedaycare.carabayar_uuid;
			// 	vm.form.select.carabayar.label = onedaycare.carabayar_nama;
			// 	vm.form.select.asuransi.value = onedaycare.asuransi_uuid;
			// 	vm.form.select.asuransi.label = onedaycare.nama_asuransi;
			// }
			// else {
			// 	vm.form.select.paketbedah.value = '';
			// 	vm.form.select.paketbedah.label = 'Silahkan Pilih';
			// 	vm.form.hargapaket = '';
			// 	vm.form.keteranganbedah.value = '';
			// 	vm.form.penjadwalanodc.value = '';
			// 	vm.form.waktuodc.value = '';
			// 	vm.form.select.carabayar.value = '';
			// 	vm.form.select.carabayar.label = 'Silahkan Pilih';
			// 	vm.form.select.asuransi.value = '';
			// 	vm.form.select.asuransi.label = 'Silahkan Pilih';
			// }

			let temps = response.data.kunjungan;

			if (temps) {
				vm.form.uuid = temps.uuid;

				vm.form.catatan.value = vm.nullcheck(vm.detail.catatan)
				vm.form.posisibolamata.value = vm.nullcheck(temps.posisi_bola_mata)
				vm.form.pergerakanbolamata.value = vm.nullcheck(temps.pergerakan_bola_mata)
				vm.form.pemeriksaanprognosa.value = vm.nullcheck(temps.pemeriksaan_prognosa)
				vm.form.pemeriksaanpenunjang.value = vm.nullcheck(temps.pemeriksaan_penunjang)
				vm.form.pemeriksaantatalaksana.value = vm.nullcheck(temps.pemeriksaan_tata_laksana)
				vm.form.oculardextrapalpebra.value = vm.nullcheck(temps.ocular_dextra_palpebra)
				vm.form.oculardextraconjunctiva.value = vm.nullcheck(temps.ocular_dextra_conjunctiva)
				vm.form.oculardextracornea.value = vm.nullcheck(temps.ocular_dextra_cornea)
				vm.form.oculardextralensa.value = vm.nullcheck(temps.ocular_dextra_lensa)
				vm.form.oculardextravitreous.value = vm.nullcheck(temps.ocular_dextra_vitreous)
				vm.form.oculardextrafunduscopy.value = vm.nullcheck(temps.ocular_dextra_funduscopy)
				vm.form.oculardextrabilikmatadepan.value = vm.nullcheck(temps.ocular_dextra_bilik_mata_depan)
				vm.form.oculardextrapupildaniris.value = vm.nullcheck(temps.ocular_dextra_pupil_dan_iris)
				vm.form.ocularsinistrapalpebra.value = vm.nullcheck(temps.ocular_sinistra_palpebra)
				vm.form.ocularsinistraconjunctiva.value = vm.nullcheck(temps.ocular_sinistra_conjunctiva)
				vm.form.ocularsinistracornea.value = vm.nullcheck(temps.ocular_sinistra_cornea)
				vm.form.ocularsinistralensa.value = vm.nullcheck(temps.ocular_sinistra_lensa)
				vm.form.ocularsinistravitreous.value = vm.nullcheck(temps.ocular_sinistra_vitreous)
				vm.form.ocularsinistrafunduscopy.value = vm.nullcheck(temps.ocular_sinistra_funduscopy)
				vm.form.ocularsinistrabilikmatadepan.value = vm.nullcheck(temps.ocular_sinistra_bilik_mata_depan)
				vm.form.ocularsinistrapupildaniris.value = vm.nullcheck(temps.ocular_sinistra_pupil_dan_iris)

				if (vm.nullcheck(temps.pemeriksaan_diagnosa) == '') {
					vm.form.select.icd10.value = '';
					vm.form.select.icd10.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.icd10.value = vm.nullcheck(temps.pemeriksaan_diagnosa_kode);
					vm.form.select.icd10.label = vm.nullcheck(temps.pemeriksaan_diagnosa);
				}

				if (vm.nullcheck(temps.pemeriksaan_tindakan) == '') {
					vm.form.select.icd9.value = '';
					vm.form.select.icd9.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.icd9.value = vm.nullcheck(temps.pemeriksaan_tindakan_kode);
					vm.form.select.icd9.label = vm.nullcheck(temps.pemeriksaan_tindakan);
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

		setlocalstorage: function () {
			if (window.localStorage.getItem("version") === null) { window.localStorage.setItem("version", 1); }
			else { let tmp = window.localStorage.getItem("version"); window.localStorage.setItem("version", (parseInt(tmp)+1)); }
		},

		updatedblocal: function(keys, response) {
			vm.setlocalstorage();

			const open = window.indexedDB.open(vm.$dbNameIndexDb, window.localStorage.getItem("version"));
			open.onupgradeneeded = (event) => {
				let db = open.result;
				for (let i = 0; i < keys.length; i++) {
					if( db.objectStoreNames.contains(keys[i]) ){
						db.deleteObjectStore(keys[i]);
					}
				}
			}
			open.onsuccess = function () { open.result.close(); setTimeout(() => { vm.createdIndexDb(response); }, 350, this); };
			open.onerror = function () {
				open.result.close();
				alert('dfs');
				if (vm.count < 3) { setTimeout(() => { vm.updatedblocal(response); }, 350, this); vm.count += 1; }
			};
			open.onblocked = function () { 
				open.result.close();
				alert('bl');
				if (vm.count < 3) { setTimeout(() => { vm.updatedblocal(response); }, 350, this); vm.count += 1; }
			};
		},

		createdIndexDb: function (data) {
			
			vm.setlocalstorage();
			
			vm.updatedbdokter(vm.$dbNameIndexDb, window.localStorage.getItem("version"), data)
				.then(function(response){
					if (response == 'berhasil') {}
				})
				.catch(function(error){
					
					console.log(error);
				});
		},
	}
}
</script>
<style>
.obatracikanclose {
	position: absolute; top: -11px; right: 20px; padding: 0 10px; background: #fff; cursor: pointer; color: #000; font-weight: bold;
}
</style>