export const formruangan = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Ruangan', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		lantai: { 
			title: 'Lantai ke', for_id: 'form_'+'lantai', type: 'number', required: 'required', 
			name: 'lantai', value: '', disabled: false, show: true, kinds: ''
		},
		jumlahbed: { 
			title: 'Jumlah Tempat Tidur', for_id: 'form_'+'jumlahbed', type: 'number', required: 'required', 
			name: 'jumlahbed', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			jenisruangan: { 
				key : 'jenisruangan', for_id: 'form_'+'jenisruangan', name: 'jenisruangan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenisruangan', isrequired: true, html: 'Jenis Ruangan', issearch: false, disabled: false,
			},
		}
	}
}