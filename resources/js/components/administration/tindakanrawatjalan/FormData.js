export const formtindakanrawatjalan = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Tindakan', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		jenis: { 
			title: 'Label', for_id: 'form_'+'jenis', type: 'text', required: 'required', 
			name: 'jenis', value: '', disabled: false, show: true, kinds: ''
		},
	}
}