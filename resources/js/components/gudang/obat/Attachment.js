export const parseobat = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('hitung_besar', form.hitungbesar.value);
	data.append('hitung_kecil', form.hitungkecil.value);
	data.append('min_stock', form.minstock.value);
	data.append('kategori', form.select.kategori.value);
	data.append('golongan', form.select.golongan.value);
	data.append('formularium', form.select.formularium.value);
	data.append('jenis', form.select.jenisobat.value);

	data.append('satuan_id_besar', form.select.satuanbesar.value);
	data.append('satuan_uuid_besar', form.select.satuanbesar.uuid);
	data.append('nama_satuan_besar', form.select.satuanbesar.label);

	data.append('satuan_id_kecil', form.select.satuankecil.value);
	data.append('satuan_uuid_kecil', form.select.satuankecil.uuid);
	data.append('nama_satuan_kecil', form.select.satuankecil.label);
	return data;
}
