export const parseunit = (form) => {

	console.log(form.select)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('nama_layanan', form.nama_layanan);
	data.append('layanan_uuid', form.layanan_uuid);
	data.append('tarif', form.tarif);
	

	return data;
}

export const parsedelete = (form) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	

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


export const parsepaket = (form) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('paket_uuid', form.select.paketbedah.value);
	data.append('nama_paket', form.select.paketbedah.label);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}

export const parseaddobat = (form) => {

	console.log(form.select)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('nama', form.nama);
	data.append('obat_uuid', form.obat_uuid);
	data.append('kategori', form.kategori);
	data.append('formularium', form.formularium);
	data.append('golongan', form.golongan);
	data.append('satuan_uuid_besar', form.satuan_uuid_besar);
	data.append('nama_satuan_besar', form.nama_satuan_besar);
	data.append('satuan_uuid_kecil', form.satuan_uuid_kecil);
	data.append('nama_satuan_kecil', form.nama_satuan_kecil);
	data.append('hitung_besar', form.hitung_besar);
	data.append('hitung_kecil', form.hitung_kecil);
	data.append('harga_netto', form.harga_netto);
	data.append('harga_netto_discount', form.harga_netto_discount);
	data.append('harga_netto_ppn', form.harga_netto_ppn);
	data.append('hpp', form.hpp);
	data.append('margin_resep', form.margin_resep);
	data.append('margin_non_resep', form.margin_non_resep);
	data.append('hja_resep', form.hja_resep);
	data.append('hja_non_resep', form.hja_non_resep);
	data.append('hja_resep_besar', form.hja_resep_besar);
	data.append('hja_non_resep_besar', form.hja_non_resep_besar);
	data.append('jumlah_kecil', form.jumlah_kecil);
	data.append('jumlah_besar', form.jumlah_besar);
	data.append('signa', form.signa);
	data.append('total', form.total);

	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}

	return data;
}

export const parsedeleteobat = (form) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	

	return data;
}

export const parseresep = (form, obat, obatracikan) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('carabayar_nama', form.carabayar_nama);
	data.append('carabayar_uuid', form.carabayar_uuid);
	data.append('obat', JSON.stringify(obat));
	data.append('obatracikan', JSON.stringify(obatracikan));
	for(var pair of data.entries()) {
		console.log(pair[0]+ ', '+ pair[1]); 
 	}
	return data;
}
