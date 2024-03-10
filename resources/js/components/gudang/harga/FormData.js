export const formharga = () => {
	return {
		title: '', posisi: '', uuid: '', detailobat: null,
		
		harganetto: { 
			title: 'Harga Netto (Satuan kecil)', for_id: 'form_'+'harganetto', type: 'number', required: 'required', 
			name: 'harganetto', value: '', disabled: false, show: true, kinds: ''
		},
		harganettodiscount: { 
			title: 'Discount (%)', for_id: 'form_'+'harganettodiscount', type: 'number', required: '', 
			name: 'harganettodiscount', value: '', disabled: false, show: true, kinds: ''
		},
		harganettoppn: { 
			title: 'PPN (%)', for_id: 'form_'+'harganettoppn', type: 'number', required: 'required', 
			name: 'harganettoppn', value: '', disabled: false, show: true, kinds: ''
		},
		hpp: { 
			title: 'Harga Pokok Penjualan (Satuan kecil)', for_id: 'form_'+'hpp', type: 'number', required: 'required', 
			name: 'hpp', value: '', disabled: true, show: true, kinds: ''
		},
		marginresep: { 
			title: 'Margin (Resep) (%)', for_id: 'form_'+'marginresep', type: 'number', required: 'required', 
			name: 'marginresep', value: '', disabled: false, show: true, kinds: ''
		},
		marginnonresep: { 
			title: 'Margin (Non-Resep) (%)', for_id: 'form_'+'marginnonresep', type: 'number', required: 'required', 
			name: 'marginnonresep', value: '', disabled: false, show: true, kinds: ''
		},
		hjaresep: { 
			title: 'Harga Jual (Resep) (Satuan kecil)', for_id: 'form_'+'hjaresep', type: 'number', required: 'required', 
			name: 'hjaresep', value: '', disabled: true, show: true, kinds: ''
		},
		hjanonresep: { 
			title: 'Harga Jual (Non-Resep) (Satuan kecil)', for_id: 'form_'+'hjanonresep', type: 'number', required: 'required', 
			name: 'hjanonresep', value: '', disabled: true, show: true, kinds: ''
		},
		hjaresepbesar: { 
			title: 'Harga Jual (Resep) (Satuan besar)', for_id: 'form_'+'hjaresepbesar', type: 'number', required: 'required', 
			name: 'hjaresepbesar', value: '', disabled: true, show: true, kinds: ''
		},
		hjanonresepbesar: { 
			title: 'Harga Jual (Non-Resep) (Satuan besar)', for_id: 'form_'+'hjanonresepbesar', type: 'number', required: 'required', 
			name: 'hjanonresepbesar', value: '', disabled: true, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan Tambahan', for_id: 'form_'+'keterangan', type: 'number', required: '', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
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