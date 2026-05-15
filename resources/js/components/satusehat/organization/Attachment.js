export const parseorganization = (form) => {
	let data = new FormData();
	data.append('satusehat_id',          form.satusehat_id);
	// Identitas
	data.append('kode',                  form.kode.value);
	data.append('nama',                  form.nama.value);
	data.append('alias',                 form.alias.value);
	data.append('active',                form.active.value);
	data.append('tipe_code',             form.tipe_code.value);
	data.append('tipe_display',          form.tipe_code.options?.find(o => o.value === form.tipe_code.value)?.label?.split(' — ')[1] ?? 'Hospital Department');
	data.append('part_of',               form.part_of.value);
	// Telecom
	data.append('telepon',               form.telepon.value);
	data.append('email',                 form.email.value);
	data.append('website',               form.website.value);
	// Alamat
	data.append('address_use',           form.address_use.value);
	data.append('address_type',          form.address_type.value);
	data.append('alamat',                form.alamat.value);
	data.append('kota',                  form.kota.value);
	data.append('kode_pos',              form.kode_pos.value);
	data.append('kode_provinsi',         form.kode_provinsi.value);
	data.append('kode_kota',             form.kode_kota.value);
	data.append('kode_kecamatan',        form.kode_kecamatan.value);
	data.append('kode_kelurahan',        form.kode_kelurahan.value);
	// Contact
	data.append('contact_purpose_code',  form.contact_purpose_code.value);
	data.append('contact_purpose_display', form.contact_purpose_code.options?.find(o => o.value === form.contact_purpose_code.value)?.label?.split(' — ')[1] ?? '');
	data.append('contact_nama',          form.contact_nama.value);
	data.append('contact_telepon',       form.contact_telepon.value);
	data.append('contact_email',         form.contact_email.value);
	return data;
}
