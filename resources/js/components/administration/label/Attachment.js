export const parselabel = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('based', form.based.value);
	data.append('icon', form.icon.value);
	data.append('link', form.link.value);
	data.append('posisi', form.posisilabel.value);
	return data;
}
