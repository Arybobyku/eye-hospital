<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">

					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.obat.name, form.select.obat.statics)" 
							:ref="form.select.obat.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.obat" v-on:keyup="selectfilter($event, form.select.obat.name)"></Selected>
					</div>

					<div class="col-6 form-mb form-mr" v-if="form.detailobat">
						<table class="table-info">
							<tr>
								<td>Nama Obat</td>
								<td><strong>{{ form.detailobat.nama }}</strong></td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td>
									<strong>{{ form.detailobat.hitung_besar }} {{ form.detailobat.nama_satuan_besar }} = 
									{{ form.detailobat.hitung_kecil }} {{ form.detailobat.nama_satuan_kecil }}</strong>
								</td>
							</tr>
							<!-- <tr>
								<td>Last Updated</td>
								<td><strong>{{ modal.form.last_update }}</strong></td>
							</tr> -->
						</table>
					</div>

					<div class="col-6 form-mb form-ml" v-if="form.detailobat">
						<table class="table-info">
							<tr>
								<td>Formularioum</td>
								<td><strong>{{ form.detailobat.formularium }}</strong></td>
							</tr>
							<tr>
								<td>Golongan</td>
								<td><strong>{{ form.detailobat.golongan }}</strong></td>
							</tr>
							<tr>
								<td>Kategori</td>
								<td><strong>{{ form.detailobat.kategori }}</strong></td>
							</tr>
						</table>
					</div>
					
					<div class="col-6 form-mr">
						<Inputed :ref="form.harganetto.name" :form="form.harganetto" v-on:keyup="countharga($event)"></Inputed>
					</div>
					
					<div class="col-6 form-ml">
						<Inputed :ref="form.harganettodiscount.name" :form="form.harganettodiscount" v-on:keyup="countharga($event)"></Inputed>
					</div>

					<div class="col-6 form-mr">
						<Inputed :ref="form.harganettoppn.name" :form="form.harganettoppn" v-on:keyup="countharga($event)"></Inputed>
					</div>

					<div class="col-6 form-ml">
						<Inputed :ref="form.hpp.name" :form="form.hpp"></Inputed>
					</div>

					<div class="col-6 form-mr">
						<Inputed :ref="form.marginresep.name" :form="form.marginresep" v-on:keyup="countharga($event)"></Inputed>
					</div>

					<div class="col-6 form-ml">
						<Inputed :ref="form.marginnonresep.name" :form="form.marginnonresep" v-on:keyup="countharga($event)"></Inputed>
					</div>

					<div class="col-6 form-mr">
						<Inputed :ref="form.hjaresep.name" :form="form.hjaresep"></Inputed>
					</div>

					<div class="col-6 form-ml">
						<Inputed :ref="form.hjanonresep.name" :form="form.hjanonresep"></Inputed>
					</div>

					<div class="col-6 form-mr">
						<Inputed :ref="form.hjaresepbesar.name" :form="form.hjaresepbesar"></Inputed>
					</div>

					<div class="col-6 form-ml">
						<Inputed :ref="form.hjanonresepbesar.name" :form="form.hjanonresepbesar"></Inputed>
					</div>

					<div class="col-12">
						<Inputed :ref="form.keterangan.name" :form="form.keterangan"></Inputed>
					</div>
				
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formharga } from './FormData.js';
import { parseharga } from './Attachment.js';
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
		vm.form = vm.formharga();
		vm.init();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: ''
	}},
	methods: {

		countharga: function () {
			vm.form.hpp.value = parseInt((vm.form.harganetto.value - (vm.form.harganetto.value * ( vm.form.harganettodiscount.value/100))) + 
													((vm.form.harganetto.value - (vm.form.harganetto.value * ( vm.form.harganettodiscount.value/100))) * 
													(vm.form.harganettoppn.value/100)));

			vm.form.hjaresep.value = parseInt(vm.form.hpp.value + (vm.form.hpp.value * (vm.form.marginresep.value/100)));
			vm.form.hjaresepbesar.value = parseInt(vm.form.hjaresep.value * parseInt(vm.form.detailobat.hitung_kecil));

			vm.form.hjanonresep.value = parseInt(vm.form.hpp.value + (vm.form.hpp.value * (vm.form.marginnonresep.value/100)));
			vm.form.hjanonresepbesar.value = parseInt(vm.form.hjanonresep.value * parseInt(vm.form.detailobat.hitung_kecil));
		},

		init:function () {
			if (vm.form.detailobat) {
				vm.form.harganetto.disabled = false;
				vm.form.harganettodiscount.disabled = false;
				vm.form.harganettoppn.disabled = false;
				vm.form.marginresep.disabled = false;
				vm.form.marginnonresep.disabled = false;
			}
			else {
				vm.form.harganetto.disabled = true;
				vm.form.harganetto.value = '';
				vm.form.harganettodiscount.disabled = true;
				vm.form.harganettodiscount.value = '';
				vm.form.harganettoppn.disabled = true;
				vm.form.harganettoppn.value = '';
				vm.form.marginresep.disabled = true;
				vm.form.marginresep.value = '';
				vm.form.marginnonresep.disabled = true;
				vm.form.marginnonresep.value = '';

				vm.form.hjaresep.value = '';
				vm.form.hjaresepbesar.value = '';

				vm.form.hjanonresep.value = '';
				vm.form.hjanonresepbesar.value = '';
			}
		},

		parseharga, formharga, initindexdb, indexdbprocessing,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form.detailobat = {
				formularium : item.formularium,
				golongan : item.golongan,
				hitung_besar : item.hitung_besar,
				hitung_kecil : item.hitung_kecil,
				id : item.id,
				kategori : item.kategori,
				keterangan : item.keterangan,
				min_stock : item.min_stock,
				nama : item.nama,
				nama_satuan_besar : item.nama_satuan_besar,
				nama_satuan_kecil : item.nama_satuan_kecil,
				satuan_uuid_besar : item.satuan_uuid_besar,
				satuan_uuid_kecil : item.satuan_uuid_kecil,
				uuid : item.uuid
			}
			vm.init();
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key); 
		},
		selectclear:function(key) { vm.form.detailobat = null; vm.init(); vm.form = vm.clearselected(vm.form, key); },
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

		show:function(posisi, title, uuid){ vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formharga(); vm.init(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parseharga(vm.form), 'harga'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			let data = response.data.data;
			vm.form.uuid = data.uuid;
			vm.form.detailobat = {
				formularium: data.formularium,
				golongan: data.golongan,
				hitung_besar: data.hitung_besar,
				hitung_kecil: data.hitung_kecil,
				kategori: data.kategori,
				nama: data.nama,
				nama_satuan_besar: data.nama_satuan_besar,
				nama_satuan_kecil: data.nama_satuan_kecil,
				id: data.obat_id,
				uuid: data.obat_uuid,
				satuan_id_besar: data.satuan_id_besar,
				satuan_id_kecil: data.satuan_id_kecil,
				satuan_uuid_besar: data.satuan_uuid_besar,
				satuan_uuid_kecil: data.satuan_uuid_kecil,
			}
			vm.form.select.obat.value = data.obat_id;
			vm.form.select.obat.label = data.nama;
			vm.form.harganetto.value = parseInt(data.harga_netto);
			vm.form.harganetto.value = parseInt(data.harga_netto);
			vm.form.harganettoppn.value = parseInt(data.harga_netto_ppn);
			vm.form.hjanonresep.value = parseInt(data.hja_non_resep);
			vm.form.hjanonresepbesar.value = data.hja_non_resep_besar;
			vm.form.hjaresep.value = parseInt(data.hja_resep);
			vm.form.hjaresepbesar.value = data.hja_resep_besar;
			vm.form.hpp.value = parseInt(data.hpp);
			vm.form.marginnonresep.value = data.margin_non_resep;
			vm.form.marginresep.value = data.margin_resep;
			vm.init();
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
      vm.$emit('dialog', text, button, 'formharga');
    },
	}
}
</script>