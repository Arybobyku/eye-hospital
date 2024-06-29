<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-semi-besar" :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Detail Pasien</h2>
			</div>
			<div class="modal-body">
				<div class="grid">
					<div class="col-12">
						<table class="table">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Jenis</th>
									<th>Nama Dokter</th>
									<th>Cara Masuk</th>
									<th>Metode Pembayaran</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody v-if="listdata.length > 0">
								<tr v-for="(item, index) in listdata">
									<td>{{ datename(item.tanggal) }}</td>
									<td>{{ item.jenis }}</td>
									<td>{{ item.nama_dokter }}</td>
									<td>{{ item.cara_masuk }}</td>
									<td>{{ item.carabayar_nama }} <span v-if="item.nama_asuransi != '' && item.nama_asuransi != 'Silahkan Pilih'">{{ item.nama_asuransi }}</span></td>
									<td>{{ item.status }}</td>
								</tr>
							</tbody>
							<tbody v-else>
								<tr><td colspan="6">No Data For Result</td></tr>
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
var vm, body;
import { datename, nullAndZero } from '../../../module/Manipulation.js';

export default {
	mounted:function() { vm = this; body = document.body; },
	created:function() { this.item = this.modal },
	data:function() { return { 
		terminate_detail: { show: false, display: 'display: none' },
		listdata: [],
		detail : { 
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: ''
		}
	}},
	methods: {

		datename, nullAndZero,
		
		empty: function (data) {
			if (!data || data == '' || data == '-' || data == '0') {
				return '-';
			}
			else { return data; }
		},

		setdataform: function (response) {
			let data = response.data.data;
			vm.listdata = [];
			vm.listdata = data;
			vm.loaderprocess();
		},
		
		show:function(){ 
			body.style.overflowY = 'hidden';
			vm.terminate_detail.display = 'display: block';
			vm.terminate_detail.show = true;
    },

		hide:function() {
			vm.terminate_detail.show = false;
			setTimeout(function() {
				vm.terminate_detail.display = 'display: none';
				body.style.overflowY = 'auto';
			}, 250, this);
		},

		loaderprocess:function() { const left = this.$refs.rootdetail.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 0); },
	}
}
</script>