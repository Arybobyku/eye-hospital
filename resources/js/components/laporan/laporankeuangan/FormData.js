export const formpermintaan = () => {
	return {
		title: '', posisi: '', uuid: '', detailobat: '', listdata: '', kode: '',
		
		dari: { 
			title: 'Dari Tanggal', for_id: 'form_'+'dari', type: 'date', required: '', 
			name: 'dari', value: '', disabled: false, show: true, kinds: ''
		},
		ke: { 
			title: 'Ke Tanggal', for_id: 'form_'+'ke', type: 'date', required: '', 
			name: 'ke', value: '', disabled: false, show: true, kinds: ''
		},
		darireg: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darireg', type: 'date', required: '', 
			name: 'darireg', value: '', disabled: false, show: true, kinds: ''
		},
		kereg: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kereg', type: 'date', required: '', 
			name: 'kereg', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: false, html: 'Nama Dokter', issearch: false, disabled: false,
			},
			carabayar: { 
				key : 'carabayar', for_id: 'form_'+'carabayar', name: 'carabayar', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayar', isrequired: false, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},

			dokterreg: { 
				key : 'dokterreg', for_id: 'form_'+'dokterreg', name: 'dokterreg', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokterreg', isrequired: false, html: 'Nama Dokter', issearch: false, disabled: false,
			},
			carabayarreg: { 
				key : 'carabayarreg', for_id: 'form_'+'carabayarreg', name: 'carabayarreg', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayarreg', isrequired: false, html: 'Metode Pembayaran', issearch: false, disabled: false,
			},

			alltindakan: { 
				key : 'alltindakan', for_id: 'form_'+'alltindakan', name: 'alltindakan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'alltindakan', isrequired: false, html: 'Nama Tindakan', issearch: false, disabled: false,
			},

			asuransi: { 
				key : 'asuransi', for_id: 'form_'+'asuransi', name: 'asuransi', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'asuransi', isrequired: false, html: 'Nama Asuransi', issearch: true, disabled: true,
			},

			asuransireg: { 
				key : 'asuransireg', for_id: 'form_'+'asuransireg', name: 'asuransireg', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'asuransireg', isrequired: false, html: 'Nama Asuransi', issearch: true, disabled: true,
			},
			jenisregistrasi: { 
				key : 'jenisregistrasi', for_id: 'form_'+'jenisregistrasi', name: 'jenisregistrasi', uuid:'', value: '', label: 'Semua', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'jenisregistrasi', isrequired: false, html: 'Jenis Kunjungan', issearch: false, disabled: false,
			},
		}
	}
}

// tambahkan di luar fungsi formpermintaan, atau bisa juga di data() component
export const jenisRegistrasiOptions = [
    { value: 'semua', label: 'Semua' },
    { value: 'Rawat Inap', label: 'Rawat Inap' },
    { value: 'Rawat Jalan', label: 'Rawat Jalan' },
];