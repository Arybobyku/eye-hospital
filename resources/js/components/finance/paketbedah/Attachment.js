export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('total', form.total.value);
	data.append('keterangan', form.keterangan.value);
	data.append('harga_sudah_ditentukan', form.harga_sudah_ditentukan.value);
	data.append('pengguna_uuid', form.select.dokter.value);
	data.append('nama_dokter', form.select.dokter.label);
	data.append('uuid_carabayar', form.select.carabayar.uuid);
	return data;
}
