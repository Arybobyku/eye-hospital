export const parseruangan = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('lantai', form.lantai.value);
	data.append('jumlah_bed', form.jumlahbed.value);
	data.append('jenis', form.select.jenisruangan.value);
	return data;
}
