export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama yang memesan barang', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formpermohonan = () => {
	return {
		title: '', posisi: '', uuid: '', label_permohonan_uuid: '',
		jumlah: { 
			title: 'Jumlah Permohonan', for_id: 'form_'+'jumlah', type: 'text', required: 'required', 
			name: 'jumlah', value: '', disabled: false, show: true, kinds: ''
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