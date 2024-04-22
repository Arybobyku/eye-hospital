export const parsekelurahan = (form, detail, tindakan, tindakanjalan, obat, obatracikan) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.pengguna_uuid);
	data.append('nama_dokter', detail.nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);

	data.append('panjar', form.panjar.value);
	data.append('keterangan_panjar', form.keteranganpanjar.value);
	data.append('catatan', form.catatan.value);
	data.append('ispending', form.ispending);

	data.append('tindakan', JSON.stringify(tindakan));

	data.append('tindakanjalan', JSON.stringify(tindakanjalan));
	data.append('inapjalan', form.inapjalan);
	data.append('kamar_inap_jalan_uuid', form.kamar_inap_jalan_uuid);
	data.append('kamar_inap_jalan_nama', form.kamar_inap_jalan_nama);
	data.append('kamar_inap_jalan_lantai', form.kamar_inap_jalan_lantai);
	data.append('kamar_inap_jalan_jumlah_bed', form.kamar_inap_jalan_jumlah_bed);
	data.append('jenis_kamar_jalan_uuid', form.jenis_kamar_jalan_uuid);
	data.append('nama_jenis_jalan_kamar', form.nama_jenis_jalan_kamar);

	data.append('obat', JSON.stringify(obat));
	data.append('obatracikan', JSON.stringify(obatracikan));

	data.append('tanggal', form.penjadwalanodc.value);
	data.append('waktu', form.waktuodc.value);
	data.append('paket_uuid', form.select.paketbedah.value);
	data.append('nama_paket', form.select.paketbedah.label);
	data.append('carabayar_uuid_odc', form.select.carabayar.value);
	data.append('carabayar_nama_odc', form.select.carabayar.label);
	data.append('asuransi_uuid', form.select.asuransi.value);
	data.append('nama_asuransi', form.select.asuransi.label);
	data.append('harga_paket', form.hargapaket);
	data.append('keterangan', form.keteranganbedah.value);

	data.append('keterangan_inap', form.keteranganinap.value);
	data.append('tanggal_bedah', form.penjadwalanbedah.value);
	data.append('waktu_bedah', form.waktubedah.value);
	data.append('paket_uuid_bedah', form.select.paketbedahbedah.value);
	data.append('nama_paket_bedah', form.select.paketbedahbedah.label);
	data.append('carabayar_uuid_bedah', form.select.carabayarbedah.value);
	data.append('carabayar_nama_bedah', form.select.carabayarbedah.label);
	data.append('asuransi_uuid_bedah', form.select.asuransibedah.value);
	data.append('nama_asuransi_bedah', form.select.asuransibedah.label);
	data.append('harga_paket_bedah', form.hargabedahpaket);
	data.append('keterangan_bedah', form.keteranganbedahbedah.value);
	data.append('kamar_inap_uuid', form.kamar_inap_uuid);
	data.append('kamar_inap_nama', form.kamar_inap_nama);
	data.append('kamar_inap_lantai', form.kamar_inap_lantai);
	data.append('kamar_inap_jumlah_bed', form.kamar_inap_jumlah_bed);
	data.append('jenis_kamar_uuid', form.jenis_kamar_uuid);
	data.append('nama_jenis_kamar', form.nama_jenis_kamar);
	
	data.append('posisi_bola_mata', form.posisibolamata.value);
	data.append('pergerakan_bola_mata', form.pergerakanbolamata.value);

	data.append('ocular_dextra_palpebra', form.oculardextrapalpebra.value);
	data.append('ocular_dextra_conjunctiva', form.oculardextraconjunctiva.value);
	data.append('ocular_dextra_cornea', form.oculardextracornea.value);
	data.append('ocular_dextra_bilik_mata_depan', form.oculardextrabilikmatadepan.value);
	data.append('ocular_dextra_pupil_dan_iris', form.oculardextrapupildaniris.value);
	data.append('ocular_dextra_lensa', form.oculardextralensa.value);
	data.append('ocular_dextra_vitreous', form.oculardextravitreous.value);
	data.append('ocular_dextra_funduscopy', form.oculardextrafunduscopy.value);
	data.append('ocular_sinistra_palpebra', form.ocularsinistrapalpebra.value);
	data.append('ocular_sinistra_conjunctiva', form.ocularsinistraconjunctiva.value);
	data.append('ocular_sinistra_cornea', form.ocularsinistracornea.value);
	data.append('ocular_sinistra_bilik_mata_depan', form.ocularsinistrabilikmatadepan.value);
	data.append('ocular_sinistra_pupil_dan_iris', form.ocularsinistrapupildaniris.value);
	data.append('ocular_sinistra_lensa', form.ocularsinistralensa.value);
	data.append('ocular_sinistra_vitreous', form.ocularsinistravitreous.value);
	data.append('ocular_sinistra_funduscopy', form.ocularsinistrafunduscopy.value);

	data.append('pemeriksaan_penunjang', form.pemeriksaanpenunjang.value);
	data.append('pemeriksaan_diagnosa', form.select.icd10.label);
	data.append('pemeriksaan_diagnosa_kode', form.select.icd10.value);
	data.append('pemeriksaan_tindakan',form.select.icd9.label);
	data.append('pemeriksaan_tindakan_kode', form.select.icd9.value);
	data.append('pemeriksaan_tata_laksana', form.pemeriksaantatalaksana.value);
	data.append('pemeriksaan_prognosa', form.pemeriksaanprognosa.value);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsetransfertindakan = (form, detail, tindakan) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.transfer_pengguna_uuid);
	data.append('nama_dokter', detail.transfer_nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);

	data.append('tindakan', JSON.stringify(tindakan));

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsekontrol = (form) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('tanggal', form.tanggalkontrol.value);
	data.append('waktu', form.waktukontrol.value);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsetransfer = (form) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('nama_dokter', form.select.dokter.label);
	data.append('pengguna_uuid', form.select.dokter.value);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsetransferremove = (pasien_transfer_uuid, registrasi_uuid) => {

	let data = new FormData();
	data.append('uuid', pasien_transfer_uuid);
	data.append('registrasi_uuid', registrasi_uuid);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parseistirahat = (form, detail) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.pengguna_uuid);
	data.append('nama_dokter', detail.nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);

	data.append('jumlah_hari', form.istirahatjumlahhari.value);
	data.append('mulai_tanggal', form.istirahatmulai.value);
	data.append('sampai_tanggal', form.istirahatsampai.value);
	data.append('diagnosa', form.istirahatdiagnosa.value);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsekonsul = (form, detail) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.pengguna_uuid);
	data.append('nama_dokter', detail.nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);

	data.append('yth', form.konsulyth.value);
	data.append('di', form.konsuldi.value);
	data.append('diagnosa', form.konsuldiagnosa.value);
	data.append('tindakan', form.konsultindakan.value);
	
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsebalasankonsul = (form, detail) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.pengguna_uuid);
	data.append('nama_dokter', detail.nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);

	data.append('yth', form.balasankonsulyth.value);
	data.append('di', form.balasankonsuldi.value);
	data.append('diagnosa', form.balasankonsuldiagnosa.value);
	data.append('tindakan', form.balasankonsultindakan.value);
	
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parseresepkacamata = (form, detail) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', detail.uuid);
	data.append('pasien_uuid', detail.pasien_uuid);
	data.append('nama_pasien', detail.nama_pasien);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('pengguna_uuid', detail.pengguna_uuid);
	data.append('nama_dokter', detail.nama_dokter);
	data.append('no_pendaftaran', detail.no_pendaftaran);
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);

	data.append('m1', form.m1);
	data.append('m2', form.m2);
	data.append('r1', form.r1);
	data.append('r2', form.r2);
	data.append('r3', form.r3);
	data.append('r4', form.r4);
	
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}