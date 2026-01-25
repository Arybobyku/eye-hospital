<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">Save Item Permohonan</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-8">
						<Selected v-on:click="selectbox($event, form.select.hargagudang.name, form.select.hargagudang.statics)" 
							:ref="form.select.hargagudang.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.hargagudang" v-on:keyup="selectfilter($event, form.select.hargagudang.name)"></Selected>
					</div>
					<div class="col-3 form-ml">
						<Inputed :ref="form.jumlah.name" :form="form.jumlah"></Inputed>
					</div>
					<div class="col-1 form-ml">
						<button class="tooltip btn-danger" v-on:click="additemobat()" style="margin-top: 20px">
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
									<th>No.</th>
									<th>Jenis</th>
									<th>Nama Obat</th>
									<th>Kemasan</th>
									<th>Permintaan</th>
									<th>Stok Akhir</th>
									<th>Harga Netto</th>
									<th>Total</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody v-if="listobat.length > 0">
								<tr v-for="(item, index) in listobat">
									<td>{{ index+1 }}</td>
									<td>{{ item.jenis }}</td>
									<td>{{ item.nama }}</td>
									<td>{{ item.hitung_kecil }} {{ item.nama_satuan_kecil }}/{{ item.nama_satuan_besar }}</td>
									<td>{{ item.jumlah_permohonan_kecil }}</td>
									<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
									<td>{{ formatrupiah(item.harga_netto.toString()) }}</td>
									<td>{{ formatrupiah(htgtotals(item).toString()) }}</td>
									<td>
										<button class="tooltip btn-danger" v-on:click="removeitemobat(index)">
											<vue-feather type="trash"></vue-feather> 
											<span class="tooltiptext">Remove Item Obat</span>
										</button>
									</td>
								</tr>
							</tbody>
							<tbody v-else>
								<tr>
									<td colspan="8">No Data for Result</td>
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
import { formpermohonan } from './FormData.js';
import { parsepermohonan } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { formatrupiah } from '../../../module/Manipulation';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formpermohonan();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
		tempobat: null, listobat: [],
	}},
	methods: {

		formpermohonan, parsepermohonan, formatrupiah,

		initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		htgtotals:function(item) {
			return item.harga_netto * item.jumlah_permohonan_kecil;
		},

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.tempobat = item;
			vm.form = vm.itemselected(vm.form, item, key); 
		},
		selectclear:function(key) { 
			vm.tempobat = null; 
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

		removeitemobat:function(index) {
			vm.listobat.splice(index, 1);
		},

		additemobat:function() {
			console.log(this.tempobat)
			if (vm.tempobat) {
				let str = {
					obat_uuid: vm.tempobat.obat_uuid,
					nama: vm.tempobat.nama,
					kategori: vm.tempobat.kategori,
					formularium: vm.tempobat.formularium,
					golongan: vm.tempobat.golongan,
					jenis: vm.tempobat.jenis,
					satuan_uuid_besar: vm.tempobat.satuan_uuid_besar,
					nama_satuan_besar: vm.tempobat.nama_satuan_besar,
					satuan_uuid_kecil: vm.tempobat.satuan_uuid_kecil,
					nama_satuan_kecil: vm.tempobat.nama_satuan_kecil,
					hitung_besar: vm.tempobat.hitung_besar,
					hitung_kecil: vm.tempobat.hitung_kecil,
					unit_uuid: 'bc0582ff-ce98-45f4-b361-ecef5b686a0f',
					nama_unit: 'Gudang Farmasi',
					jumlah_kecil: vm.tempobat.jumlah_kecil,
					jumlah_besar: vm.tempobat.jumlah_besar,
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
					jumlah_permohonan_besar: vm.form.jumlah.value,
					jumlah_permohonan_kecil: vm.form.jumlah.value,
					labeling: '',
				}
				vm.listobat.push(str);
				vm.form.select.hargagudang.value = '';
				vm.form.select.hargagudang.label = 'Silahkan Pilih';
				vm.form.jumlah.value = '';
			}
		},

		action:function() {
			let next = true;
			
			if (vm.listobat.length > 0) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			vm.form.uuid = uuid;
			vm.form.label_permohonan_uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formpermohonan(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsepermohonan(vm.form, vm.listobat), 'permohonan'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.listobat = [];
			let tmp = response.data.data;
			if (tmp.length > 0) {
				for (let i = 0; i < tmp.length; i++) {
					let str = {
						obat_uuid: tmp[i].obat_uuid,
						nama: tmp[i].nama,
						kategori: tmp[i].kategori,
						formularium: tmp[i].formularium,
						golongan: tmp[i].golongan,
						jenis: tmp[i].jenis,
						satuan_uuid_besar: tmp[i].satuan_uuid_besar,
						nama_satuan_besar: tmp[i].nama_satuan_besar,
						satuan_uuid_kecil: tmp[i].satuan_uuid_kecil,
						nama_satuan_kecil: tmp[i].nama_satuan_kecil,
						hitung_besar: tmp[0].hitung_besar,
						hitung_kecil: tmp[i].hitung_kecil,
						unit_uuid: tmp[i].unit_uuid,
						nama_unit: tmp[i].nama_unit,
						jumlah_kecil: tmp[i].jumlah_kecil,
						jumlah_besar: tmp[i].jumlah_besar,
						harga_netto: tmp[i].harga_netto,
						harga_netto_discount: tmp[i].harga_netto_discount,
						harga_netto_ppn: tmp[i].harga_netto_ppn,
						hpp: tmp[i].hpp,
						margin_resep: tmp[i].margin_resep,
						margin_non_resep: tmp[i].margin_non_resep,
						hja_resep: tmp[i].hja_resep,
						hja_non_resep: tmp[i].hja_non_resep,
						hja_resep_besar: tmp[i].hja_resep_besar,
						hja_non_resep_besar: tmp[i].hja_non_resep_besar,
						jumlah_permohonan_besar: tmp[i].jumlah_permohonan_besar,
						jumlah_permohonan_kecil: tmp[i].jumlah_permohonan_kecil,
						labeling: tmp[i].labeling,
					}
					vm.listobat.push(str);
				}
			} 

			console.log(vm.listobat, "dfdfdf")
			
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
      vm.$emit('dialog', text, button, 'formpermohonan');
    },
	}
}
</script>

