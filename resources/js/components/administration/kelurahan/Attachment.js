export const parsekelurahan = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('kecamatan_id', form.select.kecamatan.value);
	data.append('nama_kecamatan', form.select.kecamatan.label);
	return data;
}
