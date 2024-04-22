export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		tanggal: { 
			title: 'Pada Tanggal', for_id: 'form_'+'tanggal', type: 'date', required: 'required', 
			name: 'tanggal', value: '', disabled: false, show: true, kinds: ''
		},
		waktu: { 
			title: 'Pada Pukul', for_id: 'form_'+'waktu', type: 'text', required: 'required', 
			name: 'waktu', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			melalui: { 
				key : 'melalui', for_id: 'form_'+'melalui', name: 'melalui', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'melalui', isrequired: true, html: 'Pasien Dihubungi Melalui', issearch: false, disabled: false,
			},
		}
	}
}