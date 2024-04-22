export const parsekabkota = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('provinsi_id', form.select.provinsi.value);
	data.append('nama_provinsi', form.select.provinsi.label);
	return data;
}
