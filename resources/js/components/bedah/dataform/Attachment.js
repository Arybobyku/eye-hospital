export const parselaporanpembedahan = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('bedah_uuid', form.bedah_uuid);
	data.append('ruang_operasi', form.ruangoperasi.value);
	data.append('akut_terencana', form.akutterencana.value);
	data.append('kamar', form.kamar.value);
	data.append('tanggal', form.tanggal.value);
	data.append('pembedahan', form.pembedahan.value);
	data.append('ahli_anastesi', form.ahlianastesi.value);
	data.append('asisten_1', form.asisten1.value);
	data.append('asisten_2', form.asisten2.value);
	data.append('perawat_instrument', form.perawatinstrument.value);
	
	data.append('ja_umum', form.ja_umum);
	data.append('ja_bsp', form.ja_bsp);
	data.append('ja_csp', form.ja_csp);
	data.append('ja_spiral', form.ja_spiral);
	data.append('ja_epidural', form.ja_epidural);
	data.append('ja_lokal', form.ja_lokal);

	data.append('diagnosa_pra_bedah', form.diagnosaprabedah.value);
	data.append('diagnosa_pasca_bedah', form.diagnosapascabedah.value);
	data.append('indikasi_operasi', form.indikasioperasi.value);
	data.append('jenis_operasi', form.jenisoperasi.value);
	data.append('desinfeksi_kulit_dengan', form.desinfeksikulitdengan.value);
	data.append('posisi_penderita_desinfeksi', form.posisipenderitadesinfeksi.value);
	data.append('jam_operasi_dimulai', form.jamoperasidimulai.value);
	data.append('jam_operasi_selesai', form.jamoperasiselesai.value);
	data.append('lama_operasi_berlansung', form.lamaoperasiberlansung.value);
	data.append('jenis_bahan_yang_dikirim_ke_laboratorium', form.jenisbahanyangdikirimkelaboratorium.value);
	data.append('macam_sayatan', form.macamsayatan.value);
	data.append('posisi_sayatan', form.posisisayatan.value);
	data.append('teknik_operasi_dan_temuan_intra', form.teknikoperasidantemuanintra.value);
	data.append('penggunaan_amhp_khusus', form.penggunaanamhpkhusus);
	data.append('jenis_dan_jumlah_amhp_khusus', form.jenisdanjumlahamhpkhusus.value);
	data.append('komplikasi_intra_operasi', form.komplikasiintraoperasi);
	data.append('penjabaran_komplikasi_intra_operasi', form.penjabarankomplikasiintraoperasi.value);
	data.append('perdarahan', form.perdarahan.value);
	data.append('instruksi_anastesi', form.instruksianastesi.value);
	data.append('ipb_kontrol', form.ipbkontrol.value);
	data.append('ipb_puasa', form.ipbpuasa.value);
	data.append('ipb_drain', form.ipbdrain.value);
	data.append('ipb_inpus', form.ipbinpus.value);
	data.append('ipb_obat_obatan', form.ipbobatobatan.value);
	data.append('ipb_ganti_balut', form.ipbgantibalut.value);
	data.append('ipb_lainnya', form.ipblainnya.value);
	data.append('operator_bedah', form.operatorbedah.value);
	return data;
}

export const parsechecklistkesiapanbedah = (form, listrik, alat, linensteril, akhp) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('bedah_uuid', form.bedah_uuid);

	data.append('ruangan', form.ruangan.value);
	data.append('kamar', form.kamar.value);
	data.append('diagnosa', form.diagnosa.value);
	data.append('tindakan', form.tindakan.value);
	data.append('teknik_anastesi', form.teknikanastesi.value);
	data.append('tanggal_tindakan', form.tanggaltindakan.value);
	data.append('perawat_kamar_bedah', form.perawatkamarbedah.value);
	data.append('kepala_ruangan', form.kepalaruangan.value);

	data.append('listrik', listrik);
	data.append('alat', alat);
	data.append('linen_steril', linensteril);
	data.append('akhp', akhp);

	return data;
}

export const parseperawatanperioperative = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('bedah_uuid', form.bedah_uuid);

	data.append('tanggal', form.tanggal.value);
	data.append('jam', form.jam.value);
	data.append('ruangan', form.ruangan.value);
	data.append('dokter_operator', form.dokteroperator.value);
	data.append('dokter_anastesi', form.dokteranastesi.value);
	data.append('diagnosis', form.diagnosis.value);
	data.append('tindakan_operasi', form.tindakanoperasi.value);
	data.append('hasil_kgd', form.hasilkgd.value);
	data.append('waktu_pengambilan_kgd', form.waktupengambilankgd.value);
	data.append('vs_temp', form.vstemp.value);
	data.append('vs_nadi', form.vsnadi.value);
	data.append('vs_pernapasan', form.vspernapasan.value);
	data.append('vs_tekanan_darah', form.vstekanandarah.value);
	data.append('vs_tinggi', form.vstinggi.value);
	data.append('vs_berat', form.vsberat.value);
	data.append('riwayat_penyakit', form.riwayatpenyakit.value);
	data.append('alergi_obatan', form.alergiobatan.value);
	data.append('alergi_makanan', form.alergimakanan.value);
	data.append('pemeriksaan_identitas_pasien_ket', form.pemeriksaanidentitaspasienket.value);
	data.append('pemeriksaan_gelang_nama_ket', form.pemeriksaangelangnamaket.value);
	data.append('formulir_persetujuan_operasi_ket', form.formulirpersetujuanoperasiket.value);
	data.append('pemberian_premedikasi_ket', form.pemberianpremedikasiket.value);
	data.append('pemberian_makan_minum_last_ket', form.pemberianmakanminumlastket.value);
	data.append('alat_protesa_luar_ket', form.alatprotesaluarket.value);
	data.append('alat_perhiasan_ket', form.alatperhiasanket.value);
	data.append('status_pasien_terlampir_ket', form.statuspasienterlampirket.value);
	data.append('xray_scan_ket', form.xrayscanket.value);
	data.append('pencukuran_bulu_mata_ket', form.pencukuranbulumataket.value);
	data.append('pemeriksaan_darah_ket', form.pemeriksaandarahket.value);
	data.append('site_marker_ket', form.sitemarkerket.value);
	data.append('perawat_ruangan', form.perawatruangan.value);
	data.append('perawat_kamar_bedah', form.perawatkamarbedah.value);

	data.append('r_pemeriksaan_identitas_pasien', form.r_pemeriksaan_identitas_pasien);
	data.append('r_pemeriksaan_gelang_nama', form.r_pemeriksaan_gelang_nama);
	data.append('r_formulir_persetujuan_operasi', form.r_formulir_persetujuan_operasi);
	data.append('r_pemberian_premedikasi', form.r_pemberian_premedikasi);
	data.append('r_pemberian_makan_minum_last', form.r_pemberian_makan_minum_last);
	data.append('r_alat_protesa_luar', form.r_alat_protesa_luar);
	data.append('r_alat_perhiasan', form.r_alat_perhiasan);
	data.append('r_status_pasien_terlampir', form.r_status_pasien_terlampir);
	data.append('r_xray_scan', form.r_xray_scan);
	data.append('r_pencukuran_bulu_mata', form.r_pencukuran_bulu_mata);
	data.append('r_pemeriksaan_darah', form.r_pemeriksaan_darah);
	data.append('r_site_marker', form.r_site_marker);
	data.append('ok1_pemeriksaan_identitas_pasien', form.ok1_pemeriksaan_identitas_pasien);
	data.append('ok1_pemeriksaan_gelang_nama', form.ok1_pemeriksaan_gelang_nama);
	data.append('ok1_formulir_persetujuan_operasi', form.ok1_formulir_persetujuan_operasi);
	data.append('ok1_pemberian_premedikasi', form.ok1_pemberian_premedikasi);
	data.append('ok1_pemberian_makan_minum_last', form.ok1_pemberian_makan_minum_last);
	data.append('ok1_alat_protesa_luar', form.ok1_alat_protesa_luar);
	data.append('ok1_alat_perhiasan', form.ok1_alat_perhiasan);
	data.append('ok1_status_pasien_terlampir', form.ok1_status_pasien_terlampir);
	data.append('ok1_xray_scan', form.ok1_xray_scan);
	data.append('ok1_pencukuran_bulu_mata', form.ok1_pencukuran_bulu_mata);
	data.append('ok1_pemeriksaan_darah', form.ok1_pemeriksaan_darah);
	data.append('ok1_site_marker', form.ok1_site_marker);
	data.append('ok2_pemeriksaan_identitas_pasien', form.ok2_pemeriksaan_identitas_pasien);
	data.append('ok2_pemeriksaan_gelang_nama', form.ok2_pemeriksaan_gelang_nama);
	data.append('ok2_formulir_persetujuan_operasi', form.ok2_formulir_persetujuan_operasi);
	data.append('ok2_pemberian_premedikasi', form.ok2_pemberian_premedikasi);
	data.append('ok2_pemberian_makan_minum_last', form.ok2_pemberian_makan_minum_last);
	data.append('ok2_alat_protesa_luar', form.ok2_alat_protesa_luar);
	data.append('ok2_alat_perhiasan', form.ok2_alat_perhiasan);
	data.append('ok2_status_pasien_terlampir', form.ok2_status_pasien_terlampir);
	data.append('ok2_xray_scan', form.ok2_xray_scan);
	data.append('ok2_pencukuran_bulu_mata', form.ok2_pencukuran_bulu_mata);
	data.append('ok2_pemeriksaan_darah', form.ok2_pemeriksaan_darah);
	data.append('ok2_site_marker', form.ok2_site_marker);

	return data;
}

export const parsecatatanoperasikatarak = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('bedah_uuid', form.bedah_uuid);

	data.append('tanggal', form.tanggal.value);
	data.append('operasi_mulai', form.operasimulai.value);
	data.append('operasi_selesai', form.operasiselesai.value);
	data.append('dokter_bedah', form.dokterbedah.value);
	data.append('dokter_anastesi', form.dokteranastesi.value);
	data.append('tindakan_operasi', form.tindakanoperasi.value);
	data.append('perawat_scrub', form.perawatscrub.value);
	data.append('diagnosis_pra_bedah', form.diagnosisprabedah.value);
	data.append('diagnosis_pasca_bedah', form.diagnosispascabedah.value);
	data.append('catatan_tambahan', form.catatantambahan.value);
	data.append('operator', form.namaoperator.value);

	data.append('an_topical', form.an_topical);
	data.append('an_retrobulbar_peribulbar', form.an_retrobulbar_peribulbar);
	data.append('an_sub_conjunctival', form.an_sub_conjunctival);
	data.append('an_intracamelar', form.an_intracamelar);
	data.append('an_nu_bius_umum', form.an_nu_bius_umum);
	data.append('an_xylocain', form.an_xylocain);
	data.append('an_lidocain', form.an_lidocain);
	data.append('in_kornea', form.in_kornea);
	data.append('in_limbus', form.in_limbus);
	data.append('in_sclera', form.in_sclera);
	data.append('wt_main_port', form.wt_main_port);
	data.append('wt_two_side_port', form.wt_two_side_port);
	data.append('wt_one_side_port', form.wt_one_side_port);
	data.append('wt_keratome_2_koma_75_mm', form.wt_keratome_2_koma_75_mm);
	data.append('wt_crescen_knife', form.wt_crescen_knife);
	data.append('cs_ccc', form.cs_ccc);
	data.append('cs_x_mas_tree', form.cs_x_mas_tree);
	data.append('cs_linear', form.cs_linear);
	data.append('cs_can_opener', form.cs_can_opener);
	data.append('cs_tryphan_blue', form.cs_tryphan_blue);
	data.append('tb_ctr', form.tb_ctr);
	data.append('tb_kapsulotomi_posterior', form.tb_kapsulotomi_posterior);
	data.append('tb_vitrektomi_anterior', form.tb_vitrektomi_anterior);
	data.append('ci_rl', form.ci_rl);
	data.append('ci_bss', form.ci_bss);
	data.append('lio_dalam_kantung_kapsul', form.lio_dalam_kantung_kapsul);
	data.append('lio_bilik_mata_depan', form.lio_bilik_mata_depan);
	data.append('lio_sulcus_siliaris', form.lio_sulcus_siliaris);
	data.append('lio_diluar_kantong_kapsul', form.lio_diluar_kantong_kapsul);
	data.append('lio_afakia', form.lio_afakia);
	data.append('lio_fiksasi_scleral', form.lio_fiksasi_scleral);
	data.append('cv_hpmc', form.cv_hpmc);
	data.append('cv_viscoat', form.cv_viscoat);
	data.append('cv_hyaluronic_acid', form.cv_hyaluronic_acid);
	data.append('benang_tanpa_jahitan', form.benang_tanpa_jahitan);
	data.append('benang_ethylon_10_0', form.benang_ethylon_10_0);
	data.append('benang_vicryl_8_0', form.benang_vicryl_8_0);
	data.append('kompikasi_tidak_ada', form.kompikasi_tidak_ada);
	data.append('kompikasi_pcr', form.kompikasi_pcr);
	data.append('kompikasi_prolaps_vitreous', form.kompikasi_prolaps_vitreous);
	data.append('kompikasi_drop_nucleus', form.kompikasi_drop_nucleus);
	data.append('kompikasi_perdarahan', form.kompikasi_perdarahan);
	data.append('kompikasi_corneal_burn', form.kompikasi_corneal_burn);
	data.append('kompikasi_convert_to_ecce', form.kompikasi_convert_to_ecce);
	data.append('kompikasi_convert_to_icce', form.kompikasi_convert_to_icce);
	data.append('ppo_pulang_berobat_jalan', form.ppo_pulang_berobat_jalan);
	data.append('ppo_opname', form.ppo_opname);
	data.append('ipo_pdb2jpo', form.ipo_pdb2jpo);
	data.append('ipo_omdpspdb', form.ipo_omdpspdb);
	data.append('ipo_pdbddtksdto', form.ipo_pdbddtksdto);
	data.append('ipo_psdipo', form.ipo_psdipo);
	return data;
}

export const parsepersetujuantindakankedokteran = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('bedah_uuid', form.bedah_uuid);

	data.append('dokter_pelaksana_tindakan', form.dokterpelaksanatindakan.value);
	data.append('pemberi_informasi', form.pemberiinformasi.value);
	data.append('penerima_penolak_informasi', form.penerimapenolakinformasi.value);
	data.append('ji_diagnosis_wd_dd', form.jidiagnosiswddd.value);
	data.append('ji_dasar_diagnosis', form.jidasardiagnosis.value);
	data.append('ji_tindakan_kedokteran', form.jitindakankedokteran.value);
	data.append('ji_indikasi_tindakan', form.jiindikasitindakan.value);
	data.append('ji_tata_cara', form.jitatacara.value);
	data.append('ji_tujuan', form.jitujuan.value);
	data.append('ji_resiko', form.jiresiko.value);
	data.append('ji_komplikasi', form.jikomplikasi.value);
	data.append('ji_prognosis', form.jiprognosis.value);
	data.append('ji_alternatif_dan_resiko', form.jialternatifdanresiko.value);
	data.append('ji_lain_lain', form.jilainlain.value);
	data.append('ptk_nama_penerima', form.ptknamapenerima.value);
	data.append('ptk_tanggal_lahir_penerima', form.ptktanggallahirpenerima.value);
	data.append('ptk_alamat_penerima', form.ptkalamatpenerima.value);
	data.append('ptk_hubungan_penerima', form.ptkhubunganpenerima.value);
	data.append('ptk_tindakan', form.ptktindakan.value);
	data.append('ptk_terhadap', form.ptkterhadap.value);
	data.append('ptk_nama_target', form.ptknamatarget.value);
	data.append('ptk_tanggal_lahir_target', form.ptktanggallahirtarget.value);
	data.append('ptk_alamat_target', form.ptkalamattarget.value);
	data.append('tanggal', form.tanggal.value);
	data.append('pukul', form.pukul.value);
	data.append('nama_target', form.namatarget.value);
	data.append('nama_saksi', form.namasaksi.value);
	data.append('perawat', form.perawat.value);
	data.append('ptk_jenis_kelamin_target', form.select.ptkjeniskelamintarget.value);
	data.append('ptk_jenis_kelamin_penerima', form.select.ptkjeniskelaminpenerima.value);
	return data;
}

export const parsekeselamatanbedah = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('bedah_uuid', form.bedah_uuid);
	data.append('nama_operator', form.namaoperator.value);
	data.append('nama_ahli_anastesi', form.namaahlianastesi.value);
	data.append('diagnosis_medis', form.diagnosismedis.value);
	data.append('tindakan_operasi', form.tindakanoperasi.value);
	data.append('asisten_operasi', form.asistenoperasi.value);
	data.append('scrub_nurses', form.scrubnurses.value);
	data.append('si_bagian_1', form.sibagian1);
	data.append('si_bagian_2', form.sibagian2);
	data.append('si_bagian_3', form.sibagian3);
	data.append('si_bagian_4', form.sibagian4);
	data.append('si_bagian_5', form.sibagian5);
	data.append('si_bagian_6', form.sibagian6);
	data.append('si_bagian_7', form.sibagian7);
	data.append('si_nama', form.sinama.value);
	data.append('si_jam', form.sijam.value);
	data.append('so_jam', form.sojam.value);
	data.append('to_bagian_1', form.tobagian1);
	data.append('to_bagian_2_1', form.tobagian21);
	data.append('to_bagian_2_2', form.tobagian22);
	data.append('to_bagian_2_3', form.tobagian23.value);
	data.append('to_bagian_3', form.tobagian3.value);
	data.append('to_bagian_4_1', form.tobagian41);
	data.append('to_bagian_4_2', form.tobagian42);
	data.append('to_bagian_5', form.tobagian5);
	data.append('to_bagian_6', form.tobagian6);
	data.append('to_nama', form.tonama.value);
	data.append('to_jam', form.tojam.value);
	data.append('so_bagian_1', form.sobagian1);
	data.append('so_bagian_2', form.sobagian2);
	data.append('so_bagian_3', form.sobagian3);
	data.append('so_bagian_4', form.sobagian4);
	
	data.append('so_bagian_5', form.sobagian5);
	
	data.append('so_asisten_1', form.tobagian7);
	data.append('so_penata', form.tobagian8);
	return data;
}

