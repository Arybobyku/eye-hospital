export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('melalui', form.select.melalui.value);
	data.append('waktu', form.waktu.value);
	data.append('tanggal', form.tanggal.value);
	return data;
}
