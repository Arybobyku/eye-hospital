export const formretur = () => {
	return {
		title: '', posisi: '', uuid: '',
		tanggalretur: { 
			title: 'Tanggal Retur', for_id: 'form_'+'tanggalretur', type: 'date', required: 'required', 
			name: 'tanggalretur', value: '', disabled: false, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan', for_id: 'form_'+'keterangan', type: 'text', required: '', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
		},
		select : {
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
		title: '', posisi: '', uuid: '', detailobat: '', detailretur: '', listdata: '',
		keterangan: { 
			title: 'Keterangan', for_id: 'form_'+'keterangan', type: 'text', required: 'required', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
		},
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