export const parsedetail = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('dokter_uuid', form.select.dokter.value);
	data.append('nama_dokter', form.select.dokter.label);
	return data;
}
