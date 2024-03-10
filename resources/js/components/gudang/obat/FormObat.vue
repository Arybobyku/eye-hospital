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
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
					</div>

					<div class="col-7 form-mr">
						<Selected v-on:click="selectbox($event, form.select.satuanbesar.name, form.select.satuanbesar.statics)" 
							:ref="form.select.satuanbesar.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.satuanbesar" v-on:keyup="selectfilter($event, form.select.satuanbesar.name)"></Selected>
					</div>

					<div class="col-5 form-ml">
						<Inputed :ref="form.hitungbesar.name" :form="form.hitungbesar"></Inputed>
					</div>

					<div class="col-7 form-mr">
						<Selected v-on:click="selectbox($event, form.select.satuankecil.name, form.select.satuankecil.statics)" 
							:ref="form.select.satuankecil.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.satuankecil" v-on:keyup="selectfilter($event, form.select.satuankecil.name)"></Selected>
					</div>

					<div class="col-5 form-ml">
						<Inputed :ref="form.hitungkecil.name" :form="form.hitungkecil"></Inputed>
					</div>

					<div class="col-6">
						<Inputed :ref="form.minstock.name" :form="form.minstock"></Inputed>
					</div>

					<div class="col-6 form-ml">
						<Selected v-on:click="selectbox($event, form.select.jenisobat.name, form.select.jenisobat.statics)" 
							:ref="form.select.jenisobat.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.jenisobat"></Selected>
					</div>

					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.golongan.name, form.select.golongan.statics)" 
							:ref="form.select.golongan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.golongan"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kategori.name, form.select.kategori.statics)" 
							:ref="form.select.kategori.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kategori"></Selected>

						<Selected v-on:click="selectbox($event, form.select.formularium.name, form.select.formularium.statics)" 
							:ref="form.select.formularium.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.formularium"></Selected>

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
import { formobat } from './FormData.js';
import { parseobat } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { arrobat } from '../../../module/DataArray.js';


var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.arr = vm.arrobat();
		vm.form = vm.formobat();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, arr: null, btnlbl: ''
	}},
	methods: {

		parseobat, formobat, initindexdb, indexdbprocessing, arrobat,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { vm.form = vm.conditionselected(vm.form, item, key, 'address'); vm.form = vm.itemselected(vm.form, item, key); },
		selectclear:function(key) { vm.form = vm.clearselected(vm.form, key); },
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
		aturulang: function () { vm.form = vm.formobat(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parseobat(vm.form), 'obat'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.form.uuid = response.data.data.uuid;
			vm.form.nama.value = response.data.data.nama;

			vm.form.select.satuankecil.value = response.data.data.satuan_id_kecil;
			vm.form.select.satuankecil.label = response.data.data.nama_satuan_kecil;

			vm.form.select.satuanbesar.value = response.data.data.satuan_id_besar;
			vm.form.select.satuanbesar.label = response.data.data.nama_satuan_besar;
			
			vm.form.select.golongan.value = response.data.data.golongan;
			vm.form.select.golongan.label = response.data.data.golongan;
			vm.form.select.kategori.value = response.data.data.kategori;
			vm.form.select.kategori.label = response.data.data.kategori;
			vm.form.select.formularium.value = response.data.data.formularium;
			vm.form.select.formularium.label = response.data.data.formularium;

			vm.form.minstock.value = response.data.data.min_stock;
			vm.form.hitungbesar.value = response.data.data.hitung_besar;
			vm.form.hitungkecil.value = response.data.data.hitung_kecil;

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