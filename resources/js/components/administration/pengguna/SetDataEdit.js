export const setdataeditpengguna = (form, response) => {
	const data = response.data.data;
	form.penggunauuid = data.pengguna_uuid;
	form.mulaibekerja.value = data.mulai_bekerja;
	form.usernamepengguna.value = data.username_pengguna;
	form.namapengguna.value = data.nama_pengguna;
	form.sebagai.value = data.sebagai_pengguna;
	form.tempatlahir.value = data.tempat_lahir;
	form.tanggallahir.value = data.tanggal_lahir;

	if (data.posisi_pengguna == '0' || data.posisi_pengguna == '' || !data.posisi_pengguna) {
		form.select.posisiakun.value = '';
		form.select.posisiakun.label = 'Silahkan Pilih';
	}
	else {
		form.select.posisiakun.value = data.posisi_pengguna;
		form.select.posisiakun.label = data.posisi_pengguna == '8807' ? 'Karyawan' : (data.posisi_pengguna == '8808' ? 'Dokter Spesialis' : 'Dokter Umum');
	}

	if (data.jenis_kelamin == '0' || data.jenis_kelamin == '' || !data.jenis_kelamin) {
		form.select.jeniskelamin.value = '';
		form.select.jeniskelamin.label = 'Silahkan Pilih';
	}
	else {
		form.select.jeniskelamin.value = data.jenis_kelamin;
		form.select.jeniskelamin.label = data.jenis_kelamin;
	}
	
	if (data.agama == '0' || data.agama == '' || !data.agama) {
		form.select.agama.value = '';
		form.select.agama.label = 'Silahkan Pilih';
	}
	else {
		form.select.agama.value = data.agama;
		form.select.agama.label = data.agama;
	}
	
	form.nohandphone.value = data.no_handphone;
	form.daruratnohandphone.value = data.darurat_no_handphone;
	form.daruratnama.value = data.darurat_nama;
	form.darurathubungan.value = data.darurat_hubungan;
	form.ktp.value = data.ktp;
	form.nik.value = data.nik ?? '';
	form.sima.value = data.sima;
	form.simc.value = data.simc;
	form.npwp.value = data.npwp;
	form.paspor.value = data.paspor;

	if (data.status_pernikahan == '0' || data.status_pernikahan == '' || !data.status_pernikahan) {
		form.select.statuspernikahan.value = '';
		form.select.statuspernikahan.label = 'Silahkan Pilih';
	}
	else {
		form.select.statuspernikahan.value = data.status_pernikahan;
		form.select.statuspernikahan.label = data.status_pernikahan;
	}

	if (data.bpjs_ketenagakerjaan == '0' || data.bpjs_ketenagakerjaan == '' || !data.bpjs_ketenagakerjaan) {
		form.select.bpjsketenagakerjaan.value = '';
		form.select.bpjsketenagakerjaan.label = 'Silahkan Pilih';
	}
	else {
		form.select.bpjsketenagakerjaan.value = data.bpjs_ketenagakerjaan;
		form.select.bpjsketenagakerjaan.label = data.bpjs_ketenagakerjaan;
	}

	form.nobpjsketenagakerjaan.value = data.no_bpjs_ketenagakerjaan;
	
	form.banknorek.value = data.bank_norek;
	form.bankan.value = data.bank_an;
	form.banknama.value = data.bank_nama;
	form.emailpengguna.value = data.email_pengguna;
	form.alamat.value = data.alamat;

	if (data.nama_provinsi == '0' || data.nama_provinsi == '' || !data.nama_provinsi) {
		form.select.provinsi.value = '';
		form.select.provinsi.label = 'Silahkan Pilih';
	}
	else {
		form.select.provinsi.value = data.provinsi_id;
		form.select.provinsi.label = data.nama_provinsi;
	}

	if (data.kab_kota_id == '0' || data.kab_kota_id == '' || !data.kab_kota_id) {
		form.select.kabkota.value = '';
		form.select.kabkota.label = 'Silahkan Pilih';
	}
	else {
		form.select.kabkota.value = data.kab_kota_id;
		form.select.kabkota.label = data.nama_kab_kota;
	}

	if (data.kecamatan_id == '0' || data.kecamatan_id == '' || !data.kecamatan_id) {
		form.select.kecamatan.value = '';
		form.select.kecamatan.label = 'Silahkan Pilih';
	}
	else {
		form.select.kecamatan.value = data.kecamatan_id;
		form.select.kecamatan.label = data.nama_kecamatan;
	}

	if (data.kelurahan_id == '0' || data.kelurahan_id == '' || !data.kelurahan_id) {
		form.select.kelurahan.value = '';
		form.select.kelurahan.label = 'Silahkan Pilih';
	}
	else {
		form.select.kelurahan.value = data.kelurahan_id;
		form.select.kelurahan.label = data.nama_kelurahan;
	}
	form.kodepos.value = data.kodepos;
	return form;
}