export const arrkasir = () => {
	return {
		metodepembayaran: [
			{ value: 'Tunai', label: 'Tunai' },
			{ value: 'Transfer', label: 'Transfer' },
			{ value: 'Tunai + Transfer', label: 'Tunai + Transfer' },
			{ value: 'Kartu Debit', label: 'Kartu Debit' },
			{ value: 'Tunai + Kartu Debit', label: 'Tunai + Kartu Debit' },
			{ value: 'Kartu Kredit', label: 'Kartu Kredit' },
			{ value: 'Tunai + Kartu Kredit', label: 'Tunai + Kartu Kredit' },
			{ value: 'Kartu Debit + Kartu Kredit', label: 'Kartu Debit + Kartu Kredit' },
		],
	}
}

export const arrdefault = () => {
	return {
		defaulttindakan: [
			{ value: 'Ya', label: 'Ya' },
			{ value: 'Tidak', label: 'Tidak' },
		],
	}
}

export const arrtransfer = () => {
	return {
		transfer: [
			{ value: 'Alihkan ke Dokter Lain', label: 'Alihkan ke Dokter Lain' },
			{ value: 'Transfer untuk Pemeriksaan Lanjutan', label: 'Transfer untuk Pemeriksaan Lanjutan' },
		],
	}
}

export const arrbiodata = () => {
	return {
		pekerjaan: [
			{ value: 'TNI dan Polri', label: 'TNI dan Polri' },
			{ value: 'Pensiunan', label: 'Pensiunan' },
			{ value: 'Pegawai Swasta', label: 'Pegawai Swasta' },
			{ value: 'Pedagang', label: 'Pedagang' },
			{ value: 'Nelayan', label: 'Nelayan' },
			{ value: 'Petani', label: 'Petani' },
			{ value: 'Pekerja Lepas', label: 'Pekerja Lepas' },
			{ value: 'Ibu Rumah Tangga', label: 'Ibu Rumah Tangga' },
			{ value: 'Pelajar', label: 'Pelajar' },
			{ value: 'Mahasiswa', label: 'Mahasiswa' },
			{ value: 'Dibawah Umur', label: 'Dibawah Umur' },
			{ value: 'Pegawai Negeri Sipil', label: 'Pegawai Negeri Sipil' },
			{ value: 'Wiraswasta', label: 'Wiraswasta' },
			{ value: 'Guru', label: 'Guru' },
			{ value: 'Pendeta', label: 'Pendeta' },
			{ value: 'Dosen', label: 'Dosen' },
			{ value: 'Perawat', label: 'Perawat' },
			{ value: 'Pengacara', label: 'Pengacara' },
			{ value: 'Dokter', label: 'Dokter' },
			{ value: 'Bidan', label: 'Bidan' },
			{ value: 'Tabib', label: 'Tabib' },
			{ value: 'Pastor', label: 'Pastor' },
			{ value: 'Ustadz', label: 'Ustadz' },
			{ value: 'Tidak Bekerja', label: 'Tidak Bekerja' },
			{ value: 'Lainnya', label: 'Lainnya' },
		],
		jenisidentitas: [
			{ value: 'KTP', label: 'KTP' },
			{ value: 'SIM A', label: 'SIM A' },
			{ value: 'SIM B1', label: 'SIM B1' },
			{ value: 'SIM B2', label: 'SIM B2' },
			{ value: 'SIM C', label: 'SIM C' },
			{ value: 'Kartu Pelajar', label: 'Kartu Pelajar' },
			{ value: 'KTA', label: 'KTA' },
			{ value: 'KITAS', label: 'KITAS' },
			{ value: 'Paspor', label: 'Paspor' },
		],
		posisiakun: [
			{ value: '8807', label: 'Karyawan' },
			{ value: '8808', label: 'Dokter Spesialis' },
			{ value: '8809', label: 'Dokter Umum' }
		],
		bpjsketenagakerjaan: [
			{ value: 'Terdaftar', label: 'Terdaftar' },
			{ value: 'Tidak Terdaftar', label: 'Tidak Terdaftar' }
		],
		jeniskelamin: [
			{ value: 'Laki-Laki', label: 'Laki-Laki' },
			{ value: 'Perempuan', label: 'Perempuan' }
		],
		agama: [
			{ value: 'Islam', label: 'Islam' },
			{ value: 'Katolik', label: 'Katolik' },
			{ value: 'Protestan', label: 'Protestan' },
			{ value: 'Budha', label: 'Budha' },
			{ value: 'Hindu', label: 'Hindu' },
			{ value: 'Konghucu', label: 'Konghucu' }
		],
		statuspernikahan: [
			{ value: 'Menikah', label: 'Menikah' },
			{ value: 'Belum Menikah', label: 'Belum Menikah' },
			{ value: 'Janda', label: 'Janda' },
			{ value: 'Duda', label: 'Duda' },
			{ value: 'Dibawah Umur', label: 'Dibawah Umur' }
		],
		pendidikanterakhir: [
			{ value: 'SD', label: 'SD' },
			{ value: 'SMP', label: 'SMP' },
			{ value: 'SMA', label: 'SMA' },
			{ value: 'Sarjana', label: 'Sarjana' },
			{ value: 'Pasca Sarjana', label: 'Pasca Sarjana' },
			{ value: 'Doktoral', label: 'Doktoral' }
		],
		golongandarah: [
			{ value: 'A', label: 'A' },
			{ value: 'B', label: 'B' },
			{ value: 'AB', label: 'AB' },
			{ value: 'O', label: 'O' },
		],
		sebutan: [
			{ value: 'Tn.', label: 'Tn.' },
			{ value: 'Ny.', label: 'Ny.' },
			{ value: 'Nn.', label: 'Nn.' },
			{ value: 'An.', label: 'An.' },
			{ value: 'By.', label: 'By.' },
			{ value: 'Sr.', label: 'Sr.' },
			{ value: 'Jr.', label: 'Jr.' },
		],
	}
}

export const arrruangan = () => {
	return {
		jenisruangan: [
			{ value: 'VVIP', label: 'VVIP' },
			{ value: 'VIP', label: 'VIP' },
			{ value: 'Kelas 1', label: 'Kelas 1' },
			{ value: 'Kelas 2', label: 'Kelas 2' },
			{ value: 'Kelas 3', label: 'Kelas 3' }
		]
	}
}

export const arrlayanan = () => {
	return {
		kategori: [
			{ value: 'Rawat Jalan', label: 'Rawat Jalan' },
			{ value: 'Rawat Inap', label: 'Rawat Inap' },
			{ value: 'Bedah Besar', label: 'Bedah Besar' },
			{ value: 'Bedah Besar dan Khusus', label: 'Bedah Besar dan Khusus' },
			{ value: 'Bedah Sedang', label: 'Bedah Sedang' },
			{ value: 'Bedah Kecil', label: 'Bedah Kecil' },
			{ value: 'Non Bedah', label: 'Non Bedah' },
		],
	}
}

export const arrtindakan = () => {
	return {
		jenis: [
			{ value: 'Bedah Kecil', label: 'Bedah Kecil' },
			{ value: 'Bedah Sedang', label: 'Bedah Sedang' },
			{ value: 'Bedah Besar', label: 'Bedah Besar' },
			{ value: 'Bedah Besar dan Khusus', label: 'Bedah Besar dan Khusus' }
		],
	}
}

export const arrregistrasi = () => {
	return {
		jenisidentitas: [
			{ value: 'KTP', label: 'KTP' },
			{ value: 'SIM A', label: 'SIM A' },
			{ value: 'SIM B1', label: 'SIM B1' },
			{ value: 'SIM B2', label: 'SIM B2' },
			{ value: 'SIM C', label: 'SIM C' },
			{ value: 'Kartu Pelajar', label: 'Kartu Pelajar' },
			{ value: 'KTA', label: 'KTA' },
			{ value: 'KITAS', label: 'KITAS' },
			{ value: 'Paspor', label: 'Paspor' },
		],
		berkebutuhankhusus: [
			{ value: 'Tidak', label: 'Tidak' },
			{ value: 'Ya, Benar', label: 'Ya, Benar' }
		],
		caramasuk: [
			{ value: 'Datang Sendiri', label: 'Datang Sendiri' },
			{ value: 'Kasus Polisi', label: 'Kasus Polisi' },
			{ value: 'Rujukan dari', label: 'Rujukan dari' }
		],
		klinik: [
			{ value: '1', label: 'Poli 1' },
			{ value: '2', label: 'Poli 2' },
			{ value: '3', label: 'Poli 3' },
			{ value: '4', label: 'Poli 4' },
			{ value: '5', label: 'Poli 5' },
			{ value: '6', label: 'Poli 6' },
		],
	}
}

export const arrobat = () => {
	return {
		golongan: [
			{ value: 'Obat Bebas', label: 'Obat Bebas' },
			{ value: 'Obat Terbatas', label: 'Obat Terbatas' },
			{ value: 'Obat Dengan Resep', label: 'Obat Dengan Resep' },
			{ value: 'Alkes', label: 'Alkes' },
			{ value: 'Antibiotika', label: 'Antibiotika' },
			{ value: 'Gas Medis', label: 'Gas Medis' },
			{ value: 'Keras', label: 'Keras' },
			{ value: 'Multivitamin', label: 'Multivitamin' },
			{ value: 'Narkotika', label: 'Narkotika' },
			{ value: 'Psikotropika', label: 'Psikotropika' },
			{ value: 'Suplemen', label: 'Suplemen' },
			{ value: 'Tetes', label: 'Tetes' },
		],
		kategori: [
			{ value: 'Generik', label: 'Generik' },
			{ value: 'Non Generik', label: 'Non Generik' },
			{ value: 'Paten', label: 'Paten' },
			{ value: 'Narkotika', label: 'Narkotika' },
			{ value: 'PSikotropika', label: 'PSikotropika' },
			{ value: 'Umum', label: 'Umum' },
			{ value: 'DPHO', label: 'DPHO' },
		],
		formularium: [
			{ value: 'Formularium', label: 'Formularium' },
			{ value: 'Non Formularium', label: 'Non Formularium' },
		],
		jenisobat: [
			{ value: 'Obat', label: 'Obat' },
			{ value: 'Alkes', label: 'Alkes' },
			{ value: 'Bhp', label: 'Bhp' },
		]
	}
}

export const arrpembelian = () => {
	return {
		pembayaran: [
			{ value: 'Kredit', label: 'Kredit' },
			{ value: 'Tunai', label: 'Tunai' },
		]
	}
}

export const arrpemeriksaan = () => {
	return {
		klinik: [
			{ value: '1', label: 'Poli 1' },
			{ value: '2', label: 'Poli 2' },
			{ value: '3', label: 'Poli 3' },
			{ value: '4', label: 'Poli 4' },
			{ value: '5', label: 'Poli 5' },
			{ value: '6', label: 'Poli 6' },
		],
		kasusurgent: [
			{ value: 'Mata Merah', label: 'Mata Merah' },
			{ value: 'Trauma/Kesakitan', label: 'Trauma/Kesakitan' },
			{ value: 'Mata Kabur Mendadak', label: 'Mata Kabur Mendadak' },
			{ value: 'Balita/Manula', label: 'Balita/Manula' },
			{ value: 'Lainnya', label: 'Lainnya' },
		],
		statuspsikologis: [
			{ value: 'Kooperatif', label: 'Kooperatif' },
			{ value: 'Tidak Kooperatif', label: 'Tidak Kooperatif' },
			{ value: 'Cemas', label: 'Cemas' },
		],
		statusfungsional: [
			{ value: 'Jalan tanpa bantuan', label: 'Jalan tanpa bantuan' },
			{ value: 'Jalan dengan bantuan', label: 'Jalan dengan bantuan' },
			{ value: 'Kursi Roda', label: 'Kursi Roda' },
			{ value: 'Tempat tidur dorong', label: 'Tempat tidur dorong' },
		],
		nyeri: [
			{ value: 'Tidak ada nyeri', label: 'Tidak ada nyeri' },
			{ value: 'Nyeri akut', label: 'Nyeri akut' },
			{ value: 'Nyeri kronis', label: 'Nyeri kronis' },
		],
		nyerihilangbila: [
			{ value: 'Minum obat', label: 'Minum obat' },
			{ value: 'Istirahat', label: 'Istirahat' },
			{ value: 'Berubah Posisi', label: 'Berubah Posisi' },
			{ value: 'Lainnya', label: 'Lainnya' },
		],

		penyakitpernahdiderita: [
			{ value: 'Diabetes', label: 'Diabetes' },
			{ value: 'Hipertensi', label: 'Hipertensi' },
			{ value: 'Jantung', label: 'Jantung' },
			{ value: 'Heptitis', label: 'Heptitis' },
			{ value: 'Asma', label: 'Asma' },
			{ value: 'Lainnya', label: 'Lainnya' },
		],
		pernahdioperasi: [
			{ value: 'Tidak', label: 'Tidak' },
			{ value: 'Ya', label: 'Ya' },
		],
		riwayatalergimakanan: [
			{ value: 'Tidak', label: 'Tidak' },
			{ value: 'Ya', label: 'Ya' },
		],
		riwayatalergiobatan: [
			{ value: 'Tidak', label: 'Tidak' },
			{ value: 'Ya', label: 'Ya' },
		],
		obatdigunakansaatini: [
			{ value: 'Obat Pencacar Darah', label: 'Obat Pencacar Darah' },
			{ value: 'Obat Prostat', label: 'Obat Prostat' },
			{ value: 'Obat Asma', label: 'Obat Asma' },
			{ value: 'Obat Alergi/Stroid', label: 'Obat Alergi/Stroid' },
			{ value: 'Lainnya', label: 'Lainnya' },
		],
		penilaianresikojatuh: [
			{ value: 'Ya', label: 'Ya, Terjatuh' },
			{ value: 'Tidak', label: 'Tidak Terjatuh' },
		],
	}
};