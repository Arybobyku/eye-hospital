<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-6">
			<Inputed :ref="form.ruangoperasi.name" :form="form.ruangoperasi"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.kamar.name" :form="form.kamar"></Inputed>
		</div>
		<div class="col-6">
			<Inputed :ref="form.akutterencana.name" :form="form.akutterencana"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.tanggal.name" :form="form.tanggal"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.pembedahan.name" :form="form.pembedahan"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.asisten1.name" :form="form.asisten1"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.perawatinstrument.name" :form="form.perawatinstrument"></Inputed>
		</div>

		<div class="col-8">
			<Inputed :ref="form.ahlianastesi.name" :form="form.ahlianastesi"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.asisten2.name" :form="form.asisten2"></Inputed>
		</div>
		<div class="col-12">
			<table class="table">
				<tbody>
					<tr>
						<td colspan="4" style="text-align: center;">Jenis Anastesi</td>
					</tr>
					<tr>
						<td>
							Umum
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="ja_umum" value="ja_umum"
								style="cursor: pointer;">
						
						</td>
						<td>
							BSP*
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="ja_bsp" value="ja_bsp"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Spiral
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="ja_spiral" value="ja_spiral"
								style="cursor: pointer;">
						</td>
						<td>
							CSP*
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="ja_csp" value="ja_csp"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Epidural
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="ja_epidural" value="ja_epidural"
								style="cursor: pointer;">
						</td>
						<td>
							Lokal
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="ja_lokal" value="ja_lokal"
								style="cursor: pointer;">
						</td>
					</tr>
				</tbody>
			</table>
			<br>
		</div>

		<div class="col-6">
			<Inputed :ref="form.diagnosaprabedah.name" :form="form.diagnosaprabedah"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.indikasioperasi.name" :form="form.indikasioperasi"></Inputed>
		</div>
		<div class="col-6">
			<Inputed :ref="form.diagnosapascabedah.name" :form="form.diagnosapascabedah"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.jenisoperasi.name" :form="form.jenisoperasi"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.desinfeksikulitdengan.name" :form="form.desinfeksikulitdengan"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.posisipenderitadesinfeksi.name" :form="form.posisipenderitadesinfeksi"></Inputed>
		</div>

		<div class="col-2">
			<Inputed :ref="form.jamoperasidimulai.name" :form="form.jamoperasidimulai"></Inputed>
		</div>
		<div class="col-2 form-ml">
			<Inputed :ref="form.jamoperasiselesai.name" :form="form.jamoperasiselesai"></Inputed>
		</div>
		<div class="col-3 form-ml">
			<Inputed :ref="form.lamaoperasiberlansung.name" :form="form.lamaoperasiberlansung"></Inputed>
		</div>
		<div class="col-5 form-ml">
			<Inputed :ref="form.jenisbahanyangdikirimkelaboratorium.name" :form="form.jenisbahanyangdikirimkelaboratorium"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.macamsayatan.name" :form="form.macamsayatan"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.posisisayatan.name" :form="form.posisisayatan"></Inputed>
		</div>

		<div class="col-12">
			<Inputed :ref="form.teknikoperasidantemuanintra.name" :form="form.teknikoperasidantemuanintra"></Inputed>
		</div>

		<div class="col-6">
			<table style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #d6d6d6; border-radius: 8px;">
				<tr>
					<td>Penggunaan AMHP Khusus</td>
					<td><input class="checkbox" type="checkbox" :checked="penggunaanamhpkhusus" value="penggunaan_amhp_khusus"
						style="cursor: pointer;"></td>
				</tr>
			</table>
			<!-- <Inputed :ref="form.penggunaanamhpkhusus.name" :form="form.penggunaanamhpkhusus"></Inputed> -->
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.jenisdanjumlahamhpkhusus.name" :form="form.jenisdanjumlahamhpkhusus"></Inputed>
		</div>

		<div class="col-4">
			<table style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #d6d6d6; border-radius: 8px;">
				<tr>
					<td>Komplikasi Intra Operasi</td>
					<td><input class="checkbox" type="checkbox" :checked="komplikasi_intra_operasi" value="komplikasi_intra_operasi"
						style="cursor: pointer;"></td>
				</tr>
			</table>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.penjabarankomplikasiintraoperasi.name" :form="form.penjabarankomplikasiintraoperasi"></Inputed>
		</div>
		<div class="col-2 form-ml">
			<Inputed :ref="form.perdarahan.name" :form="form.perdarahan"></Inputed>
		</div>

		<div class="col-12">
			<Inputed :ref="form.instruksianastesi.name" :form="form.instruksianastesi"></Inputed>
		</div>
		
		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">Instruksi Pasca-Bedah</h3>
		</div>
		
		<div class="col-4">
			<Inputed :ref="form.ipbkontrol.name" :form="form.ipbkontrol"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.ipbpuasa.name" :form="form.ipbpuasa"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.ipbdrain.name" :form="form.ipbdrain"></Inputed>
		</div>

		<div class="col-4">
			<Inputed :ref="form.ipbinpus.name" :form="form.ipbinpus"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.ipbobatobatan.name" :form="form.ipbobatobatan"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.ipbgantibalut.name" :form="form.ipbgantibalut"></Inputed>
		</div>

		<div class="col-12">
			<Inputed :ref="form.ipblainnya.name" :form="form.ipblainnya"></Inputed>
		</div>

		<div class="col-12">
			<Inputed :ref="form.operatorbedah.name" :form="form.operatorbedah"></Inputed>
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
import { formlaporanpembedahan } from './FormData.js';
import { parselaporanpembedahan } from './Attachment.js';
import { el } from 'date-fns/locale';
var vm;
export default {
	emits: ["dialog", "parsingForm"],
	props: ['activetab'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; 
		vm.form = vm.formlaporanpembedahan();
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'laporanpembedahan',
		ja_umum:false,
		ja_bsp:false,
		ja_csp:false,
		ja_epidural:false,
		ja_lokal:false,
		ja_spiral:false,
		penggunaanamhpkhusus:false,
		komplikasiintraoperasi:false,

	}},
	methods: {
		parselaporanpembedahan, formlaporanpembedahan,

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		aturulang: function () { 
			vm.form = vm.formlaporanpembedahan(); 
			vm.ja_umum = false;
			vm.ja_bsp = false;
			vm.ja_csp = false;
			vm.ja_epidural = false;
			vm.ja_lokal = false;
			vm.ja_spiral = false;
			vm.penggunaanamhpkhusus = false;
			vm.komplikasiintraoperasi = false;
		},

		setdataform: function (data, row) {
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
				vm.form.ruangoperasi.value = data.ruang_operasi ? data.ruang_operasi : '';
				vm.form.akutterencana.value = data.akut_terencana ? data.akut_terencana : '';
				vm.form.kamar.value = data.kamar ? data.kamar : '';
				vm.form.tanggal.value = data.tanggal ? data.tanggal : '';
				vm.form.pembedahan.value = data.pembedahan ? data.pembedahan : '';
				vm.form.ahlianastesi.value = data.ahli_anastesi ? data.ahli_anastesi : '';
				vm.form.asisten1.value = data.asisten_1 ? data.asisten_1 : '';
				vm.form.asisten2.value = data.asisten_2 ? data.asisten_2 : '';
				vm.form.perawatinstrument.value = data.perawat_instrument ? data.perawat_instrument : '';
	
				vm.form.diagnosaprabedah.value = data.diagnosa_pra_bedah ? data.diagnosa_pra_bedah : '';
				vm.form.diagnosapascabedah.value = data.diagnosa_pasca_bedah ? data.diagnosa_pasca_bedah : '';
				vm.form.indikasioperasi.value = data.indikasi_operasi ? data.indikasi_operasi : '';
				vm.form.jenisoperasi.value = data.jenis_operasi ? data.jenis_operasi : '';
				vm.form.desinfeksikulitdengan.value = data.desinfeksi_kulit_dengan ? data.desinfeksi_kulit_dengan : '';
				vm.form.posisipenderitadesinfeksi.value = data.posisi_penderita_desinfeksi ? data.posisi_penderita_desinfeksi : '';
				vm.form.jamoperasidimulai.value = data.jam_operasi_dimulai ? data.jam_operasi_dimulai : '';
				vm.form.jamoperasiselesai.value = data.jam_operasi_selesai ? data.jam_operasi_selesai : '';
				vm.form.lamaoperasiberlansung.value = data.lama_operasi_berlansung ? data.lama_operasi_berlansung : '';
				vm.form.jenisbahanyangdikirimkelaboratorium.value = data.jenis_bahan_yang_dikirim_ke_laboratorium ? data.jenis_bahan_yang_dikirim_ke_laboratorium : '';
				vm.form.macamsayatan.value = data.macam_sayatan ? data.macam_sayatan : '';
				vm.form.posisisayatan.value = data.posisi_sayatan ? data.posisi_sayatan : '';
				vm.form.teknikoperasidantemuanintra.value = data.teknik_operasi_dan_temuan_intra ? data.teknik_operasi_dan_temuan_intra : '';
				//vm.form.penggunaanamhpkhusus.value = data.penggunaan_amhp_khusus ? data.penggunaan_amhp_khusus : '';
				vm.form.jenisdanjumlahamhpkhusus.value = data.jenis_dan_jumlah_amhp_khusus ? data.jenis_dan_jumlah_amhp_khusus : '';
				//vm.form.komplikasiintraoperasi.value = data.komplikasi_intra_operasi ? data.komplikasi_intra_operasi : '';
				vm.form.penjabarankomplikasiintraoperasi.value = data.penjabaran_komplikasi_intra_operasi ? data.penjabaran_komplikasi_intra_operasi : '';
				vm.form.perdarahan.value = data.perdarahan ? data.perdarahan : '';
				vm.form.instruksianastesi.value = data.instruksi_anastesi ? data.instruksi_anastesi : '';
				vm.form.ipbkontrol.value = data.ipb_kontrol ? data.ipb_kontrol : '';
				vm.form.ipbpuasa.value = data.ipb_puasa ? data.ipb_puasa : '';
				vm.form.ipbdrain.value = data.ipb_drain ? data.ipb_drain : '';
				vm.form.ipbinpus.value = data.ipb_inpus ? data.ipb_inpus : '';
				vm.form.ipbobatobatan.value = data.ipb_obat_obatan ? data.ipb_obat_obatan : '';
				vm.form.ipbgantibalut.value = data.ipb_ganti_balut ? data.ipb_ganti_balut : '';
				vm.form.ipblainnya.value = data.ipb_lainnya ? data.ipb_lainnya : '';
				vm.form.operatorbedah.value = data.operator_bedah ? data.operator_bedah : '';

				if (data.ja_umum == 'Ya') { vm.ja_umum = true; }
				if (data.ja_bsp == 'Ya') { vm.ja_bsp = true; }
				if (data.ja_csp == 'Ya') { vm.ja_csp = true; }
				if (data.ja_spiral == 'Ya') { vm.ja_spiral = true; }
				if (data.ja_lokal == 'Ya') { vm.ja_lokal = true; }
				if (data.ja_epidural == 'Ya') { vm.ja_epidural = true; }
				if (data.penggunaanamhpkhusus == 'Ya') { vm.penggunaanamhpkhusus = true; }
				if (data.komplikasiintraoperasi == 'Ya') { vm.komplikasiintraoperasi = true; }
			}
			console.log(data);
		},

		dialog:function(){
			let text = '', button = '';
			text = 'Yakin ingin menambah/perbaharui data pada halaman ini.';
			button = 'Ya, tambah/perbaharui data';
      vm.$emit('dialog', text, button, vm.keyform);
    },

		parsingForm:function() { 
			var input = document.querySelectorAll('.checkbox');
			for (var i = 0; i < input.length; i++) {
				if (input[i].checked) {
					if (input[i].value == 'ja_umum') { vm.form.ja_umum = 'Ya'; }
					else if (input[i].value == 'ja_bsp') { vm.form.ja_bsp = 'Ya'; }
					else if (input[i].value == 'ja_csp') { vm.form.ja_csp = 'Ya'; }
					else if (input[i].value == 'ja_spiral') { vm.form.ja_spiral = 'Ya'; }
					else if (input[i].value == 'ja_epidural') { vm.form.ja_epidural = 'Ya'; }
					else if (input[i].value == 'ja_lokal') { vm.form.ja_lokal = 'Ya'; }
					else if (input[i].value == 'penggunaan_amhp_khusus') { vm.form.penggunaanamhpkhusus = 'Ya'; }
					else if (input[i].value == 'komplikasi_intra_operasi') { vm.form.komplikasiintraoperasi = 'Ya'; }
				}
			else {
				if (input[i].value == 'ja_umum') { vm.form.ja_umum = 'Tidak'; }
				else if (input[i].value == 'ja_bsp') { vm.form.ja_bsp = 'Tidak'; }
				else if (input[i].value == 'ja_csp') { vm.form.ja_csp = 'Tidak'; }
				else if (input[i].value == 'ja_spiral') { vm.form.ja_spiral = 'Tidak'; }
				else if (input[i].value == 'ja_epidural') { vm.form.ja_epidural = 'Tidak'; }
				else if (input[i].value == 'ja_lokal') { vm.form.ja_lokal = 'Tidak'; }
				else if (input[i].value == 'penggunaan_amhp_khusus') { vm.form.penggunaanamhpkhusus = 'Tidak'; }
				else if (input[i].value == 'komplikasi_intra_operasi') { vm.form.komplikasiintraoperasi = 'Tidak'; }
				
			}
		}
			vm.$emit('parsingForm', vm.parselaporanpembedahan(vm.form), vm.keyform); 
		},
	}
}
</script>