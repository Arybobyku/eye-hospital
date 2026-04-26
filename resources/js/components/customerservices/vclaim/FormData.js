export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '', pasienbebas_uuid: '',
		registrasi_uuid: '',
		carabayar_uuid: '',
		carabayar_nama: '',
		layanan_uuid: '',
		nama_layanan: '',
		tarif: '',
		select: {
			carabayartindakanrawatjalan: { 
				key : 'carabayartindakanrawatjalan', for_id: 'form_'+'carabayartindakanrawatjalan', name: 'carabayartindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayartindakanrawatjalan', isrequired: true, html: 'Nama Tindakan', issearch: true, disabled: false,
			},
		}
	}
}