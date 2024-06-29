<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="ubah()" style="margin-right: 280px;">Pembayaran Diterima</button>
				<button v-on:click="cetak('pengantar')" style="margin-right: 135px;">Cetak Pengantar</button>
				<button v-on:click="cetak('claim')">Cetak Kwitansi</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-5">
						<Inputed :ref="form.kwitansi.name" :form="form.kwitansi"></Inputed>
					</div>
					<div class="col-5 form-ml">
						<Inputed :ref="form.claimadditional.name" :form="form.claimadditional"></Inputed>
					</div>
					<div class="col-2 form-ml"><button v-on:click="action()" class="excels" style="position: relative; top: 20px">Add No. Kwitansi</button></div>
					
					<div class="col-12">

						<table class="table">pengantar
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Total Tagihan</th>
									<th>No Kwitansi</th>
									<th>No Kwitansi (Klaim)</th>
									<th>Rekam Medis</th>
									<th>Nama Pasien</th>
									<th>Nama Dokter</th>
									<th>Status Pembayaran Claim</th>
								</tr>
							</thead>
							<tbody v-if="listdata.length > 0">
								<tr v-for="(item, index) in listdata">
									<td>{{ item.tanggal }}</td>
									<td>{{ totaltagihan(item.layanan) }}</td>
									<td>{{ item.no_kwitansi }}</td>
									<td>{{ item.kwitansi_claim }}</td>
									<td>{{ item.rekam_medis }}</td>
									<td>{{ item.nama_pasien }}</td>
									<td>{{ item.nama_dokter }}</td>
									<td>{{ item.status_claim }}</td>
								</tr>
								<tr><td colspan="6">Grand Total</td><td>{{ formatrupiah(supergrand.toString()) }}</td></tr>
							</tbody>
							<tbody v-else>
								<tr><td colspan="7">No Data fo result</td></tr>
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
import { parseunit } from './Attachment.js';
import { nullAndZero, datename, formatrupiah } from '../../../module/Manipulation.js';
var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formunit();
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', listdata: [], grandtotal: 0
	}},
	computed: {
		supergrand:function() {
			let tmp = 0;
			for (let i = 0; i < vm.listdata.length; i++) {
				for (let j = 0; j < vm.listdata[i].layanan.length; j++) {
					tmp += parseInt(vm.listdata[i].layanan[j].total)
				}
			}
			return tmp;
		}
	},
	methods: {

		totaltagihan:function(item) {
			let tmp = 0;
			for (let i = 0; i < item.length; i++) {
				tmp += parseInt(item[i].total);
			}
			
			return vm.formatrupiah(tmp.toString());
		},

		parseunit, formunit, datename, formatrupiah,

		// keyinput: function(event) { console.log(event.target.value); },

		cetak:function(posisi) {
			let uri = '/preview/claimgabungan/' + posisi + '/' + vm.form.posisi + '/' + vm.form.dari + '/' + vm.form.ke;
			window.open(uri);
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		ubah:function() {
			vm.$emit('parsingForm', vm.parseunit(vm.form), 'ubah');
			let text = '', button = '';
			text = 'Yakin ingin mengubah status pembayaran klaim sudah diterima.';
			button = 'Ya, ubah status';
      vm.$emit('dialog', text, button, 'formpreview');
		},

		show:function(posisi, title, uuid){ vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formunit(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { vm.$emit('parsingForm', vm.parseunit(vm.form), 'preview'); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			console.log(response);
			vm.listdata = [];
			vm.listdata = response.data.data;
			vm.form.dari = response.data.dari;
			vm.form.ke = response.data.ke;
			vm.form.posisi = response.data.posisi;
			if (vm.form.posisi == 'prodia') { vm.form.title = 'Prodia (' + vm.datename(vm.form.dari) + ' - ' + vm.datename(vm.form.ke) + ')'; }
			else if (vm.form.posisi == 'bpjstk') { vm.form.title = 'BPJS Ketenagakerjaan (' + vm.datename(vm.form.dari) + ' - ' + vm.datename(vm.form.ke) + ')'; }
			else if (vm.form.posisi == 'socfindo') { vm.form.title = 'Socfindo (' + vm.datename(vm.form.dari) + ' - ' + vm.datename(vm.form.ke) + ')'; }
			else if (vm.form.posisi == 'pln') { vm.form.title = 'Perushaan Listrik Negara (' + vm.datename(vm.form.dari) + ' - ' + vm.datename(vm.form.ke) + ')'; }
			vm.form.kwitansi.value = response.data.no_kwitansi;
			vm.form.claimadditional.value = response.data.claim_additional;
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambahkan no kwitansi klaim pada data ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, 'formpreview');
    },
	}
}
</script>