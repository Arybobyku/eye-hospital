<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-4">
			<Inputed :ref="form.tanggal.name" :form="form.tanggal"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.operasimulai.name" :form="form.operasimulai"></Inputed>
		</div>
		<div class="col-4 form-ml">
			<Inputed :ref="form.operasiselesai.name" :form="form.operasiselesai"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.dokterbedah.name" :form="form.dokterbedah"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.perawatscrub.name" :form="form.perawatscrub"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.dokteranastesi.name" :form="form.dokteranastesi"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.diagnosisprabedah.name" :form="form.diagnosisprabedah"></Inputed>
		</div>

		<div class="col-6">
			<Inputed :ref="form.tindakanoperasi.name" :form="form.tindakanoperasi"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.diagnosispascabedah.name" :form="form.diagnosispascabedah"></Inputed>
		</div>

		<div class="col-12">
			<table class="table">
				<tbody>
					<!-- Bagian Anasthesi -->
					<tr>
						<td rowspan="3" style="width: 25%;" valign="top">Anasthesi</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_topical" value="an_topical" style="margin-bottom: 10px; cursor: pointer;"> Topikal
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_retrobulbar_peribulbar" value="an_retrobulbar_peribulbar" style="margin-bottom: 10px; cursor: pointer;"> Retrobulbar/Peribulbar
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_sub_conjunctival" value="an_sub_conjunctival" style="margin-bottom: 10px; cursor: pointer;"> Subconjuctival
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_intracamelar" value="an_intracamelar" style="margin-bottom: 10px; cursor: pointer;"> Intracamelar
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_nu_bius_umum" value="an_nu_bius_umum" style="margin-bottom: 10px; cursor: pointer;"> NU/Bius Umum
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_xylocain" value="an_xylocain" style="margin-bottom: 10px; cursor: pointer;"> Xylocain
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">&nbsp;</td>
						<td style="width: 25%;">&nbsp;</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="an_lidocain" value="an_lidocain" style="margin-bottom: 10px; cursor: pointer;"> Lidocain
						</td>
					</tr>

					<!-- Bagian Insisi -->
					<tr>
						<td style="width: 25%;">Insisi</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="in_kornea" value="in_kornea" style="margin-bottom: 10px; cursor: pointer;"> Kornea
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="in_limbus" value="in_limbus" style="margin-bottom: 10px; cursor: pointer;"> Limbus
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="in_sclera" value="in_sclera" style="margin-bottom: 10px; cursor: pointer;"> Sclera
						</td>
					</tr>

					<!-- Bagian Wound (Tunel) -->
					<tr>
						<td rowspan="2" style="width: 25%;" valign="top">Wound (Tunel)</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="wt_main_port" value="wt_main_port" style="margin-bottom: 10px; cursor: pointer;"> Main Port
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="wt_two_side_port" value="wt_two_side_port" style="margin-bottom: 10px; cursor: pointer;"> Two Side Port
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="wt_one_side_port" value="wt_one_side_port" style="margin-bottom: 10px; cursor: pointer;"> One Side Port
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="wt_keratome_2_koma_75_mm" value="wt_keratome_2_koma_75_mm" style="margin-bottom: 10px; cursor: pointer;"> Keratome 2.75 mm
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="wt_crescen_knife" value="wt_crescen_knife" style="margin-bottom: 10px; cursor: pointer;"> Crescen knife
						</td>
						<td style="width: 25%;">&nbsp;</td>
					</tr>

					<!-- Bagian Capsulotomi Anterior -->
					<tr>
						<td rowspan="2" style="width: 25%;" valign="top">Capsulotomi Anterior</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cs_ccc" value="cs_ccc" style="margin-bottom: 10px; cursor: pointer;"> CCC
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cs_x_mas_tree" value="cs_x_mas_tree" style="margin-bottom: 10px; cursor: pointer;"> X'mas Tree
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cs_linear" value="cs_linear" style="margin-bottom: 10px; cursor: pointer;"> Linear
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cs_can_opener" value="cs_can_opener" style="margin-bottom: 10px; cursor: pointer;"> Can Opener
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cs_tryphan_blue" value="cs_tryphan_blue" style="margin-bottom: 10px; cursor: pointer;"> Typhan Blue
						</td>
						<td style="width: 25%;">&nbsp;</td>
					</tr>

					<!-- Bagian Teknik Tambahan -->
					<tr>
						<td style="width: 25%;">Teknik Tambahan</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="tb_ctr" value="tb_ctr" style="margin-bottom: 10px; cursor: pointer;"> CTR
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="tb_kapsulotomi_posterior" value="tb_kapsulotomi_posterior" style="margin-bottom: 10px; cursor: pointer;"> Kapsulotomi Posterior
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="tb_vitrektomi_anterior" value="tb_vitrektomi_anterior" style="margin-bottom: 10px; cursor: pointer;"> Vitrektomi Anterior
						</td>
					</tr>

					<!-- Bagian Cairan Irigas -->
					<tr>
						<td style="width: 25%;">Cairan Irigasi</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="ci_rl" value="ci_rl" style="margin-bottom: 10px; cursor: pointer;"> RL
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="ci_bss" value="ci_bss" style="margin-bottom: 10px; cursor: pointer;"> B.S.S
						</td>
						<td style="width: 25%;">&nbsp;</td>
					</tr>

					<!-- Bagian Lensa Intra Okular -->
					<tr>
						<td rowspan="2" style="width: 25%;" valign="top">Lensa Intra Okular</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="lio_dalam_kantung_kapsul" value="lio_dalam_kantung_kapsul" style="margin-bottom: 10px; cursor: pointer;"> Dalam Kantung Kapsul
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="lio_bilik_mata_depan" value="lio_bilik_mata_depan" style="margin-bottom: 10px; cursor: pointer;"> Bilik Mata Depan
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="lio_sulcus_siliaris" value="lio_sulcus_siliaris" style="margin-bottom: 10px; cursor: pointer;"> Sulcus Siliaris
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="lio_diluar_kantong_kapsul" value="lio_diluar_kantong_kapsul" style="margin-bottom: 10px; cursor: pointer;"> Diluar Kantung Kapsul
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="lio_afakia" value="lio_afakia" style="margin-bottom: 10px; cursor: pointer;"> Afakia
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="lio_fiksasi_scleral" value="lio_fiksasi_scleral" style="margin-bottom: 10px; cursor: pointer;"> Fiksasi Scleral
						</td>
					</tr>

					<!-- Bagian Cairan Viskoelastik -->
					<tr>
						<td style="width: 25%;">Cairan Viskoelastik</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cv_hpmc" value="cv_hpmc" style="margin-bottom: 10px; cursor: pointer;"> HPMC
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cv_viscoat" value="cv_viscoat" style="margin-bottom: 10px; cursor: pointer;"> Viscoat
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="cv_hyaluronic_acid" value="cv_hyaluronic_acid" style="margin-bottom: 10px; cursor: pointer;"> Hyaluronic Acid
						</td>
					</tr>

					<!-- Bagian Benang -->
					<tr>
						<td style="width: 25%;">Benang</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="benang_tanpa_jahitan" value="benang_tanpa_jahitan" style="margin-bottom: 10px; cursor: pointer;"> Tanpa Jahitan
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="benang_ethylon_10_0" value="benang_ethylon_10_0" style="margin-bottom: 10px; cursor: pointer;"> Ethylon 10-0
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="benang_vicryl_8_0" value="benang_vicryl_8_0" style="margin-bottom: 10px; cursor: pointer;"> Vicryl 8-0
						</td>
					</tr>

					<!-- Bagian Komplikasi -->
					<tr>
						<td rowspan="3" style="width: 25%;" valign="top">Komplikasi</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_tidak_ada" value="kompikasi_tidak_ada" style="margin-bottom: 10px; cursor: pointer;"> Tidak Ada
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_pcr" value="kompikasi_pcr" style="margin-bottom: 10px; cursor: pointer;"> PCR
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_prolaps_vitreous" value="kompikasi_prolaps_vitreous" style="margin-bottom: 10px; cursor: pointer;"> Prolaps Vitreous
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_drop_nucleus" value="kompikasi_drop_nucleus" style="margin-bottom: 10px; cursor: pointer;"> Drop Nucleus
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_perdarahan" value="kompikasi_perdarahan" style="margin-bottom: 10px; cursor: pointer;"> Perdarahan
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_corneal_burn" value="kompikasi_corneal_burn" style="margin-bottom: 10px; cursor: pointer;"> Corneal Burn
						</td>
					</tr>

					<tr>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_convert_to_ecce" value="kompikasi_convert_to_ecce" style="margin-bottom: 10px; cursor: pointer;"> Convert to ECCE
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="kompikasi_convert_to_icce" value="kompikasi_convert_to_icce" style="margin-bottom: 10px; cursor: pointer;"> Convert to ICCE
						</td>
						<td style="width: 25%;">&nbsp;</td>
					</tr>

					<!-- Bagian Perawatan Pasca Operasi -->
					<tr>
						<td style="width: 25%;">Perawatan Pasca Operasi</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="ppo_pulang_berobat_jalan" value="ppo_pulang_berobat_jalan" style="margin-bottom: 10px; cursor: pointer;"> Pulang Berobat Jalan
						</td>
						<td style="width: 25%;">
							<input class="checkbox" type="checkbox" :checked="ppo_opname" value="ppo_opname" style="margin-bottom: 10px; cursor: pointer;"> Opname
						</td>
						<td style="width: 25%;">&nbsp;</td>
					</tr>

					<!-- Bagian Instruksi Pasca Operasi -->
					<tr>
						<td colspan="4" style="width: 100%;">Instruksi Pasca Operasi</td>
					</tr>

					<tr>
						<td colspan="2" style="width: 50%;">
							<input class="checkbox" type="checkbox" :checked="ipo_pdb2jpo" value="ipo_pdb2jpo" style="margin-bottom: 10px; cursor: pointer;"> Perban dibuka 2 jam Pasca Operasi <br />
							<input class="checkbox" type="checkbox" :checked="ipo_omdpspdb" value="ipo_omdpspdb" style="margin-bottom: 10px; cursor: pointer;"> Obat mulai dipakai setelah perban dibuka
						</td>
						<td colspan="2" style="width: 50%;">
							<input class="checkbox" type="checkbox" :checked="ipo_pdbddtksdto" value="ipo_pdbddtksdto" style="margin-bottom: 10px; cursor: pointer;"> Perban dibuka dan ditutup kembali setelah ditetes obat <br/>
							<input class="checkbox" type="checkbox" :checked="ipo_psdipo" value="ipo_psdipo" style="margin-bottom: 10px; cursor: pointer;"> Pantangan sesuai dengan instruksi post operasi
						</td>
					</tr>

				</tbody>
			</table>
		</div>

		<!-- Bagian Instruksi Pasca Operasi -->
		<div class="col-12" style="margin-top: 16px;">
			<Inputed :ref="form.catatantambahan.name" :form="form.catatantambahan"></Inputed>
		</div>
		<!-- Bagian Instruksi Pasca Operasi -->
		<div class="col-12">
			<Inputed :ref="form.namaoperator.name" :form="form.namaoperator"></Inputed>
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
import { formcatatanoperasikatarak } from './FormData.js';
import { parsecatatanoperasikatarak } from './Attachment.js';
var vm;
export default {
	emits: ["dialog", "parsingForm"],
	props: ['activetab'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
	},
	mounted:function() { 
		vm = this; 
		vm.form = vm.formcatatanoperasikatarak();
	},
	created:function() {},
	data:function() { return { 
		form: null, keyform: 'catatanoperasikatarak',
		an_topical: false,
		an_retrobulbar_peribulbar: false,
		an_sub_conjunctival: false,
		an_intracamelar: false,
		an_nu_bius_umum: false,
		an_xylocain: false,
		an_lidocain: false,
		in_kornea: false,
		in_limbus: false,
		in_sclera: false,
		wt_main_port: false,
		wt_two_side_port: false,
		wt_one_side_port: false,
		wt_keratome_2_koma_75_mm: false,
		wt_crescen_knife: false,
		cs_ccc: false,
		cs_x_mas_tree: false,
		cs_linear: false,
		cs_can_opener: false,
		cs_tryphan_blue: false,
		tb_ctr: false,
		tb_kapsulotomi_posterior: false,
		tb_vitrektomi_anterior: false,
		ci_rl: false,
		ci_bss: false,
		lio_dalam_kantung_kapsul: false,
		lio_bilik_mata_depan: false,
		lio_sulcus_siliaris: false,
		lio_diluar_kantong_kapsul: false,
		lio_afakia: false,
		lio_fiksasi_scleral: false,
		cv_hpmc: false,
		cv_viscoat: false,
		cv_hyaluronic_acid: false,
		benang_tanpa_jahitan: false,
		benang_ethylon_10_0: false,
		benang_vicryl_8_0: false,
		kompikasi_tidak_ada: false,
		kompikasi_pcr: false,
		kompikasi_prolaps_vitreous: false,
		kompikasi_drop_nucleus: false,
		kompikasi_perdarahan: false,
		kompikasi_corneal_burn: false,
		kompikasi_convert_to_ecce: false,
		kompikasi_convert_to_icce: false,
		ppo_pulang_berobat_jalan: false,
		ppo_opname: false,
		ipo_pdb2jpo: false,
		ipo_omdpspdb: false,
		ipo_pdbddtksdto: false,
		ipo_psdipo: false,
	}},
	methods: {
		parsecatatanoperasikatarak, formcatatanoperasikatarak,

		action:function() {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}
			
			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		aturulang: function () { 
			vm.form = vm.formcatatanoperasikatarak();
			vm.an_topical = false,
			vm.an_retrobulbar_peribulbar = false;
			vm.an_sub_conjunctival = false;
			vm.an_intracamelar = false;
			vm.an_nu_bius_umum = false;
			vm.an_xylocain = false;
			vm.an_lidocain = false;
			vm.in_kornea = false;
			vm.in_limbus = false;
			vm.in_sclera = false;
			vm.wt_main_port = false;
			vm.wt_two_side_port = false;
			vm.wt_one_side_port = false;
			vm.wt_keratome_2_koma_75_mm = false;
			vm.wt_crescen_knife = false;
			vm.cs_ccc = false;
			vm.cs_x_mas_tree = false;
			vm.cs_linear = false;
			vm.cs_can_opener = false;
			vm.cs_tryphan_blue = false;
			vm.tb_ctr = false;
			vm.tb_kapsulotomi_posterior = false;
			vm.tb_vitrektomi_anterior = false;
			vm.ci_rl = false;
			vm.ci_bss = false;
			vm.lio_dalam_kantung_kapsul = false;
			vm.lio_bilik_mata_depan = false;
			vm.lio_sulcus_siliaris = false;
			vm.lio_diluar_kantong_kapsul = false;
			vm.lio_afakia = false;
			vm.lio_fiksasi_scleral = false;
			vm.cv_hpmc = false;
			vm.cv_viscoat = false;
			vm.cv_hyaluronic_acid = false;
			vm.benang_tanpa_jahitan = false;
			vm.benang_ethylon_10_0 = false;
			vm.benang_vicryl_8_0 = false;
			vm.kompikasi_tidak_ada = false;
			vm.kompikasi_pcr = false;
			vm.kompikasi_prolaps_vitreous = false;
			vm.kompikasi_drop_nucleus = false;
			vm.kompikasi_perdarahan = false;
			vm.kompikasi_corneal_burn = false;
			vm.kompikasi_convert_to_ecce = false;
			vm.kompikasi_convert_to_icce = false;
			vm.ppo_pulang_berobat_jalan = false;
			vm.ppo_opname = false;
			vm.ipo_pdb2jpo = false;
			vm.ipo_omdpspdb = false;
			vm.ipo_pdbddtksdto = false;
			vm.ipo_psdipo = false;
		},

		setdataform: function (data, row) {
			vm.aturulang();
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
				vm.form.tanggal.value = data.tanggal;
				vm.form.operasimulai.value = data.operasi_mulai;
				vm.form.operasiselesai.value = data.operasi_selesai;
				vm.form.dokterbedah.value = data.dokter_bedah;
				vm.form.dokteranastesi.value = data.dokter_anastesi;
				vm.form.tindakanoperasi.value = data.tindakan_operasi;
				vm.form.perawatscrub.value = data.perawat_scrub;
				vm.form.diagnosisprabedah.value = data.diagnosis_pra_bedah;
				vm.form.diagnosispascabedah.value = data.diagnosis_pasca_bedah;
				vm.form.catatantambahan.value = data.catatan_tambahan;
				vm.form.namaoperator.value = data.nama_operator;
				if (data.an_topical == 'ada') { vm.an_topical = true; }
				if (data.an_retrobulbar_peribulbar == 'ada') { vm.an_retrobulbar_peribulbar = true; }
				if (data.an_sub_conjunctival == 'ada') { vm.an_sub_conjunctival = true; }
				if (data.an_intracamelar == 'ada') { vm.an_intracamelar = true; }
				if (data.an_nu_bius_umum == 'ada') { vm.an_nu_bius_umum = true; }
				if (data.an_xylocain == 'ada') { vm.an_xylocain = true; }
				if (data.an_lidocain == 'ada') { vm.an_lidocain = true; }
				if (data.in_kornea == 'ada') { vm.in_kornea = true; }
				if (data.in_limbus == 'ada') { vm.in_limbus = true; }
				if (data.in_sclera == 'ada') { vm.in_sclera = true; }
				if (data.wt_main_port == 'ada') { vm.wt_main_port = true; }
				if (data.wt_two_side_port == 'ada') { vm.wt_two_side_port = true; }
				if (data.wt_one_side_port == 'ada') { vm.wt_one_side_port = true; }
				if (data.wt_keratome_2_koma_75_mm == 'ada') { vm.wt_keratome_2_koma_75_mm = true; }
				if (data.wt_crescen_knife == 'ada') { vm.wt_crescen_knife = true; }
				if (data.cs_ccc == 'ada') { vm.cs_ccc = true; }
				if (data.cs_x_mas_tree == 'ada') { vm.cs_x_mas_tree = true; }
				if (data.cs_linear == 'ada') { vm.cs_linear = true; }
				if (data.cs_can_opener == 'ada') { vm.cs_can_opener = true; }
				if (data.cs_tryphan_blue == 'ada') { vm.cs_tryphan_blue = true; }
				if (data.tb_ctr == 'ada') { vm.tb_ctr = true; }
				if (data.tb_kapsulotomi_posterior == 'ada') { vm.tb_kapsulotomi_posterior = true; }
				if (data.tb_vitrektomi_anterior == 'ada') { vm.tb_vitrektomi_anterior = true; }
				if (data.ci_rl == 'ada') { vm.ci_rl = true; }
				if (data.ci_bss == 'ada') { vm.ci_bss = true; }
				if (data.lio_dalam_kantung_kapsul == 'ada') { vm.lio_dalam_kantung_kapsul = true; }
				if (data.lio_bilik_mata_depan == 'ada') { vm.lio_bilik_mata_depan = true; }
				if (data.lio_sulcus_siliaris == 'ada') { vm.lio_sulcus_siliaris = true; }
				if (data.lio_diluar_kantong_kapsul == 'ada') { vm.lio_diluar_kantong_kapsul = true; }
				if (data.lio_afakia == 'ada') { vm.lio_afakia = true; }
				if (data.lio_fiksasi_scleral == 'ada') { vm.lio_fiksasi_scleral = true; }
				if (data.cv_hpmc == 'ada') { vm.cv_hpmc = true; }
				if (data.cv_viscoat == 'ada') { vm.cv_viscoat = true; }
				if (data.cv_hyaluronic_acid == 'ada') { vm.cv_hyaluronic_acid = true; }
				if (data.benang_tanpa_jahitan == 'ada') { vm.benang_tanpa_jahitan = true; }
				if (data.benang_ethylon_10_0 == 'ada') { vm.benang_ethylon_10_0 = true; }
				if (data.benang_vicryl_8_0 == 'ada') { vm.benang_vicryl_8_0 = true; }
				if (data.kompikasi_tidak_ada == 'ada') { vm.kompikasi_tidak_ada = true; }
				if (data.kompikasi_pcr == 'ada') { vm.kompikasi_pcr = true; }
				if (data.kompikasi_prolaps_vitreous == 'ada') { vm.kompikasi_prolaps_vitreous = true; }
				if (data.kompikasi_drop_nucleus == 'ada') { vm.kompikasi_drop_nucleus = true; }
				if (data.kompikasi_perdarahan == 'ada') { vm.kompikasi_perdarahan = true; }
				if (data.kompikasi_corneal_burn == 'ada') { vm.kompikasi_corneal_burn = true; }
				if (data.kompikasi_convert_to_ecce == 'ada') { vm.kompikasi_convert_to_ecce = true; }
				if (data.kompikasi_convert_to_icce == 'ada') { vm.kompikasi_convert_to_icce = true; }
				if (data.ppo_pulang_berobat_jalan == 'ada') { vm.ppo_pulang_berobat_jalan = true; }
				if (data.ppo_opname == 'ada') { vm.ppo_opname = true; }
				if (data.ipo_pdb2jpo == 'ada') { vm.ipo_pdb2jpo = true; }
				if (data.ipo_omdpspdb == 'ada') { vm.ipo_omdpspdb = true; }
				if (data.ipo_pdbddtksdto == 'ada') { vm.ipo_pdbddtksdto = true; }
				if (data.ipo_psdipo == 'ada') { vm.ipo_psdipo = true; }
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
					if (input[i].value == 'an_topical') { vm.form.an_topical = 'ada'; }
					else if (input[i].value == 'an_retrobulbar_peribulbar') { vm.form.an_retrobulbar_peribulbar = 'ada'; }
					else if (input[i].value == 'an_sub_conjunctival') { vm.form.an_sub_conjunctival = 'ada'; }
					else if (input[i].value == 'an_intracamelar') { vm.form.an_intracamelar = 'ada'; }
					else if (input[i].value == 'an_nu_bius_umum') { vm.form.an_nu_bius_umum = 'ada'; }
					else if (input[i].value == 'an_xylocain') { vm.form.an_xylocain = 'ada'; }

					else if (input[i].value == 'an_lidocain') { vm.form.an_lidocain = 'ada'; }
					else if (input[i].value == 'in_kornea') { vm.form.in_kornea = 'ada'; }
					else if (input[i].value == 'in_limbus') { vm.form.in_limbus = 'ada'; }
					else if (input[i].value == 'in_sclera') { vm.form.in_sclera = 'ada'; }
					else if (input[i].value == 'wt_main_port') { vm.form.wt_main_port = 'ada'; }
					else if (input[i].value == 'wt_two_side_port') { vm.form.wt_two_side_port = 'ada'; }
					else if (input[i].value == 'wt_one_side_port') { vm.form.wt_one_side_port = 'ada'; }
					else if (input[i].value == 'wt_keratome_2_koma_75_mm') { vm.form.wt_keratome_2_koma_75_mm = 'ada'; }
					else if (input[i].value == 'wt_crescen_knife') { vm.form.wt_crescen_knife = 'ada'; }
					else if (input[i].value == 'cs_ccc') { vm.form.cs_ccc = 'ada'; }
					else if (input[i].value == 'cs_x_mas_tree') { vm.form.cs_x_mas_tree = 'ada'; }
					else if (input[i].value == 'cs_linear') { vm.form.cs_linear = 'ada'; }
					else if (input[i].value == 'cs_can_opener') { vm.form.cs_can_opener = 'ada'; }
					else if (input[i].value == 'cs_tryphan_blue') { vm.form.cs_tryphan_blue = 'ada'; }
					else if (input[i].value == 'tb_ctr') { vm.form.tb_ctr = 'ada'; }

					else if (input[i].value == 'tb_kapsulotomi_posterior') { vm.form.tb_kapsulotomi_posterior = 'ada'; }
					else if (input[i].value == 'tb_vitrektomi_anterior') { vm.form.tb_vitrektomi_anterior = 'ada'; }
					else if (input[i].value == 'ci_rl') { vm.form.ci_rl = 'ada'; }
					else if (input[i].value == 'ci_bss') { vm.form.ci_bss = 'ada'; }
					else if (input[i].value == 'lio_dalam_kantung_kapsul') { vm.form.lio_dalam_kantung_kapsul = 'ada'; }
					else if (input[i].value == 'lio_bilik_mata_depan') { vm.form.lio_bilik_mata_depan = 'ada'; }
					else if (input[i].value == 'lio_sulcus_siliaris') { vm.form.lio_sulcus_siliaris = 'ada'; }
					else if (input[i].value == 'lio_diluar_kantong_kapsul') { vm.form.lio_diluar_kantong_kapsul = 'ada'; }
					else if (input[i].value == 'lio_afakia') { vm.form.lio_afakia = 'ada'; }
					else if (input[i].value == 'lio_fiksasi_scleral') { vm.form.lio_fiksasi_scleral = 'ada'; }
					else if (input[i].value == 'cv_hpmc') { vm.form.cv_hpmc = 'ada'; }
					else if (input[i].value == 'cv_viscoat') { vm.form.cv_viscoat = 'ada'; }
					else if (input[i].value == 'cv_hyaluronic_acid') { vm.form.cv_hyaluronic_acid = 'ada'; }
					else if (input[i].value == 'benang_tanpa_jahitan') { vm.form.benang_tanpa_jahitan = 'ada'; }
					else if (input[i].value == 'benang_ethylon_10_0') { vm.form.benang_ethylon_10_0 = 'ada'; }

					else if (input[i].value == 'benang_vicryl_8_0') { vm.form.benang_vicryl_8_0 = 'ada'; }
					else if (input[i].value == 'kompikasi_tidak_ada') { vm.form.kompikasi_tidak_ada = 'ada'; }
					else if (input[i].value == 'kompikasi_pcr') { vm.form.kompikasi_pcr = 'ada'; }
					else if (input[i].value == 'kompikasi_prolaps_vitreous') { vm.form.kompikasi_prolaps_vitreous = 'ada'; }
					else if (input[i].value == 'kompikasi_drop_nucleus') { vm.form.kompikasi_drop_nucleus = 'ada'; }
					else if (input[i].value == 'kompikasi_perdarahan') { vm.form.kompikasi_perdarahan = 'ada'; }
					else if (input[i].value == 'kompikasi_corneal_burn') { vm.form.kompikasi_corneal_burn = 'ada'; }
					else if (input[i].value == 'kompikasi_convert_to_ecce') { vm.form.kompikasi_convert_to_ecce = 'ada'; }
					else if (input[i].value == 'kompikasi_convert_to_icce') { vm.form.kompikasi_convert_to_icce = 'ada'; }
					else if (input[i].value == 'ppo_pulang_berobat_jalan') { vm.form.ppo_pulang_berobat_jalan = 'ada'; }
					else if (input[i].value == 'ppo_opname') { vm.form.ppo_opname = 'ada'; }
					else if (input[i].value == 'ipo_pdb2jpo') { vm.form.ipo_pdb2jpo = 'ada'; }
					else if (input[i].value == 'ipo_omdpspdb') { vm.form.ipo_omdpspdb = 'ada'; }
					else if (input[i].value == 'ipo_pdbddtksdto') { vm.form.ipo_pdbddtksdto = 'ada'; }
					else if (input[i].value == 'ipo_psdipo') { vm.form.ipo_psdipo = 'ada'; }
				}
				else {
					if (input[i].value == 'an_topical') { vm.form.an_topical = 'tidak ada'; }
					else if (input[i].value == 'an_retrobulbar_peribulbar') { vm.form.an_retrobulbar_peribulbar = 'tidak ada'; }
					else if (input[i].value == 'an_sub_conjunctival') { vm.form.an_sub_conjunctival = 'tidak ada'; }
					else if (input[i].value == 'an_intracamelar') { vm.form.an_intracamelar = 'tidak ada'; }
					else if (input[i].value == 'an_nu_bius_umum') { vm.form.an_nu_bius_umum = 'tidak ada'; }
					else if (input[i].value == 'an_xylocain') { vm.form.an_xylocain = 'tidak ada'; }

					else if (input[i].value == 'an_lidocain') { vm.form.an_lidocain = 'tidak ada'; }
					else if (input[i].value == 'in_kornea') { vm.form.in_kornea = 'tidak ada'; }
					else if (input[i].value == 'in_limbus') { vm.form.in_limbus = 'tidak ada'; }
					else if (input[i].value == 'in_sclera') { vm.form.in_sclera = 'tidak ada'; }
					else if (input[i].value == 'wt_main_port') { vm.form.wt_main_port = 'tidak ada'; }
					else if (input[i].value == 'wt_two_side_port') { vm.form.wt_two_side_port = 'tidak ada'; }
					else if (input[i].value == 'wt_one_side_port') { vm.form.wt_one_side_port = 'tidak ada'; }
					else if (input[i].value == 'wt_keratome_2_koma_75_mm') { vm.form.wt_keratome_2_koma_75_mm = 'tidak ada'; }
					else if (input[i].value == 'wt_crescen_knife') { vm.form.wt_crescen_knife = 'tidak ada'; }
					else if (input[i].value == 'cs_ccc') { vm.form.cs_ccc = 'tidak ada'; }
					else if (input[i].value == 'cs_x_mas_tree') { vm.form.cs_x_mas_tree = 'tidak ada'; }
					else if (input[i].value == 'cs_linear') { vm.form.cs_linear = 'tidak ada'; }
					else if (input[i].value == 'cs_can_opener') { vm.form.cs_can_opener = 'tidak ada'; }
					else if (input[i].value == 'cs_tryphan_blue') { vm.form.cs_tryphan_blue = 'tidak ada'; }
					else if (input[i].value == 'tb_ctr') { vm.form.tb_ctr = 'tidak ada'; }

					else if (input[i].value == 'tb_kapsulotomi_posterior') { vm.form.tb_kapsulotomi_posterior = 'tidak ada'; }
					else if (input[i].value == 'tb_vitrektomi_anterior') { vm.form.tb_vitrektomi_anterior = 'tidak ada'; }
					else if (input[i].value == 'ci_rl') { vm.form.ci_rl = 'tidak ada'; }
					else if (input[i].value == 'ci_bss') { vm.form.ci_bss = 'tidak ada'; }
					else if (input[i].value == 'lio_dalam_kantung_kapsul') { vm.form.lio_dalam_kantung_kapsul = 'tidak ada'; }
					else if (input[i].value == 'lio_bilik_mata_depan') { vm.form.lio_bilik_mata_depan = 'tidak ada'; }
					else if (input[i].value == 'lio_sulcus_siliaris') { vm.form.lio_sulcus_siliaris = 'tidak ada'; }
					else if (input[i].value == 'lio_diluar_kantong_kapsul') { vm.form.lio_diluar_kantong_kapsul = 'tidak ada'; }
					else if (input[i].value == 'lio_afakia') { vm.form.lio_afakia = 'tidak ada'; }
					else if (input[i].value == 'lio_fiksasi_scleral') { vm.form.lio_fiksasi_scleral = 'tidak ada'; }
					else if (input[i].value == 'cv_hpmc') { vm.form.cv_hpmc = 'tidak ada'; }
					else if (input[i].value == 'cv_viscoat') { vm.form.cv_viscoat = 'tidak ada'; }
					else if (input[i].value == 'cv_hyaluronic_acid') { vm.form.cv_hyaluronic_acid = 'tidak ada'; }
					else if (input[i].value == 'benang_tanpa_jahitan') { vm.form.benang_tanpa_jahitan = 'tidak ada'; }
					else if (input[i].value == 'benang_ethylon_10_0') { vm.form.benang_ethylon_10_0 = 'tidak ada'; }

					else if (input[i].value == 'benang_vicryl_8_0') { vm.form.benang_vicryl_8_0 = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_tidak_ada') { vm.form.kompikasi_tidak_ada = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_pcr') { vm.form.kompikasi_pcr = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_prolaps_vitreous') { vm.form.kompikasi_prolaps_vitreous = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_drop_nucleus') { vm.form.kompikasi_drop_nucleus = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_perdarahan') { vm.form.kompikasi_perdarahan = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_corneal_burn') { vm.form.kompikasi_corneal_burn = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_convert_to_ecce') { vm.form.kompikasi_convert_to_ecce = 'tidak ada'; }
					else if (input[i].value == 'kompikasi_convert_to_icce') { vm.form.kompikasi_convert_to_icce = 'tidak ada'; }
					else if (input[i].value == 'ppo_pulang_berobat_jalan') { vm.form.ppo_pulang_berobat_jalan = 'tidak ada'; }
					else if (input[i].value == 'ppo_opname') { vm.form.ppo_opname = 'tidak ada'; }
					else if (input[i].value == 'ipo_pdb2jpo') { vm.form.ipo_pdb2jpo = 'tidak ada'; }
					else if (input[i].value == 'ipo_omdpspdb') { vm.form.ipo_omdpspdb = 'tidak ada'; }
					else if (input[i].value == 'ipo_pdbddtksdto') { vm.form.ipo_pdbddtksdto = 'tidak ada'; }
					else if (input[i].value == 'ipo_psdipo') { vm.form.ipo_psdipo = 'tidak ada'; }
				}
			}
			vm.$emit('parsingForm', vm.parsecatatanoperasikatarak(vm.form), vm.keyform); 
		},
	}
}
</script>