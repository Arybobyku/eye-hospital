<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-besar" :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Pilih RO Yang Dipakai Untuk Cetak Surat Sehat</h2>
			</div>
			<div class="modal-body min-h-96">
        <div class="table-responsive">
					<table v-if="data" class="table">
						<thead>
							<tr>
								<th></th>
								<th>Kode</th>
								<th>Tanggal</th>
								<th>Dokter</th>
								<th>Tekanan Darah</th>
								<th>Berat Badan</th>
								<th>Tinggi Badan</th>
								<th>Suhu Tubuh</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="row in data" :key="row.kode">
								<td>
									<a :href="`/customerservices/pasien/cetaksuratsehat/${row.uuid}`" download>
										<vue-feather type="printer"></vue-feather> 
									</a>
								</td>
								<td>{{ row.kode }}</td>
								<td>{{ row.tanggal }}</td>
								<td>{{ row.nama_dokter }}</td>
								<td>{{ row.tekanan_darah }} MmHg</td>
								<td>{{ row.berat_badan }} Kg</td>
								<td>{{ row.tinggi_badan }} Cm</td>
								<td>{{ row.suhu }} <sup>o</sup>C</td>
							</tr>
						</tbody>
					</table>
				</div>
      </div>
    </div>
  </div>
</template>

<script>
var body;

export default {
  data(){
    return {
			loading: false,
			uuid: null,
			data: null,
  		terminate_detail: { show: false, display: 'display: none' },
    };
  },
	mounted:function() { body = document.body; },
  methods: {
		readData(){
			this.loading = true;
			axios.post(`/customerservices/pasien/listpemeriksaan/${this.uuid}`).then((res) => {
				this.data = res.data;
			});
		},

    show:function(uuid){
			this.uuid = uuid;
			body.style.overflowY = 'hidden';
      this.terminate_detail.display = 'display: block';
			this.terminate_detail.show = true;

			this.readData();
    },

		hide:function() {
			this.terminate_detail.show = false;
			setTimeout(() => {
				this.terminate_detail.display = 'display: none';
				body.style.overflowY = 'auto';
			}, 250, this);
		},
  }
}
</script>