<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content" :class="showups">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">
					<span>Daftar Permintaan Obat/Alkes</span>
				</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">
					<div class="col-12">
						<div class="grid">
							<div class="col-12">
								<table class="table form-mb">
									<thead>
										<tr>
											<th colspan="7">Data list obat yang diminta</th>
										</tr>
										<tr>
											<th>Nama Obat</th>
											<th>Kategori</th>
											<th>Golongan</th>
											<th>Formularium</th>
											<th>Stock Satuan Kecil</th>
											<th>Jumlah Permintaan</th>
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
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
	},
	mounted:function() { 
		vm = this; body = document.body;
		vm.form = vm.formpermintaan();
		window.addEventListener("click", function(event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } });
	},
	computed: {
		showups:function () {
			let classes = '';
			if (this.isapproval) { classes = 'modal-semi-besar'; }
			else { classes = 'modal-semi-besar'; }

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

		parsepermintaan, formpermintaan, initindexdb, indexdbprocessing, arrpembelian,


		show:function(posisi, title, uuid){ 
			vm.form.listdata = '';
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

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 170); },

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
	}
}
</script>