<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Obat/Alkes</th>
									<th>Jenis</th>
									<th>Jumlah Disistem</th>
									<th>Jumlah Fisik</th>
									<th>Selisih</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody v-if="listobat.length > 0">
								<tr v-for="(item, index) in listobat">
									<td>{{ index+1 }}</td>
									<td>{{ item.nama }}</td>
									<td>{{ item.jenis }}</td>
									<td>{{ item.before_jumlah_kecil }}</td>
									<td>{{ item.after_jumlah_kecil }}</td>
									<td>{{ item.selisih_jumlah_kecil }}</td>
									<td>{{ item.labeling }}</td>
								</tr>
							</tbody>
							<tbody v-else>
								<tr>
									<td colspan="7">No Data for Result</td>
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
import { formbalance } from './FormData.js';
import { parsebalance } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formbalance();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
		tempobat: null, listobat: [],
	}},
	methods: {

		formbalance, parsebalance,

		initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

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
			if (vm.tempobat) {
				let kecil = Math.abs(parseInt(vm.form.jumlah.value - vm.tempobat.jumlah_kecil));

				let besar = vm.form.jumlah.value/vm.tempobat.hitung_kecil;
				let labelings = '-';
				if (vm.tempobat.jumlah_kecil == vm.form.jumlah.value) {
					labelings = 'Jumlah obat/alkes antara sistem dan fisik balance';
				}
				else {
					labelings = 'Jumlah obat/alkes antara sistem dan fisik selisih '+ kecil;
				}
				let str = {
					obat_uuid: vm.tempobat.obat_uuid,
					nama: vm.tempobat.nama,
					kategori: vm.tempobat.kategori,
					formularium: vm.tempobat.formularium,
					golongan: vm.tempobat.golongan,
					jenis: vm.tempobat.jenis,
					satuan_kekuatan: '-',
					jumlah_kekuatan: 0,
					satuan_uuid_besar: vm.tempobat.satuan_uuid_besar,
					nama_satuan_besar: vm.tempobat.nama_satuan_besar,
					satuan_uuid_kecil: vm.tempobat.satuan_uuid_kecil,
					nama_satuan_kecil: vm.tempobat.nama_satuan_kecil,
					hitung_besar: vm.tempobat.hitung_besar,
					hitung_kecil: vm.tempobat.hitung_kecil,
					unit_uuid: vm.tempobat.unit_uuid,
					nama_unit: vm.tempobat.nama_unit,
					before_jumlah_kecil: vm.tempobat.jumlah_kecil,
					before_jumlah_besar: vm.tempobat.jumlah_besar,
					
					after_jumlah_kecil: vm.form.jumlah.value,
					after_jumlah_besar: besar,

					selisih_jumlah_kecil: kecil,
					selisih_jumlah_besar: Math.abs(parseInt(vm.tempobat.jumlah_besar - besar)),
					labeling: labelings
				}
				vm.listobat.push(str);
				vm.form.select.obatgudang.value = '';
				vm.form.select.obatgudang.label = 'Silahkan Pilih';
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
			vm.form.label_stockopname_uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formbalance(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsebalance(vm.form, vm.listobat), 'balance'); },

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
						satuan_kekuatan: tmp[i].satuan_kekuatan,
						jumlah_kekuatan: tmp[i].jumlah_kekuatan,
						satuan_uuid_besar: tmp[i].satuan_uuid_besar,
						nama_satuan_besar: tmp[i].nama_satuan_besar,
						satuan_uuid_kecil: tmp[i].satuan_uuid_kecil,
						nama_satuan_kecil: tmp[i].nama_satuan_kecil,
						hitung_besar: tmp[i].hitung_besar,
						hitung_kecil: tmp[i].hitung_kecil,
						unit_uuid: tmp[i].unit_uuid,
						nama_unit: tmp[i].nama_unit,
						before_jumlah_kecil: tmp[i].before_jumlah_kecil,
						before_jumlah_besar: tmp[i].before_jumlah_besar,
						
						after_jumlah_kecil: tmp[i].after_jumlah_kecil,
						after_jumlah_besar: tmp[i].after_jumlah_besar,

						selisih_jumlah_kecil: tmp[i].selisih_jumlah_kecil,
						selisih_jumlah_besar: tmp[i].selisih_jumlah_besar,
						labeling: tmp[i].labeling
					}
					vm.listobat.push(str);
				}
			} 
			
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
      vm.$emit('dialog', text, button, 'formbalance');
    },
	}
}
</script>