export const formpermintaan = () => {
	return {
		title: '', posisi: '', uuid: '', detailobat: '', listdata: '', kode: '',
		
		jumlah: { 
			title: 'Jumlah yang diminta (Dari satuan kecil)', for_id: 'form_'+'jumlah', type: 'number', required: 'required', 
			name: 'jumlah', value: '', disabled: true, show: true, kinds: ''
		},
		select: {
			obatgudang: { 
				key : 'obatgudang', for_id: 'form_'+'obatgudang', name: 'obatgudang', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'obatgudang', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},
		}
	}
}