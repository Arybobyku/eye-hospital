export const parsepengguna = (form) => {
	
	let data = new FormData();
	if (form.posisi == 'editdata') {
		data.append('pengguna_uuid', form.penggunauuid);
	}
	data.append('sebagai_pengguna', form.sebagai.value);
	data.append('nama_pengguna', form.namapengguna.value);
	data.append('tempat_lahir', form.tempatlahir.value);
	data.append('tanggal_lahir', form.tanggallahir.value);
	data.append('jenis_kelamin', form.select.jeniskelamin.value);
	data.append('agama', form.select.agama.value);
	data.append('no_handphone', form.nohandphone.value);
	data.append('darurat_no_handphone', form.daruratnohandphone.value);
	data.append('darurat_nama', form.daruratnama.value);
	data.append('darurat_hubungan', form.darurathubungan.value);
	data.append('ktp', form.ktp.value);
	data.append('sima', form.sima.value);
	data.append('simc', form.simc.value);
	data.append('npwp', form.npwp.value);
	data.append('paspor', form.paspor.value);
	data.append('status_pernikahan', form.select.statuspernikahan.value);
	data.append('bank_norek', form.banknorek.value);
	data.append('bank_an', form.bankan.value);
	data.append('bank_nama', form.banknama.value);
	data.append('email_pengguna', form.emailpengguna.value);
	data.append('alamat', form.alamat.value);
	data.append('provinsi_id', form.select.provinsi.value);
	data.append('nama_provinsi', form.select.provinsi.label);
	data.append('kab_kota_id', form.select.kabkota.value);
	data.append('nama_kab_kota', form.select.kabkota.label);
	data.append('kecamatan_id', form.select.kecamatan.value);
	data.append('nama_kecamatan', form.select.kecamatan.label);
	data.append('kelurahan_id', form.select.kelurahan.value);
	data.append('nama_kelurahan', form.select.kelurahan.label);
	data.append('kodepos', form.kodepos.value);

	return data;
}

export const parsepassword = (form) => {
	let data = new FormData();
	data.append('pengguna_uuid', form.penggunauuid);
	data.append('password_lama', form.passwordlama.value);
	data.append('password_baru', form.passwordbaru.value);
	data.append('confirm_password', form.confirmpassword.value);
	return data;
}
