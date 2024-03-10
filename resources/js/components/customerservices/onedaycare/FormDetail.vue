<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-semi-besar" :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Detail Paket Bedah</h2>
			</div>
			<div class="modal-body">
				<div class="grid">
					<div class="col-2"></div>
					<div class="col-8">
						<div class="cop-surat" >
							<div class="top" style="left: 30px">
								<img src="/images/favicon.png">
								<div class="label">
									<span class="label1">RUMAH SAKIT KHUSUS MATA</span><br />
									<span class="label2">PRIMA VISION</span><br />
									<span class="label3">VISION FOR THE NATION</span>
								</div>
							</div>
							<div class="bottom">
								<span class="label1">Jalan Pabrik Tenun NO. 51-53. Medan Petisah. 20118. <br /> Sumatera Utara. Indonesia</span><br />
								<span class="label2">Email : rsprimavision@gmail.com - HOSPITAL HOTLINE (061) 805 14 888</span>
							</div>
						</div>
					</div>
					<div class="col-2"></div>
				</div>

				<div class="grid">
					<div class="col-12">
						<div class="line-surat">
							<div class="line-double"></div>
							<div class="line-single"></div>
						</div>
					</div>
				</div>

				<div class="grid">
					<div class="col-12">
						<table class="table">
							<thead>
								
							</thead>
							<tbody>
								<tr v-for="(value, key) in pakets">
									<td colspan="3" style="width: 100%;">
										<table style="width: 100%;" border="0">
											<thead>
												<tr>
													<th colspan="3">{{ key }}</th>
												</tr>
												<tr>
													<th align="left">Nama Item</th>
													<th align="left">Quantity</th>
													<th align="left">Biaya</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="(item, index) in value">
													<td>{{ item.nama }}</td>
													<td>{{ item.quantity }}</td>
													<td>{{ formatrupiah(item.harga.toString()) }}</td>
												</tr>
											</tbody>
										</table>
									</td>
									
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
var vm, body;
import { datename, nullAndZero, formatrupiah } from '../../../module/Manipulation.js';

export default {
	mounted:function() { vm = this; body = document.body; },
	created:function() { this.item = this.modal },
	data:function() { return { 
		pakets: null,
		terminate_detail: { show: false, display: 'display: none' },
		detail : { 
			agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '', 
			kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '', 
			nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '', 
			rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: ''
		}
	}},
	methods: {

		datename, nullAndZero, formatrupiah,
		
		empty: function (data) {
			if (!data || data == '' || data == '-' || data == '0') {
				return '-';
			}
			else { return data; }
		},

		setdataform: function (response) {
			let paket = response.data.paket;
			vm.pakets = null;
			let temp = response.data.list_paket;
			temp.sort((a,b) => (a.label > b.label) ? 1 : ((b.label > a.label) ? -1 : 0));
				
			vm.pakets = temp.reduce(function (r, a) {
				r[a.label] = r[a.label] || [];
				r[a.label].push(a);
				return r;
			}, Object.create(null));	

			console.log(vm.pakets, 'sdfsdf');
			vm.loaderprocess();
		},
		
		show:function(){ 
			vm.pakets = null;
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

		loaderprocess:function() { const left = this.$refs.rootdetail.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },
	}
}
</script>