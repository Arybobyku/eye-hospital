<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-sedang" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.jeniskamar.name, form.select.jeniskamar.statics)" 
							:ref="form.select.jeniskamar.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.jeniskamar" v-on:keyup="selectfilter($event, form.select.jeniskamar.name)"></Selected>
						<Inputed :ref="form.nama.name" :form="form.nama"></Inputed>
						<Inputed :ref="form.lantai.name" :form="form.lantai"></Inputed>
						<Inputed :ref="form.jumlahbed.name" :form="form.jumlahbed"></Inputed>
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
import { formkamarinap } from './FormData.js';
import { parsekamarinap } from './Attachment.js';
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
		vm.form = vm.formkamarinap();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: ''
	}},
	methods: {

		parsekamarinap, formkamarinap, initindexdb, indexdbprocessing,
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
		aturulang: function () { vm.form = vm.formkamarinap(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsekamarinap(vm.form), 'kamarinap'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.form.uuid = response.data.data.uuid;
			vm.form.nama.value = response.data.data.nama;
			vm.form.lantai.value = response.data.data.lantai;
			vm.form.jumlahbed.value = response.data.data.jumlah_bed;
			vm.form.keterangan.value = response.data.data.keterangan;
			vm.form.select.jeniskamar.value = response.data.data.jenis_kamar_uuid;
			vm.form.select.jeniskamar.label = response.data.data.nama_jenis_kamar;
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
      vm.$emit('dialog', text, button, 'formkamarinap');
    },
	}
}
</script>