export const formorganization = () => {
	return {
		title: '', posisi: '', satusehat_id: '',

		// ── Identitas ───────────────────────────────────────────────────────
		kode: {
			title: 'Kode Internal Sub-Organisasi', for_id: 'form_kode', type: 'text',
			required: 'required', name: 'kode', value: '', disabled: false, show: true, kinds: ''
		},
		nama: {
			title: 'Nama Organisasi', for_id: 'form_nama', type: 'text',
			required: 'required', name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		alias: {
			title: 'Alias / Nama Lain (opsional)', for_id: 'form_alias', type: 'text',
			required: '', name: 'alias', value: '', disabled: false, show: true, kinds: ''
		},
		active: {
			title: 'Status Aktif', for_id: 'form_active', type: 'select',
			required: '', name: 'active', value: 'true', disabled: false, show: true, kinds: '',
			options: [{ value: 'true', label: 'Aktif' }, { value: 'false', label: 'Tidak Aktif' }]
		},
		tipe_code: {
			title: 'Tipe Organisasi', for_id: 'form_tipe_code', type: 'select',
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
		part_of: {
			title: 'Bagian dari Organisasi (partOf — kosongkan = induk utama)', for_id: 'form_part_of', type: 'select',
			required: '', name: 'part_of', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Telecom ─────────────────────────────────────────────────────────
		telepon: {
			title: 'Telepon', for_id: 'form_telepon', type: 'text',
			required: '', name: 'telepon', value: '', disabled: false, show: true, kinds: ''
		},
		email: {
			title: 'Email', for_id: 'form_email', type: 'text',
			required: '', name: 'email', value: '', disabled: false, show: true, kinds: ''
		},
		website: {
			title: 'Website (URL)', for_id: 'form_website', type: 'text',
			required: '', name: 'website', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Alamat ──────────────────────────────────────────────────────────
		address_use: {
			title: 'Penggunaan Alamat', for_id: 'form_address_use', type: 'select',
			required: '', name: 'address_use', value: 'work', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'work',    label: 'work — Tempat Kerja' },
				{ value: 'home',    label: 'home — Rumah' },
				{ value: 'temp',    label: 'temp — Sementara' },
				{ value: 'old',     label: 'old — Lama / Tidak Dipakai' },
				{ value: 'billing', label: 'billing — Penagihan' },
			]
		},
		address_type: {
			title: 'Jenis Alamat', for_id: 'form_address_type', type: 'select',
			required: '', name: 'address_type', value: 'both', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'both',     label: 'both — Fisik & Pos' },
				{ value: 'physical', label: 'physical — Fisik' },
				{ value: 'postal',   label: 'postal — Pos' },
			]
		},
		alamat: {
			title: 'Jalan / Alamat Lengkap', for_id: 'form_alamat', type: 'text',
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
			title: 'Kode Provinsi (BPS)', for_id: 'form_kode_provinsi', type: 'text',
			required: '', name: 'kode_provinsi', value: '', disabled: false, show: true, kinds: ''
		},
		kode_kota: {
			title: 'Kode Kota/Kab (BPS)', for_id: 'form_kode_kota', type: 'text',
			required: '', name: 'kode_kota', value: '', disabled: false, show: true, kinds: ''
		},
		kode_kecamatan: {
			title: 'Kode Kecamatan (BPS)', for_id: 'form_kode_kecamatan', type: 'text',
			required: '', name: 'kode_kecamatan', value: '', disabled: false, show: true, kinds: ''
		},
		kode_kelurahan: {
			title: 'Kode Kelurahan (BPS)', for_id: 'form_kode_kelurahan', type: 'text',
			required: '', name: 'kode_kelurahan', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Contact (Kontak Tujuan) ──────────────────────────────────────────
		contact_purpose_code: {
			title: 'Tujuan Kontak', for_id: 'form_contact_purpose_code', type: 'select',
			required: '', name: 'contact_purpose_code', value: '', disabled: false, show: true, kinds: '',
			options: [
				{ value: '',       label: '— Tidak ada —' },
				{ value: 'BILL',   label: 'BILL — Billing / Penagihan' },
				{ value: 'ADMIN',  label: 'ADMIN — Administratif' },
				{ value: 'HR',     label: 'HR — Human Resource' },
				{ value: 'PAYOR',  label: 'PAYOR — Pembayar' },
				{ value: 'PATINF', label: 'PATINF — Informasi Pasien' },
				{ value: 'PRESS',  label: 'PRESS — Media / Pers' },
			]
		},
		contact_nama: {
			title: 'Nama Kontak Person', for_id: 'form_contact_nama', type: 'text',
			required: '', name: 'contact_nama', value: '', disabled: false, show: true, kinds: ''
		},
		contact_telepon: {
			title: 'Telepon Kontak', for_id: 'form_contact_telepon', type: 'text',
			required: '', name: 'contact_telepon', value: '', disabled: false, show: true, kinds: ''
		},
		contact_email: {
			title: 'Email Kontak', for_id: 'form_contact_email', type: 'text',
			required: '', name: 'contact_email', value: '', disabled: false, show: true, kinds: ''
		},
	}
}
