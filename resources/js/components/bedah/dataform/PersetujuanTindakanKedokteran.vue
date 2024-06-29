<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-6">
			<Inputed :ref="form.tanggal.name" :form="form.tanggal"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.pukul.name" :form="form.pukul"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.dokterpelaksanatindakan.name" :form="form.dokterpelaksanatindakan"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.pemberiinformasi.name" :form="form.pemberiinformasi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.penerimapenolakinformasi.name" :form="form.penerimapenolakinformasi"></Inputed>
		</div>

		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Jenis Informasi</h3>
		</div>

		<div class="col-3">
			<Inputed :ref="form.jidiagnosiswddd.name" :form="form.jidiagnosiswddd"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jidasardiagnosis.name" :form="form.jidasardiagnosis"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jitindakankedokteran.name" :form="form.jitindakankedokteran"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jiindikasitindakan.name" :form="form.jiindikasitindakan"></Inputed>
		</div>

		<div class="col-3">
			<Inputed :ref="form.jitatacara.name" :form="form.jitatacara"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jitujuan.name" :form="form.jitujuan"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jiresiko.name" :form="form.jiresiko"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jikomplikasi.name" :form="form.jikomplikasi"></Inputed>
		</div>

		<div class="col-3">
			<Inputed :ref="form.jiprognosis.name" :form="form.jiprognosis"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.jialternatifdanresiko.name" :form="form.jialternatifdanresiko"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.jilainlain.name" :form="form.jilainlain"></Inputed>
		</div>

		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Yang bertanda tangan dibawah ini</h3>
		</div>

		<div class="col-6">
			<Inputed :ref="form.ptknamapenerima.name" :form="form.ptknamapenerima"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.ptktanggallahirpenerima.name" :form="form.ptktanggallahirpenerima"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Selected
				v-on:click="selectbox($event, form.select.ptkjeniskelaminpenerima.name, form.select.ptkjeniskelaminpenerima.statics)"
				:ref="form.select.ptkjeniskelaminpenerima.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.ptkjeniskelaminpenerima"></Selected>
		</div>

		<div class="col-8">
			<Inputed :ref="form.ptkalamatpenerima.name" :form="form.ptkalamatpenerima"></Inputed>
		</div>

		<div class="col-4 form-ml">
			<Inputed :ref="form.ptkhubunganpenerima.name" :form="form.ptkhubunganpenerima"></Inputed>
		</div>

		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Yang menyatakan persetujuan</h3>
		</div>

		<div class="col-6">
			<Inputed :ref="form.ptktindakan.name" :form="form.ptktindakan"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.ptkterhadap.name" :form="form.ptkterhadap"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.ptknamatarget.name" :form="form.ptknamatarget"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Inputed :ref="form.ptktanggallahirtarget.name" :form="form.ptktanggallahirtarget"></Inputed>
		</div>

		<div class="col-3 form-ml">
			<Selected
				v-on:click="selectbox($event, form.select.ptkjeniskelamintarget.name, form.select.ptkjeniskelamintarget.statics)"
				:ref="form.select.ptkjeniskelamintarget.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.ptkjeniskelamintarget"></Selected>
		</div>

		<div class="col-12">
			<Inputed :ref="form.ptkalamattarget.name" :form="form.ptkalamattarget"></Inputed>
		</div>

		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Nama yang menandatangani</h3>
		</div>

		<div class="col-4">
			<Inputed :ref="form.namatarget.name" :form="form.namatarget"></Inputed>
		</div>

		<div class="col-4 form-ml">
			<Inputed :ref="form.namasaksi.name" :form="form.namasaksi"></Inputed>
		</div>

		<div class="col-4 form-ml">
			<Inputed :ref="form.perawat.name" :form="form.perawat"></Inputed>
		</div>

	</div>

	<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form && activetab">
		<div class="col-8"></div>
		<div class="col-4" style="text-align: right">
			<button class="button-modal-page button-modal-blue" v-on:click="printsa()">Print ss</button>
			<button class="button-modal-page button-modal-green" v-on:click="action()">Add or Update</button>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formpersetujuantindakankedokteran } from './FormData.js';
import { parsepersetujuantindakankedokteran } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
var vm;
export default {
	emits: ["dialog", "parsingForm"],
	props: ['activetab'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),

	},
	mounted:function() { 
		vm = this; 
		vm.form = vm.formpersetujuantindakankedokteran();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'persetujuantindakankedokteran',
		arr: {
			ptkjeniskelamintarget: [
				{ value: 'Laki-laki', label: 'Laki-laki' },
				{ value: 'Perempuan', label: 'Perempuan' },
			],
			ptkjeniskelaminpenerima: [
				{ value: 'Laki-laki', label: 'Laki-laki' },
				{ value: 'Perempuan', label: 'Perempuan' },
			]
		}
	}},
	methods: {
		parsepersetujuantindakankedokteran, formpersetujuantindakankedokteran,

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

		aturulang: function () { 
			vm.form = vm.formpersetujuantindakankedokteran(); 
		},

		setdataform: function (data, row) {
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
				vm.form.dokterpelaksanatindakan.value = data.dokter_pelaksana_tindakan ? data.dokter_pelaksana_tindakan : '';
				vm.form.pemberiinformasi.value = data.pemberi_informasi ? data.pemberi_informasi : '';
				vm.form.penerimapenolakinformasi.value = data.penerima_penolak_informasi ? data.penerima_penolak_informasi : '';
				vm.form.jidiagnosiswddd.value = data.ji_diagnosis_wd_dd ? data.ji_diagnosis_wd_dd : '';
				vm.form.jidasardiagnosis.value = data.ji_dasar_diagnosis ? data.ji_dasar_diagnosis : '';
				vm.form.jitindakankedokteran.value = data.ji_tindakan_kedokteran ? data.ji_tindakan_kedokteran : '';
				vm.form.jiindikasitindakan.value = data.ji_indikasi_tindakan ? data.ji_indikasi_tindakan : '';
				vm.form.jitatacara.value = data.ji_tata_cara ? data.ji_tata_cara : '';
				vm.form.jitujuan.value = data.ji_tujuan ? data.ji_tujuan : '';
				vm.form.jiresiko.value = data.ji_resiko ? data.ji_resiko : '';
				vm.form.jikomplikasi.value = data.ji_komplikasi ? data.ji_komplikasi : '';
				vm.form.jiprognosis.value = data.ji_prognosis ? data.ji_prognosis : '';
				vm.form.jialternatifdanresiko.value = data.ji_alternatif_dan_resiko ? data.ji_alternatif_dan_resiko : '';
				vm.form.jilainlain.value = data.ji_lain_lain ? data.ji_lain_lain : '';
				vm.form.ptknamapenerima.value = data.ptk_nama_penerima ? data.ptk_nama_penerima : '';
				vm.form.ptktanggallahirpenerima.value = data.ptk_tanggal_lahir_penerima ? data.ptk_tanggal_lahir_penerima : '';
				vm.form.ptkalamatpenerima.value = data.ptk_alamat_penerima ? data.ptk_alamat_penerima : '';
				vm.form.ptkhubunganpenerima.value = data.ptk_hubungan_penerima ? data.ptk_hubungan_penerima : '';
				vm.form.ptktindakan.value = data.ptk_tindakan ? data.ptk_tindakan : '';
				vm.form.ptkterhadap.value = data.ptk_terhadap ? data.ptk_terhadap : '';
				vm.form.ptknamatarget.value = data.ptk_nama_target ? data.ptk_nama_target : '';
				vm.form.ptktanggallahirtarget.value = data.ptk_tanggal_lahir_target ? data.ptk_tanggal_lahir_target : '';
				vm.form.ptkalamattarget.value = data.ptk_alamat_target ? data.ptk_alamat_target : '';
				vm.form.tanggal.value = data.tanggal ? data.tanggal : '';
				vm.form.pukul.value = data.pukul ? data.pukul : '';
				vm.form.namatarget.value = data.nama_target ? data.nama_target : '';
				vm.form.namasaksi.value = data.nama_saksi ? data.nama_saksi : '';
				vm.form.perawat.value = data.perawat ? data.perawat : '';
				
				if (data.ptk_jenis_kelamin_target) {
					vm.form.select.ptkjeniskelamintarget.value = data.ptk_jenis_kelamin_target;
					vm.form.select.ptkjeniskelamintarget.label = data.ptk_jenis_kelamin_target;
				}
				else {
					vm.form.select.ptkjeniskelamintarget.value = '';
					vm.form.select.ptkjeniskelamintarget.label = 'Silahkan Pilih';
				}

				if (data.ptk_jenis_kelamin_penerima) {
					vm.form.select.ptkjeniskelaminpenerima.value = data.ptk_jenis_kelamin_penerima;
					vm.form.select.ptkjeniskelaminpenerima.label = data.ptk_jenis_kelamin_penerima;
				}
				else {
					vm.form.select.ptkjeniskelaminpenerima.value = '';
					vm.form.select.ptkjeniskelaminpenerima.label = 'Silahkan Pilih';
				}
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
			vm.$emit('parsingForm', vm.parsepersetujuantindakankedokteran(vm.form), vm.keyform); 
		},
		printsa: function () {
			console.log(vm.form.bedah_uuid);

			window.open('/print/parsepersetujuantindakankedokteran/' + vm.form.bedah_uuid, '_blank');
		},

	}
}
</script>