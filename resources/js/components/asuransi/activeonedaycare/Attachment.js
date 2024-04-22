export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('cover_asuransi', form.coverasuransi.value);
	return data;
}
