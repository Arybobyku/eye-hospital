export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		tanggal: { 
			title: 'Tanggal', for_id: 'form_'+'tanggal', type: 'date', required: 'required', 
			name: 'tanggal', value: '', disabled: false, show: true, kinds: ''
		},
		jam: { 
			title: 'Pukul', for_id: 'form_'+'jam', type: 'text', required: 'required', 
			name: 'jam', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formbalance = () => {
	return {
		title: '', posisi: '', uuid: '', label_stockopname_uuid: '',
		jumlah: { 
			title: 'Jumlah Fisik/Satuan Kecil', for_id: 'form_'+'jumlah', type: 'text', required: 'required', 
			name: 'jumlah', value: '', disabled: false, show: true, kinds: ''
		},
		select: { 
			obatgudang: { 
				key : 'obatgudang', for_id: 'form_'+'obatgudang', name: 'obatgudang', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'obatgudang', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},
		},
	}
}