export const formpermintaan = () => {
	return {
		title: '', posisi: '', uuid: '', detailobat: '', listdata: '', kode: '',
		
		dari: { 
			title: 'Dari Tanggal', for_id: 'form_'+'dari', type: 'date', required: 'required', 
			name: 'dari', value: '', disabled: true, show: true, kinds: ''
		},
		ke: { 
			title: 'Ke Tanggal', for_id: 'form_'+'ke', type: 'date', required: 'required', 
			name: 'ke', value: '', disabled: true, show: true, kinds: ''
		},
	}
}