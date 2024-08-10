<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar"
			:class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Selected
							v-on:click="selectbox($event, form.select.carabayartindakanrawatjalan.name, form.select.carabayartindakanrawatjalan.statics)"
							:ref="form.select.carabayartindakanrawatjalan.name" @selecteditem="selecteditem"
							@selectclear="selectclear" :selection="form.select.carabayartindakanrawatjalan"
							v-on:keyup="selectfilter($event, form.select.carabayartindakanrawatjalan.name)"></Selected>
					</div>
					<div class="col-12">
						<div class="col-8">

							<div class="grid">

								<div class="col-8">
									<Inputed :ref="form.tanggal.name" :form="form.tanggal">
									</Inputed>
								</div>
								<div class="col-4 form-ml">
									<Timepicker :ref="form.waktu.name" :form="form.waktu">
									</Timepicker>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th>Nama Tindakan</th>
									<th>Biaya</th>
									<th>Tanggal Ditambahkan</th>
									<th>Waktu Ditambahkan</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in listdata" v-if="listdata.length > 0">
									<td>{{ item.nama_layanan }}</td>
									<td>{{ formatrupiah(item.tarif.toString()) }}</td>
									<td>{{ item.tanggal }}</td>
									<td>{{ item.waktu }}</td>
									<td>
										<button class="tooltip btn-danger" v-on:click="removetindakan(item, index)">
											<vue-feather type="trash"></vue-feather>
											<span class="tooltiptext">Hapus Tindakan</span>
										</button>
									</td>
								</tr>
								<tr v-else>
									<td colspan="3">No Data for Result</td>
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
import { parseunit, parsedelete } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { formatrupiah } from '../../../module/Manipulation.js';

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		Timepicker: defineAsyncComponent(() => import('../../../section/Timepicker.vue')),  

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
		form: null, btnlbl: '', detail: null, listdata: []
	}},
	methods: {

		parseunit, formunit, parsedelete, formatrupiah,

		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 

			vm.form.nama_layanan = item.nama_tindakan_rawat_jalan;
			vm.form.layanan_uuid = item.tindakan_rawat_jalan_uuid;
			vm.form.tarif = item.harga;
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

		removetindakan:function(item, index) {
			vm.form.uuid = item.uuid;
			vm.parsingForm('removedata'); vm.dialog('removedata');
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { 
					//if (vm.form[key].required) {
					if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } 
					//}
				}
				else {
					for (const keyselect in vm.form.select) {
						if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
					}
				}
			}
			
			if (next) { vm.parsingForm('adddata'); vm.dialog('adddata'); }
		},

		show:function(posisi, title, uuid, detail){
			vm.detail = detail; 
			console.log(detail)
			vm.form.registrasi_uuid = detail.uuid;
			vm.form.carabayar_uuid = detail.carabayar_uuid;
			vm.form.carabayar_nama = detail.carabayar_nama;
			vm.btnlbl = 'Tambah Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formunit(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function(posisi) {
			if (posisi == 'adddata') {
				vm.$emit('parsingForm', vm.parseunit(vm.form), 'add');
			}
			else {
				vm.$emit('parsingForm', vm.parsedelete(vm.form), 'remove');
			}
			
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.listdata = response.data.data;
			vm.form.select.carabayartindakanrawatjalan.value = '';
			vm.form.select.carabayartindakanrawatjalan.label = 'Silahkan Pilih';
			vm.form.uuid = '';
			vm.loaderprocess();
		},

		dialog:function(posisi){
			let text = '', button = '';
			if (posisi == 'adddata') {
				text = 'Yakin ingin menambah data pada halaman ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin menghapus data ini.';
				button = 'Ya, hapus data';
			}
      vm.$emit('dialog', text, button, posisi);
    },
	}
}
</script>