<template>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr class="table-header">
					<th>No.</th>
					<th>Kunjungan</th>
					<th>Tanggal</th>
					<th>Waktu</th>
					<th>No Antrian</th>
					<th>No Registrasi</th>
					<th>Dokter (umum) yang menangani</th>
					<th>Status</th>
					<!-- <th>#</th> -->
				</tr>
			</thead>
			<tbody>
				<tr v-if="histori.length > 0" v-for="(item, index) in histori">
					<td>{{ index + 1 }}</td>
					<td>{{ item.jenis }}</td>
					<td>{{ item.tanggal }}</td>
					<td>{{ item.waktu }}</td>
					<td>{{ item.no_pendaftaran }}</td>
					<td>{{ item.kode }}{{ item.nomor }}</td>
					<td>{{ item.nama_dokter_umum }}</td>
					<td>
						<div class="badge badge-danger" v-if="item.status == 'Batal'">{{ item.status }}</div>
						<div class="badge badge-success" v-else>{{ item.status }}</div>
					</td>
					<!-- <td style="width: 60px;">
						<div class="btn-group">
							<button class="tooltip btn-success" v-on:click="historidetail(item)">
								<vue-feather type="arrow-up"></vue-feather> 
								<span class="tooltiptext-mini" style="width: 50px;">Detail</span>
							</button>
						</div>
					</td> -->
				</tr>
				<tr v-else>
					<td colspan="7">Belum ada histori kunjungan pasien</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>

export default {
	props: ['histori']
}

</script>