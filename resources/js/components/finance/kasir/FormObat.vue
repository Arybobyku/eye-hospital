<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()" v-if="pembayaran!='Sudah Bayar'">Proses Pembayaran</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form && detail">
				<div class="grid">
					<div class="col-4"></div>
					<div class="col-4" style="position:relative;">
						<div class="cop-surat">
							<div class="top">
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
					<div class="col-4"></div>
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
					<div class="col-12" v-if="pembayaran!='Sudah Bayar'">
						<Selected v-on:click="selectbox($event, form.select.metodepembayaran.name, form.select.metodepembayaran.statics)" 
									:ref="form.select.metodepembayaran.name" @selecteditem="selecteditem" @selectclear="selectclear"
									:selection="form.select.metodepembayaran" v-on:keyup="selectfilter($event, form.select.metodepembayaran.name)"></Selected>
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
									<th>Harga</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in listobat" v-if="listobat.length > 0">
									<td>{{ item.nama }}</td>
									<td>{{ item.signa }}</td>
									<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
									<td>{{ formatrupiah(item.hja_non_resep.toString()) }}</td>
									<td><b>{{ formatrupiah(item.total.toString()) }}</b></td>
								</tr>
								<tr v-else>
									<td colspan="3">No Data for Result</td>
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
								<tr v-for="(item, index) in listobatracikan" v-if="listobatracikan.length > 0">
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
													<td>Sub Total</td>
													<td><b>{{ formatrupiah(item.total.toString()) }}</b></td>
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
													<th>Harga</th>
													<th>Qty</th>
													<th>Sub Total</th>
												</tr>
											</thead>
											<tbody v-if="item.informasi.length > 0">
												<tr v-for="(itemin, indexin) in item.informasi">
													<td>{{ itemin.nama }}</td>
													<!-- <td>{{ itemin.komposisi }} {{ itemin.nama_satuan_komposisi }}</td>
													<td>{{ itemin.dosis_diperlukan }} {{ itemin.nama_satuan_diperlukan }}</td> -->
													<td>{{ formatrupiah(itemin.hja_non_resep.toString()) }}</td>
													<td>{{ itemin.jumlah_kecil }} {{ itemin.nama_satuan_kecil }}</td>
													<td>{{ formatrupiah(itemin.total.toString()) }}</td>
												</tr>
											</tbody>
											<tbody v-else>
												<tr>
													<td colspan="3">List data obat racikan belum ditambahkan</td>
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
					<div class="col-12" v-if="listobatracikan.length > 0">
						<table class="table">
							<thead>
								<tr>
									<th>Nama Tindakan</th>
									<th>Biaya</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in listdata" v-if="listdata.length > 0">
									<td>{{ item.nama_tindakan_rawat_jalan }}</td>
									<td>{{ item.harga }}</td>
								</tr>
								<tr v-else>
									<td colspan="3">No Data for Result</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-12">
						<table class="table">
							<tbody>
								<tr>
									<td align="left" style="width: 25%;"><b>Grant Total</b></td>
									<td align="left" style="width: 25%;"><b>{{ totalobat }}</b></td>
									<td align="left" style="width: 25%;">&nbsp;</td>
									<td align="left" style="width: 25%;">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formunit } from './FormData.js';
import { parseunit } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { datename, formatrupiah } from '../../../module/Manipulation.js';
import { arrkasir } from '../../../module/DataArray.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formunit();
		vm.arr = vm.arrkasir();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } })
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', arr: null,
		listdata: [],
		listobat: [], listobatracikan: [], tempobat: null, detail: null, pembayaran: ''
	}},
	computed: {
		totalobat:function() {
			let temp = 0;
			for (let i = 0; i < vm.listobat.length; i++) {
				temp += parseInt(vm.listobat[i].total);
			}
			for (let i = 0; i < vm.listobatracikan.length; i++) {
				temp += parseInt(vm.listobatracikan[i].total);
			}
			for (let i = 0; i < vm.listdata.length; i++) {
				temp += parseInt(vm.listdata[i].total);
			}
			let ab = vm.formatrupiah(temp.toString());
			return ab;
		},
	},
	methods: {

		parseunit, formunit, formatrupiah, datename, arrkasir,
		initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key); 

			if (key == 'apotek') {
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

		removeobat:function(index) {
			vm.listobat.splice(index, 1);
		},

		additemobat:function() {
			console.log(vm.tempobat)
			if (vm.tempobat) {
				let _total = parseInt(vm.form.quantity.value) * parseInt(vm.tempobat.hja_resep);
				let tmp = {
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
				}
				vm.listobat.push(tmp);
				vm.tempobat = null;
				vm.form.signa.value = '';
				vm.form.quantity.value = '';
				vm.form.select.apotek.value = '';
				vm.form.select.apotek.label = 'Silahkan Pilih';
			}
		},

		action:function() {
			if (vm.form.select.metodepembayaran.value != '' && vm.form.select.metodepembayaran.value != ' ' && vm.form.select.metodepembayaran.value) { 
				vm.parsingForm(); vm.dialog(); 
			}
		},

		show:function(posisi, title, uuid, pembayaran){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			vm.form.uuid = uuid;
			vm.pembayaran = pembayaran;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formunit(); 
			vm.listdata = [];
			vm.listobat = [];
			vm.listobatracikan = [];
			vm.tempobat = null;
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parseunit(vm.form), 'formobat'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.detail = response.data.detail;
			let obats = response.data.data;
			for (let i = 0; i < obats.length; i++){

				let _total = parseInt(obats[i].quantity) * parseInt(obats[i].harga);
				let tmp = {
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

			if (response.data.layanan) {
				for (let i = 0; i < response.data.layanan.length; i++){
					let _item = {
						nama_tindakan_rawat_jalan: response.data.layanan[i].nama_layanan,
						tindakan_rawat_jalan_uuid: response.data.layanan[i].layanan_uuid,
						default: response.data.layanan[i].default,
						harga: vm.formatrupiah(Math.ceil(response.data.layanan[i].tarif).toString()),
						tarif: response.data.layanan[i].tarif,
						total: response.data.layanan[i].total,
					}

					vm.listdata.push(_item);
				}
			}
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin memproses pembayaran data resep bebas ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'formobat');
    },
	}
}
</script>