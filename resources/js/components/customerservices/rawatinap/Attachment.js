export const parseunit = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('registrasi_uuid', form.registrasi_uuid);
	data.append('kamar_inap_uuid', form.kamar_inap_uuid);
	data.append('kamar_inap_nama', form.kamar_inap_nama);
	data.append('kamar_inap_lantai', form.kamar_inap_lantai);
	data.append('kamar_inap_jumlah_bed', form.kamar_inap_jumlah_bed);
	data.append('jenis_kamar_uuid', form.jenis_kamar_uuid);
	data.append('nama_jenis_kamar', form.nama_jenis_kamar);
	data.append('carabayar_uuid', form.carabayar_uuid);
	data.append('carabayar_nama', form.carabayar_nama);

	return data;
}
