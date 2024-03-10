<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-4 form-mr">
						<h3 class="label-form">Data Utama</h3>
						<Inputed :ref="form.mulaibekerja.name" :form="form.mulaibekerja"></Inputed>
						<Selected v-on:click="selectbox($event, form.select.posisiakun.name, form.select.posisiakun.statics)" 
							:ref="form.select.posisiakun.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.posisiakun"></Selected>
						<Inputed :ref="form.sebagai.name" :form="form.sebagai"></Inputed>
						<Inputed :ref="form.usernamepengguna.name" :form="form.usernamepengguna" v-on:keyup="username()"></Inputed>
						<Inputed :ref="form.namapengguna.name" :form="form.namapengguna"></Inputed>
						<Inputed :ref="form.nohandphone.name" :form="form.nohandphone"></Inputed>
						<Inputed :ref="form.tempatlahir.name" :form="form.tempatlahir"></Inputed>
						<Inputed :ref="form.tanggallahir.name" :form="form.tanggallahir"></Inputed>

						<Selected v-on:click="selectbox($event, form.select.jeniskelamin.name, form.select.jeniskelamin.statics)" 
							:ref="form.select.jeniskelamin.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.jeniskelamin"></Selected>

						<Selected v-on:click="selectbox($event, form.select.agama.name, form.select.agama.statics)" 
							:ref="form.select.agama.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.agama"></Selected>

						<Selected v-on:click="selectbox($event, form.select.statuspernikahan.name, form.select.statuspernikahan.statics)" 
							:ref="form.select.statuspernikahan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.statuspernikahan"></Selected>

						<Selected v-on:click="selectbox($event, form.select.pendidikanterakhir.name, form.select.pendidikanterakhir.statics)" 
							:ref="form.select.pendidikanterakhir.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.pendidikanterakhir"></Selected>

						<Selected v-on:click="selectbox($event, form.select.golongandarah.name, form.select.golongandarah.statics)" 
							:ref="form.select.golongandarah.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.golongandarah"></Selected>
					</div>

					<div class="col-4 form-ml form-mr">
						<h3 class="label-form">Data Alamat</h3>

						<Inputed :ref="form.emailpengguna.name" :form="form.emailpengguna"></Inputed>
						<Inputed :ref="form.alamat.name" :form="form.alamat"></Inputed>

						<Selected v-on:click="selectbox($event, form.select.provinsi.name, form.select.provinsi.statics)" 
							:ref="form.select.provinsi.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.provinsi" v-on:keyup="selectfilter($event, form.select.provinsi.name)"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kabkota.name, form.select.kabkota.statics)" 
							:ref="form.select.kabkota.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kabkota" v-on:keyup="selectfilter($event, form.select.kabkota.name)"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kecamatan.name, form.select.kecamatan.statics)" 
							:ref="form.select.kecamatan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kecamatan" v-on:keyup="selectfilter($event, form.select.kecamatan.name)"></Selected>

						<Selected v-on:click="selectbox($event, form.select.kelurahan.name, form.select.kelurahan.statics)" 
							:ref="form.select.kelurahan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.kelurahan" v-on:keyup="selectfilter($event, form.select.kelurahan.name)"></Selected>

						<Inputed :ref="form.kodepos.name" :form="form.kodepos"></Inputed>
						<Inputed :ref="form.rtrw.name" :form="form.rtrw"></Inputed>

						<h3 class="label-form-in form-mt">Akun Bank</h3>

						<Inputed :ref="form.banknama.name" :form="form.banknama"></Inputed>
						<Inputed :ref="form.banknorek.name" :form="form.banknorek"></Inputed>
						<Inputed :ref="form.bankan.name" :form="form.bankan"></Inputed>

					</div>

					<div class="col-4 form-ml">
						<h3 class="label-form">Nomor Identitas</h3>

						<Inputed :ref="form.ktp.name" :form="form.ktp"></Inputed>
						<Inputed :ref="form.npwp.name" :form="form.npwp"></Inputed>
						<Inputed :ref="form.sima.name" :form="form.sima"></Inputed>
						<Inputed :ref="form.simc.name" :form="form.simc"></Inputed>
						<Inputed :ref="form.paspor.name" :form="form.paspor"></Inputed>

						<h3 class="label-form-in form-mt">BPJS Ketenagakerjaan</h3>

						<Selected v-on:click="selectbox($event, form.select.bpjsketenagakerjaan.name, form.select.bpjsketenagakerjaan.statics)" 
							:ref="form.select.bpjsketenagakerjaan.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.bpjsketenagakerjaan"></Selected>
						<Inputed :ref="form.nobpjsketenagakerjaan.name" :form="form.nobpjsketenagakerjaan"></Inputed>

						<h3 class="label-form-in form-mt">Kontak Darurat</h3>

						<Inputed :ref="form.daruratnama.name" :form="form.daruratnama"></Inputed>
						<Inputed :ref="form.daruratnohandphone.name" :form="form.daruratnohandphone"></Inputed>
						<Inputed :ref="form.darurathubungan.name" :form="form.darurathubungan"></Inputed>

					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { setdataeditpengguna } from './SetDataEdit.js';
import { formpengguna } from './FormData.js';
import { parsepengguna } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { arrbiodata } from '../../../module/DataArray.js';
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
		vm.arr = vm.arrbiodata();
		vm.form = vm.formpengguna();
		window.onclick = function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		arr: null, form: null, btnlbl: '',
	}},
	methods: {

		parsepengguna, initindexdb, indexdbprocessing, arrbiodata, formpengguna, setdataeditpengguna,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		username: function () {
			vm.form.usernamepengguna.value = vm.form.usernamepengguna.value.toLowerCase().trim();
		},

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

		setdataform:function(response) { vm.form = vm.setdataeditpengguna(vm.form, response); vm.loaderprocess(); },

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

		show:function(posisi, title){ vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formpengguna(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsepengguna(vm.form), 'pengguna'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin memperbaharui data ini.';
			button = 'Ya, perbaharui data';
      vm.$emit('dialog', text, button, 'formpengguna');
    },
	}
}
</script>