<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-4">
			<Inputed :ref="form.namaoperator.name" :form="form.namaoperator"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.diagnosismedis.name" :form="form.diagnosismedis"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.asistenoperasi.name" :form="form.asistenoperasi"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.namaahlianastesi.name" :form="form.namaahlianastesi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.tindakanoperasi.name" :form="form.tindakanoperasi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.scrubnurses.name" :form="form.scrubnurses"></Inputed>
		</div>
		
		<div class="col-12">
			<h2 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Induksi Anastesi
			</h2>
		</div>

		<div class="col-6">
			<Inputed :ref="form.sibagian1.name" :form="form.sibagian1"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sibagian2.name" :form="form.sibagian2"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.sibagian3.name" :form="form.sibagian3"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sibagian4.name" :form="form.sibagian4"></Inputed>
		</div>

		<div class="col-12">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Apakah Pasien Memiliki (Riwayat dan Resiko)
			</h4>
		</div>

		<div class="col-2">
			<Inputed :ref="form.sibagian5.name" :form="form.sibagian5"></Inputed>
		</div>

		<div class="col-4 form-ml">
			<Inputed :ref="form.sibagian6.name" :form="form.sibagian6"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sibagian7.name" :form="form.sibagian7"></Inputed>
		</div>

		<div class="col-12">
			<h2 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Insisi Kulit
			</h2>
		</div>

		<div class="col-12">
			<Inputed :ref="form.tobagian1.name" :form="form.tobagian1"></Inputed>
		</div>

		<div class="col-12">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Antisipasi keadaan kritis untuk dokter bedah :
			</h4>
		</div>

		<div class="col-6">
			<Inputed :ref="form.tobagian21.name" :form="form.tobagian21"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.tobagian22.name" :form="form.tobagian22"></Inputed>
		</div>

		<div class="col-12">
			<Inputed :ref="form.tobagian23.name" :form="form.tobagian23"></Inputed>
		</div>

		<div class="col-12">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Untuk Dokter Anastesi :
			</h4>
		</div>

		<div class="col-12">
			<Inputed :ref="form.tobagian3.name" :form="form.tobagian3"></Inputed>
		</div>

		<div class="col-12">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Untuk Perawat :
			</h4>
		</div>

		<div class="col-6">
			<Inputed :ref="form.tobagian41.name" :form="form.tobagian41"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.tobagian42.name" :form="form.tobagian42"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.tobagian5.name" :form="form.tobagian5"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.tobagian6.name" :form="form.tobagian6"></Inputed>
		</div>

		<div class="col-12">
			<h2 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Anggota Tim Meninggalkan Ruang Operasi
			</h2>
		</div>

		<div class="col-12">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Perawat memastikan secara verbal
			</h4>
		</div>

		<div class="col-6">
			<Inputed :ref="form.sobagian1.name" :form="form.sobagian1"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sobagian2.name" :form="form.sobagian2"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.sobagian3.name" :form="form.sobagian3"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sobagian4.name" :form="form.sobagian4"></Inputed>
		</div>

		<div class="col-12">
			<Inputed :ref="form.sobagian41.name" :form="form.sobagian41"></Inputed>
		</div>

		<div class="col-12">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Untuk Dokter Bedah, Dokter Anastesi, dan Perawat :
			</h4>
		</div>

		<div class="col-6">
			<Inputed :ref="form.sobagian5.name" :form="form.sobagian5"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sobagian51.name" :form="form.sobagian51"></Inputed>
		</div>

	</div>

	<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form && activetab">
		<div class="col-8"></div>
		<div class="col-4" style="text-align: right">
			<button class="button-modal-page button-modal-blue" v-on:click="cancel()">Print Data</button>
			<button class="button-modal-page button-modal-green" v-on:click="action()">Add or Update</button>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formkeselamatanbedah } from './FormData.js';
import { parsekeselamatanbedah } from './Attachment.js';
var vm;
export default {
	emits: ["dialog", "parsingForm"],
	props: ['activetab'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; 
		vm.form = vm.formkeselamatanbedah();
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'keselamatanbedah'
	}},
	methods: {
		parsekeselamatanbedah, formkeselamatanbedah,

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		aturulang: function () { 
			vm.form = vm.formkeselamatanbedah(); 
		},

		setdataform: function (data, row) {
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
				namaoperator = data.nama_operator ? data.nama_operator : '';
				namaahlianastesi = data.nama_ahli_anastesi ? data.nama_ahli_anastesi : '';
				diagnosismedis = data.diagnosis_medis ? data.diagnosis_medis : '';
				tindakanoperasi = data.tindakan_operasi ? data.tindakan_operasi : '';
				asistenoperasi = data.asisten_operasi ? data.asisten_operasi : '';
				scrubnurses = data.scrub_nurses ? data.scrub_nurses : '';
				sibagian1 = data.si_bagian_1 ? data.si_bagian_1 : 'Ya';
				sibagian2 = data.si_bagian_2 ? data.si_bagian_2 : 'Ya';
				sibagian3 = data.si_bagian_3 ? data.si_bagian_3 : 'Ya';
				sibagian4 = data.si_bagian_4 ? data.si_bagian_4 : 'Ya';
				sibagian5 = data.si_bagian_5 ? data.si_bagian_5 : 'Ya';
				sibagian6 = data.si_bagian_6 ? data.si_bagian_6 : 'Ya';
				sibagian7 = data.si_bagian_7 ? data.si_bagian_7 : 'Ya';
				sinama = data.si_nama ? data.si_nama : '';
				tobagian1 = data.to_bagian_1 ? data.to_bagian_1 : 'Ya';
				tobagian21 = data.to_bagian_2_1 ? data.to_bagian_2_1 : '';
				tobagian22 = data.to_bagian_2_2 ? data.to_bagian_2_2 : '';
				tobagian23 = data.to_bagian_2_3 ? data.to_bagian_2_3 : '';
				tobagian3 = data.to_bagian_3 ? data.to_bagian_3 : '';
				tobagian41 = data.to_bagian_4_1 ? data.to_bagian_4_1 : '';
				tobagian42 = data.to_bagian_4_2 ? data.to_bagian_4_2 : '';
				tobagian5 = data.to_bagian_5 ? data.to_bagian_5 : 'Ya';
				tobagian6 = data.to_bagian_6 ? data.to_bagian_6 : 'Ya';
				tonama = data.to_nama ? data.to_nama : '';
				sobagian1 = data.so_bagian_1 ? data.so_bagian_1 : 'Ya';
				sobagian2 = data.so_bagian_2 ? data.so_bagian_2 : 'Ya';
				sobagian3 = data.so_bagian_3 ? data.so_bagian_3 : 'Ya';
				sobagian4 = data.so_bagian_4 ? data.so_bagian_4 : 'Ya';
				sobagian41 = data.so_bagian_4_1 ? data.so_bagian_4_1 : '';
				sobagian5 = data.so_bagian_5 ? data.so_bagian_5 : 'Ya';
				sobagian51 = data.so_bagian_5_1 ? data.so_bagian_5_1 : '';
			}
			console.log(data);
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah/perbaharui data pada halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, vm.keyform);
    },

		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parsekeselamatanbedah(vm.form), vm.keyform); 
		},
	}
}
</script>