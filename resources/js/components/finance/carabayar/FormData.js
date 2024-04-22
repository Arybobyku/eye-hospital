export const formcarabayar = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Metode Pembayaran', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formchild = () => {
	return {
		title: '', posisi: '', uuid: '', listdata: '', carabayar_uuid: '', carabayar_nama: '',
		nama: { 
			title: 'Nama Bagian (Child)', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		search: { 
			title: '', for_id: 'form_'+'search', type: 'text', required: '', 
			name: 'search', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formtarif = () => {
	return {
		title: '', posisi: '', uuid: '', listdata: '', carabayar_uuid: '', carabayar_nama: '', jenis: '',
		hitungan: {
			jeniskamar: {
				title: 'Hitungan Biaya (Hari/Jam)', for_id: 'form_'+'kamjeniskamarar', type: 'text', required: 'required', 
				name: 'jeniskamar', value: '', disabled: false, show: true, kinds: ''
			},
		},
		vvipharga: {
			tindakanbedah: {
				title: 'Harga VVIP', for_id: 'form_'+'tindakanbedah', type: 'number', required: 'required', 
				name: 'tindakanbedah', value: '', disabled: false, show: true, kinds: ''
			},
		},
		vipharga: {
			tindakanbedah: {
				title: 'Harga VIP', for_id: 'form_'+'tindakanbedah', type: 'number', required: 'required', 
				name: 'tindakanbedah', value: '', disabled: false, show: true, kinds: ''
			},
		},
		kelas1harga: {
			tindakanbedah: {
				title: 'Harga Kelas I', for_id: 'form_'+'tindakanbedah', type: 'number', required: 'required', 
				name: 'tindakanbedah', value: '', disabled: false, show: true, kinds: ''
			},
		},
		kelas2harga: {
			tindakanbedah: {
				title: 'Harga Kelas II', for_id: 'form_'+'tindakanbedah', type: 'number', required: 'required', 
				name: 'tindakanbedah', value: '', disabled: false, show: true, kinds: ''
			},
		},
		kelas3harga: {
			tindakanbedah: {
				title: 'Harga Kelas III', for_id: 'form_'+'tindakanbedah', type: 'number', required: 'required', 
				name: 'tindakanbedah', value: '', disabled: false, show: true, kinds: ''
			},
		},
		harga: { 
			tindakanrawatjalan: {
				title: 'Harga Tindakan', for_id: 'form_'+'tindakanrawatjalan', type: 'number', required: 'required', 
				name: 'tindakanrawatjalan', value: '', disabled: false, show: true, kinds: ''
			},
			tindakannonbedah: {
				title: 'Harga Tindakan', for_id: 'form_'+'tindakannonbedah', type: 'number', required: 'required', 
				name: 'tindakannonbedah', value: '', disabled: false, show: true, kinds: ''
			},
			jeniskamar: {
				title: 'Harga Kamar', for_id: 'form_'+'kamjeniskamarar', type: 'number', required: 'required', 
				name: 'jeniskamar', value: '', disabled: false, show: true, kinds: ''
			},
		},
		default: { 
			tindakanrawatjalan: {
				title: 'Default kedalam tagihan?', for_id: 'form_'+'tindakanrawatjalan', type: 'text', required: 'required', 
				name: 'tindakanrawatjalan', value: 'Tidak', disabled: false, show: true, kinds: ''
			},
			tindakannonbedah: {
				title: 'Default kedalam tagihan?', for_id: 'form_'+'tindakannonbedah', type: 'text', required: 'required', 
				name: 'tindakannonbedah', value: 'Tidak', disabled: false, show: true, kinds: ''
			},
			tindakanbedah: {
				title: 'Default kedalam tagihan?', for_id: 'form_'+'tindakanbedah', type: 'text', required: 'required', 
				name: 'tindakanbedah', value: 'Tidak', disabled: false, show: true, kinds: ''
			},
			jeniskamar: {
				title: 'Default kedalam tagihan?', for_id: 'form_'+'kamjeniskamarar', type: 'text', required: 'required', 
				name: 'jeniskamar', value: 'Tidak', disabled: false, show: true, kinds: ''
			},
		},
		select: {
			jenis: { 
				key : 'jenis', for_id: 'form_'+'jenis', name: 'jenis', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenis', isrequired: true, html: 'Jenis Tindakan', issearch: false, disabled: false,
			},
			defaulttindakan: { 
				key : 'defaulttindakan', for_id: 'form_'+'defaulttindakan', name: 'defaulttindakan', uuid:'', value: 'Tidak', label: 'Tidak', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'defaulttindakan', isrequired: true, html: 'Default kedalam tagihan?', issearch: false, disabled: false,
			},
			jeniskamar: { 
				key : 'jeniskamar', for_id: 'form_'+'jeniskamar', name: 'jeniskamar', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'jeniskamar', isrequired: true, html: 'Jenis Kamar', issearch: true, disabled: false,
			},
			tindakanrawatjalan: { 
				key : 'tindakanrawatjalan', for_id: 'form_'+'tindakanrawatjalan', name: 'tindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'tindakanrawatjalan', isrequired: true, html: 'Nama Tindakan', issearch: true, disabled: false,
			},
			tindakannonbedah: { 
				key : 'tindakannonbedah', for_id: 'form_'+'tindakannonbedah', name: 'tindakannonbedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'tindakannonbedah', isrequired: true, html: 'Nama Tindakan', issearch: true, disabled: false,
			},
			tindakanbedah: { 
				key : 'tindakanbedah', for_id: 'form_'+'tindakanbedah', name: 'tindakanbedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'tindakanbedah', isrequired: true, html: 'Nama Tindakan', issearch: true, disabled: false,
			},
		}
	}
}