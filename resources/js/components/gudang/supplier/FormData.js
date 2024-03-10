export const formsupplier = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Supplier', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		alamat: { 
			title: 'Alamat', for_id: 'form_'+'alamat', type: 'text', required: 'required', 
			name: 'alamat', value: '', disabled: false, show: true, kinds: ''
		},
		kontak: { 
			title: 'Kontak', for_id: 'form_'+'kontak', type: 'text', required: 'required', 
			name: 'kontak', value: '', disabled: false, show: true, kinds: ''
		},
	}
}