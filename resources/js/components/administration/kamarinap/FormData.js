export const formkamarinap = () => {
	return {
		title: '', posisi: '', uuid: '',
		nama: { 
			title: 'Nama Kamar Rawat Inap', for_id: 'form_'+'nama', type: 'text', required: 'required', 
			name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		lantai: { 
			title: 'Lantai ke', for_id: 'form_'+'lantai', type: 'number', required: 'required', 
			name: 'lantai', value: '', disabled: false, show: true, kinds: ''
		},
		jumlahbed: { 
			title: 'Jumlah Bed', for_id: 'form_'+'jumlahbed', type: 'number', required: 'required', 
			name: 'jumlahbed', value: '', disabled: false, show: true, kinds: ''
		},
		keterangan: { 
			title: 'Keterangan', for_id: 'form_'+'keterangan', type: 'text', required: '', 
			name: 'keterangan', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			jeniskamar: { 
				key : 'jeniskamar', for_id: 'form_'+'jeniskamar', name: 'jeniskamar', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'jenikamar', isrequired: true, html: 'Jenis Kamar', issearch: true, disabled: false,
			},
		}
	}
}