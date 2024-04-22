export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Unit', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
	}
}