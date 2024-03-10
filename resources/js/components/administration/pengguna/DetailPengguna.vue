<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-semi-besar" :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Detail Pengguna</h2>
			</div>
			<div class="modal-body">
				<div class="grid">
					<div class="col-2"></div>
					<div class="col-8">
						<div class="cop-surat" >
							<div class="top" style="left: 29px">
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
					<div class="col-2"></div>
					<div class="col-8">
						<ul class="list-detail">
							<li>
								Nama Lengkap
								<span><strong>{{ detail.nama_pengguna }}</strong></span>
							</li>
							<li>
								Tempat, Tanggal Lahir
								<span><strong>{{ detail.tempat_lahir }}, {{ datename(detail.tanggal_lahir) }}</strong></span>
							</li>
							<li>
								Jenis Kelamin
								<span><strong>{{ detail.jenis_kelamin }}</strong></span>
							</li>
							<li>
								Nomor Induk Kependudukan
								<span><strong>{{ detail.ktp }}</strong></span>
							</li>
							<li>
								Nomor Handphone
								<span><strong>{{ detail.no_handphone }}</strong></span>
							</li>
							<li>
								Alamat
								<span><strong>{{ detail.alamat }}</strong></span>
							</li>
							<li>
								Provinsi
								<span><strong>{{ detail.nama_provinsi }}</strong></span>
							</li>
							<li>
								Kabupaten/Kota
								<span><strong>{{ detail.nama_kab_kota }}</strong></span>
							</li>
							<li>
								Kecamatan
								<span><strong>{{ detail.nama_kecamatan }}</strong></span>
							</li>
							<li>
								Kelurahan
								<span><strong>{{ detail.nama_kelurahan }}</strong></span>
							</li>
							<li>
								BPJS Ketenagakerjaan
								<span><strong>{{ detail.bpjs_ketenagakerjaan }}</strong></span>
							</li>
							<li>
								Berposisi sebagai
								<span><strong>{{ changes(detail.posisi_pengguna) }}, {{ detail.sebagai_pengguna }}</strong></span>
							</li>
							<li>
								Mulai Bekerja
								<span><strong>{{ datename(nullAndZero(detail.mulai_bekerja)) }}</strong></span>
							</li>
						</ul>
					</div>
					<div class="col-2"></div>
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
		detail : { 
			nama_pengguna: '', tempat_lahir: '', tanggal_lahir: '', jenis_kelamin: '', ktp: '', 
			no_handphone: '', alamat: '', nama_provinsi: '', nama_kab_kota: '', nama_kecamatan: '', 
			nama_kelurahan: '', bpjs_ketenagakerjaan: '', posisi_pengguna: '', sebagai_pengguna: '', mulai_bekerja: '',
		}
	}},
	methods: {

		datename, nullAndZero,

		changes:function(data) { if (data == '8807') { return 'Karyawan' }; return 'Dokter'; },

		setdataform: function (response) {
			let data = response.data.detail;
			vm.detail.nama_pengguna = data.nama_pengguna;
			vm.detail.tempat_lahir = data.tempat_lahir;
			vm.detail.tanggal_lahir = data.tanggal_lahir;
			vm.detail.jenis_kelamin = data.jenis_kelamin;
			vm.detail.ktp = data.ktp;
			vm.detail.no_handphone = data.no_handphone;
			vm.detail.alamat = data.alamat;
			vm.detail.nama_provinsi = data.nama_provinsi;
			vm.detail.nama_kab_kota = data.nama_kab_kota;
			vm.detail.nama_kecamatan = data.nama_kecamatan;
			vm.detail.nama_kelurahan = data.nama_kelurahan;
			vm.detail.bpjs_ketenagakerjaan = data.bpjs_ketenagakerjaan;
			vm.detail.posisi_pengguna = data.posisi_pengguna;
			vm.detail.sebagai_pengguna = data.sebagai_pengguna;
			vm.detail.mulai_bekerja = data.mulai_bekerja;
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