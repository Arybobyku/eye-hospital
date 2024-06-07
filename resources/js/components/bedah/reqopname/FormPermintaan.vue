<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content" :class="showups">
			<div class="modal-header">
				<button v-on:click="action()" v-if="!isapproval">Tambah atau Perbaharui</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">
					<span v-html="isapproval ? 'Daftar Permintaan Obat/Alkes' : 'Tambah atau Perbaharui data Permintaan/Alkes'"></span>
				</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-3 form-mr" v-if="!isapproval">
						<div class="grid">
							<div class="col-12">
								<Selected v-on:click="selectbox($event, form.select.obatgudang.name, form.select.obatgudang.statics)" 
									:ref="form.select.obatgudang.name" @selecteditem="selecteditem" @selectclear="selectclear"
									:selection="form.select.obatgudang" v-on:keyup="selectfilter($event, form.select.obatgudang.name)"></Selected>
							</div>

							<div class="col-12" v-if="form.detailobat != ''">
								<table class="table form-mb" style="border: none">
									<tbody>
										<tr>
											<td>Nama Obat</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailobat.nama }}</strong></td>
										</tr>
										<tr>
											<td>Golongan</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailobat.golongan }}</strong></td>
										</tr>
										<tr>
											<td>Formularium</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailobat.formularium }}</strong></td>
										</tr>
										<tr>
											<td>Kategori</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailobat.kategori }}</strong></td>
										</tr>
										<tr>
											<td>Jumlah / Satuan Besar</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailobat.jumlah_besar }} {{ form.detailobat.nama_satuan_besar }}</strong></td>
										</tr>
										<tr>
											<td>Jumlah / Satuan Kecil</td>
											<td style="margin-bottom: 10px;"><strong>{{ form.detailobat.jumlah_kecil }} {{ form.detailobat.nama_satuan_kecil }}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-12">
								<Inputed :ref="form.jumlah.name" :form="form.jumlah"></Inputed>
							</div>

						</div>

						<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;">
							<div class="col-6"></div>
							<div class="col-6" style="text-align: right">
								<button class="button-modal-page button-modal-red" v-on:click="clears()">Clear</button>
								<button class="button-modal-page button-modal-green" v-on:click="add()">Add</button>
							</div>
						</div>
					</div>
					<div :class="isapproval ? 'col-12' : 'col-9'">
						<div class="grid">
							

							<div class="col-12">
								<table class="table form-mb">
									<thead>
										<tr>
											<th :colspan="isapproval ? '7' : '8'">Data list obat yang diminta</th>
										</tr>
										<tr>
											<th>Nama Obat</th>
											<th>Kategori</th>
											<th>Golongan</th>
											<th>Formularium</th>
											<th>Stock Satuan Kecil</th>
											<th>Jumlah Permintaan</th>
											<th v-if="!isapproval">#</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(item, index) in listdata" v-if="listdata.length > 0">
											<td>{{ item.nama }}</td>
											<td>{{ item.kategori }}</td>
											<td>{{ item.golongan }}</td>
											<td>{{ item.formularium }}</td>
											<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
											<td>{{ item.minta_kecil }} {{ item.nama_satuan_kecil }}</td>
											<td v-if="!isapproval">
												<button class="tooltip btn-danger">
													<vue-feather type="trash-2" v-on:click="hapus(item, index)"></vue-feather> <span class="tooltiptext">Delete Data</span>
												</button>
											</td>
										</tr>
										<tr v-else>
											<td colspan="6">No Data for Result</td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>
					</div>
					
				</div>

			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formpermintaan } from './FormData.js';
import { parsepermintaan } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { arrpembelian } from '../../../module/DataArray.js';


var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formpermintaan();
		vm.init();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	computed: {
		showups:function () {
			let classes = '';
			if (this.isapproval) { classes = 'modal-semi-besar'; }
			else { classes = 'modal-besar'; }

			if (this.terminate.show) { classes += ' modal-opened'; }
			else { classes += ' modal-closed'; }
			return classes;
		}
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '',
		satuan : { kecil: '', besar: '' },
		hitung : { kecil: '', besar: '' },
		listdata: [], isapproval: false
	}},
	methods: {

		hapus:function(item, index) {
			vm.listdata.splice(index, 1);
		},

		init: function () {
			if (vm.form.detailobat != '') {
				vm.form.jumlah.disabled = false;
			}
			else {
				vm.form.jumlah.disabled = true;
			}
			
		},

		checkup:function(event, item) {
			if (vm.form.jumlah.value > (vm.form.detailobat.jumlah_kecil - 50)) {
				vm.form.jumlah.value = '';
			}
		},

		parsepermintaan, formpermintaan, initindexdb, indexdbprocessing, arrpembelian,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			console.log(item);
			vm.form = vm.conditionselected(vm.form, item, key, 'address'); 
			vm.form = vm.itemselected(vm.form, item, key);
			
			vm.satuan.besar = item.nama_satuan_besar;
			vm.satuan.kecil = item.nama_satuan_kecil;

			vm.hitung.besar = item.hitung_besar;
			vm.hitung.kecil = item.hitung_kecil;

			vm.form.detailobat = item;
			vm.init();
		},

		add:function() {

			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
				else {
					for (const keyselect in vm.form.select) {
						if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
					}
				}
			}

			if (next) {
				let tmp = {
					minta_kecil: vm.form.jumlah.value,
					minta_besar: parseInt(vm.form.jumlah.value) / parseInt(vm.form.detailobat.jumlah_kecil),
					formularium: vm.form.detailobat.formularium,
					golongan: vm.form.detailobat.golongan,
					hitung_besar: vm.form.detailobat.hitung_besar,
					hitung_kecil: vm.form.detailobat.hitung_kecil,
					id: vm.form.detailobat.id,
					jumlah_besar: vm.form.detailobat.jumlah_besar,
					jumlah_kecil: vm.form.detailobat.jumlah_kecil,
					kategori: vm.form.detailobat.kategori,
					keterangan: vm.form.detailobat.keterangan ? vm.form.detailobat.keterangan : '',
					label: vm.form.detailobat.label,
					nama: vm.form.detailobat.nama,
					nama_satuan_besar: vm.form.detailobat.nama_satuan_besar,
					nama_satuan_kecil: vm.form.detailobat.nama_satuan_kecil,
					nama_unit: vm.form.detailobat.nama_unit,
					obat_id: vm.form.detailobat.obat_id ? vm.form.detailobat.obat_id : 0,
					obat_uuid: vm.form.detailobat.obat_uuid,
					satuan_uuid_besar: vm.form.detailobat.satuan_uuid_besar ? vm.form.detailobat.satuan_uuid_besar : '',
					satuan_uuid_kecil: vm.form.detailobat.satuan_uuid_kecil ? vm.form.detailobat.satuan_uuid_kecil : '',
					unit_id: vm.form.detailobat.unit_id ? vm.form.detailobat.unit_id : 0,
					unit_uuid: vm.form.detailobat.unit_uuid,
					uuid: vm.form.detailobat.uuid,
					value: vm.form.detailobat.value,
					dari_unit_id: '5',
					dari_unit_uuid: 'c7887937-6e20-45dd-b437-f0ee6dccc1fa',
					dari_nama_unit: 'Bedah / Operasi',
				}

				vm.listdata.push(tmp);
				
				vm.clears();
			}
		},

		clears:function() {
			vm.form.detailobat = '';
			vm.satuan.besar = '';
			vm.satuan.kecil = '';
			vm.hitung.besar = '';
			vm.hitung.kecil = '';
			vm.form.select.obatgudang.value = '';
			vm.form.select.obatgudang.label = 'Silahkan Pilih';
			vm.form.jumlah.value = '';
			vm.init();
		},
		selectclear:function(key) { 
			vm.form.detailobat = '';
			vm.form = vm.clearselected(vm.form, key); 
		},
		selectbox:function(event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
			if (result._position == 'stop') { return ; }
			else if (result._position == 'nextstop') { vm.form = result._form; }
			else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
		},

		getIndexDB:function(key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ vm.form = vm.indexdbprocessing(response, vm.form, key); })
					.catch(function(error){ console.log(error); });
			}
		},

		action:function() { 
			if (vm.listdata.length > 0) { 
				vm.form.listdata = vm.listdata;
				vm.parsingForm(); vm.dialog(); 
			} 
		},

		show:function(posisi, title, uuid){ 
			vm.form.listdata = '';
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { 
			vm.form = vm.formpermintaan(); 
			vm.satuan = { kecil: '', besar: '' }
			vm.hitung = { kecil: '', besar: '' }
			vm.listdata = [];
			vm.isapproval = false;
		},
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function() { 
			vm.$emit('parsingForm', vm.parsepermintaan(vm.form), 'permintaan'); 
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 70); },

		setdataform: function (response) {
			let data = response.data.data;
			let status = '';
			if (data.length > 0) {
				for (let i = 0; i < data.length; i++) {
					vm.form.kode = data[i].kode;
					let tmp = {
						minta_kecil: data[i].minta_kecil,
						minta_besar: data[i].minta_besar,
						formularium: data[i].formularium,
						golongan: data[i].golongan,
						hitung_besar: data[i].hitung_besar,
						hitung_kecil: data[i].hitung_kecil,
						id: '',
						jumlah_besar: data[i].jumlah_besar,
						jumlah_kecil: data[i].jumlah_kecil,
						kategori: data[i].kategori,
						keterangan: '',
						label: data[i].label,
						nama: data[i].nama,
						nama_satuan_besar: data[i].nama_satuan_besar,
						nama_satuan_kecil: data[i].nama_satuan_kecil,
						nama_unit: data[i].nama_unit,
						obat_id: data[i].obat_id,
						obat_uuid: data[i].obat_uuid,
						satuan_uuid_besar: data[i].satuan_uuid_besar,
						satuan_uuid_kecil: data[i].satuan_uuid_kecil,
						unit_id: data[i].unit_id,
						unit_uuid: data[i].unit_uuid,
						uuid: '',
						value: '',
						dari_unit_id: data[i].dari_unit_id,
						dari_unit_uuid: data[i].dari_unit_uuid,
						dari_nama_unit: data[i].dari_nama_unit,
					}
					vm.listdata.push(tmp);
					status = data[i].status;
				}
			}

			if (status == 'Permintaan') {
				vm.isapproval = false;
			}
			else {
				vm.isapproval = true;
			}
			
			vm.loaderprocess();
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin melakukan request/permintaan obat/alkes ke gudang.';
			button = 'Ya, kirim permintaan';
      vm.$emit('dialog', text, button, 'formpermintaan');
    },
	}
}
</script>