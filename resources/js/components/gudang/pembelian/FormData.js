export const formfaktur = () => {
	return {
		title: '', posisi: '', uuid: '',
		nofaktur: { 
			title: 'No Faktur', for_id: 'form_'+'nofaktur', type: 'text', required: 'required', 
			name: 'nofaktur', value: '', disabled: false, show: true, kinds: ''
		},
		tanggalfaktur: { 
			title: 'Tanggal Faktur', for_id: 'form_'+'tanggalfaktur', type: 'date', required: 'required', 
			name: 'tanggalfaktur', value: '', disabled: false, show: true, kinds: ''
		},
		ppn: { 
			title: 'PPN', for_id: 'form_'+'ppn', type: 'number', required: 'required', 
			name: 'ppn', value: '', disabled: false, show: true, kinds: ''
		},
		jangkawaktu: { 
			title: 'Jangka Waktu', for_id: 'form_'+'jangkawaktu', type: 'number', required: 'required', 
			name: 'jangkawaktu', value: '', disabled: false, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan', for_id: 'form_'+'keterangan', type: 'text', required: '', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
		},
		select : {
			pembayaran: { 
				key : 'pembayaran', for_id: 'form_'+'pembayaran', name: 'pembayaran', uuid: '', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pembayaran', isrequired: true, html: 'Jenis Pembayaran', issearch: true, disabled: false,
			},
			supplier: { 
				key : 'supplier', for_id: 'form_'+'supplier', name: 'supplier', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'supplier', isrequired: true, html: 'Nama Supplier', issearch: true, disabled: false,
			},
		}
	}
}

export const formobat = () => {
	return {
		title: '', posisi: '', uuid: '', detailobat: '', detailfaktur: '', listdata: '',
		jumlahkecil: { 
			title: 'Jumlah Satuan Kecil', for_id: 'form_'+'jumlahkecil', type: 'number', required: 'required', 
			name: 'jumlahkecil', value: '', disabled: false, show: true, kinds: ''
		},
		jumlahbesar: { 
			title: 'Jumlah / Satuan Besar', for_id: 'form_'+'jumlahbesar', type: 'number', required: 'required', 
			name: 'jumlahbesar', value: '', disabled: false, show: true, kinds: ''
		},
		hargakecil: { 
			title: 'Harga / Satuan Kecil', for_id: 'form_'+'hargakecil', type: 'number', required: 'required', 
			name: 'hargakecil', value: '', disabled: false, show: true, kinds: ''
		},
		hargabesar: { 
			title: 'Harga / Satuan Besar', for_id: 'form_'+'hargabesar', type: 'number', required: 'required', 
			name: 'hargabesar', value: '', disabled: false, show: true, kinds: ''
		},
		jumlahdiskon: { 
			title: 'Diskon (%)', for_id: 'form_'+'jumlahdiskon', type: 'number', required: '', 
			name: 'jumlahdiskon', value: '', disabled: false, show: true, kinds: ''
		},
		hargakecildiskon: { 
			title: '(Diskon) Harga / Satuan Kecil', for_id: 'form_'+'hargakecildiskon', type: 'number', required: 'required', 
			name: 'hargakecildiskon', value: '', disabled: true, show: true, kinds: ''
		},
		hargabesardiskon: { 
			title: '(Diskon) Harga / Satuan Besar', for_id: 'form_'+'hargabesardiskon', type: 'number', required: 'required', 
			name: 'hargabesardiskon', value: '', disabled: true, show: true, kinds: ''
		},
		batch: { 
			title: 'Batch', for_id: 'form_'+'batch', type: 'text', required: 'required', 
			name: 'batch', value: '', disabled: false, show: true, kinds: ''
		},
		expireddate: { 
			title: 'Kadaluarsa', for_id: 'form_'+'expireddate', type: 'date', required: 'required', 
			name: 'expireddate', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			obat: { 
				key : 'obat', for_id: 'form_'+'obat', name: 'obat', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'obat', isrequired: true, html: 'Nama Obat', issearch: true, disabled: false,
			},
		}
	}
	
}