export const parseambil = (form, jenis) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('obat_uuid', form.obat_uuid);
	let kecil = form.jumlah_kecil - form.jumlah.value;
	let besar = kecil / form.hitung_kecil;
	data.append('minta_kecil', kecil);
	data.append('minta_besar', besar);
	data.append('jumlah', form.jumlah.value);
	return data;
}

export const parsekembali = (form, jenis) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('obat_uuid', form.obat_uuid);
	let kecil = parseFloat(form.jumlah_kecil) + parseFloat(form.jumlah.value);
	let besar = kecil / form.hitung_kecil;
	data.append('minta_kecil', kecil);
	data.append('minta_besar', besar);
	data.append('jumlah', form.jumlah.value);
	return data;
}
