export const formtindakanrawatjalan = () => {
	return {
		title: '', posisi: '', uuid: '',
		label: { 
			title: 'Label', for_id: 'form_'+'label', type: 'text', required: 'required', 
			name: 'label', value: '', disabled: false, show: true, kinds: ''
		},
		sub_label: { 
			title: 'Sub Label', for_id: 'form_'+'sub_label', type: 'text', required: 'required', 
			name: 'sub_label', value: '', disabled: false, show: true, kinds: ''
		},
		nama: { 
			title: 'Nama', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		harga: { 
			title: 'Harga', for_id: 'form_'+'harga', type: 'text', required: 'required', 
			name: 'harga', value: '', disabled: false, show: true, kinds: ''
		},
	}
}