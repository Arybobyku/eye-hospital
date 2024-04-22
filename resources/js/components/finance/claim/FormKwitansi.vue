<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-sedang" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">Add/Update No Kwitansi Claim</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Inputed :ref="form.nomor.name" :form="form.nomor"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.diskon.name" :form="form.diskon"></Inputed>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formnomor } from './FormData.js';
import { parsenomor } from './Attachment.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formnomor();
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
	}},
	methods: {

		formnomor, parsenomor,

		// keyinput: function(event) { console.log(event.target.value); },

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			vm.form.registrasi_uuid = uuid;
			vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formnomor(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsenomor(vm.form), 'add'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.form.registrasi_uuid = response.data.data.uuid;
			if (response.data.data.kwitansi_claim != '-') {
				vm.form.nomor.value = response.data.data.kwitansi_claim;
			}
			else {
				vm.form.nomor.value = '';
			}

			if (response.data.data.diskon_claim != '-') {
				vm.form.diskon.value = response.data.data.diskon_claim;
			}
			else {
				vm.form.diskon.value = '';
			}
			
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin memperbaharui data pada halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'formkwitansi');
    },
	}
}
</script>