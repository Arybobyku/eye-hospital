export const parsepermintaan = (form) => {
	let data = new FormData();
	data.append('kode', form.kode);
	data.append('permintaan', JSON.stringify(form.listdata));
	return data;
}
