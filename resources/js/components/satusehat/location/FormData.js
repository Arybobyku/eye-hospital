export const formlocation = () => {
	return {
		title: '', posisi: '', satusehat_id: '',

		// ── Identitas ───────────────────────────────────────────────────────────
		kode: {
			title: 'Kode Lokasi', for_id: 'form_kode', type: 'text',
			required: 'required', name: 'kode', value: '', disabled: false, show: true, kinds: ''
		},
		nama: {
			title: 'Nama Lokasi', for_id: 'form_nama', type: 'text',
			required: 'required', name: 'nama', value: '', disabled: false, show: true, kinds: ''
		},
		alias: {
			title: 'Alias / Nama Lain (opsional)', for_id: 'form_alias', type: 'text',
			required: '', name: 'alias', value: '', disabled: false, show: true, kinds: ''
		},
		deskripsi: {
			title: 'Deskripsi', for_id: 'form_deskripsi', type: 'text',
			required: '', name: 'deskripsi', value: '', disabled: false, show: true, kinds: ''
		},
		status: {
			title: 'Status', for_id: 'form_status', type: 'select',
			required: '', name: 'status', value: 'active', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'active',    label: 'active — Aktif'           },
				{ value: 'inactive',  label: 'inactive — Tidak Aktif'   },
				{ value: 'suspended', label: 'suspended — Ditangguhkan' },
			]
		},
		operational_status: {
			title: 'Status Operasional (Tempat Tidur)', for_id: 'form_operational_status', type: 'select',
			required: '', name: 'operational_status', value: '', disabled: false, show: true, kinds: '',
			options: [
				{ value: '',  label: '— Tidak ada —'                  },
				{ value: 'O', label: 'O — Occupied (Terisi)'          },
				{ value: 'C', label: 'C — Closed (Tutup)'             },
				{ value: 'H', label: 'H — Housekeeping'               },
				{ value: 'K', label: 'K — Contaminated (Terkontaminasi)' },
				{ value: 'I', label: 'I — Isolated (Isolasi)'         },
				{ value: 'U', label: 'U — Unoccupied (Kosong)'        },
			]
		},
		mode: {
			title: 'Mode', for_id: 'form_mode', type: 'select',
			required: '', name: 'mode', value: 'instance', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'instance', label: 'instance — Lokasi Nyata'  },
				{ value: 'kind',     label: 'kind — Jenis Lokasi'      },
			]
		},

		// ── Tipe ────────────────────────────────────────────────────────────────
		tipe_layanan: {
			title: 'Tipe Layanan (ServiceDeliveryLocationType)', for_id: 'form_tipe_layanan', type: 'select',
			required: '', name: 'tipe_layanan', value: '', disabled: false, show: true, kinds: '',
			options: [
				{ value: '',      label: '— Tidak ada —'                         },
				{ value: 'ICU',   label: 'ICU — Intensive Care Unit'             },
				{ value: 'ER',    label: 'ER — Emergency Room / IGD'             },
				{ value: 'HU',    label: 'HU — Hospital Unit (Rawat Inap)'       },
				{ value: 'OU',    label: 'OU — Outpatient Unit (Rawat Jalan)'    },
				{ value: 'PHARM', label: 'PHARM — Pharmacy (Apotek)'             },
				{ value: 'LAB',   label: 'LAB — Laboratory'                      },
				{ value: 'RX',    label: 'RX — Radiology'                        },
				{ value: 'SU',    label: 'SU — Surgery Unit (Operasi)'           },
				{ value: 'PEDC',  label: 'PEDC — Pediatric Clinic'               },
				{ value: 'CARD',  label: 'CARD — Cardiology'                     },
				{ value: 'DENT',  label: 'DENT — Dentistry'                      },
				{ value: 'NEPH',  label: 'NEPH — Nephrology'                     },
				{ value: 'NEUR',  label: 'NEUR — Neurology'                      },
				{ value: 'OBGYN', label: 'OBGYN — Obstetrics & Gynecology'       },
				{ value: 'ORTHO', label: 'ORTHO — Orthopedics'                   },
				{ value: 'PSY',   label: 'PSY — Psychiatry'                      },
				{ value: 'RHAT',  label: 'RHAT — Rehabilitation'                 },
				{ value: 'GAST',  label: 'GAST — Gastroenterology'               },
				{ value: 'DERM',  label: 'DERM — Dermatology'                    },
			]
		},
		tipe_fisik: {
			title: 'Tipe Fisik (physicalType)', for_id: 'form_tipe_fisik', type: 'select',
			required: '', name: 'tipe_fisik', value: 'ro', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'ro',  label: 'ro — Room (Ruangan)'      },
				{ value: 'bu',  label: 'bu — Building (Gedung)'   },
				{ value: 'wi',  label: 'wi — Wing (Sayap)'        },
				{ value: 'lvl', label: 'lvl — Level (Lantai)'     },
				{ value: 'co',  label: 'co — Corridor (Koridor)'  },
				{ value: 'wa',  label: 'wa — Ward (Bangsal)'      },
				{ value: 've',  label: 've — Vehicle (Kendaraan)' },
				{ value: 'area',label: 'area — Area'               },
			]
		},
		service_class: {
			title: 'Kelas Layanan', for_id: 'form_service_class', type: 'select',
			required: '', name: 'service_class', value: '', disabled: false, show: true, kinds: '',
			options: [
				{ value: '',     label: '— Tidak ada —' },
				{ value: '1',    label: 'Kelas 1'        },
				{ value: '2',    label: 'Kelas 2'        },
				{ value: '3',    label: 'Kelas 3'        },
				{ value: 'VIP',  label: 'VIP'            },
				{ value: 'VVIP', label: 'VVIP'           },
			]
		},

		// ── Telecom ─────────────────────────────────────────────────────────────
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
		website: {
			title: 'Website (URL)', for_id: 'form_website', type: 'text',
			required: '', name: 'website', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Alamat ──────────────────────────────────────────────────────────────
		address_use: {
			title: 'Penggunaan Alamat', for_id: 'form_address_use', type: 'select',
			required: '', name: 'address_use', value: 'work', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'work',    label: 'work — Tempat Kerja'         },
				{ value: 'home',    label: 'home — Rumah'                },
				{ value: 'temp',    label: 'temp — Sementara'            },
				{ value: 'old',     label: 'old — Lama / Tidak Dipakai'  },
				{ value: 'billing', label: 'billing — Penagihan'         },
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
		rt: {
			title: 'RT', for_id: 'form_rt', type: 'text',
			required: '', name: 'rt', value: '', disabled: false, show: true, kinds: ''
		},
		rw: {
			title: 'RW', for_id: 'form_rw', type: 'text',
			required: '', name: 'rw', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Posisi Geografis ─────────────────────────────────────────────────────
		latitude: {
			title: 'Latitude', for_id: 'form_latitude', type: 'text',
			required: '', name: 'latitude', value: '', disabled: false, show: true, kinds: ''
		},
		longitude: {
			title: 'Longitude', for_id: 'form_longitude', type: 'text',
			required: '', name: 'longitude', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Organisasi & Relasi ──────────────────────────────────────────────────
		managing_organization: {
			title: 'Managing Organization (ID SatuSehat — kosongkan = default org)', for_id: 'form_managing_organization', type: 'text',
			required: '', name: 'managing_organization', value: '', disabled: false, show: true, kinds: ''
		},
		part_of: {
			title: 'Bagian dari Lokasi Induk (ID SatuSehat Location — opsional)', for_id: 'form_part_of', type: 'text',
			required: '', name: 'part_of', value: '', disabled: false, show: true, kinds: ''
		},

		// ── Jam Operasional ──────────────────────────────────────────────────────
		hours_all_day: {
			title: 'Buka 24 Jam', for_id: 'form_hours_all_day', type: 'select',
			required: '', name: 'hours_all_day', value: 'false', disabled: false, show: true, kinds: '',
			options: [
				{ value: 'false', label: 'Tidak' },
				{ value: 'true',  label: 'Ya — 24 Jam' },
			]
		},
		hours_days: {
			title: 'Hari Operasional (pisahkan koma: mon,tue,wed,thu,fri,sat,sun)', for_id: 'form_hours_days', type: 'text',
			required: '', name: 'hours_days', value: '', disabled: false, show: true, kinds: ''
		},
		hours_opening: {
			title: 'Jam Buka (HH:MM)', for_id: 'form_hours_opening', type: 'text',
			required: '', name: 'hours_opening', value: '', disabled: false, show: true, kinds: ''
		},
		hours_closing: {
			title: 'Jam Tutup (HH:MM)', for_id: 'form_hours_closing', type: 'text',
			required: '', name: 'hours_closing', value: '', disabled: false, show: true, kinds: ''
		},
		availability_exceptions: {
			title: 'Pengecualian Ketersediaan (teks bebas)', for_id: 'form_availability_exceptions', type: 'text',
			required: '', name: 'availability_exceptions', value: '', disabled: false, show: true, kinds: ''
		},
	}
}
