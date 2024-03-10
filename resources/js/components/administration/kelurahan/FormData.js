export const formkelurahan = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Kelurahan', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			kecamatan: { 
				key : 'kecamatan', for_id: 'form_'+'kecamatan', name: 'kecamatan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kecamatan', isrequired: true, html: 'Nama Kecamatan', issearch: true, disabled: false,
			},
		}
	}
}