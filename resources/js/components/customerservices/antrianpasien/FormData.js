
export const formantrian = () => {
	return {
		title: '', posisi: '', uuid: '', photos: '',
		select: {
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: true, html: 'Dokter yang menangani', issearch: false, disabled: false,
			},
		}
	}
}