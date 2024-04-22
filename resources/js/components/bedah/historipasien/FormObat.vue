<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-semi-besar" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<button v-on:click="action()">{{ btnlbl }}</button>
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">Pemberian Obat ke Pasien pada saat Pemulihan</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-6">
						<Selected v-on:click="selectbox($event, form.select.apotek.name, form.select.apotek.statics)" 
							:ref="form.select.apotek.name" @selecteditem="selecteditem" @selectclear="selectclear"
							:selection="form.select.apotek" v-on:keyup="selectfilter($event, form.select.apotek.name)"></Selected>
					</div>
					<div class="col-3 form-mr form-ml">
						<Inputed :ref="form.quantity.name" :form="form.quantity"></Inputed>
					</div>
					<div class="col-3 form-mr form-ml">
						<Inputed :ref="form.signaform.name" :form="form.signaform"></Inputed>
					</div>
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th>Nama Obat</th>
									<th>Signa</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Total</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(item, index) in listobat" v-if="listobat.length > 0">
									<td>{{ item.nama }}</td>
									<td>{{ item.signa }}</td>
									<td>{{ item.jumlah_kecil }} {{ item.nama_satuan_kecil }}</td>
									<td>{{ item.hja_resep }}</td>
									<td>{{ item.total }}</td>
									<td>
										<button class="tooltip btn-danger" v-on:click="removeobat(item, index)">
											<vue-feather type="trash"></vue-feather> 
											<span class="tooltiptext">Hapus Obat</span>
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
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formobat } from './FormData.js';
import { parseaddobat, parsedeleteobat } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import { formatrupiah } from '../../../module/Manipulation.js';

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formobat();
		window.addEventListener("click", function(event) {
			let a = event.target.className; 
			
			try { 
				if (a.split(" ")) { 
					a = a.split(" "); 
					
					if (a[0] != 'hospitals' && a[0] != 'click-title') { 
						vm.selecthide(); 
					} 
				} 
				if (event.target.className == '') { 
					vm.selecthide(); 
				} 
			} 
			catch { console.log('mistmatch'); } 
		});
	},
	created:function() {},
	data:function() { return { 
		terminate: { show: false, display: 'display: none' },
		form: null, btnlbl: '', detail: null, listobat: [], tempobat: null
	}},
	methods: {

		parseaddobat, formobat, parsedeleteobat, formatrupiah,

		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected, initindexdb, indexdbprocessing,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide:function() { vm.form = vm.hideselected(vm.form); },
		selecteditem:function(item, key) { 
			vm.form = vm.conditionselected(vm.form, item, key, 'address');
			vm.form = vm.itemselected(vm.form, item, key); 
			vm.tempobat = item;
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
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function(response){ 
						vm.form = vm.indexdbprocessing(response, vm.form, key); 
					})
					.catch(function(error){ console.log(error); });
			}
		},
		// keyinput: function(event) { console.log(event.target.value); },

		removeobat:function(item, index) {
			vm.form.uuid = item.uuid;
			console.log(item)
			vm.parsingForm('removedataobat'); vm.dialog('removedataobat');
		},

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { 
					//if (vm.form[key].required) {
					if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } 
					//}
				}
				else {
					for (const keyselect in vm.form.select) {
						if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
					}
				}
			}
			
			if (next) { 
				if (vm.tempobat) {
					let _total = parseInt(vm.form.quantity.value) * parseInt(vm.tempobat.hja_resep);
					vm.form.obat_uuid = vm.tempobat.obat_uuid;
					vm.form.nama = vm.tempobat.nama;
					vm.form.kategori = vm.tempobat.kategori;
					vm.form.formularium = vm.tempobat.formularium;
					vm.form.golongan = vm.tempobat.golongan;
					vm.form.satuan_uuid_besar = vm.tempobat.satuan_uuid_besar;
					vm.form.nama_satuan_besar = vm.tempobat.nama_satuan_besar;
					vm.form.satuan_uuid_kecil = vm.tempobat.satuan_uuid_kecil;
					vm.form.nama_satuan_kecil = vm.tempobat.nama_satuan_kecil;
					vm.form.hitung_besar = vm.tempobat.hitung_besar;
					vm.form.hitung_kecil = vm.tempobat.hitung_kecil;
					vm.form.harga_netto = vm.tempobat.harga_netto;
					vm.form.harga_netto_discount = vm.tempobat.harga_netto_discount ? vm.tempobat.harga_netto_discount : 0;
					vm.form.harga_netto_ppn = vm.tempobat.harga_netto_ppn;
					vm.form.hpp = vm.tempobat.hpp;
					vm.form.margin_resep = vm.tempobat.margin_resep;
					vm.form.margin_non_resep = vm.tempobat.margin_non_resep;
					vm.form.hja_resep = vm.tempobat.hja_resep;
					vm.form.hja_non_resep = vm.tempobat.hja_non_resep;
					vm.form.hja_resep_besar = vm.tempobat.hja_resep_besar;
					vm.form.hja_non_resep_besar = vm.tempobat.hja_non_resep_besar;
					vm.form.jumlah_kecil = vm.form.quantity.value;
					vm.form.jumlah_besar = parseFloat(vm.form.quantity.value/vm.tempobat.hitung_kecil);
					vm.form.signa = vm.form.signaform.value;
					vm.form.total = _total;
					
					console.log(vm.form)

					vm.tempobat = null;
					// vm.form.signa = '';
					// vm.form.quantity = '';
					// vm.form.select.apotek.value = '';
					// vm.form.select.apotek.label = 'Silahkan Pilih';

					vm.parsingForm('adddataobat'); 
					vm.dialog('adddataobat');

				}
			}
		},

		show:function(posisi, title, uuid, detail){
			vm.detail = detail; 
			console.log(detail)
			vm.form.jenis = detail.jenis;
			vm.form.registrasi_uuid = detail.registrasi_uuid;
			vm.form.carabayar_uuid = detail.carabayar_uuid;
			vm.form.carabayar_nama = detail.carabayar_nama;
			vm.btnlbl = 'Tambah Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi; 
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },
		aturulang: function () { vm.form = vm.formobat(); },
		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },
		parsingForm:function(posisi) {
			if (posisi == 'adddataobat') {
				vm.$emit('parsingForm', vm.parseaddobat(vm.form), 'addobat');
			}
			else {
				vm.$emit('parsingForm', vm.parsedeleteobat(vm.form), 'removeobat');
			}
			
		},

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {
			vm.listobat = [];
			console.log(response.data.data)
			let obats = response.data.data;
			for (let i = 0; i < obats.length; i++){

				let _total = parseInt(obats[i].quantity) * parseInt(obats[i].harga);
				let tmp = {
					uuid: obats[i].uuid,
					nama: obats[i].nama_obat,
					kategori: obats[i].kategori,
					formularium: obats[i].formularium,
					golongan: obats[i].golongan,
					satuan_uuid_besar: obats[i].satuan_uuid_besar,
					nama_satuan_besar: obats[i].nama_satuan_besar,
					satuan_uuid_kecil: obats[i].satuan_uuid_kecil,
					nama_satuan_kecil: obats[i].nama_satuan_kecil,
					hitung_besar: obats[i].hitung_besar,
					hitung_kecil: obats[i].hitung_kecil,
					harga_netto: obats[i].harga_netto,
					harga_netto_discount: obats[i].harga_netto_discount,
					harga_netto_ppn: obats[i].harga_netto_ppn,
					hpp: obats[i].hpp,
					margin_resep: obats[i].margin_resep,
					margin_non_resep: obats[i].margin_non_resep,
					hja_resep: vm.formatrupiah(obats[i].hja_resep.toString()),
					hja_non_resep: obats[i].hja_non_resep,
					hja_resep_besar: obats[i].hja_resep_besar,
					hja_non_resep_besar: obats[i].hja_non_resep_besar,
					jumlah_kecil: obats[i].jumlah_kecil,
					jumlah_besar: obats[i].jumlah_besar,
					signa: obats[i].signa,
					total: vm.formatrupiah(obats[i].total.toString()),
				}
				vm.listobat.push(tmp);
			}

			vm.form.select.apotek.value = '';
			vm.form.select.apotek.label = 'Silahkan Pilih';
			vm.form.quantity.value = '';
			vm.form.signaform.value = '';
			vm.form.uuid = '';
			vm.loaderprocess();
		},

		dialog:function(posisi){
			let text = '', button = '';
			if (posisi == 'adddataobat') {
				text = 'Yakin ingin menambah data pada halaman ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin menghapus data ini.';
				button = 'Ya, hapus data';
			}
      vm.$emit('dialog', text, button, posisi);
    },
	}
}
</script>