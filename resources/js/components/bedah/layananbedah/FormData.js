export const formdetail = () => {
	return {
		title: '', posisi: '', uuid: '', ispending: '',
		jenis: '',
		registrasi_uuid: '',
		carabayar_nama: '',
		carabayar_uuid: '',
		select: {
			carabayartindakanrawatjalan: { 
				key : 'carabayartindakanrawatjalan', for_id: 'form_'+'carabayartindakanrawatjalan', name: 'carabayartindakanrawatjalan', uuid:'', value: '', label: 'Silahkan Pilih', 
				filter: [], data: [], search: '', option: 'display: none', statics: false,
				class: 'carabayartindakanrawatjalan', isrequired: true, html: 'Nama Tindakan', issearch: true, disabled: false,
			},
		}
	}
}
