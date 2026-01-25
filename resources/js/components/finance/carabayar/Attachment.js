export const parsecarabayar = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	return data;
}

export const parsechild = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('carabayar_uuid', form.carabayar_uuid);
	data.append('carabayar_nama', form.carabayar_nama);
	data.append('nama', form.nama.value);
	//data.append('child', JSON.stringify(form.listdata));
	return data;
}

export const parsetarif = (form, key) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('key', key);
	data.append('jenis', form.jenis);
	data.append('carabayar_uuid', form.carabayar_uuid);
	data.append('carabayar_nama', form.carabayar_nama);

	if (key == 'tindakanrawatjalan') {
		data.append('harga', form.harga[key].value);
		data.append('default', form.select.defaulttindakan.value);
		data.append('tindakan_uuid', form.select[key].value);
		data.append('tindakan_nama', form.select[key].label);
	}
	else {
		if (key != 'jeniskamar') {
			if (key == 'tindakanbedah') {
				data.append('vvip_harga', form.vvipharga[key].value);
				data.append('vip_harga', form.vipharga[key].value);
				data.append('kelas1_harga', form.kelas1harga[key].value);
				data.append('kelas2_harga', form.kelas2harga[key].value);
				data.append('kelas3_harga', form.kelas3harga[key].value);
				data.append('jenis_tindakan_bedah', form.select.jenis.value);
			}
			else {
				data.append('harga', form.harga[key].value);
			}
			data.append('default', form.default[key].value);
			data.append('tindakan_uuid', form.select[key].value);
			data.append('tindakan_nama', form.select[key].label);
		}
		else {
			data.append('default', form.default[key].value);
			data.append('jenis_kamar_uuid', form.select[key].value);
			data.append('nama_jenis_kamar', form.select[key].label);
			data.append('harga', form.harga[key].value);
			data.append('jenis', form.hitungan[key].value);
		}
	}
	
	
	return data;
}
