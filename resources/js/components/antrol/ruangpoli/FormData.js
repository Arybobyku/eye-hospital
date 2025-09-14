export const formdetail = () => {
	return {
		title: '', posisi: '', uuid: '',
		ruang_poli: { 
			title: 'Nama Ruang Poli', for_id: 'form_'+'ruang_poli', type: 'text', required: 'required', 
			name: 'ruang_poli', value: '', disabled: true, show: true, kinds: ''
		},
		select: {
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: true, html: 'Nama Dokter', issearch: true, disabled: false,
			},
		}
	}
}