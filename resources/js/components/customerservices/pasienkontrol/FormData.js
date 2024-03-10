export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		select: {
			klinik: { 
				key : 'klinik', for_id: 'form_'+'melalui', name: 'klinik', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'klinik', isrequired: true, html: 'Poli Tujuan Kontrol', issearch: false, disabled: false,
			},
		}
	}
}