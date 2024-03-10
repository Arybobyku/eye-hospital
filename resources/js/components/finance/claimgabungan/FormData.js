export const formpermintaan = () => {
	return {
		title: '', posisi: '', uuid: '', detailobat: '', listdata: '', kode: '',
		
		dariprodia: { 
			title: 'Dari Tanggal', for_id: 'form_'+'dariprodia', type: 'date', required: '', 
			name: 'dariprodia', value: '', disabled: false, show: true, kinds: ''
		},
		keprodia: { 
			title: 'Ke Tanggal', for_id: 'form_'+'keprodia', type: 'date', required: '', 
			name: 'keprodia', value: '', disabled: false, show: true, kinds: ''
		},

		daribpjstk: { 
			title: 'Dari Tanggal', for_id: 'form_'+'daribpjstk', type: 'date', required: '', 
			name: 'daribpjstk', value: '', disabled: false, show: true, kinds: ''
		},
		kebpjstk: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kebpjstk', type: 'date', required: '', 
			name: 'kebpjstk', value: '', disabled: false, show: true, kinds: ''
		},

		darisocfindo: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darisocfindo', type: 'date', required: '', 
			name: 'darisocfindo', value: '', disabled: false, show: true, kinds: ''
		},
		kesocfindo: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kesocfindo', type: 'date', required: '', 
			name: 'kesocfindo', value: '', disabled: false, show: true, kinds: ''
		},

		daripln: { 
			title: 'Dari Tanggal', for_id: 'form_'+'daripln', type: 'date', required: '', 
			name: 'daripln', value: '', disabled: false, show: true, kinds: ''
		},
		kepln: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kepln', type: 'date', required: '', 
			name: 'kepln', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '', dari: '', ke: '', posisi: '',
		kwitansi: { 
			title: 'No Kwitansi Claim', for_id: 'form_'+'kwitansi', type: 'text', required: 'required', 
			name: 'kwitansi', value: '', disabled: false, show: true, kinds: ''
		},
		claimadditional: { 
			title: 'Data Lainnya (Opsional)', for_id: 'form_'+'claimadditional', type: 'text', required: '', 
			name: 'claimadditional', value: '', disabled: false, show: true, kinds: ''
		},
	}
}