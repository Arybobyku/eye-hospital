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
						<label>Kode Poli</label>
						<input type="text" v-model="form.kodepoli" readonly />
					</div>
					<div class="col-12">
						<label>Nama Sub Spesialis Poli</label>
						<input type="text" v-model="form.nmsubspesialis" readonly />
					</div>

			
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formdetail } from './FormData.js';
import { parseunit } from './Attachment.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Textarea: defineAsyncComponent(() => import('../../../section/Textarea.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formdetail();
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: {
      kodepoli: '',
      nmsubspesialis: '',
      // tambahkan field lain jika perlu
    }, btnlbl: '',
	}},
	methods: {
		open() {
  this.terminate.display = 'display: block';
  this.terminate.show = true;
  document.body.style.overflowY = 'hidden';
},

		parseunit, formdetail,

		handleFileUpload(event){
    	vm.form.datafile = event.target.files[0];
			if (!vm.form.datafile) {
				vm.form.datafile = '';
			}
			console.log(vm.form.datafile);
  	},

		// keyinput: function(event) { console.log(event.target.value); },

		action:function() {
			let next = true;
			
			if (vm.form.datafile != '') { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid, kodepoli){ vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid; vm.form.kodepoli = kodepoli; // <- disimpan ke form
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formdetail(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parseunit(vm.form), 'unit'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.form.uuid = response.data.data.uuid;
			//vm.form.content.value = response.data.data.content;
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
      vm.$emit('dialog', text, button, 'formdetail');
    },
	}
}
</script>
<style>
input[type=file] {
  width: 100%;
  max-width: 100%;
  color: #444;
  padding: 5px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid #555;
}
input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #084cdf;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}
</style>