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
	data.append('paket_uuid', form.select.paketbedah.value);
	data.append('nama_paket', form.select.paketbedah.label);
	data.append('ispending', form.ispending);

	data.append('tindakan', JSON.stringify(tindakan));

	data.append('obat', JSON.stringify(obat));


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