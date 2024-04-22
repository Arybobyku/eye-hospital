export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('content', form.content.value);
	return data;
}
