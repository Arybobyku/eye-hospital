<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar"
			:class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()" v-if="pembayaran!='Sudah Bayar'">Add or Update</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<div class="tab-lines">
							<div class="tab" style="width: 100%;"><button v-for="(item, index) in tab.button"
									:class="item.class" v-on:click="changesTab(item.value, index, item.class)">{{
									item.label }}</button></div>
						</div>

						<div class="tab-content">
							<div style="position: relative;" class="content-tab-in" v-if="tab.content.nonracikan">
								<div class="grid" v-if="pembayaran != 'Sudah Bayar'">
									<div class="col-5 form">
										<Selected
											v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)"
											:ref="form.select.apotek.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.apotek"
											v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
									</div>
									<div class="col-1 form-ml">
										<Inputed :ref="form.quantity.name" :form="form.quantity"></Inputed>
									</div>
									<div class="col-2 form-ml">
										<Inputed :ref="form.signa.name" :form="form.signa"></Inputed>
									</div>
									<div class="col-2 form-mr">
										<Selected v-on:click="
											selectbox(
												$event,
												form.select.posisimata.name,
												form.select.posisimata
													.statics
											)" :ref="form.select.posisimata.name" @selecteditem="selecteditem" @selectclear="selectclear"
											:selection="form.select.posisimata">
										</Selected>
									</div>
									<div class="col-1">
										<button class="tooltip btn-danger" v-on:click="additemobat()"
											style="margin-top: 20px">
											<vue-feather type="plus"></vue-feather>
											<span class="tooltiptext">Add Item Obat</span>
										</button>
									</div>
								</div>
								<div class="grid">
									<div class="col-12">
										<table class="table">
											<thead>
												<tr>
													<th>Nama Obat</th>
													<th>Signa</th>
													<th>Qty</th>
													<th>Posisi Mata</th>
													<th>Harga</th>
													<th>Total</th>
													<th v-if="pembayaran != 'Sudah Bayar'">#</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in listobat" v-if="listobat.length > 0">
													<td>{{ item.nama }}</td>
													<td>{{ item.signa }}</td>
													<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
													<td> {{ item.posisimata }}</td>
													<td>{{ formatrupiah(item.hja_non_resep.toString()) }}</td>
													<td>{{ formatrupiah(item.total.toString()) }}</td>

													<td v-if="pembayaran != 'Sudah Bayar'">
														<button class="tooltip btn-danger"
															v-on:click="removeobat(index)">
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
													<td colspan="2">{{ totalobat }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div style="position: relative;" class="content-tab-in" v-if="tab.content.racikan">
								<div class="grid">
									<div class="col-3 form-mr">
										<Inputed :ref="form.labelracikan.name" :form="form.labelracikan"></Inputed>
									</div>
									<div class="col-3">
										<Inputed :ref="form.jeniskemasan.name" :form="form.jeniskemasan"></Inputed>
									</div>
									<div class="col-3 form-ml">
										<Inputed :ref="form.jumlahkemasan.name" :form="form.jumlahkemasan"></Inputed>
									</div>
									<div class="col-2 form-ml">
										<Inputed :ref="form.signaracikan.name" :form="form.signaracikan"></Inputed>
									</div>
									<div class="col-1 form-ml">
										<button class="tooltip btn-success" v-on:click="additemobatracikan()"
											style="margin-top: 20px">
											<vue-feather type="plus"></vue-feather>
											<span class="tooltiptext">Add Item Racikan</span>
										</button>
									</div>

									<div class="col-12" v-if="title_racikan != ''">
										<div
											style="position: relative; width: 100%; height: auto; border: 1px solid #811927; border-radius: 8px; padding: 16px; margin-top: 5px; margin-bottom: 16px">
											<span
												style="position: absolute; top: -11px; padding: 0 10px; background: #fff; color: #000; font-weight: bold;">{{
												title_racikan }}</span>
											<span class="obatracikanclose" v-on:click="closeform()">Close form</span>
											<div class="grid">
												<div class="col-11">
													<Selected
														v-on:click="selectbox($event, form.select.apotekracikan.name, form.select.apotekracikan.statics)"
														:ref="form.select.apotekracikan.name"
														@selecteditem="selecteditem" @selectclear="selectclear"
														:selection="form.select.apotekracikan"
														v-on:keyup="selectfilter($event, form.select.apotekracikan.name)">
													</Selected>
												</div>
												<div class="col-1 form-ml">
													<button class="tooltip btn-success"
														v-on:click="additemobatracikandetail()"
														style="margin-top: 20px">
														<vue-feather type="plus"></vue-feather>
														<span class="tooltiptext">Add Obat/Alkes</span>
													</button>
												</div>
												<!-- <template v-if="tempobatracikan && tempobatracikan.jenis == 'Obat'">
													<div class="col-3"><Inputed :ref="form.komposisi.name" :form="form.komposisi"></Inputed></div>
													<div class="col-3 form-ml">
														<Selected v-on:click="selectbox($event, form.select.satuankomposisi.name, form.select.satuankomposisi.statics)" 
															:ref="form.select.satuankomposisi.name" @selecteditem="selecteditem" @selectclear="selectclear"
															:selection="form.select.satuankomposisi" v-on:keyup="selectfilter($event, form.select.satuankomposisi.name)"></Selected>
													</div>
													<div class="col-3 form-ml"><Inputed :ref="form.dosisdiperlukan.name" :form="form.dosisdiperlukan"></Inputed></div>
													<div class="col-3 form-ml">
														<Selected v-on:click="selectbox($event, form.select.satuandiperlukan.name, form.select.satuandiperlukan.statics)" 
															:ref="form.select.satuandiperlukan.name" @selecteditem="selecteditem" @selectclear="selectclear"
															:selection="form.select.satuandiperlukan" v-on:keyup="selectfilter($event, form.select.satuandiperlukan.name)"></Selected>
													</div>
													
													<div class="col-12">
														<div style="background: rgba(107, 114, 21, 0.8); border-radius: 10px; width: 100%; height: auto; padding: 10px; color: #FFF;">
															{{ htgquantity }}
														</div>
													</div>
												</template> -->

											</div>
										</div>
									</div>

									<div class="col-12">
										<table class="table">
											<thead>
												<tr>
													<th>#</th>
													<th>Data Racikan</th>
													<th>Informasi Obat</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in listobatracikan"
													v-if="listobatracikan.length > 0">
													<td>
														<button class="tooltip btn-danger"
															v-on:click="removeobatracikan(index)">
															<vue-feather type="trash"></vue-feather>
															<span class="tooltiptext">Hapus Racikan</span>
														</button>
														<button class="tooltip btn-success"
															v-on:click="showobatracikan(item, index)">
															<vue-feather type="plus"></vue-feather>
															<span class="tooltiptext">Tambah Data Obat</span>
														</button>
													</td>
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
																<tr>
																	<td>Total Biaya</td>
																	<td>{{ formatrupiah(item.total.toString()) }}</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td>
														<table class="table">
															<thead>
																<tr>
																	<th>Nama Obat</th>
																	<!-- <th>Komposisi dikemasan</th>
																	<th>Dosis yang diperlukan</th> -->
																	<th>Qty</th>
																	<th>Harga</th>
																	<th>Total</th>
																	<th>#</th>
																</tr>
															</thead>
															<tbody v-if="item.informasi.length > 0">
																<tr v-for="(itemin, indexin) in item.informasi">
																	<td>{{ itemin.nama }}</td>
																	<!-- <td>{{ itemin.komposisi }} {{ itemin.nama_satuan_komposisi }}</td>
																	<td>{{ itemin.dosis_diperlukan }} {{ itemin.nama_satuan_diperlukan }}</td> -->
																	<td>{{ itemin.jumlah_kecil }} {{
																		itemin.nama_satuan_kecil }}</td>
																	<td>{{ formatrupiah(itemin.hja_resep.toString()) }}
																	</td>
																	<td>{{ formatrupiah(itemin.total.toString()) }}</td>
																	<td>
																		<button class="tooltip btn-danger"
																			v-on:click="removeobatracikandetail(index, indexin)">
																			<vue-feather type="trash"></vue-feather>
																			<span class="tooltiptext">Hapus Data
																				Obat</span>
																		</button>
																	</td>
																</tr>
															</tbody>
															<tbody v-else>
																<tr>
																	<td colspan="3">List data obat racikan belum
																		ditambahkan</td>
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
						</div>
					</div>
				</div>

			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formresep } from './FormData.js';
import { parseresep } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { datename, formatrupiah } from '../../../module/Manipulation.js';
import { arrpemeriksaan } from "../../../module/DataArray.js";

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.arr = vm.arrpemeriksaan();
		vm.form = vm.formresep();

		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } })
	},
	created:function() {},
	data:function() { return { 
		title_racikan: '',
		index_racikan: 0,
		quantity_racikan: 0,
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
		arr: {
		},
		listobat: [], tempobat: null, listobatracikan: [], tempobatracikan: null, detail: null, pembayaran: '',
		tab: {
			button: [
					{ value: 'nonracikan', label: 'Obat Non Racikan', class: 'tab-active' },
					{ value: 'racikan', label: 'Obat Racikan', class: 'tab-no-active' },
			],
			// racikan: false,
			content: { nonracikan: true, racikan: false }
		},
	}},
	computed: {
		totalobat:function() {
			let temp = 0;
			for (let i = 0; i < vm.listobat.length; i++) {
				temp += parseInt(vm.listobat[i].total);
			}
			let ab = vm.formatrupiah(temp.toString());
			return ab;
		},
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
	},
	methods: {

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) { 
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
				}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
			}
		},

		removeobatracikan:function(index) {
			vm.listobatracikan.splice(index, 1);
			vm.title_racikan = '';
			vm.index_racikan = '';
		},

		removeobatracikandetail:function(index, indexin) {
			let _total = vm.listobatracikan[index].informasi[index].total;
			vm.listobatracikan[index].total -= parseInt(_total);
			vm.listobatracikan[index].informasi.splice(indexin, 1);
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
				vm.quantity_racikan = '1';
				let _total = parseInt(vm.quantity_racikan) * parseInt(vm.tempobatracikan.hja_resep);
				let tmp = {
					obat_uuid: vm.tempobatracikan.obat_uuid,
					nama: vm.tempobatracikan.nama,
					kategori: vm.tempobatracikan.kategori,
					formularium: vm.tempobatracikan.formularium,
					golongan: vm.tempobatracikan.golongan,
					satuan_uuid_besar: vm.tempobatracikan.satuan_uuid_besar,
					nama_satuan_besar: vm.tempobatracikan.nama_satuan_besar,
					satuan_uuid_kecil: vm.tempobatracikan.satuan_uuid_kecil,
					nama_satuan_kecil: vm.tempobatracikan.nama_satuan_kecil,
					hitung_besar: vm.tempobatracikan.hitung_besar,
					hitung_kecil: vm.tempobatracikan.hitung_kecil,
					harga_netto: vm.tempobatracikan.harga_netto,
					harga_netto_discount: vm.tempobatracikan.harga_netto_discount,
					harga_netto_ppn: vm.tempobatracikan.harga_netto_ppn,
					hpp: vm.tempobatracikan.hpp,
					margin_resep: vm.tempobatracikan.margin_resep,
					margin_non_resep: vm.tempobatracikan.margin_non_resep,
					hja_resep: vm.tempobatracikan.hja_resep,
					hja_non_resep: vm.tempobatracikan.hja_non_resep,
					hja_resep_besar: vm.tempobatracikan.hja_resep_besar,
					hja_non_resep_besar: vm.tempobatracikan.hja_non_resep_besar,
					jumlah_kecil: '1',
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
				console.log(tmp.komposisi, 'Balbala')
				vm.listobatracikan[vm.index_racikan].informasi.push(tmp);
				vm.listobatracikan[vm.index_racikan].total += _total;
				
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

		parseresep, formresep, formatrupiah, datename,
		initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, arrpemeriksaan,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key); 

			if (key == 'apotek') {
				vm.tempobat = item;
			}
			else if (key == 'apotekracikan') {
				vm.tempobatracikan = item;
			}
			 else if (key == "posisimata") {
                vm.tempobat.posisimata = item;
            }
		},

		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key)
			if(key == "posisimata") {
				vm.tempobat.posisimata = null;
			}; },
		selectbox: function (event, key, statics) {
			let msg = "select-close select-close-" + key;
			if (event.target.className != msg) {
				if (!vm.form.select[key].disabled) {
					let result = vm.boxselected(event, vm.form, key);
					if (result._position == "stop") {
						return;
					} else if (result._position == "nextstop") {
						vm.form = result._form;
					} else {
						vm.selecthide();
						vm.getIndexDB(key, statics);
						vm.form.select[key].option = "display: block";
					}
				}
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

		removeobat:function(index) {
			vm.listobat.splice(index, 1);
		},

		additemobat:function() {
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
					harga_netto: vm.tempobat.harga_netto,
					harga_netto_discount: vm.tempobat.harga_netto_discount,
					harga_netto_ppn: vm.tempobat.harga_netto_ppn,
					hpp: vm.tempobat.hpp,
					margin_resep: vm.tempobat.margin_resep,
					margin_non_resep: vm.tempobat.margin_non_resep,
					hja_resep: vm.tempobat.hja_resep,
					hja_non_resep: vm.tempobat.hja_non_resep,
					hja_resep_besar: vm.tempobat.hja_resep_besar,
					hja_non_resep_besar: vm.tempobat.hja_non_resep_besar,
					jumlah_kecil: vm.form.quantity.value,
					jumlah_besar: parseFloat(vm.form.quantity.value/vm.tempobat.hitung_kecil),
					signa: vm.form.signa.value,
					total: _total,
					posisimata: vm.tempobat.posisimata.value,
				}
				vm.listobat.push(tmp);
				
				console.log(vm.listobat, 'BUDIDIDIDDIDIDI')
				vm.tempobat = null;
				vm.form.signa.value = '';
				vm.form.quantity.value = '';
				vm.form.select.apotek.value = '';
				vm.form.select.apotek.label = 'Silahkan Pilih';
				vm.form.select.posisimata.value = "";
				vm.form.select.posisimata.label = "Silahkan Pilih";
			}
		},

		action:function() {
			if (vm.listobat.length > 0 || vm.listobatracikan.length > 0) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid, detail){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			vm.form.jenis = detail.jenis;
			vm.form.registrasi_uuid = detail.registrasi_uuid;
			vm.form.carabayar_nama = detail.carabayar_nama;
			vm.form.carabayar_uuid = detail.carabayar_uuid;
			// vm.pembayaran = pembayaran;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formresep(); 
			vm.listobat = [];
			vm.tempobat = null;
			vm.listobatracikan = [];
			vm.tempobatracikan = null;
			for (let i = 0; i < vm.tab.button.length; i++) { 
				vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active'; 
			}
			vm.tab.button[0].class = 'tab-active';
			vm.tab.content.nonracikan = true;
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
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
			vm.$emit('parsingForm', vm.parseresep(vm.form, vm.listobat, testing), 'addresep'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			// vm.detail = response.data.detail;
			vm.form.uuid = response.data.data.uuid;
			console.log('response');
			console.log(response)
			vm.listobat = [];
			vm.listobatracikan = [];
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
					harga_netto: obats[i].harga_netto,
					harga_netto_discount: obats[i].harga_netto_discount,
					harga_netto_ppn: obats[i].harga_netto_ppn,
					hpp: obats[i].hpp,
					margin_resep: obats[i].margin_resep,
					margin_non_resep: obats[i].margin_non_resep,
					hja_resep: obats[i].hja_resep,
					hja_non_resep: obats[i].hja_non_resep,
					hja_resep_besar: obats[i].hja_resep_besar,
					hja_non_resep_besar: obats[i].hja_non_resep_besar,
					jumlah_kecil: obats[i].jumlah_kecil,
					jumlah_besar: obats[i].jumlah_besar,
					signa: obats[i].signa,
					total: obats[i].total,
					posisimata: obats[i].posisimata,

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
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah data resep halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'formresep');
    },
	}
}
</script>
<style>
.obatracikanclose {
	position: absolute; top: -11px; right: 20px; padding: 0 10px; background: #fff; cursor: pointer; color: #000; font-weight: bold;
}
</style>