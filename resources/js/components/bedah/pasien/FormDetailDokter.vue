<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">Add Data</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">Dokter Bedah</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Selected v-on:click="selectbox($event, form.select.dokter.name, form.select.dokter.statics)" 
							:ref="form.select.dokter.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.dokter" v-on:keyup="selectfilter($event, form.select.dokter.name)"></Selected>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formdetaildokter } from './FormData.js';
import { parsedetaildokter } from './Attachment.js';
import { arrtransfer } from '../../../module/DataArray.js';
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
		vm.form = vm.formdetaildokter();
		vm.arr = vm.arrtransfer();
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
		form: null, arr: null, btnlbl: '', listdata: [],
	}},
	methods: {

		parsedetaildokter, formdetaildokter, arrtransfer,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.itemselected(vm.form, item, key); 
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
			
			// if (next) { 
				vm.parsingForm(); vm.dialog(); 
			// }
		},

		show:function(posisi, title, uuid){ 
			vm.form.registrasi_uuid = uuid;
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formdetaildokter(); vm.listdata = []; },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parsedetaildokter(vm.form), 'adddokter'); 
		},

		removetransfer:function(item) {
			vm.$emit('parsingForm', vm.parsedetaildokterremove(item.pasien_transfer_uuid, item.registrasi_uuid), 'removetransfer'); 
			let text = '', button = '';
			text = 'Yakin ingin membatalkan transfer pasien ke dokter yang dipilih.';
			button = 'Ya, batal transfer';
      vm.$emit('dialog', text, button, 'removetransfer');
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.listdata = [];	
			console.log(response.data);
			if (response.data.data) {
				if (response.data.data.nama_dokter != '-' && response.data.nama_dokter != '') {
					vm.form.select.dokter.value = response.data.nama_dokter;
					vm.form.select.dokter.label = response.data.nama_dokter;
				} else {
					vm.form.select.dokter.value = '';
					vm.form.select.dokter.label = 'Silahkan Pilih';
				}
			}

			// if (response.data.data.length > 0) {

			// 	for (let i = 0; i < response.data.data.length; i++) {
			// 		let tmp = {
			// 			registrasi_uuid: response.data.data[i].registrasi_uuid,
			// 			pasien_transfer_uuid: response.data.data[i].uuid,
			// 			nama_dokter: response.data.data[i].nama_dokter,
			// 			pengguna_uuid: response.data.data[i].pengguna_uuid,
			// 			status_dokter: response.data.data[i].status_dokter,
			// 			dokter_jam_periksa: response.data.data[i].dokter_jam_periksa,
			// 			dokter_jam_selesai: response.data.data[i].dokter_jam_selesai,
			// 		}
			// 		vm.listdata.push(tmp);
			// 	}
			// }
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin memilik dokter bedah';
			button = 'Ya, pilih dokter';
      vm.$emit('dialog', text, button, 'formdetaildokter');
    },
	}
}
</script>