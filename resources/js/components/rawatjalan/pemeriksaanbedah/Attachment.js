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
	
	data.append('ruang_poliklinik', 0);

	data.append('penetesan_obat', form.keluhanutama.value);
	data.append('keluhan_utama', form.penetesanobat.value);
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

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}