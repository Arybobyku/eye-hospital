export const parsefile = (form) => {
	let data = new FormData();
	data.append('pasien_uuid', form.uuid);
	data.append('datafile', form.datafile);
	return data;
}

export const parsepasien = (form) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('nama', form.nama.value);
	data.append('alias', form.alias.value);
	data.append('tempat_lahir', form.tempatlahir.value);
	data.append('tanggal_lahir', form.tanggallahir.value);
	data.append('no_identitas', form.noidentitas.value);
	data.append('email', form.email.value);
	data.append('alamat', form.alamat.value);
	data.append('no_handphone', form.nohandphone.value);
	data.append('kodepos', form.kodepos.value);
	data.append('rt_rw', form.rtrw.value);
	data.append('nama_ayah', form.namaayah.value);
	data.append('nama_ibu', form.namaibu.value);
	data.append('provinsi_id', form.select.provinsi.value);
	data.append('nama_provinsi', form.select.provinsi.label);
	data.append('kab_kota_id', form.select.kabkota.value);
	data.append('nama_kab_kota', form.select.kabkota.label);
	data.append('kecamatan_id', form.select.kecamatan.value);
	data.append('nama_kecamatan', form.select.kecamatan.label);
	data.append('kelurahan_id', form.select.kelurahan.value);
	data.append('nama_kelurahan', form.select.kelurahan.value);
	data.append('pendidikan_terakhir', form.select.pendidikanterakhir.value);
	data.append('pekerjaan', form.select.pekerjaan.value);
	data.append('status_pernikahan', form.select.statuspernikahan.value);
	data.append('agama', form.select.agama.value);
	data.append('jenis_kelamin', form.select.jeniskelamin.value);
	data.append('jenis_identitas', form.select.jenisidentitas.value);
	data.append('golongan_darah', form.select.golongandarah.value);
	data.append('sebutan', form.select.sebutan.value);
	
	return data;
}

export const parserawatjalan = (form, detail) => {
	let data = new FormData();
	data.append('uuid', form.uuid);
	data.append('photos', form.photos);
	data.append('pasien_uuid', detail.uuid);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('nama_pasien', detail.nama);
	data.append('tanggal_lahir', detail.tanggal_lahir);
	data.append('jenis_identitas', detail.jenis_identitas);
	data.append('no_identitas', detail.no_identitas);
	data.append('jenis_kelamin', detail.jenis_kelamin);
	data.append('no_handphone', detail.no_handphone);
	data.append('agama', detail.agama);

	data.append('pengguna_uuid', form.select.dokter.value);
	data.append('nama_dokter', form.select.dokter.label);
	data.append('no_pendaftaran', form.nopendaftaran.value);
	data.append('cara_masuk', form.select.caramasuk.value);
	data.append('rujukan', form.rujukan.value);
	data.append('carabayar_uuid', form.select.carabayar.value);
	data.append('carabayar_nama', form.select.carabayar.label);
	data.append('asuransi_uuid', form.select.asuransi.value);
	data.append('nama_asuransi', form.select.asuransi.label);
	data.append('ruang_poliklinik', form.select.klinik.value);
	data.append('berkebutuhan_khusus', form.select.berkebutuhankhusus.value);
	data.append('keterangan_berkebutuhan', form.keteranganberkebutuhan.value);

	data.append('nama', form.pjnama.value);
	data.append('hubungan', form.pjhubungan.value);
	data.append('alamat', form.pjalamat.value);
	data.append('jenis_identitas', form.select.jenisidentitas.value);
	data.append('no_identitas', form.pjnoidentitas.value);
	data.append('no_handphone', form.pjnohandphone.value);

	return data;
}

export const parsecetakan = (form, detail) => {
	let data = new FormData();
	data.append('pasien_uuid', detail.uuid);
	data.append('rekam_medis', detail.rekam_medis);
	data.append('nama_pasien', detail.nama);
	data.append('tanggal_lahir', detail.tanggal_lahir);
	data.append('tempat_lahir', detail.tempat_lahir);
	data.append('jenis_identitas', detail.jenis_identitas);
	data.append('no_identitas', detail.no_identitas);
	data.append('jenis_kelamin', detail.jenis_kelamin);
	data.append('no_handphone', detail.no_handphone);

	data.append('pelepasan_informasi', form.pelepasaninformasi.value);
	data.append('penerima', form.penerima.value);

	return data;
}