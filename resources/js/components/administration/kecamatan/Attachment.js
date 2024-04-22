export const parsekecamatan = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('kab_kota_id', form.select.kabkota.value);
	data.append('nama_kab_kota', form.select.kabkota.label);
	return data;
}
