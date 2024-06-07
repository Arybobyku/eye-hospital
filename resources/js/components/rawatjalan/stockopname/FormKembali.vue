<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">

					<div class="col-6 form-mb form-mr" v-if="detailobat">
						<table class="table-info">
							<tr>
								<td>Nama Obat</td>
								<td><strong>{{ detailobat.nama }}</strong></td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td>
									<strong>{{ detailobat.hitung_besar }} {{ detailobat.nama_satuan_besar }} = 
									{{ detailobat.hitung_kecil }} {{ detailobat.nama_satuan_kecil }}</strong>
								</td>
							</tr>
							<tr>
								<td>Stock Obat/Alkes</td>
								<td>
									<strong>{{ detailobat.jumlah_besar }} {{ detailobat.nama_satuan_besar }} = 
										{{ detailobat.jumlah_kecil }} {{detailobat.nama_satuan_kecil }}</strong></td>
							</tr>
						</table>
					</div>

					<div class="col-6 form-mb form-ml" v-if="detailobat">
						<table class="table-info">
							<tr>
								<td>Formularioum</td>
								<td><strong>{{ detailobat.formularium }}</strong></td>
							</tr>
							<tr>
								<td>Golongan</td>
								<td><strong>{{ detailobat.golongan }}</strong></td>
							</tr>
							<tr>
								<td>Kategori</td>
								<td><strong>{{ detailobat.kategori }}</strong></td>
							</tr>
						</table>
					</div>

					<div class="col-12">
						<Inputed :ref="form.jumlah.name" :form="form.jumlah"></Inputed>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formkembali } from './FormData.js';
import { parsekembali } from './Attachment.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formkembali();
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', detailobat: null
	}},
	methods: {

		parsekembali, formkembali,

		// keyinput: function(event) { console.log(event.target.value); },

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		show:function(posisi, title, uuid, data){ 

			vm.detailobat = data; 
			vm.form.uuid = data.uuid;
			vm.form.obat_uuid = data.obat_uuid;
			vm.form.hitung_besar = data.hitung_besar;
			vm.form.hitung_kecil = data.hitung_kecil;
			vm.form.jumlah_besar = data.jumlah_besar;
			vm.form.jumlah_kecil = data.jumlah_kecil;

			vm.btnlbl = 'Kembalikan Obat/Alkes'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formkembali(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parsekembali(vm.form), 'kembali'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.form.uuid = response.data.data.uuid;
			vm.form.nama.value = response.data.data.nama;
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin mengembembalikan obat/alkes dan data stock obat/alkes akan ditambahkan.';
			button = 'Ya, kembalikan obat/alkes';
      vm.$emit('dialog', text, button, 'formkembali');
    },
	}
}
</script>