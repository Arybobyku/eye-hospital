export const parsekamarinap = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('lantai', form.lantai.value);
	data.append('jumlah_bed', form.jumlahbed.value);
	data.append('keterangan', form.keterangan.value);
	data.append('jenis_kamar_uuid', form.select.jeniskamar.value);
	data.append('nama_jenis_kamar', form.select.jeniskamar.label);
	return data;
}
