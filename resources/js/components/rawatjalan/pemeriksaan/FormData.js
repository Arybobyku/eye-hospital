export const formkelurahan = () => {
	return {
		title: '', posisi: '', uuid: '',
		ph_bahasa: '',
		ph_pendengaran: '',
		ph_masalah_penglihatan: '',
		ph_bicara_buruk: '',
		ph_hilang_memori: '',
		ph_tidak_ada_partisipasi: '',
		ph_tidak_mampu_belajar: '',
		ph_tidak_ada_hambatan_belajar: '',
		ph_cemas: '',
		ph_emosi: '',
		ph_kognitif: '',
		ph_motivasi: '',
		edukasi_tata_tertib: '',
		edukasi_hak_dan_kewajiban: '',
		metode_audio: '',
		metode_demonstrasi: '',
		metode_lisan: '',
		metode_tulisan: '',
		metode_visual: '',
		pb_normal: '',
		pb_gangguan: '',
		bs_indonesia: '',
		bs_daerah: '',
		bs_inggris: '',
		bi_tidak: '',
		bi_iya: '',
		tp_tk: '',
		tp_sd: '',
		tp_smp: '',
		tp_sma: '',
		tp_diploma: '',
		tp_sarjana: '',
		tp_lainnya: '',
		ag_islam: '',
		ag_protestan: '',
		ag_katolik: '',
		ag_hindu: '',
		ag_budha: '',
		ag_lainnya: '',
		tp_paham: '',
		tp_kurang_paham: '',
		tp_tidak: '',
		np_modern: '',
		np_moderat: '',
		np_konvensional: '',
		rokok_ya: '',
		rokok_tidak: '',
		alkohol_ya: '',
		alkohol_tidak: '',
		kmi_ya: '',
		kmi_tidak: '',
		rpk_proses_penyakit: '',
		rpk_pengobatan: '',
		rpk_nutrisi: '',
		rpk_edukasi: '',
		rpk_lain_lain: '',
		kp_ya: '',
		kp_tidak: '',
		subject: '',
		object: '',
		assessment: '',
		plan: '',
		ttd: '',
		

 		rpk_jelaskan: {
 		title:'',	for_id: 'form_' + 'rpk_jelaskan', type: 'text', required: '',
 		   name: 'rpk_jelaskan', value: '', disabled: false, show: true, kinds: ''
 	   },
 	   kmi_alasan: {
		title: '',  for_id: 'form_' + 'kmi_alasan', type: 'text', required: '',
		name: 'kmi_alasan', value: '', disabled: false, show: true, kinds: ''
   		 },
		penetesanobat: {
			title: 'Penetesan Obat', for_id: 'form_' + 'penetesanobat', type: 'text', required: '',
			name: 'penetesanobat', value: '', disabled: false, show: true, kinds: ''
		},
		 bs_lainnya: {
			title: '', 	 for_id: 'form_' + 'bs_lainnya', type: 'text', required: '',
		 	name: 'bs_lainnya', value: '', disabled: false, show: true, kinds: ''
		 },
		nama_pemeriksa: {
			title: 'Perawat Pengkaji', for_id: 'form_' + 'nama_pemeriksa', type: 'text', required: '',
			name: 'nama_pemeriksa', value: '', disabled: false, show: true, kinds: ''
		},
		keluhanutama: {
			title: 'Keluhan Utama', for_id: 'form_' + 'keluhanutama', type: 'text', required: '',
			name: 'keluhanutama', value: '', disabled: false, show: true, kinds: '',
		},
		riwayatpenyakit: {
			title: 'Riwayat Penyakit', for_id: 'form_' + 'riwayatpenyakit', type: 'text', required: '',
			name: 'riwayatpenyakit', value: '', disabled: false, show: true, kinds: ''
		},
		kasusurgentlainnya: {
			title: 'Kasus urgent lainnya', for_id: 'form_' + 'kasusurgentlainnya', type: 'text', required: '',
			name: 'kasusurgentlainnya', value: '', disabled: false, show: true, kinds: ''
		},
		tekanandarah: {
			title: 'Tekanan Darah', for_id: 'form_' + 'tekanandarah', type: 'text', required: '',
			name: 'tekanandarah', value: '', disabled: false, show: true, kinds: '', satuan: 'mmHg'
		},
		nadi: {
			title: 'Nadi', for_id: 'form_' + 'nadi', type: 'text', required: '',
			name: 'nadi', value: '', disabled: false, show: true, kinds: '', satuan: 'x/Menit',
		},
		kgd: {
			title: 'KGD', for_id: 'form_' + 'kgd', type: 'text', required: '',
			name: 'kgd', value: '', disabled: false, show: true, kinds: '', satuan: 'mg/dL'
		},
		respiratoryrate: {
			title: 'Respiratory Rate', for_id: 'form_' + 'respiratoryrate', type: 'text', required: '',
			name: 'respiratoryrate', value: '', disabled: false, show: true, kinds: '',  satuan: 'x/Menit',
		},
		beratbadan: {
			title: 'Berat Badan', for_id: 'form_' + 'beratbadan', type: 'text', required: '',
			name: 'beratbadan', value: '', disabled: false, show: true, kinds: '', satuan: 'Kg'
		},
		tinggibadan: {
			title: 'Tinggi Badan', for_id: 'form_' + 'tinggibadan', type: 'text', required: '',
			name: 'tinggibadan', value: '', disabled: false, show: true, kinds: '', satuan: 'Cm'
		},
		suhu: {
			title: 'Suhu Tubuh', for_id: 'form_' + 'suhu', type: 'text', required: '',
			name: 'suhu', value: '', disabled: false, show: true, kinds: '', satuan : '°C'
		},
		nyerihilangbilalainnya: {
			title: 'Ketik disini bila pilih lainnya', for_id: 'form_' + 'nyerihilangbilalainnya', type: 'text', required: '',
			name: 'nyerihilangbilalainnya', value: '', disabled: false, show: true, kinds: ''
		},
		skalanyeri: {
			title: 'Skala Nyeri', for_id: 'form_' + 'skalanyeri', type: 'text', required: '',
			name: 'skalanyeri', value: '', disabled: false, show: true, kinds: ''
		},
		lokasinyeri: {
			title: 'Lokasi Nyeri', for_id: 'form_' + 'lokasinyeri', type: 'text', required: '',
			name: 'lokasinyeri', value: '', disabled: false, show: true, kinds: ''
		},
		durasinyeri: {
			title: 'Durasi Nyeri', for_id: 'form_' + 'durasinyeri', type: 'text', required: '',
			name: 'durasinyeri', value: '', disabled: false, show: true, kinds: ''
		},
		karakteristiknyeri: {
			title: 'Karakteristik Nyeri', for_id: 'form_' + 'karakteristiknyeri', type: 'text', required: '',
			name: 'karakteristiknyeri', value: '', disabled: false, show: true, kinds: ''
		},
		keterangannyeri: {
			title: 'Keterangan Tambahan', for_id: 'form_' + 'keterangannyeri', type: 'text', required: '',
			name: 'keterangannyeri', value: '', disabled: false, show: true, kinds: ''
		},
		penyakitpernahdideritalainnya: {
			title: 'Ketik disini bila pilih lainnya', for_id: 'form_' + 'skalanyeri', type: 'text', required: '',
			name: 'penyakitpernahdideritalainnya', value: '', disabled: false, show: true, kinds: ''
		},
		pernahdioperasilainnya: {
			title: 'Ketik disini bila pernah dioperasi', for_id: 'form_' + 'pernahdioperasilainnya', type: 'text', required: '',
			name: 'pernahdioperasilainnya', value: '', disabled: false, show: true, kinds: ''
		},
		ocularsinistrakacamatalamasph: {
			title: 'Sph', for_id: 'form_' + 'ocularsinistrakacamatalamasph', type: 'text', required: '',
			name: 'ocularsinistrakacamatalamasph', value: '', disabled: false, show: true, kinds: ''
		},
		riwayatalergimakananlainnya: {
			title: 'Ketik disini bila memiliki alergi makanan', for_id: 'form_' + 'riwayatalergimakananlainnya', type: 'text', required: '',
			name: 'riwayatalergimakananlainnya', value: '', disabled: false, show: true, kinds: ''
		},
		riwayatalergiobatanlainnya: {
			title: 'Ketik disini bila memiliki alergi obatan', for_id: 'form_' + 'riwayatalergiobatanlainnya', type: 'text', required: '',
			name: 'riwayatalergiobatanlainnya', value: '', disabled: false, show: true, kinds: ''
		},
		obatdigunakansaatinilainnya: {
			title: 'Ketik disini bila pilih lainnya', for_id: 'form_' + 'obatdigunakansaatinilainnya', type: 'text', required: '',
			name: 'obatdigunakansaatinilainnya', value: '', disabled: false, show: true, kinds: ''
		},
		oculardextraautoref: {
			title: 'Autoref', for_id: 'form_' + 'oculardextraautoref', type: 'text', required: '',
			name: 'oculardextraautoref', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrapd: {
			title: 'PD', for_id: 'form_' + 'oculardextrapd', type: 'text', required: '',
			name: 'oculardextrapd', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrakeratometrik1: {
			title: 'Keratometri K1', for_id: 'form_' + 'oculardextrakeratometrik1', type: 'text', required: '',
			name: 'oculardextrakeratometrik1', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrakeratometrik2: {
			title: 'Keratometri K2', for_id: 'form_' + 'oculardextrakeratometrik2', type: 'text', required: '',
			name: 'oculardextrakeratometrik2', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextratonometri: {
			title: 'Tonometri', for_id: 'form_' + 'oculardextratonometri', type: 'text', required: '',
			name: 'oculardextratonometri', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextravisus: {
			title: 'Visus', for_id: 'form_' + 'oculardextravisus', type: 'text', required: '',
			name: 'oculardextravisus', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextraadd: {
			title: 'Add', for_id: 'form_' + 'oculardextraadd', type: 'text', required: '',
			name: 'oculardextraadd', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextraautoref: {
			title: 'Autoref', for_id: 'form_' + 'oculardextraautoref', type: 'text', required: '',
			name: 'oculardextraautoref', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrabcva1: {
			title: 'BCVA', for_id: 'form_' + 'oculardextrabcva1', type: 'text', required: '',
			name: 'oculardextrabcva1', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrabcva2: {
			title: '->', for_id: 'form_' + 'oculardextrabcva2', type: 'text', required: '',
			name: 'oculardextrabcva2', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrakacamatalamasph: {
			title: 'Kacamata lama sph', for_id: 'form_' + 'oculardextrakacamatalamasph', type: 'text', required: '',
			name: 'oculardextrakacamatalamasph', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrakacamatalamacyl: {
			title: 'Kacamata lama Cyl', for_id: 'form_' + 'oculardextrakacamatalamacyl', type: 'text', required: '',
			name: 'oculardextrakacamatalamacyl', value: '', disabled: false, show: true, kinds: ''
		},

		oculardextrakacamatalamaaddisi: {
			title: 'Kacamata lama addisi', for_id: 'form_' + 'oculardextrakacamatalamaaddisi', type: 'text', required: '',
			name: 'oculardextrakacamatalamaaddisi', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistraautoref: {
			title: 'Autoref', for_id: 'form_' + 'ocularsinistraautoref', type: 'text', required: '',
			name: 'ocularsinistraautoref', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistraro: {
			title: 'Nama RO', for_id: 'form_' + 'ocularsinistraro', type: 'text', required: 'required',
			name: 'ocularsinistraro', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistrakeratometrik1: {
			title: 'Keratometri K1', for_id: 'form_' + 'ocularsinistrakeratometrik1', type: 'text', required: '',
			name: 'ocularsinistrakeratometrik1', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistrakeratometrik2: {
			title: 'Keratometri K2', for_id: 'form_' + 'ocularsinistrakeratometrik2', type: 'text', required: '',
			name: 'ocularsinistrakeratometrik2', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistratonometri: {
			title: 'Tonometri', for_id: 'form_' + 'ocularsinistratonometri', type: 'text', required: '',
			name: 'ocularsinistratonometri', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistravisus: {
			title: 'Visus', for_id: 'form_' + 'ocularsinistravisus', type: 'text', required: '',
			name: 'ocularsinistravisus', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistraadd: {
			title: 'Add', for_id: 'form_' + 'ocularsinistraadd', type: 'text', required: '',
			name: 'ocularsinistraadd', value: '', disabled: false, show: true, kinds: ''
		},
		ocularsinistrabcva1: {
			title: 'BCVA', for_id: 'form_' + 'ocularsinistrabcva1', type: 'text', required: '',
			name: 'ocularsinistrabcva1', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistrabcva2: {
			title: '->', for_id: 'form_' + 'ocularsinistrabcva2', type: 'text', required: '',
			name: 'ocularsinistrabcva2', value: '', disabled: false, show: true, kinds: ''
		},

		// ocularsinistrakacamata_lamasph:{
		// 	title: 'Kacamata lama sph', for_id: 'form_'+'skocularsinistrakacamata_lamasphalanyeri', type: 'text', required: '', 
		// 	name: 'ocularsinistrakacamata_lamasph', value: '', disabled: false, show: true, kinds: ''
		// },

		ocularsinistrakacamatalamacyl: {
			title: 'Kacamata lama Cyl', for_id: 'form_' + 'ocularsinistrakacamatalamacyl', type: 'text', required: '',
			name: 'ocularsinistrakacamatalamacyl', value: '', disabled: false, show: true, kinds: ''
		},

		ocularsinistrakacamatalamaaddisi: {
			title: 'Kacamata lama Addisi', for_id: 'form_' + 'ocularsinistrakacamatalamaaddisi', type: 'text', required: '',
			name: 'ocularsinistrakacamatalamaaddisi', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			klinik: {
				key: 'klinik', for_id: 'form_' + 'klinik', name: 'klinik', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'klinik', isrequired: true, html: 'Tujuan Ruangan', issearch: false, disabled: false,
			},
			kasusurgent: {
				key: 'kasusurgent', for_id: 'form_' + 'kasusurgent', name: 'kasusurgent', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'kasusurgent', isrequired: false, html: 'Kasus Urgent', issearch: false, disabled: false,
			},
			statuspsikologis: {
				key: 'statuspsikologis', for_id: 'form_' + 'statuspsikologis', name: 'statuspsikologis', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'statuspsikologis', isrequired: false, html: 'Stasus Psikologis', issearch: false, disabled: false,
			},
			statusfungsional: {
				key: 'statusfungsional', for_id: 'form_' + 'statusfungsional', name: 'statusfungsional', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'statusfungsional', isrequired: false, html: 'Stasus Fungsional', issearch: false, disabled: false,
			},
			nyeri: {
				key: 'nyeri', for_id: 'form_' + 'nyeri', name: 'nyeri', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'nyeri', isrequired: false, html: 'Nyeri', issearch: false, disabled: false,
			},
			nyerihilangbila: {
				key: 'nyerihilangbila', for_id: 'form_' + 'nyerihilangbila', name: 'nyerihilangbila', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'nyerihilangbila', isrequired: false, html: 'Nyeri Hilang Bila', issearch: false, disabled: false,
			},
			penyakitpernahdiderita: {
				key: 'penyakitpernahdiderita', for_id: 'form_' + 'penyakitpernahdiderita', name: 'penyakitpernahdiderita', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'penyakitpernahdiderita', isrequired: false, html: 'Penyakit pernah diderita', issearch: false, disabled: false,
			},
			pernahdioperasi: {
				key: 'pernahdioperasi', for_id: 'form_' + 'pernahdioperasi', name: 'pernahdioperasi', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pernahdioperasi', isrequired: false, html: 'Pernah dioperasi', issearch: false, disabled: false,
			},
			riwayatalergimakanan: {
				key: 'riwayatalergimakanan', for_id: 'form_' + 'riwayatalergimakanan', name: 'riwayatalergimakanan', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'riwayatalergimakanan', isrequired: false, html: 'Riwayat alergi makanan', issearch: false, disabled: false,
			},
			riwayatalergiobatan: {
				key: 'riwayatalergiobatan', for_id: 'form_' + 'riwayatalergiobatan', name: 'riwayatalergiobatan', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'riwayatalergiobatan', isrequired: false, html: 'Riwayat alergi obatan', issearch: false, disabled: false,
			},
			obatdigunakansaatini: {
				key: 'obatdigunakansaatini', for_id: 'form_' + 'obatdigunakansaatini', name: 'obatdigunakansaatini', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'obatdigunakansaatini', isrequired: false, html: 'Obat yang digunakan saat ini', issearch: false, disabled: false,
			},
			penilaianresikojatuh: {
				key: 'penilaianresikojatuh', for_id: 'form_' + 'penilaianresikojatuh', name: 'penilaianresikojatuh', uuid: '', value: '', label: 'Silahkan Pilih',
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'penilaianresikojatuh', isrequired: false, html: 'Penilaian resiko jatuh', issearch: false, disabled: false,
			},
		}
	}
}