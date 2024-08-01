export const formlaporanpembedahan = () => {
	return {
		uuid: '',
		bedah_uuid: '', ja_umum: '', ja_bsp: '', ja_csp: '', ja_epidural: '', ja_lokal: '', ja_spiral: '', penggunaanamhpkhusus: '', komplikasiintraoperasi:'',
		ruangoperasi: { 
			title: 'Ruang Operasi', for_id: 'form_'+'ruangoperasi', type: 'text', required: '', 
			name: 'ruangoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		akutterencana: { 
			title: 'Akut/Terencana', for_id: 'form_'+'akutterencana', type: 'text', required: '', 
			name: 'akutterencana', value: '', disabled: false, show: true, kinds: ''
		},
		kamar: { 
			title: 'Kamar', for_id: 'form_'+'kamar', type: 'text', required: '', 
			name: 'kamar', value: '', disabled: false, show: true, kinds: ''
		},
		tanggal: { 
			title: 'Tanggal', for_id: 'form_'+'tanggal', type: 'date', required: '', 
			name: 'tanggal', value: '', disabled: false, show: true, kinds: ''
		},
		pembedahan: { 
			title: 'Pembedahan', for_id: 'form_'+'pembedahan', type: 'text', required: '', 
			name: 'pembedahan', value: '', disabled: false, show: true, kinds: ''
		},
		ahlianastesi: { 
			title: 'Ahli Anastesi', for_id: 'form_'+'ahlianastesi', type: 'text', required: '', 
			name: 'ahlianastesi', value: '', disabled: false, show: true, kinds: ''
		},
		asisten1: { 
			title: 'Asisten 1', for_id: 'form_'+'asisten1', type: 'text', required: '', 
			name: 'asisten1', value: '', disabled: false, show: true, kinds: ''
		},
		asisten2: { 
			title: 'Asisten 2', for_id: 'form_'+'asisten2', type: 'text', required: '', 
			name: 'asisten2', value: '', disabled: false, show: true, kinds: ''
		},
		perawatinstrument: { 
			title: 'Perawat Instrument', for_id: 'form_'+'perawatinstrument', type: 'text', required: '', 
			name: 'perawatinstrument', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosaprabedah: { 
			title: 'Diagnosa Pra-Bedah', for_id: 'form_'+'diagnosaprabedah', type: 'text', required: '', 
			name: 'diagnosaprabedah', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosapascabedah: { 
			title: 'Diagnosa Pasca-Bedah', for_id: 'form_'+'diagnosapascabedah', type: 'text', required: '', 
			name: 'diagnosapascabedah', value: '', disabled: false, show: true, kinds: ''
		},
		indikasioperasi: { 
			title: 'Indikasi Operasi', for_id: 'form_'+'indikasioperasi', type: 'text', required: '', 
			name: 'indikasioperasi', value: '', disabled: false, show: true, kinds: ''
		},
		jenisoperasi: { 
			title: 'Jenis Operasi', for_id: 'form_'+'jenisoperasi', type: 'text', required: '', 
			name: 'jenisoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		desinfeksikulitdengan: { 
			title: 'Desinfeksi Kulit dengan', for_id: 'form_'+'desinfeksikulitdengan', type: 'text', required: '', 
			name: 'desinfeksikulitdengan', value: '', disabled: false, show: true, kinds: ''
		},
		posisipenderitadesinfeksi: { 
			title: 'Posisi Penderita', for_id: 'form_'+'posisipenderitadesinfeksi', type: 'text', required: '', 
			name: 'posisipenderitadesinfeksi', value: '', disabled: false, show: true, kinds: ''
		},
		jamoperasidimulai: { 
			title: 'Jam Operasi Dimulai', for_id: 'form_'+'jamoperasidimulai', type: 'text', required: '', 
			name: 'jamoperasidimulai', value: '', disabled: false, show: true, kinds: ''
		},
		jamoperasiselesai: { 
			title: 'Jam Operasi Selesai', for_id: 'form_'+'jamoperasiselesai', type: 'text', required: '', 
			name: 'jamoperasiselesai', value: '', disabled: false, show: true, kinds: ''
		},
		lamaoperasiberlansung: { 
			title: 'Lama Operasi Berlansung', for_id: 'form_'+'lamaoperasiberlansung', type: 'text', required: '', 
			name: 'lamaoperasiberlansung', value: '', disabled: false, show: true, kinds: ''
		},
		jenisbahanyangdikirimkelaboratorium: { 
			title: 'Jenis Bahan yang Dikirim ke Laboratorium untuk Pemeriksaan', for_id: 'form_'+'jenisbahanyangdikirimkelaboratorium', type: 'text', required: '', 
			name: 'jenisbahanyangdikirimkelaboratorium', value: '', disabled: false, show: true, kinds: ''
		},
		macamsayatan: { 
			title: 'Macam Sayatan', for_id: 'form_'+'macamsayatan', type: 'text', required: '', 
			name: 'macamsayatan', value: '', disabled: false, show: true, kinds: ''
		},
		posisisayatan: { 
			title: 'Posisi Sayatan', for_id: 'form_'+'posisisayatan', type: 'text', required: '', 
			name: 'posisisayatan', value: '', disabled: false, show: true, kinds: ''
		},
		teknikoperasidantemuanintra: { 
			title: 'Teknik Operasi dan Temuan Intra/Operasi', for_id: 'form_'+'teknikoperasidantemuanintra', type: 'text', required: '', 
			name: 'teknikoperasidantemuanintra', value: '', disabled: false, show: true, kinds: ''
		},
		jenisdanjumlahamhpkhusus: { 
			title: 'Jenis dan Jumlah AMHP Khusus', for_id: 'form_'+'jenisdanjumlahamhpkhusus', type: 'text', required: '', 
			name: 'jenisdanjumlahamhpkhusus', value: '', disabled: false, show: true, kinds: ''
		},
		penjabarankomplikasiintraoperasi: { 
			title: 'Penjabaran Komplikasi Intra-Operasi', for_id: 'form_'+'penjabarankomplikasiintraoperasi', type: 'text', required: '', 
			name: 'penjabarankomplikasiintraoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		perdarahan: { 
			title: 'Pendarahan (Cc)', for_id: 'form_'+'perdarahan', type: 'text', required: '', 
			name: 'perdarahan', value: '', disabled: false, show: true, kinds: ''
		},
		instruksianastesi: { 
			title: 'Instruksi Anastesi', for_id: 'form_'+'instruksianastesi', type: 'text', required: '', 
			name: 'instruksianastesi', value: '', disabled: false, show: true, kinds: ''
		},
		ipbkontrol: { 
			title: 'Kontrol Nadi/Tensi/Pernapasan/Suhu', for_id: 'form_'+'ipbkontrol', type: 'text', required: '', 
			name: 'ipbkontrol', value: '', disabled: false, show: true, kinds: ''
		},
		ipbpuasa: { 
			title: 'Puasa', for_id: 'form_'+'ipbpuasa', type: 'text', required: '', 
			name: 'ipbpuasa', value: '', disabled: false, show: true, kinds: ''
		},
		ipbdrain: { 
			title: 'Drain', for_id: 'form_'+'ipbdrain', type: 'text', required: '', 
			name: 'ipbdrain', value: '', disabled: false, show: true, kinds: ''
		},
		ipbinpus: { 
			title: 'Infus', for_id: 'form_'+'ipbinpus', type: 'text', required: '', 
			name: 'ipbinpus', value: '', disabled: false, show: true, kinds: ''
		},
		ipbobatobatan: { 
			title: 'Obat-Obatan', for_id: 'form_'+'ipbobatobatan', type: 'text', required: '', 
			name: 'ipbobatobatan', value: '', disabled: false, show: true, kinds: ''
		},
		ipbgantibalut: { 
			title: 'Ganti Balut', for_id: 'form_'+'ipbgantibalut', type: 'text', required: '', 
			name: 'ipbgantibalut', value: '', disabled: false, show: true, kinds: ''
		},
		ipblainnya: { 
			title: 'Lain-lain', for_id: 'form_'+'ipblainnya', type: 'text', required: '', 
			name: 'ipblainnya', value: '', disabled: false, show: true, kinds: ''
		},
		operatorbedah: { 
			title: 'Nama Operator', for_id: 'form_'+'operatorbedah', type: 'text', required: '', 
			name: 'operatorbedah', value: '', disabled: false, show: true, kinds: ''
		},
	}
}

export const formchecklistkesiapanbedah = () => {
	return {
		uuid: '',
		bedah_uuid: '',
		ruangan: { 
			title: 'Ruang', for_id: 'form_'+'ruangan', type: 'text', required: '', 
			name: 'ruangan', value: '', disabled: false, show: true, kinds: ''
		},
		kamar: { 
			title: 'Kamar', for_id: 'form_'+'kamar', type: 'text', required: '', 
			name: 'kamar', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosa: { 
			title: 'Diagnosa', for_id: 'form_'+'diagnosa', type: 'text', required: '', 
			name: 'diagnosa', value: '', disabled: false, show: true, kinds: ''
		},
		tindakan: { 
			title: 'Tindakan', for_id: 'form_'+'tindakan', type: 'text', required: '', 
			name: 'tindakan', value: '', disabled: false, show: true, kinds: ''
		},
		teknikanastesi: { 
			title: 'Teknik Anastesi', for_id: 'form_'+'teknikanastesi', type: 'text', required: '', 
			name: 'teknikanastesi', value: '', disabled: false, show: true, kinds: ''
		},
		tanggaltindakan: { 
			title: 'Tanggal Tindakan', for_id: 'form_'+'tanggaltindakan', type: 'date', required: '', 
			name: 'tanggaltindakan', value: '', disabled: false, show: true, kinds: ''
		},
		perawatkamarbedah: { 
			title: 'Perawat Kamar Bedah', for_id: 'form_'+'perawatkamarbedah', type: 'text', required: '', 
			name: 'perawatkamarbedah', value: '', disabled: false, show: true, kinds: ''
		},
		kepalaruangan: { 
			title: 'Kepala Ruangan', for_id: 'form_'+'kepalaruangan', type: 'text', required: '', 
			name: 'kepalaruangan', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			listrik: { 
				key : 'listrik', for_id: 'form_'+'listrik', name: 'listrik', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'listrik', isrequired: false, html: 'Listrik', issearch: false, disabled: false,
			},
			alat: { 
				key : 'alat', for_id: 'form_'+'alat', name: 'alat', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'alat', isrequired: false, html: 'Alat', issearch: false, disabled: false,
			},
			linensteril: { 
				key : 'linensteril', for_id: 'form_'+'linensteril', name: 'linensteril', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'linensteril', isrequired: false, html: 'Linen Steril', issearch: false, disabled: false,
			},
			akhp: { 
				key : 'akhp', for_id: 'form_'+'akhp', name: 'akhp', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'akhp', isrequired: false, html: 'AKHP', issearch: false, disabled: false,
			},
		}
	}
}

export const formperawatanperioperative = () => {
	return {
		uuid: '',
		bedah_uuid: '',
		tanggal: { 
			title: 'Tanggal', for_id: 'form_'+'tanggal', type: 'date', required: '', 
			name: 'tanggal', value: '', disabled: false, show: true, kinds: ''
		},
		jam: { 
			title: 'Jam', for_id: 'form_'+'jam', type: 'text', required: '', 
			name: 'jam', value: '', disabled: false, show: true, kinds: ''
		},
		
		ruangan: { 
			title: 'Ruangan', for_id: 'form_'+'ruangan', type: 'text', required: '', 
			name: 'ruangan', value: '', disabled: false, show: true, kinds: ''
		},

		dokteroperator: { 
			title: 'Dokter Operator', for_id: 'form_'+'dokteroperator', type: 'text', required: '', 
			name: 'dokteroperator', value: '', disabled: false, show: true, kinds: ''
		},

		dokteranastesi: { 
			title: 'Dokter Anastesi', for_id: 'form_'+'dokteranastesi', type: 'text', required: '', 
			name: 'dokteranastesi', value: '', disabled: false, show: true, kinds: ''
		},

		diagnosis: { 
			title: 'Diagnosis', for_id: 'form_'+'diagnosis', type: 'text', required: '', 
			name: 'diagnosis', value: '', disabled: false, show: true, kinds: ''
		},

		tindakanoperasi: { 
			title: 'Tindakan Operasi', for_id: 'form_'+'tindakanoperasi', type: 'text', required: '', 
			name: 'tindakanoperasi', value: '', disabled: false, show: true, kinds: ''
		},

		hasilkgd: { 
			title: 'Hasil KGD', for_id: 'form_'+'hasilkgd', type: 'text', required: '', 
			name: 'hasilkgd', value: '', disabled: false, show: true, kinds: ''
		},

		waktupengambilankgd: { 
			title: 'Waktu Pengambilan Pukul', for_id: 'form_'+'waktupengambilankgd', type: 'text', required: '', 
			name: 'waktupengambilankgd', value: '', disabled: false, show: true, kinds: ''
		},

		vstemp: { 
			title: 'Temperatur', for_id: 'form_'+'vstemp', type: 'text', required: '', 
			name: 'vstemp', value: '', disabled: false, show: true, kinds: ''
		},

		vsnadi: { 
			title: 'Nadi', for_id: 'form_'+'vsnadi', type: 'text', required: '', 
			name: 'vsnadi', value: '', disabled: false, show: true, kinds: ''
		},

		vspernapasan: { 
			title: 'Pernapasan', for_id: 'form_'+'vspernapasan', type: 'text', required: '', 
			name: 'vspernapasan', value: '', disabled: false, show: true, kinds: ''
		},

		vstekanandarah: { 
			title: 'Tekanan Darah', for_id: 'form_'+'vstekanandarah', type: 'text', required: '', 
			name: 'vstekanandarah', value: '', disabled: false, show: true, kinds: ''
		},

		vstinggi: { 
			title: 'Tinggi Badan', for_id: 'form_'+'vstinggi', type: 'text', required: '', 
			name: 'vstinggi', value: '', disabled: false, show: true, kinds: ''
		},

		vsberat: { 
			title: 'Berat Badan', for_id: 'form_'+'vsberat', type: 'text', required: '', 
			name: 'vsberat', value: '', disabled: false, show: true, kinds: ''
		},

		riwayatpenyakit: { 
			title: 'Riwayat Penyakit', for_id: 'form_'+'riwayatpenyakit', type: 'text', required: '', 
			name: 'riwayatpenyakit', value: '', disabled: false, show: true, kinds: ''
		},

		alergiobatan: { 
			title: 'Alergi Obatan', for_id: 'form_'+'alergiobatan', type: 'text', required: '', 
			name: 'alergiobatan', value: '', disabled: false, show: true, kinds: ''
		},

		alergimakanan: { 
			title: 'Alergi Makanan', for_id: 'form_'+'alergimakanan', type: 'text', required: '', 
			name: 'alergimakanan', value: '', disabled: false, show: true, kinds: ''
		},

		pemeriksaanidentitaspasienket: { 
			title: 'Keterangan', for_id: 'form_'+'pemeriksaanidentitaspasienket', type: 'text', required: '', 
			name: 'pemeriksaanidentitaspasienket', value: '', disabled: false, show: true, kinds: ''
		},

		pemeriksaangelangnamaket: { 
			title: 'Keterangan', for_id: 'form_'+'pemeriksaangelangnamaket', type: 'text', required: '', 
			name: 'pemeriksaangelangnamaket', value: '', disabled: false, show: true, kinds: ''
		},

		formulirpersetujuanoperasiket: { 
			title: 'Keterangan', for_id: 'form_'+'formulirpersetujuanoperasiket', type: 'text', required: '', 
			name: 'formulirpersetujuanoperasiket', value: '', disabled: false, show: true, kinds: ''
		},

		pemberianpremedikasiket: { 
			title: 'Keterangan', for_id: 'form_'+'pemberianpremedikasiket', type: 'text', required: '', 
			name: 'pemberianpremedikasiket', value: '', disabled: false, show: true, kinds: ''
		},

		pemberianmakanminumlastket: { 
			title: 'Keterangan', for_id: 'form_'+'pemberianmakanminumlastket', type: 'text', required: '', 
			name: 'pemberianmakanminumlastket', value: '', disabled: false, show: true, kinds: ''
		},

		alatprotesaluarket: { 
			title: 'Keterangan', for_id: 'form_'+'alatprotesaluarket', type: 'text', required: '', 
			name: 'alatprotesaluarket', value: '', disabled: false, show: true, kinds: ''
		},

		alatperhiasanket: { 
			title: 'Keterangan', for_id: 'form_'+'alatperhiasanket', type: 'text', required: '', 
			name: 'alatperhiasanket', value: '', disabled: false, show: true, kinds: ''
		},

		statuspasienterlampirket: { 
			title: 'Keterangan', for_id: 'form_'+'statuspasienterlampirket', type: 'text', required: '', 
			name: 'statuspasienterlampirket', value: '', disabled: false, show: true, kinds: ''
		},

		xrayscanket: { 
			title: 'Keterangan', for_id: 'form_'+'xrayscanket', type: 'text', required: '', 
			name: 'xrayscanket', value: '', disabled: false, show: true, kinds: ''
		},

		pencukuranbulumataket: { 
			title: 'Keterangan', for_id: 'form_'+'pencukuranbulumataket', type: 'text', required: '', 
			name: 'pencukuranbulumataket', value: '', disabled: false, show: true, kinds: ''
		},

		pemeriksaandarahket: { 
			title: 'Keterangan', for_id: 'form_'+'pemeriksaandarahket', type: 'text', required: '', 
			name: 'pemeriksaandarahket', value: '', disabled: false, show: true, kinds: ''
		},

		sitemarkerket: { 
			title: 'Keterangan', for_id: 'form_'+'sitemarkerket', type: 'text', required: '', 
			name: 'sitemarkerket', value: '', disabled: false, show: true, kinds: ''
		},

		perawatruangan: { 
			title: 'Nama Perawat Ruangan', for_id: 'form_'+'perawatruangan', type: 'text', required: '', 
			name: 'Nama Perawat Ruangan', value: '', disabled: false, show: true, kinds: ''
		},

		perawatkamarbedah: { 
			title: 'Nama Perawat Kamar Bedah', for_id: 'form_'+'perawatkamarbedah', type: 'text', required: '', 
			name: 'perawatkamarbedah', value: '', disabled: false, show: true, kinds: ''
		},

		r_pemeriksaan_identitas_pasien: '', r_pemeriksaan_gelang_nama: '', r_formulir_persetujuan_operasi: '', r_pemberian_premedikasi: '', r_pemberian_makan_minum_last: '',
		r_alat_protesa_luar: '', r_alat_perhiasan: '', r_status_pasien_terlampir: '', r_xray_scan: '', r_pencukuran_bulu_mata: '',
		r_pemeriksaan_darah: '', r_site_marker: '',
		ok1_pemeriksaan_identitas_pasien: '', ok1_pemeriksaan_gelang_nama: '', ok1_formulir_persetujuan_operasi: '', ok1_pemberian_premedikasi: '', ok1_pemberian_makan_minum_last: '',
		ok1_alat_protesa_luar: '', ok1_alat_perhiasan: '', ok1_status_pasien_terlampir: '', ok1_xray_scan: '', ok1_pencukuran_bulu_mata: '',
		ok1_pemeriksaan_darah: '', ok1_site_marker: '',
		ok2_pemeriksaan_identitas_pasien: '', ok2_pemeriksaan_gelang_nama: '', ok2_formulir_persetujuan_operasi: '', ok2_pemberian_premedikasi: '', ok2_pemberian_makan_minum_last: '',
		ok2_alat_protesa_luar: '', ok2_alat_perhiasan: '', ok2_status_pasien_terlampir: '', ok2_xray_scan: '', ok2_pencukuran_bulu_mata: '',
		ok2_pemeriksaan_darah: '', ok2_site_marker: '',
	}
}

export const formcatatanoperasikatarak = () => {
	return {
		uuid: '',
		bedah_uuid: '',
		tanggal: { 
			title: 'Tanggal', for_id: 'form_'+'tanggal', type: 'date', required: '', 
			name: 'tanggal', value: '', disabled: false, show: true, kinds: ''
		},
		operasimulai: { 
			title: 'Operasi mulai', for_id: 'form_'+'operasimulai', type: 'text', required: '', 
			name: 'operasimulai', value: '', disabled: false, show: true, kinds: ''
		},
		operasiselesai: { 
			title: 'Operasi selesai', for_id: 'form_'+'operasiselesai', type: 'text', required: '', 
			name: 'operasiselesai', value: '', disabled: false, show: true, kinds: ''
		},
		dokterbedah: { 
			title: 'Dokter Bedah', for_id: 'form_'+'dokterbedah', type: 'text', required: '', 
			name: 'dokterbedah', value: '', disabled: false, show: true, kinds: ''
		},
		dokteranastesi: { 
			title: 'Dokter Anastesi', for_id: 'form_'+'dokteranastesi', type: 'text', required: '', 
			name: 'dokteranastesi', value: '', disabled: false, show: true, kinds: ''
		},
		tindakanoperasi: { 
			title: 'Tindakan Operasi', for_id: 'form_'+'tindakanoperasi', type: 'text', required: '', 
			name: 'tindakanoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		perawatscrub: { 
			title: 'Perawat Scrub', for_id: 'form_'+'perawatscrub', type: 'text', required: '', 
			name: 'perawatscrub', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosisprabedah: { 
			title: 'Diagnosis Pra Bedah', for_id: 'form_'+'diagnosisprabedah', type: 'text', required: '', 
			name: 'diagnosisprabedah', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosispascabedah: { 
			title: 'Diagnosis Pasca Bedah', for_id: 'form_'+'diagnosispascabedah', type: 'text', required: '', 
			name: 'diagnosispascabedah', value: '', disabled: false, show: true, kinds: ''
		},
		catatantambahan: { 
			title: 'Catatan Tambahan', for_id: 'form_'+'catatantambahan', type: 'text', required: '', 
			name: 'catatantambahan', value: '', disabled: false, show: true, kinds: ''
		},
		namaoperator: { 
			title: 'Nama Operator', for_id: 'form_'+'namaoperator', type: 'text', required: '', 
			name: 'namaoperator', value: '', disabled: false, show: true, kinds: ''
		},

		an_topical: '', an_retrobulbar_peribulbar: '', an_sub_conjunctival: '', an_intracamelar: '', an_nu_bius_umum: '',
		an_xylocain: '', an_lidocain: '', in_kornea: '', in_limbus: '', in_sclera: '', wt_main_port: '',
		wt_two_side_port: '', wt_one_side_port: '', wt_keratome_2_koma_75_mm: '', wt_crescen_knife: '', cs_ccc: '', cs_x_mas_tree: '', cs_linear: '',
		cs_can_opener: '', cs_tryphan_blue: '', tb_ctr: '', tb_kapsulotomi_posterior: '', tb_vitrektomi_anterior: '', ci_rl: '',
		ci_bss: '', lio_dalam_kantung_kapsul: '', lio_bilik_mata_depan: '', lio_sulcus_siliaris: '', lio_diluar_kantong_kapsul: '', lio_afakia: '',
		lio_fiksasi_scleral: '', cv_hpmc: '', cv_viscoat: '', cv_hyaluronic_acid: '', benang_tanpa_jahitan: '', benang_ethylon_10_0: '',
		benang_vicryl_8_0: '', kompikasi_tidak_ada: '', kompikasi_pcr: '', kompikasi_prolaps_vitreous: '', kompikasi_drop_nucleus: '',
		kompikasi_perdarahan: '', kompikasi_corneal_burn: '', kompikasi_convert_to_ecce: '', kompikasi_convert_to_icce: '', ppo_pulang_berobat_jalan: '', ppo_opname: '',
		ipo_pdb2jpo: '', ipo_omdpspdb: '', ipo_pdbddtksdto: '', ipo_psdipo: '',
	}
}

export const formpersetujuantindakankedokteran = () => {
	return {
		uuid: '',
		bedah_uuid: '',
		dokterpelaksanatindakan: { 
			title: 'Dokter Pelaksana Tindakan', for_id: 'form_'+'dokterpelaksanatindakan', type: 'text', required: '', 
			name: 'dokterpelaksanatindakan', value: '', disabled: false, show: true, kinds: ''
		},
		pemberiinformasi: { 
			title: 'Pemberi Informasi', for_id: 'form_'+'pemberiinformasi', type: 'text', required: '', 
			name: 'pemberiinformasi', value: '', disabled: false, show: true, kinds: ''
		},
		penerimapenolakinformasi: { 
			title: 'Penerima/Penolak Informasi', for_id: 'form_'+'penerimapenolakinformasi', type: 'text', required: '', 
			name: 'penerimapenolakinformasi', value: '', disabled: false, show: true, kinds: ''
		},
		jidiagnosiswddd: { 
			title: 'Diagnosis (WD & DD)', for_id: 'form_'+'jidiagnosiswddd', type: 'text', required: '', 
			name: 'jidiagnosiswddd', value: '', disabled: false, show: true, kinds: ''
		},
		jidasardiagnosis: { 
			title: 'Dasar Diagnosis', for_id: 'form_'+'jidasardiagnosis', type: 'text', required: '', 
			name: 'jidasardiagnosis', value: '', disabled: false, show: true, kinds: ''
		},
		jitindakankedokteran: { 
			title: 'Tindakan Kedokteran', for_id: 'form_'+'jitindakankedokteran', type: 'text', required: '', 
			name: 'jitindakankedokteran', value: '', disabled: false, show: true, kinds: ''
		},
		jiindikasitindakan: { 
			title: 'Indikasi Tindakan', for_id: 'form_'+'jiindikasitindakan', type: 'text', required: '', 
			name: 'jiindikasitindakan', value: '', disabled: false, show: true, kinds: ''
		},
		jitatacara: { 
			title: 'Tata Cara', for_id: 'form_'+'jitatacara', type: 'text', required: '', 
			name: 'jitatacara', value: '', disabled: false, show: true, kinds: ''
		},
		jitujuan: { 
			title: 'Tujuan', for_id: 'form_'+'jitujuan', type: 'text', required: '', 
			name: 'jitujuan', value: '', disabled: false, show: true, kinds: ''
		},
		jiresiko: { 
			title: 'Resiko', for_id: 'form_'+'jiresiko', type: 'text', required: '', 
			name: 'jiresiko', value: '', disabled: false, show: true, kinds: ''
		},
		jikomplikasi: { 
			title: 'Komplikasi', for_id: 'form_'+'jikomplikasi', type: 'text', required: '', 
			name: 'jikomplikasi', value: '', disabled: false, show: true, kinds: ''
		},
		jiprognosis: { 
			title: 'Prognosis', for_id: 'form_'+'jiprognosis', type: 'text', required: '', 
			name: 'jiprognosis', value: '', disabled: false, show: true, kinds: ''
		},
		jialternatifdanresiko: { 
			title: 'Alternatif dan Resiko', for_id: 'form_'+'jialternatifdanresiko', type: 'text', required: '', 
			name: 'jialternatifdanresiko', value: '', disabled: false, show: true, kinds: ''
		},
		jilainlain: { 
			title: 'Lain-lain', for_id: 'form_'+'jilainlain', type: 'text', required: '', 
			name: 'jilainlain', value: '', disabled: false, show: true, kinds: ''
		},

		ptknamapenerima: { 
			title: 'Nama Lengkap', for_id: 'form_'+'ptknamapenerima', type: 'text', required: '', 
			name: 'ptknamapenerima', value: '', disabled: false, show: true, kinds: ''
		},

		ptktanggallahirpenerima: { 
			title: 'Tanggal Lahir', for_id: 'form_'+'ptktanggallahirpenerima', type: 'date', required: '', 
			name: 'ptktanggallahirpenerima', value: '', disabled: false, show: true, kinds: ''
		},

		ptkalamatpenerima: { 
			title: 'Alamat', for_id: 'form_'+'ptkalamatpenerima', type: 'text', required: '', 
			name: 'ptkalamatpenerima', value: '', disabled: false, show: true, kinds: ''
		},

		ptkhubunganpenerima: { 
			title: 'Hubungan ke pasien', for_id: 'form_'+'ptkalamatpenerima', type: 'text', required: '', 
			name: 'ptkalamatpenerima', value: '', disabled: false, show: true, kinds: ''
		},

		ptktindakan: { 
			title: 'Nama Tindakan', for_id: 'form_'+'ptktindakan', type: 'text', required: '', 
			name: 'ptktindakan', value: '', disabled: false, show: true, kinds: ''
		},

		ptkterhadap: { 
			title: 'Tindakan diberikan terhadap ', for_id: 'form_'+'ptkterhadap', type: 'text', required: '', 
			name: 'ptkterhadap', value: '', disabled: false, show: true, kinds: ''
		},

		ptknamatarget: { 
			title: 'Nama Lengkap', for_id: 'form_'+'ptknamatarget', type: 'text', required: '', 
			name: 'ptknamatarget', value: '', disabled: false, show: true, kinds: ''
		},

		ptktanggallahirtarget: { 
			title: 'Tanggal Lahir', for_id: 'form_'+'ptktanggallahirtarget', type: 'date', required: '', 
			name: 'ptktanggallahirtarget', value: '', disabled: false, show: true, kinds: ''
		},

		ptkalamattarget: { 
			title: 'Alamat', for_id: 'form_'+'ptkalamattarget', type: 'text', required: '', 
			name: 'ptkalamattarget', value: '', disabled: false, show: true, kinds: ''
		},

		tanggal: { 
			title: 'Tanggal', for_id: 'form_'+'tanggal', type: 'date', required: '', 
			name: 'tanggal', value: '', disabled: false, show: true, kinds: ''
		},

		pukul: { 
			title: 'Pukul', for_id: 'form_'+'pukul', type: 'text', required: '', 
			name: 'pukul', value: '', disabled: false, show: true, kinds: ''
		},

		namatarget: { 
			title: 'Yang Menyatakan (Pasien)', for_id: 'form_'+'namatarget', type: 'text', required: '', 
			name: 'namatarget', value: '', disabled: false, show: true, kinds: ''
		},

		namasaksi: { 
			title: 'Saksi Keluarga', for_id: 'form_'+'namasaksi', type: 'text', required: '', 
			name: 'namasaksi', value: '', disabled: false, show: true, kinds: ''
		},

		perawat: { 
			title: 'Saksi (Perawat)', for_id: 'form_'+'perawat', type: 'text', required: '', 
			name: 'perawat', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			ptkjeniskelamintarget: { 
				key : 'ptkjeniskelamintarget', for_id: 'form_'+'ptkjeniskelamintarget', name: 'ptkjeniskelamintarget', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'ptkjeniskelamintarget', isrequired: false, html: 'Jenis Kelamin', issearch: false, disabled: false,
			},
			ptkjeniskelaminpenerima: { 
				key : 'ptkjeniskelaminpenerima', for_id: 'form_'+'ptkjeniskelaminpenerima', name: 'ptkjeniskelaminpenerima', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'ptkjeniskelaminpenerima', isrequired: false, html: 'Jenis Kelamin', issearch: false, disabled: false,
			},
		}
	}
}

export const formkeselamatanbedah = () => {
	return {
		uuid: '',
		bedah_uuid: '',
		sibagian1:'', sibagian2:'', sibagian3:'', sibagian4:'', sibagian5:'', sibagian6:'', sibagian7:'', tobagian7:'', tobagian8:'', tobagian1:'', tobagian21:'', tobagian22:'', tobagian41:'', tobagian42:'', tobagian5:'', tobagian6:'',
		sobagian1:'', sobagian2:'', sobagian3:'', sobagian4:'', sobagian5:'',
		namaoperator: { 
			title: 'Nama Dokter Bedah', for_id: 'form_'+'namaoperator', type: 'text', required: '', 
			name: 'namaoperator', value: '', disabled: false, show: true, kinds: ''
		},
		namaahlianastesi: { 
			title: 'Nama Dokter Anastesi', for_id: 'form_'+'namaahlianastesi', type: 'text', required: '', 
			name: 'namaahlianastesi', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosismedis: { 
			title: 'Diagnosis Medis', for_id: 'form_'+'diagnosismedis', type: 'text', required: '', 
			name: 'diagnosismedis', value: '', disabled: false, show: true, kinds: ''
		},
		tindakanoperasi: { 
			title: 'Tindakan Operasi', for_id: 'form_'+'tindakanoperasi', type: 'text', required: '', 
			name: 'tindakanoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		asistenoperasi: { 
			title: 'Perawat Anastesi', for_id: 'form_'+'asistenoperasi', type: 'text', required: '', 
			name: 'asistenoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		scrubnurses: { 
			title: 'Perawat Instrument', for_id: 'form_'+'scrubnurses', type: 'text', required: '', 
			name: 'scrubnurses', value: '', disabled: false, show: true, kinds: ''
		},
		sijam: { 
			title: 'Waktu', for_id: 'form_'+'sijam', type: 'text', required: '', 
			name: 'sijam', value: '', disabled: false, show: true, kinds: ''
		},

		sinama: { 
			title: 'Nama Perawat', for_id: 'form_'+'sinama', type: 'text', required: '', 
			name: 'sinama', value: '', disabled: false, show: true, kinds: ''
		},

		tobagian23: { 
			title: 'Apakah tindakan beresiko atau tindakan tidak rutin yang akan dilakukan?', for_id: 'form_'+'tobagian23', type: 'text', required: '', 
			name: 'tobagian23', value: '', disabled: false, show: true, kinds: ''
		},

		tobagian3: { 
			title: 'Berapa lama tindakan ini akan dikerjakan?', for_id: 'form_'+'tobagian3', type: 'text', required: '', 
			name: 'tobagian3', value: '', disabled: false, show: true, kinds: ''
		},

		tonama: { 
			title: 'Perawat Sirkuler', for_id: 'form_'+'tonama', type: 'text', required: '', 
			name: 'tonama', value: '', disabled: false, show: true, kinds: ''
		},
		tojam: { 
			title: 'Waktu', for_id: 'form_'+'tojam', type: 'text', required: '', 
			name: 'tojam', value: '', disabled: false, show: true, kinds: ''
		},
		sojam: { 
			title: 'Waktu', for_id: 'form_'+'sojam', type: 'text', required: '', 
			name: 'sojam', value: '', disabled: false, show: true, kinds: ''
		},
	}
}
export const formlaporaninjeksiantivega = () => {
	return {
		uuid: '',
		bedah_uuid: '', os:'', od:'',
	
		namaoperator: { 
			title: 'Nama Operator', for_id: 'form_'+'namaoperator', type: 'text', required: '', 
			name: 'namaoperator', value: '', disabled: false, show: true, kinds: ''
		},
		jamoperasi: { 
			title: 'Jam Operasi', for_id: 'form_'+'jamoperasi', type: 'text', required: '', 
			name: 'jamoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		lamaoperasi: { 
			title: 'Lama Operasi', for_id: 'form_'+'lamaoperasi', type: 'text', required: '', 
			name: 'lamaoperasi', value: '', disabled: false, show: true, kinds: ''
		},
		diagnosis: { 
			title: 'Diagnosis', for_id: 'form_'+'diagnosis', type: 'text', required: '', 
			name: 'diagnosis', value: '', disabled: false, show: true, kinds: ''
		},
		asisten: { 
			title: 'Asisten', for_id: 'form_'+'asisten', type: 'text', required: '', 
			name: 'asisten', value: '', disabled: false, show: true, kinds: ''
		},

		jenisoperasi: { 
			title: 'Jenis Operasi', for_id: 'form_'+'jenisoperasi', type: 'text', required: '', 
			name: 'jenisoperasi', value: '', disabled: false, show: true, kinds: ''
		},

		anesthesia: { 
			title: 'Anesthesia', for_id: 'form_'+'anesthesia', type: 'text', required: '', 
			name: 'anesthesia', value: '', disabled: false, show: true, kinds: ''
		},

		anesthesiologist: { 
			title: 'Anesthesiologist', for_id: 'form_'+'anesthesiologist', type: 'text', required: '', 
			name: 'anesthesiologist', value: '', disabled: false, show: true, kinds: ''
		},

		intravitreal: { 
			title: '6. Dilakukan injeksi avastin / intravitreal sebanyak', for_id: 'form_'+'intravitreal', type: 'text', required: '', 
			name: 'intravitreal', value: '', disabled: false, show: true, kinds: ''
		},
		select: {
			pilihantindakan: { 
				key : 'pilihantindakan', for_id: 'form_'+'pilihantindakan', name: 'pilihantindakan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: true,
				class: 'pilihantindakan', isrequired: false, html: 'Form Untuk Tindakan', issearch: false, disabled: false,
			},
			
		}
	}
}


