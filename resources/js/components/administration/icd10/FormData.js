export const formicd10 = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama ICD 10', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		kode: { 
			title: 'Kode ICD 10', for_id: 'form_'+'kode', type: 'text', required: 'required', 
			name: 'kode', value: '', disabled: false, show: true, kinds: ''
		},
	}
}