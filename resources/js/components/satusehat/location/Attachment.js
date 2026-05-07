export const parselocation = (form) => {
	let data = new FormData();
	data.append('satusehat_id',   form.satusehat_id);
	data.append('kode',           form.kode.value);
	data.append('nama',           form.nama.value);
	data.append('deskripsi',      form.deskripsi.value);
	data.append('status',         form.status.value);
	data.append('mode',           form.mode.value);
	data.append('tipe_fisik',     form.tipe_fisik.value);
	data.append('telepon',        form.telepon.value);
	data.append('fax',            form.fax.value);
	data.append('email',          form.email.value);
	data.append('alamat',         form.alamat.value);
	data.append('kota',           form.kota.value);
	data.append('kode_pos',       form.kode_pos.value);
	data.append('kode_provinsi',  form.kode_provinsi.value);
	data.append('kode_kota',      form.kode_kota.value);
	data.append('kode_kecamatan', form.kode_kecamatan.value);
	data.append('kode_kelurahan', form.kode_kelurahan.value);
	data.append('latitude',       form.latitude.value);
	data.append('longitude',      form.longitude.value);
	return data;
}
