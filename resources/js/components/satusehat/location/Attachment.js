export const parselocation = (form) => {
	let data = new FormData();
	data.append('satusehat_id',             form.satusehat_id);
	// Identitas
	data.append('kode',                     form.kode.value);
	data.append('nama',                     form.nama.value);
	data.append('alias',                    form.alias.value);
	data.append('deskripsi',               form.deskripsi.value);
	data.append('status',                   form.status.value);
	data.append('operational_status',       form.operational_status.value);
	data.append('mode',                     form.mode.value);
	// Tipe
	data.append('tipe_layanan',             form.tipe_layanan.value);
	data.append('tipe_layanan_display',     form.tipe_layanan.options?.find(o => o.value === form.tipe_layanan.value)?.label?.split(' — ')[1] ?? '');
	data.append('tipe_fisik',               form.tipe_fisik.value);
	data.append('tipe_fisik_display',       form.tipe_fisik.options?.find(o => o.value === form.tipe_fisik.value)?.label?.split(' — ')[1] ?? 'Room');
	data.append('service_class',            form.service_class.value);
	// Telecom
	data.append('telepon',                  form.telepon.value);
	data.append('fax',                      form.fax.value);
	data.append('email',                    form.email.value);
	data.append('website',                  form.website.value);
	// Alamat
	data.append('address_use',              form.address_use.value);
	data.append('alamat',                   form.alamat.value);
	data.append('kota',                     form.kota.value);
	data.append('kode_pos',                 form.kode_pos.value);
	data.append('kode_provinsi',            form.kode_provinsi.value);
	data.append('kode_kota',               form.kode_kota.value);
	data.append('kode_kecamatan',          form.kode_kecamatan.value);
	data.append('kode_kelurahan',          form.kode_kelurahan.value);
	data.append('rt',                       form.rt.value);
	data.append('rw',                       form.rw.value);
	// Posisi
	data.append('latitude',                 form.latitude.value);
	data.append('longitude',               form.longitude.value);
	// Organisasi & Relasi
	data.append('managing_organization',    form.managing_organization.value);
	data.append('part_of',                  form.part_of.value);
	// Jam Operasional
	data.append('hours_all_day',            form.hours_all_day.value);
	data.append('hours_days',               form.hours_days.value);
	data.append('hours_opening',            form.hours_opening.value);
	data.append('hours_closing',            form.hours_closing.value);
	data.append('availability_exceptions',  form.availability_exceptions.value);
	return data;
}
