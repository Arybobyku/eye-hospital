export const parsetindakanbedah = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('jenis', form.select.jenis.value);
	return data;
}
