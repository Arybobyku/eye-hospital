export const formdetail = () => {
	return {
		title: '', posisi: '', uuid: '', datafile: '',
		kodepoli:{
			title: 'Kode Poli', for_id: 'form_'+'kodepoli', type: 'text', required: '', 
			name: 'kodepoli', value: '', disabled: false, show: true, kinds: ''
		},
		kodesubspesialis: '',
		kodedokter: '',
		layanan_uuid: '',
		nama_layanan: '',
		tarif: '',
	}
}