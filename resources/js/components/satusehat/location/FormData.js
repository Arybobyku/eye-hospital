export const formlocation = () => {
	return {
		title: '', posisi: '', satusehat_id: '',

		kode: {
			title: 'Kode Lokasi', for_id: 'form_kode', type: 'text',
			required: 'required', name: 'kode', value: '', disabled: false, show: true, kinds: ''
		},
		nama: {
			title: 'Nama Lokasi', for_id: 'form_nama', type: 'text',
			required: 'required', name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		deskripsi: {
			title: 'Deskripsi', for_id: 'form_deskripsi', type: 'text',
			required: '', name: 'deskripsi', value: '', disabled: false, show: true, kinds: ''
		},
		status: {
			title: 'Status', for_id: 'form_status', type: 'select',
			required: '', name: 'status', value: 'active', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'active',    label: 'Active'    },
				{ value: 'inactive',  label: 'Inactive'  },
				{ value: 'suspended', label: 'Suspended' },
			]
		},
		mode: {
			title: 'Mode', for_id: 'form_mode', type: 'select',
			required: '', name: 'mode', value: 'instance', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'instance', label: 'Instance' },
				{ value: 'kind',     label: 'Kind'     },
			]
		},
		tipe_fisik: {
			title: 'Tipe Fisik', for_id: 'form_tipe_fisik', type: 'select',
			required: '', name: 'tipe_fisik', value: 'ro', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'ro',  label: 'ro — Room'     },
				{ value: 'bu',  label: 'bu — Building' },
				{ value: 'wi',  label: 'wi — Wing'     },
				{ value: 'lvl', label: 'lvl — Level'   },
				{ value: 'co',  label: 'co — Corridor' },
				{ value: 'wa',  label: 'wa — Ward'     },
				{ value: 've',  label: 've — Vehicle'  },
				{ value: 'area',label: 'area — Area'   },
			]
		},
		telepon: {
			title: 'Telepon', for_id: 'form_telepon', type: 'text',
			required: '', name: 'telepon', value: '', disabled: false, show: true, kinds: ''
		},
		fax: {
			title: 'Fax', for_id: 'form_fax', type: 'text',
			required: '', name: 'fax', value: '', disabled: false, show: true, kinds: ''
		},
		email: {
			title: 'Email', for_id: 'form_email', type: 'text',
			required: '', name: 'email', value: '', disabled: false, show: true, kinds: ''
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
		latitude: {
			title: 'Latitude', for_id: 'form_latitude', type: 'text',
			required: '', name: 'latitude', value: '', disabled: false, show: true, kinds: ''
		},
		longitude: {
			title: 'Longitude', for_id: 'form_longitude', type: 'text',
			required: '', name: 'longitude', value: '', disabled: false, show: true, kinds: ''
		},
	}
}
