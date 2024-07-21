<template>
	<div class="grid" v-if="form && activetab">
        <div class="col-4">
            <table class="table" style="margin-top: 10px;">
                <tbody>
                <tr>
                    <td colspan="2" style="text-align: center;">Mata</td>
                </tr>
                <tr>
                    <td style="text-align: center;">OS</td>
                    <td style="text-align: center;"><input class="checkbox" type="checkbox" :checked="os" value="os"
                        style="cursor: pointer;"> </td>
                </tr>
                <tr>
                    <td style="text-align: center;">OD</td>
                    <td style="text-align: center;"> 
                        <input class="checkbox" type="checkbox" :checked="od" value="od"
                        style="cursor: pointer;">
                    </td>
                </tr>
                </tbody>
                
            </table>
        </div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.namaoperator.name" :form="form.namaoperator"></Inputed>
		</div>
        <div class="col-4 form-ml">
			<Inputed :ref="form.asisten.name" :form="form.asisten"></Inputed>
		</div>
        <div class="col-4">
			<Inputed :ref="form.jenisoperasi.name" :form="form.jenisoperasi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.jamoperasi.name" :form="form.jamoperasi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.lamaoperasi.name" :form="form.lamaoperasi"></Inputed>
		</div>


		<div class="col-4">
			<Inputed :ref="form.diagnosis.name" :form="form.diagnosis"></Inputed>
		</div>

		

		

		<div class="col-4 form-ml">
			<Inputed :ref="form.anesthesia.name" :form="form.anesthesia"></Inputed>
		</div>

		 <div class="col-4 form-ml">
			<Inputed :ref="form.anesthesiologist.name" :form="form.anesthesiologist"></Inputed>
		</div> 

        <!-- <div class="col-12">
            1. Pasien berbaring dalam anesresi tropical / local / Umum <br>
            2. Dilakukan tindakan a & antiseptis menggunakan providone iodinen <br>
            3. Dipasangkan eye drape <br>
            4. Dipasangkan blefarostat <br>
            5. Dilakukan pengukuran menggunakan caliper / trocar dengan jarak 3,5/4 mm dari limbus di kuadran superior/temporal <br>
            6. Dilaukan injeksi avastin / intra vitreal sebanyak <Inputed :ref="form.intravitreal.name" :form="form.intravitreal"></Inputed> ml <br>
            7. Diteteskan antibiotik <br>
            8. Mata ditutup kassa & dop <br>
            9. Tindakan selesai
        </div> -->
		

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
import { formlaporaninjeksiantivega } from './FormData.js';
import { parselaporaninjeksiantivega } from './Attachment.js';
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
		vm.form = vm.formlaporaninjeksiantivega();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'laporaninjeksiantivega',
        os:false,
        od:false,
		// arr: {
		// 	ptkjeniskelamintarget: [
		// 		{ value: 'Laki-laki', label: 'Laki-laki' },
		// 		{ value: 'Perempuan', label: 'Perempuan' },
		// 	],
		// 	ptkjeniskelaminpenerima: [
		// 		{ value: 'Laki-laki', label: 'Laki-laki' },
		// 		{ value: 'Perempuan', label: 'Perempuan' },
		// 	]
		// }
	}},
	methods: {
		parselaporaninjeksiantivega, formlaporaninjeksiantivega,

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
			vm.form = vm.formlaporaninjeksiantivega(); 
            vm.os = false;
            vm.od = false;
		},

		setdataform: function (data, row) {
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
	
				vm.form.namaoperator.value = data.nama_operator ? data.nama_operator : '';
				vm.form.jamoperasi.value = data.jam_operasi ? data.jam_operasi : '';
				vm.form.lamaoperasi.value = data.lama_operasi ? data.lama_operasi : '';
				vm.form.diagnosis.value = data.diagnosis ? data.diagnosis : '';
				vm.form.asisten.value = data.asisten ? data.asisten : '';
				vm.form.jenisoperasi.value = data.jenis_operasi ? data.jenis_operasi : '';
                vm.form.anesthesia.value = data.anesthesia ? data.anesthesia : '';
                vm.form.anesthesiologist.value = data.anesthesiologist ? data.anesthesiologist : '';
                vm.form.intravitreal.value = data.intravitreal ? data.intravitreal : '';

                if (data.os == 'Ya') { vm.os = true; }
                if (data.od == 'Ya') { vm.od = true; }
				
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
            var input = document.querySelectorAll('.checkbox');
			for (var i = 0; i < input.length; i++) {
				if (input[i].checked) {
					if (input[i].value == 'os') { vm.form.os = 'Ya'; }
					else if (input[i].value == 'od') { vm.form.od = 'Ya'; }
                }
			else {
				if (input[i].value == 'os') { vm.form.os = 'Tidak'; }
				else if (input[i].value == 'od') { vm.form.od = 'Tidak'; }
            }
        }
			vm.$emit('parsingForm', vm.parselaporaninjeksiantivega(vm.form), vm.keyform); 
		},
	}
}
</script>