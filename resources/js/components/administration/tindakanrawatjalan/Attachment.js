export const parsetindakanrawatjalan = (form) => {
	console.log(form.nama)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	return data;
}
