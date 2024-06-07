<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar tambah" :class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Histori Pemeriksaan RO</h2>
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
												<td>PD</td>
												<td colspan="2">{{ detail.ocular_dextra_pd }}</td>
											</tr>
											<tr>
												<td>Autoref</td>
												<td>{{ detail.ocular_dextra_autoref }}</td>
												<td>{{ detail.ocular_sinistra_autoref }}</td>
											</tr>
											<tr>
												<td>Add</td>
												<td>{{ detail.ocular_dextra_add }}</td>
												<td>{{ detail.ocular_sinistra_add }}</td>
											</tr>
											<tr>
												<td>BCVA</td>
												<td>{{ detail.ocular_dextra_bcva1 }} -> {{ detail.ocular_dextra_bcva2 }}</td>
												<td>{{ detail.ocular_sinistra_bcva1 }} -> {{ detail.ocular_dextra_bcva2 }}</td>
											</tr>
											<tr>
												<td>Keratometri K1</td>
												<td>{{ detail.ocular_dextra_keratometri_k1 }}</td>
												<td>{{ detail.ocular_sinistra_keratometri_k1 }}</td>
											</tr>
											<tr>
												<td>Keratometri K2</td>
												<td>{{ detail.ocular_dextra_keratometri_k2 }}</td>
												<td>{{ detail.ocular_sinistra_keratometri_k2 }}</td>
											</tr>
											<tr>
												<td>Tonometri</td>
												<td>{{ detail.ocular_dextra_tonometri }}</td>
												<td>{{ detail.ocular_sinistra_tonometri }}</td>
											</tr>
											<tr>
												<td>Visus</td>
												<td>{{ detail.ocular_dextra_visus }}</td>
												<td>{{ detail.ocular_sinistra_visus }}</td>
											</tr>
											<tr>
												<th colspan="3">Kacamata lama</th>
											</tr>
											<tr>
												<td>Sph</td>
												<td>{{ detail.ocular_dextra_kacamata_lama_sph }}</td>
												<td>{{ detail.ocular_sinistra_kacamata_lama_sph }}</td>
											</tr>
											<tr>
												<td>Cyl</td>
												<td>{{ detail.ocular_dextra_kacamata_lama_cyl }}</td>
												<td>{{ detail.ocular_sinistra_kacamata_lama_cyl }}</td>
											</tr>
											<tr>
												<td>Addisi</td>
												<td>{{ detail.ocular_dextra_kacamata_lama_addisi }}</td>
												<td>{{ detail.ocular_sinistra_kacamata_lama_addisi }}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>

							<tr>
								<th style="text-align:left">Keluhan Utama</th>
								<td style="text-align: right;">{{ detail.keluhan_utama }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Riwayat Penyakit</th>
								<td style="text-align: right;">{{ detail.riwayat_penyakit }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Kasus Urgent</th>
								<td style="text-align: right;">{{ detail.kasus_urgent }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Status Psikologi</th>
								<td style="text-align: right;">{{ detail.status_psikologi }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Status Fungsional</th>
								<td style="text-align: right;">{{ detail.status_fungsional }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Nadi</th>
								<td style="text-align: right;">{{ detail.nadi }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Tinggi Badan</th>
								<td style="text-align: right;">{{ detail.tinggi_badan }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Berat Badan</th>
								<td style="text-align: right;">{{ detail.berat_badan }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Tekanan Darah</th>
								<td style="text-align: right;">{{ detail.tekanan_darah }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Nyeri</th>
								<td style="text-align: right;">{{ detail.nyeri }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Nyeri hilang bila</th>
								<td style="text-align: right;">{{ detail.nyeri_hilang_bila }}</td>
							</tr>
							<tr>
								<th style="text-align:left">Skala Nyeri</th>
								<td style="text-align: right;">{{ detail.skala_nyeri }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Lokasi Nyeri</th>
								<td style="text-align: right;">{{ detail.lokasi_nyeri }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Durasi Nyeri</th>
								<td style="text-align: right;">{{ detail.durasi_nyeri }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Karakteristik Nyeri</th>
								<td style="text-align: right;">{{ detail.karakteristik_nyeri }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Keterangan Tambahan</th>
								<td style="text-align: right;">{{ detail.keterangan_nyeri }}</td>
							</tr>


							<tr>
								<th style="text-align:left">Penyakit yang pernah diderita</th>
								<td style="text-align: right;">{{ detail.penyakit_pernah_diderita_lainnya }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Pernah Dioperasi</th>
								<td style="text-align: right;">{{ detail.pernah_dioperasi }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Riwayat Alergi Makanan</th>
								<td style="text-align: right;">{{ detail.riwayat_alergi_makanan }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Riwayat Alergi Obatan</th>
								<td style="text-align: right;">{{ detail.riwayat_alergi_obatan }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Obat yang digunakan saat ini</th>
								<td style="text-align: right;">{{ detail.obat_digunakan_saat_ini }}</td>
							</tr>

							<tr>
								<th style="text-align:left">Penilaian Resiko Jatuh</th>
								<td style="text-align: right;">{{ detail.penilaian_resiko_jatuh }}</td>
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
			vm.loaderprocess();
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