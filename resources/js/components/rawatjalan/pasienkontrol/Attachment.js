export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('keterangan', form.keterangan.value);
	return data;
}
