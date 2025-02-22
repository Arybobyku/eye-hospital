export const parsekelurahan = (form, detail, obat, obatbedah,  obattambahan) => {
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
	data.append('carabayar_nama', detail.carabayar_nama);
	data.append('carabayar_uuid', detail.carabayar_uuid);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);
	data.append('obat', JSON.stringify(obat));
	data.append('obatbedah', JSON.stringify(obatbedah));
	data.append('obattambahan', JSON.stringify(obattambahan));

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parseunit = (form, obat, obatracikan, obattambahan, tindakan) => {
	let data = new FormData();
	data.append('pasienbebas_uuid', form.uuid);
	data.append('carabayar_nama', form.carabayar_nama);
	data.append('carabayar_uuid', form.carabayar_uuid);
	data.append('obat', JSON.stringify(obat));
	data.append('obatracikan', JSON.stringify(obatracikan));
	data.append('obattambahan', JSON.stringify(obattambahan));
	data.append('tindakan', JSON.stringify(tindakan));
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsepembeli = (form, obat) => {
	let data = new FormData();
	data.append('nama', form.nama.value);
	data.append('no_antrian', form.no_antrian.value);
	data.append('jenis', form.select.jenisracikan.value);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

