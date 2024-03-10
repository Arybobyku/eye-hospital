<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">List Reminder ke Pasien</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-6">
						<Selected v-on:click="selectbox($event, form.select.melalui.name, form.select.melalui.statics)" 
							:ref="form.select.melalui.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.melalui"></Selected>
					</div>
					<div class="col-3 form-ml">
						<Inputed :ref="form.tanggal.name" :form="form.tanggal"></Inputed>
					</div>
					<div class="col-3 form-ml">
						<Inputed :ref="form.waktu.name" :form="form.waktu"></Inputed>
					</div>
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 60px;">No.</th>
									<th>Tanggal</th>
									<th>Melalui</th>
									<th>Keterangan</th>
								</tr>
							</thead>
							<tbody v-if="listdata.length > 0">
								<tr v-for="(item, index) in listdata">
									<td>{{ index+1 }}</td>
									<td>{{ datename(item.tanggal) }} {{ item.waktu }}</td>
									<td>{{ item.melalui }}</td>
									<td>{{ item.keterangan }}</td>
								</tr>
							</tbody>
							<tbody v-else>
								<tr><td colspan="3">No data for result</td></tr>
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
import { datename } from '../../../module/Manipulation.js';
import { parseunit } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
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
		form: null, btnlbl: '', listdata: [], jadwalkontrol: null,
		arr: {
			melalui: [
				{ value: 'SMS', label: 'SMS Pesan Singkat' },
				{ value: 'Whatsapp', label: 'Aplikasi Whatsapp' },
				{ value: 'Email', label: 'Email - Surat Elektronik' },
				{ value: 'Telegram', label: 'Aplikasi Telegram' },
				{ value: 'Lainnya', label: 'Lain-lainnya' },
			],
		}
	}},
	methods: {

		parseunit, formunit, datename,
 
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
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
		},
		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid){ 
			vm.btnlbl = 'Tambah Data';
			vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formunit(); vm.jadwalkontrol = null; vm.listdata = []; },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parseunit(vm.form), 'unit'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.jadwalkontrol = response.data.jadwal;
			vm.listdata = response.data.list;

			vm.form.select.melalui.value = '';
			vm.form.select.melalui.label = 'Silahkan Pilih';
			vm.form.tanggal.value = '';
			vm.form.waktu.value = '';
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