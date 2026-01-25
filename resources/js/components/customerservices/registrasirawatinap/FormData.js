export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		registrasi_uuid: '',
		kamar_inap_uuid: '',
		kamar_inap_nama: '',
		kamar_inap_lantai: '',
		kamar_inap_jumlah_bed: '',
		jenis_kamar_uuid: '',
		nama_jenis_kamar: '',
		carabayar_uuid: '',
		carabayar_nama: '',
		select: {
			kamarinap: { 
				key : 'kamarinap', for_id: 'form_'+'kamarinap', name: 'kamarinap', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'kamarinap', isrequired: true, html: 'Nama Kamar', issearch: true, disabled: false,
			},
		}
	}
}