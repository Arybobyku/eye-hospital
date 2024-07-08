export const formcetakan = () => {
	return {
		title: '', posisi: '', uuid: '', ispending: '', m1: '', m2: '', r1: '', r2: '', r3: '', r4: '',

		konsuldi:{
			title: 'Di tempat/lokasi', for_id: 'form_'+'konsuldi', type: 'text', required: 'required', 
			name: 'konsuldi', value: '', disabled: false, show: true, kinds: ''
		},

		konsulyth:{
			title: 'Yang Terhormat', for_id: 'form_'+'konsulyth', type: 'text', required: 'required', 
			name: 'konsulyth', value: '', disabled: false, show: true, kinds: ''
		},

		konsuldiagnosa:{
			title: 'Keterangan Diagnosa', for_id: 'form_'+'konsuldiagnosa', type: 'text', required: 'required', 
			name: 'konsuldiagnosa', value: '', disabled: false, show: true, kinds: '', baris: '5'
		},

		konsultindakan:{
			title: 'Keterangan Tindakan', for_id: 'form_'+'konsultindakan', type: 'text', required: 'required', 
			name: 'konsultindakan', value: '', disabled: false, show: true, kinds: '', baris: '5'
		},

		balasankonsuldi:{
			title: 'Di tempat/lokasi', for_id: 'form_'+'balasankonsuldi', type: 'text', required: 'required', 
			name: 'balasankonsuldi', value: '', disabled: false, show: true, kinds: ''
		},

		balasankonsulyth:{
			title: 'Yang Terhormat', for_id: 'form_'+'balasankonsulyth', type: 'text', required: 'required', 
			name: 'balasankonsulyth', value: '', disabled: false, show: true, kinds: ''
		},

		balasankonsuldiagnosa:{
			title: 'Keterangan Diagnosa', for_id: 'form_'+'balasankonsuldiagnosa', type: 'text', required: 'required', 
			name: 'balasankonsuldiagnosa', value: '', disabled: false, show: true, kinds: '', baris: '5'
		},

		balasankonsultindakan:{
			title: 'Keterangan Tindakan', for_id: 'form_'+'balasankonsultindakan', type: 'text', required: 'required', 
			name: 'balasankonsultindakan', value: '', disabled: false, show: true, kinds: '', baris: '5'
		},

		istirahatjumlahhari:{
			title: 'Jumlah Hari', for_id: 'form_'+'istirahatjumlahhari', type: 'number', required: 'required', 
			name: 'istirahatjumlahhari', value: '', disabled: false, show: true, kinds: ''
		},
		istirahatmulai:{
			title: 'Dimual pada tanggal', for_id: 'form_'+'istirahatmulai', type: 'date', required: 'required', 
			name: 'istirahatmulai', value: '', disabled: false, show: true, kinds: ''
		},
		istirahatsampai:{
			title: 'Sampai ke tanggal', for_id: 'form_'+'istirahatsampai', type: 'date', required: 'required', 
			name: 'istirahatsampai', value: '', disabled: false, show: true, kinds: ''
		},
		istirahatdiagnosa:{
			title: 'Keterangan Diagnosa', for_id: 'form_'+'istirahatdiagnosa', type: 'text', required: 'required', 
			name: 'istirahatdiagnosa', value: '', disabled: false, show: true, kinds: '', baris: '5'
		},
	}
}

export const formtransfer = () => {
	return {
		title: '', posisi: '', uuid: '',
		registrasi_uuid: '',
		tarif: '',
		select : {
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: false, html: 'Dokter yang menangani', issearch: false, disabled: false,
			},
		pilihanplan: { 
				key : 'pilihanplan', for_id: 'form_'+'pilihanplan', name: 'pilihanplan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'pilihanplan', isrequired: false, html: 'Pilih Planning', issearch: false, disabled: false,
			},
		}
	}
}

export const formkontrol = () => {
	return {
		title: '', posisi: '', uuid: '',
		registrasi_uuid: '',
		tarif: '',
		tanggalkontrol:{
			title: 'Tanggal', for_id: 'form_'+'tanggalkontrol', type: 'date', required: 'required', 
			name: 'tanggalkontrol', value: '', disabled: false, show: true, kinds: ''
		},
		waktukontrol:{
			title: 'Waktu', for_id: 'form_'+'waktukontrol', type: 'text', required: 'required', 
			name: 'waktukontrol', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formkelurahan = () => {
	return {
		title: '', posisi: '', uuid: '', ispending: '',

		inapjalan: '',
		
		carabayar_nama: '',
		kamar_inap_uuid: '',
		kamar_inap_nama: '',
		kamar_inap_lantai: '',
		kamar_inap_jumlah_bed: '',
		jenis_kamar_uuid: '',
		nama_jenis_kamar: '',

		kamar_inap_jalan_uuid: '',
		kamar_inap_jalan_nama: '',
		kamar_inap_jalan_lantai: '',
		kamar_inap_jalan_jumlah_bed: '',
		jenis_kamar_jalan_uuid: '',
		nama_jenis_jalan_kamar: '',

		catatan:{
			title: 'Catatan', for_id: 'form_'+'catatan', type: 'text', required: '', 
			name: 'catatan', value: '', disabled: false, show: true, kinds: ''
		},

		penjadwalanodc:{
			title: 'Penjadwalan Bedah (One Day Care)', for_id: 'form_'+'penjadwalanodc', type: 'date', required: '', 
			name: 'penjadwalanodc', value: '', disabled: false, show: true, kinds: ''
		},

		waktuodc:{
			title: 'Pada Pukul', for_id: 'form_'+'waktuodc', type: 'time', required: '', 
			name: 'waktuodc', value: '', disabled: false, show: true, kinds: ''
		},

		paketodc:{
			title: 'Paket Bedah yang Diinginkan', for_id: 'form_'+'paketodc', type: 'text', required: '', 
			name: 'paketodc', value: '', disabled: false, show: true, kinds: ''
		},

		penjadwalanbedah:{
			title: 'Penjadwalan Bedah', for_id: 'form_'+'penjadwalanbedah', type: 'date', required: '', 
			name: 'penjadwalanbedah', value: '', disabled: false, show: true, kinds: ''
		},

		waktubedah:{
			title: 'Pada Pukul', for_id: 'form_'+'waktubedah', type: 'text', required: '', 
			name: 'waktubedah', value: '', disabled: false, show: true, kinds: ''
		},

		paketbedah:{
			title: 'Paket Bedah yang Diinginkan', for_id: 'form_'+'paketbedah', type: 'text', required: '', 
			name: 'paketbedah', value: '', disabled: false, show: true, kinds: ''
		},

		paketbedahbedah:{
			title: 'Paket Bedah yang Diinginkan', for_id: 'form_'+'paketbedahbedah', type: 'text', required: '', 
			name: 'paketbedahbedah', value: '', disabled: false, show: true, kinds: ''
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

		anamnese:{
			title: 'Anamnese', for_id: 'form_'+'anamnese', type: 'text', required: '', 
			name: 'anamnese', value: '', disabled: false, show: true, kinds: ''
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

		hargapaket: '',
		hargabedahpaket: '',

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

		keteranganpanjar:{
			title: 'Keterangan Panjar', for_id: 'form_'+'keteranganpanjar', type: 'text', required: '', 
			name: 'keteranganpanjar', value: '', disabled: false, show: true, kinds: ''
		},

		keteranganbedah:{
			title: 'Keterangan Bedah', for_id: 'form_'+'keteranganbedah', type: 'text', required: '', 
			name: 'keteranganbedah', value: '', disabled: false, show: true, kinds: ''
		},

		keteranganbedahbedah:{
			title: 'Keterangan Bedah', for_id: 'form_'+'keteranganbedahbedah', type: 'text', required: '', 
			name: 'keteranganbedahbedah', value: '', disabled: false, show: true, kinds: ''
		},

		keteranganinap:{
			title: 'Keterangan/alasan Rawat Inap', for_id: 'form_'+'keteranganinap', type: 'text', required: '', 
			name: 'keteranganinap', value: '', disabled: false, show: true, kinds: '', baris: '6'
		},

		signa:{
			title: 'Signa', for_id: 'form_'+'signa', type: 'text', required: '', 
			name: 'signa', value: '', disabled: false, show: true, kinds: ''
		},

		quantity:{
			title: 'Quantity', for_id: 'form_'+'quantity', type: 'number', required: '', 
			name: 'quantity', value: '', disabled: false, show: true, kinds: ''
		},

		labelracikan:{
			title: 'Nama Racikan', for_id: 'form_'+'labelracikan', type: 'text', required: '', 
			name: 'labelracikan', value: '', disabled: false, show: true, kinds: ''
		},

		jeniskemasan:{
			title: 'Jenis Kemasan', for_id: 'form_'+'jeniskemasan', type: 'text', required: '', 
			name: 'jeniskemasan', value: '', disabled: false, show: true, kinds: ''
		},

		jumlahkemasan:{
			title: 'Jumlah Kemasan', for_id: 'form_'+'jumlahkemasan', type: 'number', required: '', 
			name: 'jumlahkemasan', value: '', disabled: false, show: true, kinds: ''
		},

		signaracikan:{
			title: 'Signa', for_id: 'form_'+'signaracikan', type: 'text', required: '', 
			name: 'signaracikan', value: '', disabled: false, show: true, kinds: ''
		},

		dosisdiperlukan:{
			title: 'Dosis yang diperlukan', for_id: 'form_'+'dosisdiperlukan', type: 'text', required: '', 
			name: 'dosisdiperlukan', value: '', disabled: false, show: true, kinds: ''
		},

		komposisi:{
			title: 'Komposisi yang Tertera Pada Kemasan', for_id: 'form_'+'komposisi', type: 'number', required: '', 
			name: 'komposisi', value: '', disabled: false, show: true, kinds: ''
		},

		select: {
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
				db_table: 'carabayar_tindakan_rawat_jalan', dosearch: false,
				class: 'carabayartindakanrawatjalan', isrequired: false, html: 'Tindakan/Layanan', issearch: true, disabled: false,
			},

			carabayartindakanrawatjalanjalan: {
				key : 'carabayartindakanrawatjalanjalan', for_id: 'form_'+'carabayartindakanrawatjalanjalan', name: 'carabayartindakanrawatjalanjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				db_table: 'carabayar_tindakan_rawat_jalan', dosearch: false,
				class: 'carabayartindakanrawatjalanjalan', isrequired: false, html: 'Tindakan/Layanan', issearch: true, disabled: false,
			},

			apotek: {
				key : 'apotek', for_id: 'form_'+'apotek', name: 'apotek', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotek', isrequired: false, html: 'Nama Obat/Alkes', issearch: true, disabled: false,
			},

			satuankomposisi: {
				key : 'satuankomposisi', for_id: 'form_'+'satuankomposisi', name: 'satuankomposisi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'satuankomposisi', isrequired: false, html: 'Satuan Komposisi', issearch: true, disabled: false,
			},

			satuandiperlukan: {
				key : 'satuandiperlukan', for_id: 'form_'+'satuandiperlukan', name: 'satuandiperlukan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'satuandiperlukan', isrequired: false, html: 'Satuan yang diperlukan', issearch: true, disabled: false,
			},

			apotekracikan: {
				key : 'apotekracikan', for_id: 'form_'+'apotekracikan', name: 'apotekracikan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotekracikan', isrequired: false, html: 'Nama Obat/Alkes', issearch: true, disabled: false,
			},

			paketbedah: {
				key : 'paketbedah', for_id: 'form_'+'paketbedah', name: 'paketbedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'paketbedah', isrequired: false, html: 'Nama Paket Bedah', issearch: true, disabled: false,
			},

			paketbedahbedah: {
				key : 'paketbedahbedah', for_id: 'form_'+'paketbedahbedah', name: 'paketbedahbedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'paketbedahbedah', isrequired: false, html: 'Nama Paket Bedah', issearch: true, disabled: false,
			},

			carabayar: { 
				key : 'carabayar', for_id: 'form_'+'carabayar', name: 'carabayar', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayar', isrequired: false, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},
			pilihanplan: { 
				key : 'pilihanplan', for_id: 'form_'+'pilihanplan', name: 'pilihanplan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pilihanplan', isrequired: false, html: 'Pilih Planning', issearch: false, disabled: false,
			},

			
			

			asuransi: { 
				key : 'asuransi', for_id: 'form_'+'asuransi', name: 'asuransi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'asuransi', isrequired: false, html: 'Nama Asuransi', issearch: true, disabled: true,
			},

			carabayarbedah: { 
				key : 'carabayarbedah', for_id: 'form_'+'carabayarbedah', name: 'carabayarbedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayarbedah', isrequired: false, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},

			asuransibedah: { 
				key : 'asuransibedah', for_id: 'form_'+'asuransibedah', name: 'asuransibedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'asuransibedah', isrequired: false, html: 'Nama Asuransi', issearch: true, disabled: true,
			},

			kamarinap: { 
				key : 'kamarinap', for_id: 'form_'+'kamarinap', name: 'kamarinap', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kamarinap', isrequired: false, html: 'Nama Kamar', issearch: true, disabled: false,
			},

			kamarinapjalan: { 
				key : 'kamarinapjalan', for_id: 'form_'+'kamarinapjalan', name: 'kamarinapjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kamarinapjalan', isrequired: false, html: 'Nama Kamar', issearch: true, disabled: false,
			},
			
		}
	}
}