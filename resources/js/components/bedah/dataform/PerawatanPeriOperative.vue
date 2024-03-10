<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-6">
			<Inputed :ref="form.tanggal.name" :form="form.tanggal"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.jam.name" :form="form.jam"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.ruangan.name" :form="form.ruangan"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.dokteroperator.name" :form="form.dokteroperator"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.dokteranastesi.name" :form="form.dokteranastesi"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.diagnosis.name" :form="form.diagnosis"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.tindakanoperasi.name" :form="form.tindakanoperasi"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.vstemp.name" :form="form.vstemp"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.vsnadi.name" :form="form.vsnadi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.vspernapasan.name" :form="form.vspernapasan"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.vstekanandarah.name" :form="form.vstekanandarah"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.vstinggi.name" :form="form.vstinggi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.vsberat.name" :form="form.vsberat"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.riwayatpenyakit.name" :form="form.riwayatpenyakit"></Inputed>
		</div>
		<div class="col-3 form-ml">
			<Inputed :ref="form.alergiobatan.name" :form="form.alergiobatan"></Inputed>
		</div>
		<div class="col-3 form-ml">
			<Inputed :ref="form.hasilkgd.name" :form="form.hasilkgd"></Inputed>
		</div>
		<div class="col-2 form-ml">
			<Inputed :ref="form.waktupengambilankgd.name" :form="form.waktupengambilankgd"></Inputed>
		</div>

		<div class="col-12">
			<h2 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Catatan Perawatan Sebelum Operasi
			</h2>
		</div>

		<div class="col-12">
			<table style="width: 100%">
				<tr>
					<td colspan="2">&nbsp;</td>
					<td align="center" style="width: 10%;">RUANG</td>
					<td align="center" style="width: 10%;">OK</td>
					<td align="center" style="width: 10%;">OK</td>
					<td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td align="left">1.</td>
					<td align="left">Pemeriksaan Identitas Pasien</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_pemeriksaan_identitas_pasien" value="r_pemeriksaan_identitas_pasien" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_pemeriksaan_identitas_pasien" value="ok1_pemeriksaan_identitas_pasien" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_pemeriksaan_identitas_pasien" value="ok2_pemeriksaan_identitas_pasien" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.pemeriksaanidentitaspasienket.name" :form="form.pemeriksaanidentitaspasienket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">2.</td>
					<td align="left">Pemeriksaan Gelang Nama</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_pemeriksaan_gelang_nama" value="r_pemeriksaan_gelang_nama" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_pemeriksaan_gelang_nama" value="ok1_pemeriksaan_gelang_nama" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_pemeriksaan_gelang_nama" value="ok2_pemeriksaan_gelang_nama" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.pemeriksaangelangnamaket.name" :form="form.pemeriksaangelangnamaket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">3.</td>
					<td align="left">Formulir Persetujuan Operasi (Tanda Tangan)</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_formulir_persetujuan_operasi" value="r_formulir_persetujuan_operasi" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_formulir_persetujuan_operasi" value="ok1_formulir_persetujuan_operasi" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_formulir_persetujuan_operasi" value="ok2_formulir_persetujuan_operasi" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.formulirpersetujuanoperasiket.name" :form="form.formulirpersetujuanoperasiket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">4.</td>
					<td align="left">Pemberian Premedikasi</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_pemberian_premedikasi" value="r_pemberian_premedikasi" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_pemberian_premedikasi" value="ok1_pemberian_premedikasi" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_pemberian_premedikasi" value="ok2_pemberian_premedikasi" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.pemberianpremedikasiket.name" :form="form.pemberianpremedikasiket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">5.</td>
					<td align="left">Pemberian Makan dan Minum Terakhir</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_pemberian_makan_minum_last" value="r_pemberian_makan_minum_last" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_pemberian_makan_minum_last" value="ok1_pemberian_makan_minum_last" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_pemberian_makan_minum_last" value="ok2_pemberian_makan_minum_last" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.pemberianmakanminumlastket.name" :form="form.pemberianmakanminumlastket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">6.</td>
					<td align="left">Alat Prothesa Luar: Misal Gigi Palsu, Kontak Lensa</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_alat_protesa_luar" value="r_alat_protesa_luar" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_alat_protesa_luar" value="ok1_alat_protesa_luar" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_alat_protesa_luar" value="ok2_alat_protesa_luar" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.alatprotesaluarket.name" :form="form.alatprotesaluarket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">7.</td>
					<td align="left">Penjepit Rambut, Gunting Kuku, Perhiasan</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_alat_perhiasan" value="r_alat_perhiasan" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_alat_perhiasan" value="ok1_alat_perhiasan" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_alat_perhiasan" value="ok2_alat_perhiasan" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.alatperhiasanket.name" :form="form.alatperhiasanket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">8.</td>
					<td align="left">Status Pasien Terlampir</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_status_pasien_terlampir" value="r_status_pasien_terlampir" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_status_pasien_terlampir" value="ok1_status_pasien_terlampir" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_status_pasien_terlampir" value="ok2_status_pasien_terlampir" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.statuspasienterlampirket.name" :form="form.statuspasienterlampirket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">9.</td>
					<td align="left">X-Ray/Scan *Pasien Terlampir</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_xray_scan" value="r_xray_scan" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_xray_scan" value="ok1_xray_scan" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_xray_scan" value="ok2_xray_scan" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.xrayscanket.name" :form="form.xrayscanket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">10.</td>
					<td align="left">Persiapan Pencukuran Bulu Mata</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_pencukuran_bulu_mata" value="r_pencukuran_bulu_mata" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_pencukuran_bulu_mata" value="ok1_pencukuran_bulu_mata" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_pencukuran_bulu_mata" value="ok2_pencukuran_bulu_mata" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.pencukuranbulumataket.name" :form="form.pencukuranbulumataket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">11.</td>
					<td align="left">Pemeriksaan Darah (PMI/Lab R.S)</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_pemeriksaan_darah" value="r_pemeriksaan_darah" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_pemeriksaan_darah" value="ok1_pemeriksaan_darah" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_pemeriksaan_darah" value="ok2_pemeriksaan_darah" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.pemeriksaandarahket.name" :form="form.pemeriksaandarahket"></Inputed>
					</td>
				</tr>
				<tr>
					<td align="left">12.</td>
					<td align="left">Site Marker</td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="r_site_marker" value="r_site_marker" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok1_site_marker" value="ok1_site_marker" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td align="center"><input class="checkbox" type="checkbox" :checked="ok2_site_marker" value="ok2_site_marker" style="margin-bottom: 10px; cursor: pointer;"></td>
					<td>
						<Inputed :ref="form.sitemarkerket.name" :form="form.sitemarkerket"></Inputed>
					</td>
				</tr>
			</table>
		</div>

		<div class="col-6">
			<Inputed :ref="form.perawatruangan.name" :form="form.perawatruangan"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.perawatkamarbedah.name" :form="form.perawatkamarbedah"></Inputed>
		</div>

	</div>

	<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form && activetab">
		<div class="col-8"></div>
		<div class="col-4" style="text-align: right">
			<button class="button-modal-page button-modal-blue" v-on:click="cancel()">Print Data</button>
			<button class="button-modal-page button-modal-green" v-on:click="action()">Add or Update</button>
		</div>
	</div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { formperawatanperioperative } from './FormData.js';
import { parseperawatanperioperative } from './Attachment.js';
var vm;
export default {
	emits: ["dialog", "parsingForm"],
	props: ['activetab'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; 
		vm.form = vm.formperawatanperioperative();
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'perawatanperioperative',
		r_pemeriksaan_identitas_pasien: false,
		r_pemeriksaan_gelang_nama: false,
		r_formulir_persetujuan_operasi: false,
		r_pemberian_premedikasi: false,
		r_pemberian_makan_minum_last: false,
		r_alat_protesa_luar: false,
		r_alat_perhiasan: false,
		r_status_pasien_terlampir: false,
		r_xray_scan: false,
		r_pencukuran_bulu_mata: false,
		r_pemeriksaan_darah: false,
		r_site_marker: false,

		ok1_pemeriksaan_identitas_pasien: false,
		ok1_pemeriksaan_gelang_nama: false,
		ok1_formulir_persetujuan_operasi: false,
		ok1_pemberian_premedikasi: false,
		ok1_pemberian_makan_minum_last: false,
		ok1_alat_protesa_luar: false,
		ok1_alat_perhiasan: false,
		ok1_status_pasien_terlampir: false,
		ok1_xray_scan: false,
		ok1_pencukuran_bulu_mata: false,
		ok1_pemeriksaan_darah: false,
		ok1_site_marker: false,

		
		ok2_pemeriksaan_identitas_pasien: false,
		ok2_pemeriksaan_gelang_nama: false,
		ok2_formulir_persetujuan_operasi: false,
		ok2_pemberian_premedikasi: false,
		ok2_pemberian_makan_minum_last: false,
		ok2_alat_protesa_luar: false,
		ok2_alat_perhiasan: false,
		ok2_status_pasien_terlampir: false,
		ok2_xray_scan: false,
		ok2_pencukuran_bulu_mata: false,
		ok2_pemeriksaan_darah: false,
		ok2_site_marker: false,
		
		
	}},
	methods: {
		parseperawatanperioperative, formperawatanperioperative,

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		aturulang: function () { 
			vm.form = vm.formperawatanperioperative(); 
			vm.r_pemeriksaan_identitas_pasien = false;
			vm.r_pemeriksaan_gelang_nama = false;
			vm.r_formulir_persetujuan_operasi = false;
			vm.r_pemberian_premedikasi = false;
			vm.r_pemberian_makan_minum_last = false;
			vm.r_alat_protesa_luar = false;
			vm.r_alat_perhiasan = false;
			vm.r_status_pasien_terlampir = false;
			vm.r_xray_scan = false;
			vm.r_pencukuran_bulu_mata = false;
			vm.r_pemeriksaan_darah = false;
			vm.r_site_marker = false;

			vm.ok1_pemeriksaan_identitas_pasien = false;
			vm.ok1_pemeriksaan_gelang_nama = false;
			vm.ok1_formulir_persetujuan_operasi = false;
			vm.ok1_pemberian_premedikasi = false;
			vm.ok1_pemberian_makan_minum_last = false;
			vm.ok1_alat_protesa_luar = false;
			vm.ok1_alat_perhiasan = false;
			vm.ok1_status_pasien_terlampir = false;
			vm.ok1_xray_scan = false;
			vm.ok1_pencukuran_bulu_mata = false;
			vm.ok1_pemeriksaan_darah = false;
			vm.ok1_site_marker = false;

			
			vm.ok2_pemeriksaan_identitas_pasien = false;
			vm.ok2_pemeriksaan_gelang_nama = false;
			vm.ok2_formulir_persetujuan_operasi = false;
			vm.ok2_pemberian_premedikasi = false;
			vm.ok2_pemberian_makan_minum_last = false;
			vm.ok2_alat_protesa_luar = false;
			vm.ok2_alat_perhiasan = false;
			vm.ok2_status_pasien_terlampir = false;
			vm.ok2_xray_scan = false;
			vm.ok2_pencukuran_bulu_mata = false;
			vm.ok2_pemeriksaan_darah = false;
			vm.ok2_site_marker = false;
		},

		setdataform: function (data, row) {
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;

				vm.form.tanggal.value = data.tanggal ? data.tanggal : '';
				vm.form.jam.value = data.jam ? data.jam : '';
				vm.form.ruangan.value = data.ruangan ? data.ruangan : '';
				vm.form.dokteroperator.value = data.dokter_operator ? data.dokter_operator : '';
				vm.form.dokteranastesi.value = data.dokter_anastesi ? data.dokter_anastesi : '';
				vm.form.diagnosis.value = data.diagnosis ? data.diagnosis : '';
				vm.form.tindakanoperasi.value = data.tindakan_operasi ? data.tindakan_operasi : '';
				vm.form.hasilkgd.value = data.hasil_kgd ? data.hasil_kgd : '';
				vm.form.waktupengambilankgd.value = data.waktu_pengambilan_kgd ? data.waktu_pengambilan_kgd : '';
				vm.form.vstemp.value = data.vs_temp ? data.vs_temp : '';
				vm.form.vsnadi.value = data.vs_nadi ? data.vs_nadi : '';
				vm.form.vspernapasan.value = data.vs_pernapasan ? data.vs_pernapasan : '';
				vm.form.vstekanandarah.value = data.vs_tekanan_darah ? data.vs_tekanan_darah : '';
				vm.form.vstinggi.value = data.vs_tinggi ? data.vs_tinggi : '';
				vm.form.vsberat.value = data.vs_berat ? data.vs_berat : '';
				vm.form.riwayatpenyakit.value = data.riwayat_penyakit ? data.riwayat_penyakit : '';
				vm.form.alergiobatan.value = data.alergi_obatan ? data.alergi_obatan : '';
				vm.form.alergimakanan.value = data.alergi_makanan ? data.alergi_makanan : '';
				vm.form.pemeriksaanidentitaspasienket.value = data.pemeriksaan_identitas_pasien_ket ? data.pemeriksaan_identitas_pasien_ket : '';
				vm.form.pemeriksaangelangnamaket.value = data.pemeriksaan_gelang_nama_ket ? data.pemeriksaan_gelang_nama_ket : '';
				vm.form.formulirpersetujuanoperasiket.value = data.formulir_persetujuan_operasi_ket ? data.formulir_persetujuan_operasi_ket : '';
				vm.form.pemberianpremedikasiket.value = data.pemberian_premedikasi_ket ? data.pemberian_premedikasi_ket : '';
				vm.form.pemberianmakanminumlastket.value = data.pemberian_makan_minum_last_ket ? data.pemberian_makan_minum_last_ket : '';
				vm.form.alatprotesaluarket.value = data.alat_protesa_luar_ket ? data.alat_protesa_luar_ket : '';
				vm.form.alatperhiasanket.value = data.alat_perhiasan_ket ? data.alat_perhiasan_ket : '';
				vm.form.statuspasienterlampirket.value = data.status_pasien_terlampir_ket ? data.status_pasien_terlampir_ket : '';
				vm.form.xrayscanket.value = data.xray_scan_ket ? data.xray_scan_ket : '';
				vm.form.pencukuranbulumataket.value = data.pencukuran_bulu_mata_ket ? data.pencukuran_bulu_mata_ket : '';
				vm.form.pemeriksaandarahket.value = data.pemeriksaan_darah_ket ? data.pemeriksaan_darah_ket : '';
				vm.form.sitemarkerket.value = data.site_marker_ket ? data.site_marker_ket : '';
				vm.form.perawatruangan.value = data.perawat_ruangan ? data.perawat_ruangan : '';
				vm.form.perawatkamarbedah.value = data.perawat_kamar_bedah ? data.perawat_kamar_bedah : '';

				if (data.r_pemeriksaan_identitas_pasien == 'ada') { vm.r_pemeriksaan_identitas_pasien = true; }
				if (data.r_pemeriksaan_gelang_nama == 'ada') { vm.r_pemeriksaan_gelang_nama = true; }
				if (data.r_formulir_persetujuan_operasi == 'ada') { vm.r_formulir_persetujuan_operasi = true; }
				if (data.r_pemberian_premedikasi == 'ada') { vm.r_pemberian_premedikasi = true; }
				if (data.r_pemberian_makan_minum_last == 'ada') { vm.r_pemberian_makan_minum_last = true; }
				if (data.r_alat_protesa_luar == 'ada') { vm.r_alat_protesa_luar = true; }
				if (data.r_alat_perhiasan == 'ada') { vm.r_alat_perhiasan = true; }
				if (data.r_status_pasien_terlampir == 'ada') { vm.r_status_pasien_terlampir = true; }
				if (data.r_xray_scan == 'ada') { vm.r_xray_scan = true; }
				if (data.r_pencukuran_bulu_mata == 'ada') { vm.r_pencukuran_bulu_mata = true; }
				if (data.r_pemeriksaan_darah == 'ada') { vm.r_pemeriksaan_darah = true; }
				if (data.r_site_marker == 'ada') { vm.r_site_marker = true; }

				if (data.ok1_pemeriksaan_identitas_pasien == 'ada') { vm.ok1_pemeriksaan_identitas_pasien = true; }
				if (data.ok1_pemeriksaan_gelang_nama == 'ada') { vm.ok1_pemeriksaan_gelang_nama = true; }
				if (data.ok1_formulir_persetujuan_operasi == 'ada') { vm.ok1_formulir_persetujuan_operasi = true; }
				if (data.ok1_pemberian_premedikasi == 'ada') { vm.ok1_pemberian_premedikasi = true; }
				if (data.ok1_pemberian_makan_minum_last == 'ada') { vm.ok1_pemberian_makan_minum_last = true; }
				if (data.ok1_alat_protesa_luar == 'ada') { vm.ok1_alat_protesa_luar = true; }
				if (data.ok1_alat_perhiasan == 'ada') { vm.ok1_alat_perhiasan = true; }
				if (data.ok1_status_pasien_terlampir == 'ada') { vm.ok1_status_pasien_terlampir = true; }
				if (data.ok1_xray_scan == 'ada') { vm.ok1_xray_scan = true; }
				if (data.ok1_pencukuran_bulu_mata == 'ada') { vm.ok1_pencukuran_bulu_mata = true; }
				if (data.ok1_pemeriksaan_darah == 'ada') { vm.ok1_pemeriksaan_darah = true; }
				if (data.ok1_site_marker == 'ada') { vm.ok1_site_marker = true; }

				if (data.ok2_pemeriksaan_identitas_pasien == 'ada') { vm.ok2_pemeriksaan_identitas_pasien = true; }
				if (data.ok2_pemeriksaan_gelang_nama == 'ada') { vm.ok2_pemeriksaan_gelang_nama = true; }
				if (data.ok2_formulir_persetujuan_operasi == 'ada') { vm.ok2_formulir_persetujuan_operasi = true; }
				if (data.ok2_pemberian_premedikasi == 'ada') { vm.ok2_pemberian_premedikasi = true; }
				if (data.ok2_pemberian_makan_minum_last == 'ada') { vm.ok2_pemberian_makan_minum_last = true; }
				if (data.ok2_alat_protesa_luar == 'ada') { vm.ok2_alat_protesa_luar = true; }
				if (data.ok2_alat_perhiasan == 'ada') { vm.ok2_alat_perhiasan = true; }
				if (data.ok2_status_pasien_terlampir == 'ada') { vm.ok2_status_pasien_terlampir = true; }
				if (data.ok2_xray_scan == 'ada') { vm.ok2_xray_scan = true; }
				if (data.ok2_pencukuran_bulu_mata == 'ada') { vm.ok2_pencukuran_bulu_mata = true; }
				if (data.ok2_pemeriksaan_darah == 'ada') { vm.ok2_pemeriksaan_darah = true; }
				if (data.ok2_site_marker == 'ada') { vm.ok2_site_marker = true; }
			}
			console.log(data);
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah/perbaharui data pada halaman ini.';
			button = 'Ya, tambah data';
      vm.$emit('dialog', text, button, vm.keyform);
    },

		parsingForm:function() { 
			var input = document.querySelectorAll('.checkbox');
			for (var i = 0; i < input.length; i++) {
				if (input[i].checked) {
					if (input[i].value == 'r_pemeriksaan_identitas_pasien') { vm.form.r_pemeriksaan_identitas_pasien = 'ada'; }
					else if (input[i].value == 'r_pemeriksaan_gelang_nama') { vm.form.r_pemeriksaan_gelang_nama = 'ada'; }
					else if (input[i].value == 'r_formulir_persetujuan_operasi') { vm.form.r_formulir_persetujuan_operasi = 'ada'; }
					else if (input[i].value == 'r_pemberian_premedikasi') { vm.form.r_pemberian_premedikasi = 'ada'; }
					else if (input[i].value == 'r_pemberian_makan_minum_last') { vm.form.r_pemberian_makan_minum_last = 'ada'; }
					else if (input[i].value == 'r_alat_protesa_luar') { vm.form.r_alat_protesa_luar = 'ada'; }
					else if (input[i].value == 'r_alat_perhiasan') { vm.form.r_alat_perhiasan = 'ada'; }
					else if (input[i].value == 'r_status_pasien_terlampir') { vm.form.r_status_pasien_terlampir = 'ada'; }
					else if (input[i].value == 'r_xray_scan') { vm.form.r_xray_scan = 'ada'; }
					else if (input[i].value == 'r_pencukuran_bulu_mata') { vm.form.r_pencukuran_bulu_mata = 'ada'; }
					else if (input[i].value == 'r_pemeriksaan_darah') { vm.form.r_pemeriksaan_darah = 'ada'; }
					else if (input[i].value == 'r_site_marker') { vm.form.r_site_marker = 'ada'; }

					else if (input[i].value == 'ok1_pemeriksaan_identitas_pasien') { vm.form.ok1_pemeriksaan_identitas_pasien = 'ada'; }
					else if (input[i].value == 'ok1_pemeriksaan_gelang_nama') { vm.form.ok1_pemeriksaan_gelang_nama = 'ada'; }
					else if (input[i].value == 'ok1_formulir_persetujuan_operasi') { vm.form.ok1_formulir_persetujuan_operasi = 'ada'; }
					else if (input[i].value == 'ok1_pemberian_premedikasi') { vm.form.ok1_pemberian_premedikasi = 'ada'; }
					else if (input[i].value == 'ok1_pemberian_makan_minum_last') { vm.form.ok1_pemberian_makan_minum_last = 'ada'; }
					else if (input[i].value == 'ok1_alat_protesa_luar') { vm.form.ok1_alat_protesa_luar = 'ada'; }
					else if (input[i].value == 'ok1_alat_perhiasan') { vm.form.ok1_alat_perhiasan = 'ada'; }
					else if (input[i].value == 'ok1_status_pasien_terlampir') { vm.form.ok1_status_pasien_terlampir = 'ada'; }
					else if (input[i].value == 'ok1_xray_scan') { vm.form.ok1_xray_scan = 'ada'; }
					else if (input[i].value == 'ok1_pencukuran_bulu_mata') { vm.form.ok1_pencukuran_bulu_mata = 'ada'; }
					else if (input[i].value == 'ok1_pemeriksaan_darah') { vm.form.ok1_pemeriksaan_darah = 'ada'; }
					else if (input[i].value == 'ok1_site_marker') { vm.form.ok1_site_marker = 'ada'; }

					else if (input[i].value == 'ok2_pemeriksaan_identitas_pasien') { vm.form.ok2_pemeriksaan_identitas_pasien = 'ada'; }
					else if (input[i].value == 'ok2_pemeriksaan_gelang_nama') { vm.form.ok2_pemeriksaan_gelang_nama = 'ada'; }
					else if (input[i].value == 'ok2_formulir_persetujuan_operasi') { vm.form.ok2_formulir_persetujuan_operasi = 'ada'; }
					else if (input[i].value == 'ok2_pemberian_premedikasi') { vm.form.ok2_pemberian_premedikasi = 'ada'; }
					else if (input[i].value == 'ok2_pemberian_makan_minum_last') { vm.form.ok2_pemberian_makan_minum_last = 'ada'; }
					else if (input[i].value == 'ok2_alat_protesa_luar') { vm.form.ok2_alat_protesa_luar = 'ada'; }
					else if (input[i].value == 'ok2_alat_perhiasan') { vm.form.ok2_alat_perhiasan = 'ada'; }
					else if (input[i].value == 'ok2_status_pasien_terlampir') { vm.form.ok2_status_pasien_terlampir = 'ada'; }
					else if (input[i].value == 'ok2_xray_scan') { vm.form.ok2_xray_scan = 'ada'; }
					else if (input[i].value == 'ok2_pencukuran_bulu_mata') { vm.form.ok2_pencukuran_bulu_mata = 'ada'; }
					else if (input[i].value == 'ok2_pemeriksaan_darah') { vm.form.ok2_pemeriksaan_darah = 'ada'; }
					else if (input[i].value == 'ok2_site_marker') { vm.form.ok2_site_marker = 'ada'; }
				}
				else {
					if (input[i].value == 'r_pemeriksaan_identitas_pasien') { vm.form.r_pemeriksaan_identitas_pasien = 'tidak ada'; }
					else if (input[i].value == 'r_pemeriksaan_gelang_nama') { vm.form.r_pemeriksaan_gelang_nama = 'tidak ada'; }
					else if (input[i].value == 'r_formulir_persetujuan_operasi') { vm.form.r_formulir_persetujuan_operasi = 'tidak ada'; }
					else if (input[i].value == 'r_pemberian_premedikasi') { vm.form.r_pemberian_premedikasi = 'tidak ada'; }
					else if (input[i].value == 'r_pemberian_makan_minum_last') { vm.form.r_pemberian_makan_minum_last = 'tidak ada'; }
					else if (input[i].value == 'r_alat_protesa_luar') { vm.form.r_alat_protesa_luar = 'tidak ada'; }
					else if (input[i].value == 'r_alat_perhiasan') { vm.form.r_alat_perhiasan = 'tidak ada'; }
					else if (input[i].value == 'r_status_pasien_terlampir') { vm.form.r_status_pasien_terlampir = 'tidak ada'; }
					else if (input[i].value == 'r_xray_scan') { vm.form.r_xray_scan = 'tidak ada'; }
					else if (input[i].value == 'r_pencukuran_bulu_mata') { vm.form.r_pencukuran_bulu_mata = 'tidak ada'; }
					else if (input[i].value == 'r_pemeriksaan_darah') { vm.form.r_pemeriksaan_darah = 'tidak ada'; }
					else if (input[i].value == 'r_site_marker') { vm.form.r_site_marker = 'tidak ada'; }

					else if (input[i].value == 'ok1_pemeriksaan_identitas_pasien') { vm.form.ok1_pemeriksaan_identitas_pasien = 'tidak ada'; }
					else if (input[i].value == 'ok1_pemeriksaan_gelang_nama') { vm.form.ok1_pemeriksaan_gelang_nama = 'tidak ada'; }
					else if (input[i].value == 'ok1_formulir_persetujuan_operasi') { vm.form.ok1_formulir_persetujuan_operasi = 'tidak ada'; }
					else if (input[i].value == 'ok1_pemberian_premedikasi') { vm.form.ok1_pemberian_premedikasi = 'tidak ada'; }
					else if (input[i].value == 'ok1_pemberian_makan_minum_last') { vm.form.ok1_pemberian_makan_minum_last = 'tidak ada'; }
					else if (input[i].value == 'ok1_alat_protesa_luar') { vm.form.ok1_alat_protesa_luar = 'tidak ada'; }
					else if (input[i].value == 'ok1_alat_perhiasan') { vm.form.ok1_alat_perhiasan = 'tidak ada'; }
					else if (input[i].value == 'ok1_status_pasien_terlampir') { vm.form.ok1_status_pasien_terlampir = 'tidak ada'; }
					else if (input[i].value == 'ok1_xray_scan') { vm.form.ok1_xray_scan = 'tidak ada'; }
					else if (input[i].value == 'ok1_pencukuran_bulu_mata') { vm.form.ok1_pencukuran_bulu_mata = 'tidak ada'; }
					else if (input[i].value == 'ok1_pemeriksaan_darah') { vm.form.ok1_pemeriksaan_darah = 'tidak ada'; }
					else if (input[i].value == 'ok1_site_marker') { vm.form.ok1_site_marker = 'tidak ada'; }

					else if (input[i].value == 'ok2_pemeriksaan_identitas_pasien') { vm.form.ok2_pemeriksaan_identitas_pasien = 'tidak ada'; }
					else if (input[i].value == 'ok2_pemeriksaan_gelang_nama') { vm.form.ok2_pemeriksaan_gelang_nama = 'tidak ada'; }
					else if (input[i].value == 'ok2_formulir_persetujuan_operasi') { vm.form.ok2_formulir_persetujuan_operasi = 'tidak ada'; }
					else if (input[i].value == 'ok2_pemberian_premedikasi') { vm.form.ok2_pemberian_premedikasi = 'tidak ada'; }
					else if (input[i].value == 'ok2_pemberian_makan_minum_last') { vm.form.ok2_pemberian_makan_minum_last = 'tidak ada'; }
					else if (input[i].value == 'ok2_alat_protesa_luar') { vm.form.ok2_alat_protesa_luar = 'tidak ada'; }
					else if (input[i].value == 'ok2_alat_perhiasan') { vm.form.ok2_alat_perhiasan = 'tidak ada'; }
					else if (input[i].value == 'ok2_status_pasien_terlampir') { vm.form.ok2_status_pasien_terlampir = 'tidak ada'; }
					else if (input[i].value == 'ok2_xray_scan') { vm.form.ok2_xray_scan = 'tidak ada'; }
					else if (input[i].value == 'ok2_pencukuran_bulu_mata') { vm.form.ok2_pencukuran_bulu_mata = 'tidak ada'; }
					else if (input[i].value == 'ok2_pemeriksaan_darah') { vm.form.ok2_pemeriksaan_darah = 'tidak ada'; }
					else if (input[i].value == 'ok2_site_marker') { vm.form.ok2_site_marker = 'tidak ada'; }
				}
			}
			vm.$emit('parsingForm', vm.parseperawatanperioperative(vm.form), vm.keyform); 
		},
	}
}
</script>