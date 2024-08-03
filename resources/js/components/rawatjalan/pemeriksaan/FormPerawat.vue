<template>
	<div :style="terminate.display" class="modal">
		<div ref="rootmodal" class="modal-content modal-besar"
			:class="terminate.show ? 'modal-opened' : 'modal-closed'">
			<div class="modal-header">
				<span class="close" v-on:click="hide()">&times;</span>
				<h2 v-if="form">{{ form.title }}</h2>
			</div>
			<div class="modal-body" v-if="form">
				<div class="grid">		
					<div class="col-4 form-mr">
						<ul class="list-detail">
							<li>No Rekam Medis<span><strong>{{ detailperawat.rekam_medis }}</strong></span></li>
							<li>Nama Lengkap<span><strong>{{ detailperawat.nama_pasien }}</strong></span></li>
							<li>Tanggal Lahir<span><strong>{{ datename(detailperawat.tanggal_lahir) }}</strong></span>
							</li>
						</ul>
					</div>
					<div class="col-4 form-mr">
						<ul class="list-detail">
							<li>Jenis Kelamin<span><strong>{{ detailperawat.jenis_kelamin }}</strong></span></li>
							<li>Dokter yang menangani<span><strong>{{ detailperawat.nama_dokter }}</strong></span></li>
						</ul>
					</div>
					<div class="col-4 form-mr">
						<ul class="list-detail">
							<li>Cara Bayar<span><strong>{{ detailperawat.carabayar_nama }}</strong></span></li>
							<li>Nomor Handphone<span><strong>{{ detailperawat.no_handphone }}</strong></span></li>
							<li>Triase<span><strong>{{ detailperawat.berkebutuhan_khusus }}</strong></span></li>
						</ul>
					</div>
				</div>

				<div class="grid">
					<div class="col-12">

						<div class="tab-lines">
							<div class="tab"><button v-for="(item, index) in tab.button" :class="item.class"
									v-on:click="changesTab(item.value, index, item.class)">{{ item.label }}</button>
							</div>
						</div>

						<div class="tab-content">
							<div style="position: relative;" class="content-tab-in"
								v-if="tab.content.pemeriksaan_fisik">
								<div class="grid">
									<div class="col-6 form-mr">

										<Inputed :ref="form.keluhanutama.name" :form="form.keluhanutama"></Inputed>

										<Inputed :ref="form.penetesanobat.name" :form="form.penetesanobat"></Inputed>

										<Inputed :ref="form.riwayatpenyakit.name" :form="form.riwayatpenyakit">
										</Inputed>

										<Selected
											v-on:click="selectbox($event, form.select.kasusurgent.name, form.select.kasusurgent.statics)"
											:ref="form.select.kasusurgent.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.kasusurgent"
											v-on:keyup="selectfilter($event, form.select.kasusurgent.name)"></Selected>

										<Inputed :ref="form.kasusurgentlainnya.name" :form="form.kasusurgentlainnya">
										</Inputed>

										<Selected
											v-on:click="selectbox($event, form.select.statuspsikologis.name, form.select.statuspsikologis.statics)"
											:ref="form.select.statuspsikologis.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.statuspsikologis"
											v-on:keyup="selectfilter($event, form.select.statuspsikologis.name)">
										</Selected>

										<Selected
											v-on:click="selectbox($event, form.select.statusfungsional.name, form.select.statusfungsional.statics)"
											:ref="form.select.statusfungsional.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.statusfungsional"
											v-on:keyup="selectfilter($event, form.select.statusfungsional.name)">
										</Selected>


									</div>
									<div class="col-6 form-ml">

										<Inputed :ref="form.nadi.name" :form="form.nadi"></Inputed>
										<Inputed :ref="form.respiratoryrate.name" :form="form.respiratoryrate">
										</Inputed>
										<Inputed :ref="form.suhu.name" :form="form.suhu"></Inputed>
										<Inputed :ref="form.beratbadan.name" :form="form.beratbadan"></Inputed>
										<Inputed :ref="form.tinggibadan.name" :form="form.tinggibadan"></Inputed>
										<Inputed :ref="form.tekanandarah.name" :form="form.tekanandarah"></Inputed>

									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.skrinning">
								<div class="grid">
									<div class="col-6 form-mr">


										<Selected
											v-on:click="selectbox($event, form.select.nyeri.name, form.select.nyeri.statics)"
											:ref="form.select.nyeri.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.nyeri"
											v-on:keyup="selectfilter($event, form.select.nyeri.name)"></Selected>

										<Selected
											v-on:click="selectbox($event, form.select.nyerihilangbila.name, form.select.nyerihilangbila.statics)"
											:ref="form.select.nyerihilangbila.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.nyerihilangbila"
											v-on:keyup="selectfilter($event, form.select.nyerihilangbila.name)">
										</Selected>

										<Inputed :ref="form.nyerihilangbilalainnya.name"
											:form="form.nyerihilangbilalainnya"></Inputed>

										<Inputed :ref="form.skalanyeri.name" :form="form.skalanyeri"></Inputed>

									</div>
									<div class="col-6 form-ml">

										<Inputed :ref="form.lokasinyeri.name" :form="form.lokasinyeri"></Inputed>
										<Inputed :ref="form.durasinyeri.name" :form="form.durasinyeri"></Inputed>
										<Inputed :ref="form.karakteristiknyeri.name" :form="form.karakteristiknyeri">
										</Inputed>
										<Inputed :ref="form.keterangannyeri.name" :form="form.keterangannyeri">
										</Inputed>

									</div>
								</div>
							</div>

							<div class="content-tab-in" v-if="tab.content.riwayat_kesehatan">
								<div class="grid">
									<div class="col-6 form-mr">


										<Selected
											v-on:click="selectbox($event, form.select.penyakitpernahdiderita.name, form.select.penyakitpernahdiderita.statics)"
											:ref="form.select.penyakitpernahdiderita.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.penyakitpernahdiderita"
											v-on:keyup="selectfilter($event, form.select.penyakitpernahdiderita.name)">
										</Selected>

										<Inputed :ref="form.penyakitpernahdideritalainnya.name"
											:form="form.penyakitpernahdideritalainnya"></Inputed>

										<Selected
											v-on:click="selectbox($event, form.select.pernahdioperasi.name, form.select.pernahdioperasi.statics)"
											:ref="form.select.pernahdioperasi.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.pernahdioperasi"
											v-on:keyup="selectfilter($event, form.select.pernahdioperasi.name)">
										</Selected>

										<Inputed :ref="form.pernahdioperasilainnya.name"
											:form="form.pernahdioperasilainnya"></Inputed>


										<Selected
											v-on:click="selectbox($event, form.select.riwayatalergimakanan.name, form.select.riwayatalergimakanan.statics)"
											:ref="form.select.riwayatalergimakanan.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.riwayatalergimakanan"
											v-on:keyup="selectfilter($event, form.select.riwayatalergimakanan.name)">
										</Selected>

										<Inputed :ref="form.riwayatalergimakananlainnya.name"
											:form="form.riwayatalergimakananlainnya"></Inputed>

									</div>
									<div class="col-6 form-ml">
										<Selected
											v-on:click="selectbox($event, form.select.riwayatalergiobatan.name, form.select.riwayatalergimakanan.statics)"
											:ref="form.select.riwayatalergiobatan.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.riwayatalergiobatan"
											v-on:keyup="selectfilter($event, form.select.riwayatalergiobatan.name)">
										</Selected>

										<Inputed :ref="form.riwayatalergiobatanlainnya.name"
											:form="form.riwayatalergiobatanlainnya"></Inputed>

										<Selected
											v-on:click="selectbox($event, form.select.obatdigunakansaatini.name, form.select.riwayatalergimakanan.statics)"
											:ref="form.select.obatdigunakansaatini.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.obatdigunakansaatini"
											v-on:keyup="selectfilter($event, form.select.obatdigunakansaatini.name)">
										</Selected>

										<Inputed :ref="form.obatdigunakansaatinilainnya.name"
											:form="form.obatdigunakansaatinilainnya"></Inputed>

										<Selected
											v-on:click="selectbox($event, form.select.penilaianresikojatuh.name, form.select.riwayatalergimakanan.statics)"
											:ref="form.select.penilaianresikojatuh.name" @selecteditem="selecteditem"
											@selectclear="selectclear" :selection="form.select.penilaianresikojatuh"
											v-on:keyup="selectfilter($event, form.select.penilaianresikojatuh.name)">
										</Selected>

									</div>
								</div>
							</div>


						</div>
						<div class="tab-content">
							<div style="position: relative;" class="content-tab-in" v-if="tab.content.edukasi_pasien">
								<div class="grid">
									<div class="col-6 form-mr">

										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Pengkajian Hambatan</td>
												</tr>
												<tr>
													<td style="text-align: left;">Bahasa</td>
													<td style="text-align: right;"><input class="checkbox"
															type="checkbox" v-model="ph_bahasa"
															style=" cursor: pointer;"></td>
												</tr>
												<tr>
													<td style="text-align: left;">Pendengaran</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_pendengaran" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Masalah Penglihatan</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_masalah_penglihatan" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Bicara Buruk</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_bicara_buruk" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Hilang Memori</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_hilang_memori" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Tidak Ada Partisipasi</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_tidak_ada_partisipasi" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Secara Fisiologi Tidak Mampu Belajar
													</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_tidak_mampu_belajar" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Tidak Ditemukan Hambatan Belajar</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_tidak_ada_hambatan_belajar" style="cursor: pointer;">
</td>
												</tr>

												<tr>
													<td style="text-align: left;">Cemas</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_cemas" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Emoosi</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_emosi" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Kognitif</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_kognitif" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="text-align: left;">Motivasi</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ph_motivasi" style="cursor: pointer;">
</td>
												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Edukasi</td>
												</tr>
												<tr>
													<td>Tata Tertib RS</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="edukasi_tata_tertib" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Hak dan Kewajiban Pasien</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="edukasi_hak_dan_kewajiban" style="cursor: pointer;">
</td>
												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Metode Cara Belajar Yang
														Disukai</td>
												</tr>
												<tr>
													<td>Audio</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="metode_audio" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Demonstrasi</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="metode_demonstrasi" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Lisan</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="metode_lisan" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Tulisan</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="metode_tulisan" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Visual</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="metode_visual" style="cursor: pointer;">
</td>
												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Agama</td>
												</tr>
												<tr>
													<td>Islam</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ag_islam" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Protestan</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ag_protestan" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Katolik</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ag_katolik" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Hindu</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ag_hindu" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Budha</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ag_budha" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Lain-lain</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="ag_lainnya" style="cursor: pointer;">
</td>
												</tr>


											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Rencana Pendidikan
														Kesehatan</td>
												</tr>
												<tr>
													<td>Proses Penyakit</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rpk_proses_penyakit" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Pengobatan / Tindakan</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rpk_pengobatan" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Nutrisi</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rpk_nutrisi" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Edukasi Kolaboratif</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rpk_edukasi" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Lainnya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rpk_lain_lain" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="width: 60%;">Jelaskan</td>
													<td>
														<Inputed2 :ref="form.rpk_jelaskan.name"
															:form="form.rpk_jelaskan"></Inputed2>
													</td>
												</tr>


											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Kebutuhan Privasi</td>
												</tr>
												<tr>
													<td>Ya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="kp_ya" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Tidak</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="kp_tidak" style="cursor: pointer;">
</td>
												</tr>

											</tbody>
										</table>




									</div>
									<div class="col-6 form-ml">
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Pengkajian Bicara</td>
												</tr>
												<tr>
													<td>Normal</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="pb_normal" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Gangguan Bicara</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="pb_gangguan" style="cursor: pointer;">
</td>
												</tr>

											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Bahasa Sehari hari</td>
												</tr>
												<tr>
													<td>Bahasa Indonesia</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="bs_indonesia" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Bahasa Inggris</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="bs_inggris" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Bahasa Daerah</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="bs_daerah" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="width: 60%;">Bahasa Lainnya</td>
													<td>
														<Inputed2 :ref="form.bs_lainnya.name" :form="form.bs_lainnya">
														</Inputed2>
													</td>

												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Bahasa Isyarat</td>
												</tr>
												<tr>
													<td>Tidak</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="bi_tidak" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Iya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="bi_iya" style="cursor: pointer;">
</td>
												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Tingkat Pendidikan</td>
												</tr>
												<tr>
													<td>TK</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_tk" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>SD</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_sd" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>SMP</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_smp" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>SMA</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_sma" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Diploma</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_diploma" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Sarjana</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_sarjana" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Lainnya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_lainnya" style="cursor: pointer;">
</td>
												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Tingkat Pengetahuan
														Kesehatan Pasien</td>
												</tr>
												<tr>
													<td>Paham</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_paham" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Kurang Paham</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_kurang_paham" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Tidak Paham</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="tp_tidak" style="cursor: pointer;">
</td>
												</tr>

											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Nilai-nilai dan Budaya
														Pasien</td>
												</tr>
												<tr>
													<td>Modern</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="np_modern" style="cursor: pointer;">
</td>

												</tr>
												<tr>
													<td>Moderat</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="np_moderat" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Konvensional</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="np_konvensional" style="cursor: pointer;">
</td>
												</tr>
											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Merokok</td>
												</tr>
												<tr>
													<td>Ya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rokok_ya" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Tidak</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="rokok_tidak" style="cursor: pointer;">
</td>
												</tr>

											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Konsumsi Alkohol</td>
												</tr>
												<tr>
													<td>Ya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="alkohol_ya" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Tidak</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="alkohol_tidak" style="cursor: pointer;">
</td>
												</tr>

											</tbody>
										</table>
										<br>
										<table class="table">
											<tbody>
												<tr>
													<td colspan="2" style="text-align: center;">Kesediaan Menerima
														Informasi</td>
												</tr>
												<tr>
													<td>Ya</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="kmi_ya" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td>Tidak</td>
													<td style="text-align: right;">
    <input class="checkbox" type="checkbox" v-model="kmi_tidak" style="cursor: pointer;">
</td>
												</tr>
												<tr>
													<td style="width: 60%;">Alasan</td>
													<td>
														<Inputed2 :ref="form.kmi_alasan.name" :form="form.kmi_alasan">
														</Inputed2>
													</td>
												</tr>


											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
						<div class="tab-content">
							<div class="content-tab-in" v-if="tab.content.cppt">
								<div class="grid">
									<div class="col-5 form-ml">
										<iframe title="CPPT" width="100%" height="100%" style="border: 0" :src="linkR">
										</iframe>
									</div>

									<div class="col-7 form-ml">
										<label for=""> Subject</label>
										<ckeditor v-model="form.subject" :editor="editor">
										</ckeditor>
										<br>
										<label for=""> Object</label>
										<ckeditor v-model="form.object" :editor="editor">
										</ckeditor>
										<br>

										<label for=""> Assessment </label>
										<ckeditor v-model="form.assessment" :editor="editor">
										</ckeditor>
										<br />
										<label for=""> Planning </label>
										<ckeditor v-model="form.plan" :editor="editor">
										</ckeditor>
									</div>
									<div class="col-9"></div>
									<div class="col-3 form-ml form-mt">
										<label for="">Tanda Tangan Digital</label>
											<img
												v-if="form.ttd"
												:src="form.ttd"
												alt="ttd dokter"
												height="100"
												width="400"
											/>
											<br>
										<button v-if="!form.ttd" class="button-modal-page button-modal-green" v-on:click="doDigitalSignature()">Tanda Tangan Digital</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="grid" style="border-top: 1px solid #d0d0d0; padding-top: 20px;" v-if="form">
					<div class="col-8"></div>
					<div class="col-4" style="text-align: right" v-if="ishide">
						<button class="button-modal-page button-modal-red" v-on:click="redbutton()">{{ red
							}}</button>
						<button class="button-modal-page button-modal-green" v-on:click="greenbutton()">{{ green
							}}</button>
					</div>
					<div class="col-4" style="text-align: right" v-else>
						<button class="button-modal-page button-modal-red" v-on:click="cancel()">Batalkan
							Kunjungan</button>
						<button class="button-modal-page button-modal-green" v-on:click="edit()">Edit
							Data</button>
					</div>
				</div>
			</div>
			<Loader ref="Loader"></Loader>
		</div>
	</div>
</template>
<script>
import { defineAsyncComponent } from 'vue';
import { formkelurahan } from './FormData.js';
import { parsekelurahan } from './Attachment.js';
import { filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected } from '../../../module/SelectedFilter.js';
import { initindexdb, indexdbprocessing } from '../../../module/Indexdb.js';
import 'vue3-toastify/dist/index.css';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2';
import { arrpemeriksaan } from '../../../module/DataArray.js';
import { datename } from '../../../module/Manipulation.js';
import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

var vm, body;
export default {
	emits: ["dialog", "parsingForm"],
	components: {
		toast, Swal,
		Inputed: defineAsyncComponent(() => import('../../../section/Inputed.vue')),
		Inputed2: defineAsyncComponent(() => import('../../../section/Inputed2.vue')),
		Selected: defineAsyncComponent(() => import('../../../section/Selected.vue')),
		ckeditor: CKEditor.component,
	},
	computed: {
		ishide: function () {
			if (vm.test) { vm.red = 'Cancel'; }
			return vm.test ? false : true;
		},
	},
	mounted: function () {
		vm = this; body = document.body;
		vm.form = vm.formkelurahan();
		vm.arr = vm.arrpemeriksaan();
		window.onclick = function (event) { let a = event.target.className; try { if (a.split(" ")) { a = a.split(" "); if (a[0] != 'hospitals') { vm.selecthide(); } } if (event.target.className == '') { vm.selecthide(); } } catch { console.log('mistmatch'); } }
	},
	created: function () { },
	data: function () {
		return {

			linkR: "/print/rekammedis/rawat-jalan/cppt/",
			detail: null,
			editor: ClassicEditor,
			terminate: { show: false, display: 'display: none' },
			form: null, btnlbl: '', arr: null, keyform: 'addperawat',
			green: 'Save Data', red: 'Clear Form', test: null, cover: '', temporer: null,
			ph_bahasa: false,
			ph_pendengaran: false,
			ph_masalah_penglihatan: false,
			ph_bicara_buruk: false,
			ph_hilang_memori: false,
			ph_tidak_ada_partisipasi: false,
			ph_tidak_mampu_belajar: false,
			ph_tidak_ada_hambatan_belajar: false,
			ph_cemas: false,
			ph_emosi: false,
			ph_kognitif: false,
			ph_motivasi: false,
			edukasi_tata_tertib: false,
			edukasi_hak_dan_kewajiban: false,
			metode_audio: false,
			metode_demonstrasi: false,
			metode_lisan: false,
			metode_tulisan: false,
			metode_visual: false,
			pb_normal: false,
			pb_gangguan: false,
			bs_indonesia: false,
			bs_daerah: false,
			bs_inggris: false,
			bi_tidak: false,
			bi_iya: false,
			tp_tk: false,
			tp_sd: false,
			tp_smp: false,
			tp_sma: false,
			tp_diploma: false,
			tp_sarjana: false,
			tp_lainnya: false,
			ag_islam: false,
			ag_protestan: false,
			ag_katolik: false,
			ag_hindu: false,
			ag_budha: false,
			ag_lainnya: false,
			tp_paham: false,
			tp_kurang_paham: false,
			tp_tidak: false,
			np_modern: false,
			np_moderat: false,
			np_konvensional: false,
			rokok_ya: false,
			rokok_tidak: false,
			alkohol_ya: false,
			alkohol_tidak: false,
			kmi_ya: false,
			kmi_tidak: false,
			rpk_proses_penyakit: false,
			rpk_pengobatan: false,
			rpk_nutrisi: false,
			rpk_edukasi: false,
			rpk_lain_lain: false,
			kp_ya: false,
			kp_tidak: false,

			detailperawat: {
				uuid: '', registrasi_uuid: '',
				agama: '', alamat: '', alias: '', email: '', golongan_darah: '', jenis_identitas: '', jenis_kelamin: '',
				kodepos: '', nama: '', nama_ayah: '', nama_ibu: '', nama_kab_kota: '', nama_kecamatan: '', nama_kelurahan: '',
				nama_provinsi: '', no_handphone: '', no_identitas: '', pekerjaan: '', pendidikan_terakhir: '', rekam_medis: '',
				rt_rw: '', status_pernikahan: '', tanggal_lahir: '', tempat_lahir: ''
			},
			tab: {
				button: [
					{ value: 'pemeriksaan_fisik', label: 'Pemeriksaan Fisik', class: 'tab-active' },
					{ value: 'skrinning', label: 'Skrinning', class: 'tab-no-active' },
					{ value: 'riwayat_kesehatan', label: 'Riwayat Kesehatan', class: 'tab-no-active' },
					{ value: 'edukasi_pasien', label: 'Edukasi Pasien', class: 'tab-no-active' },
					{ value: 'cppt', label: 'CPPT', class: 'tab-no-active' },
				],
				content: { pemeriksaan_fisik: true, skrinning: false, riwayat_kesehatan: false, edukasi_pasien: false, cppt: false, }
			},
		}
	},
	methods: {


		datename,

		greenbutton: function () {
			if (vm.green == 'Save Data') {
				console.log(vm.form, 'dfdf')
				vm.action();
			}
		},

		doDigitalSignature: function () { 
			vm.form.ttd = window.localStorage.getItem("ttd") ?? "";
		},

		redbutton: function () {
			if (vm.red == 'Clear Form') { vm.form = vm.formkelurahan(); }
			else if (vm.red == 'Back') { vm.test = vm.temporer; }
		},

		changesTab: function (values, index, classes) {
			if (classes != 'tab-active') {
				for (let i = 0; i < vm.tab.button.length; i++) {
					vm.tab.content[vm.tab.button[i].value] = false; vm.tab.button[i].class = 'tab-no-active';	}
				vm.tab.button[index].class = 'tab-active';
				vm.tab.content[values] = true;
				vm.setCkEditor();
			}
		},

		parsekelurahan, formkelurahan, initindexdb, indexdbprocessing, arrpemeriksaan, datename,
		filterselected, hideselected, itemselected, clearselected, boxselected, conditionselected,

		selectfilter: function (event, key) { vm.form = vm.filterselected(vm.form, key); },
		selecthide: function () { vm.form = vm.hideselected(vm.form); },
		selecteditem: function (item, key) { vm.form = vm.conditionselected(vm.form, item, key, 'address'); vm.form = vm.itemselected(vm.form, item, key); },
		selectclear: function (key) { vm.form = vm.clearselected(vm.form, key); },
		selectbox: function (event, key, statics) {
			let result = vm.boxselected(event, vm.form, key);
			console.log('aaa', result);
			if (result._position == 'stop') { return; }
			else if (result._position == 'nextstop') { vm.form = result._form; }

			else { vm.selecthide(); vm.getIndexDB(key, statics); vm.form.select[key].option = 'display: block'; }
		},

		getIndexDB: function (key, statics) {
			vm.form.select[key].data = []; vm.form.select[key].filter = [];
			if (statics) { vm.form.select[key].data = this.arr[key]; vm.form.select[key].filter = this.arr[key]; }
			else {
				vm.initindexdb(vm.$dbNameIndexDb, key)
					.then(function (response) { vm.form = vm.indexdbprocessing(response, vm.form, key); })
					.catch(function (error) { console.log(error); });
			}
		},

		action: function () {
			// let next = true;
			// for (const key in vm.form) {
			// 	if (key != 'select') { if (vm.form[key].required != '') { if (vm.form[key].value == '') { next = false; } } }
			// 	else {
			// 		for (const keyselect in vm.form.select) {
			// 			if (vm.form.select[keyselect].isrequired) { if (vm.form.select[keyselect].value == '') { next = false; } }
			// 		}
			// 	}
			// }

			vm.parsingForm(); vm.dialog();
		},

		nullcheck: function (data) {
			if (!data || data == '-' || data == ' ' || data == '0' || data == '') { return ''; }
			return data;
		},

		show: function (posisi, title, uuid) {
			vm.btnlbl = posisi == 'adddataperawat' ? 'Save Data' : 'Update Data'; vm.form.uuid = uuid;
			vm.form.title = title; vm.form.posisi = posisi;
			vm.form.posisi = posisi; body.style.overflowY = 'hidden'; vm.terminate.display = 'display: block'; vm.terminate.show = true;
		},
		aturulang: function () {
			vm.form = vm.formkelurahan();
			vm.ph_bahasa = false;
			vm.ph_pendengaran = false;
			vm.ph_masalah_penglihatan = false;
			vm.ph_bicara_buruk = false;
			vm.ph_hilang_memori = false;
			vm.ph_tidak_ada_partisipasi = false;
			vm.ph_tidak_mampu_belajar = false;
			vm.ph_tidak_ada_hambatan_belajar = false;
			vm.ph_cemas = false;
			vm.ph_emosi = false;
			vm.ph_kognitif = false;
			vm.ph_motivasi = false;
			vm.edukasi_tata_tertib = false;
			vm.edukasi_hak_dan_kewajiban = false;
			vm.metode_audio = false;
			vm.metode_demonstrasi = false;
			vm.metode_lisan = false;
			vm.metode_tulisan = false;
			vm.metode_visual = false;
			vm.pb_normal = false;
			vm.pb_gangguan = false;
			vm.bs_indonesia = false;
			vm.bs_daerah = false;
			vm.bs_inggris = false;
			vm.bi_tidak = false;
			vm.bi_iya = false;
			vm.tp_tk = false;
			vm.tp_sd = false;
			vm.tp_smp = false;
			vm.tp_sma = false;
			vm.tp_diploma = false;
			vm.tp_sarjana = false;
			vm.tp_lainnya = false;
			vm.ag_islam = false;
			vm.ag_protestan = false;
			vm.ag_katolik = false;
			vm.ag_hindu = false;
			vm.ag_budha = false;
			vm.ag_lainnya = false;
			vm.tp_paham = false;
			vm.tp_kurang_paham = false;
			vm.tp_tidak = false;
			vm.np_modern = false;
			vm.np_moderat = false;
			vm.np_konvensional = false;
			vm.rokok_ya = false;
			vm.rokok_tidak = false;
			vm.alkohol_ya = false;
			vm.alkohol_tidak = false;
			vm.kmi_ya = false;
			vm.kmi_tidak = false;
			vm.rpk_proses_penyakit = false;
			vm.rpk_pengobatan = false;
			vm.rpk_nutrisi = false;
			vm.rpk_edukasi = false;
			vm.rpk_lain_lain = false;
			vm.kp_ya = false;
			vm.kp_tidak = false;
			vm.data = [];
			vm.linkR = '/print/rekammedis/rawat-jalan/cppt/'

		},

		look: function (index) {
			vm.detail = vm.data[index];
		},



		hide: function () { vm.terminate.show = false; setTimeout(function () { vm.terminate.display = 'display= none'; body.style.overflowY = 'auto'; }, 250, this); },
		// parsingForm: function () { 
		// 	vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detailperawat), 'addperawat'); 
		// },
		setCkEditor: function(val, title){
			vm.form.subject = `${vm.form.keluhanutama.value}`;
		},


		loaderprocess: function () { const left = this.$refs.rootmodal.getBoundingClientRect(); vm.$refs.Loader.running(left, 'modal', 250); },

		setdataform: function (response) {





			// if (vm.detailperawat.ruang_poliklinik != '0') {
			// 	vm.form.select.klinik.value = vm.detailperawat.ruang_poliklinik;
			// 	vm.form.select.klinik.label = 'Poli ' + vm.detailperawat.ruang_poliklinik;
			// }
			// vm.data = response.data.detailperawat;

			vm.detailperawat = response.data.data;
			vm.histori = response.data.histori;
			let temps = response.data.kunjungan;
			vm.linkR = vm.linkR + vm.detailperawat.pasien_uuid;
			console.log(vm.linkR);

			if (temps) {
				vm.form.uuid = temps.uuid;
				// vm.detailperawat.registrasi_uuid = temps.registrasi_uuid;

				vm.form.bs_lainnya.value = temps?.edukasi_pasien?.bs_lainnya ? temps.edukasi_pasien.bs_lainnya : '';
				vm.form.rpk_jelaskan.value = temps?.edukasi_pasien?.rpk_jelaskan ? temps.edukasi_pasien.rpk_jelaskan : '';
				vm.form.kmi_alasan.value = temps?.edukasi_pasien?.kmi_alasan ? temps.edukasi_pasien.kmi_alasan : '';


				vm.form.penetesanobat.value = vm.nullcheck(temps.penetesan_obat);

				vm.form.keluhanutama.value = vm.nullcheck(temps.keluhan_utama);
				vm.form.riwayatpenyakit.value = vm.nullcheck(temps.riwayat_penyakit);
				vm.form.kasusurgentlainnya.value = vm.nullcheck(temps.kasus_urgent_lainnya);
				vm.form.tekanandarah.value = vm.nullcheck(temps.tekanan_darah);
				vm.form.nadi.value = vm.nullcheck(temps.nadi);
				vm.form.respiratoryrate.value = vm.nullcheck(temps.respiratory_rate);
				vm.form.beratbadan.value = vm.nullcheck(temps.berat_badan);
				vm.form.tinggibadan.value = vm.nullcheck(temps.tinggi_badan);
				vm.form.suhu.value = vm.nullcheck(temps.suhu);
				vm.form.nyerihilangbilalainnya.value = vm.nullcheck(temps.nyeri_hilang_bila_lainnya);
				vm.form.skalanyeri.value = vm.nullcheck(temps.skala_nyeri);
				vm.form.lokasinyeri.value = vm.nullcheck(temps.lokasi_nyeri);
				vm.form.durasinyeri.value = vm.nullcheck(temps.durasi_nyeri);
				vm.form.karakteristiknyeri.value = vm.nullcheck(temps.karakteristik_nyeri);
				vm.form.keterangannyeri.value = vm.nullcheck(temps.keterangan_nyeri);
				vm.form.penyakitpernahdideritalainnya.value = vm.nullcheck(temps.penyakit_pernah_diderita_lainnya);
				vm.form.pernahdioperasilainnya.value = vm.nullcheck(temps.pernah_dioperasi_lainnya);
				//vm.form.ocularsinistrakacamatalamasph.value = vm.nullcheck(temps.ocular_sinistra_kacamata_lama_sph);
				vm.form.riwayatalergimakananlainnya.value = vm.nullcheck(temps.riwayat_alergi_makanan_lainnya);
				vm.form.riwayatalergiobatanlainnya.value = vm.nullcheck(temps.riwayat_alergi_obatan_lainnya);
				vm.form.obatdigunakansaatinilainnya.value = vm.nullcheck(temps.obat_digunakan_saat_ini_lainnya);
				if (temps.edukasi_pasien) {
					if (temps.edukasi_pasien.ph_bahasa == 'ada') { vm.ph_bahasa = true; }
					if (temps.edukasi_pasien.ph_pendengaran == 'ada') { vm.ph_pendengaran = true; }
					if (temps.edukasi_pasien.ph_masalah_penglihatan == 'ada') { vm.ph_masalah_penglihatan = true; }
					if (temps.edukasi_pasien.ph_bicara_buruk == 'ada') { vm.ph_bicara_buruk = true; }
					if (temps.edukasi_pasien.ph_hilang_memori == 'ada') { vm.ph_hilang_memori = true; }
					if (temps.edukasi_pasien.ph_tidak_ada_partisipasi == 'ada') { vm.ph_tidak_ada_partisipasi = true; }
					if (temps.edukasi_pasien.ph_tidak_mampu_belajar == 'ada') { vm.ph_tidak_mampu_belajar = true; }
					if (temps.edukasi_pasien.ph_tidak_ada_hambatan_belajar == 'ada') { vm.ph_tidak_ada_hambatan_belajar = true; }
					if (temps.edukasi_pasien.ph_cemas == 'ada') { vm.ph_cemas = true; }
					if (temps.edukasi_pasien.ph_emosi == 'ada') { vm.ph_emosi = true; }
					if (temps.edukasi_pasien.ph_kognitif == 'ada') { vm.ph_kognitif = true; }
					if (temps.edukasi_pasien.ph_motivasi == 'ada') { vm.ph_motivasi = true; }
					if (temps.edukasi_pasien.edukasi_tata_tertib == 'ada') { vm.edukasi_tata_tertib = true; }
					if (temps.edukasi_pasien.edukasi_hak_dan_kewajiban == 'ada') { vm.edukasi_hak_dan_kewajiban = true; }
					if (temps.edukasi_pasien.metode_audio == 'ada') { vm.metode_audio = true; }
					if (temps.edukasi_pasien.metode_demonstrasi == 'ada') { vm.metode_demonstrasi = true; }
					if (temps.edukasi_pasien.metode_lisan == 'ada') { vm.metode_lisan = true; }
					if (temps.edukasi_pasien.metode_tulisan == 'ada') { vm.metode_tulisan = true; }
					if (temps.edukasi_pasien.metode_visual == 'ada') { vm.metode_visual = true; }
					if (temps.edukasi_pasien.pb_normal == 'ada') { vm.pb_normal = true; }
					if (temps.edukasi_pasien.pb_gangguan == 'ada') { vm.pb_gangguan = true; }
					if (temps.edukasi_pasien.bs_indonesia == 'ada') { vm.bs_indonesia = true; }
					if (temps.edukasi_pasien.bs_daerah == 'ada') { vm.bs_daerah = true; }
					if (temps.edukasi_pasien.bs_inggris == 'ada') { vm.bs_inggris = true; }
					if (temps.edukasi_pasien.bi_tidak == 'ada') { vm.bi_tidak = true; }
					if (temps.edukasi_pasien.bi_iya == 'ada') { vm.bi_iya = true; }
					if (temps.edukasi_pasien.tp_tk == 'ada') { vm.tp_tk = true; }
					if (temps.edukasi_pasien.tp_sd == 'ada') { vm.tp_sd = true; }
					if (temps.edukasi_pasien.tp_smp == 'ada') { vm.tp_smp = true; }
					if (temps.edukasi_pasien.tp_sma == 'ada') { vm.tp_sma = true; }
					if (temps.edukasi_pasien.tp_diploma == 'ada') { vm.tp_diploma = true; }
					if (temps.edukasi_pasien.tp_sarjana == 'ada') { vm.tp_sarjana = true; }
					if (temps.edukasi_pasien.tp_lainnya == 'ada') { vm.tp_lainnya = true; }
					if (temps.edukasi_pasien.ag_islam == 'ada') { vm.ag_islam = true; }
					if (temps.edukasi_pasien.ag_protestan == 'ada') { vm.ag_protestan = true; }
					if (temps.edukasi_pasien.ag_katolik == 'ada') { vm.ag_katolik = true; }
					if (temps.edukasi_pasien.ag_hindu == 'ada') { vm.ag_hindu = true; }
					if (temps.edukasi_pasien.ag_budha == 'ada') { vm.ag_budha = true; }
					if (temps.edukasi_pasien.ag_lainnya == 'ada') { vm.ag_lainnya = true; }
					if (temps.edukasi_pasien.tp_paham == 'ada') { vm.tp_paham = true; }
					if (temps.edukasi_pasien.tp_kurang_paham == 'ada') { vm.tp_kurang_paham = true; }
					if (temps.edukasi_pasien.tp_tidak == 'ada') { vm.tp_tidak = true; }
					if (temps.edukasi_pasien.np_modern == 'ada') { vm.np_modern = true; }
					if (temps.edukasi_pasien.np_moderat == 'ada') { vm.np_moderat = true; }
					if (temps.edukasi_pasien.np_konvensional == 'ada') { vm.np_konvensional = true; }
					if (temps.edukasi_pasien.rokok_ya == 'ada') { vm.rokok_ya = true; }
					if (temps.edukasi_pasien.rokok_tidak == 'ada') { vm.rokok_tidak = true; }
					if (temps.edukasi_pasien.alkohol_ya == 'ada') { vm.alkohol_ya = true; }
					if (temps.edukasi_pasien.alkohol_tidak == 'ada') { vm.alkohol_tidak = true; }
					if (temps.edukasi_pasien.kmi_ya == 'ada') { vm.kmi_ya = true; }
					if (temps.edukasi_pasien.kmi_tidak == 'ada') { vm.kmi_tidak = true; }
					if (temps.edukasi_pasien.rpk_proses_penyakit == 'ada') { vm.rpk_proses_penyakit = true; }
					if (temps.edukasi_pasien.rpk_pengobatan == 'ada') { vm.rpk_pengobatan = true; }
					if (temps.edukasi_pasien.rpk_nutrisi == 'ada') { vm.rpk_nutrisi = true; }
					if (temps.edukasi_pasien.rpk_edukasi == 'ada') { vm.rpk_edukasi = true; }
					if (temps.edukasi_pasien.rpk_lain_lain == 'ada') { vm.rpk_lain_lain = true; }
					if (temps.edukasi_pasien.kp_ya == 'ada') { vm.kp_ya = true; }
					if (temps.edukasi_pasien.kp_tidak == 'ada') { vm.kp_tidak = true; }
				}



				if (vm.nullcheck(temps.kasus_urgent) == '') {
					vm.form.select.kasusurgent.value = '';
					vm.form.select.kasusurgent.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.kasusurgent.value = vm.nullcheck(temps.kasus_urgent);
					vm.form.select.kasusurgent.label = vm.nullcheck(temps.kasus_urgent);
				}



				if (vm.nullcheck(temps.status_psikologi) == '') {
					vm.form.select.statuspsikologis.value = '';
					vm.form.select.statuspsikologis.value = 'Silahkan Pilih';
				}
				else {
					vm.form.select.statuspsikologis.value = vm.nullcheck(temps.status_psikologi);
					vm.form.select.statuspsikologis.label = vm.nullcheck(temps.status_psikologi);
				}


				if (vm.nullcheck(temps.status_fungsional) == '') {
					vm.form.select.statusfungsional.value = '';
					vm.form.select.statusfungsional.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.statusfungsional.value = vm.nullcheck(temps.status_fungsional);
					vm.form.select.statusfungsional.label = vm.nullcheck(temps.status_fungsional);
				}


				if (vm.nullcheck(temps.nyeri) == '') {
					vm.form.select.nyeri.value = '';
					vm.form.select.nyeri.value = 'Silahkan Pilih';
				}
				else {
					vm.form.select.nyeri.value = vm.nullcheck(temps.nyeri);
					vm.form.select.nyeri.label = vm.nullcheck(temps.nyeri);
				}

				if (vm.nullcheck(temps.nyeri_hilang_bila) == '') {
					vm.form.select.nyerihilangbila.value = '';
					vm.form.select.nyerihilangbila.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.nyerihilangbila.value = vm.nullcheck(temps.nyeri_hilang_bila);
					vm.form.select.nyerihilangbila.label = vm.nullcheck(temps.nyeri_hilang_bila);
				}

				if (vm.nullcheck(temps.penyakit_pernah_diderita) == '') {
					vm.form.select.penyakitpernahdiderita.value = '';
					vm.form.select.penyakitpernahdiderita.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.penyakitpernahdiderita.value = vm.nullcheck(temps.penyakit_pernah_diderita);
					vm.form.select.penyakitpernahdiderita.label = vm.nullcheck(temps.penyakit_pernah_diderita);
				}

				if (vm.nullcheck(temps.pernah_dioperasi) == '') {
					vm.form.select.pernahdioperasi.value = '';
					vm.form.select.pernahdioperasi.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.pernahdioperasi.value = vm.nullcheck(temps.pernah_dioperasi);
					vm.form.select.pernahdioperasi.label = vm.nullcheck(temps.pernah_dioperasi);
				}

				if (vm.nullcheck(temps.riwayat_alergi_makanan) == '') {
					vm.form.select.riwayatalergimakanan.value = '';
					vm.form.select.riwayatalergimakanan.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.riwayatalergimakanan.value = vm.nullcheck(temps.riwayat_alergi_makanan);
					vm.form.select.riwayatalergimakanan.label = vm.nullcheck(temps.riwayat_alergi_makanan);
				}

				if (vm.nullcheck(temps.riwayat_alergi_obatan) == '') {
					vm.form.select.riwayatalergiobatan.value = '';
					vm.form.select.riwayatalergiobatan.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.riwayatalergiobatan.value = vm.nullcheck(temps.riwayat_alergi_obatan);
					vm.form.select.riwayatalergiobatan.label = vm.nullcheck(temps.riwayat_alergi_obatan);
				}

				if (vm.nullcheck(temps.obat_digunakan_saat_ini) == '') {
					vm.form.select.obatdigunakansaatini.value = '';
					vm.form.select.obatdigunakansaatini.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.obatdigunakansaatini.value = vm.nullcheck(temps.obat_digunakan_saat_ini);
					vm.form.select.obatdigunakansaatini.label = vm.nullcheck(temps.obat_digunakan_saat_ini);
				}

				if (vm.nullcheck(temps.penilaian_resiko_jatuh) == '') {
					vm.form.select.penilaianresikojatuh.value = '';
					vm.form.select.penilaianresikojatuh.label = 'Silahkan Pilih';
				}
				else {
					vm.form.select.penilaianresikojatuh.value = vm.nullcheck(temps.penilaian_resiko_jatuh);
					vm.form.select.penilaianresikojatuh.label = vm.nullcheck(temps.penilaian_resiko_jatuh);
				}

			}
			else {
				vm.form.uuid = '';
			}
			console.log(vm.form.uuid)

			vm.loaderprocess();
		},

		parsingForm: function () {
			vm.ph_bahasa ? vm.form.ph_bahasa = 'ada' : vm.form.ph_bahasa = 'tidak';
			vm.ph_pendengaran ? vm.form.ph_pendengaran = 'ada' : vm.form.ph_pendengaran = 'tidak';
			vm.ph_masalah_penglihatan ? vm.form.ph_masalah_penglihatan = 'ada' : vm.form.ph_masalah_penglihatan = 'tidak';
			vm.ph_bicara_buruk ? vm.form.ph_bicara_buruk = 'ada' : vm.form.ph_bicara_buruk = 'tidak';
			vm.ph_hilang_memori ? vm.form.ph_hilang_memori = 'ada' : vm.form.ph_hilang_memori = 'tidak';
			vm.ph_tidak_ada_partisipasi ? vm.form.ph_tidak_ada_partisipasi = 'ada' : vm.form.ph_tidak_ada_partisipasi = 'tidak';
			vm.ph_tidak_mampu_belajar ? vm.form.ph_tidak_mampu_belajar = 'ada' : vm.form.ph_tidak_mampu_belajar = 'tidak';
			vm.ph_tidak_ada_hambatan_belajar ? vm.form.ph_tidak_ada_hambatan_belajar = 'ada' : vm.form.ph_tidak_ada_hambatan_belajar = 'tidak';
			vm.ph_cemas ? vm.form.ph_cemas = 'ada' : vm.form.ph_cemas = 'tidak';
			vm.ph_emosi ? vm.form.ph_emosi = 'ada' : vm.form.ph_emosi = 'tidak';
			vm.ph_kognitif ? vm.form.ph_kognitif = 'ada' : vm.form.ph_kognitif = 'tidak';
			vm.ph_motivasi ? vm.form.ph_motivasi = 'ada' : vm.form.ph_motivasi = 'tidak';
			vm.edukasi_tata_tertib ? vm.form.edukasi_tata_tertib = 'ada' : vm.form.edukasi_tata_tertib = 'tidak';
			vm.edukasi_hak_dan_kewajiban ? vm.form.edukasi_hak_dan_kewajiban = 'ada' : vm.form.edukasi_hak_dan_kewajiban = 'tidak';
			vm.metode_audio ? vm.form.metode_audio = 'ada' : vm.form.metode_audio = 'tidak';
			vm.metode_demonstrasi ? vm.form.metode_demonstrasi = 'ada' : vm.form.metode_demonstrasi = 'tidak';
			vm.metode_lisan ? vm.form.metode_lisan = 'ada' : vm.form.metode_lisan = 'tidak';
			vm.metode_tulisan ? vm.form.metode_tulisan = 'ada' : vm.form.metode_tulisan = 'tidak';
			vm.metode_visual ? vm.form.metode_visual = 'ada' : vm.form.metode_visual = 'tidak';
			vm.pb_normal ? vm.form.pb_normal = 'ada' : vm.form.pb_normal = 'tidak';
			vm.pb_gangguan ? vm.form.pb_gangguan = 'ada' : vm.form.pb_gangguan = 'tidak';
			vm.bs_indonesia ? vm.form.bs_indonesia = 'ada' : vm.form.bs_indonesia = 'tidak';
			vm.bs_daerah ? vm.form.bs_daerah = 'ada' : vm.form.bs_daerah = 'tidak';
			vm.bs_inggris ? vm.form.bs_inggris = 'ada' : vm.form.bs_inggris = 'tidak';
			vm.bi_tidak ? vm.form.bi_tidak = 'ada' : vm.form.bi_tidak = 'tidak';
			vm.bi_iya ? vm.form.bi_iya = 'ada' : vm.form.bi_iya = 'tidak';
			vm.tp_tk ? vm.form.tp_tk = 'ada' : vm.form.tp_tk = 'tidak';
			vm.tp_sd ? vm.form.tp_sd = 'ada' : vm.form.tp_sd = 'tidak';
			vm.tp_smp ? vm.form.tp_smp = 'ada' : vm.form.tp_smp = 'tidak';
			vm.tp_sma ? vm.form.tp_sma = 'ada' : vm.form.tp_sma = 'tidak';
			vm.tp_diploma ? vm.form.tp_diploma = 'ada' : vm.form.tp_diploma = 'tidak';
			vm.tp_sarjana ? vm.form.tp_sarjana = 'ada' : vm.form.tp_sarjana = 'tidak';
			vm.tp_lainnya ? vm.form.tp_lainnya = 'ada' : vm.form.tp_lainnya = 'tidak';
			vm.ag_islam ? vm.form.ag_islam = 'ada' : vm.form.ag_islam = 'tidak';
			vm.ag_protestan ? vm.form.ag_protestan = 'ada' : vm.form.ag_protestan = 'tidak';
			vm.ag_katolik ? vm.form.ag_katolik = 'ada' : vm.form.ag_katolik = 'tidak';
			vm.ag_hindu ? vm.form.ag_hindu = 'ada' : vm.form.ag_hindu = 'tidak';
			vm.ag_budha ? vm.form.ag_budha = 'ada' : vm.form.ag_budha = 'tidak';
			vm.ag_lainnya ? vm.form.ag_lainnya = 'ada' : vm.form.ag_lainnya = 'tidak';
			vm.tp_paham ? vm.form.tp_paham = 'ada' : vm.form.tp_paham = 'tidak';
			vm.tp_kurang_paham ? vm.form.tp_kurang_paham = 'ada' : vm.form.tp_kurang_paham = 'tidak';
			vm.tp_tidak ? vm.form.tp_tidak = 'ada' : vm.form.tp_tidak = 'tidak';
			vm.np_modern ? vm.form.np_modern = 'ada' : vm.form.np_modern = 'tidak';
			vm.np_moderat ? vm.form.np_moderat = 'ada' : vm.form.np_moderat = 'tidak';
			vm.np_konvensional ? vm.form.np_konvensional = 'ada' : vm.form.np_konvensional = 'tidak';
			vm.rokok_ya ? vm.form.rokok_ya = 'ada' : vm.form.rokok_ya = 'tidak';
			vm.rokok_tidak ? vm.form.rokok_tidak = 'ada' : vm.form.rokok_tidak = 'tidak';
			vm.alkohol_ya ? vm.form.alkohol_ya = 'ada' : vm.form.alkohol_ya = 'tidak';
			vm.alkohol_tidak ? vm.form.alkohol_tidak = 'ada' : vm.form.alkohol_tidak = 'tidak';
			vm.kmi_ya ? vm.form.kmi_ya = 'ada' : vm.form.kmi_ya = 'tidak';
			vm.kmi_tidak ? vm.form.kmi_tidak = 'ada' : vm.form.kmi_tidak = 'tidak';
			vm.rpk_proses_penyakit ? vm.form.rpk_proses_penyakit = 'ada' : vm.form.rpk_proses_penyakit = 'tidak';
			vm.rpk_pengobatan ? vm.form.rpk_pengobatan = 'ada' : vm.form.rpk_pengobatan = 'tidak';
			vm.rpk_nutrisi ? vm.form.rpk_nutrisi = 'ada' : vm.form.rpk_nutrisi = 'tidak';
			vm.rpk_edukasi ? vm.form.rpk_edukasi = 'ada' : vm.form.rpk_edukasi = 'tidak';
			vm.rpk_lain_lain ? vm.form.rpk_lain_lain = 'ada' : vm.form.rpk_lain_lain = 'tidak';
			vm.kp_ya ? vm.form.kp_ya = 'ada' : vm.form.kp_ya = 'tidak';
			vm.kp_tidak ? vm.form.kp_tidak = 'ada' : vm.form.kp_tidak = 'tidak';


			console.log('awww', vm.form.kp_tidak);
			vm.$emit('parsingForm', vm.parsekelurahan(vm.form, vm.detailperawat), vm.keyform);
		},

		dialog: function () {
			let text = '', button = '';
			if (vm.form.posisi == 'adddataperawat') {
				text = 'Yakin ingin menambah data pada halaman ini.';
				button = 'Ya, tambah data';
			}
			else {
				text = 'Yakin ingin memperbaharui data ini.';
				button = 'Ya, perbaharui data';
			}
			vm.$emit('dialog', text, button, 'formdetailperawat');
		},
	}
}
</script>