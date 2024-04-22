export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	return data;
}


export const parsepermohonan = (form, obat) => {
	let data = new FormData();
	data.append('label_permohonan_uuid', form.label_permohonan_uuid);
	data.append('obat', JSON.stringify(obat));
	return data;
}
