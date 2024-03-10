<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-sedang" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">Cetak Surat Persetujuan</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Cetak Surat Persetujuan</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<Inputed :ref="form.pelepasaninformasi.name" :form="form.pelepasaninformasi"></Inputed>
					</div>
					<div class="col-12">
						<Inputed :ref="form.penerima.name" :form="form.penerima"></Inputed>
					</div>
					
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formcetakan } from './FormData.js';
import { parsecetakan } from './Attachment.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formcetakan();
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', detail: null,
	}},
	methods: {

		parsecetakan, formcetakan,

		// keyinput: function(event) { console.log(event.target.value); },

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, data){ 
			vm.detail = data;
			vm.form.uuid = data.uuid;
			vm.form.title = title;  
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formcetakan(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsecetakan(vm.form, vm.detail), 'suratpersetujuan'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin mencetak surat persetujuan pada pasien ini.';
			button = 'Ya, cetak surat';
      vm.$emit('dialog', text, button, 'formcetakan');
    },
	}
}
</script>