export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		jenis: '',
		registrasi_uuid: '',
		carabayar_uuid: '',
		carabayar_nama: '',
		layanan_uuid: '',
		nama_layanan: '',
		tarif: '',
		select: {
			carabayartindakanrawatjalan: { 
				key : 'carabayartindakanrawatjalan', for_id: 'form_'+'carabayartindakanrawatjalan', name: 'carabayartindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayartindakanrawatjalan', isrequired: true, html: 'Nama Tindakan', issearch: true, disabled: false,
			},
		}
	}
}

export const formkontrol = () => {
	return {
		title: '', posisi: '', uuid: '',
		jenis: '',
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

export const formrawatinap = () => {
	return {
		title: '', posisi: '', uuid: '',
		registrasi_uuid: '',
		tanggal_masuk_inap:{
			title: 'Tanggal Masuk Kamar', for_id: 'form_'+'tanggal_masuk_inap', type: 'date', required: '', 
			name: 'tanggal_masuk_inap', value: '', disabled: false, show: true, kinds: ''
		},
		
		imagetes:{
			title: 'Image', for_id: 'form_'+'imagetes', type: 'file', required: '', 
			name: 'imagetes', value: '', disabled: false, show: true, kinds: ''
		},
		
		waktu_masuk_inap:{
			title: 'Pada Pukul', for_id: 'form_'+'waktu_masuk_inap', type: 'time', required: '', 
			name: 'waktu_masuk_inap', value: '', disabled: false, show: true, kinds: ''
		},

		select: {
		kamarinap: { 
				key : 'kamarinap', for_id: 'form_'+'kamarinap', name: 'kamarinap', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kamarinap', isrequired: false, html: 'Nama Kamar', issearch: true, disabled: false,
			},

			}
	}
}

export const formdetaildokter = () => {
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
		}
	}
}


export const formobat = () => {
		return {
		title: '', posisi: '', uuid: '', ispending: '',
		registrasi_uuid: '',
		
		carabayar_nama: '',

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

		catatan:{
			title: 'Catatan', for_id: 'form_'+'catatan', type: 'text', required: '', 
			name: 'catatan', value: '', disabled: false, show: true, kinds: ''
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

			apotek: {
				key : 'apotek', for_id: 'form_'+'apotek', name: 'apotek', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotek', isrequired: false, html: 'Nama Obat', issearch: true, disabled: false,
			},

			apotekracikan: {
				key : 'apotekracikan', for_id: 'form_'+'apotekracikan', name: 'apotekracikan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotekracikan', isrequired: false, html: 'Nama Obat/Alkes', issearch: true, disabled: false,
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

			
		}
	}
}

export const formresep = () => {
	return {
		title: '', posisi: '', uuid: '', ispending: '',
		jenis: '',
		registrasi_uuid: '',
		carabayar_nama: '',
		carabayar_uuid: '',

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

		catatan:{
			title: 'Catatan', for_id: 'form_'+'catatan', type: 'text', required: '', 
			name: 'catatan', value: '', disabled: false, show: true, kinds: ''
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

			apotek: {
				key : 'apotek', for_id: 'form_'+'apotek', name: 'apotek', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotek', isrequired: false, html: 'Nama Obat', issearch: true, disabled: false,
			},

			apotekracikan: {
				key : 'apotekracikan', for_id: 'form_'+'apotekracikan', name: 'apotekracikan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotekracikan', isrequired: false, html: 'Nama Obat/Alkes', issearch: true, disabled: false,
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

						posisimata: { 
				key : 'posisimata', for_id: 'form_'+'posisimata', name: 'posisimata', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'posisimata', isrequired: false, html: 'Posisi Mata', issearch: false, disabled: false,
			},
			
		}
	}
}