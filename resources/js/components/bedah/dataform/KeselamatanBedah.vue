<template>
	<div class="grid" v-if="form && activetab">
		<div class="col-12 form-ml">
			<Inputed :ref="form.namaoperator.name" :form="form.namaoperator"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.namaahlianastesi.name" :form="form.namaahlianastesi"></Inputed>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.asistenoperasi.name" :form="form.asistenoperasi"></Inputed>
		</div>
		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Induksi Anastesi / <i>Sign In</i>
			</h3>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.sijam.name" :form="form.sijam"></Inputed>
		</div>


		<div class="col-6 form-ml">
			<Inputed :ref="form.sinama.name" :form="form.sinama"></Inputed>
		</div>





		<!-- <div class="col-4">
		<div class="col-4">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Insisi / <i>Time Out</i>
			</h4>
		</div>
		<Inputed :ref="form.tojam.name" :form="form.tojam"></Inputed>
	</div>
	<div class="col-4">
		<div class="col-4">
			<h4 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Pasien Meninggalkan Kamar Operasi / <i>Sign Out</i>
			</h4>
		</div>
		<Inputed :ref="form.sojam.name" :form="form.sojam"></Inputed>
	</div> -->
		<div class="col-12"><br></div>
		<div class="col-12" style="text-align: center;">Minimal ada Perawat, Perawat Anastesi dan Dokter Anastesi</div>
		<div class="col-12" style="text-align: center; font-size: 12px;"><i>Beri tanda checklist untuk jawaban ( Ya )
				dan kosongkan jika ( Tidak )</i><br><br></div>
		<div class="col-12"><br></div>

		<div class="col-12 form-ml">
			<table class="table">
				<tbody style="border-radius: 10px;">
					<tr>
						<td>
							Apakah identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada persetujuan
							tindakan medis yang akan dilakukan ( <i>informed_consent</i> ) ?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian1" value="si_bagian_1"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah area yang akan dioperasi sudah diberi tanda?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian2" value="si_bagian_2"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah mesin anestesi dan obat-obatan sudah lengkap?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian3" value="si_bagian_3"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah sudah terpasang 'pulse oksimetri' pada pasien, dan sudah berfungsi dengan baik?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian4" value="si_bagian_4"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah pasien memiliki riwayat alergi?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian5" value="si_bagian_5"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah pasien memiliki gangguan pernafasan? (bantuan sudah tersedia)
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian6" value="si_bagian_6"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Resiko pendarahan diatas >500ml (7ml/kg bagi anak anak) dan sudah direncanakan pemasangan
							innfus 2 line dan tersedia cairan-cairan yang akan diberikan
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sibagian7" value="si_bagian_7"
								style="cursor: pointer;">
						</td>
					</tr>
				</tbody>
			</table>
			<br>
		</div>









		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Insisi / <i>Time Out</i>
			</h3>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.tojam.name" :form="form.tojam"></Inputed>
		</div>


		<div class="col-6 form-ml">
			<Inputed :ref="form.tonama.name" :form="form.tonama"></Inputed>
		</div>
		<div class="col-12"><br></div>
		<div class="col-12" style="text-align: center;">Dengan Perawat, Perawat Anastesi, Dokter Anastesi, dan Dokter
			Bedah</div>
		<div class="col-12" style="text-align: center; font-size: 12px;"><i>Beri tanda checklist untuk jawaban ( Ya )
				dan kosongkan jika ( Tidak )</i></div>
		<div class="col-12"><br><br></div>

		<div class="col-12 form-ml">
			<table class="table">
				<tbody style="border-radius: 10px;">
					<tr>
						<td>
							Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri (nama dan peran masing
							masing)
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian1" value="to_bagian_1"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Memastikan dan baca ulang nama pasien, tindakan medis dan area yang akan diinsisi
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian21" value="to_bagian_2_1"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah profilaksis antibiotik sudah diberikan 1 jam sebelumnya?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian22" value="to_bagian_2_2"
								style="cursor: pointer;">
						</td>
					</tr>
				</tbody>
			</table>
			<br><br>
		</div>

		<div class="col-12" style="text-align: center;">Kejadian beresiko yang perlu diantisipasi untuk Dokter Bedah
		</div>
		<div class="col-12" style="text-align: center; font-size: 12px;"><i>Beri tanda checklist untuk jawaban ( Ya )
				dan kosongkan jika ( Tidak )</i><br><br></div>
		<div class="col-12"><br></div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.tobagian23.name" :form="form.tobagian23"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.tobagian3.name" :form="form.tobagian3"></Inputed>
		</div>

		<div class="col-12 form-ml">
			<table class="table">
				<tbody>
					<tr>
						<td>
							Apakah Sudah Antisipasi Pendarahan?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian41" value="to_bagian_4_1"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: right;">Untuk Dokter Anastesi</td>
					</tr>
					<tr>
						<td>
							Apakah ada hal khusus untuk pasien ini?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian42" value="to_bagian_4_2"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: right;">Untuk Tim Perawat</td>
					</tr>
					<tr>
						<td>
							Apakah sudah dipastikan kesterilan peralatan?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian5" value="to_bagian_5"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah alat implan yang dibutuhkan sudah disterilkan?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian6" value="to_bagian_6"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah ada masalah dengan peralatan atau masalah alat yang dikhawatirkan?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian7" value="so_asisten_1"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah hasil radiologi yang diperlukan sudah ada?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="tobagian8" value="so_penata"
								style="cursor: pointer;">
						</td>
					</tr>
				</tbody>
			</table>
			<br>
		</div>
		<div class="col-12">
			<h3 style="margin-bottom: 16px; margin-top: 5px; padding-bottom: 12px; border-bottom: 1px solid #d6d6d6">
				Sebelum Pasien Meninggalkan Kamar Operasi / <i>Sign Out</i>
			</h3>
		</div>
		<div class="col-6 form-ml">
			<Inputed :ref="form.sojam.name" :form="form.sojam"></Inputed>
		</div>

		<div class="col-6 form-ml">
			<Inputed :ref="form.scrubnurses.name" :form="form.scrubnurses"></Inputed>
		</div>
		<div class="col-12"><br></div>
		<div class="col-12" style="text-align: center;">Dengan Perawat, Perawat Anastesi, Dokter Anastesi, dan Dokter
			Bedah</div>
		<div class="col-12" style="text-align: center; font-size: 12px;"><i>Beri tanda checklist untuk jawaban ( Ya )
				dan kosongkan jika ( Tidak )</i></div>
		<div class="col-12"><br><br></div>

		<div class="col-12 form-ml">
			<table class="table">
				<tbody>
					<tr>
						<td>Secara verbal perawat memastikan nama tindakan</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sobagian1" value="so_bagian_1"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Kelengkapan alat, jumlah kasa, dan jarum
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sobagian2" value="so_bagian_2"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Pelabelan specimen (baca label specimen dan nama pasien dengan keras)
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sobagian3" value="so_bagian_3"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td>
							Apakah ada masalah peralatan yang perlu disampaikan?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sobagian4" value="so_bagian_4"
								style="cursor: pointer;">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							Untuk Dokter Bedah, Dokter Anastesi dan Perawat
						</td>
					</tr>
					<tr>
						<td>
							Apakah ada catatan khusus untuk proses recovery dan penanganan perawatan pasien ini?
						</td>
						<td>
							<input class="checkbox" type="checkbox" :checked="sobagian5" value="so_bagian_5"
								style="cursor: pointer;">
						</td>
						
					</tr>
				</tbody>
			</table>
			<br>
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
import { formkeselamatanbedah } from './FormData.js';
import { parsekeselamatanbedah } from './Attachment.js';
var vm;
export default {
	emits: ["dialog", "parsingForm"],
	props: ['activetab'],
	components: {
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Inputed2: defineAsyncComponent(() => import('../../../section/Inputed2.vue')),
	},
	mounted: function () {
		vm = this;
		vm.form = vm.formkeselamatanbedah();
	},
	created: function () { },
	data: function () {
		return {
			form: null, keyform: 'keselamatanbedah',
			sibagian1: false,
			sibagian2: false,
			sibagian3: false,
			sibagian4: false,
			sibagian5: false,
			sibagian6: false,
			tobagian7: false,
			tobagian8: false,
			tobagian1: false,
			tobagian21: false,
			tobagian22: false,
			tobagian41: false,
			tobagian42: false,
			tobagian5: false,
			tobagian6: false,
			sobagian1: false,
			sobagian2: false,
			sobagian3: false,
			sobagian4: false,
			sobagian5: false,
		}
	},
	methods: {
		parsekeselamatanbedah, formkeselamatanbedah,

		action: function () {
			let next = true;
			for (const key in vm.form) {
				if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			}

			if (next) { vm.parsingForm(); vm.dialog(); }
		},

		aturulang: function () {
			vm.form = vm.formkeselamatanbedah();
			vm.sibagian1 = false;
			vm.sibagian2 = false;
			vm.sibagian3 = false;
			vm.sibagian4 = false;
			vm.sibagian5 = false;
			vm.sibagian6 = false;
			vm.sibagian7 = false;
			vm.tobagian7 = false;
			vm.tobagian8 = false;
			vm.tobagian1 = false;
			vm.tobagian21 = false;
			vm.tobagian22 = false;
			vm.tobagian41 = false;
			vm.tobagian42 = false;
			vm.tobagian5 = false;
			vm.tobagian6 = false;
			vm.sobagian2 = false;
			vm.sobagian3 = false;
			vm.sobagian4 = false;
			vm.sobagian5 = false;
			vm.sobagian1 = false;
		},

		setdataform: function (data, row) {
			vm.form.bedah_uuid = row.uuid;
			vm.form.uuid = '';
			if (data) {
				vm.form.uuid = data.uuid;
				vm.form.namaoperator.value = data.nama_operator ? data.nama_operator : '';
				vm.form.namaahlianastesi.value = data.nama_ahli_anastesi ? data.nama_ahli_anastesi : '';
				vm.form.diagnosismedis.value = data.diagnosis_medis ? data.diagnosis_medis : '';
				vm.form.tindakanoperasi.value = data.tindakan_operasi ? data.tindakan_operasi : '';
				vm.form.asistenoperasi.value = data.asisten_operasi ? data.asisten_operasi : '';
				vm.form.scrubnurses.value = data.scrub_nurses ? data.scrub_nurses : '';

				vm.form.sinama.value = data.si_nama ? data.si_nama : '';
				vm.form.sijam.value = data.si_jam ? data.si_jam : '';

				vm.form.tobagian23.value = data.to_bagian_2_3 ? data.to_bagian_2_3 : '';
				vm.form.tobagian3.value = data.to_bagian_3 ? data.to_bagian_3 : '';

				vm.form.tonama.value = data.to_nama ? data.to_nama : '';
				vm.form.tojam.value = data.to_jam ? data.to_jam : '';
				vm.form.sojam.value = data.so_jam ? data.so_jam : '';

				if (data.si_bagian_1 == 'Ya') { vm.sibagian1 = true; }
				if (data.si_bagian_2 == 'Ya') { vm.sibagian2 = true; }
				if (data.si_bagian_3 == 'Ya') { vm.sibagian3 = true; }
				if (data.si_bagian_4 == 'Ya') { vm.sibagian4 = true; }
				if (data.si_bagian_5 == 'Ya') { vm.sibagian5 = true; }
				if (data.si_bagian_6 == 'Ya') { vm.sibagian6 = true; }
				if (data.si_bagian_7 == 'Ya') { vm.sibagian7 = true; }
				if (data.so_asisten_1 == 'Ya') { vm.tobagian7 = true; }
				if (data.so_penata == 'Ya') { vm.tobagian8 = true; }
				if (data.to_bagian_1 == 'Ya') { vm.tobagian1 = true; }
				if (data.to_bagian_2_1 == 'Ya') { vm.tobagian21 = true; }
				if (data.to_bagian_2_2 == 'Ya') { vm.tobagian22 = true; }
				if (data.to_bagian_4_1 == 'Ya') { vm.tobagian41 = true; }
				if (data.to_bagian_4_2 == 'Ya') { vm.tobagian42 = true; }
				if (data.to_bagian_5 == 'Ya') { vm.tobagian5 = true; }
				if (data.to_bagian_6 == 'Ya') { vm.tobagian6 = true; }
				if (data.so_bagian_2 == 'Ya') { vm.sobagian2 = true; }
				if (data.so_bagian_3 == 'Ya') { vm.sobagian3 = true; }
				if (data.so_bagian_4 == 'Ya') { vm.sobagian4 = true; }
				if (data.so_bagian_5 == 'Ya') { vm.sobagian5 = true; }
				if (data.so_bagian_1 == 'Ya') { vm.sobagian1 = true; }

			}

			console.log(data);
		},

		dialog: function () {
			let text = '', button = '';
			text = 'Yakin ingin menambah/perbaharui data pada halaman ini.';
			button = 'Ya, tambah data';
			vm.$emit('dialog', text, button, vm.keyform);
		},

		parsingForm: function () {
			var input = document.querySelectorAll('.checkbox');
			for (var i = 0; i < input.length; i++) {
				if (input[i].checked) {
					if (input[i].value == 'si_bagian_1') { vm.form.sibagian1 = 'Ya'; }
					else if (input[i].value == 'si_bagian_2') { vm.form.sibagian2 = 'Ya'; }
					else if (input[i].value == 'si_bagian_3') { vm.form.sibagian3 = 'Ya'; }
					else if (input[i].value == 'si_bagian_4') { vm.form.sibagian4 = 'Ya'; }
					else if (input[i].value == 'si_bagian_5') { vm.form.sibagian5 = 'Ya'; }
					else if (input[i].value == 'si_bagian_6') { vm.form.sibagian6 = 'Ya'; }
					else if (input[i].value == 'si_bagian_7') { vm.form.sibagian7 = 'Ya'; }
					else if (input[i].value == 'so_asisten_1') { vm.form.tobagian7 = 'Ya'; }
					else if (input[i].value == 'so_penata') { vm.form.tobagian8 = 'Ya'; }
					else if (input[i].value == 'to_bagian_1') { vm.form.tobagian1 = 'Ya'; }
					else if (input[i].value == 'to_bagian_2_1') { vm.form.tobagian21 = 'Ya'; }
					else if (input[i].value == 'to_bagian_2_2') { vm.form.tobagian22 = 'Ya'; }
					else if (input[i].value == 'to_bagian_4_1') { vm.form.tobagian41 = 'Ya'; }
					else if (input[i].value == 'to_bagian_4_2') { vm.form.tobagian42 = 'Ya'; }
					else if (input[i].value == 'to_bagian_5') { vm.form.tobagian5 = 'Ya'; }
					else if (input[i].value == 'to_bagian_6') { vm.form.tobagian6 = 'Ya'; }
					else if (input[i].value == 'so_bagian_2') { vm.form.sobagian2 = 'Ya'; }
					else if (input[i].value == 'so_bagian_3') { vm.form.sobagian3 = 'Ya'; }
					else if (input[i].value == 'so_bagian_4') { vm.form.sobagian4 = 'Ya'; }
					else if (input[i].value == 'so_bagian_5') { vm.form.sobagian5 = 'Ya'; }
					else if (input[i].value == 'so_bagian_1') { vm.form.sobagian1 = 'Ya'; }

				}
				else {
					if (input[i].value == 'si_bagian_1') { vm.form.sibagian1 = 'Tidak'; }
					else if (input[i].value == 'si_bagian_2') { vm.form.sibagian2 = 'Tidak'; }
					else if (input[i].value == 'si_bagian_3') { vm.form.sibagian3 = 'Tidak'; }
					else if (input[i].value == 'si_bagian_4') { vm.form.sibagian4 = 'Tidak'; }
					else if (input[i].value == 'si_bagian_5') { vm.form.sibagian5 = 'Tidak'; }
					else if (input[i].value == 'si_bagian_6') { vm.form.sibagian6 = 'Tidak'; }
					else if (input[i].value == 'si_bagian_7') { vm.form.sibagian7 = 'Tidak'; }
					else if (input[i].value == 'so_asisten_1') { vm.form.tobagian7 = 'Tidak'; }
					else if (input[i].value == 'so_penata') { vm.form.tobagian8 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_1') { vm.form.tobagian1 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_2_1') { vm.form.tobagian21 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_2_2') { vm.form.tobagian22 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_4_1') { vm.form.tobagian41 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_4_2') { vm.form.tobagian42 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_5') { vm.form.tobagian5 = 'Tidak'; }
					else if (input[i].value == 'to_bagian_6') { vm.form.tobagian6 = 'Tidak'; }
					else if (input[i].value == 'so_bagian_2') { vm.form.sobagian2 = 'Tidak'; }
					else if (input[i].value == 'so_bagian_3') { vm.form.sobagian3 = 'Tidak'; }
					else if (input[i].value == 'so_bagian_4') { vm.form.sobagian4 = 'Tidak'; }
					else if (input[i].value == 'so_bagian_5') { vm.form.sobagian5 = 'Tidak'; }
					else if (input[i].value == 'so_bagian_1') { vm.form.sobagian1 = 'Tidak'; }

				}
			}
			vm.$emit('parsingForm', vm.parsekeselamatanbedah(vm.form), vm.keyform);
		},
	}
}
</script>