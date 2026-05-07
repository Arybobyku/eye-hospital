import { createRouter, createWebHistory } from 'vue-router';

const _base = '/dashboard/';

const routes = [
	/**********************************************************************************
	 * Bagian BPJS
	 ***********************************************************************************/
	{
		path: _base + 'bridging-vclaim',
		name: 'BPJS - Bridging Vclaim',
		component: () => import('./components/bpjs/bridging/index.vue'),
		meta: { title: 'BPJS - Bridging Vclaim' },
		props: true
	},
	{ 
		path: _base + 'bpjs-diagnosa', 
		name: 'BPJS - Diagnosa', 
		component: () => import('./components/bpjs/diagnosa/index.vue'),
		meta: { title: 'BPJS - Diagnosa' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-dokter', 
		name: 'BPJS - Dokter', 
		component: () => import('./components/bpjs/dokter/index.vue'),
		meta: { title: 'BPJS - Dokter' },
		props: true 
	},	
	/**********************************************************************************
	 * Bagian PROFILE
	 ***********************************************************************************/
	
  { 
		path: _base + 'profile', 
		name: 'Data Profile', 
		component: () => import('./components/profile/index.vue'),
		meta: { title: 'Data Profile' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian ADMINISTRATION
	 ***********************************************************************************/

	/*{ 
		path: _base + 'bpjs-diagnosa', 
		name: 'Diagnosa', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Diagnosa' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-dokter', 
		name: 'Dokter', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Dokter' },
		props: true 
	},*/
	{ 
		path: _base + 'bpjs-kesadaran', 
		name: 'Kesadaran', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Kesadaran' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-kunjungan', 
		name: 'Kunjungan', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Kunjungan' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-riwayat-kunjungan', 
		name: 'Riwayat Kunjungan', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Riwayat Kunjungan' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-mcu', 
		name: 'MCU', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'MCU' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-obat', 
		name: 'Obat', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Obat' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-pendaftaran', 
		name: 'Pendaftara', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Pendaftara' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-peserta', 
		name: 'Peserta', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Peserta' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-poli', 
		name: 'Poli', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Poli' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-tindakan', 
		name: 'Tindakan', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Tindakan' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-status-pulang', 
		name: 'Status Pulang', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Status Pulang' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-kelompok', 
		name: 'Kelompok', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Kelompok' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-spesialis', 
		name: 'Spesialis', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Spesialis' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-sub-spesialis', 
		name: 'Sub Spesialis', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Sub Spesialis' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-sarana', 
		name: 'Sarana', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Sarana' },
		props: true 
	},
	{ 
		path: _base + 'bpjs-khusus', 
		name: 'Khusus', 
		component: () => import('./components/administration/kosong/index.vue'),
		meta: { title: 'Khusus' },
		props: true 
	},


	{ 
		path: _base + 'histori', 
		name: 'Histori', 
		component: () => import('./components/administration/histori/index.vue'),
		meta: { title: 'Riwayat Pengguna' },
		props: true 
	},
	{ 
		path: _base + 'running-text', 
		name: 'Data Running Text', 
		component: () => import('./components/administration/runningtext/index.vue'),
		meta: { title: 'Data Running Text' },
		props: true 
	},
	{ 
		path: _base + 'running-image', 
		name: 'Data Running Image', 
		component: () => import('./components/administration/runningimage/index.vue'),
		meta: { title: 'Data Running Image' },
		props: true 
	},
	{ 
		path: _base + 'tracking', 
		name: 'Tracking Rawat Jalan', 
		component: () => import('./components/administration/tracking/index.vue'),
		meta: { title: 'Tracking Rawat Jalan' },
		props: true 
	},
	{ 
		path: _base + 'icd9', 
		name: 'Icd9', 
		component: () => import('./components/administration/icd9/index.vue'),
		meta: { title: 'Data ICD 09' },
		props: true 
	},
	{ 
		path: _base + 'icd10', 
		name: 'Icd10', 
		component: () => import('./components/administration/icd10/index.vue'),
		meta: { title: 'Data ICD 10' },
		props: true 
	},
	{ 
		path: _base + 'unit', 
		name: 'Unit', 
		component: () => import('./components/administration/unit/index.vue'),
		meta: { title: 'Data Unit' },
		props: true 
	},
	{ 
		path: _base + 'label', 
		name: 'Label', 
		component: () => import('./components/administration/label/index.vue'),
		meta: { title: 'Data Label' },
		props: true 
	},
	{ 
		path: _base + 'editonedaycare', 
		name: 'Jalur Edit (One Day Care)', 
		component: () => import('./components/administration/pemeriksaanodc/index.vue'),
		meta: { title: 'Jalur Edit (One Day Care)' },
		props: true 
	},
	{ 
		path: _base + 'editrawatinap', 
		name: 'Jalur Edit (Rawat Inap)', 
		component: () => import('./components/administration/pemeriksaanrawatinap/index.vue'),
		meta: { title: 'Jalur Edit (Rawat Inap)' },
		props: true 
	},
	{ 
		path: _base + 'provinsi', 
		name: 'Provinsi', 
		component: () => import('./components/administration/provinsi/index.vue'),
		meta: { title: 'Data KProvinsi' },
		props: true 
	},
	{ 
		path: _base + 'kabkota', 
		name: 'Kabupaten/Kota', 
		component: () => import('./components/administration/kabkota/index.vue'),
		meta: { title: 'Data Kabupaten/Kota' },
		props: true 
	},
	{ 
		path: _base + 'kecamatan', 
		name: 'Kecamatan', 
		component: () => import('./components/administration/kecamatan/index.vue'),
		meta: { title: 'Data Kecamatan' },
		props: true 
	},
	{ 
		path: _base + 'kelurahan', 
		name: 'Kelurahan', 
		component: () => import('./components/administration/kelurahan/index.vue'),
		meta: { title: 'Data Kelurahan' },
		props: true 
	},
	{ 
		path: _base + 'pengguna', 
		name: 'Pengguna', 
		component: () => import('./components/administration/pengguna/index.vue'),
		meta: { title: 'Data Pengguna' },
		props: true 
	},
	{ 
		path: _base + 'jeniskamar', 
		name: 'Jenis Kamar', 
		component: () => import('./components/administration/jeniskamar/index.vue'),
		meta: { title: 'Data Jenis Kamar' },
		props: true 
	},
	{ 
		path: _base + 'kamarinap', 
		name: 'Kamar Rawat Inap', 
		component: () => import('./components/administration/kamarinap/index.vue'),
		meta: { title: 'Kamar Rawat Inap' },
		props: true 
	},


	{ 
		path: _base + 'pasien-inap', 
		name: '(RI) Pasien Rawat Inap', 
		component: () => import('./components/rawatinap/pasien/index.vue'),
		meta: { title: '(RI) Pasien Rawat Inap' },
		props: true 
	},
	

	/**********************************************************************************
	 * Bagian Gudang Farmasi
	 ***********************************************************************************/

	{ 
		path: _base + 'gudang-farmasi-supplier', 
		name: 'Supplier', 
		component: () => import('./components/gudang/supplier/index.vue'),
		meta: { title: 'Data Supplier' },
		props: true 
	},
	{ 
		path: _base + 'gudang-farmasi-satuan-obat-alkes', 
		name: 'Satuan Obat/Alkes', 
		component: () => import('./components/gudang/satuan/index.vue'),
		meta: { title: 'Data Satuan Obat/Alkes' },
		props: true 
	},
	{ 
		path: _base + 'gudang-obat-alkes', 
		name: 'Master Obat/Alkes', 
		component: () => import('./components/gudang/obat/index.vue'),
		meta: { title: 'Master Obat/Alkes' },
		props: true 
	},
	{ 
		path: _base + 'gudang-harga-obat-alkes', 
		name: 'Penentuan Harga Obat/Alkes', 
		component: () => import('./components/gudang/harga/index.vue'),
		meta: { title: 'Penentuan Harga Obat/Alkes' },
		props: true 
	},
	{ 
		path: _base + 'gudang-pembelian-obat-alkes', 
		name: 'Data Pembelian Obat/Alkes', 
		component: () => import('./components/gudang/pembelian/index.vue'),
		meta: { title: 'Data Pembelian Obat/Alkes' },
		props: true 
	},
	{ 
		path: _base + 'gudang-stock-opname', 
		name: '(Gudang) Data Stock Obat/Alkes', 
		component: () => import('./components/gudang/stockopname/index.vue'),
		meta: { title: '(Gudang) Data Stock Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'gudang-stock-catat', 
		name: '(Gudang) Stock Opname Obat/Alkes', 
		component: () => import('./components/gudang/stockcatat/index.vue'),
		meta: { title: '(Gudang) Stock Opname Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'gudang-permohonan-obat-alkes', 
		name: '(Gudang) Permohonan Obat/Alkes', 
		component: () => import('./components/gudang/permohonan/index.vue'),
		meta: { title: '(Gudang) Permohonan Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'gudang-accepment-opname', 
		name: '(Gudang) Permintaan Obat/Alkes', 
		component: () => import('./components/gudang/accopname/index.vue'),
		meta: { title: '(Gudang) Permintaan Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'gudang-request-barang', 
		name: '(Gudang) Pemesanan Obat/Alkes', 
		component: () => import('./components/gudang/requestbarang/index.vue'),
		meta: { title: '(Gudang) Pemesanan Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'gudang-retur', 
		name: '(Gudang) Daftar Retur Obat/Alkes', 
		component: () => import('./components/gudang/retur/index.vue'),
		meta: { title: '(Gudang) Daftar Retur Obat/Alkes' },
		props: true 
	},

	// { 
	// 	path: _base + 'gudang-expired-date', 
	// 	name: '(Gudang) Daftar Expired Date Obat/Alkes', 
	// 	component: () => import('./components/gudang/expired/index.vue'),
	// 	meta: { title: '(Gudang) Daftar Expired Date Obat/Alkes' },
	// 	props: true 
	// },

	/**********************************************************************************
	 * Bagian Bedah
	 ***********************************************************************************/

	{ 
		path: _base + 'bedah-stock-opname', 
		name: '(Bedah) Stock Obat/Alkes', 
		component: () => import('./components/bedah/stockopname/index.vue'),
		meta: { title: '(Bedah) Stock Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'bedah-request-opname', 
		name: '(Bedah) Permintaan Obat/Alkes', 
		component: () => import('./components/bedah/reqopname/index.vue'),
		meta: { title: '(Bedah) Permintaan Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'bedah-pasien', 
		name: 'Data Pasien Bedah', 
		component: () => import('./components/bedah/pasien/index.vue'),
		meta: { title: 'Data Pasien Bedah' },
		props: true 
	},

	{ 
		path: _base + 'edit-paket-bedah-pasien', 
		name: 'Edit Layanan Pasien Bedah', 
		component: () => import('./components/bedah/layananbedah/index.vue'),
		meta: { title: 'Edit Layanan Pasien Bedah' },
		props: true 
	},

	{ 
		path: _base + 'histori-bedah-pasien', 
		name: 'Histori Pasien Bedah', 
		component: () => import('./components/bedah/historipasien/index.vue'),
		meta: { title: 'Histori Pasien Bedah' },
		props: true 
	},

	{ 
		path: _base + 'data-form-bedah-pasien', 
		name: '(Form) Pasien Bedah', 
		component: () => import('./components/bedah/dataform/index.vue'),
		meta: { title: '(Form) Pasien Bedah' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Asuransi
	 ***********************************************************************************/

	{ 
		path: _base + 'asuransi-rawatjalan-pasien', 
		name: '(Asuransi) Daftar Pasien Rawat Jalan', 
		component: () => import('./components/asuransi/rawatjalan/index.vue'),
		meta: { title: '(Asuransi) Daftar Pasien Rawat Jalan' },
		props: true 
	},

	{ 
		path: _base + 'asuransi-activeonedaycare-pasien', 
		name: '(Asuransi) Data Pasien One Day Care', 
		component: () => import('./components/asuransi/activeonedaycare/index.vue'),
		meta: { title: '(Asuransi) Data Pasien One Day Care' },
		props: true 
	},

	{ 
		path: _base + 'asuransi-activeinapbedah-pasien', 
		name: '(Asuransi) Data Pasien Rawat Inap', 
		component: () => import('./components/asuransi/activeinapbedah/index.vue'),
		meta: { title: '(Asuransi) Data Pasien Rawat Inap' },
		props: true 
	},

	
	{ 
		path: _base + 'asuransi-onedaycare-pasien', 
		name: '(Reg-Asuransi) Pasien Bedah (One Day Care)', 
		component: () => import('./components/asuransi/onedaycare/index.vue'),
		meta: { title: '(Reg-Asuransi) Pasien Bedah (One Day Care)' },
		props: true 
	},

	{ 
		path: _base + 'asuransi-inapbedah-pasien', 
		name: '(Reg-Asuransi) Pasien Bedah (Inap & Bedah)', 
		component: () => import('./components/asuransi/inapbedah/index.vue'),
		meta: { title: '(Reg-Asuransi) Pasien Bedah (Inap & Bedah)' },
		props: true 
	},

	{ 
		path: _base + 'asuransi-cetakan-rawat-jalan', 
		name: '(Form Cetakan) Rawat Jalan', 
		component: () => import('./components/asuransi/cetakan/index.vue'),
		meta: { title: '(Form Cetakan) Rawat Jalan' },
		props: true 
	},

	/**********************************************************************************
	 * Keuangan
	 ***********************************************************************************/
	{
		path: _base + 'finance-claim',
		name: 'Claim',
		component: () => import('./components/finance/claimdokumen/index.vue'),
		meta: { title: 'Claim' },
		props: true
	},

	{
		path: _base + 'claim-asuransi',
		name: 'Klaim Asuransi (Tunggal)',
		component: () => import('./components/finance/claim/index.vue'),
		meta: { title: 'Klaim Asuransi (Tunggal)' },
		props: true
	},

	{ 
		path: _base + 'claim-gabungan-asuransi', 
		name: 'Klaim Asuransi (Gabungan)', 
		component: () => import('./components/finance/claimgabungan/index.vue'),
		meta: { title: 'Klaim Asuransi (Gabungan)' },
		props: true 
	},

	{ 
		path: _base + 'pembayaran-faktur', 
		name: 'Pembayaran Faktur (Obat/Alkes)', 
		component: () => import('./components/finance/faktur/index.vue'),
		meta: { title: 'Pembayaran Faktur (Obat/Alkes)' },
		props: true 
	},


	/**********************************************************************************
	 * RME
	 ***********************************************************************************/
	{ 
		path: _base + 'rme-pasien', 
		name: 'RME (Data Pasien)', 
		component: () => import('./components/rme/index.vue'),
		meta: { title: 'RME (Data Pasien)' },
		props: true 
	},

	{ 
		path: _base + 'rme-ttd-dokter', 
		name: 'Notifikasi Tanda Tangan Dokter', 
		component: () => import('./components/rme/ttd-dokter/index.vue'),
		meta: { title: 'Notifikasi Tanda Tangan Dokter' },
		props: true 
	},

	/**********************************************************************************
	 * Laporan
	 ***********************************************************************************/
	{ 
		path: _base + 'laporan-obat-alkes-farmasi', 
		name: 'Laporan Obat/Alkes (Farmasi)', 
		component: () => import('./components/laporan/laporanfarmasi/index.vue'),
		meta: { title: 'Laporan Obat/Alkes (Farmasi)' },
		props: true 
	},
	

	{ 
		path: _base + 'laporan-faktur-obat', 
		name: '(Apotek) Laporan Faktur Obat/Alkes', 
		component: () => import('./components/laporan/laporanfakturobat/index.vue'),
		meta: { title: '(Apotek) Laporan Faktur Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'laporan-keuangan', 
		name: 'Laporan Keuangan', 
		component: () => import('./components/laporan/laporankeuangan/index.vue'),
		meta: { title: 'Laporan Keuangan' },
		props: true 
	},
	{ 
		path: _base + 'laporan-kontrol-pasien', 
		name: 'Laporan Kontrol Pasien', 
		component: () => import('./components/laporan/laporankontrol/index.vue'),
		meta: { title: 'Laporan Kontrol Pasien' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Apotek
	 ***********************************************************************************/

	{ 
		path: _base + 'apotek-stock-opname', 
		name: '(Apotek) Stock Obat/Alkes', 
		component: () => import('./components/apotek/stockopname/index.vue'),
		meta: { title: '(Apotek) Stock Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'apotek-stock-catat', 
		name: '(Apotek) Stock Opname Obat/Alkes', 
		component: () => import('./components/apotek/stockcatat/index.vue'),
		meta: { title: '(Apotek) Stock Opname Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'apotek-request-opname', 
		name: '(Apotek) Permintaan Obat/Alkes', 
		component: () => import('./components/apotek/reqopname/index.vue'),
		meta: { title: '(Apotek) Permintaan Obat/Alkes' },
		props: true 
	},
	{ 
		path: _base + 'ri-request-opname', 
		name: '(Rawat Inap) Permintaan Obat/Alkes ke Gudang', 
		component: () => import('./components/rawatinap/reqopname/index.vue'),
		meta: { title: '(Rawat Inap) Permintaan Obat/Alkes ke Gudang' },
		props: true 
	},

	{ 
		path: _base + 'farmasi', 
		name: 'Data Farmasi (Rawat Jalan)', 
		component: () => import('./components/apotek/farmasi/index.vue'),
		meta: { title: 'Data Farmasi (Rawat Jalan)' },
		props: true 
	},

	{ 
		path: _base + 'historifarmasi', 
		name: 'Histori Farmasi (Rawat Jalan)', 
		component: () => import('./components/apotek/historifarmasi/index.vue'),
		meta: { title: 'Histori Farmasi (Rawat Jalan)' },
		props: true 
	},

	{ 
		path: _base + 'historifarmasirawatinap', 
		name: 'Histori Farmasi (Rawat Inap)', 
		component: () => import('./components/apotek/historifarmasirawatinap/index.vue'),
		meta: { title: 'Histori Farmasi (Rawat Inap)' },
		props: true 
	},

	{ 
		path: _base + 'historibebas', 
		name: 'Histori Pasien Bebas', 
		component: () => import('./components/apotek/historibebas/index.vue'),
		meta: { title: 'Histori Pasien Bebas' },
		props: true 
	},

	{ 
		path: _base + 'farmasi-rawa-inap', 
		name: 'Data Farmasi (Rawat Inap)', 
		component: () => import('./components/apotek/farmasirawatinap/index.vue'),
		meta: { title: 'Data Farmasi (Rawat Inap)' },
		props: true 
	},


	/**********************************************************************************
	 * Bagian IGD
	 ***********************************************************************************/
	{ 
		path: _base + 'pasien-igd', 
		name: 'Data Pasien (IGD)', 
		component: () => import('./components/igd/pasien/index.vue'),
		meta: { title: 'Data Pasien (IGD)' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Master Pasien
	 ***********************************************************************************/
	{ 
		path: _base + 'master-pasien', 
		name: 'Histori Data Pasien', 
		component: () => import('./components/master/pasien/index.vue'),
		meta: { title: 'Histori Data Pasien' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Master Rekam Medis
	 ***********************************************************************************/
	{ 
		path: _base + 'master-rekam-medis', 
		name: 'Histori Data Rekam Medis', 
		component: () => import('./components/master/rekammedis/index.vue'),
		meta: { title: 'Histori Data Rekam Medis' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Master Resume Medis
	 ***********************************************************************************/
		{ 
			path: _base + 'master-resume-medis', 
			name: 'Rekam Medis', 
			component: () => import('./components/master/resumemedis/index.vue'),
			meta: { title: 'Rekam Medis' },
			props: true 
		},
		{ 
			path: _base + 'cppt', 
			name: 'CPPT', 
			component: () => import('./components/master/cppt/index.vue'),
			meta: { title: 'CPPT' },
			props: true 
		},

	/**********************************************************************************
	 * Bagian Customer Services
	 ***********************************************************************************/
	{ 
		path: _base + 'customer-service-vclaim', 
		name: 'BPJS - VClaim', 
		component: () => import('./components/customerservices/vclaim/index.vue'),
		meta: { title: 'BPJS - VClaim' },
		props: true 
	},
	{ 
		path: _base + 'pasien', 
		name: 'Data Pasien', 
		component: () => import('./components/customerservices/pasien/index.vue'),
		meta: { title: 'Data Pasien' },
		props: true 
	},

	{ 
		path: _base + 'antrianpasien', 
		name: 'Posisi Antrian Pasien', 
		component: () => import('./components/customerservices/antrianpasien/index.vue'),
		meta: { title: 'Posisi Antrian  Pasien' },
		props: true 
	},
	

	{ 
		path: _base + 'historirawatjalan', 
		name: 'Histori Rawat Jalan', 
		component: () => import('./components/customerservices/historirawatjalan/index.vue'),
		meta: { title: 'Histori Rawat Jalan' },
		props: true 
	},

	{ 
		path: _base + 'historirawatinap', 
		name: 'Histori Rawat Inap', 
		component: () => import('./components/customerservices/historirawatinap/index.vue'),
		meta: { title: 'Histori Rawat Inap' },
		props: true 
	},

	// { 
	// 	path: _base + 'historionedaycare', 
	// 	name: 'Histori One Day Care', 
	// 	component: () => import('./components/customerservices/historionedaycare/index.vue'),
	// 	meta: { title: 'Histori One Day Care' },
	// 	props: true 
	// },

	{ 
		path: _base + 'pasien-kunjungan', 
		name: 'Kunjungan Pasien (Rawat Jalan)', 
		component: () => import('./components/customerservices/pasienactive/index.vue'),
		meta: { title: 'Kunjungan Pasien (Rawat Jalan)' },
		props: true 
	},

	{ 
		path: _base + 'antrian-dokter', 
		name: 'Data Antrian Dokter', 
		component: () => import('./components/customerservices/antriandokter/index.vue'),
		meta: { title: 'Data Antrian Dokter' },
		props: true 
	},

	{ 
		path: _base + 'registrasi-rawatinap', 
		name: '(CS) Pasien Rawat Inap', 
		component: () => import('./components/customerservices/rawatinap/index.vue'),
		meta: { title: '(CS) Pasien Rawat Inap' },
		props: true 
	},

	{ 
		path: _base + 'bebas-obat-racikan', 
		name: 'Pembelian Obat Racikan', 
		component: () => import('./components/customerservices/racikan/index.vue'),
		meta: { title: 'Pembelian Obat Racikan' },
		props: true 
	},

	{ 
		path: _base + 'reminder-kontrol', 
		name: 'Reminder Kontrol Pasien', 
		component: () => import('./components/customerservices/reminderkontrol/index.vue'),
		meta: { title: 'Reminder Kontrol Pasien' },
		props: true 
	},

	{ 
		path: _base + 'pasien-kontrol', 
		name: '(CS) Data Pasien Kontrol', 
		component: () => import('./components/customerservices/pasienkontrol/index.vue'),
		meta: { title: '(CS) Data Pasien Kontrol' },
		props: true 
	},

	{ 
		path: _base + 'cs-onedaycare-pasien', 
		name: 'Registrasi Pasien Bedah', 
		component: () => import('./components/customerservices/onedaycare/index.vue'),
		meta: { title: 'Registrasi Pasien Bedah' },
		props: true 
	},

	{ 
		path: _base + 'cs-inapbedah-pasien', 
		name: '(Registrasi) Pasien Bedah (Inap & Bedah)', 
		component: () => import('./components/customerservices/inapbedah/index.vue'),
		meta: { title: '(Registrasi) Pasien Bedah (Inap & Bedah)' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Rawat Jalan
	 ***********************************************************************************/
	{ 
		path: _base + 'rawatjalan-pemeriksaan-ro', 
		name: 'Data Pemeriksaan', 
		component: () => import('./components/rawatjalan/pemeriksaan/index.vue'),
		meta: { title: 'Data Pemeriksaan' },
		props: true 
	},

	{
		path: _base + 'histori-pemeriksaan-ro',
		name: 'Histori Pemeriksaan',
		component: () => import('./components/rawatjalan/historipemeriksaan/index.vue'),
		meta: { title: 'Histori Pemeriksaan' },
		props: true
	},

	{
		path: _base + 'rawatjalan-pemeriksaan-penunjang',
		name: 'Pemeriksaan Penunjang',
		component: () => import('./components/rawatjalan/pemeriksaanpenunjang/index.vue'),
		meta: { title: 'Pemeriksaan Penunjang' },
		props: true
	},

	{ 
		path: _base + 'bedah-rawatjalan-pemeriksaan-ro', 
		name: 'Data Pemeriksaan Ro (Bedah)', 
		component: () => import('./components/rawatjalan/pemeriksaanbedah/index.vue'),
		meta: { title: 'Data Pemeriksaan Ro (Bedah)' },
		props: true 
	},

	{ 
		path: _base + 'dokter-pemeriksaan', 
		name: 'Data Pemeriksaan Dokter (Rawat Jalan)', 
		component: () => import('./components/dokter/pemeriksaan/index.vue'),
		meta: { title: 'Data Pemeriksaan Dokter (Rawat Jalan)' },
		props: true 
	},

	{ 
		path: _base + 'dokter-pemeriksaan-odc', 
		name: 'Bedah One Day Care', 
		component: () => import('./components/dokter/pemeriksaanodc/index.vue'),
		meta: { title: 'Bedah One Day Care' },
		props: true 
	},

	{ 
		path: _base + 'dokter-pasien-kontrol', 
		name: '(Dokter) Data Pasien Kontrol', 
		component: () => import('./components/rawatjalan/pasienkontrol/index.vue'),
		meta: { title: '(Dokter) Data Pasien Kontrol' },
		props: true 
	},

	{ 
		path: _base + 'rj-stock-opname', 
		name: '(RJ) Stock Opname Obat/Alkes', 
		component: () => import('./components/rawatjalan/stockopname/index.vue'),
		meta: { title: '(RJ) Stock Opname Obat/Alkes' },
		props: true 
	},

	{ 
		path: _base + 'rj-request-opname', 
		name: '(RJ) Permintaan Obat/Alkes', 
		component: () => import('./components/rawatjalan/reqopname/index.vue'),
		meta: { title: '(RJ) Permintaan Obat/Alkes' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian Finance
	 ***********************************************************************************/
	{ 
		path: _base + 'carabayar', 
		name: 'Metode Pembayaran', 
		component: () => import('./components/finance/carabayar/index.vue'),
		meta: { title: 'Penjamin' },
		props: true 
	},

	{ 
		path: _base + 'tindakanrawatjalan', 
		name: 'Buku Tarif', 
		component: () => import('./components/administration/tindakanrawatjalan/index.vue'),
		meta: { title: 'Buku Tarif' },
		props: true 
	},
	// { 
	// 	path: _base + 'tindakannonbedah', 
	// 	name: 'Data Tindakan Non Bedah', 
	// 	component: () => import('./components/administration/tindakannonbedah/index.vue'),
	// 	meta: { title: 'Data Tindakan Non Bedah' },
	// 	props: true 
	// },
	{ 
		path: _base + 'tindakanbedah', 
		name: 'Data Tindakan Bedah', 
		component: () => import('./components/administration/tindakanbedah/index.vue'),
		meta: { title: 'Data Tindakan Bedah' },
		props: true 
	},

	{ 
		path: _base + 'kasir', 
		name: 'Kasir', 
		component: () => import('./components/finance/kasir/index.vue'),
		meta: { title: 'Kasir' },
		props: true 
	},

		{ 
		path: _base + 'editkasir', 
		name: 'Edit Kasir', 
		component: () => import('./components/finance/editkasir/index.vue'),
		meta: { title: 'Edit Kasir' },
		props: true 
	},
	

	{ 
		path: _base + 'histori-kasir', 
		name: 'Histori (Tagihan Rawat Jalan)', 
		component: () => import('./components/finance/historikasir/index.vue'),
		meta: { title: 'Histori (Tagihan Rawat Jalan)' },
		props: true 
	},

	{ 
		path: _base + 'histori-kasirrawatinap', 
		name: 'Histori (Tagihan Rawat Inap)', 
		component: () => import('./components/finance/historikasirrawatinap/index.vue'),
		meta: { title: 'Histori (Tagihan Rawat Inap)' },
		props: true 
	},

	{ 
		path: _base + 'histori-bebas', 
		name: 'Histori (Pasien Bebas)', 
		component: () => import('./components/finance/historibebas/index.vue'),
		meta: { title: 'Histori (Pasien Bebas)' },
		props: true 
	},

	{ 
		path: _base + 'bedah-kasir', 
		name: 'Kasir (Rawat Inap)', 
		component: () => import('./components/finance/bedahkasir/index.vue'),
		meta: { title: 'Kasir (Rawat Inap)' },
		props: true 
	},

	{ 
		path: _base + 'paketbedah', 
		name: 'Paket Bedah', 
		component: () => import('./components/finance/paketbedah/index.vue'),
		meta: { title: 'Paket Bedah' },
		props: true 
	},

	/**********************************************************************************
	 * Bagian ERROR
	 ***********************************************************************************/

	{ 
		path: _base + 'error/:link', 
		name: 'Error', 
		component: () => import('./components/error/error.vue'),
		meta: { title: 'Error Page' },
		props: true 
	},
	{ 
		path: _base + 'forbidden', 
		name: 'Forbidden', 
		component: () => import('./components/error/forbidden.vue'),
		meta: { title: 'Forbidden Page' },
		props: true 
	},
	{ 
		path: _base + 'notfound', 
		name: 'Not Found', 
		component: () => import('./components/error/notfound.vue'),
		meta: { title: 'Not Found Page' },
		props: true 
	},
		
	
	/**********************************************************************************
	 * Bagian Rawat Jalan
	 ***********************************************************************************/

	// { 
	// 	path: _base + 'rj-stock-opname', 
	// 	name: '(RJ) Stock Opname Obat/Alkes', 
	// 	component: () => import('./components/rawatjalan/stockopname/index.vue'),
	// 	meta: { title: '(RJ) Stock Opname Obat/Alkes' },
	// 	props: true 
	// },
	// { 
	// 	path: _base + 'ruangan', 
	// 	name: 'Ruangan', 
	// 	component: () => import('./components/administration/ruangan/index.vue'),
	// 	meta: { title: 'Data Ruangan' },
	// 	props: true 
	// },


	// { path: _base + 'layanan', name: 'Layanan Rumah Sakit',  component: () => import('./components/finance/layanan/index.vue'),
	// 	meta: { title: 'Layanan Rumah Sakit' },props: true },
	/**********************************************************************************
	 * Bagian SatuSehat
	 ***********************************************************************************/
	{
		path: _base + 'satusehat-organization',
		name: 'SatuSehat - Organization',
		component: () => import('./components/satusehat/organization/index.vue'),
		meta: { title: 'SatuSehat - Organization' },
		props: true
	},
	{
		path: _base + 'satusehat-location',
		name: 'SatuSehat - Location',
		component: () => import('./components/satusehat/location/index.vue'),
		meta: { title: 'SatuSehat - Location' },
		props: true
	},
	{
		path: _base + 'satusehat-token',
		name: 'SatuSehat - Access Token',
		component: () => import('./components/satusehat/token/index.vue'),
		meta: { title: 'SatuSehat - Access Token' },
		props: true
	},

];

const router = createRouter({ history: createWebHistory(), routes });
const DEFAULT_TITLE = 'Some Default Title';
router.afterEach((to, from) => { document.title = to.meta.title || DEFAULT_TITLE; });
export default router;
