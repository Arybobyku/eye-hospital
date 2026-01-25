export const parseunit = (form) => {

	console.log(form.select)
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('pasienbebas_uuid', form.pasienbebas_uuid);
	data.append('carabayar_nama', form.carabayar_nama);
	data.append('carabayar_uuid', form.carabayar_uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('nama_layanan', form.nama_layanan);
	data.append('layanan_uuid', form.layanan_uuid);
	data.append('tarif', form.tarif);
	
	return data;
}

export const parsedelete = (form) => {

	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('pasienbebas_uuid', form.pasienbebas_uuid);
	

	return data;
}