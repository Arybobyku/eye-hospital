export const formpasien = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Pasien', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		no_ktp: { 
			title: 'No KTP (NIK)', for_id: 'form_'+'no_ktp', type: 'text', required: 'required', 
			name: 'no_ktp', value: '', disabled: false, show: true, kinds: ''
		},
		no_bpjs: { 
			title: 'No BPJS', for_id: 'form_'+'no_bpjs', type: 'text', required: '', 
			name: 'no_bpjs', value: '', disabled: false, show: true, kinds: ''
		},
		alias: { 
			title: 'Nama Alias', for_id: 'form_'+'alias', type: 'text', required: '', 
			name: 'alias', value: '', disabled: false, show: true, kinds: ''
		},
		tempatlahir: { 
			title: 'Tempat Lahir', for_id: 'form_'+'tempatlahir', type: 'text', required: 'required', 
			name: 'tempatlahir', value: '', disabled: false, show: true, kinds: ''
		},
		tanggallahir: { 
			title: 'Tanggal Lahir', for_id: 'form_'+'tanggallahir', type: 'date', required: 'required', 
			name: 'tanggallahir', value: '', disabled: false, show: true, kinds: ''
		},
		noidentitas: { 
			title: 'No Identitas', for_id: 'form_'+'noidentitas', type: 'text', required: 'required', 
			name: 'noidentitas', value: '', disabled: false, show: true, kinds: ''
		},
		email: { 
			title: 'Email', for_id: 'form_'+'email', type: 'text', required: '', 
			name: 'email', value: '', disabled: false, show: true, kinds: ''
		},
		alamat: { 
			title: 'Alamat', for_id: 'form_'+'alamat', type: 'text', required: 'required', 
			name: 'alamat', value: '', disabled: false, show: true, kinds: ''
		},
		nohandphone: { 
			title: 'No Handphone', for_id: 'form_'+'nohandphone', type: 'text', required: 'required', 
			name: 'nohandphone', value: '', disabled: false, show: true, kinds: ''
		},
		kodepos: { 
			title: 'Kode Pos', for_id: 'form_'+'kodepos', type: 'text', required: '', 
			name: 'kodepos', value: '', disabled: false, show: true, kinds: ''
		},
		rtrw: { 
			title: 'RT & RW', for_id: 'form_'+'rtrw', type: 'text', required: '', 
			name: 'rtrw', value: '', disabled: false, show: true, kinds: ''
		},
		namaayah: { 
			title: 'Nama Ayah', for_id: 'form_'+'namaayah', type: 'text', required: '', 
			name: 'namaayah', value: '', disabled: false, show: true, kinds: ''
		},
		namaibu: { 
			title: 'Nama Ibu', for_id: 'form_'+'namaibu', type: 'text', required: '', 
			name: 'namaibu', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			provinsi: { 
				key : 'provinsi', for_id: 'form_'+'provinsi', name: 'provinsi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'provinsi', isrequired: true, html: 'Nama Provinsi', issearch: true, disabled: false,
			},
			kabkota: { 
				key : 'kabkota', for_id: 'form_'+'kabkota', name: 'kabkota', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kabkota', isrequired: true, html: 'Nama Kabupaten/Kota', issearch: true, disabled: false,
			},
			kecamatan: { 
				key : 'kecamatan', for_id: 'form_'+'kecamatan', name: 'kecamatan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kecamatan', isrequired: true, html: 'Nama Kecamatan', issearch: true, disabled: false,
			},
			kelurahan: { 
				key : 'kelurahan', for_id: 'form_'+'kelurahan', name: 'kelurahan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kelurahan', isrequired: false, html: 'Nama Kelurahan', issearch: true, disabled: false,
			},
			pendidikanterakhir: { 
				key : 'pendidikanterakhir', for_id: 'form_'+'pendidikanterakhir', name: 'pendidikanterakhir', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pendidikanterakhir', isrequired: false, html: 'Pendidikan Terakhir', issearch: false, disabled: false,
			},
			pekerjaan: { 
				key : 'pekerjaan', for_id: 'form_'+'pekerjaan', name: 'pekerjaan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pekerjaan', isrequired: false, html: 'Pekerjaan', issearch: false, disabled: false,
			},
			statuspernikahan: { 
				key : 'statuspernikahan', for_id: 'form_'+'statuspernikahan', name: 'statuspernikahan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'statuspernikahan', isrequired: true, html: 'Status Pernikahan', issearch: false, disabled: false,
			},
			agama: { 
				key : 'agama', for_id: 'form_'+'agama', name: 'agama', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'agama', isrequired: true, html: 'Agama', issearch: false, disabled: false,
			},
			jeniskelamin: { 
				key : 'jeniskelamin', for_id: 'form_'+'jeniskelamin', name: 'jeniskelamin', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jeniskelamin', isrequired: true, html: 'Jenis Kelamin', issearch: false, disabled: false,
			},
			jenisidentitas: { 
				key : 'jenisidentitas', for_id: 'form_'+'jenisidentitas', name: 'jenisidentitas', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenisidentitas', isrequired: true, html: 'Jenis Identitas Lainnya', issearch: false, disabled: false,
			},
			golongandarah: { 
				key : 'golongandarah', for_id: 'form_'+'golongandarah', name: 'golongandarah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'golongandarah', isrequired: false, html: 'Gologan Darah', issearch: false, disabled: false,
			},
			sebutan: { 
				key : 'sebutan', for_id: 'form_'+'sebutan', name: 'sebutan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'sebutan', isrequired: true, html: 'Sebutan', issearch: false, disabled: false,
			},
			
		}

	}
}

export const formcetakan = () => {
	return {
		title: '', posisi: '', uuid: '',
		pelepasaninformasi: { 
			title: 'Pelepasan Informasi Kepada', for_id: 'form_'+'pelepasaninformasi', type: 'text', required: 'required', 
			name: 'pelepasaninformasi', value: '', disabled: false, show: true, kinds: ''
		},
		penerima: { 
			title: 'Penerima Informasi', for_id: 'form_'+'penerima', type: 'text', required: 'required', 
			name: 'penerima', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formfile = () => {
	return {
		title: '', posisi: '', uuid: '', datafile: ''
	}
}

export const formrawatjalan = () => {
	return {
		title: '', posisi: '', uuid: '', photos: '',
		rujukan: { 
			title: 'Rujukan', for_id: 'form_'+'rujukan', type: 'text', required: '', 
			name: 'rujukan', value: '', disabled: true, show: true, kinds: ''
		},
		nopendaftaran: { 
			title: 'Nomor Antrian', for_id: 'form_'+'nopendaftaran', type: 'text', required: 'required', 
			name: 'nopendaftaran', value: '', disabled: false, show: true, kinds: ''
		},
		keteranganberkebutuhan: { 
			title: 'Keterangan berkebutuhan khusus', for_id: 'form_'+'keteranganberkebutuhan', type: 'text', required: '', 
			name: 'keteranganberkebutuhan', value: '', disabled: true, show: true, kinds: ''
		},
		pjnama: { 
			title: 'Nama Penanggung Jawab', for_id: 'form_'+'pjnama', type: 'text', required: '', 
			name: 'pjnama', value: '', disabled: false, show: true, kinds: ''
		},
		pjhubungan: { 
			title: 'Hubungan', for_id: 'form_'+'pjhubungan', type: 'text', required: '', 
			name: 'pjhubungan', value: '', disabled: false, show: true, kinds: ''
		},
		pjalamat: { 
			title: 'Alamat', for_id: 'form_'+'pjalamat', type: 'text', required: '', 
			name: 'pjalamat', value: '', disabled: false, show: true, kinds: ''
		},
		pjnoidentitas: { 
			title: 'No Identitas', for_id: 'form_'+'pjnoidentitas', type: 'text', required: '', 
			name: 'pjnoidentitas', value: '', disabled: false, show: true, kinds: ''
		},
		pjnohandphone: { 
			title: 'No Handphone', for_id: 'form_'+'pjnohandphone', type: 'text', required: '', 
			name: 'pjnohandphone', value: '', disabled: false, show: true, kinds: ''
		},
		no_bpjs_kes: { 
			title: 'No BPJS Kesehatan', for_id: 'form_'+'no_bpjs_kes', type: 'text', required: '', 
			name: 'no_bpjs_kes', value: '', disabled: false, show: false, kinds: ''
		},
		ruang_poli: { 
			title: 'Ruang Poliklinik', for_id: 'form_'+'ruang_poli', type: 'text', required: '', 
			name: 'ruang_poli', value: '', disabled: true, show: false, kinds: ''
		},
		nomorreferensi: { 
			title: 'No Referensi', for_id: 'form_'+'nomorreferensi', type: 'text', required: '', 
			name: 'nomorreferensi', value: '', disabled: false, show: false, kinds: ''
		},
		select: {
			caramasuk: { 
				key : 'caramasuk', for_id: 'form_'+'caramasuk', name: 'caramasuk', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'caramasuk', isrequired: true, html: 'Cara Masuk', issearch: false, disabled: false,
			},
			klinik: { 
				key : 'klinik', for_id: 'form_'+'klinik', name: 'klinik', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'klinik', isrequired: false, html: 'Ruangan Poli Tujuan', issearch: false, disabled: true,
			},
			jenisidentitas: { 
				key : 'jenisidentitas', for_id: 'form_'+'jenisidentitas', name: 'jenisidentitas', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenisidentitas', isrequired: false, html: 'Jenis Identitas PJ', issearch: false, disabled: false,
			},
			berkebutuhankhusus: { 
				key : 'berkebutuhankhusus', for_id: 'form_'+'berkebutuhankhusus', name: 'berkebutuhankhusus', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'berkebutuhankhusus', isrequired: true, html: 'Berkebutuhan Khusus/Triase/Disabilitas?', issearch: false, disabled: false,
			},
			
			// dokter: { 
			// 	key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
			// 	filter: [], data: [], search: '', option: 'display: none', statics: false,
			// 	class: 'dokter', isrequired: true, html: 'Dokter yang menangani', issearch: false, disabled: false,
			// },

			carabayar: { 
				key : 'carabayar', for_id: 'form_'+'carabayar', name: 'carabayar', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayar', isrequired: true, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},

			asuransi: { 
				key : 'asuransi', for_id: 'form_'+'asuransi', name: 'asuransi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'asuransi', isrequired: false, html: 'Nama Asuransi', issearch: true, disabled: true,
			},

		}
	}
}