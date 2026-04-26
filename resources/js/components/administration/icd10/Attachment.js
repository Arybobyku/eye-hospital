export const parseicd10 = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('kode', form.kode.value);
	return data;
}
