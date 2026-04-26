export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Pemohon', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formpermintaan = () => {
	return {
		title: '', posisi: '', uuid: '', label_ermintaan_uuid: '',
		jumlah: { 
			title: 'Jumlah', for_id: 'form_'+'jumlah', type: 'number', required: 'required', 
			name: 'jumlah', value: '', disabled: false, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan', for_id: 'form_'+'keterangan', type: 'text', required: '', 
			name: 'keterangan', value: '-', disabled: false, show: true, kinds: ''
		},
		select: { 
			hargagudang: { 
				key : 'hargagudang', for_id: 'form_'+'hargagudang', name: 'hargagudang', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'hargagudang', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},
		},
	}
}