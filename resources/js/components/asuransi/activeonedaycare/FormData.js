export const formunit = () => {
	return {
		title: '', posisi: '', uuid: '',
		coverasuransi: { 
			title: 'Jumlah Cover Asuransi', for_id: 'form_'+'coverasuransi', type: 'number', required: 'required', 
			name: 'coverasuransi', value: '', disabled: false, show: true, kinds: ''
		},
	}
}