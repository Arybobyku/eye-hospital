<template>
	<div :style="terminate_detail.display" class="modal">
		<div ref="rootdetail" class="modal-content modal-semi-besar" :class="terminate_detail.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2>Detail Pasien</h2>
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
					<div class="col-2"></div>
					<div class="col-8">
						<ul class="list-detail">
							<li>No Rekam Medis<span><strong>{{ detail.rekam_medis }}</strong></span></li>
							<li>Nama Lengkap<span><strong>{{ detail.nama }}</strong></span></li>
							<li>Tempat, Tanggal Lahir<span><strong>{{ detail.tempat_lahir }}, {{ datename(detail.tanggal_lahir) }}</strong></span></li>
							<li>Jenis Kelamin<span><strong>{{ detail.jenis_kelamin }}</strong></span></li>
							<li>Jenis Identitas<span><strong>{{ detail.jenis_identitas }}</strong></span></li>
							<li>Nomor Identitas<span><strong>{{ detail.no_identitas }}</strong></span></li>
							<li>Nomor Handphone<span><strong>{{ detail.no_handphone }}</strong></span></li>
							<li>Email<span><strong>{{ detail.email }}</strong></span></li>
							<li>Pendidikan Terakhir<span><strong>{{ detail.pendidikan_terakhir }}</strong></span></li>
							<li>Alamat<span><strong>{{ detail.alamat }}</strong></span></li>
							<li>Provinsi<span><strong>{{ detail.nama_provinsi }}</strong></span></li>
							<li>Kabupaten/Kota<span><strong>{{ detail.nama_kab_kota }}</strong></span></li>
							<li>Kecamatan<span><strong>{{ detail.nama_kecamatan }}</strong></span></li>
							<li>Kelurahan<span><strong>{{ detail.nama_kelurahan }}</strong></span></li>
							<li>Status Pernikahan<span><strong>{{ detail.status_pernikahan }}</strong></span></li>
							<li>Pekerjaan<span><strong>{{ detail.pekerjaan }}</strong></span></li>
							<li>Golongan Darah<span><strong>{{ detail.golongan_darah }}</strong></span></li>
							<li>Nama Ayah<span><strong>{{ detail.nama_ayah }}</strong></span></li>
							<li>Nama Ibu<span><strong>{{ detail.nama_ibu }}</strong></span></li>
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
			vm.detail.agama = data.agama;
			vm.detail.alamat = data.alamat;
			vm.detail.alias = vm.empty(data.alias);
			vm.detail.email = vm.empty(data.email);
			vm.detail.golongan_darah = vm.empty(data.golongan_darah);
			vm.detail.jenis_identitas = data.jenis_identitas;
			vm.detail.jenis_kelamin = data.jenis_kelamin;
			vm.detail.kodepos = vm.empty(data.kodepos);
			vm.detail.nama = data.nama;
			vm.detail.nama_ayah = vm.empty(data.nama_ayah);
			vm.detail.nama_ibu = vm.empty(data.nama_ibu);
			vm.detail.nama_kab_kota = data.nama_kab_kota;
			vm.detail.nama_kecamatan = data.nama_kecamatan;
			vm.detail.nama_kelurahan = data.nama_kelurahan;
			vm.detail.nama_provinsi = data.nama_provinsi;
			vm.detail.no_handphone = vm.empty(data.no_handphone);
			vm.detail.no_identitas = data.no_identitas;
			vm.detail.pekerjaan = vm.empty(data.pekerjaan);
			vm.detail.pendidikan_terakhir = vm.empty(data.pendidikan_terakhir);
			vm.detail.rekam_medis = data.rekam_medis;
			vm.detail.rt_rw = vm.empty(data.rt_rw);
			vm.detail.status_pernikahan = vm.empty(data.status_pernikahan);
			vm.detail.tanggal_lahir = data.tanggal_lahir;
			vm.detail.tempat_lahir = data.tempat_lahir;
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