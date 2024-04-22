<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-6">
			<Inputed :ref="form.ruang.name" :form="form.ruang"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.kamar.name" :form="form.kamar"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.diagnosa.name" :form="form.diagnosa"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.tindakan.name" :form="form.tindakan"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.teknikanastesi.name" :form="form.teknikanastesi"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.tanggaltindakan.name" :form="form.tanggaltindakan"></Inputed>
		</div>

		<div class="col-6">
			<Selected v-on:click="selectbox($event, form.select.listrik.name, form.select.listrik.statics)" 
				:ref="form.select.listrik.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.listrik"></Selected>
			<table class="table">
				<thead>
					<tr><th colspan="3">Datalist : LISTRIK</th></tr>
					<tr>
						<th>No.</th>
						<th>Nama Item</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody v-if="listdata.listrik.length > 0">
					<tr v-for="(item, index) in listdata.listrik">
						<td>{{ index+1 }}</td>
						<td>{{ item.nama }}</td>
						<td>
							<button class="tooltip btn-danger" v-on:click="removed(index, 'listrik')">
									<vue-feather type="trash"></vue-feather> 
									<span class="tooltiptext">Hapus Data</span>
							</button>
						</td>
					</tr>
				</tbody>
				<tbody v-else><tr><td colspan="3">No data for Result</td></tr></tbody>
			</table>
		</div>
		<div class="col-6 form-ml">
			<Selected v-on:click="selectbox($event, form.select.alat.name, form.select.alat.statics)" 
				:ref="form.select.alat.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.alat"></Selected>
			<table class="table">
				<thead>
					<tr><th colspan="3">Datalist : ALAT</th></tr>
					<tr>
						<th>No.</th>
						<th>Nama Item</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody v-if="listdata.alat.length > 0">
					<tr v-for="(item, index) in listdata.alat">
						<td>{{ index+1 }}</td>
						<td>{{ item.nama }}</td>
						<td>
							<button class="tooltip btn-danger" v-on:click="removed(index, 'alat')">
									<vue-feather type="trash"></vue-feather> 
									<span class="tooltiptext">Hapus Data</span>
							</button>
						</td>
					</tr>
				</tbody>
				<tbody v-else><tr><td colspan="3">No data for Result</td></tr></tbody>
			</table>
		</div>

		<div class="col-6" style="margin-top: 14px">
			<Selected v-on:click="selectbox($event, form.select.linensteril.name, form.select.linensteril.statics)" 
				:ref="form.select.linensteril.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.linensteril"></Selected>
			<table class="table">
				<thead>
					<tr><th colspan="3">Datalist : LINEN STERIL</th></tr>
					<tr>
						<th>No.</th>
						<th>Nama Item</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody v-if="listdata.linensteril.length > 0">
					<tr v-for="(item, index) in listdata.linensteril">
						<td>{{ index+1 }}</td>
						<td>{{ item.nama }}</td>
						<td>
							<button class="tooltip btn-danger" v-on:click="removed(index, 'linensteril')">
									<vue-feather type="trash"></vue-feather> 
									<span class="tooltiptext">Hapus Data</span>
							</button>
						</td>
					</tr>
				</tbody>
				<tbody v-else><tr><td colspan="3">No data for Result</td></tr></tbody>
			</table>
		</div>
		<div class="col-6 form-ml" style="margin-top: 14px">
			<Selected v-on:click="selectbox($event, form.select.akhp.name, form.select.akhp.statics)" 
				:ref="form.select.akhp.name" @selecteditem="selecteditem" @selectclear="selectclear"
				:selection="form.select.akhp"></Selected>
			<table class="table">
				<thead>
					<tr><th colspan="3">Datalist : AKHP</th></tr>
					<tr>
						<th>No.</th>
						<th>Nama Item</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody v-if="listdata.akhp.length > 0">
					<tr v-for="(item, index) in listdata.akhp">
						<td>{{ index+1 }}</td>
						<td>{{ item.nama }}</td>
						<td>
							<button class="tooltip btn-danger" v-on:click="removed(index, 'akhp')">
									<vue-feather type="trash"></vue-feather> 
									<span class="tooltiptext">Hapus Data</span>
							</button>
						</td>
					</tr>
				</tbody>
				<tbody v-else><tr><td colspan="3">No data for Result</td></tr></tbody>
			</table>
		</div>

		<div class="col-12" style="margin-top: 10px">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">Pemeriksaan</h3>
		</div>
		
		<div class="col-6">
			<Inputed :ref="form.perawatkamarbedah.name" :form="form.perawatkamarbedah"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.kepalaruangan.name" :form="form.kepalaruangan"></Inputed>
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
import { formchecklistkesiapanbedah } from './FormData.js';
import { parsechecklistkesiapanbedah } from './Attachment.js';
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
		vm.form = vm.formchecklistkesiapanbedah();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'checklistkesiapanbedah',
		listdata: { listrik: [], alat: [], linensteril: [], akhp: [], },
		arr: {
			listrik: [
				{ value: 'Mesin Phaco terhubung dengan sumber listrik, indikator (+)', label: 'Mesin Phaco terhubung dengan sumber listrik, indikator (+)' },
				{ value: 'Mesin anastesi terhubung dengan sumber listrik, indikator (+)', label: 'Mesin anastesi terhubung dengan sumber listrik, indikator (+)' },
				{ value: 'Light source, monitor Mata terhubung dengan sumber listrik, indikator (+)', label: 'Light source, monitor Mata terhubung dengan sumber listrik, indikator (+)' },
				{ value: 'Extention kabel terhubung degan sumber listrik, indikator (+)', label: 'Extention kabel terhubung degan sumber listrik, indikator (+)' },
				{ value: 'Meja operasi terhubung degan sumber listrik, indikator (+)', label: 'Meja operasi terhubung degan sumber listrik, indikator (+)' },
				{ value: 'Microskop terhubung dengan sumber listrik, indikator (+)', label: 'Microskop terhubung dengan sumber listrik, indikator (+)' },
				{ value: 'Lampu kamar operasi menyala', label: 'Lampu kamar operasi menyala' },
				{ value: 'AC berfungsi dengan baik', label: 'AC berfungsi dengan baik' },
				{ value: 'Gas medis terhubung dengan mesin, indikator (+)', label: 'Gas medis terhubung dengan mesin, indikator (+)' },
			],
			alat: [
				{ value: 'Casette, selang, Diatermi, dan kenoktor Mesin Phaco sudah tersedia', label: 'Casette, selang, Diatermi, dan kenoktor Mesin Phaco sudah tersedia' },
				{ value: 'Patient plate sudah tersedia', label: 'Patient plate sudah tersedia' },
				{ value: 'Instrument steril sesuai dengan kebutuhan sudah tersedia', label: 'Instrument steril sesuai dengan kebutuhan sudah tersedia' },
				{ value: 'Handle Microskop streril', label: 'Handle Microskop streril' },
				{ value: 'Kom kidney steril sudah tersedia', label: 'Kom kidney steril sudah tersedia' },
			],
			linensteril: [
				{ value: 'Jas steril', label: 'Jas steril' },
				{ value: 'Duk steril', label: 'Duk steril' },
				{ value: 'Linen meja instrumen', label: 'Linen meja instrumen' },
				{ value: 'Kasa', label: 'Kasa' },
			],
			akhp: [
				{ value: 'Tersedia AKHP sesuai kebutuhan', label: 'Tersedia AKHP sesuai kebutuhan' },
			]
		}
	}},
	methods: {
		parsechecklistkesiapanbedah, formchecklistkesiapanbedah,

		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 
			let row = { nama: item.value };
			vm.listdata[key].push(row);
			vm.form.select[key].value = '';
			vm.form.select[key].label = 'Silahkan Pilih';
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

		removed:function(index, key) {
			vm.listdata[key].splice(index, 1);
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		aturulang: function () { 
			vm.form = vm.formchecklistkesiapanbedah(); 
		},

		setdataform: function (data, row) {
			vm.aturulang();
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
				if (data.listrik && data.listrik != '') { vm.listdata.listrik = JSON.parse(data.listrik); }
				if (data.alat && data.alat != '') { vm.listdata.alat = JSON.parse(data.alat); }
				if (data.linen_steril && data.linensteril != '') { vm.listdata.linen_steril = JSON.parse(data.linen_steril); }
				if (data.akhp && data.akhp != '') { vm.listdata.akhp = JSON.parse(data.akhp); }

				vm.form.ruang.value = data.ruangan ? data.ruangan : '';
				vm.form.kamar.value = data.kamar ? data.kamar : '';
				vm.form.diagnosa.value = data.diagnosa ? data.diagnosa : '';
				vm.form.tindakan.value = data.tindakan ? data.tindakan : '';
				vm.form.teknikanastesi.value = data.teknik_anastesi ? data.teknik_anastesi : '';
				vm.form.tanggaltindakan.value = data.tanggal_tindakan ? data.tanggal_tindakan : '';
				vm.form.perawatkamarbedah.value = data.perawat_kamar_bedah ? data.perawat_kamar_bedah : '';
				vm.form.kepalaruangan.value = data.kepala_ruangan ? data.kepala_ruangan : '';
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
			let tmp_listrik = '';
			let tmp_alat = '';
			let tmp_linensteril = '';
			let tmp_akhp = '';
			if (vm.listdata.listrik.length > 0) { tmp_listrik = JSON.stringify(vm.listdata.listrik); }
			if (vm.listdata.alat.length > 0) { tmp_alat = JSON.stringify(vm.listdata.alat); }
			if (vm.listdata.linensteril.length > 0) { tmp_alat = JSON.stringify(vm.listdata.linensteril); }
			if (vm.listdata.akhp.length > 0) { tmp_akhp = JSON.stringify(vm.listdata.akhp); }


			vm.$emit('parsingForm', vm.parsechecklistkesiapanbedah(vm.form, tmp_listrik, tmp_alat, tmp_linensteril, tmp_akhp), vm.keyform); 
		},
	}
}
</script>