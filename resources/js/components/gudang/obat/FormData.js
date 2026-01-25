export const formobat = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Obat', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		hitungbesar: { 
			title: 'Angka Satuan', for_id: 'form_'+'hitungbesar', type: 'number', required: 'required', 
			name: 'hitungbesar', value: '1', disabled: true, show: true, kinds: ''
		},
		hitungkecil: { 
			title: 'Angka Satuan', for_id: 'form_'+'hitungkecil', type: 'number', required: 'required', 
			name: 'hitungkecil', value: '', disabled: false, show: true, kinds: ''
		},
		minstock: { 
			title: 'Minimum Stock (Dari satuan kecil)', for_id: 'form_'+'minstock', type: 'number', required: 'required', 
			name: 'minstock', value: '', disabled: false, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan Tambahan', for_id: 'form_'+'keterangan', type: 'number', required: '', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			satuanbesar: { 
				key : 'satuanbesar', for_id: 'form_'+'satuanbesar', name: 'satuanbesar', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'satuanbesar', isrequired: true, html: 'Satuan Besar', issearch: true, disabled: false,
			},
			satuankecil: { 
				key : 'satuankecil', for_id: 'form_'+'satuankecil', name: 'satuankecil', uuid: '', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'satuankecil', isrequired: true, html: 'Satuan Kecil', issearch: true, disabled: false,
			},
			golongan: { 
				key : 'golongan', for_id: 'form_'+'golongan', name: 'golongan', uuid: '', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'golongan', isrequired: false, html: 'Golongan', issearch: false, disabled: false,
			},
			kategori: { 
				key : 'kategori', for_id: 'form_'+'kategori', name: 'kategori', uuid: '', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'kategori', isrequired: false, html: 'Kategori', issearch: false, disabled: false,
			},
			formularium: { 
				key : 'formularium', for_id: 'form_'+'formularium', name: 'formularium', uuid: '', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'formularium', isrequired: false, html: 'Formularium', issearch: false, disabled: false,
			},
			jenisobat: { 
				key : 'jenisobat', for_id: 'form_'+'jenisobat', name: 'jenisobat', uuid: '', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenisobat', isrequired: true, html: 'Jenis Barang', issearch: false, disabled: false,
			},
		}
	}
}