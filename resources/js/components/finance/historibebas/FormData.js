export const formkelurahan = () => {
	return {
		title: '', posisi: '', uuid: '', ispending: '',
		
		carabayar_nama: '',

		catatan:{
			title: 'Catatan', for_id: 'form_'+'catatan', type: 'text', required: '', 
			name: 'catatan', value: '', disabled: false, show: true, kinds: ''
		},

		posisibolamata:{
			title: 'Posisi Bola Mata', for_id: 'form_'+'posisibolamata', type: 'text', required: '', 
			name: 'posisibolamata', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		pergerakanbolamata:{
			title: 'Pergerakan Bola Mata', for_id: 'form_'+'pergerakanbolamata', type: 'text', required: '', 
			name: 'pergerakanbolamata', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		pemeriksaanprognosa:{
			title: 'Prognosa', for_id: 'form_'+'pemeriksaanprognosa', type: 'text', required: '', 
			name: 'pemeriksaanprognosa', value: '', disabled: false, show: true, kinds: ''
		},

		pemeriksaanpenunjang:{
			title: 'Pemeriksaan Penunjang', for_id: 'form_'+'pemeriksaanpenunjang', type: 'text', required: '', 
			name: 'pemeriksaanpenunjang', value: '', disabled: false, show: true, kinds: ''
		},

		pemeriksaantatalaksana:{
			title: 'Tata Laksana', for_id: 'form_'+'pemeriksaantatalaksana', type: 'text', required: '', 
			name: 'pemeriksaantatalaksana', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrapalpebra:{
			title: 'Palpebra', for_id: 'form_'+'oculardextrapalpebra', type: 'text', required: '', 
			name: 'oculardextrapalpebra', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextraconjunctiva:{
			title: 'Conjunctiva', for_id: 'form_'+'oculardextraconjunctiva', type: 'text', required: '', 
			name: 'oculardextraconjunctiva', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextracornea:{
			title: 'Cornea', for_id: 'form_'+'oculardextracornea', type: 'text', required: '', 
			name: 'oculardextracornea', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextralensa:{
			title: 'Lensa', for_id: 'form_'+'oculardextralensa', type: 'text', required: '', 
			name: 'oculardextralensa', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextravitreous:{
			title: 'Vitreous', for_id: 'form_'+'oculardextravitreous', type: 'text', required: '', 
			name: 'oculardextravitreous', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextrafunduscopy:{
			title: 'Funduscopy', for_id: 'form_'+'oculardextrafunduscopy', type: 'text', required: '', 
			name: 'oculardextrafunduscopy', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextrabilikmatadepan:{
			title: 'Bilik Mata Depan', for_id: 'form_'+'oculardextrabilikmatadepan', type: 'text', required: '', 
			name: 'oculardextrabilikmatadepan', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		oculardextrapupildaniris:{
			title: 'Pupil dan Iris', for_id: 'form_'+'oculardextrapupildaniris', type: 'text', required: '', 
			name: 'oculardextrapupildaniris', value: 'Normal', disabled: false, show: true, kinds: ''
		},



		ocularsinistrapalpebra:{
			title: 'Palpebra', for_id: 'form_'+'ocularsinistrapalpebra', type: 'text', required: '', 
			name: 'ocularsinistrapalpebra', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistraconjunctiva:{
			title: 'Conjunctiva', for_id: 'form_'+'ocularsinistraconjunctiva', type: 'text', required: '', 
			name: 'ocularsinistraconjunctiva', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistracornea:{
			title: 'Cornea', for_id: 'form_'+'ocularsinistracornea', type: 'text', required: '', 
			name: 'ocularsinistracornea', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistralensa:{
			title: 'Lensa', for_id: 'form_'+'ocularsinistralensa', type: 'text', required: '', 
			name: 'ocularsinistralensa', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistravitreous:{
			title: 'Vitreous', for_id: 'form_'+'ocularsinistravitreous', type: 'text', required: '', 
			name: 'ocularsinistravitreous', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistrafunduscopy:{
			title: 'Funduscopy', for_id: 'form_'+'ocularsinistrafunduscopy', type: 'text', required: '', 
			name: 'ocularsinistrafunduscopy', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistrabilikmatadepan:{
			title: 'Bilik Mata Depan', for_id: 'form_'+'ocularsinistrabilikmatadepan', type: 'text', required: '', 
			name: 'ocularsinistrabilikmatadepan', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		ocularsinistrapupildaniris:{
			title: 'Pupil dan Iris', for_id: 'form_'+'ocularsinistrapupildaniris', type: 'text', required: '', 
			name: 'ocularsinistrapupildaniris', value: 'Normal', disabled: false, show: true, kinds: ''
		},

		panjar:{
			title: 'Panjar', for_id: 'form_'+'panjar', type: 'number', required: '', 
			name: 'panjar', value: '', disabled: false, show: true, kinds: ''
		},

		signa:{
			title: 'Signa', for_id: 'form_'+'signa', type: 'text', required: '', 
			name: 'signa', value: '', disabled: false, show: true, kinds: ''
		},

		signa:{
			title: 'Signa', for_id: 'form_'+'signa', type: 'text', required: '', 
			name: 'signa', value: '', disabled: false, show: true, kinds: ''
		},

		quantity:{
			title: 'Quantity', for_id: 'form_'+'quantity', type: 'number', required: '', 
			name: 'quantity', value: '', disabled: false, show: true, kinds: ''
		},


		select: {
			metodepembayaran: {
				key : 'metodepembayaran', for_id: 'form_'+'metodepembayaran', name: 'metodepembayaran', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'metodepembayaran', isrequired: false, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},
			icd9: {
				key : 'icd9', for_id: 'form_'+'icd9', name: 'icd9', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'icd9', isrequired: false, html: 'Data ICD 9', issearch: true, disabled: false,
			},	
			icd10: {
				key : 'icd10', for_id: 'form_'+'icd10', name: 'icd10', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'icd10', isrequired: false, html: 'Data ICD 10', issearch: true, disabled: false,
			},
			carabayartindakanrawatjalan: {
				key : 'carabayartindakanrawatjalan', for_id: 'form_'+'carabayartindakanrawatjalan', name: 'carabayartindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayartindakanrawatjalan', isrequired: false, html: 'Tindakan/Layanan', issearch: true, disabled: false,
			},

			apotek: {
				key : 'apotek', for_id: 'form_'+'apotek', name: 'apotek', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotek', isrequired: false, html: 'Nama Obat', issearch: true, disabled: false,
			},
			
		}
	}
}

export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		select: {
			metodepembayaran: {
				key : 'metodepembayaran', for_id: 'form_'+'metodepembayaran', name: 'metodepembayaran', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'metodepembayaran', isrequired: true, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},
		}
	}
}