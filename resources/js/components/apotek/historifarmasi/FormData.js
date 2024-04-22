export const formpembeli = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama:{
			title: 'Nama Pembeli', for_id: 'form_'+'nama', type: 'text', required: '', 
			name: 'nama', value: 'Pasien Bebas', disabled: false, show: true, kinds: ''
		},

		jenis:{
			title: 'Jenis Obat', for_id: 'form_'+'jenis', type: 'text', required: '', 
			name: 'jenis', value: 'Non Racikan', disabled: false, show: true, kinds: ''
		},
	}
}

export const formkelurahan = () => {
	return {
		title: '', posisi: '', uuid: '', ispending: '',
		
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

			carabayartindakanrawatjalan: {
				key : 'carabayartindakanrawatjalan', for_id: 'form_'+'carabayartindakanrawatjalan', name: 'carabayartindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				db_table: 'carabayar_tindakan_rawat_jalan', dosearch: false,
				class: 'carabayartindakanrawatjalan', isrequired: false, html: 'Tindakan/Layanan', issearch: true, disabled: false,
			},
			
		}
	}
}

export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		carabayar_uuid: '',
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
		
		signa:{
			title: 'Signa', for_id: 'form_'+'signa', type: 'text', required: '', 
			name: 'signa', value: '', disabled: false, show: true, kinds: ''
		},

		quantity:{
			title: 'Quantity', for_id: 'form_'+'quantity', type: 'number', required: '', 
			name: 'quantity', value: '', disabled: false, show: true, kinds: ''
		},

		
		quantityracikan:{
			title: 'Quantity', for_id: 'form_'+'quantityracikan', type: 'number', required: '', 
			name: 'quantityracikan', value: '', disabled: false, show: true, kinds: ''
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

			carabayartindakanrawatjalan: {
				key : 'carabayartindakanrawatjalan', for_id: 'form_'+'carabayartindakanrawatjalan', name: 'carabayartindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				db_table: 'carabayar_tindakan_rawat_jalan', dosearch: false,
				class: 'carabayartindakanrawatjalan', isrequired: false, html: 'Tindakan/Layanan', issearch: true, disabled: false,
			},
		}
	}
}