export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('klinik', form.select.klinik.value);
	return data;
}
