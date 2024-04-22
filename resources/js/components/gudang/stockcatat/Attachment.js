export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('tanggal', form.tanggal.value);
	data.append('jam', form.jam.value);
	return data;
}


export const parsebalance = (form, obat) => {
	let data = new FormData();
	data.append('label_stockopname_uuid', form.label_stockopname_uuid);
	data.append('obat', JSON.stringify(obat));
	return data;
}
