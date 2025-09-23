export const parsedetail = (form, layanan) => {

	console.log(form.select)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('layanan', JSON.stringify(layanan));
	return data;
}
