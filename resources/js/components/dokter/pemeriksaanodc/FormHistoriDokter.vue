<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar tambah" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Histori Pemeriksaan Dokter</h2>
			</div>
			<div class="modal-body" v-if="data.length > 0">
				<div class="grid">
					<div class="col-5 form-mr">
						<table class="table">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>No. Registrasi</th>
									<th>Dokter yang menangani</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr v-if="data.length > 0" v-for="(item, index) in data">
									<td>{{ datename(item.tanggal) }}</td>
									<td>{{ item.registrasi_kode }}{{ item.registrasi_nomor }}</td>
									<td>{{ item.nama_dokter }}</td>
									<td>
										<button class="button-modal-page button-modal-green" v-on:click="look(index)">Detail</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-7 form-ml form-mr" v-if="detail">
						<table class="table embed" style="border: 0;">

							<tr>
								<td colspan="2">
									<table class="table">
										<thead>
											<tr>
												<th>Tanggal</th>
												<td colspan="2">{{ datename(detail.tanggal) }}</td>
											</tr>
											<tr>
												<th>No Registrasi</th>
												<td colspan="2">{{ detail.registrasi_kode }}{{ detail.registrasi_nomor }}</td>
											</tr>
											<tr>
												<th>Dokter yang menangani</th>
												<td colspan="2">{{ detail.nama_dokter }}</td>
											</tr>
										</thead>
										<thead>
											<tr>
												<th>Nama Item</th>
												<th>Ocular Dextra</th>
												<th>Ocular Sinistra</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>BIlik Mata Depan</td>
												<td>{{ detail.ocular_dextra_bilik_mata_depan }}</td>
												<td>{{ detail.ocular_sinistra_bilik_mata_depan }}</td>
											</tr>
											<tr>
												<td>Conjungtiva</td>
												<td>{{ detail.ocular_dextra_conjunctiva }}</td>
												<td>{{ detail.ocular_sinistra_conjunctiva }}</td>
											</tr>
											<tr>
												<td>Cornea</td>
												<td>{{ detail.ocular_dextra_cornea }}</td>
												<td>{{ detail.ocular_sinistra_cornea }}</td>
											</tr>
											<tr>
												<td>Fundoscopy</td>
												<td>{{ detail.ocular_dextra_funduscopy }}</td>
												<td>{{ detail.ocular_sinistra_funduscopy }}</td>
											</tr>
											<tr>
												<td>Lensa</td>
												<td>{{ detail.ocular_dextra_lensa }}</td>
												<td>{{ detail.ocular_sinistra_lensa }}</td>
											</tr>
											<tr>
												<td>Palperbra</td>
												<td>{{ detail.ocular_dextra_palpebra }}</td>
												<td>{{ detail.ocular_sinistra_palpebra }}</td>
											</tr>
											<tr>
												<td>Pupil dan Iris</td>
												<td>{{ detail.ocular_dextra_pupil_dan_iris }}</td>
												<td>{{ detail.ocular_sinistra_pupil_dan_iris }}</td>
											</tr>
											<tr>
												<td>Vetreous</td>
												<td>{{ detail.ocular_dextra_vitreous }}</td>
												<td>{{ detail.ocular_sinistra_vitreous }}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>

							<tr>
								<th style="text-align:left">Diagnosa</th>
								<td style="text-align: right;">{{ detail.pemeriksaan_diagnosa }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Penunjang</th>
								<td style="text-align: right;">{{ detail.pemeriksaan_penunjang }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Prognosa</th>
								<td style="text-align: right;">{{ detail.pemeriksaan_prognosa }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Tindakan</th>
								<td style="text-align: right;">{{ detail.pemeriksaan_tindakan }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Tata Laksana</th>
								<td style="text-align: right;">{{ detail.pemeriksaan_tata_laksana }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Pergerakan Bola Mata</th>
								<td style="text-align: right;">{{ detail.nadi }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Posisi Bola Mata</th>
								<td style="text-align: right;">{{ detail.posisi_bola_mata }}</td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>

			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>

<script>


var vm, body;
import { datename } from '../../../module/Manipulation.js';
export default {
	mounted: function() {
		vm = this;
		body = document.body;
	},
	data:function() { return { 
		data: [], detail: null,
		terminate: { show: false, display: 'display: none' },
	}},
	methods: {

		datename,

		show:function(posisi, title, uuid){ 
			vm.btnlbl = posisi == 'adddata' ? 'Save Data' : 'Update Data'; 
			 body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
    },

		hide:function() { vm.terminate.show = false; setTimeout(function() { vm.terminate.display = 'display: none'; body.style.overflowY = 'auto'; }, 250, this); },

		loaderprocess:function() { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },
		setdataform: function (response) {
			vm.data = response.data.histori;
			// vm.loaderprocess();
		},
		aturulang: function() {
			vm.data = [];
		},

		look: function(index) {
			vm.detail = vm.data[index];
		}
	}
}

</script>
<style>
table.embed tr td  {
	padding: 10px;
	border-bottom: 1px solid #c0c0c0;
}

table.embed tr th  {
	padding: 10px;
	border-bottom: 1px solid #c0c0c0;
}
.tambah {
	min-height: 400px;
}
</style>