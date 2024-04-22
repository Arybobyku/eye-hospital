export const formtindakanbedah = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Tindakan', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		select : {
			jenis: { 
				key : 'jenis', for_id: 'form_'+'jenis', name: 'jenis', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenis', isrequired: true, html: 'Jenis Tindakan', issearch: false, disabled: false,
			},
		}
	}
}