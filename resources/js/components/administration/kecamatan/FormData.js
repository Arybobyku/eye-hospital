export const formkecamatan = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Kecamatan', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			kabkota: { 
				key : 'kabkota', for_id: 'form_'+'kabkota', name: 'kabkota', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kabkota', isrequired: true, html: 'Nama Kabupaten/Kota', issearch: true, disabled: false,
			},
		}
	}
}