export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		nopendaftaran: { 
			title: 'Nomor Antrian', for_id: 'form_'+'nopendaftaran', type: 'text', required: 'required', 
			name: 'nopendaftaran', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			berkebutuhankhusus: { 
				key : 'berkebutuhankhusus', for_id: 'form_'+'berkebutuhankhusus', name: 'berkebutuhankhusus', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'berkebutuhankhusus', isrequired: true, html: 'Berkebutuhan Khusus/Triase/Disabilitas?', issearch: false, disabled: false,
			},
			
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: true, html: 'Dokter yang menangani', issearch: false, disabled: false,
			},
		}
	}
}