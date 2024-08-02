export const formpengguna = () => {
	return {
		title: '', posisi: '', penggunauuid: '', ttd: '',
		sebagai: { 
			title: 'Posisi Sebagai', for_id: 'form_'+'sebagai', type: 'text', required: 'required', 
			name: 'sebagai', value: '', disabled: false, show: true, kinds: ''
		},
		namapengguna: { 
			title: 'Nama Lengkap', for_id: 'form_'+'namapengguna', type: 'text', required: 'required', 
			name: 'namapengguna', value: '', disabled: false, show: true, kinds: ''
		},
		npwp: { 
			title: 'Nomor Pokok Wajib Pajak', for_id: 'form_'+'npwp', type: 'text', required: '', 
			name: 'npwp', value: '', disabled: false, show: true, kinds: ''
		},
		tempatlahir: { 
			title: 'Tempat Lahir', for_id: 'form_'+'tempatlahir', type: 'text', required: 'required', 
			name: 'tempatlahir', value: '', disabled: false, show: true, kinds: ''
		},
		tanggallahir: { 
			title: 'Tanggal Lahir', for_id: 'form_'+'tanggallahir', type: 'date', required: 'required', 
			name: 'tanggallahir', value: '', disabled: false, show: true, kinds: ''
		},
		emailpengguna: { 
			title: 'Email', for_id: 'form_'+'emailpengguna', type: 'email', required: 'required', 
			name: 'emailpengguna', value: '', disabled: false, show: true, kinds: ''
		},
		alamat: { 
			title: 'Alamat', for_id: 'form_'+'alamat', type: 'text', required: 'required', 
			name: 'email', value: '', disabled: false, show: true, kinds: ''
		},
		kodepos: { 
			title: 'Kode Pos', for_id: 'form_'+'kodepos', type: 'text', required: '', 
			name: 'kodepos', value: '', disabled: false, show: true, kinds: ''
		},
		rtrw: { 
			title: 'RT RW', for_id: 'form_'+'rtrw', type: 'text', required: '', 
			name: 'rtrw', value: '', disabled: false, show: true, kinds: ''
		},
		banknama: { 
			title: 'Nama Bank', for_id: 'form_'+'banknama', type: 'text', required: '', 
			name: 'banknama', value: '', disabled: false, show: true, kinds: ''
		},
		banknorek: { 
			title: 'No Rekening', for_id: 'form_'+'banknorek', type: 'text', required: '', 
			name: 'banknorek', value: '', disabled: false, show: true, kinds: ''
		},
		bankan: { 
			title: 'Atas Nama', for_id: 'form_'+'bankan', type: 'text', required: '', 
			name: 'bankan', value: '', disabled: false, show: true, kinds: ''
		},
		nohandphone: { 
			title: 'No Handphone', for_id: 'form_'+'nohandphone', type: 'text', required: 'required', 
			name: 'nohandphone', value: '', disabled: false, show: true, kinds: ''
		},
		ktp: { 
			title: 'No KTP', for_id: 'form_'+'ktp', type: 'text', required: 'required', 
			name: 'ktp', value: '', disabled: false, show: true, kinds: ''
		},
		sima: { 
			title: 'No SIM A', for_id: 'form_'+'sima', type: 'text', required: '', 
			name: 'sima', value: '', disabled: false, show: true, kinds: ''
		},
		simc: { 
			title: 'No SIM C', for_id: 'form_'+'simc', type: 'text', required: '', 
			name: 'simc', value: '', disabled: false, show: true, kinds: ''
		},
		paspor: { 
			title: 'No Paspor', for_id: 'form_'+'paspor', type: 'text', required: '', 
			name: 'paspor', value: '', disabled: false, show: true, kinds: ''
		},
		daruratnama: { 
			title: 'Nama Lengkap', for_id: 'form_'+'daruratnama', type: 'text', required: '', 
			name: 'daruratnama', value: '', disabled: false, show: true, kinds: ''
		},
		daruratnohandphone: { 
			title: 'No Handphone', for_id: 'form_'+'daruratnohandphone', type: 'text', required: '', 
			name: 'daruratnohandphone', value: '', disabled: false, show: true, kinds: ''
		},
		darurathubungan: { 
			title: 'Hubungan', for_id: 'form_'+'darurathubungan', type: 'text', required: '', 
			name: 'darurathubungan', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			jeniskelamin: { 
				key : 'jeniskelamin', for_id: 'form_'+'jeniskelamin', name: 'jeniskelamin', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jeniskelamin', isrequired: true, html: 'Jenis Kelamin', issearch: false, disabled: false,
			},
			agama: { 
				key : 'agama', for_id: 'form_'+'agama', name: 'agama', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'agama', isrequired: true, html: 'Agama', issearch: false, disabled: false,
			},
			statuspernikahan: { 
				key : 'statuspernikahan', for_id: 'form_'+'statuspernikahan', name: 'statuspernikahan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'statuspernikahan', isrequired: false, html: 'Status Pernikahan', issearch: false, disabled: false,
			},
			pendidikanterakhir: { 
				key : 'pendidikanterakhir', for_id: 'form_'+'pendidikanterakhir', name: 'pendidikanterakhir', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pendidikanterakhir', isrequired: false, html: 'Pendidikan Terakhir', issearch: false, disabled: false,
			},
			golongandarah: { 
				key : 'golongandarah', for_id: 'form_'+'golongandarah', name: 'golongandarah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'golongandarah', isrequired: false, html: 'Golongan Darah', issearch: false, disabled: false,
			},
			provinsi: { 
				key : 'provinsi', for_id: 'form_'+'provinsi', name: 'provinsi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'provinsi', isrequired: true, html: 'Nama Provinsi', issearch: true, disabled: false,
				db_table: 'provinsi', dosearch: false,
			},
			kabkota: { 
				key : 'kabkota', for_id: 'form_'+'kabkota', name: 'kabkota', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kabkota', isrequired: true, html: 'Nama Kabupaten/Kota', issearch: true, disabled: false,
				db_table: 'kab_kota', dosearch: false,
			},
			kecamatan: { 
				key : 'kecamatan', for_id: 'form_'+'kecamatan', name: 'kecamatan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kecamatan', isrequired: true, html: 'Kecamatan', issearch: true, disabled: false,
				db_table: 'kecamatan', dosearch: false,
			},
			kelurahan: { 
				key : 'kelurahan', for_id: 'form_'+'kelurahan', name: 'kelurahan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kelurahan', isrequired: true, html: 'Kelurahan', issearch: true, disabled: false,
				db_table: 'kelurahan', dosearch: false,
			},
		}
	}
}

export const formpassword = () => {
	return {
		title: '', posisi: '', penggunauuid: '',
		passwordlama: { 
			title: 'Password Lama', for_id: 'form_'+'passwordlama', type: 'password', required: 'required', 
			name: 'passwordlama', value: '', disabled: false, show: true, kinds: ''
		},
		passwordbaru: { 
			title: 'Paswword Baru', for_id: 'form_'+'passwordbaru', type: 'password', required: 'required', 
			name: 'passwordbaru', value: '', disabled: false, show: true, kinds: ''
		},
		confirmpassword: { 
			title: 'Konfirmasi Password', for_id: 'form_'+'confirmpassword', type: 'password', required: 'required', 
			name: 'confirmpassword', value: '', disabled: false, show: true, kinds: ''
		},
	}
}