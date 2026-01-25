export const formicd9 = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama ICD 09', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		kode: { 
			title: 'Kode ICD 09', for_id: 'form_'+'kode', type: 'text', required: 'required', 
			name: 'kode', value: '', disabled: false, show: true, kinds: ''
		},
	}
}