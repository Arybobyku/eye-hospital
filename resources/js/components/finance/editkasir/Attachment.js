export const parsekelurahan = (form, detail, listdata) => {
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
	data.append('ruang_poliklinik', detail.ruang_poliklinik);
	data.append('jenis', detail.jenis);
	data.append('kode', detail.kode);
	data.append('nomor', detail.nomor);
	data.append('diskon_rp', form.diskon_rp);
	data.append('diskon_persen', form.diskon_persen);
	data.append('tindakan', JSON.stringify(listdata));

	data.append('metode_pembayaran', form.select.metodepembayaran.value);
	data.append('tanggal', form.tanggal.value);
	data.append('rekam_medis', form.rekam_medis.value);
	data.append('no_kwitansi', form.no_kwitansi.value);
	data.append('carabayar_nama', form.carabayar.value);
	data.append('nama_dokter', form.namadokter.value);
	data.append('nama_dokter_spesialis', form.namadokterspesialis.value);
	data.append('edit_superadmin', true);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parseunit = (form) => {
	let data = new FormData();
	data.append('pasienbebas_uuid', form.uuid);
	data.append('metode_pembayaran', form.select.metodepembayaran.value);
	data.append('edit_superadmin', true);
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsehapus = (form, detail, global) => {
	let data = new FormData();
	data.append('registrasi_uuid', detail.uuid);
	data.append('uuid', global.uuid);
	data.append('jenis', global.jenis);
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parseperbaharui = (form, detail, global) => {
	let data = new FormData();
	data.append('registrasi_uuid', detail.uuid);
	data.append('uuid', global.uuid);
	data.append('tarif', global.tarif);
	data.append('total', global.total);
	
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parsepanjar = (form) => {
	let data = new FormData();
	data.append('uuid', form.registrasi_uuid);
	data.append('panjar', form.panjar.value);
	data.append('keterangan', form.keterangan.value);
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}