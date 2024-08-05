export const parsekelurahan = (form, detail) => {
	console.log(detail)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.pengguna_uuid);
	data.append('nama_dokter', detail.nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);
	
	data.append('ruang_poliklinik', form.select.klinik.value);

	data.append('penetesan_obat', form.penetesanobat.value);
	data.append('keluhan_utama', form.keluhanutama.value);
	data.append('nama_pemeriksa', form.nama_pemeriksa.value);
	data.append('riwayat_penyakit', form.riwayatpenyakit.value);
	data.append('kasus_urgent', form.select.kasusurgent.value);
	data.append('kasus_urgent_lainnya', form.kasusurgentlainnya.value);
	data.append('status_psikologis', form.select.statuspsikologis.value);
	data.append('status_fungsional', form.select.statusfungsional.value);
	data.append('tekanan_darah', form.tekanandarah.value);
	data.append('nadi', form.nadi.value);
	data.append('respiratory_rate', form.respiratoryrate.value);
	data.append('suhu', form.suhu.value);
	data.append('berat_badan', form.beratbadan.value);
	data.append('tinggi_badan', form.tinggibadan.value);

	data.append('nyeri', form.select.nyeri.value);
	data.append('nyeri_hilang_bila', form.select.nyerihilangbila.value);
	data.append('nyeri_hilang_bila_lainnya', form.nyerihilangbilalainnya.value);
	data.append('skala_nyeri', form.skalanyeri.value);
	data.append('lokasi_nyeri', form.lokasinyeri.value);
	data.append('durasi_nyeri', form.durasinyeri.value);
	data.append('karakteristik_nyeri', form.karakteristiknyeri.value);
	data.append('keterangan_nyeri', form.keterangannyeri.value);

	data.append('penyakit_pernah_diderita',form.select.penyakitpernahdiderita.value);
	data.append('penyakit_pernah_diderita_lainnya', form.penyakitpernahdideritalainnya.value);
	data.append('pernah_dioperasi', form.select.pernahdioperasi.value);
	data.append('pernah_dioperasi_lainnya', form.pernahdioperasilainnya.value);
	data.append('riwayat_alergi_makanan', form.select.riwayatalergimakanan.value);
	data.append('riwayat_alergi_makanan_lainnya', form.riwayatalergimakananlainnya.value);
	data.append('riwayat_alergi_obatan', form.select.riwayatalergiobatan.value);
	data.append('riwayat_alergi_obatan_lainnya', form.riwayatalergiobatanlainnya.value);
	data.append('obat_digunakan_saat_ini', form.select.obatdigunakansaatini.value);
	data.append('obat_digunakan_saat_ini_lainnya', form.obatdigunakansaatinilainnya.value);
	data.append('penilaian_resiko_jatuh', form.select.penilaianresikojatuh.value);

	data.append('ocular_dextra_autoref', form.oculardextraautoref.value);
	data.append('ocular_dextra_pd', form.oculardextrapd.value);
	data.append('ocular_dextra_keratometri_k1', form.oculardextrakeratometrik1.value);
	data.append('ocular_dextra_keratometri_k2', form.oculardextrakeratometrik2.value);
	data.append('ocular_dextra_tonometri', form.oculardextratonometri.value);
	data.append('ocular_dextra_visus', form.oculardextravisus.value);
	data.append('ocular_dextra_add', form.oculardextraadd.value);
	data.append('ocular_dextra_bcva1', form.oculardextrabcva1.value);
	data.append('ocular_dextra_bcva2', form.oculardextrabcva2.value);
	data.append('ocular_dextra_kacamata_lama_sph', form.oculardextrakacamatalamasph.value);
	data.append('ocular_dextra_kacamata_lama_cyl', form.oculardextrakacamatalamacyl.value);
	data.append('ocular_dextra_kacamata_lama_addisi', form.oculardextrakacamatalamaaddisi.value);

	data.append('ocular_sinistra_autoref', form.ocularsinistraautoref.value);
	data.append('ocular_sinistra_ro', form.ocularsinistraro.value);
	data.append('ocular_sinistra_keratometri_k1', form.ocularsinistrakeratometrik1.value);
	data.append('ocular_sinistra_keratometri_k2', form.ocularsinistrakeratometrik2.value);
	data.append('ocular_sinistra_tonometri', form.ocularsinistratonometri.value);
	data.append('ocular_sinistra_visus', form.ocularsinistravisus.value);
	data.append('ocular_sinistra_add', form.ocularsinistraadd.value);
	data.append('ocular_sinistra_bcva1', form.ocularsinistrabcva1.value);
	data.append('ocular_sinistra_bcva2', form.ocularsinistrabcva2.value);
	data.append('ocular_sinistra_kacamata_lama_sph', form.ocularsinistrakacamatalamasph.value);
	data.append('ocular_sinistra_kacamata_lama_cyl', form.ocularsinistrakacamatalamacyl.value);
	data.append('ocular_sinistra_kacamata_lama_addisi', form.ocularsinistrakacamatalamaaddisi.value);


	data.append('bs_lainnya', form.bs_lainnya.value);
	data.append('rpk_jelaskan', form.rpk_jelaskan.value);
	data.append('kmi_alasan', form.kmi_alasan.value);
	data.append('ph_bahasa', form.ph_bahasa);
	data.append('ph_pendengaran', form.ph_pendengaran);
	data.append('ph_masalah_penglihatan', form.ph_masalah_penglihatan);
	data.append('ph_bicara_buruk', form.ph_bicara_buruk);
	data.append('ph_hilang_memori', form.ph_hilang_memori);
	data.append('ph_tidak_ada_partisipasi', form.ph_tidak_ada_partisipasi);
	data.append('ph_tidak_mampu_belajar', form.ph_tidak_mampu_belajar);
	data.append('ph_tidak_ada_hambatan_belajar', form.ph_tidak_ada_hambatan_belajar);
	data.append('ph_cemas', form.ph_cemas);
	data.append('ph_emosi', form.ph_emosi);
	data.append('ph_kognitif', form.ph_kognitif);
	data.append('ph_motivasi', form.ph_motivasi);
	data.append('edukasi_tata_tertib', form.edukasi_tata_tertib);
	data.append('edukasi_hak_dan_kewajiban', form.edukasi_hak_dan_kewajiban);
	data.append('metode_audio', form.metode_audio);
	data.append('metode_demonstrasi', form.metode_demonstrasi);
	data.append('metode_lisan', form.metode_lisan);
	data.append('metode_tulisan', form.metode_tulisan);
	data.append('metode_visual', form.metode_visual);
	data.append('pb_normal', form.pb_normal);
	data.append('pb_gangguan', form.pb_gangguan);
	data.append('bs_indonesia', form.bs_indonesia);
	data.append('bs_daerah', form.bs_daerah);
	data.append('bs_inggris', form.bs_inggris);
	data.append('bi_tidak', form.bi_tidak);
	data.append('bi_iya', form.bi_iya);
	data.append('tp_tk', form.tp_tk);
	data.append('tp_sd', form.tp_sd);
	data.append('tp_smp', form.tp_smp);
	data.append('tp_sma', form.tp_sma);
	data.append('tp_diploma', form.tp_diploma);
	data.append('tp_sarjana', form.tp_sarjana);
	data.append('tp_lainnya', form.tp_lainnya);
	data.append('ag_islam', form.ag_islam);
	data.append('ag_protestan', form.ag_protestan);
	data.append('ag_katolik', form.ag_katolik);
	data.append('ag_hindu', form.ag_hindu);
	data.append('ag_budha', form.ag_budha);
	data.append('ag_lainnya', form.ag_lainnya);
	data.append('tp_paham', form.tp_paham);
	data.append('tp_kurang_paham', form.tp_kurang_paham);
	data.append('tp_tidak', form.tp_tidak);
	data.append('np_modern', form.np_modern);
	data.append('np_moderat', form.np_moderat);
	data.append('np_konvensional', form.np_konvensional);
	data.append('rokok_ya', form.rokok_ya);
	data.append('rokok_tidak', form.rokok_tidak);
	data.append('alkohol_ya', form.alkohol_ya);
	data.append('alkohol_tidak', form.alkohol_tidak);
	data.append('kmi_ya', form.kmi_ya);
	data.append('kmi_tidak', form.kmi_tidak);
	data.append('rpk_proses_penyakit', form.rpk_proses_penyakit);
	data.append('rpk_pengobatan', form.rpk_pengobatan);
	data.append('rpk_nutrisi', form.rpk_nutrisi);
	data.append('rpk_edukasi', form.rpk_edukasi);
	data.append('rpk_lain_lain', form.rpk_lain_lain);
	data.append('kp_ya', form.kp_ya);
	data.append('kp_tidak', form.kp_tidak);

	data.append('subject', form.subject);
	data.append('object', form.object);
	data.append('assessment', form.assessment);
	data.append('plan', form.plan);
	data.append('ttd', form.ttd);
	

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}