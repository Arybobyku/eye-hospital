<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-sedang" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">Add/Update Jadwal</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">Tambah Paket Operasi</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.paketbedah.name, form.select.paketbedah.statics)" 
							:ref="form.select.paketbedah.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.paketbedah" v-on:keyup="selectfilter($event, form.select.paketbedah.name)"></Selected>
						</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formpaket } from './FormData.js';
import { parsepaket } from './Attachment.js';
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
		vm.form = vm.formpaket();

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
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
	}},
	methods: {

		parsepaket, formpaket,

		initindexdb, indexdbprocessing,
filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { 
			vm.form = vm.filterselected(vm.form, key); 
		},

		selectfilter: function (event, jambu, key) { 
			
			vm.form = vm.filterselected(vm.form, jambu);
		},
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key);
			console.log("key");
			console.log(key);
			console.log(item.total);
			 if(key == 'paketbedah') {
			vm.form.harga_paket = item.total;
		} 

		},
		selectclear:function(key) { 
			vm.form = vm.clearselected(vm.form, key);
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
					})
					.catch(function(error){ console.log(error); });
			}
		},
		
		// keyinput: function(event) { console.log(event.target.value); },

		action:function() {
			vm.parsingForm(); vm.dialog(); 
		},

		show:function(posisi, title, uuid){ 
			vm.form.registrasi_uuid = uuid;
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formpaket(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsepaket(vm.form), 'addpaket'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {

			if (response.data.data) {
				vm.form.uuid = response.data.uuid;
				if (response.data.data.nama_paket_bedah != '-') {
					vm.form.select.paketbedah.value = response.data.data.paket_bedah_uuid;
					vm.form.select.paketbedah.label = response.data.data.nama_paket_bedah;
					vm.form.harga_paket = response.data.data.tarif;
					console.log("tarif");
					console.log(response.data.data.tarif);
				}

				else {
					vm.form.select.paketbedah.value = '';
					vm.form.select.paketbedah.label = 'Silahkan Pilih';
					vm.form.harga_paket = 0;

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
      vm.$emit('dialog', text, button, 'formpaket');
    },
	}
}
</script>