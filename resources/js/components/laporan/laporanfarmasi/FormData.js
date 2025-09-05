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
		darifaktur: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darifaktur', type: 'date', required: '', 
			name: 'darifaktur', value: '', disabled: false, show: true, kinds: ''
		},
		kefaktur: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kefaktur', type: 'date', required: '', 
			name: 'kefaktur', value: '', disabled: false, show: true, kinds: ''
		},

		dariretur: { 
			title: 'Dari Tanggal', for_id: 'form_'+'dariretur', type: 'date', required: '', 
			name: 'dariretur', value: '', disabled: false, show: true, kinds: ''
		},
		keretur: { 
			title: 'Ke Tanggal', for_id: 'form_'+'keretur', type: 'date', required: '', 
			name: 'keretur', value: '', disabled: false, show: true, kinds: ''
		},

		darikartustockall: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darikartustockall', type: 'date', required: '', 
			name: 'darikartustockall', value: '', disabled: false, show: true, kinds: ''
		},
		kekartustockall: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kekartustockall', type: 'date', required: '', 
			name: 'kekartustockall', value: '', disabled: false, show: true, kinds: ''
		},

		darikartustockgudang: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darikartustockgudang', type: 'date', required: '', 
			name: 'darikartustockgudang', value: '', disabled: false, show: true, kinds: ''
		},
		kekartustockgudang: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kekartustockgudang', type: 'date', required: '', 
			name: 'kekartustockgudang', value: '', disabled: false, show: true, kinds: ''
		},

		darikartustockapotek: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darikartustockapotek', type: 'date', required: '', 
			name: 'darikartustockapotek', value: '', disabled: false, show: true, kinds: ''
		},
		kekartustockapotek: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kekartustockapotek', type: 'date', required: '', 
			name: 'kekartustockapotek', value: '', disabled: false, show: true, kinds: ''
		},
		darikartustockbedah: { 
			title: 'Dari Tanggal', for_id: 'form_'+'darikartustockbedah', type: 'date', required: '', 
			name: 'darikartustockbedah', value: '', disabled: false, show: true, kinds: ''
		},
		kekartustockbedah: { 
			title: 'Ke Tanggal', for_id: 'form_'+'kekartustockbedah', type: 'date', required: '', 
			name: 'kekartustockbedah', value: '', disabled: false, show: true, kinds: ''
		},

		stockopnameapotek: { 
			title: 'Pilih Bulan dan Tahun', for_id: 'form_'+'stockopnameapotek', type: 'month', required: '', 
			name: 'stockopnameapotek', value: '', disabled: false, show: true, kinds: ''
		},
		stockopnamegudang: { 
			title: 'Pilih Tanggal', for_id: 'form_'+'stockopnamegudang', type: 'month', required: '', 
			name: 'stockopnamegudang', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			dokter: { 
				key : 'dokter', for_id: 'form_'+'dokter', name: 'dokter', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'dokter', isrequired: false, html: 'Nama Dokter', issearch: false, disabled: false,
			},
			supplier: { 
				key : 'supplier', for_id: 'form_'+'supplier', name: 'supplier', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'supplier', isrequired: false, html: 'Nama Supplier', issearch: false, disabled: false,
			},
			supplierretur: { 
				key : 'supplierretur', for_id: 'form_'+'supplierretur', name: 'supplierretur', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'supplierretur', isrequired: false, html: 'Nama Supplier', issearch: false, disabled: false,
			},
			obat2: { 
				key : 'obat2', for_id: 'form_'+'obat2', name: 'obat2', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'obat2', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},

			obat3: { 
				key : 'obat3', for_id: 'form_'+'obat3', name: 'obat3', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'obat3', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},

			obat: { 
				key : 'obat', for_id: 'form_'+'obat', name: 'obat', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'obat', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},
			
			apotek: {
				key : 'apotek', for_id: 'form_'+'apotek', name: 'apotek', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'apotek', isrequired: false, html: 'Nama Obat/Alkes', issearch: true, disabled: false,
			},
			bedah: {
				key : 'bedah', for_id: 'form_'+'bedah', name: 'bedah', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'bedah', isrequired: false, html: 'Nama Obat/Alkes', issearch: true, disabled: false,
			},
		}
	}
}