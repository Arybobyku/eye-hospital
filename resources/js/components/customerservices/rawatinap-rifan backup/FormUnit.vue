<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">Registrasi Pasien ke Kamar</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.kamarinap.name, form.select.kamarinap.statics)" 
							:ref="form.select.kamarinap.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kamarinap" v-on:keyup="selectfilter($event, form.select.kamarinap.name)"></Selected>
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
		window.onclick = function(event) { 
			let a = event.target.className; 
			
			try { 
				if (a.split(" ")) { 
					a = a.split(" "); 
					
					if (a[0] != 'hospitals' && a[0] != 'click-title') { 
						vm.selecthide(); 
					} 
				} 
				if (event.target.className == '') { 
					vm.selecthide(); 
				} 
			} 
			catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', detail: null, posisiproses: ''
	}},
	methods: {

		parseunit, formunit,

		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 

			vm.form.kamar_inap_uuid = item.uuid;
			vm.form.kamar_inap_nama = item.nama;
			vm.form.kamar_inap_lantai = item.lantai;
			vm.form.kamar_inap_jumlah_bed = item.jumlah_bed;
			vm.form.jenis_kamar_uuid = item.jenis_kamar_uuid;
			vm.form.nama_jenis_kamar = item.nama_jenis_kamar;
		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
		},
		selectbox:function(event, key, statics) {

			if (!vm.form.select[key].disabled) {
				let result = vm.boxselected(event, vm.form, key);
				if (result._position == 'stop') { return ; }
				else if (result._position == 'nextstop') { vm.form = result._form; }
				else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
			}
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key); 
					})
					.catch(function(error){ console.log(error); });
			}
		},
		// keyinput: function(event) { console.log(event.target.value); },

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

		show:function(posisi, title, uuid, detail){
			vm.posisiproses = posisi;
			vm.detail = detail; 
			console.log(detail)
			vm.form.registrasi_uuid = detail.uuid;
			vm.form.carabayar_uuid = detail.carabayar_uuid;
			vm.form.carabayar_nama = detail.carabayar_nama;
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formunit(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parseunit(vm.form), 'unit'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.form.uuid = response.data.data.uuid;
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
      vm.$emit('dialog', text, button, 'formunit');
    },
	}
}
</script>