export const formambil= () => {
	return {
		title: '', posisi: '', uuid: '', obat_uuid: '', hitung_besar: 0, hitung_kecil: 0, jumlah_besar: 0, jumlah_kecil: 0,
		jumlah: { 
			title: 'Jumlah yang diambil (Dari satuan terkecil)', for_id: 'form_'+'jumlah', type: 'number', required: 'required', 
			name: 'jumlah', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formkembali= () => {
	return {
		title: '', posisi: '', uuid: '', obat_uuid: '', hitung_besar: 0, hitung_kecil: 0, jumlah_besar: 0, jumlah_kecil: 0,
		jumlah: { 
			title: 'Jumlah yang dikembalikan (Dari satuan terkecil)', for_id: 'form_'+'jumlah', type: 'number', required: 'required', 
			name: 'jumlah', value: '', disabled: false, show: true, kinds: ''
		},
	}
}