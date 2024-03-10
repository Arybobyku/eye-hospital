export const formkabkota = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Kabupaten/Kota', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			provinsi: { 
				key : 'provinsi', for_id: 'form_'+'provinsi', name: 'provinsi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'provinsi', isrequired: true, html: 'Nama Provinsi', issearch: true, disabled: false,
			},
		}
	}
}