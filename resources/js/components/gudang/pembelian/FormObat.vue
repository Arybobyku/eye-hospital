<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content" :class="showups">
			<div class="modal-header">
				<button v-on:click="action()" v-if="!isapproval">Tambah atau Perbaharui</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">
					<span v-html="isapproval ? 'Daftar Obat Faktur <strong style=\'color: green\'>(Approved)</strong>' : 'Tambah atau Perbaharui data Obat'"></span>
				</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-5 form-mr" v-if="!isapproval">
						<div class="grid">
							<div class="col-12">
								<Selected v-on:click="selectbox($event, form.select.obat.name, form.select.obat.statics)" 
									:ref="form.select.obat.name" @selecteditem="selecteditem" @selectclear="selectclear"
									:selection="form.select.obat" v-on:keyup="selectfilter($event, form.select.obat.name)"></Selected>
							</div>

							<div class="col-12" style="margin-bottom: 14px; font-family: 'Roboto Black'; color: #1c84ee" v-if="form.detailobat != ''">
								<span>
									Notes : {{ form.detailobat.nama }} dengan kalkulasi : 
									{{ form.detailobat.hitung_besar }} {{ form.detailobat.nama_satuan_besar }} = 
									{{ form.detailobat.hitung_kecil }} {{ form.detailobat.nama_satuan_kecil }}
								</span>
							</div>

							<div class="col-6 form-mr">
								<Inputed :ref="form.jumlahkecil.name" :form="form.jumlahkecil" v-on:keyup="checkup($event, 'jumlah_kecil')"></Inputed>
							</div>

							<div class="col-6 form-ml">
								<Inputed :ref="form.jumlahbesar.name" :form="form.jumlahbesar" v-on:keyup="checkup($event, 'jumlah_besar')"></Inputed>
							</div>

							<div class="col-6 form-mr">
								<Inputed :ref="form.hargakecil.name" :form="form.hargakecil" v-on:keyup="checkup($event, 'harga_kecil')"></Inputed>
							</div>

							<div class="col-6 form-ml">
								<Inputed :ref="form.hargabesar.name" :form="form.hargabesar" v-on:keyup="checkup($event, 'harga_besar')"></Inputed>
							</div>

							<div class="col-12">
								<Inputed :ref="form.jumlahdiskon.name" :form="form.jumlahdiskon" v-on:keyup="checkup($event, 'jumlah_diskon')"></Inputed>
							</div>

							<div class="col-6 form-mr">
								<Inputed :ref="form.hargakecildiskon.name" :form="form.hargakecildiskon"></Inputed>
							</div>

							<div class="col-6 form-ml">
								<Inputed :ref="form.hargabesardiskon.name" :form="form.hargabesardiskon"></Inputed>
							</div>

							<div class="col-6 form-mr">
								<Inputed :ref="form.batch.name" :form="form.batch"></Inputed>
							</div>

							<div class="col-6 form-ml">
								<Inputed :ref="form.expireddate.name" :form="form.expireddate"></Inputed>
							</div>
						</div>

						<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;">
							<div class="col-7"></div>
							<div class="col-5" style="text-align: right">
								<button class="button-modal-page button-modal-red" v-on:click="clears()">Clear</button>
								<button class="button-modal-page button-modal-green" v-on:click="add()">Add</button>
							</div>
						</div>
					</div>
					<div :class="isapproval ? 'col-12' : 'col-7'">
						<div class="grid">
							<div class="col-6">
								<table class="table form-mb" style="border: none">
									<tbody>
										<tr>
											<td>Nama Supplier</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailfaktur.nama_supplier }}</strong></td>
										</tr>
										<tr>
											<td>No Faktur</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailfaktur.no_faktur }}</strong></td>
										</tr>
										<tr>
											<td>Tanggal Faktur</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailfaktur.tanggal_faktur }}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-6">
								<table class="table form-mb" style="border: none">
									<tbody>
										<tr>
											<td>Jenis Pembayaran</td>
											<td style="margin-bottom: 10px;">
												<strong>
													{{ form.detailfaktur.pembayaran }}
													<span v-if="form.detailfaktur.pembayaran == 'Kredit'">{{ form.detailfaktur.jangka_waktu }} Hari</span>
												</strong>
											</td>
										</tr>
										<tr>
											<td>PPN %</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailfaktur.ppn }}</strong></td>
										</tr>
										<tr>
											<td>Penerima</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailfaktur.penerima }}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-12">
								<table class="table form-mb">
									<thead>
										<tr>
											<th>Nama Obat</th>
											<th>Jumlah/Satuan Kecil</th>
											<th>Jumlah/Satuan Besar</th>
											<th>Harga/Satuan Kecil</th>
											<th>Harga/Satuan Besar</th>
											<th>No Batch</th>
											<th>Expired Date</th>
											<th v-if="!isapproval">#</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(item, index) in listdata" v-if="listdata.length > 0">
											<td>{{ item.nama }}</td>
											<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
											<td>{{ item.jumlah_besar }} {{ item.nama_satuan_besar }}</td>
											<td>{{ item.harga_kecil }}/{{ item.nama_satuan_kecil }}</td>
											<td>{{ item.harga_besar }}/{{ item.nama_satuan_besar }}</td>
											<td>{{ item.batch }}</td>
											<td>{{ item.expired_date }}</td>
											<td v-if="!isapproval">
												<button class="tooltip btn-danger">
													<vue-feather type="trash-2" v-on:click="hapus(item, index)"></vue-feather> <span class="tooltiptext">Delete Data</span>
												</button>
											</td>
										</tr>
										<tr v-else>
											<td colspan="6">No Data for Result</td>
										</tr>
									</tbody>
								</table>
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
import { formobat } from './FormData.js';
import { parseobat } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { arrpembelian } from '../../../module/DataArray.js';


var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formobat();
		vm.init();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	computed: {
		showups:function () {
			let classes = '';
			if (this.isapproval) { classes = 'modal-besar'; }
			else { classes = 'modal-besar'; }

			if (this.terminate.show) { classes += ' modal-opened'; }
			else { classes += ' modal-closed'; }
			return classes;
		}
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
		satuan : { kecil: '', besar: '' },
		hitung : { kecil: '', besar: '' },
		listdata: [], isapproval: false
	}},
	methods: {

		hapus:function(item, index) {
			vm.listdata.splice(index, 1);
		},

		init: function () {
			if (vm.form.detailobat != '') {
				vm.form.jumlahkecil.disabled = false;
				vm.form.jumlahbesar.disabled = false;
				vm.form.hargakecil.disabled = false;
				vm.form.hargabesar.disabled = false;
				vm.form.jumlahdiskon.disabled = false;
				vm.form.batch.disabled = false;
				vm.form.expireddate.disabled = false;
			}
			else {
				vm.form.jumlahkecil.disabled = true;
				vm.form.jumlahbesar.disabled = true;
				vm.form.hargakecil.disabled = true;
				vm.form.hargabesar.disabled = true;
				vm.form.jumlahdiskon.disabled = true;
				vm.form.batch.disabled = true;
				vm.form.expireddate.disabled = true;
			}
			
		},

		checkup:function(event, item) {
			if (item == 'jumlah_kecil') {
				vm.form.jumlahbesar.value = vm.form.jumlahkecil.value / vm.hitung.kecil;
			}
			else if (item == 'jumlah_besar') {
				vm.form.jumlahkecil.value = vm.form.jumlahbesar.value * vm.hitung.kecil;
			}
			else if (item == 'harga_kecil') {
				vm.form.hargabesar.value = vm.form.hargakecil.value * vm.hitung.kecil;
				vm.form.hargabesardiskon.value = vm.form.hargabesar.value - (vm.form.hargabesar.value * (vm.form.jumlahdiskon.value/100));
				vm.form.hargakecildiskon.value = vm.form.hargakecil.value - (vm.form.hargakecil.value * (vm.form.jumlahdiskon.value/100));
			}
			else if (item == 'harga_besar') {
				vm.form.hargakecil.value = vm.form.hargabesar.value / vm.hitung.kecil;
				vm.form.hargabesardiskon.value = vm.form.hargabesar.value - (vm.form.hargabesar.value * (vm.form.jumlahdiskon.value/100));
				vm.form.hargakecildiskon.value = vm.form.hargakecil.value - (vm.form.hargakecil.value * (vm.form.jumlahdiskon.value/100));
			}
			else if (item == 'jumlah_diskon') {
				vm.form.hargabesardiskon.value = vm.form.hargabesar.value - (vm.form.hargabesar.value * (vm.form.jumlahdiskon.value/100));
				vm.form.hargakecildiskon.value = vm.form.hargakecil.value - (vm.form.hargakecil.value * (vm.form.jumlahdiskon.value/100));
			}
		},

		parseobat, formobat, initindexdb, indexdbprocessing, arrpembelian,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key);
			
			vm.satuan.besar = item.nama_satuan_besar;
			vm.satuan.kecil = item.nama_satuan_kecil;

			vm.hitung.besar = item.hitung_besar;
			vm.hitung.kecil = item.hitung_kecil;

			vm.form.detailobat = { 
				id: item.id,
				uuid: item.uuid,
				nama: item.nama,
				keterangan: item.keterangan,
				satuan_uuid_besar: item.satuan_uuid_besar,
				nama_satuan_besar: item.nama_satuan_besar,
				satuan_uuid_kecil: item.satuan_uuid_kecil,
				nama_satuan_kecil: item.nama_satuan_kecil,
				hitung_besar: item.hitung_besar,
				hitung_kecil: item.hitung_kecil,
				kategori: item.kategori,
				formularium: item.formularium,
				golongan: item.golongan,
			}
			vm.init();
		},

		add:function() {

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
				let tmp = {
					pembelian_uuid: vm.form.detailfaktur.uuid,
					supplier_uuid: vm.form.detailfaktur.supplier_uuid,
					nama_supplier: vm.form.detailfaktur.nama_supplier,
					ppn: vm.form.detailfaktur.ppn,
					no_faktur: vm.form.detailfaktur.no_faktur,
					tanggal_faktur: vm.form.detailfaktur.tanggal_faktur,
					tanggal_waktu: vm.form.detailfaktur.tanggal_waktu,
					pembayaran: vm.form.detailfaktur.pembayaran,
					jangka_waktu: vm.form.detailfaktur.jangka_waktu,

					obat_uuid: vm.form.detailobat.uuid,
					nama: vm.form.detailobat.nama,
					kategori: vm.form.detailobat.kategori,
					formularium: vm.form.detailobat.formularium,
					golongan: vm.form.detailobat.golongan,
					satuan_uuid_besar: vm.form.detailobat.satuan_uuid_besar,
					nama_satuan_besar: vm.form.detailobat.nama_satuan_besar,
					satuan_uuid_kecil: vm.form.detailobat.satuan_uuid_kecil,
					nama_satuan_kecil: vm.form.detailobat.nama_satuan_kecil,

					hitung_besar: vm.hitung.besar,
					hitung_kecil: vm.hitung.kecil,

					jumlah_kecil: vm.form.jumlahkecil.value,
					jumlah_besar: vm.form.jumlahbesar.value,
					harga_kecil: vm.form.hargakecil.value,
					harga_besar: vm.form.hargabesar.value,
					harga_kecil_diskon: vm.form.hargakecildiskon.value,
					harga_besar_diskon: vm.form.hargabesardiskon.value,
					jumlah_diskon: vm.form.jumlahdiskon.value,
					
					batch: vm.form.batch.value,
					expired_date: vm.form.expireddate.value,
				}

				vm.listdata.push(tmp);
				
				vm.clears();
			}
		},


		clears:function() {
			vm.form.detailobat = '';
			vm.satuan.besar = '';
			vm.satuan.kecil = '';
			vm.hitung.besar = '';
			vm.hitung.kecil = '';
			vm.form.select.obat.value = '';
			vm.form.select.obat.label = 'Silahkan Pilih';
			vm.form.jumlahkecil.value = '';
			vm.form.jumlahbesar.value = '';
			vm.form.hargakecil.value = '';
			vm.form.hargabesar.value = '';
			vm.form.hargakecildiskon.value = '';
			vm.form.hargabesardiskon.value = '';
			vm.form.jumlahdiskon.value = '';
			vm.form.batch.value = '';
			vm.form.expireddate.value = '';
			vm.init();
		},
		selectclear:function(key) { 
			vm.form.detailobat = '';
			vm.form = vm.clearselected(vm.form, key); 
		},
		selectbox:function(event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
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
			if (vm.listdata.length > 0) { 
				vm.form.listdata = vm.listdata;
				vm.parsingForm(); vm.dialog(); 
			} 
		},

		show:function(posisi, title, uuid){ 
			vm.form.listdata = '';
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formobat(); 
			vm.satuan = { kecil: '', besar: '' }
			vm.hitung = { kecil: '', besar: '' }
			vm.listdata = [];
			vm.isapproval = false;
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parseobat(vm.form), 'obat'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 0); },

		setdataform: function (response) {
			vm.form.detailfaktur = response.data.data;
			vm.listdata = response.data.dataobat;
			if (vm.form.detailfaktur.status == 'approve') { vm.isapproval = true; }
			else { vm.isapproval = false; }
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
      vm.$emit('dialog', text, button, 'formobat');
    },
	}
}
</script>