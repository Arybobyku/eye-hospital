export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Paket', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		total: { 
			title: 'Total Biaya', for_id: 'form_'+'total', type: 'number', required: '', 
			name: 'total', value: '', disabled: false, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan', for_id: 'form_'+'keterangan', type: 'text', required: '', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: false, html: 'Nama Dokter', issearch: false, disabled: false,
			},
		}
	}
}

export const listpaket = () => {
	return {
		title: '', posisi: '', uuid: '', nama_paket_bedah: '', paket_bedah_uuid: '',
		label: { 
			title: 'Label', for_id: 'form_'+'label', type: 'text', required: 'required', 
			name: 'label', value: '', disabled: false, show: true, kinds: ''
		},
		sublabel: { 
			title: 'Sub Label', for_id: 'form_'+'sublabel', type: 'text', required: 'required', 
			name: 'sublabel', value: '', disabled: false, show: true, kinds: ''
		},
		nama: { 
			title: 'Nama', for_id: 'form_'+'nama', type: 'text', required: '', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		quantity: { 
			title: 'Qty', for_id: 'form_'+'quantity', type: 'number', required: '', 
			name: 'quantity', value: '', disabled: false, show: true, kinds: ''
		},
		harga: { 
			title: 'Harga', for_id: 'form_'+'harga', type: 'number', required: 'required', 
			name: 'harga', value: '', disabled: false, show: true, kinds: ''
		},
	}
}