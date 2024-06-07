export const formjeniskamar = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Jenis Kamar', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
	}
}