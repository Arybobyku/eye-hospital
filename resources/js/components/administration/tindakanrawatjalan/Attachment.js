export const parsetindakanrawatjalan = (form) => {
	console.log(form.nama)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('label', form.label.value);
	data.append('sub_label', form.sub_label.value);
	data.append('nama', form.nama.value);
	data.append('harga', form.harga.value);
	return data;
}
