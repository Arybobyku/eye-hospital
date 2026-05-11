export const formorganization = () => {
	return {
		title: '', posisi: '', satusehat_id: '',

		kode: {
			title: 'Kode Internal', for_id: 'form_kode', type: 'text',
			required: 'required', name: 'kode', value: '', disabled: false, show: true, kinds: ''
		},
		nama: {
			title: 'Nama Organisasi', for_id: 'form_nama', type: 'text',
			required: 'required', name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		active: {
			title: 'Status', for_id: 'form_active', type: 'select',
			required: '', name: 'active', value: 'true', disabled: false, show: true, kinds: '',
			options: [{ value: 'true', label: 'Aktif' }, { value: 'false', label: 'Tidak Aktif' }]
		},
		tipe_code: {
			title: 'Kode Tipe', for_id: 'form_tipe_code', type: 'select',
			required: '', name: 'tipe_code', value: 'dept', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'dept',  label: 'dept — Hospital Department' },
				{ value: 'prov',  label: 'prov — Healthcare Provider' },
				{ value: 'team',  label: 'team — Organizational Team' },
				{ value: 'govt',  label: 'govt — Government' },
				{ value: 'ins',   label: 'ins — Insurance Company' },
				{ value: 'other', label: 'other — Other' },
			]
		},
		telepon: {
			title: 'Telepon', for_id: 'form_telepon', type: 'text',
			required: '', name: 'telepon', value: '', disabled: false, show: true, kinds: ''
		},
		email: {
			title: 'Email', for_id: 'form_email', type: 'text',
			required: '', name: 'email', value: '', disabled: false, show: true, kinds: ''
		},
		website: {
			title: 'Website', for_id: 'form_website', type: 'text',
			required: '', name: 'website', value: '', disabled: false, show: true, kinds: ''
		},
		alamat: {
			title: 'Alamat', for_id: 'form_alamat', type: 'text',
			required: '', name: 'alamat', value: '', disabled: false, show: true, kinds: ''
		},
		kota: {
			title: 'Kota', for_id: 'form_kota', type: 'text',
			required: '', name: 'kota', value: '', disabled: false, show: true, kinds: ''
		},
		kode_pos: {
			title: 'Kode Pos', for_id: 'form_kode_pos', type: 'text',
			required: '', name: 'kode_pos', value: '', disabled: false, show: true, kinds: ''
		},
		kode_provinsi: {
			title: 'Kode Provinsi', for_id: 'form_kode_provinsi', type: 'text',
			required: '', name: 'kode_provinsi', value: '', disabled: false, show: true, kinds: ''
		},
		kode_kota: {
			title: 'Kode Kota/Kab', for_id: 'form_kode_kota', type: 'text',
			required: '', name: 'kode_kota', value: '', disabled: false, show: true, kinds: ''
		},
		kode_kecamatan: {
			title: 'Kode Kecamatan', for_id: 'form_kode_kecamatan', type: 'text',
			required: '', name: 'kode_kecamatan', value: '', disabled: false, show: true, kinds: ''
		},
		kode_kelurahan: {
			title: 'Kode Kelurahan', for_id: 'form_kode_kelurahan', type: 'text',
			required: '', name: 'kode_kelurahan', value: '', disabled: false, show: true, kinds: ''
		},
	}
}
